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

                                    <?php 
                                    if ($mensaje == NULL){
                                        
                                        if ($habitaciones != FALSE){

                                            foreach ($habitaciones as $row_list){

                                                if ($row_list['idMesa'] != NULL){
                                                    
                                                    if (($adultoCount <= $row_list['cantAdulto']) && ($ninoCount <= $row_list['cantNino'])){
                                                        
                                                        ?>
                                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                                            <a href="#" data-rel="<?php echo $row_list['idMesa']; ?>" class="x_content btn-regreserv" style="background-color: gainsboro">
                                                                <?php //echo $row_list['idMesa']; ?>
                                                                <div class="alert alert-success" role="alert">
                                                                    <?php echo "HABITACION: ".$row_list['nombreMesa']; ?>
                                                                    <span style="padding-left: 35%"><?php echo "$".number_format($row_list['valorNoche'],0,",","."); ?></span>
                                                                    <div align="right" style="font-size: 8px"><?php echo "Por Noche"; ?></div>
                                                                </div>
                                                                
                                                                <?php echo $row_list['caracteristicas']."<br /><br />"; ?>
                                                                
                                                                <center>
                                                                <span class="label label-warning">
                                                                    <?php echo "Adultos: ".$row_list['cantAdulto']; ?>
                                                                </span>
                                                                <span class="label label-success">
                                                                    <?php echo "Niños: ".$row_list['cantNino']; ?>
                                                                </span>
                                                                </center>
                                                                
                                                                <div class="well well-sm" style="text-align: center">
                                                                    <?php echo $periodo; ?>
                                                                </div>
                                                                
                                                            </a>
                                                        </div>
                                                        <?php
                                                        
                                                    } 
                                                    
                                                }

                                            }
                                            
                                        }
                                        
                                    } else {
                                        
                                        echo $mensaje;
                                        
                                    }
                                    ?>
                                    <br />
                                </div>     
                            </div>
                            <center>
                                <a href="<?php echo base_url() . 'index.php/CCalendar'; ?>" class="btn btn-primary btn-lg">
                                    <i class="glyphicon glyphicon-remove-sign glyphicon-white"></i> Cancelar
                                </a>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->
        
        <!--Modal - Reservar-->
        <div class="modal fade" id="myModal-reserv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-reserv" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_reserv" action="<?php echo base_url() . 'index.php/CCalendar/deletedetailsale'; ?>" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Registrar Reserva</h3>
                        </div>
                        <div class="modal-body">
                            <label class="control-label" for="habitacion">Habitacion</label>
                            <input type="text" class="form-control" id="habitacion" name="habitacion" required="">
                            <br />
                            <input type="hidden" class="form-control" id="idregdetalle" name="idregdetalle">
                            <input type="hidden" class="form-control" id="typereg" name="typereg">
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" class="btn btn-primary">Eliminar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--End modal Reservar-->

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
        
  </body>
</html>
