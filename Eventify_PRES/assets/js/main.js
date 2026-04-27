document.addEventListener('DOMContentLoaded', () => {
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (!window.confirm('Are you sure you want to delete this event?')) {
                event.preventDefault();
            }
        });
    });

    const form = document.getElementById('eventForm');
    const description = document.getElementById('description');
    const meter = document.getElementById('descriptionMeter');

    if (form) {
        form.addEventListener('submit', (event) => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    }

    if (description && meter) {
        const updateMeter = () => {
            meter.textContent = `${description.value.trim().length} characters`;
        };
        updateMeter();
        description.addEventListener('input', updateMeter);
    }
});
