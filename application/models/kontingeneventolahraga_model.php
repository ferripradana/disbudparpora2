<?php 


if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Kontingeneventolahraga_model extends CI_Model{
	public $table = 'kontingen_event_olahraga';
	public $id ='id';
	public $order = 'asc';

	//id, id_event, id_kecamatan, nama, tmp_lahir, tgl_lahir, kelamin, alamat, telepon,
	//sekolah, kelas, posisi, cabang, kelas_olahraga 

	function __construct(){
		parent::__construct();
	}

	function get_all($id_event, $id_kecamatan){
		$this->db->order_by('k.nama', $this->order);
		$this->db->where('k.id_event', $id_event );
		$this->db->where('k.id_kecamatan', $id_kecamatan);
		$return = $this->db->select('k.*, c.caborname')

                            ->from('kontingen_event_olahraga k')
                            ->join('cabor c','k.cabang = c.id')
                            ->get()
                            ->result();
        return $return;
	}


    function get_all_print($id_event, $id_kecamatan){
        $this->db->order_by('k.nama', $this->order);
        $this->db->where('k.id_event', $id_event );
        $this->db->where('k.id_kecamatan', $id_kecamatan);
        $result = $this->db->select('k.*, kc.id_cabor, kc.`id_kelascabor`, c.`caborname`, kelas.nama AS kelascabang')
                            ->from('kontingen_event_olahraga k')
                            ->join('kontingen_event_olahraga_cabor kc', 'k.id_event=kc.id_event AND k.id= kc.id_kontingen_person' )
                            ->join('cabor c', 'kc.id_cabor=c.id')
                            ->join('kelascabor kelas', 'kelas.id = kc.id_kelascabor')
                            ->get()
                            ->result();
        
        $return = array();       
        foreach ($result as $key => $value) {

            if(empty($return[$value->id]))
            $return[$value->id] = $value;
            $return[$value->id]->kelas_olahraga[] = $value->caborname.' / '.$value->kelascabang;
       
        }

        return $return;
        
    }



	function index_limit($limit, $start = 0, $id_event, $id_kecamatan){
		$this->db->order_by('k.nama', 'ASC');
		$this->db->limit($limit, $start);

		$this->db->where('id_event', $id_event );
		$this->db->where('id_kecamatan', $id_kecamatan );
		$return = $this->db->select('k.*, c.caborname')
                            ->from('kontingen_event_olahraga k')
                            ->join('cabor c','k.cabang = c.id')
                            ->get()
                            ->result();
        return $return;
	}

 
	function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    function total_rows($id_event, $id_kecamatan) {
        $this->db->from($this->table);
       	$this->db->where('id_event', $id_event );
		$this->db->where('id_kecamatan', $id_kecamatan); 
        return $this->db->count_all_results();
    }



    function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
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