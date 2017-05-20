<?php
$system_name    = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
$system_title   = $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;
$text_align     = $this->db->get_where('settings', array('type' => 'text_align'))->row()->description;
$account_type   = $this->session->userdata('login_type');
$company_name = $this->db->get_where("settings",array("type"=>"company_name"))->row()->description;
$address = $this->db->get_where("settings",array("type"=>"address"))->row()->description;
$tel = $this->db->get_where("settings",array("type"=>"tel"))->row()->description;
$email = $this->db->get_where("settings",array("type"=>"system_email"))->row()->description;
$website = $this->db->get_where("settings",array("type"=>"website"))->row()->description;
$logo_url = base_url()."assets/images/logo.png";
$acc_id = $this->session->userdata("login_user_id");
$user_name = $this->crud_model->get_type_name_by_id($account_type,$acc_id);
?>
<!DOCTYPE html>
<html lang="en" dir="<?php if ($text_align == 'right-to-left') echo 'rtl'; ?>">
    <head>

        <title><?php echo $page_title; ?> - <?php echo $system_title; ?></title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="Hospital Management System - Q-AFya version 2.0.0" />
        <meta name="author" content="Bravo Kenya" />
        <?php include 'includes_top.php'; ?>

    </head>
    <body class="page-body" >
        <div class="page-container" style="padding:0px" >
            <div class="main-content">
                <div class="row">
                    <div class="col-sm-12 ">
                        <div class="DTTT_PrintMessage">
                            <div class="col-sm-12 print-header">
                                <p><?php echo $company_name;?></p>
                                <p>P.O BOX: <?php echo $address;?></p>
                                <p>Tel: <?php echo $tel;?></p>
                                <p>E-mail: <?php echo $email;?></p>
                                <p>Website: <?php echo $website;?></p>
                                <img src="<?php echo base_url();?>assets/images/logo.png">
                            </div>
                        </div> 
                    </div>
                
                    <div style="clear:both;"></div>
                    <br>
                    <div class="col-sm-12">
                        <?php include 'reports/' . $page_name . '.php'; ?>
                    </div>
                    <div class="col-sm-12">
                        <div class="DTTT_PrintMessage">
                            <div class="col-sm-12 print-footer">
                                <p>Thank You for your Partnership</p>
                                <p>Report Pulled By <?php echo $user_name;?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>