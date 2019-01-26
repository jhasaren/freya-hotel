<?php
/**************************************************************************
* Nombre de la Clase: CCalendar
* Version: 1.0
* Descripcion: Es el controlador para gestionar el Modulo de Agedas
* en el sistema.
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 09/04/2017
**************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class CCalendar extends CI_Controller {

    function __construct() {
        
        parent::__construct(); /*por defecto*/
        $this->load->helper('url'); /*Carga la url base por defecto*/
        $this->load->library('jasr'); /*Funciones Externas de Apoyo*/
        
        /*Carga Modelos*/
        $this->load->model('MCalendar'); /*Modelo para el Agendamiento*/
        $this->load->model('MService'); /*Modelo para los Servicios*/
        $this->load->model('MSale'); /*Modelo para los Clientes*/
        $this->load->model('MUser'); /*Modelo para la Sede*/
        
        date_default_timezone_set('America/Bogota'); /*Zona horaria*/

        //lineas para eliminar el historico de navegacion./
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: index
     * Descripcion: Direcciona al usuario segun la sesion
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 27/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function index() {
        
        if ($this->session->userdata('validated')) {

            $this->module($info);
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: module
     * Descripcion: Redirecciona respuesta al usuario
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 21/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function module($info) {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(12)){ /*Agendas*/

                /*Consulta Modelo para obtener listado de Sedes*/
                $listSede = $this->MUser->list_sedes();
                
                $info['list_sede'] = $listSede;
                $this->load->view('calendar/setentidad',$info);
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: module
     * Descripcion: Redirecciona respuesta al usuario
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 21/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function servicesede() {
        
        if ($this->session->userdata('validated')) {
            
            if (!$this->input->post()){
                
                show_404();
                
            } else {
            
                if ($this->MRecurso->validaRecurso(12)){

                    /*Captura Variables*/
                    $dataSede = explode("|", $this->input->post('idsede'));
                    $sede = $dataSede[0];
                    $nombreSede = $dataSede[1];
                    $periodo = $this->input->post('periodo');
                    $adultosCount = $this->input->post('cantadult');
                    $ninoCount = $this->input->post('cantkid');
                    
                    $dataFecha = explode("|", $periodo);
                    $dateIN = new DateTime($dataFecha[0]); 
                    $checkin = $dateIN->format('Y-m-d');
                    $dateOUT = new DateTime($dataFecha[1]); 
                    $checkout = $dateOUT->format('Y-m-d');
                    
                    /*cantidad de dias*/
                    $diff = strtotime($checkout) - strtotime($checkin);
                    $days = floor($diff / (60*60*24) );
                    
                    /*Recupera habitaciones activas en la sede con la capacidad*/
                    $habitaciones = $this->MCalendar->list_board_calendar($adultosCount,$ninoCount,$sede);
                    
                    if ($habitaciones != FALSE){
                        
                        /*Consulta Modelo para validar la disponibilidad segun los criterios ingresados*/
                        $listHabitaciones = $this->MCalendar->list_habitaciones_libre($habitaciones,$checkin,$checkout);

                        if ($listHabitaciones['disponibilidad'] != FALSE){

                            $info['sede'] = $sede;
                            $info['nombreSede'] = $nombreSede;
                            $info['adultoCount'] = $adultosCount;
                            $info['ninoCount'] = $ninoCount;
                            $info['periodo_desde'] = $checkin;
                            $info['periodo_hasta'] = $checkout;
                            $info['cantidadNoches'] = $days;
                            $info['habitaciones'] = $listHabitaciones;
                            $info['mensaje'] = NULL;
                            $info['list_document'] = $this->MUser->type_doc_list(); /*Consulta Modelo para obtener lista de tipo documento*/
                            $this->load->view('calendar/setservice',$info);

                        } else {

                            /*No hay disponible*/
                            $info['sede'] = $sede;
                            $info['nombreSede'] = $nombreSede;
                            $info['adultoCount'] = $adultosCount;
                            $info['ninoCount'] = $ninoCount;
                            $info['periodo'] = $periodo;
                            $info['mensaje'] = $listHabitaciones['mensaje'];
                            $this->load->view('calendar/setservice',$info);

                        }
                        
                    } else {
                        
                        /*No hay disponible*/
                        $info['sede'] = $sede;
                        $info['nombreSede'] = $nombreSede;
                        $info['adultoCount'] = $adultosCount;
                        $info['ninoCount'] = $ninoCount;
                        $info['periodo'] = $periodo;
                        $info['mensaje'] = "Lo sentimos. Actualmente no contamos con habitaciones para la cantidad de Huéspedes indicados.";
                        $this->load->view('calendar/setservice',$info);
                        
                    }
                    
                    
                    
                } else {

                    show_404();

                }
            
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: personalcalendar
     * Descripcion: Ver empleados asignados para atender el servicio
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 12/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function personalcalendar() {
        
        if ($this->session->userdata('validated')) {
            
            if (!$this->input->post()){
                
                $this->index();
                
            } else {
            
                if ($this->MRecurso->validaRecurso(12)){

                    /*captura de variables*/
                    $servicio = $this->input->post('idservice');
                    $datacliente = explode('|', $this->input->post('idcliente'));
                    $cliente = $datacliente[1];
                    $sede = $this->input->post('idsede');
                    $nombresede = $this->input->post('nombresede');

                    /*Valida si el usuario/cliente existe*/
                    $validateClient = $this->MUser->verify_user($cliente);
                    
                    if ($validateClient != FALSE){
                    
                        /*consulta el modelo para obtener listado de Empleados que atienden el servicio para la sede*/
                        $listEmpleadosAsigned = $this->MService->list_service_empleados($servicio,$sede);

                        if ($listEmpleadosAsigned == FALSE){

                            $info['message'] = 'No hay profesionales asignados para atender el servicio seleccionado. Comuniquese al Centro de Belleza.';
                            $info['alert'] = 1;
                            $this->module($info);

                        } else {

                            /*Obtiene datos del servicio*/
                            $dataServicio = $this->MService->datos_servicio($servicio);

                            $info['dataServicio'] = $dataServicio;
                            $info['idcliente'] = $cliente;
                            $info['listEmpleadosAsg'] = $listEmpleadosAsigned;
                            $info['sede'] = $sede;
                            $info['nombreSede'] = $nombresede;
                            $this->load->view('calendar/setempleado',$info);

                        }
                    
                    } else {
                        
                        $info['message'] = 'El Cliente no existe, por favor digite y seleccione de la lista.';
                        $info['alert'] = 2;
                        $this->module($info);
                        
                    }

                } else {

                    show_404();

                }
            
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: seecalendar
     * Descripcion: Agendas por empleado
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 14/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function seecalendar() {
        
        if ($this->session->userdata('validated')) {
            
            if (!$this->input->post()){
                
                $this->index();
                
            } else {
            
                if ($this->MRecurso->validaRecurso(12)){

                    /*captura de variables*/
                    $servicio = $this->input->post('servicio');
                    $cliente = $this->input->post('cliente');
                    $empleado = $this->input->post('empleado');
                    $sede = $this->input->post('idsede');
                    $nombreSede = $this->input->post('nombreSede');
                    $date = new DateTime($this->input->post('fechaCita')); 
                    $fechaAgenda = $date->format('Y-m-d');
                    $diaSemana = date("N",strtotime($fechaAgenda));/*dia de la semana 1 Lun, 7 dom*/
                                        
                    $dataRow = explode('|', $empleado);
                    $idEmpleado = $dataRow[0];
                    $nombreEmpleado = $dataRow[1];

                    /*consulta el modelo para obtener listado de Empleados que atienden el servicio*/
                    $listEmpleadosAsigned = $this->MService->list_service_empleados($servicio,$sede);
                    
                    /*Obtiene datos del servicio*/
                    $dataServicio = $this->MService->datos_servicio($servicio);
                    
                    /*Obtiene configuracion del horario del empleado para la fecha*/
                    $dataHorario = $this->MCalendar->horario_empleado($diaSemana,$idEmpleado);
                    
                    /*Obtiene Parametro Intervalo de Tiempo para las secciones de la agenda*/
                    $data = file_get_contents(base_url().'public/bower_components/parametros/config.json');
                    $configuracion = json_decode($data, true);
                    $parametroTime = $configuracion['parametros']['intervaloMinutosServicio'];
                    
                    if ($dataHorario != FALSE){
                    
                        /*Obtiene los eventos registrados en la agenda del profesional*/
                        $dataEvent = $this->MCalendar->eventos_empleado($idEmpleado,$fechaAgenda);

                        if ($dataEvent == FALSE){

                            $info['dataEvent'] = 0;

                        } else {

                            $info['dataEvent'] = 1;
                            $info['listEvent'] = $dataEvent;

                        }
                        
                        $info['dataHorario'] = $dataHorario;
                        $info['viewCalendar'] = 1;
                        $info['nombreEmpleado'] = $nombreEmpleado;
                        $info['idEmpleado'] = $idEmpleado;
                        $info['fechaCita'] = $fechaAgenda;
                        $info['dataServicio'] = $dataServicio;
                        $info['idcliente'] = $cliente;
                        $info['listEmpleadosAsg'] = $listEmpleadosAsigned;
                        $info['sede'] = $sede;
                        $info['nombreSede'] = $nombreSede;
                        $info['parametroTime'] = $parametroTime;
                        $this->load->view('calendar/setempleado',$info);
                    
                    } else {
                        
                        $info['viewCalendar'] = 0;
                        $info['idEmpleado'] = $idEmpleado;
                        $info['fechaCita'] = $fechaAgenda;
                        $info['dataServicio'] = $dataServicio;
                        $info['idcliente'] = $cliente;
                        $info['listEmpleadosAsg'] = $listEmpleadosAsigned;
                        $info['message'] = 'El Profesional no tiene habilitado horario para el dia seleccionado. Comuniquese con el Centro de Belleza.';
                        $info['alert'] = 1;
                        $this->load->view('calendar/setempleado',$info);
                        
                    }    

                } else {

                    show_404();

                }
            
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: addevent
     * Descripcion: Agrega un evento (reservacion de habitacion)
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 25/01/2019, Ultima modificacion: 
     **************************************************************************/
    public function addevent() {
        
        if ($this->session->userdata('validated')) {
            
            if (!$this->input->post()){
                
                $this->index();
                
            } else {
            
                if ($this->MRecurso->validaRecurso(12)){

                    /*captura de variables*/
                    $typeDoc = $this->input->post('typedoc');
                    $identificacion = $this->input->post('identificacion');
                    $nombres = $this->input->post('nameclient');
                    $apellidos = $this->input->post('lastnameclient');
                    $telefono = $this->input->post('celular');
                    $email = $this->input->post('email');
                    $idHabitacion = $this->input->post('habitacion');
                    $nochesReserva = $this->input->post('noches_reserva');
                    $valorTotalReserva = $this->input->post('valor_reserva');
                    $sede = $this->input->post('sede');
                    $periodo_desde = $this->input->post('desde');
                    $periodo_hasta = $this->input->post('hasta');
                    $empleado = $this->session->userdata('userid');
                    $countAdult = $this->input->post('adultos');
                    $countNino = $this->input->post('ninos');
                                        
                    
                    if ($this->jasr->validaTipoString($nombres,1) && $this->jasr->validaTipoString($apellidos,1)){
                        
                        if ($this->jasr->validaTipoString($identificacion,5)){
                            
                            if ($this->jasr->validaTipoString($email,6)){
                                
                                /*Envia al Modelo para registrar la reserva*/
                                $calendarRegistro = $this->MCalendar->add_event($idHabitacion,$typeDoc,$identificacion,$nombres,$apellidos,$telefono,$email,$nochesReserva,$valorTotalReserva,$periodo_desde,$periodo_hasta,$empleado,$sede,$countAdult,$countNino);

                                if ($calendarRegistro != FALSE) {

                                    $info['message'] = 'Habitación Reservada Exitosamente.';
                                    $info['alert'] = 1;
                                    $this->module($info);

                                } else {

                                    $info['message'] = 'No fue posible reservar la Habitación. Verifique la disponibilidad nuevamente.';
                                    $info['alert'] = 2;
                                    $this->module($info);

                                }
                                
                            } else {
                                
                                $info['message'] = 'No fue posible registrar la reserva. El correo electronico es incorrecto.';
                                $info['alert'] = 2;
                                $this->module($info);
                                
                            }
                            
                        } else {
                            
                            $info['message'] = 'No fue posible registrar la reserva. La identificacion es incorrecta.';
                            $info['alert'] = 2;
                            $this->module($info);
                            
                        }
                        
                    } else {
                        
                        $info['message'] = 'No fue posible registrar la reserva. Los campos nombre y apellidos son incorrectos.';
                        $info['alert'] = 2;
                        $this->module($info);
                        
                    }
                    
                } else {

                    show_404();

                }
            
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: listevent
     * Descripcion: Lista las citas agendadas
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 20/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function listevent($typeUser) {
        
        if ($this->session->userdata('validated')) {
                        
            if ($this->MRecurso->validaRecurso(12)){

                /*ROL CLIENTE: permite ver sus citas*/
                if ($typeUser == 'cliente'){
                    
                    if ($this->MRecurso->validaRecurso(14)){ /*Citas Cliente*/
                    
                        /*consulta el modelo para obtener listado de eventos de un usuario*/
                        $dataEvent = $this->MCalendar->list_event_cliente($this->session->userdata('userid'));

                        if ($dataEvent != FALSE){

                            $info['list_event'] = $dataEvent;
                            $this->load->view('calendar/listevent-client',$info);

                        } else {

                            $info['message'] = 'No tiene citas reservadas.';
                            $info['alert'] = 1;
                            $this->load->view('calendar/listevent-client',$info);

                        }
                        
                    } else {
                        
                        show_404();
                        
                    }
                }
                
                /*ROL SUPERADMIN: permite ver todas las citas de la sede*/
                if ($typeUser == 'sede'){
                    
                    if ($this->MRecurso->validaRecurso(15)){ /*Citas Sede*/
                    
                        /*consulta el modelo para obtener listado de eventos de la sede*/
                        $eventSede = $this->MCalendar->list_event_sede();

                        if ($eventSede != FALSE){

                            $info['list_event'] = $eventSede;
                            $this->load->view('calendar/listevent-sede',$info);

                        } else {

                            $info['message'] = 'La sede no tiene Citas Reservadas.';
                            $info['alert'] = 1;
                            $this->load->view('calendar/listevent-sede',$info);

                        }
                    } else {
                        
                        show_404();
                    }
                }

            } else {

                show_404();

            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: eventcancel
     * Descripcion: Cancelar Cita Agendada
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 21/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function eventcancel() {
        
        if ($this->session->userdata('validated')) {
            
            if (!$this->input->post()){
                
                show_404();
                
            } else {
                        
                if ($this->MRecurso->validaRecurso(12)){
                    
                    /*captura variables*/
                    $evento = $this->input->post('idevento');
                    $tipoUsuario = $this->input->post('typeUser');

                    /*Obtiene el detalle del evento (fechaInicio)*/
                    $detailEvent = $this->MCalendar->detail_event($evento);
                    
                    /*Calcula la diferencia en Minutos de la fecha/hora del evento frente a la actual*/
                    $segundos = strtotime($detailEvent->fechaInicioEvento) - strtotime(date('Y-m-d h:i:s'));
                    $diferencia_minutos = intval($segundos/60);
                    
                    /*Obtiene Parametro Minutos Minimos para Cancelar cita*/
                    $data = file_get_contents(base_url().'public/bower_components/parametros/config.json');
                    $configuracion = json_decode($data, true);
                    $parametroTime = $configuracion['parametros']['MinMinutosCancelaCita'];
                    
                    if ($diferencia_minutos < $parametroTime){
                        
                        $info['message'] = 'No es posible cancelar la cita. No cumple con el Tiempo minimo permitido para cancelar. Comuniquese con el centro de belleza.';
                        $info['alert'] = 2;
                        
                        if ($tipoUsuario == 'cliente'){
                            /*Consulta modelo para listar Citas Reservadas del Cliente*/
                            $dataEvent = $this->MCalendar->list_event_cliente($this->session->userdata('userid'));
                            $info['list_event'] = $dataEvent;
                            $this->load->view('calendar/listevent-client',$info);
                        }

                        if ($tipoUsuario == 'superadmin'){
                            /*consulta el modelo para obtener listado de eventos de la sede*/
                            $eventSede = $this->MCalendar->list_event_sede();
                            $info['list_event'] = $eventSede;
                            $this->load->view('calendar/listevent-sede',$info);
                        }
                        
                    } else {
                    
                        /*envia datos al modelo para cancelar cita*/
                        $cancelEvent = $this->MCalendar->event_cancel($evento);

                        if ($cancelEvent == TRUE){

                            $info['message'] = 'Cita Cancelada Exitosamente.';
                            $info['alert'] = 1;

                            if ($tipoUsuario == 'cliente'){
                                /*Consulta modelo para listar Citas Reservadas del Cliente*/
                                $dataEvent = $this->MCalendar->list_event_cliente($this->session->userdata('userid'));
                                $info['list_event'] = $dataEvent;
                                $this->load->view('calendar/listevent-client',$info);
                            }

                            if ($tipoUsuario == 'superadmin'){
                                /*consulta el modelo para obtener listado de eventos de la sede*/
                                $eventSede = $this->MCalendar->list_event_sede();
                                $info['list_event'] = $eventSede;
                                $this->load->view('calendar/listevent-sede',$info);
                            }

                        } else {

                            $info['message'] = 'No es posible Cancelar la Cita.';
                            $info['alert'] = 2;

                            if ($tipoUsuario == 'cliente'){
                                /*Consulta modelo para listar Citas Reservadas del Cliente*/
                                $dataEvent = $this->MCalendar->list_event_cliente($this->session->userdata('userid'));
                                $info['list_event'] = $dataEvent;
                                $this->load->view('calendar/listevent-client',$info);
                            }

                            if ($tipoUsuario == 'superadmin'){
                                /*consulta el modelo para obtener listado de eventos de la sede*/
                                $eventSede = $this->MCalendar->list_event_sede();
                                $info['list_event'] = $eventSede;
                                $this->load->view('calendar/listevent-sede',$info);
                            }

                        }
                    
                    }

                } else {

                    show_404();

                }
            
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: eventconsulta
     * Descripcion: Consulta los datos de un evento
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 29/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function eventconsulta($idEvento) {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(12)){

                /*consulta modelo ´para obtener datos del evento*/
                $dataEvent = $this->MCalendar->detail_event($idEvento);
                
                if ($dataEvent != FALSE){
                    
                    echo "<h4>";
                    echo "<strong>Servicio:</strong> ".$dataEvent->descServicio."<br />";
                    echo "<strong>Profesional:</strong> ".$dataEvent->nombreEmpleado."<br /><br />";
                    echo "<strong>Inicio:</strong> ".$dataEvent->fechaInicioEvento."<br />";
                    echo "<strong>Fin:</strong> ".$dataEvent->fechaFinEvento."<br />";
                    echo "<strong>Tiempo Estimado de Atención:</strong> ".$dataEvent->tiempoAtencion." Min.<br /><br />";
                    echo "<strong>Sede:</strong> ".$dataEvent->nombreSede."<br />";
                    echo "<strong>Dirección:</strong> ".$dataEvent->direccionSede."<br />";
                    echo "<strong>Telefono:</strong> ".$dataEvent->telefonoSede."<br />";
                    echo "</h4>";
                    
                } else {
                    
                    echo "No se encuentra informacion de la Cita. Comuniquese con el Centro de Belleza.";
                    
                }
                
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }    
    
}
