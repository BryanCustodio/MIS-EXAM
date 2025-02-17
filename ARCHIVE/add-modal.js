// Modal handling
const addModal = document.getElementById('addModal');
const openAddModalBtn = document.getElementById('openAddModal');
const closeBtns = document.querySelectorAll('.close');

openAddModalBtn.addEventListener('click', function () {
    addModal.style.display = 'block';
});

closeBtns.forEach(btn => {
    btn.addEventListener('click', function () {
        addModal.style.display = 'none';
    });
});

// Close when clicking outside the modal
window.addEventListener('click', function (event) {
    if (event.target === addModal) {
        addModal.style.display = 'none';
    }
});

function closeAddModal() {
    addModal.style.display = 'none';
}
