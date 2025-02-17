document.addEventListener("DOMContentLoaded", function () {
    function handleSubmit(formId, actionType) {
        document.getElementById(formId).addEventListener("submit", function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            formData.append(actionType, true);

            fetch("../admin.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: data.message || "Redirecting...",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        }
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: data.message,
                    });
                }
            })
            .catch(error => console.error("Error:", error));
        });
    }

    handleSubmit("login-form", "login");
    handleSubmit("register-form", "register");
});

function toggleForms() {
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const formTitle = document.getElementById('form-title');
    const toggleText = document.getElementById('toggle-text');
    const toggleLink = document.getElementById('toggle-link');

    if (registerForm.style.display === 'none') {
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
        formTitle.innerHTML = 'Register';
        toggleText.innerHTML = 'Already have an account?';
        toggleLink.innerHTML = 'Login here';
    } else {
        loginForm.style.display = 'block';
        registerForm.style.display = 'none';
        formTitle.innerHTML = 'Login';
        toggleText.innerHTML = "Don't have an account?";
        toggleLink.innerHTML = 'Register here';
    }
}
