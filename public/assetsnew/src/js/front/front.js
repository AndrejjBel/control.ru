function navScroll(headerId) {
    const masthead = document.getElementById(headerId);
    var prevScrollpos = window.pageYOffset;
    window.onscroll = function() {
        var currentScrollPos = window.pageYOffset;
        if (prevScrollpos > 20) {
            masthead.classList.add('header-wrap-shadow');

        } else if (prevScrollpos < 20) {
            masthead.classList.remove('header-wrap-shadow');
        }
        prevScrollpos = currentScrollPos;
    };
}
navScroll('topnav');

function dropdownElems()  {
    const dropdownBtns = document.querySelectorAll('[data-dropdown]');
    if (!dropdownBtns.length) return;
    dropdownBtns.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            document.querySelector('[data-dropdown-elem="'+btn.dataset.dropdown+'"]').classList.toggle('vision');
            dropdownElemsHide(btn, document.querySelector('[data-dropdown-elem="'+btn.dataset.dropdown+'"]'));
        });
    });

}
dropdownElems();

function dropdownElemsHide(btn, elem) {
    document.addEventListener('click', (e) => {
        if (!btn.contains(e.target) && !elem.contains(e.target)) {
            elem.classList.remove('vision');
        }
    })
}
