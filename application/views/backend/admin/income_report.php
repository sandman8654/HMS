
<div class="row">
    <div class="col-sm-12">
        <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?report/income_report" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <div class="col-sm-3">
                    <div class = "col-sm-3">
                        <label for="" class="control-label pull-right">Category:</label>
                    </div>
                    <div class = "col-sm-9">
                        <select name="type" class="form-control selectboxit" required>
                            <option value="today" <?php if($type=="today") echo 'selected'; ?>>Today</option>
                            <option value="all" <?php if($type=="all") echo 'selected'; ?>>All</option>
                            <option value="wprofit" <?php if($type=="wprofit") echo 'selected'; ?>>With Profit</option>
                            <option value="wloss" <?php if($type=="wloss") echo 'selected'; ?>>With Loss</option>
                            <option value="byitem" <?php if($type=="byitem") echo 'selected'; ?>>By Item</option>
                            <option value="bypat" <?php if($type=="bypat") echo 'selected'; ?>>By Patient</option>
                            <option value="bydepart" <?php if($type=="bydepart") echo 'selected'; ?>>By Department</option>
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
                                $list = $this->db->get("items")->result_array();
                                foreach($list as $item){ ?>
                                    <option value="<?php echo $item['ItemCode']; ?>" <?php if ($item["ItemCode"]==$itemid) echo 'selected'; ?> ><?php echo $item['ItemName']; ?></option>        
                            <?php    } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3 <?php if($type!="bydepart") echo 'hidden';?>" id="seldepart">
                    <div class = "col-sm-3">
                        <label for="" class="control-label pull-right">Department:</label>
                    </div>
                    <div class = "col-sm-9">
                        <select name="depart" class="form-control selectboxit" >
                            <?php 
                                $this->db->order_by("name");
                                $list = $this->db->get("department")->result_array();
                                foreach($list as $item){ ?>
                                    <option value="<?php echo $item['name']; ?>" <?php if ($item["name"]==$dept) echo 'selected'; ?> ><?php echo $item['name']; ?></option>        
                            <?php    } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3 <?php if($type!="bypat") echo 'hidden';?>" id="selpatient">
                    <div class = "col-sm-3">
                        <label for="" class="control-label pull-right">Patient:</label>
                    </div>
                    <div class = "col-sm-9">
                        <select name="patient" class="form-control selectboxit" >
                            <?php 
                                $this->db->order_by("name");
                                $list = $this->db->get("patient")->result_array();
                                foreach($list as $item){ ?>
                                    <option value="<?php echo $item['patient_id']; ?>" <?php if ($item["patient_id"]==$patid) echo 'selected'; ?> ><?php echo $item['name']; ?></option>        
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
                    <input type="submit" value="View Income Analysis" class="form-control btn btn-primary"></input>
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
                    <th><?php echo get_phrase('patient_name');?></th>
                    <th><?php echo get_phrase('item_name');?></th>
                    <th><?php echo get_phrase('unit_price');?></th>
                    <th><?php echo get_phrase('qty');?></th>
                    <th><?php echo get_phrase('vat');?></th>
                    <th><?php echo get_phrase('discount');?></th>
                    <th><?php echo get_phrase('total_sale');?></th>
                    <th><?php echo get_phrase('posted');?></th>
                    <th><?php echo get_phrase('cashier');?></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($income_list as $item){ ?> 
                    <tr>
                        <td><?php echo $item['trans_date'];?></td>
                        <td><?php echo $item['patient_name'];?></td>
                        <td><?php echo $item['item_name'];?></td>
                        <td><?php echo $item['unit_price'];?></td>
                        <td><?php echo $item['qty'];?></td>
                        <td><?php echo $item['vat'];?></td>
                        <td><?php echo $item['discount'];?></td>
                        <td><?php echo $item['total_sale'];?></td>
                        <td><?php echo $item['posted'];?></td>
                        <td><?php echo $item['cashier'];?></td>
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
            if (val == "bydepart") option = $("select[name='depart']").val();
            if (val == "bypat") option = $("select[name='patient']").val();
            
            window.open("<?php echo base_url(); ?>"+"index.php?report/income_report/print_view/"+"<?php echo $type.'/'.strtotime($from).'/'.strtotime($to); ?>"+"/"+option);
        });
        $("select[name='type']").on("change",function(e){
            e.preventDefault();
            var val = $(this).val()||"";
            $("#selitem").addClass("hidden");
            $("#seldepart").addClass("hidden");
            $("#selpatient").addClass("hidden");
            if (val == "byitem") $("#selitem").removeClass("hidden");
            if (val == "bydepart") $("#seldepart").removeClass("hidden");
            if (val == "bypat") $("#selpatient").removeClass("hidden");
        })
    });
</script>