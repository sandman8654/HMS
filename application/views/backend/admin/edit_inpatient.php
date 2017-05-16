<?php
// param2: patient_id from sendpatients
// param3: subtask from sendpatients
if (strlen($param2)>0) $isset_param=true;
if ($isset_param) {
    $patient_id = $param2;
    $subtask = ($param3!="")?$param3:"patient";
    $single_patient_info = $this->db->get_where('patient', array('patient_id' => $patient_id))->result_array();
    if (count($single_patient_info)==0){
        
        redirect(base_url()."index.php?admin/inpatients");
    };
    $row = $single_patient_info[0];
    $patient_type="inpatients";
    if($row["inout_status"]>1) $patient_type="maternity";
    $bed_info = $this->db->get_where('bed_allotment', array('patient_id' => $patient_id))->result_array()[0];
    $bed = $this->db->get_where('bed', array('bed_id' => $bed_info["bed_id"]))->result_array()[0];
    //admission
    $admit_info = $this->db->get_where('inpatient_admit_info', array('patient_id' => $patient_id))->result_array()[0];
    $admission_diag = $this->db->get_where('inpatient_admission_diag', array('admission_id' => $admit_info["admission_id"]))->result_array();
}
?>
<?php
    if(strlen($param2)>0) {?>
    <script>
        var patientId = <?php echo $param2;?>;
    </script>
<?php }?>

<script>
// global variables
        var baseUrl = "<?php echo base_url();?>";
        var curHisID = "",
            phyExamID="",
            DiagID="",
            theatreID="",
            labID = "",
            radID="";

</script>
<script src="<?php echo base_url(); ?>assets/js/amcharts/amcharts.js"></script>
<script src="<?php echo base_url(); ?>assets/js/amcharts/serial.js"></script>
<script src="<?php echo base_url(); ?>assets/js/amcharts/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/amcharts/plugins/export/export.css" type="text/css" media="all" />
<script src="<?php echo base_url(); ?>assets/js/amcharts/themes/light.js"></script>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3 id="test-date"><?php echo get_phrase('inpatient_management'); ?></h3>
                </div>
            </div>
            
            <div class="panel-body">
                <h4 class="pull-left"><?php
                    if($bed["type"]=="")
                        echo "Bed room not allowed";
                    else
                        echo 'Bed Room Information: '.$bed['type']." room-".$bed['room_no']." bed-".$bed['bed_number']; 
                 ?></h4>
                <div class="col-md-12 col-sm-12">
                    <ul class="nav nav-tabs bordered">
                        <li class="<?php if($subtask=='patient') echo 'active';?>"><a href="#tabs-1" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('patient_profile'); ?></span></a></li>
                        <li class="<?php if($subtask=='admission') echo 'active';?>"><a href="#tabs-2" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('admission_form'); ?></span></a></li>
                        <li class="<?php if($subtask=='supandproc') echo 'active';?>"><a href="#tabs-3" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('supplies_and_procedure'); ?></span></a></li>
              <!--          <li class="<?php if($subtask=='theaterchecklist') echo 'active';?>"><a href="#tabs-4" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('theater_checklist'); ?></span></a></li>-->
                        <li class="<?php if($subtask=='laboratory') echo 'active';?>"><a href="#tabs-5" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('Laboratory'); ?></span></a></li>
                        <li class="<?php if($subtask=='radiology') echo 'active';?>"><a href="#tabs-6" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('Radiology'); ?></span></a></li>
              <!--      <li class="<?php if($subtask=='observ') echo 'active';?>"><a href="#tabs-7" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('pre-oprative_observation'); ?></span></a></li>-->
                        <li class="<?php if($subtask=='cardex') echo 'active';?>"><a href="#tabs-8" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('nursing_cardex'); ?></span></a></li>
                        <li class="<?php if($subtask=='careplan') echo 'active';?>"><a href="#tabs-9" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('nursing_care_plan'); ?></span></a></li>
                        <li class="<?php if($subtask=='hourlytemp') echo 'active';?>"><a href="#tabs-10" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('four_hourly_temperature'); ?></span></a></li>
             <!--           <li class="<?php if($subtask=='monandevetemp') echo 'active';?>"><a href="#tabs-11" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('morning_and_evening_temperature'); ?></span></a></li>-->
                        <li class="<?php if($subtask=='bloodchart') echo 'active';?>"><a href="#tabs-12" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('blood_press_chart'); ?></span></a></li>
                        <li class="<?php if($subtask=='fluidbalchart') echo 'active';?>"><a href="#tabs-13" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('fluid_balance_chart'); ?></span></a></li>
                        <li class="<?php if($subtask=='details') echo 'active';?>"><a href="#tabs-14" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('other_details'); ?></span></a></li>
                    </ul>
                    <div  class="tab-content recep-tab">
                        <div id="tabs-1" class="tab-pane <?php if($subtask=='patient') echo 'active'; ?>">
                            <?php include 'inpatient_profile.php' ?>
                        </div>
                        <div id="tabs-2" class="tab-pane <?php if($subtask=='admission') echo 'active';?>">
                            <?php include 'inpatient_admission_form.php' ?>
                        </div>
                        <div id="tabs-3" class="tab-pane <?php if($subtask=='supandproc') echo 'active';?>">
                            <?php include 'inpatient_sup_and_proc.php' ?>
                        </div>
               <!--         <div id="tabs-4" class="tab-pane ">
                            
                        </div>-->
                        <div id="tabs-5" class="tab-pane <?php if($subtask=='laboratory') echo 'active';?>">
                            <?php include 'inpatient_lab_result.php' ?>
                        </div>
                        <div id="tabs-6" class="tab-pane <?php if($subtask=='radiology') echo 'active';?>">
                            <?php include 'inpatient_rad_result.php' ?>
                        </div>
              <!--          <div id="tabs-7" class="tab-pane ">
                            
                        </div>-->
                        <div id="tabs-8" class="tab-pane <?php if($subtask=='cardex') echo 'active';?>">
                            <?php include 'inpatient_nursing_cardex.php' ?>
                        </div>
                        <div id="tabs-9" class="tab-pane <?php if($subtask=='careplan') echo 'active';?>">
                            <?php include 'inpatient_nursing_care_plan.php' ?>
                        </div>
                        <div id="tabs-10" class="tab-pane <?php if($subtask=='hourlytemp') echo 'active';?>">
                            <?php include 'inpatient_hourly_temper.php' ?>
                        </div>
                        <div id="tabs-12" class="tab-pane <?php if($subtask=='bloodchart') echo 'active';?>">
                            <?php include 'inpatient_blood_chart.php' ?>
                        </div>
                        <div id="tabs-13" class="tab-pane <?php if($subtask=='fluidbalchart') echo 'active';?>">
                            <?php include 'inpatient_fluid_balance_chart.php' ?>
                        </div>
                        <div id="tabs-14" class="tab-pane <?php if($subtask=='details') echo 'active';?>">
                            <?php include 'inpatient_other_details.php' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
