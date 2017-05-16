<?php
//$param2 : reception id
if (strlen($param2)>0){
    $isset_param=true;
    $trans = $this->crud_model->get_pending_list_for_payment($param2)[0];
    $bill_list = $this->db->get_where("sales",array("recep_id"=>$param2,"status"=>0))->result_array();
    $pid = $trans["patient_id"];
    $patient_inf = $this->db->get_where("patient",array("patient_id"=>$pid))->row();
}
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('payments_process'); ?></h3>
                </div>
            </div>

            <div class="panel-body">
                <div class="pull-left" id="updated-date" >
                    <?php if($isset_param){
                        $date = date("d/m/Y H:i:s",$trans["posted_date"]);
                        echo"<p>This payment is posted at ". $date." </p>";
                    } ?>
                </div>
                <div class="pull-right">
                    <a href="#" id="submitbill" class="btn btn-success btn-md">Submit</a>
                    <a href="<?php echo base_url(); ?>index.php?admin/payment" class="btn btn-danger btn-md">Exit</a>
                </div>
                <div class="col-md-12 col-sm-12">
                    
                    <div class="col-sm-12 col-md-6 has-right-border">
                        <form role="form" class="form-horizontal form-groups-bordered" >
                            <h4 class="add-patient-sub-title"><?php echo get_phrase('patient_information'); ?></h4>
                            <div class="form-group">
                                <p><?php echo get_phrase('patient_name');?>:&nbsp;<?php echo $patient_inf->name;?></p>
                                <p><?php echo get_phrase('reception_no');?>:&nbsp;<?php echo $param2;?></p>
                            </div>
                            <h4 class="add-patient-sub-title"><?php echo get_phrase('posted_bill_information'); ?></h4>
                            <div class="form-group" style="height:500px">
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-striped datatable" id="table-pending-list">
                                        <thead>
                                            <tr>
                                                <th><?php echo get_phrase('item_code');?></th>
                                                <th><?php echo get_phrase('item_name');?></th>
                                                <th><?php echo get_phrase('quantity');?></th>
                                                <th><?php echo get_phrase('unit_price');?></th>
                                                <th><?php echo get_phrase('discount');?></th>
                                                <th><?php echo get_phrase('total_price');?></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php 
                                            foreach ($bill_list as $row) { 
                                                $item_inf = $this->db->get_where("items",array("ItemCode"=>$row['item_id']))->row();
                                                ?>   
                                                <tr>
                                                    <td><?php echo $row['item_id']?></td>
                                                    <td><?php echo $item_inf->ItemName ?></td>
                                                    <td><?php echo $row['qty']?></td>
                                                    <td><?php echo $row['unit_price']?></td>
                                                    <td><?php echo $row['discount']?></td>
                                                    <td><?php echo $row["qty"]*$row["unit_price"]-$row["discount"]?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-6 ">
                        <form role="form" class="form-horizontal form-groups-bordered" >
                            <h4 class="add-patient-sub-title"><?php echo get_phrase('payment_information'); ?></h4>
                            <div class="form-group">
                                <div class="col-md-4 col-sm-12">
                                    <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('Bill').": "; ?></label>
                                    <div class="col-md-9">
                                        <input disabled type="text" name="name" class="form-control" id="field-bill" value="<?php echo $trans["total"] ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('Paid').": "; ?></label>
                                    <div class="col-md-9">
                                        <input disabled type="text" name="name" class="form-control" id="field-paid" value="0"/>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('Bal').": "; ?></label>
                                    <div class="col-md-9">
                                        <input disabled type="text" name="name" class="form-control" id="field-bal" value="0"/>
                                    </div>
                                </div>
                            </div>
                            <h4 class="add-patient-sub-title"><?php echo get_phrase('receive_payments'); ?></h4>
                            <div class="form-group">
                                <div class="col-md-3 col-sm-12" style="margin-bottom: 10px;">
                                    <label for="field-ta" class="control-label"><?php echo get_phrase('mode').": "; ?></label>
                                    <select id="mode-select" name="mode-select" class="form-control " placeholder=<?php echo get_phrase('type_search_term');?>>
                                        <option value="Cash" selected="selected">Cash</option>
                                        <option value="Waiver" >Waiver</option>
                                        <option value="Credit">Credit</option>
                                        <option value="Companies">Companies</option>
                                        <option value="Bank">Bank</option>        
                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-12 hidden" id="insur_div" style="margin-bottom: 10px;">
                                    <label for="field-ta" class="control-label"><?php echo get_phrase('A/C').": "; ?></label>
                                    <select id="insur-select" name="insur-select" class="form-control" >
                                        <?php 
                                            $this->db->order_by("CustomerName");
                                            $comp = $this->db->get("creditcustomers")->result_array();
                                            foreach($comp as $row){?>
                                            <option value=<?php echo $row['CustomerId'];?>><?php echo $row["CustomerName"];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-12 hidden" id="bank_div" style="margin-bottom: 10px;">
                                    <label for="field-ta" class="control-label"><?php echo get_phrase('A/C').": "; ?></label>
                                    <select id="bank-select" name="bank-select" class="form-control" >
                                    <?php 
                                        $bank = $this->db->get_where("ledgers",array("type"=>"Asset","category"=>"Bank"))->result_array();
                                        foreach($bank as $row){?>
                                        <option value=<?php echo $row['ledgerid'];?>><?php echo $row["name"];?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-12 hidden" style="margin-bottom: 10px;" id="cno_div">
                                    <label for="field-ta" class="control-label"><?php echo get_phrase('ref_no').": "; ?></label>
                                    <input disabled type="text" name="name" class="form-control" id="field-cardno" value="<?php echo $patient_inf->cardno ;?>"/>
                                 </div>
                                <div class="col-md-4 col-sm-12" style="margin-bottom: 10px;">
                                    <label for="field-ta" class="control-label"><?php echo get_phrase('amount').": "; ?></label>
                                    <input type="text" name="name" class="form-control" id="field-amount" value="0" required/>
                                </div>
                                
                            </div>
                            <div style="margin:10px;height:10px">
                                <a href="#" id="addcarts" class="btn btn-success btn-md pull-left">Add</a>
                      <!--          <input type="checkbox" name="creditnote" id="creditnote" style="float:right;margin:8px 3px 0 3px" ></input>
                                <label for="field-ta" class="control-label" style="float:right"><?php echo get_phrase('credit_note').": "; ?></label>-->
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-striped datatable" id="table-payment-list">
                                        <thead>
                                            <tr>
                                                <th><?php echo get_phrase('mode');?></th>
                                                <th><?php echo get_phrase('A/C_id');?></th>
                                                <th><?php echo get_phrase('A/C_name');?></th>
                                                <th><?php echo get_phrase('Ref_no');?></th>
                                                <th><?php echo get_phrase('amount');?></th>
                                                <th><?php echo get_phrase('option');?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="display:none" data-url="<?php echo base_url(); ?>" id="baseurl"></div>

<script type="text/javascript">
//table box event
    jQuery(window).load(function ()
    {
        var $ = jQuery;

        var pmTable = $("#table-payment-list").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
        });
       

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Highlighted rows
        $("#table-payment-list tbody input[type=checkbox]").each(function (i, el)
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
   
   var globalReceptionID= "<?php echo ($isset_param)?$param2:"";?>",
        globalPatientID = "<?php echo $pid;?>",
        myCarts=[];
   
   
   jQuery(window).load(function (){
        var $ = jQuery;
        var pmTable = $("#table-payment-list").dataTable();
        // if check patient id
        function checkPatientId(){
            var patid = $("#patientselect").find("option:selected").val();
            if (patid.length==0){
                $.alert("<?php echo get_phrase('select_patient');?>",'Error!' );       
                return false;
            }
            return true;
        };

        $("#mode-select").on('change',function(){
           var $this = $(this);
           var val = $this.val();
           if (val=="Cash"||val=="Credit"){
                $("#insur_div").addClass("hidden");
                $("#bank_div").addClass("hidden");
                $("#cno_div").addClass("hidden");
           }else if(val=="Waiver"){
                $("#insur_div").addClass("hidden");
                $("#bank_div").addClass("hidden");
                $("#cno_div").removeClass("hidden");
           }else if(val=="Companies"){
                $("#insur_div").removeClass("hidden");
                $("#bank_div").addClass("hidden");
                $("#cno_div").removeClass("hidden");
           }else if(val=="Bank"){
                $("#insur_div").addClass("hidden");
                $("#bank_div").removeClass("hidden");
                $("#cno_div").removeClass("hidden");
           }     
        });
  
        // add cart info to datatable
        $("#addcarts").on('click',function(e){
            e.preventDefault();
            var cart={};
            cart["amount"] = eval($("#field-amount").val())||0;
            if (cart["amount"] ==0) return;
            var mode = cart["mode"] = $("#mode-select").val();
            if (mode=="Cash"){
                cart["acid"] = ""; cart["refno"]="";cart["acname"]="";
            }else if(mode=="Waiver"){
                cart["acid"] = ""; 
                cart["refno"]=$("#cno_div").val();
                cart["acname"]="";
            }else if(mode=="Companies"){
                cart["acid"] = $("#insur-select").val(); 
                cart["refno"]=$("#cno_div").val();
                cart["acname"]=$("#insur-select").find("option:selected").text();
            }else if(mode=="Credit"){
                cart["acid"] = ""; 
                cart["refno"]="";
                cart["acname"]="";
            }else if(mode=="Bank"){
                cart["acid"] = $("#bank-select").val(); 
                cart["refno"]=$("#cno_div").val();
                cart["acname"]=$("#bank-select").find("option:selected").text();
            }
           
            //add cart item
            pmTable.fnAddData([
                cart["mode"],
                cart["acid"],
                cart["acname"],
                cart["refno"],
                cart["amount"],
                "<a href='#' id='del_cart_item_"+myCarts.length+"' data-id="+myCarts.length+" class=\"btn btn-danger btn-sm btn-icon icon-left\"><i class=\"entypo-cancel\"></i>Delete</a>"
            ]);
             //delete cart item function
            $("#del_cart_item_"+myCarts.length).on("click",function(e){
                e.preventDefault();
                var nTr=$(this).parents('tr')[0];
                pmTable.fnDeleteRow(nTr);
                var pr = $($(nTr).children()[4]).text();
                changePaidPrice(eval(pr),1);
                var id = $(this).data("id");
                myCarts[id]["status"]=0;
            });
            changePaidPrice(cart["amount"],0);
            cart["status"]=1;
            myCarts[myCarts.length] = cart;
            //change final price;
            function changePaidPrice(am,b){
                var bill = eval($("#field-bill").val())||0,
                    paid = eval($("#field-paid").val())||0,
                    cm = paid+am; 
                    if(b) cm -= 2*am;
                    bal = bill-cm;
                    $("#field-paid").val(cm);
                    $("#field-bal").val(bal);
           };

        });
        // submit payment information
        $("#submitbill").on("click",function(e){
            e.preventDefault();
            var bal = eval($("#field-bal").val())||0;
            if (bal<0){
                $.alert("more paid, balance can not be less than 0.","Error");
                return;
            };
            // ready data
            var data = {
                    patient_id:globalPatientID,
                    recept_id:globalReceptionID,
                    url:"<?php echo base_url();?>"+"index.php?modal/submitpayment/",
                    creditstatus:$("#creditnote").prop("checked")?1:0,
                    bal:bal,//eval($("#field-bal").val())||0,
                    carts:function(items){
                        var res=[];
                        $.each(items, function(id){
                            items[id].status && (res[res.length]=items[id]);
                        });
                        return res;
                    }(myCarts)
            };
            // if cart is empty
            if (data.carts.length==0){
                $.alert("<?php echo get_phrase('cart_is_empty!') ?>"); return;
            }
            // remove delete button on datatable if success after submitted;
            var afterCallback = function(){
                myCarts=[];
                var $table = $("#table-payment-list");
                $table.find("tr").each(function(id){
                    var $this = $(this);
                    $this.find("td").last().find("a").remove();
                });
            };
            // confirmation for submitting carts bill.
            $.confirm({
                title: '<?php echo get_phrase("submit_patient_payment_confirmation");?>',
                content: '<?php echo get_phrase("submit_patient_payment_confirmation_message");?>',
                buttons: {
                    confirm: function () {
                        submitPayment(data);
                    },
                    cancel: function () {
                     //   $.alert('Canceled!');
                    }
                }
            });
            // after submmited
        });
    });
</script>

