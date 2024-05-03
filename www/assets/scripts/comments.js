{
  const writeComment = document.getElementById('write-comment-button');
  writeComment?.addEventListener('click', async () => {
    const comment = prompt('Write your comment down below:');
    if (comment) {
      const url = new URL(window.location.href);

      await fetch(`${url.pathname}/comment`, {
        method: 'POST',
        body: 'comment=' + encodeURIComponent(comment),
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
      });

      location.reload();
    }
  });
}
