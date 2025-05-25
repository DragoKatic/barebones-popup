// Barebones PopUp plugin script
// This script controls the display logic of the popup window.

/**
 * Wait for the DOM to be fully loaded before running script.
 */
document.addEventListener('DOMContentLoaded', function () {
  const wrapper = document.getElementById('ac-wrapper');
  const closeBtn = document.querySelector('.close');

  // Check if popup wrapper exists
  if (wrapper) {
    // Display the popup
    wrapper.style.display = 'flex';

    // Close the popup on close button click
    if (closeBtn) {
      closeBtn.addEventListener('click', function () {
        wrapper.style.display = 'none';
      });
    }

    // Close the popup when Escape key is pressed
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        wrapper.style.display = 'none';
      }
    });

    // Close the popup when clicking outside the popup content
    wrapper.addEventListener('click', function (e) {
      if (e.target === wrapper) {
        wrapper.style.display = 'none';
      }
    });
  }
});
