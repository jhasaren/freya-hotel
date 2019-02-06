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
    <link href="<?php echo base_url().'public/gentelella/build/css/custom.min.css'; ?>" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo base_url().'public/gentelella/vendors/iCheck/skins/flat/green.css'; ?>" rel="stylesheet">
    
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url().'public/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css'; ?>" rel="stylesheet">
    
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
                        <h3>Registrar Venta<br />#<?php echo $this->session->userdata('idSale'); ?></h3>
                        <?php
                        if ($data_mesa->idEstadoMesa == 1){
                            $label = "label-danger";
                        }
                        
                        if ($data_mesa->idEstadoMesa == 2){
                            $label = "label-success";
                        }
                        
                        if ($data_mesa->idEstadoMesa == 3){
                            $label = "label-info";
                        }
                        ?>
                        Reserva #<?php echo $this->session->userdata('idReserva'); ?><br />
                        <span class="label <?php echo $label; ?>">
                            <?php echo $data_mesa->descEstadoMesa; ?>
                        </span>
                        <?php 
                        if ($porcenInList->idEstadoRecibo == 8){
                            echo "CUENTA X COBRAR";
                        } 
                        
                        /*Setea los datos como variable de sesion*/
                        $datos_session = array(
                            'sdescuento' => ($porcenInList->porcenDescuento*100),
                            'sservicio' => ($porcenInList->porcenServicio*100),
                            'sclient' => $clientInList->idUsuario,
                            'sempleado' => $porcenInList->idEmpleadoAtiende
                        );
                        $this->session->set_userdata($datos_session);
                        ?>
                        <?php
                        /*echo "<br />Lista Usuarios Venta->".$this->cache->memcached->get('memcached10')."<br />";
                        echo "Lista Servicios->".$this->cache->memcached->get('memcached12')."<br />";
                        echo "Lista Productos->".$this->cache->memcached->get('memcached16')."<br />";
                        echo "Cliente en Lista->".$this->cache->memcached->get('memcached11')."<br />";*/
                        ?>
                    </div>

                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <div></div>
                                <span style="font-size: 18px">
                                    <?php
                                    if ($serviceInList != FALSE){
                                        foreach ($serviceInList as $valueServ){
                                            $serviceSubtotal = $serviceSubtotal+$valueServ['valor'];
                                        }
                                    }
                                    if ($productInList != FALSE){
                                        foreach ($productInList as $valueProd){
                                            $productoSubtotal = $productoSubtotal+$valueProd['valor'];
                                        }
                                    }
                                    if ($adicionalInList != FALSE){
                                        foreach ($adicionalInList as $valueAdic){
                                            $adicionalSubtotal = $adicionalSubtotal+$valueAdic['valor'];
                                        }
                                    }
                                    $valorConceptos = $serviceSubtotal+$productoSubtotal+$adicionalSubtotal;
                                    $subtotal = ($valorConceptos)-($serviceSubtotal*(($porcenInList->porcenDescuento)));
                                    ?>
                                    <div style="color: #000000; font-size: 16px">Descuento: <?php echo ($porcenInList->porcenDescuento*100)."%-($".number_format($valorConceptos,0,',','.').")"; ?></div>
                                    <div style="color: #000000; font-size: 16px">Servicio: <?php echo ($porcenInList->porcenServicio*100)."%+($".number_format($subtotal,0,',','.').")"; ?></div>
                                    <span style="color: #000000; font-size: 28px">Subtotal: $<?php echo number_format($subtotal+(($subtotal*($porcenInList->porcenServicio))),0,',','.'); ?></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <!--Alerta-->
                        <?php if ($receiptSale->cantidad == 0){ ?>
                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                No hay recibos disponibles.
                            </div>
                        <?php } ?>
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
                        <!--Alerta Add Concepto-->
                        <?php if ($idmessage == 1){ ?>
                        <div class="alert alert-info alert-dismissible fade in">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                            <?php echo $message; ?>
                        </div>
                        <?php } else if ($idmessage == 2) { ?>
                        <div class="alert alert-danger alert-dismissible fade in">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                            <?php echo $message; ?>
                        </div>
                        <?php } ?>
                        <!--/Alerta Add Concepto-->

                        <div class="x_panel">
                            <div class="x_title">
                                <span style="color: #009999; font-weight: bold">
                                    <?php echo "HABITACIÓN: ".$data_mesa->nombreMesa." | ADULTOS: ".$data_mesa->cantAdulto." | NIÑOS: ".$data_mesa->cantNino; ?>
                                </span>
                                <br />
                                <span style="color: #000000;">
                                    <?php echo $data_mesa->caracteristicas; ?>
                                </span>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <?php if (($porcenInList->idEstadoRecibo != 8) && ($data_mesa->idEstadoMesa != 3)) { ?>
                                <div class="row">
                                    <div class="animated flipInY col-lg-2 col-md-2 col-sm-2 col-xs-6"> 
                                        <a class="btn-saleclient" href="#">
                                            <div class="bs-glyphicons">
                                                <ul class="bs-glyphicons-list">
                                                    <li>
                                                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                                        <span class="glyphicon-class" style="font-size: 14px;">Huéspedes</span>
                                                        <div>-<?php echo $clientInList->idUsuario.'-'; ?></div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="animated flipInY col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                        <a class="btn-saleempleado" href="#">
                                            <div class="bs-glyphicons">
                                                <ul class="bs-glyphicons-list">
                                                    <li>
                                                        <span class="glyphicon glyphicon-road" aria-hidden="true"></span>
                                                        <span class="glyphicon-class" style="font-size: 14px;">
                                                            Vehículos
                                                            <div></div>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="animated flipInY col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                        <a class="btn-saleservice" href="#">
                                            <div class="bs-glyphicons">
                                                <ul class="bs-glyphicons-list">
                                                    <li>
                                                        <span class="glyphicon glyphicon-lamp" aria-hidden="true"></span>
                                                        <span class="glyphicon-class" style="font-size: 14px;">Alojamiento</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </a>    
                                    </div>
                                    <div class="animated flipInY col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                        <a class="btn-saleproduct" href="#">
                                            <div class="bs-glyphicons">
                                                <ul class="bs-glyphicons-list">
                                                    <li>
                                                        <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
                                                        <span class="glyphicon-class" style="font-size: 14px;">Productos</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="animated flipInY col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                        <a class="btn-saleespecial" href="#">
                                            <div class="bs-glyphicons">
                                                <ul class="bs-glyphicons-list">
                                                    <li>
                                                        <span class="glyphicon glyphicon-tags" aria-hidden="true"></span>
                                                        <span class="glyphicon-class" style="font-size: 14px;">Cargo Adicional</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </a>    
                                    </div>
                                    <div class="animated flipInY col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                        <a class="btn-saledesc" href="#">
                                            <div class="bs-glyphicons">
                                                <ul class="bs-glyphicons-list">
                                                    <li>
                                                        <span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span>
                                                        <span class="glyphicon-class" style="font-size: 14px;">
                                                            Servicio/Descuento
                                                            <div><?php echo ($porcenInList->porcenServicio*100)."% / ".($porcenInList->porcenDescuento*100)."%"; ?></div>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="row">
                                    <?php //if ($this->session->userdata('sclient') != NULL) { ?>
                                    <div class="col-md-10 col-sm-10 col-xs-10">
                                        <div class="x_panel" style="background-color: #81a4ba;">
                                            <div class="x_title" style="color: white;">
                                                <h2>Info. Huésped Principal</h2>
                                                <ul class="nav navbar-right panel_toolbox">
                                                    <li>
                                                        <span class="label label-warning">
                                                            <a href='<?php echo base_url().'index.php/CSale/contratohuesped/'.$clientInList->idUsuario."/".$clientInList->descDocumento."/".$clientInList->nombre_usuario; ?>' target="e_blank"><span style="color: #000">Imprimir Contrato</span></a>
                                                        </span>
                                                    </li>
                                                </ul>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content" style="color: white;">
                                                <B>Identificación</B>: <?php echo $clientInList->descDocumento." ".$clientInList->idUsuario; ?> | <B>Nombre</B>: <?php echo $clientInList->nombre_usuario; ?> | <B>Edad</B>: <?php echo $clientInList->edad; ?> años<br />
                                                <B>Dirección</B>: <?php echo $clientInList->direccion; ?> | 
                                                <B>Telefono</B>: <?php echo $clientInList->numCelular; ?> |
                                                <B>Email</B>: <?php echo $clientInList->email; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="animated flipInY col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                        <a class="btn-saleinterno" href="#">
                                            <div class="">
                                                <ul class="bs-glyphicons-list">
                                                    <li>
                                                        <p class="center-block download-buttons">
                                                            <?php if (($porcenInList->idEstadoRecibo == 8)) { ?>
                                                            <a href="<?php echo base_url() . 'index.php/CSale/liquidasale'; ?>" class="btn btn-success btn-lg">
                                                                <i class="glyphicon glyphicon-barcode glyphicon-white"></i> Liquidar
                                                            </a>
                                                            <?php 
                                                            } else { 
                                                                if (($data_mesa->idEstadoMesa == 3) && ($porcenInList->idEstadoRecibo != 8)){
                                                                ?>
                                                                <a href="<?php echo base_url() . 'index.php/CSale/enableboard/'.$data_mesa->idMesa; ?>" class="btn btn-default btn-lg">
                                                                    <i class="glyphicon glyphicon-check red"></i> Habilitar
                                                                </a>
                                                                <?php 
                                                                } else {
                                                                    ?>
                                                                    <a href="<?php echo base_url() . 'index.php/CSale/liquidasale'; ?>" class="btn btn-success btn-lg">
                                                                        <i class="glyphicon glyphicon-barcode glyphicon-white"></i> Liquidar
                                                                    </a>
                                                                    <a href="<?php echo base_url() . 'index.php/CSale/canceldatasale'; ?>" class="btn btn-default btn-lg">
                                                                        <i class="glyphicon glyphicon-remove red"></i> Eliminar
                                                                    </a>
                                                                    <?php
                                                                }
                                                            } 
                                                            ?>
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </a>
                                    </div>
                                    <?php //} ?>
                                    <?php if ($huespedInList != NULL){ ?>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_title" style="background-color: #89e0e0; color: black;">
                                                <h2>Huéspedes Acompañantes</h2>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Identificacion</th>
                                                            <th>Nombre</th>
                                                            <th>Datos</th>
                                                            <th>Edad</th>
                                                            <th>Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($huespedInList as $row_huesped_in){
                                                            ?>
                                                            <tr>
                                                                <th scope="row"><?php echo $row_huesped_in['descDocumento']." ".$row_huesped_in['idUsuarioHuesped']; ?></th>
                                                                <td><?php echo $row_huesped_in['nombre']." ".$row_huesped_in['apellido']; ?></td>
                                                                <td><?php echo $row_huesped_in['direccion']."<br />Tel: ".$row_huesped_in['numCelular']."<br />".$row_huesped_in['email']; ?></td>
                                                                <td><?php echo $row_huesped_in['edad']; ?></td>
                                                                <td>
                                                                    <?php 
                                                                    if ($porcenInList->idEstadoRecibo != 8) {
                                                                        echo "<a class='btn-saleitemdel' data-rel='".$row_huesped_in['id']."' data-rel2='5' href='#'><i class='glyphicon glyphicon-remove red'></i></a>";
                                                                    } 
                                                                    ?>
                                                                    <a class='btn-saledocument' target="e_blank" href='<?php echo base_url().'index.php/CSale/contratohuesped/'.$row_huesped_in['idUsuarioHuesped']."/".$row_huesped_in['descDocumento']."/".$row_huesped_in['nombre']." ".$row_huesped_in['apellido']; ?>'><i class='glyphicon glyphicon-book red'></i></a>
                                                                </td>
                                                                
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php if ($productInList != NULL){ ?>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_title" style="background-color: #5ec0ff; color: black;">
                                                <h2>Tarifas Cargadas</h2>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Nombre</th>
                                                            <th>Cant</th>
                                                            <th>Valor</th>
                                                            <th>Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($productInList as $row_product_in){
                                                            ?>
                                                            <tr>
                                                                <th scope="row"><?php echo $row_product_in['idRegistroDetalle']; ?></th>
                                                                <td><?php echo $row_product_in['descProducto']; ?></td>
                                                                <td><?php echo $row_product_in['cantidad']; ?></td>
                                                                <td>$<?php echo number_format($row_product_in['valor'],0,',','.'); ?></td>
                                                                <td>
                                                                <?php 
                                                                if ($porcenInList->idEstadoRecibo != 8) {
                                                                    echo "<a class='btn-saleitemdel' data-rel='".$row_product_in['idRegistroDetalle']."' data-rel2='2' href='#'><i class='glyphicon glyphicon-remove red'></i></a>";
                                                                } 
                                                                ?>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php if ($adicionalInList != NULL){ ?>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_title" style="background-color: #E8E792; color: black;">
                                                <h2>Cargos Adicionales</h2>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Nombre</th>
                                                            <th>Valor</th>
                                                            <th>Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($adicionalInList as $row_adicional_in){
                                                            ?>
                                                            <tr>
                                                                <th scope="row"><?php echo $row_adicional_in['idRegistroDetalle']; ?></th>
                                                                <td><?php echo $row_adicional_in['cargoEspecial']; ?></td>
                                                                <td>$<?php echo number_format($row_adicional_in['valor'],0,',','.'); ?></td>
                                                                <td>
                                                                <?php 
                                                                if ($porcenInList->idEstadoRecibo != 8) {
                                                                    echo "<a class='btn-saleitemdel' data-rel='".$row_adicional_in['idRegistroDetalle']."' data-rel2='3' href='#'><i class='glyphicon glyphicon-remove red'></i></a>";
                                                                } 
                                                                ?>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php if ($plateInList != NULL){ ?>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_title" style="background-color: #aadc7b; color: black;">
                                                <h2>Vehiculos Registrados</h2>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Placa</th>
                                                            <th>Tipo</th>
                                                            <th>Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($plateInList as $row_plate_in){
                                                            ?>
                                                            <tr>
                                                                <th scope="row"><?php echo $row_plate_in['id']; ?></th>
                                                                <td><?php echo $row_plate_in['placa']; ?></td>
                                                                <td><?php echo $row_plate_in['tipoVehiculo']; ?></td>
                                                                <td>
                                                                <?php 
                                                                if ($porcenInList->idEstadoRecibo != 8) {
                                                                    echo "<a class='btn-saleitemdel' data-rel='".$row_plate_in['id']."' data-rel2='4' href='#'><i class='glyphicon glyphicon-remove red'></i></a>";
                                                                } 
                                                                ?>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <!--<center>
                            <p class="center-block download-buttons">
                                <a href="<?php //echo base_url() . 'index.php/CSale/canceldatasale'; ?>" class="btn btn-default btn-lg">
                                    <i class="glyphicon glyphicon-remove red"></i> Eliminar
                                </a>
                                <a href="<?php //echo base_url() . 'index.php/CSale/liquidasale'; ?>" class="btn btn-success btn-lg">
                                    <i class="glyphicon glyphicon-barcode glyphicon-white"></i> Liquidar
                                </a>
                            </p>
                        </center>-->
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->
        
        <!--Modal - Huespedes-->
        <div class="modal fade" id="myModal-c" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-c" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_client_sale" action="<?php echo base_url() . 'index.php/CSale/addusersale'; ?>" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Huéspedes</h3>
                            <a class="btn-newcliente" href="#">
                                <i class="glyphicon glyphicon-plus-sign blue"></i>
                                Registrar Nuevo
                            </a>

                        </div>
                        <div class="modal-body">
                            <?php if ($this->session->userdata('sclient') != NULL) { ?>
                                <div class="alert alert-info">
                                    Esta venta tiene como Principal el cliente Nro. Identificación: <?php echo $clientInList->idUsuario; ?>
                                </div>
                            <?php } ?>
                            <label class="control-label" for="select">Escriba parte del nombre y seleccione de la lista</label>
                            <div class="controls">
                                <input class="select2_single form-control" type="text" name="idcliente" id="idcliente" required="" />
                            </div>
                            <br />
                            <label>
                                <input type="checkbox" class="flat" name="huesped_principal" >
                                Principal
                            </label>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" id="btn-click-client" class="btn btn-primary">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!--Modal - vehiculos-->
        <div class="modal fade" id="myModal-em" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-em" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_empleado_sale" action="<?php echo base_url() . 'index.php/CSale/addvehiculosale'; ?>" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Vehículo</h3>
                        </div>
                        <div class="modal-body">
                            <label class="control-label" for="select">Digite la Placa</label>
                            <div class="controls">
                                <input class="select2_single form-control" type="text" name="placa" id="placa" onblur="this.value = this.value.toUpperCase()" autocomplete="Off" required="" />
                            </div>
                            <br />
                            <label class="control-label" for="select">Seleccione el Tipo de Vehículo</label>
                            <div class="controls">
                                <select class="select2_single form-control" id="idempleadoventa" name="tipovehiculo" data-rel="chosen">
                                    <option value="AUTOMOVIL" >AUTOMOVIL</option>
                                    <option value="MOTOCICLETA" >MOTOCICLETA</option>
                                    <option value="CAMIONETA" >CAMIONETA</option>
                                    <option value="BUSETA" >BUSETA</option>
                                </select>
                            </div>
                            <br />
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" id="btn-click-empl" class="btn btn-primary">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!--Modal - Alojamiento-->
        <div class="modal fade" id="myModal-s" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-s" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_service_sale" action="<?php echo base_url() . 'index.php/CSale/addproductsale'; ?>" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Alojamiento</h3>
                        </div>
                        <div class="modal-body">
                            <div class="controls">
                                <?php 
                                if ($this->config->item('tarifa_dinamica') == 1){
                                    $readonly = 'readonly';
                                } else {
                                    $readonly = '';
                                }
                                ?>
                                <label class="control-label" for="select">Escriba parte del nombre y seleccione de la lista</label>
                                <div class="controls">
                                    <input class="select2_single form-control" type="text" name="idproducto" id="idservice" value="<?php echo $data_mesa->idTarifa .' | '.$data_mesa->valorProducto." | ".$data_mesa->descGrupoServicio." | ".$data_mesa->descProducto; ?>" <?php echo $readonly; ?> required="" />
                                </div>
                                <br />
                            </div>
                            <input type="hidden" class="form-control" id="idempleado_ser" name="idempleado" value="<?php echo $this->session->userdata('userid'); ?>">
                            <input type="hidden" class="form-control" id="typeReg" name="typeReg" value="0"> <!--Alojamiento-->
                            <br />
                            <label class="control-label" for="selectError">Cantidad de Noches</label>
                            <div class="controls">
                                <input type="text" class="form-control" id="cantidad_ser" name="cantidad" value="<?php echo $data_reserva->tiempoAtencion; ?>" readonly="">                                
                            </div>
                            <br />
                            <label class="control-label" for="selectError">CheckIn</label>
                            <div class="controls">
                                <input class="form-control" type="datetime" name="checkin" id="idservice" value="<?php echo $data_reserva->fechaInicioEvento; ?>" required="" readonly="" />
                            </div>
                            <br />
                            <label class="control-label" for="selectError">CheckOut</label>
                            <div class="controls">
                                <input class="form-control" type="datetime" name="checkout" id="checkout" value="<?php echo $data_reserva->fechaFinEvento; ?>" required="" readonly="" />
                            </div>
                            <br />
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" id="btn-click-serv" class="btn btn-primary">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!--Modal - Producto Venta-->
        <div class="modal fade" id="myModal-p" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-p" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_product_sale" action="<?php echo base_url() . 'index.php/CSale/addproductsale'; ?>" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Producto</h3>
                        </div>
                        <div class="modal-body">
                            <div class="controls">
                                <label class="control-label" for="select">Escriba parte del nombre y seleccione de la lista</label>
                                <div class="controls">
                                    <input class="select2_single form-control" type="text" name="idproducto" id="idproducto" required="" />
                                </div>
                                <br />
                            </div>
                            <input type="hidden" class="form-control" id="idempleado_pr" name="idempleado" value="<?php echo $this->session->userdata('userid'); ?>">
                            <input type="hidden" class="form-control" id="typeReg" name="typeReg" value="1"> <!--Producto-->
                            <br />
                            <label class="control-label" for="cantidad">Cantidad</label>
                            <select class="select2_single form-control" id="cantidad_pr" name="cantidad" data-rel="chosen">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <br />
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" id="btn-click-prod" class="btn btn-primary">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!--Modal - Cargo Adicional-->
        <div class="modal fade" id="myModal-esp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-esp" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_cargo_adc" action="<?php echo base_url() . 'index.php/CSale/addcargoadc'; ?>" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Cargo Adicional</h3>
                        </div>
                        <div class="modal-body">
                            <label class="control-label" for="Interno">Descripción/Motivo</label>
                            <input type="text" class="form-control" id="motivo" name="motivo" onblur="this.value = this.value.toUpperCase()" required="" autocomplete="off" maxlength="60" >
                            <br />
                            <label class="control-label" for="valorCargo">Valor ($)</label>
                            <input type="tel" class="form-control" id="valorCargo" name="valorCargo" required="" autocomplete="off" pattern="\d*">
                            <input type="hidden" class="form-control" id="porcentEmpleado" name="porcentEmpleado" value="0">
                            <input type="hidden" class="form-control" id="idempleado" name="idempleado" value="<?php echo $this->session->userdata('userid'); ?>">
                            <br />
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" id="btn-click-adc" class="btn btn-primary">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!--Modal - Eliminar item-->
        <div class="modal fade" id="myModal-itemdel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-itemdel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_product_int" action="<?php echo base_url() . 'index.php/CSale/deletedetailsale'; ?>" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Eliminar Item de la Venta</h3>
                        </div>
                        <div class="modal-body">
                            <label class="control-label" for="Interno">Seleccione Motivo</label>
                            <div class="controls">
                                <select class="select2_single form-control" id="motivoanulaitem" name="motivoanulaitem" data-rel="chosen" style="font-size: 16px">
                                    <option value="ERROR_DIGITACION_CAJA">Error Digitacion Cajero</option>
                                    <option value="DOCUMENTO_NO_CORRESPONDE">Documento no corresponde</option>
                                    <option value="CLIENTE_DESISTE">Cliente Desiste</option>
                                </select>
                            </div>
                            <br />
                            <?php if ($this->config->item('permiso_elim_item') == 1){ ?>
                                <label class="control-label" for="pass">Contraseña Administrador</label>
                                <input type="password" class="form-control" id="passadmin" name="passadmin" required="" style="font-size: 60px">
                                <br />
                            <?php } ?>
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
        
        <!--Modal - Descuento-->
        <div class="modal fade" id="myModal-desc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-desc" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <?php 
                    if ($porcenInList->idEstadoRecibo == 2){
                        $stateInput = "readonly";
                    } else {
                        $stateInput = "";
                    }
                    ?>
                    <form role="form" name="form_descuento" action="<?php echo base_url() . 'index.php/CSale/addporcentdesc'; ?>" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Servicio/Descuento</h3>
                        </div>
                        <div class="modal-body">
                            <?php 
                            /*Si el recibo esta liquidado y el perfil no es superadmin, no permite el cambio*/
                            if (($porcenInList->idEstadoRecibo == 2) && $this->session->userdata('perfil') != 'SUPERADMIN') { 
                                $stateInput = "readonly";
                                ?>
                                <div class="alert alert-info">
                                    No se puede modificar. El recibo ya se encuentra liquidado.
                                </div>
                                <?php 
                            } else { 
                                $stateInput = ""; 
                            }
                            ?>
                            <label class="control-label" for="Porcentaje">Servicio Voluntario (%)</label>
                            <input type="tel" class="form-control" id="porcen_servicio" name="porcen_servicio" placeholder="Servicio" value="<?php if ($porcenInList->porcenServicio == 0){ echo $this->config->item('procen_servicio'); } else { echo $porcenInList->porcenServicio*100; } ?>" required="" autocomplete="off" <?php echo $stateInput; ?> pattern="\d*">
                            <br />
                            <label class="control-label" for="Porcentaje">Descuento (%) *Solo aplicable para tarifa de Alojamiento</label>
                            <input type="tel" class="form-control" id="procentaje" name="procentaje" placeholder="Descuento" value="<?php if ($porcenInList->porcenDescuento !== NULL){ echo $porcenInList->porcenDescuento*100; } else { echo 0; } ?>" required="" autocomplete="off" <?php echo $stateInput; ?> pattern="\d*">
                            <br />
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" id="btn-click-desc" class="btn btn-primary">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!--Modal - Agregar Nuevo usuario Cliente -->
        <div class="modal fade" id="myModal-nc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-nc" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_user_cliente" action="<?php echo base_url() . 'index.php/CSale/adduser/cliente'; ?>" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Agregar Cliente</h3>
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
                                <label for="identificacion">Nro. Identificación</label>
                                <input type="number" class="form-control" id="identificacion" name="identificacion" placeholder="Documento Cliente" autocomplete="Off" required="">
                            </div>
                            <div class="form-group">
                                <label for="Nombre">Cliente</label>
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="nameclient" name="nameclient" placeholder="Nombres" autocomplete="Off" required="">
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="lastnameclient" name="lastnameclient" placeholder="Apellidos" autocomplete="Off" required="">
                            </div>
                            <div class="form-group">
                                <label for="fechanace">Fecha de Nacimiento</label>
                                <input type="text" name="fechanace" required="" class="form-control has-feedback-left" id="single_cal5" value="<?php echo $fechaIni; ?>" placeholder="Fecha Nacimiento" aria-describedby="inputSuccess2Status" readonly="">
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                <br />
                                <label for="datoscontacto">Datos de Contacto</label>
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="direccion" name="direccion" placeholder="Direccion" autocomplete="Off" >
                                <input type="text" class="form-control" id="celular" name="celular" placeholder="Telefono Fijo/Celular" autocomplete="Off" >
                                <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electronico" autocomplete="Off" >
                                <br />
                                <label>
                                    <input type="checkbox" class="flat" name="huesped_principal" >
                                    Principal
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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
    
    <!-- iCheck -->
    <script src="<?php echo base_url().'public/gentelella/vendors/iCheck/icheck.min.js'; ?>"></script>
    
    <!-- jQuery autocomplete -->
    <script src="<?php echo base_url().'public/gentelella/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js'; ?>"></script>
    <script>
    var clientes = [
        <?php foreach ($list_user as $row_user) { ?>
            { value: '<?php echo $row_user['nombre_usuario']." |".$row_user['idUsuario']; ?>' },
        <?php } ?>
    ];
    $('#idcliente').autocomplete({
        lookup: clientes
    });
    
    var servicios = [
        <?php 
        foreach ($list_service as $row_service) {
            if ($row_service['agotado'] < 1){
                ?>
                { value: '<?php echo $row_service['idProducto']." | ".$row_service['valorProducto']." | ".$row_service['descGrupoServicio']." | ".$row_service['descProducto']; ?>' },
                <?php 
            }
        } 
        ?>
    ];
    $('#idservice').autocomplete({
        lookup: servicios
    });
    
    var productos = [
        <?php foreach ($list_product as $row_product) { ?>
            { value: '<?php echo $row_product['idProducto']." | ".$row_product['valorProducto']." | ".$row_product['descGrupoServicio']." | ".$row_product['descProducto']; ?>' },
        <?php } ?>
    ];
    $('#idproducto').autocomplete({
        lookup: productos
    });
    </script>
    
  </body>
</html>
