<?php 


if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Kontingeneventolahragacabor_model extends CI_Model{
	public $table = 'kontingen_event_olahraga_cabor';
	public $id ='id';
	public $order = 'asc';

	//id, `id_kontingen_person`, id_cabor,`id_kelascabor`

	function __construct(){
		parent::__construct();
	}


    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }	




	function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    function get_by_kontingen($idkontingen)
    {
        $this->db->where('id_kontingen_person', $idkontingen);
        $result =  $this->db->get($this->table)->result();
        $return = array();
        foreach ($result as $key => $value) {
            $return[$value->id_kelascabor] = $value->id_kelascabor;
        }
        return $return;
    }


     function delete_by_person($idkontingen)
    {
        $this->db->where('id_kontingen_person', $idkontingen);
        $this->db->delete($this->table);
    }




    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

   
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

  
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    function delete_by_event($id)
    {
        $this->db->where('id_event', $id);
        $this->db->delete($this->table);
    }
}    