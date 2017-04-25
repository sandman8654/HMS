<?php
$medicine_category_info = $this->db->get('medicine_category')->result_array();
$single_medicine_info   = $this->db->get_where('medicine', array('medicine_id' => $param2))->result_array();
foreach ($single_medicine_info as $row) {
?>

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <h3><?php echo get_phrase('edit_medicine'); ?></h3>
                    </div>
                </div>

                <div class="panel-body">

                    <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?pharmacist/medicine/update/<?php echo $row['medicine_id']; ?>" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name'); ?></label>

                            <div class="col-sm-5">
                                <input type="text" name="name" class="form-control" id="field-1" value="<?php echo $row['name']; ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('medicine_category'); ?></label>

                            <div class="col-sm-5">
                                <select name="medicine_category_id" class="form-control">
                                    <option value=""><?php echo get_phrase('select_medicine_category'); ?></option>
                                    <?php foreach ($medicine_category_info as $row2) { ?>
                                        <option value="<?php echo $row2['medicine_category_id']; ?>" <?php if ($row['medicine_category_id'] == $row2['medicine_category_id']) echo 'selected'; ?>>
                                            <?php echo $row2['name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('description'); ?></label>

                            <div class="col-sm-9">
                                <textarea name="description" class="form-control" id="field-ta"><?php echo $row['description']; ?></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('price'); ?></label>

                            <div class="col-sm-5">
                                <input type="number" name="price" class="form-control" id="field-1" value="<?php echo $row['price']; ?>">
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('total_quantity'); ?></label>

                            <div class="col-sm-5">
                                <input type="number" name="total_quantity" class="form-control" value="<?php echo $row['total_quantity']; ?>" />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('manufacturing_company'); ?></label>

                            <div class="col-sm-5">
                                <input type="text" name="manufacturing_company" class="form-control" id="field-1" value="<?php echo $row['manufacturing_company']; ?>">
                            </div>
                        </div>

                        <div class="col-sm-3 control-label col-sm-offset-2">
                            <input type="submit" class="btn btn-success" value="Update">
                        </div>
                    </form>

                </div>

            </div>

        </div>
    </div>
<?php } ?>