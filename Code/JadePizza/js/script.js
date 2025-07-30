/*-------------------------------------------------------------
/* File: main.js
/* Description: Handles UI logic for popups, forms,
/*              deal validation, address toggling, 
/*              and password visibility.
/*-------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------*/

/*----------------------------------------
/* Popup Functions for Email Contact
----------------------------------------*/
function openPopup() {
  document.getElementById("emailPopup").style.display = "block";
}

function closePopup() {
  document.getElementById("emailPopup").style.display = "none";
}

window.onclick = function (event) {
  const popup = document.getElementById("emailPopup");
  if (event.target === popup) {
    closePopup();
  }
};


/*----------------------------------------
/* Toggle Section Details
----------------------------------------*/
function toggleDetails(id) {
  const section = document.getElementById('details-' + id);
  const isHidden = window.getComputedStyle(section).display === 'none';
  section.style.display = isHidden ? 'block' : 'none';
}


/*----------------------------------------
/* Toggle Address Fields for Delivery
 ----------------------------------------*/
function toggleAddressFields() {
  const deliveryOption = document.getElementById('delivery');
  const pickupOption = document.getElementById('pickup');
  const addressSection = document.getElementById('address-fields');
  const requiredFields = ['address', 'postal_code', 'province', 'country'];

  if (deliveryOption && pickupOption && addressSection) {
    const isDelivery = deliveryOption.checked;
    addressSection.style.display = isDelivery ? 'block' : 'none';

    requiredFields.forEach(id => {
      const field = document.getElementById(id);
      if (field) field.required = isDelivery;
    });
  }
}


/*----------------------------------------
/* Add Additional Deal Requirement Block
----------------------------------------*/
function addRequirement() {
  const container = document.getElementById('requirements-container');
  const block = container.querySelector('.requirement-block');
  const clone = block.cloneNode(true);

  clone.querySelectorAll('input').forEach(input => input.value = '');
  clone.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

  container.appendChild(clone);
}


/*----------------------------------------
/* On Load Events and Form Logic
----------------------------------------*/
document.addEventListener('DOMContentLoaded', function () {
  toggleAddressFields();

  const deliveryRadio = document.getElementById('delivery');
  const pickupRadio = document.getElementById('pickup');
  if (deliveryRadio && pickupRadio) {
    deliveryRadio.addEventListener('change', toggleAddressFields);
    pickupRadio.addEventListener('change', toggleAddressFields);
  }

  /*----------------------------------------
  /* Handle Menu Item Size Rules (based on category)
  ----------------------------------------*/
  const menuCategorySelect = document.getElementById('category');
  if (menuCategorySelect) {
    menuCategorySelect.addEventListener('change', function () {
      const category = this.value;

      const sizeMap = {
        Regular: { checkbox: 'Regular', input: 'Regular' },
        Can: { checkbox: 'Can', input: 'Can' },
        Small: { checkbox: 'Small', input: 'Small' },
        Medium: { checkbox: 'Medium', input: 'Medium' },
        Large: { checkbox: 'Large', input: 'Large' },
      };

      for (const size in sizeMap) {
        const checkbox = document.querySelector(`input[name="sizes[]"][value="${size}"]`);
        const input = document.querySelector(`input[name="prices[${size}]"]`);

        let shouldEnable = true;

        if (category === 'Pizza') {
          shouldEnable = ['Small', 'Medium', 'Large'].includes(size);
        } else if (category === 'Side') {
          shouldEnable = size === 'Regular';
        } else if (category === 'Drink') {
          shouldEnable = size === 'Can';
        }

        if (checkbox && input) {
          checkbox.disabled = !shouldEnable;
          input.disabled = !shouldEnable;

          if (!shouldEnable) {
            checkbox.checked = false;
            input.value = '';
          }
        }
      }
    });

    menuCategorySelect.dispatchEvent(new Event('change'));
  }


  /*----------------------------------------
  /* Deal Requirement Size Restrictions
  ----------------------------------------*/
  function applyDealSizeRules() {
    document.querySelectorAll('.requirement-block').forEach(block => {
      const categorySelect = block.querySelector('select[name="required_category[]"]');
      const sizeSelect = block.querySelector('select[name="required_size[]"]');

      categorySelect.addEventListener('change', () => {
        const value = categorySelect.value;

        Array.from(sizeSelect.options).forEach(option => {
          const size = option.value;
          let shouldEnable = true;

          if (value === 'Pizza') {
            shouldEnable = ['Small', 'Medium', 'Large'].includes(size) || size === '';
          } else if (value === 'Side') {
            shouldEnable = size === 'Regular' || size === '';
          } else if (value === 'Drink') {
            shouldEnable = size === 'Can' || size === '';
          }

          option.disabled = !shouldEnable;

          /*----------------------------------------
          /* Reset invalid selection
          ----------------------------------------*/
          if (!shouldEnable && sizeSelect.value === size) {
            sizeSelect.value = '';
          }
        });
      });

      /*----------------------------------------
      /* Trigger on page load
      ----------------------------------------*/
      categorySelect.dispatchEvent(new Event('change'));
    });
  }

  applyDealSizeRules();

  /*----------------------------------------
  /* Rebind deal rules to new blocks
  ----------------------------------------*/
  window.addRequirement = function () {
    const container = document.getElementById('requirements-container');
    const block = container.querySelector('.requirement-block');
    const clone = block.cloneNode(true);

    clone.querySelectorAll('input').forEach(input => input.value = '');
    clone.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

    container.appendChild(clone);
    applyDealSizeRules();
  };
});


/*----------------------------------------
/* Toggle Password Visibility
----------------------------------------*/
function togglePassword() {
  const passwordInput = document.getElementById("password");
  passwordInput.type = passwordInput.type === "password" ? "text" : "password";
}
