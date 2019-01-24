<div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
        <a href="<?php echo base_url().'index.php/CPrincipal'; ?>" class="site_title"><i class="fa fa-circle-o"></i> <span><?php echo $this->config->item('namebussines'); ?></span></a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix">
        <div class="profile_info">
            <span>Bienvenido,</span>
            <h2><?php echo $this->session->userdata('nombre_usuario'); ?></h2>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <h3>General</h3>
            <ul class="nav side-menu">
                <li>
                    <a href="<?php echo base_url().'index.php/CPrincipal'; ?>">
                        <i class="fa fa-home"></i> Inicio
                    </a>
                </li>
                
                <?php if ($this->MRecurso->validaRecurso(9)){ /*Registro de Venta*/ ?>
                <!--<li>
                    <a href="<?php // echo base_url().'index.php/CSale/createsale'; ?>">
                        <i class="fa fa-usd"></i> Ventas
                    </a>
                </li>-->
                <li>
                    <a href="<?php echo base_url().'index.php/CSale/boards/2'; ?>">
                        <i class="fa fa-bed"></i> Habitación
                    </a>
                </li>
                <!--<li><a><i class="fa fa-usd"></i> Ventas <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="<?php // echo base_url().'index.php/CSale/createsale'; ?>">Registrar Venta</a></li>
                        <li><a href="<?php // echo base_url().'index.php/CSale/pendientespago'; ?>">Pendientes de Pago</a></li>
                    </ul>
                </li>-->
                <?php } ?>
                
                <?php //if ($this->MRecurso->validaRecurso(1)){ /*Servicios*/ ?>
                <!--<li>
                    <a href="<?php //echo base_url().'index.php/CService'; ?>">
                        <i class="fa fa-diamond"></i> Servicios
                    </a>
                </li>-->
                <!--<li><a><i class="fa fa-star-half-o"></i> Platos <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="<?php // echo base_url().'index.php/CService'; ?>">Lista de Servicios</a></li>
                    </ul>
                </li>-->
                <?php //} ?>
                
                <?php if ($this->MRecurso->validaRecurso(2)){ /*Productos*/ ?>
                <li>
                    <a href="<?php echo base_url().'index.php/CProduct'; ?>">
                        <i class="fa fa-diamond"></i> Tarifas
                    </a>
                </li>
                <!--<li><a><i class="fa fa-shopping-cart"></i> Productos <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="<?php // echo base_url().'index.php/CProduct'; ?>">Lista de Productos</a></li>
                        <li><a href="<?php // echo base_url().'index.php/CProduct/stock'; ?>">Stock</a></li>
                    </ul>
                </li>-->
                <?php } ?>
                
                <?php if ($this->MRecurso->validaRecurso(7)){ /*Usuarios*/ ?>
                <li>
                    <a href="<?php echo base_url().'index.php/CUser'; ?>">
                        <i class="fa fa-user-plus"></i> Usuarios
                    </a>
                </li>
                <!--<li><a><i class="fa fa-users"></i> Usuarios <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="<?php // echo base_url().'index.php/CUser'; ?>">Lista de Usuarios</a></li>
                    </ul>
                </li>-->
                <?php } ?>
                
                <?php if ($this->MRecurso->validaRecurso(8)){ /*Recibos*/ ?>
                <li>
                    <a href="<?php echo base_url().'index.php/CReport/module/reportPayment'; ?>">
                        <i class="fa fa-book"></i> Recibos
                    </a>
                </li>
                <?php } ?>
                
                <?php if ($this->MRecurso->validaRecurso(10)){ /*Reportes*/ ?>
                <li>
                    <a href="<?php echo base_url().'index.php/CReport/module/reportSedes'; ?>">
                        <i class="fa fa-folder-open"></i> Reportes
                    </a>
                </li>
                <?php } ?>
                
                <?php if ($this->MRecurso->validaRecurso(12)){ /*Reservas*/ ?>
                <li>
                    <a href="<?php echo base_url().'index.php/CCalendar/listevent/sede'; ?>">
                        <i class="fa fa-calendar-check-o"></i> Reservas
                    </a>
                    
                    <!--<a><i class="fa fa-calendar-check-o"></i> Reservas <span class="fa fa-chevron-down"></span></a>-->
                    <!--<ul class="nav child_menu">-->
                        <?php //if ($this->MRecurso->validaRecurso(140)) { /*Mis Citas - Cliente*/ ?>
                        <!--<li><a href="<?php //echo base_url().'index.php/CCalendar/listevent/cliente'; ?>">Mis Citas</a></li>-->
                        <?php //} ?>
                        <?php //if ($this->MRecurso->validaRecurso(155)) { /*Citas Sede - Superadmin*/ ?>
                        <!--<li><a href="<?php //echo base_url().'index.php/CCalendar/listevent/sede'; ?>">Citas Reservadas</a></li>-->
                        <?php //} ?>
                        <!--<li><a href="<?php //echo base_url().'index.php/CCalendar'; ?>">Reservar Cita</a></li>-->
                    <!--</ul>-->
                </li>
                <?php } ?>
                
                <?php if ($this->MRecurso->validaRecurso(10)){ /*Fidelizacion*/ ?>
                <li>
                    <a href="<?php echo base_url().'index.php/CReport/module/reportFide'; ?>">
                        <i class="fa fa-heart"></i> Fidelizacion
                    </a>
                </li>
<!--                <li><a><i class="fa fa-heart"></i> Fidelizacion <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <?php // if ($this->MRecurso->validaRecurso(5)){ /*Fidelizacion*/ ?>
                        <li><a href="<?php // echo base_url().'index.php/CReport/module/reportFide'; ?>">Comportamiento de Clientes</a></li>
                        <li><a href="<?php // echo base_url().'index.php/CReport/module/reportBirthday'; ?>">Cumpleaños del Mes</a></li>
                        <?php // } ?>
                    </ul>
                </li>-->
                <?php } ?>
            </ul>
        </div>

    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">
<!--        <a data-toggle="tooltip" data-placement="top" title="Settings">
            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="Lock">
            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
        </a>-->


        <a data-toggle="tooltip" data-placement="top" title="Copyright Amadeus Soluciones" href="#">
            <span class="glyphicon glyphicon-copyright-mark" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="Version 1.0.0" href="#">
            <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="Salir" href="<?php echo base_url().'index.php/CPrincipal/logout'; ?>">
            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
        </a>
    </div>
    <!-- /menu footer buttons -->
</div>