// Fixation automatique de la barre de navigation lors du défilement vers le bas, et affichage lors du défilement vers le haut.
document.addEventListener("DOMContentLoaded", function(){
    let headerElm = document.querySelector('header');
    if(headerElm){
        let lastScrollTop = 0;
        window.addEventListener('scroll', function() {
            let scrollTop = window.scrollY;
            if(scrollTop < lastScrollTop) {
                headerElm.classList.add('navbar-fixed');
            }
            else {
                headerElm.classList.remove('navbar-fixed');
            }
            lastScrollTop = scrollTop;
        });
    }
});