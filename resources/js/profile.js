document.addEventListener('DOMContentLoaded', function() {
    console.log('ok');
    const modalOpenButtons = document.querySelectorAll('[data-modal-toggle]');
    const modalCloseButtons = document.querySelectorAll('[data-modal-close]');
    const modalOverlay = document.getElementById('modal-overlay');

    modalOpenButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const targetModalId = this.dataset.modalTarget;
            const targetModal = document.getElementById(targetModalId);
            targetModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        });
    });

    modalCloseButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const targetModalId = this.dataset.modalClose;
            const targetModal = document.getElementById(targetModalId);
            targetModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
    });

    modalOverlay.addEventListener('click', function() {
        const openModals = document.querySelectorAll('.modal:not(.hidden)');
        openModals.forEach(function(modal) {
            modal.classList.add('hidden');
        });
        document.body.classList.remove('overflow-hidden');
    });
});