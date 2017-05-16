<?php
    $sup_proc_list = $this->db->get_where("inpatient_sup_proc",array("patient_id"=>$patient_id))->result_array();
?>
<form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/inpatients/update/<?php echo $patient_id; ?>/supandproc" method="post" enctype="multipart/form-data">
    <h4 class="add-patient-sub-title pull-left"><?php echo get_phrase('supplies_and_procedure');?></h4>
    <div class="pull-right" style="margin-bottom:5px;margin-right:30px;">
        <input type="submit" class="btn btn-success" value="Update">
        <a href="<?php echo base_url()."index.php?admin/$patient_type";?>" class="btn btn-danger btn-md">Exit</a>
    </div>
    <div style="clear:both;"></div>
    <div class="col-sm-12 col-md-12" >
        <a onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/add_inpatient_supplies_and_procedure/<?php echo $patient_id?>');" 
            class="btn btn-primary " >
                <?php echo get_phrase('add_data'); ?>
        </a>
        <div style="clear:both;"></div>
        <br>
        <table class="table table-bordered table-striped datatable" id="table-2">
             
            <thead>
                <tr>
                    <th><?php echo get_phrase('date');?></th>
                    <th><?php echo get_phrase('Sterile_gloves');?></th>
                    <th><?php echo get_phrase('Catheter');?></th>
                    <th><?php echo get_phrase('Urine_bag');?></th>
                    <th><?php echo get_phrase('Branula');?></th>
                    <th><?php echo get_phrase('Fluid_I.V._giving_set');?></th>
                    <th><?php echo get_phrase('Blood_giving_set');?></th>
                    <th><?php echo get_phrase('Blood_bag');?></th>
                    <th><?php echo get_phrase('N.G._Tube');?></th>
                    <th><?php echo get_phrase('Sulfratule');?></th>
                    <th><?php echo get_phrase('I.V._fluids');?></th>
                    <th><?php echo get_phrase('Dressing');?></th>
                    <th><?php echo get_phrase('R.O.S');?></th>
                    <th><?php echo get_phrase('Catheterization');?></th>
                    <th><?php echo get_phrase('HB');?></th>
                    <th><?php echo get_phrase('Blood_sugar');?></th>
                    <th><?php echo get_phrase('Physiotherapy');?></th>
                    <th><?php echo get_phrase('Occupational_Therapy');?></th>
                    <th><?php echo get_phrase('Others');?></th>
                    <th><?php echo get_phrase('Options');?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($sup_proc_list as $item){ ?>
                    <th><?php echo $item['date'];?></th>
                    <th><?php echo $item['sg'];?></th>
                    <th><?php echo $item['cath'];?></th>
                    <th><?php echo $item['ub'];?></th>
                    <th><?php echo $item['bra'];?></th>
                    <th><?php echo $item['fivgs'];?></th>
                    <th><?php echo $item['bgs'];?></th>
                    <th><?php echo $item['bb'];?></th>
                    <th><?php echo $item['ngt'];?></th>
                    <th><?php echo $item['sulf'];?></th>
                    <th><?php echo $item['ivf'];?></th>
                    <th><?php echo $item['dres'];?></th>
                    <th><?php echo $item['ros'];?></th>
                    <th><?php echo $item['cathz'];?></th>
                    <th><?php echo $item['hb'];?></th>
                    <th><?php echo $item['bs'];?></th>
                    <th><?php echo $item['phys'];?></th>
                    <th><?php echo $item['ot'];?></th>
                    <th><?php echo $item['other'];?></th>
                    <th>
                        <?php $date = "/".strtotime($item["date"]);?>
                        <a  onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/edit_inpatient_sup_and_proc/<?php echo $patient_id.$date; ?>');" 
                            class="btn btn-default btn-sm btn-icon icon-left">
                                <i class="entypo-pencil"></i>
                                <?php echo get_phrase('edit'); ?>

                        </a>
                        <a  href="<?php echo base_url();?>index.php?admin/inpatients/delete/<?php echo $item["id"].'/supandproc'; ?>" 
                            class="btn btn-danger btn-sm btn-icon icon-left" onclick="return checkDelete();" >
                                <i class="entypo-cancel"></i>
                                <?php echo get_phrase('delete'); ?>
                    </th>
                <?php } ?>
            </tbody>
        </table>
    </div>
</form>

<script type="text/javascript">
//admission tab process
    jQuery(window).load(function ()
    {
        var $ = jQuery;
        $("#table-2").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Highlighted rows
        $("#table-2 tbody input[type=checkbox]").each(function (i, el)
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