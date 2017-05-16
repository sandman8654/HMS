<a href="<?php echo base_url();?>index.php?admin/patient/register" 
    class="btn btn-primary pull-right">
        <?php echo get_phrase('add_patient'); ?>
</a>
<div style="clear:both;"></div>
<br>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th><?php echo get_phrase('image');?></th>
            <th><?php echo get_phrase('name');?></th>
            <th><?php echo get_phrase('email');?></th>
            <th><?php echo get_phrase('phone');?></th>
            <th><?php echo get_phrase('sex');?></th>
            <th><?php echo get_phrase('birth_date');?></th>
            <th><?php echo get_phrase('blood_group');?></th>
            <th><?php echo get_phrase('inout_status');?></th>
            <th><?php echo get_phrase('register_date');?></th>
            <th><?php echo get_phrase('options');?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($patient_info as $row) { ?>   
            <tr>
                <td><img src="<?php echo $this->crud_model->get_image_url('patient' , $row['patient_id']);?>" class="img-circle" width="40px" height="40px">
                <?php if ($row['status']==0){ ?>
                <div class="patient-new-badge">new</div>
                <?php } ?>
                </td>
                <td><?php echo $row['name']?></td>
                <td><?php echo $row['email']?></td>
                <td><?php echo $row['phone']?></td>
                <td><?php echo $row['sex']?></td>
                <td><?php echo date('m/d/Y', $row['birth_date']); ?></td>
                <td><?php echo $row['blood_group']?></td>
                <td><?php 
                    if ($row['inout_status']==1)echo "Inpatient";
                    if ($row['inout_status']==0)echo "Outpatient";
                    if ($row['inout_status']==2)echo "Maternity";
                    ?></td>
                <td><?php echo date('d/m/Y', $row['registered_date']); ?></td>
                <td>
                    
                    <a  href="<?php echo base_url();?>index.php?admin/patient/edit/<?php echo $row['patient_id']?>" 
                        class="btn btn-default btn-sm btn-icon icon-left">
                            <i class="entypo-pencil"></i>
                            Edit
                    </a>
                    <?php 
                        if ($this->session->userdata('admin_login') ||$this->session->userdata('receptionist_login')){
                            if($row["status"]==0){ ?>
                         <a  href="<?php echo base_url();?>index.php?admin/reception/registerfrompm/<?php echo $row['patient_id']?>" 
                            class="btn btn-default btn-sm btn-icon icon-left">
                                <i class="entypo-pencil"></i>
                                Make Reception
                        </a>
                        <?php   } }
                    ?>
                    <a href="<?php echo base_url();?>index.php?admin/patient/delete/<?php echo $row['patient_id']?>" 
                        class="btn btn-danger btn-sm btn-icon icon-left" onclick="return checkDelete();">
                            <i class="entypo-cancel"></i>
                            Delete
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script type="text/javascript">
    jQuery(window).load(function ()
    {
        var $ = jQuery;

        $("#table-2").dataTable({
            "sPaginationType": "bootstrap",
            aaSorting:[[9,"desc"]],
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