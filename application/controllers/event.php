<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event extends MY_Controller
{

    private $base_url =  'event/index/';
    private $_menu = 'event'; 
    private $total_rows;
    private $cabang_option;
    private $jenis_option;
    private $kecamatan_option;
    private $tingkatan_option;


    function __construct()
    {
        parent::__construct();
        $this->load->model('eventolahraga_model'); 
        $this->load->model('atlit_model');
        $this->load->model('cabor_model');
        $this->load->model('jenis_model');
        $this->load->model('kecamatan_model');
        $this->load->model('tingkatan_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->model('kontingenkecamatan_model');
        $this->load->model('kontingeneventolahraga_model');
        $this->load->model('Kontingeneventolahragacabor_model');
        $this->load->model('kelascabor_model');
        $this->total_rows =  $this->eventolahraga_model->total_rows();
        $this->cabang_option = $this->cabor_model->get_all_array();
        $this->jenis_option = $this->jenis_model->get_all_array();
        $this->kecamatan_option = $this->kecamatan_model->get_all_array();
        $this->tingkatan_option = $this->tingkatan_model->get_all_array();
    }

    public function index()
    {

        // print_r($this->kecamatan_option); die();
        $keyword = '';
        $config = getConfigPaging($this->base_url, $this->total_rows, $this->_menu );
        $this->pagination->initialize($config);
        $start = $this->uri->segment(3, 0);
        $event = $this->eventolahraga_model->index_limit($config['per_page'], $start);

        $this->data = array(
            'events' => $event,
            'keyword' => $keyword,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'tingkatan_option' => $this->tingkatan_option,
            'start' => $start,
        );

        $this->content = 'event/event/event_list';// menyimpan nilai admin/master_admin/admin_list ke content difungsikan untuk penetapan content di MY_Controller
        $this->layout();
    }
    
    public function search() 
    {
        $keyword = $this->uri->segment(3, $this->input->post('keyword', TRUE));
      
        
        if ($this->uri->segment(2)=='search') {
            $this->base_url =  'event/search/' . $keyword;
        } else {
            $this->base_url = 'event/index/';
        }
        $this->total_rows = $this->eventolahraga_model->search_total_rows($keyword);
        $this->_menu = 'event/search/'.$keyword.'';
        $config = getConfigPaging($this->base_url, $this->total_rows, $this->_menu, 1 );

        $this->pagination->initialize($config);

        $start = $this->uri->segment(4, 0);
        $events = $this->eventolahraga_model->search_index_limit($config['per_page'], $start, $keyword);

        $this->data = array(
            'events' => $events,
            'keyword' => $keyword,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'tingkatan_option' => $this->tingkatan_option,
            'start' => $start,
        );
         $this->content = 'event/event/event_list';// menyimpan nilai admin/master_admin/admin_list ke content difungsikan untuk penetapan content di MY_Controller
        $this->layout();
    }

    public function read($id) 
    {
        $row = $this->eventolahraga_model->get_by_id($id);
        if ($row) {
            $this->data = array(
                'id'    => $row->id,
                'name'  => $row->name,
                'tglmulai'  => date_formater($row->tglmulai),
                'tglselesai'  => date_formater($row->tglselesai),
                'tingkat'  => $this->tingkatan_option[$row->tingkat],
                'tglmulai_pendaftaran'  => date_formater($row->tglmulai_pendaftaran),
                'tglselesai_pendaftaran'  => date_formater($row->tglselesai_pendaftaran),
                'status_pendaftaran' =>  $row->status_pendaftaran,
                'klasmen' =>  $row->klasmen,

           );

            $this->content = 'event/event/event_read';
            $this->layout();
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('atlit'));
        }
    }

    public function create(){
    	// id , NAME, tglmulai, tglselesai, tingkat, tglmulai_pendaftaran, tglselesai_pendaftaran, `status_pendaftaran`, klasmen	
    	$this->data = array(
    		'button' => 'Create',
    		'action' => site_url('event/create_action'),
    		'id'	=> set_value('id'),
    		'name'  => set_value('name'),
    		'tglmulai' =>set_value('tglmulai'),
    		'tglselesai' => set_value('tglselesai'),
    		'tingkat' => set_value('tingkat'),
    		'tglmulai_pendaftaran' => set_value('tglmulai_pendaftaran'),
    		'tglselesai_pendaftaran' => set_value('tglselesai_pendaftaran'),
    		'status_pendaftaran' => set_value('status_pendaftaran'),
    		'klasmen' => set_value('klasmen'),
    		'tingkatan_option' => $this->tingkatan_option,
    	);

    	$this->content = 'event/event/event_form';
    	$this->layout();	
    }


    public function create_action(){
    	$this->_rules();
    	if($this->form_validation->run()==false){
    		$this->create();
    	}else{
    		$data = array(
	    		'name'  =>  $this->input->post('name',TRUE),
	    		'tglmulai' =>  date_for_mysql($this->input->post('tglmulai',TRUE)),
	    		'tglselesai' => date_for_mysql($this->input->post('tglselesai',TRUE)),
	    		'tingkat' => $this->input->post('tingkat',TRUE),
	    		'tglmulai_pendaftaran' => date_for_mysql($this->input->post('tglmulai_pendaftaran',TRUE)),
	    		'tglselesai_pendaftaran' => date_for_mysql($this->input->post('tglselesai_pendaftaran',TRUE)),
	    		'status_pendaftaran' =>  $this->input->post('status_pendaftaran',TRUE),
	    		'klasmen' =>  $this->input->post('klasmen',TRUE),
	    	
    		);

    		$lastid = $this->eventolahraga_model->insert($data);

    		//id, id_kecamatan, id_event

    		foreach ($this->kecamatan_option as $key => $value) {
    			if ($key==27) {
    				continue;
    			}
    		  	$kontingenkecamatandata = array(
    		  		'id_kecamatan' => $key,
    		  		'id_event'	   => $lastid,	
    		  	);
    		  	$this->kontingenkecamatan_model->insert($kontingenkecamatandata);

    		}

            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('event'));
    	}
    }

    public function update($id){
    	 $row = $this->eventolahraga_model->get_by_id($id);
    	 if ($row) {
    	 	$this->data = array(
	    		'button' => 'Update',
	    		'action' => site_url('event/update_action'),
	    		'id'	=> set_value('id', $row->id),
	    		'name'  => set_value('name', $row->name),
	    		'tglmulai' =>set_value('tglmulai', date_for_form($row->tglmulai)  ),
	    		'tglselesai' => set_value('tglselesai', date_for_form($row->tglselesai)),
	    		'tingkat' => set_value('tingkat', $row->tingkat),
	    		'tglmulai_pendaftaran' => set_value('tglmulai_pendaftaran', date_for_form($row->tglmulai_pendaftaran)),
	    		'tglselesai_pendaftaran' => set_value('tglselesai_pendaftaran',  date_for_form($row->tglselesai_pendaftaran)),
	    		'status_pendaftaran' => set_value('status_pendaftaran', $row->status_pendaftaran),
	    		'klasmen' => set_value('klasmen', $row->klasmen),
	    		'tingkatan_option' => $this->tingkatan_option,
	    	);

    	 	$this->content = 'event/event/event_form';
            $this->layout();
    	 }else{
    	 	 $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('event'));
    	 }

    }


    public function update_action(){
    	$this->_rules();
        

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
        	$data = array(
	    		'name'  =>  $this->input->post('name',TRUE),
	    		'tglmulai' =>  date_for_mysql($this->input->post('tglmulai',TRUE)),
	    		'tglselesai' => date_for_mysql($this->input->post('tglselesai',TRUE)),
	    		'tingkat' => $this->input->post('tingkat',TRUE),
	    		'tglmulai_pendaftaran' => date_for_mysql($this->input->post('tglmulai_pendaftaran',TRUE)),
	    		'tglselesai_pendaftaran' => date_for_mysql($this->input->post('tglselesai_pendaftaran',TRUE)),
	    		'status_pendaftaran' =>  $this->input->post('status_pendaftaran',TRUE),
	    		'klasmen' =>  $this->input->post('klasmen',TRUE),
	    	
    		);


        	$this->eventolahraga_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('event'));
        }
    }

     public function delete($id) 
    {
        $row = $this->eventolahraga_model->get_by_id($id);
        if ($row) {
            $this->eventolahraga_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            $this->kontingenkecamatan_model->delete_by_event($id);
            $this->kontingeneventolahraga_model->delete_by_event($id);
            $this->Kontingeneventolahragacabor_model->delete_by_event($id);
            redirect(site_url('event'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('event'));
        }
    }



    public function kontingen($id_event){
    	$kontingenkecamatan = $this->kontingenkecamatan_model->get_by_event($id_event);
    	$row = $this->eventolahraga_model->get_by_id($id_event);
    	$this->data = array(
    		'kontingenkecamatan' => $kontingenkecamatan,
    		'id_event'			 => $id_event,
    		'namaeven'		     => $row->name,
    		'kecamatan_option' => $this->kecamatan_option,
    	);

    	$this->content = 'event/event/kontingen';
        $this->layout();
    }

    public function kontingenpersonil($id_event, $id_kecamatan){
    	$keyword = '';
       
        $personil = $this->kontingeneventolahraga_model->get_all($id_event, $id_kecamatan);
         $event = $this->eventolahraga_model->get_by_id($id_event);

        $this->data = array(
          	'personil' => $personil,
          	'back'	   => '/event/kontingen/'.$id_event,
          	'id_event' => $id_event,
          	'id_kecamatan' => $id_kecamatan,
            'event'     => $event
        );
        $this->content = 'event/event/kontingenpersonil_list'; 
        $this->layout();		
    }

    public function readeventkontingenperson($id) 
    {
        $row = $this->kontingeneventolahraga_model->get_by_id($id);
        if ($row) {
            $this->data = array(
                'id'         => $row->id,
                'id_event'   => $row->id_event,
                'id_kecamatan' => $row->id_kecamatan,
                'nama'       => $row->nama,
                'kelamin'    => $row->kelamin,
                'tmp_lahir'  => $row->tmp_lahir,
                'tgl_lahir'  => date_formater($row->tgl_lahir),
                'alamat'     => $row->alamat,
                'cabang'     => $this->cabang_option[$row->cabang],
                'alamat'     => $row->alamat,
                'telepon'    => $row->telepon,
                'posisi'     => $row->posisi,
                'sertifikat' => $row->sertifikat,
                'sekolah'    => $row->sekolah,
                'kelas'      => $row->kelas,
                'tinggibadan'=> $row->tinggibadan,
                'beratbadan' => $row->beratbadan,
                'foto'       => $row->foto,

           );

            $this->content = 'event/event/readeventkontingenperson';
            $this->layout();
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            $this->content = 'event/event/kontingenpersonil_list';
        }
    }

    public function eventkontingeninsertperson($id_event, $id_kecamatan){

    	$this->load->library('user_agent');
    	$event = $this->eventolahraga_model->get_by_id($id_event);
    	$kelascabor = $this->kelascabor_model->get_by_tingkat( $event->tingkat);

    	$this->data = array(
    		'button' 			=> 'Create',
    		'action' 			=> site_url('event/eventkontingeninsertpersonaction'), 
    		'id'       			=> set_value('id'),
    		'id_event' 			=> $id_event,
    		'id_kecamatan'  	=> $id_kecamatan,
    		'nama'				=> set_value('nama'),
    		'tmp_lahir'			=> set_value('tmp_lahir'),
    		'tgl_lahir'			=> set_value('tgl_lahir'),
    		'kelamin'			=> set_value('kelamin'),
    		'alamat'			=> set_value('alamat'),
    		'telepon'			=> set_value('telepon'),
    		'posisi'			=> set_value('posisi'),
            'sertifikat'        => set_value('sertifikat'),
            'sekolah'           => set_value('sekolah'),
            'kelas'             => set_value('kelas'),
            'beratbadan'        => set_value('beratbadan'),
    		'tinggibadan'	    => set_value('tinggibadan'),
    		'event_tingkat'     => $event->tingkat, 
    		'cabang_option' 	=> $this->cabang_option,
    		'jenis_option'  	=> $this->jenis_option,
    		'kelascabor'		=> array(),
    		'tingkatan_option'  => $this->tingkatan_option,
    		'back'				=> $this->agent->referrer(),
    	);

    	$this->content = 'event/event/eventkontingeninsertperson';
    	$this->layout();		
    		
    }

    public function doPrint($id_event, $id_kecamatan){
        $event = $this->eventolahraga_model->get_by_id($id_event);
        $personil = $this->kontingeneventolahraga_model->get_all_print($id_event, $id_kecamatan);


        $data = array(
            'event' => $event,
            'personil' => $personil,
            'kecamatan' =>  $this->kecamatan_option,
        );   
        // print_r($data); die(); 
        $this->load->view('event/event/print',$data);
    }


    public function eventkontingeninsertpersonaction(){
        $this->_ruleskontingen();

        $id_event = $this->input->post('id_event',TRUE);
        $id_kecamatan = $this->input->post('id_kecamatan',TRUE) ;

        $name_foto = '';
        if ($_FILES['foto']['size']>0) {
            $name_foto = $this->doUpload('foto');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->eventkontingeninsertperson($id_event, $id_kecamatan);
        } else {
            $data = array(
            	'id_event' 			=> $id_event,
    			'id_kecamatan'  	=> $id_kecamatan,
    			'nama'				=> $this->input->post('nama',TRUE),
    			'tmp_lahir'			=> $this->input->post('tmp_lahir',TRUE),
    			'tgl_lahir'			=> date_for_mysql($this->input->post('tgl_lahir',TRUE)),
    			'kelamin'			=> $this->input->post('kelamin',TRUE),
    			'alamat'			=> $this->input->post('alamat',TRUE),
    			'telepon'			=> $this->input->post('telepon',TRUE),
    			'posisi'			=> $this->input->post('posisi',TRUE),
                'sertifikat'        => $this->input->post('sertifikat',TRUE),
                'sekolah'           => $this->input->post('sekolah',TRUE),
                'kelas'             => $this->input->post('kelas',TRUE),
    			'beratbadan'        => $this->input->post('beratbadan',TRUE),
                'tinggibadan'       => $this->input->post('tinggibadan',TRUE),
                'cabang'			=> $this->input->post('cabang',TRUE),
        		'foto' 				=> $name_foto,
    	    );

            $idinserted = $this->kontingeneventolahraga_model->insert($data);


            foreach ($this->input->post('kelas_cabor',TRUE) as $k => $v) {
				$subcabordata = array(
                    'id_event' => $id_event,
					'id_kontingen_person' => $idinserted, 
					'id_cabor' => $this->input->post('cabang',TRUE),
					'id_kelascabor' => $v,
				);	
				$this->Kontingeneventolahragacabor_model->insert($subcabordata);

           	}

            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('event/kontingen/personil/'.$id_event.'/'.$id_kecamatan));
        }
    }


    public function eventkontingenupdateperson($id){
    	$row = $this->kontingeneventolahraga_model->get_by_id($id);
        $event = $this->eventolahraga_model->get_by_id($row->id_event);
                        
    	 if ($row) {

    	 	$kontingencabor = $this->Kontingeneventolahragacabor_model->get_by_kontingen($row->id);

    	 	$this->data = array(
	    		'button' => 'Update',
	    		'action' => site_url('event/eventkontingenupdateaction'),
	    		'id'       			=> set_value('id', $row->id),
    			'id_event' 			=> $row->id_event,
    			'id_kecamatan'  	=> $row->id_kecamatan,
    			'nama'				=> set_value('nama', $row->nama),
    			'tmp_lahir'			=> set_value('tmp_lahir', $row->tmp_lahir ),
    			'tgl_lahir'			=> set_value('tgl_lahir', date_for_form($row->tgl_lahir) ),
    			'kelamin'			=> set_value('kelamin', $row->kelamin),
    			'alamat'			=> set_value('alamat', $row->alamat),
    			'telepon'			=> set_value('telepon', $row->telepon),
    			'posisi'			=> set_value('posisi', $row->posisi),
                'sertifikat'        => set_value('sertifikat', $row->sertifikat),
                'sekolah'           => set_value('sekolah', $row->sekolah),
                'kelas'             => set_value('kelas', $row->kelas),
    			'tinggibadan'       => set_value('tinggibadan', $row->tinggibadan),
                'beratbadan'        => set_value('beratbadan', $row->beratbadan),
                'cabang'			=> set_value('cabang', $row->cabang),
    			'foto'				=> set_value('foto', $row->foto),
    			'cabang_option' 	=> $this->cabang_option,
    			'jenis_option'  	=> $this->jenis_option,
    			'kontingencabor'	=> $kontingencabor,
    			'tingkatan_option'  => $this->tingkatan_option,
                'event_tingkat'     => $event->tingkat,
	    	);

    	 	$event = $this->eventolahraga_model->get_by_id($row->id_event);
            // $kelascabor = $this->kelascabor_model->get_by_cabang($id,$tingkat);
    		$kelascabor = $this->kelascabor_model->get_by_cabang_edit( $row->cabang,$event->tingkat);

            // print_r($kelascabor); die();

    		$this->data['kelascabor'] = $kelascabor;


    	 	$this->content = 'event/event/eventkontingeninsertperson';
    		$this->layout();
    	 }
    }


    public function eventkontingenupdateaction(){
    	$this->_ruleskontingen();
        $name_foto ='';

        if ($this->form_validation->run() == FALSE) {
        	// echo $this->input->post('id', TRUE); die();
            $this->eventkontingenupdateperson($this->input->post('id', TRUE));
        } else {
            if ($_FILES['foto']['size']>0) {
                $name_foto = $this->doUpload('foto');
            }

            $data = array(
        		'id_event' 			=> $this->input->post('id_event',TRUE),
    			'id_kecamatan'  	=> $this->input->post('id_kecamatan',TRUE),
    			'nama'				=> $this->input->post('nama',TRUE),
    			'tmp_lahir'			=> $this->input->post('tmp_lahir',TRUE),
    			'tgl_lahir'			=> date_for_mysql($this->input->post('tgl_lahir',TRUE)),
    			'kelamin'			=> $this->input->post('kelamin',TRUE),
    			'alamat'			=> $this->input->post('alamat',TRUE),
    			'telepon'			=> $this->input->post('telepon',TRUE),
    			'posisi'			=> $this->input->post('posisi',TRUE),
                'sertifikat'        => $this->input->post('sertifikat',TRUE),
                'sekolah'           => $this->input->post('sekolah',TRUE),
                'kelas'             => $this->input->post('kelas',TRUE),
                'tinggibadan'       => $this->input->post('tinggibadan',TRUE),
                'beratbadan'        => $this->input->post('beratbadan',TRUE),
    			'cabang'			=> $this->input->post('cabang',TRUE),
	        );

             if ($name_foto!='') {
                $data['foto'] = $name_foto;
                $row = $this->kontingeneventolahraga_model->get_by_id($this->input->post('id', TRUE));
                if (!empty($row->foto) ) { //
                    $this->deleteOldPhoto($row->foto); //
                } //
            }

            $id_event 		= $this->input->post('id_event',TRUE);
            $id_kecamatan 	=  $this->input->post('id_kecamatan',TRUE) ;

            $this->kontingeneventolahraga_model->update($this->input->post('id', TRUE), $data);

            $this->Kontingeneventolahragacabor_model->delete_by_person( $this->input->post('id', TRUE));

            foreach ($this->input->post('kelas_cabor',TRUE) as $k => $v) {
				$subcabordata = array(
                    'id_event' => $id_event,
					'id_kontingen_person' => $this->input->post('id', TRUE), 
					'id_cabor' => $this->input->post('cabang',TRUE),
					'id_kelascabor' => $v,
				);	
				$this->Kontingeneventolahragacabor_model->insert($subcabordata);

           	}


            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('event/kontingen/personil/'.$id_event.'/'.$id_kecamatan) );
        }
    }


    public function eventkontingendeleteperson($id) {
    	$row = $this->kontingeneventolahraga_model->get_by_id($id);
        if ($row) {
        	$id_event = $row->id_event;
        	$id_kecamatan = $row->id_kecamatan;
            if (!empty($row->foto) ) { 
                    $this->deleteOldPhoto($row->foto); 
            } 
            $this->kontingeneventolahraga_model->delete($id);
            $this->Kontingeneventolahragacabor_model->delete_by_person($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('event/kontingen/personil/'.$id_event.'/'.$id_kecamatan) );
        } 
    }


    public function getKelasCabang(){
        $id =  $this->input->post('id',TRUE);
        $tingkat =  $this->input->post('tingkat',TRUE);
        $kelas = $this->kelascabor_model->get_by_cabang($id,$tingkat);
        $data['json']['data'] = array(
                    'sukses' => 1,
                    'kelas' => $kelas,
                
        );
        $this->load->view('json', $data);

    }



    public function _rules() 
    {
    	$this->form_validation->set_rules('name', ' ', 'trim|required');
    	$this->form_validation->set_rules('tglmulai', ' ', 'trim|required');
    	$this->form_validation->set_rules('tglselesai', ' ', 'trim|required');
    	
    	

    	$this->form_validation->set_rules('id', 'id', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }


    public function _ruleskontingen() 
    {
    	$this->form_validation->set_rules('nama', ' ', 'trim|required');
    	$this->form_validation->set_rules('cabang', ' ', 'trim|required');
    	// $this->form_validation->set_rules('jenis', ' ', 'trim|required');
    	$this->form_validation->set_rules('id', 'id', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }


    
}

/* End of file atlit.php */
/* Location: ./application/controllers/atlit.php */