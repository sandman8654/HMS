<div class="DTTT_PrintMessage">
    <div class="col-sm-12 print-header">
        <p>Official Income Statement Report</p>
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
            <th><?php echo get_phrase('Kshs');?></th>
            <th><?php echo get_phrase('Kshs');?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($income_state_list as $item){ ?> 
            <tr>
                <td><?php echo $item['item'];?></td>
                <td><?php echo $item['kshs1'];?></td>
                <td><?php echo $item['kshs2'];?></td>
            </tr>
        <?php } ?>

    </tbody>
    <tfoot>
        <tr>
            <th><?php echo get_phrase('Net Income');?></th>
            <th><?php echo $total1;?></th>
            <th><?php echo $total2;?></th>
        </tr>
    </tfoot>
</table>
