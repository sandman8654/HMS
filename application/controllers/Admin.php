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
            $data['user_name'] = $this->input->post('username');
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

    function doctor($task = "", $doctor_id = "",$other="") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
         $account_str = "doctor";
        if ($task == "create") {
            $username = $_POST['username'];
            if ($this->crud_model->check_sys_user_name($username)) {
                $this->crud_model->save_doctor_info();
                $this->session->set_flashdata('message', get_phrase('doctor_info_saved_successfuly'));
            } else {
                $this->session->set_flashdata('message', get_phrase('duplicate_system_user_name'));
            }
            redirect(base_url() . 'index.php?admin/doctor');
        }
        if ($task=="edit"||$task=="register"||$task=="edit_employee"){
           
            if ($task=="edit_employee"){
                $comm = "edit"."_employee_info";
                $data['page_title'] = get_phrase("edit_employee_information");
                $data['account_type_str'] = $account_str;
                $data['account_id'] = $doctor_id;
                $data['tabs_type'] = $other;
            } else{
                $comm =  (($task=="register")?'add':'edit')."_".$account_str;
                $data['page_title'] = get_phrase($comm);
                $data['param2'] = $doctor_id;
            }
            $data['page_name'] = $comm;
            $this->load->view('backend/index', $data);
            return;
        }
        if ($task == "update") {
            $this->crud_model->update_doctor_info($doctor_id);
            $this->session->set_flashdata('message', get_phrase('doctor_info_updated_successfuly'));
            
            redirect(base_url() . 'index.php?admin/doctor');
        }
        if ($task == "update_emp") {
            $this->manage_emplyee_info($account_str, $doctor_id, $other);
            return;
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
        if($task=="register"||$task=="edit"){
            $comm = "add_reception";//($task=="register"||strlen($reception_id)==0)?"add_reception":"view_reception";
            $data['page_name'] = $comm;//($task=="register"||strlen($reception_id)==0)?"add_reception":"view_reception";
            $data['param2'] = $reception_id;
            $data['page_title'] = get_phrase(($task=="register"||strlen($reception_id)==0)?"add_reception":"view_reception");
            $this->load->view('backend/index', $data);
        }else if($task=="registerfrompm"){
            $res = $this->crud_model->save_reception_info("",$reception_id);
            $data['page_name'] =  "add_reception";
            $data['param2'] = $res[0]['reception_id'];
            $data['page_title'] = "add_reception";
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
                $this->crud_model->delete_triage_info($patient_id);
                redirect(base_url() . 'index.php?admin/triage');
            }

   //         $data['patient_info'] = $this->crud_model->select_patient_info();
            $data['page_name'] = 'manage_triage';
            $data['page_title'] = get_phrase('triage');
            $this->load->view('backend/index', $data);
        }    
    }
//patient
    function patient($task = "", $patient_id = "",$other="") {
        
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
                $patient = $this->db->get_where('patient', array('user_name' => $username))->row()->name;
                if ($patient == null) {
                    $patient_id = $this->crud_model->save_patient_info();
                    $this->session->set_flashdata('message', get_phrase('patient_info_saved_successfuly'));
                } else {
                    $this->session->set_flashdata('message', get_phrase('duplicate_user_name'));
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
    function admin($task = "", $admin_id = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $account_str = "admin";
        if ($task == "create") {
           $username = $_POST['username'];
           if ($this->crud_model->check_sys_user_name($username)) {
                $this->crud_model->save_admin_info();
                $this->session->set_flashdata('message', get_phrase('admin_info_saved_successfuly'));
            } else {
                $this->session->set_flashdata('message', get_phrase('duplicate_system_user_name'));
            }
            redirect(base_url() . 'index.php?admin/admin');
        }
        if ($task=="edit"||$task=="register"||$task=="edit_employee"){
           
            if ($task=="edit_employee"){
                $comm = "edit"."_employee_info";
                $data['page_title'] = get_phrase("edit_employee_information");
                $data['account_type_str'] = $account_str;
                $data['account_id'] = $admin_id;
                $data['tabs_type'] = $other;
            } else{
                $comm =  (($task=="register")?'add':'edit')."_".$account_str;
                $data['page_title'] = get_phrase($comm);
                $data['param2'] = $admin_id;
            }
            $data['page_name'] = $comm;
            $this->load->view('backend/index', $data);
            return;
        }
        if ($task == "update") {
                $this->crud_model->update_admin_info($admin_id);
                $this->session->set_flashdata('message', get_phrase('administrator_info_updated_successfuly'));
                redirect(base_url() . 'index.php?admin/admin');
        }
         if ($task == "update_emp") {
            $this->manage_emplyee_info($account_str, $admin_id, $other);
            return;
        }
        if ($task == "delete") {
            $this->crud_model->delete_admin_info($admin_id);
            redirect(base_url() . 'index.php?admin/admin');
        }

        $data['admin_info'] = $this->crud_model->select_admin_info();
        $data['page_name'] = 'manage_administrator';
        $data['page_title'] = get_phrase('administrator');
        $this->load->view('backend/index', $data);
    }
    function nurse($task = "", $nurse_id = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $account_str = "nurse";
        if ($task == "create") {
           $username = $_POST['username'];
           if ($this->crud_model->check_sys_user_name($username)) {
                $this->crud_model->save_nurse_info();
                $this->session->set_flashdata('message', get_phrase('nurse_info_saved_successfuly'));
            } else {
                $this->session->set_flashdata('message', get_phrase('duplicate_system_user_name'));
            }
            redirect(base_url() . 'index.php?admin/nurse');
        }
        if ($task=="edit"||$task=="register"||$task=="edit_employee"){
           
            if ($task=="edit_employee"){
                $comm = "edit"."_employee_info";
                $data['page_title'] = get_phrase("edit_employee_information");
                $data['account_type_str'] = $account_str;
                $data['account_id'] = $nurse_id;
                $data['tabs_type'] = $other;
            } else{
                $comm =  (($task=="register")?'add':'edit')."_".$account_str;
                $data['page_title'] = get_phrase($comm);
                $data['param2'] = $nurse_id;
            }
            $data['page_name'] = $comm;
            $this->load->view('backend/index', $data);
            return;
        }
        if ($task == "update") {
                $this->crud_model->update_nurse_info($nurse_id);
                $this->session->set_flashdata('message', get_phrase('nurse_info_updated_successfuly'));
                redirect(base_url() . 'index.php?admin/nurse');
        }
         if ($task == "update_emp") {
            $this->manage_emplyee_info($account_str, $nurse_id, $other);
            return;
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

    function pharmacist($task = "", $pharmacist_id = "",$other="") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $account_str = "pharmacist";
        if ($task == "create") {
            $username = $_POST['username'];
            if ($this->crud_model->check_sys_user_name(username)) {
                $this->crud_model->save_pharmacist_info();
                $this->session->set_flashdata('message', get_phrase('pharmacist_info_saved_successfuly'));
            } else {
                $this->session->set_flashdata('message', get_phrase('duplicate_email'));
            }
            redirect(base_url() . 'index.php?admin/pharmacist');
        }
        if ($task=="edit"||$task=="register"||$task=="edit_employee"){
           
            if ($task=="edit_employee"){
                $comm = "edit"."_employee_info";
                $data['page_title'] = get_phrase("edit_employee_information");
                $data['account_type_str'] = $account_str;
                $data['account_id'] = $pharmacist_id;
                $data['tabs_type'] = $other;
            } else{
                $comm =  (($task=="register")?'add':'edit')."_".$account_str;
                $data['page_title'] = get_phrase($comm);
                $data['param2'] = $pharmacist_id;
            }
            $data['page_name'] = $comm;
            $this->load->view('backend/index', $data);
            return;
        }
        if ($task == "update_emp") {
            $this->manage_emplyee_info($account_str, $pharmacist_id, $other);
            return;
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

    function laboratorist($task = "", $laboratorist_id = "",$other="") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $account_str = "laboratorist";
        if ($task == "create") {
            $username = $_POST['username'];
            if ($this->crud_model->check_sys_user_name(username)) {
                $this->crud_model->save_laboratorist_info();
                $this->session->set_flashdata('message', get_phrase('laboratorist_info_saved_successfuly'));
            } else {
                $this->session->set_flashdata('message', get_phrase('duplicate_system_user_name'));
            }
            redirect(base_url() . 'index.php?admin/laboratorist');
        }

        if ($task == "update") {
                $this->crud_model->update_laboratorist_info($laboratorist_id);
                $this->session->set_flashdata('message', get_phrase('laboratorist_info_updated_successfuly'));
                redirect(base_url() . 'index.php?admin/laboratorist');
        }
        if ($task=="edit"||$task=="register"||$task=="edit_employee"){
           
            if ($task=="edit_employee"){
                $comm = "edit"."_employee_info";
                $data['page_title'] = get_phrase("edit_employee_information");
                $data['account_type_str'] = $account_str;
                $data['account_id'] = $laboratorist_id;
                $data['tabs_type'] = $other;
            } else{
                $comm =  (($task=="register")?'add':'edit')."_".$account_str;
                $data['page_title'] = get_phrase($comm);
                $data['param2'] = $laboratorist_id;
            }
            $data['page_name'] = $comm;
            $this->load->view('backend/index', $data);
            return;
        }
        if ($task == "update_emp") {
            $this->manage_emplyee_info($account_str, $laboratorist_id, $other);
            return;
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

    function accountant($task = "", $accountant_id = "",$other="") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $account_str = "accountant";
        if ($task == "create") {
            $email = $_POST['email'];
            //$accountant = $this->db->get_where($account_str, array('email' => $email))->row()->name;
            $username = $_POST['username'];
            if ($this->crud_model->check_sys_user_name($username)) {
                $this->crud_model->save_accountant_info();
                $this->session->set_flashdata('message', get_phrase($account_str.'_info_saved_successfuly'));
            } else {
                $this->session->set_flashdata('message', get_phrase('duplicate_system_user_name'));
            }
            redirect(base_url() . 'index.php?admin/'.$account_str);
        }
        if ($task=="edit"||$task=="register"||$task=="edit_employee"){
           
            if ($task=="edit_employee"){
                $comm = "edit"."_employee_info";
                $data['page_title'] = get_phrase("edit_employee_information");
                $data['account_type_str'] = $account_str;
                $data['account_id'] = $accountant_id;
                $data['tabs_type'] = $other;
            } else{
                $comm =  (($task=="register")?'add':'edit')."_".$account_str;
                $data['page_title'] = get_phrase($comm);
                $data['param2'] = $accountant_id;
            }
            $data['page_name'] = $comm;
            $this->load->view('backend/index', $data);
            return;
        }
        if ($task == "update") {
                $this->crud_model->update_account_info($account_str,$accountant_id);
                $this->session->set_flashdata('message', get_phrase($account_str.'_info_updated_successfuly'));
                redirect(base_url() . 'index.php?admin/'.$account_str);
        }
        if ($task == "update_emp") {
            $this->manage_emplyee_info($account_str,$accountant_id,$other);
            return;
        }

        if ($task == "delete") {
            $this->crud_model->delete_accountant_info($accountant_id);
            redirect(base_url() . 'index.php?admin/'.$account_str);
        }

        $data[$account_str.'_info'] = $this->crud_model->select_accountant_info();
        $data['page_name'] = 'manage_'.$account_str;
        $data['page_title'] = get_phrase($account_str);
        $this->load->view('backend/index', $data);
    }

    function receptionist($task = "", $receptionist_id = "",$other="") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $account_str="receptionist";
        if ($task == "create") {
            $username = $_POST['username'];
            if ($this->crud_model->check_sys_user_name(username)) {
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
        if ($task=="edit"||$task=="register"||$task=="edit_employee"){
           
            if ($task=="edit_employee"){
                $comm = "edit"."_employee_info";
                $data['page_title'] = get_phrase("edit_employee_information");
                $data['account_type_str'] = $account_str;
                $data['account_id'] = $receptionist_id;
                $data['tabs_type'] = $other;
            } else{
                $comm =  (($task=="register")?'add':'edit')."_".$account_str;
                $data['page_title'] = get_phrase($comm);
                $data['param2'] = $receptionist_id;
            }
            $data['page_name'] = $comm;
            $this->load->view('backend/index', $data);
            return;
        }
        if ($task == "update_emp") {
            $this->manage_emplyee_info($account_str, $receptionist_id, $other);
            return;
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
/*
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
*/
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
        /* */
        
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

        $this->db->like("emp", $user_type."-".$employee_id);
        $emp_info_list = $this->db->get("employee");
        $basic_salary =0;
        if($emp_info_list->num_rows()>0)
            $basic_salary = $emp_info_list->row()->salary;
        if ($basic_salary=="") $basic_salary=0;    
        $page_data['basic_salary'] = $basic_salary;
        
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
            
            if ($task=="create"){
                $reqstr=explode("-",$this->input->post("pinfo"));
                $data["recept_id"] = $reqstr[0];
                $data["patient_id"] = $reqstr[1];
                $data["cons_id"] = 0;
                $data["req_list"] = array($this->input->post("itemcode"));
                $data["status"] = 0;
                $msg = $this->crud_model->save_lab_request_for_patient($data);
                if ($msg=="") $msg = "New request added successfully.";
                $this->session->set_flashdata('message', $msg);
            }else if ($task == "delete" && strlen($labreq_id)>0) {
                $this->crud_model->delete_labreq_info($labreq_id);
                $this->session->set_flashdata('message', "The request deleted successfully.");
            //    redirect(base_url() . 'index.php?admin/labreq');
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
            if ($task=="create"){
                $reqstr=explode("-",$this->input->post("pinfo"));
                $data["recept_id"] = $reqstr[0];
                $data["patient_id"] = $reqstr[1];
                $data["cons_id"] = 0;
                $data["req_list"] = array($this->input->post("itemcode"));
                $data["status"] = 0;
                $msg = $this->crud_model->save_rad_request_for_patient($data);
                if ($msg=="") $msg = "New request added successfully.";
                $this->session->set_flashdata('message', $msg);
            }else if ($task == "delete" && strlen($radreq_id)>0) {
                $this->crud_model->delete_radreq_info($radreq_id);
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
        if($task=="edit"){
            $comm =  "add_pharmacy_bill";
            $data['page_name'] = $comm;
            $data['page_title'] = get_phrase("pharmacy_bill_process");
            if (count($req_id)==0){
                redirect(base_url(), 'refresh');
                return;
            }
            $data['param2'] = $req_id;
            $this->load->view('backend/index', $data);
        }else if($task=="create"){
            $comm =  "add_pharmacy_request";
            $data['page_name'] = $comm;
            $data['page_title'] = get_phrase("pharmacy_request");
            $this->load->view('backend/index', $data);
        }else if($task=="register"){
            $comm =  "add_pharmacy_request";
            $data['page_name'] = $comm;
            $data['page_title'] = get_phrase("pharmacy_request");
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
          /*  $email = $_POST['email'];
            $nurse = $this->db->get_where('nurse', array('email' => $email))->row()->name;
            if ($nurse == null) {
                $this->crud_model->save_nurse_info();
                $this->session->set_flashdata('message', get_phrase('nurse_info_saved_successfuly'));
            } else {
                $this->session->set_flashdata('message', get_phrase('duplicate_email'));
            }*/
            $data["crid"] = $_POST["crid"];
            $data["drid"] = $_POST["drid"];
            $data["amount"] = $_POST["amount"];
            $data["description"] = $_POST["note"];
            $data["bankid"] = $_POST["bankid"];
            $data["accname"] = $_POST["accname"];
            $b = $this->crud_model->insert_ledger_entries($data);
            $msg="";
            if($b){
                $msg = 'New entries was added successfully';
            }else{
                $msg = "Got some errors.";
            }
            $this->session->set_flashdata('message', $msg);
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
    // management ledgers panel
    function ledgerspanel($task = "",$id=""){
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create"||$task == "update") {
            $b = $this->crud_model->save_ledger_item($id);
            if($b){
                $msg = (($task=="update")?'The':'New').' ledger was saved successfully';
            }else{
                $msg = "Got some errors.";
            }
            $this->session->set_flashdata('message', $msg);
            redirect(base_url() . 'index.php?admin/ledgerspanel');
        }elseif($task=="delete"){
            if (strlen($id)>0) {
                $this->crud_model->delete_ledger_info($id);
                $msg = 'Seleted ledger was deleted successfully';
                $this->session->set_flashdata('message', $msg);
                redirect(base_url() . 'index.php?admin/ledgerspanel');
            }
        }
        $sql = "select * from ledgers WHERE ledgerid!=601 order by name";
        $data['ledger_info'] = $this->db->query($sql)->result_array();
        $data['page_name'] = 'manage_ledgers_panel';
        $data['page_title'] = get_phrase('ledgers_panel');
        $this->load->view('backend/index', $data);
    }
    function mngdebtor($task="", $id=""){
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if ($task == "create"||$task == "update") {
            $b = $this->crud_model->save_debtor_item($id);
            if($b){
                $msg = (($task=="update")?'The':'New').' debtor was saved successfully';
            }else{
                $msg = "Got some errors.";
            }
            $this->session->set_flashdata('message', $msg);
            redirect(base_url().'index.php?admin/mngdebtor#tab-2');
        }elseif($task=="delete"){
            if (strlen($id)>0) {
                $this->crud_model->delete_debtor_info($id);
                $msg = 'Seleted debtor was deleted successfully';
                $this->session->set_flashdata('message', $msg);
                redirect(base_url() . 'index.php?admin/mngdebtor');
            }
        }
        $data['page_name'] = 'manage_debtor';
        $data['page_title'] = get_phrase('debtor_management');
        $this->load->view('backend/index', $data);
    }
    // management scheme information
    function mngscheme($task="", $id=""){
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if ($task == "create"||$task == "update") {
            $b = $this->crud_model->save_scheme_item($id);
            if($b){
                $msg = (($task=="update")?'The':'New').' scheme was saved successfully';
            }else{
                $msg = "Got some errors.";
            }
            $this->session->set_flashdata('message', $msg);
            redirect(base_url().'index.php?admin/mngdebtor');
        }elseif($task=="delete"){
            if (strlen($id)>0) {
                $this->crud_model->delete_scheme_info($id);
                $msg = 'Seleted scheme was deleted successfully';
                $this->session->set_flashdata('message', $msg);
                redirect(base_url() . 'index.php?admin/mngdebtor');
            }
        }
        $data['page_name'] = 'manage_debtor';
        $data['page_title'] = get_phrase('debtor_management');
        $this->load->view('backend/index', $data);
    }
    //management creditors
    function mngcreditor($task="", $id=""){
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if ($task == "create"||$task == "update") {
            $b = $this->crud_model->save_creditor_item($id);
            if($b){
                $msg = (($task=="update")?'The':'New').' creditor was saved successfully';
            }else{
                $msg = "Got some errors.";
            }
            $this->session->set_flashdata('message', $msg);
            redirect(base_url().'index.php?admin/mngcreditor');
        }elseif($task=="delete"){
            if (strlen($id)>0) {
                $this->crud_model->delete_creditor_info($id);
                $msg = 'Seleted debtor was deleted successfully';
                $this->session->set_flashdata('message', $msg);
                redirect(base_url() . 'index.php?admin/mngcreditor');
            }
        }
        $data['page_name'] = 'manage_creditor';
        $data['page_title'] = get_phrase('creditor_management');
        $this->load->view('backend/index', $data);
    }
    //find invoices
    function findinvoices(){
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $data['page_name'] = 'manage_find_invoice';
        $data['page_title'] = get_phrase('invoice_search_panel');
        $this->load->view('backend/index', $data);
    }
    //manage expense
    function mngexpenses($task=""){
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if ($task == "create") {
            $msg = $this->crud_model->save_expense_item();
            $this->session->set_flashdata('message', $msg);
            redirect(base_url().'index.php?admin/mngexpenses');
        }
        $data['page_name'] = 'manage_expense';
        $data['page_title'] = get_phrase('expenses_management');
        $this->load->view('backend/index', $data);
    }
    //manage bank deposit
    function bnkdeposit($task=""){
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if ($task == "create") {
            $msg = $this->crud_model->save_bnkdeposit_item();
            $this->session->set_flashdata('message', $msg);
            redirect(base_url().'index.php?admin/bnkdeposit');
        }
        $data['page_name'] = 'manage_bank_deposit';
        $data['page_title'] = get_phrase('bank_deposit_management');
        $this->load->view('backend/index', $data);
    }
    //manage bank deposit
    function cashcollection($task=""){
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if ($task == "create") {
            $msg = $this->crud_model->save_cash_collection_item();
            $this->session->set_flashdata('message', $msg);
            redirect(base_url().'index.php?admin/cashcollection');
        }
        $data['page_name'] = 'manage_cash_collection';
        $data['page_title'] = get_phrase('accountant_cash_collection');
        $this->load->view('backend/index', $data);
    }
    // management stock items 
    function stockitems($task = "",$id=""){
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create"||$task == "update") {
            $b = $this->crud_model->save_stock_item($id);
            $msg="";
            if($b){
                $msg = (($task=="update")?'The':'New').' item was saved successfully';
            }else{
                $msg = "Got some errors.";
            }
            $this->session->set_flashdata('message', $msg);
            redirect(base_url() . 'index.php?admin/mngstocks/manage_stock_items');
        }elseif($task=="delete"){
            if (strlen($id)>0) {
                $this->crud_model->delete_stockitem_info($id);
                $msg = 'Seleted item was deleted successfully';
                $this->session->set_flashdata('message', $msg);
                redirect(base_url() . 'index.php?admin/mngstocks/manage_stock_items');
            }
        }
        
        $data['page_name'] = 'manage_stocks';
        $data["page_subname"] = 'manage_stock_items';
        $data['page_title'] = get_phrase('stock_management_panel');
        $this->load->view('backend/index', $data);
    }
    // management stock request 
    function stockrequest($task = "",$id=""){
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create") {
            $b = $this->crud_model->save_stock_request();
            $msg="";
            if($b){
                $msg = 'The request was submited successfully';
            }else{
                $msg = "Got some errors.";
            }
            $this->session->set_flashdata('message', $msg);
            redirect(base_url() . 'index.php?admin/mngstocks/manage_stock_request');
        }
        
        $data['page_name'] = 'manage_stocks';
        $data["page_subname"] = 'manage_stock_request';
        $data['page_title'] = get_phrase('stock_management_panel');
        $this->load->view('backend/index', $data);
    }
    // management stock transfer 
    function stocktransfer($task = "",$id=""){
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if ($task == "transfer"||$task == "revoke") {
            $b = $this->crud_model->proc_stock_request($task,$id);
            $msg ="";
            if($b){
                $msg = 'The request was '.(($task=="transfer")?"transfered":"revoked").' successfully';
            }else{
                $msg = "Got some errors.";
            }
            $this->session->set_flashdata('message', $msg);
            redirect(base_url() . 'index.php?admin/mngstocks/manage_stock_transfer');
        }
        
        $data['page_name'] = 'manage_stocks';
        $data["page_subname"] = 'manage_stock_transfer';
        $data['page_title'] = get_phrase('stock_management_panel');
        $this->load->view('backend/index', $data);
    }
    //stock adjustment
    function stockadjustment($task = "",$id=""){
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create") {
            $b = $this->crud_model->save_stock_adjustment();
            $msg="";
            if($b){
                $msg = 'The request was submited successfully';
            }else{
                $msg = "Got some errors.";
            }
            $this->session->set_flashdata('message', $msg);
            redirect(base_url() . 'index.php?admin/mngstocks/manage_stock_adjustment');
        }
        
        $data['page_name'] = 'manage_stocks';
        $data["page_subname"] = 'manage_stock_adjustment';
        $data['page_title'] = get_phrase('stock_management_panel');
        $this->load->view('backend/index', $data);
    }
    //stock adjustment
    function stockusageregister($task = "",$id=""){
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create") {
            $b = $this->crud_model->save_stock_usage_register();
            $msg="";
            if($b){
                $msg = 'The request was submited successfully';
            }else{
                $msg = "Got some errors.";
            }
            $this->session->set_flashdata('message', $msg);
            redirect(base_url() . 'index.php?admin/mngstocks/manage_stock_usage_register');
        }
        
        $data['page_name'] = 'manage_stocks';
        $data["page_subname"] = 'manage_stock_usage_register';
        $data['page_title'] = get_phrase('stock_management_panel');
        $this->load->view('backend/index', $data);
    }
    // stocks management(stock items, request, transfer etc)
    function mngstocks($action='manage_stock_items'){
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        // collect item information
        $sql = "select * from items order by ItemName";
        $data['item_info'] = $this->db->query($sql)->result_array();
        // collect stock request information
        $this->db->order_by("TransDate","desc");
        $stock_req_list=$this->db->get_where("issuetable",array("status"=>1))->result_array();
        $data["stock_req_list"] = $stock_req_list;

        $data['page_name'] = 'manage_stocks';
        $data["page_subname"] = $action;
        $data['page_title'] = get_phrase('stock_management_panel');
        $this->load->view('backend/index', $data);
    }
    //goods management
    function mnggoods($task = "",$type=""){
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if ($task == "create") {
            $b=false;
            if ($type=="grn")
                $b = $this->crud_model->save_goods_receive_inwards();
            else
                $b = $this->crud_model->save_goods_returned_outwards();

            $msg="";
            if($b){
                $msg = 'The '.(($type=="grn")?'GRN':'GRO').' request was submited successfully';
            }else{
                $msg = "Got some errors.";
            }
            $this->session->set_flashdata('message', $msg);
            redirect(base_url() . 'index.php?admin/mnggoods');
        }
         // collect item information
        $sql = "select * from items where type='GOOD' order by ItemName";
        $data['item_info'] = $this->db->query($sql)->result_array();

        $data['page_name'] = 'manage_goods';
        $data['page_title'] = get_phrase('good_management_panel');
        $this->load->view('backend/index', $data);
    }
    // local purchase order management
    function mnglpo($task=""){
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if ($task == "create") {
                $b = $this->crud_model->save_local_purchase_order();
            $msg="";
            if($b){
                $msg = 'The LPO request was submited successfully';
            }else{
                $msg = "Got some errors.";
            }
            $this->session->set_flashdata('message', $msg);
            redirect(base_url() . 'index.php?admin/mnglpo');
        }
         // collect item information
        $sql = "select * from items where type='GOOD' order by ItemName";
        $data['item_info'] = $this->db->query($sql)->result_array();

        $data['page_name'] = 'manage_lpo';
        $data['page_title'] = get_phrase('local_purchase_order');
        $this->load->view('backend/index', $data);
    }
    // create and update employee information
    function manage_emplyee_info($account_str,$account_id,$eidt_type){
        if ($eidt_type=="" || $eidt_type != 'sys_user_profile'){
            $this->crud_model->update_account_emp_info($account_str,$account_id,$eidt_type);
        }else if($eidt_type == 'sys_user_profile'){
            $user_name = $this->input->post('username');
            $user = $this->db->get_where($account_str,array($account_str."_id"=>$account_id))->row();
            if ($user_name!=$user->user_name){
                if ($this->crud_model->check_sys_user_name($user_name)==false){
                    $this->session->set_flashdata('message', get_phrase($account_str.'_employee_system_user_name_duplicated'));
                    redirect(base_url() . 'index.php?admin/'.$account_str.'/edit_employee/'.$account_id.'/'.$eidt_type);
                    return;
                }else{
                    $this->db->where($account_str."_id",$account_id);
                    $this->db->update($account_str, array('user_name' => $user_name));
                    $current_password_input = sha1($this->input->post('password'));
                    $new_password = sha1($this->input->post('new_password'));
                    $confirm_new_password = sha1($this->input->post('confirm_new_password'));

                    $current_password_db = $this->db->get_where($account_str, array($account_str.'_id' =>
                                $account_id))->row()->password;

                    if ($current_password_db == $current_password_input && $new_password == $confirm_new_password) {
                        $this->db->where($account_str.'_id', $account_id);
                        $this->db->update($account_str, array('password' => $new_password));
                        $this->session->set_flashdata('message', get_phrase('password_info_updated_successfuly'));
                    } else {
                        $this->session->set_flashdata('message', get_phrase('password_update_failed'));
                    }
                    redirect(base_url() . 'index.php?admin/'.$account_str.'/edit_employee/'.$account_id.'/'.$eidt_type);
                    return;   
                }
            } 
        }
        $this->session->set_flashdata('message', get_phrase($account_str.'_employee_info_updated_successfuly'));
        redirect(base_url() . 'index.php?admin/'.$account_str.'/edit_employee/'.$account_id.'/'.$eidt_type);
    }
    // from nurse
    function bed($task = "", $bed_id = "") {
        if ( $this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_bed_info();
            $this->session->set_flashdata('message', get_phrase('bed_info_saved_successfuly'));
            redirect(base_url() . 'index.php?admin/bed');
        }

        if ($task == "update") {
            $this->crud_model->update_bed_info($bed_id);
            $this->session->set_flashdata('message', get_phrase('bed_info_updated_successfuly'));
            redirect(base_url() . 'index.php?admin/bed');
        }

        if ($task == "delete") {
            $this->crud_model->delete_bed_info($bed_id);
            redirect(base_url() . 'index.php?admin/bed');
        }

        $data['bed_info'] = $this->crud_model->select_bed_info();
        $data['page_name'] = 'manage_bed';
        $data['page_title'] = get_phrase('bed');
        $this->load->view('backend/index', $data);
    }

    function bed_allotment($task = "", $bed_allotment_id = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        
        if ($task == "create") {
            $this->crud_model->save_bed_allotment_info();
            $this->session->set_flashdata('message', get_phrase('bed_allotment_info_saved_successfuly'));
            redirect(base_url() . 'index.php?admin/bed_allotment');
        }

        if ($task == "update") {
            $this->crud_model->update_bed_allotment_info($bed_allotment_id);
            $this->session->set_flashdata('message', get_phrase('bed_allotment_info_updated_successfuly'));
            redirect(base_url() . 'index.php?admin/bed_allotment');
        }

        if ($task == "delete") {
            $this->crud_model->delete_bed_allotment_info($bed_allotment_id);
            redirect(base_url() . 'index.php?admin/bed_allotment');
        }

        $data['bed_allotment_info'] = $this->crud_model->select_bed_allotment_info();
        $data['page_name'] = 'manage_bed_allotment';
        $data['page_title'] = get_phrase('bed_allotment');
        $this->load->view('backend/index', $data);
    }

    function blood_bank($task = "", $blood_group_id = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "update") {
            $this->crud_model->update_blood_bank_info($blood_group_id);
            $this->session->set_flashdata('message', get_phrase('blood_bank_info_updated_successfuly'));
            redirect(base_url() . 'index.php?admin/blood_bank');
        }

        $data['blood_bank_info'] = $this->crud_model->select_blood_bank_info();
        $data['page_name'] = 'manage_blood_bank';
        $data['page_title'] = get_phrase('blood_bank');
        $this->load->view('backend/index', $data);
    }

    function blood_donor($task = "", $blood_donor_id = "") {
        if ($this->session->userdata('admin_login') != 1) {
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
            redirect(base_url() . 'index.php?admin/blood_donor');
        }

        if ($task == "update") {
            $this->crud_model->update_blood_donor_info($blood_donor_id);
            $this->session->set_flashdata('message', get_phrase('blood_donor_info_updated_successfuly'));
            redirect(base_url() . 'index.php?admin/blood_donor');
        }

        if ($task == "delete") {
            $this->crud_model->delete_blood_donor_info($blood_donor_id);
            redirect(base_url() . 'index.php?admin/blood_donor');
        }

        $data['blood_donor_info'] = $this->crud_model->select_blood_donor_info();
        $data['page_name'] = 'manage_blood_donor';
        $data['page_title'] = get_phrase('blood_donor');
        $this->load->view('backend/index', $data);
    }
    /* private messaging */

    function message($param1 = 'message_home', $param2 = '', $param3 = '') {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        if ($param1 == 'send_new') {
            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?admin/message/message_read/' . $message_thread_code, 'refresh');
        }
        

        if ($param1 == 'send_reply') {
            $this->crud_model->send_reply_message($param2);  //$param2 = message_thread_code
            $this->session->set_flashdata('message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?admin/message/message_read/' . $param2, 'refresh');
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

    // set up bank
    function bank_settings($task = "", $bank_id = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "update") {
            $this->crud_model->update_bank_info($bank_id);
            $this->session->set_flashdata('message', get_phrase('bank_info_updated_successfuly'));
            redirect(base_url() . 'index.php?admin/bank_settings');
        }
        if ($task == "create") {
            $this->crud_model->save_bank_info();
            $this->session->set_flashdata('message', get_phrase('bank_info_saved_successfuly'));
            redirect(base_url() . 'index.php?admin/bank_settings');
        }
        if ($task == "delete") {
            $this->crud_model->delete_bank_info($bank_id);
            $this->session->set_flashdata('message', get_phrase('bank_info_deleted_successfuly'));
            redirect(base_url() . 'index.php?admin/bank_settings');
        }
        $data['bank_info'] = $this->crud_model->select_bank_info();
        $data['page_name'] = 'manage_bank';
        $data['page_title'] = get_phrase('bank_settings');
        $this->load->view('backend/index', $data);
    }
    //Inpatient controller
     function inpatients($task = "", $id = "", $subtask="",$other="") {
        
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        
        if($task=="edit" && $id != ""){
            $comm =  "edit_inpatient";
            $data['page_name'] = $comm;
            $data['page_title'] = get_phrase($comm);
            $data['param2'] = $id;
            $data['param3'] = $subtask;
            
            $this->load->view('backend/index', $data);
            return;
        }
        if ($task == "update") {
            if ($subtask=="patient"){
                $this->crud_model->update_patient_info($id);
                $this->session->set_flashdata('message', get_phrase('inpatient_info_updated_successfuly'));
                redirect(base_url() . "index.php?admin/inpatients/edit/$id/$subtask");
            }
            if ($subtask=="admission"){
                $patient_id = $id;
                if ($other=="diag"){
                    $patient_id =  $this->crud_model->update_inpatient_admission_diag($id);
                    $this->session->set_flashdata('message', get_phrase('inpatient_admission_diagnosis_updated_successfuly'));
                }else{
                    $this->session->set_flashdata('message', get_phrase('inpatient_admission_updated_successfuly'));
                    $this->crud_model->update_inpatient_admission_info($id);
                }
                redirect(base_url() . "index.php?admin/inpatients/edit/$patient_id/$subtask");
            }
            if ($subtask=="supandproc"){
                $this->crud_model->save_inpatient_sup_and_proc($id);
                $this->session->set_flashdata('message', get_phrase('inpatient_supplies_and_procedure_updated_successfuly'));
                redirect(base_url() . "index.php?admin/inpatients/edit/$id/$subtask");
            }
            if ($subtask=="cardex"){
                $patient_id = $this->crud_model->update_inpatient_nursing_cardex($id);
                $this->session->set_flashdata('message', get_phrase('inpatient_nursing_cardex_updated_successfuly'));
                redirect(base_url() . "index.php?admin/inpatients/edit/$patient_id/$subtask");
            }
            if ($subtask=="careplan"){
                $patient_id = $this->crud_model->update_inpatient_nursing_care_plan($id);
                $this->session->set_flashdata('message', get_phrase('inpatient_nursing_care_plan_updated_successfuly'));
                redirect(base_url() . "index.php?admin/inpatients/edit/$patient_id/$subtask");
            }
            if ($subtask=="hourlytemp"){
                $patient_id = $this->crud_model->update_inpatient_hourly_temper($id);
                $this->session->set_flashdata('message', get_phrase('inpatient_hourly_temperature_updated_successfuly'));
                redirect(base_url() . "index.php?admin/inpatients/edit/$patient_id/$subtask");
            }
            if ($subtask=="bloodchart"){
                $patient_id = $this->crud_model->update_inpatient_blood_press($id);
                $this->session->set_flashdata('message', get_phrase('inpatient_blood_press_updated_successfuly'));
                redirect(base_url() . "index.php?admin/inpatients/edit/$patient_id/$subtask");
            }
            if ($subtask=="fluidbalchart"){
                $patient_id = $this->crud_model->update_inpatient_fluid_balance($id);
                $this->session->set_flashdata('message', get_phrase('inpatient_fluid_balance_updated_successfuly'));
                redirect(base_url() . "index.php?admin/inpatients/edit/$patient_id/$subtask");
            }
            if ($subtask=="details"){
                $this->crud_model->update_inpatient_other_details($id);
                $this->session->set_flashdata('message', get_phrase('inpatient_other_details_updated_successfuly'));
                redirect(base_url() . "index.php?admin/inpatients/edit/$id/$subtask");
            }
        }
        if ($task == "create") {
            $b=true;
            if ($subtask=="admission"){
                if ($other="diag"){
                    $this->crud_model->save_inpatient_admission_diag($id);
                    $this->session->set_flashdata('message', get_phrase('inpatient_admission_diagnosis_saved_successfuly'));
                }
            }else if ($subtask=="supandproc"){
                $this->crud_model->save_inpatient_sup_and_proc($id);
                $this->session->set_flashdata('message', get_phrase('inpatient_supplies_and_procedure_saved_successfuly'));
            }else if ($subtask=="cardex"){
                $this->crud_model->save_inpatient_nursing_cardex($id);
                $this->session->set_flashdata('message', get_phrase('inpatient_nursing_cardex_saved_successfuly'));
            }else if ($subtask=="careplan"){
                $this->crud_model->save_inpatient_nursing_care_plan($id);
                $this->session->set_flashdata('message', get_phrase('inpatient_nursing_care_plan_saved_successfuly'));
            }else if ($subtask=="hourlytemp"){
                $this->crud_model->save_inpatient_hourly_temper($id);
                $this->session->set_flashdata('message', get_phrase('inpatient_hourly_temperature_saved_successfuly'));
            }else if ($subtask=="bloodchart"){
                $this->crud_model->save_inpatient_blood_press($id);
                $this->session->set_flashdata('message', get_phrase('inpatient_blood_press_saved_successfuly'));
            }else if ($subtask=="fluidbalchart"){
                $this->crud_model->save_inpatient_fluid_balance($id);
                $this->session->set_flashdata('message', get_phrase('inpatient_fluid_balance_saved_successfuly'));
            }else $b=false;
            if($b) redirect(base_url() . "index.php?admin/inpatients/edit/$id/$subtask");
        }
        if ($task == "delete") {
            $patient_id="";
            if ($subtask=="admission"){
                if ($other="diag"){
                    $patient_id = $this->crud_model->delete_inpatient_admission_diag($id);
                    $this->session->set_flashdata('message', get_phrase('inpatient_admission_diagnosis_deleted_successfuly'));
                }
            }else if ($subtask=="supandproc"){
                $patient_id= $this->crud_model->delete_inpatient_sup_and_proc($id);
                $this->session->set_flashdata('message', get_phrase('inpatient_supplies_and_procedure_deleted_successfuly'));
               
            }else if ($subtask=="cardex"){
                $patient_id= $this->crud_model->delete_inpatient_nursing_cardex($id);
                $this->session->set_flashdata('message', get_phrase('inpatient_nursing_cardex_deleted_successfuly'));
            }else if ($subtask=="careplan"){
                $patient_id= $this->crud_model->delete_inpatient_nursing_care_plan($id);
                $this->session->set_flashdata('message', get_phrase('inpatient_nursing_care_plan_deleted_successfuly'));
            }else if ($subtask=="hourlytemp"){
                $patient_id= $this->crud_model->delete_inpatient_hourly_temper($id);
                $this->session->set_flashdata('message', get_phrase('inpatient_houly_temperature_deleted_successfuly'));
            }else if ($subtask=="bloodchart"){
                $patient_id= $this->crud_model->delete_inpatient_blood_press($id);
                $this->session->set_flashdata('message', get_phrase('inpatient_blood_press_deleted_successfuly'));
            }else if ($subtask=="fluidbalchart"){
                $patient_id= $this->crud_model->delete_inpatient_fluid_balance($id);
                $this->session->set_flashdata('message', get_phrase('inpatient_fluid_balance_deleted_successfuly'));
            }else $b=false;
            if($b) redirect(base_url() . "index.php?admin/inpatients/edit/$patient_id/$subtask");
        }
        $data['patient_info'] = $this->crud_model->select_inpatient_info();
        $data['page_name'] = 'manage_inpatient';
        $data['page_title'] = get_phrase('inpatient');
        $this->load->view('backend/index', $data);
    }
    function maternity($task = "", $id = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
                
        $data['patient_info'] = $this->crud_model->select_inpatient_info(true);
        $data['page_name'] = 'manage_maternity';
        $data['page_title'] = get_phrase('maternity');
        $this->load->view('backend/index', $data);
    }
    function trial_bal_report($task = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $msg="Trial Balance was generated successfully.";
        $from=$this->input->post("from");
        $to=$this->input->post("to");
        $data=array();
        if ($from!="" && $to!=""){
            $from_date = strtotime($from);
            $to_date = strtotime($to);
            if($from_date<=$to_date){
                $res = $this->crud_model->gen_trial_balance($from_date,$to_date);
                $data["trial_bal_list"] = $res[0];
                $data["total_dr"]=$res[1];
                $data["total_cr"]=$res[2];
                $data["from"] = $from;
                $data["to"] = $to;
            }else
                $msg = "From Date can not be forward than To Date.";
        }else
            $msg = "Please select From and To dates.";

        $this->session->set_flashdata('message', $msg);
        $data['page_name'] = 'trial_report';
        $data['page_title'] = get_phrase('trial_balance_report');
        $this->load->view('backend/index', $data);
    }
    function income_statement_report($task = "") {
       if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $msg="Income Statement Report was generated successfully.";
        $from=$this->input->post("from");
        $to=$this->input->post("to");
        $data=array();
        if ($from!="" && $to!=""){
            $from_date = strtotime($from);
            $to_date = strtotime($to);
            if($from_date<=$to_date){
                $res = $this->crud_model->gen_income_statement_report($from_date,$to_date);
                $data["income_state_list"] = $res[0];
                $data["total1"]=$res[1];
                $data["total2"]=$res[2];
                $data["from"] = $from;
                $data["to"] = $to;
            }else
                $msg = "From Date can not be forward than To Date.";
        }else
            $msg = "Please select From and To dates.";

        $this->session->set_flashdata('message', $msg);
        $data['page_name'] = 'income_statement_report';
        $data['page_title'] = get_phrase('income_statement_report');
        $this->load->view('backend/index', $data);
     }
     function balance_sheet_report($task = "") {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['page_name'] = 'balance_sheet_report';
        $data['page_title'] = get_phrase('balance_sheet_report');
        $this->load->view('backend/index', $data);
    }
    function upload_scan_image($task="",$patient_id,$reqid){
        if ($task=="upload"){
            $filename = time()."-".basename($_FILES["file"]["name"]);
            $targetDir1="uploads/radiology_image/$patient_id/";
            $targetDir2 = $targetDir1.$reqid."/";
            if (!is_dir($targetDir1)){
                mkdir($targetDir1,0777);
                mkdir($targetDir2,0777);
            }else{
                if (!is_dir($targetDir2))
                    mkdir($targetDir2,0777);
            }
            $targetFilePath = $targetDir2.$filename;
            move_uploaded_file($_FILES["file"]["tmp_name"],$targetFilePath);
            echo $targetFilePath;
        }else if($task=="delete"){
            $filepath = "uploads/radiology_image/$patient_id/$reqid/";
            $filepath .= $this->input->post("filename");
            unlink($filepath); 
            echo "OK";
        }
        
    }
    
}



























