<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Assetolahraga_model extends CI_Model
{

    public $table = 'assetolahraga';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
         if ($this->session->userdata('kecamatan')!=27) {
             $this->db->where('kecamatan',$this->session->userdata('kecamatan'));
        }
        return $this->db->get($this->table)->result();
    }

    function get_all_excel(){
            $this->db->order_by('name', 'asc');
             if ($this->session->userdata('kecamatan')!=27) {
                 $this->db->where('kecamatan',$this->session->userdata('kecamatan'));
            }
           $return = $this->db->select('a.*, k.kecamatanname as kecamatan')
                            ->from('assetolahraga a')
                            ->join('kecamatan k','a.kecamatan=k.id')
                            ->get()
                            ->result();
            $output = array();
            foreach ($return as $key => $value) {
                $output[$value->id] = (array) $value;
            }
        return $output;
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
         if ($this->session->userdata('kecamatan')!=27) {
             $this->db->where('kecamatan',$this->session->userdata('kecamatan'));
        }
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows() {
        $this->db->from($this->table);
         if ($this->session->userdata('kecamatan')!=27) {
             $this->db->where('kecamatan',$this->session->userdata('kecamatan'));
        }
        return $this->db->count_all_results();
    }

    // get data with limit
    function index_limit($limit, $start = 0) {
        $this->db->order_by('a.'.$this->id, $this->order);
        $this->db->limit($limit, $start);
         if ($this->session->userdata('kecamatan')!=27) {
             $this->db->where('kecamatan',$this->session->userdata('kecamatan'));
        }
        $return = $this->db->select('a.*, k.kecamatanname as kecamatan')
                            ->from('assetolahraga a')
                            ->join('kecamatan k','a.kecamatan=k.id')
                            ->get()
                            ->result();
        return $return;
    }
    
    // get search total rows
    function search_total_rows($keyword = NULL) {
	$this->db->like('name', $keyword);
    $this->db->or_like('k.kecamatanname', $keyword);
	$this->db->or_like('tahun', $keyword);
	$this->db->or_like('kondisi', $keyword);
     if ($this->session->userdata('kecamatan')!=27) {
             $this->db->where('kecamatan',$this->session->userdata('kecamatan'));
        }
    $this->db->select('a.*, k.kecamatanname as kecamatan')
                            ->from('assetolahraga a')
                            ->join('kecamatan k','a.kecamatan=k.id');
    return $this->db->count_all_results();
    }

    // get search data with limit
    function search_index_limit($limit, $start = 0, $keyword = NULL) {
        $this->db->order_by($this->id, $this->order);
	$this->db->like('name', $keyword);
    $this->db->or_like('k.kecamatanname', $keyword);
	$this->db->or_like('tahun', $keyword);
	$this->db->or_like('kondisi', $keyword);
	$this->db->limit($limit, $start);
     if ($this->session->userdata('kecamatan')!=27) {
             $this->db->where('kecamatan',$this->session->userdata('kecamatan'));
        }
    $this->db->order_by('a.'.$this->id, $this->order);
        $this->db->limit($limit, $start);
        $return = $this->db->select('a.*, k.kecamatanname as kecamatan')
                            ->from('assetolahraga a')
                            ->join('kecamatan k','a.kecamatan=k.id')
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

/* End of file assetolahraga_model.php */
/* Location: ./application/models/assetolahraga_model.php */