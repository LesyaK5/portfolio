// проверяем авторизацию (в localStorage есть запись "user_token") и отображаем корзину (.cart {display:flex})
function checkAuthorization() {
    if (localStorage.getItem('user_token') != null) {
        // показываем блок cart
        const cartElement = document.querySelector('.cart');
        cartElement.style.display = 'flex';
    } else {
        // если токена нет, перенаправляем на страницу входа
        window.location.href = 'authorization.html';
    }
}

async function getProductsForCart(URL) {
    let response = await fetch(URL);
    if (response.ok) {
        let json = await response.json();
        // console.log(json);
        return json;
    }
}

async function printCart(cart, totalQuantity) {
    // выводим количество товаров в корзине на страницу
    const totalQuantityElement = document.querySelectorAll('.totalQuantity');
    totalQuantityElement.forEach(elem => elem.textContent = totalQuantity);

    let URLstring = '?id=%5B';

    if (Object.keys(cart).length !== 0) {
        for (const id in (cart)) {
            URLstring += id;
            URLstring += '%2C';
        }
        URLstring = URLstring.slice(0, length - 3);
        URLstring += '%5D';

        URLstring = '../server/getProductsForCart.php' + URLstring;
        // отправляем запрос к серверу
        const products = await getProductsForCart(URLstring);

        // вывод данных на страницу
        const productList = document.querySelector('.cart-left');    // нашли контейнер с классом product-list (список всех товаров)
        productList.innerHTML = "";     // здесь мы убираем товары предыдущей страницы, чтобы отрисовать товары текущей стр, на которую мы перешли.
        let subTotal = 0;   // общая сумма товаров
        let product = '';
        products.forEach(card => {
            subTotal += parseInt(card.price) * parseInt(cart[card.id_product]);
            product = '<div class="cart-product">';
            if (card.img.length > 0)
                product += `<img class="cart-img" src="img/catalog/${card.id_product}/${card.img[0]}" alt="product">`;
            product +=
                `<div class="cart-content">
                    <h3 class="product-heading">${(card.product_name).toUpperCase()} арт.${card.id_product}</h3>
                    <div class="product-parameters">
                        <p>
                            <span class="product-parameters__name">Price:</span>
                            <span class="product-parameters__value product-price"><i class="fa-solid fa-ruble-sign"></i> ${card.price}</span>
                        </p>
                        <p>
                            <span class="product-parameters__name">Color:</span>
                            <span class="product-parameters__value">${card.color_name}</span>
                        </p>
                        <p>
                            <span class="product-parameters__name">Size:</span>
                            <span class="product-parameters__value">${card.size_name}</span>
                        </p>
                        <p class="product-parameters__quantity-block">
                            <span class="product-parameters__name">Quantity:</span>
                            <input class="product-parameters__quantity" type="number" min="1" step="1" data-productID="${card.id_product}" value="${cart[card.id_product]}">
                        </p>
                    </div>
                </div>
                <i class="fa fa-times btn-del" aria-hidden="true" data-productID="${card.id_product}"></i>
            </div>`;

            productList.innerHTML += product;
        });
        product =
            `<div class="cart-buttons">
                <div>
                    <p id="clearCart" class="cart-button">CLEAR SHOPPING CART</p>
                </div>
                <div>
                    <p id="toCatalog" class="cart-button">CONTINUE SHOPPING</p>
                </div>
            </div>`;
        productList.innerHTML += product;

        const subTotalElement = document.querySelector('.amount-subtotal__price');
        subTotalElement.textContent = '₽' + subTotal;
        const grandTotalElement = document.querySelector('.amount-grandtotal__price');
        grandTotalElement.textContent = '₽' + subTotal;

        const delButtons = document.querySelectorAll('.btn-del');
        delButtons.forEach(btn => btn.addEventListener('click', () => {
            const productID = btn.getAttribute('data-productID');
            totalQuantity = totalQuantity - Number(cart[productID]);

            delete cart[productID];

            // сохраняем в localStorage новую корзину
            localStorage.setItem('cart', JSON.stringify(cart));
            localStorage.setItem('totalQuantity', totalQuantity);

            printCart(cart, totalQuantity);
        }));

        const quantities = document.querySelectorAll('.product-parameters__quantity');

        quantities.forEach(quantity => quantity.addEventListener('change', () => {
            if (Number(quantity.value) <= 0) {
                quantity.value = "1";
            } else {
                quantity.value = Math.trunc(Number(quantity.value));
            }
            totalQuantity = totalQuantity - Number(cart[quantity.getAttribute('data-productID')]) + Number(quantity.value);
            localStorage.setItem('totalQuantity', totalQuantity);
            cart[quantity.getAttribute('data-productID')] = quantity.value;
            localStorage.setItem('cart', JSON.stringify(cart));
            totalQuantityElement.forEach(elem => elem.textContent = totalQuantity);

        }));

        const toCatalog = document.querySelector('#toCatalog');
        toCatalog.addEventListener('click', () => window.location.href = `catalog.html`)

        const clearCart = document.querySelector('#clearCart');
        clearCart.addEventListener('click', () => {
            cart = {};
            localStorage.setItem('cart', JSON.stringify(cart));
            totalQuantity = 0;
            localStorage.setItem('totalQuantity', totalQuantity);
            totalQuantityElement.forEach(elem => elem.textContent = totalQuantity);
            window.scrollTo(0, 0);
            printError();
        })

    } else {
        // console.log('корзина пуста');
        printError();
    }
}

function printError() {
    const cartElement = document.querySelector('.cart-left');
    cartElement.innerHTML = '';

    const h3 = document.createElement('h3');
    h3.classList.add('form__title');
    h3.textContent = 'ВАША КОРЗИНА ПУСТА';
    cartElement.append(h3);

    const div = document.createElement('div');
    div.classList.add('catalog-button');
    const a = document.createElement('a');
    a.classList.add('catalog-button__all-products', 'button__white');    // классы из index.html
    a.textContent = 'ПЕРЕЙТИ В КАТАЛОГ';
    a.addEventListener('click', () => window.location.href = `catalog.html`);
    div.appendChild(a);
    cartElement.append(div);
}

async function main() {
    // получаем корзину из localStorage
    let cart = {};
    let totalQuantity = 0;
    // если в корзине есть товары (в localStorage), то получаем их    
    if (localStorage.getItem('cart') != null) {
        cart = JSON.parse(localStorage.getItem('cart'));
        totalQuantity = localStorage.getItem('totalQuantity');
        // выводим корзину на экран
        printCart(cart, totalQuantity);
    } else {
        printError();
    }
}

main();