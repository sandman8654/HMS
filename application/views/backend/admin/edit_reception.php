<?php
/*if (strlen($param2)>0) $isset_param=true;
$row = array();
if ($isset_param) {
    $single_patient_info = $this->db->get_where('patient', array('patient_id' => $param2))->result_array();
    if (count(single_patient_info)>0) $row = $single_patient_info[0];
}*/
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('patient_info_title'); ?></h3>
                </div>
            </div>

            <div class="panel-body">
                    <div class="pull-left" id="updated-date" ></div>
                    <div class="pull-right">
                        <a href="#" id="save" class="btn btn-success btn-md">Save</a>
                        <a href="<?php echo base_url(); ?>index.php?admin/reception" class="btn btn-danger btn-md">Exit</a>
                    </div>
                    <div class="col-md-12 col-md-12">
                        
                        <div class="col-md-5 col-md-5 has-right-border">
                            <form role="form" class="form-horizontal form-groups-bordered" >
                                <h4 class="add-patient-sub-title"><?php echo get_phrase('patient_detail_info_title'); ?></h4>
                                <div class="form-group">
                                    <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('select_patient_for_reception'); ?></label>
                                    <div class="col-md-9">
                                        <select id="patientselect" name="patient_group" class="form-control select2" placeholder=<?php echo get_phrase('selecet_patient_name_or_id');?>>
                                            <option value=""><?php echo get_phrase('select_a_patient'); ?></option>
                                            <optgroup label="<?php echo get_phrase('patient'); ?>">
                                                <?php $all_patient_info= $this->db->get_where('patient')->result_array();
                                                    foreach ($all_patient_info as $patient){ ?>
                                                    <option value=<?php echo $patient['patient_id']; ?> <?php if ($patient['patient_id'] == $param2) echo ' selected';?>><?php echo $patient['name']."- ".$patient['patient_id']; ?></option>        
                                                <?php } ?>
                                            </optgroup>    
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><?php echo get_phrase('image'); ?></label>
                                    <div class="col-md-9">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                <img src="http://placehold.it/200x150" id="pimg" alt="...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-1" class="col-md-3 control-label"><?php echo get_phrase('name'); ?></label>
                                    <div class="col-md-9">
                                        <input disabled type="text" name="name" class="form-control" id="field-pname" value="<?php echo ($isset_param)?$row['name']:''; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-md-3 control-label"><?php echo get_phrase('email'); ?></label>

                                    <div class="col-md-9">
                                        <input disabled type="email" name="email" class="form-control" id="field-pemail" value="<?php echo ($isset_param)?$row['email']:''; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('address'); ?></label>
                                    <div class="col-md-9">
                                        <textarea disabled name="address" class="form-control" id="field-paddress"><?php echo ($isset_param)?trim($row['address']):''; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-1" class="col-md-3 control-label"><?php echo get_phrase('phone'); ?></label>

                                    <div class="col-md-9">
                                        <input disabled type="text" name="phone" class="form-control" id="field-pphone"  value="<?php echo ($isset_param)?$row['phone']:''; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('sex'); ?></label>

                                    <div class="col-md-9">
                                        <input disabled type="text" name="phone" class="form-control" id="field-psex" >
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="field-1" class="col-md-3 control-label"><?php echo get_phrase('birth_of_date'); ?></label>

                                    <div class="col-md-9">
                                        <input disabled type="text" name="birth_date" class="form-control datepicker" id="field-pbod">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="field-1" class="col-md-3 control-label"><?php echo get_phrase('age'); ?></label>

                                    <div class="col-md-9">
                                        <input disabled type="number" name="age" class="form-control" id="field-page" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('blood_group'); ?></label>
                                    <div class="col-md-9">
                                        <input disabled type="text" name="blood_group" class="form-control" id="field-pbg" >
                                    </div>
                                </div>
                                            
                            </form>
                        </div>
                        <div class="col-md-7 col-md-7 ">

                            <ul class="nav nav-tabs bordered">
                                <li class="active"><a href="#tabs-1" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('payment_registration'); ?></span></a></li>
                                <li><a href="#tabs-2" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('consultation_billing'); ?></span></a></li>
                                <li><a href="#tabs-3" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('start_new_conversation'); ?></span></a></li>
                            </ul>
                            <div  class="tab-content recep-tab">
                                <div id="tabs-1" class="tab-pane active">
                                    <form role="form" class="form-horizontal form-groups-bordered">
                                        <div class="form-group">
                                            <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('payment_type'); ?></label>
                                            <div class="col-md-5">
                                                <select name="payment_type" id="payment_type" class="form-control">
                                                    <option value=0 selected><?php echo get_phrase('cash'); ?></option>
                                                    <option value=1><?php echo get_phrase('company'); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- put here patient insurance infomation -->
                                        <div class="form-group hidden compinfo">
                                            <label for="field-1" class="col-md-3 control-label"><?php echo get_phrase('scheme'); ?></label>
                                            <div class="col-md-5">
                                                <input disabled type="text" name="scheme" data-insurid="" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group hidden compinfo">
                                            <label for="field-1" class="col-md-3 control-label"><?php echo get_phrase('company'); ?></label>
                                            <div class="col-md-5">
                                                <input disabled type="text" name="insur_comp_name" class="form-control"  >
                                            </div>
                                        </div>
                                        <div class="form-group hidden compinfo">
                                            <label for="field-1" class="col-md-3 control-label"><?php echo get_phrase('insur_card_no'); ?></label>
                                            <div class="col-md-5">
                                                <input disabled type="text" name="insur_card_no" class="form-control"  >
                                            </div>
                                        </div>
                                        <div class="form-group hidden compinfo">
                                            <div class="col-md-5 pull-right">
                                                <a href="#" id="pick-smart" class="btn btn-success btn-md"><?php echo get_phrase('pick_smart_data');?></a>    
                                            </div>
                                        </div>    

                                        <div class="col-md-offset-1 col-md-5 control-label">
                                            <a href="#" id="save-billing-info" class="btn btn-success btn-md"><?php echo get_phrase('save_billing_info');?></a>
                                            <a href="<?php echo base_url(); ?>index.php?admin/reception" class="btn btn-danger btn-md"><?php echo get_phrase('exit');?></a>
                                            <div id="saved_status"></div>
                                        </div>
                                        <input type="hidden" name="insur_benamount" >
                                        <input type="hidden" name="insur_exid" >
                                        <input type="hidden" name="insur_forwardid" >
                                        <input type="hidden" name="insur_smartstatus"  >
                                    </form>  
                                    
                                </div>
                                <div id="tabs-2" class="tab-pane">
                                    <form role="form" class="form-horizontal form-groups-bordered">
                                       <h4 class="add-patient-sub-title"><?php echo get_phrase('billing'); ?></h4> 
                                       <div class="form-group">
                                            <label for="field-ta" class="col-md-2 control-label"><?php echo get_phrase('item').":"; ?></label>
                                            <div class="col-md-4">
                                                <select id="itemselect" name="items_group" class="form-control" >
                                                    <option value="" selected ><?php echo get_phrase('selecet_Item_name');?></option> 
                                                    <?php $all_items_info= $this->db->get_where('items')->result_array();
                                                        foreach ($all_items_info as $item){ ?>
                                                        <option value=<?php echo $item['ItemCode']; ?> data-price="<?php echo $item['SalePrice']; ?>" data-type="<?php echo $item['Type']; ?>"><?php echo $item['ItemName']." - ".$item['Type']; ?></option>        
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <label for="field-qty" class="col-md-1 control-label"><?php echo get_phrase('qty').":"; ?></label>    
                                            <div class="col-md-2">
                                                <input  type="text" name="cart_qty" class="form-control" id="field-qty" value="0"/>
                                            </div>
                                            <label for="field-price" class="col-md-1 control-label"><?php echo get_phrase('price').":"; ?></label>    
                                            <div class="col-md-2">
                                                <input type="text" name="cart_price" class="form-control" id="field-price" value="0" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="field-ta" class="col-md-2 control-label"><?php echo get_phrase('total_price').":"; ?></label>
                                            <div class="col-md-2">
                                                <input disabled type="text" name="cart_total_price" class="form-control" id="field-total-price" value="0"/>
                                            </div>
                                            <label for="field-ta" class="col-md-2 control-label"><?php echo get_phrase('discount').":"; ?></label>
                                            <div class="col-md-2">
                                                <input type="text" name="cart_discount_price" class="form-control" id="field-discount" value="0"/>
                                            </div>
                                            <label for="field-ta" class="col-md-2 control-label"><?php echo get_phrase('sub_net').":"; ?></label>
                                            <div class="col-md-2">
                                                <input disabled type="text" name="cart_subnet_price" class="form-control" id="field-subnet-price" value="0"/>
                                            </div>
                                         </div>
                                         <div class="form-group">   
                                            <div class="col-md-4">
                                                <select id="iid" name="items_group" class="form-control" >
                                                    <?php $all_items_info= $this->db->get_where('extmedics')->result_array();
                                                        foreach ($all_items_info as $item){ ?>
                                                        <option value=<?php echo $item['id']; ?>><?php echo $item['name']; ?></option>        
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <label for="field-ta" class="col-md-2 control-label"><?php echo get_phrase('final_total').":"; ?></label>
                                            <div class="col-md-2">
                                                <input disabled type="text" name="cart_subnet_price" class="form-control" id="field-final-price" value="0"/>
                                            </div>
                                             <div class="col-md-4 control-label">
                                                <a href="#" class="btn btn-success btn-md" id="additem"><?php echo get_phrase('add_item');?></a>
                                                <a href="#" class="btn btn-success btn-md" id="addbill"><?php echo get_phrase('add_bill');?></a>
                                            </div>
                                        </div>
                                        <h4 class="add-patient-sub-title"><?php echo get_phrase('items'); ?></h4> 
                                        <div class="form-group">
                                            <table class="table table-bordered table-striped datatable" id="item-table">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo get_phrase('itemName');?></th>
                                                        <th><?php echo get_phrase('quantity');?></th>
                                                        <th><?php echo get_phrase('unit_price');?></th>
                                                        <th><?php echo get_phrase('total_price');?></th>
                                                        <th><?php echo get_phrase('discount');?></th>
                                                        <th><?php echo get_phrase('subnet');?></th>
                                                        <th><?php echo get_phrase('remove');?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>    
                                    </form>
                                </div>
                                <div id="tabs-3"  class="tab-pane">
                                    <form role="form" class="form-horizontal form-groups-bordered" >
                                        <div class="form-group">
                                            <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('select_payment'); ?></label>
                                            <div class="col-md-5">
                                                <select name="select_payment" id="select_payment" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('patient_type'); ?></label>
                                            <div class="col-md-5">
                                                <select name="patient_type" id="patient_type" class="form-control">
                                                    <option value="new"><?php echo get_phrase('new_patient'); ?></value>
                                                    <option value="revisit"><?php echo get_phrase('revisit'); ?></value>
                                                    <option value="review"><?php echo get_phrase('review'); ?></value>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('send_to'); ?></label>
                                            <div class="col-md-5">
                                                <select name="send_to" id="send_to" class="form-control">
                                                    <option value="GENERAL CONSULTATIONS">General Consultations</option>
                                                    <option value="PHYSIOTHERAPY">Physiotherapy</option>
                                                    <option value="EYE CLINIC">Eye Clinic</option>
                                                    <option value="MCH">MCH</option>
                                                    <option value="NUTRITION">Nutrition</option>
                                                    <option value="DENTAL CLINIC">Dental Clinic</option>
                                                    <option value="PAEDIATRICS">Paediatrics</option>
                                                    <option value="COUNSELLING">Counselling</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <center>
                                                <a href="#" class="btn btn-success btn-md" id="additem"><?php echo get_phrase('send_patient');?></a>
                                                <a href="#" class="btn btn-danger btn-md" id="additem"><?php echo get_phrase('exit');?></a>
                                            </center>
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
<div style="display:none" data-url="<?php echo base_url(); ?>" id="baseurl"></div>

<script type="text/javascript">
//table box event
    jQuery(window).load(function ()
    {
        var $ = jQuery;

        $("#item-table").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
        });
       

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Highlighted rows
        $("#item-table tbody input[type=checkbox]").each(function (i, el)
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
   
   var globalReceptionID="", myCarts=[];
   var deleteCartItem, cart={};
   
   jQuery(window).load(function (){
        var $ = jQuery;
        function checkPatientId(){
            var patid = $("#patientselect").find("option:selected").val();
            if (patid.length==0){
                $.alert("<?php echo get_phrase('select_patient');?>",'Error!' );       
                return false;
            }
            return true;
        };
        $("#patientselect").on("change",function(){
            var $this = $(this);
            var val = $this.find("option:selected").val();
            //window.location.href = $("#baseurl").data("url")+"index.php?admin/reception/register/"+val;
            if (val.length==0){
                setValue({}); return;
            }
            $.get($("#baseurl").data("url")+"index.php?modal/getpatientinfo/"+val,function(data){
                data = eval(data);
         //       console.log(data);
                setValue(data[0]);
             }); 
             function setValue(data){
                // main patient setting
                $("#field-pname").val(data["name"]||"");
                $("#field-pemail").val(data["email"]||"");
                $("#field-paddress").val(data["address"]||"");
                $("#field-pphone").val(data["phone"]||"");
                $("#field-psex").val(data["sex"]||"");
                $("#field-pbod").val(data["birth_date"]||"");
                $("#field-page").val(data["age"]||"");
                $("#field-pbg").val(data["blood_group"]||"");
                data["image_url"] && $("#pimg").attr("src",data["image_url"]);
                //insurer setting
                if ($.isArray(data["insur"]) && data["insur"].length>0){
                    var item = data["insur"][0];
                    $("input[name='scheme']").val(item['name']);
                    $("input[name='scheme']").data("insurid",item['id']);
                    $("input[name='insur_comp_name']").val(item['cmpname']);
                    $("input[name='insur_smartstatus']").val(item['smt']);
                }
                // other setting
                $("input[name='insur_benamount']").val(data["benamount"]||"");
                $("input[name='insur_exid']").val(data["exid"]||"");
                $("input[name='insur_forwardid']").val(data["forwardid"]||"");
                $("input[name='insur_card_no']").val(data["cardno"]||"");
             };

        });
        // patient other information tabs
        if($("#payment_type").find("option:selected").val()==1){
            $("#tabs-1").find(".compinfo").removeClass("hidden");
        }
        $("#payment_type").on('change',function(){
           var $this = $(this);
           var val = $this.find("option:selected").val();
           if (val==1){
                $("#tabs-1").find(".compinfo").removeClass("hidden");
           }else{
                $("#tabs-1").find(".compinfo").addClass("hidden");
           }     
        });
      
        // save billing info process
        $("#save-billing-info").on('click',function(e){
            e.preventDefault();
            var patid = $("#patientselect").find("option:selected").val();
            if (patid.length==0){
                $.alert("<?php echo get_phrase('select_patient');?>",'Error!' );       
                return;
            }
            var paymentType = $("#payment_type").find("option:selected").val();
            if(eval(paymentType)==1){
                var insurid = $("input[name='scheme']").data("insurid"),
                    data={};
                data['pt']= paymentType;
                
                if ( insurid.length==0){
		            $.alert("<?php echo get_phrase('insurer_error');?>",'Error!' );
                    return;
                }else{
                    var smt = $("input[name='insur_smartstatus']").val();
                    if (eval(smt)&&$benamount.length==0){
                        //go to pick smart link date_add
                        $.alert("<?php echo get_phrase('smartlink_error');?>",'Error!' );
                    }else{
                        data['bn'] = $("input[name='insur_benamount']").val();
                        data['exid'] = $("input[name='insur_exid']").val();
                        data['fdid'] = $("input[name='insur_forwardid']").val();
                    }
                }
              }
              $.ajax({
                  url:$("#baseurl").data("url")+"index.php?modal/savebillinginformation/"+patid,
                  data:data,
                  type:"POST",
                  success:function(res){
                      if (res=='success'){
                         $.alert("<?php echo get_phrase('save_billing_info_success');?>",'Success' );   
                      }
                  }
              })  

        });
        $("#pick-smart").on('click',function(e){
            //put here smart ajax function.
            // we can here get benamount,exid,forwardid from smart database.
            e.preventDefault();
            var patid = $("#patientselect").find("option:selected").val();
            if (patid.length==0){
                $.alert("<?php echo get_phrase('select_patient');?>",'Error!' );       
                return;
            }
        });
        // cart calcuation for selecting item
        $("#itemselect").on('change',function(){
            var $this = $(this);
            var $el = $this.find("option:selected");
            var price = $el.data("price")||0;
            $("#field-price").val(price);
            $("#field-qty").val(!price?0:1);
            $("#field-total-price").val(price);
            $("#field-discount").val(0);
            $("#field-subnet-price").val(price);
        });
        
        $("#field-qty").on("keyup",function(){
            var $this = $(this);
            var qty = eval($this.val())||0,
                price = eval($("#field-price").val())||0,
                disc = eval( $("#field-discount").val())||0;
            $("#field-total-price").val(qty*price);
            $("#field-subnet-price").val(qty*price-disc);
        });
        $("#field-price").on("keyup",function(){
            var $this = $(this);
            var price = eval($this.val())||0,
                qty = eval($("#field-qty").val())||0,
                disc = eval( $("#field-discount").val())||0 ;
            $("#field-total-price").val(qty*price);
            $("#field-subnet-price").val(qty*price - disc);
        });
        $("#field-discount").on("keyup",function(){
            var $this = $(this);
            var disc = eval($this.val())||0,
                tp = eval($("#field-total-price").val())||0;
            $("#field-subnet-price").val(tp-disc);
        });
        // add cart info to datatable
        $("#additem").on('click',function(e){
            e.preventDefault();
            if (!checkPatientId()) return;
           
            var  $selectOpEl = $("#itemselect").find("option:selected");
            cart["ben"]= $("input[name='insur_benamount']").val();
            cart["type"] = $selectOpEl.data("type");
            cart["itemCode"] = $selectOpEl.val();
            if (cart["itemCode"].length==0){
                $.alert("<?php echo get_phrase('select_an_item'); ?>","Error");
                return;
            };
            cart["qty"] = eval($("#field-qty").val())||0;
            if (cart["qty"]==0){
                $.alert("<?php echo get_phrase('enter_the_quantity'); ?>","Error");
                return;
            }
            cart["unitprice"] = eval($("#field-price").val())||0;
            cart["totalprice"]= eval($("#field-total-price").val())||0;
            if (cart["totalprice"]==0){
                $.alert("<?php echo get_phrase('enter_the_price'); ?>","Error");
                return;
            }   
            if (cart["totalprice"]> cart["ben"] &&  cart["type"]=="GOOD"){
                $.alert('<p>The quantity entered cannot exceed the balance existing under this Departmental store. Bal is ' + cart["ben"] + '</p>',"Error");
                return;
            }

            cart["discount"]= eval($("#field-discount").val())||0;
            var $table = $("#item-table").dataTable();
            cart["itemName"] =  $selectOpEl.text().split("-")[0];
            cart["iid"] = $("#iid").find("option:selected").val();

            //delete cart item
            deleteCartItem = function(el){
                var $table = $("#item-table").dataTable();
                var nTr=$(el).parents('tr')[0];
                $table.fnDeleteRow(nTr);
                var pr = $($(nTr).children()[3]).text();
                changeFinalPrice(eval(pr),1);
            };
            //add cart item
            $table.fnAddData([
                cart["itemName"],
                cart["qty"],
                cart["unitprice"],
                cart["totalprice"],
                cart["discount"],
                $("#field-subnet-price").val()||0,
                "<a href='#' onclick='deleteCartItem(this);' class=\"btn btn-danger btn-sm btn-icon icon-left\"><i class=\"entypo-cancel\"></i>Delete</a>"
            ]);
            changeFinalPrice(cart["unitprice"],0);
            
            //change final price;
            function changeFinalPrice(val, dir){
                var pr = eval($("#field-final-price").val())||0;
                if (dir==0) 
                    $("#field-final-price").val(pr+val);
                else
                    $("#field-final-price").val(pr-val);
            }
        });
        // make transaction for consultation
        $("#addbill").on("click",function(e)){
            e.preventDefault();
            $.confirm({
                title: '<?php echo get_parse("submit_patient_bill_confirmation");?>',
                content: '<?php echo get_parse("submit_patient_bill_confirmation_message");?>',
                buttons: {
                    confirm: function () {
                       
                    },
                    cancel: function () {
                     //   $.alert('Canceled!');
                    }
                }
            });
            // add cart oject
     //       myCart[mayCart.length]= cart;

        });
        //save reception info
        $("#save").on("click",function(e){
            e.preventDefault();
            var patid = $("#patientselect").find("option:selected").val();
            if (patid.length==0){
                $.alert("Please select patient information!","Error");
                return;
            };
            var data={};
            data["patient_id"] = patid;

            $.ajax({
                  url:$("#baseurl").data("url")+"index.php?modal/savereception/"+globalReceptionID,
                  data:data,
                  type:"POST",
                  success:function(res){
                      res = eval(res);
                      if (res){
                         globalReceptionID = res[0]["reception_id"];
                         var date = res[0]["date"];
                         $.alert("<?php echo get_phrase('save_reception_info_success');?>",'Success' );   
                         $("#updated-date").html("<p>This reception is updated at "+date+" </p>");
                      }
                  }
            });

        });
                
    });
</script>

