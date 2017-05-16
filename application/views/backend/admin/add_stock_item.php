
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('add_stock_item'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/stockitems/create"" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Code'); ?></label>

                        <div class="col-sm-5">
                            <input type="text" disabled name="itemcode" class="form-control" id="field-1" value="auto number" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('item_name*'); ?></label>

                        <div class="col-sm-5">
                            <input type="text" name="itemname" class="form-control" id="field-1" required placeholder="Type Item name." >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Type'); ?></label>

                        <div class="col-sm-5">  
                            <select name="type" class="form-control">
                                <option value="GOOD" >GOOD</option>
                                <option value="SERVICE" >SERVICE</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Category'); ?></label>

                        <div class="col-sm-5">
                            <select name="category" class="form-control" id="cat_select">
                                <option value="CSSD" ><?php echo get_phrase('CSSD');?></option>
                                <option value="GENERAL" ><?php echo get_phrase('GENERAL');?></option>
                                <option value="HOUSEKEEPING" ><?php echo get_phrase('HOUSEKEEPING');?></option>
                                <option value="KITCHEN"  ><?php echo get_phrase('KITCHEN');?></option>
                                <option value="LABORATORY"  ><?php echo get_phrase('LABORATORY');?></option>
                                <option value="PHARMACEUTICALS"  ><?php echo get_phrase('PHARMACEUTICALS');?></option>
                                <option value="STATIONERY"><?php echo get_phrase('STATIONERY');?></option>
                                <option value="PROCUREMENT"><?php echo get_phrase('PROCUREMENT');?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('sub_Category'); ?></label>
                        <div class="col-sm-5">
                            <select name="subcategory" class="form-control" placeholder="select subcategory">
                                <option value=""><?php echo get_phrase('select_subcategory'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('supplier'); ?></label>
                        <div class="col-sm-5">
                            <select id="sup_select" name="supid" class="form-control" >
                                <option value=""><?php echo get_phrase('type_search_term'); ?></option>
                                <?php 
                                    $this->db->order_by("CustomerName");
                                    $all_items_info= $this->db->get("creditsuppliers")->result_array();
                                    foreach ($all_items_info as $item){ ?>
                                        <option value="<?php echo $item['CustomerId']; ?>"><?php echo $item['CustomerName']; ?></option>
                                <?php }  ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('pack_size*'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="pack" required class="form-control" id="field-1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Minimum_Bal(Departmental)'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="minbal" class="form-control" id="field-1" title="In terms of Units not parts"  >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('sale_price*'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="saleprice" class="form-control" id="field-1" required placeholder="0" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('purchase_price'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="purchaseprice" class="form-control" id="field-1"  placeholder="0" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('vat'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="vat" class="form-control" id="field-1"   >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('molecule'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="molecule" class="form-control" id="field-1" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Taxable'); ?></label>

                        <div class="col-sm-5">
                            <select name="taxable" class="form-control">
                                <option value="NO"  ><?php echo get_phrase('NO');?></option>
                                <option value="YES" ><?php echo get_phrase('YES');?></option>
                            </select>
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('sellable'); ?></label>
                        <div class="col-sm-5">
                            <select name="sellable" class="form-control">
                                <option value="YES"><?php echo get_phrase('YES');?></option>
                                <option value="NO" ><?php echo get_phrase('NO');?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('lead_time'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="leadtime" class="form-control" id="field-1">
                        </div>
                    </div>
                    <div class="col-sm-3 control-label col-sm-offset-2">
                        <input type="submit" class="btn btn-success" value="Add Item">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("input[name='pack']").ForceNumericOnly();
    $("input[name='minbal']").ForceNumericOnly();
    $("input[name='saleprice']").ForceNumericOnly();
    $("input[name='purchaseprice']").ForceNumericOnly();
    $("#cat_select").on("change",function(){
        changeSubCategory($(this).val());
    });
    function changeSubCategory(cat){
        if (cat=="") return;
        $("select[name='subcategory']").children().remove();
        $.get("<?php echo base_url(); ?>"+"index.php?modal/getsubcategory/"+cat, function(res){
            res = eval(res);
            $("<option></option>").val("").text("Select subcategory").appendTo($("select[name='subcategory']"));
            $.each(res,function(){
                $("<option></option>").val(this["name"]).text(this["name"]).appendTo($("select[name='subcategory']"));
            })
        });
    }
    changeSubCategory($("#cat_select").val());
</script>