<!-- Toast Container -->
<div class="position-fixed" id="toastContainer" style="top: 20px; right: 20px; z-index: 9999; min-width: 350px;">
</div>

<script>
// Toast Notification System
function showToast(message, type = 'success', duration = 4000) {
    const toastContainer = document.getElementById('toastContainer');
    
    const toastEl = document.createElement('div');
    toastEl.className = `toast show mb-3`;
    toastEl.setAttribute('role', 'alert');
    toastEl.setAttribute('aria-live', 'assertive');
    toastEl.setAttribute('aria-atomic', 'true');
    
    let bgColor = '';
    let icon = '';
    let textColor = 'text-dark';
    
    switch(type.toLowerCase()) {
        case 'success':
            bgColor = 'bg-success';
            icon = '<i class="bi bi-check-circle-fill me-2 text-white" style="font-size: 18px;"></i>';
            textColor = 'text-white';
            break;
        case 'error':
        case 'danger':
            bgColor = 'bg-danger';
            icon = '<i class="bi bi-exclamation-circle-fill me-2 text-white" style="font-size: 18px;"></i>';
            textColor = 'text-white';
            break;
        case 'warning':
            bgColor = 'bg-warning';
            icon = '<i class="bi bi-exclamation-triangle-fill me-2" style="font-size: 18px; color: #000;"></i>';
            textColor = 'text-dark';
            break;
        case 'info':
            bgColor = 'bg-info';
            icon = '<i class="bi bi-info-circle-fill me-2 text-white" style="font-size: 18px;"></i>';
            textColor = 'text-white';
            break;
    }
    
    toastEl.innerHTML = `
        <div class="${bgColor} ${textColor} border-0 shadow-lg rounded-3" style="padding: 14px 18px;">
            <div class="d-flex align-items-center">
                ${icon}
                <span class="fw-medium">${message}</span>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="toast" aria-label="Close" style="opacity: 0.8;"></button>
            </div>
        </div>
    `;
    
    toastContainer.appendChild(toastEl);
    
    // Auto remove after duration
    if (duration > 0) {
        setTimeout(() => {
            toastEl.classList.remove('show');
            setTimeout(() => toastEl.remove(), 300);
        }, duration);
    }
}

// Expose globally
window.showToast = showToast;
</script>

<style>
#toastContainer {
    display: flex;
    flex-direction: column-reverse;
}

.toast {
    border-radius: 12px;
    animation: slideIn 0.3s ease-out;
    backdrop-filter: blur(10px);
}

@keyframes slideIn {
    from {
        transform: translateX(400px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.toast.show {
    opacity: 1;
}

.btn-close-white {
    opacity: 0.8 !important;
}

.btn-close-white:hover {
    opacity: 1 !important;
}
</style>
