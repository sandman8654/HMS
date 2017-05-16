<button onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/add_laboratory_request/');" 
    class="btn btn-primary pull-right">
        <?php echo get_phrase('new_request'); ?>
</button>
<div style="clear:both;"></div>
<br>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th><?php echo get_phrase('request_id');?></th>
            <th><?php echo get_phrase('reception_id');?></th>
            <th><?php echo get_phrase('patient');?></th>
            <th><?php echo get_phrase('item');?></th>
            <th><?php echo get_phrase('request_date');?></th>
            <th><?php echo get_phrase('status');?></th>
            <th><?php echo get_phrase('options');?></th>
        </tr>
    </thead>

    <tbody>
        <?php 
            $labreq_info = $this->crud_model->select_lab_req_info();
        ?>
        <?php foreach ($labreq_info as $row) { ?>   
            <tr>
                <td><?php echo $row['req_id']?></td>
                <td><?php echo $row['recept_id']?></td>
                <td><?php echo $row['patient_info']?></td>
                <td><?php echo $row['item_name']?></td>
                <td><?php echo $row['req_date']?></td>
                <td><?php echo $row['status']?></td>
                <td>
                    <a  href="<?php echo base_url();?>index.php?admin/labreq/edit/<?php echo $row['req_id']?>" 
                        class="btn btn-default btn-sm btn-icon icon-left">
                            <i class="entypo-pencil"></i>
                            start
                    </a>
                    <a href="<?php echo base_url();?>index.php?admin/labreq/delete/<?php echo $row['req_id']?>" 
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

        var table = $("#table-2").dataTable({
            "sPaginationType": "bootstrap",
            aaSorting:[[4,"desc"]],
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