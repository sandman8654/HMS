
<h4 class="add-patient-sub-title"><?php echo get_phrase('Stock_request_list'); ?></h4>
<table class="table table-bordered table-striped datatable" id="table-streq-list">
    <thead>
        <tr>
            <th><?php echo get_phrase('request_date');?></th>
            <th><?php echo get_phrase('item_name');?></th>
            <th><?php echo get_phrase('issue_no');?></th>
            <th><?php echo get_phrase('From');?></th>
            <th><?php echo get_phrase('to');?></th>
            <th><?php echo get_phrase('pack');?></th>
            <th><?php echo get_phrase('unit');?></th>
            <th><?php echo get_phrase('part');?></th>
            <th><?php echo get_phrase('action');?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($stock_req_list as $row) {?>
             <tr>
                <td> <?php echo $row["TransDate"]; ?> </td>
                <td> <?php echo $row["ItemName"]; ?> </td>
                <td> <?php echo $row["IssueNo"]; ?> </td>
                <td> <?php echo $row["Dep2"]; ?> </td>
                <td> <?php echo $row["Dep1"]; ?> </td>
                <td> <?php echo $row["Pack"]; ?> </td>
                <td> <?php echo $row["UnitBox"]; ?> </td>
                <td> <?php echo $row["PartBox"]; ?> </td>
                <td> <a  href="<?php echo base_url();?>index.php?admin/stocktransfer/transfer/<?php echo $row['TransNo']?>" 
                        class="btn btn-default btn-sm btn-icon icon-left" onclick="return checkConfirm('Would you like to transfer the stock request?');">
                            <i class="entypo-pencil"></i>
                            Transfer
                    </a>
                    <a href="<?php echo base_url();?>index.php?admin/stocktransfer/revoke/<?php echo $row['TransNo']?>" 
                        class="btn btn-danger btn-sm btn-icon icon-left" onclick="return checkConfirm('Would you like to revoke the stock request?');">
                            <i class="entypo-cancel"></i>
                            Revoke
                    </a> </td>
             </tr>
        <?php } ?>
    </tbody>
</table>

<script type="text/javascript">
    function checkConfirm(msg){
       var chk=confirm(msg);
        if(chk)
        {
          return true;  
        }
        else{
            return false;
        }
     
    }
    jQuery(window).load(function ()
    {
        var $ = jQuery;

        $("#table-streq-list").dataTable({
            "sPaginationType": "bootstrap",
            aaSorting:[[0,"desc"]],
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Highlighted rows
        $("#table-streq-list tbody input[type=checkbox]").each(function (i, el)
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