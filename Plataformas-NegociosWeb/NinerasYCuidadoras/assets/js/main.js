document.addEventListener('DOMContentLoaded', function() {
    // Navbar scroll effect
    const navbar = document.querySelector('.navbar');
    const navLinks = document.querySelector('.nav-links');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Mobile menu toggle
    const menuToggle = document.createElement('div');
    menuToggle.classList.add('menu-toggle');
    menuToggle.innerHTML = '<span></span><span></span><span></span>';
    navbar.querySelector('.container').appendChild(menuToggle);

    menuToggle.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });

    // Animate services cards on scroll
    const observerOptions = {
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.service-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.6s ease';
        observer.observe(card);
    });

    // Form validation if exists
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!field.value) {
                    e.preventDefault();
                    field.classList.add('error');
                } else {
                    field.classList.remove('error');
                }
            });
        });
    });

    // Validación del formulario de registro
    const registroForm = document.querySelector('.registro-form');
    if (registroForm) {
        registroForm.addEventListener('submit', function(e) {
            let isValid = true;
            const nombre = document.getElementById('nombre');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            
            // Limpiar errores previos
            document.querySelectorAll('.error-message').forEach(el => el.remove());
            document.querySelectorAll('.error-input').forEach(el => el.classList.remove('error-input'));

            // Validar nombre
            if (nombre.value.trim().length < 3) {
                showError(nombre, 'El nombre debe tener al menos 3 caracteres');
                isValid = false;
            }

            // Validar email
            if (!isValidEmail(email.value)) {
                showError(email, 'Por favor ingrese un email válido');
                isValid = false;
            }

            // Validar contraseña
            if (password.value.length < 6) {
                showError(password, 'La contraseña debe tener al menos 6 caracteres');
                isValid = false;
            }

            // Validar confirmación de contraseña
            if (password.value !== confirmPassword.value) {
                showError(confirmPassword, 'Las contraseñas no coinciden');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });

        // Validar email en tiempo real
        const emailInput = document.getElementById('email');
        if (emailInput) {
            let timeoutId;
            emailInput.addEventListener('input', function() {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(() => {
                    if (isValidEmail(this.value)) {
                        this.classList.remove('error-input');
                        removeError(this);
                    }
                }, 500);
            });
        }

        // Validar contraseñas en tiempo real
        const passwordInputs = document.querySelectorAll('input[type="password"]');
        passwordInputs.forEach(input => {
            input.addEventListener('input', function() {
                const password = document.getElementById('password');
                const confirm = document.getElementById('confirm_password');
                if (password.value && confirm.value) {
                    if (password.value === confirm.value) {
                        password.classList.remove('error-input');
                        confirm.classList.remove('error-input');
                        removeError(confirm);
                    }
                }
            });
        });
    }

    // Manejo del formulario de perfil
    const perfilForm = document.querySelector('.perfil-form');
    if (perfilForm) {
        const passwordInputs = perfilForm.querySelectorAll('input[type="password"]');
        const alerts = perfilForm.querySelectorAll('.alert');
        
        // Remover alertas después de 5 segundos
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }, 5000);
        });

        // Validación de contraseñas en tiempo real
        if (passwordInputs.length) {
            const newPassword = document.getElementById('new_password');
            const confirmPassword = document.getElementById('confirm_password');
            
            function validatePasswords() {
                if (newPassword.value || confirmPassword.value) {
                    if (newPassword.value.length < 6) {
                        showError(newPassword, 'La contraseña debe tener al menos 6 caracteres');
                    } else if (newPassword.value !== confirmPassword.value) {
                        showError(confirmPassword, 'Las contraseñas no coinciden');
                    } else {
                        removeError(newPassword);
                        removeError(confirmPassword);
                    }
                }
            }

            passwordInputs.forEach(input => {
                input.addEventListener('input', validatePasswords);
            });
        }

        // Validar formulario antes de enviar
        perfilForm.addEventListener('submit', function(e) {
            let isValid = true;
            const nombre = document.getElementById('nombre');
            const email = document.getElementById('email');

            // Limpiar errores previos
            document.querySelectorAll('.error-message').forEach(el => el.remove());

            // Validar nombre
            if (nombre.value.trim().length < 3) {
                showError(nombre, 'El nombre debe tener al menos 3 caracteres');
                isValid = false;
            }

            // Validar email
            if (!isValidEmail(email.value)) {
                showError(email, 'Por favor ingrese un email válido');
                isValid = false;
            }

            // Validar contraseñas si se están cambiando
            const newPassword = document.getElementById('new_password');
            const confirmPassword = document.getElementById('confirm_password');
            if (newPassword.value || confirmPassword.value) {
                if (newPassword.value.length < 6) {
                    showError(newPassword, 'La contraseña debe tener al menos 6 caracteres');
                    isValid = false;
                } else if (newPassword.value !== confirmPassword.value) {
                    showError(confirmPassword, 'Las contraseñas no coinciden');
                    isValid = false;
                }
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    }

    // Manejo del menú desplegable
    const dropdowns = document.querySelectorAll('.dropdown');
    
    dropdowns.forEach(dropdown => {
        const toggle = dropdown.querySelector('.dropdown-toggle');
        
        toggle.addEventListener('click', (e) => {
            e.preventDefault();
            
            // Cerrar otros dropdowns
            dropdowns.forEach(otherDropdown => {
                if (otherDropdown !== dropdown) {
                    otherDropdown.classList.remove('active');
                }
            });
            
            dropdown.classList.toggle('active');
        });
    });
    
    // Cerrar dropdown al hacer click fuera
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.dropdown')) {
            dropdowns.forEach(dropdown => {
                dropdown.classList.remove('active');
            });
        }
    });

    // Funciones auxiliares
    function showError(element, message) {
        element.classList.add('error-input');
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.style.color = '#dc2626';
        errorDiv.style.fontSize = '0.875rem';
        errorDiv.style.marginTop = '0.25rem';
        errorDiv.textContent = message;
        element.parentNode.appendChild(errorDiv);
    }

    function removeError(element) {
        const errorMessage = element.parentNode.querySelector('.error-message');
        if (errorMessage) {
            errorMessage.remove();
        }
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
});