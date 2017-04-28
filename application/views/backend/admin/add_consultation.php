<?php
// param2: patient_id from sendpatients
// param3: queue_id from sendpatients
if (strlen($param2)>0&&strlen($param3)>0) $isset_param=true;
if ($isset_param) {
    $single_patient_info = $this->db->get_where('patient', array('patient_id' => $param2))->result_array();
    $row = $single_patient_info[0];
    $recept_id = $this->db->get_where("sendpatients",array("id"=>$param3))->result_array()[0]["recept_id"];
    $single_triage_info =  $this->crud_model->get_triage_list_from_receptid($recept_id);
    $triage = $single_triage_info[0];
    $cons_arr = $this->db->get_where("consultations",array("recept_id"=>$recept_id))->result_array();
    $cons_id="";
    if (count($cons_arr)>0) $cons_id = $cons_arr[0]["id"];
}
?>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3 id="test-date"><?php echo get_phrase('consultation_info'); ?></h3>
                </div>
            </div>
            
            <div class="panel-body">
                <div class="pull-right">
                    <a href="#" id="update-consultation" class="btn btn-success btn-md">Save</a>
                    <a href="<?php echo base_url(); ?>index.php?admin/consultation" class="btn btn-danger btn-md">Exit</a>
                </div>
                <h4 class="pull-left" id="update-date"><?php if ($isset_param && strlen($cons_arr[0]["last_date"])>0) echo 'This Consultation was updated at '.date("d/m/Y H:i:s", $cons_arr[0]["last_date"]); ?></h4>
                <div class="col-md-12 col-sm-12">
                    <ul class="nav nav-tabs bordered">
                        <li class="active"><a href="#tabs-1" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('patient_profile'); ?></span></a></li>
                        <li><a href="#tabs-2" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('triage_analysis'); ?></span></a></li>
                        <li><a href="#tabs-3" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('past_history'); ?></span></a></li>
                        <li><a href="#tabs-4" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('current_history'); ?></span></a></li>
                        <li><a href="#tabs-5" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('physical_examination'); ?></span></a></li>
                        <li><a href="#tabs-6" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('diagnosis'); ?></span></a></li>
                        <li><a href="#tabs-7" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('theatre'); ?></span></a></li>
                        <li><a href="#tabs-8" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('Pharmacy'); ?></span></a></li>
                        <li><a href="#tabs-9" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('Laboratory'); ?></span></a></li>
                        <li><a href="#tabs-10" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('Radiology'); ?></span></a></li>
                        <li><a href="#tabs-11" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('other_details'); ?></span></a></li>
                    </ul>
                    <div  class="tab-content recep-tab">
                        <div id="tabs-1" class="tab-pane active">
                            <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/patient/update/<?php echo $row['patient_id']; ?>" method="post" enctype="multipart/form-data">
                                <div class="col-md-12 col-sm-12">
                                    <div class="col-md-5 col-sm-5 has-right-border">
                                        <h4 class="add-patient-sub-title"><?php echo get_phrase('patient_detail_info_title'); ?></h4>
                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name'); ?></label>
                                            <div class="col-sm-9">
                                                <input disabled type="text" name="name" class="form-control" id="field-1" value="<?php echo $row['name']; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email'); ?></label>

                                            <div class="col-sm-9">
                                                <input disabled type="email" name="email" class="form-control" id="field-1" value="<?php echo $row['email']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('address'); ?></label>

                                            <div class="col-sm-9">
                                                <textarea disabled name="address" class="form-control" id="field-ta"><?php echo $row['address']; ?></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('phone'); ?></label>

                                            <div class="col-sm-9">
                                                <input disabled type="text" name="phone" class="form-control" id="field-1"  value="<?php echo $row['phone']; ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('sex'); ?></label>

                                            <div class="col-sm-9">
                                                <select disabled name="sex" class="form-control">
                                                    <option value=""><?php echo get_phrase('select_sex'); ?></option>
                                                    <option value="male" <?php if ($row['sex'] == 'male')echo 'selected';?>>
                                                        <?php echo get_phrase('male'); ?>
                                                    </option>
                                                    <option value="female" <?php if ($row['sex'] == 'female')echo 'selected';?>>
                                                        <?php echo get_phrase('female'); ?>
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('birth_date'); ?></label>

                                            <div class="col-sm-9">
                                                <input disabled type="text" name="birth_date" class="form-control datepicker" id="field-1" value="<?php echo date('d/m/Y', $row['birth_date']); ?>" >
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('age'); ?></label>

                                            <div class="col-sm-9">
                                                <input disabled type="number" name="age" class="form-control" id="field-1" value="<?php echo $row['age']; ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('blood_group'); ?></label>

                                            <div class="col-sm-9">
                                                <select disabled name="blood_group" class="form-control">
                                                    <option value=""><?php echo get_phrase('select_blood_group'); ?></option>
                                                    <option value="A+" <?php if ($row['blood_group'] == 'A+')echo 'selected';?>>A+</option>
                                                    <option value="A-" <?php if ($row['blood_group'] == 'A-')echo 'selected';?>>A-</option>
                                                    <option value="B+" <?php if ($row['blood_group'] == 'B+')echo 'selected';?>>B+</option>
                                                    <option value="B-" <?php if ($row['blood_group'] == 'B-')echo 'selected';?>>B-</option>
                                                    <option value="AB+" <?php if ($row['blood_group'] == 'AB+')echo 'selected';?>>AB+</option>
                                                    <option value="AB-" <?php if ($row['blood_group'] == 'AB-')echo 'selected';?>>AB-</option>
                                                    <option value="O+" <?php if ($row['blood_group'] == 'O+')echo 'selected';?>>O+</option>
                                                    <option value="O-" <?php if ($row['blood_group'] == 'O-')echo 'selected';?>>O-</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><?php echo get_phrase('image'); ?></label>

                                            <div class="col-sm-9">

                                                <div class="fileinput fileinput-new" >
                                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
                                                        <img src="<?php echo $this->crud_model->get_image_url('patient' , $row['patient_id']);?>" alt="...">
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                                </div>

                                            </div>
                                        </div>

                                            
                                        
                                    </div>
                                    <div class="col-md-5 col-sm-5 ">
                                        <h4 class="add-patient-sub-title"><?php echo get_phrase('patient_guardian_info_title'); ?></h4>
                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name'); ?></label>
                                            <div class="col-sm-9">
                                                <input disabled type="text" name="rel_name" class="form-control" id="field-1" value="<?php echo $row['gname']; ?>" >
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('relation_patient'); ?></label>

                                            <div class="col-sm-9">
                                                <select disabled name="rel_group" class="form-control">
                                                    <option value=""></option>
                                                    <option value="father" <?php if ($row['grship'] == 'father')echo 'selected';?>><?php echo get_phrase('rel_father');?></option>
                                                    <option value="mother" <?php if ($row['grship'] == 'mother')echo 'selected';?>><?php echo get_phrase('rel_mother');?></option>
                                                    <option value="husband" <?php if ($row['grship'] == 'husband')echo 'selected';?>><?php echo get_phrase('rel_husband');?></option>
                                                    <option value="wife" <?php if ($row['grship'] == 'wife')echo 'selected';?>><?php echo get_phrase('rel_wife');?></option>    
                                                    <option value="brother" <?php if ($row['grship'] == 'brother')echo 'selected';?>><?php echo get_phrase('rel_brother');?></option>
                                                    <option value="sister" <?php if ($row['grship'] == 'sister')echo 'selected';?>><?php echo get_phrase('rel_sister');?></option>
                                                    <option value="uncle" <?php if ($row['grship'] == 'uncle')echo 'selected';?>><?php echo get_phrase('rel_uncle');?></option>
                                                    <option value="aunt" <?php if ($row['grship'] == 'aunt')echo 'selected';?>><?php echo get_phrase('rel_aunt');?></option>
                                                    <option value="cousin" <?php if ($row['grship'] == 'cousin')echo 'selected';?>><?php echo get_phrase('rel_cousin');?></option>
                                                    <option value="son" <?php if ($row['grship'] == 'son')echo 'selected';?>><?php echo get_phrase('rel_son');?></option>
                                                    <option value="doughter" <?php if ($row['grship'] == 'doughter')echo 'selected';?>><?php echo get_phrase('rel_daughter');?></option>
                                                    <option value="others" <?php if ($row['grship'] == 'others')echo 'selected';?>><?php echo get_phrase('rel_others');?></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('rel_phone'); ?></label>

                                            <div class="col-sm-9">
                                                <input disabled type="text" name="rel_phone" class="form-control" id="field-1" value="<?php echo $row['gcont']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('rel_address'); ?></label>

                                            <div class="col-sm-9">
                                                <textarea  disabled name="rel_address" class="form-control" id="field-ta"><?php echo $row['gaddress']; ?></textarea>
                                            </div>
                                        </div>
                                        <h4 class="add-patient-sub-title"><?php echo get_phrase('patient_employer_info_title'); ?></h4>
                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('employer_name'); ?></label>

                                            <div class="col-sm-9">
                                                <input disabled type="text" name="emp_name" class="form-control" id="field-1" value="<?php echo $row['empname']; ?>" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('employer_no'); ?></label>

                                            <div class="col-sm-9">
                                                <input disabled type="text" name="emp_no" class="form-control" id="field-1" value="<?php echo $row['empno']; ?>" >
                                            </div>
                                        </div>
                                        <h4 class="add-patient-sub-title"><?php echo get_phrase('insurance_scheme_details'); ?></h4>
                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('insurer'); ?></label>
                                            <div class="col-sm-9">
                                                <select disabled name="insur_group" id="insur_group" class="form-control">
                                                    <?php $all_insur_info= $this->crud_model->select_insurer_info();
                                                        foreach ($all_insur_info as $item){ ?>
                                                        <option value=<?php echo $item['id']; ?> <?php if ($row['insurerid'] == $item['id'])echo 'selected';?> data-cmpname="<?php echo $item['cmpname']; ?>"><?php echo $item['name'] ?></option>        
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('insur_card_no'); ?></label>

                                            <div class="col-sm-9">
                                                <input disabled type="text" name="insur_card_no" class="form-control" id="field-1" value="<?php echo $row['cardno']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('insur_company_name'); ?></label>

                                            <div class="col-sm-9">
                                                <input  disabled type="text" disabled name="insur_comp_name" id="insur_comp_name" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('other_note'); ?></label>

                                            <div class="col-sm-9">
                                                <textarea  disabled name="other_note" class="form-control" id="field-ta"><?php echo $row['odetails']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>   
                                
                            </form>
                        </div>
                        <div id="tabs-2" class="tab-pane ">
                            <div class="col-sm-12 col-md-3 has-right-border" style="height:500px;">
                                <form role="form" class="form-horizontal form-groups-bordered" >
                                    <h4 class="add-patient-sub-title"><?php echo get_phrase('triage_analysis');?></h4>
                                    <div class="form-group">
                                        <label for="field-1" class="col-md-3 col-sm-3 control-label"><?php echo get_phrase('temp'); ?></label>
                                        <div class="col-sm-5 col-md-5">
                                            <input disabled type="text" name="name" class="form-control" id="field-temp" value="<?php echo $triage['temp']; ?>"/>
                                        </div>
                                        <div class="col-md-1 col-sm-1 unit-symbol">
                                        <p> &deg;C</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-md-3 col-sm-3 control-label"><?php echo get_phrase('b_p'); ?></label>
                                        <div class="col-md-5 col-sm-5">
                                            <input disabled type="text" name="bph" class="form-control" id="field-bph" value="<?php echo $triage['bph']; ?>"/><br/>
                                            <input disabled type="text" name="bpl" class="form-control" id="field-bpl" value="<?php echo $triage['bpl']; ?>"/>
                                        </div>
                                        <div class="col-md-1 col-sm-1 unit-symbol">
                                        <p>mmHg</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-md-3 col-sm-3 control-label"><?php echo get_phrase('weight'); ?></label>
                                        <div class="col-md-5 col-sm-5">
                                            <input disabled type="text" name="weight" class="form-control" id="field-weight" value="<?php echo $triage['weight']; ?>"/>
                                        </div>
                                        <div class="col-md-1 col-sm-1 unit-symbol">
                                        <p>kgs</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-md-3 col-sm-3 control-label"><?php echo get_phrase('resp_rate'); ?></label>
                                        <div class="col-md-5 col-sm-5">
                                            <input disabled type="text" name="resprate" class="form-control" id="field-resprate" value="<?php echo $triage['resprate']; ?>"/>
                                        </div>
                                        <div class="col-md-1 col-sm-1 unit-symbol">
                                        <p>Breaths/min</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-md-3 col-sm-3 control-label"><?php echo get_phrase('pulse_rate'); ?></label>
                                        <div class="col-md-5 col-sm-5">
                                            <input disabled type="text" name="pulserate" class="form-control" id="field-pulserate" value="<?php echo $triage['pulserate']; ?>"/>
                                        </div>
                                        <div class="col-md-1 col-sm-1 unit-symbol">
                                        <p>Beats/Min</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-md-3 col-sm-3 control-label"><?php echo get_phrase('r_b_s'); ?></label>
                                        <div class="col-md-5 col-sm-5">
                                            <input disabled type="text" name="rbs" class="form-control" id="field-rbs" value="<?php echo $triage['rbs']; ?>"/>
                                        </div>
                                        <div class="col-md-1 col-sm-1 unit-symbol">
                                        <p>mMoles/Ltr</p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-12 col-md-4 has-right-border" style="height: 500px;">
                                <h4 class="add-patient-sub-title"><?php echo get_phrase('known_problems_allergies');?></h4>
                                <?php echo $triage['allergies']; ?>
                            </div>
                            <div class="col-sm-12 col-md-4 " style="height: 500px;">
                                <h4 class="add-patient-sub-title"><?php echo get_phrase('other_details');?></h4>
                                <?php echo $triage['otherdetails']; ?>
                            </div>
                        </div>
                        <div id="tabs-3" class="tab-pane ">
                        </div>
                        <div id="tabs-4" class="tab-pane ">
                            <form role="form" class="form-horizontal form-groups-bordered" >
                                <div class="form-group">
                                    <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('Type_Symptom_name_and_press_enter'); ?></label>
                                    <div class="col-md-9">
                                        <select id="symptom-select" name="symptom-select" class="form-control select2" placeholder=<?php echo get_phrase('type_search_term');?>>
                                            <option value=""><?php echo get_phrase('type_search_term'); ?></option>
                                            <optgroup label="<?php echo get_phrase('symptom'); ?>">
                                                <?php $all_info= $this->db->get_where('symptoms')->result_array();
                                                    foreach ($all_info as $item){ ?>
                                                    <option value=<?php echo $item['id']; ?>><?php echo $item['name']; ?></option>        
                                                <?php } ?>
                                            </optgroup>    
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 compose-message-editor">
                                        <textarea row="25" class="form-control" data-stylesheet-url="assets/css/wysihtml5-color.css"  name="current_history" 
                                            id="current_history_wysiwyg" style="height:380px"><?php
                                                if (count($cons_id)>0){
                                                    $arr = $this->db->get_where("currenthistory",array("cons_id"=>$cons_id))->result_array();
                                                    if (count($arr)>0) echo $arr[0]["content"];
                                                }
                                            ?></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="tabs-5" class="tab-pane ">
                            <form role="form" class="form-horizontal form-groups-bordered" >
                                <div class="form-group">
                                    <div class="col-md-12 compose-message-editor">
                                        <textarea row="25" class="form-control" data-stylesheet-url="assets/css/wysihtml5-color.css" name="physical_exam" 
                                            id="physical_exam_wysiwyg" style="height:450px"><?php
                                                if (count($cons_id)>0){
                                                    $arr = $this->db->get_where("physicalexam",array("cons_id"=>$cons_id))->result_array();
                                                    if (count($arr)>0) echo $arr[0]["content"];
                                                }
                                            ?></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="tabs-6" class="tab-pane ">
                            <div class="col-sm-12 col-md-12">
                                <form role="form" class="form-horizontal form-groups-bordered" >
                                    <div class="form-group">
                                        <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('Type_Diagnosis_name_and_press_enter_(ICD10_Format)'); ?></label>
                                        <div class="col-md-9">
                                            <select id="icd10-select" name="icd10-select" class="form-control select2" placeholder=<?php echo get_phrase('type_search_term');?>>
                                                <option value=""><?php echo get_phrase('type_search_term'); ?></option>
                                                <optgroup label="<?php echo get_phrase('icd10'); ?>">
                                                    <?php $all_info= $this->db->get_where('icd10')->result_array();
                                                        foreach ($all_info as $item){ ?>
                                                        <option value=<?php echo $item['code']; ?>><?php echo $item['name']; ?></option>        
                                                    <?php } ?>
                                                </optgroup>    
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6 compose-message-editor has-right-border">
                                            <textarea row="25" class="form-control" data-stylesheet-url="assets/css/wysihtml5-color.css"  name="diag_history" 
                                                id="diag_wysiwyg" style="height:380px"><?php
                                                    if (count($cons_id)>0){
                                                        $arr = $this->db->get_where("diagnosis_history",array("cons_id"=>$cons_id))->result_array();
                                                        if (count($arr)>0) echo $arr[0]["content"];
                                                    }
                                                ?></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('diagnosis_summary'); ?></label>
                                                <div class="col-md-9">
                                                    <select id="diag-select" name="diag-select" class="form-control select2" placeholder=<?php echo get_phrase('type_search_term');?>>
                                                        <option value=""><?php echo get_phrase('type_search_term'); ?></option>
                                                        <optgroup label="<?php echo get_phrase('diagnosis'); ?>">
                                                            <?php $all_info= $this->db->get_where('diagnosis')->result_array();
                                                                foreach ($all_info as $item){ ?>
                                                                <option value=<?php echo $item['id']; ?>><?php echo $item['name']; ?></option>        
                                                            <?php } ?>
                                                        </optgroup>    
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-control col-md-12 " id="diag_summary_editor" style="height:364px; margin-left:15px;"></div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                        <div id="tabs-7" class="tab-pane ">
                            <div class="col-sm-12 col-md-6">
                                <form role="form" class="form-horizontal form-groups-bordered" >
                                    <div class="form-group">
                                        <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('Type_Theatre_procedure_name_and_press_enter'); ?></label>
                                        <div class="col-md-9">
                                            <select id="theatre-select" name="theatre-select" class="form-control select2" placeholder=<?php echo get_phrase('type_search_term');?>>
                                                <option value=""><?php echo get_phrase('type_search_term'); ?></option>
                                                <optgroup label="<?php echo get_phrase('procedures'); ?>">
                                                    <?php $all_info= $this->db->get_where('procedures')->result_array();
                                                        foreach ($all_info as $item){ ?>
                                                        <option value=<?php echo $item['id']; ?>><?php echo $item['name']; ?></option>        
                                                    <?php } ?>
                                                </optgroup>    
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                         <h4 class="add-patient-sub-title"><?php echo get_phrase('theatre_request_list');?></h4>
                                         <div class="form-control col-md-12 " id="theatre_req_list" style="height:390px; margin-left:15px;"></div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <h4 class="add-patient-sub-title"><?php echo get_phrase('theatre_summary');?></h4>
                                <div class="form-control col-md-12 " id="theatre_summary_editor" style="height:465px; margin-left:15px;"></div>
                            </div>
                        </div>
                        <div id="tabs-8" class="tab-pane ">
                            <div class="col-md-6 col-sm-12">
                                <form role="form" class="form-horizontal form-groups-bordered" >
                                    <div class="form-group">
                                        <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('drug_name:'); ?></label>
                                        <div class="col-md-9">
                                            <select id="drug-select" name="drug-select" class="form-control select2" placeholder=<?php echo get_phrase('type_search_drug');?>>
                                                <option value=""><?php echo get_phrase('type_search_drug'); ?></option>
                                                <optgroup label="<?php echo get_phrase('drug_name'); ?>">
                                                    <?php  $this->db->order_by('ItemName' , 'asc');
                                                        $all_info= $this->db->get_where('items',array("category"=>"PHARMACEUTICALS"))->result_array();
                                                        foreach ($all_info as $item){ ?>
                                                        <option value=<?php echo $item['ItemCode']; ?>><?php echo $item['ItemName']; ?></option>        
                                                    <?php } ?>
                                                </optgroup>    
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-ta" class="col-md-3 control-label" ><?php echo get_phrase('dosage:'); ?></label>
                                        <div class="col-md-3">
                                             <input type="text"  name="dosage_qty" id="dosage_qty" class="form-control" style="width:50px;float:left" >
                                             <select class="form-control" id="dosagetype_sel" style="width:100px;float:left">
                                                <option value="">Select one...</option>
                                                <option value="Tabs">Tabs</option>
                                                <option value="Mls">Mls</option>
                                                <option value="Capsules">Capsules</option>
                                                <option value="Suspensions">Suspensions</option>
                                                <option value="Elixirs">Elixirs</option>
                                                <option value="Syrups">Syrups</option>
                                                <option value="Creams">Creams</option>
                                                <option value="Ointments">Ointments</option>
                                                <option value="Suppositories">Suppositories</option>
                                                <option value="Inhalers">Inhalers</option>
                                                <option value="Vials">Vials</option>
                                                <option value="Patch">Patch</option>
                                                <option value="Pessaries">Pessaries</option>
                                                <option value="Ampoule"></option>
                                            </select>
                                        </div>
                                        <label for="field-ta" class="col-md-3 control-label" ><?php echo get_phrase('route:'); ?></label>
                                        <div class="col-md-3">
                                            <select class="form-control" id="route_sel" style="">
                                                <option value="">Select one...</option>
                                                <option value="Oral">Oral</option>
                                                <option value="Rectal">Rectal</option>
                                                <option value="I.V">I.V</option>
                                                <option value="I.M">I.M</option>
                                                <option value="S.C">S.C</option>
                                                <option value="Intraspinal Injection">Intraspinal Injection</option>
                                                <option value="Inhalation">Inhalation</option>
                                                <option value="Vaginal">Vaginal</option>
                                                <option value="Aural">Aural</option>
                                                <option value="Intranasal">Intranasal</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-ta" class="col-md-3 control-label" ><?php echo get_phrase('frequency:'); ?></label>
                                        <div class="col-md-3">
                                             <select class="form-control" id="freq_sel" style="">
                                                <option value="">Select one...</option>
                                                <option value="1">stat</option>
                                                <option value="1">n/a</option>
                                                <option value="24">Once Hourly</option>
                                                <option value="1">Once Daily</option>
                                                <option value="2">Twice Daily</option>
                                                <option value="3">Thrice Daily</option>
                                                <option value="4">Four Times Daily</option>
                                                <option value="0.1429">Once Weekly</option>
                                                <option value="0.2857">Twice Weekly</option>
                                                <option value="0.4286">Thrice Weekly</option>
                                                <option value="0.5714">Four Times Weekly</option>
                                                <option value="1">Mane</option>
                                                <option value="1">Nocte</option>
                                                <option value="4">Qid/Qds</option>
                                                <option value="1">P.R.N</option>
                                            </select>
                                        </div>
                                        <label for="field-ta" class="col-md-3 control-label" ><?php echo get_phrase('duration:'); ?></label>
                                        <div class="col-md-3">
                                            <input type="text"  name="duration_qty" id="duration_qty" class="form-control" style="width:50px;float:left" >
                                            <select class="form-control" id="duration_type" style="width:100px;float:left">
                                                <option value="">Select one...</option>
                                                <option value="1">stat</option>
                                                <option value="1">n/a</option>
                                                <option value="0.04167">Hours</option>
                                                <option value="1">days</option>
                                                <option value="7">weeks</option>
                                                <option value="30">months</option>
                                                <option value="1">Single Dose</option>
                                                <option value="1">Continous</option>
                                                <option value="1">When Needed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-ta" class="col-md-3 control-label" ><?php echo get_phrase('note:'); ?></label>
                                        <div class="col-md-9 compose-message-editor">
                                            <textarea row="25" class="form-control" name="medication" 
                                                id="medication_note" style="height:50px"></textarea>
                                        </div>
                                    </div>
                                    <h4 class="add-patient-sub-title pull-left"><?php echo get_phrase('prescription_list'); ?></h4>
                                    <a href="#" id="add_presc" class="btn btn-success btn-md pull-right"><?php echo get_phrase('add_prescription'); ?></a>
                                    <div class="form-group" style="height:500px">
                                        <table class="table table-bordered table-striped datatable" id="table-presc-list">
                                            <thead>
                                                <tr>
                                                    <th style="width:50px"><?php echo get_phrase('no');?></th>
                                                    <th><?php echo get_phrase('prescription');?></th>
                                                    <th style="width:100px"><?php echo get_phrase('action');?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <h4 class="add-patient-sub-title"><?php echo get_phrase('Summary');?></h4>
                                <div class="col-md-12" style="height:465px" id="pharmacy_summary">
                                    <?php
                                        if (count($cons_id)>0){
                                           $arr_pharmacy = $this->db->get_where("pharmacy_request",array("cons_id"=>$cons_id))->result_array();
                                           if (count($arr_pharmacy)>0){
                                               foreach($arr_pharmacy as $row){
                                                    $req_id = $row["id"];
                                                    $this->db->order_by("timestamp","desc");
                                                    $presc_list = $this->db->get_where("prescription",array("req_id"=>$req_id))->result_array();
                                                    $olddate="";
                                                    for($i=0;$i<count($presc_list);$i++){
                                                        $date = date("Y-m-d",$row["timestamp"]);   
                                                        if ($olddate!=$date){
                                                            $olddate = $date;
                                                            echo $date."<hr/>";  
                                                        }
                                                        $n = $i+1;
                                                        echo $n.".  ".$presc_list[$i]["medication"]."<br/>".$presc_list[$i]["note"]."<br/><br/>";
                                                    };
                                               }
                                            } 
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div id="tabs-9" class="tab-pane ">
                            <div class="col-sm-12 col-md-6">
                                <form role="form" class="form-horizontal form-groups-bordered" >
                                    <div class="form-group">
                                        <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('Type_laboratory_name_and_press_enter'); ?></label>
                                        <div class="col-md-9">
                                            <select id="lab-select" name="lab-select" class="form-control select2" placeholder=<?php echo get_phrase('type_search_term');?>>
                                                <option value=""><?php echo get_phrase('type_search_term'); ?></option>
                                                <optgroup label="<?php echo get_phrase('laboratory'); ?>">
                                                    <?php  $this->db->order_by('ItemName' , 'asc');
                                                        $all_info= $this->db->get_where('items',array("category"=>"LABORATORY"))->result_array();
                                                        foreach ($all_info as $item){ ?>
                                                        <option value=<?php echo $item['ItemCode']; ?>><?php echo $item['ItemName']; ?></option>        
                                                    <?php } ?>
                                                </optgroup>    
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                         <h4 class="add-patient-sub-title"><?php echo get_phrase('laboratory_request_list');?></h4>
                                         <div class="form-control col-md-12 " id="lab_req_list" style="height:390px; margin-left:15px;"></div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <h4 class="add-patient-sub-title"><?php echo get_phrase('laboratory_summary');?></h4>
                                <div class="form-control col-md-12 " id="lab_summary_editor" style="height:465px; margin-left:15px;overflow:scroll">
                                    <?php
                                        if (count($cons_id)>0){
                                            $arr_lab_req = $this->db->get_where("lab_request",array("cons_id"=>$cons_id))->result_array();
                                            $arr_status = array("Pending","Process","Complete");
                                            foreach($arr_lab_req as $req){
                                                $icode = $req["itemcode"];
                                                $iname = $this->db->get_where("items",array("ItemCode"=>$icode))->result_array()[0]["ItemName"];
                                                $time = date("Y-m-d H:i:s",$req["end_time"]);
                                                $status = $req["status"];
                                                echo "Date : ".$time."<br/><br/>";
                                                echo "Lab Request - [".$arr_status[$status]."]<br/>";
                                                echo $iname."<br/><br/>";
                                                echo "Lab Result"."<br/>";
                                                $result = $this->db->get_where("lab_result",array("req_id"=>$req["id"]))->row()->result;
                                                echo $result;
                                                echo "<br/><hr/>";
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div id="tabs-10" class="tab-pane ">
                            <div class="col-sm-12 col-md-6">
                                <form role="form" class="form-horizontal form-groups-bordered" >
                                    <div class="form-group">
                                        <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('Type_Radiology_name_and_press_enter'); ?></label>
                                        <div class="col-md-9">
                                            <select id="rad-select" name="rad-select" class="form-control select2" placeholder=<?php echo get_phrase('type_search_term');?>>
                                                <option value=""><?php echo get_phrase('type_search_term'); ?></option>
                                                <optgroup label="<?php echo get_phrase('radiology'); ?>">
                                                    <?php  $this->db->order_by('ItemName' , 'asc');
                                                        $all_info= $this->db->get_where('items',array("category"=>"RADIOLOGY"))->result_array();
                                                        foreach ($all_info as $item){ ?>
                                                        <option value=<?php echo $item['ItemCode']; ?>><?php echo $item['ItemName']; ?></option>        
                                                    <?php } ?>
                                                </optgroup>    
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                         <h4 class="add-patient-sub-title"><?php echo get_phrase('Radiology_request_list');?></h4>
                                         <div class="form-control col-md-12 " id="rad_req_list" style="height:390px; margin-left:15px;"></div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <h4 class="add-patient-sub-title"><?php echo get_phrase('Radiology_summary');?></h4>
                                <div class="form-control col-md-12 " id="rad_summary_editor" style="height:465px; margin-left:15px;overflow:scroll">
                                    <?php
                                        if (count($cons_id)>0){
                                            $arr_lab_req = $this->db->get_where("rad_request",array("cons_id"=>$cons_id))->result_array();
                                            $arr_status = array("Pending","Process","Complete");
                                            foreach($arr_lab_req as $row){
                                                $icode = $row["itemcode"];
                                                $iname = $this->db->get_where("items",array("ItemCode"=>$icode))->result_array()[0]["ItemName"];
                                                $time = date("Y-m-d",$row["end_time"]);
                                                $status = $row["status"];
                                                echo "Date : ".$time."<hr/>";
                                                echo "Rad Request - [".$arr_status[$status]."]<br/>";
                                                echo $iname."<hr/>";
                                                echo "Rad Result"."<br/>";
                                                echo "<br/>";
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div id="tabs-11" class="tab-pane ">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
    if(strlen($param3)>0) {?>
    <script>
        var queueId = "<?php echo $param3;?>";
        var transId = "<?php echo $triage['trans_id'];?>";
        var patientType = "<?php echo $triage['patient_type'];?>";
    </script>
<?php }?>
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
        var receptID = "<?php echo $recept_id;?>",
            consID = "<?php echo $cons_id;?>";
        var pharmacy_cart=[], globalPharmacyCartNum =0 ;    

</script>
<script type="text/javascript">
//table box event
    jQuery(window).load(function ()
    {
        var $ = jQuery;
        $("#current_history_wysiwyg").wysihtml5();
        $("#physical_exam_wysiwyg").wysihtml5();
        $("#diag_wysiwyg").wysihtml5();
        //$("#medication_wysiwyg").wysihtml5();
        
        //current history edit
        $("#symptom-select").on("change",function(){
           var sym = $(this).find("option:selected").text();
           var hisText = $("#current_history_wysiwyg").parent().find(".wysihtml5-sandbox").contents().find("body").html();
           hisText += "<br/>" + sym+";";
           $("#current_history_wysiwyg").parent().find(".wysihtml5-sandbox").contents().find("body").html(hisText);
        });
        saveCurrentHistory = function(){
            var hisText = $("#current_history_wysiwyg").parent().find(".wysihtml5-sandbox").contents().find("body").html();
            if (consID.length>0){
                var data={};
                data["cons_id"]=consID;
                data["content"] = hisText;
                data["queue_id"] = queueId;
                $.post(baseUrl+"index.php?modal/savecurrenthistory",data,function(){});
            }
        };
        //physical examination edit
        savePhysicalExam = function(){
            var text = $("#physical_exam_wysiwyg").parent().find(".wysihtml5-sandbox").contents().find("body").html();
            if (consID.length>0){
                var data={};
                data["cons_id"]=consID;
                data["content"] = text;
                data["queue_id"] = queueId;
                $.post(baseUrl+"index.php?modal/savephysicalexam",data,function(){});
            }
        };
         //diagnosis history edit
        $("#icd10-select").on("change",function(){
           var icd10 = $(this).find("option:selected").text();
           var hisText = $("#diag_wysiwyg").parent().find(".wysihtml5-sandbox").contents().find("body").html();
           hisText += "<br/>" + icd10+";";
           $("#diag_wysiwyg").parent().find(".wysihtml5-sandbox").contents().find("body").html(hisText);
        });
        //diagnosis summary edit
        $("#diag-select").on("change",function(){
           var diag = $(this).find("option:selected").text(),
               val = $(this).find("option:selected").val() ;
           makeSuperBox($("#diag_summary_editor"),diag,val);
        });
        //make super box
        function makeSuperBox(el,diag,val){
           //var textEl = $("#diag_summary_editor");
           if ((typeof val=="undefined") || (val.length==0)) return;
           var temp = $("<div></div>")
                        .text(diag)
                        .data("diag",diag)
                        .data("val",val)
                        .addClass("superbox")
                        .appendTo(el);
            $("<a href='#'></a>")
                .html("<i class='entypo-cancel'></i>")
                .on("click",function(e){
                    e.preventDefault();
                    $(this).parent().remove();
                })
                .appendTo(temp);
        };
        function displayDiagSummaryFromData(data){
           $.each(data.split(","),function(){
               if (this.length==0) return;
                makeSuperBox($("#diag_summary_editor"),this);
           })
        };
         <?php
            if (isset($arr) && count($arr)>0){
                $diag_summaries = $arr[0]["diag_items"];
                echo "displayDiagSummaryFromData('$diag_summaries');";              
            }
        ?>
        //save diagnosis information
        saveDiagnosis = function(){
            var text = $("#diag_wysiwyg").parent().find(".wysihtml5-sandbox").contents().find("body").html();
            if (consID.length>0){
                var data={};
                data["cons_id"]=consID;
                data["content"] = text;
                data["queue_id"] = queueId;
                data["diag_summaies"]="";
                $("#diag_summary_editor").find(".superbox").each(function(){
                    var $this = $(this);
                    data["diag_summaies"] +=$this.data("diag")+",";
                });
                $.post(baseUrl+"index.php?modal/savediagnosishistory",data,function(){});
            }
        }
        // theatre select box edit
         $("#theatre-select").on("change",function(){
           var theatre = $(this).find("option:selected").text(),
                val = $(this).find("option:selected").val();
           makeSuperBox($("#theatre_req_list"),theatre);
        });
        // pharmacy save
        //prescription table in pharmacy
        var prescTboby = $("#table-presc-list").find("tbody");
        $("#add_presc").on("click",function(e){
            e.preventDefault();
            var cart={},presc="";
            cart["drug_id"]=$("#drug-select").val();
            presc += $("#drug-select").find("option:selected").text();
            cart["dosage_qty"]=eval($("#dosage_qty").val())||0;
            if (cart["dosage_qty"]==0) return;
            cart["dosage_type"]=$("#dosagetype_sel").val()||"";
            if (cart["dosage_type"].length==0) return;
            presc += " - " + cart["dosage_qty"] + " " + cart["dosage_type"];
            cart["route"]=$("#route_sel").val()||"";
            if (cart["route"].length==0) return;
            presc += " - " + cart["route"];
            cart["freq_val"]=$("#freq_sel").val()||"";
            if (cart["freq_val"].length==0) return;
            cart["freq"]=$("#freq_sel").find("option:selected").text()||"";
            presc += " - " + cart["freq"];
            cart["dura_qty"]=eval($("#duration_qty").val())||0;
            if (cart["dura_qty"]==0) return;
            cart["dura_type"]=$("#duration_type").find("option:selected").text()||"";
            cart["dura_type_val"]=eval($("#duration_type").val())||0;
            if (cart["dura_type_val"]==0) return;
            cart["drug_qty"]=Math.round(cart["dura_qty"]*cart["dosage_qty"]*cart["dura_type_val"]*cart["freq_val"]);
            if (cart["drug_qty"]==0) return;
            presc += " - " + cart["dura_qty"] + " " + cart["dura_type"];
            presc += " - " + cart["drug_qty"];
            cart["note"] = $("#medication_note").val();
            cart["prescription"] = presc;
            presc += "<br/>" + cart["note"];
            cart["status"]=0;
            pharmacy_cart[pharmacy_cart.length] =cart;
            globalPharmacyCartNum++;
            //insert tabel list
            var $tr = $("<tr></tr>").appendTo(prescTboby);
            $("<td></td>").html(pharmacy_cart.length).appendTo($tr);
            $("<td></td>").html(presc).appendTo($tr);
            var aTag = "<a href='#' id='del_cart_item_"+globalPharmacyCartNum+"' class=\"btn btn-danger btn-sm btn-icon icon-left\"><i class=\"entypo-cancel\"></i>Delete</a>";
            $("<td></td>").html(aTag).appendTo($tr);
            //delete cart item function
            $("#del_cart_item_"+globalPharmacyCartNum).on("click",function(e){
                e.preventDefault();
                var nTr=$(this).parents('tr')[0];
                var id = eval($(nTr).children().eq(0).text())-1;
                var recarts = [],num=0;
                $.each(pharmacy_cart,function(n){
                    if (n!=id) {
                        recarts[recarts.length] = this;
                        prescTboby.find("tr").eq(n).children().eq(0).html(recarts.length);    
                    }
                });
                pharmacy_cart = recarts;
                nTr.remove();
            });
        });
        savePharmacy = function(b){
            if (consID.length>0){
                var data={};
                data["cons_id"]=consID;
                data["recept_id"]= receptID;
                data["patient_id"] = patientId;
                data["presc_list"] = function(){
                    var res=[];
                    $.each(pharmacy_cart,function(n){
                        if (this["status"]==0) {
                            res[res.length] = this;
                        }
                    });
                    return res;
                }();
                if (data["presc_list"].length<1) return;
                $.post(baseUrl+"index.php?modal/savepharmacy",data,function(res){
                    if (res=="success"){
                        $.alert("Sent pharmacy request to pharmacist successfully","Success");
                        $html = "Today" +"<hr/>";
                        $.each(pharmacy_cart,function(id){
                            $html += (id+1)+". "+this["prescription"] +"<br/>";
                            $html += this["note"]+"<br/>";
                        });
                        $("#pharmacy_summary").prepend( $html);
                        pharmacy_cart=[];
                        prescTboby.find("tr").remove();
                    }
                });
            }
        };
        //send pharmacy request to pharmacist
        $("#send-pharmacy").on("click",function(){
            savePharmacy();
        });
        // lab select box editor
        
        $("#lab-select").on("change",function(){
           var lab = $(this).find("option:selected").text(),
           val = $(this).find("option:selected").val();
           makeSuperBox($("#lab_req_list"),lab,val);
        });
        //send lab request
        saveLabratory = function(){
            if (consID.length>0){
                var data={};
                data["cons_id"]=consID;
                data["recept_id"]= receptID;
                data["patient_id"] = patientId;
                data["req_list"] = "";
                $("#lab_req_list").find(".superbox").each(function(){
                    var $this = $(this);
                    data["req_list"] +=$this.data("val")+",";
                });
                data["req_list"] = data["req_list"].substr(0,data["req_list"].length-1);
                if (data["req_list"].length<1) return;
              //  if (b) data["status"] = 1;
                $.post(baseUrl+"index.php?modal/savelaboratory",data,function(res){
                    if (res=="success"){
                        $.alert("Sent pharmacy request to pharmacist successfully","Success");
                    }
                });
            }
        };
        // radiology select box editor
        
        $("#rad-select").on("change",function(){
           var lab = $(this).find("option:selected").text(),
           val = $(this).find("option:selected").val();
           makeSuperBox($("#rad_req_list"),lab,val);
        });
        //send Rad request
        saveRadiology = function(b){
            if (consID.length>0){
                var data={};
                data["cons_id"]=consID;
                data["recept_id"]= receptID;
                data["patient_id"] = patientId;
                data["req_list"] = "";
                $("#rad_req_list").find(".superbox").each(function(){
                    var $this = $(this);
                    data["req_list"] +=$this.data("val")+",";
                });
                
                data["req_list"] = data["req_list"].substr(0,data["req_list"].length-1);
                if (data["req_list"].length<1) return;
             //   if (b) data["status"] = 1;
                $.post(baseUrl+"index.php?modal/saveradiology",data,function(res){
                    if (res=="success"){
                        $.alert("Sent radiology request to radilogist successfully","Success");
                    }
                });
            }
        };
        // main save function
        
        $("#update-consultation").on("click",function(e){
            e.preventDefault();
            var data={};
            data["recept_id"]= receptID;
            data["queue_id"] = queueId;
            data["patient_id"] = patientId;
            $.post(baseUrl+"index.php?modal/saveconsultation",data,function(res){
                var resData = eval(res)[0];
                if (resData.msg=="success"){
                    if (consID.length==0) consID = resData.consID.toString();
                    $.alert("Consultation is updated successfully","Success");
                    $("#update-date").text('This Consultation was updated at '+resData.lastdate);
                    saveCurrentHistory();
                    savePhysicalExam();
                    saveDiagnosis();
                    savePharmacy();
                    saveLabratory();
                    saveRadiology();
                }else{
                    $.alert("while updating, some errors raised.","Error");
                }
            })
            
        })
    });
</script>