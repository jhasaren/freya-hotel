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
    
    <link rel="shortcut icon" href="<?php echo base_url().'public/img/favicon.ico'; ?>">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
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
                        <h3>Detalle Recibo No.<?php echo $recibo; ?></h3>
                    </div>

                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <div></div>
                                <span class="input-group-btn">
                                    <a class="btn btn-warning btn-reserva" href="#"><i class="glyphicon glyphicon-calendar"></i> Detalle Alojamiento</a>
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
                                <h2>Venta ID:<?php echo $venta; ?></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <?php 
                                echo "Estado: ".$general->descEstadoRecibo."<br />";
                                echo "Fecha Ingreso: ".$general->fechaLiquida."<br />"; 
                                echo "Fecha Pago: ".$general->fechaPideCuenta."<br />"; 
                                echo "Liquida: ".$general->personaLiquida." [".$general->idUsuarioLiquida."]<br />";
                                echo "Cliente: ".$general->personaCliente." [CC. ".$general->idUsuarioCliente."]<br />";
                                echo "Recepcionista: ".$general->personaAtiende." [CC. ".$general->idEmpleadoAtiende."]<br />";
                                echo "Subtotal 1: $".number_format($general->valorTotalVenta,0,',','.')."<br />";
                                echo "Descuento: ".($general->porcenDescuento*100)."% *Solo aplica a Alojamiento<br />";
                                echo "Subtotal 2: $".number_format($general->valorLiquida,0,',','.')."<br />";
                                echo "Atención: $".number_format(($general->valorLiquida*$general->porcenServicio),0,',','.')."<br />";
                                echo "Valor Pagado: $".number_format($general->valorLiquida+($general->valorLiquida*$general->porcenServicio),0,',','.')."<br />";
                                ?>
                                <hr />
                                <?php
                                /*Forma de Pago*/
                                echo "<h4>Forma de Pago</h4>";
                                if ($formaPago == NULL){
                                    echo "--";
                                } else {
                                    foreach ($formaPago as $valueFormPago) {
                                        echo $valueFormPago['descTipoPago']." -> Valor: $".number_format($valueFormPago['valorPago'],0,',','.')." | Ref: ".$valueFormPago['referenciaPago']."<br />";
                                    }
                                }
                                
                                ?>
                                <hr />
                                <?php
                                /*Servicios*/
                                /*echo "<h3>Servicios</h3>";
                                if ($servicios == NULL){
                                    echo "--";
                                } else {
                                    foreach ($servicios as $valueServ) {
                                        echo $valueServ['descServicio']." -> Cantidad: ".$valueServ['cantidad']." -> $".number_format($valueServ['valor'],0,',','.')."<br />";
                                    }
                                }*/

                                /*Productos*/
                                echo "<h3>Tarifas y Conceptos</h3>";
                                if ($productos == NULL){
                                    echo "--";
                                } else {
                                    foreach ($productos as $valueProd) {
                                        echo $valueProd['descProducto']." -> Cantidad: ".$valueProd['cantidad']." -> $".number_format($valueProd['valor'],0,',','.')."<br />";
                                    }
                                }

                                /*Adicional*/
                                echo "<h3>Adicional</h3>";
                                if ($adicional == NULL){
                                    echo "--";
                                } else {
                                    foreach ($adicional as $valueAdic) {
                                        echo $valueAdic['cargoEspecial']." -> $".number_format($valueAdic['valor'],0,',','.')."<br />";
                                    }
                                }
                                ?>
                                <br /><br />
                            </div>
                            <center>
                                <a href="<?php echo base_url() . 'files/recibos/recibo_'.$recibo.'.pdf'; ?>" class="btn btn-primary btn-lg" target="_blank">
                                    <i class="glyphicon glyphicon-search glyphicon-download"></i> Descargar PDF
                                </a>
                                <a href="<?php echo base_url() . 'index.php/CReport/module/reportPayment'; ?>" class="btn btn-success btn-lg">
                                    <i class="glyphicon glyphicon-search glyphicon-white"></i> Consultar Otro
                                </a>
                            </center>
                            
                            <?php if ($general->idEstadoRecibo != 3) { ?>
                            <div class="x_content">
                                <form role="form" name="form_receipt_anul" action="<?php echo base_url() . 'index.php/CReport/anularecibo'; ?>" method="post">
                                    <div class="modal-body">
                                        <fieldset>
                                            <div class="col-md-4 xdisplay_inputx form-group"></div>
                                            <div class="col-md-4 xdisplay_inputx form-group">
                                                <input type="text" name="motivoanula" required="" class="form-control" placeholder="Motivo de Anulacion" autocomplete="off" style="height: 80px;" maxlength="90" >
                                                <input type="hidden" name="recibo" value="<?php echo $recibo; ?>" >
                                            </div>
                                            <div class="col-md-4 xdisplay_inputx form-group has-feedback"></div>
                                        </fieldset>
                                        <center>
                                            <button type="submit" class="btn btn-warning">Anular</button>
                                        </center>
                                    </div>
                                </form>
                            </div>
                            <?php } else { ?>
                            <div class="x_content">
                                    <div class="modal-body">
                                        <fieldset>
                                            <div class="col-md-4 xdisplay_inputx form-group"></div>
                                            <div class="col-md-4 xdisplay_inputx form-group">
                                                <B>Motivo Anulación:</B><br />
                                                <?php echo $general->motivoAnula; ?><br />
                                                <B>Usuario Anula:</B>
                                                <?php echo $general->usuarioAnula; ?><br />
                                                <B>Fecha Anulación:</B>
                                                <?php echo $general->fechaAnula; ?><br />
                                            </div>
                                            <div class="col-md-4 xdisplay_inputx form-group has-feedback"></div>
                                        </fieldset>
                                    </div>
                            </div>
                            <?php } ?>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->
        
        <!--Modal - Detalle Reserva-->
        <div class="modal fade" id="myModal-reser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-reser" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h3>Detalle Alojamiento</h3>
                    </div>
                    <div class="modal-body">
                        <div class="controls">
                            <label class="control-label" for="select">Reserva</label>
                            <br />
                            <?php 
                            echo "Fecha Solicitud: ".$alojamiento['reservaDetalle']->fechaRegistro."<br />";
                            echo "Identificación: ".$alojamiento['reservaDetalle']->idCliente."<br />";
                            echo "Nombre: ".$alojamiento['reservaDetalle']->nombreCliente." ".$alojamiento['reservaDetalle']->apellidoCliente."<br />";
                            echo "Telefono: ".$alojamiento['reservaDetalle']->telefonoCliente."<br />";
                            echo "Email: ".$alojamiento['reservaDetalle']->emailCliente."<br />";
                            echo "Habitacion: ".$alojamiento['reservaDetalle']->nombreMesa."<br />";
                            echo "Noches: ".$alojamiento['reservaDetalle']->tiempoAtencion."<br />";
                            echo "Entrada: ".$alojamiento['reservaDetalle']->fechaInicioEvento."<br />";
                            echo "Salida: ".$alojamiento['reservaDetalle']->fechaFinEvento."<br />";
                            echo "Huéspedes: Adultos ".$alojamiento['reservaDetalle']->adultos." Niños ".$alojamiento['reservaDetalle']->ninos."<br />";
                            echo "Valor Alojamiento: ".$alojamiento['reservaDetalle']->valorReserva."<br />";
                            ?>
                            <br />
                        </div>
                        <div class="controls">
                            <label class="control-label" for="select">Huéspedes</label>
                            <br />
                            <?php 
                            if ($alojamiento['huespedes'] != NULL){
                                foreach ($alojamiento['huespedes'] as $valueHuesped) {
                                    echo "Identificación: ".$valueHuesped['descDocumento']." ".$valueHuesped['idUsuarioHuesped']."<br />";
                                    echo "Nombre: ".$valueHuesped['nombre']." ".$valueHuesped['apellido']."<br />";
                                    echo "Fecha Nacimiento: ".$valueHuesped['fechaNacimiento']."<br /><br />";
                                }
                            }
                            ?>
                        </div>
                        <div class="controls">
                            <label class="control-label" for="select">Vehículos</label>
                            <br />
                            <?php 
                            if ($alojamiento['vehiculos'] != NULL){
                                foreach ($alojamiento['vehiculos'] as $valueVehiculo) {
                                    echo "Placa: ".$valueVehiculo['placa']."<br />";
                                    echo "Tipo: ".$valueVehiculo['tipoVehiculo']."<br /><br />";
                                }
                            }
                            ?>
                            <br />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>
        <!--Fin modal - detalle reserva-->

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
