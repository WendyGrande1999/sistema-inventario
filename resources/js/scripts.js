const eyeButton = document.querySelector("#eye-icon");
const inputPass = document.querySelector("#password");
const inputEmail = document.querySelector("#email");


eyeButton.addEventListener("click", (e) => {
    if (eyeButton.classList.contains("fa-eye")) {
        eyeButton.classList.remove("fa-eye");
        eyeButton.classList.add("fa-eye-slash");
        inputPass.setAttribute("type", "text")
    }
    else {
        eyeButton.classList.remove("fa-eye-slash");
        eyeButton.classList.add("fa-eye");
        inputPass.setAttribute("type", "password")
    }
});


const forms = document.querySelectorAll('.needs-validation');

forms.forEach(form => {
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        event.stopPropagation();
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
        }
        else {
            console.log("email", inputEmail.value)
            console.log("password", inputPass.value)



        }


    });
});
