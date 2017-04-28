<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author : Robin San
 * 	date	: 11 Apr, 2017
 */

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');

        /* cache control */
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    /*     * *default function, redirects to login page if no admin logged in yet** */

    public function index() {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('admin_login') == 1)
            redirect(base_url() . 'index.php?admin/dashboard', 'refresh');
    }
    //set system local timezone.
    static function setSystemTz() {
      //  $systemTz = trim(file_get_contents("/etc/timezone"));
      //  if ($systemTz == 'Etc/UTC') $systemTz = 'UTC';
        $systemTz = "";
        date_default_timezone_set($systemTz);
    }
    /*     * *ADMIN DASHBOARD** */

    function dashboard() {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name'] = 'dashboard';
        $page_data['page_title'] = get_phrase('admin_dashboard');
        $this->load->view('backend/index', $page_data);
    }

    /*     * ***LANGUAGE SETTINGS******** */

    function manage_language($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'edit_phrase') {
            $page_data['edit_profile'] = $param2;
        }
        if ($param1 == 'update_phrase') {
            $language = $param2;
            $total_phrase = $this->input->post('total_phrase');
            for ($i = 1; $i < $total_phrase; $i++) {
                //$data[$language]	=	$this->input->post('phrase').$i;
                $this->db->where('phrase_id', $i);
                $this->db->update('language', array($language => $this->input->post('phrase' . $i)));
            }
            redirect(base_url() . 'index.php?admin/manage_language/edit_phrase/' . $language, 'refresh');
        }
        if ($param1 == 'do_update') {
            $language = $this->input->post('language');
            $data[$language] = $this->input->post('phrase');
            $this->db->where('phrase_id', $param2);
            $this->db->update('language', $data);
            $this->session->set_flashdata('message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
        }
        if ($param1 == 'add_phrase') {
            $data['phrase'] = $this->input->post('phrase');
            $this->db->insert('language', $data);
            $this->session->set_flashdata('message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
        }
        if ($param1 == 'add_language') {
            $language = $this->input->post('language');
            $this->load->dbforge();
            $fields = array(
                $language => array(
                    'type' => 'LONGTEXT'
                )
            );
            $this->dbforge->add_column('language', $fields);

            $this->session->set_flashdata('message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
        }
        if ($param1 == 'delete_language') {
            $language = $param2;
            $this->load->dbforge();
            $this->dbforge->drop_column('language', $language);
            $this->session->set_flashdata('message', get_phrase('settings_updated'));

            redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
        }
        $page_data['page_name'] = 'manage_language';
        $page_data['page_title'] = get_phrase('manage_language');
        //$page_data['language_phrases'] = $this->db->get('language')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    /*     * ***SITE/SYSTEM SETTINGS******** */

    function system_settings($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'do_update') {
            $this->crud_model->update_system_settings();
            $this->session->set_flashdata('message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/system_settings/', 'refresh');
        }
        if ($param1 == 'upload_logo') {
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/logo.png');
            $this->session->set_flashdata('message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/system_settings/', 'refresh');
        }
        $page_data['page_name'] = 'system_settings';
        $page_data['page_title'] = get_phrase('system_settings');
        $page_data['settings'] = $this->db->get('settings')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    // SMS settings.
    function sms_settings($param1 = '') {

        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'do_update') {
            $this->crud_model->update_sms_settings();
            $this->session->set_flashdata('message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/sms_settings/', 'refresh');
        }

        $page_data['page_name'] = 'sms_settings';
        $page_data['page_title'] = get_phrase('sms_settings');
        $this->load->view('backend/index', $page_data);
    }

    /*     * ****MANAGE OWN PROFILE AND CHANGE PASSWORD** */
   
    function manage_profile($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'update_profile_info') {
            $data['name'] = $this->input->post('name');
            $data['email'] = $this->input->post('email');

            $this->db->where('admin_id', $this->session->userdata('login_user_id'));
            $this->db->update('admin', $data);

            $this->session->set_flashdata('message', get_phrase('profile_info_updated_successfuly'));
            redirect(base_url() . 'index.php?admin/manage_profile');
        }
        if ($param1 == 'change_password') {
            $current_password_input = sha1($this->input->post('password'));
            $new_password = sha1($this->input->post('new_password'));
            $confirm_new_password = sha1($this->input->post('confirm_new_password'));

            $current_password_db = $this->db->get_where('admin', array('admin_id' =>
                        $this->session->userdata('login_user_id')))->row()->password;

            if ($current_password_db == $current_password_input && $new_password == $confirm_new_password) {
                $this->db->where('admin_id', $this->session->userdata('login_user_id'));
                $this->db->update('admin', array('password' => $new_password));

                $this->session->set_flashdata('message', get_phrase('password_info_updated_successfuly'));
                redirect(base_url() . 'index.php?admin/manage_profile');
            } else {
                $this->session->set_flashdata('message', get_phrase('password_update_failed'));
                redirect(base_url() . 'index.php?admin/manage_profile');
            }
        }
        $page_data['page_name'] = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data'] = $this->db->get_where('admin', array('admin_id' => $this->session->userdata('login_user_id')))->result_array();
        $this->load->view('backend/index', $page_data);
    }

    function department($task = "", $department_id = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_department_info();
            $this->session->set_flashdata('message', get_phrase('department_info_saved_successfuly'));
            redirect(base_url() . 'index.php?admin/department');
        }

        if ($task == "update") {
            $this->crud_model->update_department_info($department_id);
            $this->session->set_flashdata('message', get_phrase('department_info_updated_successfuly'));
            redirect(base_url() . 'index.php?admin/department');
        }

        if ($task == "delete") {
            $this->crud_model->delete_department_info($department_id);
            redirect(base_url() . 'index.php?admin/department');
        }

        $data['department_info'] = $this->crud_model->select_department_info();
        $data['page_name'] = 'manage_department';
        $data['page_title'] = get_phrase('department');
        $this->load->view('backend/index', $data);
    }

    function doctor($task = "", $doctor_id = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create") {
            $email = $_POST['email'];
            $doctor = $this->db->get_where('doctor', array('email' => $email))->row()->name;

            if ($doctor == null) {
                $this->crud_model->save_doctor_info();
                $this->session->set_flashdata('message', get_phrase('doctor_info_saved_successfuly'));
            } else {
                $this->session->set_flashdata('message', get_phrase('duplicate_email'));
            }
            redirect(base_url() . 'index.php?admin/doctor');
        }

        if ($task == "update") {
          
                $this->crud_model->update_doctor_info($doctor_id);
                $this->session->set_flashdata('message', get_phrase('doctor_info_updated_successfuly'));
            
                redirect(base_url() . 'index.php?admin/doctor');
        }

        if ($task == "delete") {
            $this->crud_model->delete_doctor_info($doctor_id);
            redirect(base_url() . 'index.php?admin/doctor');
        }
        $data['doctor_info'] = $this->crud_model->select_doctor_info();
        $data['page_name'] = 'manage_doctor';
        $data['page_title'] = get_phrase('doctor');
        $this->load->view('backend/index', $data);
    }
    
    function reception($task = "", $reception_id = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if($task=="register"||$task=="view"){
            $comm = "add_reception";//($task=="register"||strlen($reception_id)==0)?"add_reception":"view_reception";
            $data['page_name'] = $comm;//($task=="register"||strlen($reception_id)==0)?"add_reception":"view_reception";
            $data['param2'] = $reception_id;
            $data['page_title'] = get_phrase(($task=="register"||strlen($reception_id)==0)?"add_reception":"view_reception");
            $this->load->view('backend/index', $data);
        }else {
            if ($task == "delete") {
                $this->crud_model->delete_reception_info($reception_id);
                $this->session->set_flashdata('message', get_phrase('reception_info_deleted_successfuly'));
                redirect(base_url() . 'index.php?admin/reception');
            }

            $data['receptions_info'] = $this->crud_model->select_receptions_info();
            $data['page_name'] = 'manage_reception';
            $data['page_title'] = get_phrase('reception');
            $this->load->view('backend/index', $data);
        }    
        
    }
    function triage($task = "", $patient_id = "",$queue_id="") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if($task=="register"||$task=="edit"){
            $comm =  (($task=="register")?'add':'edit')."_triage";
            $data['page_name'] = $comm;
            $data['page_title'] = get_phrase($comm);
            $data['param2'] = $patient_id;
            $data['param3'] = $queue_id;
            $this->load->view('backend/index', $data);
        }else {
            if ($task == "create") {
      /*          $email = $_POST['email'];
                $patient = $this->db->get_where('patient', array('email' => $email))->row()->name;
                if ($patient == null) {
                    $this->crud_model->save_patient_info();
                    $this->session->set_flashdata('message', get_phrase('patient_info_saved_successfuly'));
                } else {
                    $this->session->set_flashdata('message', get_phrase('duplicate_email'));
                }*/
                redirect(base_url() . 'index.php?admin/triage');
            }

            if ($task == "update") {
     //               $this->crud_model->update_patient_info($patient_id);
    //                $this->session->set_flashdata('message', get_phrase('patient_info_updated_successfuly'));
                    redirect(base_url() . 'index.php?admin/triage');
            }

            if ($task == "delete") {
     //           $this->crud_model->delete_patient_info($patient_id);
                redirect(base_url() . 'index.php?admin/triage');
            }

   //         $data['patient_info'] = $this->crud_model->select_patient_info();
            $data['page_name'] = 'manage_triage';
            $data['page_title'] = get_phrase('triage');
            $this->load->view('backend/index', $data);
        }    
    }
//patient
    function patient($task = "", $patient_id = "") {
        
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if($task=="register"||$task=="edit"){
            $comm =  (($task=="register")?'add':'edit')."_patient";
            $data['page_name'] = $comm;
            $data['page_title'] = get_phrase($comm);
            $data['param2'] = $patient_id;
            $this->load->view('backend/index', $data);
        }else {
            if ($task == "create") {
                $email = $_POST['email'];
                $username = $_POST['username'];
                $patient = $this->db->get_where('patient', array('email' => $email))->row()->name;
                if ($patient == null) {
                    $patient_id = $this->crud_model->save_patient_info();
                    $this->session->set_flashdata('message', get_phrase('patient_info_saved_successfuly'));
                } else {
                    $this->session->set_flashdata('message', get_phrase('duplicate_email'));
                }
                redirect(base_url() . "index.php?admin/patient/edit/$patient_id");
            }

            if ($task == "update") {
                    $this->crud_model->update_patient_info($patient_id);
                    $this->session->set_flashdata('message', get_phrase('patient_info_updated_successfuly'));
                    redirect(base_url() . "index.php?admin/patient/edit/$patient_id");
            }

            if ($task == "delete") {
                $this->crud_model->delete_patient_info($patient_id);
                redirect(base_url() . 'index.php?admin/patient');
            }

            $data['patient_info'] = $this->crud_model->select_patient_info();
            $data['page_name'] = 'manage_patient';
            $data['page_title'] = get_phrase('patient');
            $this->load->view('backend/index', $data);
        }    
        
    }

    function nurse($task = "", $nurse_id = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create") {
            $email = $_POST['email'];
            $nurse = $this->db->get_where('nurse', array('email' => $email))->row()->name;
            if ($nurse == null) {
                $this->crud_model->save_nurse_info();
                $this->session->set_flashdata('message', get_phrase('nurse_info_saved_successfuly'));
            } else {
                $this->session->set_flashdata('message', get_phrase('duplicate_email'));
            }
            redirect(base_url() . 'index.php?admin/nurse');
        }

        if ($task == "update") {
                $this->crud_model->update_nurse_info($nurse_id);
                $this->session->set_flashdata('message', get_phrase('nurse_info_updated_successfuly'));
                redirect(base_url() . 'index.php?admin/nurse');
        }

        if ($task == "delete") {
            $this->crud_model->delete_nurse_info($nurse_id);
            redirect(base_url() . 'index.php?admin/nurse');
        }

        $data['nurse_info'] = $this->crud_model->select_nurse_info();
        $data['page_name'] = 'manage_nurse';
        $data['page_title'] = get_phrase('nurse');
        $this->load->view('backend/index', $data);
    }

    function pharmacist($task = "", $pharmacist_id = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create") {
            $email = $_POST['email'];
            $pharmacist = $this->db->get_where('pharmacist', array('email' => $email))->row()->name;
            if ($pharmacist == null) {
                $this->crud_model->save_pharmacist_info();
                $this->session->set_flashdata('message', get_phrase('pharmacist_info_saved_successfuly'));
            } else {
                $this->session->set_flashdata('message', get_phrase('duplicate_email'));
            }
            redirect(base_url() . 'index.php?admin/pharmacist');
        }

        if ($task == "update") {
                $this->crud_model->update_pharmacist_info($pharmacist_id);
                $this->session->set_flashdata('message', get_phrase('pharmacist_info_updated_successfuly'));
                redirect(base_url() . 'index.php?admin/pharmacist');
        }

        if ($task == "delete") {
            $this->crud_model->delete_pharmacist_info($pharmacist_id);
            redirect(base_url() . 'index.php?admin/pharmacist');
        }

        $data['pharmacist_info'] = $this->crud_model->select_pharmacist_info();
        $data['page_name'] = 'manage_pharmacist';
        $data['page_title'] = get_phrase('pharmacist');
        $this->load->view('backend/index', $data);
    }

    function laboratorist($task = "", $laboratorist_id = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create") {
            $email = $_POST['email'];
            $laboratorist = $this->db->get_where('laboratorist', array('email' => $email))->row()->name;
            if ($laboratorist == null) {
                $this->crud_model->save_laboratorist_info();
                $this->session->set_flashdata('message', get_phrase('laboratorist_info_saved_successfuly'));
            } else {
                $this->session->set_flashdata('message', get_phrase('duplicate_email'));
            }
            redirect(base_url() . 'index.php?admin/laboratorist');
        }

        if ($task == "update") {
                $this->crud_model->update_laboratorist_info($laboratorist_id);
                $this->session->set_flashdata('message', get_phrase('laboratorist_info_updated_successfuly'));
                redirect(base_url() . 'index.php?admin/laboratorist');
        }

        if ($task == "delete") {
            $this->crud_model->delete_laboratorist_info($laboratorist_id);
            redirect(base_url() . 'index.php?admin/laboratorist');
        }

        $data['laboratorist_info'] = $this->crud_model->select_laboratorist_info();
        $data['page_name'] = 'manage_laboratorist';
        $data['page_title'] = get_phrase('laboratorist');
        $this->load->view('backend/index', $data);
    }

    function accountant($task = "", $accountant_id = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create") {
            $email = $_POST['email'];
            $accountant = $this->db->get_where('accountant', array('email' => $email))->row()->name;
            if ($accountant == null) {
                $this->crud_model->save_accountant_info();
                $this->session->set_flashdata('message', get_phrase('accountant_info_saved_successfuly'));
            } else {
                $this->session->set_flashdata('message', get_phrase('duplicate_email'));
            }
            redirect(base_url() . 'index.php?admin/accountant');
        }

        if ($task == "update") {
                $this->crud_model->update_accountant_info($accountant_id);
                $this->session->set_flashdata('message', get_phrase('accountant_info_updated_successfuly'));
                redirect(base_url() . 'index.php?admin/accountant');
        }

        if ($task == "delete") {
            $this->crud_model->delete_accountant_info($accountant_id);
            redirect(base_url() . 'index.php?admin/accountant');
        }

        $data['accountant_info'] = $this->crud_model->select_accountant_info();
        $data['page_name'] = 'manage_accountant';
        $data['page_title'] = get_phrase('accountant');
        $this->load->view('backend/index', $data);
    }

    function receptionist($task = "", $receptionist_id = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create") {
            $email = $_POST['email'];
            $receptionist = $this->db->get_where('receptionist', array('email' => $email))->row()->name;
            if ($receptionist == null) {
                $this->crud_model->save_receptionist_info();
                $this->session->set_flashdata('message', get_phrase('receptionist_info_saved_successfuly'));
            } else {
                $this->session->set_flashdata('message', get_phrase('duplicate_email'));
            }
            redirect(base_url() . 'index.php?admin/receptionist');
        }

        if ($task == "update") {
                $this->crud_model->update_receptionist_info($receptionist_id);
                $this->session->set_flashdata('message', get_phrase('receptionist_info_updated_successfuly'));
                redirect(base_url() . 'index.php?admin/receptionist');
        }

        if ($task == "delete") {
            $this->crud_model->delete_receptionist_info($receptionist_id);
            redirect(base_url() . 'index.php?admin/receptionist');
        }

        $data['receptionist_info'] = $this->crud_model->select_receptionist_info();
        $data['page_name'] = 'manage_receptionist';
        $data['page_title'] = get_phrase('receptionist');
        $this->load->view('backend/index', $data);
    }

    function payment_history($task = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['invoice_info'] = $this->crud_model->select_invoice_info();
        $data['page_name'] = 'show_payment_history';
        $data['page_title'] = get_phrase('payment_history');
        $this->load->view('backend/index', $data);
    }

    function bed_allotment($task = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['bed_allotment_info'] = $this->crud_model->select_bed_allotment_info();
        $data['page_name'] = 'show_bed_allotment';
        $data['page_title'] = get_phrase('bed_allotment');
        $this->load->view('backend/index', $data);
    }

    function blood_bank($task = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['blood_bank_info'] = $this->crud_model->select_blood_bank_info();
        $data['page_name'] = 'show_blood_bank';
        $data['page_title'] = get_phrase('blood_bank');
        $this->load->view('backend/index', $data);
    }

    function blood_donor($task = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['blood_donor_info'] = $this->crud_model->select_blood_donor_info();
        $data['page_name'] = 'show_blood_donor';
        $data['page_title'] = get_phrase('blood_donor');
        $this->load->view('backend/index', $data);
    }

    function medicine($task = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['medicine_info'] = $this->crud_model->select_medicine_info();
        $data['page_name'] = 'show_medicine';
        $data['page_title'] = get_phrase('medicine');
        $this->load->view('backend/index', $data);
    }

    function operation_report($task = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['page_name'] = 'show_operation_report';
        $data['page_title'] = get_phrase('operation_report');
        $this->load->view('backend/index', $data);
    }

    function birth_report($task = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['page_name'] = 'show_birth_report';
        $data['page_title'] = get_phrase('birth_report');
        $this->load->view('backend/index', $data);
    }

    function death_report($task = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['page_name'] = 'show_death_report';
        $data['page_title'] = get_phrase('death_report');
        $this->load->view('backend/index', $data);
    }

    function notice($task = "", $notice_id = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_notice_info();
            $this->session->set_flashdata('message', get_phrase('notice_info_saved_successfuly'));
            redirect(base_url() . 'index.php?admin/notice');
        }

        if ($task == "update") {
            $this->crud_model->update_notice_info($notice_id);
            $this->session->set_flashdata('message', get_phrase('notice_info_updated_successfuly'));
            redirect(base_url() . 'index.php?admin/notice');
        }

        if ($task == "delete") {
            $this->crud_model->delete_notice_info($notice_id);
            redirect(base_url() . 'index.php?admin/notice');
        }

        $data['notice_info'] = $this->crud_model->select_notice_info();
        $data['page_name'] = 'manage_notice';
        $data['page_title'] = get_phrase('noticeboard');
        $this->load->view('backend/index', $data);
    }

    // PAYROLL
    function payroll()
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $page_data['page_name']     = 'payroll_add';
        $page_data['page_title']    = get_phrase('create_payroll');
        $this->load->view('backend/index', $page_data);
    }

    function payroll_selector()
    {
        $user           = explode('-', $this->input->post('employee_id'));
        $user_type      = $user[0];
        $employee_id    = $user[1];
        $month          = $this->input->post('month');
        $year           = $this->input->post('year');
        
        redirect(base_url() . 'index.php?admin/payroll_view/' . $user_type
            . '/' . $employee_id . '/' . $month . '/' . $year, 'refresh');
    }
    
    function payroll_view($user_type = '', $employee_id = '', $month = '', $year = '')
    {
        $page_data['user_type']     = $user_type;
        $page_data['employee_id']   = $employee_id;
        $page_data['month']         = $month;
        $page_data['year']          = $year;
        $page_data['page_name']     = 'payroll_add_view';
        $page_data['page_title']    = get_phrase('create_payroll');
        $this->load->view('backend/index', $page_data);
    }
    
    function create_payroll()
    {
        $data['payroll_code']   = substr(md5(rand(100000000, 20000000000)), 0, 7);
        $data['user_id']        = $this->input->post('user_id');
        $data['user_type']      = $this->input->post('user_type');
        $data['joining_salary'] = $this->input->post('joining_salary');
        
        $allowances             = array();
        $allowance_types        = $this->input->post('allowance_type');
        $allowance_amounts      = $this->input->post('allowance_amount');
        $number_of_entries      = sizeof($allowance_types);
        
        for($i = 0; $i < $number_of_entries; $i++)
        {
            if($allowance_types[$i] != "" && $allowance_amounts[$i] != "")
            {
                $new_entry = array('type' => $allowance_types[$i], 'amount' => $allowance_amounts[$i]);
                array_push($allowances, $new_entry);
            }
        }
        $data['allowances']     = json_encode($allowances);
        
        $deductions             = array();
        $deduction_types        = $this->input->post('deduction_type');
        $deduction_amounts      = $this->input->post('deduction_amount');
        $number_of_entries      = sizeof($deduction_types);
        
        for($i = 0; $i < $number_of_entries; $i++)
        {
            if($deduction_types[$i] != "" && $deduction_amounts[$i] != "")
            {
                $new_entry = array('type' => $deduction_types[$i], 'amount' => $deduction_amounts[$i]);
                array_push($deductions, $new_entry);
            }
        }
        $data['deductions']     = json_encode($deductions);
        $data['date']           = $this->input->post('month') . ',' . $this->input->post('year');
        $data['status']         = $this->input->post('status');
        
        $this->db->insert('payroll', $data);
        
        $this->session->set_flashdata('message', get_phrase('data_created_successfully'));
        redirect(base_url() . 'index.php?admin/payroll_list', 'refresh');
    }
    
    function payroll_list($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if($param1 == 'mark_paid') {
            $data['status'] = 1;
            
            $this->db->update('payroll', $data, array('payroll_id' => $param2));
            
            $this->session->set_flashdata('message', get_phrase('data_updated_successfully'));
            redirect(base_url() . 'index.php?admin/payroll_list', 'refresh');
        }
        
        $page_data['page_name']     = 'payroll_list';
        $page_data['page_title']    = get_phrase('payroll_list');
        $this->load->view('backend/index', $page_data);
    }
    //consultations
    function consultation($task="", $param1 = "",$param2=""){
         if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if($task=="register"||$task=="edit"){
            $comm =  (($task=="register")?'add':'edit')."_consultation";
            $data['page_name'] = $comm;
            $data['page_title'] = get_phrase("general_consultation");
            $data['param2'] = $param1;
            $data['param3'] = $param2;
            $this->load->view('backend/index', $data);
        }else {
            if ($task == "update") {
     //               $this->crud_model->update_patient_info($patient_id);
    //                $this->session->set_flashdata('message', get_phrase('patient_info_updated_successfuly'));
                    redirect(base_url() . 'index.php?admin/consultation');
            }

            if ($task == "delete") {
                $this->crud_model->delete_consultation_info($param1);
                redirect(base_url() . 'index.php?admin/consultation');
            }

   //         $data['patient_info'] = $this->crud_model->select_patient_info();
            $data['page_name'] = 'manage_consultation';
            $data['page_title'] = get_phrase('consultation');
            $this->load->view('backend/index', $data);
        }    
    }
     //payments
    function payment($task="", $param1 = "",$param2=""){
         if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if($task=="register"||$task=="edit"){
            $comm =  (($task=="register")?'add':'edit')."_payment";
            $data['page_name'] = $comm;
            $data['page_title'] = get_phrase("payment");
            if (count($param1)==0){
                redirect(base_url(), 'refresh');
                return;
            }
            $data['param2'] = $param1; // reception id
            $this->load->view('backend/index', $data);
        }else {
            if ($task == "update") {
     //               $this->crud_model->update_patient_info($patient_id);
    //                $this->session->set_flashdata('message', get_phrase('patient_info_updated_successfuly'));
                    redirect(base_url() . 'index.php?admin/consultation');
            }

            if ($task == "delete") {
                $this->crud_model->delete_consultation_info($param1);
                redirect(base_url() . 'index.php?admin/consultation');
            }

   //         $data['patient_info'] = $this->crud_model->select_patient_info();
            $data['page_name'] = 'manage_payment';
            $data['page_title'] = get_phrase('payments');
            $this->load->view('backend/index', $data);
        }    
    }
    //laboratory management
    function labreq($task = "", $labreq_id = "") {
        
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if($task=="register"||$task=="edit"){
            $comm =  "add_laboratory";
            $data['page_name'] = $comm;
            $data['page_title'] = get_phrase("laboratory_process");
            if (count($labreq_id)==0){
                redirect(base_url(), 'refresh');
                return;
            }
            $data['param2'] = $labreq_id;
            $this->load->view('backend/index', $data);
        }else {
            
          

            if ($task == "delete" && strlen($labreq_id)>0) {
                $this->crud_model->delete_labreq_info($labreq_id);
                redirect(base_url() . 'index.php?admin/labreq');
            }
            $data['page_name'] = 'manage_laboratory';
            $data['page_title'] = get_phrase('laboratory');
            $this->load->view('backend/index', $data);
        }    
    }
    //radiology management
    function radreq($task = "", $radreq_id = "") {
        
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if($task=="register"||$task=="edit"){
            $comm =  "add_radiology";
            $data['page_name'] = $comm;
            $data['page_title'] = get_phrase("radiology_process");
            if (count($radreq_id)==0){
                redirect(base_url(), 'refresh');
                return;
            }
            $data['param2'] = $radreq_id;
            $this->load->view('backend/index', $data);
        }else {
       
            if ($task == "delete" && strlen($radreq_id)>0) {
                $this->crud_model->delete_labreq_info($radreq_id);
                redirect(base_url() . 'index.php?admin/radreq');
            }
            $data['page_name'] = 'manage_radiology';
            $data['page_title'] = get_phrase('radiology');
            $this->load->view('backend/index', $data);
        }    
    }
    //pharmacy management
    function pharmreq($task = "", $req_id = "") {
        
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if($task=="register"||$task=="edit"){
            $comm =  "add_pharmacy_bill";
            $data['page_name'] = $comm;
            $data['page_title'] = get_phrase("pharmacy_bill_process");
            if (count($req_id)==0){
                redirect(base_url(), 'refresh');
                return;
            }
            $data['param2'] = $req_id;
            $this->load->view('backend/index', $data);
        }else {
       
            if ($task == "delete" && strlen($req_id)>0) {
                $this->crud_model->delete_pharmreq_info($req_id);
                redirect(base_url() . 'index.php?admin/pharmreq');
            }
            $data['page_name'] = 'manage_pharmacy_bill';
            $data['page_title'] = get_phrase('pharmacy_request_list');
            $this->load->view('backend/index', $data);
        }    
    }
    // manage billing service
    function mngbillserv(){
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        };
        $data['page_name'] = 'manage_billing_services';
        $data['page_title'] = get_phrase('manage_billing_services');
        $this->load->view('backend/index', $data);
    }
    // manage journal entries
    function journalentry($task = "",$id="") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create") {
            $email = $_POST['email'];
            $nurse = $this->db->get_where('nurse', array('email' => $email))->row()->name;
            if ($nurse == null) {
                $this->crud_model->save_nurse_info();
                $this->session->set_flashdata('message', get_phrase('nurse_info_saved_successfuly'));
            } else {
                $this->session->set_flashdata('message', get_phrase('duplicate_email'));
            }
            redirect(base_url() . 'index.php?admin/journalentry');
        }elseif($task=="post"){
            // post ledger entries to general ledger
            $b = $this->crud_model->post_ledger_entries($id);
            $msg="";
            if($b){
                $msg = 'All ledger entries was posted to general ledger successfully';
            }else{
                $msg = "Got some errors, so not posted yet.";
            }
            $this->session->set_flashdata('message', $msg);
            redirect(base_url() . 'index.php?admin/journalentry');
            return;
        }
        $data['journal_entry_info'] = $this->crud_model->select_journal_entry_info();
        $data['page_name'] = 'manage_journal';
        $data['page_title'] = get_phrase('journal_entries');
        $this->load->view('backend/index', $data);
    }
}



























