
<form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/stockrequest/create" method="post" enctype="multipart/form-data">
    <div class="col-md-5 col-sm-12 has-right-border" style="min-height:500px;">
        <h4 class="add-patient-sub-title"><?php echo get_phrase('stock_item_information'); ?></h4>
        <div class="form-group">
            <div class="col-md-6 col-sm-12">
                <p class="col-md-12 col-sm-12 "><?php echo get_phrase('from_branch*'); ?></p>
                <div class="col-sm-12 col-md-12">
                    <select required name="frombranch" class="form-control" placeholder="From Branch">
                        <option value="" ><?php echo get_phrase('select_branch'); ?></option>
                        <?php 
                            $this->db->order_by("name");
                            $branch_list = $this->db->get("branch")->result_array();
                            foreach ($branch_list as $item){?>
                                <option value="<?php echo $item['name']; ?>" ><?php echo $item['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <p class="col-md-12 col-sm-12 "><?php echo get_phrase('to_branch*'); ?></p>
                <div class="col-sm-12 col-md-12">
                    <select required name="tobranch" class="form-control " >
                        <option value="" ><?php echo get_phrase('select_branch'); ?></option>
                        <?php 
                            foreach ($branch_list as $item){?>
                                <option value="<?php echo $item['name']; ?>" ><?php echo $item['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            
        </div>

        <div class="form-group">
            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('items'); ?></label>

            <div class="col-sm-9">
                <select id="item_select_req" name="item" class="form-control select2" placeholder="<?php echo get_phrase('type_search_term');?>">
                    <option value=""><?php echo get_phrase('type_search_item'); ?></option>
                    <optgroup label="<?php echo get_phrase('stock_item'); ?>">
                    </optgroup>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('pack_size'); ?></label>
            <div class="col-sm-5">
                <input type="text" name="pack" class="form-control" id="field-1" value="0" disabled>
            </div>
        </div>
        <h4 class="add-patient-sub-title"><?php echo get_phrase('current_balance'); ?></h4>
        <div class="form-group">
            <div class="col-md-6 col-sm-12">
                <p class="col-md-12 col-sm-12 "><?php echo get_phrase('unit:'); ?></p>
                <div class="col-sm-12 col-md-12">
                    <input type="text" name="curr_unit" class="form-control" disabled  >
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <p class="col-md-12 col-sm-12 "><?php echo get_phrase('Parts:'); ?></p>
                <div class="col-sm-12 col-md-12">
                    <input type="text" name="curr_parts" class="form-control" disabled  >
                </div>
            </div>
            
        </div>
        <h4 class="add-patient-sub-title"><?php echo get_phrase('requesting_balance'); ?></h4>
        <div class="form-group">
            <div class="col-md-6 col-sm-12">
                <p class="col-md-12 col-sm-12 "><?php echo get_phrase('unit:'); ?></p>
                <div class="col-sm-12 col-md-12">
                    <input type="text" name="req_unit" class="form-control" val="0" placeholder="0" >
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <p class="col-md-12 col-sm-12 "><?php echo get_phrase('Parts:'); ?></p>
                <div class="col-sm-12 col-md-12">
                    <input type="text" name="req_parts" class="form-control" val="0" placeholder="0">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12 col-md-12  control-label">
                <a hefr="#" id="add_cart" class="btn btn-success"><?php echo get_phrase('add_cart'); ?></a>
                <a hefr="#" id="empty_carts" class="btn btn-success"><?php echo get_phrase('empty_carts'); ?></a>
            </div>
        </div> 
    </div>
    <div class="col-md-7 col-sm-12 ">
        
        <h4 class="add-patient-sub-title"><?php echo get_phrase('requested_goods'); ?></h4>
        <div class="form-group">
            <div class="col-sm-12 col-md-12  control-label">
                <input type="submit" class="btn btn-success" value="Submit">
            </div> 
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <table class="table table-bordered table-striped datatable" id="table-req-list">
                    <thead>
                        <tr>
                            <th><?php echo get_phrase('item_name');?></th>
                            <th><?php echo get_phrase('from');?></th>
                            <th><?php echo get_phrase('to');?></th>
                            <th><?php echo get_phrase('unit');?></th>
                            <th><?php echo get_phrase('part');?></th>
                            <th><?php echo get_phrase('action');?></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    
</form>
<script>
    jQuery(window).load(function (){
        var $ = jQuery;
        $("#table-req-list").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
        });
       

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Highlighted rows
        $("#table-req-list tbody input[type=checkbox]").each(function (i, el)
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
<script>
    var items_info=[];
    
    jQuery(window).load(function (){
        var $ = jQuery,tmp={};
        var myCart = [];
        //item array(type=good)
        var tbCart = $("#table-req-list").dataTable();
        <?php 
            foreach ($item_info as $item){
                if ($item["Type"]=="GOOD"){
                    echo "tmp={};";
                    foreach($item as $k=>$v) { ?>
                        tmp["<?php echo $k; ?>"] = "<?php echo $v; ?>"; 
                    <?php } ?>
                    items_info.push(tmp);
              <?php  }
            } ?>
        // insert item options tags
        $fromBrancEl = $("#tabs-2 select[name='frombranch']");
        $toBrancEl = $("#tabs-2 select[name='tobranch']");
        $itemSelEl2 = $("#item_select_req");
        function insertOptTageForItems(){
            var rootEl = $itemSelEl2.find("optgroup");
            var fromBranchBal = $fromBrancEl.val()||"",
                toBranchBal = $toBrancEl.val()||"";
            if (fromBranchBal=="PROCUREMENT") fromBranchBal="Bal";
            if (toBranchBal=="PROCUREMENT") toBranchBal="Bal";
            rootEl.children().remove();
            if(fromBranchBal=="" || toBranchBal=="" ) return;
            $.each(items_info,function(){
                $("<option></option>")
                    .val(this.ItemCode||"")
                    .data("frombal",this[fromBranchBal]||0)
                    .data("tobal",this[toBranchBal]||0)
                    .data("pack",this["Pack"]||0)
                    .data("purprice",this["PurchPrice"]||0)
                    .text((this.ItemName||"")+"- Bal:"+(this[toBranchBal]||0))
                    .appendTo(rootEl);
            });
        }
        
        $toBrancEl.on("change",function(){
            if ($fromBrancEl.val()==""){
                $.alert("Please select frombranch value.","warning");
                return;
            }
            insertOptTageForItems();
        });
        $fromBrancEl.on("change",function(){
            if ($toBrancEl.val()==""){
                $.alert("Please select tobranch value.","warning");
                return;
            }
            insertOptTageForItems();
        });
        $itemSelEl2.on("change",function(){
            var $this = $(this),
                $actEl = $this.find("option:selected"),
                code = $actEl.val(),
                pack = eval($actEl.data("pack"))||0,
                fBal = eval($actEl.data("frombal"))||0,
                tBal = eval($actEl.data("tobal"))||0;
            curr_code = code;
            $("#tabs-2 input[name='pack']").val(pack);
            var a=(pack==0)?0:Math.floor(fBal/pack);
	        var b=(pack==0)?0:fBal%pack;
            $("#tabs-2 input[name='curr_unit']").val(a);
            $("#tabs-2 input[name='curr_parts']").val(b);
        });
        
        $("#add_cart").on("click",function(e){

            e.preventDefault();
            var code = $itemSelEl2.find("option:selected").val(),
                ounits = eval($("#tabs-2 input[name='curr_unit']").val())||0,
                oparts = eval($("#tabs-2 input[name='curr_parts']").val())||0,
                runits = eval($("#tabs-2 input[name='req_unit']").val())||0,
                rparts = eval($("#tabs-2 input[name='req_parts']").val())||0,
                pack = $("#tabs-2 input[name='pack']").val(),
                oBal = pack*ounits+oparts,
                rBal = pack*runits+rparts;
            if(code=="") return;
            if (runits==0 && rparts==0){
                $.alert("Please input units and parts value.","Error");
                return;
            }
            if(oBal<rBal){
                $.alert("Quantity requested cannot exceed the stock balance!","Error");
                return;
            };
            var tBal = rBal;
            $.each(myCart,function(){
                if (this["code"]==code&&this["status"]==1){
                    tBal += pack*this["units"] +this["parts"];
                }
            });
            if(oBal<tBal){
                $.alert("Quantity requested cannot exceed the stock balance!","Error");
                return;
            };
            cart={
                "name":$itemSelEl2.find("option:selected").text().split("-")[0],
                "code":code,
                "units":runits,
                "parts":rparts,
                "pack":pack,
                "from":$fromBrancEl.val(),
                "to":$toBrancEl.val(),
                "status":1
            };

            myCart.push(cart);
            var n = myCart.length;
            tbCart.fnAddData([
                cart["name"],
                cart["from"],
                cart["to"],
                cart["units"],
                cart["parts"],
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