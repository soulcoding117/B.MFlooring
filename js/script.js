document.addEventListener("DOMContentLoaded", function() {
  // Toast container setup
  const toastContainer = document.createElement('div');
  toastContainer.id = 'toast-container';
  document.body.appendChild(toastContainer);

  // Toast functions
  function showToast(message, type = 'info', duration = 3000) {
    const toast = document.createElement('div'); // Fixed syntax issue
    toast.className = `toast ${type}`;

    const content = document.createElement('div');
    content.textContent = message;

    if (type === 'loading') {
      const loadingBar = document.createElement('div');
      loadingBar.className = 'loading-bar';
      toast.appendChild(loadingBar);
    }

    toast.appendChild(content);
    toastContainer.appendChild(toast);

    setTimeout(() => {
      if (toast.parentNode) {
        toast.parentNode.removeChild(toast);
      }
    }, duration);
  }

  function hideToast() {
    toastContainer.innerHTML = '';
  }

  // Form handling
  const form = document.getElementById("loginForm");
  if (form) {
    form.addEventListener("submit", function(event) {
      event.preventDefault();
      hideToast();
      showToast('Processing login...', 'loading');

      const formData = new FormData(form);
      
      fetch("php/login.php", {
        method: "POST",
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        hideToast();
        if (data.success) {
          showToast('Login successful! Redirecting...', 'success', 2000);
          setTimeout(() => window.location.href = 'landing.html', 2000);
        } else {
          showToast(`Login failed: ${data.error || 'Unknown error'}`, 'error', 5000);
        }
      })
      .catch(error => {
        hideToast();
        showToast('Network error. Please try again.', 'error', 5000);
        console.error("Error:", error);
      });
    });
  } else {
    console.error("Form with ID 'loginForm' not found.");
  }
});
