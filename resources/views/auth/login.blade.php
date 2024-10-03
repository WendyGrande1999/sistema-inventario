<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />


    <link rel="stylesheet" href="{{ asset('assets/estilos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/estilo_login.css') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <!-- font-awesome icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

</head>

<body>
    <section class="login_section d-flex align-items-center justify-content-center">
        <div class="login_Box shadow rounded-1">
            <div class="logo text-center mb-4">
                <img src="{{ asset('images/logoo.png')}}"  style="width: 90px; height: auto;" class="img-fluid" />
                <h1 class="h3 pt-2 mt-1">Bienvenido</h1>
                <p class="small_text">Por favor ingresa tus datos para iniciar sesión</p>
            </div>

            <div class="d-flex justify-content-between mb-4">

            </div>

            <div </div>

            </div>

            <div class=" mb-4 d-flex">
                <div class="line"></div>
                <small class="or text-center px-2">Agrege la informacion corespondiente</small>
                <div class="line"></div>
            </div>

            <form action="{{ route('login') }}" method="post"class="needs-validation" novalidate>
                @csrf

                <!-- Mostrar mensajes de error -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="login_form">
                    <div class="form-floating mb-4">
                        <input type="email" class="form-control"  name="email" ="form2Example11" placeholder="nombre@gmail.com"
                            required />
                        <label for="email " class="small_text">
                            Correo</label>
                        <div class="invalid-feedback">
                            Porfavor agrege un correo valido
                        </div>
                    </div>

                    <div class="form-floating position-relative">
                        <input type="password" name="password" class="form-control" id="form2Example22" placeholder="Password" required />
                        <label for="password" class="small_text">Contraseña</label>
                        <i id="eye-icon" class="fa fa-eye  position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;" aria-hidden="true"></i>
                        <div class="invalid-feedback">
                            Porfavor agrege la contraseña
                        </div>
                    </div>

                </div>

                <div class="text-end mb-4 mt-2">
                    <a class="text-end small_text link-primary" href="{{ route('password.request') }}">¿Olvidaste tu
                        contraseña?</a>

                </div>

                <button class="btn btn-primary w-100" type="submit">Iniciar Sesion</button>

            </form>
        </div>
    </section>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous" defer>
    </script>

    <script src="{{ asset('js/scripts.js')}}"></script>
</body>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const eyeButton = document.getElementById('eye-icon'); // Cambia el ID si es necesario
        const inputPass = document.getElementById('form2Example22'); // Cambia el ID si es necesario

        // Función para alternar la visibilidad de la contraseña
        const togglePasswordVisibility = () => {
            if (eyeButton.classList.contains("fa-eye")) {
                eyeButton.classList.remove("fa-eye");
                eyeButton.classList.add("fa-eye-slash");
                inputPass.setAttribute("type", "text");
            } else {
                eyeButton.classList.remove("fa-eye-slash");
                eyeButton.classList.add("fa-eye");
                inputPass.setAttribute("type", "password");
            }
        };

        // Agregar evento de clic al botón de ojo
        eyeButton.addEventListener("click", togglePasswordVisibility);
    });
</script>



</html>
