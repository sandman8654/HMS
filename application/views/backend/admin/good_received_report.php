<div class="row">
    <div class="col-sm-12">
        <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?report/grn_report" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <div class="col-sm-3">
                    <div class = "col-sm-3">
                        <label for="" class="control-label pull-right">Category:</label>
                    </div>
                    <div class = "col-sm-9">
                        <select name="type" class="form-control selectboxit" required>
                            <option value="all" <?php if($type=="all") echo 'selected'; ?>>All</option>
                            <option value="byitem" <?php if($type=="byitem") echo 'selected'; ?>>By Item</option>
                            <option value="bysup" <?php if($type=="bysup") echo 'selected'; ?>>By Supplier</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3 <?php if($type!="byitem") echo 'hidden';?>" id="selitem">
                    <div class = "col-sm-3 " >
                        <label for="" class="control-label pull-right">Item:</label>
                    </div>
                    <div class = "col-sm-9">
                        <select name="item" class="form-control selectboxit" >
                            <?php 
                                $this->db->order_by("ItemName");
                                $this->db->where("Type","GOOD");
                                $list = $this->db->get("items")->result_array();
                                foreach($list as $item){ ?>
                                    <option value="<?php echo $item['ItemCode']; ?>" <?php if ($item["ItemCode"]==$itemid) echo 'selected'; ?> ><?php echo $item['ItemName']; ?></option>        
                            <?php    } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3 <?php if($type!="bysup") echo 'hidden';?>" id="selsup">
                    <div class = "col-sm-3">
                        <label for="" class="control-label pull-right">Supplier:</label>
                    </div>
                    <div class = "col-sm-9">
                        <select name="supplier" class="form-control selectboxit" >
                            <?php 
                                $this->db->order_by("CustomerName");
                                $list = $this->db->get("creditsuppliers")->result_array();
                                foreach($list as $item){ ?>
                                    <option value="<?php echo $item['CustomerId']; ?>" <?php if ($item["CustomerId"]==$supplier) echo 'selected'; ?> ><?php echo $item['CustomerName']; ?></option>        
                            <?php    } ?>
                        </select>
                    </div>
                </div>
            </div>
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
                    <th><?php echo get_phrase('trans_date');?></th>
                    <th><?php echo get_phrase('GRN_no');?></th>
                    <th><?php echo get_phrase('supplier');?></th>
                    <th><?php echo get_phrase('item_name');?></th>
                    <th><?php echo get_phrase('unit');?></th>
                    <th><?php echo get_phrase('part');?></th>
                    <th><?php echo get_phrase('price');?></th>
                    <th><?php echo get_phrase('total');?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($grn_list as $item){ ?> 
                    <tr>
                        <td><?php echo $item['trans_date'];?></td>
                        <td><?php echo $item['grnno'];?></td>
                        <td><?php echo $item['supplier'];?></td>
                        <td><?php echo $item['item_name'];?></td>
                        <td><?php echo $item['unit'];?></td>
                        <td><?php echo $item['part'];?></td>
                        <td><?php echo $item['price'];?></td>
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
            var val = $("select[name='type']").val(),option="";
            if (val == "byitem") option = $("select[name='item']").val();
            if (val == "bysup") option = $("select[name='supplier']").val();
            window.open("<?php echo base_url(); ?>"+"index.php?report/grn_report/print_view/"+"<?php echo $type.'/'.strtotime($from).'/'.strtotime($to); ?>"+"/"+option);
        });
        $("select[name='type']").on("change",function(e){
            e.preventDefault();
            var val = $(this).val()||"";
            $("#selitem").addClass("hidden");
            $("#selsup").addClass("hidden");
            if (val == "byitem") $("#selitem").removeClass("hidden");
            if (val == "bysup") $("#selsup").removeClass("hidden");
        })
    });
</script>