/*Sticky header
*****************************************************/
window.addEventListener('scroll', function () {
    var header = document.querySelector('header');
    header.classList.toggle("sticky", window.scrollY > 0);
});

/*Update copy automatically
**************************************************/
document.querySelector(".year-copy").innerText = new Date().getFullYear();

/*Header anchor links
*********************************************/
$(document).ready(function(){
    $('header li a[href^="#"], .card-body a').on('click',function (e) {
        e.preventDefault();
        var target = this.hash,
        $target = $(target);

        if ($("header").hasClass("sticky")) {
            var numberScroll = 88;
        } else {
            var numberScroll = 203;
        }

        $('html, body').stop().animate({
            'scrollTop': $target.offset().top - numberScroll
        }, 500, 'swing');
    });
}); 

/*JS para que al clickear en nav items se cierre hamburguesa
*****************************************************************************/
const navLinks = document.querySelectorAll('.nav-item');
const menuToggle = document.getElementById('navbarNav');
const bsCollapse = new bootstrap.Collapse(menuToggle, {toggle:false});
navLinks.forEach((l) => {
    l.addEventListener('click', () => { bsCollapse.toggle() })
});

/*AOS
*********************************************/
AOS.init({
    once: true, // whether animation should happen only once - while scrolling down
});