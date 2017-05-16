<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3 id="test-date"><?php echo get_phrase('goods_management'); ?></h3>
                </div>
            </div>
            
            <div class="panel-body">
                <div class="col-md-12 col-sm-12">
                    <ul class="nav nav-tabs bordered">
                        <li class="active"><a href="#tabs-1" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('good_received_inwards(GRN)'); ?></span></a></li>
                        <li><a href="#tabs-2" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('good_returned_outwards'); ?></span></a></li>
                    </ul>
                    <div  class="tab-content recep-tab">
                        <div id="tabs-1" class="tab-pane active">
                            <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/mnggoods/create/grn" method="post" enctype="multipart/form-data">
                                <div class="col-md-5 col-sm-12 has-right-border" style="min-height:500px;">
                                    <h4 class="add-patient-sub-title"><?php echo get_phrase('good_information'); ?></h4>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('supplier_name:'); ?></label>
                                        <div class="col-sm-9">
                                            <select id="supid" name="supid" class="form-control select2" placeholder="<?php echo get_phrase('type_search_supplier');?>">
                                                <option value=""><?php echo get_phrase('type_search_supplier'); ?></option>
                                                <optgroup label="<?php echo get_phrase('supplier'); ?>">
                                                    <?php 
                                                        $this->db->order_by("CustomerName");
                                                        $all_items_info= $this->db->get('creditsuppliers')->result_array();
                                                        foreach ($all_items_info as $item){ ?>
                                                        <option data-bal ="<?php echo $item['Bal']; ?>" value=<?php echo $item['CustomerId']; ?>><?php echo $item['CustomerName']; ?></option> 
                                                   <?php } ?>
                                                </optgroup>    
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Items'); ?></label>

                                        <div class="col-sm-9">
                                            <select id="ac_select" name="item" class="form-control select2" placeholder="<?php echo get_phrase('type_search_item');?>">
                                                <option value=""><?php echo get_phrase('type_search_item'); ?></option>
                                                <optgroup label="<?php echo get_phrase('item'); ?>">
                                                    <?php 
                                                        foreach ($item_info as $item){ ?>
                                                        <option value=<?php echo $item['ItemCode']; ?> 
                                                                data-pack= <?php echo $item['Pack']; ?>
                                                                data-saleprice= <?php echo $item['SalePrice']; ?>
                                                                data-purprice= <?php echo $item['PurchPrice']; ?>
                                                                data-bal= <?php echo $item['PHARMACY']; ?>
                                                                data-qsold = <?php echo $item['Qsold']; ?>
                                                                data-qpurch = <?php echo $item['Qpurch']; ?>><?php echo $item['ItemName']; ?></option>
                                                   <?php } ?>
                                                </optgroup>    
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12 col-md-4">
                                            <label for="refno" class="col-sm-12"><?php echo get_phrase('pack:'); ?></label>
                                            <div class="col-sm-12">
                                                <input disabled type="text" name="pack" class="form-control" id="pack" >
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="refno" class="col-sm-12"><?php echo get_phrase('invoice_number*:'); ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="invno" class="form-control" id="invno" >
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="refno" class="col-sm-12"><?php echo get_phrase('date*:'); ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="date" class="form-control datepicker" id="date" placeholder="mm/dd/yyyy">
                                            </div>
                                        </div>
                                     </div>   
                                    <div class="form-group">
                                        <div class="col-sm-12 col-md-4">
                                            <label for="refno" class="col-sm-12"><?php echo get_phrase('unit*:'); ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="unit" class="form-control" id="pack" value=0 >
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="refno" class="col-sm-12"><?php echo get_phrase('part*:'); ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="part" class="form-control" id="invno" value=0 >
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="refno" class="col-sm-12"><?php echo get_phrase('purchase_price*:'); ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="purprice" class="form-control" id="purprice" value=0 >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12 col-md-4">
                                            <label for="refno" class="col-sm-12"><?php echo get_phrase('batch_no*:'); ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="batchno" class="form-control" id="batchno" >
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="refno" class="col-sm-12"><?php echo get_phrase('expiry_date:'); ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="expdate" class="form-control datepicker" id="expdate" placeholder="mm/dd/yyyy">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="refno" class="col-sm-12"><?php echo get_phrase('margin:'); ?></label>
                                            <div class="col-sm-12">
                                                <input disabled type="text" name="margin" class="form-control" id="margin" value=1  >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12 col-md-5">
                                            <label for="refno" class="col-sm-12"><?php echo get_phrase('total_price:'); ?></label>
                                            <div class="col-sm-12">
                                                <input disabled type="text" name="totprice" class="form-control" id="totprice" value=0  >
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-12 col-md-5">
                                            <label for="field-1" class="col-sm-12"><?php echo get_phrase('Sale Price*:'); ?></label>
                                            <div class="col-sm-12">
                                            <!--    <select name="spset" class="form-control">
                                                    <option value="3"><?php echo get_phrase('old_price');?></option>
                                                    <option value="1"><?php echo get_phrase('average');?></option>
                                                    <option value="2"><?php echo get_phrase('set_new_price');?></option>
                                                </select>-->
                                                <input type="text" name="saleprice" class="form-control" id="saleprice" value=0  >
                                            </div>
                                        </div>
                                    </div>     
                                    <div class="form-group">
                                     <!--   <div class="col-sm-2 col-md-2">
                                            <label for="refno"><?php echo get_phrase('bonus:'); ?></label>
                                            <input  type="checkbox" name="bonus"  id="bonus" value="0" >
                                        </div>
                                        <div class="col-sm-3 col-md-3">
                                            <label for="refno" ><?php echo get_phrase('non-billable:'); ?></label>
                                            <input  type="checkbox" name="nonbillable"  id="nonbillable" value="0" >
                                        </div>-->
                                        <div class="col-md-offset-5 col-sm-7 col-md-7 ">
                                            <a hefr="#" class="btn btn-success add_cart"><?php echo get_phrase('add_cart'); ?></a>
                                            <a hefr="#"  class="btn btn-success empty_carts"><?php echo get_phrase('empty_carts'); ?></a>
                                        </div>
                                    </div>     
                                </div>
                                <div class="col-md-7 col-sm-12">
                                    <h4 class="add-patient-sub-title pull-left"><?php echo get_phrase('carts'); ?></h4>
                                    <input type="submit" class="btn btn-success pull-right" value="Submit" style="margin-bottom:10px;">
                                    <div style="clear:both;"></div>
                                    <table class="table table-bordered table-striped datatable" id="table-cart-list1">
                                        <thead>
                                            <tr>
                                                <th><?php echo get_phrase('ItemName');?></th>
                                                <th><?php echo get_phrase('Supplier');?></th>
                                                <th><?php echo get_phrase('batch_no');?></th>
                                                <th><?php echo get_phrase('unit');?></th>
                                                <th><?php echo get_phrase('part');?></th>
                                                <th><?php echo get_phrase('total_price');?></th>
                                                <th><?php echo get_phrase('purchase');?></th>
                                                <th><?php echo get_phrase('selling');?></th>
                                                <th><?php echo get_phrase('action');?></th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <input type="hidden" id="pricet" name="pricet" title="In Part Price"/>
                            </form>
                        </div>
                        <div id="tabs-2" class="tab-pane ">
                             <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/mnggoods/create/gro" method="post" enctype="multipart/form-data">
                                <div class="col-md-5 col-sm-12 has-right-border" style="min-height:500px;">
                                    <h4 class="add-patient-sub-title"><?php echo get_phrase('good_information'); ?></h4>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('supplier_name:'); ?></label>
                                        <div class="col-sm-9">
                                            <select  name="supid" class="form-control select2" placeholder="<?php echo get_phrase('type_search_supplier');?>">
                                                <option value=""><?php echo get_phrase('type_search_supplier'); ?></option>
                                                <optgroup label="<?php echo get_phrase('supplier'); ?>">
                                                    <?php 
                                                        $this->db->order_by("CustomerName");
                                                        $all_items_info= $this->db->get('creditsuppliers')->result_array();
                                                        foreach ($all_items_info as $item){ ?>
                                                        <option data-bal ="<?php echo $item['Bal']; ?>" value=<?php echo $item['CustomerId']; ?>><?php echo $item['CustomerName']; ?></option> 
                                                   <?php } ?>
                                                </optgroup>    
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Items'); ?></label>

                                        <div class="col-sm-9">
                                            <select  name="item" class="form-control select2" placeholder="<?php echo get_phrase('type_search_item');?>">
                                                <option value=""><?php echo get_phrase('type_search_item'); ?></option>
                                                <optgroup label="<?php echo get_phrase('item'); ?>">
                                                    <?php 
                                                        foreach ($item_info as $item){ ?>
                                                        <option value=<?php echo $item['ItemCode']; ?> 
                                                                data-pack= <?php echo $item['Pack']; ?>
                                                                data-saleprice= <?php echo $item['SalePrice']; ?>
                                                                data-purprice= <?php echo $item['PurchPrice']; ?>
                                                                data-bal= <?php echo $item['PHARMACY']; ?>
                                                                data-qsold = <?php echo $item['Qsold']; ?>
                                                                data-qpurch = <?php echo $item['Qpurch']; ?>><?php echo $item['ItemName']; ?></option>
                                                   <?php } ?>
                                                </optgroup>    
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12 col-md-4">
                                            <label for="refno" class="col-sm-12"><?php echo get_phrase('pack:'); ?></label>
                                            <div class="col-sm-12">
                                                <input disabled type="text" name="pack" class="form-control" id="pack" >
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="refno" class="col-sm-12"><?php echo get_phrase('invoice_number*:'); ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="invno" class="form-control" id="invno" >
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="refno" class="col-sm-12"><?php echo get_phrase('date*:'); ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="date" class="form-control datepicker" id="date" placeholder="mm/dd/yyyy">
                                            </div>
                                        </div>
                                     </div>   
                                    <div class="form-group">
                                        <div class="col-sm-12 col-md-4">
                                            <label for="refno" class="col-sm-12"><?php echo get_phrase('unit*:'); ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="unit" class="form-control" id="pack" value=0 >
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="refno" class="col-sm-12"><?php echo get_phrase('part*:'); ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="part" class="form-control" id="invno" value=0 >
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="refno" class="col-sm-12"><?php echo get_phrase('purchase_price*:'); ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="purprice" class="form-control" id="purprice" value=0 >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12 col-md-4">
                                            <label for="refno" class="col-sm-12"><?php echo get_phrase('batch_no*:'); ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="batchno" class="form-control" id="batchno" >
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="refno" class="col-sm-12"><?php echo get_phrase('expiry_date:'); ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="expdate" class="form-control datepicker" id="expdate" placeholder="mm/dd/yyyy">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="refno" class="col-sm-12"><?php echo get_phrase('LPO_no:'); ?></label>
                                            <div class="col-sm-12">
                                                <input  type="text" name="lpono" class="form-control" id="margin"  >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12 col-md-4">
                                            <label for="refno" class="col-sm-12"><?php echo get_phrase('total_price:'); ?></label>
                                            <div class="col-sm-12">
                                                <input disabled type="text" name="totprice" class="form-control" id="totprice" value=0  >
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-12 col-md-8">
                                            <label for="field-1" class="col-sm-12"><?php echo get_phrase('reason:'); ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="reason" class="form-control col-sm-12" />
                                            </div>
                                        </div>
                                    </div>     
                                    <div class="form-group">
                                        <div class="col-md-offset-5 col-sm-7 col-md-7 ">
                                            <a hefr="#"  class="btn btn-success add_cart"><?php echo get_phrase('add_cart'); ?></a>
                                            <a hefr="#"  class="btn btn-success empty_carts"><?php echo get_phrase('empty_carts'); ?></a>
                                        </div>
                                    </div>     
                                </div>
                                <div class="col-md-7 col-sm-12">
                                    <h4 class="add-patient-sub-title pull-left"><?php echo get_phrase('carts'); ?></h4>
                                    <input type="submit" class="btn btn-success pull-right" value="Submit" style="margin-bottom:10px;">
                                    <div style="clear:both;"></div>
                                    <table class="table table-bordered table-striped datatable" id="table-cart-list2">
                                        <thead>
                                            <tr>
                                                <th><?php echo get_phrase('ItemName');?></th>
                                                <th><?php echo get_phrase('Supplier');?></th>
                                                <th><?php echo get_phrase('batch_no');?></th>
                                                <th><?php echo get_phrase('unit');?></th>
                                                <th><?php echo get_phrase('part');?></th>
                                                <th><?php echo get_phrase('total_price');?></th>
                                                <th><?php echo get_phrase('purchase');?></th>
                                                <th><?php echo get_phrase('action');?></th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(window).load(function ()
    {
        var $ = jQuery;
        $("#table-cart-list1").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Highlighted rows
        $("#table-cart-list1 tbody input[type=checkbox]").each(function (i, el)
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
        $("#table-cart-list2").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Highlighted rows
        $("#table-cart-list2 tbody input[type=checkbox]").each(function (i, el)
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
    function GetFormattedDate() {
        var todayTime = new Date();
        var month = todayTime .getMonth() + 1;
        var day = todayTime .getDate();
        var year = todayTime .getFullYear();
        return month + "/" + day + "/" + year;
    }
    
    jQuery(window).load(function ()
    {   
        $=jQuery;
        var myCart=[];
        $itemSelEl1 = $("#tabs-1 select[name='item']");
        $supplierEl1 = $("#tabs-1 select[name='supid']");
        $("#tabs-1 input[name='date']").val(GetFormattedDate());
        var tbCart1 = $("#table-cart-list1").dataTable();
        $("#tabs-1 .add_cart").on("click",function(e){

            e.preventDefault();
           
            var code = $itemSelEl1.find("option:selected").val(),
                spid = $supplierEl1.find("option:selected").val(),
                invno = $("#tabs-1 input[name='invno']").val()||"",
                pack = eval($("#tabs-1 input[name='pack']").val())||0,
                date = $("#tabs-1 input[name='date']").val(),
                units = eval($("#tabs-1 input[name='unit']").val())||0,
                parts = eval($("#tabs-1 input[name='part']").val())||0,
                purprice = eval($("#tabs-1 input[name='purprice']").val())||0,
                saleprice = eval($("#tabs-1 input[name='saleprice']").val())||0,
                batchno = $("#tabs-1 input[name='batchno']").val()||"",
                expdate = $("#tabs-1 input[name='expdate']").val()||"",
                margin = eval($("#tabs-1 input[name='margin']").val())||0,
                totprice = eval($("#tabs-1 input[name='totprice']").val())||0,
                spset = eval($("#tabs-1 select[name='spset']").val()),
                bonus = eval($("#tabs-1 input[name='bonus']").val())||0,
                nonbillable = eval($("#tabs-1 input[name='nonbillable']").val())||0,
                bal = pack*units+parts;
            if(code=="") return;
            if (units==0 && parts==0){
                $.alert("Enter the quantity!","Error");
                return;
            };
            if (invno==""){
                $.alert("Enter the Invoice Number!","Error");
                return;
            }
            if (purprice==0){
                $.alert("Enter the Unit purchase price!","Error");
                return;
            }
             if (saleprice==0){
                $.alert("Enter the Unit sale     price!","Error");
                return;
            }
            if (spid==""){
                $.alert("Enter the Supplier name!","Error");
                return;
            }
            if (batchno==""){
                $.alert("Enter the Batch No!","Error");
                return;
            }
           
            if(bonus==1){
                purprice = totprice = 0;
            }
                
            cart={
                "supid":spid,       
                "supname":$supplierEl1.find("option:selected").text(),
                "name":$itemSelEl1.find("option:selected").text(),
                "code":code,
                "units":units,
                "parts":parts,
                "pack":pack,
                "batchno":batchno,
                "invno":invno,
                "purprice":purprice,
                "saleprice":saleprice,
                "expdate":expdate,
                "margin":margin,
                "spset":spset,
                "totprice":totprice,
                "date":date,
                "status":1
            };

            myCart.push(cart);
            var n = myCart.length;
            tbCart1.fnAddData([
                cart["name"],
                cart["supname"],
                cart["batchno"],
                cart["units"],
                cart["parts"],
                cart["totprice"],
                cart["purprice"],
                cart["saleprice"],
                "<a href='#' id='del_cart_item_"+n+"' data-id='"+n+"' class=\"btn btn-danger btn-sm btn-icon icon-left\"><i class=\"entypo-cancel\"></i>Delete</a>"
            ]);
            $(" #del_cart_item_"+n).on("click", function(e){
                e.preventDefault();
                var nTr=$(this).parents('tr')[0];
                tbCart1.fnDeleteRow(nTr);
                var n = $(this).data("id");
                myCart[n-1]["status"]=0;
            });
        });
        $("#tabs-1 .empty_carts").on("click",function(e){
            e.preventDefault();
            tbCart1.fnClearTable(true);
            myCart=[];
            
        });
        $itemSelEl1.on("change",function(){
            var $this = $(this),
                $opt = $this.find("option:selected");
                pack = eval($opt.data("pack"))||"0";
            $("#tabs-1 input[name='pack']").val(pack);
            $("#tabs-1 input[name='margin']").val(1);          
            $("#tabs-1 input[name='totprice']").val(0);
            $("#tabs-1 input[name='unit']").val(0);
            $("#tabs-1 input[name='part']").val(0);
            $("#tabs-1 input[name='purprice']").val(0);
            $("#tabs-1 input[name='saleprice']").val(eval($opt.data("saleprice"))||0);
        });
        $("#tabs-1 input[name='bonus']").on("click",function(){
            var val = $(this).val();
            $(this).val((val==1)?0:1);
            if ($(this).val==1){
                $("#tabs-1 input[name='totprice']").val(0);
                $("#tabs-1 input[name='purprice']").val(0);
            }
        });
        $("#tabs-1 input[name='nonbillable']").on("click",function(){
            var val = $(this).val();
            $(this).val((val==1)?0:1);
            if ($(this).val==1){
                $("#tabs-1 input[name='pricet']").val(0);
            }
        });
        function calcTotalPrice(){
            var units = eval($("#tabs-1 input[name='unit']").val())||0,
                parts = eval($("#tabs-1 input[name='part']").val())||0,
                pack = eval($("#tabs-1 input[name='pack']").val())||0,
                purprice = eval($("#tabs-1 input[name='purprice']").val())||0,
                totalPrice = purprice*(pack*units+parts);
            $("#tabs-1 input[name='totprice']").val(totalPrice);
        }
        $("#tabs-1 input[name='unit']").on("keyup",function(){
            calcTotalPrice();
        }).ForceNumericOnly();
        $("#tabs-1 input[name='part']").on("keyup",function(){
            calcTotalPrice();
        }).ForceNumericOnly();
        $("#tabs-1 input[name='purprice']").on("keyup",function(){
            calcTotalPrice();
        }).ForceNumericOnly();
        $("#tabs-1 form").submit(function(){
            var data=[], $this=$(this);
            $.each(myCart,function(){
                if(this["status"]==1){
                    data.push(this);
                }
            });
            if (data.length==0){
                $.alert("The cart is empty!","Error");
                return false;
            }
            $("<input></input>")
                .attr({"type":"hidden","name":"carts"})
                .val(JSON.stringify(data))
                .appendTo($this);
            return true;
        })
    });
</script>

<script>
 jQuery(window).load(function ()
    {   
        $=jQuery;
        var myCart=[];
        $itemSelEl2= $("#tabs-2 select[name='item']");
        $supplierEl2= $("#tabs-2 select[name='supid']");
        $("#tabs-2 input[name='date']").val(GetFormattedDate());
        var tbCart2 = $("#table-cart-list2").dataTable();
        $("#tabs-2 .add_cart").on("click",function(e){

            e.preventDefault();
            
            var code = $itemSelEl2.find("option:selected").val(),
                spid = $supplierEl2.find("option:selected").val(),
                invno = $("#tabs-2 input[name='invno']").val()||"",
                pack = eval($("#tabs-2 input[name='pack']").val())||0,
                date = $("#tabs-2 input[name='date']").val()||"",
                units = eval($("#tabs-2 input[name='unit']").val())||0,
                parts = eval($("#tabs-2 input[name='part']").val())||0,
                purprice = eval($("#tabs-2 input[name='purprice']").val())||0,
                batchno = $("#tabs-2 input[name='batchno']").val()||"",
                lpono = $("#tabs-2 input[name='lpono']").val()||"",
                expdate = $("#tabs-2 input[name='expdate']").val()||"",
                reason = $("#tabs-2 input[name='reason']").val()||"",
                totprice = eval($("#tabs-2 input[name='totprice']").val())||0,
                bal = pack*units+parts;
            if(code=="") return;
            if (units==0 && parts==0){
                $.alert("Enter the quantity!","Error");
                return;
            };
            if (invno==""){
                $.alert("Enter the Invoice Number!","Error");
                return;
            }
            if (purprice==0){
                $.alert("Enter the Unit purchase price!","Error");
                return;
            }
            if (spid==""){
                $.alert("Enter the Supplier name!","Error");
                return;
            }
            if (batchno==""){
                $.alert("Enter the Batch No!","Error");
                return;
            }
           
            cart={
                "supid":spid,       
                "supname":$supplierEl2.find("option:selected").text(),
                "name":$itemSelEl2.find("option:selected").text(),
                "code":code,
                "units":units,
                "parts":parts,
                "pack":pack,
                "batchno":batchno,
                "lpono":lpono,
                "invno":invno,
                "purprice":purprice,
                "expdate":expdate,
                "totprice":totprice,
                "date":date,
                "status":1
            };

            myCart.push(cart);
            var n = myCart.length;
            tbCart2.fnAddData([
                cart["name"],
                cart["supname"],
                cart["batchno"],
                cart["units"],
                cart["parts"],
                cart["totprice"],
                cart["purprice"],
                "<a href='#' id='del_cart_item_1"+n+"' data-id='"+n+"' class=\"btn btn-danger btn-sm btn-icon icon-left\"><i class=\"entypo-cancel\"></i>Delete</a>"
            ]);
            $(" #del_cart_item_1"+n).on("click", function(e){
                e.preventDefault();
                var nTr=$(this).parents('tr')[0];
                tbCart2.fnDeleteRow(nTr);
                var n = $(this).data("id");
                myCart[n-1]["status"]=0;
            });
        });
        $("#tabs-2 .empty_carts").on("click",function(e){
            e.preventDefault();
            tbCart2.fnClearTable(true);
            myCart=[];
            
        });
        $itemSelEl2.on("change",function(){
            var $this = $(this),
                $opt = $this.find("option:selected");
                pack = eval($opt.data("pack"))||"0";
            $("#tabs-2 input[name='pack']").val(pack);
            $("#tabs-2 input[name='totprice']").val(0);
            $("#tabs-2 input[name='unit']").val(0);
            $("#tabs-2 input[name='part']").val(0);
            $("#tabs-2 input[name='purprice']").val(0);
        });
        
        function calcTotalPrice(){
            var units = eval($("#tabs-2 input[name='unit']").val())||0,
                parts = eval($("#tabs-2 input[name='part']").val())||0,
                pack = eval($("#tabs-2 input[name='pack']").val())||0,
                purprice = eval($("#tabs-2 input[name='purprice']").val())||0,
                totalPrice = purprice*(pack*units+parts);
            $("#tabs-2 input[name='totprice']").val(totalPrice);
        }
        $("#tabs-2 input[name='unit']").on("keyup",function(){
            calcTotalPrice();
        }).ForceNumericOnly();
        $("#tabs-2 input[name='part']").on("keyup",function(){
            calcTotalPrice();
        }).ForceNumericOnly();
        $("#tabs-2 input[name='purprice']").on("keyup",function(){
            calcTotalPrice();
        }).ForceNumericOnly();
        $("#tabs-2 form").submit(function(){
            var data=[], $this=$(this);
            $.each(myCart,function(){
                if(this["status"]==1){
                    data.push(this);
                }
            });
            if (data.length==0){
                $.alert("The cart is empty!","Error");
                return false;
            }
            $("<input></input>")
                .attr({"type":"hidden","name":"carts"})
                .val(JSON.stringify(data))
                .appendTo($this);
            return true;
        })
    });
</script>
