const triggers1 = document.querySelectorAll('[aria-haspopup="dialog1"]');
const doc1 = document.querySelector('.js-document');
const focusableElementsArray1 = [
  	'[href]',
  	'button:not([disabled])',
  	'input:not([disabled])',
  	'select:not([disabled])',
  	'textarea:not([disabled])',
  	'[tabindex]:not([tabindex="-1"])',
];
const keyCodes1 = {
  tab: 9,
  enter: 13,
  escape: 27,
};

const open1 = function (dialog1) {
  const focusableElements = dialog1.querySelectorAll(focusableElementsArray1);
  const firstFocusableElement = focusableElements[0];
  const lastFocusableElement = focusableElements[focusableElements.length - 1];

  dialog1.setAttribute('aria-hidden', false);
  doc1.setAttribute('aria-hidden', true);

  // return if no focusable element
  if (!firstFocusableElement) {
    return;
  }

  window.setTimeout(() => {
    firstFocusableElement.focus();

    // trapping focus inside the dialog
    focusableElements.forEach((focusableElement) => {
      if (focusableElement.addEventListener) {
        focusableElement.addEventListener('keydown', (event) => {
          const tab = event.which === keyCodes1.tab;

          if (!tab) {
            return;
          }

          if (event.shiftKey) {
            if (event.target === firstFocusableElement) { // shift + tab
              event.preventDefault();

              lastFocusableElement.focus();
            }
          } else if (event.target === lastFocusableElement) { // tab
            event.preventDefault();

            firstFocusableElement.focus();
          }
        });
      }
    });
  }, 100);
};

const close1 = function (dialog1, trigger1) {
  dialog1.setAttribute('aria-hidden', true);
  doc1.setAttribute('aria-hidden', false);

  // restoring focus
  trigger1.focus();
};

triggers1.forEach((trigger1) => {
  const dialog1 = document.getElementById(trigger1.getAttribute('aria-controls'));
  const dismissTriggers = dialog1.querySelectorAll('[data-dismiss]');

  // open dialog
  trigger1.addEventListener('click', (event) => {
    event.preventDefault();

    open(dialog1);
  });

  trigger1.addEventListener('keydown', (event) => {
    if (event.which === keyCodes1.enter) {
      event.preventDefault();

      open(dialog1);
    }  
  });

  // close dialog
  dialog1.addEventListener('keydown', (event) => {
    if (event.which === keyCodes1.escape) {
      close(dialog1, trigger1);
    }      
  });

  dismissTriggers.forEach((dismissTrigger) => {
    const dismissDialog = document.getElementById(dismissTrigger.dataset.dismiss);

    dismissTrigger.addEventListener('click', (event) => {
      event.preventDefault();

      close(dismissDialog, trigger1);
    });
  });

  window.addEventListener('click', (event) => {
    if (event.target === dialog1) {
      close(dialog1, trigger1);
    }
  }); 
});