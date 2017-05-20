<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    function index() {
    }
    function trial_bal_report($task = "",$fromdate="",$todate="",$as_at="") {
        $now =strtotime(date("m/d/Y"));
        $as_at_date = $from_date = $to_date=0;
        if ($task=="print_view"){
            $from_date =$fromdate;
            if ($from_date =="") $from_date = strtotime($from_date);
            $to_date = $todate;
            $as_at_date = $as_at;
        }else{
            $msg="Trial Balance was generated successfully.";
            $from=$this->input->post("from");
            $to=$this->input->post("to");
            $as_at = $this->input->post("as_at");
            if ($from=="" && $to=="" && $as_at==""){$as_at=date("m/d/Y");}
            if ($as_at!=""){
                $from="";$to="";
                $as_at_date = strtotime($as_at);
            }else{
                if($to=="") $to=date("m/d/Y");
                if($from=="") $from=date("m/d/Y");
                $from_date = strtotime($from);
                $to_date = strtotime($to);
            }
             
        }
        $data=array();
        if ($to_date>$now) {$to_date = $now; $to=date("m/d/Y"); }
        if ($from_date>$now){ $from_date = $now;$from=date("m/d/Y");}
        if ($from_date>$to_date) $from_date = $to_date;
        if ($as_at_date !=0 ) {$from_date=$as_at_date; $to_date = "";}
        $res = $this->crud_model->gen_trial_balance($from_date, $to_date);
        $data["trial_bal_list"] = $res[0];
        $data["total_dr"]=$res[1];
        $data["total_cr"]=$res[2];
        $data["from"] = ($as_at!="")?"":date("m/d/Y",$from_date);
        $data["to"] = ($as_at!="")?"":date("m/d/Y",$to_date);
        $data["as_at"] = ($as_at!="")?date("m/d/Y",$as_at_date):"";
        $data['page_title'] = get_phrase('trial_balance_report');
        if ($task=="print_view"){
            $data['page_name'] = 'trial_balance_report';
            $this->load->view('backend/reports',$data);
        }else{
            $this->session->set_flashdata('message', $msg);
            $data['page_name'] = 'trial_report';
            $this->load->view('backend/index', $data);
        }
        
    }
    function income_statement_report($task = "",$fromdate="",$todate="",$as_at="") {
       
        $now =strtotime(date("m/d/Y"));
        $as_at_date = $from_date = $to_date=0;
        if ($task=="print_view"){
            $from_date =$fromdate;
            if ($from_date =="") $from_date = strtotime($from_date);
            $to_date = $todate;
            $as_at_date = $as_at;
        }else{
            $msg="Income Statement was generated successfully.";
            $from=$this->input->post("from");
            $to=$this->input->post("to");
            $as_at = $this->input->post("as_at");
            if ($from=="" && $to=="" && $as_at==""){$as_at=date("m/d/Y");}
            if ($as_at!=""){
                $from="";$to="";
                $as_at_date = strtotime($as_at);
            }else{
                if($to=="") $to=date("m/d/Y");
                if($from=="") $from=date("m/d/Y");
                $from_date = strtotime($from);
                $to_date = strtotime($to);
            }
             
        }
        $data=array();
        if ($to_date>$now) {$to_date = $now; $to=date("m/d/Y"); }
        if ($from_date>$now){ $from_date = $now;$from=date("m/d/Y");}
        if ($from_date>$to_date) $from_date = $to_date;
        if ($as_at_date !=0 ) {$from_date=$as_at_date; $to_date = "";}
        $res = $this->crud_model->gen_income_statement_report($from_date,$to_date);
        $data["income_state_list"] = $res[0];
        $data["total1"]=$res[1];
        $data["total2"]=$res[2];
        $data["from"] = ($as_at!="")?"":date("m/d/Y",$from_date);
        $data["to"] = ($as_at!="")?"":date("m/d/Y",$to_date);
        $data["as_at"] = ($as_at!="")?date("m/d/Y",$as_at_date):"";

        $data['page_name'] = 'income_statement_report';
        $data['page_title'] = get_phrase('income_statement_report');
        if ($task=="print_view"){
            $this->load->view('backend/reports',$data);
        }else{
            $this->session->set_flashdata('message', $msg);
            $this->load->view('backend/index', $data);
        }
     }
     
     function balance_sheet_report($task = "",$fromdate="",$todate="",$as_at="") {
        $now =strtotime(date("m/d/Y"));
        $as_at_date = $from_date = $to_date=0;
        if ($task=="print_view"){
            $from_date =$fromdate;
            if ($from_date =="") $from_date = strtotime($from_date);
            $to_date = $todate;
            $as_at_date = $as_at;
        }else{
            $msg="Balance Sheet was generated successfully.";
            $from=$this->input->post("from");
            $to=$this->input->post("to");
            $as_at = $this->input->post("as_at");
            if ($from=="" && $to=="" && $as_at==""){$as_at=date("m/d/Y");}
            if ($as_at!=""){
                $from="";$to="";
                $as_at_date = strtotime($as_at);
            }else{
                if($to=="") $to=date("m/d/Y");
                if($from=="") $from=date("m/d/Y");
                $from_date = strtotime($from);
                $to_date = strtotime($to);
            }
             
        }
        $data=array();
        if ($to_date>$now) {$to_date = $now; $to=date("m/d/Y"); }
        if ($from_date>$now){ $from_date = $now;$from=date("m/d/Y");}
        if ($from_date>$to_date) $from_date = $to_date;
        if ($as_at_date !=0 ) {$from_date=$as_at_date; $to_date = "";}
        $res = $this->crud_model->gen_balance_sheet_report($from_date,$to_date);
        $data["asset_bal_list"] = $res[0];
        $data["lieq_bal_list"] = $res[1];
        $data["total1"]=$res[2];
        $data["total2"]=$res[3];
        $data["from"] = ($as_at!="")?"":date("m/d/Y",$from_date);
        $data["to"] = ($as_at!="")?"":date("m/d/Y",$to_date);
        $data["as_at"] = ($as_at!="")?date("m/d/Y",$as_at_date):"";

        $data['page_name'] = 'balance_sheet_report';
        $data['page_title'] = get_phrase('balance_sheet_report');
        if ($task=="print_view"){
            $this->load->view('backend/reports',$data);
        }else{
            $this->session->set_flashdata('message', $msg);
            $this->load->view('backend/index', $data);
        }
    }

    function income_report($task="",$req_type="",$fromdate="",$todate="",$req_options=""){
        $now =strtotime(date("m/d/Y"));
        $as_at_date = $from_date = $to_date=0;
        $options = "";
        if ($task=="print_view"){
            $from_date =$fromdate;
            $to_date= $todate;
            $type = $req_type;
            $options = $req_options;
        }else{
            if ($task!=""){
                $type=$task;
            } 
            else{
                $msg="Income Report was generated successfully.";
                $type = $this->input->post("type");
                $from = $this->input->post("from");
                $to = $this->input->post("to");
                if($to=="") $to=date("m/d/Y");
                if($from=="") $from=date("m/d/Y");
                $from_date = strtotime($from);
                $to_date = strtotime($to);
                if ($type=="today"){
                    $from_date =$now;
                    $to_date= $from_date;
                }else if($type=="byitem"){
                    $options= $this->input->post("item");
                }else if($type=="bypat"){
                    $options =$this->input->post("patient");
                }else if($type=="bydepart"){
                    $options =$this->input->post("depart");
                }
            }
            

        }
        $data=array();
        $data["type"]=$type;
        if ($task=="print_view" || $task==""){
            $income_list = $this->crud_model->income_analysis_report($from_date,$to_date,$type,$options);
            $data["income_list"] = $income_list[0];
            $data["from"] = date("m/d/Y",$from_date);
            $data["to"] = date("m/d/Y",$to_date);
            $data["vat"] = $income_list[3];
            $data["discount"] = $income_list[4];
            $data["sales"] = $income_list[1];
            $data["cost"] = $income_list[2];
            if($type=="byitem") $data["itemid"] = $options;
            if($type=="bydepart") $data["dept"] = $options;
            if($type=="bypat") $data["patid"] = $options;
        }
        $data['page_name'] = 'income_report';
        $data['page_title'] = get_phrase('income_analysis_report');
        if ($task=="print_view"){
            $this->load->view('backend/reports',$data);
        }else{
            $this->session->set_flashdata('message', $msg);
            $this->load->view('backend/index', $data);
        }
    }
    function invoice_report($task="",$req_type="",$fromdate="",$todate="",$req_options=""){
        $now =strtotime(date("m/d/Y H:i:s"));
        $from_date = $to_date=0;
        $options = "";
        if ($task=="print_view"){
            $from_date =$fromdate;
            $to_date= $todate;
            $type = $req_type;
            $options = $req_options;
        }else{
            if ($task!=""){
                $type=$task;
            } 
            else{
                $msg="Invoice Report was generated successfully.";
                $type = $this->input->post("type");
                $from = $this->input->post("from");
                $to = $this->input->post("to");
                $fromtime = $this->input->post("fromtime");
                $totime = $this->input->post("totime");
                if($to=="") $to=date("m/d/Y");
                if($from=="") $from=date("m/d/Y");
                $from_date = strtotime($from." ".$fromtime);
                $to_date = strtotime($to." ".$totime);
                if ($type=="today"){
                    $from_date = strtotime(date("m/d/Y"));
                    $to_date= $now;
                }else if($type=="bycomp"){
                    $options= $this->input->post("comp");
                }
            }
        }
        $data=array();
        $data["type"]=$type;
        if ($task=="print_view" || $task==""){
            $invoice_list = $this->crud_model->invoice_report($from_date,$to_date,$type,$options);
            $data["invoice_list"] = $invoice_list[0];
            $data["from"] = date("m/d/Y",$from_date);
            $data["to"] = date("m/d/Y",$to_date);
            $data["fromtime"] = date("H:i",$from_date);
            $data["totime"] = date("H:i",$to_date);
            $data["cash"] = $invoice_list[1];
            $data["comp"] = $invoice_list[2];
            $data["bank"] = $invoice_list[4];
            $data["credit"] = $invoice_list[3];
            if($type=="bycomp") $data["comp"] = $options;
        }
        $data['page_name'] = 'invoice_report';
        $data['page_title'] = get_phrase('invoice_report');
        if ($task=="print_view"){
            $this->load->view('backend/reports',$data);
        }else{
            $this->session->set_flashdata('message', $msg);
            $this->load->view('backend/index', $data);
        }
    }
    function grn_report($task="",$req_type="",$fromdate="",$todate="",$req_options=""){
        $now =strtotime(date("m/d/Y"));
        $as_at_date = $from_date = $to_date=0;
        $options = "";
        if ($task=="print_view"){
            $from_date =$fromdate;
            $to_date= $todate;
            $type = $req_type;
            $options = $req_options;
        }else{
            if ($task!=""){
                $type=$task;
            } 
            else{
                $msg="Goods Received Report was generated successfully.";
                $type = $this->input->post("type");
                $from = $this->input->post("from");
                $to = $this->input->post("to");
                if($to=="") $to=date("m/d/Y");
                if($from=="") $from=date("m/d/Y");
                $from_date = strtotime($from);
                $to_date = strtotime($to);
                if($type=="byitem"){
                    $options= $this->input->post("item");
                }else if($type=="bysup"){
                    $options =$this->input->post("supplier");
                }
            }
        }
        $data=array();
        $data["type"]=$type;
        if ($task=="print_view" || $task==""){
            $grn_list = $this->crud_model->good_received_report($from_date,$to_date,$type,$options);
            $data["grn_list"] = $grn_list[0];
            $data["from"] = date("m/d/Y",$from_date);
            $data["to"] = date("m/d/Y",$to_date);
            $data["total_cost"] = $grn_list[1];
            if($type=="byitem") $data["itemid"] = $options;
            if($type=="bysup") $data["supplier"] = $options;
        }
        $data['page_name'] = 'good_received_report';
        $data['page_title'] = get_phrase('goods_received_report');
        if ($task=="print_view"){
            $this->load->view('backend/reports',$data);
        }else{
            $this->session->set_flashdata('message', $msg);
            $this->load->view('backend/index', $data);
        }
    }
    function grc_report($task="",$req_type="",$fromdate="",$todate="",$req_options=""){
        $now =strtotime(date("m/d/Y"));
        $as_at_date = $from_date = $to_date=0;
        $options = "";
        if ($task=="print_view"){
            $from_date =$fromdate;
            $to_date= $todate;
            $type = $req_type;
            $options = $req_options;
        }else{
            if ($task!=""){
                $type=$task;
            } 
            else{
                $msg="Goods Returned Report was generated successfully.";
                $type = $this->input->post("type");
                $from = $this->input->post("from");
                $to = $this->input->post("to");
                if($to=="") $to=date("m/d/Y");
                if($from=="") $from=date("m/d/Y");
                $from_date = strtotime($from);
                $to_date = strtotime($to);
                if($type=="byitem"){
                    $options= $this->input->post("item");
                }else if($type=="bysup"){
                    $options =$this->input->post("supplier");
                }
            }
        }
        $data=array();
        $data["type"]=$type;
        if ($task=="print_view" || $task==""){
            $grc_list = $this->crud_model->good_returned_report($from_date,$to_date,$type,$options);
            $data["grc_list"] = $grc_list[0];
            $data["from"] = date("m/d/Y",$from_date);
            $data["to"] = date("m/d/Y",$to_date);
            $data["total_cost"] = $grc_list[1];
            if($type=="byitem") $data["itemid"] = $options;
            if($type=="bysup") $data["supplier"] = $options;
        }
        $data['page_name'] = 'good_returned_report';
        $data['page_title'] = get_phrase('goods_returned_report');
        if ($task=="print_view"){
            $this->load->view('backend/reports',$data);
        }else{
            $this->session->set_flashdata('message', $msg);
            $this->load->view('backend/index', $data);
        }
    }
    function reprint_grn_received_report($task="",$req_refno=""){
        $data=array();$msg="";$refno="";
        if ($task=="print_view"){
            $refno = $req_refno;
        }else{
            $refno = $this->input->post("refno");
        }
        if ($task=="print_view" || $task==""){
            if ($refno!=""){
                $list = $this->crud_model->reprint_grn_received_report($refno);
                $data["grn_list"] = $list[0];
                $data["total_cost"] = $list[1];
                $data["refno"] = $refno;
                $data["supplier"] = $list[2];
                $data["invno"] = $list[3];
                $msg="Reprint GRN Received Report was generated successfully.";
            }
        }
        $data['page_name'] = 'reprint_grn_received_report';
        $data['page_title'] = get_phrase('reprint_GRN_received_report');
        if ($task=="print_view"){
            $this->load->view('backend/reports',$data);
        }else{
            $this->session->set_flashdata('message', $msg);
            $this->load->view('backend/index', $data);
        }
    }
    function reprint_grn_returned_report($task="",$req_refno=""){
        $data=array();$msg="";$refno="";
        if ($task=="print_view"){
            $refno = $req_refno;
        }else{
            $refno = $this->input->post("refno");
        }
        if ($task=="print_view" || $task==""){
            if ($refno!=""){
                $list = $this->crud_model->reprint_grn_returned_report($refno);
                $data["grn_list"] = $list[0];
                $data["total_cost"] = $list[1];
                $data["refno"] = $refno;
                $data["supplier"] = $list[2];
                $data["invno"] = $list[3];
                $msg="Reprint GRN returned Report was generated successfully.";
            }
        }
        $data['page_name'] = 'reprint_grn_returned_report';
        $data['page_title'] = get_phrase('reprint_GRN_returned_report');
        if ($task=="print_view"){
            $this->load->view('backend/reports',$data);
        }else{
            $this->session->set_flashdata('message', $msg);
            $this->load->view('backend/index', $data);
        }
    }
}