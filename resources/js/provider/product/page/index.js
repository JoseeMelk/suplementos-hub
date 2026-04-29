import { renderProductList } from "../handlers/render-product-list";
import { initProductPage } from "./product-page";

async function init() {
    await renderProductList();
    await initProductPage();
}

init();