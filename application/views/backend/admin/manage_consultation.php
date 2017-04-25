
<div style="clear:both;"></div>
<br>
<h3><?php echo get_phrase('pending_list');?></h3>
<table class="table table-bordered table-striped datatable" id="table-pending-list">
    <thead>
        <tr>
            <th><?php echo get_phrase('reception_no');?></th>
            <th><?php echo get_phrase('queue_no');?></th>
            <th><?php echo get_phrase('patient_no');?></th>
            <th><?php echo get_phrase('patient_name');?></th>
            <th><?php echo get_phrase('sent_date');?></th>
            <th><?php echo get_phrase('options');?></th>
        </tr>
    </thead>

    <tbody>
        <?php 
        $pending_list = $this->crud_model->get_pending_list_for_consultation();
        foreach ($pending_list as $row) { ?>   
            <tr>
                <td><?php echo $row['recept_id']?></td>
                <td><?php echo $row['queue_id']?></td>
                <td><?php echo $row['patient_id']?></td>
                <td><?php echo $row['patient_name']?></td>
                <td><?php echo $row['sent_date']?></td>
                <td>
                    <a  href="<?php echo base_url();?>index.php?admin/consultation/register/<?php echo $row['patient_id']?>/<?php echo $row['queue_id']?>" 
                        class="btn btn-default btn-sm btn-icon icon-left">
                            <i class="entypo-pencil"></i>
                            Start 
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<h3><?php echo get_phrase('consultation_list');?></h3>
<table class="table table-bordered table-striped datatable" id="table-cons-list">
    <thead>
        <tr>
            <th><?php echo get_phrase('consultation_id');?></th>
            <th><?php echo get_phrase('patient_id');?></th>
            <th><?php echo get_phrase('patient_name');?></th>
            <th><?php echo get_phrase('last_review_date');?></th>
            <th><?php echo get_phrase('options');?></th>
        </tr>
    </thead>

    <tbody>
        <?php  $list = $this->crud_model->get_consultation_list();
            foreach ($list as $row) { ?>   
            <tr>
                <td><?php echo $row['cons_id']?></td>
                <td><?php echo $row['patient_id']?></td>
                <td><?php echo $row['patient_name']?></td>
                <td><?php echo $row['last_review_date']?></td>
                <td>
                    <a  href="<?php echo base_url();?>index.php?admin/consultation/register/<?php echo $row['patient_id']?>/<?php echo $row['queue_id']?>" 
                        class="btn btn-default btn-sm btn-icon icon-left">
                            <i class="entypo-pencil"></i>
                            Edit
                    </a>
                    <a href="<?php echo base_url();?>index.php?admin/consultation/delete/<?php echo $row['cons_id']?>" 
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
        $("#table-pending-list").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Highlighted rows
        $("#table-pending-list tbody input[type=checkbox]").each(function (i, el)
        {
            var $this = $(el),
                    $p = $this.closest('tr');

            $(el).on('change', function ()
            {
                var is_checked = $this.is(':checked');

                $p[is_checked ? 'addClass' : 'removeClass']('highlight');
            });
        });

        $("#table-cons-list").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Highlighted rows
        $("#table-cons-list tbody input[type=checkbox]").each(function (i, el)
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