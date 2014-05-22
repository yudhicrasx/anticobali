<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('m_users');
        $this->load->model('m_refer', 'mr');
        $this->load->library('form_validation');
    }

    public function index() {
        $this->load->model('m_refer', 'mr');
        $data = '';

        $this->_set_rules();
        if ($this->form_validation->run()) {
            $email = $this->input->post('email', TRUE);
            $password = $this->input->post('password', TRUE);

            $this->load->library('encrypt');

            $encrypted_passwd = $this->encrypt->sha1($this->config->item('encryption_key') . $password);
            $check_login = $this->mr->select_by(TBL_USERS, '*', array('email' => $email, 'password' => $encrypted_passwd));
            if ($check_login) {
                $userData = $check_login->row();
                $mySession = array(
                    'antiqueku_session' => $userData->email . ' ' . $userData->input_date
                );
                $this->session->set_userdata($mySession);
                redirect(base_url() . 'admin/items');
            } else {
                $this->session->set_flashdata('flash_msg', alertMsg(0, 'Wrong Email or Password'));
                redirect(base_url('login'));
            }
        }
        $this->data['my_body'] = $this->load->view('public/v_login', $data, true);
        $this->global_template($this->data, 'v_login', 'public');
    }

    function _set_rules() {
        $my_rules = array(
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required'
                ));

        $this->form_validation->set_rules($my_rules);
    }

    public function logout() {
        $this->session->unset_userdata('fullname');
        $this->session->sess_destroy();
        redirect(base_url('login'), 'refresh');
    }

}