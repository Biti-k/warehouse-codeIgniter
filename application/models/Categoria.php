<?php

class Categoria extends CI_Model{
    protected $_name = 'categoria';
    function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function get($id){
        $this->db->where('id', $id);
        $query = $this->db->get($this->_name);
        return $query->result();
    }

    public function getAll(){
        $query = $this->db->get($this->_name);
        return $query->result();
    }
}