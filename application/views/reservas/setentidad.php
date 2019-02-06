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
                                        <label class="control-label" style="color: #000" for="selectSede">HOTEL</label>
                                        <div class="controls">
                                            <select class="select2_single form-control" id="idsede" name="idsede" data-rel="chosen">
                                                <?php
                                                foreach ($list_sede as $row_sede){
                                                    ?>
                                                    <option value="<?php echo $row_sede['idSede']."|".$row_sede['nombreSede']; ?>"><?php echo $row_sede['nombreSede']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <br />
                                        <label class="control-label" style="color: #000" for="selectSede">CHECKIN-CHECKOUT</label>
                                        <fieldset>
                                            <input class="daterangepicker-field form-control" name="periodo"></input>
                                        </fieldset>
                                        <br />
                                        <label class="control-label" style="color: #000" for="selectSede">ADULTOS</label>
                                        <fieldset>
                                            <input type="number" class="form-control" onblur="this.value = this.value.toUpperCase()" id="cantadult" name="cantadult" placeholder="Cantidad" min="1" max="10" value="1" required="">
                                        </fieldset>
                                        <br />
                                        <label class="control-label" style="color: #000" for="selectSede">NIÑOS</label>
                                        <fieldset>
                                            <input type="number" class="form-control" onblur="this.value = this.value.toUpperCase()" id="cantkid" name="cantkid" placeholder="Cantidad" min="0" max="10" value="0"  required="">
                                        </fieldset>
                                        <br />
                                        <center>
                                            <button type="submit" class="btn btn-success btn-lg">Siguiente
                                                <i class="glyphicon glyphicon-forward glyphicon-white"></i>
                                            </button>
                                        </center>
                                    </div>
                                    
                                </form> 
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
