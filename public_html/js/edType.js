document.addEventListener("DOMContentLoaded", function() {
    let edTypeBlock= document.querySelector("#pills-fl");
    let edTypeBtns= edTypeBlock.querySelectorAll("a");
    edTypeBtns.forEach((el,i) => {
        el.addEventListener("click", (e)=>{
            if(e.target.classList.contains("active")) return false;
            let edType= e.target.getAttribute("data-etype");
            edTypeBlock.querySelector(".active").classList.remove("active");
            e.target.classList.add("active");
            eTypeHide();
            eTypeShow(edType)
            checkCard();
            return false;
        });
    });

});
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
function checkCard(){
    let list= document.querySelectorAll(".box-depart");
    list.forEach((el,i) => {
        let check= el.querySelectorAll(".edTypeShow").length;
        if(check === 0)
            el.classList.add("d-none");
        else
            el.classList.remove("d-none");
    });
    return false;
}