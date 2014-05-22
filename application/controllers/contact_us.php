<?php

if (!defined('BASEPATH'))
    die();

class Contact_us extends Main_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('m_refer', 'mr');
        $this->load->library('form_validation');
        $this->load->helper('captcha');
    }

    public function index() {        
    }

    public function form() {
        if ($this->input->post('bot_trap')) { //Bot Trap
            redirect(base_url());
        }

        $vals = array(
            'img_path' => './assets/captcha/',
            'img_url' => base_url('assets/captcha') . '/',
            'img_width' => '150',
            'img_height' => 30,
            'expiration' => 7200
        );

        $cap = create_captcha($vals);
        $data['captcha'] = $cap['image'];

        $save_data = array(
            'captcha_time' => $cap['time'],
            'ip_address' => $this->input->ip_address(),
            'word' => $cap['word']
        );
        $query = $this->db->insert_string('captcha', $save_data);
        $this->db->query($query);

        $this->_set_rules();
        if ($this->form_validation->run()) {
            $d[TBL_CONTACT_US] = array_slice($this->input->post(), 0, -2);
            $query_insert = $this->mr->insert_update($d);

            if ($query_insert) {
                $code = 1;
                $msg = "Thank you for contacting us. We will respond you very soon.";
                $this->_send_email_to_admin();
            } else {
                $code = 2;
                $msg = "Failed to send Contact Us form. Please try again";
            }
            $this->session->set_flashdata('flash_msg', alertMsg($code, $msg));
            redirect(base_url() . 'contact_us/form/');
        }

        $this->data['my_body'] = $this->load->view('public/v_contact_us_form', $data, true);
        $this->global_template($this->data, 'v_index', 'public');
    }

    public function _send_email_to_admin() {
        $this->load->library('email');
        $this->load->helper('string');
        
        $config['protocol'] = 'mail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        
        $from = $this->input->post('email');
        $this->email->to("sales@antiqueku.com");
        $this->email->from($from);
        $this->email->subject('Antiqueku.com - Contact Us');
        $this->email->message($this->input->post('message'));

        if ($this->email->send()) {
            $d[TBL_CONTACT_US_EMAIL_SEND]['to'] = $from;
            $d[TBL_CONTACT_US_EMAIL_SEND]['sent'] = 1;
            $this->mr->insert_update($d);
        }
    }

    public function _set_rules() {
        $rules = array(
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|email|trim'
            ),
            array(
                'field' => 'message',
                'label' => 'Message',
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'word',
                'label' => 'Captcha',
                'rules' => 'required|trim|callback_check_captcha'
            )
        );
        $this->form_validation->set_rules($rules);
    }

    public function check_captcha($str) {
        $expiration = time() - 7200; // Two hour limit
        $this->db->query("DELETE FROM captcha WHERE captcha_time < " . $expiration);

        // Then see if a captcha exists:
        $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
        $binds = array($str, $this->input->ip_address(), $expiration);
        $query = $this->db->query($sql, $binds);
        $row = $query->row();
        if ($row->count == 0) {            
            log_message("error", "You must submit the word that appears in the image");
            return FALSE;
        }
        return TRUE;
    }

}

/* End of file items.php */
/* Location: ./application/controllers/admin/items.php */
