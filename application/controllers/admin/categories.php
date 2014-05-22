<?php

if (!defined('BASEPATH'))
    die();

class Categories extends Main_Controller {

    function __construct() {
        parent::__construct();
        $this->logged_in();
        //$this->load->helper('form');
        $this->load->model('m_refer', 'mr');
        $this->load->library('form_validation');
    }

    public function index() {
        $this->load->model('categories_model', 'cm');
        $data['query'] = $this->cm->select_order(TBL_CATEGORIES);

        $this->data['my_body'] = $this->load->view('admin/v_categories_list', $data, true);
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
            $data['row'] = $this->mr->select_by(TBL_CATEGORIES, '*', array('id_categories' => $id));
            $data['url'] = $this->mr->select_by(TBL_URL, '*', array('directlink' => 'category/index/'.$id));
        }
		
        $this->data['my_body'] = $this->load->view('admin/v_categories_form', $data, true);
        $this->global_template($this->data, 'v_index', 'admin');
    }
    
    public function _add_record() {
        $this->_set_rules();
        if ($this->form_validation->run()) {
            $d = parse_form($this->input->post());
            $d[TBL_CATEGORIES]['active'] = $this->input->post('category_active') == 'on' ? 1 : 0;

            $photo_fields = $this->_photo();
            $records[TBL_CATEGORIES] = array_merge($d[TBL_CATEGORIES], $photo_fields);

            $query_insert = $this->mr->insert_update($records);
            if ($query_insert) {
                $code = 1;
            } else {
                $code = 2;
            }
            $this->session->set_flashdata('flash_msg', alertMsg($code));
            redirect(base_url() . 'admin/categories/form/' . $query_insert['last_id'][TBL_CATEGORIES][0]);
        }
    }

    public function _photo() {
        /* upload photo */
        $uploadProperties = $this->_upload_photo();
        $this->_resize_photo($uploadProperties);
        $recordsMerge = array(
            'photo' => $uploadProperties['upload_data']['raw_name'] . $uploadProperties['upload_data']['file_ext']);
        $d = $recordsMerge;
        return $d;
    }

    public function delete() {
        $d = parse_form($this->input->post());
        foreach ($d as $key => $row):
            $table_name = $key;
            foreach ($row as $key1 => $row1):
                $selector_name = $key1;
                $photo_ids = $row1;
            endforeach;
        endforeach;
        $this->_delete_photos($photo_ids);

        $query_delete = $this->mr->delete_by_ids($table_name, $selector_name, $photo_ids);
        if ($query_delete) {
            $code = 5;
        } else {
            $code = 6;
        }
        $this->session->set_flashdata('flash_msg', alertMsg($code));
        redirect(base_url() . 'admin/categories');
    }

    public function _delete_photos($photo_ids) {
        $query = $this->mr->select_by_where_in(TBL_CATEGORIES, '*', 'id_categories', $photo_ids);
        foreach ($query->result() as $photo):
            if (file_exists('./assets/category/' . $photo->photo)) {
                unlink('./assets/category/' . $photo->photo);
            }
        endforeach;
    }

    public function _update_data($id) {
        if ($_FILES['photo']['error'] == 0) {
            $photo_fields = $this->_photo();
        }
        $this->_set_rules();
        if ($this->form_validation->run()) {
            $d = parse_form($this->input->post());
            $d[TBL_CATEGORIES]['active'] = $this->input->post('category_active') == 'on' ? 1 : 0;
            if (isset($photo_fields)) {
                $d[TBL_CATEGORIES] = array_merge($d[TBL_CATEGORIES], $photo_fields);
            }
			$new_data[TBL_CATEGORIES] = $d[TBL_CATEGORIES]; //separate array from tbl_url.
            $db_where[TBL_CATEGORIES] = array('id_categories' => $id);
			
            $this->db->trans_begin(); //DB TRANSACTION
            $query_update = $this->mr->insert_update($new_data, 'update', $db_where);
			//$this->_update_permalink($id);
			/* DELETE THIS LATER WHEN FINISH */
			$id_and_title = array('id_categories' => $id, 'title' => urlSeo($this->input->post('input_categories_category')));
			$insert_url = $this->_add_permalink($d[TBL_URL], $id_and_title);
			
			if($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
                $code = 4;
			} else {
                $code = 3;
				$this->db->trans_commit();
				//$new_id = '/'.$query_insert['last_id'][TBL_ITEMS][0];				
            }
			die('ss');
            $this->session->set_flashdata('flash_msg', alertMsg($code));
            redirect(base_url() . 'admin/categories/form/' . $id);
        }
    }

    function _upload_photo() {
        $config['upload_path'] = './assets/category';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2000';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('photo')) {
            $code = $this->upload->display_errors();
            $this->session->set_flashdata('flash_msg', alertMsg(0, $code));
            redirect(base_url() . 'admin/categories/form/');
        } else {
            $upload_properties = array('upload_data' => $this->upload->data());
            return $upload_properties;
        }
    }

    function _resize_photo(array $value) {
        $this->load->library('image_lib');

        $con_resize['image_library'] = 'gd2';
        $con_resize['source_image'] = './assets/category/' . $value['upload_data']['file_name'];
        $con_resize['maintain_ratio'] = TRUE;
        $con_resize['width'] = 170;
        $con_resize['height'] = 200;

        $this->image_lib->initialize($con_resize);

        if (!$this->image_lib->resize()) {
            $code = $this->image_lib->display_errors();
            $this->session->set_flashdata('flash_msg', alertMsg(0, $code));
            redirect(base_url() . 'admin/categories/form/');
        }
    }
	
	public function _add_permalink($data, $id_and_title) {
		$data[TBL_URL] = $data;
		$directlink = 'category/index/'.$id_and_title['id_categories'];
		$record[TBL_URL] = array('directlink' => $directlink, 'permalink' => 'category/'.$id_and_title['title']);		
		
        return $this->mr->insert_update($record);
	}
	
	public function _update_permalink($id) { 
		//cek if record exist, then get a permalink.
			$directlink = 'category/index/'.$id;
			$get_url = $this->mr->select_by(TBL_URL, '*', array('directlink' => $directlink));
			if ($get_url) {
				$permalink = array('permalink' => trim($this->input->post('input_url_permalink')));
				$url_data[TBL_URL] = $permalink;
				$db_where[TBL_URL] = array('directlink' => $directlink);
				$this->mr->insert_update($url_data, 'update', $db_where);
				return TRUE;
			}
			return FALSE;
	}

    public function _set_rules() {
        $rules = array(
            array(
                'field' => 'input_categories_category',
                'label' => 'Category',
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'input_categories_description',
                'label' => 'Description',
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'input_url_permalink',
                'label' => 'Description',
                'rules' => 'trim|callback_url_check'
            )
        );
        $this->form_validation->set_rules($rules);
    }
	
	public function url_check($str) {
		if (empty($str)) { //use for new URL (doesn't exist on DB yet)
			$str = $this->input->post('input_categories_category');
		}
		//cek if record exist, then get a permalink.
        $get_url = $this->mr->select_by(TBL_URL, '*', array('permalink' => urlSeo($str)));
		if($get_url) {
			$this->form_validation->set_message('url_check', '%s duplication. Please change it manually');
			return FALSE;
		}
		return TRUE;
	}

}

/* End of file items.php */
/* Location: ./application/controllers/admin/items.php */
