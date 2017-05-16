<div class="row">
    <div class="col-sm-12">
        <h4 class="add-patient-sub-title"><?php echo get_phrase('Basic_information'); ?></h4>
        <div class="col-sm-12 col-md-4">
            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('department'); ?></label>
            <div class="col-sm-9">
                <select required name="branch" class="form-control" placeholder="Branch">
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
        <div class="col-sm-12 col-md-4">
            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('category'); ?></label>
            <div class="col-sm-9">
                <select required name="category" class="form-control" placeholder="All">
                    <option value="" ><?php echo get_phrase('all'); ?></option>
                    <?php 
                        $this->db->order_by("ItemCat");
                        $this->db->where("Type","GOOD");
                        $cat_list = $this->db->get("categories")->result_array();
                        foreach ($cat_list as $item){?>
                            <option value="<?php echo $item['ItemCat']; ?>" ><?php echo $item['ItemCat']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('sub_Category'); ?></label>
            <div class="col-sm-9">
                <select name="subcategory" class="form-control" placeholder="All">
                    <option value=""><?php echo get_phrase('all'); ?></option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <h4 class="add-patient-sub-title"><?php echo get_phrase('stock_valuation_list'); ?></h4>
        <table class="table table-bordered table-striped datatable" id="table-val-list">
            <thead>
                <tr>
                    <th><?php echo get_phrase('item_name');?></th>
                    <th><?php echo get_phrase('category');?></th>
                    <th><?php echo get_phrase('sub_category');?></th>
                    <th><?php echo get_phrase('pack_size');?></th>
                    <th><?php echo get_phrase('unit');?></th>
                    <th><?php echo get_phrase('part');?></th>
                    <th><?php echo get_phrase('Total');?></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    jQuery(window).load(function ()
    {
        var $ = jQuery;

        $("#table-val-list").dataTable({
            "sPaginationType": "bootstrap",
            aaSorting:[[0,"desc"]],
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Highlighted rows
        $("#table-val-list tbody input[type=checkbox]").each(function (i, el)
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

    $("#tabs-6 select[name='category']").on("change",function(){
        changeSubCategory($(this).val());
    });
    function changeSubCategory(cat){
        if (cat=="") return;
        $("#tabs-6 select[name='subcategory']").children().remove();
        $.get("<?php echo base_url(); ?>"+"index.php?modal/getsubcategory/"+cat, function(res){
            res = eval(res);
            $("<option></option>").val("").text("All").appendTo($("select[name='subcategory']"));
            $.each(res,function(){
                $("<option></option>").val(this["name"]).text(this["name"]).appendTo($("select[name='subcategory']"));
            })
        });
    }
    changeSubCategory($("#tabs-6 select[name='category']").val());
    });
</script>
<script>
    jQuery(window).load(function(){
        var $=jQuery;
        function displayValuation(){
            var rootEl = $itemSelEl2.find("optgroup");
            var branch = $("#tabs-6 select[name='branch']").val()||"",
                cat = $("#tabs-6 select[name='category']").val()||"",
                subcat = $("#tabs-6 select[name='subcategory']").val()||"";
            if (branch=="PROCUREMENT") branch="Bal";
            var tb = $("#table-val-list").dataTable();
            tb.fnClearTable(true);
            if (branch=="") return; 
            $.each(items_info,function(){
                var tmp = this;
                var bal = eval(tmp[branch])||0;
                if (bal>0){
                    var pack = eval(tmp["Pack"])||0;
                    if (pack>0){
                        var b=true;
                        if (cat!="" && tmp["Category"]!=cat) b= false;
                        if (subcat!="" && tmp["SubCategory"]!=subcat) b= false;
                        if (b){
                            var unit = Math.floor(bal/pack),
                            part = bal%pack;
                            tb.fnAddData([
                                tmp["ItemName"],
                                tmp["Category"],
                                tmp["SubCategory"],
                                tmp["Pack"],
                                unit,
                                part,
                                bal*tmp["SalePrice"]
                            ]);    
                        }
                    }
                }
            });
        };
        displayValuation();
        $("#tabs-6 select[name='branch']").on("change",function(){
            displayValuation();
        });
        $("#tabs-6 select[name='category']").on("change",function(){
            displayValuation();
        });
        $("#tabs-6 select[name='subcategory']").on("change",function(){
            displayValuation();
        });
    });
</script>