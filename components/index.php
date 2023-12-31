<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head><script src="../assets/js/color-modes.js"></script>

  <link rel="stylesheet" href="">
  <?php

session_start();
if(!isset($_SESSION["id_usuario"])){
  header("Location:./login.html");
}

?>

  <link rel="stylesheet" href="">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.118.2">
    
    <title>SIS-310</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/navbars-offcanvas/">

    

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style/style.css">

    <link rel="stylesheet" href="../style/stylep.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
    <link href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

      .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
      }

      .bd-mode-toggle {
        z-index: 1500;
      }

      .bd-mode-toggle .dropdown-menu .active .bi {
        display: block !important;
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="../navbars-offcanvas/navbars-offcanvas.css" rel="stylesheet">
  </head>
  <body>
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
      <symbol id="check2" viewBox="0 0 16 16">
        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
      </symbol>
      <symbol id="circle-half" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
      </symbol>
      <symbol id="moon-stars-fill" viewBox="0 0 16 16">
        <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/>
        <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"/>
      </symbol>
      <symbol id="sun-fill" viewBox="0 0 16 16">
        <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
      </symbol>
    </svg>

    <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
      <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center"
              id="bd-theme"
              type="button"
              aria-expanded="false"
              data-bs-toggle="dropdown"
              aria-label="Toggle theme (auto)">
        <svg class="bi my-1 theme-icon-active" width="1em" height="1em"><use href="#circle-half"></use></svg>
        <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
      </button>
      <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
        <li>
          <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
            <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#sun-fill"></use></svg>
            Light
            <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
          </button>
        </li>
        <li>
          <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
            <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#moon-stars-fill"></use></svg>
            Dark
            <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
          </button>
        </li>
        <li>
          <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
            <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#circle-half"></use></svg>
            Auto
            <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
          </button>
        </li>
      </ul>
    </div>

    
<main>

 
  <nav class="navbar navbar-dark bg-dark" aria-label="Dark offcanvas navbar">

    <div class="navbar2">

      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbarDark" aria-controls="offcanvasNavbarDark" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbarDark" aria-labelledby="offcanvasNavbarDarkLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarDarkLabel">Temas</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="./index.html">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="javascript:changeContent('Indicadores de preferencia/indicadores_de_preferencia.html')">Indicadores de preferencia</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="javascript:changeContent('Diagrama de pareto/diagrama_de_Pareto2.html')">Diagramas de pareto</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="javascript:changeContent('pronosticos/pronosticos.html')">Pronosticos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="javascript:changeContent('PAP/PAP.php')">Plan de agregado de produccion</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./cerrarssesion.php">Cerrar sesion</a>
            </li>

          </ul>
        </div>
      </div>
    </div>
  </nav>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
    <div class="container-fluid">
      <div class="navbar-brand"  id="titulo1">SIS-310</div>

        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="./index.html">Home</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="javascript:changeContent('Indicadores de preferencia/indicadores_de_preferencia.html')">Indicadores de preferencia</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="javascript:changeContent('Diagrama de pareto/diagrama_de_Pareto2.html')">Diagramas de pareto</a>
           </li>
           <li class="nav-item">
            <a class="nav-link" href="javascript:changeContent('PAP/PAP.php')">Plan de agregado de produccion</a>
          </li>
         <li class="nav-item">
          <a class="nav-link" href="javascript:changeContent('pronosticos/pronosticos.html')">Pronosticos</a>
       </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>


  <div class="content my-5 bg-body-tertiary p-5 rounded col-sm-8 py-5 mx-auto justify-text" id="content">
        <h1 class="display-5 fw-normal">¿Qué es un sistema de producción?</h1>
        <p class="fs-5">Este sistema hace los calculos necesarios para la materia de SIS-310 puedes revisar el <a href="https://github.com/bspoloo/SIS310-BSPO">repositorio</a> y <a href="https://www.youtube.com/watch?v=IPmjCOOmyCc">cuentas</a> de los creadores de este proyecto.</p>
        <p>Un sistema de producción es una recopilación de modalidades productivas, aplicadas en la administración de empresas con el fin de organizar la producción o la prestación de servicios.
          Cada uno de los diferentes sistemas de producción, cuando se aplica, genera efectos que se sienten directamente en la economía, la sociedad y el espacio geográfico.</p>
        <p>
          <a class="btn btn-primary" href="../components/navbar/#offcanvas" role="button">Learn more about offcanvas navbars &raquo;</a>
        </p>
        <h3 class="display-5 fw-normal">¿Cómo funcionan los sistemas de producción?</h3>
        <p>Los sistemas de producción funcionan como un conjunto de procesos y operaciones interconectados entre sí para generar un producto o un servicio.

          El funcionamiento del sistema productivo variará según el tipo de negocio al que se aplique. Para ello, existen varias técnicas de planificación y gestión que se pueden elegir para organizar mejor tu empresa.
          
          Además del tipo de industria, debemos tener 
          en cuenta que, a medida que una empresa crece, automáticamente incorpora nuevas personas, máquinas y operaciones, lo que genera la necesidad de un rediseño del sistema de producción.</p>
          
          <center><img src="../images/img1.jpg" alt="sistema de produccion"></center>

          <h3>Tipos de sistemas de produccion</h3>
          <p>Pero al fin y al cabo, ¿qué varía en cada tipo de producción?

            Los sistemas más conocidos y aplicados en 
            diferentes áreas de la economía son: sistema de
             producción continua e intermitente y dirigido a grandes proyectos.</p>
          <h3>Sistema de producción continua</h3>
          <p>El objetivo del sistema de producción continua es producir tantos artículos como sea posible en el menor tiempo posible, también conocido como fordismo.

            Normalmente, el producto no sufre grandes cambios y el proceso fluye de forma predecible e ininterrumpida.
            
            Su característica principal es la repetición de las mismas operaciones, con pocas interrupciones.
            
            En la industria textil, por ejemplo, el proceso de aplicación de botones a una prenda de vestir, así como la costura de piezas a granel.</p>
          <h3>Sistema de producción intermitente</h3>
          <p>El sistema de producción intermitente, por otro lado, tiene en cuenta la información y las tendencias del mercado, que son bien conocidas por quienes trabajan en moda.

            Desde esta perspectiva, se presta mayor atención a las pérdidas que se producen en todo el proceso productivo.
            
            La industria de la moda, además de trabajar con las tendencias y apuestas de los grandes diseñadores, necesitas considerar la demanda del público consumidor. Por eso, a la hora de planificar una nueva producción, muchas empresas tienen en cuenta la demanda de un tipo específico de ropa, por ejemplo.
            
            En algunas regiones de mundo, por ejemplo, aunque sea invierno, el frío no alcanza la intensidad suficiente para justificar una gran producción de abrigos.
            
            Un punto a considerar en este tipo de sistemas es que, cuando surge un problema en un determinado producto, o en el lote a producir, no es posible reiniciar el proceso de producción inmediatamente, ya que el siguiente producto entrará en la cola. La única opción es cambiar las pruebas y puesta a punto de las máquinas, centrándonos en la atención de un nuevo cliente.
            
            Por lo tanto, los productos que ya han sido producidos deben ir a un área de segregación donde luego se encontrará el probable problema.</p>


            <h3>Producción para grandes proyectos</h3>
            <p>Esta es la forma más personalizada de pensar en un sistema de producción, ya que está impulsado por la demanda del cliente.

              Esta modalidad de producción proporciona una reducción de pérdidas ya que los proyectos se planifican meticulosamente para atender solicitudes específicas.
              
              Sin embargo, la necesidad de dirigir todos los recursos disponibles para asegurar la entrega del proyecto en la fecha correcta, puede generar la necesidad de que varios profesionales interactúen entre sí, complejizando la gestión.</p>
        <h2>Conceptos importantes</h2>
        <h3>Fronteras</h3>
        <p>
          También conocida como curva de posibilidades de producción, ilustra gráficamente la escasez de factores de producción y representa el límite de la capacidad productiva de una empresa.
        </p>

        <h3>Entradas</h3>
        <p>
          Son aquellos recursos transformados como materiales, información y consumidores o los recursos que actúan sobre ellos, como empleados, edificios, equipos y tecnología.
        </p>

        <h3>Rendimiento</h3>
        <p>
          Es la transformación de recursos o sistemas de entrada en otras formas, ya sean productos, servicios o subproductos.
        </p>

        <h3>Salidas</h3>
        <p>
          Es el resultado del proceso de transformación. Aquellos bienes o servicios físicos y sus productos indirectos como la basura y la polución.
        </p>

        <h3>Feedback</h3>
        <p>
          También conocido como feedback loop, es la metodología que identifica visualmente las relaciones de causa y efecto de los procesos de una empresa, entregando una visión sistémica del negocio.
        </p>
        <h3>¿Qué se necesita para implementar un sistema de producción?</h3>
        <p>
          Para implementar un sistema de producción en tu empresa, debes adaptarlo al tipo de salida que deseas generar. Sin embargo, independientemente del modelo que mejor se adapte a tus objetivos, algunos consejos generales pueden ser valiosos.
        </p>
      
        <p>Entre ellos:</p>
      
        <ol>
          <li>
            <strong>Mapear las etapas de producción</strong><br>
            Mapear los procesos y las etapas de producción.
          </li>
          <li>
            <strong>Definir metas y realizar un seguimiento de los ciclos de producción</strong><br>
            Calcula el tiempo de cada proceso para organizarlos y adaptarlos a los tiempos de entrega. Una vez hecho esto, determina tus objetivos para realizar un mejor seguimiento de los resultados de los procesos en cada ciclo de producción.
          </li>
          <li>
            <strong>Establecer indicadores de desempeño</strong><br>
            Establece indicadores clave de desempeño (KPI’s) acordes a la maquinaria y personal involucrado en los procesos.
          </li>
          <li>
            <strong>Impulsar un sistema de gestión integrado entre las distintas áreas de la empresa</strong><br>
            Capacita a tu equipo para adaptarse al sistema de producción.
          </li>
        </ol>
  </div>
</main>
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
<script src="../script/fetch.js"></script>
<script src="../script/script_indPreferencias.js"></script>
<script src="../script/script_pareto.js"></script>
<script src="../script/script_pronosticos.js"></script>
<script src="../script/script_PAP.js"></script>

<script type="module">
  import {
      Grid,
      html
  } from "https://unpkg.com/gridjs?module";
</script>
<script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>


    </body>
</html>
