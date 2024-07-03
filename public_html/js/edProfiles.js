document.addEventListener("DOMContentLoaded", function() {
    let edTypeBlock= document.querySelector("#pills-fl");
    let edTypeBtns= edTypeBlock.querySelectorAll("a");

    let edLevelMenuList= document.querySelectorAll("a.edLevelMenu");
    let tabsBlock= document.querySelector('#pills-tab');
    let tabs = tabsBlock.querySelectorAll('#pills-tab .nav-link');
    let tabContents = document.querySelectorAll('.tab-pane');

    if(get("tab"))
        window.scrollTo(window.scrollX, tabsBlock.offsetTop - 100);

    // ОБРАБОТКА ВЕРХНЕГО МЕНЮ //
    edLevelMenuList.forEach((el,i) => {
        el.addEventListener("click", (e)=>{
            e.preventDefault();
            let level= e.target.getAttribute("href");
            showEdLevel(level);
            window.scrollTo(window.scrollX, tabsBlock.offsetTop - 100);
        });
    });

    // ОБРАБОТКА МЕНЮ С УРОВНЕМ ОБРАЗОВАНИЯ //

    tabs.forEach(tab => {
        tab.addEventListener('click', function(event) {
            event.preventDefault();
            let level= event.target.getAttribute("href");
            showEdLevel(level);
        });
    });

    // ОБРАБОТКА МЕНЮ С ФОРМОЙ ОБУЧЕНИЯ //

    edTypeBtns.forEach((el,i) => {
        el.addEventListener("click", (e)=>{
            e.preventDefault();
            if(e.target.classList.contains("active")) return false;
            let edType= e.target.getAttribute("data-etype");
            edTypeBlock.querySelector(".active").classList.remove("active");
            e.target.classList.add("active");
            eTypeHide();
            eTypeShow(edType)
            checkCard();
        });
    });


    // получение параметра с адресной строки //
    function get(name){
        if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
            return decodeURIComponent(name[1]);
    }

    //  ПОИСК //
    function searchDepartments() {
        // Получаем значение из поля поиска
        var searchText = document.getElementById("search-depart").value.toLowerCase();

        // Получаем все элементы с классом "card-title"
        var cardTitles = document.getElementsByClassName("name");

        // Проходимся по всем элементам и скрываем те, которые не содержат введенный текст
        for (var i = 0; i < cardTitles.length; i++) {
            var cardTitleText = cardTitles[i].innerText.toLowerCase();
            var card = cardTitles[i].closest('.box-depart');
            if (cardTitleText.includes(searchText)) {
                card.style.display = "block";
                card.removeAttribute("data-found");
            } else {
                card.style.display = "none";
                card.setAttribute("data-found","hide");
            }
        }
        checkCountVisibleCards();
    }
    // Добавляем обработчик события input к полю поиска
    document.getElementById("search-depart").addEventListener("input", searchDepartments);

    //  END ПОИСК //


    // ФУНКЦИИ ПОСТАНОВКИ МЕТКИ ДЛЯ ПЕРЕКЮЧЕНИЯ КАРТОЧЕК //
    function eTypeHide(){
        let list= document.querySelectorAll(".tab-content .edTypeShow");
        list.forEach((el,i) => {
            el.classList.remove("edTypeShow");
            el.classList.add("edTypeHide");
        });
        return false;
    }
    function eTypeShow(op){
        let list= document.querySelectorAll(".tab-content ."+op);
        list.forEach((el,i) => {
            el.classList.remove("edTypeHide");
            el.classList.add("edTypeShow");
        });
        return false;
    }

    // ПЕРЕКЛЮЧЕНИЕ КАРТОЧЕК //
    function checkCard(){
        let list= document.querySelectorAll(".box-depart");
        list.forEach((el,i) => {
            let check= el.querySelectorAll(".edTypeShow").length;
            if(check === 0)
                el.classList.add("d-none");
            else
                el.classList.remove("d-none");
        });
        checkCountVisibleCards();
        return false;
    }

    // ФУНКЦИЯ ПЕРЕКЛЮЧЕНИЕ ПАНЕЛЕЙ С КАРТОЧКАМИ //
    function showEdLevel(level){
        let activeTabs= tabsBlock.querySelectorAll("a.active");
        activeTabs.forEach(tab => tab.classList.remove('active'));
        let active= tabsBlock.querySelector("[href='"+level+"']");
        active.classList.add('active');
        tabContents.forEach(tabContent => tabContent.classList.remove('show', 'active'));
        const target = document.querySelector(level);
        target.classList.add('show', 'active');
        checkCountVisibleCards();
        return false;
    }


    // ФУНКЦИЯ ПРОВЕРКИ КОЛ-ВА ВИДИМЫХ КАРТОЧЕК СОГЛАСНО ФИЛЬТРА И ПОИСКА //
    function checkCountVisibleCards(){
        let list= document.querySelectorAll(".tab-pane.active .box-depart");
        let list2= document.querySelectorAll(".tab-pane.active .box-depart.d-none");
        let list3= document.querySelectorAll(".tab-pane.active .box-depart:not([data-found='hide'])");
        let boxNotFound= document.getElementById("not_found");
        if(list.length == list2.length || !list3.length)
            boxNotFound.classList.remove("d-none");
        else
            boxNotFound.classList.add("d-none");
        return false;
    }

});
