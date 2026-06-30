function bukaModal(idModal) {
    document.getElementById(idModal).classList.add('active');
}

function tutupModal(idModal) {
    document.getElementById(idModal).classList.remove('active');
}

document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
    overlay.addEventListener('click', function(e) {
        if (e.target === overlay) overlay.classList.remove('active');
    });
});
