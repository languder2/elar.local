document.addEventListener("DOMContentLoaded",function (){
    let list= document.querySelectorAll(".change-visible");
    list.forEach(el=>{
        el.addEventListener("change",e=>{
            e.preventDefault();
            let data= new FormData();
            let display= el.checked?"1":"0";

            data.append('display', display);
            data.append('id', el.getAttribute("data-id"));
            fetch(el.getAttribute("data-link"),{
                method: "POST",
                body: data,
            })
                .then(response => {return response.text();})
                .then(data => {
                    //console.log(data);
                });
        });
    });
});
