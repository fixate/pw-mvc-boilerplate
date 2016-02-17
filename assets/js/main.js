/* -------------------------------------------------- *\
    MAIN
\* -------------------------------------------------- */
import toggler from './lib/toggler';

const $ = window.jQuery;





/* -------------------------------------------------- *\
    INITIALISE TOGGLER
\* -------------------------------------------------- */
if ($.fn.toggler) {
  $('.js-menu-toggle').toggler({
    activeClass: 'is-open-menu',
  });
}





/* -------------------------------------------------- *\
    DISABLE HOVER
\* -------------------------------------------------- */
window.addEventListener('scroll', () => {
  const body = document.body;
  let timer = void 0;
  clearTimeout(timer);

  if (!body.classList.contains('disable-hover')) {
    body.classList.add('disable-hover');
  }

  timer = setTimeout(() => {
    body.classList.remove('disable-hover');
  }, 100);
});





/* -------------------------------------------------- *\
    REMOVE NO-JS
\* -------------------------------------------------- */
$('html').removeClass('no-js');
