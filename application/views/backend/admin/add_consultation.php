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
                                        <h4 class="add-patient-sub-title col-md-4 col-sm-4"><?php echo get_phrase('medications');?></h4>
                                        <a href="#" id="send-pharmacy" class="btn btn-success btn-md">Send Request</a>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 compose-message-editor">
                                            <textarea row="25" class="form-control" data-stylesheet-url="assets/css/wysihtml5-color.css" name="medication" 
                                                id="medication_wysiwyg" style="height:450px"><?php
                                                if (count($cons_id)>0){
                                                    $arr_pharmacy = $this->db->get_where("pharmacy_request",array("cons_id"=>$cons_id))->result_array();
                                                    if (count($arr_pharmacy)>0){
                                                        $row = $arr_pharmacy[0];
                                                        echo $row["medications"]; 
                                                    } 
                                                }
                                            ?></textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <h4 class="add-patient-sub-title"><?php echo get_phrase('Summary');?></h4>
                                <div class="col-md-12" style="height:465px" id="pharmacy_summary">
                                    <?php
                                        if (count($cons_id)>0){
                                            if (count($arr_pharmacy)>0){
                                                $row = $arr_pharmacy[0];
                                                $date = date("Y-m-d",$row["timestamp"]);     
                                                $status = $row["status"];
                                                $status_arr=array("Pending","Posted","Completed");
                                                echo $date." [".$status_arr[$status]."] <br/>";
                                                echo $row["medications"]; 
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
                                            foreach($arr_lab_req as $row){
                                                $icode = $row["itemcode"];
                                                $iname = $this->db->get_where("items",array("ItemCode"=>$icode))->result_array()[0]["ItemName"];
                                                $time = date("Y-m-d",$row["end_time"]);
                                                $status = $row["status"];
                                                echo "Date : ".$time."<hr/>";
                                                echo "Lab Request - [".$arr_status[$status]."]<br/>";
                                                echo $iname."<hr/>";
                                                echo "Lab Result"."<br/>";
                                                echo "<br/>";
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

</script>
<script type="text/javascript">
//table box event
    jQuery(window).load(function ()
    {
        var $ = jQuery;
        $("#current_history_wysiwyg").wysihtml5();
        $("#physical_exam_wysiwyg").wysihtml5();
        $("#diag_wysiwyg").wysihtml5();
        $("#medication_wysiwyg").wysihtml5();
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
        savePharmacy = function(b){
            var text = $("#medication_wysiwyg").parent().find(".wysihtml5-sandbox").contents().find("body").html();
            if (consID.length>0){
                var data={};
                data["cons_id"]=consID;
                data["recept_id"]= receptID;
                data["patient_id"] = patientId;
                data["content"] = text;
                if (b) data["status"] = 1;
                if (data["content"].length<1) return;
                $.post(baseUrl+"index.php?modal/savepharmacy",data,function(res){
                    if (b&&res=="success"){
                        $.alert("Sent pharmacy request to pharmacist successfully","Success");
                    }
                });
            }
        };
        //send pharmacy request to pharmacist
        $("#send-pharmacy").on("click",function(){
            savePharmacy(true);
        });
        // lab select box editor
        
        $("#lab-select").on("change",function(){
           var lab = $(this).find("option:selected").text(),
           val = $(this).find("option:selected").val();
           makeSuperBox($("#lab_req_list"),lab,val);
        });
        //send lab request
        saveLabratory = function(b){
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
                if (b) data["status"] = 1;
                $.post(baseUrl+"index.php?modal/savelaboratory",data,function(res){
                    if (b&&res=="success"){
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
                if (b) data["status"] = 1;
                $.post(baseUrl+"index.php?modal/saveradiology",data,function(res){
                    if (b&&res=="success"){
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