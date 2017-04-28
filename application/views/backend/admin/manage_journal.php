<button onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/add_journal_entry/');" 
    class="btn btn-primary pull-right" >
        <?php echo get_phrase('add_new_journal_entry'); ?>
</button>
<a href="<?php echo base_url();?>index.php?admin/journalentry/post" id="post-entry" class="btn btn-primary pull-right" style="margin-right:10px">
        <?php echo get_phrase('post_all_entries'); ?>
</a>
<div style="clear:both;"></div>
<br>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th><?php echo get_phrase('date');?></th>
            <th><?php echo get_phrase('credit');?></th>
            <th><?php echo get_phrase('debit');?></th>
            <th><?php echo get_phrase('amount');?></th>
            <th><?php echo get_phrase('description');?></th>
            <th><?php echo get_phrase('posted');?></th>
            <th><?php echo get_phrase('action');?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($journal_entry_info as $row) { ?>   
            <tr>
                <td><?php echo date("Y/m/d H:i:s",$row['stamp'])?></td>
                <td><?php echo $row['crname']?></td>
                <td><?php echo $row['drname']?></td>
                <td><?php echo $row['amount']?></td>
                <td><?php echo $row['description']?></td>
                <td><?php echo ($row['status']==1)?"Yes":"No"; ?></td>
                <?php $status = $row['status']; $tid = $row['transid']?>
                <td>
                    <?php if ($status == 0) {?>
                        <a href="#" data-tid="<?php echo $tid ?>" 
                            class="btn btn-danger btn-sm btn-icon icon-left">
                                <i class="entypo-pencil"></i>
                                Reverse
                        </a>
                    <?php } elseif($status==3) {
                        echo "reversed";
                    }else{
                        echo "cannot reverse";
                    }?>
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
            aaSorting:[[0,"desc"]],
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
