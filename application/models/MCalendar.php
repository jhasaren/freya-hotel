<?php
/**************************************************************************
* Nombre de la Clase: MCalendar
* Descripcion: Es el Modelo para las interacciones en BD del modulo Agendas
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 09/04/2017
**************************************************************************/

if (!defined('BASEPATH')) exit('No direct script access allowed');

class MCalendar extends CI_Model {

    public function __construct() {
        
        /*instancia la clase de conexion a la BD para este modelo*/
        parent::__construct();
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_service_calendar
     * Descripcion: Obtiene los servicios activos para registrar agendar cita
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 10/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function list_service_calendar($sede) {
        
        /*Recupera los servicios creados*/
        $query = $this->db->query("SELECT
                                s.idServicio,
                                g.descGrupoServicio,
                                s.descServicio
                                FROM
                                servicios s
                                JOIN grupo_servicio g ON g.idGrupoServicio = s.idGrupoServicio
                                WHERE
                                s.activo = 'S'
                                AND s.agenda = 'S'
                                AND s.idSede = ".$sede."
                                ORDER BY 2,3");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_habitaciones_libre
     * Descripcion: Obtiene las habitaciones disponibles para la sede
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 24/01/2019, Ultima modificacion: 
     **************************************************************************/
    public function list_habitaciones_libre($habitaciones,$checkin,$checkout) {
                
        $inicia = FALSE;
        $dataDisponibles['disponibilidad'] = TRUE;
        if ($habitaciones['sitio'] != FALSE){
            
            $count = 0;
            foreach ($habitaciones['sitio'] as $row_list){

                /*
                Recupera las reservas registradas para cada habitacion en el periodo 
                seleccionado las cuales se encuentren 1-REGISTRADAS y/o -CONFIRMADA.
                */                
                $query = $this->db->query("SELECT
                                        e.idEvento
                                        FROM
                                        eventos_habitacion e
                                        WHERE
                                        e.idMesa = ".$row_list['idMesa']."
                                        AND e.idEstadoReserva IN (1,2,4)
                                        AND
                                        (((fechaInicioEvento >= '".$checkin." ".$this->config->item('checkout')."'
                                        AND fechaInicioEvento <= '".$checkout." ".$this->config->item('checkout')."')
                                        OR
                                        (fechaFinEvento >= '".$checkin." ".$this->config->item('checkin')."'
                                        AND fechaFinEvento <= '".$checkout." ".$this->config->item('checkin')."'))
                                        OR
                                        ((fechaFinEvento >= '".$checkin." ".$this->config->item('checkin')."')
                                        AND
                                        (fechaInicioEvento <= '".$checkout." ".$this->config->item('checkout')."')))
                                        ");
                
                if ($query->num_rows() == 0) { /*si hay disponibilidad, muestra la habitacion al usuario*/          
                    
                    /*esta disponible*/
                    $dataDisponibles[$count] = array(
                        'idMesa' => $row_list['idMesa'],
                        'nombreMesa' => $row_list['nombreMesa'],
                        'caracteristicas' => $row_list['caracteristicas'],
                        'cantAdulto' => $row_list['cantAdulto'],
                        'cantNino' => $row_list['cantNino'],
                        'valorNoche' => $row_list['valorProducto']
                    );
                    
                    $count++;
                    
                }
                
            }
            
            $inicia = TRUE;
        
        }
        
        if ($inicia == FALSE){
            
            $dataDisponibles['disponibilidad'] = FALSE;
            $dataDisponibles['mensaje'] = "No hay habitaciones habilitadas en este momento.";
            return $dataDisponibles; /*no hay habitaciones disponibles*/
            
        } else {
            
            if ($count == 0){
                
                $dataDisponibles['disponibilidad'] = FALSE;
                $dataDisponibles['mensaje'] = "No hay habitaciones disponibles en el periodo seleccionado.";
                return $dataDisponibles; /*no hay disponibilidada*/
                
            } else {
                      
                return $dataDisponibles; /*disponibles*/
                
            }
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_board_calendar
     * Descripcion: Obtiene la disponibilidad de las mesas en la sede
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 25/01/2019, Ultima modificacion: 10/02/2019
     **************************************************************************/
    public function list_board_calendar($adult,$nino,$sede,$adultosCountTotal) {
                
        /*Recupera la disponibilidad de habitaciones en la sede que cumplen con la capacidad*/
        /*TODAS*/
        if ($this->config->item('tarifa_huespedes') == 1){ /*si la tarifa se calcula basada en los huespedes*/
            
            $query = $this->db->query("SELECT
                                    m.idMesa,
                                    m.nombreMesa,
                                    m.activo,
                                    m.idTipoMesa,
                                    t.descTipoMesa,
                                    m.idVenta,
                                    v.idEstadoRecibo,
                                    DATE_FORMAT(v.fechaLiquida, '%H:%i %p') as time,
                                    m.caracteristicas,
                                    m.idEstadoMesa,
                                    te.descEstadoMesa,
                                    m.cantAdulto,
                                    m.cantNino,
                                    m.idTarifa,
                                    (p.valorProducto * ".$adultosCountTotal.") as valorProducto
                                    FROM mesas m
                                    JOIN tipo_mesa t ON t.idTipoMesa = m.idTipoMesa
                                    JOIN tipo_estado_mesa te ON te.idEstadoMesa = m.idEstadoMesa
                                    LEFT JOIN venta_maestro v ON v.idVenta = m.idVenta
                                    LEFT JOIN productos p ON p.idProducto = m.idTarifa AND p.activo = 'S' AND idTipoProducto = 1
                                    WHERE
                                    m.activo = 'S'
                                    AND m.idSede = ".$sede."
                                    AND m.cantAdulto >= ".$adult."
                                    AND m.cantNino >= ".$nino."");
        
        } else {
            
            $query = $this->db->query("SELECT
                                    m.idMesa,
                                    m.nombreMesa,
                                    m.activo,
                                    m.idTipoMesa,
                                    t.descTipoMesa,
                                    m.idVenta,
                                    v.idEstadoRecibo,
                                    DATE_FORMAT(v.fechaLiquida, '%H:%i %p') as time,
                                    m.caracteristicas,
                                    m.idEstadoMesa,
                                    te.descEstadoMesa,
                                    m.cantAdulto,
                                    m.cantNino,
                                    m.idTarifa,
                                    p.valorProducto
                                    FROM mesas m
                                    JOIN tipo_mesa t ON t.idTipoMesa = m.idTipoMesa
                                    JOIN tipo_estado_mesa te ON te.idEstadoMesa = m.idEstadoMesa
                                    LEFT JOIN venta_maestro v ON v.idVenta = m.idVenta
                                    LEFT JOIN productos p ON p.idProducto = m.idTarifa AND p.activo = 'S' AND idTipoProducto = 1
                                    WHERE
                                    m.activo = 'S'
                                    AND m.idSede = ".$sede."
                                    AND m.cantAdulto >= ".$adult."
                                    AND m.cantNino >= ".$nino."");
            
        }
        if ($query->num_rows() == 0) {

            return false;

        } else {
            
            $dataBoard['sitio'] = $query->result_array();
            
            return $dataBoard;

        }
            
    }
    
    /**************************************************************************
     * Nombre del Metodo: add_event
     * Descripcion: Registra un Evento para la agenda de un Empleado
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 25/01/2019, Ultima modificacion: 10/02/2019
     **************************************************************************/
    public function add_event($mesa,$tipoDoc,$idcliente,$nombre,$apellido,$tel,$email,$tiempo,$valorTotal,$desde,$hasta,$empleado,$sede,$adultos,$ninos,$totalHuespedCobro) {
                    
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        $query = $this->db->query("INSERT INTO
                                    eventos_habitacion (
                                    idMesa, 
                                    idTipoDocumento, 
                                    idCliente, 
                                    nombreCliente, 
                                    apellidoCliente, 
                                    telefonoCliente, 
                                    emailCliente, 
                                    tiempoAtencion, 
                                    valorReserva, 
                                    fechaInicioEvento, 
                                    fechaFinEvento, 
                                    fechaRegistro, 
                                    usuarioRegistro, 
                                    idSede,
                                    adultos,
                                    ninos,
                                    totalHuespedCobro,
                                    idEstadoReserva
                                    ) VALUES (
                                    ".$mesa.",
                                    ".$tipoDoc.",
                                    ".$idcliente.",
                                    '".$nombre."',
                                    '".$apellido."',
                                    '".$tel."',
                                    '".$email."',
                                    ".$tiempo.",
                                    ".$valorTotal.",
                                    '".$desde." ".$this->config->item('checkin')."',
                                    '".$hasta." ".$this->config->item('checkout')."',
                                    NOW(),
                                    '".$empleado."',
                                    ".$sede.",
                                    ".$adultos.",
                                    ".$ninos.",
                                    ".$totalHuespedCobro.",
                                    1
                                    )");
        $idevento = $this->db->insert_id();
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){

            return false;

        } else {
            
            $this->event_process($idevento, 1); /*Registra proceso*/
            return $idevento;

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: verify_calendar
     * Descripcion: Recupera las citas registradas para el empleado en determinado 
     * periodo de tiempo para determinar la viabilidad del registro de un nuevo evento
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 16/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function verify_calendar($empleado,$fechaini,$fechafin) {
        
        $tiempoAten1 = strtotime("-1 minute", strtotime($fechafin));
        $fechaFinaliza = date('Y-m-d H:i:s',$tiempoAten1);
        
        /*Recupera las citas registradas para el empleado*/
        $query = $this->db->query("SELECT
                                e.idEvento
                                FROM
                                eventos_empleado e
                                WHERE
                                e.idEmpleado = ".$empleado."
                                AND fechaInicioEvento 
                                BETWEEN '".$fechaini."' 
                                AND '".$fechaFinaliza."'");
        
        if ($query->num_rows() == 0) {
            
            $tiempoAten2 = strtotime("+1 minute", strtotime($fechaini));
            $fechaInicio = date('Y-m-d H:i:s',$tiempoAten2);
            
            $query2 = $this->db->query("SELECT
                                    e.idEvento
                                    FROM
                                    eventos_empleado e
                                    WHERE
                                    e.idEmpleado = ".$empleado."
                                    AND fechaFinEvento 
                                    BETWEEN '".$fechaInicio."' 
                                    AND '".$fechafin."'");
            
            if ($query2->num_rows() == 0) {
            
                return false;
            
            } else {
                
                return $query2->result_array();
                
            }
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: eventos_pendiente_confirmar
     * Descripcion: Obtiene la cantidad de reservas pendientes de confirmar en la sede
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 27/01/2019, Ultima modificacion: 
     **************************************************************************/
    public function eventos_pendiente_confirmar() {
                
        /*Recupera las reservas pendientes de confirmacion*/
        $query = $this->db->query("SELECT
                                count(1) as pedienteConfirmar
                                FROM eventos_habitacion
                                WHERE idEstadoReserva = 1
                                AND idSede = ".$this->session->userdata('sede')."");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->row();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: eventos_empleado
     * Descripcion: Recupera las citas registradas para el empleado en determinado 
     * periodo de tiempo
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 16/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function eventos_empleado($empleado,$fecha) {
                
        /*Recupera las citas registradas para el empleado*/
        $query = $this->db->query("SELECT
                                e.idEvento,
                                e.idServicio,
                                e.fechaInicioEvento,
                                e.fechaFinEvento
                                FROM
                                eventos_empleado e
                                WHERE
                                e.idEmpleado = ".$empleado."
                                AND e.fechaInicioEvento 
                                BETWEEN '".$fecha." 00:00:00' 
                                AND '".$fecha." 23:59:59'");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: horario_empleado
     * Descripcion: Obtiene el horario del empleado para un dia de la semana
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 16/04/2017, Ultima modificacion: 
    **************************************************************************/
    public function horario_empleado($diaSemana,$idEmpleado) {
        
        /*Recupera los servicios creados*/
        $query = $this->db->query("SELECT
                                h.horaIniciaTurno,
                                h.horaFinTurno,
                                h.horaIniciaAlmuerzo,
                                h.horaFinAlmuerzo
                                FROM
                                horario_empleado h
                                WHERE
                                h.idEmpleado = ".$idEmpleado."
                                AND h.idDia = ".$diaSemana."");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->row();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_event_cliente
     * Descripcion: Obtiene los eventos/citas reservadas del cliente
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 21/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function list_event_cliente($idUsuario) {
        
        /*Recupera los eventos creados*/
        $query = $this->db->query("SELECT
                                e.idEvento,
                                e.idEmpleado,
                                concat(a.nombre,' ',a.apellido) as nombreEmpleado,
                                e.idCliente,
                                e.idServicio,
                                s.descServicio,
                                e.fechaInicioEvento,
                                e.fechaFinEvento,
                                e.tiempoAtencion,
                                e.idSede,
                                d.nombreSede,
                                d.direccionSede,
                                d.telefonoSede
                                FROM
                                eventos_empleado e
                                JOIN app_usuarios a ON a.idUsuario = e.idEmpleado
                                JOIN servicios s ON s.idServicio = e.idServicio
                                JOIN sede d ON d.idSede = e.idSede
                                WHERE
                                e.idCliente = ".$idUsuario."
                                ORDER BY e.fechaInicioEvento 
                                AND fechaInicioEvento >= CURDATE()");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_event_sede
     * Descripcion: Obtiene los eventos/citas reservadas de la sede
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 27/01/2019, Ultima modificacion: 
     **************************************************************************/
    public function list_event_sede() {
        
        /*Recupera los eventos creados*/
        $query = $this->db->query("SELECT
                                e.idEvento,
                                e.idMesa,
                                m.nombreMesa,
                                t.descTipoMesa,
                                i.descDocumento,
                                e.idCliente,
                                e.nombreCliente,
                                e.apellidoCliente,
                                e.telefonoCliente,
                                e.emailCliente,
                                e.tiempoAtencion,
                                e.valorReserva,
                                e.fechaInicioEvento,
                                e.fechaFinEvento,
                                e.fechaRegistro,
                                s.nombreSede,
                                e.adultos,
                                e.ninos,
                                e.totalHuespedCobro,
                                e.idEstadoReserva,
                                r.descEstadoReserva
                                FROM eventos_habitacion e
                                JOIN mesas m ON m.idMesa = e.idMesa
                                JOIN tipo_mesa t ON t.idTipoMesa = m.idTipoMesa
                                JOIN tipo_identificacion i ON i.idTipoDocumento = e.idTipoDocumento
                                JOIN sede s ON s.idSede = e.idSede
                                JOIN tipo_estado_reserva r ON r.idEstadoReserva = e.idEstadoReserva
                                WHERE e.idSede = ".$this->session->userdata('sede')."
                                AND e.idEstadoReserva IN (1,2)
                                ORDER BY e.fechaInicioEvento DESC");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: event_process
     * Descripcion: Permite cambiar el estado de una reserva
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 27/01/2019, Ultima modificacion: 
     **************************************************************************/
    public function event_process($idevento,$estado) {
        
        /*Valida si el usuario existe en la sesion*/
        if ($this->session->userdata('userid') == NULL){
            $usuarioProceso = 0;
        } else {
            $usuarioProceso = $this->session->userdata('userid');
        }
            
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        $query = $this->db->query("UPDATE eventos_habitacion SET idEstadoReserva = ".$estado." WHERE idEvento = ".$idevento."");
        $query2 = $this->db->query("INSERT INTO reserva_proceso (
                                idEvento, 
                                usuarioProceso, 
                                fechaProceso, 
                                idEstadoReserva) 
                                VALUES(
                                ".$idevento.",
                                ".$usuarioProceso.",
                                NOW(),
                                ".$estado.")");
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){

            return false;

        } else {

            return true;

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: upd_habitacion_sede
     * Descripcion: Permite cambiar el estado de una habitacion
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 29/01/2019, Ultima modificacion: 
     **************************************************************************/
    public function upd_habitacion_sede($idHabitacion,$estado) {
        
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        $query = $this->db->query("UPDATE mesas SET idEstadoMesa = ".$estado." WHERE idMesa = ".$idHabitacion."");
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){

            return false;

        } else {

            return true;

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: upd_hab_reserva
     * Descripcion: Permite registrar la relacion de una habitacion y una reserva
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 29/01/2019, Ultima modificacion: 
     **************************************************************************/
    public function upd_hab_reserva($idHabitacion,$evento) {
        
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        $query = $this->db->query("INSERT INTO control_habitacion_reserva (idMesa,idReserva) VALUES (".$idHabitacion.",".$evento.")");
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){

            return false;

        } else {

            return true;

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: del_hab_reserva
     * Descripcion: Permite eliminar la relacion de una habitacion y una reserva
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 29/01/2019, Ultima modificacion: 
     **************************************************************************/
    public function del_hab_reserva($idHabitacion,$evento) {
        
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        $query = $this->db->query("DELETE FROM control_habitacion_reserva WHERE idMesa = ".$idHabitacion." and idReserva=".$evento."");
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){

            return false;

        } else {

            return true;

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: detail_event
     * Descripcion: Obtiene el detalle de un evento/cita reservada en la sede
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 27/01/2019, Ultima modificacion: 
     **************************************************************************/
    public function detail_event($idevento) {
        
        /*Recupera los eventos creados*/
        $query = $this->db->query("SELECT
                                e.idEvento,
                                e.idMesa,
                                m.nombreMesa,
                                t.descTipoMesa,
                                i.descDocumento,
                                e.idCliente,
                                e.nombreCliente,
                                e.apellidoCliente,
                                e.telefonoCliente,
                                e.emailCliente,
                                e.tiempoAtencion,
                                e.valorReserva,
                                e.fechaInicioEvento,
                                e.fechaFinEvento,
                                e.fechaRegistro,
                                s.nombreSede,
                                e.adultos,
                                e.ninos,
                                e.idEstadoReserva,
                                r.descEstadoReserva
                                FROM eventos_habitacion e
                                JOIN mesas m ON m.idMesa = e.idMesa
                                JOIN tipo_mesa t ON t.idTipoMesa = m.idTipoMesa
                                JOIN tipo_identificacion i ON i.idTipoDocumento = e.idTipoDocumento
                                JOIN sede s ON s.idSede = e.idSede
                                JOIN tipo_estado_reserva r ON r.idEstadoReserva = e.idEstadoReserva
                                WHERE e.idSede = ".$this->session->userdata('sede')."
                                AND e.idEvento = ".$idevento."
                                /*AND e.idEstadoReserva IN (1,2)*/
                                ");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->row();
            
        }
        
    }
        
}
