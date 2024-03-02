<?php

class Cat_producte extends CI_Model{
    protected $_name = 'categoria_producte';
    function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function getAll(){
        $query = $this->db->get($this->_name);
        return $query->result();
    }

    public function insert($data){
        return $this->db->insert($this->_name ,$data);
    }

    public function delete($id){
        $query = $this->db->delete($this->_name, array('producte' => $id));
    }

    public function get_where($producte, $cat){
        $query = $this->db->get_where($this->_name, array(
            'producte' => $producte,
            'categoria' => $cat
        ));
        return $query->result();
    }
}