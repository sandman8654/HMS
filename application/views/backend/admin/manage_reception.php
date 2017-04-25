<a href="<?php echo base_url();?>index.php?admin/reception/register" 
    class="btn btn-primary pull-right">
        <?php echo get_phrase('add_reception'); ?>
</a>
<div style="clear:both;"></div>
<br>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th><?php echo get_phrase('reception_id');?></th>
            <th><?php echo get_phrase('receptionist_name');?></th>
            <th><?php echo get_phrase('patient_name');?></th>
            <th><?php echo get_phrase('reception_date');?></th>
            <th><?php echo get_phrase('options');?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($receptions_info as $row) { ?>   
            <tr>
                <td><?php echo $row['reception_id']?></td>
                <td><?php echo $row['receptionist_name']?></td>
                <td><?php echo $row['patient_name']?></td>
                <td><?php echo date('d/m/Y H:i:s',$row['reception_date'])?></td>
                <td>
                    <a  href="<?php echo base_url();?>index.php?admin/reception/view/<?php echo $row['reception_id']?>" 
                        class="btn btn-default btn-sm btn-icon icon-left">
                            <i class="entypo-pencil"></i>
                            view
                    </a>
                    <a href="<?php echo base_url();?>index.php?admin/reception/delete/<?php echo $row['reception_id']?>" 
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