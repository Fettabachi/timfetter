(function () {
  var form = document.getElementById('targeted-resume-form');
  var printButton = document.getElementById('targeted-resume-print');
  var newLetterButton = document.getElementById('targeted-resume-new');
  var status = document.getElementById('targeted-resume-status');

  if (!form || !printButton || !newLetterButton) {
    return;
  }

  var genericLetter = {
    attention: 'Creative Director / Digital Production Team',
    subject: 'Available Contract Front-End & WordPress Developer Support',
    greeting: 'Hello,',
    opening: "I'm based in the Atlanta area and reaching out to introduce myself in case your team needs additional WordPress or front-end development support for client websites.",
    experience: "For more than 15 years, I've helped agencies turn approved designs and project requirements into polished, responsive websites. I build custom themes and reusable content sections, work with Advanced Custom Fields and Elementor, and refine interfaces for accessibility and long-term maintenance.",
    fit: 'Your work supporting clients through website design and ongoing digital services is a strong fit for my experience. I can help your team build and improve client pages while respecting existing designs, content needs, and production workflows.',
    close: 'I would welcome a conversation if freelance or overflow development support would be useful. My resume is on the next page, and selected work is available at timfetter.com. Thank you for your time and consideration.'
  };

  function updateLetter() {
    form.querySelectorAll('[name]').forEach(function (field) {
      var output = document.querySelector('[data-targeted-output="' + field.name + '"]');
      if (output) {
        output.textContent = field.value.trim();
      }
    });
  }

  form.addEventListener('input', function () {
    updateLetter();
    status.textContent = '';
  });
  form.addEventListener('submit', function (event) {
    event.preventDefault();
  });
  newLetterButton.addEventListener('click', function () {
    Object.keys(genericLetter).forEach(function (name) {
      var field = form.elements.namedItem(name);
      if (field) {
        field.value = genericLetter[name];
      }
    });
    updateLetter();
    status.textContent = 'Generic agency letter loaded. Add the company-specific details before printing.';
    form.elements.namedItem('attention').focus();
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
