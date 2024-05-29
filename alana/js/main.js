async function getResponse() {
    // localStorage.clear();
    let totalQuantity = 0;
    // если в корзине есть товары (в localStorage), то получаем их    
    if (localStorage.getItem('totalQuantity') != null) {
        totalQuantity = localStorage.getItem('totalQuantity');
    } 
    // выводим количество товаров в корзине на страницу
    const totalQuantityElement = document.querySelector('.totalQuantity');
    totalQuantityElement.textContent = totalQuantity;

    let response = await fetch('../server/getLatestProducts.php');
    if (response.ok) { // если HTTP-статус в диапазоне 200-299.
        // получаем тело ответа 
        let json = await response.json();           // получаем ответ в виде json-формата
        // let json = await response.text();        // получаем ответ в виде текста
        let content = {}; // json.splice(0, 9);
        if (window.innerWidth < 1024) {
            content = json.splice(0, 2);
        } else {
            content = json.splice(0, 3);
        }
        
        let list = document.querySelector('.product-list');    // нашли контейнер с классом product-list
        list.innerHTML = '';
        for (let key in content) {
            list.innerHTML += `
                <div class="product__card">
                    <img src="../img/catalog/${content[key].id_product}/${content[key].img[0]}" alt="product" class="product__card-img">
                    <div class="product__card-text">
                        <h3 class="product__card-title">${(content[key].product_name).toUpperCase() }</h3>
                        <p class="product__card-dsc">${content[key].product_description}</p>
                        <p class="product__card-price"><i class="fa-solid fa-ruble-sign"></i> ${content[key].price}</p>
                    </div>

                    <a href="product.html" class="product__card-add">
                        <i class="fa-solid fa-cart-shopping"></i>Add to Cart
                    </a>

                </div>
            `;
        } 
    } else {
        alert("Ошибка HTTP: " + response.status);
    }  

}

getResponse();