<?php
if (strlen($param2)>0&&strlen($param3)>0) $isset_param=true;
if ($isset_param) {
    $single_patient_info = $this->db->get_where('patient', array('patient_id' => $param2))->result_array();
    $row = $single_patient_info[0];
    $single_triage_info = $this->crud_model->get_triage_list($param2,$param3);
    $triage = $single_triage_info[0];
    $recept_id = $this->db->get_where("sendpatients",array("id"=>$param3))->result_array()[0]["recept_id"];
}
?>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3 id="test-date"><?php echo get_phrase('patient_info_title'); ?></h3>
                </div>
            </div>
            
            <div class="panel-body">
                    <div class="pull-right">
                        <a href="#" id="update-triage" class="btn btn-success btn-md">Save</a>
                        <a href="<?php echo base_url(); ?>index.php?admin/triage" class="btn btn-danger btn-md">Exit</a>
                    </div>
                    <h4 class="pull-left"><?php if ($isset_param && strlen($triage["triage_date"])>0) echo 'This triage was updated at '. $triage["triage_date"]; ?></h4>
                    <div class="col-sm-12 col-md-12">
                        
                        <div class="col-sm-12 col-md-4 has-right-border">
                            <form role="form" class="form-horizontal form-groups-bordered" >
                                <h4 class="add-patient-sub-title"><?php echo get_phrase('patient_detail_info_title'); ?></h4>
                                <div class="form-group">
                                    <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('select_patient_for_triage'); ?></label>
                                    <div class="col-md-9">
                                        <select disabled id="patientselect" name="patient_group" class="form-control" placeholder=<?php echo get_phrase('selecet_patient_name_or_id');?>>
                                            <?php $all_patient_info= $this->db->get_where('patient')->result_array();
                                                foreach ($all_patient_info as $patient){ ?>
                                                <option value=<?php echo $patient['patient_id']; ?> <?php if ($patient['patient_id'] == $param2) echo ' selected';?>><?php echo $patient['name']."- ".$patient['patient_id']; ?></option>        
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px; margin:0 auto">
                                                <img src="<?php echo ($isset_param)?$this->crud_model->get_image_url('patient' , $row['patient_id']):'http://placehold.it/200x150';?>" alt="...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-1" class="col-md-3 control-label"><?php echo get_phrase('name'); ?></label>
                                    <div class="col-md-9">
                                        <input disabled type="text" name="name" class="form-control" id="field-1" value="<?php echo ($isset_param)?$row['name']:''; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-md-3 control-label"><?php echo get_phrase('email'); ?></label>

                                    <div class="col-md-9">
                                        <input disabled type="email" name="email" class="form-control" id="field-1" value="<?php echo ($isset_param)?$row['email']:''; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('address'); ?></label>
                                    <div class="col-md-9">
                                        <textarea disabled name="address" class="form-control" id="field-ta"><?php echo ($isset_param)?trim($row['address']):''; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-1" class="col-md-3 control-label"><?php echo get_phrase('phone'); ?></label>

                                    <div class="col-md-9">
                                        <input disabled type="text" name="phone" class="form-control" id="field-1"  value="<?php echo ($isset_param)?$row['phone']:''; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('sex'); ?></label>

                                    <div class="col-md-9">
                                        
                                        <select disabled name="sex" class="form-control">
                                            <?php if($isset_param){ ?>
                                                <option value=""><?php echo get_phrase('select_sex'); ?></option>
                                                <option value="male" <?php if ($row['sex'] == 'male')echo 'selected';?>>
                                                    <?php echo get_phrase('male'); ?>
                                                </option>
                                                <option value="female" <?php if ($row['sex'] == 'female')echo 'selected';?>>
                                                    <?php echo get_phrase('female'); ?>
                                                </option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="field-1" class="col-md-3 control-label"><?php echo get_phrase('birth_date'); ?></label>

                                    <div class="col-md-9">
                                        <input disabled type="text" name="birth_date" class="form-control datepicker" id="field-1" value="<?php echo ($isset_param)?(date('d/m/Y', $row['birth_date'])):''; ?>" >
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="field-1" class="col-md-3 control-label"><?php echo get_phrase('age'); ?></label>

                                    <div class="col-md-9">
                                        <input disabled type="number" name="age" class="form-control" id="field-1" value="<?php echo ($isset_param)?$row['age']:''; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('blood_group'); ?></label>
                                    <div class="col-md-9">
                                        <select disabled name="blood_group" class="form-control">
                                            <?php if($isset_param){ ?>
                                            <option value=""><?php echo get_phrase('select_blood_group'); ?></option>
                                            <option value="A+" <?php if ($row['blood_group'] == 'A+')echo 'selected';?>>A+</option>
                                            <option value="A-" <?php if ($row['blood_group'] == 'A-')echo 'selected';?>>A-</option>
                                            <option value="B+" <?php if ($row['blood_group'] == 'B+')echo 'selected';?>>B+</option>
                                            <option value="B-" <?php if ($row['blood_group'] == 'B-')echo 'selected';?>>B-</option>
                                            <option value="AB+" <?php if ($row['blood_group'] == 'AB+')echo 'selected';?>>AB+</option>
                                            <option value="AB-" <?php if ($row['blood_group'] == 'AB-')echo 'selected';?>>AB-</option>
                                            <option value="O+" <?php if ($row['blood_group'] == 'O+')echo 'selected';?>>O+</option>
                                            <option value="O-" <?php if ($row['blood_group'] == 'O-')echo 'selected';?>>O-</option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                            
                            </form>
                        </div>
                        <div class="col-sm-12 col-md-3 has-right-border" style="min-height: 790px;">
                            <form role="form" class="form-horizontal form-groups-bordered" >
                                <h4 class="add-patient-sub-title"><?php echo get_phrase('triage_analysis');?></h4>
                                <div class="form-group">
                                    <label for="field-1" class="col-md-3 col-sm-3 control-label"><?php echo get_phrase('temp'); ?></label>
                                    <div class="col-sm-5 col-md-5">
                                        <input type="text" name="name" class="form-control" id="field-temp" value="<?php echo $triage['temp']; ?>"/>
                                    </div>
                                    <div class="col-md-1 col-sm-1 unit-symbol">
                                       <p> &deg;C</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-1" class="col-md-3 col-sm-3 control-label"><?php echo get_phrase('b_p'); ?></label>
                                    <div class="col-md-5 col-sm-5">
                                        <input type="text" name="bph" class="form-control" id="field-bph" value="<?php echo $triage['bph']; ?>"/><br/>
                                        <input type="text" name="bpl" class="form-control" id="field-bpl" value="<?php echo $triage['bpl']; ?>"/>
                                    </div>
                                    <div class="col-md-1 col-sm-1 unit-symbol">
                                       <p>mmHg</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-1" class="col-md-3 col-sm-3 control-label"><?php echo get_phrase('weight'); ?></label>
                                    <div class="col-md-5 col-sm-5">
                                        <input type="text" name="weight" class="form-control" id="field-weight" value="<?php echo $triage['weight']; ?>"/>
                                    </div>
                                    <div class="col-md-1 col-sm-1 unit-symbol">
                                       <p>kgs</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-1" class="col-md-3 col-sm-3 control-label"><?php echo get_phrase('resp_rate'); ?></label>
                                    <div class="col-md-5 col-sm-5">
                                        <input type="text" name="resprate" class="form-control" id="field-resprate" value="<?php echo $triage['resprate']; ?>"/>
                                    </div>
                                    <div class="col-md-1 col-sm-1 unit-symbol">
                                       <p>Breaths/min</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-1" class="col-md-3 col-sm-3 control-label"><?php echo get_phrase('pulse_rate'); ?></label>
                                    <div class="col-md-5 col-sm-5">
                                        <input type="text" name="pulserate" class="form-control" id="field-pulserate" value="<?php echo $triage['pulserate']; ?>"/>
                                    </div>
                                    <div class="col-md-1 col-sm-1 unit-symbol">
                                       <p>Beats/Min</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-1" class="col-md-3 col-sm-3 control-label"><?php echo get_phrase('r_b_s'); ?></label>
                                    <div class="col-md-5 col-sm-5">
                                        <input type="text" name="rbs" class="form-control" id="field-rbs" value="<?php echo $triage['rbs']; ?>"/>
                                    </div>
                                    <div class="col-md-1 col-sm-1 unit-symbol">
                                       <p>mMoles/Ltr</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('send_to'); ?></label>
                                    <div class="col-md-7 col-sm-7 ">
                                        <select name="send_to" id="send_to" class="form-control">
                                            <?php $all_items_info= $this->db->get_where('doctor')->result_array();
                                                foreach ($all_items_info as $item){?>
                                                <option value=<?php echo $item['doctor_id']; ?>><?php echo $item['name']." - ".$item['email']; ?></option>        
                                            <?php } ?>
                                            <!--<option value="GENERAL CONSULTATIONS">General Consultations</option>
                                            <option value="PHYSIOTHERAPY">Physiotherapy</option>
                                            <option value="EYE CLINIC">Eye Clinic</option>
                                            <option value="MCH">MCH</option>
                                            <option value="NUTRITION">Nutrition</option>
                                            <option value="DENTAL CLINIC">Dental Clinic</option>
                                            <option value="PAEDIATRICS">Paediatrics</option>
                                            <option value="COUNSELLING">Counselling</option>-->
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-offset-4 col-md-7 col-sm-7 ">
                                        <a href="#" id="sendto" class="btn btn-success btn-md">Send To</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/wysihtml5-color.css"></link>
                        <div class="col-sm-12 col-md-5 ">
                            <form role="form" class="form-horizontal form-groups-bordered" >
                                <h4 class="add-patient-sub-title"><?php echo get_phrase('other_details');?></h4>
                                <div class="form-group">
                                    <label for="field-1" class="col-md-offset-1 col-sm-offset-1 control-label"><?php echo get_phrase('known_problems_allergies'); ?></label>
                                    <div class="col-md-12 compose-message-editor">
                                        <textarea row="5" class="form-control "  
                                            name="details1" placeholder="<?php echo get_phrase('known_problems_allergies'); ?>" 
                                            id="details1_wysiwyg"><?php echo $triage['allergies']; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-1" class="col-md-offset-1 col-sm-offset-1 control-label"><?php echo get_phrase('additional_details'); ?></label>
                                    <div class="col-md-12 compose-message-editor">
                                        <textarea row="5" class="form-control  " name="details2" placeholder="<?php echo get_phrase('additional_details'); ?>" 
                                            id="details2_wysiwyg"><?php echo $triage['otherdetails']; ?></textarea>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                    
            </div>
        </div>
    </div>
</div>
<div id="wysihtml5-toolbar" style="display: none;">
  <a data-wysihtml5-command="bold">bold</a>
  <a data-wysihtml5-command="italic">italic</a>

  <!-- Some wysihtml5 commands require extra parameters -->
  <a data-wysihtml5-command="foreColor" data-wysihtml5-command-value="red">red</a>
  <a data-wysihtml5-command="foreColor" data-wysihtml5-command-value="green">green</a>
  <a data-wysihtml5-command="foreColor" data-wysihtml5-command-value="blue">blue</a>

  <!-- Some wysihtml5 commands like 'createLink' require extra paramaters specified by the user (eg. href) -->
  <a data-wysihtml5-command="createLink">insert link</a>
  <div data-wysihtml5-dialog="createLink" style="display: none;">
    <label>
      Link:
      <input data-wysihtml5-dialog-field="href" value="http://" class="text">
    </label>
    <a data-wysihtml5-dialog-action="save">OK</a> <a data-wysihtml5-dialog-action="cancel">Cancel</a>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/jquery-plugin/js/jquery-editable-select.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-plugin/css/editable-select.css"></link>

<?php
    if(strlen($param3)>0) {?>
    <script>
        var queueId = "<?php echo $param3;?>";
        var transId = "<?php echo $triage['trans_id'];?>";
        var patientType = "<?php echo $triage['patient_type'];?>";
        var receptId = "<?php if(strlen($recept_id)>0) echo $recept_id;?>";
    </script>
<?php }?>
<?php
    if(strlen($param2)>0) {?>
    <script>
        var patientId = <?php echo $param2;?>;
    </script>
<?php }?>

<script>
        var baseUrl = "<?php echo base_url();?>";
</script>
<script type="text/javascript">
//table box event
    jQuery(window).load(function ()
    {
        var $ = jQuery;

        new wysihtml5.Editor("details1_wysiwyg", {toolbar:wysihtml5-toolbar });
        new wysihtml5.Editor("details2_wysiwyg", {toolbar:wysihtml5-toolbar });

        // update triage data for patient
        $("#update-triage").on("click",function(e){
            e.preventDefault();
            if (queueId<=0 || queueId.toString().length==0 ) return;
            if (patientId<=0 || patientId.toString().length==0 ) return;
            data={};
            data["url"] = baseUrl + "index.php?modal/savetriagedata";
            data["queue_id"] = queueId;
            data["patient_id"] = patientId;
            data["temp"] = $("#field-temp").val();
            data["bph"] = $("#field-bph").val();
            data["bpl"] = $("#field-bpl").val();
            data["weight"] = $("#field-weight").val();
            data["resprate"] = $("#field-resprate").val();
            data["rbs"] = $("#field-rbs").val();
            data["pulserate"] = $("#field-pulserate").val();
            data["allergies"] = $("#details1_wysiwyg").val();
            data["otherdetails"] = $("#details2_wysiwyg").val();
            $.post(data.url,data,function(res){
                if (res=="success"){
                    $.alert("Triage data was updated successfully.","Success");
                }else{
                    $.alert("while updating, some errors raised.","Error");
                }
            });
        });
        //send patiant to doctor
        $("#sendto").on("click",function(e){
            e.preventDefault();
            var data={};
            data['url'] = baseUrl+"index.php?modal/sendtobranch/";
            var tid = transId.toString();
            var did = $("#send_to").val().toString();
            
            if (tid.length==0) {
                $.alert("please select payments for patient!","Error"); return;
            }
            if (did.length==0) {
                $.alert("please select doctor for patient!","Error"); return;
            }
         //   if (!checkPatientId()) return;
            data['paymentId'] =tid;
            data['patientId'] = patientId;
            data['sentto_account_type'] = 'doctor';
            data['sentto_account_id'] =  did;
            data["type"]="consultation";
            data["patient_type"] = patientType;
            data["recept_id"] = receptId;
            function aftercallback(){
  //              window.location.href = "<?php echo base_url(); ?>index.php?admin/triage";
            }
            sendToBranch(data,aftercallback);
        })
    });
</script>