<div class="DTTT_PrintMessage">
    <div class="col-sm-12 print-header">
        <p>Official Trial Balance Report</p>
        <?php if ($as_at!=""){ ?>
        <p>As At: <?php echo $as_at; ?> </p>
        <?php } else { ?>
        <p>From: <?php echo $from; ?> To: <?php echo $to; ?> </p>
        <?php } ?>
    </div>
</div> 
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th><?php echo get_phrase('Item');?></th>
            <th><?php echo get_phrase('Dr');?></th>
            <th><?php echo get_phrase('Cr');?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($trial_bal_list as $item){ ?> 
            <tr>
                <td><?php echo $item['item'];?></td>
                <td><?php echo $item['dr'];?></td>
                <td><?php echo $item['cr'];?></td>
            </tr>
        <?php } ?>

    </tbody>
    <tfoot>
        <tr>
            <th><?php echo get_phrase('Total');?></th>
            <th><?php echo $total_dr;?></th>
            <th><?php echo $total_cr;?></th>
        </tr>
    </tfoot>
</table>

