import './bootstrap';
import '~resources/scss/app.scss';
import '~icons/bootstrap-icons.scss';
import * as bootstrap from 'bootstrap';
import.meta.glob([
    '../img/**'
])




document.querySelectorAll('.item-delete-form').forEach(form => {
    form.addEventListener('submit', (ev)=>{
        ev.preventDefault();
        
        const modalDOMElement = form.querySelector('.my-modal');
        const modalDOMEelementYes = form.querySelector('.my-modal-yes');
        const modalDOMEelementNo = form.querySelector('.my-modal-no');


        modalDOMElement.classList.add('visible');
        
        modalDOMEelementNo.addEventListener('click', function(){
            modalDOMElement.classList.remove('visible');
        })



        modalDOMEelementYes.addEventListener('click', function(){

            form.submit();

        })
    })
})