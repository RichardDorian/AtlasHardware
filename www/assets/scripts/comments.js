// Get the HTML element with the ID "write-comment-button" and add an event listener to it
const writeComment = document.getElementById('write-comment-button');
writeComment?.addEventListener('click', async () => {

  // Prompt the user to enter a comment
  const comment = prompt('Write your comment down below:');

  // If the user entered a comment
  if (comment) {

    // Construct a URL using the current page's URL and append the string "/comment" to it
    const url = new URL(window.location.href);

    // Send a POST request to the constructed URL with the user's comment as the request body, encoded as a URL-encoded string
    await fetch(`${url.pathname}/comment`, {
      method: 'POST',
      body: 'comment=' + encodeURIComponent(comment),
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
    });

    // Reload the page to display the new comment
    location.reload();
  }
});
