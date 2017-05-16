    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <h3><?php echo get_phrase('add_radiology_request'); ?></h3>
                    </div>
                </div>

                <div class="panel-body">

                    <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/radreq/create" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('selelect_reception:'); ?></label>
                            <div class="col-md-9">
                                <select required id="patient-select" name="pinfo" class="form-control " placeholder=<?php echo get_phrase('type_search_patient');?>>
                                    <option value=""><?php echo get_phrase('type_search_patient'); ?></option>
                                    <optgroup label="<?php echo get_phrase('recept_no-_patient'); ?>">
                                        <?php  
                                            $all_info= $this->db->get_where('sendpatients',array("sendto"=>"RAD"))->result_array();
                                            foreach ($all_info as $item){ ?>
                                            <option value="<?php echo $item['recept_id'].'-'.$item['patient_id']; ?>"><?php echo $item['recept_id']." - ".$this->crud_model->select_patient_info_by_patient_id($item["patient_id"])[0]["name"]; ?></option>                                            <?php } ?>
                                    </optgroup>    
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('radiology_name:'); ?></label>
                            <div class="col-md-9">
                                <select required id="drug-select" name="itemcode" class="form-control " placeholder=<?php echo get_phrase('type_search_radiology');?>>
                                    <option value=""><?php echo get_phrase('type_search_radiology'); ?></option>
                                    <optgroup label="<?php echo get_phrase('radiology_name'); ?>">
                                        <?php  $this->db->order_by('ItemName' , 'asc');
                                            $all_info= $this->db->get_where('items',array("category"=>"RADIOLOGY"))->result_array();
                                            foreach ($all_info as $item){ ?>
                                            <option value=<?php echo $item['ItemCode']; ?>><?php echo $item['ItemName']; ?></option>        
                                        <?php } ?>
                                    </optgroup>    
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3 control-label col-sm-offset-2">
                            <input type="submit" class="btn btn-success" value="Submit">
                        </div>
                    </form>

                </div>

            </div>

        </div>
    </div>
