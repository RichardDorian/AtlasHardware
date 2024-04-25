{
  const myAccountEl = document.querySelector('#my-account > button');
  const menuEl = document.querySelector('header > div#my-account > div');

  if (myAccountEl instanceof Element && menuEl instanceof Element) {
    myAccountEl?.addEventListener('click', () =>
      menuEl.classList.toggle('hidden')
    );

    function hideMenu() {
      menuEl.classList.add('hidden');
    }

    document.body.addEventListener('click', (event) => {
      if (myAccountEl.contains(event.target)) return;
      hideMenu();
    });
    document.addEventListener('keyup', (event) => {
      if (event.key !== 'Escape') return;

      hideMenu();
      myAccountEl.blur();
    });

    // the account popup is positioned fixed, so it doesn't move with the page scroll, so we need to hide it when the user scrolls
    // it's in fixed to be positioned relative viewport, in absolute the position will be relative to the first parent with a relative position
    window.addEventListener('scroll', function() {hideMenu();});
  }
}

