{
  // Get all save/unsave elements
  const saveUnsaveElements = document.querySelectorAll('[data-save-unsave]');

  for (const element of saveUnsaveElements) {
    // When the user clicks on such an element
    // it sends the associated request to save
    // or unsave the post
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

      // Reload the page to update the UI
      location.reload();
    });
  }
}
