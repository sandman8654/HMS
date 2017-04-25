<?php
$single_patient_info = $this->db->get_where('patient', array('patient_id' => $param2))->result_array();
foreach ($single_patient_info as $row) {
?>
   
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <h3><?php echo get_phrase('patient_info_title'); ?></h3>
                    </div>
                </div>

                <div class="panel-body">
                    <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/patient/update/<?php echo $row['patient_id']; ?>" method="post" enctype="multipart/form-data">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-5 col-sm-5 has-right-border">
                                <h4 class="add-patient-sub-title"><?php echo get_phrase('patient_detail_info_title'); ?></h4>
                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="name" class="form-control" id="field-1" value="<?php echo $row['name']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email'); ?></label>

                                    <div class="col-sm-9">
                                        <input type="email" name="email" class="form-control" id="field-1" value="<?php echo $row['email']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('address'); ?></label>

                                    <div class="col-sm-9">
                                        <textarea name="address" class="form-control" id="field-ta"><?php echo $row['address']; ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('phone'); ?></label>

                                    <div class="col-sm-9">
                                        <input type="text" name="phone" class="form-control" id="field-1"  value="<?php echo $row['phone']; ?>">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('sex'); ?></label>

                                    <div class="col-sm-9">
                                        <select name="sex" class="form-control">
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
                                        <input type="text" name="birth_date" class="form-control datepicker" id="field-1" value="<?php echo date('d/m/Y', $row['birth_date']); ?>" >
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('age'); ?></label>

                                    <div class="col-sm-9">
                                        <input type="number" name="age" class="form-control" id="field-1" value="<?php echo $row['age']; ?>">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('blood_group'); ?></label>

                                    <div class="col-sm-9">
                                        <select name="blood_group" class="form-control">
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
                                    <label for="field-ta" class="control-label col-sm-3" ><?php echo get_phrase('is_inpaitent?').": "; ?></label>
                                    <div class="col-sm-9">
                                        <input type="checkbox" name="inout_status" id="inout_status" <?php if ($row["inout_status"]==1) echo "checked" ?>></input>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('image'); ?></label>

                                    <div class="col-sm-9">

                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
                                                <img src="<?php echo $this->crud_model->get_image_url('patient' , $row['patient_id']);?>" alt="...">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                            <div>
                                                <span class="btn btn-white btn-file">
                                                    <span class="fileinput-new">Select image</span>
                                                    <span class="fileinput-exists">Change</span>
                                                    <input type="file" name="image" accept="image/*">
                                                </span>
                                                <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                    
                                
                            </div>
                            <div class="col-md-5 col-sm-5 ">
                                <h4 class="add-patient-sub-title"><?php echo get_phrase('patient_guardian_info_title'); ?></h4>
                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="rel_name" class="form-control" id="field-1" value="<?php echo $row['gname']; ?>" >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('relation_patient'); ?></label>

                                    <div class="col-sm-9">
                                        <select name="rel_group" class="form-control">
                                            <option value=""><?php echo get_phrase('select_rel_group'); ?></option>
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
                                        <input type="text" name="rel_phone" class="form-control" id="field-1" value="<?php echo $row['gcont']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('rel_address'); ?></label>

                                    <div class="col-sm-9">
                                        <textarea name="rel_address" class="form-control" id="field-ta"><?php echo $row['gaddress']; ?></textarea>
                                    </div>
                                </div>
                                <h4 class="add-patient-sub-title"><?php echo get_phrase('patient_employer_info_title'); ?></h4>
                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('employer_name'); ?></label>

                                    <div class="col-sm-9">
                                        <input type="text" name="emp_name" class="form-control" id="field-1" value="<?php echo $row['empname']; ?>" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('employer_no'); ?></label>

                                    <div class="col-sm-9">
                                        <input type="text" name="emp_no" class="form-control" id="field-1" value="<?php echo $row['empno']; ?>" >
                                    </div>
                                </div>
                                <h4 class="add-patient-sub-title"><?php echo get_phrase('insurance_scheme_details'); ?></h4>
                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('insurer'); ?></label>
                                    <div class="col-sm-9">
                                        <select name="insur_group" id="insur_group" class="form-control">
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
                                        <input type="text" name="insur_card_no" class="form-control" id="field-1" value="<?php echo $row['cardno']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('insur_company_name'); ?></label>

                                    <div class="col-sm-9">
                                        <input type="text" disabled name="insur_comp_name" id="insur_comp_name" class="form-control" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('other_note'); ?></label>

                                    <div class="col-sm-9">
                                        <textarea name="other_note" class="form-control" id="field-ta"><?php echo $row['odetails']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2 col-md-2  control-label">
                                <input type="submit" class="btn btn-success" value="Update">
                                <a href="<?php echo base_url(); ?>index.php?admin/patient" class="btn btn-danger btn-md">Exit</a>
                            </div> 
                        </div>   
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<script>
    jQuery(window).load(function (){
        var $ = jQuery;
        //insurer select box event
        $("#insur_comp_name").val($("#insur_group").find("option:selected").data("cmpname"));
        $("#insur_group").on('change',function(){
           var $this = $(this);
           var $item = $this.find("option:selected");
           $("#insur_comp_name").val($item.data("cmpname"));
        });
         $("#inout_status").on("click",function(){
            var st = $(this).prop("checked");
            $(this).val((st)?1:0);
        });
    });
</script>