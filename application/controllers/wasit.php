<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wasit extends MY_Controller
{
    private $base_url =  'wasit/index/';
    private $_menu = 'wasit'; 
    private $total_rows ;
    private $cabang_option ;
    private $jenis_option ;
    private $kecamatan_option ;

    function __construct()
    {
        parent::__construct();
        $this->load->model('wasit_model');
        $this->load->library('form_validation');
        $this->load->model('cabor_model');
        $this->load->model('jenis_model');
        $this->load->model('kecamatan_model');
        $this->load->library('pagination');
         $this->load->model('sertifikatwasit_model');
        $this->total_rows =  $this->wasit_model->total_rows();
        $this->cabang_option = $this->cabor_model->get_all_array();
        $this->jenis_option = $this->jenis_model->get_all_array();
        $this->kecamatan_option = $this->kecamatan_model->get_all_array();
    }

    public function index()
    {
        $keyword = '';
        $config = getConfigPaging($this->base_url, $this->total_rows, $this->_menu );
        $this->pagination->initialize($config);

        $start = $this->uri->segment(3, 0);
        $wasit = $this->wasit_model->index_limit($config['per_page'], $start);

        $this->data = array(
            'wasit_data' => $wasit,
            'keyword' => $keyword,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );

        $this->content = 'olahraga/wasit/wasit_list';
        $this->layout();
    }
    
    public function search() 
    {
        $keyword = $this->uri->segment(3, $this->input->post('keyword', TRUE));
        $this->load->library('pagination');
        
        if ($this->uri->segment(2)=='search') {
             $this->base_url =  'wasit/search/' . $keyword;
        } else {
             $this->base_url =  'wasit/index/';
        }

        $this->total_rows = $this->wasit_model->search_total_rows($keyword);
        $this->_menu = 'wasit/search/'.$keyword.'';
        $config = getConfigPaging($this->base_url, $this->total_rows, $this->_menu, 1 );

        $this->pagination->initialize($config);

        $start = $this->uri->segment(4, 0);
        $wasit = $this->wasit_model->search_index_limit($config['per_page'], $start, $keyword);

        $this->data = array(
            'wasit_data' => $wasit,
            'keyword' => $keyword,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->content = 'olahraga/wasit/wasit_list';
        $this->layout();
    }

    public function read($id) 
    {
        $row = $this->wasit_model->get_by_id($id);
        if ($row) {
            $this->data = array(
		'id' => $row->id,
		'cabang' => $this->cabang_option[$row->cabang],
		'jenis' => $this->jenis_option[$row->jenis],
		'kecamatan' => $this->kecamatan_option[$row->kecamatan],
		'nama' => $row->nama,
		'tmp_lahir' => $row->tmp_lahir,
		'tgl_lahir' => date_formater($row->tgl_lahir),
		'alamat' => $row->alamat,
		'kelamin' => $row->kelamin,
		'telepon' => $row->telepon,
		'foto' => $row->foto,
	    );
            $this->content = 'olahraga/wasit/wasit_read';
            $this->layout();
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('wasit'));
        }
    }
    
    public function create() 
    {
        $this->data = array(
            'button' => 'Create',
            'action' => site_url('wasit/create_action'),
	    'id' => set_value('id'),
	    'cabang' => set_value('cabang'),
	    'jenis' => set_value('jenis'),
	    'kecamatan' => set_value('kecamatan'),
	    'nama' => set_value('nama'),
	    'tmp_lahir' => set_value('tmp_lahir'),
	    'tgl_lahir' => set_value('tgl_lahir'),
	    'alamat' => set_value('alamat'),
	    'kelamin' => set_value('kelamin'),
	    'telepon' => set_value('telepon'),
	    'foto' => set_value('foto'),
        'cabang_option' => $this->cabang_option,
        'jenis_option' => $this->jenis_option,
        'kecamatan_option' => $this->kecamatan_option,
	);
        $this->content = 'olahraga/wasit/wasit_form';
        $this->layout();
    }
    
    public function create_action() 
    {
        $this->_rules();

        $name_foto = '';
        if ($_FILES['foto']['size']>0) {
            $name_foto = $this->doUpload('foto');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'jenis' => $this->input->post('jenis',TRUE),
		'cabang' => $this->input->post('cabang',TRUE),
        'kecamatan' => $this->input->post('kecamatan',TRUE),
		'nama' => $this->input->post('nama',TRUE),
		'tmp_lahir' => $this->input->post('tmp_lahir',TRUE),
		'tgl_lahir' => date_for_mysql($this->input->post('tgl_lahir',TRUE)),
		'alamat' => $this->input->post('alamat',TRUE),
		'kelamin' => $this->input->post('kelamin',TRUE),
		'telepon' => $this->input->post('telepon',TRUE),
		'foto' => $name_foto,
	    );

            $this->wasit_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('wasit'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->wasit_model->get_by_id($id);

        if ($row) {
            $this->data = array(
                'button' => 'Update',
                'action' => site_url('wasit/update_action'),
        		'id' => set_value('id', $row->id),
        		'cabang' => set_value('cabang', $row->cabang),
        		'jenis' => set_value('jenis', $row->jenis),
        		'kecamatan' => set_value('kecamatan', $row->kecamatan),
        		'nama' => set_value('nama', $row->nama),
        		'tmp_lahir' => set_value('tmp_lahir', $row->tmp_lahir),
        		'tgl_lahir' => set_value('tgl_lahir', date_for_form($row->tgl_lahir)),
        		'alamat' => set_value('alamat', $row->alamat),
        		'kelamin' => set_value('kelamin', $row->kelamin),
        		'telepon' => set_value('telepon', $row->telepon),
        		'foto' => set_value('foto', $row->foto),
                'cabang_option' => $this->cabang_option,
                'jenis_option' => $this->jenis_option,
                'kecamatan_option' => $this->kecamatan_option,
	    );
            $this->content = 'olahraga/wasit/wasit_form';
            $this->layout();
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('wasit'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
        $name_foto ='';

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            if ($_FILES['foto']['size']>0) {
                $name_foto = $this->doUpload('foto');
            }

            $data = array(
        		'cabang' => $this->input->post('cabang',TRUE),
        		'jenis' => $this->input->post('jenis',TRUE),
        		'kecamatan' => $this->input->post('kecamatan',TRUE),
        		'nama' => $this->input->post('nama',TRUE),
        		'tmp_lahir' => $this->input->post('tmp_lahir',TRUE),
        		'tgl_lahir' => date_for_mysql($this->input->post('tgl_lahir',TRUE)),
        		'alamat' => $this->input->post('alamat',TRUE),
        		'kelamin' => $this->input->post('kelamin',TRUE),
        		'telepon' => $this->input->post('telepon',TRUE),
        		
	    );

            if ($name_foto!='') {
                $data['foto'] = $name_foto;
                $row = $this->wasit_model->get_by_id($this->input->post('id', TRUE));
                if (!empty($row->foto) ) {
                    $this->deleteOldPhoto($row->foto);
                }
            }

            $this->wasit_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('wasit'));
        }
    }

    public function delete($id) 
    {
        $row = $this->wasit_model->get_by_id($id);

        if ($row) {
            if (!empty($row->foto) ) { //
                    $this->deleteOldPhoto($row->foto); //
                }
            $this->wasit_model->delete($id);
            $this->sertifikatwasit_model->deletebywasit($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('wasit'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('wasit'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('cabang', ' ', 'trim|required|numeric');
	$this->form_validation->set_rules('jenis', ' ', 'trim|required|numeric');
	$this->form_validation->set_rules('kecamatan', ' ', 'trim|required|numeric');
	$this->form_validation->set_rules('nama', ' ', 'trim|required');
	$this->form_validation->set_rules('tmp_lahir', ' ', 'trim|required');
	$this->form_validation->set_rules('tgl_lahir', ' ', 'trim|required');
	$this->form_validation->set_rules('alamat', ' ', 'trim|required');
	$this->form_validation->set_rules('kelamin', ' ', 'trim|required|numeric');
	$this->form_validation->set_rules('telepon', ' ', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function sertifikat($id){
          $row = $this->wasit_model->get_by_id($id);
          $this->data = array(
            'id_wasit'    => $id,
            'sertifikat_wasit' => $this->sertifikatwasit_model->get_by_wasit($id),
            'nama' => $row->nama,
          );

          $this->content = 'olahraga/wasit/sertifikat';
          $this->layout();
    }

    public function deletesertifikat($idwasit,$id){
        $row = $this->sertifikatwasit_model->get_by_id($id);
        if ($row) {
            $this->sertifikatwasit_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            $this->sertifikat($idwasit);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
             $this->sertifikat($idwasit);
        }  
    }

    public function sertifikatbyid($id){
        $row = $this->sertifikatwasit_model->get_by_id($id);

        if ($row) {
            $data['json']['data'] = array(
                    'sukses' => 1,
                    'form' => array(
                        'id' => $row->id,
                        'id_wasit' => $row->id_wasit,
                        'tingkat' => $row->tingkat,
                        'sertifikatname' => $row->sertifikatname,
                        'tahun' => $row->tahun,
                    ),
                );
        }else{
            $data['json']['data'] = array(
                    'sukses' => 0,
                    'message' =>  'Tidak Ditemukan'
                );
        }
        $this->load->view('json', $data);
    }

    public function sertifikatsave(){

        $data = array(
            'id_wasit' => $this->input->post('id_wasit',TRUE),
            'tingkat' => $this->input->post('tingkat',TRUE),
            'sertifikatname' => $this->input->post('sertifikatname',TRUE),
            'tahun' => $this->input->post('tahun',TRUE),
        );
        $insertid = $this->sertifikatwasit_model->insert($data);
        if ($insertid>0) {
            $data['json']['data'] = array(
                    'sukses' => 1,
                    'message' => 'Berhasil disimpan',
            );
        }else{
             $data['json']['data'] = array(
                    'sukses' => 0,
                    'message' => 'Gagal Disimpan',
            );
        }
       
        $this->load->view('json', $data);

    }

    public function sertifikatupdate(){
         $data = array(
            'id_wasit' => $this->input->post('id_wasit',TRUE),
            'tingkat' => $this->input->post('tingkat',TRUE),
            'sertifikatname' => $this->input->post('sertifikatname',TRUE),
            'tahun' => $this->input->post('tahun',TRUE),
        );
        $update_id = $this->sertifikatwasit_model->update( $this->input->post('id_sertifikat',TRUE) ,$data);
        if ($this->sertifikatwasit_model->get_by_id( $this->input->post('id_sertifikat',TRUE))) {
            $data['json']['data'] = array(
                    'sukses' => 1,
                    'message' => 'Berhasil disimpan',
            );
        }else{
             $data['json']['data'] = array(
                    'sukses' => 0,
                    'message' => 'Gagal Disimpan',
            );
        }
       
        $this->load->view('json', $data);        
    }

    public function excel(){
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Wasit list');


        $styleArray = array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          )
        );    

        $th = array(
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '000000'),
                'size'  => 12,
                'name'  => 'Arial', 
            ));
        $fill = array(
            'type' => 'solid',
            'startcolor' => array(
             'rgb' => '40E0D0',
            )
        );

        //[tmp_lahir] => Klaten
        //[tgl_lahir] => 1989-06-23

        $field = array(
                        'no' => 'No.',
                        'nama' => 'Nama',
                        'ttl'  => 'Tempat / Tgl Lahir',
                        'kecamatan' => 'Kecamatan',
                        'alamat'    => 'Alamat',
                        'cabang' => 'Cabang OR',
                        'sertifikat'  => 'Sertifikasi'
                      );


        $wasit = $this->wasit_model->get_all_excel(); 
         
       

        $row = 1;
        $header = $this->excel->getSheet(0);
        foreach(range('A','G') as $columnID) {
             $this->excel->getActiveSheet()->getColumnDimension($columnID)
            ->setAutoSize(true);
        }

        $col = 0    ;
        foreach ($field as $key => $value) {
              $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $value);
              $this->excel->getActiveSheet()->getStyleByColumnAndRow($col,$row)->applyFromArray($th)->getFill()->applyFromArray($fill);
              $col++;  
        }
     
       $row = 2;
       $nomer = 1;
       foreach ($wasit as $key => $val) {
             $col = 0;
          
            foreach ($field as $kf => $vf) {
                if ($kf == 'ttl') {
                     $this->excel->getActiveSheet()
                         ->setCellValueByColumnAndRow($col, $row, $val['tmp_lahir'].', '.date_formater($val['tgl_lahir']) )
                         ->getStyleByColumnAndRow($col, $row)
                         ->applyFromArray($styleArray)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);   
                         $col++;
                }else if ($kf == 'sertifikat'){
                    $string = "";
                    foreach ($val[$kf] as $kp => $vp) {
                        $string .= "- Sertifikat : ". $vp['sertifikatname']."\n Tingkat: ". $vp['tingkat']."\n Tahun: ". $vp['tahun']."\n"; 
                    }
                    $this->excel->getActiveSheet()
                         ->setCellValueByColumnAndRow($col, $row, $string)
                         ->getStyleByColumnAndRow($col, $row)
                         ->applyFromArray($styleArray)
                         ->getAlignment()
                         ->setWrapText(true);
                         $col++;  
                
                }else{
                     $this->excel->getActiveSheet()
                         ->setCellValueByColumnAndRow($col, $row, ($kf=='no')? $nomer : $val[$kf])
                         ->getStyleByColumnAndRow($col, $row)
                         ->applyFromArray($styleArray)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);   
                         $col++;    
                }
                

            }
            $nomer++;
                      
            $row++;
       }

       
        $filename='Wasit.xls'; 
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); 
        header('Cache-Control: max-age=0'); 
 
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        ob_end_clean();
        $objWriter->save('php://output');
    }
};

/* End of file wasit.php */
/* Location: ./application/controllers/wasit.php */