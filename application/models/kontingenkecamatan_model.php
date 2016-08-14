<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kontingenkecamatan_model extends CI_Model{
	
	public $table = 'kontingen_event_perkecamatan';
	public $id = 'id';
	public $order = 'DESC';

	function __construct(){
		parent::__construct();
	}

    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

	function get_by_id($id){
		$this->db->where($this->id, $id);
		return $this->db->get($this->table)->row();
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

    
    function delete_by_event($id_event){
    	$this->db->where('id_event' , $id_event);
        $this->db->delete($this->table);
    }

    function get_by_event($id_event){
        $this->db->order_by('id_kecamatan', 'ASC');
        if ($this->session->userdata('kecamatan')!=27) {
             $this->db->where('id_kecamatan',$this->session->userdata('kecamatan'));
        }
        $this->db->where('id_event', $id_event );
        return $this->db->get($this->table)->result();
    }



}



