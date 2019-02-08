<?php
/**************************************************************************
* Nombre de la Clase: CReservas
* Version: 1.0
* Descripcion: Es el controlador para gestionar el Modulo de reservas publico
* en el sistema.
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 06/02/2019
**************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class CReservas extends CI_Controller {

    function __construct() {
        
        parent::__construct(); /*por defecto*/
        $this->load->helper('url'); /*Carga la url base por defecto*/
        $this->load->library('jasr'); /*Funciones Externas de Apoyo*/
        
        /*Carga Modelos*/
        $this->load->model('MCalendar'); /*Modelo para el Agendamiento*/
        $this->load->model('MService'); /*Modelo para los Servicios*/
        $this->load->model('MSale'); /*Modelo para los Clientes*/
        $this->load->model('MUser'); /*Modelo para la Sede*/
        $this->load->file('application/libraries/class.phpmailer.php'); /*Libreria para el envio de Email*/
        
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
     * Fecha Creacion: 06/02/2019, Ultima modificacion: 
     **************************************************************************/
    public function index() {
        
        $this->module($info);
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: module
     * Descripcion: Redirecciona respuesta al usuario
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 06/02/2019, Ultima modificacion: 
     **************************************************************************/
    public function module($info) {

        /*Consulta Modelo para obtener listado de Sedes*/
        $listSede = $this->MUser->list_sedes();

        $info['list_sede'] = $listSede;
        $this->load->view('reservas/setentidad',$info);
            
    }
    
    /**************************************************************************
     * Nombre del Metodo: module
     * Descripcion: Redirecciona respuesta al usuario
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 06/02/2019, Ultima modificacion: 
     **************************************************************************/
    public function servicesede() {
                    
        if (!$this->input->post()){

            show_404();

        } else {

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
                    $this->load->view('reservas/setservice',$info);

                } else {

                    /*No hay disponible*/
                    $info['sede'] = $sede;
                    $info['nombreSede'] = $nombreSede;
                    $info['adultoCount'] = $adultosCount;
                    $info['ninoCount'] = $ninoCount;
                    $info['periodo'] = $periodo;
                    $info['mensaje'] = $listHabitaciones['mensaje'];
                    $this->load->view('reservas/setservice',$info);

                }

            } else {

                /*No hay disponible*/
                $info['sede'] = $sede;
                $info['nombreSede'] = $nombreSede;
                $info['adultoCount'] = $adultosCount;
                $info['ninoCount'] = $ninoCount;
                $info['periodo'] = $periodo;
                $info['mensaje'] = "Lo sentimos. Actualmente no contamos con habitaciones para la cantidad de Huéspedes indicados.";
                $this->load->view('reservas/setservice',$info);

            }

        }
        
    }
        
    /**************************************************************************
     * Nombre del Metodo: addevent
     * Descripcion: Agrega un evento (reservacion de habitacion)
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 06/02/2019, Ultima modificacion: 
     **************************************************************************/
    public function addevent() {
                    
        if (!$this->input->post()){

            $this->index();

        } else {

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

                            $mail = $this->notificamail($email,$nombres,$apellidos,$nochesReserva,$periodo_desde,$periodo_hasta,$countAdult,$countNino,$calendarRegistro);
                            
                            if ($mail){
                                
                                log_message("DEBUG", "****************************");
                                log_message("DEBUG", "Se envio correo exitosamente");
                                log_message("DEBUG", "****************************");
                                $info['reserva'] = $calendarRegistro;
                                $info['message'] = 'Su reserva se ha registrado Exitosamente. Pronto uno de nuestros asesores se comunicara con usted para hacer la confirmación.';
                                $info['alert'] = 1;
                                $this->load->view('reservas/event-finish',$info);
                                
                            } else {
                                
                                log_message("ERROR", "****************************");
                                log_message("ERROR", "No se pudo enviar correo electronico");
                                log_message("ERROR", "****************************");
                                $info['reserva'] = $calendarRegistro;
                                $info['message'] = 'Su reserva se ha registrado Exitosamente. Pronto uno de nuestros asesores se comunicara con usted para hacer la confirmación.';
                                $info['alert'] = 1;
                                $this->load->view('reservas/event-finish',$info);
                                
                            }
                            
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

        }
        
    }
    
    
    /**************************************************************************
     * Nombre del Metodo: notificamail
     * Descripcion: Permite enviar correo electronico
     * Autor: jhonalexander90@gmai.xom
     * Fecha Creacion: 07/02/2019, Ultima modificacion: 
     **************************************************************************/
    public function notificamail($email,$nombres,$apellidos,$nochesReserva,$periodo_desde,$periodo_hasta,$countAdult,$countNino,$calendarRegistro) {
        
        /*Notifica al correo electronico*/
        $notificationMail = new PHPMailer();
        //Propiedades del mensaje       
        $notificationMail->IsSMTP();
        $notificationMail->SMTPAuth   = true;
        $notificationMail->SMTPSecure = "tls";
        $notificationMail->Port       = 587;
        $notificationMail->Host       = 'mx1.hostinger.co';
        $notificationMail->Username   = "compras@tiendavitreo.com";	
        $notificationMail->Password   = "vitreotienda";
        $notificationMail->SMTPDebug  = 1;
        $notificationMail->From       = "compras@tiendavitreo.com";
        $notificationMail->FromName   = "Freya Hotel";
        //$mail->SetFrom('infomultas@consorciopst.com', 'Info Multas');
        $notificationMail->AddAddress($email);
                    
        $notificationMail->Subject  = "Reserva Realizada [#".$calendarRegistro."]";
        //Cuerpo del mensaje
        $body = " <html>"
                . "<body>"
                . "<p style='font-family: Lucida Console; color: #000;'>"
                . "Hola, Es un gusto saber que pronto podrás disfrutar de esta maravillosa experiencia. Estas son algunas de las 
                   recomendaciones para que la pases excelente: 1- Recuerda que estarás en una zona de reserva natural, con diversidad 
                   de aves y clima 2- Te vas a encontrar con un clima fresco en el día y frío en la noche, ven preparado 3- Desconéctate 
                   de la rutina y conéctate con la naturaleza 4- Prepárate para liberarte del stress del día a día y recargar 
                   baterías para lo que viene 5- Lo mas importante disfruta de la experiencia ¡Tu reserva fue exitosa!<br /><br />"
                . "<B>Detalles de tú Reserva</B><br /><br />"
                . "Huésped(es): ".$nombres." ".$apellidos."<br />
                    #Reserva: ".$calendarRegistro."<br />
                    Entrada: ".$periodo_desde."<br />
                    Salida: ".$periodo_hasta."<br />
                    Número de noches: ".$nochesReserva."<br />
                    Huéspedes: Adultos: ".$countAdult.", Niños: ".$countNino."<br /><br />"
                . "El check in es a las ".$this->config->item('checkin')." y el check out a las ".$this->config->item('checkout').". Estamos ubicados en La Tulia a 15 minutos del municipio de "
                . "Roldanillo-Valle, te podemos enviar ubicación exacta antes de tu estadía. Puedes disfrutar de servicio adicional "
                . "de restaurante, vinos, cocteles, ademas puedes rentar caballos y practicar parapente. "
                . "Pronto uno de nuestros asesores te contactara para hacer la confirmación, debes hacer la consignación de tu reserva en las siguientes 48 horas del registro para evitar cancelación. Bancolombia Alexis "
                . "Mendoza -Cuenta de ahorro 30100274134- <B>POR FAVOR ENVIAR COPIA DE CONSIGNACION AL EMAIL O WHATSAPP CON NOMBRE Y NUMERO "
                . "DE RESERVA</B>. Tenemos servicio de datafono en el lugar. Gracias por tu reserva.<br />"
                . "</p>"
                . "</body>"
                . "</html>";
        
        $notificationMail->Body = $body;
        $notificationMail->IsHTML(true);
        $notificationMail->CharSet = 'UTF-8';

        //enviar el correo
        if (($notificationMail->Send()) == TRUE){

            return TRUE;

        } else {

            return FALSE;

        }
        
    }    
    
}
