          
<div class="row">
    <div class="col-md-offset-4 col-md-4 col-sm-12">

        <div class="panel panel-primary " data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('stock_usage_register'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/stockusageregister/create/<?php echo $row['ItemCode']; ?>" method="post" enctype="multipart/form-data">
                    <h4 class="add-patient-sub-title"><?php echo get_phrase('stock_item_information'); ?></h4>
                    <div class="form-group">
                        <p class="col-sm-3"><?php echo get_phrase('branch*'); ?></p>
                        <div class="col-sm-12">
                            <select required name="branch" class="form-control" placeholder="Branch">
                                <option value="" ><?php echo get_phrase('select_branch'); ?></option>
                                <?php 
                                    $this->db->order_by("name");
                                    $branch_list = $this->db->get("branch")->result_array();
                                    foreach ($branch_list as $item){?>
                                        <option value="<?php echo $item['id'].'-'.$item['name']; ?>" ><?php echo $item['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3"><?php echo get_phrase('items'); ?></label>
                        <div class="col-sm-12">
                            <select id="item_select_adj" name="item" class="form-control select2" placeholder="<?php echo get_phrase('type_search_term');?>">
                                <option value=""><?php echo get_phrase('type_search_item'); ?></option>
                                <optgroup label="<?php echo get_phrase('stock_item'); ?>">
                                     <?php 
                                        foreach ($item_info as $item){?>
                                            <option value="<?php echo $item['ItemCode']; ?>" ><?php echo $item['ItemName']; ?></option>
                                    <?php } ?>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3"><?php echo get_phrase('qty_used*'); ?></label>
                        <div class="col-sm-12">
                            <input type="text" name="qty" class="form-control" id="field-1" value="0" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3"><?php echo get_phrase('note*'); ?></label>
                        <div class="col-sm-12">
                            <textarea name="note" class="form-control" id="field-ta" required></textarea>
                        </div>
                    </div>
                    <div class="col-sm-3 control-label col-sm-offset-2">
                        <input type="submit" class="btn btn-success" value="Register">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
 /*   $("input[name='pack']").ForceNumericOnly();
    $("input[name='minbal']").ForceNumericOnly();
    $("input[name='saleprice']").ForceNumericOnly();
    $("input[name='purchaseprice']").ForceNumericOnly();*/
    $("input[name='qty']").ForceNumericOnly();
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
      