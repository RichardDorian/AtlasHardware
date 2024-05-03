{
  const links = document.querySelectorAll('div#scroll-indicator > div > a');
  const indicator = document.querySelector('div#scroll-indicator > span');

  for (const link of links) {
    link.addEventListener('click', (event) => {
      event.preventDefault();

      // Update the CSS variable for indicator position
      const id = parseInt(event.target.getAttribute('data-id'));
      indicator.style.setProperty(
        '--indicator-position',
        `${(100 / links.length) * id}%`
      );

      // Update the text color
      for (const link of links) {
        link.classList.remove('selected');
      }
      link.classList.add('selected');

      // Scroll to the associated element
      if (link.hasAttribute('data-scroll-to-top')) {
        window.scrollTo({
          top: 0,
          behavior: 'smooth',
        });
      } else {
        document.querySelector(link.getAttribute('href'))?.scrollIntoView({
          behavior: 'smooth',
        });
      }
    });
  }
}
