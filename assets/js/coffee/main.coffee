if $.fn.toggler
  $('.js-menu-toggle').toggler
    activeClass: 'is-open-nav'





#--------------------------------------------------#
# JANK-FREE SCROLL - http://www.thecssninja.com/javascript/pointer-events-60fps
#--------------------------------------------------#
body = document.body
timer = undefined
$(window).on 'scroll', () ->
  clearTimeout timer
  body.classList.add "disable-hover"  unless body.classList.contains("disable-hover")
  timer = setTimeout(->
    body.classList.remove "disable-hover"
    return
  , 50)
  return






$('html').removeClass('no-js')
