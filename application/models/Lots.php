<?php

class Lots extends CI_Model{
    protected $_name = 'lots';
    function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function get($id){
        $this->db->where('producte', $id);
        $query = $this->db->get($this->_name);
        return $query->result();
    }
    
    public function getFromP($producte){
        $this->db->where('producte', $producte);
        $query = $this->db->get($this->_name);
        return $query->result();
    }

    public function getAll(){
        $this->db->order_by('DATA', 'DESC');
        $query = $this->db->get($this->_name);
        return $query->result();
    }

    public function insert($data){
        $this->db->insert($this->_name, $data);
        return $this->db->insert_id();
    }
}