<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3 id="test-date"><?php echo get_phrase('local_purchase_order'); ?></h3>
                </div>
            </div>
            
            <div class="panel-body">
                <div class="col-md-12 col-sm-12">
                    <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/mnglpo/create" method="post" enctype="multipart/form-data">
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
                                                        data-purprice= <?php echo $item['PurchPrice']; ?>
                                                        data-bal= <?php echo $item['PHARMACY']; ?>><?php echo $item['ItemName']; ?></option>
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
                                
                            </div>   
                            <div class="form-group">
                                <div class="col-sm-12 col-md-4">
                                    <label for="refno" class="col-sm-12"><?php echo get_phrase('date*:'); ?></label>
                                    <div class="col-sm-12">
                                        <input type="text" name="date" class="form-control datepicker" id="date" placeholder="mm/dd/yyyy">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="refno" class="col-sm-12"><?php echo get_phrase('purchase_price*:'); ?></label>
                                    <div class="col-sm-12">
                                        <input type="text" name="purprice" class="form-control" id="purprice" value=0 >
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="refno" class="col-sm-12"><?php echo get_phrase('total_price:'); ?></label>
                                    <div class="col-sm-12">
                                        <input disabled type="text" name="totprice" class="form-control" id="totprice" value=0  >
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-md-offset-5 col-sm-7 col-md-7 ">
                                    <a hefr="#" id="add_cart" class="btn btn-success add_cart"><?php echo get_phrase('add_cart'); ?></a>
                                    <a hefr="#" id="empty_carts" class="btn btn-success empty_carts"><?php echo get_phrase('empty_carts'); ?></a>
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
                                        <th><?php echo get_phrase('Item_Name');?></th>
                                        <th><?php echo get_phrase('Supplier');?></th>
                                        <th><?php echo get_phrase('unit');?></th>
                                        <th><?php echo get_phrase('part');?></th>
                                        <th><?php echo get_phrase('purchase_price');?></th>
                                        <th><?php echo get_phrase('total_price');?></th>
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
        $itemSelEl1 = $(" select[name='item']");
        $supplierEl1 = $(" select[name='supid']");
        $(" input[name='date']").val(GetFormattedDate());

        $("#add_cart").on("click",function(e){

            e.preventDefault();
            var tbCart = $("#table-cart-list1").dataTable();
            var code = $itemSelEl1.find("option:selected").val(),
                spid = $supplierEl1.find("option:selected").val(),
                pack = eval($(" input[name='pack']").val())||0,
                date = $(" input[name='date']").val(),
                units = eval($(" input[name='unit']").val())||0,
                parts = eval($(" input[name='part']").val())||0,
                purprice = eval($(" input[name='purprice']").val())||0,
                totprice = eval($(" input[name='totprice']").val())||0,
                bal = pack*units+parts;
            if(code=="") return;
            if (units==0 && parts==0){
                $.alert("Enter the quantity!","Error");
                return;
            };
            if (purprice==0){
                $.alert("Enter the Unit purchase price!","Error");
                return;
            }
            if (spid==""){
                $.alert("Enter the Supplier name!","Error");
                return;
            }
                
            cart={
                "supid":spid,       
                "supname":$supplierEl1.find("option:selected").text(),
                "name":$itemSelEl1.find("option:selected").text(),
                "code":code,
                "units":units,
                "parts":parts,
                "pack":pack,
                "purprice":purprice,
                "totprice":totprice,
                "date":date,
                "status":1
            };

            myCart.push(cart);
            var n = myCart.length;
            tbCart.fnAddData([
                cart["name"],
                cart["supname"],
                cart["units"],
                cart["parts"],
                cart["purprice"],
                cart["totprice"],
                "<a href='#' id='del_cart_item_"+n+"' data-id='"+n+"' class=\"btn btn-danger btn-sm btn-icon icon-left\"><i class=\"entypo-cancel\"></i>Delete</a>"
            ]);
            $(" #del_cart_item_"+n).on("click", function(e){
                e.preventDefault();
                var nTr=$(this).parents('tr')[0];
                tbCart.fnDeleteRow(nTr);
                var n = $(this).data("id");
                myCart[n-1]["status"]=0;
            });
        });
        $("#empty_carts").on("click",function(e){
            e.preventDefault();
            tbCart.fnClearTable(true);
            myCart=[];
            
        });
        $itemSelEl1.on("change",function(){
            var $this = $(this),
                $opt = $this.find("option:selected");
                pack = eval($opt.data("pack"))||"0";
            $(" input[name='pack']").val(pack);
            $(" input[name='totprice']").val(0);
            $(" input[name='unit']").val(0);
            $(" input[name='part']").val(0);
            $(" input[name='purprice']").val(0);
        });
        $(" input[name='bonus']").on("click",function(){
            var val = $(this).val();
            $(this).val((val==1)?0:1);
            if ($(this).val==1){
                $(" input[name='totprice']").val(0);
                $(" input[name='purprice']").val(0);
            }
        });
        $(" input[name='nonbillable']").on("click",function(){
            var val = $(this).val();
            $(this).val((val==1)?0:1);
            if ($(this).val==1){
                $(" input[name='pricet']").val(0);
            }
        });
        function calcTotalPrice(){
            var units = eval($("input[name='unit']").val())||0,
                parts = eval($("input[name='part']").val())||0,
                pack = eval($("input[name='pack']").val())||0,
                purprice = eval($("input[name='purprice']").val())||0,
                totalPrice = purprice*(pack*units+parts);
            $(" input[name='totprice']").val(totalPrice);
        }
        $(" input[name='unit']").on("keyup",function(){
            calcTotalPrice();
        }).ForceNumericOnly();
        $(" input[name='part']").on("keyup",function(){
            calcTotalPrice();
        }).ForceNumericOnly();
        $(" input[name='purprice']").on("keyup",function(){
            calcTotalPrice();
        }).ForceNumericOnly();
        $(" form").submit(function(){
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


