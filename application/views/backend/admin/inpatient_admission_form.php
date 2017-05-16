<form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/inpatients/update/<?php echo $patient_id; ?>/admission" method="post" enctype="multipart/form-data">
    <div class="pull-right" style="margin-bottom:5px;margin-right:30px;">
        <input type="submit" class="btn btn-success" value="Update">
        <a href="<?php echo base_url()."index.php?admin/$patient_type";?>" class="btn btn-danger btn-md">Exit</a>
    </div>
    <div class="col-sm-12 col-md-6 has-right-border" style="height:500px;">
        <h4 class="add-patient-sub-title"><?php echo get_phrase('admission');?></h4>
        <a onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/add_admission_diag/<?php echo $patient_id?>');" 
            class="btn btn-primary pull-right">
                <?php echo get_phrase('add_admission_diagnosis'); ?>
        </a>
        <div style="clear:both;"></div>
        <br>
        <table class="table table-bordered table-striped datatable" id="table-admission">
            <thead>
                <tr>
                    <th><?php echo get_phrase('diagnosis');?></th>
                    <th><?php echo get_phrase('admit/Discharge_date');?></th>
                    <th><?php echo get_phrase('remarks_on_discharge');?></th>
                    <th><?php echo get_phrase('options');?></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($admission_diag as $item) { 
                    $type = ($item["type"]==0)?"Admitted":"Discharged";
                    ?>   
                    <tr>
                        <td><?php echo $item['diag_note']?></td>
                        <td><?php echo $item['date']." : ".$type?></td>
                        <td><?php echo $item['remark_on_discharge']?></td>
                        <td>
                            <a  onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/edit_admission_diag/<?php echo $patient_id."/".$item["diag_id"]?>');" 
                                class="btn btn-default btn-sm btn-icon icon-left">
                                    <i class="entypo-pencil"></i>
                                    <?php echo get_phrase('edit'); ?>

                            </a>
                            <a  href="<?php echo base_url();?>index.php?admin/inpatients/delete/<?php echo $item["diag_id"].'/admission/diag'; ?>" 
                                class="btn btn-danger btn-sm btn-icon icon-left" onclick="return checkDelete();">
                                    <i class="entypo-cancel"></i>
                                    <?php echo get_phrase('delete'); ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="col-sm-12 col-md-6" style="height: 500px;">
        <h4 class="add-patient-sub-title"><?php echo get_phrase('insrtuction_for_treatment_and_investigations');?></h4>
        <div class="form-group">
            <div class="col-md-12 ">
                <textarea row="25" class="form-control"   name="instruction_note" 
                    id="instruct_wysiwyg" style="height:200px"><?php
                        echo $admit_info["instruct_note"];
                    ?></textarea>
            </div>
        </div>
        <h4 class="add-patient-sub-title"><?php echo get_phrase('diet');?></h4>
        <div class="form-group">
            <div class="col-md-12 ">
                <textarea row="25" class="form-control"  name="diet_note" 
                    id="diet_wysiwyg" style="height:200px"><?php
                        echo $admit_info["diet_note"];
                    ?></textarea>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
//admission tab process
    jQuery(window).load(function ()
    {
        var $ = jQuery;
        $("#table-admission").dataTable({
            "sPaginationType": "bootstrap",
            aaSorting:[[1,"asc"]],
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Highlighted rows
        $("#table-admission tbody input[type=checkbox]").each(function (i, el)
        {
            var $this = $(el),
                    $p = $this.closest('tr');

            $(el).on('change', function ()
            {
                var is_checked = $this.is(':checked');

                $p[is_checked ? 'addClass' : 'removeClass']('highlight');
            });
        });

        // Replace Checboxes
        $(".pagination a").click(function (ev)
        {
            replaceCheckboxes();
        });
    
    });
</script>