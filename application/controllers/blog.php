<?php

if (!defined('BASEPATH'))
    die();

class Blog extends Main_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('m_refer', 'mr');
    }

    public function index() {
        $this->load->model('blog_model');
        $data['query'] = $this->blog_model->select_order(TBL_BLOG, "*", array('active'=>1), "", "order");
		$data['urls'] = $this->mr->select_by(TBL_URL); //Short URL

        $this->data['my_body'] = $this->load->view('public/v_blog_list', $data, true);
        $this->global_template($this->data, 'v_index', 'public');
    }

    public function detail($id) {
        $data['query'] = $this->mr->select_by(TBL_BLOG, '*', array('id_blog' => $id));
        if($data['query']) {
            $data['description'] = trim(preg_replace('/\s\s+/', ' ', strip_tags($data['query']->row()->intro_text)));
        }
        
        $this->data['my_body'] = $this->load->view('public/v_blog_details', $data, true);
        $this->global_template($this->data, 'v_index', 'public');
    }

}

/* End of file items.php */
/* Location: ./application/controllers/admin/items.php */
