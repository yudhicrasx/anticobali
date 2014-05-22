<?php

if (!defined('BASEPATH'))
    die();

class Subscribe extends Main_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('m_refer', 'mr');
        $this->load->library('form_validation');
    }

    public function index() {
        $this->_set_rules();
        $data = array();
        if($this->input->post('bot_trap')) { //Bot Trap
            redirect(base_url());
        }

        if ($this->form_validation->run()) {
            $d = parse_form($this->input->post());
            $query_insert = $this->mr->insert_update($d);
            if ($query_insert) {
                $code = 1;
                $msg = 'Your email has been saved. Thank you for subscribe.';
            } else {
                $code = 2;
                $msg = 'Your email can not be saved. Please insert a correct email.';
            }
            $this->session->set_flashdata('flash_msg', alertMsg($code, $msg));
            redirect(base_url());
        }
        $this->data['my_body'] = $this->load->view('public/v_homepage', $data, true);
        $this->global_template($this->data, 'v_index', 'public');
    }

    public function _set_rules() {
        $rules = array(
            array(
                'field' => 'input_subscribers_email',
                'label' => 'Email Subscribe',
                'rules' => 'required|email|trim'
            )
        );
        $this->form_validation->set_rules($rules);
    }

}

/* End of file search.php */
/* Location: ./application/controllers/search.php */
