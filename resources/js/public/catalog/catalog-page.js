import { renderPaginate } from '../../components/paginate';
import bootstrap from 'bootstrap/dist/js/bootstrap.bundle.min.js';

// Obtener slug del data attribute o del URL
let slug = document.getElementById('productGrid')?.dataset.slug || 
           window.location.pathname.split('/')[2];

let currentPage = 1;
const perPage = 12;

console.log('Slug del catálogo:', slug);

async function loadProducts(page = 1) {
    try {
        const url = `/catalogo/${slug}/api?page=${page}&per_page=${perPage}`;
        console.log('Cargando desde:', url);
        const response = await fetch(url);
        const data = await response.json();

        console.log('Respuesta de API:', data);

        if (!data.ok) {
            console.log('API retornó ok: false');
            showEmptyState();
            return;
        }

        console.log('Productos recibidos:', data.data);
        renderProducts(data.data || []);
        renderPagination(data.meta);
        
    } catch (error) {
        console.error('Error cargando productos:', error);
        showEmptyState();
    }
}

function renderProducts(products) {
    const grid = document.getElementById('productGrid');
    const emptyState = document.getElementById('emptyState');
    
    if (!products || products.length === 0) {
        grid.innerHTML = '';
        emptyState.classList.remove('d-none');
        return;
    }

    emptyState.classList.add('d-none');
    grid.innerHTML = products.map(product => {
        const imageUrl = product.image_url;
        const category = product.category || 'Sin categoría';
        const description = product.description || 'Sin descripción';
        const price = parseFloat(product.price).toFixed(2);
        
        const imageHtml = imageUrl 
            ? `<img src="${imageUrl}" class="card-img-top" alt="${product.name}" style="height: 200px; object-fit: cover;">`
            : `<div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);"><i class="bi-image" style="font-size: 3rem; color: #ccc;"></i></div>`;
        
        return `
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm product-card">
                    <div class="position-relative">
                        ${imageHtml}

                        <span class="badge bg-success position-absolute top-0 end-0 m-2">
                            Disponible
                        </span>
                    </div>

                    <div class="card-body d-flex flex-column">
                        <h6 class="fw-semibold mb-1">
                            ${product.name} 
                            <small class="text-muted">- ${category}</small>
                        </h6>

                        <span class="text-success fw-bold mb-2">
                            $${price}
                        </span>

                        <p class="text-muted small mb-3">
                            ${description}
                        </p>

                        <div class="mt-auto">
                            <button class="btn btn-sm btn-outline-primary w-100 btn-details" 
                                    data-product-id="${product.id}">
                                Detalles
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }).join('');

    // Agregar event listeners a los botones de detalles
    grid.querySelectorAll('.btn-details').forEach(button => {
        button.addEventListener('click', () => {
            const productId = button.dataset.productId;
            loadProductDetailsFromAPI(productId);
        });
    });
}

function renderPagination(meta) {
    const container = document.getElementById('paginationContainer');
    const nav = document.querySelector('#paginationNav');
    
    if (!meta.total || meta.total === 0) {
        container.style.display = 'none';
        return;
    }

    container.style.display = 'flex';
    
    // Actualizar info
    const from = (meta.current_page - 1) * meta.per_page + 1;
    const to = Math.min(meta.current_page * meta.per_page, meta.total);
    
    document.getElementById('paginationFrom').textContent = from;
    document.getElementById('paginationTo').textContent = to;
    document.getElementById('paginationTotal').textContent = meta.total;

    // Usar el componente renderPaginate
    nav.innerHTML = renderPaginate(meta);

    // Agregar event listeners a los enlaces de paginación
    nav.querySelectorAll('a[data-page]').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const page = link.getAttribute('data-page');
            if (page !== '#') {
                loadProducts(parseInt(page));
                window.scrollTo(0, 0);
            }
        });
    });
}

function showEmptyState() {
    document.getElementById('productGrid').innerHTML = '';
    document.getElementById('emptyState').classList.remove('d-none');
    document.getElementById('paginationContainer').style.display = 'none';
}

async function loadProductDetailsFromAPI(productId) {
    try {
        const url = `/catalogo/${slug}/productos/${productId}`;
        console.log('Obteniendo detalles desde:', url);
        
        const response = await fetch(url);
        const data = await response.json();

        console.log('Detalles obtenidos:', data);

        if (!data.ok) {
            alert('Producto no encontrado');
            return;
        }

        const product = data.data;
        showProductDetails(product);
        
    } catch (error) {
        console.error('Error cargando detalles:', error);
        alert('Error al cargar los detalles del producto');
    }
}

function showProductDetails(product) {
    const imageUrl = product.image_url;
    const category = product.category || 'Sin categoría';
    const description = product.description || 'Sin descripción disponible';
    const price = parseFloat(product.price).toFixed(2);
    
    document.getElementById('productDetailTitle').textContent = product.name;
    document.getElementById('productDetailName').textContent = product.name;
    document.getElementById('productDetailPrice').textContent = `$${price}`;
    document.getElementById('productDetailCategory').textContent = `Categoría: ${category}`;
    document.getElementById('productDetailDescription').textContent = description;
    
    const imgElement = document.getElementById('productDetailImage');
    if (imageUrl) {
        imgElement.src = imageUrl;
        imgElement.style.display = 'block';
    } else {
        imgElement.style.display = 'none';
    }
    
    const modal = new bootstrap.Modal(document.getElementById('productDetailModal'));
    modal.show();
}

// Cargar productos al iniciar
document.addEventListener('DOMContentLoaded', () => {
    loadProducts(1);
});
