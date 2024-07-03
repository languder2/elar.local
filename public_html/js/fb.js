document.addEventListener("DOMContentLoaded", function() {
    let phone= document.getElementById('fb_phone');
    const phoneMask = IMask(phone, {
        mask: '+{7} (000) 000-00-00',
    });
    phoneMask.on('accept', (e) => {
        e.target.classList.remove("is-valid","is-invalid");
    });
    phoneMask.on('complete', () => {phone.classList.add("is-valid")});
    phone.addEventListener("change",(e)=>{
        checkFormField(e.target,"phone");
    });

    let fbcalls= document.querySelectorAll(".fb_call");
    fbcalls.forEach(el => {
        el.addEventListener("click", (e)=>{
            e.preventDefault();
            let fbBlock= document.querySelector('.fb_block');
            if(!fbBlock.classList.contains("fb_show"))
                fbShow(fbBlock);
            else
                fbHide(fbBlock);
            return false;
        });
    });
    document.querySelector("#fb_form .close").addEventListener("click", (e)=>{e.preventDefault(); fbHide(document.querySelector('.fb_block'));});
    document.querySelector(".fb_response .close").addEventListener("click", (e)=>{e.preventDefault(); fbHide(document.querySelector('.fb_response'));});
    document.querySelector(".fb_response .btnClose").addEventListener("click", (e)=>{e.preventDefault(); fbHide(document.querySelector('.fb_response'));});
    let form= document.querySelector("#fb_form");
    form.onsubmit =  ()=>{
        if(checkForm()){
            let data= new FormData(form);
            fetch(form.getAttribute("action"),{
                method: "POST",
                body: data,
            })
                .then(response => {return response.text();})
                .then(data => {
                    data= JSON.parse(data);
                    fbHide(document.querySelector('.fb_block'));
                    fbShow(document.querySelector('.fb_response'));
                });
        }
        return false;
    }

    function fbShow(el){
        el.classList.remove('fb_hide');
        el.classList.add('fb_show');
        return false;
    }
    function fbHide(el){
        el.classList.remove('fb_show');
        el.classList.add('fb_hide');
        return false;
    }
    function checkForm(){
        checkFormField(document.getElementById('fb_name'),"name");
        checkFormField(document.getElementById('fb_email'),"email");
        checkFormField(document.getElementById('fb_phone'),"phone");
        checkFormField(document.getElementById('fb_message'),"message");
        return !document.querySelectorAll('#fb_form .is-invalid').length;
    }
    function checkFormField(el,type){
        el.classList.remove("is-valid","is-invalid");
        switch (type){
            case "name":
                el.classList.add(el.value.length?"is-valid":"is-invalid");
                break;
            case "email":
                el.classList.add(/^[\w.]+@\w+[.][a-z]{2,3}$/i.test(el.value)?"is-valid":"is-invalid");
                break;
            case "phone":
                el.classList.add(/^\+7 \([0-9]{3}\) [0-9]{3}(-[0-9]{2}){2}$/.test(el.value)?"is-valid":"is-invalid");
                break;
            case "message":
                el.classList.add(el.value?"is-valid":"is-invalid");
            break;
        }
    }


});

