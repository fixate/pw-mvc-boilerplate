/*--------------------------------------------------*\
    TOGGLER
\*--------------------------------------------------*/
import $ from 'jQuery';

export default $.fn.toggler = function(options) {
  if (options == null) {
    options = {};
  }

  return this.each(function() {
    var $el, getTarget, getToggleText, i, isOn, isWideEnough, len, ref, resizeTimer, selector, setElems, setOn, setShow, singleClass, togglePress;
    $el = $(this);
    options.activeClass || (options.activeClass = 'is-active');
    options.activeTriggerClass || (options.activeTriggerClass = 'is-active');
    options.closeTarget || (options.closeTarget = false);
    selector = $el.selector;
    resizeTimer = null;

    if (!!options.groupElement) {
      ref = $(this).attr('class').split(/\s+/);
      for (i = 0, len = ref.length; i < len; i++) {
        singleClass = ref[i];
        if (+(singleClass.search(/js-/)) !== -1) {
          options.elmts = $('.' + singleClass);
        }
      }
    }

    getTarget = function(el) {
      return $($(el).data('target'));
    };

    isOn = function($el) {
      return $el.hasClass(options.activeClass) || !!$el.data('on');
    };

    setOn = function($el, active) {
      var text;
      $el.data('on', active);
      text = getToggleText($el, active);
      if (text) {
        $el.text(text);
      }
    };

    getToggleText = function($el, active) {
      if (active) {
        return $el.data('on-text') || options.onText;
      } else {
        return $el.data('off-text') || options.offText;
      }
    };

    togglePress = function($el) {
      var $target, active;
      $target = getTarget($el);
      active = isOn($target);
      return setShow($el, !active);
    };

    isWideEnough = function($el) {
      return !$el.data('click-off-min-width') || $(self).width() >= $el.data('click-off-min-width');
    };

    setShow = function($el, active) {
      var $target, fn;
      $target = getTarget($el);
      fn = active ? 'addClass' : 'removeClass';
      if (!!options.groupElement) {
        $el = options.elmts;
      }
      setOn($el, !active);
      $target[fn](options.activeClass);
      return $el[fn](options.activeTriggerClass);
    };

    setElems = function($el) {
      return $el.each(function() {
        var $target;
        $el = $(this);
        $target = getTarget($el);
        return setOn($el, $target.hasClass(options.activeClass));
      });
    };

    $el.parent().on('click touch', function(e) {
      return $el.each(function(index) {
        if (e.target === $el[index] || [].slice.call($el.children()).indexOf(e.target) > -1) {
          e.preventDefault();
          togglePress($el);
          return false;
        }
      });
    });

    $('html').on('touchstart', function(e) {
      return $(this).css('cursor', 'pointer');
    });

    $(self.document).on('click touch', $el, function(e) {
      var $exceptEl;
      $exceptEl = $($el.data('click-off-exception'));
      if ($el.data('click-off') === 'on' && isWideEnough($el) && ([].indexOf.call($exceptEl, e.target) === -1 && !$exceptEl.find(e.target).length)) {
        setShow($el, false);
      }
    });

    return setElems($el);
  });
};
