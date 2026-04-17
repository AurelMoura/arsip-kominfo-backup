<script>
function confirmDeleteSweetAlert(form, title = 'Yakin ingin menghapus?', text = 'Data yang dihapus tidak bisa dikembalikan!') {
    // If form is a string selector, find the element
    if (typeof form === 'string') {
        form = document.querySelector(form);
    }

    // If form is passed as 'this' from event handler, it's already the form element
    if (!form || !(form instanceof HTMLFormElement)) {
        console.error('Form element not found or invalid');
        return false;
    }

    Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d32f2f',
        cancelButtonColor: '#757575',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        allowOutsideClick: false,
        allowEscapeKey: true,
        didOpen: (modal) => {
            modal.style.zIndex = 9999;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            showToast('Menghapus data...', 'info');
            form.submit();
        }
    });

    return false;
}

// Deprecated - kept for backward compatibility
function handleDeleteClick(event, formSelector) {
    event.preventDefault();
    event.stopPropagation();
    confirmDeleteSweetAlert(formSelector);
    return false;
}
</script>
</script>
