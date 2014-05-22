<?php

if (!defined('BASEPATH'))
    die();

class Blog extends Main_Controller {

    function __construct() {
        parent::__construct();
        $this->logged_in();
        //$this->load->helper('form');
        $this->load->model('m_refer', 'mr');
        $this->load->library('form_validation');
    }

    public function index() {
        $this->load->model('blog_model');
        $data['query'] = $this->blog_model->select_order(TBL_BLOG, "*", "", "", "order");

        $this->data['my_body'] = $this->load->view('admin/v_blog_list', $data, true);
        $this->global_template($this->data, 'v_index', 'admin');
    }

    public function form($id = '') {
		$this->load->helper('file');
		
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
            $data['row'] = $this->mr->select_by(TBL_BLOG, '*', array('id_blog' => $id));
            $data['url'] = $this->mr->select_by(TBL_URL, '*', array('directlink' => 'blog/detail/'.$id));
        }

        $this->data['my_body'] = $this->load->view('admin/v_blog_form', $data, true);
        $this->global_template($this->data, 'v_index', 'admin');
    }

    public function _add_record() {
        $this->_set_rules();
        if ($this->form_validation->run()) {
            $d = parse_form($this->input->post());
            $d[TBL_BLOG]['active'] = $this->input->post('blog_active') == 'on' ? 1 : 0;

            $photo_fields = $this->_photo();
            $records[TBL_BLOG] = array_merge($d[TBL_BLOG], $photo_fields);

            $this->db->trans_begin();
            $query_insert = $this->mr->insert_update($records);
			$id_and_title = array('id_item' => $query_insert['last_id'][TBL_ITEMS][0], 'title' => urlSeo($this->input->post('input_items_name')));
			$insert_url = $this->_add_permalink($d[TBL_URL], $id_and_title);
            if($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
                $code = 2;
			} else {
                $code = 1;
				$this->db->trans_commit();
				$new_id = '/'.$query_insert['last_id'][TBL_ITEMS][0];	
				$this->save_routes(); //write cache/routes.php			
            }
            $this->session->set_flashdata('flash_msg', alertMsg($code));
            redirect(base_url() . 'admin/blog/form/' . $query_insert['last_id'][TBL_BLOG][0]);
        }
    }

    public function _photo() {
        /* upload photo */
        $uploadProperties = $this->_upload_photo();
        $this->_resize_photo($uploadProperties);
        $recordsMerge = array(
            'intro_photo' => $uploadProperties['upload_data']['raw_name'] . $uploadProperties['upload_data']['file_ext']);
        $d = $recordsMerge;
        return $d;
    }

    public function reorder() {
        $this->load->model('blog_model');

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
            $this->blog_model->reorder($id, $order);
        endforeach;
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $msg = 'Blog Orders are failed to be updated.';
            $code = 0;
        } else {
            $msg = 'Blog Orders are successfully updated.';
            $code = 1;
        }

        $this->session->set_flashdata('flash_msg', alertMsg($code));
        redirect(base_url() . 'admin/blog/');
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
        redirect(base_url() . 'admin/blog');
    }
    
    public function _delete_photos($photo_ids) {
        $query = $this->mr->select_by_where_in(TBL_BLOG, '*', 'id_blog', $photo_ids);
        foreach ($query->result() as $photo):
            if (file_exists('./assets/img/' . $photo->intro_photo)) {
                unlink('./assets/img/' . $photo->intro_photo);
            }
        endforeach;
    }

    public function _update_data($id) {
        if ($_FILES['photo']['error'] == 0) {
            $photo_fields = $this->_photo();            
            $this->_delete_photos(array($id));
        }
        $this->_set_rules($id);
        if ($this->form_validation->run()) {
            $d = parse_form($this->input->post());
			$new_data[TBL_BLOG] = $d[TBL_BLOG]; //separate array from tbl_url.
            $d[TBL_BLOG]['active'] = $this->input->post('blog_active') == 'on' ? 1 : 0;
            if (isset($photo_fields)) {
                $d[TBL_BLOG] = array_merge($d[TBL_BLOG], $photo_fields);
            }

            $db_where[TBL_BLOG] = array('id_blog' => $id);
			
            $this->db->trans_begin();
            $query_update = $this->m_refer->insert_update($new_data, 'update', $db_where);
			
			$url_data[TBL_URL] = $d[TBL_URL];
			//$this->_update_permalink($id);
			/* DELETE THIS LATER WHEN FINISH */
			$id_and_title = array('id_blog' => $id, 'title' => urlSeo($this->input->post('input_blog_title')));
			$insert_url = $this->_add_permalink($d[TBL_URL], $id_and_title);
			if($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
                $code = 4;
            } else {
				$this->db->trans_commit();
				$this->save_routes(); //write cache/routes.php
                $code = 3;
            }
            $this->session->set_flashdata('flash_msg', alertMsg($code));
            redirect(base_url() . 'admin/blog/form/' . $id);
        }
    }
	
	public function _update_permalink($id) {		
		//cek if record exist, then get a permalink.
			$directlink = 'blog/'.$id;
			$get_url = $this->mr->select_by(TBL_URL, '*', array('directlink' => $directlink));
			if ($get_url) {
				$permalink = array('permalink' => trim($this->input->post('input_url_permalink')));
				$url_data[TBL_URL] = $permalink;
				$db_where[TBL_URL] = array('directlink' => $directlink);
				$this->mr->insert_update($url_data, 'update', $db_where);
			}
	}
		
	public function _add_permalink($data, $id_and_title) {
		$data[TBL_URL] = $data;
		$directlink = 'blog/detail/'.$id_and_title['id_blog'];
		$record[TBL_URL] = array('directlink' => $directlink, 'permalink' => 'blog/'.$id_and_title['title']);		
		
        return $this->mr->insert_update($record);
	}

    function _upload_photo() {
        $config['upload_path'] = './assets/img';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2000';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('photo')) {
            $code = $this->upload->display_errors();
            $this->session->set_flashdata('flash_msg', alertMsg(0, $code));
            redirect(base_url() . 'admin/blog/form/');
        } else {
            $upload_properties = array('upload_data' => $this->upload->data());
            return $upload_properties;
        }
    }

    function _resize_photo(array $value) {
        $this->load->library('image_lib');

        $con_resize['image_library'] = 'gd2';
        $con_resize['source_image'] = './assets/img/' . $value['upload_data']['file_name'];
        $con_resize['maintain_ratio'] = TRUE;
        $con_resize['width'] = 200;
        $con_resize['height'] = 150;

        $this->image_lib->initialize($con_resize);

        if (!$this->image_lib->resize()) {
            $code = $this->image_lib->display_errors();
            $this->session->set_flashdata('flash_msg', alertMsg(0, $code));
            redirect(base_url() . 'admin/blog/form/');
        }
    }

    public function _set_rules($id = NULL) {
        $rules = array(
            array(
                'field' => 'input_blog_title',
                'label' => 'Title',
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'input_blog_intro_text',
                'label' => 'Into Text',
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'input_blog_text',
                'label' => 'Text',
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'input_blog_title',
                'label' => 'Permalink',
                'rules' => 'callback_url_check['.$id.']'
            )
        );
        $this->form_validation->set_rules($rules);
    }
	
	public function url_check($str, $id) {
		//if ($id === NULL) {
			//cek if record exist, then get a permalink.
			$get_url = $this->mr->select_by(TBL_URL, '*', array('permalink' => 'blog/'.urlSeo($str)));
			if($get_url) {
				$this->form_validation->set_message('url_check', '%s duplication. Please change it manually');
				return FALSE;
			}
		//}
		return TRUE;
	}

}

/* End of file blog.php */
/* Location: ./application/controllers/admin/blog.php */
