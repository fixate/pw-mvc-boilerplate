/* -------------------------------------------------- *\
    MAIN
\* -------------------------------------------------- */
import toggler from './lib/toggler';

const $ = window.jQuery;

if ($.fn.toggler) {
  $('.js-menu-toggle').toggler({
    activeClass: 'is-open-nav',
  });
}

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

$('html').removeClass('no-js');
