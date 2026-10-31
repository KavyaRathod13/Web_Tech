
// StudentHub form handling and session-aware links

document.addEventListener('DOMContentLoaded', async function () {

    let session;

    try {
        const response = await fetch('backend/csrf.php');

        if (!response.ok) {
            throw new Error('Unable to fetch session token.');
        }

        session = await response.json();

    } catch (e) {
        console.error('Session loading error:', e);
        return;
    }

    const csrf = session.csrf;

    // Add CSRF token to registration and login forms

    document.querySelectorAll('#registerForm, #loginForm').forEach(function (form) {

        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'csrf';
        hidden.value = csrf;

        form.appendChild(hidden);
    });

    // Read URL parameters

    const params = new URLSearchParams(location.search);

    const registerStatus = document.getElementById('registerStatus');
    const loginStatus = document.getElementById('loginStatus');

    // Registration messages

    if (registerStatus && params.has('error')) {

        registerStatus.textContent =
            params.get('error') === 'duplicate'
                ? 'Email or enrollment number already registered.'
                : 'Please check all your details and password.';
    }

    // Login messages

    if (loginStatus && params.has('error')) {
        loginStatus.textContent =
            'Incorrect login details or session expired.';
    }

    if (loginStatus && params.has('registered')) {
        loginStatus.textContent =
            'Registration successful. Please log in.';
    }

    if (loginStatus && params.has('logout')) {
        loginStatus.textContent =
            'You have logged out.';
    }

    // Registration validation

    const register = document.getElementById('registerForm');

    if (register) {

        register.addEventListener('submit', function (event) {

            const password = document.getElementById('password').value;
            const confirm = document.getElementById('confirm').value;
            const status = document.getElementById('registerStatus');

            const strong =
                /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/.test(password);

            if (!strong || password !== confirm) {

                event.preventDefault();

                status.textContent = !strong
                    ? 'Password needs 8 characters, uppercase, lowercase, number and special character.'
                    : 'Passwords do not match.';

                status.className = 'text-danger small mt-2';
            }
        });
    }

    // Contact form submission

    const contact = document.getElementById('contactForm');

    if (contact) {

        contact.addEventListener('submit', async function (event) {

            event.preventDefault();

            const status = document.getElementById('contactStatus');

            if (!contact.checkValidity()) {
                contact.classList.add('was-validated');
                return;
            }

            const data = new FormData(contact);
            data.append('csrf', csrf);

            try {

                const response = await fetch('backend/contact.php', {
                    method: 'POST',
                    body: data
                });

                const result = await response.json();

                status.textContent = result.message || result.error;

                status.className = response.ok
                    ? 'text-success small mt-2'
                    : 'text-danger small mt-2';

                if (response.ok) {
                    contact.reset();
                }

            } catch (e) {
                status.textContent = 'Unable to send message.';
            }
        });
    }

    // Feedback form submission

    const feedbackForm = document.getElementById('feedbackForm');

    if (feedbackForm) {

        feedbackForm.addEventListener('submit', async function (event) {

            event.preventDefault();

            const status = document.getElementById('feedbackStatus');
            const ratingError = document.getElementById('ratingError');

            // Validate all required fields

            if (!feedbackForm.checkValidity()) {

                feedbackForm.classList.add('was-validated');

                status.textContent = 'Please complete all required fields.';
                status.className = 'text-danger small mt-3';

                return;
            }

            // Validate rating

            const rating = feedbackForm.querySelector(
                'input[name="rating"]:checked'
            );

            if (!rating) {

                ratingError.textContent = 'Please select a rating.';

                return;
            }

            ratingError.textContent = '';

            // Show submitting message

            status.textContent = 'Submitting feedback...';
            status.className = 'text-secondary small mt-3';

            // Prepare form data

            const data = new FormData(feedbackForm);
            data.append('csrf', csrf);

            try {

                // Send feedback to PHP backend

                const response = await fetch('backend/feedback.php', {
                    method: 'POST',
                    body: data
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(
                        result.error || 'Unable to submit feedback.'
                    );
                }

                // FIX: Reset the form BEFORE displaying success message

                feedbackForm.reset();
                feedbackForm.classList.remove('was-validated');

                // Display success message AFTER resetting

                status.textContent =
                    result.message ||
                    'Thank you! Your feedback was submitted successfully.';

                status.className = 'text-success small mt-3';

            } catch (error) {

                status.textContent =
                    error.message || 'Unable to submit feedback.';

                status.className = 'text-danger small mt-3';

            }
        });

        // Clear messages when the Clear button is clicked

        feedbackForm.addEventListener('reset', function () {

            const status = document.getElementById('feedbackStatus');
            const ratingError = document.getElementById('ratingError');

            if (status) {
                status.textContent = '';
            }

            if (ratingError) {
                ratingError.textContent = '';
            }

            feedbackForm.classList.remove('was-validated');

        });
    }

    // Session-aware Logout navigation
    // Prevent duplicate Logout links on PHP pages

    if (session.logged_in) {

        const nav = document.querySelector('.navbar-nav');

        if (nav) {

            const existingLogout = nav.querySelector(
                'a[href="backend/logout.php"]'
            );

            if (!existingLogout) {

                const li = document.createElement('li');
                li.className = 'nav-item';

                const a = document.createElement('a');
                a.className = 'nav-link';
                a.href = 'backend/logout.php';
                a.textContent = 'Logout';

                li.appendChild(a);
                nav.appendChild(li);
            }
        }
    }

});
