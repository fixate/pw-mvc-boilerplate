/* --------------------------------------------------*\
    TOGGLER
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

  function init() {
    document.addEventListener('click', handleClick);
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

    handleExternalTriggerClick(triggerPair, clickTarget);
  }

  function handleTriggerClick(triggerPair) {
    const { target, trigger } = triggerPair;
    const matchingPairs = getMatchingPairs(triggerPair);
    const triggerWasActive = trigger.classList.contains(triggerToggleClass);
    const classListFn = triggerWasActive ? 'remove' : 'add';

    matchingPairs.map(pair => {
      pair.trigger.classList[classListFn](triggerToggleClass);
    });
    target.classList[classListFn](targetToggleClass);
  }

  function handleExternalTriggerClick(triggerPair, clickTarget) {
    const nonMatchingPairs = getNonMatchingPairs(triggerPair);

    nonMatchingPairs.map(pair => {
      const clickIsOutsideTarget = clickTarget !== pair.target && !pair.target.contains(clickTarget);
      const clickIsOutsideTrigger = clickTarget !== pair.trigger && !pair.trigger.contains(clickTarget);

      if (clickIsOutsideTrigger && clickIsOutsideTarget) {
        pair.trigger.classList.remove(triggerToggleClass);
        pair.target.classList.remove(targetToggleClass);
      }
    });
  }

  function getMatchingPairs(triggerPair) {
    return elementPairs.filter(pair => {
      return triggerPair.target === pair.target;
    });
  }

  function getNonMatchingPairs(triggerPair) {
    return elementPairs.filter(pair => {
      return triggerPair.target !== pair.target;
    });
  }

  function destroy() {
    document.removeEventListener('click', handleClick);
  }

  init();

  return {
    elementPairs,
    destroy,
  };
}

