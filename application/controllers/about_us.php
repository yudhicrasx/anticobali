<?php

if (!defined('BASEPATH'))
    die();

class About_us extends Main_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $data = array();
        
        $this->data['my_body'] = $this->load->view('public/v_about_us', $data, true);
        $this->global_template($this->data, 'v_index', 'public');
    }
    
    public function faq() {
        $data = array();
        
        $this->data['my_body'] = $this->load->view('public/v_faq', $data, true);
        $this->global_template($this->data, 'v_index', 'public');
    }

}

/* End of file items.php */
/* Location: ./application/controllers/admin/items.php */
