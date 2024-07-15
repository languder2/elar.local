document.addEventListener("DOMContentLoaded",   ()=> {

    let FilterGroupList =   document.querySelectorAll(".filter-input-group");

    if(FilterGroupList.length === 0) return false;

    let inputList    =   document.querySelectorAll(".filter-input-group .focus-show-list");

    if(inputList.length !== 0) {
        inputList.forEach(input => {
            input.addEventListener("blur", evt => {
                if(evt.relatedTarget.classList.contains("setFilter"))
                    location.href= evt.relatedTarget.getAttribute("href");
            });
            input.addEventListener("change", () => {
                if(input.value !== "")
                    input.parentElement.querySelector("label").classList.add("active");
                else
                    input.parentElement.querySelector("label").classList.remove("active");
            });
            input.addEventListener("keyup", () => {
                let value   = input.value.toLowerCase();
                let linkList = input.parentElement.querySelectorAll(".variables a:not(.default)");
                linkList.forEach(link => {
                    if(link.innerText.toLowerCase().includes(value))
                        link.classList.remove("hide");
                    else
                        link.classList.add("hide");
                });
            });

        });
    }
});