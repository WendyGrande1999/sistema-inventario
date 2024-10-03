<!-- resources/views/partials/guest/navbar.blade.php -->

<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm menu-horizontal">
    <div class="container">

        <a class="navbar-brand" href="#">{{ __('Hojas Eco Villa') }}</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarGuest" aria-controls="navbarGuest" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarGuest">
            <ul class="navbar-nav ms-auto">
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar sesión') }}</a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</nav>

