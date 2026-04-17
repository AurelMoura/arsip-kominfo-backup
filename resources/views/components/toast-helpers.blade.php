<!-- Toast Helper Functions -->
<script>
// Toast confirm function - shows confirmation dialog and then shows toast on success
function confirmAndToast(message, successMsg = null, actionFn = null, errorCallback = null) {
    return new Promise((resolve) => {
        if (confirm(message)) {
            if (typeof actionFn === 'function') {
                try {
                    const result = actionFn();
                    if (result instanceof Promise) {
                        result.then(() => {
                            if (successMsg) showToast(successMsg, 'success');
                            resolve(true);
                        }).catch((err) => {
                            if (errorCallback) errorCallback(err);
                            resolve(false);
                        });
                    } else {
                        if (successMsg) showToast(successMsg, 'success');
                        resolve(true);
                    }
                } catch(err) {
                    if (errorCallback) errorCallback(err);
                    resolve(false);
                }
            } else {
                if (successMsg) showToast(successMsg, 'success');
                resolve(true);
            }
        } else {
            resolve(false);
        }
    });
}

// Modal Konfirmasi Modern
function showConfirmModal(title, message, onConfirm, onCancel) {
    return new Promise((resolve) => {
        const modalId = 'confirmModal_' + Date.now();
        const modalHTML = `
            <div class="modal fade" id="${modalId}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg rounded-4">
                        <div class="modal-header border-0 pt-4 px-4">
                            <h5 class="fw-bold text-dark mb-0">${title}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body px-4 py-3">
                            <p class="text-muted mb-0">${message}</p>
                        </div>
                        <div class="modal-footer border-0 pb-4 px-4">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal" id="btn-cancel-${modalId}">Batal</button>
                            <button type="button" class="btn btn-danger rounded-pill px-4" id="btn-confirm-${modalId}">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        const modal = new bootstrap.Modal(document.getElementById(modalId));
        
        document.getElementById(`btn-confirm-${modalId}`).addEventListener('click', () => {
            modal.hide();
            if (typeof onConfirm === 'function') onConfirm();
            resolve(true);
        });
        
        document.getElementById(`btn-cancel-${modalId}`).addEventListener('click', () => {
            if (typeof onCancel === 'function') onCancel();
            resolve(false);
        });
        
        modal.show();
        
        // Cleanup modal after hide
        document.getElementById(modalId).addEventListener('hidden.bs.modal', () => {
            document.getElementById(modalId).remove();
        });
    });
}

// Form submit with confirmation
function confirmFormSubmit(formId, message, successMsg) {
    const form = document.getElementById(formId);
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!confirm(message)) {
                e.preventDefault();
                return false;
            }
        });
    }
}

// Direct toast from form onsubmit
window.confirmDelete = function(message) {
    return confirm(message);
};

// Map old alert() calls to toast
window.alertToast = function(message, type = 'info') {
    showToast(message, type);
};

// Modern delete confirmation with toast
window.modernConfirmDelete = function(message, actionFn) {
    if (confirm(message)) {
        try {
            showToast('Menghapus data...', 'info');
            const result = actionFn();
            if (result instanceof Promise) {
                return result.then(() => {
                    showToast('Data berhasil dihapus!', 'success');
                    return true;
                }).catch((err) => {
                    showToast('Gagal menghapus data: ' + (err.message || 'Silakan coba lagi'), 'error');
                    return false;
                });
            } else {
                showToast('Data berhasil dihapus!', 'success');
                return true;
            }
        } catch(err) {
            showToast('Gagal menghapus data: ' + err.message, 'error');
            return false;
        }
    }
    return false;
};
</script>
