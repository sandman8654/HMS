<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Patient extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    function index() {
        if ($this->session->userdata('patient_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['page_name'] = 'dashboard';
        $data['page_title'] = get_phrase('patient_dashboard');
        $this->load->view('backend/index', $data);
    }

    function doctor($task = "") {
        if ($this->session->userdata('patient_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['doctor_info'] = $this->crud_model->select_doctor_info();
        $data['page_name'] = 'show_doctor';
        $data['page_title'] = get_phrase('doctor');
        $this->load->view('backend/index', $data);
    }

    function blood_bank($task = "") {
        if ($this->session->userdata('patient_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['blood_bank_info'] = $this->crud_model->select_blood_bank_info();
        $data['blood_donor_info'] = $this->crud_model->select_blood_donor_info();
        $data['page_name'] = 'show_blood_bank';
        $data['page_title'] = get_phrase('blood_bank');
        $this->load->view('backend/index', $data);
    }

    function admit_history($task = "") {
        if ($this->session->userdata('patient_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['page_name'] = 'show_admit_history';
        $data['page_title'] = get_phrase('admit_history');
        $this->load->view('backend/index', $data);
    }

    function operation_history($task = "") {
        if ($this->session->userdata('patient_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['page_name'] = 'show_operation_history';
        $data['page_title'] = get_phrase('operation_history');
        $this->load->view('backend/index', $data);
    }

    function manage_profile($task = "") {
        if ($this->session->userdata('patient_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $patient_id = $this->session->userdata('login_user_id');
        if ($task == "update") {
                $this->crud_model->update_patient_info($patient_id);
                $this->session->set_flashdata('message', get_phrase('profile_info_updated_successfuly'));
                redirect(base_url() . 'index.php?patient/manage_profile');
        }

        if ($task == "change_password") {
            $password = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->password;
            $old_password = sha1($this->input->post('old_password'));
            $new_password = $this->input->post('new_password');
            $confirm_new_password = $this->input->post('confirm_new_password');

            if ($password == $old_password && $new_password == $confirm_new_password) {
                $data['password'] = sha1($new_password);

                $this->db->where('patient_id', $patient_id);
                $this->db->update('patient', $data);

                $this->session->set_flashdata('message', get_phrase('password_info_updated_successfuly'));
                redirect(base_url() . 'index.php?patient/manage_profile');
            } else {
                $this->session->set_flashdata('message', get_phrase('password_update_failed'));
                redirect(base_url() . 'index.php?patient/manage_profile');
            }
        }

        $data['page_name'] = 'edit_profile';
        $data['page_title'] = get_phrase('profile');
        $this->load->view('backend/index', $data);
    }

    function appointment($task = "", $appointment_id = "") {
        if ($this->session->userdata('patient_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['appointment_info'] = $this->crud_model->select_appointment_info_by_patient_id();
        $data['page_name'] = 'show_appointment';
        $data['page_title'] = get_phrase('appointment');
        $this->load->view('backend/index', $data);
    }

    function appointment_pending($task = "", $appointment_id = "") {
        if ($this->session->userdata('patient_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_requested_appointment_info();
            $this->session->set_flashdata('message', get_phrase('request_for_appointment_sent'));
            redirect(base_url() . 'index.php?patient/appointment_pending');
        }

        $data['pending_appointment_info'] = $this->crud_model->select_pending_appointment_info_by_patient_id();
        $data['page_name'] = 'show_pending_appointment';
        $data['page_title'] = get_phrase('pending_appointment');
        $this->load->view('backend/index', $data);
    }

    function prescription($task = "", $prescription_id = "") {
        if ($this->session->userdata('patient_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['prescription_info'] = $this->crud_model->select_prescription_info_by_patient_id();
        $data['page_name'] = 'show_all_prescription';
        $data['page_title'] = get_phrase('prescription');
        $this->load->view('backend/index', $data);
    }

    function invoice($task = "", $invoice_id = "") {
        if ($this->session->userdata('patient_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['invoice_info'] = $this->crud_model->select_invoice_info_by_patient_id();
        $data['page_name'] = 'show_all_invoice';
        $data['page_title'] = get_phrase('invoice');
        $this->load->view('backend/index', $data);
    }

    /* private messaging */

    function message($param1 = 'message_home', $param2 = '', $param3 = '') {
        if ($this->session->userdata('patient_login') != 1)
            redirect(base_url(), 'refresh');

        if ($param1 == 'send_new') {
            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?patient/message/message_read/' . $message_thread_code, 'refresh');
        }

        if ($param1 == 'send_reply') {
            $this->crud_model->send_reply_message($param2);  //$param2 = message_thread_code
            $this->session->set_flashdata('message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?patient/message/message_read/' . $param2, 'refresh');
        }

        if ($param1 == 'message_read') {
            $page_data['current_message_thread_code'] = $param2;  // $param2 = message_thread_code
            $this->crud_model->mark_thread_messages_read($param2);
        }

        $page_data['message_inner_page_name'] = $param1;
        $page_data['page_name'] = 'message';
        $page_data['page_title'] = get_phrase('private_messaging');
        $this->load->view('backend/index', $page_data);
    }

}
