async function getInfoAboutProduct(URL) {
    let response = await fetch(URL);
    if (response.ok) {
        let json = await response.json();
        return json;
    }
}

async function main() {
    try {
        // корзина покупателя
        let cart = {};
        let totalQuantity = 0;
        // если в корзине есть товары (в localStorage), то получаем их    
        if (localStorage.getItem('cart') != null) {
            cart = JSON.parse(localStorage.getItem('cart'));
            totalQuantity = localStorage.getItem('totalQuantity');
        }
        // выводим количество товаров в корзине на страницу
        const totalQuantityElement = document.querySelectorAll('.totalQuantity');
        totalQuantityElement.forEach(elem => elem.textContent = totalQuantity);

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

        let response = await fetch('../server/getLatestProducts.php');
        if (response.ok) {
            // получаем тело ответа 
            let json = await response.json();
            let content = {};
            if (window.innerWidth < 1125) {
                content = json.splice(0, 2);
            } else {
                content = json.splice(0, 3);
            }

            let productList = document.querySelector('.product-list');    // нашли контейнер с классом product-list
            productList.innerHTML = '';
            content.forEach(card => {
                let product = '';
                if (card.img.length > 0)
                    product +=
                        `<img src="../img/catalog/${card.id_product}/${card.img[0]}" alt="product" class="product__card-img">`;
                product +=
                    `<div class="product__card-text">
                        <h3 class="product__card-title">${(card.product_name).toUpperCase()} арт.${card.id_product}</h3>
                        <textarea class="product__card-dsc">${card.product_description}</textarea>
                        <p class="product__card-price"><i class="fa-solid fa-ruble-sign"></i> ${card.price}</p>
                    </div>

                    <a class="product__card-add" data-idProduct="${card.id_product}">
                        <i class="fa-solid fa-cart-shopping"></i>Add to Cart
                    </a>
                    `;
                productList.innerHTML +=
                    // добавляем карточку и обработчик кликов на ней
                    `<div class="product__card" data-idProduct="${card.id_product}">` + product +
                    `</div>`;
            });

            // ищем все карточки товаров на странице и добавляем обработчик кликов на них - аналогичен строке 195 ( - 3 строки))) )
            const cardsList = document.querySelectorAll('.product__card');
            cardsList.forEach(card => {
                card.addEventListener('click', (event) => {
                    // проверяем, на кнопку "Add to Cart" было нажатие или на другую часть карточки
                    let toCartButton = card.querySelector('.product__card-add');
                    const productId = toCartButton.getAttribute('data-idProduct');

                    if (event.target == toCartButton) {
                        // добавляем товар в корзину
                        if (cart[productId] != undefined) {
                            cart[productId]++;
                            totalQuantity++;
                        } else {
                            cart[productId] = 1;
                            totalQuantity++;
                        }
                        // сохраняем корзину в localStorage
                        localStorage.setItem('cart', JSON.stringify(cart));
                        localStorage.setItem('totalQuantity', totalQuantity);
                        totalQuantityElement.forEach(elem => elem.textContent = totalQuantity);
                    } else {
                        window.location.href = `product.html?id=${productId}`;
                    }
                })
            })
        }
    } catch (error) {
        let productList = document.querySelector('.product-list');    // нашли контейнер с классом product-list
        productList.textContent = '';
        const p = document.createElement('p');
        p.classList.add('catalog-text');
        p.textContent = 'Произошла ошибка при загрузке с сервера. Попробуйте обновить страницу.';
        productList.append(p);
    }
}

main();