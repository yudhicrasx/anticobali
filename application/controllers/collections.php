<?php

if (!defined('BASEPATH'))
    die();

class Collections extends Main_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('m_refer', 'mr');
        $this->load->model('items_model');
        $this->load->model('categories_model', 'cm');
        $this->data['categories'] = $this->cm->select_order(TBL_CATEGORIES, '*', array('active'=>1));
    }
    
    public function index() {      
	  //  $this->load->model('items_model');
        //$data['query'] = $this->items_model->join_items_photos();
        //$where = array(TBL_ITEMS_CATEGORIES.'.id_categories' => 6);
       // $data['query'] = $this->items_model->join_items_photos();
        //$this->load->model('sliders_model');
       // $data['slider'] = $this->sliders_model->select_order(TBL_SLIDERS, "*", array('active'=>1), "", "order");
        $data['categories'] = $this->data['categories'];
		$data['urls'] = $this->mr->select_by(TBL_URL); //Short URL
        		
		$this->data['my_body'] = $this->load->view('public/v_collections', $data, true);
        $this->global_template($this->data, 'v_index', 'public');
    }
	
    public function details($id_item) {
        $data['query'] = $this->items_model->join_items_photos(array(TBL_ITEMS.'.id_items'=>$id_item));
		$data['urls'] = $this->mr->select_by(TBL_URL); //Short URL
        if($data['query']) {
            //$data['keywords'] = $data['query']->row()->keywords;
            $data['description'] = trim(preg_replace('/\s\s+/', ' ', strip_tags($data['query']->row()->description)));
        }
        $this->data['my_body'] = $this->load->view('public/v_item_details', $data, true);
        $this->global_template($this->data, 'v_index', 'public');
    }

}

/* End of file collections.php */
/* Location: ./application/controllers/collections.php */
