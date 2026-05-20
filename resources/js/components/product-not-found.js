export function productNotFound(message) {
    return `
        <div class="col-12">
            <div class="card border-0 shadow-sm text-center py-5">
                <div class="card-body">
                    <i class="bi bi-box-seam text-muted" style="font-size: 2rem;"></i>
                    <h6 class="mt-3 mb-1">Sin productos</h6>
                    <p class="text-muted mb-0">
                        ${message}
                    </p>
                </div>
            </div>
        </div>
    `;
}