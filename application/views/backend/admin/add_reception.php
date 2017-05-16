<?php
if (strlen($param2)>0) $isset_param=true;
$row = array();
if ($isset_param) {
    $single_info = $this->db->get_where('receptions', array('refno' => $param2))->result_array();
    if (count(single_info)>0) $row = $single_info[0];
}
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
                    <div class="pull-left" id="updated-date" >
                        <?php if($isset_param){
                            $date = date("d/m/Y H:i:s",$row["recept_date"]);
                            echo"<p>This reception is updated at $date </p>";
                        } ?>
                    </div>
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
                                        <select <?php if($isset_param) echo disabled?> id="patientselect" name="patient_group" class="form-control select2" placeholder=<?php echo get_phrase('selecet_patient_name_or_id');?>>
                                            <option value=""><?php echo get_phrase('select_a_patient'); ?></option>
                                            <optgroup label="<?php echo get_phrase('patient'); ?>">
                                                <?php $all_patient_info= $this->db->get_where('patient')->result_array();
                                                    foreach ($all_patient_info as $patient){ ?>
                                                    <option value=<?php echo $patient['patient_id']; ?> <?php if ($patient['patient_id'] == $row["patient_id"]) echo ' selected';?>><?php echo $patient['name']."- ".$patient['patient_id']; ?></option>        
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
                                        <input disabled type="text" name="age" class="form-control" id="field-page" >
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
                                                    <option value=0 ><?php echo get_phrase('cash'); ?></option>
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
                                                <select  id="itemselect" name="items_group" class="form-control" >
                                                    <option value="" selected ><?php echo get_phrase('selecet_Item_name');?></option> 
                                                    
                                                    <?php 
                                                        $this->db->order_by('ItemName' , '');
                                                        $all_items_info= $this->db->get('items')->result_array();
                                                        foreach ($all_items_info as $item){ 
                                                        if(strpos(strtolower($item['ItemName']),"consult")!==false)
                                                          {?>
                                                        <option value=<?php echo $item['ItemCode']; ?>  data-price="<?php echo $item['SalePrice']; ?>" data-type="<?php echo $item['Type']; ?>"><?php echo $item['ItemName']." - ".$item['Type']; ?></option>        
                                                    <?php }} ?>
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
                                                        foreach ($all_items_info as $item){?>
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
                                                <a href="#" class="btn btn-danger btn-md" id="addbill"><?php echo get_phrase('add_bill');?></a>
                                            </div>
                                        </div>
                                        <h4 class="add-patient-sub-title"><?php echo get_phrase('items'); ?></h4> 
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <table class="table table-bordered table-striped datatable" id="item-table">
                                                    <thead>
                                                        <tr>
                                                            <th><?php echo get_phrase('item_name');?></th>
                                                            <th><?php echo get_phrase('quantity');?></th>
                                                            <th><?php echo get_phrase('unit_price');?></th>
                                                            <th><?php echo get_phrase('total_price');?></th>
                                                            <th><?php echo get_phrase('discount');?></th>
                                                            <th><?php echo get_phrase('subnet');?></th>
                                                            <th><?php echo get_phrase('income');?></th>
                                                            <th><?php echo get_phrase('remove');?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            if ($isset_param){
                                                                $cartsbill = $this->crud_model->select_carts_info($param2,"CONSULTATION");
                                                                foreach ($cartsbill as $item){?>
                                                                    <tr>
                                                                        <td><?php echo $item['itemname'];?></td>
                                                                        <td><?php echo $item['quantity'];?></td>
                                                                        <td><?php echo $item['unit_price'];?></td>
                                                                        <td><?php echo (float)$item['quantity']*(float)$item['unit_price'];?></td>
                                                                        <td><?php echo $item['discount'];?></td>
                                                                        <td><?php echo $item['quantity']*$item['unit_price'] - $item['discount'];?></td>
                                                                        <td><?php echo $item['income'];?></td>
                                                                        <td></td>
                                                                    </tr>
                                                                <?php }}
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>    
                                    </form>
                                </div>
                                <div id="tabs-3"  class="tab-pane">
                                    <form role="form" class="form-horizontal form-groups-bordered" >
                                        <div class="form-group">
                                            <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('select_payment'); ?></label>
                                            <div class="col-md-5">
                                                <select name="select_payment" id="select_payment" class="form-control">
                                                    <option value="">Select Payment</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('patient_type'); ?></label>
                                            <div class="col-md-5">
                                                <?php
                                                    $patient_type_status = 0;// new patient
                                                    if ($isset_param){
                                                        $arr = $this->db->get_where("patient",array("patient_id"=>$row["patient_id"]))->result_array();
                                                        $lastdate = $arr[0]["last_visited_date"];
                                                        if ($lastdate==null)
                                                            $patient_type_status = 1; // revisit patient
                                                        else{
                                                            $ldate = date("Y-m-d",$lastdate);
                                                            $today = date("Y-m-d");
                                                            $diff = date_diff($today,$ldate);
                                                            $div = $diff->y * 365.25 + $diff->m * 30 + $diff->d ;
                                                            if($div>7) 
                                                                $patient_type_status=1; //revisit
                                                            else 
                                                                $patient_type_status=2; //review
                                                        }

                                                    }

                                                ?>    
                                                <select disabled name="patient_type" id="patient_type" class="form-control">
                                                    <option value="new" <?php if( $patient_type_status==0) echo "selected"?>><?php echo get_phrase('new_patient'); ?></value>
                                                    <option value="revisit" <?php if( $patient_type_status==1) echo "selected"?>><?php echo get_phrase('revisit'); ?></value>
                                                    <option value="review" <?php if( $patient_type_status==2) echo "selected"?>><?php echo get_phrase('review'); ?></value>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('send_to'); ?></label>
                                            <div class="col-md-5">
                                                <select name="send_to" id="send_to" class="form-control">
                                                <!--  <?php $all_items_info= $this->db->get_where('nurse')->result_array();
                                                        foreach ($all_items_info as $item){?>
                                                        <option value=<?php echo $item['nurse_id']; ?>><?php echo $item['name']." - ".$item['email']; ?></option>        
                                                    <?php } ?>-->
                                                    <option value="TRIAGE" >General Consultations</option>
                                                    <option value="LAB">Laboratory</option>
                                                    <option value="RAD">Radiology</option>
                                                    <option value="PHARMACY">Pharmacy</option>
                                              <!--  <option value="MCH">MCH</option>
                                                    <option value="NUTRITION">Nutrition</option>
                                                    <option value="DENTAL CLINIC">Dental Clinic</option>
                                                    <option value="PAEDIATRICS">Paediatrics</option>
                                                    <option value="COUNSELLING">Counselling</option>-->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <center>
                                                <a href="#" class="btn btn-success btn-md" id="sendpatient"><?php echo get_phrase('send_patient');?></a>
                                                <a href="<?php echo base_url(); ?>index.php?admin/reception" class="btn btn-danger btn-md" id="exit"><?php echo get_phrase('exit');?></a>
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
   
   var globalReceptionID= "<?php echo ($isset_param)?$param2:"";?>",
        globalPatientID = "<?php echo ($isset_param)?$row['patient_id']:"";?>",
        myCarts=[];
   
   
   jQuery(window).load(function (){
        var $ = jQuery;
        // if check patient id
        function checkPatientId(){
            var patid = $("#patientselect").find("option:selected").val();
            if (patid.length==0){
                $.alert("<?php echo get_phrase('select_patient');?>",'Error!' );       
                return false;
            }
            return true;
        };
        // fill out patient information
        function fillPatientInfo(patiendId,isEmpty){
            if (!isEmpty){
                $.get($("#baseurl").data("url")+"index.php?modal/getpatientinfo/"+patiendId,function(data){
                    data = eval(data);
                   console.log(data);
                    setValue(data[0]);
                }); 
            };
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
                //patient type setting
                var status =2 , statusarr=["new","revisit","review"];
                if (data["last_visited_date"].length>0){
                    var ldate = new Date(data["last_visited_date"]);
                    var today = new Date();
                    var diff_ms = today-ldate;
                    //Get 1 day in milliseconds
                    var one_day=1000*60*60*24;
                    var diff= Math.round(diff_ms/one_day); 
                    if (diff>7) status=1;
                };
                $("#patient_type").val(statusarr[status]);
            }
        };
        if (globalPatientID.length>0)
            fillPatientInfo(globalPatientID,false);
        $("#patientselect").on("change",function(){
            var $this = $(this);
            var val = $this.find("option:selected").val();
            if (val.length==0){
                setValue(val,true); return;
            }
            fillPatientInfo(val,false);
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
            var cart={};
            var  $selectOpEl = $("#itemselect").find("option:selected");
    
            cart["itemcode"] = $selectOpEl.val();
            if (cart["itemcode"].length==0){
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
            cart["iid_name"] = $("#iid").find("option:selected").text();
           

            //add cart item
            $table.fnAddData([
                cart["itemName"],
                cart["qty"],
                cart["unitprice"],
                cart["totalprice"],
                cart["discount"],
                $("#field-subnet-price").val()||0,
                cart["iid_name"],
                "<a href='#' id='del_cart_item_"+myCarts.length+"' data-id="+myCarts.length+" class=\"btn btn-danger btn-sm btn-icon icon-left\"><i class=\"entypo-cancel\"></i>Delete</a>"
            ]);
             //delete cart item function
            $("#del_cart_item_"+myCarts.length).on("click",function(e){
                e.preventDefault();
                var nTr=$(this).parents('tr')[0];
                $table.fnDeleteRow(nTr);
                var pr = $($(nTr).children()[3]).text();
                changeFinalPrice(eval(pr),1);
                var id = $(this).data("id");
                myCarts[id]["status"]=0;
            });
            changeFinalPrice(cart["totalprice"],0);
            cart["status"]=1;
            myCarts[myCarts.length] = cart;
            //change final price;
            function changeFinalPrice(val, dir){
                var pr = eval($("#field-final-price").val())||0, res = 0;
                res = ((dir==0)?1:-1)*val+pr;
                $("#field-final-price").val(res);
                return res;
            };

        });
        // make transaction for consultation
        $("#addbill").on("click",function(e){
            e.preventDefault();
            // ready data
            var data = {
                    recepId:globalReceptionID,
                    url:"<?php echo base_url();?>"+"index.php?modal/submitbill/",
                    type:"con",// it means bill from consultaiton(triage)
                    carts:function(items){
                        var res=[];
                        $.each(items, function(id){
                            console.log(items);
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
                var $table = $("#item-table");
                $table.find("tr").each(function(id){
                    var $this = $(this);
                    $this.find("td").last().find("a").remove();
                });
            };
            // confirmation for submitting carts bill.
            $.confirm({
                title: '<?php echo get_phrase("submit_patient_bill_confirmation");?>',
                content: '<?php echo get_phrase("submit_patient_bill_confirmation_message");?>',
                buttons: {
                    confirm: function () {
                       if (data.recepId.length==0){
                            saveReceptionProc(submitBill,data,afterCallback);
                       }else
                            submitBill(data,afterCallback);
                    },
                    cancel: function () {
                     //   $.alert('Canceled!');
                    }
                }
            });
            // after submmited

        });
        // save reception information
        function saveReceptionProc(nextCallback,callbackParam,afterCallback){
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
                         globalReceptionID = res[0]["reception_id"].toString();
                         var date = res[0]["date"];
                         if ($.isFunction(nextCallback)&&callbackParam){
                            callbackParam["recepId"] = globalReceptionID;
                            nextCallback(callbackParam, afterCallback);
                         }else
                            $.alert("<?php echo get_phrase('save_reception_info_success');?>",'Success' );   
                         $("#updated-date").html("<p>This reception is updated at "+date+" </p>");
                         $("#patientselect").attr("disabled",true);
                      }
                  }
            });
        }
        //save reception info
        $("#save").on("click",function(e){
            e.preventDefault();
            saveReceptionProc();
        });
        // select valid payment information for consultation on "start new consulation" Tab
        function getPaymentSelInfo(){
            var $selEl = $("#select_payment");
            if (globalReceptionID.length==0) return;
            $.get($("#baseurl").data("url")+"index.php?modal/getpaymentforcons/"+globalReceptionID,
            function(data){
                data = eval(data);
                $.each(data,function(){
                   var $op = $("<option></option>").attr("value",this.transid).text(this.itemname).appendTo($selEl);
                });
            })
        } 
        if (globalReceptionID.length>0) getPaymentSelInfo();     

        //send patiant to branch
        $("#sendpatient").on("click",function(e){
            e.preventDefault();
            var data={};
            data['url'] = $("#baseurl").data("url")+"index.php?modal/sendtobranch/";
            var tid = $("#select_payment").val().toString();
            var nid = $("#send_to").val().toString();
            if (globalReceptionID.length==0) return;
            if (tid.length==0 && nid=="TRIAGE") {
                $.alert("please select payments for patient!","Error"); return;
            }
   /*         if (nid.length==0) {
                $.alert("please select nurse for patient!","Error"); return;
            }*/
            if (!checkPatientId()) return;
            data['paymentId'] =tid;
            data['patientId'] = $("#patientselect").find("option:selected").val();
  //          data['sentto_account_type'] = 'nurse';
  //          data['sentto_account_id'] =  $("#send_to").val();
            data["type"]=nid;
            data["recept_id"] = globalReceptionID;
            data["patient_type"] = $("#patient_type").val();
            function aftercallback(){
        //        window.location.href = "<?php echo base_url(); ?>index.php?admin/reception";
            }
            sendToBranch(data,aftercallback);
        });
    });
</script>

