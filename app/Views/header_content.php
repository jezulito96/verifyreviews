<div class="headerContainer">

    <div class="logoContainer">
        <div class="logo">
            <a href="https://verifyreviews.es">
                <?php echo '<img class="imgLogo" src="'.base_url() .'img/logoMovil.png" title="Verify Reviews" alt="Verify Reviews" />'; ?>
                <?php echo '<img class="imgLogo2" src="'.base_url() .'img/logotipo4.png" title="Verify Reviews" alt="Verify Reviews" />'; ?>
            </a>
        </div>

    </div>

    <div class="menuContainer">
        <!-- Logo de https://iconos8.es/icon/set/cruz-menu/family-office -->
        <img class="imgMenu"
            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAT0lEQVR4nO3WwQkAIAwDwIzezesWKuEO8jf4aBIAHpmSZEuS1w9QJK0/MiUBAPLBRTbj0zoatySpKTIlAQDywUU249M6GrckqSkyJQEg1x3OPOvHECpbTAAAAABJRU5ErkJggg==" />

        <!-- Logo de https://iconos8.es/icon/set/cruz-menu/family-office -->
        <img class="imgMenu2" style="display: none"
            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAABKElEQVR4nO2YzU7CQBRGz+PogldAZYE/rJSCO3CJoLj0kX0A5SeAlDShhpAZ2tA6nU6+k3TXuZmT2+nce0EIIYQQQvhIA3guMV4LuMExl8AXsAGGJcRrAt/AzKVMKhHvn9+CMlfAz0G8GXCNA/r7TMQlyLSB+VGsLfCGIxKZtWEDoxIkPnBMzyLzmmPtLbAwrJ1SERGwMmxofGLNnW8S58h4K5HStchM/t6Ae4vEO57RAZaWP1BtJFIeLZnJypaXPBgyU9k98V8ytZIIRqST49Py9pAHddifTmy4Nr/fbo7b3ftbPQqhRInOqIBtla/z8j2rjB/l7EW8kOkbJJIu8aVgYxUDnzgimFb34mj4UHSS0qxq+HAok0gMqOk4KKgBnRBCCCGEIJMdXBTwCqWDRf4AAAAASUVORK5CYII=" />
    </div>
<!-- Lista que se desplegará al hacer clic en el botón -->
<ul class="listaMenu" >
    <?php
        $sesionIniciada = session() -> get("sesionIniciada");
        if(isset($sesionIniciada) && $sesionIniciada == 1) {

            echo '<li><a href="http://verifyReviews.es/verifyreviews/cerrarSesion">Cerrar sesion</a></li>';
            echo '<li><a href="http://verifyReviews.es/verifyreviews/misResenas">Mis reseñas</a></li>';
            // echo '<li>Favoritos</li>';
            

        } else if(isset($sesionIniciada) && $sesionIniciada == 2){
            echo '<li><a href="http://verifyReviews.es/verifyreviews/cerrarSesion">Cerrar sesion</a></li>';
            echo '<li><a href="http://verifyReviews.es/verifyreviews/miNegocio">Mi negocio</a></li>';
            echo '<li><a href="http://verifyReviews.es/verifyreviews/generarResenas">Generar reseñas</a></li>';

        } else{

            echo '<li><a href="http://verifyReviews.es/verifyreviews/login">Iniciar sesion</a></li>';
            echo '<li><a href="http://verifyReviews.es/verifyreviews/nuevoNegocio">¿Eres un negocio?</a></li>';
            echo '<li><a href="http://verifyReviews.es/verifyreviews/nuevoUsuario">Regístrate</a></li>';

        }       
    ?>

</ul>


</div>



