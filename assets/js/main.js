/*--------------------------------------------------*\
    MAIN
\*--------------------------------------------------*/
import toggler from './lib/toggler';

var body = document.body;

if ($.fn.toggler) {
  $('.js-menu-toggle').toggler({
    activeClass: 'is-open-nav'
  });
}

$(window).on('scroll', function() {
  var timer = void 0;
  clearTimeout(timer);

  if (!body.classList.contains("disable-hover")) {
    body.classList.add("disable-hover");
  }

  timer = setTimeout(function() {
    body.classList.remove("disable-hover");
  }, 50);
});

$('html').removeClass('no-js');
