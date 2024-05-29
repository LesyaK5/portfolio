/**
 * Отображает только 5 кнопок пагинации
 * @returns 
 */

// получаем список, размеры, цвет, категории товаров из БД
async function getProductParameters(URL) {
    let response = await fetch(URL);
    if (response.ok) {
        let json = await response.json();
        // let json = await response.text();
        console.log(json);
        return json;
    }
}


// будет выводить размеры в фильтр checkbox
function displaySizes(sizes) {
    const sizeBox = document.querySelector('#size');
    sizeBox.innerHTML = '';
    sizes.forEach(size => {
        sizeBox.innerHTML += `
        <div class="sort-content__box">
            <input class="checkbox" id="${size.id_size}" type="checkbox" value="${size.id_size}">
            <label class="sort-label" for="${size.id_size}">${size.size_name}</label>
        </div>`;
    })
}

// будет выводить цвета в фильтр checkbox
function displayColors(colors) {
    const colorBox = document.querySelector('#color');
    colorBox.innerHTML = '';
    colors.forEach(color => {
        colorBox.innerHTML += `
        <div class="sort-content__box">
            <input class="checkbox" id="${color.id_color}" type="checkbox" value="${color.id_color}">
            <label class="sort-label" for="${color.id_color}">${color.color_name}</label>
        </div>`;
    })
}

// будет выводить категории товаров
function displayCategories(categories) {
    const categoryBox = document.querySelector('#category');
    categoryBox.innerHTML = '';
    categories.forEach(category => {
        categoryBox.innerHTML += `
        <a href="#" class="filterContent__link" id="${category.id_category}">${category.category_name}</a>
        `
    })
}

// получаем строку для get-запроса (с фильтрами)
function getURLstring(obj, page) {
    // собираем все выбранные значения в переменной
    let chosenString = `?page=${page}`;
    if (obj.price.price1 !== '') {
        chosenString += `&price1=${obj.price.price1}`;
    };
    if (obj.price.price2 !== '') {
        chosenString += `&price2=${obj.price.price2}`;
    };
    if (obj.size.size > 0) {
        chosenString += '&size=%5B';
        obj.size.forEach((el) => {
            chosenString += `${el}%2C`;
        });
        chosenString = chosenString.slice(0, length - 3);
        chosenString += '%5D';
    };
    if (obj.color.size > 0) {
        chosenString += '&color=%5B';
        obj.color.forEach((el) => {
            chosenString += `${el}%2C`;
        });
        chosenString = chosenString.slice(0, length - 3);
        chosenString += '%5D';
    };
    if (obj.category !== 0) {
        chosenString += `&category=${obj.category}`;
    }
    return chosenString;
}

async function displayPage(clientChoose, currentPage, buttonsCount, cardsPerPage) {
    // получаем список товаров
    let filteredProducts = await getProductParameters(clientChoose);

    const pagesCount = Math.ceil(filteredProducts.length / cardsPerPage);
    // Отрисовываем товары на странице
    const startNumber = cardsPerPage * (currentPage - 1);   // номер карточки, с которой начинается вывод на стр
    const endNumber = startNumber + cardsPerPage;        // номер карточки, на которой заканчивается вывод на стр
    const paginatedData = filteredProducts.slice(startNumber, endNumber);    // cрезанный массив с выбранными карточками

    displayProductList(paginatedData);

    // Пагинация
    if (pagesCount > 1) {
        displayPagination(currentPage, pagesCount, buttonsCount, filteredProducts, cardsPerPage);
    } else {
        const paginationEl = document.querySelector('.catalog-pagination');
        paginationEl.innerHTML = '';
    }
}

function displayProductList(products) {
    // корзина покупателя
    let cart = {};
    // количество товаров в корзине
    let totalQuantity = 0;
    // если в корзине есть товары (в localStorage), то получаем их    
    if (localStorage.getItem('cart') != null ) {
        cart = JSON.parse(localStorage.getItem('cart'));
        totalQuantity = localStorage.getItem('totalQuantity');
    }
    const productList = document.querySelector('.product-list');    // нашли контейнер с классом product-list (список всех товаров)
    productList.innerHTML = "";     // здесь мы убираем товары предыдущей страницы, чтобы отрисовать товары текущей стр, на которую мы перешли.
    // запишем количество товаров в корзине на значок корзины
    const totalQuantityElement = document.querySelector('.totalQuantity');
    totalQuantityElement.textContent = totalQuantity;

    products.forEach(card => {                                 // проходимся по полученному массиву товаров
        
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
            `<div class="product__card" onclick="cardClick(event)" data-idProduct="${card.id_product}">` + product + 
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
                totalQuantityElement.textContent = totalQuantity;
            } else {
                window.location.href = `product.html?id=${productId}`;
            }
        })
    })
}
// при создании карточки добавили обработчик клика на ней
function cardClick(event) {
    // проверяем, на кнопку "Add to Cart" было нажатие или на другую часть карточки
    // console.log('function cardClick: ' + event.target);
}

function displayPagination(currentPage, pagesCount, buttonsCount, filteredProducts, cardsPerPage) {
    const paginationEl = document.querySelector('.catalog-pagination');
    paginationEl.innerHTML = '';

    const ulEl = document.createElement("ul");
    ulEl.classList.add('pages');

    const liFirst = document.createElement("li");
    liFirst.classList.add('page');
    liFirst.textContent = '<';
    ulEl.appendChild(liFirst);

    // определяем с какой по какую цифру отрисовать
    let start = 1; // 0
    let end = pagesCount;
    if (pagesCount > buttonsCount) {                
        if (currentPage <= buttonsCount / 2 + 1) {  
            end = buttonsCount;
        } else if(currentPage >= pagesCount - 2) {
            start = pagesCount - buttonsCount + 1;
        } else {
            start = Number(currentPage) - 2;
            end = Number(currentPage) + 2;
        }
    }

    for (let i = start; i <= end; i++) {
        const liEl = document.createElement("li");
        liEl.classList.add('page');
        liEl.innerText = i;
        ulEl.appendChild(liEl);
    }

    const liLast = document.createElement("li");
    liLast.classList.add('page');
    liLast.textContent = '>';
    ulEl.appendChild(liLast);

    paginationEl.appendChild(ulEl);

    // закрасить номер текущей страницы
    let pagesItems = document.querySelectorAll('.pages li');   // у предыдущей страницы нужно удалить выделение номера
    pagesItems.forEach(page => {
        if (page.textContent == currentPage) page.classList.add('page-active');
        else page.classList.remove('page-active');
    });
    ulEl.addEventListener('click', (event) => {
        // вычисляем текущую страницу
        currentPage = event.target.textContent;
        if (currentPage === '>') {
            currentPage = pagesCount;
        } else if (currentPage === '<') {
            currentPage = '1';
        }

        // перерисовываем пагинацию
        displayPagination(currentPage, pagesCount, buttonsCount, filteredProducts, cardsPerPage);

        // отрисовываем товары
        const startNumber = cardsPerPage * (currentPage - 1);           // номер карточки, с которой начинается вывод на стр
        const endNumber = startNumber + cardsPerPage;                   // номер карточки, на которой заканчивается вывод на стр
        const paginatedData = filteredProducts.slice(startNumber, endNumber);    // cрезанный массив с выбранными карточками
        displayProductList(paginatedData);
    })
};

function colorCurrentPageNumber(currentPage) {
    // закрасить номер текущей страницы
    let pagesItems = document.querySelectorAll('.pages li');   // у предыдущей страницы нужно удалить выделение номера
    pagesItems.forEach(page => {
        if (page.textContent === currentPage) page.classList.add('page-active');
        else page.classList.remove('page-active');
    });
}

async function main() {
    try {
        // при загрузке страницы отображаются товары по умолчанию (товары, добавленные в БД последними) - первая страница
        let clientChoose = '../server/getFilteredProducts.php?page=1';

        let cardsPerPage = 9; // rows количество карточек на одной странице
        if (window.innerWidth < 1025) {
            cardsPerPage = 8;
        }
        const buttonsCount = 5; // количество кнопок пагинации
        let currentPage = '1';


        displayPage(clientChoose, currentPage, buttonsCount, cardsPerPage);

        const sizes = await getProductParameters('../server/getProductSizes.php');
        displaySizes(sizes);

        // получим список цветов
        const colors = await getProductParameters('../server/getProductColors.php');
        displayColors(colors);

        // получим список категорий
        const categories = await getProductParameters('../server/getProductCategories.php');
        displayCategories(categories);

        // обработаем изменения фильтра
        const choose = {};
        choose.price = { 'price1': '', 'price2': '' }; //[0, Infinity];
        choose.size = new Set();
        choose.color = new Set();
        choose.category = 0;  //  можно выбрать только одну категорию

        // при выборе/удалении размера
        const sizeBox = document.querySelector('#size');
        sizeBox.addEventListener('change', async function (event) {
            if (event.target.checked) {
                choose.size.add(event.target.id);
            } else {
                choose.size.delete(event.target.id);
            };
            clientChoose = getURLstring(choose, currentPage);

            clientChoose = '../server/getFilteredProducts.php' + clientChoose;
            // закрыть окошко
            sizeBox.closest('.sort-details').removeAttribute('open');

            displayPage(clientChoose, currentPage, buttonsCount, cardsPerPage);
        });

        // при выборе/удалении цвета 
        const colorBox = document.querySelector('#color');
        colorBox.addEventListener('change', async (event) => {
            if (event.target.checked) {
                choose.color.add(event.target.id);
            } else {
                choose.color.delete(event.target.id);
            };
            clientChoose = getURLstring(choose, currentPage);

            clientChoose = '../server/getFilteredProducts.php' + clientChoose;
            // закрыть окошко
            colorBox.closest('.sort-details').removeAttribute('open');

            displayPage(clientChoose, currentPage, buttonsCount, cardsPerPage);
        });

        const priceBox = document.querySelector('#price');
        priceBox.addEventListener('change', async (event) => {
            if (event.target.value !== '') {
                choose.price[event.target.id] = event.target.value;
            } else {
                choose.price[event.target.id] = '';
            }
            clientChoose = getURLstring(choose, currentPage);

            clientChoose = '../server/getFilteredProducts.php' + clientChoose;
            // закрыть окошко
            priceBox.closest('.sort-details').removeAttribute('open');

            displayPage(clientChoose, currentPage, buttonsCount, cardsPerPage);
        });

        const categoryBox = document.querySelector('#category');
        categoryBox.addEventListener('click', async (event) => {
            event.preventDefault();
            choose.category = event.target.id;
            clientChoose = getURLstring(choose, currentPage);

            clientChoose = '../server/getFilteredProducts.php' + clientChoose;
            // закрыть окошко
            categoryBox.closest('.filter').removeAttribute('open');

            displayPage(clientChoose, currentPage, buttonsCount, cardsPerPage);
        });
        
    } catch (error) {
        console.log(error);
    }
}

main();