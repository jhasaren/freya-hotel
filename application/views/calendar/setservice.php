<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Freya, Salon, Belleza, Gestion, Seguridad, Eficiencia, Calidad, Informacion">
    <meta name="author" content="Amadeus Soluciones">

    <title>Freya - Hotel</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url().'public/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css'; ?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url().'public/gentelella/vendors/font-awesome/css/font-awesome.min.css'; ?>" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url().'public/gentelella/vendors/nprogress/nprogress.css'; ?>" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?php echo base_url().'public/gentelella/build/css/custom.min.css'; ?>" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo base_url().'public/gentelella/vendors/iCheck/skins/flat/green.css'; ?>" rel="stylesheet">
    
    <link rel="shortcut icon" href="<?php echo base_url().'public/img/favicon.ico'; ?>">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
            <?php 
            /*include*/
            $this->load->view('includes/menu');
            ?>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <?php 
            /*include*/
            $this->load->view('includes/top');
            ?>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Reservas</h3>
                    </div>

                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <div></div>
                                <span class="input-group-btn">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <!--Alerta-->
                        <?php if ($alert == 1){ ?>
                            <div class="alert alert-info alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <?php echo $message; ?>
                            </div>
                        <?php } else if ($alert == 2){ ?>
                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>
                        <!--/Alerta-->
                        
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Habitaciones Disponibles</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="modal-body">
                                    <strong><?php echo $nombreSede; ?></strong><br /><br />
                                    <div class="row">
                                    <?php 
                                    if ($mensaje == NULL){
                                        
                                        if ($habitaciones != FALSE){
                                            
                                            if ($cantidadNoches == 0){
                                                $cantNoches = 1;
                                            } else {
                                                $cantNoches = $cantidadNoches;
                                            }

                                            foreach ($habitaciones as $row_list){

                                                if ($row_list['idMesa'] != NULL){
                                                                                                            
                                                    ?>                                    
                                                    <div class="col-md-6" style="height: 300px">
                                                        <div class="x_content" style="background-color: gainsboro">
                                                            <?php //echo $row_list['idMesa']; ?>           
                                                            
                                                            <table style="width: 100%; background-color: #89cbea; border-collapse: separate; border-spacing: 10px; border-radius: 10px 10px 10px 10px; -moz-border-radius: 10px 10px 10px 10px; -webkit-border-radius: 10px 10px 10px 10px; border: 0px solid #000000;">
                                                                <tr style="border-collapse: separate; border-spacing: 10px;">
                                                                    <td>
                                                                        <span style="font-size: 25px; font-weight: bold; color: #000"><?php echo $row_list['nombreMesa']; ?></span>
                                                                        <a href="#" data-rel="<?php echo $row_list['idMesa']; ?>" data-rel2="<?php echo $row_list['nombreMesa']; ?>" data-rel3="<?php echo $this->config->item('url_img'); ?>" class="btn-verhabitacion">
                                                                            <span class="label label-primary">Ver Fotos</span>
                                                                        </a>
                                                                        <span style="float: right">
                                                                            <?php echo "$".number_format(($row_list['valorNoche']*$cantNoches),0,",",".")." Por ". $cantNoches ." Noche(s)"; ?>
                                                                            <a href="#" data-rel="<?php echo $row_list['idMesa']; ?>" data-rel2="<?php echo $row_list['nombreMesa']; ?>" data-rel3="<?php echo ($row_list['valorNoche']*$cantNoches); ?>" data-rel4="<?php echo $cantNoches; ?>" data-rel5="<?php echo $periodo_desde; ?>" data-rel6="<?php echo $periodo_hasta; ?>" class="btn-regreserv">
                                                                                <span class="label label-danger">Reservar</span>
                                                                            </a>
                                                                            
                                                                        </span>
                                                                        <br /><br />
                                                                    </td>
                                                                </tr>	
                                                            </table>
                                                            <br /><br />
                                                            <div class="col-md-12 col-sm-12 col-xs-12" style="">
                                                                <?php echo $row_list['caracteristicas']."<br /><br />"; ?>
                                                            </div>
                                                            
                                                            <center>
                                                            <div class="label label-warning">
                                                                <?php echo "Adultos: ".$row_list['cantAdulto']; ?>
                                                            </div>
                                                            <div class="label label-success">
                                                                <?php echo "Niños: ".$row_list['cantNino']; ?>
                                                            </div>
                                                            </center>

                                                            <div class="well well-sm" style="text-align: center">
                                                                <?php echo "Desde ".$periodo_desde." Hasta ".$periodo_hasta; ?>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <?php
                                                    
                                                }

                                            }
                                            
                                        }
                                        
                                    } else {
                                        
                                        echo $mensaje;
                                        
                                    }
                                    ?>
                                    </div>  
                                </div>     
                            </div>
                        </div>
                        
                        <center>
                            <a href="<?php echo base_url() . 'index.php/CCalendar'; ?>" class="btn btn-warning btn-lg">
                                <i class="glyphicon glyphicon-remove-sign glyphicon-white"></i> Regresar
                            </a>
                        </center>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->
        
        <!--Modal - Reservar-->
        <div class="modal fade" id="myModal-reserv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-reserv" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_reserv" action="<?php echo base_url() . 'index.php/CCalendar/addevent'; ?>" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Registrar Reserva</h3>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="TipoDoc">Tipo de Documento</label>
                                <select class="form-control" name="typedoc">
                                    <?php
                                    foreach ($list_document as $row) {
                                        ?>
                                        <option value="<?php echo $row['idTipoDocumento']; ?>"><?php echo $row['descDocumento']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" id="identificacion" name="identificacion" placeholder="Nro de Identificacion" autocomplete="Off" required="">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="nameclient" name="nameclient" placeholder="Nombres" autocomplete="Off" required="">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="lastnameclient" name="lastnameclient" placeholder="Apellidos" autocomplete="Off" required="">
                            </div>
                            <div class="form-group">
                                <label for="datoscontacto">Datos de Contacto</label>
                                <input type="text" class="form-control" id="celular" name="celular" placeholder="Telefono Celular" autocomplete="Off" required="" >
                                <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electronico" autocomplete="Off" required="" >
                            </div>
                            
                            <input type="hidden" class="form-control" id="habitacion" name="habitacion">
                            <input type="hidden" class="form-control" id="noches_reserva" name="noches_reserva">
                            <input type="hidden" class="form-control" id="valor_reserva" name="valor_reserva">
                            <input type="hidden" class="form-control" id="sede" name="sede" value="<?php echo $sede; ?>">
                            <input type="hidden" class="form-control" id="desde" name="desde">
                            <input type="hidden" class="form-control" id="hasta" name="hasta">
                            <input type="hidden" class="form-control" id="adultos" name="adultos" value="<?php echo $adultoCount; ?>" >
                            <input type="hidden" class="form-control" id="ninos" name="ninos" value="<?php echo $ninoCount; ?>">
                            
                            <div class="alert alert-success" role="alert">
                                <B>Habitacion:</B> <span id="texto_habitacion" style="font-size: 18px; color: #000"></span><br />                  
                                <B>Valor Total:</B> $ <span id="texto_valor_total" style="font-size: 18px; color: #000"></span><br />  
                                <B>Cantidad Noches:</B> <span id="texto_nocreserva" style="font-size: 18px; color: #000"></span><br />
                                <B>Desde:</B> <span id="texto_desde" style="font-size: 18px; color: #000"></span> 
                                <B>Hasta:</B> <span id="texto_hasta" style="font-size: 18px; color: #000"></span><br />
                                <B>Adultos:</B> <span id="texto_adulto" style="font-size: 18px; color: #000"><?php echo $adultoCount; ?></span> 
                                <B>Niños:</B> <span id="texto_nino" style="font-size: 18px; color: #000"><?php echo $ninoCount; ?></span>
                            </div>
                            
                            <label>
                                <input type="checkbox" class="flat" name="huesped_principal" required="">
                                Acepto Términos y Condiciones 
                                <a href="#" class="btn-terms" style="color: #38b393">
                                    [LEER]
                                </a>
                            </label>
                            
                            <br />
                            
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" class="btn btn-success">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--End modal Reservar-->
        
        <!--Modal - Imagenes Habitacion-->
        <div class="modal fade" id="myModal-imghabit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-imghabit" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h3><span id="name_habitacion" style="font-size: 18px; color: #000"></span></h3>
                    </div>
                    <div class="modal-body">
                        <?php
                        for ($i = 1; $i <= 5; $i++){
                            ?>
                            <picture>
                                <img id="imagen<?php echo $i; ?>" src="" class="img-fluid img-thumbnail" alt="Habitacion">
                            </picture>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>
        <!--End modal Imagenes Habitacion-->
        
        <!--Modal - Terminos y condiciones reserva -->
        <div class="modal fade" id="myModal-terms" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-terms" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_terms" action="<?php echo base_url() . 'index.php/CSale/adduser/cliente'; ?>" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Términos y Condiciones</h3>
                        </div>
                        <div class="modal-body" style="text-align: justify">
                            * En caso tal, la reserva se debera cancelar como minimo con 4 horas de anticpación.<br /><br />
                            
                            <B>POLITICA DE DATOS</B><br /><br />
                            Información que nos proporcionas. HOTEL puede pedirte que proporciones información personal cuando solicites un Pedido de un Producto en el Sitio Web. Por ejemplo, solicitamos información personal relacionada con tus datos de identificación (nombres, apellidos, dirección de envió, dirección de correo electrónico, ciudad, departamento, teléfono, identificación y la prescripcion médica de tu formúla expedida por tú optómetra u oftalmólogo).
                            <br /><br />
                            Información que obtenemos del uso que haces de nuestros servicios. Recolectamos información relacionada con el servicio que ofrecemos. Entre la información obtenida de esta forma, se incluyen los siguientes datos: la dirección IP y Pais. Corresponde igualmente a información relacionada con tus transacciones a través de HOTEL.
                            <br /><br />
                            La información que identifica y particulariza a una persona física o que permite ponerse en contacto con ella, como por ejemplo, el nombre, el teléfono, la dirección, correo electrónico, entre otros, tiene el carácter de personal. Esa información es de propiedad exclusiva de esa persona. La información que se registra de forma tal que no refleja ni hace referencia a una persona física en particular, permitiendo su identificación de forma individual, como por ejemplo la relacionada con la reserva, alojamiento, la adquisición de un determinado bien, servicio o producto, el medio de pago, el banco utilizado, entre otros, no tienen el carácter de información personal.
                            <br /><br />
                            Para las finalidades descritas en esta Política, HOTEL puede recolectar, usar, almacenar y proteger tu información personal, entre la que se incluye, la siguiente:
                            <br /><br />
                            Información de identificación (por ejemplo, nombre, domicilio, número de teléfono fijo o móvil, dirección de correo electrónico, identificacion, fecha de nacimiento).
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--End Terminos y Condiciones Reserva-->

        <!-- footer content -->
        <?php 
        /*include*/
        $this->load->view('includes/footer-bar');
        ?>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url().'public/gentelella/vendors/jquery/dist/jquery.min.js'; ?>"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url().'public/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js'; ?>"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url().'public/gentelella/vendors/fastclick/lib/fastclick.js'; ?>"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url().'public/gentelella/vendors/nprogress/nprogress.js'; ?>"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url().'public/gentelella/build/js/custom.js'; ?>"></script><!--Minificar-->  
    <!-- iCheck -->
    <script src="<?php echo base_url().'public/gentelella/vendors/iCheck/icheck.min.js'; ?>"></script>
        
  </body>
</html>
