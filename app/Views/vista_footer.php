<div class="footer">
    <div class="container_logo_footer">
        <img src="<?php echo base_url() ?>img/logoMovil_2.png" alt="Logotipo" class="logo1">
        <img src="<?php echo base_url() ?>img/logotipo3.png" alt="Logotipo" class="logo2">
    </div>
    

    <ul class="listaMenu_footer">
        <?php
            $sesionIniciada = session() -> get("sesionIniciada");
            if(isset($sesionIniciada) && $sesionIniciada == 1) {

                echo '<li><a href="http://verifyReviews.es/verifyreviews/cerrarSesion">Cerrar sesion</a></li>';
                echo '<li><a href="http://verifyReviews.es/verifyreviews/misResenas">Mis reseñas</a></li>';
                echo '<li>Favoritos</li>';
                

            } else if(isset($sesionIniciada) && $sesionIniciada == 2){
                echo '<li><a href="http://verifyReviews.es/verifyreviews/cerrarSesion">Cerrar sesion</a></li>';
                echo '<li><a href="http://verifyReviews.es/verifyreviews/miNegocio">Mi negocio</a></li>';
                echo '<li><a href="http://verifyReviews.es/verifyreviews/generarResenas">Generar reseñas</a></li>';

            } else{

                echo '<li><a href="http://verifyReviews.es/verifyreviews/login">Iniciar sesion</a></li>';
                echo '<li><a href="http://verifyReviews.es/verifyreviews/nuevoNegocio">¿Eres un negocio?</a></li>';
                echo '<li><a href="http://verifyReviews.es/verifyreviews/nuevoUsuario">Registrate</a></li>';

            }       
        ?>
    </ul>   

    <div class="social">
        <a href="https://www.facebook.com" target="_blank">      
            <i class="fa-brands fa-square-x-twitter"></i>
            <p>X</p>
        </a>
        <a href="https://www.twitter.com" target="_blank">
            <i class="fab fa-facebook-f "></i>
            <p>Facebook</p>
        </a>
        <a href="https://www.instagram.com" target="_blank">
            <i class="fab fa-instagram " ></i>
            <p>Instagram</p>
        </a>
    </div>
    
    <p>&copy; 2024 Verify Reviews. Proyecto de DAW 2024.</p>
        
</div>



