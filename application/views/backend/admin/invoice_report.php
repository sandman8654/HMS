
<div class="row">
    <div class="col-sm-12">
        <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?report/invoice_report" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <div class="col-sm-3">
                    <div class = "col-sm-3">
                        <label for="" class="control-label pull-right">Category:</label>
                    </div>
                    <div class = "col-sm-9">
                        <select name="type" class="form-control selectboxit" required>
                            <option value="today" <?php if($type=="today") echo 'selected'; ?>>Today Invoice</option>
                            <option value="all" <?php if($type=="all") echo 'selected'; ?>>All Inovice</option>
                            <option value="bycomp" <?php if($type=="bycomp") echo 'selected'; ?>>By Company</option>
                            <option value="bycash" <?php if($type=="bycash") echo 'selected'; ?>>Receipts(cash paying)</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3 <?php if($type!="bycomp") echo 'hidden';?>" id="selcomp">
                    <div class = "col-sm-3 " >
                        <label for="" class="control-label pull-right">Item:</label>
                    </div>
                    <div class = "col-sm-9">
                        <select name="comp" class="form-control selectboxit" >
                            <?php 
                                $this->db->order_by("CustomerName");
                                $list = $this->db->get("creditcustomers")->result_array();
                                foreach($list as $item){ ?>
                                    <option value="<?php echo $item['CustomerId']; ?>" <?php if ($item["CustomerId"]==$compid) echo 'selected'; ?> ><?php echo $item['CustomerName']; ?></option>        
                            <?php    } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">                
                <div class="col-sm-5">
                    <div class = "col-sm-3">
                        <label for="" class="control-label pull-right">From:</label>
                    </div>
                    <div class = "col-sm-5">
                        <input name="from" type="text" class="form-control datepicker" value="<?php echo $from; ?>"></input>
                        
                    </div>
                    <div class = "col-sm-4">
                        <input name="fromtime" type="time" class="form-control " value="<?php echo $fromtime; ?>"></input>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class = "col-sm-3">
                        <label for="" class="control-label pull-right">To:</label>
                    </div>
                    <div class = "col-sm-5">
                        <input name="to" type="text" class="form-control datepicker" value="<?php echo $to; ?>"></input>
                    </div>
                    <div class="col-sm-4">
                        <input name="totime" type="time" class="form-control " value="<?php echo $totime; ?>"></input>
                    </div>
                </div>
                <div class="col-sm-2">
                    <input type="submit" value="View Invoice" class="form-control btn btn-primary"></input>
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
       <table class="table table-bordered table-striped datatable">
           
            <thead>
                <tr>
                    <th><?php echo get_phrase('date');?></th>
                    <th><?php echo get_phrase('patient_id');?></th>
                    <th><?php echo get_phrase('patient_name');?></th>
                    <th><?php echo get_phrase('pay_mode');?></th>
                    <th><?php echo get_phrase('company');?></th>
                    <th><?php echo get_phrase('Rcpt/Invoice_No');?></th>
                    <th><?php echo get_phrase('Amount');?></th>
                    <th><?php echo get_phrase('Time');?></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($invoice_list as $item){ ?> 
                    <tr>
                        <td><?php echo $item['date'];?></td>
                        <td><?php echo $item['patient_id'];?></td>
                        <td><?php echo $item['patient_name'];?></td>
                        <td><?php echo $item['pay_mode'];?></td>
                        <td><?php echo $item['company'];?></td>
                        <td><?php echo $item['inv_No'];?></td>
                        <td><?php echo $item['amount'];?></td>
                        <td><?php echo $item['time'];?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    jQuery(window).load(function ()
    {
        var $ = jQuery;
        $("#print-view").on("click",function(e){
            e.preventDefault();
            var val = $("select[name='type']").val(),option="";
            if (val == "bycomp") option = $("select[name='comp']").val();
            
            window.open("<?php echo base_url(); ?>"+"index.php?report/invoice_report/print_view/"+"<?php echo $type.'/'.strtotime($from.' '.$fromtime).'/'.strtotime($to.' '.$totime); ?>"+"/"+option);
        });
        $("select[name='type']").on("change",function(e){
            e.preventDefault();
            var val = $(this).val()||"";
            $("#selcomp").addClass("hidden");
            if (val == "bycomp") $("#selcomp").removeClass("hidden");
        })
    });
</script>