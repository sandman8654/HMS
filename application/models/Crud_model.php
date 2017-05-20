<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function clear_cache() {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    function get_type_name_by_id($type, $type_id = '', $field = 'name') {
        $this->db->where($type . '_id', $type_id);
        $query = $this->db->get($type);
        $result = $query->result_array();
        foreach ($result as $row)
            return $row[$field];
        //return	$this->db->get_where($type,array($type.'_id'=>$type_id))->row()->$field;	
    }



    // Create a new invoice.
    function create_invoice() 
    {
        $data['title']              = $this->input->post('title');
        $data['invoice_number']     = $this->input->post('invoice_number');
        $data['patient_id']         = $this->input->post('patient_id');
        $data['creation_timestamp'] = $this->input->post('creation_timestamp');
        $data['due_timestamp']      = $this->input->post('due_timestamp');
        $data['vat_percentage']     = $this->input->post('vat_percentage');
        $data['discount_amount']    = $this->input->post('discount_amount');
        $data['status']             = $this->input->post('status');

        $invoice_entries            = array();
        $descriptions               = $this->input->post('entry_description');
        $amounts                    = $this->input->post('entry_amount');
        $number_of_entries          = sizeof($descriptions);
        
        for ($i = 0; $i < $number_of_entries; $i++)
        {
            if ($descriptions[$i] != "" && $amounts[$i] != "")
            {
                $new_entry          = array('description' => $descriptions[$i], 'amount' => $amounts[$i]);
                array_push($invoice_entries, $new_entry);
            }
        }
        $data['invoice_entries']    = json_encode($invoice_entries);

        $this->db->insert('invoice', $data);
    }
    
    function select_invoice_info()
    {
        return $this->db->get('invoice')->result_array();
    }
    
    function select_invoice_info_by_patient_id()
    {
        $patient_id = $this->session->userdata('login_user_id');
        return $this->db->get_where('invoice', array('patient_id' => $patient_id))->result_array();
    }

    function update_invoice($invoice_id)
    {
        $data['title']              = $this->input->post('title');
        $data['invoice_number']     = $this->input->post('invoice_number');
        $data['patient_id']         = $this->input->post('patient_id');
        $data['creation_timestamp'] = $this->input->post('creation_timestamp');
        $data['due_timestamp']      = $this->input->post('due_timestamp');
        $data['vat_percentage']     = $this->input->post('vat_percentage');
        $data['discount_amount']    = $this->input->post('discount_amount');
        $data['status']             = $this->input->post('status');

        $invoice_entries            = array();
        $descriptions               = $this->input->post('entry_description');
        $amounts                    = $this->input->post('entry_amount');
        $number_of_entries          = sizeof($descriptions);
        
        for ($i = 0; $i < $number_of_entries; $i++)
        {
            if ($descriptions[$i] != "" && $amounts[$i] != "")
            {
                $new_entry          = array('description' => $descriptions[$i], 'amount' => $amounts[$i]);
                array_push($invoice_entries, $new_entry);
            }
        }
        $data['invoice_entries']    = json_encode($invoice_entries);

        $this->db->where('invoice_id', $invoice_id);
        $this->db->update('invoice', $data);
    }

    function delete_invoice($invoice_id)
    {
        $this->db->where('invoice_id', $invoice_id);
        $this->db->delete('invoice');
    }

    function calculate_invoice_total_amount($invoice_number)
    {
        $total_amount           = 0;
        $invoice                = $this->db->get_where('invoice', array('invoice_number' => $invoice_number))->result_array();
        foreach ($invoice as $row)
        {
            $invoice_entries    = json_decode($row['invoice_entries']);
            foreach ($invoice_entries as $invoice_entry)
                $total_amount  += $invoice_entry->amount;

            $vat_amount         = $total_amount * $row['vat_percentage'] / 100;
            $grand_total        = $total_amount + $vat_amount - $row['discount_amount'];
        }

        return $grand_total;
    }

  

    //////system settings//////
    function update_system_settings() {
        $data['description'] = $this->input->post('system_name');
        $this->db->where('type', 'system_name');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('system_title');
        $this->db->where('type', 'system_title');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('address');
        $this->db->where('type', 'address');
        $this->db->update('settings', $data);

        
        $data['description'] = $this->input->post('company_name');
        $this->db->where('type', 'company_name');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('location_description');
        $this->db->where('type', 'location_description');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('website');
        $this->db->where('type', 'website');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('phone');
        $this->db->where('type', 'phone');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('paypal_email');
        $this->db->where('type', 'paypal_email');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('currency');
        $this->db->where('type', 'currency');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('system_email');
        $this->db->where('type', 'system_email');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('buyer');
        $this->db->where('type', 'buyer');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('system_name');
        $this->db->where('type', 'system_name');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('purchase_code');
        $this->db->where('type', 'purchase_code');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('language');
        $this->db->where('type', 'language');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('text_align');
        $this->db->where('type', 'text_align');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('tel');
        $this->db->where('type', 'phone');
        $this->db->update('settings', $data);

        move_uploaded_file($_FILES['image']['tmp_name'], 'assets/images/logo.png');
    }
    
    // SMS settings.
    function update_sms_settings() {
        
        $data['description'] = $this->input->post('clickatell_user');
        $this->db->where('type', 'clickatell_user');
        $this->db->update('settings', $data);
        
        $data['description'] = $this->input->post('clickatell_password');
        $this->db->where('type', 'clickatell_password');
        $this->db->update('settings', $data);
        
        $data['description'] = $this->input->post('clickatell_api_id');
        $this->db->where('type', 'clickatell_api_id');
        $this->db->update('settings', $data);
    }

    /////creates log/////
    function create_log($data) {
        $data['timestamp'] = strtotime(date('Y-m-d') . ' ' . date('H:i:s'));
        $data['ip'] = $_SERVER["REMOTE_ADDR"];
        $location = new SimpleXMLElement(file_get_contents('http://freegeoip.net/xml/' . $_SERVER["REMOTE_ADDR"]));
        $data['location'] = $location->City . ' , ' . $location->CountryName;
        $this->db->insert('log', $data);
    }

    ////////BACKUP RESTORE/////////
    function create_backup($type) {
        $this->load->dbutil();


        $options = array(
            'format' => 'txt', // gzip, zip, txt
            'add_drop' => TRUE, // Whether to add DROP TABLE statements to backup file
            'add_insert' => TRUE, // Whether to add INSERT data to backup file
            'newline' => "\n"               // Newline character used in backup file
        );


        if ($type == 'all') {
            $tables = array('');
            $file_name = 'system_backup';
        } else {
            $tables = array('tables' => array($type));
            $file_name = 'backup_' . $type;
        }

        $backup = & $this->dbutil->backup(array_merge($options, $tables));


        $this->load->helper('download');
        force_download($file_name . '.sql', $backup);
    }

    /////////RESTORE TOTAL DB/ DB TABLE FROM UPLOADED BACKUP SQL FILE//////////
    function restore_backup() {
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/backup.sql');
        $this->load->dbutil();


        $prefs = array(
            'filepath' => 'uploads/backup.sql',
            'delete_after_upload' => TRUE,
            'delimiter' => ';'
        );
        $restore = & $this->dbutil->restore($prefs);
        unlink($prefs['filepath']);
    }

    /////////DELETE DATA FROM TABLES///////////////
    function truncate($type) {
        if ($type == 'all') {
            $this->db->truncate('student');
            $this->db->truncate('mark');
            $this->db->truncate('teacher');
            $this->db->truncate('subject');
            $this->db->truncate('class');
            $this->db->truncate('exam');
            $this->db->truncate('grade');
        } else {
            $this->db->truncate($type);
        }
    }

    ////////IMAGE URL//////////
    function get_image_url($type = '', $id = '') {
        if (file_exists('uploads/' . $type . '_image/' . $id . '.jpg'))
            $image_url = base_url() . 'uploads/' . $type . '_image/' . $id . '.jpg';
        else
            $image_url = base_url() . 'uploads/user.jpg';

        return $image_url;
    }
    
    function save_department_info()
    {
        $data['name'] 		= $this->input->post('name');
        $data['description']    = $this->input->post('description');
        
        $this->db->insert('department',$data);
    }
    
    function select_department_info()
    {
        return $this->db->get('department')->result_array();
    }
    
    function update_department_info($department_id)
    {
        $data['name'] 		= $this->input->post('name');
        $data['description'] 	= $this->input->post('description');
        
        $this->db->where('department_id',$department_id);
        $this->db->update('department',$data);
    }
    
    function delete_department_info($department_id)
    {
        $this->db->where('department_id',$department_id);
        $this->db->delete('department');
    }
    
    function save_doctor_info()
    {
        $data['name'] 		= $this->input->post('name');
        $data['user_name'] 		= $this->input->post('username');
        $data['email'] 		= $this->input->post('email');
        $data['password']       = sha1($this->input->post('password'));
        $data['address'] 	= $this->input->post('address');
        $data['phone']          = $this->input->post('phone');
        $data['department_id'] 	= $this->input->post('department_id');
        $data['profile'] 	= $this->input->post('profile');
        
        $this->db->insert('doctor',$data);
        
        $doctor_id  =   $this->db->insert_id();
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/doctor_image/" . $doctor_id . '.jpg');
    }
    
    function select_doctor_info()
    {
        return $this->db->get('doctor')->result_array();
    }
    
    function update_doctor_info($doctor_id)
    {
        $data['name'] 		= $this->input->post('name');
        $username = $this->input->post('username');
        
        $data['email'] 		= $this->input->post('email');
        $data['address'] 	= $this->input->post('address');
        $data['phone']          = $this->input->post('phone');
        $data['department_id'] 	= $this->input->post('department_id');
        $data['profile'] 	= $this->input->post('profile');
        
        $this->db->where('doctor_id',$doctor_id);
        $this->db->update('doctor',$data);
        
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/doctor_image/" . $doctor_id . '.jpg');
    }
    
    function delete_doctor_info($doctor_id)
    {
        $this->db->where('doctor_id',$doctor_id);
        $this->db->delete('doctor');
    }
    
    function save_patient_info()
    {
        $data['name'] 		= $this->input->post('name');
        $data['email'] 		= $this->input->post('email');
        $data['password']       = sha1($this->input->post('password'));
        $data['address'] 	= $this->input->post('address');
        $data['phone']          = $this->input->post('phone');
        $data['sex']            = $this->input->post('sex');
        $data['birth_date']     = strtotime($this->input->post('birth_date'));
        $data['age']            = $this->input->post('age');
        $data['blood_group'] 	= $this->input->post('blood_group');
        $data['user_name'] 		= $this->input->post('username');
        $data['gname'] 	= $this->input->post('rel_name');
        $data['grship'] 	= $this->input->post('rel_group');
        $data['gcont'] 	= $this->input->post('rel_phone');
        $data['gaddress'] 	= $this->input->post('rel_address');
        $data['empname'] 	= $this->input->post('emp_name');
        $data['empno'] 	= $this->input->post('emp_no');
        $data['insurerid'] 	= $this->input->post('insur_group');
        $data['cardno'] 	= $this->input->post('insur_card_no');
        $data['odetails'] 	= $this->input->post('other_note');
        $data["inout_status"] = $this->input->post('inout_status');
        $registe_date = $data["registered_date"] = strtotime(date("m/d/y H:i:s"));
        
        $this->db->insert('patient',$data);
        $patient_id  =   $this->db->insert_id();

        $this->db->insert("visitor_log",array(
            "patient_id"=>$patient_id,
            "type"=>0,
            "visit_date"=>$registe_date
        ));
       
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/patient_image/" . $patient_id . '.jpg');

        return $patient_id;
    }
    
    function select_patient_info()
    {
        $this->db->order_by("registered_date","desc");
        $this->db->order_by("status","desc");
        return $this->db->get('patient')->result_array();
    }
    function select_inpatient_info($isMaternity=false)
    {
        $this->db->order_by("registered_date","desc");
        $this->db->order_by("status","desc");
        $this->db->where("inout_status",(($isMaternity)?2:1));
        return $this->db->get('patient')->result_array();
    }
    function select_patient_info_by_patient_id( $patient_id = '' )
    {
        return $this->db->get_where('patient', array('patient_id' => $patient_id))->result_array();
    }
            
    function update_patient_info($patient_id)
    {
        $data['name'] 		= $this->input->post('name');
        $data['email'] 		= $this->input->post('email');
        $data['address'] 	= $this->input->post('address');
        $data['phone']          = $this->input->post('phone');
        $data['sex']            = $this->input->post('sex');
        $data['birth_date']     = strtotime($this->input->post('birth_date'));
        $data['age']            = $this->input->post('age');
        $data['blood_group'] 	= $this->input->post('blood_group');
        $data['user_name'] 		= $this->input->post('username');
        $data['gname'] 	= $this->input->post('rel_name');
        $data['grship'] 	= $this->input->post('rel_group');
        $data['gcont'] 	= $this->input->post('rel_phone');
        $data['gaddress'] 	= $this->input->post('rel_address');
        $data['empname'] 	= $this->input->post('emp_name');
        $data['empno'] 	= $this->input->post('emp_no');
        $data['insurerid'] 	= $this->input->post('insur_group');
        $data['cardno'] 	= $this->input->post('insur_card_no');
        $data['odetails'] 	= $this->input->post('other_note');
        $data["inout_status"] = $this->input->post('inout_status');
        $this->db->where('patient_id',$patient_id);
        $this->db->update('patient',$data);
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/patient_image/" . $patient_id . '.jpg');
    }
    function update_patient_info_for_billing($patient_id,$data){
        $this->db->where('patient_id',$patient_id);
        $this->db->update('patient',$data);
    }
    function delete_patient_info($patient_id)
    {
        $this->db->where('patient_id',$patient_id);
        $this->db->delete('patient');
    }
    
    function save_nurse_info()
    {
        $data['name'] 		= $this->input->post('name');
        $data['user_name'] 		= $this->input->post('username');
        $data['email'] 		= $this->input->post('email');
        $data['password']       = sha1($this->input->post('password'));
        $data['address'] 	= $this->input->post('address');
        $data['phone']          = $this->input->post('phone');
        
        $this->db->insert('nurse',$data);
        
        $nurse_id  =   $this->db->insert_id();
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/nurse_image/" . $nurse_id . '.jpg');
    }
    
    function select_nurse_info()
    {
        return $this->db->get('nurse')->result_array();
    }
    
    function update_nurse_info($nurse_id)
    {
        $data['name'] 		= $this->input->post('name');
        $data['email'] 		= $this->input->post('email');
        $data['address'] 	= $this->input->post('address');
        $data['phone']          = $this->input->post('phone');
        
        $this->db->where('nurse_id',$nurse_id);
        $this->db->update('nurse',$data);
        
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/nurse_image/" . $nurse_id . '.jpg');
    }
    
    function delete_nurse_info($nurse_id)
    {
        $this->db->where('nurse_id',$nurse_id);
        $this->db->delete('nurse');
    }
    
    function save_pharmacist_info()
    {
        $data['name'] 		= $this->input->post('name');
        $data['user_name'] 		= $this->input->post('username');
        $data['email'] 		= $this->input->post('email');
        $data['password']       = sha1($this->input->post('password'));
        $data['address'] 	= $this->input->post('address');
        $data['phone']          = $this->input->post('phone');
        
        $this->db->insert('pharmacist',$data);
        
        $pharmacist_id  =   $this->db->insert_id();
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/pharmacist_image/" . $pharmacist_id . '.jpg');
    }
    
    function select_pharmacist_info()
    {
        return $this->db->get('pharmacist')->result_array();
    }
    
    function update_pharmacist_info($pharmacist_id)
    {
        $data['name'] 		= $this->input->post('name');
        $data['email'] 		= $this->input->post('email');
        $data['address'] 	= $this->input->post('address');
        $data['phone']          = $this->input->post('phone');
        
        $this->db->where('pharmacist_id',$pharmacist_id);
        $this->db->update('pharmacist',$data);
        
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/pharmacist_image/" . $pharmacist_id . '.jpg');
    }
    
    function delete_pharmacist_info($pharmacist_id)
    {
        $this->db->where('pharmacist_id',$pharmacist_id);
        $this->db->delete('pharmacist');
    }
    
    function save_laboratorist_info()
    {
        $data['name'] 		= $this->input->post('name');
        $data['user_name'] 		= $this->input->post('username');
        $data['email'] 		= $this->input->post('email');
        $data['password']       = sha1($this->input->post('password'));
        $data['address'] 	= $this->input->post('address');
        $data['phone']          = $this->input->post('phone');
        
        $this->db->insert('laboratorist',$data);
        
        $laboratorist_id  =   $this->db->insert_id();
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/laboratorist_image/" . $laboratorist_id . '.jpg');
    }
    
    function select_laboratorist_info()
    {
        return $this->db->get('laboratorist')->result_array();
    }
    
    function update_laboratorist_info($laboratorist_id)
    {
        $data['name'] 		= $this->input->post('name');
        $data['email'] 		= $this->input->post('email');
        $data['address'] 	= $this->input->post('address');
        $data['phone']          = $this->input->post('phone');
        
        $this->db->where('laboratorist_id',$laboratorist_id);
        $this->db->update('laboratorist',$data);
        
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/laboratorist_image/" . $laboratorist_id . '.jpg');
    }
    
    function delete_laboratorist_info($laboratorist_id)
    {
        $this->db->where('laboratorist_id',$laboratorist_id);
        $this->db->delete('laboratorist');
    }
    
    function save_accountant_info()
    {
        $data['name'] 		= $this->input->post('name');
        $data['user_name'] 		= $this->input->post('username');
        $data['email'] 		= $this->input->post('email');
        $data['password']       = sha1($this->input->post('password'));
        $data['address'] 	= $this->input->post('address');
        $data['phone']          = $this->input->post('phone');
        
        $this->db->insert('accountant',$data);
        
        $accountant_id  =   $this->db->insert_id();
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/accountant_image/" . $accountant_id . '.jpg');
    }
    
    function select_accountant_info()
    {
        return $this->db->get('accountant')->result_array();
    }
    
    
    function select_admin_info()
    {
        return $this->db->get('admin')->result_array();
    }
    function save_admin_info()
    {
        $data['name'] 		= $this->input->post('name');
        $data['user_name'] 		= $this->input->post('username');
        $data['email'] 		= $this->input->post('email');
        $data['password']       = sha1($this->input->post('password'));
        $data['address'] 	= $this->input->post('address');
        $data['phone']          = $this->input->post('phone');
        
        $this->db->insert('admin',$data);
        
        $admin_id  =   $this->db->insert_id();
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/admin_image/" . $admin_id . '.jpg');
    }
    function delete_admin_info($admin_id)
    {
        if ($this->db->count_all("admin")==1) return;
        $this->db->where('admin_id',$admin_id);
        $this->db->delete('accountant');
    }
    function update_account_info($account_type,$account_id, $full_name="")
    {
        if ($full_name !="") 
            $data['name'] = $full_name;
        else    
            $data['name'] 		= $this->input->post('name');
        $data['email'] 		= $this->input->post('email');
        $data['address'] 	= $this->input->post('address');
        $data['phone']          = $this->input->post('phone');
        
        $this->db->where($account_type.'_id',$account_id);
        $this->db->update($account_type,$data);
        
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/$account_type"."_image/" . $account_id . '.jpg');
    }
    
    function update_account_emp_info($account_type, $account_id, $type="")
    {
        if ($type=="" || $type=="personal_details"){
            $fn =$data['fname'] 		= $this->input->post('fname');
            $mn =$data['mname'] 		= $this->input->post('mname');
            $ln =$data['lname'] 		= $this->input->post('lname');
            $data['dob'] 		= $this->input->post('birth_date');
            $data['marital'] 		= $this->input->post('marital');
            $data['languages'] 		=  implode(";",$this->input->post('languages'));
            $data['gender'] 		=  $this->input->post('gender');
            $data['idno'] 		=  $this->input->post('idno');
            $data['pinno'] 		=  $this->input->post('pinno');
            $data['phone'] 		=  $this->input->post('phone');
            $data['email'] 		= $this->input->post('email');
            $data['phyadd'] 	= $this->input->post('address');
            $data['phone2']          = $this->input->post('phone2');
            $full_name = implode(" ",array($fn,$mn,$ln));
            $this->update_account_info($account_type,$account_id,$full_name);
        }else if ($type=="salary_details"){
             $data['salary'] 		= $this->input->post('salary');
             $data['employdate'] 		= $this->input->post('doe');
             $emp_type=$data['emptype'] 		= $this->input->post('emptype');
      //       if (strtolower($emp_type) == 'contract'){
             $data['contractfrom'] 		= $this->input->post('contractfrom');
             $data['contractto'] 		= $this->input->post('contractto');
    //         };
             $data['dept'] 		= $this->input->post('dept');
             $data['position'] 		= $this->input->post('position');
             $data['jobdesc'] 		= $this->input->post('jobdesc');
        }else if ($type=="medical_details"){
             $data['bgroup'] 		= $this->input->post('bgroup');
             $data['alergy'] 		= $this->input->post('alergy');
        }else if ($type=="emergancy_contact"){
             $data['ename'] 		= $this->input->post('ename');
             $data['ephone'] 		= $this->input->post('ephone');
             $data['epostal'] 		= $this->input->post('epostal');
        }else if ($type=="education_experience"){
             $data['education'] 		= implode(";",$this->input->post('courses'));
             $data['experience'] 		= implode(";",$this->input->post('exps'));
        }else if ($type=="payslip_details"){
             $data['bid'] 		= $this->input->post('bank');
             $data['acno'] 		= $this->input->post('acno');
             $data['nhif'] 		= $this->input->post('nhif');
             $data['nssf'] 		= $this->input->post('nssf');
        }else if ($type=="skills_hobbies"){
             $data['skills'] 		= implode(";",$this->input->post('skills'));
             $data['hobbies'] 		= implode(";",$this->input->post('hobbies'));
        }else{
            return;
        }

        $acc_info = $this->db->get_where($account_type,array($account_type.'_id'=>$account_id))->row();
        $empno = $acc_info->emp_no;
        
        $b= false;
        if ($empno==""){
            $b=true;
        }else{
            $this->db->where('emp',$empno);
            $emp_inf = $this->db->get("employee",array("emp"=>$empno))->result_array();
            if(count($emp_inf)>0){
                $this->db->where('emp',$empno);
                $this->db->update('employee',$data);
            }else{
                $b=true;
            }
        }
        if ($b){
            $this->db->insert('employee',$data);
            $id = $this->db->insert_id();
            $empno = $account_type."-".$account_id."-".$id;
            $this->db->where('serial',$id);
            $this->db->update('employee',array("emp"=>$empno));
            $this->db->where($account_type.'_id',$account_id);
            $this->db->update($account_type,array("emp_no"=>$empno));
        }
        
     //   move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/accountant_image/" . $accountant_id . '.jpg');
    }
    
    function delete_accountant_info($accountant_id)
    {
        $this->db->where('accountant_id',$accountant_id);
        $this->db->delete('accountant');
    }
    
    function save_receptionist_info()
    {
        $data['name'] 		= $this->input->post('name');
        $data['user_name'] 		= $this->input->post('name');
        $data['email'] 		= $this->input->post('email');
        $data['password']       = sha1($this->input->post('password'));
        $data['address'] 	= $this->input->post('address');
        $data['phone']          = $this->input->post('phone');
        
        $this->db->insert('receptionist',$data);
        
        $receptionist_id  =   $this->db->insert_id();
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/receptionist_image/" . $receptionist_id . '.jpg');
    }
    
    function select_receptionist_info()
    {
        return $this->db->get('receptionist')->result_array();
    }
    
    function update_receptionist_info($receptionist_id)
    {
        $data['name'] 		= $this->input->post('name');
        $data['email'] 		= $this->input->post('email');
        $data['address'] 	= $this->input->post('address');
        $data['phone']          = $this->input->post('phone');
        
        $this->db->where('receptionist_id',$receptionist_id);
        $this->db->update('receptionist',$data);
        
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/receptionist_image/" . $receptionist_id . '.jpg');
    }
    
    function delete_receptionist_info($receptionist_id)
    {
        $this->db->where('receptionist_id',$receptionist_id);
        $this->db->delete('receptionist');
    }
    
    function save_bed_allotment_info()
    {
        $data['bed_id']                 = $this->input->post('bed_id');
        $data['patient_id'] 		    = $this->input->post('patient_id');
        $data['allotment_timestamp'] 	= strtotime($this->input->post('allotment_timestamp'));
        $data['discharge_timestamp']    = strtotime($this->input->post('discharge_timestamp'));
        
        $this->db->insert('bed_allotment',$data);
    }
    
    function select_bed_allotment_info()
    {
        return $this->db->get('bed_allotment')->result_array();
    }
    
    function update_bed_allotment_info($bed_allotment_id)
    {
        $data['bed_id']                 = $this->input->post('bed_id');
        $data['patient_id'] 		= $this->input->post('patient_id');
        $data['allotment_timestamp'] 	= strtotime($this->input->post('allotment_timestamp'));
        $data['discharge_timestamp']    = strtotime($this->input->post('discharge_timestamp'));
        
        $this->db->where('bed_allotment_id',$bed_allotment_id);
        $this->db->update('bed_allotment',$data);
    }
    
    function delete_bed_allotment_info($bed_allotment_id)
    {
        $this->db->where('bed_allotment_id',$bed_allotment_id);
        $this->db->delete('bed_allotment');
    }
    
    function select_blood_bank_info()
    {
        return $this->db->get('blood_bank')->result_array();
    }
    function update_blood_bank_info($blood_group_id)
    {
        $data['status']    = $this->input->post('status');
        
        $this->db->where('blood_group_id',$blood_group_id);
        $this->db->update('blood_bank',$data);
    }

    function save_bank_info()
    {
        $data['name']                 = $this->input->post('name');
        $this->db->insert('banktbl',$data);
    }

    function select_bank_info()
    {
        return $this->db->get('banktbl')->result_array();
    }

    function update_bank_info($bank_id)
    {
        $data['name']    = $this->input->post('name');
        
        $this->db->where('id',$bank_id);
        $this->db->update('banktbl',$data);
    }
    function delete_bank_info($bank_id)
    {
        $this->db->where('id',$bank_id);
        $this->db->delete('banktbl');
    }
    
    function save_report_info()
    {
        $data['type'] 		= $this->input->post('type');
        $data['description']    = $this->input->post('description');
        $data['timestamp']      = strtotime($this->input->post('timestamp'));
        $data['patient_id']     = $this->input->post('patient_id');
        
        $login_type             = $this->session->userdata('login_type');
        if($login_type=='nurse')
            $data['doctor_id']  = $this->input->post('doctor_id');
        else $data['doctor_id'] = $this->session->userdata('login_user_id');

        // Multiple File Upload
        $file_names = array();
        for ($i = 0; $i < count($_FILES['userfile']['name']); $i++)
            if($_FILES['userfile']['name'][$i] != '') {
                array_push($file_names, $_FILES['userfile']['name'][$i]);
                move_uploaded_file($_FILES['userfile']['tmp_name'][$i], 'uploads/report_file/' . $_FILES['userfile']['name'][$i]);
            }

        if(!empty($file_names))
            $data['files']  = json_encode($file_names);
        
        $this->db->insert('report',$data);
    }
    
    function select_report_info()
    {
        return $this->db->get('report')->result_array();
    }
    
    function update_report_info($report_id)
    {
        $data['type'] 		= $this->input->post('type');
        $data['description']    = $this->input->post('description');
        $data['timestamp']      = strtotime($this->input->post('timestamp'));
        $data['patient_id']     = $this->input->post('patient_id');
        
        $login_type             = $this->session->userdata('login_type');
        if($login_type=='nurse')
            $data['doctor_id']  = $this->input->post('doctor_id');
        else $data['doctor_id'] = $this->session->userdata('login_user_id');
        
        $this->db->where('report_id',$report_id);
        $this->db->update('report',$data);
    }
    
    function delete_report_info($report_id)
    {
        $files = $this->db->get_where('report', array('report_id' => $report_id))->row()->files;
        
        if($files != '') {
            $files = json_decode($files);

            foreach ($files as $file_name)
                unlink('uploads/report_file/' . $file_name);
        }

        $this->db->where('report_id',$report_id);
        $this->db->delete('report');
    }
    
    function delete_report_file($report_id = '', $file_serial = '')
    {
        $files = $this->db->get_where('report', array('report_id' => $report_id))->row()->files;

        $counter    = 1;
        $file_names = array();
        $files      = json_decode($files);
        foreach ($files as $file_name) {
            if($counter == $file_serial)
                unlink('uploads/report_file/' . $file_name);
            else
                array_push($file_names, $file_name);
            $counter++;
        }

        $data['files']  = json_encode($file_names);

        $this->db->where('report_id', $report_id);
        $this->db->update('report', $data);
    }
    
    function save_bed_info()
    {
        $data['bed_number']     = $this->input->post('bed_number');
        $data['room_no']     = $this->input->post('room_number');
        $data['type'] 		= $this->input->post('type');
        $data['description']    = $this->input->post('description');
        
        $this->db->insert('bed',$data);
    }
    
    function select_bed_info()
    {
        return $this->db->get('bed')->result_array();
    }
    
    function update_bed_info($bed_id)
    {
        $data['bed_number']     = $this->input->post('bed_number');
        $data['room_no']     = $this->input->post('room_number');
        $data['type'] 		= $this->input->post('type');
        $data['description']    = $this->input->post('description');
        
        $this->db->where('bed_id',$bed_id);
        $this->db->update('bed',$data);
    }
    
    function delete_bed_info($bed_id)
    {
        $this->db->where('bed_id',$bed_id);
        $this->db->delete('bed');
    }
    
    function save_blood_donor_info()
    {
        $data['name']                       = $this->input->post('name');
        $data['email']                      = $this->input->post('email');
        $data['address']                    = $this->input->post('address');
        $data['phone']                      = $this->input->post('phone');
        $data['sex']                        = $this->input->post('sex');
        $data['age']                        = $this->input->post('age');
        $data['blood_group']                = $this->input->post('blood_group');
        $data['last_donation_timestamp']    = strtotime($this->input->post('last_donation_timestamp'));
        
        $this->db->insert('blood_donor',$data);
    }
    
    function select_blood_donor_info()
    {
        return $this->db->get('blood_donor')->result_array();
    }
    
    function update_blood_donor_info($blood_donor_id)
    {
        $data['name']                       = $this->input->post('name');
        $data['email']                      = $this->input->post('email');
        $data['address']                    = $this->input->post('address');
        $data['phone']                      = $this->input->post('phone');
        $data['sex']                        = $this->input->post('sex');
        $data['age']                        = $this->input->post('age');
        $data['blood_group']                = $this->input->post('blood_group');
        $data['last_donation_timestamp']    = strtotime($this->input->post('last_donation_timestamp'));
        
        $this->db->where('blood_donor_id',$blood_donor_id);
        $this->db->update('blood_donor',$data);
    }
    
    function delete_blood_donor_info($blood_donor_id)
    {
        $this->db->where('blood_donor_id',$blood_donor_id);
        $this->db->delete('blood_donor');
    }
    
    function save_medicine_category_info()
    {
        $data['name'] 		= $this->input->post('name');
        $data['description']    = $this->input->post('description');
        
        $this->db->insert('medicine_category',$data);
    }
    
    function select_medicine_category_info()
    {
        return $this->db->get('medicine_category')->result_array();
    }
    
    function update_medicine_category_info($medicine_category_id)
    {
        $data['name'] 		= $this->input->post('name');
        $data['description'] 	= $this->input->post('description');
        
        $this->db->where('medicine_category_id',$medicine_category_id);
        $this->db->update('medicine_category',$data);
    }
    
    function delete_medicine_category_info($medicine_category_id)
    {
        $this->db->where('medicine_category_id',$medicine_category_id);
        $this->db->delete('medicine_category');
    }
    
    function save_medicine_info()
    {
        $data['name']                   = $this->input->post('name');
        $data['medicine_category_id']   = $this->input->post('medicine_category_id');
        $data['description']            = $this->input->post('description');
        $data['price']                  = $this->input->post('price');
        $data['manufacturing_company']  = $this->input->post('manufacturing_company');
        $data['total_quantity']         = $this->input->post('total_quantity');
        $data['sold_quantity']          = 0;
        
        $this->db->insert('medicine',$data);
    }
    
    function select_medicine_info()
    {
        return $this->db->get('medicine')->result_array();
    }
    
    function update_medicine_info($medicine_id)
    {
        $data['name']                   = $this->input->post('name');
        $data['medicine_category_id']   = $this->input->post('medicine_category_id');
        $data['description']            = $this->input->post('description');
        $data['price']                  = $this->input->post('price');
        $data['manufacturing_company']  = $this->input->post('manufacturing_company');
        $data['total_quantity']         = $this->input->post('total_quantity');
        
        $this->db->where('medicine_id',$medicine_id);
        $this->db->update('medicine',$data);
    }
    
    function delete_medicine_info($medicine_id)
    {
        $this->db->where('medicine_id',$medicine_id);
        $this->db->delete('medicine');
    }
    
    function save_appointment_info()
    {
        $data['timestamp']  = strtotime($this->input->post('date_timestamp').' '.$this->input->post('time_timestamp') );
        $data['status']     = 'approved';
        $data['patient_id'] = $this->input->post('patient_id');
        
        if($this->session->userdata('login_type') == 'doctor')
            $data['doctor_id']  = $this->session->userdata('login_user_id');
        else
            $data['doctor_id']  = $this->input->post('doctor_id');
        
        $this->db->insert('appointment',$data);
        
        // Notify patient with sms.
        $notify = $this->input->post('notify');
        if($notify != '') {
            $patient_name   =   $this->db->get_where('patient',
                                array('patient_id' => $data['patient_id']))->row()->name;
            $doctor_name    =   $this->db->get_where('doctor',
                                array('doctor_id' => $data['doctor_id']))->row()->name;
            $date           =   date('l, d F Y', $data['timestamp']);
            $time           =   date('g:i a', $data['timestamp']);
            $message        =   $patient_name . ', you have an appointment with doctor ' . $doctor_name . ' on ' . $date . ' at ' . $time . '.';
            $receiver_phone =   $this->db->get_where('patient',
                                array('patient_id' => $data['patient_id']))->row()->phone;
            
            $this->sms_model->send_sms($message, $receiver_phone);
        }
    }
    
    function save_requested_appointment_info()
    {
        $data['timestamp']  = strtotime($this->input->post('date_timestamp').' '.$this->input->post('time_timestamp') );
        $data['doctor_id']  = $this->input->post('doctor_id');
        $data['patient_id'] = $this->session->userdata('login_user_id');
        $data['status']     = 'pending';
        
        $this->db->insert('appointment',$data);
    }
    
    function select_appointment_info_by_doctor_id()
    {
        $doctor_id = $this->session->userdata('login_user_id');
        
        $this->db->order_by('timestamp' , 'desc');
        $this->db->where('doctor_id' , $doctor_id);
        $this->db->where('status' , 'approved');
        
        return $this->db->get('appointment')->result_array();
    }
    
    function select_appointment_info_by_patient_id()
    {
        $patient_id = $this->session->userdata('login_user_id');
        return $this->db->get_where('appointment', array('patient_id' => $patient_id, 'status' => 'approved'))->result_array();
    }
    
    function select_appointment_info($doctor_id = '', $start_timestamp = '', $end_timestamp = '')
    {
        $response = array();
        if($doctor_id == 'all') {
            $this->db->order_by('doctor_id', 'asc');
            $this->db->order_by('timestamp', 'desc');
            $appointments = $this->db->get_where('appointment', array('status' => 'approved'))->result_array();
            foreach ($appointments as $row) {
                if($row['timestamp'] >= $start_timestamp && $row['timestamp'] <= $end_timestamp)
                    array_push ($response, $row);
            }
        }
        else {
            $this->db->order_by('timestamp', 'desc');
            $appointments = $this->db->get_where('appointment', array('doctor_id' => $doctor_id, 'status' => 'approved'))->result_array();
            foreach ($appointments as $row) {
                if($row['timestamp'] >= $start_timestamp && $row['timestamp'] <= $end_timestamp)
                    array_push ($response, $row);
            }
        }
        return $response;
    }
    
    function select_pending_appointment_info_by_patient_id()
    {
        $patient_id = $this->session->userdata('login_user_id');
        return $this->db->get_where('appointment', array('patient_id' => $patient_id, 'status' => 'pending'))->result_array();
    }
    
    function select_requested_appointment_info_by_doctor_id()
    {
        $doctor_id = $this->session->userdata('login_user_id');
        return $this->db->get_where('appointment', array('doctor_id' => $doctor_id, 'status' => 'pending'))->result_array();
    }
    
    function select_requested_appointment_info()
    {
        $this->db->order_by('doctor_id', 'asc');
        return $this->db->get_where('appointment', array('status' => 'pending'))->result_array();
    }
    
    function select_patient_info_by_doctor_id()
    {
        $doctor_id = $this->session->userdata('login_user_id');
        
        $this->db->group_by('patient_id');
        return $this->db->get_where('appointment', array('doctor_id' => $doctor_id, 'status' => 'approved'))->result_array();
    }
    
    function select_appointments_between_loggedin_patient_and_doctor()
    {
        $patient_id = $this->session->userdata('login_user_id');
        
        $this->db->group_by('doctor_id');
        return $this->db->get_where('appointment', array('patient_id' => $patient_id, 'status' => 'approved'))->result_array();
    }
    
    function update_appointment_info($appointment_id)
    {
        $data['timestamp']  = strtotime($this->input->post('date_timestamp').' '.$this->input->post('time_timestamp') );
        $data['patient_id'] = $this->input->post('patient_id');
        
        $this->db->where('appointment_id',$appointment_id);
        $this->db->update('appointment',$data);
        
        // Notify patient with sms.
        $notify = $this->input->post('notify');
        if($notify != '') {
            $doctor_id      =   $this->session->userdata('login_user_id');
            $patient_name   =   $this->db->get_where('patient',
                                array('patient_id' => $data['patient_id']))->row()->name;
            $doctor_name    =   $this->db->get_where('doctor',
                                array('doctor_id' => $doctor_id))->row()->name;
            $date           =   date('l, d F Y', $data['timestamp']);
            $time           =   date('g:i a', $data['timestamp']);
            $message        =   $patient_name . ', your appointment with doctor ' . $doctor_name . ' has been updated to ' . $date . ' at ' . $time . '.';
            $receiver_phone =   $this->db->get_where('patient',
                                array('patient_id' => $data['patient_id']))->row()->phone;
            
            $this->sms_model->send_sms($message, $receiver_phone);
        }
    }
    
    function approve_appointment_info($appointment_id)
    {
        $data['timestamp']  = strtotime($this->input->post('date_timestamp').' '.$this->input->post('time_timestamp') );
        $data['status']     = 'approved';
        
        if($this->session->userdata('login_type') == 'receptionist')
            $data['doctor_id'] = $this->input->post('doctor_id');
        
        $this->db->where('appointment_id',$appointment_id);
        $this->db->update('appointment',$data);
        
        // Notify patient with sms.
        $notify = $this->input->post('notify');
        if($notify != '') {
            $doctor_id      =   $this->db->get_where('appointment',
                                array('appointment_id' => $appointment_id))->row()->doctor_id;
            $patient_id     =   $this->db->get_where('appointment',
                                array('appointment_id' => $appointment_id))->row()->patient_id;
            $patient_name   =   $this->db->get_where('patient',
                                array('patient_id' => $patient_id))->row()->name;
            $doctor_name    =   $this->db->get_where('doctor',
                                array('doctor_id' => $doctor_id))->row()->name;
            $date           =   date('l, d F Y', $data['timestamp']);
            $time           =   date('g:i a', $data['timestamp']);
            $message        =   $patient_name . ', your requested appointment with doctor ' . $doctor_name . ' on ' . $date . ' at ' . $time . ' has been approved.';
            $receiver_phone =   $this->db->get_where('patient',
                                array('patient_id' => $patient_id))->row()->phone;
            
            $this->sms_model->send_sms($message, $receiver_phone);
        }
    }
    
    function delete_appointment_info($appointment_id)
    {
        $this->db->where('appointment_id',$appointment_id);
        $this->db->delete('appointment');
    }
    
    function save_prescription_info()
    {
        $data['timestamp']      = strtotime($this->input->post('date_timestamp').' '.$this->input->post('time_timestamp') );
        $data['patient_id']     = $this->input->post('patient_id');
        $data['case_history']   = $this->input->post('case_history');
        $data['medication']     = $this->input->post('medication');
        $data['note']           = $this->input->post('note');
        $data['doctor_id']      = $this->session->userdata('login_user_id');
        
        $this->db->insert('prescription',$data);
    }
    
    function select_prescription_info_by_doctor_id()
    {
        $doctor_id = $this->session->userdata('login_user_id');
        return $this->db->get_where('prescription', array('doctor_id' => $doctor_id))->result_array();
    }
    
    function select_medication_history( $patient_id = '' )
    {
        return $this->db->get_where('prescription', array('patient_id' => $patient_id))->result_array();
    }
    
    function select_prescription_info_by_patient_id()
    {
        $patient_id = $this->session->userdata('login_user_id');
        return $this->db->get_where('prescription', array('patient_id' => $patient_id))->result_array();
    }
    
    function update_prescription_info($prescription_id)
    {
        $data['timestamp']      = strtotime($this->input->post('date_timestamp').' '.$this->input->post('time_timestamp') );
        $data['patient_id']     = $this->input->post('patient_id');
        $data['case_history']   = $this->input->post('case_history');
        $data['medication']     = $this->input->post('medication');
        $data['note']           = $this->input->post('note');
        $data['doctor_id']      = $this->session->userdata('login_user_id');
        
        $this->db->where('prescription_id',$prescription_id);
        $this->db->update('prescription',$data);
    }
    
    function delete_prescription_info($prescription_id)
    {
        $this->db->where('prescription_id',$prescription_id);
        $this->db->delete('prescription');
    }
    
    function save_diagnosis_report_info()
    {
        $data['timestamp']          = strtotime($this->input->post('date_timestamp').' '.$this->input->post('time_timestamp') );
        $data['report_type']        = $this->input->post('report_type');
        $data['file_name']          = $_FILES["file_name"]["name"];
        $data['document_type']      = $this->input->post('document_type');
        $data['description']        = $this->input->post('description');
        $data['prescription_id']    = $this->input->post('prescription_id');
        
        $this->db->insert('diagnosis_report',$data);
        
        $diagnosis_report_id        = $this->db->insert_id();
        move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/diagnosis_report/" . $_FILES["file_name"]["name"]);
    }
    
    function select_diagnosis_report_info()
    {
        return $this->db->get('diagnosis_report')->result_array();
    }
    
    function delete_diagnosis_report_info($diagnosis_report_id)
    {
        $this->db->where('diagnosis_report_id',$diagnosis_report_id);
        $this->db->delete('diagnosis_report');
    }
    
    function save_notice_info()
    {
        $data['title']              = $this->input->post('title');
        $data['description']        = $this->input->post('description');
        if($this->input->post('start_timestamp') != '')
            $data['start_timestamp']    = strtotime($this->input->post('start_timestamp'));
        else 
            $data['start_timestamp']    = '';
        if($this->input->post('end_timestamp') != '')
            $data['end_timestamp']      = strtotime($this->input->post('end_timestamp'));
        else
            $data['end_timestamp']      = $data['start_timestamp'];
        
        $this->db->insert('notice',$data);
    }
    
    function select_notice_info()
    {
        return $this->db->get('notice')->result_array();
    }
    
    function update_notice_info($notice_id)
    {
        $data['title']              = $this->input->post('title');
        $data['description']        = $this->input->post('description');
        if($this->input->post('start_timestamp') != '')
            $data['start_timestamp']    = strtotime($this->input->post('start_timestamp'));
        else 
            $data['start_timestamp']    = '';
        if($this->input->post('end_timestamp') != '')
            $data['end_timestamp']      = strtotime($this->input->post('end_timestamp'));
        else
            $data['end_timestamp']      = $data['start_timestamp'];
        
        $this->db->where('notice_id',$notice_id);
        $this->db->update('notice',$data);
    }
    
    function delete_notice_info($notice_id)
    {
        $this->db->where('notice_id',$notice_id);
        $this->db->delete('notice');
    }
    
    ////////private message//////
    function send_new_private_message() {
        $message    = $this->input->post('message');
        $timestamp  = strtotime(date("Y-m-d H:i:s"));

        $reciever   = $this->input->post('reciever');
        $sender     = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');

        //check if the thread between those 2 users exists, if not create new thread
        $num1 = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->num_rows();
        $num2 = $this->db->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->num_rows();
        if ($num1 == 0 && $num2 == 0) {
            $message_thread_code                        = substr(md5(rand(100000000, 20000000000)), 0, 15);
            $data_message_thread['message_thread_code'] = $message_thread_code;
            $data_message_thread['sender']              = $sender;
            $data_message_thread['reciever']            = $reciever;
            $this->db->insert('message_thread', $data_message_thread);
        }
        if ($num1 > 0)
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->row()->message_thread_code;
        if ($num2 > 0)
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->row()->message_thread_code;


        $data_message['message_thread_code']    = $message_thread_code;
        $data_message['message']                = $message;
        $data_message['sender']                 = $sender;
        $data_message['timestamp']              = $timestamp;
        $this->db->insert('message', $data_message);

        return $message_thread_code;
    }

    function send_reply_message($message_thread_code) {
        $message    = $this->input->post('message');
        $timestamp  = strtotime(date("Y-m-d H:i:s"));
        $sender     = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');


        $data_message['message_thread_code']    = $message_thread_code;
        $data_message['message']                = $message;
        $data_message['sender']                 = $sender;
        $data_message['timestamp']              = $timestamp;
        $this->db->insert('message', $data_message);
    }

    function mark_thread_messages_read($message_thread_code) {
        // mark read only the oponnent messages of this thread, not currently logged in user's sent messages
        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $this->db->where('sender !=', $current_user);
        $this->db->where('message_thread_code', $message_thread_code);
        $this->db->update('message', array('read_status' => 1));
    }

    function count_unread_message_of_thread($message_thread_code) {
        $unread_message_counter = 0;
        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $messages = $this->db->get_where('message', array('message_thread_code' => $message_thread_code))->result_array();
        foreach ($messages as $row) {
            if ($row['sender'] != $current_user && $row['read_status'] == '0')
                $unread_message_counter++;
        }
        return $unread_message_counter;
    }

    //CREATE MEDICINE SALE
    function create_medicine_sale() {
        $data['patient_id']     = $this->input->post('patient_id');
        $data['total_amount']   = $this->input->post('total_amount');

        $medicines              = array();
        $medicine_ids           = $this->input->post('medicine_id');
        $medicine_quantities    = $this->input->post('medicine_quantity');
        $number_of_entries      = sizeof($medicine_ids);
        
        for($i = 0; $i < $number_of_entries; $i++)
        {
            if($medicine_ids[$i] != "" && $medicine_quantities[$i] != "")
            {
                $new_entry = array('medicine_id' => $medicine_ids[$i], 'quantity' => $medicine_quantities[$i]);
                array_push($medicines, $new_entry);

                // UPDATE MEDICINE INVENTORY
                $sold_quantity = $this->db->get_where('medicine', array('medicine_id' => $medicine_ids[$i]))->row()->sold_quantity;

                $data2['sold_quantity'] = $sold_quantity + $medicine_quantities[$i];

                $this->db->update('medicine', $data2, array('medicine_id' => $medicine_ids[$i]));
            }
        }
        $data['medicines'] = json_encode($medicines);

        $this->db->insert('medicine_sale', $data);
    }
    //Get Insurerance Infomation
    function select_insurer_info($id=""){
        $result = array(); $items=array();
        if (strlen($id)>0){
            $items = $this->db->get_where('schemes',array('SchemeId' => $id))->result_array();
        }else
            $items = $this->db->get('schemes')->result_array();
        foreach($items as $item){
            $tmp = array();
            $tmp['id']=$item['SchemeId'];
            $tmp['name']=$item['SchemeName'];
            $tmp['smt'] = $item['SmartComp']; 
            $tmp['cmpname'] = "";
            $this->db->where('CustomerId' , $item['CompanyId']);
            $comparray =  $this->db->get('creditcustomers')->result_array();
            if (count($comparray)>0)
                $tmp['cmpname'] = $comparray[0]['CustomerName'];
            array_push($result,$tmp);
        };
        return $result;
    }
    function save_visitor_log($patient_id, $date){
        $today = strtotime(date("m/d/Y"));
        $this->db->where("patient_id",$pateint_id);
        $this->db->where("visit_date >",$today);
        $this->db->where("visit_date <=",time());
        $log = $this->db->get("visitor_log");
        if($log->num_rows()>0) return;

        $type=1;//review
        $reg_date = $this->select_patient_info_by_patient_id($patient_id)[0]["registered_date"];
        $limit = 60*60*24*10;
        $diff = $today - $reg_date;
        if ($diff>$limit) $type=2;//revisit;

        $this->db->insert("visitor_log",array(
            "patient_id"=>$patient_id,
            "type"=>$type,
            "visit_date"=>$date
        ));
    }
    function save_reception_info($reception_id, $patient_id){
        $recep_date=$data["recept_date"] =  strtotime(date("Y-m-d H:i:s"));
        $data["account_type"] = $this->session->userdata('login_type');
        $data["patient_id"] = $patient_id;
        $data["receptionist_id"] = $this->session->userdata('login_user_id');
        $refno = "";
        if (strlen($reception_id)==0){
            $data['status'] = 0;
            $this->db->insert('receptions',$data);
            $refno = $this->db->insert_id();
            $this->save_visitor_log($patient_id,$recep_date);
        }else
            $this->db->update('receptions',$data,array("refno"=>$reception_id));
        // update last visit date on patient.
        $data1['last_visited_date'] = strtotime(date("Y-m-d"));
        $data1["status"] = 1;
        $this->db->where('patient_id', $patient_id);
        $this->db->update('patient', $data1);

        
        return array(array('reception_id'=>$refno,'date'=>date("d/m/Y H:i:s",$data["recept_date"])));
    }   
    function select_receptions_info(){
        $receptions = $this->db->get('receptions')->result_array();
        $res = array();
        foreach ($receptions as $item){
            $temp=array();
            $temp["reception_id"] = $item["refno"];
            $temp["reception_date"] = $item["recept_date"];
            $temp["status"] = $item["status"];
            $receptionist_info = $this->db->get_where($item["account_type"], array($item["account_type"]."_id"=>$item["receptionist_id"]))->result_array();
            $patient_info = $this->db->get_where("patient", array("patient_id"=>$item["patient_id"]))->result_array();
            if (count($receptionist_info)>0) $temp["receptionist_name"] =$receptionist_info[0]["name"];
            if (count($patient_info)>0) $temp["patient_name"] =$patient_info[0]["name"];
            array_push($res,$temp);
        }
        return $res;
    }
    function delete_reception_info($reception_id){
        $this->db->where('refno', $reception_id);
        $this->db->delete('receptions');
    }
    // insert bill cart data to sales
    function insert_bill_info_for_sales($reception_id, $carts, $billtype="", $req_id=0){
        $b=true;
        foreach($carts as $cart){
            $data["item_id"]=$cart["itemcode"];
            $data["qty"]=$cart["qty"];
            $data["unit_price"]=$cart["unitprice"];
            $data["discount"]=$cart["discount"];
            $data["post_account_type"] = $this->session->userdata('login_type');
            $data["post_account_id"] = $this->session->userdata('login_user_id');
            $data["posted_date"] =  strtotime(date("Y-m-d H:i:s"));
            $data["iid"]=$cart["iid"];
            $data["recep_id"]=$reception_id;
            $data["status"]=0;
            $b&=$this->db->insert('sales',$data);
        }
        $table = "lab_request";
        if ($billtype=="rad") $table = "rad_request";
        $this->db->where("id",$req_id);
        $this->db->update($table,array("status"=>1));
       return $b;
    }
    // get itemname from itemcode
    function select_item_name($itemcode){
        $arr = $this->db->get_where("items", array("ItemCode"=>$itemcode))->result_array();
        $res="";
        if (count($arr)>0) $res = $arr[0]["ItemName"];
        return $res;
    }
    // get extmedic name from iid
    function select_incomename_from_extmedics($iid){
        $arr = $this->db->get_where("extmedics", array("id"=>$iid))->result_array();
        $res="";
        if (count($arr)>0) $res = $arr[0]["name"];
        return $res;
    }
    // get cart bill informatino
    function select_carts_info($reception_id,$category=""){
        $carts = $this->db->get_where('sales', array("recep_id"=>$reception_id))->result_array();
        $res = array();
        foreach ($carts as $item){
            $temp=array();
            $item_list = $this->db->get_where("items",array("ItemCode"=>$item["item_id"]))->row();
            if($item_list->SubCategory==$category||$item_list->Category==$category){
                $temp["itemname"] = $item_list->ItemName;
                $temp["quantity"] = $item["qty"];
                $temp["unit_price"] = $item["unit_price"];
                $temp["discount"] = $item["discount"];
                $temp["income"] = $this->select_incomename_from_extmedics($item["iid"]);
                array_push($res,$temp);
            }
        }
        return $res;
    }
   // get payment information from sales
    
    function select_payment_info($reception_id,$category=""){
        $carts = $this->db->get_where('sales', array("recep_id"=>$reception_id,"status"=>"1"))->result_array();
        $res = array();
        foreach ($carts as $item){
            $temp=array();
            $item_list = $this->db->get_where("items",array("ItemCode"=>$item["item_id"]))->row();
            if($item_list->SubCategory==$category||$item_list->Category==$category){
                $temp["itemname"] = $item_list->ItemName;
                $temp["transid"] = $item["trans_id"];
                array_push($res,$temp);
            }
        }
        return $res;
    }

    // save patient info to sendpatients table
    function send_patient_to_branch($params){
        $data['trans_id'] = $params["trans_id"];
        $data['sendto'] = $params['sendto'];
        $data["post_account_type"] = $this->session->userdata('login_type');
        $data["post_account_id"] = $this->session->userdata('login_user_id');
        $data["posted_date"] =  strtotime(date("Y-m-d H:i:s"));

 //       $data["sentto_account_type"] =$params["sentto_account_type"];
 //       $data["sentto_account_id"] = $params["sentto_account_id"];
        $data["patient_id"] = $params["patient_id"];
        $data["patient_type"] = $params["patient_type"];
        $data["recept_id"] = $params["recept_id"];
        //duplicated check
        $dup_list = $this->db->get_where("sendpatients",array(
            "patient_id"=>$data["patient_id"],
            "sendto"=>$data["sendto"],
            "recept_id"=>$data["recept_id"],
            "trans_id"=>$data["trans_id"]
        ));
        $b=true;
        if ($dup_list->num_rows()==0){
            $b = $this->db->insert('sendpatients',$data);
            $data1["status"] = 2;
            $this->db->where('trans_id', $params["trans_id"]);
            $b &= $this->db->update('sales', $data1);
            // sent to branch and update status on recption table
            $this->db->where('refno', $params["recept_id"]);
            $b &= $this->db->update('receptions', array("status"=>2));
        }
        return b;
        
    }
    // get pending list for triage
    function get_pending_list_for_triage(){
        $data=array();
        $res = array();
        if ($this->session->userdata('login_type')!="admin"){
            $data['sentto_account_type'] = $this->session->userdata('login_type');
            $data['sentto_account_id'] = $this->session->userdata('login_user_id');
        };
        $data['status'] = 0;
        $data['sendto'] = "triage";
        $list = $this->db->get_where("sendpatients",$data)->result_array();
        foreach($list as $item){
            $tmp = array();
            $tid = $item["trans_id"];
            $pid = $item["patient_id"];
            $plist = $this->select_patient_info_by_patient_id($pid)[0];
            $tmp["patient_id"] = $pid;
            $tmp["patient_name"] = $plist["name"];
            $tmp["sent_date"] = date("m/d/Y H:i:s",$item["posted_date"]);
            $tmp["queue_id"] = $item["id"];
            array_push($res,$tmp);
        };
        return $res;
    }
    
    //save triage date
    function save_triage_for_patient($params){
        $this->db->where("queue_id",$params["queue_id"]);
        $this->db->where("patient_id",$params["patient_id"]);
        $arr = $this->db->get("triage",array("queue_id"=>$params["queue_id"],"patient_id"=>$params["patient_id"]))->result_array();
        foreach($params as $k=>$v){
            $data[$k]=$v;
        }

        $data["test_date"] = strtotime(date("Y-m-d H:i:s"));
        $data['test_account_type'] = $this->session->userdata('login_type');
        $data['test_account_id'] = $this->session->userdata('login_user_id');
        
        if (count($arr)>0){//update
            $id = $arr[0]["id"];
            $this->db->where("id",$id);
            $this->db->update("triage",$data);            
        }else{
            $this->db->insert("triage",$data);
        }
        // change status of queue in sendpatients table
        $this->db->where("id",$params["queue_id"]);
        $this->db->update("sendpatients",array("status"=>1));            
    }
    //get triage list
    function get_triage_list($patient_id="", $queue_id=""){
        $data=array();
        if ($this->session->userdata('login_type')!="admin"){
            $data['sentto_account_type'] = $this->session->userdata('login_type');
            $data['sentto_account_id'] = $this->session->userdata('login_user_id');
        };
        if(strlen($patient_id)>0&&strlen($queue_id)>0){
            $data["patient_id"] = $patient_id;
            $data["queue_id"] = $queue_id;
        };
        $list = $this->db->get_where("triage",$data)->result_array();
        $res = array();
        foreach($list as $item){
            $tmp["triage_id"] = $item["id"];
            $pid=$tmp["patient_id"] = $item["patient_id"];
            $tmp["triage_date"] = date("d/m/Y H:i:s", $item["test_date"]);
            $tmp["queue_id"] = $item["queue_id"];
            $plist = $this->select_patient_info_by_patient_id($pid)[0];
            $tmp["patient_name"] = $plist["name"];
            if(strlen($patient_id)>0&&strlen($queue_id)>0){
                $tmp["temp"] = $item["temp"];
                $tmp["bph"] = $item["bp1"];
                $tmp["bpl"] = $item["bp2"];
                $tmp["weight"] = $item["weight"];
                $tmp["resprate"] = $item["resprate"];
                $tmp["pulserate"] = $item["pulserate"];
                $tmp["rbs"] = $item["rbs"];
                $tmp["allergies"] = $item["allergies"];
                $tmp["otherdetails"] = $item["other_details"];
            };
            $qlist = $this->db->get("sendpatients",array("id"=>$item["queue_id"]))->result_array();
            foreach($qlist as $row){
                $tmp["trans_id"]=$row["trans_id"];
                $tmp["patient_type"]=$row["patient_type"];
            }
            array_push($res,$tmp);
        }
        return $res;
        
    }
    //get triage list from reception id
    function get_triage_list_from_receptid($recept_id=""){
        $res = array();
        $list = $this->db->get_where("sendpatients",array("recept_id"=>$recept_id,"sendto"=>"triage"))->result_array();
        $qid = $list[0]["id"];
        $pid = $list[0]["patient_id"];
        $res = $this->get_triage_list($pid,$qid);
        return $res;
    }
    // delete tirage information
    function delete_triage_info($id){
        $this->db->where('id', $id);
        $this->db->delete('triage');
    }
    // get pending list for consultation
    function get_pending_list_for_consultation(){
        $data=array();
        $res = array();
        if ($this->session->userdata('login_type')!="admin"){
            $data['sentto_account_type'] = $this->session->userdata('login_type');
            $data['sentto_account_id'] = $this->session->userdata('login_user_id');
        };
        $data['status'] = 0;
        $data['sendto'] = "consultation";
        $list = $this->db->get_where("sendpatients",$data)->result_array();
        foreach($list as $item){
            $tmp = array();
            $tid = $item["trans_id"];
            $pid = $item["patient_id"];
            $plist = $this->select_patient_info_by_patient_id($pid)[0];
            $tmp["patient_id"] = $pid;
            $tmp["patient_name"] = $plist["name"];
            $tmp["sent_date"] = date("Y-m-d H:i:s",$item["posted_date"]);
            $tmp["queue_id"] = $item["id"];
            $tmp["recept_id"] = $item["recept_id"];
            array_push($res,$tmp);
        };
        return $res;
    }
    // save consultation
    function save_consult_for_patient($params){
        $data = $params;
        $table = "consultations";
        $arr = $this->db->get_where($table,$data)->result_array();
        $res = array();
        $res['msg']="success";
        $now = date("m/d/Y H:i:s");
        $data["last_date"] = strtotime($now);
        if (count($arr)==0){
            $data['cons_account_type'] = $this->session->userdata('login_type');
            $data['cons_account_id'] = $this->session->userdata('login_user_id');
            $this->db->insert($table,$data);
            $res["consID"]= $this->db->insert_id();
        }else{
            $this->db->where("id",$arr[0]["id"]);
            $this->db->update($table,array("last_date"=>$data["last_date"]));
        };
         // change queue status
        $this->db->where("id",$params["queue_id"]);
        $this->db->update("sendpatients",array("status"=>1));
        $res["lastdate"] = $now;
        return array($res);
    }
    // save current history for patient
    function save_cur_history_for_patient($params){
         $data = $params;
         $now = date("m/d/Y H:i:s");
         $table = "currenthistory";
         $data["timestamp"] = strtotime($now);
         $arr = $this->db->get_where($table,array("cons_id"=>$data["cons_id"]))->result_array();
         if (count($arr)==0){
            $this->db->insert($table,$data);
         }else{
            $this->db->where("id",$arr[0]["id"]);
            $this->db->update($table,$data);
         };
    }
    // get consultation list
    function get_consultation_list(){
        $data=array();
        if ($this->session->userdata('login_type')!="admin"){
            $data['cons_account_type'] = $this->session->userdata('login_type');
            $data['cons_account_id'] = $this->session->userdata('login_user_id');
        };
        $list = $this->db->get_where("consultations",$data)->result_array();
        $res = array();
        foreach($list as $item){
            $tmp["cons_id"] = $item["id"];
            $tmp["queue_id"] = $item["queue_id"];
            $pid=$tmp["patient_id"] = $item["patient_id"];
            $tmp["last_review_date"] = date("d/m/Y H:i:s", $item["last_date"]);
     //       $tmp["queue_id"] = $item["queue_id"];
            $plist = $this->select_patient_info_by_patient_id($pid)[0];
            $tmp["patient_name"] = $plist["name"];
            array_push($res,$tmp);
        }
        return $res;
    }
    // delete consultation information
    function delete_consultation_info($cons_id){
        $this->db->where('id', $cons_id);
        $this->db->delete('consultations');
    }
    // save physical examination information
    function save_physical_exam_for_patient($params){
         $data = $params;
         $now = date("m/d/Y H:i:s");
         $table = "physicalexam";
         $data["timestamp"] = strtotime($now);
         $arr = $this->db->get_where($table,array("cons_id"=>$data["cons_id"]))->result_array();
         if (count($arr)==0){
            $this->db->insert($table,$data);
         }else{
            $this->db->where("id",$arr[0]["id"]);
            $this->db->update($table,$data);
         };
    }
    // save diagnosis information
    function save_diag_history_for_patient($params){
         $data = $params;
         $now = date("m/d/Y H:i:s");
         $table = "diagnosis_history";
         $data["timestamp"] = strtotime($now);
         $arr = $this->db->get_where($table,array("cons_id"=>$data["cons_id"]))->result_array();
         if (count($arr)==0){
            $this->db->insert($table,$data);
         }else{
            $this->db->where("id",$arr[0]["id"]);
            $this->db->update($table,$data);
         };
    }
    //save pharmacy request
    function save_pharmacy_request_for_patient($params,$presc_list){
         $data = $params;
         $now = date("m/d/Y H:i:s");
         $table = "pharmacy_request";
         $data["timestamp"] = strtotime($now);
         $data['sender_account_type'] = $this->session->userdata('login_type');
         $data['sender_account_id'] = $this->session->userdata('login_user_id');
         $req_id = 0;
         $b=true;
         $arr = $this->db->get_where($table,array("cons_id"=>$data["cons_id"]));
         if ($arr->num_rows()==0){
            $b&=$this->db->insert($table,$data);
            $req_id = $this->db->insert_id();
         }else{
            $this->db->where("id",$arr->row()->id);
            $b&=$this->db->update($table,$data);
            $req_id = $arr->row()->id;
         };
         if ($req_id==0)
            $b=false;
          else
            $b&=$this->save_prescriptions_for_pharmacy_request($req_id,$data,$presc_list);
         return ($b)?"success":"failure";
    }
    // save_prescriptions_for_pharmacy_request
    function save_prescriptions_for_pharmacy_request($req_id,$params,$presc_list){
        $data["cons_id"] = $params["cons_id"];
        $data["recept_id"] = $params["recept_id"];
        $data["patient_id"] = $params["patient_id"];
        $data["req_id"] = $req_id;
        $now = date("m/d/Y H:i:s");
        $data["timestamp"] = strtotime($now);
        $data['doctor_account_type'] = $this->session->userdata('login_type');
        $data['doctor_id'] = $this->session->userdata('login_user_id');
        $b=true;
        $table = "prescription";
        foreach($presc_list as $list){
            $data["drug_id"] = $list["drug_id"];
            $data["drug_qty"] = $list["drug_qty"];
            $data["medication"] = $list["prescription"];
            $data["note"] = $list["note"];
            $b&=$this->db->insert($table,$data);
        }
        return $b;
    }
    //save laboratory request
    function save_lab_request_for_patient($params){
         $data["recept_id"] = $params["recept_id"];
         $data["cons_id"] = $params["cons_id"];
         $data["patient_id"] = $params["patient_id"];
         $now = date("m/d/Y H:i:s");
         $table = "lab_request";
         $data["start_time"] =$data["end_time"] = strtotime($now);
         $data['sender_account_type'] = $this->session->userdata('login_type');
         $data['sender_account_id'] = $this->session->userdata('login_user_id');
         $msg="";
         for ($i=0;$i<count($params["req_list"]);$i++){
             $val = $params["req_list"][$i];
            if (count($val)>0){
                $arr = $this->db->get_where($table,array("cons_id"=>$data["cons_id"],
                "itemcode"=>$val))->result_array();
                $data["itemcode"]=$val;
                if (count($arr)==0){
                    $this->db->insert($table,$data);
                }else{
                  //  $this->db->where("id",$arr[0]["id"]);
                  //  $this->db->update($table,$data);
                  $msg = "The request have been already added today";
                };
            }
            
         }
         return $msg;
    }
    function delete_labreq_info($id){
        $table = "lab_request";
        $this->db->where("id",$id);
        $this->db->delete($table);
    }
    function delete_radreq_info($id){
        $table = "rad_request";
        $this->db->where("id",$id);
        $this->db->delete($table);
    }
    //save radiology request
    function save_rad_request_for_patient($params){
         $data["recept_id"] = $params["recept_id"];
         $data["cons_id"] = $params["cons_id"];
         $data["patient_id"] = $params["patient_id"];
         $now = date("m/d/Y H:i:s");
         $table = "rad_request";
         $data["start_time"] =$data["end_time"] = strtotime($now);
         $data['sender_account_type'] = $this->session->userdata('login_type');
         $data['sender_account_id'] = $this->session->userdata('login_user_id');
         for ($i=0;$i<count($params["req_list"]);$i++){
             $val = $params["req_list"][$i];
            if (count($val)>0){
                $arr = $this->db->get_where($table,array("cons_id"=>$data["cons_id"],
                "itemcode"=>$val))->result_array();
                $data["itemcode"]=$val;
                if (count($arr)==0){
                    $this->db->insert($table,$data);
                }else{
                     $msg = "The request have been already added today";
                }
                    /*else{
                    $this->db->where("id",$arr[0]["id"]);
                    $this->db->update($table,$data);
                };*/
            }
            
         }
         return $msg;
         
    }
    // get pending list for payment process
    function get_pending_list_for_payment($recept_id=""){
        
        $sql = "SELECT SUM(qty*unit_price-discount) as total, recep_id,posted_date,receptions.patient_id as patient_id, patient.name  as patient_name FROM sales, receptions, patient where sales.recep_id=receptions.refno and receptions.patient_id=patient.patient_id and sales.status=0 ";
        if ($recept_id!="") $sql .= " and sales.recep_id='".$recept_id."'";
        $sql .= " GROUP BY recep_id";
        $list = $this->db->query($sql)->result_array();
        return $list;
        /*$res=array();
        foreach($list as $row){
            $tmp["recept_id"]=$row["recep_id"];
            $tmp["total_amount"]= $row["total"];
            $tmp["sent_date"]= $row["posted_date"];

        }*/
    }
    // payment process
    function submit_payment_for_patient($params){
        //tabel collection for payment process
        $tables = array(
            "receipt" => "receipts",
            "ledger" => "ledgers",
            "ledgerentery"=>"ledgerentries",
            "credit_customer" => "creditcustomers",
            "debt_customer"=>"customerdebts",
            "sales" => "sales",
            "lab_req" => "lab_request",
            "rad_req" => "rad_request",
            "phar_req" => "pharmacy_request",
            "items" => "items",
            "stock_track"=>"stocktrack"
        );
        // account information on ledgers table
        $acc_info = array(
            "account_receivable"=>array("628","Accounts Receivable"),
            "income_revenue"=>array("635","Income Revenue"),
            "waiver_account"=>array("700","Waiver Account"),
            "inventory"=>array("630","Inventory"),
            "cost_of_goods_sold"=>array("644","Cost Of Goods Sold"),
            "cashier_ac"=>array("705","Cashier A/C")
        );
        $b = true;
   //     $total_amount = 0;
        $pid = $params["patient_id"];
        $recepid = $params["recept_id"];
        foreach($params["carts"] as $cart){
            //insert into receipts table
            $tmp = array();
            $tmp["timestamp"]=strtotime(date("m/d/Y H:i:s"));
            $tmp["patient_id"] = $pid ;
            $tmp["recept_id"]= $recepid ;
            $mode = $tmp["paymode"] =$cart["mode"];
            $amount = $tmp["amount"] = $cart["amount"];
            $acid = $tmp["company_id"] = $cart["acid"];
            $cardno = $tmp["cardno"] = $cart["refno"];
            $login_type = $tmp['receiver_account_type'] = $this->session->userdata('login_type');
            $login_id = $tmp['receiver_account_id'] = $this->session->userdata('login_user_id');
            $now = strtotime(date("m/d/Y H:i:s"));
            $b &= $this->db->insert($tables["receipt"],$tmp);
   //         $total_amount += $amount;
            if (!$b) return $b;
            // register according to payment mode
            if ($mode=="Cash"){
                //first register in ledgerentries table
                $cash_bal = $this->get_bal_from_ledger($acc_info["cashier_ac"][0]);
                $cash_bal += $amount;
                $income_bal =$this-> get_bal_from_ledger($acc_info["income_revenue"][0]);
                $income_bal += $amount;
                $tmp = array();
                $tmp["crid"] = $acc_info["cashier_ac"][0];
                $tmp["drid"] = $acc_info["income_revenue"][0];
                $tmp["amount"] = $amount;
                $tmp["description"] = 'Income from Cash sales-Inv No:'.$recepid;
                $tmp["stamp"] = $now;
                $tmp["crbal"] = $cash_bal;
                $tmp["drbal"] = $income_bal;
                $tmp["status"] =0;
                $b &=$this->db->insert($tables["ledgerentery"],$tmp);
                //update ledger tabel
                $this->db->where("ledgerid",$acc_info["income_revenue"][0]);
                $b &=$this->db->update($tables["ledger"],array("bal"=>$income_bal));
                $this->db->where("ledgerid",$acc_info["cashier_ac"][0]);
                $b &=$this->db->update($tables["ledger"],array("bal"=>$cash_bal));
            }elseif ($mode=="Credit"){// if mode is credit
                $tmp=array();
                $tmp["PatId"] = $pid;
                //check whether patient is registered in creditcustomer table
                $arr = $this->db->get_where($tables["credit_customer"],array("PatientId"=>$pid))->result_array();
                if (count($arr)>0){
                    $tmp["CustomerId"] = $arr[0]["CustomerId"];
                    $bal = $arr[0]["Bal"];
                    $bal = $bal+$amount;
                    $tmp["InvBal"]=$tmp["Bal"] = $bal;
                }else{
                    $this->db->insert($tables["credit_customer"],array("PatientId"=>$pid));
                    $tmp["CustomerId"] = $this->db->insert_id();
                    $tmp["InvBal"]=$tmp["Bal"] = $amount;
                }
                // register into customerdebt table
                $tmp["InvoiceNo"] = $recepid;
                $tmp["amount"] = $amount;
                $tmp["DrCr"] = "dr";
                $tmp["stamp"] = $now;
                $tmp["Description"] = "Hospital charges on ".date("m/d/Y");
                $tmp["date"] =date("m/d/Y");
                $tmp["status"] = 1;
                $this->db->insert($tables["debt_customer"],$tmp);
                //update creditcustomers table
                $this->db->where("CustomerId", $tmp["CustomerId"]);
                $this->db->update($tables["credit_customer"],array("bal"=>$tmp["Bal"]));
                $rec_bal=$this->get_bal_from_ledger($acc_info["account_receivable"][0]);
                $rec_bal+=$amount;
                $income_bal=$this->get_bal_from_ledger($acc_info["income_revenue"][0]);
                $income_bal+=$amount;
                //insert ledgerentries table
                $tmp = array();
                $tmp["crid"] = $acc_info["account_receivable"][0];
                $tmp["drid"] = $acc_info["income_revenue"][0];
                $tmp["amount"] = $amount;
                $tmp["description"] = 'Income from Credit sales-Inv No:'.$recepid;
                $tmp["stamp"] = strtotime(date("m/d/Y H:i:s"));
                $tmp["crbal"] = $rec_bal;
                $tmp["drbal"] = $income_bal;
                $tmp["status"] =0;
                $b &=$this->db->insert($tables["ledgerentery"],$tmp);
                //update ledgers table
                $this->db->where("ledgerid",$acc_info["income_revenue"][0]);
                $b &=$this->db->update($tables["ledger"],array("bal"=>$income_bal));
                $this->db->where("ledgerid",$acc_info["account_receivable"][0]);
                $b &=$this->db->update($tables["ledger"],array("bal"=>$rec_bal));
            }elseif($mode=="Company"){
                $plist = $this->select_patient_info_by_patient_id($pid)[0];
                $benam= $plist["benamount"];
                $smartstatus = $plist["smartstatus"];
                if ($smartstatus==1){
                    $benam -= $amount;
                    $this->db->where("patient_id",$pid);
                    $b &= $this->db->update("patient",array("benamount"=>$benam));
                }else $b=false;
            }elseif($mode="Bank"){
                // get bank balance from ledgers table
                $bank_bal = $this->get_bal_from_ledger($acid);
                $bank_bal += $amount;
                //get balance income from ledgers table
                $income_bal = $this->get_bal_from_ledger($acc_info["income_revenue"][0]);
                $income_bal += $amount;
                //insert ledgerentry
                $tmp = array();
                $tmp["crid"] = $acid;
                $tmp["drid"] = $acc_info["income_revenue"][0];
                $tmp["amount"] = $amount;
                $tmp["description"] = 'Income through bank payments-Inv No:'.$recepid;
                $tmp["stamp"] = $now;
                $tmp["crbal"] = $bank_bal;
                $tmp["drbal"] = $income_bal;
                $tmp["status"] =0;
                $b &=$this->db->insert($tables["ledgerentery"],$tmp);
                //update ledger
                $this->db->where("ledgerid",$acc_info["income_revenue"][0]);
                $b &=$this->db->update($tables["ledger"],array("bal"=>$income_bal));
                $this->db->where("ledgerid",$acc_info["cashier_ac"][0]);
                $b &=$this->db->update($tables["ledger"],array("bal"=>$bank_bal));
            }elseif($mode="Waiver"){
                //update ledgers-waivers expenses
                $waiver_bal = $this->get_bal_from_ledger($acc_info["waiver_account"][0]);
                $waiver_bal += $amount;
                //get balance income from ledgers table
                $income_bal = $this->get_bal_from_ledger($acc_info["income_revenue"][0]);
                $income_bal += $amount;
                 //insert ledgerentry
                $tmp = array();
                $tmp["crid"] = $acc_info["waiver_account"][0];
                $tmp["drid"] = $acc_info["income_revenue"][0];
                $tmp["amount"] = $amount;
                $tmp["description"] = 'Income through Waivers -Waiver No:'.$cardno;
                $tmp["stamp"] = $now;
                $tmp["crbal"] = $waiver_bal;
                $tmp["drbal"] = $income_bal;
                $tmp["status"] =0;
                $b &=$this->db->insert($tables["ledgerentery"],$tmp);
                //update ledger
                $this->db->where("ledgerid",$acc_info["income_revenue"][0]);
                $b &=$this->db->update($tables["ledger"],array("bal"=>$income_bal));
                $this->db->where("ledgerid",$acc_info["waiver_account"][0]);
                $b &=$this->db->update($tables["ledger"],array("bal"=>$waiver_bal));
            }
        }
        // if sumitted bal >0 , debt process
        if ($params["bal"]>0){
            $tmp=array();
            $tmp["PatId"] = $pid;
            $debt_bal = $params["bal"];
            //check whether patient is registered in creditcustomer table
            $arr = $this->db->get_where($tables["credit_customer"],array("PatientId"=>$pid))->result_array();
            if (count($arr)>0){
                $tmp["CustomerId"] = $arr[0]["CustomerId"];
                $bal = $arr[0]["Bal"];
                $bal = $bal+$debt_bal;
                $tmp["InvBal"]=$tmp["Bal"] = $bal;
            }else{
                $this->db->insert($tables["credit_customer"],array("PatientId"=>$pid,
                "CustomerName"=>$this->select_patient_info_by_patient_id($pid)[0]["name"]));
                $tmp["CustomerId"] = $this->db->insert_id();
                $tmp["InvBal"]=$tmp["Bal"] = $debt_bal;
            }
            // register into customerdebt table
            $tmp["InvoiceNo"] = $recepid;
            $tmp["amount"] = $debt_bal;
            $tmp["DrCr"] = "dr";
            $tmp["stamp"] = $now;
            $tmp["Description"] = "Hospital charges on ".date("m/d/Y");
            $tmp["date"] =date("m/d/Y");
            $tmp["status"] = 1;
            $this->db->insert($tables["debt_customer"],$tmp);
            //update creditcustomers table
            $this->db->where("CustomerId", $tmp["CustomerId"]);
            $this->db->update($tables["credit_customer"],array("bal"=>$tmp["Bal"]));
        }
        // final process, we have to change status of sales table.
        $tmp = array();
        $tmp["status"] = 1;// will go complete paid status , value is 2
        $tmp["approved_date"] = $now;
        $tmp["account_type"] = $login_type;
        $tmp["cashier_id"] = $login_id;
        $this->db->where("recep_id",$recepid);
        $this->db->update("sales",$tmp);
        // update status on reception table
        $this->db->where("refno",$recepid);
        $this->db->update("receptions",array("status"=>1));
        
        //UPDATE DATABASE -REDUCTION OF STOCK ITEMS
        //reduce stock
        $sales_info = $this->db->get_where($tables["sales"],array("recep_id"=>$recepid))->result_array();
        foreach($sales_info as $row){
            $qty = $row["qty"];
            $item_id = $row["item_id"];
            $item_info = $this->db->get_where("items",array("ItemCode"=>$item_id))->result_array();
            $total_price = $qty*$row["unit_price"]-$row["discount"];
            //update lab table,radiology table,pharmacy table,theatre table.
            //laboratory
            $this->db->where("recept_id",$recepid);
            $this->db->where("itemcode",$item_id);
            $b &=$this->db->update($tables["lab_req"],array("status"=>2));// it means paid status
            // radiology table update
            $this->db->where("recept_id",$recepid);
            $this->db->where("itemcode",$item_id);
            $b &=$this->db->update($tables["rad_req"],array("status"=>2));
            // pharmacy table update
            $this->db->where("recept_id",$recepid);
    //        $this->db->where("itemcode",$item_id);
            $b &=$this->db->update($tables["phar_req"],array("status"=>2));//paid status

            if (count($item_info)>0){
                $item = $item_info[0];
                $type = $item["Type"];
                $total_price = $item["Type"];
                if ($type=="GOOD"){
                    $tmp=array();
                    $ph_bal = $item["PHARMACY"];
                    $pack = $item["Pack"];
                    $diff = $pack-$qty;
                    //update ledgers				
                    $invbal = $this->get_bal_from_ledger($acc_info["inventory"][0]);
                    $invbal -= $total_price;
                    $supbal = $this->get_bal_from_ledger($acc_info["cost_of_goods_sold"][0]);
                    $supbal += $total_price;
					//insert into stock track 
                    $tmp["Date"]=$now;
                    $tmp["Stamp"]=$now;    
                    $tmp["Dept"]="PHARMACY";
                    $tmp["ItemCode"]=$item_id;
                    $tmp["Pack"] = $pack;
                    $tmp["Qty"] = $qty;
                    $tmp["Bal"] = $diff;
                    $tmp["Description"]="OUTPATIENT SALES-".$recepid;
                    $tmp["account_type"] = $login_type;
                    $tmp["account_id"] = $login_id;
                    $this->db->insert($tables["stock_track"],$tmp);
                    //update items table
                    $this->db->where("ItemCode",$item_id);
                    $b &= $this->db->update($tables["items"],array("PHARMACY"=>$diff));
                     //update ledger
                    $this->db->where("ledgerid",$acc_info["inventory"][0]);
                    $b &=$this->db->update($tables["ledger"],array("bal"=>$invbal));
                    $this->db->where("ledgerid",$acc_info["cost_of_goods_sold"][0]);
                    $b &=$this->db->update($tables["ledger"],array("bal"=>$supbal));
                     //insert ledgerentry
                    $tmp = array();
                    $tmp["crid"] = $acc_info["inventory"][0];
                    $tmp["drid"] = $acc_info["cost_of_goods_sold"][0];
                    $tmp["amount"] = $total_price;
                    $tmp["description"] = 'Goods Sold-Inv No:'.$cardno;
                    $tmp["stamp"] = $now;
                    $tmp["crbal"] = $invbal;
                    $tmp["drbal"] = $supbal;
                    $tmp["status"] =0;
                    $b &=$this->db->insert($tables["ledgerentery"],$tmp);
                }
            }else $b=false;
        }
        return ($b)?"success":"failure";
    }
    function get_bal_from_ledger($ledgerid){
        $table = "ledgers";
        $res = $this->db->get_where($table,array("ledgerid"=>$ledgerid))->result_array();
        if (count($res)>0){
            return $res[0]["bal"];
        }else
            return 0;
    }
    //laboratory
    function select_lab_req_info($req_id=""){
        $res=array();
        if (strlen($req_id)>0) $this->db->where("id","$req_id");
        $this->db->order_by("start_time desc");
        $list = $this->db->get("lab_request")->result_array();
        foreach($list as $row){
            $tmp=array();
            $tmp["req_id"] = $row["id"];
            $tmp["recept_id"]=$row["recept_id"];
            $oinf = $this->select_patient_info_by_patient_id($row["patient_id"])[0];
            $tmp["patient_info"] = $oinf["name"]." - ".$oinf["patient_id"];
            $tmp["item_name"] = $this->select_item_name($row["itemcode"]);
            $tmp["req_date"] = date("Y/m/d H:i:s",$row["start_time"]);
            if ($row["status"]==0) $tmp["status"] = "Pending";
            if ($row["status"]==1) $tmp["status"] = "billed";
            if ($row["status"]==2) $tmp["status"] = "Processing";
            if ($row["status"]==3) $tmp["status"] = "Completed";
            array_push($res,$tmp);
        }
        return $res;
    }
    // lab reception
    function save_lab_recept_for_patient($param){
        $res=array();$b=true;
        $data=$param;
        $data['doneby_account_type'] = $this->session->userdata('login_type');
        $data['doneby_account_id'] = $this->session->userdata('login_user_id');
        $table = "lab_result";
        $date = date("Y/m/d H:i:s");
        $arr = $this->db->get_where($table,array("req_id"=>$data["req_id"],"patient_id"=>$data["patient_id"],"recept_id"=>$data["recept_id"]))->result_array();
        if (count($arr)>0){
            $data["serv_time"] = strtotime($date);
            $this->db->where("id",$arr[0]["id"]);
            $b&=$this->db->update($table,$data);
        }else{
            $data["receive_time"] = strtotime($date);
            $b&=$this->db->insert($table,$data);
        }
        if ($b){
            $this->db->where("id",$data["req_id"]);
            $b&=$this->db->update("lab_request",array("status"=>3,"end_time"=>strtotime($date)));
        }
        $tmp["msg"]=($b)?"success":"failure";
        $tmp["date"]=$date;
        array_push($res,$tmp);
        return json_encode($res);
    }
    // radiology request information
    function select_rad_req_info($req_id=""){
        $res=array();
        if (strlen($req_id)>0) $this->db->where("id","$req_id");
        $this->db->order_by("start_time desc");
        $list = $this->db->get("rad_request")->result_array();
        foreach($list as $row){
            $tmp=array();
            $tmp["req_id"] = $row["id"];
            $tmp["recept_id"]=$row["recept_id"];
            $oinf = $this->select_patient_info_by_patient_id($row["patient_id"])[0];
            $tmp["patient_info"] = $oinf["name"]." - ".$oinf["patient_id"];
            $tmp["item_name"] = $this->select_item_name($row["itemcode"]);
            $tmp["req_date"] = date("Y/m/d H:i:s",$row["start_time"]);
            if ($row["status"]==0) $tmp["status"] = "Pending";
            if ($row["status"]==1) $tmp["status"] = "billed";
            if ($row["status"]==2) $tmp["status"] = "Processing";
            if ($row["status"]==3) $tmp["status"] = "Completed";
            array_push($res,$tmp);
        }
        return $res;
    }
     // rad result saved
    function save_rad_result_for_patient($param,$req_id){
        $res=array();$b=true;
        $data=$param;
        $data['doneby_account_type'] = $this->session->userdata('login_type');
        $data['doneby_account_id'] = $this->session->userdata('login_user_id');
        $data["status"] =3;
        $table = "rad_request";
        $date = date("Y/m/d H:i:s");
        $data["end_time"] =strtotime($date);
        $this->db->where("id",$req_id);
        $b&=$this->db->update($table,$data);

        $tmp["msg"]=($b)?"success":"failure";
        $tmp["date"]=$date;
        array_push($res,$tmp);
        return json_encode($res);
    }
     // pharmacy request information
    function select_pharmacy_req_info($req_id=""){
        $res=array();
        if (strlen($req_id)>0) $this->db->where("id","$req_id");
        $this->db->order_by("status","ASC");
        $this->db->order_by("timestamp","desc");
        $list = $this->db->get("pharmacy_request")->result_array();
        foreach($list as $row){
            $tmp=array();
            $tmp["req_id"] = $row["id"];
            $tmp["recept_id"]=$row["recept_id"];
            $oinf = $this->select_patient_info_by_patient_id($row["patient_id"])[0];
            $tmp["patient_info"] = $oinf["name"]." - ".$oinf["patient_id"];
            $tmp["req_date"] = date("Y/m/d H:i:s",$row["timestamp"]);
            if ($row["status"]==0) $tmp["status"] = "posted";
            if ($row["status"]==1) $tmp["status"] = "billed";
            if ($row["status"]==2) $tmp["status"] = "paid";
            array_push($res,$tmp);
        }
        return $res;
    }
    // select journal entries
    function select_journal_entry_info(){
        $table = "ledgerentries";
        $this->db->order_by("stamp","desc");
        $entries = $this->db->get($table)->result_array();
        $res=array();
        foreach($entries as $item){
            $tmp = $item;
            $tmp["crname"] = $this->db->get_where("ledgers",array("ledgerid"=>$item["crid"]))->row()->name;
            $tmp["drname"] = $this->db->get_where("ledgers",array("ledgerid"=>$item["drid"]))->row()->name;
            array_push($res,$tmp);
        }
        return $res;
    }
    //post ledger entry to general ledger
    function post_ledger_entries(){
        $list = array();
        $enrty_table = "ledgerentries";
        $gen_ledger_tabel = "generalledger";
        $ledger_table = "ledgers";
        $sql = "select * from ledgers WHERE ledgerid!=601 order by name";
        $list = $this->db->query($sql)->result_array();
        $date = date("Y/m/d");
        $b=true;
        foreach($list as $row){
            $tmp["lid"]=stripslashes($row['ledgerid']);
			$tmp["lname"]=stripslashes($row['name']);
			$tmp["balance"]=stripslashes($row['bal']);
            $tmp["date"]= $date;
            $tmp["stamp"]= strtotime($date);
            $tmp["status"]= 1;
            $b&=$this->db->insert($gen_ledger_tabel,$tmp);

        }
        $this->db->where("status",0);
        $b&=$this->db->update($enrty_table,array("status"=>1));
        $b&=$this->db->update($ledger_table,array("date"=>$date));
        return $b;
    }
    // reverse journal entry
    function reverse_journal_entry($trans_id){
        $entry_table = "ledgerentries";
        $gen_ledger_tabel = "generalledger";
        $ledger_table = "ledgers";
        $date = date("Y/m/d H:i:s");
        $row = $this->db->get_where($entry_table,array("transid"=>$trans_id))->row();
        $tmp["crid"] =$cr = $row->crid;
        $tmp["drid"] =$dr = $row->drid;
        $tmp["amount"]= $amount= $row->amount;
        $bid=NULL;
        $bname=NULL;
        if($cr==625||$dr==625||$cr==658||$dr==658||$cr==659||$dr==659){
            $bid=$row->bankid;
            $bname=$row->accname;
        }
        //this was a debit
        $rowdr = $this->db->get_where($ledger_table,array("ledgerid"=>$dr))->row();
        $drtype = $rowdr->type;
        $drbal = $rowdr->bal;
        if($drtype=='Liability'||$drtype=='Revenue'||$drtype=='Equity'||$drtype=='Drawings'){
            $drbal=$drbal-$amount;
        }
        else{
            $drbal=$drbal+$amount;
        }
        //this was a credit
        $rowcr = $this->db->get_where($ledger_table,array("ledgerid"=>$cr))->row();
        $crtype = $rowcr->type;
        $crbal = $rowcr->bal;
        if($crtype=='Asset'||$crtype=='Expense'){
            $crbal=$crbal-$amount;												
        }
        else{
            $crbal=$crbal+$amount;
        }
        $tmp["description"] = 'reversal for TX id: '.$trans_id;
        $tmp["stamp"] = strtotime($date);
        $tmp["crbal"]=$crbal;
        $tmp["drbal"]=$drbal;
        $tmp["bankid"]=$bid;
        $tmp["accname"]=$bname;
        $tmp["status"]=3;
        $b=true;
        $b &= $this->db->insert($entry_table,$tmp);
        $this->db->where("transid",$trans_id);
        $b &= $this->db->update($entry_table,array("status"=>3));
        $this->db->where("ledgerid",$cr);
        $b &= $this->db->update($ledger_table,array("bal"=>$crbal));
        $this->db->where("ledgerid",$dr);
        $b &= $this->db->update($ledger_table,array("bal"=>$drbal));

        return ($b)?"success":"failure";
    }
    //insert new ledger entry
    function insert_ledger_entries($param){
        $data=$param;
        $entry_table = "ledgerentries";
        $gen_ledger_tabel = "generalledger";
        $ledger_table = "ledgers";
        $date = date("Y/m/d H:i:s");
        $data["stamp"] = strtotime($date);
        $data["status"] = 0;
        $amount = $data["amount"];
        //this was a debit
        $rowdr = $this->db->get_where($ledger_table,array("ledgerid"=>$data["crid"]))->row();
        $drtype = $rowdr->type;
        $drbal = $rowdr->bal;
        if($drtype=='Liability'||$drtype=='Revenue'||$drtype=='Equity'||$drtype=='Drawings'){
            $drbal=$drbal-$amount;
        }
        else{
            $drbal=$drbal+$amount;
        }
        //this was a credit
        $rowcr = $this->db->get_where($ledger_table,array("ledgerid"=>$data["drid"]))->row();
        $crtype = $rowcr->type;
        $crbal = $rowcr->bal;
        if($crtype=='Asset'||$crtype=='Expense'){
            $crbal=$crbal-$amount;												
        }
        else{
            $crbal=$crbal+$amount;
        }
        $data["crbal"]=$drbal;
        $data["drbal"]=$crbal;
        $b=true;
        $b &= $this->db->insert($entry_table,$data);
        $this->db->where("ledgerid",$data["crid"]);
        $b &= $this->db->update($ledger_table,array("bal"=>$drbal));
        $this->db->where("ledgerid",$data["drid"]);
        $b &= $this->db->update($ledger_table,array("bal"=>$crbal));
    }
    // insert ledger item
    function save_ledger_item($id=""){
        $data["name"]=$this->input->post("name");
        $data["type"]=$this->input->post("type");
        $data["category"]=$this->input->post("category");
        $data["date"]=date("Y/m/d");
        $data["bal"] = 0;
        $data["status"] = 1;
        $b=true;
        if ($id==""){
           $b &= $this->db->insert("ledgers",$data);
        }else{
            $this->db->where("ledgerid",$id);
            $data["bal"] = $this->input->post("balance");
            $b &= $this->db->update("ledgers",$data);
        }
        return $b;
    }
    //delete ledger info
    function delete_ledger_info($id){
        $this->db->where("ledgerid",$id);
        $this->db->delete("ledgers");
    }
    // select information from customerdebtor
    function get_customer_debtor_info($id){
        $table = "customerdebts";
        $this->db->where("CustomerId",$id);
        $this->db->where("DrCr","dr");
        $this->db->where("Status",1);
        $info = $this->db->get($table)->result_array();
        $res = array();
        foreach($info as $row){
            $tmp["id"] = $row["TransNo"];
            $tmp["date"] =$row["Date"];
            $pid = $row["PatId"];
            $tmp["patinfo"] = $this->select_patient_info_by_patient_id($pid)[0]["name"]."-".$pid;
            $tmp["invno"] = $row["InvoiceNo"];
            $tmp["amount"] = $row["Amount"];
            $tmp["invbal"] = $row["InvBal"];
            $tmp["paid"] = $row["Paid"];
            $tmp["bal"] = $row["Bal"];
            array_push($res,$tmp);
        }
        return $res;
    }
    function get_scheme_info($id=""){
        $this->db->order_by("SchemeName");
        if ($id!="") $this->db->where("SchemeId",$id);
        $list = $this->db->get("schemes")->result_array();
        $res=array();
        foreach ($list as $row) { 
            $company_info = $this->db->get_where("creditcustomers",array("CustomerId"=>$row["CompanyId"]))->row();
            $tmp["cpname"] = $company_info->CustomerName;
            $tmp["schname"] = $row["SchemeName"];
            $tmp["tel"] = $row["Tel"];
            $tmp["smartstatus"] = $company_info->SmartComp;
            $tmp["cpstatus"] = $row["CoPay"];
            $tmp["cptype"] = $row["CoPayType"];
            $tmp["cpam"] = $row["CoPayAm"];
            $tmp["id"] = $row["SchemeId"];
            $tmp["cpid"] =  $company_info->CustomerId;
            array_push($res,$tmp);
        }        
        return $res;
    }
    //save scheme info
    function save_scheme_item($id){
        $data["SchemeName"]=$this->input->post("schname");
        $data["Tel"]=$this->input->post("tel");
        $data["CoPay"] = $this->input->post("cpstatus");
        $data["CoPayType"] = $this->input->post("cptype");
        $data["CoPayAm"] = $this->input->post("cpam");
        $data["CompanyId"] = $this->input->post("cpid");
        $b=true;
        if ($id==""){
           $b &= $this->db->insert("schemes",$data);
        }else{
            $this->db->where("SchemeId",$id);
            $b &= $this->db->update("schemes",$data);
        }
        return $b;
    }
    //delete debtor info
    function delete_scheme_info($id){
        $this->db->where("SchemeId",$id);
        $this->db->delete("schemes");
    }
    // save debtor information
    function save_debtor_item($id){
        $data["CustomerName"]=$this->input->post("name");
        $data["Tel"]=$this->input->post("phone");
        $data["SmartComp"] = $this->input->post("smartcomp");
        $b=true;
        if ($id==""){
           $b &= $this->db->insert("creditcustomers",$data);
        }else{
            $this->db->where("CustomerId",$id);
            $b &= $this->db->update("creditcustomers",$data);
        }
        return $b;
    }
    //delete debtor info
    function delete_debtor_info($id){
        $this->db->where("CustomerId",$id);
        $this->db->delete("creditcustomers");
    }
    //get creditor customer invoice
    function get_customer_creditor_info($id){
        $table = "supplierdebts";
        $this->db->where("SupplierId",$id);
        $this->db->where("DrCr","dr");
        $this->db->where("Status",1);
        $info = $this->db->get($table)->result_array();
        $res = array();
        foreach($info as $row){
            $tmp["id"] = $row["TransNo"];
            $tmp["date"] = $row["Date"];
            $tmp["invno"] = $row["InvoiceNo"];
            $tmp["amount"] = $row["Amount"];
            $tmp["invbal"] = $row["InvBal"];
            $tmp["paid"] = $row["Paid"];
            $tmp["bal"] = $row["Bal"];
            array_push($res,$tmp);
        }
        return $res;
    }
     // save creditor information
    function save_creditor_item($id){
        $data["CustomerName"]=$this->input->post("name");
        $data["Tel"]=$this->input->post("phone");
        $b=true;
        if ($id==""){
           $b &= $this->db->insert("creditsuppliers",$data);
        }else{
            $this->db->where("CustomerId",$id);
            $b &= $this->db->update("creditsuppliers",$data);
        }
        return $b;
    }
    //delete creditor info
    function delete_creditor_info($id){
        $this->db->where("CustomerId",$id);
        $this->db->delete("creditsuppliers");
    }
    //make payment for creditors
    function make_payment_for_creditor($cusid,$ledger_id){
        $table_crditor="creditsuppliers";
        $table_supplier_debt="supplierdebts";
        $table_ledgerentries = "ledgerentries";
        $table_ledgers = "ledgers";
        $creditor_info = $this->db->get_where($table_crditor,array("CustomerId"=>$cusid))->row();
        
        $bal = $creditor_info->Bal;
        $data = $this->input->post("data");
        $refno = $this->input->post("refno");
        $date = date("d/m/Y");
        $b=true;
        $total_paying=0;
        foreach($data as $row){
            $trans_id = $row["id"];
            $paying_val = $row["paying"];
            $inv_info = $this->db->get_where($table_supplier_debt, array("TransNo"=>$trans_id))->row();
            $paid = $inv_info->Paid;
            $inv_val = $inv_info->InvBal;
            $inv_no = $inv_info->InvoiceNo;
            $amount = $inv_info->Amount;
            $nPaid = $tmp["Paid"] = $paid+$paying_val;
            $total_paying += $paying_val;
            $tmp["Bal"] = $row["Bal"];//$amount-$paying_val;
            $tmp["InvoiceNo"] = $inv_no;
            $tmp["DrCr"] = "cr";
            $tmp["SupplierId"] = $cusid;
            $tmp["SupplierName"] = $creditor_info->CustomerName;
            $tmp["GrnNo"] = "";
            $tmp["Amount"]=$paying_val;
            $nInvbal = $tmp["InvBal"]=$inv_val- $paying_val;
            $tmp["Description"] = "Payment of GRN Invoice-".$inv_no."-Ref No:".$refno;
            $tmp["Date"]= $date;
            $tmp["Stamp"] = strtotime($date);
            $tmp["status"] = 1;
            $b&=$this->db->insert($table_supplier_debt,$tmp);
            $this->db->where("TransNo",$trans_id);
            $b&=$this->db->update($table_supplier_debt,array("InvBal"=>$nInvbal,"Paid"=>$nPaid));
            if ($nInvbal ==0){
                $this->db->where("TransNo",$trans_id);
                $b&=$this->db->update($table_supplier_debt,array("Status"=>2));
            };
        };
        $this->db->where("CustomerId",$cusid);
        $b&=$this->db->update($table_crditor,array("Bal"=>$bal-$total_paying));
        //update ledger
        $bal1=$this->db->get_where($table_ledgers,array("ledgerid"=>629))->row()->bal;
        $bal2=$this->db->get_where($table_ledgers,array("ledgerid"=>$ledger_id))->row()->bal;
        $bal1 -= $total_paying;
        $bal2 -= $total_paying;
        $this->db->where("ledgerid",629);
        $b&=$this->db->update($table_ledgers,array("bal"=>$bal1));
        $this->db->where("ledgerid",$ledger_id);
        $b&=$this->db->update($table_ledgers,array("bal"=>$bal2));
        $b&=$this->db->insert($table_ledgerentries,array(
            "crid"=>629,
            "drid"=>$ledger_id,
            "amount"=>$total_paying,
            "description"=>"Payment of Creditors",
            "date"=>$date,
            "stamp"=>strtotime($date),
            "crbal"=>$bal1,
            "drbal"=>$bal2,
            "status"=>0
        ));
        return (b)?"success":"failure";
    }
      //receive payment for debtors
    function receive_payment_for_debtor($cusid,$ledger_id){
        $table_crditor="creditcustomers";
        $table_customer_debt="customerdebts";
        $table_ledgerentries = "ledgerentries";
        $table_ledgers = "ledgers";
        $table_receipt ="debtreceipts";
        $creditor_info = $this->db->get_where($table_crditor,array("CustomerId"=>$cusid))->row();
        
        $bal = $creditor_info->Bal;
        $data = $this->input->post("data");
        $refno = $this->input->post("refno");
        $date = date("m/d/Y");
        $b=true;
        $total_paying=0;
        $totinv="";
        foreach($data as $row){
            $trans_id = $row["id"];
            $paying_val = $row["paying"];
            $inv_info = $this->db->get_where($table_customer_debt, array("TransNo"=>$trans_id))->row();
            $paid = $inv_info->Paid;
            $inv_val = $inv_info->InvBal;
            $inv_no = $inv_info->InvoiceNo;
            $amount = $inv_info->Amount;
            $nPaid = $tmp["Paid"] = $paid+$paying_val;
            $total_paying += $paying_val;
            $tmp["Bal"] = $inv_info->Bal;//$amount-$paying_val;
            $tmp["InvoiceNo"]=$inv_no;
            $totinv.=$inv_no.';';
            $tmp["DrCr"] = "cr";
            $cid=$tmp["CustomerId"] = $cusid;
            $cname=$tmp["CustomerName"] = $creditor_info->CustomerName;
            $tmp["Amount"]=$paying_val;
            $nInvbal = $tmp["InvBal"]=$inv_val- $paying_val;
            $tmp["Description"] = "Payment of Invoice-Inv No-".$inv_no."-Ref No:".$refno;
            $tmp["Date"]= $date;
            $tmp["Stamp"] = strtotime($date);
            $tmp["status"] = 1;
            $b&=$this->db->insert($table_customer_debt,$tmp);
            $this->db->where("TransNo",$trans_id);
            $b&=$this->db->update($table_customer_debt,array("InvBal"=>$nInvbal,"Paid"=>$nPaid));
            if ($nInvbal ==0){
                $this->db->where("TransNo",$trans_id);
                $b&=$this->db->update($table_customer_debt,array("Status"=>2));
            };
             
        };
        $this->db->where("CustomerId",$cusid);
        $b&=$this->db->update($table_crditor,array("Bal"=>$bal-$total_paying));
        //update ledger
        $bal1=$this->db->get_where($table_ledgers,array("ledgerid"=>628))->row()->bal;
        $bal2=$this->db->get_where($table_ledgers,array("ledgerid"=>$ledger_id))->row()->bal;
        $bal1 -= $total_paying;
        $bal2 -= $total_paying;
        $this->db->where("ledgerid",628);
        $b&=$this->db->update($table_ledgers,array("bal"=>$bal1));
        $this->db->where("ledgerid",$ledger_id);
        $b&=$this->db->update($table_ledgers,array("bal"=>$bal2));
        $b&=$this->db->insert($table_ledgerentries,array(
            "crid"=>629,
            "drid"=>$ledger_id,
            "amount"=>$total_paying,
            "description"=>"Income from Credit sales",
            "date"=>$date,
            "stamp"=>strtotime($date),
            "crbal"=>$bal1,
            "drbal"=>$bal2,
            "status"=>0
        ));
        $data['doneby_account_type'] = $this->session->userdata('login_type');
        $data['doneby_account_id'] = $this->session->userdata('login_user_id');
       //insert new receipt
        $b&=$this->db->insert($table_receipt,array(
            "cid"=>$cusid,
            "cname"=>$creditor_info->CustomerName,
            "amount"=>$total_paying,
            "description"=>$totinv,
            "date"=>$date,
            "stamp"=>strtotime($date),
            "account_id"=>$this->session->userdata('login_user_id'),
            "account_type"=>$this->session->userdata('login_type'),
            "bal"=>$bal -$total_paying,
            "status"=>1
        ));
        return (b)?"success":"failure";
    }
    //get inovices for receipts by pid
    function get_invoices_for_receipts_by_pid($invno=""){
        $table = "receipts";
        if($invno!="") 
            $this->db->where("invno",$invno);
        $this->db->where("Paymode","Companies");
        $info = $this->db->get($table)->result_array();
        $res = array();
        foreach($info as $row){
            $tmp["id"] = $row["id"];
            $tmp["date"] = date("m/d/Y H:i:s", $row["timestamp"]);
            $tmp["invno"] = $row["invno"];
            $tmp["pname"] = $this->crud_model->select_patient_info_by_patient_id($row['patient_id'])[0]["name"];
            $tmp["pid"] = $row["patient_id"];
            array_push($res,$tmp);
        }
        return $res;
    }
    //create expense transaction
    function save_expense_item(){
        $table="ledgers";
        $drid = $this->input->post("acid");
        $amount = $this->input->post("amount");
        $note = $this->input->post("note");
        $date = $this->input->post("date");
        $crinfo = $this->db->get_where($table,array("ledgerid"=>"670"))->row();
        $msg = "Transaction success!";
        $b=true;
        $crid=$crinfo->ledgerid;
        if ($crid==""){
            $msg = "You have to be registered as a chief cashier to carry out this transaction.";
        }else{
            $crbal = $crinfo->bal;
            $drinfo = $this->db->get_where($table,array("ledgerid"=>$drid))->row();
            $drbal = $drinfo->bal;
            $crbal = $crbal - $amount;
            $drbal = $drbal + $amount;
            $stamp = strtotime(date("Y/m/d H:i:s"));
            if ($crbal <0 ){
                $msg="Chief Cashier Account balance cannot be less than zero.";
            }else{
                $b &= $this->db->insert("ledgerentries", array(
                    "crid"=>$crid,
                    "drid"=>$drid,
                    "date"=>$date,
                    "amount"=>$amount,
                    "description"=>$note,
                    "crbal"=>$crbal,
                    "drbal"=>$drbal,
                    "stamp"=>$stamp,
                    "status"=>0
                ));
                $this->db->where("ledgerid","670");
                $b &= $this->db->update($table, array("bal"=>$crbal));
                $this->db->where("ledgerid",$drid);
                $b &= $this->db->update($table, array("bal"=>$drbal));
                if($b==false) $msg = "Got some errors.";
            }
        }
        return $msg;
    }
    //create bank deposit transaction
    function save_bnkdeposit_item(){
        $table="ledgers";
        $drid = $this->input->post("acid");
        $amount = $this->input->post("amount");
        $note = $this->input->post("note");
        $crid = "705";
        $crinfo = $this->db->get_where($table,array("ledgerid"=>$crid))->row();
        $msg = "Transaction success!";
        $b=true;
     //   $crid=$crinfo->ledgerid;
        if ($crid==""){
            $msg = "You have to be registered as a chief cashier to carry out this transaction.";
        }else{
            $crbal = $crinfo->bal;
            $drinfo = $this->db->get_where($table,array("ledgerid"=>$drid))->row();
            $drbal = $drinfo->bal;
            $crbal = $crbal - $amount;
            $drbal = $drbal + $amount;
            $date = date("Y/m/d H:i:s");
            $stamp = strtotime($date);
            if ($crbal <0 ){
                $msg="Chief Cashier Account balance cannot be less than zero.";
            }else{
                $b &= $this->db->insert("ledgerentries", array(
                    "crid"=>$crid,
                    "drid"=>$drid,
                    "date"=>$date,
                    "amount"=>$amount,
                    "description"=>$note,
                    "crbal"=>$crbal,
                    "drbal"=>$drbal,
                    "stamp"=>$stamp,
                    "date"=>$date,
                    "status"=>0
                ));
                $this->db->where("ledgerid",$crid);
                $b &= $this->db->update($table, array("bal"=>$crbal));
                $this->db->where("ledgerid",$drid);
                $b &= $this->db->update($table, array("bal"=>$drbal));
                // make bank deposit entry
                $b &= $this->db->insert("bankdeposits", array(
                    "bank_id"=>$drid,
                    "date"=>$date,
                    "amount"=>$amount,
                    "stamp"=>$stamp,
                    "status"=>1
                ));
                if($b==false) $msg = "Got some errors.";
            }
        }
        return $msg;
    }
     //create cash collection transaction
    function save_cash_collection_item(){
        $table="ledgers";
        $crid = $this->input->post("acid");
        $amount = $this->input->post("amount");
        $note = $this->input->post("note");
        $drid = "705";
        $drinfo = $this->db->get_where($table,array("ledgerid"=>$drid))->row();
        $msg = "Transaction success!";
        $b=true;
     //   $crid=$crinfo->ledgerid;
        if ($crid==""){
            $msg = "You have to be registered as a chief cashier to carry out this transaction.";
        }else{
            $drbal = $drinfo->bal;
            $crinfo = $this->db->get_where($table,array("ledgerid"=>$crid))->row();
            $crbal = $crinfo->bal;
            $crbal = $crbal - $amount;
            $drbal = $drbal + $amount;
            $date = date("Y/m/d H:i:s");
            $stamp = strtotime($date);
            if ($crbal <0 ){
                $msg="Chief Cashier Account balance cannot be less than zero.";
            }else{
                $b &= $this->db->insert("ledgerentries", array(
                    "crid"=>$crid,
                    "drid"=>$drid,
                    "date"=>$date,
                    "amount"=>$amount,
                    "description"=>$note,
                    "crbal"=>$crbal,
                    "drbal"=>$drbal,
                    "stamp"=>$stamp,
                    "date"=>$date,
                    "status"=>0
                ));
                $this->db->where("ledgerid",$crid);
                $b &= $this->db->update($table, array("bal"=>$crbal));
                $this->db->where("ledgerid",$drid);
                $b &= $this->db->update($table, array("bal"=>$drbal));
                if($b==false) $msg = "Got some errors.";
            }
        }
        return $msg;
    }
    // save stock item
    function save_stock_item($id=""){
        $data["ItemName"]=$this->input->post("itemname");
  //      $data["Type"]=$this->input->post("type");
        $data["Category"]=$this->input->post("category");
        $data["SubCategory"]=$this->input->post("subcategory");
        $data["SalePrice"]=$this->input->post("saleprice");
        $data["MinBal"]=$this->input->post("minbal");
        $data["Molecule"]=$this->input->post("molecule");
        $data["LeadTime"]=$this->input->post("leadtime");
        $data["Supplier"]=$this->input->post("supid");
        $data["Pack"]=$this->input->post("pack");
        $data["PurchPrice"]=$this->input->post("purchaseprice");
        $data["Vat"]=$this->input->post("vat");
        $data["Taxable"]=$this->input->post("taxable");
        $data["Sellable"]=$this->input->post("sellable");
        $b=true;
        if ($id==""){
            $data["Type"]=$this->input->post("type");
            $b &= $this->db->insert("items",$data);
        }else{
            $this->db->where("ItemCode",$id);
            $b &= $this->db->update("items",$data);
        }
        return $b;
    }
    // save stock request
    function save_stock_request(){
        $carts = json_decode($this->input->post("carts"),true);
        $b=true;
        $item_table = "items";
        $issue_table = "issuetable";
        //get receipt no
        $q =$this->db->query("SELECT * FROM $issue_table order by TransNo desc limit 0,1")->row();
        $rcptno=$q->IssueNo +1;
        foreach($carts as $cart){
            $code = $cart["code"];
            $item_info = $this->db->get_where($item_table,array("itemCode"=>$code))->result_array()[0];
            $purch_price = $item_info["PurchPrice"];
            $qty = $cart["pack"]*$cart["units"] +$cart["parts"];
            $total_price = $qty * $purch_price;
            $b &= $this->db->insert($issue_table,array(
                "IssueNo"=>$rcptno,
                "ItemCode"=>$cart["code"],
                "ItemName"=>$cart["name"],
                "Dep1"=>$cart["to"],
                "Dep2"=>$cart["from"],
                "Pack"=>$cart["pack"],
                "Stamp"=>strtotime(date("Ymd H:i:s")),
                "Qty"=>$qty,
                "Total"=>$total_price,
                "UnitBox"=>$cart["units"],
                "PartBox"=>$cart["parts"],
                "TransDate"=>date("Ymd"),
                "Status"=>1,
                "requested_account_id"=>$this->session->userdata('login_user_id'),
                "requested_account_type"=>$this->session->userdata('login_type')
            ));
        };
        return $b;
    }
    //process stock request(stock tranfer)
    function proc_stock_request($task="", $id=""){
        if ($task==""||$id=="") return false;
        $table_item = "items";
        $table_issue = "issuetable";
        $tabele_track = "stocktrack";
        $b=true;
        if($task=="transfer"){
            $req_info = $this->db->get_where($table_issue,array("TransNo"=>$id))->row();
            $qty =  $req_info->Qty;
            $itemcode = $req_info->ItemCode;
            $item_info = $this->db->get_where($table_item,array("ItemCode"=>$itemcode))->result_array()[0];
            $fromDep = $req_info->Dep2;//from
            $toDep = $req_info->Dep1;//to
            $d2= ($fromDep=="PROCUREMENT")?"Bal":$fromDep;
            $d1= ($toDep=="PROCUREMENT")?"Bal":$toDep;
            $bal1 = $item_info[$d1];
            $bal2 = $item_info[$d2];
            $bal1 += $qty;
            $bal2 -= $qty;
            $pack= $req_info->Pack;         
            $now = date("Y/m/d");
            $b &= $this->db->insert($tabele_track, array(
                "Date"=>$now,
                "Dept"=>$toDep,
                "ItemCode"=>$itemcode,
                "Pack"=>$pack,
                "Description"=>'STOCK TRANSFER FROM '.$fromDep,
                "Qty"=>$qty,
                "Bal"=>$bal1,
                "Stamp"=>strtotime($now),
                "account_id"=>$this->session->userdata('login_user_id'),
                "account_type"=>$this->session->userdata('login_type')
            ));
            $b &= $this->db->insert($tabele_track, array(
                "Date"=>$now,
                "Dept"=>$fromDep,
                "ItemCode"=>$itemcode,
                "Pack"=>$pack,
                "Description"=>'STOCK TRANSFER TO '.$toDep,
                "Qty"=>$qty,
                "Bal"=>$bal2,
                "Stamp"=>strtotime($now),
                "account_id"=>$this->session->userdata('login_user_id'),
                "account_type"=>$this->session->userdata('login_type')
            ));
            if ($b){
                $this->db->where("TransNo",$id);
                $b &=$this->db->update($table_issue, array(
                    "Status"=>2,
                    "TransDate"=>$now,
                    "issued_acount_type"=>$this->session->userdata('login_type'),
                    "issued_acount_id"=>$this->session->userdata('login_user_id'),
                    "Stamp"=>strtotime($now)
                ));
                $this->db->where("ItemCode",$itemcode);
                $b &=$this->db->update($table_item, array(
                    $d2=>$bal2,
                    $d1=>$bal1,
                ));
            }
            
        }else if($task=="revoke"){
            $this->db->where("TransNo",$id);
            $b &= $this->db->update($table_issue,array("status"=>0));
        };
        return $b;
    }
    //stock adjustment
    function save_stock_adjustment(){
        $carts = json_decode($this->input->post("carts"),true);
        $b=true;
        $item_table = "items";
        $var_table = "variance";
        $table_track = "stocktrack";
        $table_ledgers = "ledgers";
        $table_ledgers_entry = "ledgerentries";
        //get receipt no
        $q =$this->db->query("SELECT * FROM $var_table order by id desc limit 0,1")->row();
        $rcptno=$q->vno +1;
        $j=0;
        foreach($carts as $cart){
            $code = $cart["code"];
            $item_info = $this->db->get_where($item_table,array("itemCode"=>$code))->result_array()[0];
            $bra = $cart["from"];
            $bra = ($bra=="PROCUREMENT")?"Bal":$bra;
            $bal = $item_info[$bra];
            $purch_price = $item_info["PurchPrice"];
            $qty = $cart["pack"]*$cart["units"] +$cart["parts"];
            $diffa=$qty-$bal;
            $total_price = $diffa * $purch_price;
            $j+=$total_price;
            $now = date("Y/m/d");
            $b &= $this->db->insert($var_table,array(
                "vno"=>$rcptno,
                "itemcode"=>$cart["code"],
                "itemname"=>$cart["name"],
                "dept"=>$cart["from"],
                "pack"=>$cart["pack"],
                "stamp"=>strtotime(date("Ymd H:i:s")),
                "bala"=>$bal,
                "balb"=>$qty,
                "total"=>$total_price,
                "date"=>$now,
                "status"=>1,
                "requested_account_id"=>$this->session->userdata('login_user_id'),
                "requested_account_type"=>$this->session->userdata('login_type')
            ));
            //insert into stock track
			$b &= $this->db->insert($table_track, array(
                "Date"=>$now,
                "Dept"=>$bra,
                "ItemCode"=>$code,
                "Pack"=>$cart["pack"],
                "Description"=>'STOCK ADJUSTMENT',
                "Qty"=>$diffa,
                "Bal"=>$qty,
                "Stamp"=>strtotime($now),
                "account_id"=>$this->session->userdata('login_user_id'),
                "account_type"=>$this->session->userdata('login_type')
            ));
            $this->db->where("ItemCode",$code);
            $b &=$this->db->update($item_table, array(
                $bra=>$qty,
                "Diff"=>$diffa
            ));
        };
        if ($b){
                //update ledgers-stock

            $amount=$j;
            $ledger_info = $this->db->get_where($table_ledgers,array("ledgerid"=>'630'))->row();
            $invbal= $ledger_info->bal;
            $invbal=$invbal+$amount;

            $ledger_info = $this->db->get_where($table_ledgers,array("ledgerid"=>'725'))->row();
            $supbal= $ledger_info->bal;
            $supbal=$supbal-$amount;

            $b &= $this->db->insert($table_ledgers_entry, array(
                "crid"=>"630",
                "drid"=>"725",
                "description"=>"STOCK ADJUSTMENT",
                "date"=>$now,
                "stamp"=>strtotime($now),
                "crbal"=>$invbal,
                "drbal"=>$supbal,
                "status"=>0,
                "amount"=>$amount
            ));
            $this->db->where("ledgerid",'630');
            $b &= $this->db->update($table_ledgers,array("bal"=>$invbal));
            $this->db->where("ledgerid",'725');
            $b &= $this->db->update($table_ledgers,array("bal"=>$supbal));
        }
        return $b;
    }
    //stock usage register
    function save_stock_usage_register(){
        $brancharray = explode("-",$this->input->post("branch"));
        $branchId = $brancharray[0];
        $branch = $brancharray[1];
        $itemcode = $this->input->post("item");
        $qtyused = $this->input->post("qty");
        $note = $this->input->post("note");
        $date=date('Y/m/d');
		$stamp=strtotime($date);
        $b=true;
        $item_table = "items";
        $table_track = "stocktrack";
        $table_stockuse = "stockuse";
        $table_ledgers = "ledgers";
        $table_ledgers_entry = "ledgerentries";
        $branch = ($branch=="PROCUREMENT")?"Bal":$branch;
        $item_info = $this->db->get_where($item_table,array("itemCode"=>$itemcode))->result_array()[0];
        $bal = $item_info[$branch];
        $purch_price = $item_info["PurchPrice"];
        $pack = $item_info["Pack"];
        $nbal=$bal-$qtyused;
		$total=$purch_price*$qtyused;
        //insert into stock track
        $b &= $this->db->insert($table_track, array(
            "Date"=>$date,
            "Dept"=>$branch,
            "ItemCode"=>$itemcode,
            "Pack"=>$pack,
            "Description"=>'STOCK USAGE REGISTER',
            "Qty"=>$qtyused,
            "Bal"=>$nbal,
            "Stamp"=>$stamp,
            "account_id"=>$this->session->userdata('login_user_id'),
            "account_type"=>$this->session->userdata('login_type')
        ));
        $this->db->where("ItemCode",$itemcode);
        $b &=$this->db->update($item_table, array(
            $branch=>$nbal
        ));
        //insert into stock usage
        $b &= $this->db->insert($table_stockuse, array(
            "date"=>$date,
            "branchid"=>$branchId,  
            "branchname"=>$branch,
            "itemcode"=>$itemcode,
            "itemname"=>$item_info["ItemName"],
            "details"=>$note,
            "status"=>1,
            "qty"=>$qtyused,
            "stamp"=>$stamp,
            "account_id"=>$this->session->userdata('login_user_id'),
            "account_type"=>$this->session->userdata('login_type')
        ));
       
        if ($b){
                //update ledgers-stock

            $amount=$total;
            $ledger_info = $this->db->get_where($table_ledgers,array("ledgerid"=>'630'))->row();
            $invbal= $ledger_info->bal;
            $invbal=$invbal-$amount;

            $ledger_info = $this->db->get_where($table_ledgers,array("ledgerid"=>'701'))->row();
            $supbal= $ledger_info->bal;
            $supbal=$supbal+$amount;

            $b &= $this->db->insert($table_ledgers_entry, array(
                "crid"=>"630",
                "drid"=>"701",
                "description"=>"STOCK USAGE",
                "date"=>$date,
                "stamp"=>$stamp,
                "crbal"=>$invbal,
                "drbal"=>$supbal,
                "status"=>0,
                "amount"=>$amount
            ));
            $this->db->where("ledgerid",'630');
            $b &= $this->db->update($table_ledgers,array("bal"=>$invbal));
            $this->db->where("ledgerid",'701');
            $b &= $this->db->update($table_ledgers,array("bal"=>$supbal));
        }
        return $b;
    }
    //delete stock item
    function delete_stockitem_info($id){
        $this->db->where("ItemCode",$id);
        $this->db->delete("items");
    }
    function select_sub_category_by_category($cat){
        if ($cat !="PROCUREMENT") 
            $this->db->where("branch",$cat);
        $sub_cat_list = $this->db->get("subcategories")->result_array();
        $res = array();
        foreach ($sub_cat_list as $item){
            array_push($res,$item);
        }
        return $res;
    }
    //good receive inwards
    function save_goods_receive_inwards(){
        $carts = json_decode($this->input->post("carts"),true);
        $b=true;
        $item_table = "items";
        $table_track = "stocktrack";
        $table_ledgers = "ledgers";
        $table_ledgers_entry = "ledgerentries";
        $table_purch = "purchases";
        //get receipt no
        $q =$this->db->query("SELECT * FROM $table_purch order by TransNo desc limit 0,1")->row();
        $rcptno=$q->PurchNo +1;
        $j=0;
        foreach($carts as $cart){
            $code = $cart["code"];
            $item_info = $this->db->get_where($item_table,array("itemCode"=>$code))->result_array()[0];
            $bra = "PHARMACY";
            $bal = $item_info[$bra];
            $purch_price = $item_info["PurchPrice"];
            $qty = $cart["pack"]*$cart["units"] +$cart["parts"];
            $diffa=$qty+$bal;
            $qpurch = $item_info["Qpurch"];
            $now = date("Y/m/d");
            $total_price = $qty*$purch_price;
            $j += $total_price;
            $sid = $cart["supid"];
            $sname = $cart["supname"];
            //insert into stock track
			$b &= $this->db->insert($table_track, array(
                "Date"=>$now,
                "Dept"=>"PHARMACY",
                "ItemCode"=>$code,
                "Pack"=>$cart["pack"],
                "Description"=>'PURCHASES - '.$cart["supname"],
                "Qty"=>$qty,
                "Bal"=>$diffa,      
                "Stamp"=>strtotime($now),
                "account_id"=>$this->session->userdata('login_user_id'),
                "account_type"=>$this->session->userdata('login_type')
            ));
            $this->db->where("ItemCode",$code);
            $b &=$this->db->update($item_table, array(
                "SalePrice"=>$cart["saleprice"],
                "PurchPrice"=>$cart["purprice"],
                "PHARMACY"=>$diffa,
                "Qpurch"=>$qpurch+$qty
            ));
            //insert purchase item
            $b &= $this->db->insert($table_purch, array(
                "PurchNo"=>$rcptno,
                "PurchDate"=>$cart["date"],
                "ItemCode"=>$code,
                "ItemName"=>$cart["name"],
                "UnitBox"=>$cart["units"],
                "PartBox"=>$cart["parts"],
                "Quantity"=>$qty,
                "SalePrice"=>$cart["saleprice"],
                "PurchPrice"=>$cart["purprice"],
                "TotalPrice"=>$total_price,
                "SupplierId"=>$sid,
                "Supplier"=>$sname,
                "BatchNo"=>$cart["batchno"],
                "InvoiceNo"=>$cart["invno"],
                "StockDate"=>$now,
                "Bal"=>$diffa,
                "Expiry"=>$cart["expdate"],
                "expstamp"=>$cart["expdate"],
                "Stamp"=>strtotime($now),
                "InvoiceAmt"=>0,
                "account_id"=>$this->session->userdata('login_user_id'),
                "account_type"=>$this->session->userdata('login_type')
            ));
            // creditor debtors
            $crinfo = $this->db->get_where("creditsuppliers", array("CustomerId"=>$sid))->row();
            $crbal = $crinfo->Bal;
            $crbal += $total_price;
            $b &= $this->db->insert("supplierdebts",array(
                "SupplierId"=>$sid,
                "SupplierName"=>$sname,
                "InvoiceNo"=>$cart["invno"],
                "GrnNo"=>$rcptno,
                "Amount"=>$total_price,
                "DrCr"=>"dr",
                "Paid"=>0,
                "InvBal"=>$total_price,
                "Bal"=>$crbal,
                "Description"=>"Purchases",
                "Date"=>$now,
                "Stamp"=>strtotime($now),
                "Status"=>1
            ));
            $this->db->where("CustomerId",$sid);
            $b&= $this->db->update("creditsuppliers", array("Bal"=>$crbal));
        };

        $this->db->where("PurchNo",$rcptno);
        $b &= $this->db->update($table_purch,array("InvoiceAmt"=>$j));

        if ($b){
           $amount=$j;
                 //update ledgers-stock
            $ledger_info = $this->db->get_where($table_ledgers,array("ledgerid"=>'629'))->row();
            $invbal= $ledger_info->bal;
            $invbal=$invbal+$amount;

            $ledger_info = $this->db->get_where($table_ledgers,array("ledgerid"=>'630'))->row();
            $supbal= $ledger_info->bal;
            $supbal=$supbal-$amount;

            $b &= $this->db->insert($table_ledgers_entry, array(
                "crid"=>"630",
                "drid"=>"725",
                "description"=>"Goods Received Inwards",
                "date"=>$now,
                "stamp"=>strtotime($now),
                "crbal"=>$supbal,
                "drbal"=>$invbal,
                "status"=>0,
                "amount"=>$amount
            ));
            $this->db->where("ledgerid",'629');
            $b &= $this->db->update($table_ledgers,array("bal"=>$invbal));
            $this->db->where("ledgerid",'630');
            $b &= $this->db->update($table_ledgers,array("bal"=>$supbal));
        }
        return $b;
    }
    //good returned outwards
    function save_goods_returned_outwards(){
        $carts = json_decode($this->input->post("carts"),true);
        $b=true;
        $item_table = "items";
        $table_track = "stocktrack";
        $table_ledgers = "ledgers";
        $table_ledgers_entry = "ledgerentries";
        $table_returned = "goodsreturned";
        //get receipt no
        $q =$this->db->query("SELECT * FROM $table_returned order by id desc limit 0,1")->row();
        $rcptno=$q->gnrno +1;
        $j=0;
        foreach($carts as $cart){
            $code = $cart["code"];
            $item_info = $this->db->get_where($item_table,array("itemCode"=>$code))->result_array()[0];
            $bra = "PHARMACY";
            $bal = $item_info[$bra];
            $purch_price = $item_info["PurchPrice"];
            $lpo = $cart["lpono"];
            $qty = $cart["pack"]*$cart["units"] +$cart["parts"];
            $diffa=$bal-$qty;
            $now = date("Y/m/d");
            $total_price = $qty*$purch_price;
            $j += $total_price;
            $sid = $cart["supid"];
            $sname = $cart["supname"];
            //insert into stock track
			$b &= $this->db->insert($table_track, array(
                "Date"=>$now,
                "Dept"=>"PHARMACY",
                "ItemCode"=>$code,
                "Pack"=>$cart["pack"],
                "Description"=>'GOODS RETURNED - '.$sname,
                "Qty"=>$qty,
                "Bal"=>$diffa,      
                "Stamp"=>strtotime($now),
                "account_id"=>$this->session->userdata('login_user_id'),
                "account_type"=>$this->session->userdata('login_type')
            ));
            $this->db->where("ItemCode",$code);
            $b &=$this->db->update($item_table, array(
                "PHARMACY"=>$diffa
            ));
            //insert goods returned item
            $b &= $this->db->insert($table_returned, array(
                "gnrno"=>$rcptno,
                "code"=>$code,
                "itemname"=>$cart["name"],
                "unit"=>$cart["units"],
                "part"=>$cart["parts"],
                "date"=>$cart["date"],
                "pprice"=>$cart["purprice"],
                "total"=>$total_price,
                "sname"=>$sname,
                "batch"=>$cart["batchno"],
                "invoice"=>$cart["invno"],
                "lpo"=>$lpo,
                "reason"=>$cart["reason"],
                "pack"=>$cart["pack"],
                "expiry"=>$cart["expdate"],
                "stamp"=>strtotime($now),
                "status"=>1,
                "totalamount"=>0,
                "account_id"=>$this->session->userdata('login_user_id'),
                "account_type"=>$this->session->userdata('login_type')
            ));
            //post credit note
            $crinfo = $this->db->get_where("creditsuppliers", array("CustomerId"=>$sid))->row();
            $crbal = $crinfo->Bal;
            $crbal -= $total_price;
            $b &= $this->db->insert("supplierdebts",array(
                "SupplierId"=>$sid,
                "SupplierName"=>$sname,
                "InvoiceNo"=>$cart["invno"],
                "GrnNo"=>$rcptno,
                "Amount"=>$total_price,
                "DrCr"=>"cr",
                "Paid"=>0,
                "InvBal"=>$total_price,
                "Bal"=>$crbal,
                "Description"=>"Purchases",
                "Date"=>$now,
                "Stamp"=>strtotime($now),
                "Status"=>1
            ));
            $this->db->where("CustomerId",$sid);
            $b&= $this->db->update("creditsuppliers", array("Bal"=>$crbal));
        };

        $this->db->where("gnrno",$rcptno);
        $b &= $this->db->update($table_returned,array("totalamount"=>$j));

        if ($b){
           $amount=$j;
            //update ledgers-stock
            $ledger_info = $this->db->get_where($table_ledgers,array("ledgerid"=>'630'))->row();
            $invbal= $ledger_info->bal;
            $invbal=$invbal+$amount;

            $ledger_info = $this->db->get_where($table_ledgers,array("ledgerid"=>'651'))->row();
            $supbal= $ledger_info->bal;
            $supbal=$supbal-$amount;

            $b &= $this->db->insert($table_ledgers_entry, array(
                "crid"=>"630",
                "drid"=>"651",
                "description"=>"Goods Returned Outwards",
                "date"=>$now,
                "stamp"=>strtotime($now),
                "crbal"=>$invbal,
                "drbal"=>$supbal,
                "status"=>0,
                "amount"=>$amount
            ));
            $this->db->where("ledgerid",'630');
            $b &= $this->db->update($table_ledgers,array("bal"=>$invbal));
            $this->db->where("ledgerid",'651');
            $b &= $this->db->update($table_ledgers,array("bal"=>$supbal));

            //update ledgers-acs/payable
            $ledger_info = $this->db->get_where($table_ledgers,array("ledgerid"=>'629'))->row();
            $invbal= $ledger_info->bal;
            $invbal=$invbal-$amount;

            $ledger_info = $this->db->get_where($table_ledgers,array("ledgerid"=>'644'))->row();
            $supbal= $ledger_info->bal;
            $supbal=$supbal+$amount;

            $b &= $this->db->insert($table_ledgers_entry, array(
                "crid"=>"644",
                "drid"=>"629",
                "description"=>"Goods Returned Outwards",
                "date"=>$now,
                "stamp"=>strtotime($now),
                "crbal"=>$supbal,
                "drbal"=>$invbal,
                "status"=>0,
                "amount"=>$amount
            ));
            $this->db->where("ledgerid",'629');
            $b &= $this->db->update($table_ledgers,array("bal"=>$invbal));
            $this->db->where("ledgerid",'630');
            $b &= $this->db->update($table_ledgers,array("bal"=>$supbal));
        }
        return $b;
    }
    function save_local_purchase_order(){
        $carts = json_decode($this->input->post("carts"),true);
        $b=true;
        $table_lpo="lpo";
        $item_table = "items";
        //get receipt no
        $q =$this->db->query("SELECT * FROM $table_lpo order by id desc limit 0,1")->row();
        $rcptno=$q->lpono +1;
        $now = date("Ymd");
        foreach($carts as $cart){
            $code = $cart["code"];
            $item_info = $this->db->get_where($item_table,array("itemCode"=>$code))->result_array()[0];
            $b &= $this->db->insert($table_lpo, array(
                "lpono"=>$rcptno,
                "supplier"=>$cart["supname"],
                "date"=>$cart["date"],
                "itemname"=>$item_info["ItemName"],
                "pack"=>$cart["pack"],
                "unit"=>$cart["units"],
                "part"=>$cart["parts"],
                "price"=>$cart["purprice"],
                "total"=>$cart["totprice"],
                "status"=>1,
                "account_id"=>$this->session->userdata('login_user_id'),
                "account_type"=>$this->session->userdata('login_type'),
                "stamp"=>strtotime($now)
            ));
        }
        return $b;
    }
    function check_sys_user_name($username){
        $acc_list = array("admin","accountant","doctor","nurse","receptionist","laboratorist","pharmacist");
        $b=true;
        foreach ($acc_list as $acc){
            $user = $this->db->get_where($acc,array("user_name"=>$username))->result_array();
            if (count($user)>0){
                $b=false; break;
            }
        }
        return $b;
    }
    function get_alarm_list(){
        $res = array();
        $total=0;
        //get new patients
        $new_patient_list = $this->db->get_where("patient",array("status"=>0))->result_array();
        if (count($new_patient_list)>0){
            $tmp["message"] = "New Patients";//.count($new_patient_list);
            $tmp["count"] = count($new_patient_list);
            $desc_list = array();
            foreach($new_patient_list as $item){
                array_push($desc_list, array(
                    "desc"=>$item["name"]." - No: ".$item['patient_id'],
                    "date"=>date("m/d/Y H:m:i",$item["registered_date"]),
                    "id"=>$item["patient_id"]));
                $total++;
            }
            $tmp["desc_list"] = $desc_list;
            $tmp["url"]= base_url()."index.php?".$this->session->userdata("login_type")."/patient";
            array_push($res,$tmp);
        }
        //get new receptions(pending list)
        $new_list = $this->db->get_where("receptions",array("status"=>0))->result_array();
        if (count($new_list)>0){
            $tmp["message"] = "Pending Receptions";//.count($new_patient_list);
            $tmp["count"] = count($new_list);
            $desc_list = array();
            foreach($new_list as $item){
                $pid = $item["patient_id"];
                $pname = $this->select_patient_info_by_patient_id($pid)[0]["name"];
                array_push($desc_list, array(
                    "desc"=>$pname." - No: ".$item['refno'],
                    "date"=>date("m/d/Y H:m:i",$item["recept_date"]),
                    "id"=>$item["refno"]));
                $total++;                
            }
            $tmp["desc_list"] = $desc_list;
            $tmp["url"]= base_url()."index.php?".$this->session->userdata("login_type")."/reception";
            array_push($res,$tmp);
        }
        //get new triage
        $new_list = $this->get_pending_list_for_triage();
        if (count($new_list)>0){
            $tmp["message"] = "Pending Triages";
            $tmp["count"] = count($new_list);
            $desc_list = array();
            foreach($new_list as $item){
                $pname = $item["patient_name"];
                array_push($desc_list, array(
                    "desc"=>$pname." - No: ".$item['queue_id'],
                    "suburl"=>"register/".$item['patient_id'],
                    "date"=>$item["sent_date"],
                    "id"=>$item["queue_id"]));
                $total++;                
            }
            $tmp["desc_list"] = $desc_list;
            $tmp["url"]= base_url()."index.php?".$this->session->userdata("login_type")."/triage";
            array_push($res,$tmp);
        }
        //get new consultation
        $new_list = $this->get_pending_list_for_consultation();
        if (count($new_list)>0){
            $tmp["message"] = "Pending Consultations";
            $tmp["count"] = count($new_list);
            $desc_list = array();
            foreach($new_list as $item){
                $pname = $item["patient_name"];
                array_push($desc_list, array(
                    "desc"=>$pname." - No: ".$item['queue_id'],
                    "suburl"=>"register/".$item['patient_id'],
                    "date"=>date("m/d/Y H:m:i",$item["last_date"]),   
                    "id"=>$item["queue_id"]));
                $total++;                
            }
            $tmp["desc_list"] = $desc_list;
            $tmp["url"]= base_url()."index.php?".$this->session->userdata("login_type")."/consultation";
            array_push($res,$tmp);
        }
        //get new payments
        $new_list = $this->get_pending_list_for_payment();//$this->db->get_where("rad_request",array("status"=>0))->result_array();
        if (count($new_list)>0){
            $tmp["message"] = "Pending Payments";//.count($new_patient_list);
            $tmp["count"] = count($new_list);
            $desc_list = array();
            foreach($new_list as $item){
                $pname = $item["patient_name"];
                array_push($desc_list, array(
                    "desc"=>$pname." - No: ".$item['recep_id'],
                    "date"=>date("m/d/Y H:m:i",$item["posted_date"]), 
                    "suburl"=>"register",
                    "id"=>$item["recep_id"]));
                $total++;                
            }
            $tmp["desc_list"] = $desc_list;
            $tmp["url"]= base_url()."index.php?".$this->session->userdata("login_type")."/payment";
            array_push($res,$tmp);
        }
        //get new lab req
        $new_list = $this->db->get_where("lab_request",array("status"=>0))->result_array();
        if (count($new_list)>0){
            $tmp["message"] = "Pending Lab Requests";//.count($new_patient_list);
            $tmp["count"] = count($new_list);
            $desc_list = array();
            foreach($new_list as $item){
                $pid = $item["patient_id"];
                $pname = $this->select_patient_info_by_patient_id($pid)[0]["name"];
                array_push($desc_list, array(
                    "desc"=>$pname." - No: ".$item['id'],
                    "date"=>date("m/d/Y H:m:i",$item["start_time"]),
                    "id"=>$item["id"]));
                $total++;                
            }
            $tmp["desc_list"] = $desc_list;
            $tmp["url"]= base_url()."index.php?".$this->session->userdata("login_type")."/labreq";
            array_push($res,$tmp);
        }
        //get new rad req
        $new_list = $this->db->get_where("rad_request",array("status"=>0))->result_array();
        if (count($new_list)>0){
            $tmp["message"] = "Pending Rad Requests";//.count($new_patient_list);
            $tmp["count"] = count($new_list);
            $desc_list = array();
            foreach($new_list as $item){
                $pid = $item["patient_id"];
                $pname = $this->select_patient_info_by_patient_id($pid)[0]["name"];
                array_push($desc_list, array(
                    "desc"=>$pname." - No: ".$item['id'],
                    "date"=>date("m/d/Y H:m:i",$item["start_time"]),
                    "id"=>$item["id"]));
                $total++;                
            }
            $tmp["desc_list"] = $desc_list;
            $tmp["url"]= base_url()."index.php?".$this->session->userdata("login_type")."/radreq";
            array_push($res,$tmp);
        }
        
        
        //get new pharmarcy req
         $new_list = $this->db->get_where("pharmacy_request",array("status"=>0))->result_array();
        if (count($new_list)>0){
            $tmp["message"] = "Pending Pharm Requests";//.count($new_patient_list);
            $tmp["count"] = count($new_list);
            $desc_list = array();
            foreach($new_list as $item){
                $pid = $item["patient_id"];
                $pname = $this->select_patient_info_by_patient_id($pid)[0]["name"];
                array_push($desc_list, array(
                    "desc"=>$pname." - No: ".$item['id'],
                    "date"=>date("m/d/Y H:m:i",$item["timestamp"]),
                    "id"=>$item["id"]));
                $total++;                
            }
            $tmp["desc_list"] = $desc_list;
            $tmp["url"]= base_url()."index.php?".$this->session->userdata("login_type")."/pharmreq";
            array_push($res,$tmp);
        }
        return array("total_alarms"=>$total,"alarm_list"=>$res);
    }
    // save inpatient diagnosis for admission
    function save_inpatient_admission_diag($id){
        $list = $this->db->get_where("inpatient_admit_info",array("patient_id"=>$id));
        $admit_id = "";
        if ($list->num_rows()>0){
            $admit_id = $list->row()->admission_id;
        }else{
            $this->db->insert("inpatient_admit_info",array("patient_id"=>$id));
            $admit_id = $this->db->insert_id();
        }
        $data["type"] = $this->input->post("type");
        $data["date"] = $this->input->post("date");
        $data["diag_note"] = $this->input->post("diag_note");
        $data["remark_on_discharge"] = $this->input->post("remark_note");
        $data["admission_id"] = $admit_id;
        $this->db->insert("inpatient_admission_diag",$data);
    }
    function update_inpatient_admission_diag($id){

        $list = $this->db->get_where("inpatient_admission_diag",array("diag_id"=>$id));
        $admit_id = $list->row()->admission_id;
        $res = $this->db->get_where("inpatient_admit_info", array("admission_id"=>$admit_id))->row()->patient_id;

        $data["type"] = $this->input->post("type");
        $data["date"] = $this->input->post("date");
        $data["diag_note"] = $this->input->post("diag_note");
        $data["remark_on_discharge"] = $this->input->post("remark_note");
        $this->db->where("diag_id",$id);
        $this->db->update("inpatient_admission_diag",$data);
        return $res;
    }
    function delete_inpatient_admission_diag($id){

        $list = $this->db->get_where("inpatient_admission_diag",array("diag_id"=>$id));
        $admit_id = $list->row()->admission_id;
        $res = $this->db->get_where("inpatient_admit_info", array("admission_id"=>$admit_id))->row()->patient_id;

        $this->db->where("diag_id",$id);
        $this->db->delete("inpatient_admission_diag");
        return $res;
    }
    function update_inpatient_admission_info($id){
        $data["instruct_note"] = $this->input->post("instruction_note");
        $data["diet_note"] = $this->input->post("diet_note");
        $this->db->where("patient_id",$id);
        $this->db->update("inpatient_admit_info",$data);
        return $res;
    }
    function save_inpatient_sup_and_proc($id){
        $now = date("m/d/Y");
        $data["sg"] = $this->input->post("sg");
        $data["cath"] = $this->input->post("cath");
        $data["ub"] = $this->input->post("ub");
        $data["bra"] = $this->input->post("bra");
        $data["fivgs"] = $this->input->post("fivgs");
        $data["bgs"] = $this->input->post("bgs");
        $data["bb"] = $this->input->post("bb");
        $data["ngt"] = $this->input->post("ngt");
        $data["sulf"] = $this->input->post("sulf");
        $data["ivf"] = $this->input->post("ivf");
        $data["dres"] = $this->input->post("dres");
        $data["ros"] = $this->input->post("ros");
        $data["cathz"] = $this->input->post("cathz");
        $data["hb"] = $this->input->post("hb");
        $data["bs"] = $this->input->post("bs");
        $data["phys"] = $this->input->post("phys");
        $data["ot"] = $this->input->post("ot");
        $data["other"] = $this->input->post("other");
        $list = $this->db->get_where("inpatient_sup_proc", array("patient_id"=>$id,
            "date"=>$now));
        if ($list->num_rows()==0){
            $data["patient_id"] = $id;
            $data["date"] =  $now ;
            $this->db->insert("inpatient_sup_proc",$data);
        }else{
            $this->db->where("patient_id",$id);
            $this->db->where("date",$now);
            $this->db->update("inpatient_sup_proc",$data);
        }
    }
    function delete_inpatient_sup_and_proc($id){
        $pid = $this->db->get_where("inpatient_sup_proc",array("id"=>$id))->row()->patient_id;
        $this->db->where("id",$id);
        $this->db->delete("inpatient_sup_proc");
        return $pid;
    }
    function save_inpatient_nursing_cardex($id){
        $time = date("H:m");
        $data["date"] = $this->input->post("date");
        $data["time"] = $this->input->post("time");
        if ($date["time"]=="") $date["time"]=$time;
        $data["note"] = $this->input->post("note");
        $data["doneby_account_type"] = $this->session->userdata('login_type');
        $data["doneby_account_id"] = $this->session->userdata('login_user_id');
        $data["patient_id"]=$id;
        $this->db->insert("inpatient_nursing_cardex",$data);
    }
    function update_inpatient_nursing_cardex($id){
        $time = date("H:m");
        $data["date"] = $this->input->post("date");
        $data["time"] = $this->input->post("time");
        if ($date["time"]=="") $date["time"]=$time;
        $data["note"] = $this->input->post("note");
        $data["doneby_account_type"] = $this->session->userdata('login_type');
        $data["doneby_account_id"] = $this->session->userdata('login_user_id');
        $pid = $this->db->get_where("inpatient_nursing_cardex",array("id"=>$id))->row()->patient_id;
        $this->db->where("id",$id);
        $this->db->update("inpatient_nursing_cardex",$data);
        return $pid;
    }
    function delete_inpatient_nursing_cardex($id){
        $pid = $this->db->get_where("inpatient_nursing_cardex",array("id"=>$id))->row()->patient_id;
        $this->db->where("id",$id);
        $this->db->delete("inpatient_nursing_cardex");
        return $pid;
    }

    function save_inpatient_nursing_care_plan($id){
        $data["date"] = $this->input->post("date");
        $data["assessment"] = $this->input->post("assessment");
        $data["diagnosis"] = $this->input->post("diagnosis");
        $data["goal"] = $this->input->post("goal");
        $data["intervention"] = $this->input->post("intervention");
        $data["evaluation"] = $this->input->post("evaluation");
        $data["doneby_account_type"] = $this->session->userdata('login_type');
        $data["doneby_account_id"] = $this->session->userdata('login_user_id');
        $data["patient_id"]=$id;
        $this->db->insert("inpatient_nursing_care_plan",$data);
    }

    function update_inpatient_nursing_care_plan($id){
        $data["date"] = $this->input->post("date");
        $data["assessment"] = $this->input->post("assessment");
        $data["diagnosis"] = $this->input->post("diagnosis");
        $data["goal"] = $this->input->post("goal");
        $data["intervention"] = $this->input->post("intervention");
        $data["evaluation"] = $this->input->post("evaluation");
        $data["doneby_account_type"] = $this->session->userdata('login_type');
        $data["doneby_account_id"] = $this->session->userdata('login_user_id');
        $this->db->where("id",$id);
        $this->db->update("inpatient_nursing_care_plan",$data);
        $pid = $this->db->get_where("inpatient_nursing_care_plan",array("id"=>$id))->row()->patient_id;
        return $pid;
    }
    function delete_inpatient_nursing_care_plan($id){
        $pid = $this->db->get_where("inpatient_nursing_care_plan",array("id"=>$id))->row()->patient_id;
        $this->db->where("id",$id);
        $this->db->delete("inpatient_nursing_care_plan");
        return $pid;
    }
    function save_inpatient_hourly_temper($id){
        $data["date"] = $this->input->post("date");
        $data["time"] = $this->input->post("time");
        $list = $this->db->get_where("inpatient_measure_4hourly_temp", array(
            "date"=>$data["date"],
            "time"=>$data["time"],
            "patient_id"=>$id
        ));
        if ($list->num_rows()>0){
            $this->update_inpatient_hourly_temper($list->row()->id);
            return;
        }
        $data["temper"] = $this->input->post("temp");
        $data["pulse"] = $this->input->post("pulse");
        $data["resp"] = $this->input->post("resp");
        $data["bowels"] = $this->input->post("bowels");
        $data["urine"] = $this->input->post("urine");
        $data["doneby_account_type"] = $this->session->userdata('login_type');
        $data["doneby_account_id"] = $this->session->userdata('login_user_id');
        $data["patient_id"]=$id;
        $this->db->insert("inpatient_measure_4hourly_temp",$data);
    }

    function update_inpatient_hourly_temper($id){
        $data["date"] = $this->input->post("date");
        $data["time"] = $this->input->post("time");
        $data["temper"] = $this->input->post("temp");
        $data["pulse"] = $this->input->post("pulse");
        $data["resp"] = $this->input->post("resp");
        $data["bowels"] = $this->input->post("bowels");
        $data["urine"] = $this->input->post("urine");
        $data["doneby_account_type"] = $this->session->userdata('login_type');
        $data["doneby_account_id"] = $this->session->userdata('login_user_id');
        $this->db->where("id",$id);
        $this->db->update("inpatient_measure_4hourly_temp",$data);
        $pid = $this->db->get_where("inpatient_measure_4hourly_temp",array("id"=>$id))->row()->patient_id;
        return $pid;
    }
    function delete_inpatient_hourly_temper($id){
        $pid = $this->db->get_where("inpatient_measure_4hourly_temp",array("id"=>$id))->row()->patient_id;
        $this->db->where("id",$id);
        $this->db->delete("inpatient_measure_4hourly_temp");
        return $pid;
    }
    function save_inpatient_blood_press($id){
        $data["date"] = $this->input->post("date");
        $data["time"] = $this->input->post("time");
        $list = $this->db->get_where("inpatient_measure_blood_press", array(
            "date"=>$data["date"],
            "time"=>$data["time"],
            "patient_id"=>$id
        ));
        if ($list->num_rows()>0){
            $this->update_inpatient_blood_press($list->row()->id);
            return;
        }
        $data["bp"] = $this->input->post("bp");
        $data["doneby_account_type"] = $this->session->userdata('login_type');
        $data["doneby_account_id"] = $this->session->userdata('login_user_id');
        $data["patient_id"]=$id;
        $this->db->insert("inpatient_measure_blood_press",$data);
    }

    function update_inpatient_blood_press($id){
        $data["date"] = $this->input->post("date");
        $data["time"] = $this->input->post("time");
        $data["bp"] = $this->input->post("bp");
        $data["doneby_account_type"] = $this->session->userdata('login_type');
        $data["doneby_account_id"] = $this->session->userdata('login_user_id');
        $this->db->where("id",$id);
        $this->db->update("inpatient_measure_blood_press",$data);
        $pid = $this->db->get_where("inpatient_measure_blood_press",array("id"=>$id))->row()->patient_id;
        return $pid;
    }
    function delete_inpatient_blood_press($id){
        $pid = $this->db->get_where("inpatient_measure_blood_press",array("id"=>$id))->row()->patient_id;
        $this->db->where("id",$id);
        $this->db->delete("inpatient_measure_blood_press");
        return $pid;
    }
    function save_inpatient_fluid_balance($id){
        $data["date"] = $this->input->post("date");
        $data["time"] = $this->input->post("time");
        $list = $this->db->get_where("inpatient_fluid_balance", array(
            "date"=>$data["date"],
            "time"=>$data["time"],
            "patient_id"=>$id
        ));
        if ($list->num_rows()>0){
            $this->update_inpatient_fluid_balance($list->row()->id);
            return;
        }
        $data["input_fluid_type"] = $this->input->post("inftype");
        $data["input_fluid_amount"] = $this->input->post("inamount");
        $data["output_fluid_type"] = $this->input->post("outftype");
        $data["output_fluid_amount"] = $this->input->post("outamount");
        $data["comment"] = $this->input->post("comment");
        $data["doneby_account_type"] = $this->session->userdata('login_type');
        $data["doneby_account_id"] = $this->session->userdata('login_user_id');
        $data["patient_id"]=$id;
        $this->db->insert("inpatient_fluid_balance",$data);
    }

    function update_inpatient_fluid_balance($id){
        $data["date"] = $this->input->post("date");
        $data["time"] = $this->input->post("time");
        $data["input_fluid_type"] = $this->input->post("inftype");
        $data["input_fluid_amount"] = $this->input->post("inamount");
        $data["output_fluid_type"] = $this->input->post("outftype");
        $data["output_fluid_amount"] = $this->input->post("outamount");
        $data["comment"] = $this->input->post("comment");
        $data["doneby_account_type"] = $this->session->userdata('login_type');
        $data["doneby_account_id"] = $this->session->userdata('login_user_id');
        $this->db->where("id",$id);
        $this->db->update("inpatient_fluid_balance",$data);
        $pid = $this->db->get_where("inpatient_fluid_balance",array("id"=>$id))->row()->patient_id;
        return $pid;
    }
    function delete_inpatient_fluid_balance($id){
        $pid = $this->db->get_where("inpatient_fluid_balance",array("id"=>$id))->row()->patient_id;
        $this->db->where("id",$id);
        $this->db->delete("inpatient_fluid_balance");
        return $pid;
    }
    function update_inpatient_other_details($id){
        $data["note"] = $this->input->post("note");
        $date["stamp"] = strtotime(date("Y/md/ H:i:s"));
        $data["doneby_account_type"] = $this->session->userdata('login_type');
        $data["doneby_account_id"] = $this->session->userdata('login_user_id');
        $list = $this->db->get_where("inpatient_other_details", array(
            "patient_id"=>$id
        ));
        if ($list->num_rows()==0){
            $data["patient_id"] = $id;
            $this->db->insert("inpatient_other_details",$data);
            return;
        }else{
            $this->db->where("patient_id",$id);
            $this->db->update("inpatient_other_details",$data);
        }
       
    }
    function gen_trial_balance($from="", $to=""){
        $res_trial_bal_list = array();
        $this->db->where("ledgerid !=","601");
        $this->db->order_by("name");
        $ledgers = $this->db->get("ledgers")->result_array();
        $table_gl = "generalledger";
        $temp = array();
     //   if ($from==$to) $to="";
        foreach($ledgers as $item){
            $a=0;$b=0;$c=0;
            $this->db->where("lid ",$item["ledgerid"]);
            $this->db->where("stamp <=",$from);
            $this->db->group_by("lid");
            $a = $this->db->get($table_gl)->row()->balance;
            if ($to!=""){
                $this->db->where("lid ",$item["ledgerid"]);
                $this->db->where("stamp <",$to);
                $this->db->group_by("lid");
                $b = $this->db->get($table_gl)->row()->balance;
            }else $b=0;
            $c = $a-$b;
            array_push($temp, array("lid"=>$item["ledgerid"],"type"=>$item["type"],"bal"=>$c,"name"=>$item["name"]));
        };
        $dr_bal=0;$cr_bal=0;
        foreach($temp as $row){
            $tmp=array();
            $tmp["item"] = $row["name"];
            $type = $row["type"];
            $bal = $row["bal"];
            $tmp["cr"]=$tmp["dr"]="";
            if($type=='Expense'||$type=='Asset'){
                $tmp["dr"]=$bal;
                $dr_bal+=$bal;
            }
            if($type=='Liability'||$type=='Revenue'||$type=='Equity'){
                $cr_bal+=$bal;
                $tmp["cr"]=$bal; 
            }
            array_push($res_trial_bal_list,$tmp);
        }
        return array($res_trial_bal_list,$dr_bal,$cr_bal);
    }
    
    function gen_income_statement_report($from="", $to=""){
        $res_bal_list = array();
        $this->db->where("ledgerid !=","601");
        $this->db->order_by("type","desc");
        $this->db->order_by("name");
        $this->db->order_by("ledgerid");
        $ledgers = $this->db->get("ledgers")->result_array();
        $table_gl = "generalledger";
        $temp = array();
        if ($from==$to) $to="";
        foreach($ledgers as $item){
            $a=0;$b=0;$c=0;
            $this->db->where("lid =",$item["ledgerid"]);
            $this->db->where("stamp <=",$from);
            $this->db->group_by("lid");
            $a = $this->db->get($table_gl)->row()->balance;
            if ($to!=""){
                $this->db->where("lid =",$item["ledgerid"]);
                $this->db->where("stamp <",$to);
                $this->db->group_by("lid");
                $b = $this->db->get($table_gl)->row()->balance;
            }else $b=0;
            $c = $a-$b;
            array_push($temp, array("lid"=>$item["ledgerid"],"type"=>$item["type"],"bal"=>$c,"name"=>$item["name"]));
        };
        $total1=0;$total2=0;
        foreach($temp as $row){
            $tmp=array();
            $tmp["item"] = $row["name"];
            $type = $row["type"];
            $bal = $row["bal"];
            $tmp["kshs1"]=$tmp["kshs2"]="";
            if($type=='Expense'){
                $tmp["kshs1"]=$bal;
                $total1+=$bal;
            }
            if($type=='Revenue'){
                $total2+=$bal;
                $tmp["kshs2"]=$bal; 
            }
            if ($type=="Revenue"||$type=="Expense")
                 array_push($res_bal_list,$tmp);
        }
        return array($res_bal_list,$total2-$total1,"");
    }
     function gen_balance_sheet_report($from, $to){
        $res_bal_list = array();
        $this->db->where("ledgerid !=","601");
        $this->db->order_by("type","desc");
        $this->db->order_by("name");
        $this->db->order_by("ledgerid");
        $ledgers = $this->db->get("ledgers")->result_array();
        $table_gl = "generalledger";
        $temp = array();
        if ($from==$to) $to="";
        foreach($ledgers as $item){
            $a=0;$b=0;$c=0;
            $this->db->where("lid =",$item["ledgerid"]);
            $this->db->where("stamp <=",$from);
            $this->db->group_by("lid");
            $a = $this->db->get($table_gl)->row()->balance;
            if ($to!=""){
                $this->db->where("lid =",$item["ledgerid"]);
                $this->db->where("stamp <",$to);
                $this->db->group_by("lid");
                $b = $this->db->get($table_gl)->row()->balance;
            }else $b=0;
            $c = $a-$b;
            array_push($temp, array("lid"=>$item["ledgerid"],"type"=>$item["type"],"bal"=>$c,"name"=>$item["name"]));
        };

        $exp=$rev=$ass=$ad=$li=$eq=$re=0;
        $asset_bal_list=array();
        $lieq_bal_list=array();
        foreach($temp as $row){
            $tmp=array();
            $tmp["item"] = $row["name"];
            $type = $row["type"];
            $bal = $row["bal"];
            $tmp["kshs"]=0;
            if($type=='Expense'){
//$tmp["kshs1"]=$bal;
                $exp+=$bal;
            }
            if($type=='Revenue'){
                $rev+=$bal;
  //              $tmp["kshs2"]=$bal; 
            }
            if($type=='Asset'){
                $ass+=$bal;
                $tmp["kshs"]=$bal; 
                array_push($asset_bal_list, $tmp);
            }
            if($type=='Liability'){
                $tmp["kshs"]=$bal; 
                array_push($lieq_bal_list, $tmp);
                $li+=$bal;
            }
            if($type=='Equity'){
                $tmp["kshs"]=($row["lid"]=="634")?$rev-$exp:$bal; 
                array_push($lieq_bal_list, $tmp);
                $eq+=$bal;
            }
            if ($row["lid"]=="633")
                $ad = $bal;
            if ($row["lid"]=="650")
                $re = $bal;    

        }
        array_push($asset_bal_list, array("item"=>"Less: Accumulated Depreciation","kshs"=>"(".$ad.")"));
        array_push($lieq_bal_list, array("item"=>"Less: Drawings","kshs"=>"(".$re.")"));
        return array($asset_bal_list,$lieq_bal_list,$ass+$ad,$rev-$exp+$re+$li+$eq);

    }
    function income_analysis_report($from="",$to="",$type="",$option=""){
        $items_list = $this->db->get("items")->result_array();
        $items = array();
        foreach($items_list as $row){
            $temp["itemcode"] = $row["ItemCode"];
            $temp["itemname"] = $row["ItemName"];
            $temp["cost"] = $row["PurchPrice"];
            if ($tmp["cost"]=="")$tmp["cost"]=0;
            $temp["category"] = $row["Category"];
            $temp["vat"] = $row["Vat"];
            if ($tmp["vat"]=="")$tmp["vat"]=0;
            
            $items[(string)$row["ItemCode"]]=$temp;
        }
        $table = "sales";
        $this->db->where("approved_date>=",$from);
        if ($to !="" && $to !=0) $this->db->where("approved_date<=",$to);
        $this->db->where("status !=",0);
        $this->db->where("item_id !=",599);
        $this->db->where("item_id !=",84);
        
        $sales_list = $this->db->get($table)->result_array();
        $total_price=$total_cost=$vat=$discount=0;
        $res =array();
        foreach($sales_list as $row){
            $tmp = array();
            $tmp["trans_date"] = date("m/d/Y", $row["approved_date"]);
            $patient_id = $this->db->get_where("receptions",array("refno"=>$row["recep_id"]))->row()->patient_id;
            $tmp["patient_name"] = $this->select_patient_info_by_patient_id($patient_id)[0]["name"];
            $itemcode =(string)$row['item_id'];
            $tmp["item_name"] = $items[$itemcode]["itemname"];
            $tmp["unit_price"] = $row["unit_price"];
            $tmp["qty"] = $row["qty"];
            $tmp["vat"] = $items[$itemcode]["vat"];
            if ($tmp["vat"]=="")$tmp["vat"]=0;
            $tmp["discount"] = $row["discount"];
            if ($tmp["discount"]=="")$tmp["discount"]=0;
            $tmp["total_sale"] = $row["unit_price"]*$row["qty"] - $tmp["discount"];//vat?
            $tmp["posted"] = date("m/d/Y",$row["posted_date"]);
            $tmp["cashier"] = $this->db->get_where($row["account_type"],array($row["account_type"]."_id"=>$row["cashier_id"]))->row()->name;

            //get department info of cashier
            $this->db->like("emp",$row["account_type"]."-".$row["cashier_id"]);
            $dept = $this->db->get("employee")->row()->dept;
            switch ($type){
                case "today":
                case "all":
                    $total_price+=$tmp["total_sale"];
                    $total_cost+= $items[$itemcode]["cost"];
                    $vat+= $items[$itemcode]["vat"];
                    $discount+=$tmp["discount"];
                    array_push($res,$tmp);
                    break;
                case "wprofit":
                    if ($tmp["total_sale"]>$items[$itemcode]["cost"]){
                        $total_price+=$tmp["total_sale"];
                        $total_cost+= $items[$itemcode]["cost"];
                        $vat+= $items[$itemcode]["vat"];
                        $discount+=$tmp["discount"];
                        array_push($res,$tmp);
                    }
                    break;
                case "wloss":
                    if ($tmp["total_sale"]<$items[$itemcode]["cost"]){
                        $total_price+=$tmp["total_sale"];
                        $total_cost+= $items[$itemcode]["cost"];
                        $vat+= $items[$itemcode]["vat"];
                        $discount+=$tmp["discount"];
                        array_push($res,$tmp);
                    }
                    break;
                case "byitem":
                    if ($itemcode==$option){
                        $total_price+=$tmp["total_sale"];
                        $total_cost+= $items[$itemcode]["cost"];
                        $vat+= $items[$itemcode]["vat"];
                        $discount+=$tmp["discount"];
                        array_push($res,$tmp);
                    }
                    break;
                case "bydepart":
                    if ($dept == $option){
                        $total_price+=$tmp["total_sale"];
                        $total_cost+= $items[$itemcode]["cost"];
                        $vat+= $items[$itemcode]["vat"];
                        $discount+=$tmp["discount"];
                        array_push($res,$tmp);
                    }
                    break;
                case "bypat":
                    if ($patient_id == $option){
                        $total_price+=$tmp["total_sale"];
                        $total_cost+= $items[$itemcode]["cost"];
                        $vat+= $items[$itemcode]["vat"];
                        $discount+=$tmp["discount"];
                        array_push($res,$tmp);
                    }
                    break;
                default:
                    break;
            }
        }
        return array($res,$total_price,$total_cost,$vat,$discount);
    }
    function invoice_report($from="",$to="",$type="",$option=""){
        $table="receipts";
        
        switch($type){
            case "today":
                $from = strtotime(date("m/d/Y"));
                $to = time();
                $where = "(paymode='Companies' OR paymode='Credit')";
                break;
            case "all":
                $where = "(paymode='Companies' OR paymode='Credit')";
                break;
            case "bycomp":
                $where = "(paymode='Companies' OR paymode='Credit')";
                break;
            case "bycash":
                $where = "(paymode='Cash' OR paymode='Bank')";
                break;
            default:
                break;
        }
        $where = "timestamp >='$from' AND timestamp <='$to'"." AND ".$where;
        $this->db->where($where);
        $list = $this->db->get($table)->result_array();
        $res = array(); $cash=$comp=$cre=$bank=0;
        foreach($list as $item){
            $tmp["date"] = date("m/d/Y", $item["timestamp"]);
            $tmp["patient_id"] = $item["patient_id"];
            $tmp["patient_name"] = $this->select_patient_info_by_patient_id($tmp["patient_id"])[0]["name"];
            $tmp["pay_mode"] = $item["paymode"];
            $tmp["company"] = $this->db->get_where("creditcustomers",array('CustomerId'=>$item["company_id"]))->row()->CustomerName;
            $tmp["inv_No"] = $item["invno"];
            $tmp["amount"] = $item["amount"];
            $tmp["time"] = date("H:i:s", $item["timestamp"]);
            if($item["paymode"]=="Cash") $cash+=$item["amount"];
            if($item["paymode"]=="Companies") $comp+=$item["amount"];
            if($item["paymode"]=="Credit") $cre+=$item["amount"];
            if($item["paymode"]=="Bank") $bank+=$item["amount"];
            array_push($res,$tmp);
        }
        return array($res,$cash,$comp,$cre,$bank);
    }
    function good_received_report($from="",$to="",$type="",$option=""){
        $this->db->where("Type","GOOD");
        $items_list = $this->db->get("items")->result_array();
        $items = array();
        foreach($items_list as $row){
            $temp["itemcode"] = $row["ItemCode"];
            $temp["itemname"] = $row["ItemName"];
            $items[(string)$row["ItemCode"]]=$temp;
        }
        $table = "purchases";
        $this->db->where("Stamp>=",$from);
        if ($to !="" && $to !=0) $this->db->where("Stamp<=",$to);
        switch ($type){
            case "all":
                break;
            case "byitem":
                $this->db->where("ItemCode",$option);
                break;
            case "bysup":
                $this->db->where("SupplierId",$option);
                break;
            default:
                break;
        }
        $list = $this->db->get($table)->result_array();
        $total_cost=0;
        $res =array();
        foreach($list as $row){
            $tmp = array();
            $tmp["trans_date"] = date("m/d/Y", $row["Stamp"]);
            $tmp["grnno"] = $row["PurchNo"];
            $tmp["supplier"] = $this->db->get_where("creditsuppliers",array('CustomerId'=>$row["SupplierId"]))->row()->CustomerName;
            $itemcode =(string)$row['ItemCode'];
            $tmp["item_name"] = $items[$itemcode]["itemname"];
            $tmp["unit"] = $row["UnitBox"];
            $tmp["part"] = $row["PartBox"];
            $tmp["price"] = $row["PurchPrice"];
            $tmp["total"] = $row["TotalPrice"];
            $total_cost +=$row["TotalPrice"];
            array_push($res,$tmp);
        }
        return array($res,$total_cost);
    }
    function good_returned_report($from="",$to="",$type="",$option=""){
        $items_list = $this->db->get("items")->result_array();
        $items = array();
        foreach($items_list as $row){
            $temp["itemcode"] = $row["ItemCode"];
            $temp["itemname"] = $row["ItemName"];
            $items[(string)$row["ItemCode"]]=$temp;
        }
        $table = "goodsreturned";
        $this->db->where("stamp>=",$from);
        if ($to !="" && $to !=0) $this->db->where("stamp<=",$to);
        switch ($type){
            case "all":
                break;
            case "byitem":
                $this->db->where("code",$option);
                break;
            case "bysup":
                $this->db->where("sid",$option);
                break;
            default:
                break;
        }
        $list = $this->db->get($table)->result_array();
        $total_cost=0;
        $res =array();
        foreach($list as $row){
            $tmp = array();
            $tmp["trans_date"] = date("m/d/Y", $row["stamp"]);
            $tmp["grnno"] = $row["gnrno"];
            $tmp["supplier"] = $this->db->get_where("creditsuppliers",array('CustomerId'=>$row["sid"]))->row()->CustomerName;
            $itemcode =(string)$row['code'];
            $tmp["item_name"] = $items[$itemcode]["itemname"];
            $tmp["unit"] = $row["unit"];
            $tmp["part"] = $row["part"];
            $tmp["price"] = $row["pprice"];
            $tmp["total"] = $row["total"];
            $total_cost +=$tmp["total"];
            array_push($res,$tmp);
        }
        return array($res,$total_cost);
    }
    function reprint_grn_received_report($refno){
        $this->db->where("Type","GOOD");
        $items_list = $this->db->get("items")->result_array();
        $items = array();
        foreach($items_list as $row){
            $temp["itemcode"] = $row["ItemCode"];
            $temp["itemname"] = $row["ItemName"];
            $temp["pack"] = $row["Pack"];
            $temp["saleprice"] = $row["SalePrice"];
            $items[(string)$row["ItemCode"]]=$temp;
        }

        $this->db->where("PurchNo",$refno);
        $table = "purchases";
        $list=$this->db->get($table)->result_array();
        $total=0;$supplier=$invno="";
        $res = array();
        $supplier = $this->db->get_where("creditsuppliers",array('CustomerId'=>$list[0]["SupplierId"]))->row()->CustomerName;
        $invno = $list[0]["InvoiceNo"];
        foreach($list as $row){
            $itemcode =(string)$row['ItemCode'];
            $tmp["item_name"] = $items[$itemcode]["itemname"];
            $tmp["pack"] = $items[$itemcode]["pack"];
            $tmp["batchno"] = $row["BatchNo"];
            $tmp["expiry"] = $row["Expiry"];
            $tmp["unit"] = $row["UnitBox"];
            $tmp["part"] = $row["PartBox"];
            $tmp["pprice"] = $row["PurchPrice"];
            $tmp["sprice"] = $items[$itemcode]["saleprice"];
            $tmp["total"] = $row["TotalPrice"];
            if ( $tmp["total"]=="")  $tmp["total"]=0;
            $total += $tmp["total"];
            array_push($res,$tmp);
        }
        return array($res,$total,$supplier,$invno);
    }
    function reprint_grn_returned_report($refno){
        $this->db->where("Type","GOOD");
        $items_list = $this->db->get("items")->result_array();
        $items = array();
        foreach($items_list as $row){
            $temp["itemcode"] = $row["ItemCode"];
            $temp["itemname"] = $row["ItemName"];
            $temp["pack"] = $row["Pack"];
            $temp["saleprice"] = $row["SalePrice"];
            $items[(string)$row["ItemCode"]]=$temp;
        }

        $this->db->where("gnrno",$refno);
        $table = "goodsreturned";
        $list=$this->db->get($table)->result_array();
        $total=0;$supplier=$invno="";
        $res = array();
        $supplier = $this->db->get_where("creditsuppliers",array('CustomerId'=>$list[0]["sid"]))->row()->CustomerName;
        $invno = $list[0]["invoice"];
        foreach($list as $row){
            $itemcode =(string)$row['code'];
            $tmp["item_name"] = $items[$itemcode]["itemname"];
            $tmp["pack"] = $items[$itemcode]["pack"];
            $tmp["batchno"] = $row["batch"];
            $tmp["unit"] = $row["unit"];
            $tmp["part"] = $row["part"];
            $tmp["pprice"] = $row["pprice"];
            $tmp["total"] = $row["total"];
            if ( $tmp["total"]=="")  $tmp["total"]=0;
            $total += $tmp["total"];
            array_push($res,$tmp);
        }
        return array($res,$total,$supplier,$invno);
    }

    function get_upload_rad_images($pateint_id,$reqid){
        $res=array();
        $upload_image_path="uploads/radiology_image/$pateint_id/$reqid/";
        $res = directory_map($upload_image_path);
        return $res;
    }
    function get_data_for_income_expense_chart(){
        $time = time();
        $now_year = date("Y",$time);
        $now_month = date("m",$time);
        $m1 =$y1=0;
        $m1=$now_month+1; $y1=$now_year-1;
        $res=array();
        $this->db->where("ledgerid !=","601");
        $this->db->order_by("name");
        $ledgers = $this->db->get("ledgers")->result_array();
        $table_gl = "generalledger";
        for ($i=0;$i<=12;$i++){
            $m1++;
            If ($m1>12) {$m1=1; $y1++;};
            $from =strtotime($y1."-".$m1."-1");
            $to =strtotime($y1."-".$m1."-31");
            $a=0;
            $temp = array();
            foreach($ledgers as $item){
                $a=0;$b=0;$c=0;
                $this->db->where("lid ",$item["ledgerid"]);
                $this->db->where("stamp>=".$from);
                $this->db->where("stamp<=".$to);
                $this->db->group_by("lid");
                $a = $this->db->get($table_gl)->row()->balance;
                array_push($temp, array("lid"=>$item["ledgerid"],"type"=>$item["type"],"bal"=>$a,"name"=>$item["name"]));
            };
            $dr_bal=0;$cr_bal=0;
            foreach($temp as $row){
                $tmp=array();
                $type = $row["type"];
                $bal = $row["bal"];
                if($type=='Expense'||$type=='Asset'){
                    $dr_bal+=$bal;
                }
                if($type=='Liability'||$type=='Revenue'||$type=='Equity'){
                    $cr_bal+=$bal;
                }
            }
            $tmp["month"] = $y1.".".$m1; 
            $tmp["expenses"] = $dr_bal;
            $tmp["income"] = $cr_bal;
            array_push($res,$tmp);
        }
        return json_encode($res);
    }

    function get_data_for_patient_chart(){  
        $time = time();
        $now_year = date("Y",$time);
        $now_month = date("m",$time);
        $m1 =$y1=0;
        $m1=$now_month+1; $y1=$now_year-1;
        $res=array();
        for ($i=0;$i<=12;$i++){
            $m1++;
            If ($m1>12) {$m1=1; $y1++;};
            $from =strtotime($y1."-".$m1."-1");
            $to =strtotime($y1."-".$m1."-31");
            $this->db->where("visit_date >=",$from);
            $this->db->where("visit_date <=",$to);
            $val = $this->db->get("visitor_log")->result_array();
            $tmp["newpatients"] = 0;
            $tmp["revisits"] = 0;
            $tmp["reviews"] = 0;
            foreach($val as $item){
                if ($item["type"]==0) $tmp["newpatients"]++;
                if ($item["type"]==1) $tmp["revisits"]++;
                if ($item["type"]==2) $tmp["reviews"]++;
            }
            $tmp["month"] = $y1.".".$m1; 
            
            array_push($res,$tmp);
        }
        return json_encode($res);
    }
    function save_todo_item(){
        $name = $this->input->post("title");
        if($name=="") return;
        $this->db->insert("todo_list",array(
            "todo_name"=>$name,
            "date"=>time(),
            "status"=>0
        ));
        $id = $this->db->insert_id();
        $this->db->where("id",$id);
        $this->db->update("todo_list",array("todo_order"=>$id));
    }
    function todo_mark_as_done($id,$val){
        $this->db->where("id",$id);
        $this->db->update("todo_list",array("status"=>$val));
    }
    function todo_delete_item($id){
        $this->db->where("id",$id);
        $this->db->delete("todo_list");
    }
    function get_todo_unmarked_count(){
        $this->db->where("status",0);
        $cn = $this->db->get("todo_list")->num_rows();
        return $cn;
    }
    function todo_swap_item($id,$swap_with){
        $this->db->order_by("todo_order","ASC");
        $list = $this->db->get("todo_list")->result_array();
        $order_num=0;
        foreach ($list as $item){
            if($item["id"]==$id) break;
            $order_num++;
        }
        if ($swap_with=="up" && $order_num==0) return;
        if ($swap_with=="down" && $order_num==(count($list)-1)) return;
        $chid = $list[$order_num-1]["id"];
        $chorder = $list[$order_num-1]["todo_order"];
        if ($swap_with=="down"){
            $chid = $list[$order_num+1]["id"];
            $chorder = $list[$order_num+1]["todo_order"];
        }
        $nowid = $list[$order_num]["id"];
        $noworder = $list[$order_num]["todo_order"];
        $this->db->where("id",$chid);
        $this->db->update("todo_list",array("todo_order"=>$noworder));
        $this->db->where("id",$nowid);
        $this->db->update("todo_list",array("todo_order"=>$chorder));
    }
}



























