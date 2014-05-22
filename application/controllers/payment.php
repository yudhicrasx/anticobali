<?php

if (!defined('BASEPATH'))
    die();

class Payment extends Main_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('merchant');
    }

    public function index() {
        $data = array();
        
        $this->merchant->load('paypal_express');
        $settings = array(
            'username' => '****',
            'password' => '****',
            'signature' => '****',
            'test_mode' => true);
        $this->merchant->initialize($settings);
        $params = array(
            'amount' => 100.00,
            'currency' => 'USD',
            'return_url' => base_url('berhasil'),
            'cancel_url' => base_url('cancel')
            );

        $response = $this->merchant->purchase($params);
        if ($response->success()) {
            // mark order as complete
            die('sukses');
            $gateway_reference = $response->reference();
        } else {
            $message = $response->message();
            echo('Error processing payment: ' . $message);
            exit;
        }

        $this->data['my_body'] = $this->load->view('public/v_payment', $data, true);
        $this->global_template($this->data, 'v_index', 'public');
    }

    public function faq() {
        $data = array();

        $this->data['my_body'] = $this->load->view('public/v_faq', $data, true);
        $this->global_template($this->data, 'v_index', 'public');
    }

}

/* End of file items.php */
/* Location: ./application/controllers/admin/items.php */
