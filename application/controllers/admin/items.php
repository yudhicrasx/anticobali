<?php

if (!defined('BASEPATH'))
    die();

class Items extends Main_Controller {

    function __construct() {
        parent::__construct();
        $this->logged_in();
        $this->load->helper('form');
        $this->load->model('m_refer', 'mr');
        $this->load->library('form_validation');
    }

    public function index() {
        $this->load->model('items_model');
        $data['query'] = $this->items_model->select_order(TBL_ITEMS, "id_items, name, price, stock, order, active", "", "", "order");
        $data['item_photo'] = $this->mr->select_by(TBL_PHOTOS);

        $this->data['my_body'] = $this->load->view('admin/v_items_list', $data, true);
        $this->global_template($this->data, 'v_index', 'admin');
    }

    public function form($id = '') {
		$this->load->helper('file');
		
        $data['row_category'] = $this->mr->select_by(TBL_CATEGORIES);
        //Update. get data by id 
        if ($id !== '') {
            $data['row'] = $this->mr->select_by(TBL_ITEMS, '*', array('id_items' => $id));
            $data['row_photo'] = $this->mr->select_by(TBL_PHOTOS, '*', array('id_items' => $id));
            $data['row_items_categories'] = $this->mr->select_by(TBL_ITEMS_CATEGORIES, '*', array('id_items' => $id));
            $data['url'] = $this->mr->select_by(TBL_URL, '*', array('directlink' => 'collections/details/'.$id));

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
            redirect(base_url() . 'admin/items/form/' . $id_item . '#item-photo-section');
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
            //$selector_name = '';
            foreach ($row as $key1 => $row1):
                //$selector_name = $key1;
                $ids[$key1] = $row1;
            endforeach;
        endforeach;

        $this->db->trans_start();
        foreach ($ids['order'] as $id => $order):
            $active = isset($ids['active'][$id]) ? 1:0;
            $query = array("order" => $order, "active" => $active);
            $this->items_model->reorder($id, $query);
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
        if ($id_item !== '') { //Delete only Photos (not Items)
            foreach ($d as $key => $row):
                $table_name = $key;
                foreach ($row as $key1 => $row1):
                    $selector_name = $key1;
                    $photo_ids = $row1;
                endforeach;
            endforeach;
            $this->_delete_photos($photo_ids);
            $query_delete = $this->mr->delete_by_ids($table_name, $selector_name, $photo_ids);
            $code = $query_delete ? 5 : 6;
        } else { //Delete Items (also Items_Categories, Photos)
            foreach ($d as $key => $row):
                $table_name = $key;
                foreach ($row as $key1 => $row1):
                    $selector_name = $key1;
                    $ids = $row1;
                endforeach;
            endforeach;

            $this->db->trans_start();
            //Delete Table PHOTOS
            $this->_delete_photos_by_item_ids($ids);
            $this->mr->delete_by_ids(TBL_PHOTOS, 'id_items', $ids);
            //Delete Table ITEMS_CATEGORIES
            $this->mr->delete_by_ids(TBL_ITEMS_CATEGORIES, 'id_items', $ids);
            $query_delete = $this->mr->delete_by_ids($table_name, $selector_name, $ids);
            $this->db->trans_complete();

            $code = $this->db->trans_status() === FALSE ? 4 : 3;
        }
        $this->session->set_flashdata('flash_msg', alertMsg($code));
        if ($id_item !== '') { //Delete Photos
            redirect(base_url() . 'admin/items/form/' . $id_item . '#item-photo-section');
        } else {
            redirect(base_url() . 'admin/items');
        }
    }

    public function _delete_photos($photo_ids) {
        $query = $this->mr->select_by_where_in(TBL_PHOTOS, '*', 'id_photos', $photo_ids);
        foreach ($query->result() as $photo):
            if (file_exists('./assets/photo/' . $photo->photo_thumbnail)) {
                unlink('./assets/photo/' . $photo->photo_thumbnail);
            }
            if (file_exists('./assets/photo/' . $photo->photo_original)) {
                unlink('./assets/photo/' . $photo->photo_original);
            }
        endforeach;
    }

    public function _delete_photos_by_item_ids($item_ids) {
        $query = $this->mr->select_by_where_in(TBL_PHOTOS, '*', 'id_items', $item_ids);
        if ($query) {
            foreach ($query->result() as $photo):
                if (file_exists('./assets/photo/' . $photo->photo_thumbnail)) {
                    unlink('./assets/photo/' . $photo->photo_thumbnail);
                }
                if (file_exists('./assets/photo/' . $photo->photo_original)) {
                    unlink('./assets/photo/' . $photo->photo_original);
                }
            endforeach;
        }
    }

    public function _update_data($id_items) {
        $this->_set_rules_items();
        if ($this->form_validation->run()) {
            $d = parse_form($this->input->post());
			$new_data[TBL_ITEMS] = $d[TBL_ITEMS]; //separate array from tbl_url.

            $this->db->trans_start();
            //Delete Table ITEMS_CATEGORIES
            $this->mr->delete_by_ids(TBL_ITEMS_CATEGORIES, 'id_items', array($id_items));
            //Update Table ITEMS
            $db_where[TBL_ITEMS] = array('id_items' => $id_items);
            $this->mr->insert_update($new_data, 'update', $db_where);
			
            //Insert Table ITEMS_CATEGORIES
            if (is_array($this->input->post('selected_categories'))) {
                foreach ($this->input->post('selected_categories') as $category_id):
                    $category_data[] = array('id_categories' => $category_id, 'id_items' => $id_items);
                endforeach;
            }
            $this->mr->insert_batch(TBL_ITEMS_CATEGORIES, $category_data);
			$url_data[TBL_URL] = $d[TBL_URL];
			$this->_update_permalink($id_items);
			/* DELETE THIS LATER WHEN FINISH */
			//$id_and_title = array('id_item' => $id_items, 'title' => urlSeo($this->input->post('input_items_name')));
			//$insert_url = $this->_add_permalink($d[TBL_URL], $id_and_title);
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $code = 4;
            } else {
                $code = 3;
				$this->save_routes(); //write cache/routes.php
            }
            $this->session->set_flashdata('flash_msg', alertMsg($code));
            redirect(base_url() . 'admin/items/form/' . $id_items);
        }
    }
	
	public function _update_permalink($id) {		
		//cek if record exist, then get a permalink.
			$directlink = 'collections/details/'.$id;
			$get_url = $this->mr->select_by(TBL_URL, '*', array('directlink' => $directlink));
			if ($get_url) {
				$permalink = array('permalink' => trim($this->input->post('input_url_permalink')));
				$url_data[TBL_URL] = $permalink;
				$db_where[TBL_URL] = array('directlink' => $directlink);
				$this->mr->insert_update($url_data, 'update', $db_where);
			}
	}

    public function _add_record() {
        $this->_set_rules_items();
        if ($this->form_validation->run()) {
            $this->db->trans_begin();
			
            $d = parse_form($this->input->post());
			$new_data[TBL_ITEMS] = $d[TBL_ITEMS]; //separate array from tbl_url.
            $query_insert = $this->mr->insert_update($new_data);

            if (is_array($this->input->post('selected_categories'))) {
                foreach ($this->input->post('selected_categories') as $category_id):
                    $category_data[] = array('id_categories' => $category_id, 'id_items' => $query_insert['last_id'][TBL_ITEMS][0]);
                endforeach;
            }

            $this->mr->insert_batch(TBL_ITEMS_CATEGORIES, $category_data);
			$id_and_title = array('id_item' => $query_insert['last_id'][TBL_ITEMS][0], 'title' => urlSeo($this->input->post('input_items_name')));
			$insert_url = $this->_add_permalink($d[TBL_URL], $id_and_title);
			$new_id = '';
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
            redirect(base_url() . 'admin/items/form' . $new_id);
        }
    }
	
	public function _add_permalink($data, $id_and_title) {
		$data[TBL_URL] = $data;
		$directlink = 'collections/details/'.$id_and_title['id_item'];
		$record[TBL_URL] = array('directlink' => $directlink, 'permalink' => $id_and_title['title']);		
		
        return $this->mr->insert_update($record);
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
                'field' => 'selected_categories',
                'label' => 'Category(ies)',
                'rules' => 'required'
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
                'field' => 'input_items_name',
                'label' => 'Permalink',
                'rules' => 'callback_url_check'
            )
        );
        $this->form_validation->set_rules($rules);
    }
	
	public function url_check($str) {
		if ($id === NULL) {
			//cek if record exist, then get a permalink.
			$get_url = $this->mr->select_by(TBL_URL, '*', array('permalink' => urlSeo($str)));
			if($get_url) {
				$this->form_validation->set_message('url_check', '%s duplication. Please change it manually');
				return FALSE;
			}
		}
		return TRUE;
	}

}

/* End of file items.php */
/* Location: ./application/controllers/admin/items.php */
