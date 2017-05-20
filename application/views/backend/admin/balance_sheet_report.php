<div class="row">
    <div class="col-sm-12">
        <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?report/balance_sheet_report" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <div class="col-sm-3">
                    <div class = "col-sm-3">
                        <label for="" class="control-label pull-right">From:</label>
                    </div>
                    <div class = "col-sm-9">
                        <input name="from" type="text" class="form-control datepicker" value="<?php echo $from; ?>"></input>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class = "col-sm-3">
                        <label for="" class="control-label pull-right">To:</label>
                    </div>
                    <div class = "col-sm-9">
                        <input name="to" type="text" class="form-control datepicker" value="<?php echo $to; ?>"></input>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class = "col-sm-3">
                        <label for="" class="control-label pull-right">As At:</label>
                    </div>
                    <div class = "col-sm-9">
                        <input name="as_at" type="text" class="form-control datepicker" value="<?php echo $as_at; ?>"></input>
                    </div>
                </div>
                <div class="col-sm-2">
                    <input type="submit" value="View Balance Sheet" class="form-control btn btn-primary"></input>
                </div>
            </div>
        </form>
    </div>
   
    <div style="clear:both;"></div>
    <br>
    <button id="print-view" class="btn btn-primary pull-right" style="margin-right:30px;" >Print View</button> 
    <div style="clear:both;"></div>
    <br>
    <div class="col-sm-12">
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
    </div>
</div>
<script type="text/javascript">
    jQuery(window).load(function ()
    {
        var $ = jQuery;
        $("#print-view").on("click",function(e){
            e.preventDefault();
            <?php if ($as_at!="") {?>
                    window.open("<?php echo base_url(); ?>"+"index.php?report/balance_sheet_report/print_view/0/0/"+"<?php echo strtotime($as_at); ?>");
            <?php }else{ ?>
                    window.open("<?php echo base_url(); ?>"+"index.php?report/balance_sheet_report/print_view/"+"<?php echo strtotime($from).'/'.strtotime($to); ?>");
            <?php }?>
            
        })
    });
</script>