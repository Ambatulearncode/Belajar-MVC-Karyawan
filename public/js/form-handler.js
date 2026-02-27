/**
 * Form Handler for Karyawan Management System
 * Handles form validation, submission feedback, and interactive elements
 */

class FormHandler {
  constructor() {
    this.forms = document.querySelectorAll("form[data-validate]");
    this.init();
  }

  init() {
    this.setupFormValidation();
    this.setupFormFeedback();
    this.setupDeleteConfirmations();
    this.setupLoadingStates();
  }

  setupFormValidation() {
    this.forms.forEach((form) => {
      form.addEventListener("submit", (e) => {
        if (!this.validateForm(form)) {
          e.preventDefault();
          this.showFormErrors(form);
        }
      });

      // Real-time validation
      const inputs = form.querySelectorAll("input, select, textarea");
      inputs.forEach((input) => {
        input.addEventListener("blur", () => this.validateField(input));
        input.addEventListener("input", () => this.clearFieldError(input));
      });
    });
  }

  validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll("[required]");

    requiredFields.forEach((field) => {
      if (!this.validateField(field)) {
        isValid = false;
      }
    });

    // Special validation for password confirmation
    const password = form.querySelector('input[name="password"]');
    const passwordConfirm = form.querySelector(
      'input[name="password_confirmation"]',
    );

    if (
      password &&
      passwordConfirm &&
      password.value &&
      passwordConfirm.value
    ) {
      if (password.value !== passwordConfirm.value) {
        this.showFieldError(passwordConfirm, "Password tidak cocok");
        isValid = false;
      }
    }

    return isValid;
  }

  validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    let errorMessage = "";

    // Required validation
    if (field.hasAttribute("required") && !value) {
      errorMessage =
        field.getAttribute("data-required-message") || "Field ini wajib diisi";
      isValid = false;
    }

    // Min length validation
    if (
      field.hasAttribute("minlength") &&
      value.length < parseInt(field.getAttribute("minlength"))
    ) {
      errorMessage =
        field.getAttribute("data-minlength-message") ||
        `Minimal ${field.getAttribute("minlength")} karakter`;
      isValid = false;
    }

    // Email validation
    if (field.type === "email" && value && !this.isValidEmail(value)) {
      errorMessage =
        field.getAttribute("data-email-message") || "Format email tidak valid";
      isValid = false;
    }

    // Number validation
    if (field.type === "number" && value) {
      const min = parseFloat(field.getAttribute("min"));
      const max = parseFloat(field.getAttribute("max"));

      if (!isNaN(min) && parseFloat(value) < min) {
        errorMessage =
          field.getAttribute("data-min-message") || `Nilai minimal ${min}`;
        isValid = false;
      }

      if (!isNaN(max) && parseFloat(value) > max) {
        errorMessage =
          field.getAttribute("data-max-message") || `Nilai maksimal ${max}`;
        isValid = false;
      }
    }

    if (!isValid && errorMessage) {
      this.showFieldError(field, errorMessage);
    } else {
      this.clearFieldError(field);
    }

    return isValid;
  }

  showFieldError(field, message) {
    this.clearFieldError(field);

    field.classList.add(
      "border-red-300",
      "focus:border-red-500",
      "focus:ring-red-200",
    );

    const errorDiv = document.createElement("div");
    errorDiv.className = "mt-1 text-sm text-red-600 flex items-center";
    errorDiv.innerHTML = `<i class="bi bi-exclamation-circle mr-1"></i> ${message}`;
    errorDiv.id = `${field.id}-error`;

    field.parentNode.appendChild(errorDiv);
  }

  clearFieldError(field) {
    field.classList.remove(
      "border-red-300",
      "focus:border-red-500",
      "focus:ring-red-200",
    );

    const errorDiv = field.parentNode.querySelector(`#${field.id}-error`);
    if (errorDiv) {
      errorDiv.remove();
    }
  }

  showFormErrors(form) {
    const firstError = form.querySelector(".border-red-300");
    if (firstError) {
      firstError.focus();

      // Show notification
      if (window.Notifications) {
        window.Notifications.error("Harap perbaiki kesalahan pada form");
      }
    }
  }

  setupFormFeedback() {
    // Handle form submission feedback
    document.addEventListener("formSubmission", (e) => {
      const { success, message } = e.detail;

      if (success && window.Notifications) {
        window.Notifications.success(message || "Data berhasil disimpan!");
      } else if (!success && window.Notifications) {
        window.Notifications.error(message || "Terjadi kesalahan!");
      }
    });
  }

  setupDeleteConfirmations() {
    // Handle form submission with data-confirm-delete
    document.addEventListener("submit", function (e) {
      const form = e.target.closest("form[data-confirm-delete]");
      if (!form) return;

      e.preventDefault(); // Stop submission

      const itemName = form.getAttribute("data-item-name") || "data ini";

      // PAKE INI: window.FormHandler (huruf besar F)
      if (window.FormHandler) {
        window.FormHandler.showDeleteConfirmation(itemName, function () {
          // Unbind event listener temporarily to avoid loop
          form.removeEventListener("submit", arguments.callee);
          form.submit();
        });
      } else {
        // Fallback ke confirm biasa
        if (confirm(`Yakin ingin menghapus ${itemName}?`)) {
          form.submit();
        }
      }
    });
  }

  showDeleteConfirmation(itemName, callback, type = "delete") {
    console.log("showDeleteConfirmation dipanggil dengan:", { itemName, type });
    const modal = document.createElement("div");
    modal.className =
      "fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4";

    // Tentukan konfigurasi berdasarkan type
    const isRestore = type === "restore";

    // Icon dan warna berbeda
    const icon = isRestore ? "bi-arrow-return-left" : "bi-exclamation-triangle";
    const bgColor = isRestore ? "bg-green-100" : "bg-red-100";
    const iconColor = isRestore ? "text-green-600" : "text-red-600";
    const title = isRestore ? "Konfirmasi Restore" : "Konfirmasi Hapus";
    const message = isRestore
      ? `Yakin ingin mengembalikan data <span class="font-semibold">"${itemName}"</span>?`
      : `Yakin ingin menghapus <span class="font-semibold">"${itemName}"</span>? Tindakan ini tidak dapat dibatalkan.`;
    const confirmText = isRestore ? "Restore" : "Hapus";
    const confirmBg = isRestore
      ? "bg-green-600 hover:bg-green-700"
      : "bg-red-600 hover:bg-red-700";
    const cancelBg = "bg-gray-100 hover:bg-gray-200";

    modal.innerHTML = `
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 mx-auto ${bgColor} rounded-full mb-4">
                    <i class="bi ${icon} ${iconColor} text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 text-center mb-2">${title}</h3>
                <p class="text-sm text-gray-500 text-center mb-6">
                    ${message}
                </p>
                <div class="flex gap-3">
                    <button type="button" class="btn-cancel flex-1 ${cancelBg} text-gray-800 py-2 px-4 rounded-lg transition">
                        Batal
                    </button>
                    <button type="button" class="btn-confirm flex-1 ${confirmBg} text-white py-2 px-4 rounded-lg transition">
                        ${confirmText}
                    </button>
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(modal);

    modal.querySelector(".btn-cancel").addEventListener("click", () => {
      document.body.removeChild(modal);
    });

    modal.querySelector(".btn-confirm").addEventListener("click", () => {
      document.body.removeChild(modal);
      if (callback) callback();
    });

    // Close on background click
    modal.addEventListener("click", (e) => {
      if (e.target === modal) {
        document.body.removeChild(modal);
      }
    });
  }

  showRestoreConfirmation(itemName, callback) {
    const modal = document.createElement("div");
    modal.className =
      "fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4";

    modal.innerHTML = `
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full mb-4">
                    <i class="bi bi-arrow-return-left text-green-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 text-center mb-2">Konfirmasi Restore</h3>
                <p class="text-sm text-gray-500 text-center mb-6">
                    Yakin ingin mengembalikan data <span class="font-semibold">"${itemName}"</span>?
                </p>
                <div class="flex gap-3">
                    <button type="button" class="btn-cancel flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 py-2 px-4 rounded-lg transition">
                        Batal
                    </button>
                    <button type="button" class="btn-confirm flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg transition">
                        Restore
                    </button>
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(modal);

    modal.querySelector(".btn-cancel").addEventListener("click", () => {
      document.body.removeChild(modal);
    });

    modal.querySelector(".btn-confirm").addEventListener("click", () => {
      document.body.removeChild(modal);
      if (callback) callback();
    });

    modal.addEventListener("click", (e) => {
      if (e.target === modal) {
        document.body.removeChild(modal);
      }
    });
  }

  test() {
    alert("FormHandler is working!");
    console.log("FormHandler test method called");
  }
  setupLoadingStates() {
    // Add loading state to submit buttons
    document.addEventListener("submit", (e) => {
      const form = e.target;
      const submitButton = form.querySelector('button[type="submit"]');

      if (submitButton) {
        const originalText = submitButton.innerHTML;
        submitButton.innerHTML = `
                    <i class="bi bi-arrow-repeat animate-spin mr-2"></i>
                    Memproses...
                `;
        submitButton.disabled = true;

        // Restore button after form submission (if not redirected)
        setTimeout(() => {
          submitButton.innerHTML = originalText;
          submitButton.disabled = false;
        }, 3000);
      }
    });
  }

  isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
  }
}

// Initialize form handler
const formHandler = new FormHandler();

// Make it available globally
window.FormHandler = formHandler;
window.formHandler = formHandler;
