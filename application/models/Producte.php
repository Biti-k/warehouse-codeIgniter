<?php

class Producte extends CI_Model{
    protected $_name = 'producte';
    function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function get($id){
        $query = $this->db->get_where($this->_name, array("id" => $id));
        return $query->result();
    }

    public function update($id, $data){
        $this->db->where('id', $id);
        $this->db->update($this->_name, $data);
    }

    public function getAll(){
        $query = $this->db->get($this->_name);
        return $query->result();
    }

    public function insert($data){
        $this->db->insert($this->_name, $data);
        return $this->db->insert_id();
    }

    public function delete($id){
        $query = $this->db->delete($this->_name, array('id' => $id));
    }
}