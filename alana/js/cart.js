// проверяем авторизацию (в localStorage есть запись "user_token") и отображаем корзину (.cart {display:flex})
function checkAuthorization() {
    if (localStorage.getItem('user_token') !== null) {
        // показываем блок cart
        let cartElement = document.querySelector('.cart');
        cartElement.style.display = 'flex';
    } else {
        // если токена нет, перенаправляем на страницу входа
        window.location.href = 'authorization.html';
    }
}

async function getProductsForCart(URL) {
    let response = await fetch(URL);
    if (response.ok) {
        // let json = await response.text();
        let json = await response.json();
        console.log(json);
        return json;
    }
}

async function main() {
    checkAuthorization();
    // получаем корзину из localStorage
    let cart = {};
    let totalQuantity = 0;
    // если в корзине есть товары (в localStorage), то получаем их    
    if (localStorage.getItem('cart') != null) {
        cart = JSON.parse(localStorage.getItem('cart'));
        totalQuantity = localStorage.getItem('totalQuantity');
    } 
    // выводим количество товаров в корзине на страницу
    const totalQuantityElement = document.querySelector('.totalQuantity');
    totalQuantityElement.textContent = totalQuantity;

    // количество товаров в корзине
    const productsCount = Object.values(cart).reduce((sum, count) => sum + count, 0); // общее количество товаров

    let URLstring = '?id=%5B';
    if (cart != null) {
        
        for (const id in (cart)) {
            console.log(id);
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
                    <h3 class="product-heading">${(card.product_name).toUpperCase()} ${card.id_product}</h3>
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
                            <input class="product-parameters__quantity" type="number" min="0" value="${cart[card.id_product]}">
                        </p>
                    </div>
                </div>
                <i class="fa fa-times btn-del" aria-hidden="true"></i>
            </div>`;
                
            productList.innerHTML += product;
        });
        product = 
        `
        <div class="cart-buttons">
                <div>
                    <p class="cart-button">CLEAR SHOPPING CART</p>
                </div>
                <div>
                    <p class="cart-button">CONTINUE SHOPPING</p>
                </div>
            </div>`;
        productList.innerHTML += product;

        const subTotalElement = document.querySelector('.amount-subtotal__price');
        subTotalElement.textContent = '₽' + subTotal;
        const grandTotalElement = document.querySelector('.amount-grandtotal__price');
        grandTotalElement.textContent = '₽' + subTotal;

    } else {
        console.log('корзина пуста');
    }
}

main();