    
    <?php 
        if (isset ($head_content)) echo $head_content;
    ?>
    <body >
                <!-- flecha flotante para subir arriba -->
        <div class="flechaArriba" style="display:none;">
            <i class="fas fa-arrow-up"></i>
        </div>
        <script>
            $(document).ready(function(){
                $(window).scroll(function(){
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
                $('.flechaArriba').click(function(){
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                    // return false;
                });
            });
        </script>
        <header id="header" class="header">

            <?php if (isset ($header_content)) echo $header_content; ?>
        
        </header>  

        <?php if (isset ($index_content)) { ?>

            <!-- para el carrousel de videos de la version escritorio  -->
            <section class="carousel_Categorias" id="carousel_cat_escritorio">
                <?php 
                if(isset($listaCategorias)){
                    foreach($listaCategorias as $i => $categoria){
                        echo '
                            <div class="videoContainer">
                                <a href="https://verifyreviews.es/verifyreviews/categoria?id='. $categoria -> getCodCategoria() .'">
                                    <video class="videoCat" autoplay loop muted playsinline>
                                        <source src="'. base_url()  . 'img/categorias/catM_V-'. $categoria -> getCodCategoria()  . '.mp4" type="video/mp4">
                                        <source src="'. base_url()  . 'img/categorias/catM_V-'. $categoria -> getCodCategoria()  . '.webm" type="video/webm">
                                        Tu navegador no soporta la etiqueta de video.
                                    </video>
                                </a>
                                <h5 class="tituloCat">'. $categoria -> getTipoNegocio()  . ' </h5>
                            </div>
                        ';
                    }
                }
                ?>
            </section>
        <?php
        } ?>

        <nav>
            <div class="filtros_container" >
                <button id="btn_filtros"><i class="fas fa-filter"></i> Filtros</button>
                <input type="text" placeholder="Buscar" id="buscar" value="">
                <i class="fas fa-search" id="buscar-icono"></i>
            </div>
            <div id="container_filtros" style="display:none;">  
            
                <div class="lista_filtros">

                    <div class="nombre_filtro">
                        <i class="fas fa-map-marker-alt"></i>
                        <h5>Ciudad</h5>
                    </div>
                    <div class="filtros">
                        <button class="opciones_filtro" value="1_soria">Soria</button>
                        <button class="opciones_filtro" value="1_madrid">Madrid</button>
                        <button class="opciones_filtro" value="1_barcelona">Barcelona</button>
                        <button class="opciones_filtro" value="1_valencia">Valencia</button>
                    </div>

                    <div class="nombre_filtro">
                        <i class="fas fa-map-marker-alt"></i>
                        <h5>Categoria</h5>
                    </div>
                    <div class="filtros">
                        <button class="opciones_filtro" value="2_1">Restaurantes</button>
                        <button class="opciones_filtro" value="2_2">Peluquerías</button>
                        <button class="opciones_filtro" value="2_3">Cafeterías</button>
                        <button class="opciones_filtro" value="2_4">Talleres</button>
                        <button class="opciones_filtro" value="2_5">Perfumerías</button>
                        <button class="opciones_filtro" value="2_6">Psicología</button>
                        <button class="opciones_filtro" value="2_7">Moda</button>
                    </div>

                    <div class="nombre_filtro">
                        <i class="fas fa-map-marker-alt"></i>
                        <h5>Valoración</h5>
                    </div>
                    <div class="filtros">
                        <button class="opciones_filtro" value="3_1">
                            <i class="fas fa-check check_filtro"></i>
                        </button>
                        <button class="opciones_filtro" value="3_2">
                            <i class="fas fa-check check_filtro"></i>
                            <i class="fas fa-check check_filtro"></i>
                        </button>
                        <button class="opciones_filtro" value="3_3">
                            <i class="fas fa-check check_filtro"></i>
                            <i class="fas fa-check check_filtro"></i>
                            <i class="fas fa-check check_filtro"></i>
                        </button>
                        <button class="opciones_filtro" value="3_4">
                            <i class="fas fa-check check_filtro"></i>
                            <i class="fas fa-check check_filtro"></i>
                            <i class="fas fa-check check_filtro"></i>
                            <i class="fas fa-check check_filtro"></i>
                        </button>
                        <button class="opciones_filtro" value="3_5">
                            <i class="fas fa-check check_filtro"></i>
                            <i class="fas fa-check check_filtro"></i>
                            <i class="fas fa-check check_filtro"></i>
                            <i class="fas fa-check check_filtro"></i>
                            <i class="fas fa-check check_filtro"></i>
                        </button>
                    </div>

                </div>

            </div>
            <div class="resultados_busqueda" style="display:none;">

                <!-- se mostraran los resultados de la busqueda y los filtros -->
                
            </div>
            
        </nav> 
         

        <script>
            $(document).ready(function() {
                $('#carousel_cat_escritorio').slick({
                    dots: true, // puntitos
                    slidesToShow: 1, // fotos que se pintan a la vez
                });

                var info_filtros = [];
                $('.opciones_filtro').click(function() {
                    const valor = $(this).val();
                    $(this).toggleClass("filtro_seleccionado");
                    const index = info_filtros.indexOf(valor);
                    if (index === -1) {
                        info_filtros.push(valor);
                    } else {
                        info_filtros.splice(index, 1);
                    }
                    console.log(info_filtros);
                });

                $("#btn_filtros").click(function(){
                    $("#container_filtros").toggle(500);
                });

                $('#buscar-icono').click(function() {
                    $("#cerrar_busqueda").toggle(500);
                    var texto = $('#buscar').val();
                    if(texto == ""){
                        texto = "false";
                    }
                    $.ajax({
                        url: 'https://verifyreviews.es/verifyreviews/filtro',
                        type: 'POST',
                        data: { texto: texto , filtros: JSON.stringify(info_filtros) },
                        success: function(response) {
                            $('.resultados_busqueda').html(response).show();
                        },
                        error: function(xhr, status, error) {
                            console.error('Error en la búsqueda:', error);
                        }
                    });
                });
            });
            
        </script>
        
        <main id="main" class="main">
            <!-- <p>
                <span style="font-weight: bold;">Aviso importante:</span><br>
                Esta página web ha sido creada exclusivamente con fines educativos. 
                Cualquier contenido presente en este sitio es para uso académico y no con propósitos comerciales o profesionales. Agradecemos tu comprensión y cooperación.
            </p> -->
            <!-- vista inicio de la web -->
            <?php if (isset ($index_content)) echo $index_content; ?> 

            <!-- vista  para registrar un negocio -->
            <?php if (isset ($nuevo_negocio)) echo $nuevo_negocio; ?>

            <!-- vista para registrar un usuario -->
            <?php if (isset ($nuevo_usuario)) echo $nuevo_usuario; ?>

            <!-- vista para inicio de sesion -->
            <?php if (isset ($login)) echo $login; ?>

            <!-- cuando el negocio pulsa "generar resenas" -->
            <?php if (isset ($generarResenas)) echo $generarResenas; ?>

            <!-- cuando el usuario escanea el codigo qr -->
            <?php if (isset ($resena_content)) echo $resena_content; ?>

            <!--  vista para pintar los negocios que pertenecen a una categoria -->
            <?php if (isset ($cont_categoria)) echo $cont_categoria; ?>
            

            <!--  vista para la informacion de un negocio en concreto -->
            <?php if (isset ($info_negocio)) echo $info_negocio; ?>
            

            <!--  vista para que el usuario_registrado vea las resenas que ha escrito -->
            <?php if (isset ($mis_resenas_usuario)) echo $mis_resenas_usuario; ?>
            

            <!--  vista para que el negocio vea sus reseñas y sus valoraciones -->
            <?php if (isset ($mi_negocio)) echo $mi_negocio; ?>

            <!--  vista para la confirmacion del correo electrónico -->
            <?php if (isset ($confirmacion_email)) echo $confirmacion_email; ?>

            <?php
            if (isset ($val))
                echo $val;
            ?>

            <br />
        </main>

        <div class="clearfix"></div>

        <footer>
            <!--  vista para que el negocio vea sus reseñas y sus valoraciones -->
            <?php if (isset ($vista_footer)) echo $vista_footer; ?>
        </footer>

    </body>

</html>