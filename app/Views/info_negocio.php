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
                                echo '<div class="informacion_popup" id="informacion_popup_' . $resena-> getCodResena() . '" >';
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
                                echo '<div  id="informacion_popup2_' . $resena-> getCodResena() . '" >';
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

        // PINTAR EL Mapa  info_mapa
        var latitud = $("#latitud").val();
        var longitud = $("#longitud").val();
        var nombre_negocio_mapa = $('#nombre_necogio_mapa').val();

        var mapa = L.map('info_mapa').setView([latitud, longitud], 16);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mapa);

        L.marker([latitud, longitud]).addTo(mapa)
            .bindPopup(nombre_negocio_mapa) 
            .openPopup();
        

    });
</script>
        <div id="content_mapa">
            <div class="head_mapa">
                <div class="icono_mapa">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="calle_mapa">
                    <?php echo $negocio -> getCalle() . ", " . $negocio -> getCiudad() . ", " . $negocio -> getPais(); ?> 
                </div>
            </div>

            <div id="info_mapa" class="info_mapa" >
                <?php
                    $coordenadas = $negocio -> getCoordenadas();
                    if($coordenadas == null ||  empty($coordenadas)){
                        echo "Upss hemos tenido un problema con el mapa, en estos  momentos no es posible dar la ubicacion,perdone las molestias";
                    }else{
                        $coord = explode(",", $coordenadas);

                        echo '<input type="hidden" value="'. $coord[0] . '" id="latitud" />';
                        echo '<input type="hidden" value="'. $coord[1] . '" id="longitud" />';
                        echo '<input type="hidden" value="'. $negocio -> getNombre() . '" id="nombre_necogio_mapa" />';

                    }

                ?>
                
            </div> 
        </div>

        <div id="content_llamar">
            <div class="icono_llamar">
                <i class="fas fa-phone iconosColor"></i>
            </div>
                
            <div id="telefono_llamar">
                    <a href="tel:<?php echo $negocio -> getTelefonoNegocio(); ?>" ><?php echo $negocio -> getTelefonoNegocio(); ?></a>
            </div>
        </div>

        <div id="content_email">
            <div class="icono_mail">
                <i class="fas fa-envelope iconosColor"></i>
            </div>
                
            <div id="mail_mail">
                <a href="mailto:<?php echo $negocio -> getEmail() ?>"><?php echo $negocio -> getEmail() ?></a>
            </div>
        </div>

        <div id="content_redesSociales">
            <div class="info_redes">
                <a href="https://twitter.com" target="_blank" rel="noopener noreferrer">
                    <i class="fab fa-twitter iconos_redes"></i>
                </a>
                
                <a href="https://facebook.com" target="_blank" rel="noopener noreferrer">
                    <i class="fab fa-facebook-f iconos_redes"></i>
                </a>
                
                <a href="https://instagram.com" target="_blank" rel="noopener noreferrer">
                    <i class="fab fa-instagram iconosColor"></i>
                </a>
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