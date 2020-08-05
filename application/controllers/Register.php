<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->common->set_timezone();
        $this->load->model('user/m_register', 'objregister');
    }

    public function index() {
        $this->load->view('main_header');
        $this->load->view('register');
        $this->load->view('footer');
    }

    public function add_customer() {
        $result = $this->objregister->add_customer();
        if ($result == "exist") {
            header('location:' . base_url() . 'register?msg=A'); //email or phone already Exist
        } else if ($result == "error") {
            header('location:' . base_url() . 'register?msg=E'); //Some Error
        } else {
            header('location:' . base_url() . 'register/user_profile/' . $result); //Register Success
        }
    }

    public function user_profile($reg_id) {
        $data["myprofile"] = $this->objregister->get_user_profile_details($reg_id);
        $data["cms_details"] = $this->objregister->get_cms_details(1);
        $this->load->view('header');
        $this->load->view('update_user', $data);
        $this->load->view('footer');
    }

    public function update_user() {
        $cust_id = $this->objregister->update_user();
        if ($cust_id == "exist") {
            $post = $this->input->post();
            $cust_id = $post['cust_id'];
            header('location:' . base_url() . 'register/user_profile/' . $cust_id);
        } else {
            $post = $this->input->post();
            $cust_id = $post['cust_id'];
            header('location:' . base_url() . 'register/plan_pricing/' . $cust_id);
        }
    }

    public function plan_pricing($cust_id) {
        $data["plan_pricing"] = $this->objregister->get_plan_pricing();
        $data["myprofile"] = $this->objregister->get_user_profile_details($cust_id);
        $data["cms_details"] = $this->objregister->get_cms_details(2);
        $this->load->view('header');
        $this->load->view('plan_pricing', $data);
        $this->load->view('footer');
    }

    public function update_registration_type() {
        $cust_id = $this->objregister->update_registration_type();
        header('location:' . base_url() . 'register/payment/' . $cust_id);
    }

    public function payment($cust_id) {
        $data["myprofile"] = $this->objregister->get_user_payment_details($cust_id);
        $data["cancellation_policy"] = $this->objregister->get_cms_details(3);
        $data["cms_details"] = $this->objregister->get_cms_details(3);
        $this->load->view('header');
        $this->load->view('payment', $data);
        $this->load->view('footer');
    }

    public function pay_payment() {
        $cust_id = $this->objregister->pay_payment();
        header('location:' . base_url() . 'register/payment_confirmed/' . $cust_id);
    }

    public function payment_confirmed($cust_id) {
        $data["cms_details"] = $this->objregister->get_cms_details(5);
        $data["cust_id"] = $cust_id;
        $this->load->view('header');
        $this->load->view('payment_confirmed', $data);
        $this->load->view('footer');
    }

    public function get_promo_code_details() {
        $promo_code_details = $this->objregister->get_promo_code_details();
        if (!empty($promo_code_details)) {
            echo json_encode(array("status" => "success", "promo_code_details" => $promo_code_details));
        } else {
            echo json_encode(array("status" => "error"));
        }
    }

}
