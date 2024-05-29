async function getInfoAboutProduct(URL) {
    let response = await fetch(URL);
    if (response.ok) {
        // let json = await response.text();
        let json = await response.json();
        return json;
    }
}

async function main() {
    let totalQuantity = 0;
    // если в корзине есть товары (в localStorage), то получаем их    
    if (localStorage.getItem('totalQuantity') != null) {
        totalQuantity = localStorage.getItem('totalQuantity');
    }
    // выводим количество товаров в корзине на страницу
    const totalQuantityElement = document.querySelector('.totalQuantity');
    totalQuantityElement.textContent = totalQuantity;

    const product = await getInfoAboutProduct(`../server/getInfoAboutProduct.php${window.location.search}`);
    const productElement = `
                    <a href="#" class="productView__dsc-category">${product[0].gender_name}</a>
                    <div class="productView__dsc-line"></div>
                    <h3 class="productView__dsc-title">${product[0].product_name}</h3>
                    <p class="productView__dsc-text">${product[0].product_description}</p>
                    <p class="productView__dsc-price"><i class="fa-solid fa-ruble-sign"></i>${product[0].price}</p>`;

    let productBox = document.querySelector('.productView__dsc');
    productBox.innerHTML = productElement;

    // "загружаем" картинки в слайдер
    let sliderImages = document.querySelector('.swiper-wrapper');
    sliderImages.innerHTML = '';
    product[0].img.forEach(image => {
        sliderImages.innerHTML += `<div class="swiper-slide"><img src="../img/catalog/${product[0].id_product}/${image}" alt="" class="swiper-img"></div>`;
    });
}

main();