<?php
/*
*   date: 2017.4.25
*   author: Robin San
*/
if (strlen($param2)>0) $isset_param=true;
$row = array();
if ($isset_param) {
    $single_info = $this->db->get_where('rad_request', array('id' => $param2))->result_array();
    if (count(single_info)>0){
        $row = $single_info[0];
    } 
}
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('radiology_information'); ?></h3>
                </div>
            </div>

            <div class="panel-body">
                    <div class="pull-left" id="updated-date" >
                        <?php if($isset_param){
                            $date = date("Y/m/d H:i:s",$row["start_time"]);
                            echo"<p>This request was posted at $date </p>";
                        } ?>
                    </div>
                    <div class="pull-right">
                        <a href="#" id="save" class="btn btn-success btn-md">Save</a>
                        <a href="<?php echo base_url(); ?>index.php?admin/radreq" class="btn btn-danger btn-md">Exit</a>
                    </div>
                    <div class="col-md-12 col-md-12">
                        
                        <div class="col-md-5 col-md-5 has-right-border" id="patient-container">
                            <form role="form" class="form-horizontal form-groups-bordered" >
                                <h4 class="add-patient-sub-title"><?php echo get_phrase('patient_detail_info_title'); ?></h4>
                                <div class="form-group">
                                    <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('select_patient_for_reception'); ?></label>
                                    <div class="col-md-9">
                                        <select <?php if($isset_param) echo 'disabled'?> id="patientselect" name="patient_group" class="form-control select2" placeholder=<?php echo get_phrase('selecet_patient_name_or_id');?>>
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
                                <li class="active"><a href="#tabs-1" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('Billing'); ?></span></a></li>
                                <li><a href="#tabs-2" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('radiology_tests'); ?></span></a></li>
                                <li><a href="#tabs-3" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('radiology_analysis'); ?></span></a></li>
                                <li><a href="#tabs-4" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('upload_scans'); ?></span></a></li>
                                <li><a href="#tabs-5" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('summary'); ?></span></a></li>
                            </ul>
                            <div  class="tab-content recep-tab">
                                <div id="tabs-1" class="tab-pane active">
                                     <form role="form" class="form-horizontal form-groups-bordered">
                                       <h4 class="add-patient-sub-title"><?php echo get_phrase('billing'); ?></h4> 
                                       <?php $status = $row["status"];?>
                                       <?php if ($status!=0) { ?> <p> The billing information has been submitted already.</p> <?php }?>
                                       <div class="form-group">
                                            <label for="field-ta" class="col-md-2 control-label"><?php echo get_phrase('item').":"; ?></label>
                                            <div class="col-md-4">
                                                <select <?php if ($status!=0) echo 'disabled'?> id="itemselect" name="items_group" class="form-control" >
                                                    <option value="" selected ><?php echo get_phrase('selecet_Item_name');?></option> 
                                                    <?php 
                                                        $all_items_info= $this->db->get_where('items',array("ItemCode"=>$row["itemcode"]))->result_array();
                                                        foreach ($all_items_info as $item){ ?>
                                                        <option value=<?php echo $item['ItemCode']; ?>  data-price="<?php echo $item['SalePrice']; ?>" data-type="<?php echo $item['Type']; ?>"><?php echo $item['ItemName']." - ".$item['Type']; ?></option>        
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
                                                
                                                <select <?php if ($status!=0) echo 'disabled'?> id="iid" name="items_group" class="form-control" >
                                                    <?php $all_extm_info= $this->db->get_where('extmedics')->result_array();
                                                        foreach ($all_extm_info as $item){?>
                                                        <option value=<?php echo $item['id']; ?>><?php echo $item['name']; ?></option>        
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <label for="field-ta" class="col-md-2 control-label"><?php echo get_phrase('final_total').":"; ?></label>
                                            <div class="col-md-2">
                                                <input disabled type="text" name="cart_subnet_price" class="form-control" id="field-final-price" value="0"/>
                                            </div>
                                             <div class="col-md-4 control-label">
                                                
                                                <a href="#" class="btn btn-success btn-md <?php if ($status!=0) echo 'disabled'?>" id="additem"><?php echo get_phrase('add_item');?></a>
                                                <a href="#" class="btn btn-danger btn-md <?php if ($status!=0) echo 'disabled'?>" id="addbill"><?php echo get_phrase('add_bill');?></a>
                                            </div>
                                        </div>
                                        <h4 class="add-patient-sub-title"><?php echo get_phrase('items'); ?></h4> 
                                        <div class="form-group">
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
                                                            $cartsbill = $this->crud_model->select_carts_info($param2);
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
                                    </form>
                                    
                                </div>
                                <div id="tabs-2" class="tab-pane">
                                    <form role="form" class="form-horizontal form-groups-bordered">
                                       <?php 
                                            $pay_status = $this->db->get_where("sales",array("item_id"=>$row["itemcode"],"recep_id"=>$row["recept_id"]))->row()->status;
                                       ?> 
                                       <h4 class="add-patient-sub-title "><?php echo get_phrase('Requested_test_detail'); ?></h4> 
                                       <?php if ($pay_status!=1) echo"<p> you have to pay for this test</p> ";
                                       ?>
                                       <div class="form-group">
                                            <label for="field-ta" class="col-md-2 control-label"><?php echo get_phrase('Test_name').":"; ?></label>
                                            <div class="col-md-10">
                                                <p class="form-control" ><?php echo $all_items_info[0]["ItemName"];?></p>
                                            </div>
                                        </div>
                                       
                                         <div class="form-group">
                                            <label for="field-ta" class="col-md-2 control-label"><?php echo get_phrase('request_time').":"; ?></label>
                                            <div class="col-md-10">
                                                <p  class="form-control" ><?php echo date("Y/m/d H:i", $row["start_time"]);?></p>
                                            </div>
                                         </div>
                                         <div class="form-group">
                                            <label for="field-ta" class="col-md-2 control-label"><?php echo get_phrase('request_by').":"; ?></label>
                                            <div class="col-md-10">
                                                <?php 
                                                    $acc_type = $row["sender_account_type"];
                                                    $acc_id = $row["sender_account_id"];
                                                    $sendername = $this->db->get_where($acc_type, array($acc_type."_id"=>$acc_id))->result_array()[0]["name"];
                                                ?>
                                                <p class="form-control"  ><?php echo $sendername;?></p>
                                            </div>
                                         </div>
                                         <?php if ($status==3){
                                            echo "<div class='form-group'> 
                                                <label for='field-ta' class='col-md-2 control-label'>".get_phrase('done_by').':'."</label>
                                                <div class='col-md-10'>";
                                                $acc_type = $row["doneby_account_type"];
                                                $acc_id = $row["doneby_account_id"];
                                                $sendername = $this->db->get_where($acc_type, array($acc_type."_id"=>$acc_id))->result_array()[0]["name"];
                                            echo "<p class='form-control'> $sendername</p></div></div>";
                                         }?>
                                         <div class="form-group">
                                            <label for="field-ta" class="col-md-2 control-label"><?php echo get_phrase('status').":"; ?></label>
                                            <div class="col-md-10">
                                                <p class="form-control" ><?php if ($status==0) 
                                                                                    echo get_phrase('pending');
                                                                               elseif($status==1) 
                                                                                    echo get_phrase('billed');
                                                                               elseif($status==2) 
                                                                                    echo get_phrase('processing');
                                                                               elseif($status==3)
                                                                                    echo get_phrase('completed');  
                                                ?></p>
                                            </div>
                                         </div>
                                         <?php if ($status==3){
                                            echo '<div class="form-group">';
                                            echo '<label for="field-ta" class="col-md-2 control-label">'.get_phrase('time_of_completion').":".'</label>';
                                            echo '<div class="col-md-10">';
                                            echo '<p  class="form-control" >'.date("Y/m/d H:i", $row["end_time"]).'</p>';
                                            echo '</div></div>';
                                        }?>
                                    </form>
                                </div>
                                <div id="tabs-3"  class="tab-pane">
                                    <div class="col-md-12 compose-message-editor">
                                        <textarea <?php if ($status<2) echo 'disabled'?> row="25" class="form-control" data-stylesheet-url="assets/css/wysihtml5-color.css"  name="lab_result_wysiwyg" 
                                            id="rad_result_wysiwyg" style="height:380px"><?php
                                             echo $row["rad_result"]; 
                                            ?></textarea>
                                    </div>
                                </div>
                                <div id="tabs-4"  class="tab-pane">
                                    <div class="col-md-12 ">
                                         <h4 class="add-patient-sub-title" ><?php echo get_phrase('scan_images'); ?></h4>
                                         
                                         <form id="upload-scan" role="form" class="form-horizontal form-groups-bordered"  method="post" enctype="multipart/form-data">
                                            <div class="col-sm-12" <?php if ($status<2) echo 'disabled'?>>
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
                                                        <img src="http://placehold.it/200x150" alt="...">
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                                    <p id="file-name"></p>
                                                    <div>
                                                        <span class="btn btn-white btn-file">
                                                            <span class="fileinput-new">Select image</span>
                                                            <span class="fileinput-exists">Change</span>
                                                            <input type="file" name="scan-image" accept="image/*">
                                                        </span>
                                                        <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                        <a href="#" class="btn btn-success" id="upload" >Upload</a>
                                                     </div>
                                                </div>
                                            </div>
                                         </form>
                                    </div>
                                    <div id="image-gallery" class="col-sm-12">
                                        <script src="assets/js/zoomify/dist/zoomify.min.js"></script>
                                        <link href="assets/js/zoomify/dist/zoomify.min.css" rel="stylesheet">
                                        <?php $list = $this->crud_model->get_upload_rad_images($row["patient_id"],$param2);
                                            foreach ($list as $item){ ?>
                                                <div class="col-sm-3">
                                                    <a href="#" class="upload-remove-icon" title="Remove" data-filename="<?php echo $item;?>"><i class="fa fa-close" aria-hidden="true"></i> </a>
                                                    <img class="image-zoomable" width="100%" height:"100%" style="margin-top:10px" src="<?php echo base_url().'uploads/radiology_image/'.$row["patient_id"]."/$param2/".$item; ?>" data-filename="<?php echo $item;?>" />
                                                </div>
                                        <?php }
                                        ?>
                                    </div>
                                </div>
                                <div id="tabs-5"  class="tab-pane">
                                    <div class="col-md-12 compose-message-editor" id="lab-result-container" style="overflow:visible">
                                        <?php 
                                            $arr_lab_req = $this->db->get_where("rad_request",array("cons_id"=>$row["cons_id"]))->result_array();
                                            $arr_status = array("Pending","Billed","Processing","Completed");
                                            foreach($arr_lab_req as $req){
                                                $icode = $req["itemcode"];
                                                $iname = $this->db->get_where("items",array("ItemCode"=>$icode))->result_array()[0]["ItemName"];
                                                $time = date("Y-m-d H:i:s",$req["end_time"]);
                                                $status = $req["status"];
                                                echo "Date : ".$time."<br/><br/>";
                                                echo "Radiology Request - [".$arr_status[$status]."]<br/>";
                                                echo $iname."<br/><br/>";
                                                echo "Radiology Result"."<br/>";
                                                $result = $req["rad_result"];
                                                echo $result;
                                                echo "<br/><hr/>";
                                            }
                                        ?>
                                    </div>
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
        //html editors
        $("#rad_result_wysiwyg").wysihtml5();
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
   
   var globalReceptionID= "<?php echo ($isset_param)?$row['recept_id']:"";?>",
        globalPatientID = "<?php echo ($isset_param)?$row['patient_id']:"";?>",
        labReceptStatus = "<?php echo ($isset_param)?$row['status']:"";?>",
        myCarts=[];
   
   
   jQuery(window).load(function (){
        var $ = jQuery;
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
       // height adjustment
       $("#lab-result-container").height($("#patient-container").height()-70);
        
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
                    type:"rad",// it means bill from radiology
                    reqid:<?php  echo ($isset_param)?$param2:0;?>,
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
                $.alert("<?php echo get_phrase('cart_is_empty!') ?>","Error"); return;
            }
           
            // confirmation for submitting carts bill.
            $.confirm({
                title: '<?php echo get_phrase("submit_patient_bill_confirmation");?>',
                content: '<?php echo get_phrase("submit_patient_bill_confirmation_message");?>',
                buttons: {
                    confirm: function () {
                         // remove delete button on datatable if success after submitted;
                        var afterCallback = function(){
                            myCarts=[];
                            var $table = $("#item-table");
                            $table.find("tr").each(function(id){
                                var $this = $(this);
                                $this.find("td").last().find("a").remove();
                            });
                            window.location.reload();
                        };
                       if (data.recepId.length==0){
                            $.alert("The paitient has no reception, please recept now","Error");
                       }else
                            submitBill(data,afterCallback);
                    },
                    cancel: function () {
                    }
                }
            });
            // after submmited

        });
        // save reception information
        function saveReceptionProc(nextCallback,callbackParam,afterCallback){
            var data={};
      //      data["patient_id"] = globalPatientID;
    //        data["recept_id"] = globalReceptionID;
            data["result"] = $("#rad_result_wysiwyg").parent().find(".wysihtml5-sandbox").contents().find("body").html();
            $.ajax({
                  url:$("#baseurl").data("url")+"index.php?modal/saveradresult/"+<?php echo $row["id"]?>,
                  data:data,
                  type:"POST",
                  success:function(res){
                      res = eval(res);
                      if (res && res[0].msg=="success"){
                         var date = res[0]["date"];
                         $.alert("The radiology information was saved successfully",'Success' );   
                         $("#updated-date").html("<p>This Radiology was updated at "+date+" </p>");
                     }else{
                         $.alert("Rad Reception failure!",'Failure' );   
                     }
                  }
            });
        }
        //save reception info
        $("#save").on("click",function(e){
            e.preventDefault();
            saveReceptionProc();
        });
      
        var file ={};
        $("input[type='file']").on("change",function(e){
            file = e.target.files[0]||{};
            $("#file-name").text(file["name"]||"");
        });
        function deleteProcess(el){
            var $that = $(el);
                $fn = $(el).data("filename");
                $.ajax({
                    url:"<?php echo base_url().'index.php?admin/upload_scan_image/delete/'.$row['patient_id']."/$param2"; ?>",
                    data:{filename:$fn},
                    type:"POST",
                    success:function(res){
                        $that.parent().remove();
                    }
                })
        };
        $("#upload").on("click",function(e){
            e.preventDefault();
            fname = file.name ||"";
            if (fname=="") {
                $.alert("please select scan image.","warning");
                return;
            }
            var data = new FormData();
            data.append('file',file,fname);
            var url = "<?php echo base_url().'index.php?admin/upload_scan_image/upload/'.$row['patient_id']."/$param2"; ?>";
            var xhr = new XMLHttpRequest();
            xhr.open("POST",url,true);
            xhr.send(data);
           
            xhr.onload = function(){
                var res = xhr.responseText;
                var image_url = res;
                $rootEl = $("#image-gallery");
                $div = $("<div></div>").addClass("col-sm-3").appendTo($rootEl);
                $a = $("<a href='#'></a>").data("filename",fname).addClass("upload-remove-icon").attr("title","Remove").appendTo($div);
                $a.on("click",function(e){
                    e.preventDefault();
                    deleteProcess(this);
                    
                })
                $("<i></i>").addClass("fa").addClass("fa-close").attr("aria-hidden",true).appendTo($a);
                $("<img/>")
                    .addClass("image-zoomable")
                    .css({"width":"100%",height:"100%","margin-top":"10px"})
                    .attr("src","<?php echo base_url();?>"+image_url)
                    .appendTo($div)
                    .zoomify();
            }
            
        });
        $("img.image-zoomable").zoomify();
        $("a.upload-remove-icon").on("click",function(e){
            e.preventDefault();
            deleteProcess(this);
        })
    });
</script>

