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
  }
}
