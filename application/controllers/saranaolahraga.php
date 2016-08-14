<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Saranaolahraga extends My_Controller
{
    private $base_url = 'saranaolahraga/index';
    private $_menu = 'saranaolahraga';
    private $total_rows ;
    private $kecamatan_option;
    function __construct()
    {
        parent::__construct();
        $this->load->model('saranaolahraga_model');
        $this->load->library('form_validation');
        $this->load->model('kecamatan_model');
        $this->load->library('pagination');
        $this->total_rows =  $this->saranaolahraga_model->total_rows();
        $this->kecamatan_option = $this->kecamatan_model->get_all_array();
    }

    public function index()
    {
        $keyword = '';
        $config = getConfigPaging($this->base_url, $this->total_rows, $this->_menu );
        $this->pagination->initialize($config);
        $start = $this->uri->segment(3, 0);
        $saranaolahraga = $this->saranaolahraga_model->index_limit($config['per_page'], $start);

        $this->data = array(
            'saranaolahraga_data' => $saranaolahraga,
            'keyword' => $keyword,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );

        $this->content = 'sapras/saranaolahraga/saranaolahraga_list';
        $this->layout();
    }
    
    public function search() 
    {
        $keyword = $this->uri->segment(3, $this->input->post('keyword', TRUE));
        
        if ($this->uri->segment(2)=='search') {
            $config['base_url'] = base_url() . 'saranaolahraga/search/' . $keyword;
        } else {
            $config['base_url'] = base_url() . 'saranaolahraga/index/';
        }
        $this->total_rows = $this->saranaolahraga_model->search_total_rows($keyword);
        $this->_menu = 'saranaolahraga/search/'.$keyword.'';
        $config = getConfigPaging($this->base_url, $this->total_rows, $this->_menu, 1 );

        $this->pagination->initialize($config);

        $start = $this->uri->segment(4, 0);
        $saranaolahraga = $this->saranaolahraga_model->search_index_limit($config['per_page'], $start, $keyword);

        $this->data = array(
            'saranaolahraga_data' => $saranaolahraga,
            'keyword' => $keyword,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->content = 'sapras/saranaolahraga/saranaolahraga_list';
        $this->layout();
    }

    public function read($id) 
    {
        $row = $this->saranaolahraga_model->get_by_id($id);
        if ($row) {
            $this->data = array(
		'id' => $row->id,
		'name' => $row->name,
		'alamat' => $row->alamat,
		'kecamatan' => $this->kecamatan_option[$row->kecamatan],
		'kondisi' => $row->kondisi,
		'kategori' => $row->kategori,
		'kepemilikan' => $row->kepemilikan,
		'kapasitas' => $row->kapasitas,
	    );
            $this->content = 'sapras/saranaolahraga/saranaolahraga_read';
            $this->layout();
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('saranaolahraga'));
        }
    }
    
    public function create() 
    {
        $this->data = array(
            'button' => 'Create',
            'action' => site_url('saranaolahraga/create_action'),
	    'id' => set_value('id'),
	    'name' => set_value('name'),
	    'alamat' => set_value('alamat'),
	    'kecamatan' => set_value('kecamatan'),
	    'kondisi' => set_value('kondisi'),
	    'kategori' => set_value('kategori'),
	    'kepemilikan' => set_value('kepemilikan'),
	    'kapasitas' => set_value('kapasitas'),
        'kecamatan_option' => $this->kecamatan_option,
	);
        $this->content = 'sapras/saranaolahraga/saranaolahraga_form';
        $this->layout();
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'name' => $this->input->post('name',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'kecamatan' => $this->input->post('kecamatan',TRUE),
		'kondisi' => $this->input->post('kondisi',TRUE),
		'kategori' => $this->input->post('kategori',TRUE),
		'kepemilikan' => $this->input->post('kepemilikan',TRUE),
		'kapasitas' => $this->input->post('kapasitas',TRUE),
	    );

            $this->saranaolahraga_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('saranaolahraga'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->saranaolahraga_model->get_by_id($id);

        if ($row) {
            $this->data = array(
                'button' => 'Update',
                'action' => site_url('saranaolahraga/update_action'),
		'id' => set_value('id', $row->id),
		'name' => set_value('name', $row->name),
		'alamat' => set_value('alamat', $row->alamat),
		'kecamatan' => set_value('kecamatan', $row->kecamatan),
		'kondisi' => set_value('kondisi', $row->kondisi),
		'kategori' => set_value('kategori', $row->kategori),
		'kepemilikan' => set_value('kepemilikan', $row->kepemilikan),
		'kapasitas' => set_value('kapasitas', $row->kapasitas),
        'kecamatan_option' => $this->kecamatan_option,
	    );
            $this->content = 'sapras/saranaolahraga/saranaolahraga_form';
            $this->layout();
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('saranaolahraga'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'name' => $this->input->post('name',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'kecamatan' => $this->input->post('kecamatan',TRUE),
		'kondisi' => $this->input->post('kondisi',TRUE),
		'kategori' => $this->input->post('kategori',TRUE),
		'kepemilikan' => $this->input->post('kepemilikan',TRUE),
		'kapasitas' => $this->input->post('kapasitas',TRUE),
	    );

            $this->saranaolahraga_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('saranaolahraga'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->saranaolahraga_model->get_by_id($id);

        if ($row) {
            $this->saranaolahraga_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('saranaolahraga'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('saranaolahraga'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('name', ' ', 'trim|required');
	$this->form_validation->set_rules('alamat', ' ', 'trim|required');
	$this->form_validation->set_rules('kecamatan', ' ', 'trim|required|numeric');
	$this->form_validation->set_rules('kondisi', ' ', 'trim|required|numeric');
	$this->form_validation->set_rules('kategori', ' ', 'trim|required|numeric');
	$this->form_validation->set_rules('kepemilikan', ' ', 'trim|required');
	$this->form_validation->set_rules('kapasitas', ' ', 'trim|required|numeric');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel(){
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Saranaolahraga list');


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
                        'name' => 'Nama',
                        'alamat'  => 'Tempat / Tgl Lahir',
                        'kecamatan' => 'Kecamatan',
                        'kondisi'    => 'Kondisi',
                        'kategori' => 'Kategori',
                        'kepemilikan'  => 'Kepemilikan',
                        'kapasitas'  => 'Kapasitas'
                      );


        $saranaolahraga = $this->saranaolahraga_model->get_all_excel(); 
         
       

        $row = 1;
        $header = $this->excel->getSheet(0);
        foreach(range('A','H') as $columnID) {
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
       foreach ($saranaolahraga as $key => $val) {
             $col = 0;
          
            foreach ($field as $kf => $vf) {
                if ($kf == 'kondisi') {
                     $this->excel->getActiveSheet()
                         ->setCellValueByColumnAndRow($col, $row, getKondisi($val['kondisi']) )
                         ->getStyleByColumnAndRow($col, $row)
                         ->applyFromArray($styleArray)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);   
                         $col++;
                }else if ($kf == 'kategori') {
                     $this->excel->getActiveSheet()
                         ->setCellValueByColumnAndRow($col, $row, getKategori($val['kategori']) )
                         ->getStyleByColumnAndRow($col, $row)
                         ->applyFromArray($styleArray)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);   
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

       
        $filename='saranaolahraga.xls'; 
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); 
        header('Cache-Control: max-age=0'); 
 
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        ob_end_clean();
        $objWriter->save('php://output');
    }

};

/* End of file saranaolahraga.php */
/* Location: ./application/controllers/saranaolahraga.php */