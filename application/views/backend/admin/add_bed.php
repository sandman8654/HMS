<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('add_bed'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/bed/create" method="post" enctype="multipart/form-data">
                
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('bed_number'); ?></label>

                        <div class="col-sm-5">
                            <input required type="number" name="bed_number" class="form-control" id="field-1" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('room_number'); ?></label>

                        <div class="col-sm-5">
                            <input required type="text" name="room_number" class="form-control" id="field-1" >
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('type'); ?></label>

                        <div class="col-sm-5">
                            <select required name="type" class="form-control">
                                <option value=""><?php echo get_phrase('select_type'); ?></option>
                                <option value="Male Ward"><?php echo get_phrase('male_ward'); ?></option>
                                <option value="Female Ward"><?php echo get_phrase('female_ward'); ?></option>
                                <option value="Paediatrics"><?php echo get_phrase('paediatrics'); ?></option>
                                <option value="Maternity"><?php echo get_phrase('maternity'); ?></option>
                                <option value="Cabin"><?php echo get_phrase('cabin'); ?></option>
                                <option value="ICU"><?php echo get_phrase('icu'); ?></option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('description'); ?></label>

                        <div class="col-sm-9">
                            <textarea name="description" class="form-control" id="field-ta"></textarea>
                        </div>
                    </div>

                    <div class="col-sm-3 control-label col-sm-offset-1">
                        <input type="submit" class="btn btn-success" value="Submit">
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>