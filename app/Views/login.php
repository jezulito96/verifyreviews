

<div class="containerformLogin">
    <?php 
        $sesion = session() -> get("sesionIniciada");
        if(isset($sesion) && $sesion == 1 || isset($sesion) && $sesion == 2) {
            $usuario = session() -> get('usuario_en_sesion');
            echo '<h3 class="bien" style="padding:5px;">Bienvenido,</br> ' . $usuario['nombre'] . '</h3>';
        }else{
            echo '<h3>Login</h3>';
        }
    ?>
    
    <div class="div_span">
        <?php 
            if(isset($errorEmail)){
                echo '<p class="error">' . $errorEmail . '</p>';
            }
        ?>
    </div>
    <form action="setLogin" method="post" class="formLogin">
        <input type="email" name="email" placeholder="Email" class="inputs" required focus>
        <input type="password" name="contrasena" placeholder="Contraseña" class="inputs" required>
        <small>Recordar contraseña</small>
        <div class="botones_enviar">
            <input type="submit" value="Iniciar Sesión" class="btn_enviar">
            <a href="http://verifyReviews.es/verifyreviews/nuevoUsuario" style="text-align:center;" class="btn_enviar2">Regístrate</a>
        </div>
        
    </form>
    
</div>