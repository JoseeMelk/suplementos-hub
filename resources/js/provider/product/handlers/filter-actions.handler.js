import { renderCategorySelect } from "../components/category-select";
import { renderStatusSelect } from "../components/status-select";
import { getCategories } from "../services/product-service";

/**
 * Filtros por defecto
 */
let _filter = {
    search: null,
    category_id: null,
    is_visible: null
}

export async function renderFilter() {
    const categories = await getCategories();
    const status = {
        1: 'Visible',
        0: 'Oculto'
    };
    if(_filter.category_id) {
        renderCategorySelect(categories.data, 'categoryFilter', _filter.category_id);
    }
    renderCategorySelect(categories.data, 'categoryFilter');

    if(_filter.is_visible !== null) {
        renderStatusSelect(status, 'statusFilter', _filter.is_visible);
    }
    renderStatusSelect(status, 'statusFilter');
}

export function getFilters(){
    let search = document.getElementById('searchInput').value || null;
    if (search && search.length > 0 && search.length <= 3) {
        search = null;
    }
    const category_id = document.getElementById('categoryFilter').value || null;
    const is_visible = document.getElementById('statusFilter').value || null;

    _filter = {
        search: search || null,
        category_id: category_id || null,
        is_visible: is_visible || null
    };

    return _filter;
}

export function resetFilters() {
    const input = document.getElementById('searchInput');
    input.value = '';
    if(input.classList.contains('is-invalid')) {
        input.classList.remove('is-invalid');
    }
    document.getElementById('categoryFilter').value = '';
    document.getElementById('statusFilter').value = '';
    _filter = {
        search: null,
        category_id: null,
        is_visible: null
    };
}

export function validateSearchInput() {
    const input = document.getElementById('searchInput');
    const error = document.getElementById('searchError');

    const value = input.value.trim();

    if (value.length > 0 && value.length <= 3) {
        input.classList.add('is-invalid');
        return false;
    }

    input.classList.remove('is-invalid');
    return true;
}