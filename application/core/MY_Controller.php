<?php

class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
		//$this->_short_url();
    }
	
	/*public function _short_url() {
		$this->load->model('m_refer', 'mr');
		
		$permalink = uri_string();
		$permalink[0] = '';
		$data['urls'] = $this->mr->select_by(TBL_URL, '*', array('permalink' => $permalink); //Short URL
		
	}*/

    function global_template($data, $index = 'v_index', $priviledge = 'public') {
        $data['js'] = isset($data['javascript']) ? $data['javascript'] : "";
        unset($data['javascript']);
        $data['body'] = $data['my_body'];
		
        $data['flash_message_view'] = $this->load->view("templates/{$priviledge}/flash_msg", '', true);
        $data['menubar_view'] = $this->load->view("templates/{$priviledge}/menubar", '', true);		
        if(file_exists("./application/views/templates/{$priviledge}/footerbar.php")) {
            $data['footerbar_view'] = $this->load->view("templates/{$priviledge}/footerbar", '', true);
        }
        $this->load->view("templates/{$priviledge}/{$index}", $data);
    }
		
	//Function to call DB in order to get all permalinks
	function save_routes() {
		$routes = $this->m_refer->select_by(TBL_URL);//Short URL

		$data = array();

			if (!empty($routes )) {
				$data[] = '<?php if ( ! defined(\'BASEPATH\')) exit(\'No direct script access allowed\');';

				foreach ($routes->result() as $route) {
					$data[] = '$route[\'' . $route->permalink . '\'] = \'' . $route->directlink . '\';';
				}
				$output = implode("\n", $data);

				write_file(APPPATH . 'cache/routes.php', $output);
			}
	}

    public function logged_in() {
        if (!$this->session->userdata('antiqueku_session')) {
            redirect(base_url());
        }
    }

}
