// slider
let slideNumber = 0;
let slides = document.querySelectorAll('.main__slide');
let dots = document.querySelectorAll('.main__dot');
const nextBtn = document.querySelector('.main__slider_rightArrow');
const prevBtn = document.querySelector('.main__slider_leftArrow');
nextBtn.addEventListener('click', () => {
    if (slideNumber === slides.length - 1) {
        slideNumber = 0;
    } else {
        slideNumber++;
    }
    getSlide(slideNumber);
    stopAutoplay();
})
prevBtn.addEventListener('click', () => {
    if (slideNumber === 0) {
        slideNumber = slides.length - 1;
    } else {
        slideNumber--;
    }
    getSlide(slideNumber);
    stopAutoplay();
})

function getSlide(slideNumber) {
    // console.log(slideNumber);
    slides.forEach((slide, index) => {
        if (index === slideNumber) {
            slide.classList.add('main__slide_active');
        } else {
            slide.classList.remove('main__slide_active');
        }
    })
    dots.forEach((dot, index) => {
        if (index === slideNumber) {
            dot.classList.add('main__dot_active');
        } else {
            dot.classList.remove('main__dot_active');
        }
    })
}

function autoChangeSlides() {
    // console.log(slideNumber);
    // console.log(slides.length);
    if (slideNumber === slides.length - 1) {
        slideNumber = 0;
    } else {
        slideNumber++;
    }
    getSlide(slideNumber);
}


let autoplayInterval = null;
function startAutoplay() {
    if (!autoplayInterval) {
        autoplayInterval = setInterval(autoChangeSlides, 3000);
    }
}

function stopAutoplay() {
    clearInterval(autoplayInterval);
    autoplayInterval = null;
}

startAutoplay();
// setInterval(autoChangeSlides, 2000);


// услуги
const serviceTypeArray = {
    'sanitary': 'Сантехника',
    'painting': 'Отделочные работы',
    'building': 'Строительство домов',
    'electric': 'Электрика'
}
const servicesArray = {
    'sanitary': [
        'Перенос и установка счетчиков',
        'Монтаж и ремонт водопровода',
        'Монтаж отопления',
        'Монтаж канализации',
        'Замена и перенос  полотенцесушителя',
        'Установка кранов на полотенцесушитель',
        'Установка инсталляций',
        'Установка всех видов сантех оборудования',
        'Замена батарей отопления',
        'Замена и демонтаж радиатора отопления',
        'Замена труб в ванной и туалете',
        'Замена труб в ванной',
        'Замена труб на пластиковые',
        'Монтаж трубопроводов ПВХ',
        'Замена и демонтаж радиатора отопления'
    ],
    'painting': [
        'Электромонтажные и сантехнические работы',
        'Демонтажные работы',
        'Штукатурные работы ',
        'Малярные работы',
        'Монтаж ГКЛ',
        'Облицовка стен и потолков',
        'Укладка плитки',
        'Укладка всех видов наполных покрытий'
    ],
    'building': [
        'Профессиональная укладка блоков ПГС',
        'Укладка кирпича',
        'Укладка пазогребневых плит',
        'Монтаж плит',
        'Монтаж перекрытий',
        'монтаж балок и пермычек',
        'Изготовление монолитного пола',
        'Установка перегородок',
        'Установка вентиляционных каналов',
        'Кровельные работы любой сложности'
    ],
    'electric': [
        'Замена розеток и выключателей',
        'Перенос розеток и выключателей',
        'Замена электропроводки',
        'Сборка электросчетчиков',
        'Установка электросчетчиков'
    ]
};
let services = document.querySelectorAll('.service');
let servicesList = document.querySelector('.service__list');
let serviceTitle = document.querySelector('.service__titleDsc');
servicesList.innerHTML = '';
serviceTitle.innerHTML = 'Сантехника';
servicesArray['sanitary'].forEach(serviceName => {
    // console.log(serviceName);
    let p = document.createElement('p');
    p.classList.add('service__list_padding');
    p.textContent = serviceName;
    servicesList.append(p);
})

services.forEach(service => {
    service.addEventListener('click', (event) => {
        servicesList.innerHTML = '';
        serviceTitle.innerHTML = '';
        // console.log(event.target.closest('.service').id);
        const serviceType = event.target.closest('.service').id;
        serviceTitle.textContent = serviceTypeArray[serviceType];

        servicesArray[serviceType].forEach(serviceName => {
            // console.log(serviceName);
            let p = document.createElement('p');
            p.classList.add('service__list_padding');
            p.textContent = serviceName;
            servicesList.append(p);
        })
    })
})

// о нас
const aboutUsArray = {
    1: ['более', 15, 'лет успешной работы'],
    2: ['более', 500, 'довольных клиентов'],
    3: ['более', 1000, 'м² готовых объектов'],
    4: ['более', 20, 'месяцев рассрочки'],
    5: ['более', 100, 'готовых решений']
}
let circleNumber = document.querySelector('.circle__number');
let circleText = document.querySelectorAll('.circle__text');
const aboutText = document.querySelectorAll('.aboutUs__text');
aboutText.forEach((text, index) => {
    text.addEventListener('click', () => {
        circleText[0].textContent = aboutUsArray[index + 1][0];
        circleText[1].textContent = aboutUsArray[index + 1][2];
        circleNumber.textContent = aboutUsArray[index + 1][1];
    })
})

// ГАЛЕРЕЯ
// var fs = require('fs');
// var files = fs.readdirSync('/assets/photos/');
const dir = '../img/gallery/';
const galleryTypes = {
    'tile': 'ПЛИТКА',
    'masonry': 'КЛАДКА',
    'painting': 'ОТДЕЛКА',
    'roof': 'КРОВЛЯ',
    'sanitary': 'САНТЕХНИКА',
    'electric': 'ЭЛЕКТРИКА'
}
const gallery = {
    'tile': ['tile.jpg', 'roof2.jpg', 'roof3.jpg', 'roof4.jpg', 'roof5.jpg', 'roof6.jpg', 'trim.jpg'],
    'masonry': ['placing.jpg', 'roof2.jpg', 'roof3.jpg', 'roof4.jpg', 'roof5.jpg', 'roof6.jpg', 'trim.jpg', 'placing.jpg'],
    'painting': ['trim.jpg', 'roof2.jpg', 'roof3.jpg', 'roof4.jpg', 'roof5.jpg', 'roof6.jpg', 'sanitary2.jpg', 'placing.jpg'],
    'roof': ['roof.jpg', 'roof2.jpg', 'roof3.jpg', 'roof4.jpg', 'roof5.jpg', 'roof6.jpg', 'electric.jpg', 'sanitary2.jpg'],
    'sanitary': ['sanitary2.jpg', 'roof2.jpg', 'roof3.jpg', 'roof4.jpg', 'roof5.jpg', 'roof6.jpg', 'electric.jpg'],
    'electric': ['electric.jpg', 'roof2.jpg', 'roof3.jpg', 'roof4.jpg', 'roof5.jpg', 'roof6.jpg', 'sanitary2.jpg', 'trim.jpg']
}
const cards = document.querySelectorAll('.card');
const cardsBox = document.querySelector('.gallery__popupContainer');
const closeButton = document.querySelector('.gallery__exit');
const photoBox = document.querySelector('.gallery__photoBox');
// photoBox.textContent = '';
closeButton.addEventListener('click', () => {
    cardsBox.style.display = 'none';
})
cards.forEach(card => {
    card.addEventListener('click', (event) => {
        photoBox.textContent = '';
        cardsBox.style.display = 'flex';
        console.log(event.target.closest('.card').id);
        const cardName = event.target.closest('.card').id;
        document.querySelector('.gallery__title').textContent = galleryTypes[cardName];
        gallery[cardName].forEach(image => {
            let img = document.createElement('img');
            img.classList.add('gallery__photoBox-img');
            img.src = 'img/gallery/' + image;
            img.alt = 'галерея работ';
            photoBox.append(img);
        })
    })
})



// ПРАЙС-ЛИСТ
const navbar = document.querySelector('.pricelist__navbar');
let tabs = document.querySelectorAll('.pricelist__tab');
let tables = document.querySelectorAll('.pricelist__table');

navbar.addEventListener('click', (event) => {
    // console.log(event.target.id);
    const tabNum = event.target.id.slice(3);
    console.log(tabNum);

    tabs.forEach((tab, index) => {
        // console.log(tab);
        tab.classList.remove('pricelist__tab_rightBorderNone');
        if (index + 1 == tabNum) {
            tab.classList.add('pricelist__tab_active');
            // if (tabNum > 1) {
            //     tabs[Number(tabNum) - 2].classList.add('pricelist__tab_rightBorderNone');
            // }
        } else {
            tab.classList.remove('pricelist__tab_active');

        }
    })

    if (tabNum > 1) {
        tabs[Number(tabNum) - 2].classList.add('pricelist__tab_rightBorderNone');
    }

    tables.forEach((table, index) => {
        // console.log(table);
        if (index + 1 == tabNum) {
            // console.log('add index', index);
            table.classList.add('pricelist__table_active');
        }
        else {
            // console.log('delete index', index);
            table.classList.remove('pricelist__table_active');
        }
    })
})
