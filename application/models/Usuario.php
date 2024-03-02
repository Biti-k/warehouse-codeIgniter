<?php

class Usuario extends CI_Model{
    protected $_name = 'usuario';
    function __construct(){
        $this->load->database();
    }

    public function get($nom, $pass){
        $query = $this->db->get_where($this->_name, array('nom' => $nom, 'pass' => $pass));
        return $query->result();
    }
}