import { truncateText } from "../utils/text-truncate";

export function createProductCard(product) {
    const col = document.createElement('div');
    col.className = 'col-6 col-md-4 col-lg-3';

    col.innerHTML = `
        <div class="card h-100 border-0 shadow-sm product-card">
            <div class="position-relative p-1">
                <img src="${product.image_url ?? 'https://via.placeholder.com/300x200'}" 
                     class="card-img-top"
                     alt="${product.name}">

                <span class="badge ${product.is_visible ? 'bg-success' : 'bg-secondary'} position-absolute top-0 end-0 m-2">
                    ${product.is_visible ? 'Visible' : 'Oculto'}
                </span>
            </div>

            <div class="card-body d-flex flex-column">
                <h6 class="fw-semibold mb-1">${product.name} <small class="text-muted"> - ${product.category ?? 'Sin categoría'}</small></h6>

                <span class="text-success fw-bold mb-2">
                    $${product.price}
                </span>

                <p class="text-muted small mb-3">
                    ${truncateText(product.description ?? '')}
                </p>

                <div class="mt-auto d-flex flex-column flex-md-row gap-2">
                    <button class="btn btn-sm btn-outline-primary w-100 btn-edit" data-id="${product.id}">
                        Editar
                    </button>
                    <button class="btn btn-sm btn-outline-danger w-100 btn-delete" data-id="${product.id}">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    `;

    return col;
}