<?php

if (!defined('BASEPATH'))
    die();

class Homepage extends Main_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('m_refer', 'mr');
    }

    public function index() {
        $this->load->model('items_model');
        //$data['query'] = $this->items_model->join_items_photos();
        //$where = array(TBL_ITEMS_CATEGORIES.'.id_categories' => 6);
        $data['query'] = $this->items_model->join_items_itemsCategories();
        $this->load->model('sliders_model');
        $data['slider'] = $this->sliders_model->select_order(TBL_SLIDERS, "*", array('active'=>1), "", "order");
        $this->load->model('categories_model', 'cm');
        $data['categories'] = $this->cm->select_order(TBL_CATEGORIES);

        $this->data['my_body'] = $this->load->view('public/v_homepage', $data, true);
        $this->global_template($this->data, 'v_index', 'public');
    }

    public function form($id = '') {
        $data = array();
        //Update. get data by id 
        if ($id !== '') {
            $data['row'] = $this->mr->select_by(TBL_ITEMS, '*', array('id_items' => $id));
            $data['row_photo'] = $this->mr->select_by(TBL_PHOTOS, '*', array('id_items' => $id));
            $this->_update_data($id);
        } else {
            $this->_add_record();
        }

        $this->data['my_body'] = $this->load->view('admin/v_items_form', $data, true);
        $this->global_template($this->data, 'v_index', 'admin');
    }

    public function photo($id_item = '') {
        $data = array();
        $this->_set_rules_photo();
        if ($id_item !== '') {
            /* upload photo */
            if ($_FILES['photo']['error'] == 0) {
                $uploadProperties = $this->_upload_photo($id_item);
                $this->_resize_photo($uploadProperties, $id_item);
                $recordsMerge = array(
                    'id_items' => $id_item,
                    'photo_thumbnail' => $uploadProperties['upload_data']['raw_name'] . '_thumb' . $uploadProperties['upload_data']['file_ext'],
                    'photo_original' => $uploadProperties['upload_data']['raw_name'] . $uploadProperties['upload_data']['file_ext']);
                $d[TBL_PHOTOS] = $recordsMerge;
            }
            $query_insert = $this->mr->insert_update($d);
            if ($query_insert) {
                $code = 1;
            } else {
                $code = 2;
            }
            $this->session->set_flashdata('flash_msg', alertMsg($code));
            redirect(base_url() . 'admin/items/form/' . $id_item);
        } else {
            $msg = 'Upload Photo Failed. No Item Selected';
            $this->session->set_flashdata('flash_msg', alertMsg($code, $msg));
            redirect(base_url() . 'admin/items');
        }

        $this->data['my_body'] = $this->load->view('admin/v_items_form', $data, true);
        $this->global_template($this->data, 'v_index', 'admin');
    }

    public function reorder() {
        $this->load->model('items_model');

        $d = parse_form($this->input->post());
        $table_name = '';
        foreach ($d as $key => $row):
            $table_name = $key;
            $selector_name = '';
            foreach ($row as $key1 => $row1):
                $selector_name = $key1;
                $ids = $row1;
            endforeach;
        endforeach;

        $this->db->trans_start();
        foreach ($ids as $id => $order):
            $this->items_model->reorder($id, $order);
        endforeach;
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $msg = 'Item Orders are failed to be updated.';
            $code = 0;
        } else {
            $msg = 'Item Orders are successfully updated.';
            $code = 1;
        }

        $this->session->set_flashdata('flash_msg', alertMsg($code));
        redirect(base_url() . 'admin/items/');
    }

    public function delete($id_item = '') {
        $d = parse_form($this->input->post());
        foreach ($d as $key => $row):
            $table_name = $key;
            foreach ($row as $key1 => $row1):
                $selector_name = $key1;
                $ids = $row1;
            endforeach;
        endforeach;
        if ($id_item !== '') { //Delete Photos
            $this->_delete_photos($ids);
            $query_delete = $this->mr->delete_by_ids($table_name, $selector_name, $ids);
        } else {
            $query_delete = $this->mr->delete_by_ids($table_name, $selector_name, $ids);
        }
        if ($query_delete) {
            $code = 5;
        } else {
            $code = 6;
        }
        $this->session->set_flashdata('flash_msg', alertMsg($code));
        if ($id_item !== '') { //Delete Photos
            redirect(base_url() . 'admin/items/form/' . $id_item);
        } else {
            redirect(base_url() . 'admin/items');
        }
    }

    public function _delete_photos($ids) {
        $query = $this->mr->select_by_where_in(TBL_PHOTOS, '*', 'id_photos', $ids);
        foreach ($query->result() as $photo):
            if (file_exists('./assets/photo/' . $photo->photo_thumbnail)) {
                unlink('./assets/photo/' . $photo->photo_thumbnail);
            }
            if (file_exists('./assets/photo/' . $photo->photo_original)) {
                unlink('./assets/photo/' . $photo->photo_original);
            }
        endforeach;
    }

    public function _update_data($id) {
        $this->_set_rules_items();
        if ($this->form_validation->run()) {
            $d = parse_form($this->input->post());
            $db_where[TBL_ITEMS] = array('id_items' => $id);
            $query_update = $this->mr->insert_update($d, 'update', $db_where);
            if ($query_update) {
                $code = 3;
            } else {
                $code = 4;
            }
            $this->session->set_flashdata('flash_msg', alertMsg($code));
            redirect(base_url() . 'items/form/' . $id);
        }
    }

    public function _add_record() {
        $this->_set_rules_items();
        if ($this->form_validation->run()) {
            $d = parse_form($this->input->post());
            $query_insert = $this->mr->insert_update($d);
            if ($query_insert) {
                $code = 1;
            } else {
                $code = 2;
            }
            $this->session->set_flashdata('flash_msg', alertMsg($code));
            redirect(base_url() . 'admin/items/form/' . $query_insert['last_id'][TBL_ITEMS][0]);
        }
    }

    public function _set_rules_photo() {
        $rules = array(
            array(
                'field' => 'photo',
                'label' => 'Photo',
                'rules' => 'required|trim'
            )
        );
        $this->form_validation->set_rules($rules);
    }

    function _upload_photo($item_id) {
        $config['upload_path'] = './assets/photo';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2000';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('photo')) {
            $code = $this->upload->display_errors();
            $this->session->set_flashdata('flash_msg', alertMsg(0, $code));
            redirect(base_url() . 'admin/items/form/' . $item_id);
        } else {
            $upload_properties = array('upload_data' => $this->upload->data());
            return $upload_properties;
        }
    }

    function _resize_photo(array $value, $item_id) {
        $this->load->library('image_lib');

        $con_resize['image_library'] = 'gd2';
        $con_resize['create_thumb'] = TRUE;
        $con_resize['source_image'] = './assets/photo/' . $value['upload_data']['file_name'];
        $con_resize['maintain_ratio'] = TRUE;
        $con_resize['height'] = 200;
        $con_resize['width'] = 200;

        $this->image_lib->initialize($con_resize);

        if (!$this->image_lib->resize()) {
            $code = $this->image_lib->display_errors();
            $this->session->set_flashdata('flash_msg', alertMsg(0, $code));
            redirect(base_url() . 'admin/items/form/' . $item_id);
        }
    }

    public function _set_rules_items() {
        $rules = array(
            array(
                'field' => 'input_items_name',
                'label' => 'Name',
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'input_items_weight',
                'label' => 'Weight',
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'input_items_price',
                'label' => 'Price',
                'rules' => 'integer|trim'
            ),
            array(
                'field' => 'input_items_producing',
                'label' => 'Producing',
                'rules' => 'required|max_length[1]|trim'
            ),
            array(
                'field' => 'input_items_description',
                'label' => 'Description',
                'rules' => 'trim'
            ),
            array(
                'field' => 'input_items_stock',
                'label' => 'Stock',
                'rules' => 'integer|max_length[5]|trim'
            ),
            array(
                'field' => 'input_items_keywords',
                'label' => 'Keywords',
                'rules' => 'required|trim'
            )
        );
        $this->form_validation->set_rules($rules);
    }

}

/* End of file items.php */
/* Location: ./application/controllers/admin/items.php */
