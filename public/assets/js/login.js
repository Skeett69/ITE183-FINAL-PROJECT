// Modern Login Handler for Tailwind CSS Design
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const submitBtn = document.getElementById('submit');
    const errorMessage = document.getElementById('errorMessage');

    // Show error message
    function showError(message) {
        if (errorMessage) {
            errorMessage.querySelector('span').textContent = message;
            errorMessage.classList.remove('hidden');
            
            // Hide after 5 seconds
            setTimeout(() => {
                errorMessage.classList.add('hidden');
            }, 5000);
        }
    }

    // Hide error message
    function hideError() {
        if (errorMessage) {
            errorMessage.classList.add('hidden');
        }
    }

    // Form submission handler
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            hideError();

            // Get form data
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // Basic validation
            if (!email || !password) {
                showError('Please fill in all fields');
                return;
            }

            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="flex items-center justify-center gap-2"><i class="fas fa-spinner fa-spin"></i> <span>Signing In...</span></span>';

            // Create form data
            const formData = new FormData(loginForm);

            // Submit form via AJAX
            fetch('/login', {
                method: 'POST',
                headers: { 
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'error') {
                    showError(data.message || 'Invalid credentials. Please try again.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<span class="flex items-center justify-center gap-2"><span>Sign In</span><i class="fas fa-arrow-right"></i></span>';
                } else if (data.status === 'success') {
                    // Show success message
                    submitBtn.innerHTML = '<span class="flex items-center justify-center gap-2"><i class="fas fa-check"></i> <span>Success!</span></span>';
                    submitBtn.classList.add('bg-green-500');
                    
                    // Redirect to dashboard
                    setTimeout(() => {
                        window.location.href = data.redirect || '/dashboard';
                    }, 500);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showError('An error occurred. Please try again.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<span class="flex items-center justify-center gap-2"><span>Sign In</span><i class="fas fa-arrow-right"></i></span>';
            });
        });
    }

    // Input field animations (optional - add focus effects)
    const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-white/50');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-white/50');
        });
    });
});
