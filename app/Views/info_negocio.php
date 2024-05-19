<?php
    if(isset($negocio)){
        ?>
        <div class="containerTitulo" >
            <?php  
                echo $negocio -> getNombre(). "<i class='far fa-heart icono-corazon'></i>";
            ?>
        </div>
        
        <?php

        echo '<div class="fotosContainerNegocio">';

            // recojo las rutas de las fotos y las pinto 
            $foto_principal = $negocio -> getFotoPrincipal();
            echo '<div class="fotoContainer" style="margin-left:15px;">';
                echo '<a class="fotoContainer"  href="https://verifyreviews.es/verifyreviews/negocio?id='. $negocio -> getCodNegocio() . '" >';
                    echo '<img src="'. base_url(). $foto_principal .'" alt="'. $negocio -> getNombre() .'" title="'. $negocio -> getNombre() .'"/>';
                echo '</a>';
            echo '</div>';


            $rutasimgs = $negocio -> getFotosBD();
            $imagenes = explode(",", $rutasimgs);
            foreach($imagenes as $key => $valor){
            $rutaImagen = base_url().'/images/n/n_'.$negocio -> getCodNegocio().'/img_negocio/'.  $valor ;
            //    echo "<p color='red'>" .base_url(). $valor ."</p>";
                echo '<div class="fotoContainer" >';
                    echo '<a class="fotoContainer"  href="https://verifyreviews.es/verifyreviews/negocio?id='. $negocio -> getCodNegocio() . '" >';
                        echo '<img src="' . $rutaImagen . '" alt="'. $negocio -> getNombre() .'" title="'. $negocio -> getNombre() .'"/>';
                    echo '</a>';
                echo '</div>';
            }
            
        echo '</div>';
    } 
?>

    <div class="sliderInfoNegocio">

        <div class="containerIcono container_opiniones">
            <i class="fas fa-comment iconosColor"></i>
            <span id="opiniones">Opiniones</span>
        </div>
        <div class="containerIcono container_mapa">
            <i class="fas fa-map-marked-alt iconosColor"></i>
            <span id="mapa">Mapa</span>
        </div>
        <div class="containerIcono container_llamar">
            <i class="fas fa-phone iconosColor"></i>
            <span id="llamar">Llamar</span>
        </div>

        <div class="containerIcono container_email">
            <i class="fas fa-envelope iconosColor"></i>
            <span id="email">Email</span>
        </div>
        <div class="containerIcono container_redesSociales">
            <i class="fas fa-share-alt iconosColor"></i>
            <span id="redesSociales">Redes</span>
        </div>

    </div>
    
    <div class="infoContainerNegocio">

        <div id="content_opiniones">
            <h3>
                Opiniones
            </h3>    
            <?php
            echo '<div class="container_opiniones_info">';
                foreach($lista_resenas as $i => $resena){
                        
                    echo '<div class="info_opiniones" >';

                        echo '<div class="head_opinion">';
                            // imagen de usuario
                            echo '<div class="nick_opinion">';
                                echo '<i class="fas fa-map-marked-alt iconosColor"></i>';
                                echo $resena -> getNickname();
                            echo '</div>';
                            
                            echo '<div class="resultado_opinion">';
                                // NOTA MEDIA DE LAS RESEÑAS DEL NEGOCIO

                                echo '<i class="fas fa-map-marked-alt iconosColor"></i>';
                                // imagen de check del logo
                                echo '<div class="nota_media">4,2</div>';

                            echo '</div>';

                        echo '</div>';

                        $fecha = $resena -> getFechaServicio();
                        echo '<div class="fecha_opinion">'. substr($fecha, 0, 10) . '</div>';
                        
                        echo '<div class="titulo_opinion">';
                            // TITULO DE LA RESEÑA
                            echo $resena -> getTitulo();                            

                        echo '</div>';

                        echo '<div class="menu_opinion">';
                            // btn_imagenes    |  btn_ opinion
                            $es_disabled = "";
                            if($resena -> getFotos() != false){
                                $es_disabled = 'btn_opinion1';
                            }
                            echo '<div id="' . $resena-> getCodResena() . '" class="' . $es_disabled . '" >Imágenes</div>';
                            echo '<div id="' . $resena-> getCodResena() . '" class="btn_opinion2" >Opinión</div>';

                        echo '</div>';

                        echo '<div id="popup_' . $resena-> getCodResena() . '" class="popup">';
                            echo '<div id="contenido_popup_' . $resena-> getCodResena() . '" class="contenido_popup" >';
                                echo '<span class="boton_cerrar_' . $resena-> getCodResena() . '">&times;</span>';
                                echo '<div id="informacion_popup_"' . $resena-> getCodResena() . '" >';
                                    // echo $resena -> getFotos(); 
                                    
                                    $rutasimgs = $resena -> getFotos();
                                    $imagenes = explode(",", $rutasimgs);
                                    foreach($imagenes as $key => $valor){
                                        $rutaImagen = base_url().'/images/n/' . $valor;
                                        echo '<img class="imgs_resenas" src="' . $rutaImagen . '" alt="'. $negocio -> getNombre() .'" />';
                                    }
                                    
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';

                        echo '<div id="popup2_' . $resena-> getCodResena() . '" class="popup2">';
                            echo '<div id="contenido_popup2_' . $resena-> getCodResena() . '" class="contenido_popup2" >';
                                echo '<span class="boton_cerrar2_' . $resena-> getCodResena() . '" >&times;</span>';
                                echo '<div id="informacion_popup2_' . $resena-> getCodResena() . '" >';
                                    echo $resena -> getOpinion(); 
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';

                    echo '</div>';

                }
            echo '</div>';

            ?>
        </div>
<script>
    $(document).ready(function () {
        
        // -------------    Para los botones de las reseñas fotos y opinion     -------------------
        $(".btn_opinion1").click(function() {
            
                var id = $(this).attr('id');
                var $popup = $("#popup_" + id);
                var $boton_cerrar = $(".boton_cerrar_" + id);

                $popup.css("display", "flex");

                $boton_cerrar.click(function() {
                $popup.css("display", "none");
                });

                $(window).click(function (evento) {
                    if ($(evento.target).is($popup)) {
                        $popup.css("display", "none");
                    }
                });
        });


        $(".btn_opinion2").click(function() {
            var id = $(this).attr('id');

            var $popup2 = $("#popup2_" + id );
            var $boton_cerrar2 = $(".boton_cerrar2_" + id);

            $popup2.css("display", "flex");
           
            $boton_cerrar2.click(function () {
                $popup2.css("display", "none");
            });

            $(window).click(function (evento) {
                if ($(evento.target).is($popup2)) {
                    $popup2.css("display", "none");
                }
            });

        });


    });
</script>
        <div id="content_mapa">
            <h3>
                Mapa
            </h3>   
            <div id="info_opiniones">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eu erat ornare, maximus arcu sit amet, lacinia eros. Vivamus porta sem lectus, et vulputate lectus malesuada sit amet. Ut imperdiet condimentum ornare. Aenean id porttitor lorem. In lectus ipsum, porta id eros eget, congue tempus purus. Duis ut maximus lorem, ut semper sapien. Etiam dignissim bibendum tellus, consequat aliquam justo. Duis arcu felis, placerat vitae molestie eu, efficitur eget nisl. Mauris scelerisque nec enim sed elementum. Nam quis volutpat enim.

            Aenean at quam malesuada ipsum viverra tristique. Phasellus erat lacus, imperdiet vitae libero eget, efficitur eleifend enim. Aenean et tristique metus. Maecenas id tortor eu risus pretium ornare. Integer eu ornare lacus, sed maximus odio. Integer id magna metus. Sed elementum, lorem nec gravida viverra, libero massa elementum sapien, vitae maximus risus ante ac sem. In a efficitur magna. Phasellus feugiat libero ipsum. Aliquam interdum sollicitudin fermentum. Praesent sit amet nunc turpis. Nulla cursus non est vel scelerisque. Suspendisse accumsan massa eu aliquam ornare. Nullam vel orci faucibus, volutpat leo eget, varius sem. In vitae sagittis lacus, non commodo mi. Quisque velit risus, tincidunt a porttitor ac, imperdiet vel dui. 
            </div> 
        </div>

        <div id="content_llamar">
            <h3>
                Llamar
            </h3>    
            <div id="info_llamar">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eu erat ornare, maximus arcu sit amet, lacinia eros. Vivamus porta sem lectus, et vulputate lectus malesuada sit amet. Ut imperdiet condimentum ornare. Aenean id porttitor lorem. In lectus ipsum, porta id eros eget, congue tempus purus. Duis ut maximus lorem, ut semper sapien. Etiam dignissim bibendum tellus, consequat aliquam justo. Duis arcu felis, placerat vitae molestie eu, efficitur eget nisl. Mauris scelerisque nec enim sed elementum. Nam quis volutpat enim.

            Aenean at quam malesuada ipsum viverra tristique. Phasellus erat lacus, imperdiet vitae libero eget, efficitur eleifend enim. Aenean et tristique metus. Maecenas id tortor eu risus pretium ornare. Integer eu ornare lacus, sed maximus odio. Integer id magna metus. Sed elementum, lorem nec gravida viverra, libero massa elementum sapien, vitae maximus risus ante ac sem. In a efficitur magna. Phasellus feugiat libero ipsum. Aliquam interdum sollicitudin fermentum. Praesent sit amet nunc turpis. Nulla cursus non est vel scelerisque. Suspendisse accumsan massa eu aliquam ornare. Nullam vel orci faucibus, volutpat leo eget, varius sem. In vitae sagittis lacus, non commodo mi. Quisque velit risus, tincidunt a porttitor ac, imperdiet vel dui. 
            </div>
        </div>

        <div id="content_email">
            <h3>
                Email
            </h3>   
            <div id="info">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eu erat ornare, maximus arcu sit amet, lacinia eros. Vivamus porta sem lectus, et vulputate lectus malesuada sit amet. Ut imperdiet condimentum ornare. Aenean id porttitor lorem. In lectus ipsum, porta id eros eget, congue tempus purus. Duis ut maximus lorem, ut semper sapien. Etiam dignissim bibendum tellus, consequat aliquam justo. Duis arcu felis, placerat vitae molestie eu, efficitur eget nisl. Mauris scelerisque nec enim sed elementum. Nam quis volutpat enim.

            Aenean at quam malesuada ipsum viverra tristique. Phasellus erat lacus, imperdiet vitae libero eget, efficitur eleifend enim. Aenean et tristique metus. Maecenas id tortor eu risus pretium ornare. Integer eu ornare lacus, sed maximus odio. Integer id magna metus. Sed elementum, lorem nec gravida viverra, libero massa elementum sapien, vitae maximus risus ante ac sem. In a efficitur magna. Phasellus feugiat libero ipsum. Aliquam interdum sollicitudin fermentum. Praesent sit amet nunc turpis. Nulla cursus non est vel scelerisque. Suspendisse accumsan massa eu aliquam ornare. Nullam vel orci faucibus, volutpat leo eget, varius sem. In vitae sagittis lacus, non commodo mi. Quisque velit risus, tincidunt a porttitor ac, imperdiet vel dui. 
            </div> 
        </div>

        <div id="content_redesSociales">
            <div id="Facebook">
                <h3>
                    Facebook
                </h3>    
                <div id="info">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eu erat ornare, maximus arcu sit amet, lacinia eros. Vivamus porta sem lectus, et vulputate lectus malesuada sit amet. Ut imperdiet condimentum ornare. Aenean id porttitor lorem. In lectus ipsum, porta id eros eget, congue tempus purus. Duis ut maximus lorem, ut semper sapien. Etiam dignissim bibendum tellus, consequat aliquam justo. Duis arcu felis, placerat vitae molestie eu, efficitur eget nisl. Mauris scelerisque nec enim sed elementum. Nam quis volutpat enim.

                Aenean at quam malesuada ipsum viverra tristique. Phasellus erat lacus, imperdiet vitae libero eget, efficitur eleifend enim. Aenean et tristique metus. Maecenas id tortor eu risus pretium ornare. Integer eu ornare lacus, sed maximus odio. Integer id magna metus. Sed elementum, lorem nec gravida viverra, libero massa elementum sapien, vitae maximus risus ante ac sem. In a efficitur magna. Phasellus feugiat libero ipsum. Aliquam interdum sollicitudin fermentum. Praesent sit amet nunc turpis. Nulla cursus non est vel scelerisque. Suspendisse accumsan massa eu aliquam ornare. Nullam vel orci faucibus, volutpat leo eget, varius sem. In vitae sagittis lacus, non commodo mi. Quisque velit risus, tincidunt a porttitor ac, imperdiet vel dui. 
                </div>
            </div>

            <div id="x">
                <h3>
                    X
                </h3>   
                <div id="info">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eu erat ornare, maximus arcu sit amet, lacinia eros. Vivamus porta sem lectus, et vulputate lectus malesuada sit amet. Ut imperdiet condimentum ornare. Aenean id porttitor lorem. In lectus ipsum, porta id eros eget, congue tempus purus. Duis ut maximus lorem, ut semper sapien. Etiam dignissim bibendum tellus, consequat aliquam justo. Duis arcu felis, placerat vitae molestie eu, efficitur eget nisl. Mauris scelerisque nec enim sed elementum. Nam quis volutpat enim.

                Aenean at quam malesuada ipsum viverra tristique. Phasellus erat lacus, imperdiet vitae libero eget, efficitur eleifend enim. Aenean et tristique metus. Maecenas id tortor eu risus pretium ornare. Integer eu ornare lacus, sed maximus odio. Integer id magna metus. Sed elementum, lorem nec gravida viverra, libero massa elementum sapien, vitae maximus risus ante ac sem. In a efficitur magna. Phasellus feugiat libero ipsum. Aliquam interdum sollicitudin fermentum. Praesent sit amet nunc turpis. Nulla cursus non est vel scelerisque. Suspendisse accumsan massa eu aliquam ornare. Nullam vel orci faucibus, volutpat leo eget, varius sem. In vitae sagittis lacus, non commodo mi. Quisque velit risus, tincidunt a porttitor ac, imperdiet vel dui. 
                </div> 
            </div>

            <div id="instagram">
                <h3>
                    Instagram
                </h3> 
                <div id="info">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eu erat ornare, maximus arcu sit amet, lacinia eros. Vivamus porta sem lectus, et vulputate lectus malesuada sit amet. Ut imperdiet condimentum ornare. Aenean id porttitor lorem. In lectus ipsum, porta id eros eget, congue tempus purus. Duis ut maximus lorem, ut semper sapien. Etiam dignissim bibendum tellus, consequat aliquam justo. Duis arcu felis, placerat vitae molestie eu, efficitur eget nisl. Mauris scelerisque nec enim sed elementum. Nam quis volutpat enim.

                Aenean at quam malesuada ipsum viverra tristique. Phasellus erat lacus, imperdiet vitae libero eget, efficitur eleifend enim. Aenean et tristique metus. Maecenas id tortor eu risus pretium ornare. Integer eu ornare lacus, sed maximus odio. Integer id magna metus. Sed elementum, lorem nec gravida viverra, libero massa elementum sapien, vitae maximus risus ante ac sem. In a efficitur magna. Phasellus feugiat libero ipsum. Aliquam interdum sollicitudin fermentum. Praesent sit amet nunc turpis. Nulla cursus non est vel scelerisque. Suspendisse accumsan massa eu aliquam ornare. Nullam vel orci faucibus, volutpat leo eget, varius sem. In vitae sagittis lacus, non commodo mi. Quisque velit risus, tincidunt a porttitor ac, imperdiet vel dui. 
                </div>   
            </div>
            
        </div>


    </div>

    <div class="flechaArriba" style="display:none;">
        <i class="fas fa-arrow-up"></i>
    </div>

<script>
    $(document).ready(function(){
        $('.container_opiniones').click(function(){
            $('html, body').animate({
                scrollTop: $('#content_opiniones').offset().top
            }, 1000);
        });

        $('.container_mapa').click(function(){
            $('html, body').animate({
                scrollTop: $('#content_mapa').offset().top
            }, 1000);
        });

        $('.container_llamar').click(function(){
            $('html, body').animate({
                scrollTop: $('#content_llamar').offset().top
            }, 1000);
        });

        $('.container_email').click(function(){
            $('html, body').animate({
                scrollTop: $('#content_email').offset().top
            }, 1000);
        });

        $('.container_redesSociales').click(function(){
            $('html, body').animate({
                scrollTop: $('#content_redesSociales').offset().top
            }, 1000);
        });

        $('.flechaArriba').click(function() {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            return false;
        });
        
        $(window).scroll(function() {
            var alturaTotal = $(document).height();
            var alturaPantalla = $(window).height();
            var scroll = $(window).scrollTop();

            // console.log("altura total" + alturaTotal);
            // console.log("altura pant" + alturaPantalla);
            // console.log("scrol" + scroll);

            if (scroll + 100 <= alturaPantalla) {
                $('.flechaArriba').hide();
            } else {
                $('.flechaArriba').show();
            }
        });
    });
</script>