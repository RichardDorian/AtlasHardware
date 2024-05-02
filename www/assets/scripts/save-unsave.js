{
  const saveUnsaveElements = document.querySelectorAll('[data-save-unsave]');

  for (const element of saveUnsaveElements) {
    element.addEventListener('click', async () => {
      const id = element.dataset.saveUnsave;
      const saved = element.classList.contains('saved');
      const route = saved ? '/me/unsave' : '/me/save';

      await fetch(route, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({ post: id }),
      });

      location.reload();
    });
  }
}
