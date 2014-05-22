<?php

if (!defined('BASEPATH'))
    die();

class Search extends Main_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index() {
        $this->load->model('items_model');
        $this->_set_rules_search();
        $data = array();
        if ($this->form_validation->run()) {
            $data['query'] = $this->items_model->search($this->input->post('input_keyword'));
        }
        $this->data['my_body'] = $this->load->view('public/v_search', $data, true);
        $this->global_template($this->data, 'v_index', 'public');
    }

    public function _set_rules_search() {
        $rules = array(
            array(
                'field' => 'input_keyword',
                'label' => 'Keyword',
                'rules' => 'required|trim'
            )
        );
        $this->form_validation->set_rules($rules);
    }

}

/* End of file search.php */
/* Location: ./application/controllers/search.php */
