<?php

if (!defined('BASEPATH'))
    die();

class Category extends Main_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('m_refer', 'mr');
        $this->load->model('items_model');
        $this->load->library('form_validation');
        $this->_get_category();
    }

    private function _get_category() {
        $this->load->model('categories_model', 'cm');
        $this->data['categories'] = $this->cm->select_order(TBL_CATEGORIES, '*', array('active'=>1));
    }
    public function index($id_category = '') {
        $data['get_category'] = $this->mr->select_by(TBL_CATEGORIES, '*', array('id_categories' => $id_category));
        if ($id_category !== '') { //items per category
            $data['query'] = $this->items_model->join_items_itemsCategories(array(TBL_CATEGORIES . '.id_categories' => $id_category));
			$data['urls'] = $this->mr->select_by(TBL_URL); //Short URL
        } else { //list of items
            $data['query'] = $this->items_model->join_items_itemsCategories();
        }

        $this->data['my_body'] = $this->load->view('public/v_category', $data, true);
        $this->global_template($this->data, 'v_index', 'public');
    }

}

/* End of file search.php */
/* Location: ./application/controllers/search.php */
