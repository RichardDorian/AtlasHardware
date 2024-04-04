{
  const form = document.querySelector('main form');
  const status = document.querySelector('div#status');

  const elements = {
    username: form.querySelector('input[name="username"]'),
    password: form.querySelector('input[name="password"]'),
    passwordRepeat: form.querySelector('input[name="password-repeat"]'),
    register: form.querySelector('button[type="submit"]'),
    statusContainer: status.querySelector('span'),
    statusIcon: status.querySelector('span > span.material-symbols-rounded'),
    statusText: status.querySelector(
      'span > span:not(.material-symbols-rounded)'
    ),
  };

  function createStatusElements() {
    elements.statusContainer = document.createElement('span');
    status.appendChild(elements.statusContainer);

    elements.statusIcon = document.createElement('span');
    elements.statusIcon.classList.add('material-symbols-rounded');
    elements.statusContainer.appendChild(elements.statusIcon);

    elements.statusText = document.createElement('span');
    elements.statusContainer.appendChild(elements.statusText);
  }

  function setStatus(level, message) {
    if (elements.statusContainer === null) createStatusElements();

    elements.statusContainer.classList.remove('warning', 'error');
    elements.statusContainer.classList.add(level);
    elements.statusIcon.textContent = level;
    elements.statusText.textContent = message;
  }

  function lengthCheck(string, name, min, max) {
    if (string.length < min) {
      setStatus('warning', `${name} must be at least ${min} characters`);
      return false;
    }

    if (string.length > max) {
      setStatus('warning', `${name} must be at most ${max} characters long`);
      return false;
    }

    return true;
  }

  elements.register.addEventListener('click', (event) => {
    event.preventDefault();

    if (!lengthCheck(elements.username.value, 'Username', 4, 20)) return;
    if (!lengthCheck(elements.password.value, 'Password', 8, 100)) return;

    if (elements.password.value !== elements.passwordRepeat.value) {
      setStatus('warning', 'Passwords do not match');
      return;
    }

    form.submit();
  });
}
