<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modal extends CI_Controller {

	
	function __construct()
    {
        parent::__construct();
		$this->load->database();
        $this->load->library('session');
		/*cache control*/
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2017 05:00:00 GMT"); 
    }
	
	/***default functin, redirects to login page if no admin logged in yet***/
	public function index()
	{
		
	}
	
	
	/*
	*	$page_name		=	The name of page
	*/
	function popup($page_name = '' , $param2 = '' , $param3 = '')
	{
		$account_type                   =	$this->session->userdata('login_type');
		$page_data['param2']		=	$param2;
		$page_data['param3']		=	$param3;
		$this->load->view( 'backend/'.$account_type.'/'.$page_name.'.php' ,$page_data);
		
	//	echo '<script src="assets/js/neon-custom-ajax.js"></script>';
    //            echo '<script>$(".html5editor").wysihtml5();</script>';
	}
	/*
	* get patient info by json encode
	*/
	function getpatientinfo($patient_id){
		$data = $this->crud_model->select_patient_info_by_patient_id($patient_id);
		$res = array();
		foreach($data as $item){
			$temp = $item;
			$temp["birth_date"] = date('d/m/Y', $item['birth_date']);
			$temp["last_visited_date"] = date('Y-m-d', $item['last_visited_date']);
			$temp["image_url"] = $this->crud_model->get_image_url('patient' , $item['patient_id']);
			if (strlen($item["insurerid"])>0)
				$temp["insur"] = $this->crud_model->select_insurer_info($item["insurerid"]);
			array_push($res,$temp);
		}

		echo json_encode($res);
	}
	/*
	 * save billing information
	*/
	
	function savebillinginformation($patient_id)
	{
		$params = array("pt","bn","exid","fdid");
		$fields = array("paytype","benamount","exid","forwardid");
		$data = array();
		for($i=0; $i<count($params); $i++){
			$data[$fields[$i]] = isset($_POST[$param[$i]])?$_POST[$param[$i]]:"";
		};
		$this->crud_model->update_patient_info_for_billing($patient_id,$data);
		echo "success";
	}
	/*
	* save reception info
	*/
	function savereception($reception_id=""){
		$patient_id = $_POST["patient_id"];
		echo json_encode($this->crud_model->save_reception_info($reception_id,$patient_id));
	}
	/*
	* submit bill
	*/
	function submitbill(){
		$billtype = $_POST["type"];
		$reception_id = $_POST["recepId"];
		$billdata = $_POST["carts"];
		$reqid=$this->input->post("reqid");
		echo ($this->crud_model->insert_bill_info_for_sales($reception_id,$billdata,$billtype,$reqid))?"success":"failure";
	}
	/*
	* get payment reception
	*/
	function getpaymentforcons($reception_id){
		echo json_encode($this->crud_model->select_payment_info($reception_id,"CONSULTATION"));
	}
	/*
	* send patient to branch (triage, consultation,...)
	*/
	function sendtobranch(){
		$data['trans_id'] =  $_POST['paymentId'];
        $data['sendto'] = $_POST['type'];
  //      $data["sentto_account_type"] =$_POST["sentto_account_type"];
  //      $data["sentto_account_id"] = $_POST["sentto_account_id"];
		$data["patient_id"] = $_POST["patientId"];
		$data["patient_type"] = $_POST["patient_type"];
		$data["recept_id"] =$_POST["recept_id"];
		$this->crud_model->send_patient_to_branch($data);
		echo "success";
	}
	/*
	* save patient triage 
	*/
	function savetriagedata(){
		//$data['trans_id'] =  $_POST['paymentId'];
        $data['queue_id'] = $_POST['queue_id'];
        $data["patient_id"] =$_POST["patient_id"];
        $data["temp"] = $_POST["temp"];
		$data["bp1"] = $_POST["bph"];
		$data["bp2"] = $_POST["bpl"];
		$data["weight"] = $_POST["weight"];
		$data["resprate"] = $_POST["resprate"];
		$data["rbs"] = $_POST["rbs"];
		$data["pulserate"] = $_POST["pulserate"];
		$data["allergies"] = $_POST["allergies"];
		$data["other_details"] = $_POST["otherdetails"];
		$this->crud_model->save_triage_for_patient($data);
		echo "success";
	}
	/*
	* save patient consultation 
	*/
	function saveconsultation(){
		$data["recept_id"] = $_POST['recept_id'];
		$data["queue_id"] = $_POST['queue_id'];
		$data["patient_id"] = $_POST['patient_id'];
		echo json_encode($this->crud_model->save_consult_for_patient($data));
	}
	/*
	* save current hisotry for patient consultation 
	*/
	function savecurrenthistory(){
//		$data["recept_id"] = $_POST['recept_id'];
		$data["cons_id"] = $_POST['cons_id'];
//		$data["patient_id"] = $_POST['patient_id'];
		$data["content"] = $_POST['content'];
		$this->crud_model->save_cur_history_for_patient($data);
		echo "success"; 
	}
	/*
	* save Physical examination for patient consultation 
	*/
	function savephysicalexam(){
//		$data["recept_id"] = $_POST['recept_id'];
		$data["cons_id"] = $_POST['cons_id'];
//		$data["patient_id"] = $_POST['patient_id'];
		$data["content"] = $_POST['content'];
		$this->crud_model->save_physical_exam_for_patient($data);
		echo "success"; 
	}
	function savediagnosishistory(){
//		$data["recept_id"] = $_POST['recept_id'];
		$data["cons_id"] = $_POST['cons_id'];
//		$data["patient_id"] = $_POST['patient_id'];
		$data["content"] = $_POST['content'];
		$data["diag_items"] = $_POST['diag_summaies'];
		$this->crud_model->save_diag_history_for_patient($data);
		echo "success"; 
	}
	function savepharmacy(){
		$data["recept_id"] = $_POST['recept_id'];
		$data["cons_id"] = $_POST['cons_id'];
		$data["patient_id"] = $_POST['patient_id'];
	//	$data["medications"] = $_POST['presc_list'];
		$data["status"] =  0;
		echo $this->crud_model->save_pharmacy_request_for_patient($data,$_POST['presc_list']);
	}
	function savelaboratory(){
		$data["recept_id"] = $_POST['recept_id'];
		$data["cons_id"] = $_POST['cons_id'];
		$data["patient_id"] = $_POST['patient_id'];
		$data["req_list"] = explode(",",$_POST['req_list']);
		if (isset($_POST["status"])) $data["status"] =  $_POST['status'];
		$this->crud_model->save_lab_request_for_patient($data);
		echo "success"; 
	}
	function saveradiology(){
		$data["recept_id"] = $_POST['recept_id'];
		$data["cons_id"] = $_POST['cons_id'];
		$data["patient_id"] = $_POST['patient_id'];
		$data["req_list"] = explode(",",$_POST['req_list']);
		if (isset($_POST["status"])) $data["status"] =  $_POST['status'];
		$this->crud_model->save_rad_request_for_patient($data);
		echo "success"; 
	}
	function submitpayment(){
		$data["patient_id"]= $_POST["patient_id"];
		$data["recept_id"] = $_POST["recept_id"];
		$data["credit_status"] = $_POST["creditstatus"];
		$data["carts"] = $_POST["carts"];
		$data["bal"] = $_POST["bal"];
		echo $this->crud_model->submit_payment_for_patient($data);
	}
	function savelabreception($param){
		$data["req_id"]=$param;
		$data["patient_id"]=$_POST["patient_id"];
		$data["recept_id"] = $_POST["recept_id"];
		$data["sample_id"]=$_POST["sample_id"];
		$data["sample_cond"]=$_POST["sample_condition"];
		$data["reject_accept_status"]=$_POST["ra_status"];
		$data["source"]=$_POST["source"];
		$data["other_details"]=$_POST["other_details"];
		$data["result"]=$_POST["result"];
		echo $this->crud_model->save_lab_recept_for_patient($data);
	}
	function saveradresult($param){
//		$data["patient_id"]=$_POST["patient_id"];
//		$data["recept_id"] = $_POST["recept_id"];
		$data["rad_result"]=$_POST["result"];
		echo $this->crud_model->save_rad_result_for_patient($data,$param);
	}
	function reversejournalentry($trans_id){
		if ($this->session->userdata('admin_login') != 1 &&
			$this->session->userdata('accountant_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh'); return;
        };
		echo $this->crud_model->reverse_journal_entry($trans_id);
	}
	//get customer debtor information
	function getdebtorinvoice($cusid){
		//echo $cusid;
		echo json_encode($this->crud_model->get_customer_debtor_info($cusid));
	}
	function getcreditorinvoice($cusid){
		echo json_encode($this->crud_model->get_customer_creditor_info($cusid));
	}
	// make payment for creditor suppliers
	function makepaymentforcr($cusid,$lid){
		if ($this->session->userdata('admin_login') != 1 &&
			$this->session->userdata('accountant_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh'); return;
        };
		echo $this->crud_model->make_payment_for_creditor($cusid,$lid);
	}
	// receive payment for debtor suppliers
	function recievepaymentfordr($cusid,$lid){
		if ($this->session->userdata('admin_login') != 1 &&
			$this->session->userdata('accountant_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh'); return;
        };
		echo $this->crud_model->receive_payment_for_debtor($cusid,$lid);
	}
	// receive payment for debtor suppliers
	function getreceiptsinvoice($invno){
		echo json_encode($this->crud_model->get_invoices_for_receipts_by_pid($invno));
	}
	/*
	* get subcategory for items
	*/
	function getsubcategory($cat){
		echo json_encode($this->crud_model->select_sub_category_by_category($cat));
	}

	
}

