<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Accountant extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    function index() {
        if ($this->session->userdata('accountant_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['page_name'] = 'dashboard';
        $data['page_title'] = get_phrase('accountant_dashboard');
        $this->load->view('backend/index', $data);
    }

    function invoice_add($task = "") {
        if ($this->session->userdata('accountant_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->create_invoice();
            $this->session->set_flashdata('message', get_phrase('invoice_info_saved_successfuly'));
            redirect(base_url() . 'index.php?accountant/invoice_manage');
        }

        $data['page_name'] = 'add_invoice';
        $data['page_title'] = get_phrase('invoice');
        $this->load->view('backend/index', $data);
    }

    function invoice_manage($task = "", $invoice_id = "") {
        if ($this->session->userdata('accountant_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "update") {
            $this->crud_model->update_invoice($invoice_id);
            $this->session->set_flashdata('message', get_phrase('invoice_info_updated_successfuly'));
            redirect(base_url() . 'index.php?accountant/invoice_manage');
        }

        if ($task == "delete") {
            $this->crud_model->delete_invoice($invoice_id);
            redirect(base_url() . 'index.php?accountant/invoice_manage');
        }

        $data['invoice_info'] = $this->crud_model->select_invoice_info();
        $data['page_name'] = 'manage_invoice';
        $data['page_title'] = get_phrase('invoice');
        $this->load->view('backend/index', $data);
    }

    function manage_profile($task = "") {
        if ($this->session->userdata('accountant_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $accountant_id = $this->session->userdata('login_user_id');
        if ($task == "update") {
                $this->crud_model->update_accountant_info($accountant_id);
                $this->session->set_flashdata('message', get_phrase('profile_info_updated_successfuly'));
                redirect(base_url() . 'index.php?accountant/manage_profile');
        }

        if ($task == "change_password") {
            $password = $this->db->get_where('accountant', array('accountant_id' => $accountant_id))->row()->password;
            $old_password = sha1($this->input->post('old_password'));
            $new_password = $this->input->post('new_password');
            $confirm_new_password = $this->input->post('confirm_new_password');

            if ($password == $old_password && $new_password == $confirm_new_password) {
                $data['password'] = sha1($new_password);

                $this->db->where('accountant_id', $accountant_id);
                $this->db->update('accountant', $data);

                $this->session->set_flashdata('message', get_phrase('password_info_updated_successfuly'));
                redirect(base_url() . 'index.php?accountant/manage_profile');
            } else {
                $this->session->set_flashdata('message', get_phrase('password_update_failed'));
                redirect(base_url() . 'index.php?accountant/manage_profile');
            }
        }

        $data['page_name'] = 'edit_profile';
        $data['page_title'] = get_phrase('profile');
        $this->load->view('backend/index', $data);
    }

    function form($task = "") {
        if ($this->session->userdata('accountant_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['page_name'] = 'form_create';
        $data['page_title'] = get_phrase('create_form');
        $this->load->view('backend/index', $data);
    }

    function get_form_element($element_type) {
        if ($this->session->userdata('accountant_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        echo $html = $this->db->get_where('form_element', array('type' => $element_type))->row()->html;
        //$this->load->view('backend/accountant/form_create_body', $html);
        //echo $element_type;
    }
    
    function payroll_list($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('accountant_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        
        $page_data['page_name']     = 'payroll_list';
        $page_data['page_title']    = get_phrase('payroll_list');
        $this->load->view('backend/index', $page_data);
    }

}
