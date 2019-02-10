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
    <link href="<?php echo base_url().'public/gentelella/build/css/custom.res.css'; ?>" rel="stylesheet">
    <!-- Form Style -->
    <link href="<?php echo base_url().'public/contactform/css/main.css'; ?>" rel="stylesheet">
    
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url().'public/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css'; ?>" rel="stylesheet">
    
    <link rel="shortcut icon" href="<?php echo base_url().'public/img/favicon.ico'; ?>">
  </head>

  <body class="nav-md">
      <div class="container body" style="background: #e7ed3f">
      <div class="main_container">
        <!--<div class="col-md-3 left_col">-->
            <?php 
            /*include*/
            //$this->load->view('includes/menu');
            ?>
        <!--</div>-->

        <!-- top navigation -->
        <!--<div class="top_nav">-->
            <?php 
            /*include*/
            //$this->load->view('includes/top');
            ?>
        <!--</div>-->
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3 style="color: #FFF"><?php echo $this->config->item('namebussines'); ?></h3>
                    </div>

                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <div></div>
                                <span class="input-group-btn">
<!--                                    <span class="input-group-btn">
                                        <a class="btn btn-info" href="<?php // echo base_url().'index.php/CCalendar/listevent/sede'; ?>"><i class="glyphicon glyphicon-th"></i> Ver Reservas</a>
                                    </span>-->
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
                            <div class="alert alert-success alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                Recuerde: 
                                Si desea cancelar su reserva debe realizarlo minimo con 4 horas de anticipación.
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
                                <h2>Reservar Habitación</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form role="form" name="form_entidad" action="<?php echo base_url().'index.php/CReservas/servicesede'; ?>" method="post">
                                    <div class="modal-body">
                                        <?php
                                        foreach ($list_sede as $row_sede){
                                            $idSede = $row_sede['idSede'];
                                            $nameSede = $row_sede['nombreSede'];
                                        }
                                        ?>
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <label class="control-label" style="color: #000" for="selectSede">HOTEL</label>
                                            <fieldset>
                                                <div class="wrap-input1 validate-input" data-validate = "">
                                                    <input type="text" class="form-control input1" id="namesede" name="namesede" value="<?php echo $nameSede; ?>" readonly="">
                                                    <input type="hidden" id="idsede" name="idsede" value="<?php echo $idSede."|".$nameSede; ?>">
                                                    <span class="shadow-input1"></span>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <label class="control-label" style="color: #000" for="selectSede">CHECKIN-CHECKOUT</label>
                                            <fieldset>
                                                <div class="wrap-input1 validate-input" data-validate = "">
                                                    <input class="daterangepicker-field form-control input1" name="periodo"></input>
                                                    <span class="shadow-input1"></span>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <label class="control-label" style="color: #000" for="selectSede">ADULTOS</label>
                                            <fieldset>
                                                <div class="wrap-input1 validate-input" data-validate = "">
                                                    <input type="number" class="form-control input1" onblur="this.value = this.value.toUpperCase()" id="cantadult" name="cantadult" placeholder="Cantidad" min="1" max="10" value="1" required="">
                                                    <span class="shadow-input1"></span>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <label class="control-label" style="color: #000" for="selectSede">NIÑOS</label>
                                            <fieldset>
                                                <div class="wrap-input1 validate-input" data-validate = "">
                                                    <input type="number" class="form-control input1" onblur="this.value = this.value.toUpperCase()" id="cantkid" name="cantkid" placeholder="Cantidad" min="0" max="10" value="0"  required="">
                                                    <span class="shadow-input1"></span>
                                                    <span id="edadnino"></span>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <br />
                                            <center>
                                                <button type="submit" class="btn btn-success btn-lg">Buscar
                                                    <i class="glyphicon glyphicon-search glyphicon-white"></i>
                                                </button>
                                            </center>
                                        </div>
                                    </div>
                                    
                                </form> 
                            </div>
                        </div>
                        <div class="x_panel" style="opacity: 0.8">
                            <div class="x_content">
                                <div class="col-md-3 col-sm-12 col-xs-12" style="text-align: center">
                                    <center>
                                    <img alt="Freya" class="img-fluid img-thumbnail" src="<?php echo base_url().'public/img/relaxicon.png'; ?>" />
                                    </center>
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12" style="text-align: center">
                                    <center>
                                    <img alt="Freya" class="img-fluid img-thumbnail" src="<?php echo base_url().'public/img/parapenticon.png'; ?>" />
                                    </center>
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12" style="text-align: center">
                                    <center>
                                    <img alt="Freya" class="img-fluid img-thumbnail" src="<?php echo base_url().'public/img/cofeeicon.png'; ?>" />
                                    </center>
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12" style="text-align: center">
                                    <center>
                                    <img alt="Freya" class="img-fluid img-thumbnail" src="<?php echo base_url().'public/img/horseicon.png'; ?>" />
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->

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
    
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo base_url().'public/gentelella/vendors/moment/min/moment.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js'; ?>"></script>
    
  </body>
</html>
