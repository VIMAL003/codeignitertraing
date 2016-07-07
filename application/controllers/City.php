<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class City extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('City_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'city/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'city/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'city/index.html';
            $config['first_url'] = base_url() . 'city/index.html';
        }

        $config['per_page'] = 2;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->City_model->total_rows($q);
        $city = $this->City_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'city_data' => $city,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('city/city_list', $data);
    }

    public function read($id) 
    {
        $row = $this->City_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'name' => $row->name,
	    );
            $this->load->view('city/city_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('city'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('city/create_action'),
	    'id' => set_value('id'),
	    'name' => set_value('name'),
	);
        $this->load->view('city/city_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'name' => $this->input->post('name',TRUE),
	    );

            $this->City_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('city'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->City_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('city/update_action'),
		'id' => set_value('id', $row->id),
		'name' => set_value('name', $row->name),
	    );
            $this->load->view('city/city_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('city'));
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
	    );

            $this->City_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('city'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->City_model->get_by_id($id);

        if ($row) {
            $this->City_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('city'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('city'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('name', 'name', 'trim|required|is_unique[city.name]');

	$this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_message('required', 'The %s is required.');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "city.xls";
        $judul = "city";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Name");

	foreach ($this->City_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->name);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file City.php */
/* Location: ./application/controllers/City.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-07-05 15:04:41 */
/* http://harviacode.com */