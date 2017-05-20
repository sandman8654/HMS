<div class="row">
    <div class="col-sm-12">
        <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?report/reprint_grn_received_report" method="post" enctype="multipart/form-data">
            
            <div class="form-group">                
                <div class="col-sm-6">
                    <div class = "col-sm-3">
                        <label for="" class="control-label pull-right">Ref No:</label>
                    </div>
                    <div class = "col-sm-9">
                        <select name="refno" class="form-control selectboxit" >
                            <?php 

                                $this->db->order_by("PurchNo");
                                $this->db->group_by("PurchNo");
                                $list = $this->db->get("purchases")->result_array();
                                foreach($list as $item){ 
                                    $supname = $this->db->get_where("creditsuppliers",array('CustomerId'=>$item["SupplierId"]))->row()->CustomerName;
                                    ?>
                                    <option value="<?php echo $item['PurchNo']; ?>" <?php if ($item["PurchNo"]==$refno) echo 'selected'; ?> ><?php echo $item['PurchNo']."-".$supname."-".$item['PurchDate']."-".$item['InvoiceNo']; ?></option>        
                            <?php    } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2">
                    <input type="submit" value="View Report " class="form-control btn btn-primary"></input>
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
                    <th><?php echo get_phrase('item_name');?></th>
                    <th><?php echo get_phrase('pack');?></th>
                    <th><?php echo get_phrase('batch_no');?></th>
                    <th><?php echo get_phrase('expiry_date');?></th>
                    <th><?php echo get_phrase('unit');?></th>
                    <th><?php echo get_phrase('part');?></th>
                    <th><?php echo get_phrase('purchase_price');?></th>
                     <th><?php echo get_phrase('sale_price');?></th>
                    <th><?php echo get_phrase('total');?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($grn_list as $item){ ?> 
                    <tr>
                        <td><?php echo $item['item_name'];?></td>
                        <td><?php echo $item['pack'];?></td>
                        <td><?php echo $item['batchno'];?></td>
                        <td><?php echo $item['expiry'];?></td>
                        <td><?php echo $item['unit'];?></td>
                        <td><?php echo $item['part'];?></td>
                        <td><?php echo $item['pprice'];?></td>
                        <td><?php echo $item['sprice'];?></td>
                        <td><?php echo $item['total'];?></td>
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
            var val = $("select[name='refno']").val(),option=val;
            window.open("<?php echo base_url(); ?>"+"index.php?report/reprint_grn_received_report/print_view/"+option);
        });
       
    });
</script>