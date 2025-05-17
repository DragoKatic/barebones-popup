// Part of Barebones PopUp plugin
// License: GPLv2 or later

document.addEventListener('DOMContentLoaded', function () {
  const wrapper = document.getElementById('ac-wrapper');
  const closeBtn = document.querySelector('.close');

  if (wrapper) {
        wrapper.style.display = 'flex'; // Show popup

        if (closeBtn) {
          closeBtn.addEventListener('click', function () {
            wrapper.style.display = 'none';
        });
      }

      document.addEventListener('keydown', function (e) {
          if (e.key === 'Escape') {
            wrapper.style.display = 'none';
        }
    });

      wrapper.addEventListener('click', function (e) {
          if (e.target === wrapper) {
            wrapper.style.display = 'none';
        }
    });
  }
});