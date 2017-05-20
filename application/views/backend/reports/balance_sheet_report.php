<div class="DTTT_PrintMessage">
    <div class="col-sm-12 print-header">
        <p>Official Balance Sheet</p>
        <?php if ($as_at!=""){ ?>
        <p>As At: <?php echo $as_at; ?> </p>
        <?php } else { ?>
        <p>From: <?php echo $from; ?> To: <?php echo $to; ?> </p>
        <?php } ?>
    </div>
</div>
<?php 
    $diff = count($asset_bal_list) - count($lieq_bal_list);
?>
 <div class="col-sm-6" style="padding-right:0px" >
    <table class="table table-bordered table-striped datatable " >
        <thead>
            <tr>
                <th colspan=2 style="text-align:center"><?php echo get_phrase('Assets');?></th>
            </tr>
            <tr>
                <th><?php echo get_phrase('Item');?></th>
                <th><?php echo get_phrase('KShs');?></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($asset_bal_list as $item){ ?> 
                <tr>
                    <td><?php echo $item['item'];?></td>
                    <td><?php echo $item['kshs'];?></td>
                </tr>
            <?php } ?>

        </tbody>
        <tfoot>
            <tr>
                <th><?php echo get_phrase('Total_assets');?></th>
                <th><?php echo $total1;?></th>
            </tr>
        </tfoot>
    </table>
</div>
<div class="col-sm-6 "style="padding-left:0px">
    <table class="table table-bordered table-striped datatable " >
            
        <thead>
            <tr>
                <th colspan=2 style="text-align:center"><?php echo get_phrase('liabilities_&_equity');?></th>
            </tr>
            <tr>
                <th><?php echo get_phrase('Item');?></th>
                <th><?php echo get_phrase('KShs');?></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($lieq_bal_list as $item){ ?> 
                <tr>
                    <td><?php echo $item['item'];?></td>
                    <td><?php echo $item['kshs'];?></td>
                </tr>
            <?php } ?>
            <?php 
                if ($diff>0){?>
                        <tr>
                            <td colspan=2  rowspan=<?php echo $diff+1; ?>>&nbsp; </td>
                            
                        </tr>
                <?php 
                    for ($i=0;$i<$diff;$i++){ ?>
                        <tr>
                            <td style="visibility:hidden">&nbsp;</td> 
                        </tr>
                <?php   }
                ?>        
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th><?php echo get_phrase('Total_Liabilities_&_Equity');?></th>
                <th><?php echo $total2;?></th>
            </tr>
        </tfoot>
    </table>
</div>