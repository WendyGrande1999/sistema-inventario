@extends('layouts.app')

@section('title', 'Ayuda')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center">Centro de Ayuda</h1>
    
    <!-- Sección de videos -->
    <div class="mb-5">
        <h2 class="mb-3">Videos</h2>
        <p>Consulta nuestra playlist en YouTube para aprender a usar cada funcionalidad del sistema:</p>
        <a href="https://www.youtube.com/playlist?list=PLgWOHTG03_v5the31KVhQopMQXk-92wkY" target="_blank" class="btn btn-primary mb-4">
            Ver playlist completa
        </a>

        <div class="row">
            <div class="col-md-6">
                <h5>Gestión de usuarios</h5>
                <a href="https://www.youtube.com/watch?v=0suDd7DZVqI&list=PLgWOHTG03_v5the31KVhQopMQXk-92wkY&index=11" target="_blank">Ver video</a>
            </div>
            <div class="col-md-6">
                <h5>Recuperar contraseña</h5>
                <a href="https://www.youtube.com/watch?v=PY1SKfWrORE&list=PLgWOHTG03_v5the31KVhQopMQXk-92wkY&index=2" target="_blank">Ver video</a>
            </div>
            <div class="col-md-6 mt-3">
                <h5>Gestión de productos</h5>
                <a href="https://www.youtube.com/watch?v=zfl-ZTYF9DY&list=PLgWOHTG03_v5the31KVhQopMQXk-92wkY&index=8" target="_blank">Ver video</a>
            </div>
            <div class="col-md-6 mt-3">
                <h5>Entradas</h5>
                <a href="https://www.youtube.com/watch?v=e-6Ds3qSfgg&list=PLgWOHTG03_v5the31KVhQopMQXk-92wkY&index=14" target="_blank">Ver video</a>
            </div>
            <div class="col-md-6 mt-3">
                <h5>Salidas</h5>
                <a href="https://www.youtube.com/watch?v=qhTs8Mp2lOU&list=PLgWOHTG03_v5the31KVhQopMQXk-92wkY&index=4" target="_blank">Ver video</a>
            </div>
            <div class="col-md-6 mt-3">
                <h5>Stock de productos</h5>
                <a href="https://www.youtube.com/watch?v=CMG1yXAzef8&list=PLgWOHTG03_v5the31KVhQopMQXk-92wkY&index=7" target="_blank">Ver video</a>
            </div>
            <div class="col-md-6 mt-3">
                <h5>Cierres de inventario</h5>
                <a href="https://www.youtube.com/watch?v=jlaE_wMJT1g&list=PLgWOHTG03_v5the31KVhQopMQXk-92wkY&index=15" target="_blank">Ver video</a>
            </div>
            <div class="col-md-6 mt-3">
                <h5>Gestión de reporte por producto</h5>
                <a href="https://www.youtube.com/watch?v=qvl_bA2Mhr8&list=PLgWOHTG03_v5the31KVhQopMQXk-92wkY&index=16" target="_blank">Ver video</a>
            </div>
            <div class="col-md-6 mt-3">
                <h5>Gestión de reporte diario</h5>
                <a href="https://www.youtube.com/watch?v=psRClqpG_lE&list=PLgWOHTG03_v5the31KVhQopMQXk-92wkY&index=13" target="_blank">Ver video</a>
            </div>
        </div>
    </div>

    <!-- Sección de preguntas frecuentes -->
    <div>
        <h2 class="mb-3">Preguntas frecuentes</h2>
        <div class="accordion" id="faqAccordion">

            <div class="accordion-item">
                <h2 class="accordion-header" id="faq1">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                        ¿Cómo recupero mi contraseña?
                    </button>
                </h2>
                <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Ve al inicio de sesión y haz clic en "¿Olvidaste tu contraseña?". Luego, sigue las instrucciones para restablecerla.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="faq2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                        ¿Puedo eliminar un producto del inventario?
                    </button>
                </h2>
                <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Sí, pero asegúrate de que el producto no tenga entradas ni salidas registradas, de lo contrario el sistema no permitirá eliminar el registro.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="faq3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                        ¿Cómo registro una nueva entrada de producto?
                    </button>
                </h2>
                <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Ve a la sección de entradas, selecciona el producto, indica la cantidad y precio, y guarda los datos.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="faq4">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                        ¿Qué ocurre si elimino una entrada con salidas asociadas?
                    </button>
                </h2>
                <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="faq4" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Las salidas asociadas también serán eliminadas automáticamente para evitar inconsistencias en el stock.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="faq5">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                        ¿Cómo se maneja la gestión de existencias?
                    </button>
                </h2>
                <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="faq5" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        En la sección "Gestión de existencias", las entradas mostradas en la lista pertenecen a las entradas activas (es decir, las entradas de un producto que aún tengan cantidad disponible).
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="faq6">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                        ¿Dónde puedo ver el resumen actual de todos los productos y su stock?
                    </button>
                </h2>
                <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="faq6" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        En el ítem "Stock" del menú lateral derecho, puedes ver un resumen actualizado de todos los movimientos de entradas y salidas.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="faq7">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                        ¿Qué rango de fechas toma el sistema en la sección de Stock para deducir el stock actual?
                    </button>
                </h2>
                <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="faq7" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Al inicio del uso del sistema, se toman todas las entradas y salidas hasta la fecha en que se genere un cierre de inventario. A partir de esa fecha comienza un nuevo contador.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="faq8">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                        ¿Cuándo una entrada se vuelve inactiva?
                    </button>
                </h2>
                <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="faq7" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Al sumar todas las cantidades salientes y estan dejan en productos disponibles en 0 a una determinada entrada, entonces se convierte en inactiva.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="faq8">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                        ¿Donde puedo ver el historial de una entrada inactiva?
                    </button>
                </h2>
                <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="faq7" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        En la sección Cierres de inventario -> Historial de cierres -> Selecciona fecha cierre. Esta vista nos muestra una lista de todas las entradas dentro del rango de cierre. 
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
