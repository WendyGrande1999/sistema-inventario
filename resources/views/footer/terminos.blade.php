@extends('layouts.app')

@section('title', 'Términos y Condiciones')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4">Términos y Condiciones</h1>

    <div class="mb-4">
        <h2>1. Aceptación de los términos</h2>
        <p>
            Al utilizar este sistema de inventarios, aceptas cumplir con los términos y condiciones establecidos en este documento. Si no estás de acuerdo, no debes usar el sistema.
        </p>
    </div>

    <div class="mb-4">
        <h2>2. Uso adecuado del sistema</h2>
        <p>
            Este sistema debe utilizarse exclusivamente para gestionar los inventarios de la organización. Está prohibido:
        </p>
        <ul>
            <li>Acceder sin autorización a datos o módulos del sistema.</li>
            <li>Modificar o eliminar registros sin causa justificada.</li>
            <li>Compartir credenciales de usuario con terceros.</li>
            <li>Realizar modificaciones al sistema con fines de comercialización o distribución sin la autorización expresa de los titulares de los derechos de autor.</li>
        </ul>
    </div>

    <div class="mb-4">
        <h2>3. Responsabilidades del usuario</h2>
        <p>
            Cada usuario es responsable de:
        </p>
        <ul>
            <li>Proporcionar información precisa al registrar o actualizar datos.</li>
            <li>Proteger sus credenciales de acceso.</li>
            <li>Informar al administrador sobre cualquier error, irregularidad o problema técnico detectado.</li>
            <li>Asumir los costos asociados al alojamiento web y al mantenimiento necesario para el uso continuo del sistema.</li>
        </ul>
    </div>

    <div class="mb-4">
        <h2>4. Limitaciones de responsabilidad</h2>
        <p>
            El administrador del sistema no será responsable por:
        </p>
        <ul>
            <li>Errores cometidos por los usuarios al registrar datos.</li>
            <li>La pérdida de datos causada por incumplimiento de estas condiciones.</li>
            <li>Fallas técnicas causadas por factores externos al sistema.</li>
        </ul>
    </div>

    <div class="mb-4">
        <h2>5. Confidencialidad y seguridad</h2>
        <p>
            Los datos registrados en el sistema son confidenciales y deben manejarse de acuerdo con las políticas internas de la organización.
        </p>
    </div>

    <div class="mb-4">
        <h2>6. Prohibición de modificaciones para comercialización</h2>
        <p>
            Este sistema es propiedad intelectual de sus desarrolladores. Queda estrictamente prohibido modificar, distribuir o comercializar el sistema sin la autorización expresa y por escrito de los titulares de los derechos de autor.
        </p>
    </div>

    <div class="mb-4">
        <h2>7. Costos de alojamiento</h2>
        <p>
            El uso del sistema requiere un servicio de alojamiento web. El usuario deberá incurrir en los costos asociados a este servicio, que incluye, pero no se limita a, el mantenimiento del servidor, el almacenamiento de datos y la configuración de dominios.
        </p>
    </div>

  

    <div class="mb-4">
        <h2>8. Contacto</h2>
        <p>
            Si tienes dudas sobre estos términos, puedes comunicarte con el administrador del sistema a través del correo <strong>elizabethalvarezgra17@gmail.com</strong>.
        </p>
    </div>

    <div class="text-center mt-5">
        <a href="{{ url()->previous() }}" class="btn btn-primary">Regresar</a>
    </div>
</div>
@endsection
