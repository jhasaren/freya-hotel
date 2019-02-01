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
    <!-- Datatables -->
    <link href="<?php echo base_url().'public/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css'; ?>" rel="stylesheet">
    
    <style>
    /*Deshabilitar cajon de busqueda en Datatable*/
    .dataTables_filter, .dataTables_info { display: none; }
    </style>
    
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
            
            <?php if ($this->session->userdata('perfil') == 'EMPLEADO' || $this->session->userdata('perfil') == 'SUPERADMIN') { ?>
            <!-- top tiles -->
            <div class="row tile_count">
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                    <span class="count_top"><i class="fa fa-user"></i> Total Clientes</span>
                    <div class="count"><?php echo $clientesRegistrados->cantidad; ?></div>
                    <span class="count_bottom"><i class="green"></i> Activos</span>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                    <span class="count_top"><i class="fa fa-user"></i> Tarifa Alojamiento</span>
                    <div class="count green"><?php echo $serviciosDia->cantidadServicios; ?></div>
                    <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>Hoy <?php echo date('D d/m'); ?></i></span>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                    <span class="count_top"><i class="fa fa-user"></i> Productos Vendidos</span>
                    <div class="count blue"><?php if($productosDia->cantidadProductos == NULL){ echo "0"; } else echo $productosDia->cantidadProductos; ?></div>
                    <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>Hoy <?php echo date('D d/m'); ?></i></span>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                    <span class="count_top"><i class="fa fa-clock-o"></i> Pagos Registrados</span>
                    <div class="count purple"><?php echo $recibosPagados->cantidad; ?></div>
                    <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>Hoy $<?php echo number_format($recibosPagados->valor_pagado,0,',','.'); ?></i></span>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                    <span class="count_top"><i class="fa fa-user"></i> Cuentas x Cobrar</span>
                    <div class="count red"><?php echo $recibosLiquidados->cantidad; ?></div>
                    <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>$<?php echo number_format($recibosLiquidados->valor_pagado,0,',','.'); ?></i></span>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                    <span class="count_top"><i class="fa fa-user"></i> Gastos Pendientes</span>
                    <div class="count"><?php echo $gastosPendientes->cantidad; ?></div>
                    <span class="count_bottom"><i class="red"><i class="fa fa-sort-asc"></i>$<?php echo number_format($gastosPendientes->valorpendiente,0,',','.'); ?></i></span>
                </div>
            </div>
            <!-- /top tiles -->
            <?php } ?>
            
            <div class="">

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
                            <div class="x_content">
                                <!--Gastos Pendiente Pago-->
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="bs-example" data-example-id="simple-jumbotron">
                                            <div class="jumbotron">
                                                <!--<h1>Freya!</h1>-->
                                                <!--<p>Software para la Administración Integral de Restaurantes</p>-->
                                                <center>
                                                <img alt="Freya" src="<?php echo base_url().'public/img/logo.png'; ?>" />
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2>Gastos Pendientes de Pago</h2>
                                                <ul class="nav navbar-right panel_toolbox">
                                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                    </li>
                                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                                    </li>
                                                </ul>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <table id="datatable" class="table table-responsive">
                                                    <thead>
                                                        <th>Descripcion</th>
                                                        <th>Valor</th>
                                                        <th>Hasta</th>
                                                        <th>Tipo</th>
                                                        <th>Categoria</th>
                                                        <th>Accion</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if ($gastosPendienteDetalle != FALSE){
                                                            foreach ($gastosPendienteDetalle as $row_list){
                                                                ?>
                                                                <tr style="background-color: #FFFFFF;">
                                                                    <td class="small green"><?php echo $row_list['descGasto']; ?></td>
                                                                    <td class="small blue">$<?php echo number_format($row_list['valorGasto'],0,',','.'); ?></td>
                                                                    <td class="small"><?php echo $row_list['fechaPago']; ?></td>
                                                                    <td class="small"><?php echo $row_list['descTipoGasto']; ?></td>
                                                                    <td class="small"><?php echo $row_list['descCategoria']; ?></td>
                                                                    <td class="center">
                                                                        <a href="<?php echo base_url().'index.php/CPrincipal/dataedit/gastos/'.$row_list['idGasto']; ?>" >
                                                                            <span class="label label-success">Editar</span>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                    <?php
                                                    //echo "Detalle Gastos Pendientes->".$this->cache->memcached->get('memcached28')."<br />";
                                                    //echo "Cantidad Gastos Pendientes->".$this->cache->memcached->get('memcached27');
                                                    ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Fin Gastos Pendiente Pago-->
                                
                                <!--Stock Productos-->
                                
                                <!--Fin Stock productos-->
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- top tiles -->
            <center>
            <div class="row tile_count">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <a class="btn btn-info" href="<?php echo base_url().'index.php/CSale/boards/2'; ?>"><i class="glyphicon glyphicon-th"></i> HABITACIONES</a>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <a class="btn btn-danger" href="<?php echo base_url().'index.php/CCalendar/listevent/sede'; ?>"><i class="glyphicon glyphicon-th"></i> CONTROL DE RESERVAS</a>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <a class="btn btn-warning" href="<?php echo base_url().'index.php/CCalendar'; ?>"><i class="glyphicon glyphicon-th"></i> NUEVA RESERVA</a>
                </div>
            </div>
            </center>    
            <!-- /top tiles -->
            
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
    <!-- Datatables -->
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js'; ?>"></script>
  </body>
</html>
