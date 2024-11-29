@extends('layouts.app')

@section('title', 'Política de Privacidad')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4">Política de Privacidad</h1>

    <div class="mb-4">
        
        <p>
            En este apartado se describen las políticas de privacidad y seguridad del sistema de gestión de inventarios. La seguridad de tus datos es nuestra principal prioridad, por lo que nos comprometemos a proteger la información personal que nos brindes durante el uso del sistema.
        </p>
    </div>

    <div class="mb-4">
        <h2>Información recolectada</h2>
        <p>
            El sistema recopila y almacena información esencial para la gestión de inventarios, incluyendo:
        </p>
        <ul>
            <li>Datos de identificación personal (nombre, correo electrónico, usuario).</li>
            <li>Información relacionada con los productos (nombre, cantidad, precio, fecha de registro).</li>
            <li>Datos de transacciones (entradas y salidas de inventario).</li>
            <li>Generar reportes (de productos, diarios y en un intervalo de fechas).</li>
        </ul>
    </div>

    <div class="mb-4">
        <h2>Uso de la información</h2>
        <p>
            Los datos recolectados se utilizarán para:
        </p>
        <ul>
            <li>Gestionar las operaciones del inventario de manera eficiente.</li>
            <li>Generar reportes y estadísticas para análisis internos.</li>
          
        </ul>
    </div>

    <div class="mb-4">
        <h2>Seguridad de la información</h2>
        <p>
            La seguridad de tu información personal es fundamental. Por lo tanto se implementaron medidas de seguridad técnica y administrativas  para proteger la información almacenada en nuestro sistema. Algunas de las políticas clave son:
        </p>
        <ul>
    <li><strong>Cifrado de datos:</strong> Cuando un usuario crea una cuenta, la contraseña es encriptada utilizando un protocolo de seguridad estándar, lo que asegura que no sea accesible ni almacenada en texto claro.</li>
    <li><strong>Autenticación de usuario:</strong> El sistema exige que cada usuario se autentique mediante credenciales seguras (usuario y contraseña). Se recomienda cambiar la contraseña periódicamente para garantizar la seguridad de la cuenta.</li>
    <li><strong>Control de acceso:</strong> El acceso a la información está estrictamente controlado según los roles y permisos asignados a cada usuario. Solo los usuarios con permisos específicos pueden acceder a datos sensibles del sistema.</li>
    <li><strong>Inicios de sesión:</strong> Si un usuario intenta acceder al sistema desde otro navegador utilizando la URL de una sesión abierta, se le mostrará una vista del sistema sin acceso a la información. El sistema solicitará al usuario que inicie sesión nuevamente para garantizar la seguridad de la cuenta.</li>
    <li><strong>Almacenamiento seguro:</strong> Todos los datos son almacenados en servidores protegidos con medidas de seguridad, que incluyen protección contra accesos no autorizados. Además, se realizan respaldos periódicos para asegurar la integridad de la información.</li>
</ul>

    </div>

   

    <div class="mb-4">
        <h2>Compartir la información a terceros</h2>
        <p>
            No compartimos ni vendemos la información personal que se recopila a terceros, excepto en los siguientes casos:
        </p>
        <ul>
            <li>Si es requerido por la ley o alguna autoridad competente.</li>
            <li>Para mejorar la funcionalidad del sistema a través de servicios de terceros, como herramientas de análisis (estos servicios deben cumplir con los estándares de privacidad correspondientes).</li>
        </ul>
    </div>

 
   

    <div class="text-center mt-5">
        <a href="{{ url()->previous() }}" class="btn btn-primary">Regresar</a>
    </div>
</div>
@endsection
