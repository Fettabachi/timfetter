(function () {
  var form = document.getElementById('targeted-resume-form');
  var printButton = document.getElementById('targeted-resume-print');
  var status = document.getElementById('targeted-resume-status');

  if (!form || !printButton) {
    return;
  }

  function updateLetter() {
    form.querySelectorAll('[name]').forEach(function (field) {
      var output = document.querySelector('[data-targeted-output="' + field.name + '"]');
      if (output) {
        output.textContent = field.value.trim();
      }
    });
    status.textContent = '';
  }

  form.addEventListener('input', updateLetter);
  form.addEventListener('reset', function () {
    window.setTimeout(updateLetter, 0);
  });
  form.addEventListener('submit', function (event) {
    event.preventDefault();
  });
  printButton.addEventListener('click', function () {
    if (!form.reportValidity()) {
      return;
    }
    updateLetter();
    status.textContent = 'In the print dialog, choose Save as PDF and confirm that the preview has two pages.';
    window.print();
  });

  updateLetter();
})();
