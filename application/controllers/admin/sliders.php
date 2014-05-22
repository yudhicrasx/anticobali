<?php

if (!defined('BASEPATH'))
    die();

class Sliders extends Main_Controller {

    function __construct() {
        parent::__construct();
        $this->logged_in();
        //$this->load->helper('form');
        $this->load->model('m_refer', 'mr');
        $this->load->library('form_validation');
    }

    public function index() {
        $this->load->model('sliders_model');
        $data['query'] = $this->sliders_model->select_order(TBL_SLIDERS, "id_sliders, title, photo_thumbnail, photo_original, order, title, active", "", "", "order");

        $this->data['my_body'] = $this->load->view('admin/v_sliders_list', $data, true);
        $this->global_template($this->data, 'v_index', 'admin');
    }

    public function form($id = '') {
        $data = array();
        //Update. get data by id 
        if ($this->input->post()) {
            if ($id !== '') {
                $this->_update_data($id);
            } else {
                $this->_add_record();
            }
        }
        if ($id !== '') {
            $data['row'] = $this->mr->select_by(TBL_SLIDERS, '*', array('id_sliders' => $id));
        }

        $this->data['my_body'] = $this->load->view('admin/v_sliders_form', $data, true);
        $this->global_template($this->data, 'v_index', 'admin');
    }

    public function _add_record() {
        $this->_set_rules_sliders();
        if ($this->form_validation->run()) {
            $d = parse_form($this->input->post());
            $d[TBL_SLIDERS]['active'] = $this->input->post('sliders_active') == 'on' ? 1 : 0;

            $photo_fields = $this->_photo();
            $records[TBL_SLIDERS] = array_merge($d[TBL_SLIDERS], $photo_fields);

            $query_insert = $this->mr->insert_update($records);
            if ($query_insert) {
                $code = 1;
            } else {
                $code = 2;
            }
            $this->session->set_flashdata('flash_msg', alertMsg($code));
            redirect(base_url() . 'admin/sliders/form/' . $query_insert['last_id'][TBL_SLIDERS][0]);
        }
    }

    public function _photo() {
        /* upload photo */
        // if ($_FILES['photo']['error'] == 0) {
        $uploadProperties = $this->_upload_photo();
        $this->_resize_photo($uploadProperties);
        $recordsMerge = array(
            'photo_thumbnail' => $uploadProperties['upload_data']['raw_name'] . '_thumb' . $uploadProperties['upload_data']['file_ext'],
            'photo_original' => $uploadProperties['upload_data']['raw_name'] . $uploadProperties['upload_data']['file_ext']);
        $d = $recordsMerge;
        return $d;
        //  } else {
        //      return $_FILES['photo']['error'];
        // }
    }

    public function reorder() {
        $this->load->model('sliders_model');

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
            $this->sliders_model->reorder($id, $order);
        endforeach;
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $msg = 'Slider Orders are failed to be updated.';
            $code = 0;
        } else {
            $msg = 'Slider Orders are successfully updated.';
            $code = 1;
        }

        $this->session->set_flashdata('flash_msg', alertMsg($code));
        redirect(base_url() . 'admin/sliders/');
    }

    public function delete() {
        $d = parse_form($this->input->post());
        foreach ($d as $key => $row):
            $table_name = $key;
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
        redirect(base_url() . 'admin/sliders');
    }

    public function _update_data($id) {
        if ($_FILES['photo']['error'] == 0) {
            $photo_fields = $this->_photo();
        }
        $this->_set_rules_sliders();
        if ($this->form_validation->run()) {
            $d = parse_form($this->input->post());
            $d[TBL_SLIDERS]['active'] = $this->input->post('sliders_active') == 'on' ? 1 : 0;
            if (isset($photo_fields)) {
                $d[TBL_SLIDERS] = array_merge($d[TBL_SLIDERS], $photo_fields);
            }

            $db_where[TBL_SLIDERS] = array('id_sliders' => $id);
            $query_update = $this->mr->insert_update($d, 'update', $db_where);
            if ($query_update) {
                $code = 3;
            } else {
                $code = 4;
            }
            $this->session->set_flashdata('flash_msg', alertMsg($code));
            redirect(base_url() . 'admin/sliders/form/' . $id);
        }
    }

    function _upload_photo() {
        $config['upload_path'] = './assets/sliders';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2000';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('photo')) {
            $code = $this->upload->display_errors();
            $this->session->set_flashdata('flash_msg', alertMsg(0, $code));
            redirect(base_url() . 'admin/sliders/form/');
        } else {
            $upload_properties = array('upload_data' => $this->upload->data());
            return $upload_properties;
        }
    }

    function _resize_photo(array $value) {
        $this->load->library('image_lib');

        $con_resize['image_library'] = 'gd2';
        $con_resize['create_thumb'] = TRUE;
        $con_resize['source_image'] = './assets/sliders/' . $value['upload_data']['file_name'];
        $con_resize['maintain_ratio'] = TRUE;
        $con_resize['width'] = 960;
        $con_resize['height'] = 500;

        $this->image_lib->initialize($con_resize);

        if (!$this->image_lib->resize()) {
            $code = $this->image_lib->display_errors();
            $this->session->set_flashdata('flash_msg', alertMsg(0, $code));
            redirect(base_url() . 'admin/sliders/form/');
        }
    }

    public function _set_rules_sliders() {
        $rules = array(
            array(
                'field' => 'input_sliders_title',
                'label' => 'Title',
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'input_sliders_link',
                'label' => 'Link',
                'rules' => 'trim'
            )
        );
        $this->form_validation->set_rules($rules);
    }

}

/* End of file slider.php */
/* Location: ./application/controllers/admin/slider.php */
