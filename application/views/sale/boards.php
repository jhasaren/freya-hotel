<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Freya, Hotel, Hostal, Gestion, Seguridad, Eficiencia, Calidad, Informacion, Reservas">
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
    <!-- Board Style -->
    <link href="<?php echo base_url().'public/gentelella/build/css/board.css'; ?>" rel="stylesheet">
    
    <link rel="shortcut icon" href="<?php echo base_url().'public/img/favicon.ico'; ?>">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed"> <!--menu_fixed-->
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
                        <h3>Habitaciones</h3>
                        <span class="label label-warning">
                            <a href="<?php echo base_url().'index.php/CSale/pendientespago'; ?>">Ver Cuentas x Cobrar</a>
                        </span>
                        <!--<span class="label label-info">
                            <a href="<?php //echo base_url().'index.php/CSale/resetconsecutivoturno'; ?>">Reiniciar Consecutivo Turno</a>
                        </span>-->
                        <br /><br />
                    </div>

                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <div></div>
                                <span class="input-group-btn">
                                    <a class="btn btn-info" href="<?php echo base_url().'index.php/CSale/boards/1'; ?>"><i class="glyphicon glyphicon-th-list"></i> Ver Lista</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel" style="background-color: transparent; border: none">
                            <div class="x_content">                                
                                <!--*******************SITIO***************************-->
                                <div class="row">
                                    <?php 
                                    if ($list_board['sitio'] != FALSE){
                                        foreach ($list_board['sitio'] as $row_list){
                                            if ($row_list['idEstadoMesa'] == 1){ /*ocupada*/
                                                
                                                $color = "#F3BEB5"; /*mesa ocupada en proceso pago - azul*/
                                                $flag = $row_list['idVenta'];
                                                $disabledBoard = "true";
                                                $ocupation = $row_list['descEstadoMesa'];
                                                $caracteristicas = $row_list['caracteristicas'];
                                                $reserva = $row_list['idReserva'];
                                                
                                            } else {
                                                
                                                if ($row_list['idEstadoMesa'] == 3){ /*proceso limpieza*/ 
                                                
                                                    $color = "#A8DFED"; /*mesa ocupada en pedido - azul*/
                                                    $flag = 0;
                                                    $disabledBoard = "true";
                                                    $ocupation = $row_list['descEstadoMesa'];
                                                    $caracteristicas = $row_list['caracteristicas'];
                                                    $reserva = 0;
                                                    
                                                } else {
                                                    
                                                    $color = "#CBEDA8"; /*mesa libre - verde*/
                                                    $flag = 0;
                                                    $disabledBoard = "false";
                                                    $ocupation = $row_list['descEstadoMesa'];
                                                    $caracteristicas = $row_list['caracteristicas'];
                                                    $reserva = 0;
                                                    
                                                }
                                            }
                                            ?>
                                            <div class="col-sm-2">
                                                <div class="do-item do-item-circle do-circle">
                                                    <!--http://placehold.it/261x261-->
                                                    <img src="<?php echo base_url().'public/img/261x261S.jpg'; ?>" class="do-item do-circle">
                                                    <div class="do-info-wrap do-circle" style="background-color: <?php echo $color; ?>">
                                                        <a href="<?php echo base_url().'index.php/CSale/createsale/'.$row_list['idMesa'].'/'.$flag."/".$reserva; ?>" onclick="return <?php echo $disabledBoard; ?>;" >
                                                            <div class="do-info">
                                                                <div class="do-info-front do-circle">
                                                                    <center>
                                                                        <h3 style="color: #000">
                                                                            <i class="fa fa-hotel fa-2x"></i><br />
                                                                            <?php echo $row_list['nombreMesa']; ?>
                                                                        </h3>
                                                                        <?php //echo $caracteristicas; ?>
                                                                    </center>
                                                                </div>
                                                                <div class="do-info-back do-circle">
                                                                    <h3><?php echo $ocupation; ?></h3>
                                                                    <div>
                                                                        <span class="label label-info">                        
                                                                            <?php echo $row_list['time']; ?>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <!--**********************************************-->
                                <hr />
                                <!--************************DOMICILIO**********************-->
                                
                                <!--**********************************************-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->
        
        <!-- footer content -->
        <?php 
        /*include*/
        //$this->load->view('includes/footer-bar');
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
    
    <!-- jQuery autocomplete -->
    <script src="<?php echo base_url().'public/gentelella/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js'; ?>"></script>
    <script>
    /*var clientes = [
        <?php // foreach ($list_user as $row_user) { ?>
            { value: '<?php // echo $row_user['nombre_usuario']." |".$row_user['idUsuario']; ?>' },
        <?php // } ?>
    ];

    $('#idcliente').autocomplete({
        lookup: clientes
    });*/
    
    /*Actualiza pagina cada 60 segundos*/
    /*setTimeout(function(){
       location.reload();
    },60000); */
    </script>
    
  </body>
</html>
