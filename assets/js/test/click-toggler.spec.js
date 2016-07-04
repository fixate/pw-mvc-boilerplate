import test from 'tape';

import createDocument from './fixtures/create-document';

import clickToggler from '../lib/click-toggler';

const btnClassName = 'js-trigger';
const divClassName = 'js-target';

const document = createDocument();
global.navigator = window.navigator;

const body = document.body;
body.innerHTML = `<html>
                    <body>
                      <div class="${divClassName}"></div>
                      <button class="${btnClassName}" data-target=".${divClassName}"></button>
                      <button class="${btnClassName}" data-target=".${divClassName}"></button>
                      <button class="${btnClassName}"></button>
                    </body>
                  </html>`;
const clickEvent = new window.MouseEvent('click', { bubbles: true });
const [button1, button2, button3] = [...body.querySelectorAll(`.${btnClassName}`)];
const targetDiv = body.querySelector(`.${divClassName}`);

function setup(opts = {}) {
  button1.className = btnClassName;
  button2.className = btnClassName;
  button3.className = btnClassName;
  targetDiv.className = divClassName;

  return clickToggler(`.${btnClassName}`, opts);
}

test('#clickToggler', nest => {
  nest.test('-> trigger clicked after destroyed', assert => {
    const msg = 'no longer toggles active class';
    const toggle = setup();

    button1.dispatchEvent(clickEvent);
    toggle.destroy();
    button1.dispatchEvent(clickEvent);

    const actual = button1.className;
    const expected = [btnClassName, 'is-active'].join(' ');

    assert.equal(actual, expected, msg);
    assert.end();
  });

  nest.test('-> trigger clicked when not active', assert => {
    const msg = 'adds active class';
    const toggle = setup();

    button1.dispatchEvent(clickEvent);

    const actual = button1.className;
    const expected = `${btnClassName} is-active`;
    toggle.destroy();

    assert.equal(actual, expected, msg);
    assert.end();
  });

  nest.test('-> trigger clicked when active', assert => {
    const msg = 'removes active class';
    const toggle = setup();

    button2.classList.add('is-active');
    button2.dispatchEvent(clickEvent);
    toggle.destroy();

    const actual = button2.className;
    const expected = btnClassName;

    assert.equal(actual, expected, msg);
    assert.end();
  });

  nest.test('-> click dispatched outside of trigger', (assert) => {
    const msg = 'removes active class';
    const toggle = setup();

    button1.classList.add('is-active');
    body.dispatchEvent(clickEvent);
    toggle.destroy();

    const actual = button1.className;
    const expected = btnClassName;

    assert.equal(actual, expected, msg);
    assert.end();
  });

  nest.test('-> trigger clicked when other triggers are active', (assert) => {
    const msg = 'removes active classes from other triggers';
    const toggle = setup();

    button1.classList.add('is-active');
    button3.dispatchEvent(clickEvent);
    toggle.destroy();

    const actual = button2.className;
    const expected = btnClassName;

    assert.equal(actual, expected, msg);
    assert.end();
  });

  nest.test('-> trigger clicked when initd with custom active class', assert => {
    const msg = 'adds custom active class to trigger';
    const triggerActiveClass = 'so-active';
    const toggle = setup({ triggerActiveClass });

    button1.dispatchEvent(clickEvent);
    toggle.destroy();

    const actual = button1.className;
    const expected = [btnClassName, triggerActiveClass].join(' ');

    assert.equal(actual, expected, msg);
    assert.end();
  });

  nest.test('-> triggers with the same target are in sync with clicked trigger', assert => {
    const msg = 'adds active class to all triggers';
    const toggle = setup();

    button1.dispatchEvent(clickEvent);
    toggle.destroy();

    const actual = button2.className;
    const expected = button1.className;

    assert.equal(actual, expected, msg);
    assert.end();
  });

  nest.test('-> click dispatched outside of active target', (assert) => {
    const msg = 'removes active class';
    const toggle = setup({ targetActiveClass: 'target-active' });

    targetDiv.classList.add('target-active');
    body.dispatchEvent(clickEvent);
    toggle.destroy();

    const actual = targetDiv.className;
    const expected = divClassName;

    assert.equal(actual, expected, msg);
    assert.end();
  });

  nest.test('-> click dispatched inside of active target', (assert) => {
    const msg = 'retains active class';
    const toggle = setup({ targetActiveClass: 'target-active' });

    targetDiv.classList.add('target-active');
    targetDiv.dispatchEvent(clickEvent);
    toggle.destroy();

    const actual = targetDiv.className;
    const expected = [divClassName, 'target-active'].join(' ');

    assert.equal(actual, expected, msg);
    assert.end();
  });
});

