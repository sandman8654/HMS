<?php
// account_type: system account type of employess
// account_id: system user id
// tabs_type: active tab type
if ($account_type_str !="" && $account_id!=""){
    $sys_user_info = $this->db->get_where($account_type_str, array($account_type_str.'_id' => $account_id))->result_array();
    $rowsys=$sys_user_info[0];
    $single_emp_info = $this->db->get_where("employee", array("emp"=>$rowsys["emp_no"]))->result_array();
    $row = $single_emp_info[0];
    
}
if ($tabs_type=="") $tabs_type="personal_details";

?>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3 id="test-date"><?php echo get_phrase('employee_info'); ?></h3>
                </div>
            </div>
            
            <div class="panel-body">
               
                <div class="col-md-12 col-sm-12">
                    <ul class="nav nav-tabs bordered">
                        <li class="<?php if($tabs_type=='personal_details') echo 'active';?>"><a href="#tabs-1" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('personal_details'); ?></span></a></li>
                        <li class="<?php if($tabs_type=='salary_details') echo 'active';?>"><a href="#tabs-2" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('salary_details'); ?></span></a></li>
                        <li class="<?php if($tabs_type=='medical_details') echo 'active';?>"><a href="#tabs-3" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('medical_details'); ?></span></a></li>
                        <li class="<?php if($tabs_type=='emergancy_contact') echo 'active';?>"><a href="#tabs-4" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('emergancy_contact'); ?></span></a></li>
                        <li class="<?php if($tabs_type=='education_experience') echo 'active';?>"><a href="#tabs-5" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('education_&_experience'); ?></span></a></li>
                        <li class="<?php if($tabs_type=='payslip_details') echo 'active';?>"><a href="#tabs-6" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('payslip_details'); ?></span></a></li>
                        <li class="<?php if($tabs_type=='skills_hobbies') echo 'active';?>"><a href="#tabs-7" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('skills_&_hobbies'); ?></span></a></li>
             <!--           <li class="<?php if($tabs_type=='sys_user_profile') echo 'active';?>"><a href="#tabs-8" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('system_user_profile'); ?></span></a></li>-->
                    </ul>
                    <div  class="tab-content recep-tab">
                        <div id="tabs-1" class="tab-pane <?php if($tabs_type=='personal_details') echo 'active';?>">
                            <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url().'index.php?admin/'.$account_type_str.'/update_emp/'.$account_id.'/personal_details' ; ?>" method="post" enctype="multipart/form-data">
                                <div class="col-md-12 col-sm-12">
                                    <h4 class="add-patient-sub-title"><?php echo get_phrase('personal_details'); ?></h4>
                                     <div class="pull-right" style="margin-bottom:10px">
                                        <input type="submit" class="btn btn-success btn-md" value="Save" />
                                        <a href="<?php echo base_url().'index.php?admin/'.$account_type_str ;?>" class="btn btn-danger btn-md">Exit</a>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('employee_no'); ?></label>
                                        <div class="col-sm-9">
                                            <input disabled type="text" name="empno" class="form-control"  value="<?php echo $rowsys['emp_no']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <?php
                                            $name = implode(" ",array($row["fname"],$row["mname"],$row["lname"]));
                                            $fn=$mn=$ln="";
                                            if (trim($name)=="") {
                                                $name = $rowsys["name"];
                                                $fullname = explode(" ", $name);
                                                $fn = $fullname[0];
                                                if (count($fullname) == 2){ $ln = $fullname[1];}
                                                if (count($fullname) == 3){ $mn = $fullname[1];$ln = $fullname[2];}
                                            }else{
                                                $fn = $row["fname"];
                                                $mn =$row["mname"];
                                                $ln = $row["lname"];
                                            }
                                        ?>
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('first_name*'); ?></label>
                                        <div class="col-sm-9">
                                            <input required type="text" name="fname" class="form-control" value="<?php echo $fn; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('middle_name'); ?></label>
                                        <div class="col-sm-9">
                                            <input  type="text" name="mname" class="form-control" value="<?php echo $mn; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('last_name*'); ?></label>
                                        <div class="col-sm-9">
                                            <input required type="text" name="lname" class="form-control" value="<?php echo $ln; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('birth_date'); ?></label>

                                        <div class="col-sm-9">
                                            <input type="text" name="birth_date" class="form-control datepicker" value="<?php echo $row['dob']; ?>" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('marriage_status'); ?></label>
                                        <div class="col-sm-9">
                                            <select name="marital" class="form-control selectboxit">
                                                <option value="single" <?php if ($row['marital'] == 'single')echo 'selected';?>>
                                                    <?php echo get_phrase('single'); ?>
                                                </option>
                                                <option value="engaged" <?php if ($row['marital'] == 'engaged')echo 'selected';?>>
                                                    <?php echo get_phrase('engaged'); ?>
                                                </option>
                                                <option value="married" <?php if ($row['marital'] == 'married')echo 'selected';?>>
                                                    <?php echo get_phrase('married'); ?>
                                                </option>
                                                <option value="divorced" <?php if ($row['marital'] == 'divorced')echo 'selected';?>>
                                                    <?php echo get_phrase('divorced'); ?>
                                                </option>
                                                <option value="widowed" <?php if ($row['marital'] == 'widowed')echo 'selected';?>>
                                                    <?php echo get_phrase('widowed'); ?>
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('language'); ?></label>
                                        <div class="col-sm-9">
                                            <select name="language" class="form-control selectboxit">
                                                <option value=""><?php echo get_phrase('select_language'); ?></option>
                                                <?php
                                                    $lang_info = $this->db->get("languages")->result_array();
                                                    foreach($lang_info as $item){ ?>
                                                        <option value="<?php echo $item['name']; ?>"><?php echo $item['name']; ?></option>
                                                    <?php } ?>
                                            </select>
                                            <div id="lang_list" style="margin-top:10px">
                                                <?php 
                                                    $lang_str = explode(";",$row["languages"]);
                                                    foreach($lang_str as $lang){ ?>
                                                        <input type="hidden" name="languages[]" value="<?php echo $lang; ?>"/>
                                                <?php    }
                                                ?>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('gender'); ?></label>

                                        <div class="col-sm-9">
                                            <select name="gender" class="form-control selectboxit">
                                                <option value=""><?php echo get_phrase('select_gender'); ?></option>
                                                <option value="male" <?php if ($row['gender'] == 'male')echo 'selected';?>>
                                                    <?php echo get_phrase('male'); ?>
                                                </option>
                                                <option value="female" <?php if ($row['gender'] == 'female')echo 'selected';?>>
                                                    <?php echo get_phrase('female'); ?>
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('ID_no*'); ?></label>
                                        <div class="col-sm-9">
                                            <input  type="text" name="idno" class="form-control" requiured  value="<?php echo $row['idno']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('pIN_no'); ?></label>
                                        <div class="col-sm-9">
                                            <input  type="text" name="pinno" class="form-control"   value="<?php echo $row['pinno']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('phone*'); ?></label>
                                        <div class="col-sm-9">
                                            <input  type="text" name="phone" requiured class="form-control" id="field-1"  value="<?php echo $rowsys['phone']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('phone2'); ?></label>
                                        <div class="col-sm-9">
                                            <input  type="text" name="phone2" class="form-control" id="field-1"  value="<?php echo $row['phone2']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email'); ?></label>
                                        <div class="col-sm-9">
                                            <input  type="email" name="email" class="form-control"  value="<?php echo $rowsys['email']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('address'); ?></label>
                                        <div class="col-sm-9">
                                            <textarea  name="address" class="form-control" ><?php echo $rowsys['address']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><?php echo get_phrase('image'); ?></label>

                                        <div class="col-sm-9">

                                            <div class="fileinput fileinput-new" >
                                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
                                                    <img src="<?php echo $this->crud_model->get_image_url($account_type , $account_id);?>" alt="...">
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
                                
                            </form>
                        </div>
                        <div id="tabs-2" class="tab-pane <?php if($tabs_type=='salary_details') echo 'active';?>">
                            <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url().'index.php?admin/'.$account_type_str.'/update_emp/'.$account_id.'/salary_details' ; ?>" method="post" enctype="multipart/form-data">
                                <div class="col-md-12 col-sm-12">
                                    <h4 class="add-patient-sub-title"><?php echo get_phrase('salary_details_information'); ?></h4>
                                    <div class="pull-right" style="margin-bottom:10px">
                                        <input type="submit" class="btn btn-success btn-md" value="Save" />
                                        <a href="<?php echo base_url().'index.php?admin/'.$account_type_str ;?>" class="btn btn-danger btn-md">Exit</a>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('basic_salary*'); ?></label>
                                        <div class="col-sm-9">
                                            <input required type="text" name="salary" class="form-control"  value="<?php echo $row['salary']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('D.O.E*'); ?></label>
                                        <div class="col-sm-9">
                                            <input required type="text" name="doe" class="form-control datepicker" value="<?php echo $row['employdate']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('employee_type'); ?></label>
                                        <div class="col-sm-9">
                                            <select name="emptype" class="form-control selectboxit">
                                                <option value="permanent" <?php if (strtolower($row['emptype']) == 'permanent')echo 'selected';?>>
                                                    <?php echo get_phrase('permanent'); ?>
                                                </option>
                                                <option value="contract" <?php if (strtolower($row['emptype']) == 'contract')echo 'selected';?>>
                                                    <?php echo get_phrase('contract'); ?>
                                                </option>
                                                <option value="temporary" <?php if (strtolower($row['emptype']) == 'temporary')echo 'selected';?>>
                                                    <?php echo get_phrase('temporary'); ?>
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group emptype <?php if (strtolower($row['emptype']) != 'contract')echo 'hidden';?> ">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('contract_from'); ?></label>
                                        <div class="col-sm-9">
                                            <input  type="text" name="contractfrom" class="form-control datepicker" value="<?php echo $row['contractfrom']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group emptype <?php if (strtolower($row['emptype']) != 'contract')echo 'hidden';?>">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('contract_to'); ?></label>
                                        <div class="col-sm-9">
                                            <input  type="text" name="contractto" class="form-control datepicker" value="<?php echo $row['contractto']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('department*'); ?></label>
                                        <div class="col-sm-9">
                                            <select required name="dept" class="form-control selectboxit">
                                                <option value=""><?php echo get_phrase('select_department'); ?></option>
                                                <?php
                                                    $this->db->order_by("name");
                                                    $info = $this->db->get("department")->result_array();
                                                    foreach($info as $item){ ?>
                                                        <option value="<?php echo $item['name']; ?>" <?php if (strtolower($row['dept']) == strtolower($item['name'])) echo 'selected';?>><?php echo $item['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('position*'); ?></label>
                                        <div class="col-sm-9">
                                            <select required name="position" class="form-control selectboxit">
                                                <option value=""><?php echo get_phrase('select_position'); ?></option>
                                                <?php
                                                    $this->db->order_by("name");
                                                    $info = $this->db->get("positions")->result_array();
                                                    foreach($info as $item){ ?>
                                                        <option value="<?php echo $item['name']; ?>" <?php if (strtolower($row['position']) == strtolower($item['name'])) echo 'selected';?> ><?php echo $item['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('job_description'); ?></label>
                                        <div class="col-sm-9">
                                            <textarea  name="jobdesc" class="form-control" style="height:100px" ><?php echo $row['jobdesc']; ?></textarea>
                                        </div>
                                    </div>
                                    
                                </div>   
                            </form>
                        </div>
                        <div id="tabs-3" class="tab-pane <?php if($tabs_type=='medical_details') echo 'active';?>">
                            <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url().'index.php?admin/'.$account_type_str.'/update_emp/'.$account_id.'/medical_details' ; ?>" method="post" enctype="multipart/form-data">
                                <h4 class="add-patient-sub-title"><?php echo get_phrase('medical_details_information'); ?></h4>
                                <div class="pull-right" style="margin-bottom:10px">
                                    <input type="submit" class="btn btn-success btn-md" value="Save" />
                                    <a href="<?php echo base_url().'index.php?admin/'.$account_type_str ;?>" class="btn btn-danger btn-md">Exit</a>
                                </div>
                                <div style="clear:both"></div>
                                <div class="form-group">
                                    <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('blood_group'); ?></label>
                                    <div class="col-sm-9">
                                        <select name="bgroup" class="form-control">
                                            <option value=""><?php echo get_phrase('select_blood_group'); ?></option>
                                            <option value="A+" <?php if ($row['bgroup'] == 'A+')echo 'selected';?>>A+</option>
                                            <option value="A-" <?php if ($row['bgroup'] == 'A-')echo 'selected';?>>A-</option>
                                            <option value="B+" <?php if ($row['bgroup'] == 'B+')echo 'selected';?>>B+</option>
                                            <option value="B-" <?php if ($row['bgroup'] == 'B-')echo 'selected';?>>B-</option>
                                            <option value="AB+" <?php if ($row['bgroup'] == 'AB+')echo 'selected';?>>AB+</option>
                                            <option value="AB-" <?php if ($row['bgroup'] == 'AB-')echo 'selected';?>>AB-</option>
                                            <option value="O+" <?php if ($row['bgroup'] == 'O+')echo 'selected';?>>O+</option>
                                            <option value="O-" <?php if ($row['bgroup'] == 'O-')echo 'selected';?>>O-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('Known_Health_Problems/Alergies'); ?></label>
                                    <div class="col-sm-9">
                                        <textarea  name="alergy" class="form-control" style="height:300px" ><?php echo $row['alergy']; ?></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="tabs-4" class="tab-pane <?php if($tabs_type=='emergancy_contact') echo 'active';?>">
                            <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url().'index.php?admin/'.$account_type_str.'/update_emp/'.$account_id.'/emergancy_contact' ; ?>" method="post" enctype="multipart/form-data">
                                <div class="col-md-12 col-sm-12">
                                    <h4 class="add-patient-sub-title"><?php echo get_phrase('emergancy_contact_information'); ?></h4>
                                    <div class="pull-right" style="margin-bottom:10px">
                                        <input type="submit" class="btn btn-success btn-md" value="Save" />
                                        <a href="<?php echo base_url().'index.php?admin/'.$account_type_str ;?>" class="btn btn-danger btn-md">Exit</a>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('emergency_name*'); ?></label>
                                        <div class="col-sm-9">
                                            <input required type="text" name="ename" class="form-control"  value="<?php echo $row['ename']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('emergency_phone*'); ?></label>
                                        <div class="col-sm-9">
                                            <input required type="text" name="ephone" class="form-control"  value="<?php echo $row['ephone']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('postal_address'); ?></label>
                                        <div class="col-sm-9">
                                            <input type="text" name="epostal" class="form-control"  value="<?php echo $row['epostal']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="tabs-5" class="tab-pane <?php if($tabs_type=='education_experience') echo 'active';?>">
                            <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url().'index.php?admin/'.$account_type_str.'/update_emp/'.$account_id.'/education_experience' ; ?>" method="post" enctype="multipart/form-data">
                                <div class="col-md-12 col-sm-12">
                                    <h4 class="add-patient-sub-title"><?php echo get_phrase('education_information'); ?></h4>
                                    <div class="pull-right" style="margin-bottom:10px">
                                        <input type="submit" class="btn btn-success btn-md" value="Save" />
                                        <a href="<?php echo base_url().'index.php?admin/'.$account_type_str ;?>" class="btn btn-danger btn-md">Exit</a>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Course'); ?></label>
                                        <div class="col-sm-9">
                                            <select name="course" class="form-control selectboxit">
                                                <option value=""><?php echo get_phrase('select_course'); ?></option>
                                                <?php
                                                    $info = $this->db->get("courses")->result_array();
                                                    foreach($info as $item){ ?>
                                                        <option value="<?php echo $item['name']; ?>"><?php echo $item['name']; ?></option>
                                                    <?php } ?>
                                            </select>
                                            <div id="course_list" style="margin-top:10px">
                                                <?php 
                                                    $str = explode(";",$row["education"]);
                                                    foreach($str as $course){ ?>
                                                        <input type="hidden" name="courses[]" value="<?php echo $course; ?>"/>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('experience'); ?></label>
                                        <div class="col-sm-9">
                                            <select name="experience" class="form-control selectboxit">
                                                <option value=""><?php echo get_phrase('select_experience'); ?></option>
                                                <?php
                                                    $info = $this->db->get("experience")->result_array();
                                                    foreach($info as $item){ ?>
                                                        <option value="<?php echo $item['name']; ?>"><?php echo $item['name']; ?></option>
                                                    <?php } ?>
                                            </select>
                                            <div id="exp_list" style="margin-top:10px">
                                                <?php 
                                                    $str = explode(";",$row["experience"]);
                                                    foreach($str as $item){ ?>
                                                        <input type="hidden" name="exps[]" value="<?php echo $item; ?>"/>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="tabs-6" class="tab-pane <?php if($tabs_type=='payslip_details') echo 'active';?>">
                            <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url().'index.php?admin/'.$account_type_str.'/update_emp/'.$account_id.'/payslip_details' ; ?>" method="post" enctype="multipart/form-data">
                                <div class="col-md-12 col-sm-12">
                                    <h4 class="add-patient-sub-title"><?php echo get_phrase('payslip_information'); ?></h4>
                                    <div class="pull-right" style="margin-bottom:10px">
                                        <input type="submit" class="btn btn-success btn-md" value="Save" />
                                        <a href="<?php echo base_url().'index.php?admin/'.$account_type_str ;?>" class="btn btn-danger btn-md">Exit</a>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('bank'); ?></label>
                                        <div class="col-sm-9">
                                            <select name="bank" class="form-control selectboxit">
                                                <option value=""><?php echo get_phrase('select_bank'); ?></option>
                                                <?php
                                                    $info = $this->db->get("banktbl")->result_array();
                                                    foreach($info as $item){ ?>
                                                        <option value="<?php echo $item['id']; ?>" <?php if($item['id']==$row["bid"]) echo 'selected';?> ><?php echo $item['name']; ?></option>
                                                    <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('a/C_no'); ?></label>
                                        <div class="col-sm-9">
                                            <input type="text" name="acno" class="form-control"  value="<?php echo $row['acno']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('NHIF_no'); ?></label>
                                        <div class="col-sm-9">
                                            <input type="text" name="nhif" class="form-control"  value="<?php echo $row['nhif']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('NSSF_no'); ?></label>
                                        <div class="col-sm-9">
                                            <input type="text" name="nssf" class="form-control"  value="<?php echo $row['nssf']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="tabs-7" class="tab-pane <?php if($tabs_type=='skills_hobbies') echo 'active';?>">
                            <div class="col-sm-12 col-md-12">
                                <form role="form" class="form-horizontal form-groups-bordered" onkeypress="return event.keyCode != 13;" action="<?php echo base_url().'index.php?admin/'.$account_type_str.'/update_emp/'.$account_id.'/skills_hobbies' ; ?>" method="post" enctype="multipart/form-data">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="pull-right" style="margin-bottom:10px">
                                            <input type="submit" class="btn btn-success btn-md" value="Save" />
                                            <a href="<?php echo base_url().'index.php?admin/'.$account_type_str ;?>" class="btn btn-danger btn-md">Exit</a>
                                        </div>
                                        <h4 class="add-patient-sub-title"><?php echo get_phrase('skill_information'); ?></h4>
                                        <div style="clear:both"></div>
                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('skill'); ?></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="skill" class="form-control" placeholder="Type and Press Enter..."/> 
                                                <div id="skill_list" style="margin-top:10px">
                                                    <?php 
                                                        $str = explode(";",$row["skills"]);
                                                        foreach($str as $item){ ?>
                                                            <input type="hidden" name="skills[]" value="<?php echo $item; ?>"/>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="add-patient-sub-title"><?php echo get_phrase('hobby_information'); ?></h4>
                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('hobby'); ?></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="hobby" class="form-control" placeholder="Type and Press Enter..."/>
                                                <div id="hobby_list" style="margin-top:10px">
                                                    <?php 
                                                        $str = explode(";",$row["hobbies"]);
                                                        foreach($str as $item){ ?>
                                                            <input type="hidden" name="hobbies[]" value="<?php echo $item; ?>"/>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="tabs-8" class="tab-pane <?php if($tabs_type=='sys_user_profile') echo 'active';?>">
                            <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url().'index.php?admin/'.$account_type_str.'/update_emp/'.$account_id.'/sys_user_profile' ; ?>" method="post" enctype="multipart/form-data">
                                <div class="col-md-12 col-sm-12">
                                    <h4 class="add-patient-sub-title"><?php echo get_phrase('system_user_information'); ?></h4>
                                    <div class="pull-right" style="margin-bottom:10px">
                                        <input type="submit" class="btn btn-success btn-md" value="Save" />
                                        <a href="<?php echo base_url().'index.php?admin/'.$account_type_str ;?>" class="btn btn-danger btn-md">Exit</a>
                                    </div>
                                    <div style="clear:both"></div>
                                   
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('system_user_name'); ?></label>
                                        <div class="col-sm-5">
                                            <input required type="text" name="username" class="form-control"  value="<?php echo $rowsys['user_name']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><?php echo get_phrase('current_password');?></label>
                                        <div class="col-sm-5">
                                            <input type="password" class="form-control" name="password" value=""/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><?php echo get_phrase('new_password');?></label>
                                        <div class="col-sm-5">
                                            <input type="password" class="form-control" name="new_password" value=""/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><?php echo get_phrase('confirm_new_password');?></label>
                                        <div class="col-sm-5">
                                            <input type="password" class="form-control" name="confirm_new_password" value=""/>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
// global variables
        var baseUrl = "<?php echo base_url();?>";
</script>
<script type="text/javascript">
//table box event
    jQuery(window).load(function ()
    {
        var $ = jQuery;
        
        //make super box
        function makeSuperBox(el,val){
           //var textEl = $("#diag_summary_editor");
           if ((typeof val=="undefined") || (val.length==0)) return;
           var temp = $("<div></div>")
                        .text(val)
                        .attr("id",val)
                        .addClass("superbox")
                        .appendTo(el);
            $("<a href='#'></a>")
                .html("<i class='entypo-cancel'></i>")
                .on("click",function(e){
                    e.preventDefault();
                    var val = $(this).parent().text();
                    el.find("input[value='"+val+"']").remove();
                    $(this).parent().remove();
                })
                .appendTo(temp);
        };
        $("input[name='languages[]']").each(function(){
            var val= $(this).val();
            makeSuperBox($("#lang_list"),val);
        });
        $("select[name='language']").on("change",function(){
            var val = $(this).val();
            var txt = $("#"+val).text();
            if (txt.length>0 || val=="" ) return;
            makeSuperBox($("#lang_list"),val);
            $("<input></input>")
            .attr({
                "type":"hidden",
                "name":"languages[]",
            }).val(val).appendTo($("#lang_list"));
        });
        $("input[name='courses[]']").each(function(){
            var val= $(this).val();
            makeSuperBox($("#course_list"),val);
        });
        $("select[name='course']").on("change",function(){
            var val = $(this).val();
            var txt = $("#"+val).text();
            if (txt.length>0 || val=="" ) return;
            makeSuperBox($("#course_list"),val);
            $("<input></input>")
            .attr({
                "type":"hidden",
                "name":"courses[]",
            }).val(val).appendTo($("#course_list"));
        });
        $("input[name='exps[]']").each(function(){
            var val= $(this).val();
            makeSuperBox($("#exp_list"),val);
        });
        $("select[name='experience']").on("change",function(){
            var val = $(this).val();
            var txt = $("#"+val).text();
            if (txt.length>0 || val=="" ) return;
            makeSuperBox($("#exp_list"),val);
            $("<input></input>")
            .attr({
                "type":"hidden",
                "name":"exps[]",
            }).val(val).appendTo($("#exp_list"));
        });
        $("select[name='emptype']").on("change", function(){
            var val = $(this).val();
            if (val!="contract") {
                $(".emptype").addClass("hidden");
            }else{
                $(".emptype").removeClass("hidden");
            }
        });

        //skill and hobby inputbox
        $("input[name='skills[]']").each(function(){
            var val= $(this).val();
            makeSuperBox($("#skill_list"),val);
        });
        $("input[name='hobbies[]']").each(function(){
            var val= $(this).val();
            makeSuperBox($("#hobby_list"),val);
        });
        $("input[name='skill']").on("keyup",function(e){
            e.preventDefault();
            $(this).focus();
            if(e.keyCode==13){
                var val= $(this).val();
                makeSuperBox($("#skill_list"),val);
                $(this).val("");
                $("<input></input>")
                .attr({
                    "type":"hidden",
                    "name":"skills[]",
                }).val(val).appendTo($("#skill_list"));
            }
        });
        $("input[name='hobby']").on("keyup",function(e){
            e.preventDefault();
            $(this).focus();
            if(e.keyCode==13){
                var val= $(this).val();
                makeSuperBox($("#hobby_list"),val);
                $(this).val("");
                $("<input></input>")
                .attr({
                    "type":"hidden",
                    "name":"hobbies[]",
                }).val(val).appendTo($("#hobby_list"));
            }
        });
        
    });
</script>