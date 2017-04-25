<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Laboratorist extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    function index() {
        if ($this->session->userdata('laboratorist_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['page_name'] = 'dashboard';
        $data['page_title'] = get_phrase('laboratorist_dashboard');
        $this->load->view('backend/index', $data);
    }

    function blood_bank($task = "", $blood_group_id = "") {
        if ($this->session->userdata('laboratorist_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "update") {
            $this->crud_model->update_blood_bank_info($blood_group_id);
            $this->session->set_flashdata('message', get_phrase('blood_bank_info_updated_successfuly'));
            redirect(base_url() . 'index.php?laboratorist/blood_bank');
        }

        $data['blood_bank_info'] = $this->crud_model->select_blood_bank_info();
        $data['page_name'] = 'manage_blood_bank';
        $data['page_title'] = get_phrase('blood_bank');
        $this->load->view('backend/index', $data);
    }

    function blood_donor($task = "", $blood_donor_id = "") {
        if ($this->session->userdata('laboratorist_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create") {
            $email = $_POST['email'];
            $blood_donor = $this->db->get_where('blood_donor', array('email' => $email))->row()->name;
            if ($blood_donor == null) {
                $this->crud_model->save_blood_donor_info();
                $this->session->set_flashdata('message', get_phrase('blood_donor_info_saved_successfuly'));
            } else {
                $this->session->set_flashdata('message', get_phrase('duplicate_email'));
            }
            redirect(base_url() . 'index.php?laboratorist/blood_donor');
        }

        if ($task == "update") {
                $this->crud_model->update_blood_donor_info($blood_donor_id);
                $this->session->set_flashdata('message', get_phrase('blood_donor_info_updated_successfuly'));
                redirect(base_url() . 'index.php?laboratorist/blood_donor');
        }

        if ($task == "delete") {
            $this->crud_model->delete_blood_donor_info($blood_donor_id);
            redirect(base_url() . 'index.php?laboratorist/blood_donor');
        }

        $data['blood_donor_info'] = $this->crud_model->select_blood_donor_info();
        $data['page_name'] = 'manage_blood_donor';
        $data['page_title'] = get_phrase('blood_donor');
        $this->load->view('backend/index', $data);
    }

    function manage_profile($task = "") {
        if ($this->session->userdata('laboratorist_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $laboratorist_id = $this->session->userdata('login_user_id');
        if ($task == "update") {
            $this->crud_model->update_laboratorist_info($laboratorist_id);
            $this->session->set_flashdata('message', get_phrase('profile_info_updated_successfuly'));
            redirect(base_url() . 'index.php?laboratorist/manage_profile');
        }

        if ($task == "change_password") {
            $password = $this->db->get_where('laboratorist', array('laboratorist_id' => $laboratorist_id))->row()->password;
            $old_password = sha1($this->input->post('old_password'));
            $new_password = $this->input->post('new_password');
            $confirm_new_password = $this->input->post('confirm_new_password');

            if ($password == $old_password && $new_password == $confirm_new_password) {
                $data['password'] = sha1($new_password);

                $this->db->where('laboratorist_id', $laboratorist_id);
                $this->db->update('laboratorist', $data);

                $this->session->set_flashdata('message', get_phrase('password_info_updated_successfuly'));
                redirect(base_url() . 'index.php?laboratorist/manage_profile');
            } else {
                $this->session->set_flashdata('message', get_phrase('password_update_failed'));
                redirect(base_url() . 'index.php?laboratorist/manage_profile');
            }
        }

        $data['page_name'] = 'edit_profile';
        $data['page_title'] = get_phrase('profile');
        $this->load->view('backend/index', $data);
    }
    
    function payroll_list($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('laboratorist_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        
        $page_data['page_name']     = 'payroll_list';
        $page_data['page_title']    = get_phrase('payroll_list');
        $this->load->view('backend/index', $page_data);
    }

}
