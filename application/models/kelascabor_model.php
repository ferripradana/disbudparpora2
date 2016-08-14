<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kelascabor_model extends CI_Model
{

    public $table = 'kelascabor';
    public $id = 'nama';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    function get_by_tingkat($tingkat){
        $this->db->where('tingkatan', $tingkat);
        $result =  $this->db->get($this->table)->result();
        $return = array();
        foreach ($result as $key => $value) {
            $return[$value->id] = $value->nama;
        }
        return $return;
    }


    function get_by_cabang($id, $tingkatan){
        $this->db->where('cabang', $id);
        $this->db->where('tingkatan', $tingkatan);
        $result =  $this->db->get($this->table)->result();
        $return = array();  
         foreach ($result as $key => $value) {
            $return[] = array(
                'value' => $value->id,
                'label' => $value->nama,
            ); 
        }
        return $return;
    }

    function get_by_cabang_edit($id, $tingkatan){
        $this->db->where('cabang', $id);
        $this->db->where('tingkatan', $tingkatan);
        $result =  $this->db->get($this->table)->result();
        $return = array();  
         foreach ($result as $key => $value) {
            $return[$value->id] = $value->nama;
        }
        return $return;
    }


    
    // get total rows
    function total_rows() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit
    function index_limit($limit, $start = 0) {
        $this->db->order_by('kc.'.$this->id, $this->order);
        $this->db->limit($limit, $start);
        $return = $this->db->select('kc.*, c.caborname as cabang, t.tingkatanname as tingkatan')
                            ->from('kelascabor kc')
                            ->join('cabor c','kc.cabang=c.id')
                            ->join('tingkatan t','kc.tingkatan=t.id')
                            ->get()
                            ->result();
        return $return;
    }
    
    // get search total rows
    function search_total_rows($keyword = NULL) {
 
	$this->db->like('c.caborname', $keyword);
	$this->db->or_like('t.tingkatanname', $keyword);
	$this->db->or_like('nama', $keyword);
	$this->db->select('kc.*, c.caborname as cabang, t.tingkatanname as tingkatan')
                            ->from('kelascabor kc')
                            ->join('cabor c','kc.cabang=c.id')
                            ->join('tingkatan t','kc.tingkatan=t.id');
        return $this->db->count_all_results();
    }

    // get search data with limit
    function search_index_limit($limit, $start = 0, $keyword = NULL) {
        $this->db->order_by($this->id, $this->order);
	$this->db->like('c.caborname', $keyword);
	$this->db->or_like('t.tingkatanname', $keyword);
	$this->db->or_like('nama', $keyword);
	$this->db->limit($limit, $start);
    $this->db->order_by('kc.'.$this->id, $this->order);
        $this->db->limit($limit, $start);
        $return = $this->db->select('kc.*, c.caborname as cabang, t.tingkatanname as tingkatan')
                            ->from('kelascabor kc')
                            ->join('cabor c','kc.cabang=c.id')
                            ->join('tingkatan t','kc.tingkatan=t.id')
                            ->get()
                            ->result();
        return $return;
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

/* End of file kelascabor_model.php */
/* Location: ./application/models/kelascabor_model.php */