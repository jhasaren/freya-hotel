<?php
/**************************************************************************
* Nombre de la Clase: CBoard
* Version: 1.2.0
* Descripcion: Es el controlador para gestionar el Modulo de Gestion Habitación
* en el sistema.
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 22/09/2018
**************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class CBoard extends CI_Controller {

    function __construct() {
        
        parent::__construct(); /*por defecto*/
        $this->load->helper('url'); /*Carga la url base por defecto*/
        $this->load->library('jasr'); /*Funciones Externas de Apoyo*/
        
        /*Carga Modelos*/
        $this->load->model('MBoard'); /*Modelo para los Productos*/
        
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
     * Fecha Creacion: 22/09/2018, Ultima modificacion: 
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
     * Fecha Creacion: 22/09/2018, Ultima modificacion: 
     **************************************************************************/
    public function module($info) {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(2)){

                /*Consulta Modelo para obtener listado de Mesas creadas*/
                $listBoards = $this->MBoard->list_boards();
                /*Consulta Modelo para obtener listado de Tipo de Mesas creadas*/
                $listTypeBoards = $this->MBoard->list_type_board();
                /*Retorna a la vista con los datos obtenidos*/
                $info['list_board'] = $listBoards;
                $info['list_type_board'] = $listTypeBoards;
                $this->load->view('boards/boardlist',$info);
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
        
    /**************************************************************************
     * Nombre del Metodo: addboard
     * Descripcion: Crear Habitación
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/09/2018, Ultima modificacion: 
     **************************************************************************/
    public function addboard(){
        
        if ($this->session->userdata('validated')) {
            
            /*Valida que la peticion http sea POST*/
            if (!$this->input->post()){

                $this->module($info);

            } else {

                if ($this->MRecurso->validaRecurso(2)){
                
                    /*Captura Variables*/
                    $name = strtoupper($this->input->post('nameboard'));
                    $type = $this->input->post('typeboard');
                    $car1 = $this->input->post('car1'); /*1 cama doble*/
                    $car2 = $this->input->post('car2'); /*1 cama sencilla*/
                    $car3 = $this->input->post('car3'); /*2 camas doble*/
                    $car4 = $this->input->post('car4'); /*2 camas sencilla*/
                    $car5 = $this->input->post('car5'); /*calefaccion*/

                    if ($this->jasr->validaTipoString($name,1)){
                        
                        $caracteristicas = NULL;
                        if ($car1 == 'on'){ 
                            /*1 cama doble*/
                            $caracteristicas = $caracteristicas."| 1CD "; 
                        } 
                        
                        if ($car2 == 'on'){ 
                            /*1 cama sencilla*/
                            $caracteristicas = $caracteristicas."| 1CS "; 
                        } 
                        
                        if ($car3 == 'on'){ 
                            /*2 camas doble*/
                            $caracteristicas = $caracteristicas."| 2CD "; 
                        } 
                        
                        if ($car4 == 'on'){ 
                            /*2 camas sencilla*/
                            $caracteristicas = $caracteristicas."| 2CS "; 
                        } 
                        
                        if ($car5 == 'on'){ 
                            /*calefaccion*/
                            $caracteristicas = $caracteristicas."| CLF "; 
                        } 
                        
                        /*Envia datos al modelo para el registro*/
                        $registerData = $this->MBoard->create_board($name,$type,$caracteristicas);

                        if ($registerData == TRUE){

                            $info['message'] = 'Habitación creada Exitosamente';
                            $info['alert'] = 1;
                            $this->module($info);

                        } else {

                            $info['message'] = 'No fue posible crear la Habitación';
                            $info['alert'] = 2;
                            $this->module($info);

                        }
                        
                    } else {

                        $info['message'] = 'No fue posible agregar la Habitación. Nombre incorrecto.';
                        $info['alert'] = 2;
                        $this->module($info);

                    }
                
                } else {
                    
                    show_404();
                    
                }

            }
        
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: updboard
     * Descripcion: Actualiza una Mesa
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/09/2018, Ultima modificacion: 
     **************************************************************************/
    public function updboard(){
        
        if ($this->session->userdata('validated')) {
        
            /*Valida que la peticion http sea POST*/
            if (!$this->input->post()){

                $this->module($info);

            } else {

                if ($this->MRecurso->validaRecurso(2)){
                
                    /*Captura Variables*/
                    $nameBoard = strtoupper($this->input->post('nameboard'));
                    $estado = $this->input->post('estadoBoard');
                    if ($estado == 'on'){ $valueState = 'S'; } else $valueState = 'N';
                    $idboard = $this->input->post('idboard'); 

                    if ($this->jasr->validaTipoString($nameBoard,1)){

                        /*Envia datos al modelo para la actualizacion del producto*/
                        $updateData = $this->MBoard->update_board($idboard,$nameBoard,$valueState);

                        if ($updateData == TRUE){

                            $info['message'] = "Mesa #".$idboard." Actualizada Exitosamente";
                            $info['alert'] = 1;
                            $this->module($info);

                        } else {

                            $info['message'] = 'No fue posible Actualizar la Mesa';
                            $info['alert'] = 2;
                            $this->module($info);

                        }

                    } else {

                        $info['message'] = 'No fue posible actualizar la Mesa. Nombre incorrecto.';
                        $info['alert'] = 2;
                        $this->module($info);

                    }
                
                } else {
                    
                    show_404();
                    
                }

            }
        
        } else {
            
            $this->index();
            
        }
        
    }
    
}
