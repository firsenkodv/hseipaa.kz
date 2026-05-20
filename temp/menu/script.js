document.querySelectorAll('.has-dropdown > button').forEach(button => {
  button.addEventListener('click', event => {
    event.stopPropagation();

    const item = button.parentElement;

    document.querySelectorAll('.has-dropdown').forEach(dropdown => {
      if (dropdown !== item) {
        dropdown.classList.remove('is-open');
      }
    });

    item.classList.toggle('is-open');
  });
});

document.addEventListener('click', () => {
  document.querySelectorAll('.has-dropdown').forEach(dropdown => {
    dropdown.classList.remove('is-open');
  });
});
