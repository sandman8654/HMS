<?php
/*
*   date: 2017.4.25
*   author: Robin San
*/
if (strlen($param2)>0) $isset_param=true;
$row = array();
$presc_info=array();
$patient_info=array();
if ($isset_param) {
    $single_info = $this->db->get_where('pharmacy_request', array('id' => $param2))->result_array();
    if (count(single_info)>0){
        $row = $single_info[0];
        $presc_info = $this->db->get_where("prescription", array('req_id' => $row["id"]))->result_array();
        $patient_info = $this->db->get_where("patient", array('patient_id' => $row["patient_id"]))->result_array()[0];
    };
    
}
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('pharmacy_information'); ?></h3>
                </div>
            </div>

            <div class="panel-body">
                    <div class="pull-left" id="updated-date" >
                        <?php if($isset_param){
                            $date = date("Y/m/d H:i:s",$row["timestamp"]);
                            echo"<p>This request was posted at $date </p>";
                        } ?>
                    </div>
                    <div class="col-md-12 col-md-12">
                        
                        <div class="col-md-5 col-md-5 has-right-border" id="patient-container">
                            <form role="form" class="form-horizontal form-groups-bordered" >
                                <h4 class="add-patient-sub-title"><?php echo get_phrase('patient_detail_info_title'); ?></h4>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><?php echo get_phrase('image'); ?></label>
                                    <div class="col-md-9">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                <?php 
                                                    $img_url = $this->crud_model->get_image_url('patient' , $patient_info['patient_id']);
                                                    if ($img_url=="") 
                                                        $img_url = "http://placehold.it/200x150"; 
                                                ?>
                                                <img src="<?php echo $img_url; ?>" id="pimg" alt="...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-1" class="col-md-3 control-label"><?php echo get_phrase('name'); ?></label>
                                    <div class="col-md-9">
                                        <input disabled type="text" name="name" class="form-control" id="field-pname" value="<?php echo ($isset_param)?$patient_info['name']:''; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-md-3 control-label"><?php echo get_phrase('email'); ?></label>

                                    <div class="col-md-9">
                                        <input disabled type="email" name="email" class="form-control" id="field-pemail" value="<?php echo ($isset_param)?$patient_info['email']:''; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('address'); ?></label>
                                    <div class="col-md-9">
                                        <textarea disabled name="address" class="form-control" id="field-paddress"><?php echo ($isset_param)?trim($patient_info['address']):''; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-1" class="col-md-3 control-label"><?php echo get_phrase('phone'); ?></label>

                                    <div class="col-md-9">
                                        <input disabled type="text" name="phone" class="form-control" id="field-pphone"  value="<?php echo ($isset_param)?$patient_info['phone']:''; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('sex'); ?></label>

                                    <div class="col-md-9">
                                        <input disabled type="text" name="phone" class="form-control" id="field-psex" value= "<?php echo ($isset_param)?$patient_info['sex']:''; ?>">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="field-1" class="col-md-3 control-label"><?php echo get_phrase('birth_of_date'); ?></label>

                                    <div class="col-md-9">
                                        <input disabled type="text" name="birth_date" class="form-control datepicker" id="field-pbod" value="<?php echo ($isset_param)?date("Y/m/d",$patient_info['birth_date']):''; ?>">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="field-1" class="col-md-3 control-label"><?php echo get_phrase('age'); ?></label>

                                    <div class="col-md-9">
                                        <input disabled type="number" name="age" class="form-control" id="field-page" value ="<?php echo ($isset_param)?$patient_info['age']:''; ?>" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('blood_group'); ?></label>
                                    <div class="col-md-9">
                                        <input disabled type="text" name="blood_group" class="form-control" id="field-pbg" value="<?php echo ($isset_param)?$patient_info['blood_group']:''; ?>" >
                                    </div>
                                </div>
                                            
                            </form>
                        </div>
                        <div class="col-md-7 col-md-7 ">

                            <ul class="nav nav-tabs bordered">
                                <li class="active"><a href="#tabs-1" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('Billing'); ?></span></a></li>
                                <li ><a href="#tabs-2" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('pharmacy_requests'); ?></span></a></li>
                               
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
                                                        foreach($presc_info as $item){
                                                            $this->db->or_where("ItemCode",$item["drug_id"]);
                                                        }
                                                        $all_items_info= $this->db->get('items')->result_array();
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
                                        <h4 class="add-patient-sub-title pull-left"><?php echo get_phrase('prescription_list'); ?></h4>
                                        <div class="form-group" style="height:500px">
                                            <table class="table table-bordered table-striped datatable" id="table-presc-list">
                                                <thead>
                                                    <tr>
                                                        <th style="width:50px"><?php echo get_phrase('no');?></th>
                                                        <th><?php echo get_phrase('drug_name');?></th>
                                                        <th><?php echo get_phrase('drug_quantity');?></th>
                                                        <th><?php echo get_phrase('prescription');?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $n=0;?>
                                                    <?php foreach ($presc_info as $item) { 
                                                        $n++;
                                                    ?>   
                                                        <tr>
                                                            <td><?php echo $n?></td>
                                                            <td><?php echo $this->crud_model->select_item_name($item['drug_id'])?></td>
                                                            <td><?php echo $item['drug_qty']?></td>
                                                            <td><?php echo $item['medication']."<br/>".$item['note']?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
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
        //html editors
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
                    type:"lab",// it means bill from laboratory
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
        
      

    });
</script>

