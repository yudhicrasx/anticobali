<?php

if (!defined('BASEPATH'))
    die();

class Contact_us extends Main_Controller {

    function __construct() {
        parent::__construct();
        $this->logged_in();
        //$this->load->helper('form');
        $this->load->model('m_refer', 'mr');
        $this->load->library('form_validation');
    }

    public function index() {
        $this->load->model('contact_us_model', 'cu');
        $data['query'] = $this->cu->select_order(TBL_CONTACT_US, "*", "", "", "input_date");

        $this->data['my_body'] = $this->load->view('admin/v_contact-us_list', $data, true);
        $this->global_template($this->data, 'v_index', 'admin');
    }

    public function details($id) {
        $data['query'] = $this->mr->select_by(TBL_CONTACT_US, '*', array('id_contact_us' => $id));

        $this->data['my_body'] = $this->load->view('admin/v_contact-us_details', $data, true);
        $this->global_template($this->data, 'v_single', 'admin');
    }

    public function delete() {
        $d = parse_form($this->input->post());
        foreach ($d as $key => $row):
            $table_name = TBL_CONTACT_US;
            foreach ($row as $key1 => $row1):
                $selector_name = $key1;
                $ids = $row1;
            endforeach;
        endforeach;

        $query_delete = $this->mr->delete_by_ids($table_name, $selector_name, $ids);
        if ($query_delete) {
            $code = 5;
        } else {
            $code = 6;
        }
        $this->session->set_flashdata('flash_msg', alertMsg($code));
        redirect(base_url() . 'admin/contact_us');
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
