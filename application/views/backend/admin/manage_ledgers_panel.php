<button onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/add_ledgers/');" 
    class="btn btn-primary pull-right" >
        <?php echo get_phrase('add_new_ledger'); ?>
</button>
<div style="clear:both;"></div>
<br>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th><?php echo get_phrase('ledger_no');?></th>
            <th><?php echo get_phrase('ledger_name');?></th>
            <th><?php echo get_phrase('type');?></th>
            <th><?php echo get_phrase('category');?></th>
            <th><?php echo get_phrase('balance');?></th>
            <th><?php echo get_phrase('action');?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($ledger_info as $row) { ?>   
            <tr>
                <td><?php echo $row['ledgerid']?></td>
                <td><?php echo $row['name']?></td>
                <td><?php echo $row['type']?></td>
                <td><?php echo $row['category']?></td>
                <td><?php echo $row['bal']?></td>
                <td>
                   <a  onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/edit_ledger/<?php echo $row['ledgerid']?>');" 
                        class="btn btn-default btn-sm btn-icon icon-left">
                            <i class="entypo-pencil"></i>
                            Edit
                    </a>
                    <a href="<?php echo base_url();?>index.php?admin/ledgerspanel/delete/<?php echo $row['ledgerid']?>" 
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
            aaSorting:[[0,"asc"]],
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
<script type="text/javascript">
    jQuery(window).load(function ()
    {
        var $ = jQuery;
        $("a.btn").on("click",function(e){
            var $this = $(this);
            if ($this.attr("href")!="#") return;
            e.preventDefault();
            $.confirm({
                title:"Reverse Confirm",
                content:"You are about to reverse this particular entry. <br/> Continue?",
                buttons: {
                    confirm: function () {
                         $.get("<?php echo base_url();?>index.php?/modal/reversejournalentry/"+$this.data("tid"),
                            function(res){
                                if (res=="success"){
                                    var p = $this.parents()[0];
                                    $this.remove();
                                    $(p).html("reversed");
                                }else{
                                    $.alert("Got some errors!","Error");
                                }
                            });
                    },
                    cancel: function () {
                     //   $.alert('Canceled!');
                    }
                }
            })
           
        })
    });
</script>
