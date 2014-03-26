'use strict'

# *******************************************************
# Toggler
# *******************************************************
$.fn.toggler = (options = {}) ->
	options.activeClass ||= 'active'
	options.activeTriggerClass ||= 'active'
	options.closeTarget ||= false
	selector = @selector
	resizeTimer = null

	getTarget = (el) ->
		$ $(el).data('target')

	isOn = ($el) ->
		if $el.hasClass(options.activeClass)
			true
		else
			!!$el.data('on')

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

		setOn($el, !active)
		$target[fn](options.activeClass)
		$el[fn](options.activeTriggerClass)

	setElems = ($el) ->
		$el.each ->
			$el = $(@)
			$target = getTarget($el)

			setOn($el, $target.hasClass(options.activeClass))

	$el = $(@)
	$($el.parent).on 'click touch', @selector, (e) ->
		e.preventDefault()
		e.stopPropagation()
		togglePress $(@)
		return

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
		$selector = $(selector)

		for el in $selector
			$elem = $(el)
			if $elem.data('click-off')  == 'on' && isWideEnough($elem) && !$(e.target).hasClass($elem.data('click-off-exception'))
				setShow($elem, false)

		return

	setElems($el)


$('.js-menu-toggle').toggler
	activeClass: 'is-open-nav',

$('html').removeClass('no-js')

