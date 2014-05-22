<?php

if (!defined('BASEPATH'))
    die();

class Item extends Main_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('m_refer', 'mr');
        $this->load->model('items_model');
    }

    public function index($id_category) {
    }
    
    public function details($id_item) {
        $data['query'] = $this->items_model->join_items_photos(array(TBL_ITEMS.'.id_items'=>$id_item));
                
        $this->data['my_body'] = $this->load->view('public/v_item_details', $data, true);
        $this->global_template($this->data, 'v_index', 'public');
    }

}

/* End of file item.php */
/* Location: ./application/controllers/item.php */
