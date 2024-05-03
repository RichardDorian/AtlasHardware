{
  const myAccountEl = document.querySelector('#my-account > button');
  const menuEl = document.querySelector('header > div#my-account > div');

  // If the user is logged out, the menuEl will be null
  if (myAccountEl instanceof Element && menuEl instanceof Element) {
    // When the user clicks on the account button, we show the menu
    myAccountEl?.addEventListener('click', () =>
      menuEl.classList.toggle('hidden')
    );

    function hideMenu() {
      menuEl.classList.add('hidden');
    }

    // If the user clicks outside the menu, we hide it
    document.body.addEventListener('click', (event) => {
      if (myAccountEl.contains(event.target)) return;
      hideMenu();
    });

    // If the user presses the escape key, we hide the menu
    document.addEventListener('keyup', (event) => {
      if (event.key !== 'Escape') return;

      hideMenu();
      myAccountEl.blur(); // We remove focus from the element
    });

    // Hide menu on scroll
    window.addEventListener('scroll', hideMenu);
  }
}
