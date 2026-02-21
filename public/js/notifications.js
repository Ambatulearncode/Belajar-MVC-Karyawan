/**
 * Notification System for Karyawan Management System
 * Handles success, error, info, and warning notifications
 * Position: Bottom Right
 */

class NotificationSystem {
  constructor() {
    this.notificationContainer = null;
    this.init();
  }

  init() {
    // Create notification container if it doesn't exist
    if (!document.getElementById("notification-container")) {
      this.createNotificationContainer();
    }

    // Auto-hide existing alerts after 5 seconds
    this.autoHideAlerts();

    // Listen for new notifications
    this.setupEventListeners();

    // Show session notifications
    this.showSessionNotifications();
  }

  createNotificationContainer() {
    this.notificationContainer = document.createElement("div");
    this.notificationContainer.id = "notification-container";
    this.notificationContainer.className =
      "fixed bottom-4 right-4 z-50 space-y-3 w-full max-w-sm";
    document.body.appendChild(this.notificationContainer);
  }

  setupEventListeners() {
    // Listen for custom notification events
    document.addEventListener("showNotification", (e) => {
      this.show(e.detail.type, e.detail.message, e.detail.duration);
    });

    // Close button event delegation
    document.addEventListener("click", (e) => {
      if (e.target.closest(".notification-close")) {
        this.closeNotification(e.target.closest(".notification"));
      }
    });

    // Close notification on click anywhere (optional)
    document.addEventListener("click", (e) => {
      if (
        e.target.closest(".notification") &&
        !e.target.closest(".notification-close")
      ) {
        // Optional: close notification when clicked
        // this.closeNotification(e.target.closest('.notification'));
      }
    });
  }

  show(type, message, duration = 5000) {
    const notification = this.createNotificationElement(type, message);
    this.notificationContainer.appendChild(notification);

    // Animate in from bottom
    setTimeout(() => {
      notification.classList.remove("opacity-0", "translate-y-full");
      notification.classList.add("opacity-100", "translate-y-0");
    }, 10);

    // Auto remove if duration is set
    if (duration > 0) {
      setTimeout(() => {
        this.closeNotification(notification);
      }, duration);
    }

    return notification;
  }

  createNotificationElement(type, message) {
    const icons = {
      success: "bi-check-circle",
      error: "bi-exclamation-triangle",
      warning: "bi-exclamation-circle",
      info: "bi-info-circle",
    };

    const colors = {
      success: "bg-green-50 border-green-200 text-green-800",
      error: "bg-red-50 border-red-200 text-red-800",
      warning: "bg-yellow-50 border-yellow-200 text-yellow-800",
      info: "bg-blue-50 border-blue-200 text-blue-800",
    };

    const iconColors = {
      success: "text-green-500",
      error: "text-red-500",
      warning: "text-yellow-500",
      info: "text-blue-500",
    };

    const borderColors = {
      success: "border-l-4 border-green-500",
      error: "border-l-4 border-red-500",
      warning: "border-l-4 border-yellow-500",
      info: "border-l-4 border-blue-500",
    };

    const notification = document.createElement("div");
    notification.className = `notification transform transition-all duration-300 ease-out opacity-0 translate-y-full ${colors[type]} ${borderColors[type]} rounded-r-lg shadow-lg p-4`;
    notification.setAttribute("role", "alert");

    notification.innerHTML = `
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="bi ${icons[type]} ${iconColors[type]} text-xl"></i>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium">${message}</p>
                </div>
                <div class="ml-4 flex-shrink-0">
                    <button type="button" class="notification-close inline-flex text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                        <i class="bi bi-x-lg text-sm"></i>
                    </button>
                </div>
            </div>
        `;

    return notification;
  }

  closeNotification(notification) {
    notification.classList.remove("opacity-100", "translate-y-0");
    notification.classList.add("opacity-0", "translate-y-full");

    setTimeout(() => {
      if (notification.parentNode) {
        notification.parentNode.removeChild(notification);
      }
    }, 300);
  }

  success(message, duration = 5000) {
    return this.show("success", message, duration);
  }

  error(message, duration = 5000) {
    return this.show("error", message, duration);
  }

  warning(message, duration = 5000) {
    return this.show("warning", message, duration);
  }

  info(message, duration = 5000) {
    return this.show("info", message, duration);
  }

  autoHideAlerts() {
    // Auto-hide existing Bootstrap-style alerts
    setTimeout(() => {
      const alerts = document.querySelectorAll(".joko-alert");
      alerts.forEach((alert) => {
        // Add slide out animation
        alert.style.transform = "translateY(20px)";
        alert.style.opacity = "0";
        alert.style.transition = "all 0.3s ease-out";

        setTimeout(() => {
          if (alert.parentNode) {
            alert.parentNode.removeChild(alert);
          }
        }, 300);
      });
    }, 5000);
  }

  // Show notification from session messages
  showSessionNotifications() {
    // Check for session messages in data attributes
    const successMsg = document.body.getAttribute("data-success");
    const errorMsg = document.body.getAttribute("data-error");
    const infoMsg = document.body.getAttribute("data-info");
    const warningMsg = document.body.getAttribute("data-warning");

    if (successMsg) {
      setTimeout(() => this.success(successMsg), 300);
      document.body.removeAttribute("data-success");
    }

    if (errorMsg) {
      setTimeout(() => this.error(errorMsg), 300);
      document.body.removeAttribute("data-error");
    }

    if (infoMsg) {
      setTimeout(() => this.info(infoMsg), 300);
      document.body.removeAttribute("data-info");
    }

    if (warningMsg) {
      setTimeout(() => this.warning(warningMsg), 300);
      document.body.removeAttribute("data-warning");
    }
  }

  // Clear all notifications
  clearAll() {
    const notifications =
      this.notificationContainer.querySelectorAll(".notification");
    notifications.forEach((notification) => {
      this.closeNotification(notification);
    });
  }
}

// Initialize notification system when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
  window.Notifications = new NotificationSystem();

  // Also show any existing alert messages
  const existingAlerts = document.querySelectorAll(".joko-alert");
  existingAlerts.forEach((alert) => {
    const type = alert.classList.contains("joko-alert-success")
      ? "success"
      : alert.classList.contains("joko-alert-danger")
        ? "error"
        : alert.classList.contains("joko-alert-warning")
          ? "warning"
          : "info";

    const message = alert.querySelector("p")?.textContent || alert.textContent;

    if (message && window.Notifications) {
      setTimeout(() => {
        window.Notifications[type](message.trim());
        alert.remove();
      }, 500);
    }
  });
});

// Make it available globally immediately
window.Notifications = window.Notifications || {
  success: (msg, dur) => console.log("Success:", msg, dur),
  error: (msg, dur) => console.log("Error:", msg, dur),
  warning: (msg, dur) => console.log("Warning:", msg, dur),
  info: (msg, dur) => console.log("Info:", msg, dur),
};
