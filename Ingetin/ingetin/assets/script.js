document.addEventListener('DOMContentLoaded', function() {
    // Toast notification
    const toastEl = document.querySelector('.toast');
    if (toastEl) {
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    }
    
    // Tooltip initialization
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Datepicker for deadline fields
    const deadlineFields = document.querySelectorAll('input[type="date"]');
    deadlineFields.forEach(field => {
        if (!field.value) {
            const today = new Date();
            const dd = String(today.getDate()).padStart(2, '0');
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const yyyy = today.getFullYear();
            field.value = `${yyyy}-${mm}-${dd}`;
        }
    });
});