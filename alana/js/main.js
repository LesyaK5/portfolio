async function main() {
    // корзина покупателя
    let cart = {};
    // количество товаров в корзине
    let totalQuantity = 0;
    // если в корзине есть товары (в localStorage), то получаем их    
    if (localStorage.getItem('cart') != null) {
        cart = JSON.parse(localStorage.getItem('cart'));
        totalQuantity = localStorage.getItem('totalQuantity');
    }
    // запишем количество товаров в корзине на значок корзины
    const totalQuantityElement = document.querySelectorAll('.totalQuantity');
    totalQuantityElement.forEach(elem => elem.textContent = totalQuantity);

    let response = await fetch('../server/getLatestProducts.php');
    if (response.ok) { 
        // получаем тело ответа 
        let json = await response.json();           
        let content = {}; 
        if (window.innerWidth < 1125) {
            content = json.splice(0, 4);
        } else {
            content = json.splice(0, 6);
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
                    </a>`;
            productList.innerHTML +=
                // добавляем карточку товара
                `<div class="product__card" data-idProduct="${card.id_product}">` + product +
                `</div>`;
        });

        // ищем все карточки товаров на странице и добавляем обработчик кликов на них - аналогичен строке 195 ( - 3 строки))) )
        const cardsList = document.querySelectorAll('.product__card');
        cardsList.forEach(card => {
            card.addEventListener('click', (event) => {
                // проверяем, на кнопку "Add to Cart" было нажатие или на другую часть карточки
                let toCartButton = card.querySelector('.product__card-add'); // находим ребенка внутри card
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
                    // выводим количество товаров в корзине вна страницу
                    totalQuantityElement.forEach(elem => elem.textContent = totalQuantity);
                } else {
                    window.location.href = `product.html?id=${productId}`;
                }
            })
        })
    } else {
        // alert("Ошибка HTTP: " + response.status);
        let productList = document.querySelector('.product-list');    // нашли контейнер с классом product-list
        productList.textContent = '';
        const p = document.createElement('p');
        p.classList.add('catalog-text');
        p.textContent = 'Произошла ошибка при загрузке с сервера. Попробуйте обновить страницу.';
        productList.append(p);
    }  
}

main();