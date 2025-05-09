document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("registerForm") || document.getElementById("adminUserForm");

    const fields = [
        { id: 'name', pattern: /^[A-Z][a-záéíóúñü]+(?: [A-Z][a-záéíóúñü]+)*$/, message: 'Debe comenzar con mayúscula y no contener números' },
        { id: 'last_name', pattern: /^[A-Z][a-záéíóúñü]+(?: [A-Z][a-záéíóúñü]+)*$/, message: 'Cada apellido debe comenzar con mayúscula y no contener números' },
        { id: 'erasmus_destination', pattern: /^[A-Z][a-záéíóúñü]+(?: [A-Z][a-záéíóúñü]+)*$/, message: 'Debe ser una ciudad, país o pueblo. Cada palabra con mayúscula' },
        { id: 'email', pattern: /^[^@]+@[^@]+\.[a-zA-Z]{2,3}$/, message: 'Debe ser un correo válido: texto@dominio.com' },
        { id: 'password', pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/, message: 'Mínimo 8 caracteres, una mayúscula, una minúscula y un número.' }
    ];

    fields.forEach(field => {
        const input = document.getElementById(field.id);
        if (!input) return;

        let errorSpan = document.createElement('div');
        errorSpan.className = 'text-danger small mt-1';
        errorSpan.style.display = 'none';
        input.after(errorSpan);

        input.addEventListener('input', () => {
            if (!field.pattern.test(input.value)) {
                errorSpan.textContent = field.message;
                errorSpan.style.display = 'block';
                input.classList.add('is-invalid');
            } else {
                errorSpan.textContent = '';
                errorSpan.style.display = 'none';
                input.classList.remove('is-invalid');
            }
        });
    });

    // confirmacion de la contraseña
    const password = document.getElementById('password');
    const confirm = document.getElementById('password_confirmation');
    if (password && confirm) {
        const confirmError = document.createElement('div');
        confirmError.className = 'text-danger small mt-1';
        confirmError.style.display = 'none';
        confirm.after(confirmError);

        confirm.addEventListener('input', () => {
            if (confirm.value !== password.value) {
                confirmError.textContent = 'Las contraseñas no coinciden.';
                confirmError.style.display = 'block';
                confirm.classList.add('is-invalid');
            } else {
                confirmError.textContent = '';
                confirmError.style.display = 'none';
                confirm.classList.remove('is-invalid');
            }
        });
    }

    // validacion de fechas
    ['birthdate', 'arrival_date', 'end_date'].forEach(id => {
        const input = document.getElementById(id);
        if (!input) return;

        const error = document.createElement('div');
        error.className = 'text-danger small mt-1';
        error.style.display = 'none';
        input.after(error);

        input.addEventListener('input', () => {
            const year = input.value.split('-')[0];
            if (!/^\d{4}$/.test(year)) {
                error.textContent = 'El año debe tener 4 dígitos.';
                error.style.display = 'block';
                input.classList.add('is-invalid');
            } else {
                error.textContent = '';
                error.style.display = 'none';
                input.classList.remove('is-invalid');
            }
        });
    });

    //fecha de nacimiento antes de hoy
    const birthdate = document.getElementById('birthdate');
    if (birthdate) {
        birthdate.addEventListener('change', function () {
            const inputDate = new Date(this.value);
            const today = new Date();
            const error = birthdate.nextElementSibling;
            if (inputDate >= today) {
                error.textContent = 'La fecha de nacimiento debe ser anterior a hoy.';
                error.style.display = 'block';
            } else {
                error.textContent = '';
                error.style.display = 'none';
            }
        });
    }

    // end_date > arrival_date
    const arrival = document.getElementById('arrival_date');
    const end = document.getElementById('end_date');
    if (arrival && end) {
        end.addEventListener('change', function () {
            const arrivalDate = new Date(arrival.value);
            const endDate = new Date(this.value);
            const error = end.nextElementSibling;
            if (arrivalDate && endDate <= arrivalDate) {
                error.textContent = 'La fecha de finalización debe ser posterior a la de llegada.';
                error.style.display = 'block';
            } else {
                error.textContent = '';
                error.style.display = 'none';
            }
        });
    }

    // validacion final al enviar
    form.addEventListener('submit', function (e) {
        let valid = true;

        // validar campos manualmente
        fields.forEach(field => {
            const input = document.getElementById(field.id);
            if (!input || !field.pattern.test(input.value)) {
                valid = false;
                input.classList.add('is-invalid');
            }
        });

        if (password && confirm && password.value !== confirm.value) {
            valid = false;
            confirm.classList.add('is-invalid');
        }

        if (!valid) {
            e.preventDefault();
            alert('Corrige los errores antes de enviar el formulario.');
        }
    });
});
