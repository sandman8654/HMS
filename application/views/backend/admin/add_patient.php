<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('patient_info_title'); ?></h3>
                </div>
            </div>

            <div class="panel-body">
                <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/patient/create" method="post" enctype="multipart/form-data">
                    <div class="col-md-5 col-sm-12 has-right-border">
                        <h4 class="add-patient-sub-title"><?php echo get_phrase('patient_detail_info_title'); ?></h4>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name'); ?></label>
                            <div class="col-sm-9">
                                <input required type="text" name="name" class="form-control" id="field-1"  >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email'); ?></label>

                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control" id="field-1" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('user_name'); ?></label>

                            <div class="col-sm-9">
                                <input type="text" name="username" class="form-control" id="field-1" >
                            </div>
                        </div>    
                                                
                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('address'); ?></label>

                            <div class="col-sm-9">
                                <textarea name="address" class="form-control" id="field-ta"></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('phone'); ?></label>

                            <div class="col-sm-9">
                                <input type="text" name="phone" class="form-control" id="field-1" >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('sex'); ?></label>

                            <div class="col-sm-9">
                                <select name="sex" class="form-control">
                                    <option value="male"><?php echo get_phrase('male'); ?></option>
                                    <option value="female"><?php echo get_phrase('female'); ?></option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('birth_date'); ?></label>

                            <div class="col-sm-9">
                                <input required type="text" name="birth_date" class="form-control datepicker" >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('age');  ?></label>

                            <div class="col-sm-9">
                                <input type="text" name="age" class="form-control"  onkeypress="return false;"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('blood_group'); ?></label>

                            <div class="col-sm-9">
                                <select name="blood_group" class="form-control">
                                    <option value=""><?php echo get_phrase('select_blood_group'); ?></option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-ta" class="control-label col-sm-3" ><?php echo get_phrase('paitent_type').": "; ?></label>
                            <div class="col-sm-9">
                                <input type="radio" name="inout_status"  value='1'>Inpatient</input>
                                <input type="radio" name="inout_status" checked value='0' style="margin-left:10px">Outpatient</input>
                                <input type="radio" name="inout_status"  value='2' style="margin-left:10px">Maternity</input>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('image'); ?></label>

                            <div class="col-sm-9">

                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
                                        <img src="http://placehold.it/200x150" alt="...">
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
                    <div class="col-md-5 col-sm-12 ">
                        
                        <h4 class="add-patient-sub-title"><?php echo get_phrase('patient_guardian_info_title'); ?></h4>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" name="rel_name" class="form-control" id="field-1" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('relation_patient'); ?></label>

                            <div class="col-sm-9">
                                    <select name="rel_group" class="form-control">
                                    <option value=""><?php echo get_phrase('select_rel_group'); ?></option>
                                    <option value="father"><?php echo get_phrase('rel_father');?></option>
                                    <option value="mother"><?php echo get_phrase('rel_mother');?></option>
                                    <option value="husband"><?php echo get_phrase('rel_husband');?></option>
                                    <option value="wife"><?php echo get_phrase('rel_wife');?></option>    
                                    <option value="brother"><?php echo get_phrase('rel_brother');?></option>
                                    <option value="sister"><?php echo get_phrase('rel_sister');?></option>
                                    <option value="uncle"><?php echo get_phrase('rel_uncle');?></option>
                                    <option value="aunt"><?php echo get_phrase('rel_aunt');?></option>
                                    <option value="cousin"><?php echo get_phrase('rel_cousin');?></option>
                                    <option value="son"><?php echo get_phrase('rel_son');?></option>
                                    <option value="doughter"><?php echo get_phrase('rel_daughter');?></option>
                                    <option value="others"><?php echo get_phrase('rel_others');?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('rel_phone'); ?></label>

                            <div class="col-sm-9">
                                <input type="text" name="rel_phone" class="form-control" id="field-1" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('rel_address'); ?></label>

                            <div class="col-sm-9">
                                <textarea name="rel_address" class="form-control" id="field-ta"></textarea>
                            </div>
                        </div>
                            <h4 class="add-patient-sub-title"><?php echo get_phrase('patient_employer_info_title'); ?></h4>
                            <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('employer_name'); ?></label>

                            <div class="col-sm-9">
                                <input type="text" name="emp_name" class="form-control" id="field-1" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('employer_no'); ?></label>

                            <div class="col-sm-9">
                                <input type="text" name="emp_no" class="form-control" id="field-1" >
                            </div>
                        </div>
                        <h4 class="add-patient-sub-title"><?php echo get_phrase('insurance_scheme_details'); ?></h4>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('insurer'); ?></label>
                            <div class="col-sm-9">
                                <select name="insur_group" id="insur_group" class="form-control">
                                    <?php $all_insur_info= $this->crud_model->select_insurer_info();
                                        foreach ($all_insur_info as $item){ ?>
                                        <option value=<?php echo $item['id']; ?> data-cmpname="<?php echo $item['cmpname']; ?>"><?php echo $item['name'] ?></option>        
                                    <?php } ?>       
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('insur_card_no'); ?></label>

                            <div class="col-sm-9">
                                <input type="text" name="insur_card_no" class="form-control" id="field-1" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('insur_company_name'); ?></label>

                            <div class="col-sm-9">
                                <input disabled type="text" name="insur_comp_name" id="insur_comp_name" class="form-control" id="field-1" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('other_note'); ?></label>

                            <div class="col-sm-9">
                                <textarea name="other_note" class="form-control" id="field-ta"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2  control-label">
                        <input type="submit" class="btn btn-success" value="Submit">
                        <a href="<?php echo base_url(); ?>index.php?admin/patient" class="btn btn-danger btn-md">Exit</a>
                    </div> 
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(window).load(function (){
        var $ = jQuery;
        //insurer select box event
        $("#insur_group").on('change',function(){
           var $this = $(this);
           var $item = $this.find("option:selected");
           $("#insur_comp_name").val($item.data("cmpname"));
        });
 
      
        var $item = $("#insur_group").find("option:selected");
        $("#insur_comp_name").val($item.data("cmpname"));

        var birthDate = $("input[name='birth_date']").val()||"";
        if (birthDate != "") $("input[name='age']").val(age(birthDate));
        $("input[name='birth_date']").on("change",function(){
            var birthDate = $(this).val();
            $("input[name='age']").val(age(birthDate));
        });

    });
</script>