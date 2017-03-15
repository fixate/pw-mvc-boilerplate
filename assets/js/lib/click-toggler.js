/* --------------------------------------------------*\
    CLICK TOGGLER
\* --------------------------------------------------*/
export default function clickToggler(selector, opts = {}) {
  const elementPairs = [...document.querySelectorAll(selector)].map(elem => (
    {
      target: document.querySelector(elem.getAttribute('data-target')),
      trigger: elem,
    }
  ));
  const triggerToggleClass = opts.triggerActiveClass || 'is-active';
  const targetToggleClass = opts.targetActiveClass || 'is-active';
  const afterGoActiveCb = opts.afterGoActive || null;
  const afterGoInactiveCb = opts.afterGoInactive || null;
  const respectExternal = opts.respectExternalClick !== undefined ?
                            opts.respectExternalClick :
                              true;

  function init() {
    document.addEventListener(getEventType(), handleClick);
  }

  function getEventType() {
    return /iPad/.test(navigator.userAgent) ? 'touchend' : 'click';
  }

  function handleClick(e) {
    const clickTarget = e.target;
    const triggerPair = elementPairs.reduce((aggr, pair) => {
      const { trigger } = pair;
      const triggerClicked = clickTarget === trigger || trigger.contains(clickTarget);

      if (triggerClicked) return pair;

      return aggr;
    }, false);

    if (triggerPair) handleTriggerClick(triggerPair);

    if (respectExternal) handleExternalTriggerClick(triggerPair, clickTarget);
  }

  function handleTriggerClick(triggerPair) {
    const { target, trigger } = triggerPair;
    const matchingPairs = getMatchingPairs(triggerPair);
    const triggerWasActive = trigger.classList.contains(triggerToggleClass);
    const classListFn = triggerWasActive ? 'remove' : 'add';
    const cb = triggerWasActive ? afterGoInactiveCb : afterGoActiveCb;

    matchingPairs.map(pair =>
      pair.trigger.classList[classListFn](triggerToggleClass)
    );

    if (target) target.classList[classListFn](targetToggleClass);

    handleCallback(cb, triggerPair);
  }

  function handleExternalTriggerClick(triggerPair, clickTarget) {
    const nonMatchingPairs = getNonMatchingPairs(triggerPair);

    const deactivated = nonMatchingPairs.map(pair => {
      const { target, trigger } = pair;
      const clickIsOutsideTarget = target &&
                                    clickTarget !== target &&
                                    !target.contains(clickTarget);
      const clickIsOutsideTrigger = clickTarget !== trigger &&
                                    !trigger.contains(clickTarget);
      const shouldDeactivate = (clickIsOutsideTrigger && !target)
                            || (clickIsOutsideTrigger && clickIsOutsideTarget);
      const willUpdateClassName = target && target.classList.contains(targetToggleClass) ||
                                    trigger.classList.contains(triggerToggleClass);

      if (shouldDeactivate) {
        if (target) target.classList.remove(targetToggleClass);

        trigger.classList.remove(triggerToggleClass);
      }

      return willUpdateClassName;
    });

    if (deactivated.some(val => val === true)) {
      handleCallback(afterGoInactiveCb, triggerPair);
    }
  }

  function handleCallback(cb, triggerPair) {
    if (typeof cb === 'function') {
      cb(elementPairs, triggerPair);
    }
  }

  function getMatchingPairs(triggerPair) {
    return elementPairs.filter(pair =>
      triggerPair.target === pair.target
    );
  }

  function getNonMatchingPairs(triggerPair) {
    return elementPairs.filter(pair =>
      triggerPair.target !== pair.target
    );
  }

  function destroy() {
    document.removeEventListener(getEventType(), handleClick);
  }

  init();

  return {
    elementPairs,
    destroy,
  };
}
