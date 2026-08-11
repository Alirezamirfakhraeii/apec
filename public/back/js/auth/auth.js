document.addEventListener('DOMContentLoaded', () => {

    const loginForm = document.querySelector('[data-login-form]');

    if (!loginForm) {
        return;
    }

    const submitButton =
        loginForm.querySelector('[data-login-submit]');

    const submitText =
        loginForm.querySelector('[data-login-submit-text]');


    loginForm.addEventListener('submit', () => {

        if (!submitButton) {
            return;
        }

        submitButton.disabled = true;

        const loadingText =
            submitButton.dataset.loadingText;

        if (submitText && loadingText) {
            submitText.textContent = loadingText;
        }

    });

});


document.addEventListener('DOMContentLoaded', function () {
    const loader = document.getElementById('global-loader');

    if (loader) {
        loader.style.display = 'none';
    }
});
