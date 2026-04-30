import { renderProductList } from "../handlers/render-product.handler";
import { initProductPage } from "./product-page";

async function init() {
    await renderProductList();
    await initProductPage();
}

init();