<?php
/**************************************************************************
* Nombre de la Clase: MAuditoria
* Descripcion: Es el Modelo para las interacciones en BD del modulo Auditoria
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 18/01/2019
**************************************************************************/

if (!defined('BASEPATH')) exit('No direct script access allowed');

class MAuditoria extends CI_Model {

    public function __construct() {
        
        /*instancia la clase de conexion a la BD para este modelo*/
        parent::__construct();
        $this->load->driver('cache'); /*Carga cache*/
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: db_user_audit
     * Descripcion: Selecciona el usuario de conexion a base de datos
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 18/01/2019, Ultima modificacion: 
     * IMPORTANTE: el usuario debe existir en BD
     **************************************************************************/
    public function db_user_audit($username) {
                    
        $config['hostname'] = '192.168.1.65';
        $config['username'] = $username;
        $config['password'] = 'Jh4s4r3n2020';
        $config['database'] = 'freyahotel';
        $config['dbdriver'] = "mysqli";
        $config['dbprefix'] = "";
        $config['pconnect'] = FALSE;
        $config['db_debug'] = FALSE;
        $config['cache_on'] = FALSE;
        $config['cachedir'] = "";
        $config['char_set'] = "utf8";
        $config['dbcollat'] = "utf8_general_ci";

        $connect = $this->load->database($config, TRUE);
        
        return $connect;
        
    }
    
}
