document.addEventListener("DOMContentLoaded", function () {
  // Add toast container to HTML body
  const toastContainer = document.createElement("div");
  toastContainer.id = "toast-container";
  document.body.appendChild(toastContainer);

  // Toast functions
  function showToast(message, type = "info", duration = 3000) {
    const toast = document.createElement("div");
    toast.className = `toast ${type}`;

    const content = document.createElement("div");
    content.textContent = message;

    if (type === "loading") {
      const loadingBar = document.createElement("div");
      loadingBar.className = "loading-bar";
      toast.appendChild(loadingBar);
    }

    toast.appendChild(content);
    toastContainer.appendChild(toast);

    setTimeout(() => {
      toast.remove();
    }, duration);
  }

  function hideToast() {
    while (toastContainer.firstChild) {
      toastContainer.removeChild(toastContainer.firstChild);
    }
  }

  const form = document.getElementById("loginForm");
  form.addEventListener("submit", function (event) {
    event.preventDefault();
    hideToast(); // Clear existing toasts
    showToast("Processing login...", "loading");

    const formData = new FormData(form);

    fetch("php/login.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        hideToast();
        if (data.success) {
          showToast("Login successful! Redirecting...", "success", 2000);
          setTimeout(() => {
            window.location.href = "landing.html";
          }, 2000);
        } else {
          showToast(`Login failed: ${data.error || "Unknown error"}`, "error", 5000);
        }
      })
      .catch((error) => {
        hideToast();
        showToast("Network error. Please try again.", "error", 5000);
        console.error("Error:", error);
      });
  });
});