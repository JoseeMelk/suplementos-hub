import { renderProductList } from "../handlers/render-product-list";

async function init() {
    await renderProductList();
}

init();