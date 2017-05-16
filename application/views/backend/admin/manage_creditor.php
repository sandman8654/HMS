<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3 id="test-date"><?php echo get_phrase('creditors_management'); ?></h3>
                </div>
            </div>
            
            <div class="panel-body">
                <div class="col-md-12 col-sm-12">
                    <ul class="nav nav-tabs bordered">
                        <li class="active"><a href="#tabs-1" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('make_payments'); ?></span></a></li>
                        <li><a href="#tabs-2" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('edit_creditors'); ?></span></a></li>
                        <li><a href="#tabs-3" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('statements'); ?></span></a></li>
                    </ul>
                    <div  class="tab-content recep-tab">
                        <div id="tabs-1" class="tab-pane active">
                            <form role="form" class="form-horizontal form-groups-bordered" >
                                <div class="col-md-5 col-sm-12 has-right-border" style="height:500px;">
                                    <h4 class="add-patient-sub-title"><?php echo get_phrase('creditor_information'); ?></h4>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('creditor_name:'); ?></label>
                                        <div class="col-sm-9">
                                            <select id="crname_select" name="drname" class="form-control select2" placeholder="<?php echo get_phrase('type_search_term');?>">
                                                <option value=""><?php echo get_phrase('type_search_term'); ?></option>
                                                <optgroup label="<?php echo get_phrase('creditor'); ?>">
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
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('A/c:'); ?></label>

                                        <div class="col-sm-9">
                                            <select id="ac_select" name="acname" class="form-control select2" placeholder="<?php echo get_phrase('type_search_term');?>">
                                                <option value=""><?php echo get_phrase('type_search_term'); ?></option>
                                                <optgroup label="<?php echo get_phrase('A/C'); ?>">
                                                    <?php 
                                                        $this->db->where("type","Asset");
                                                        $all_items_info= $this->db->get('ledgers')->result_array();
                                                        foreach ($all_items_info as $item){ ?>
                                                        <option value=<?php echo $item['ledgerid']; ?>><?php echo $item['name']; ?></option>
                                                   <?php } ?>
                                                </optgroup>    
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="refno" class="col-sm-3 control-label"><?php echo get_phrase('Ref_no:'); ?></label>

                                        <div class="col-sm-9">
                                            <input type="text" name="refno" class="form-control" id="refno" >
                                        </div>
                                    </div>    
                                    <div class="form-group">
                                        <label for="total" class="col-sm-3 control-label"><?php echo get_phrase('total'); ?></label>

                                        <div class="col-sm-9">
                                            <input type="text" data-total="0" disabled name="total" class="form-control" id="total" value=0 >
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="balance" class="col-sm-3 control-label"><?php echo get_phrase('balance'); ?></label>

                                        <div class="col-sm-9">
                                            <input type="text" disabled name="balance" class="form-control" id="balance" value=0 >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-3 control-label col-sm-offset-2">
                                            <a href="#" class="btn btn-success btn-md" id="saverecpay" ><?php echo get_phrase('save'); ?></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7 col-sm-12 " style="height:500px;overflow:auto">
                                   <h4 class="add-patient-sub-title"><?php echo get_phrase('Invoice_information'); ?></h4>
                                   <table class="table table-bordered table-striped datatable" id="table-inv-list">
                                        <thead>
                                            <tr>
                                                <th><?php echo get_phrase('check');?></th>
                                                <th><?php echo get_phrase('date');?></th>
                                                <th><?php echo get_phrase('invoice_no');?></th>
                                                <th><?php echo get_phrase('amount');?></th>
                                                <th><?php echo get_phrase('paid');?></th>
                                                <th><?php echo get_phrase('invoice_balance');?></th>
                                                <th><?php echo get_phrase('paying');?></th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                        <div id="tabs-2" class="tab-pane ">
                            <h4 class="add-patient-sub-title"><?php echo get_phrase('creditors_information'); ?></h4>
                            <a onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/add_creditor');" 
                                class="btn btn-success btn-sm "  style="margin-bottom:10px">
                                    <?php echo get_phrase("add_new_credibtor")?>
                            </a>
                            
                            <table class="table table-bordered table-striped datatable" id="table-creditor-list">
                                <thead>
                                    <tr>
                                        <th><?php echo get_phrase('No');?></th>
                                        <th><?php echo get_phrase('Customer_name');?></th>
                                        <th><?php echo get_phrase('telephone');?></th>
                                        <th><?php echo get_phrase('balance');?></th>
                                        <th><?php echo get_phrase('action');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  $this->db->order_by("CustomerName");
                                        $list = $this->db->get("creditsuppliers")->result_array();
                                        foreach ($list as $row) { ?>   
                                        <tr>
                                            <td><?php echo $row['CustomerId']?></td>
                                            <td><?php echo $row['CustomerName']?></td>
                                            <td><?php echo $row['Tel']?></td>
                                            <td><?php echo $row['Bal']?></td>
                                            <td>
                                                <a  onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/edit_creditor/<?php echo $row['CustomerId']?>');" 
                                                    class="btn btn-default btn-sm btn-icon icon-left">
                                                        <i class="entypo-pencil"></i>
                                                        Edit
                                                </a>
                                                <a href="<?php echo base_url();?>index.php?admin/mngcreditor/delete/<?php echo $row['CustomerId']?>" 
                                                    class="btn btn-danger btn-sm btn-icon icon-left" onclick="return checkDelete();">
                                                        <i class="entypo-cancel"></i>
                                                        Delete
                                                </a>
                                                
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="tabs-3" class="tab-pane ">
                            <div class="col-sm-12 col-md-5">
                                <form role="form" class="form-horizontal form-groups-bordered">
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('company_name'); ?></label>
                                        <div class="col-sm-9">
                                            <select  name="crid" class="form-control select2" placeholder="<?php echo get_phrase('type_search_creditor');?>" required>
                                                <option value=""><?php echo get_phrase('type_search_creditor'); ?></option>
                                                <?php 
                                                    $all_items_info= $this->db->get('creditsuppliers')->result_array();
                                                    foreach ($all_items_info as $item){ ?>
                                                    <option value=<?php echo $item['CustomerId']; ?>><?php echo $item['CustomerName']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('from'); ?></label>

                                        <div class="col-sm-9">
                                            <input type="text" name="from_date" class="form-control datepicker" id="field-1" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('to'); ?></label>

                                        <div class="col-sm-9">
                                            <input type="text" name="to_date" class="form-control datepicker" id="field-1" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('view_all'); ?></label>

                                        <div class="col-sm-5">
                                            <input  id="viewall" name="viewall" type="checkbox" value="0"></input>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-3 control-label col-sm-offset-2">
                                            <a href="<?php echo base_url(); ?>index.php?admin/viewstatment" class="btn btn-success btn-md" onclick="checkviewstatus()"><?php echo get_phrase('view_statement'); ?></a>
                                        </div>
                                    </div>
                                </form>    
                            </div>
                            
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
        $("#table-inv-list").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Highlighted rows
        $("#table-inv-list tbody input[type=checkbox]").each(function (i, el)
        {
            var $this = $(el),
                    $p = $this.closest('tr');

            $(el).on('change', function ()
            {
                var is_checked = $this.is(':checked');

                $p[is_checked ? 'addClass' : 'removeClass']('highlight');
            });
        });
        $("#table-creditor-list").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Highlighted rows
        $("#table-creditor-list tbody input[type=checkbox]").each(function (i, el)
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

    jQuery(window).load(function ()
    {   
        $=jQuery;
        $("#crname_select").on("change",function(){
            var cusid = $(this).val();
            $.get("<?php echo base_url();?>"+"index.php?modal/getcreditorinvoice/"+cusid,function(res){
                var data = eval(res),
                    tb = $("#table-inv-list").dataTable();
                $("#total").val("0");
                $("#total").data("total","0");
                var bal = eval($("#crname_select option:selected").data("bal"))||0;
                 $("#balance").val(bal);
                tb.fnClearTable(true) ;
                $.each(data,function(id){
                    tb.fnAddData([
                        "<input type='checkbox' id='tbl-chk-"+this["id"]+"' value='0' disabled>",
                        this["date"],
                        this["invno"],
                        this["amount"],
                        this["paid"],
                        this["invbal"],
                        "<input type='text' data-bal='"+this["bal"]+"' id='tbl-num-"+this["id"]+"' placeholder='0'>"
                    ]);
                    $("#tbl-num-"+this["id"]).ForceNumericOnly();
                    $("#tbl-num-"+this["id"]).on("keyup",function(e){
                        var $this=$(this),
                            id = $this.attr("id").split("-")[2],
                            bal = eval($this.data("bal"))||0;
                            st = $("#tbl-chk-"+id).prop("checked");
                        $this.attr("title","To make a payment, you have to click checkbox.");    
                        $this.tooltip();
                        var v= eval($this.val())||0;
                        if (v>0) {
                            if (v>bal){
                                $.alert("Payment made is more than the invoice balance!","error");
                                $("#tbl-chk-"+id).attr("disabled","true");
                            }else{
                                $("#tbl-chk-"+id).removeAttr("disabled");
                            }
                        }else
                            $("#tbl-chk-"+id).attr("disabled","true");
                    });
                    $("#tbl-chk-"+this["id"]).on("change",function(e){
                        var $this=$(this),
                            id = $this.attr("id").split("-")[2],
                            paid = eval($("#tbl-num-"+id).val())||0,
                            v = $(this).val();
                        $this.val(v=="0"?"1":"0");
                        var paid = eval($("#tbl-num-"+id).val())||0;
                        var totalPrice = eval($("#total").val())||0;
                        var bal = eval($("#balance").val())||0;
                        if($this.val()=="1"){
                            totalPrice += paid;
                            $("#balance").val(bal-paid);
                            $("#tbl-num-"+id).attr("disabled","true");
                        }else{
                            $("#tbl-num-"+id).removeAttr("disabled");
                            totalPrice -= paid;
                             $("#balance").val(bal+paid);
                        };
                        $("#total").val(totalPrice);
                    });
                });
                
                
            });
        });
        $('#saverecpay').on("click",function(e){
            e.preventDefault();
            var data=[];
            $("#table-inv-list tbody").find("tr").each(function(){
                var $this = $(this);
                var chkEl = $this.children().eq(0).find("input"),
                    payingBalEl = $this.children().eq(6).find("input");
                if (typeof payingBalEl.attr("id") == "undefined") return;
                id = payingBalEl.attr("id").split("-")[2];
                if (chkEl.prop("checked")){
                    var tmp={};
                    tmp["id"] = id;
                    tmp["paying"] = payingBalEl.val();
                    data.push(tmp);
                }
            });
            if (data.length==0){
                 $.alert("payment item is empty!'.","Error");
                return;
            };
            var cid = $("#crname_select").val(),
                lid = $("#ac_select").val(),
                refno=$("#refno").val();
            if (lid==""){
                $.alert("You have to select 'A/c name'.","Error");
                return;
            }
            
            $.post("<?php echo base_url();?>index.php?modal/makepaymentforcr/"+cid+"/"+lid,{refno:refno,data:data},function(res){
                if(res=="success"){
                    $.alert("Transaction success","success");
                }else{
                    $.alert("Transaction Failure.Please Repeat the transaction.","error");
                }
            });
        });
        $("#viewall").on("change",function(){
            var v = $(this).val();
            $(this).val((v=="0")?"1":"0");
        });

    });
</script>
