#--------------------------------------------------#
# Toggler
#--------------------------------------------------#
$.fn.toggler = (options = {}) ->
  @.each ->
    $el = $(@)
    options.activeClass ||= 'is-active'
    options.activeTriggerClass ||= 'is-active'
    options.closeTarget ||= false
    selector = $el.selector
    resizeTimer = null

    #  groupElments apply actions to all occurring togglers
    if !!options.groupElement
      for singleClass in $(@).attr('class').split(/\s+/)
        if +(singleClass.search /js-/) != -1
          options.elmts = $('.' + singleClass)

    getTarget = (el) ->
      $($(el).data('target'))

    isOn = ($el) ->
      $el.hasClass(options.activeClass) || !!$el.data('on')

    setOn = ($el, active) ->
      $el.data('on', active)
      text = getToggleText($el, active)
      $el.text(text) if text
      return

    getToggleText = ($el, active) ->
      if active
        $el.data('on-text') || options.onText
      else
        $el.data('off-text') || options.offText

    togglePress = ($el) ->
      $target = getTarget($el)
      active = isOn($target)
      setShow($el, !active)

    isWideEnough = ($el) ->
      !$el.data('click-off-min-width') ||
        $(self).width() >= $el.data('click-off-min-width')

    setShow = ($el, active) ->
      $target = getTarget($el)

      fn = if active then 'addClass' else 'removeClass'

      if !!options.groupElement
        $el = options.elmts  #change el to a group el

      setOn($el, !active)
      $target[fn](options.activeClass)
      $el[fn](options.activeTriggerClass)

    setElems = ($el) ->
      $el.each ->
        $el = $(@)
        $target = getTarget($el)

        setOn($el, $target.hasClass(options.activeClass))

    $el.parent().on 'click touch', (e) ->
      $el.each (index) ->
        if (e.target == $el[index] or [].slice.call($el.children()).indexOf(e.target) > -1)
          e.preventDefault()
          togglePress($el)
          false

    # iOS Safari doesn't fire the click event at and above body, unless... wait for it...
    # the elements have the CSS property cursor: pointer;
    #
    # http://www.quirksmode.org/blog/archives/2010/10/click_event_del_1.html
    #
    # let's set this only for touch devices so that click-off works as expected without
    # making a nasty cursor on desktop
    $('html').on 'touchstart', (e) ->
      $(this).css('cursor', 'pointer')

    $(self.document).on 'click touch', $el, (e) ->
      if $el.data('click-off')  == 'on' && isWideEnough($el) && !$(e.target).hasClass($el.data('click-off-exception'))
        setShow($el, false)

      return

    setElems($el)

