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
        $data['username'] 		= $this->input->post('username');
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
        $data["registered_date"] = strtotime(date("m/d/y H:i:s"));
        $this->db->insert('patient',$data);
        
        $patient_id  =   $this->db->insert_id();
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/patient_image/" . $patient_id . '.jpg');
        return $patient_id;
    }
    
    function select_patient_info()
    {
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
        $data['username'] 		= $this->input->post('username');
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
    
    function update_accountant_info($accountant_id)
    {
        $data['name'] 		= $this->input->post('name');
        $data['email'] 		= $this->input->post('email');
        $data['address'] 	= $this->input->post('address');
        $data['phone']          = $this->input->post('phone');
        
        $this->db->where('accountant_id',$accountant_id);
        $this->db->update('accountant',$data);
        
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/accountant_image/" . $accountant_id . '.jpg');
    }
    
    function delete_accountant_info($accountant_id)
    {
        $this->db->where('accountant_id',$accountant_id);
        $this->db->delete('accountant');
    }
    
    function save_receptionist_info()
    {
        $data['name'] 		= $this->input->post('name');
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
    function save_reception_info($reception_id, $patient_id){
        $data["recept_date"] =  strtotime(date("Y-m-d H:i:s"));
        $data["account_type"] = $this->session->userdata('login_type');
        $data["patient_id"] = $patient_id;
        $data["receptionist_id"] = $this->session->userdata('login_user_id');
        $refno = "";
        if (strlen($reception_id)==0){
            $this->db->insert('receptions',$data);
            $refno = $this->db->insert_id();
        }else
            $this->db->update('receptions',$data,array("refno"=>$reception_id));
        // update last visit date on patient.
        $data1['last_visited_date'] = strtotime(date("Y-m-d"));
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
    function insert_bill_info_for_sales($reception_id, $carts){
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
            $b&=$this->db->insert('sales',$data);
        }
       
        
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
    function select_carts_info($reception_id){
        $carts = $this->db->get_where('sales', array("recep_id"=>$reception_id))->result_array();
        $res = array();
        foreach ($carts as $item){
            $temp=array();
            $temp["itemname"] = $this->select_item_name($item["item_id"]);
            $temp["quantity"] = $item["qty"];
            $temp["unit_price"] = $item["unit_price"];
            $temp["discount"] = $item["discount"];
            $temp["income"] = $this->select_incomename_from_extmedics($item["iid"]);
            array_push($res,$temp);
        }
        return $res;
    }
   // get payment information from sales
    
    function select_payment_info($reception_id){
        $carts = $this->db->get_where('sales', array("recep_id"=>$reception_id,"status"=>"1"))->result_array();
        $res = array();
        foreach ($carts as $item){
            $temp=array();
            $temp["itemname"] = $this->select_item_name($item["item_id"]);
            $temp["transid"] = $item["trans_id"];
            array_push($res,$temp);
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
        $data["sentto_account_type"] =$params["sentto_account_type"];
        $data["sentto_account_id"] = $params["sentto_account_id"];
        $data["patient_id"] = $params["patient_id"];
        $data["patient_type"] = $params["patient_type"];
        $data["recept_id"] = $params["recept_id"];
        $b = $this->db->insert('sendpatients',$data);
        $data1["status"] = 2;
        $this->db->where('trans_id', $params["trans_id"]);
        $b &= $this->db->update('sales', $data1);
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
            $tmp["sent_date"] = date("Y-m-d H:i:s",$item["posted_date"]);
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
         $arr = $this->db->get_where($table,array("cons_id"=>$data["cons_id"]))->result_array();
         if (count($arr)==0){
            $b&=$this->db->insert($table,$data);
            $req_id = $this->insert_id();
         }else{
            $this->db->where("id",$arr[0]["id"]);
            $b&=$this->db->update($table,$data);
            $req_id = $arr[0]["id"];
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
         for ($i=0;$i<count($params["req_list"]);$i++){
             $val = $params["req_list"][$i];
            if (count($val)>0){
                $arr = $this->db->get_where($table,array("cons_id"=>$data["cons_id"],
                "itemcode"=>$val))->result_array();
                $data["itemcode"]=$val;
                if (count($arr)==0){
                    $this->db->insert($table,$data);
                }/*else{
                    $this->db->where("id",$arr[0]["id"]);
                    $this->db->update($table,$data);
                };*/
            }
            
         }
         
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
                }/*else{
                    $this->db->where("id",$arr[0]["id"]);
                    $this->db->update($table,$data);
                };*/
            }
            
         }
         
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
    // paymetn process
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
        foreach($params["carts"] as $cart){
            //insert into receipts table
            $tmp = array();
            $tmp["timestamp"]=date("d/m/y H:i:s");
            $pid = $tmp["patient_id"] = $params["patient_id"];
            $recepid = $tmp["recept_id"]=$params["recept_id"];
            $mode = $tmp["paymode"] =$cart["mode"];
            $amount = $tmp["amount"] = $cart["amount"];
            $acid = $tmp["company_id"] = $cart["acid"];
            $cardno = $tmp["cardno"] = $cart["refno"];
            $login_type = $tmp['receiver_account_type'] = $this->session->userdata('login_type');
            $login_id = $tmp['receiver_account_id'] = $this->session->userdata('login_user_id');
            $now = strtotime(date("Y/m/d H:i:s"));
            $b &= $this->db->insert($tables["receipt"],$tmp);
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
                $tmp["Description"] = "Hospital charges on ".date("Y/m/d");
                $tmp["date"] =date("Y/m/d");
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
                $tmp["stamp"] = strtotime(date("Y/m/d H:i:s"));
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
        // final process, we have to change status of sales table.
        $tmp = array();
        $tmp["status"] = 1;// will go complete paid status , value is 1
        $tmp["approved_date"] = $now;
        $tmp["account_type"] = $login_type;
        $tmp["cashier_id"] = $login_id;
        $this->db->where("recep_id",$recepid);
        $this->db->update("sales",$tmp);
        
        
        //UPDATE DATABASE -REDUCTION OF STOCK ITEMS
        //reduce stock
        $sales_info = $this->db->get_where($tables["sales"],array("recep_id"=>$recepid))->result_array();
        foreach($sales_info as $row){
            $qty = $row["qty"];
            $item_id = $row["item_id"];
            $item_info = $this->db->get_where("items",array("ItemCode"=>$item_id))->result_array();
            $total_price = $qty*$row["unit_price"]-$row["discount"];
            //update lab table,radiology table,pharmacy table,theatre table.
            $this->db->where("recept_id",$recepid);
            $this->db->where("itemcode",$item_id);
            $b &=$this->db->update($tables["lab_req"],array("status"=>1));// it means paid status
            $this->db->where("recept_id",$recepid);
            $this->db->where("itemcode",$item_id);
            $b &=$this->db->update($tables["rad_req"],array("status"=>1));
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
            if ($row["status"]==1) $tmp["status"] = "Process";
            if ($row["status"]==2) $tmp["status"] = "Completed";
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
            $b&=$this->db->update("lab_request",array("status"=>2,"end_time"=>strtotime($date)));
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
            if ($row["status"]==1) $tmp["status"] = "Process";
            if ($row["status"]==2) $tmp["status"] = "Completed";
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
        $data["status"] =2;
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
        $crtype = $rowdr->type;
        $crbal = $rowdr->bal;
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
}



























