
<div class="row">
    <div class="col-md-12">
      <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <h3 id="test-date"><?php echo get_phrase('pharmacy_request'); ?></h3>
                </div>
            </div>
            
            <div class="panel-body">
                <form role="form" class="form-horizontal form-groups-bordered dol-sm-12 col-md-8 col-md-offset-2" action="<?php echo base_url(); ?>index.php?admin/pharmreq/create" method="post" enctype="multipart/form-data">
                    <div class="pull-right">
                        <!--<input  type="submit" value="submit" class="btn btn-success btn-md"></input>-->
                        <a href="#" id="send-pharmacy" class="btn btn-success btn-md">submit</a>
                        <a href="<?php echo base_url(); ?>index.php?admin/pharmreq" class="btn btn-danger btn-md">Exit</a>
                    </div>
                    <div style="clear:both"></div>
                    <div class="form-group">
                        <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('selelect_reception:'); ?></label>
                        <div class="col-md-9">
                            <select required id="patient-select" name="patient-select" class="form-control select2" placeholder=<?php echo get_phrase('type_search_patient');?>>
                                <option value=""><?php echo get_phrase('type_search_patient'); ?></option>
                                <optgroup label="<?php echo get_phrase('recept_no-_patient'); ?>">
                                    <?php  
                                        $all_info= $this->db->get_where('sendpatients',array("sendto"=>"PHARMACY"))->result_array();
                                        foreach ($all_info as $item){ ?>
                                        <option value="<?php echo $item['recept_id'].'-'.$item['patient_id']; ?>"><?php echo $item['recept_id']." - ".$this->crud_model->select_patient_info_by_patient_id($item["patient_id"])[0]["name"]; ?></option>                                            <?php } ?>
                                </optgroup>    
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-ta" class="col-md-3 control-label"><?php echo get_phrase('drug_name:'); ?></label>
                        <div class="col-md-9">
                            <select required id="drug-select" name="drug-select" class="form-control select2" placeholder=<?php echo get_phrase('type_search_drug');?>>
                                <option value=""><?php echo get_phrase('type_search_drug'); ?></option>
                                <optgroup label="<?php echo get_phrase('drug_name'); ?>">
                                    <?php  $this->db->order_by('ItemName' , 'asc');
                                        $all_info= $this->db->get_where('items',array("category"=>"PHARMACEUTICALS"))->result_array();
                                        foreach ($all_info as $item){ ?>
                                        <option value=<?php echo $item['ItemCode']; ?>><?php echo $item['ItemName']; ?></option>        
                                    <?php } ?>
                                </optgroup>    
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6">
                            <label for="field-ta" class="col-md-12 col-sm-12 " ><?php echo get_phrase('dosage:'); ?></label>
                            <div class="col-md-3 col-sm-3">
                                <input type="text"  name="dosage_qty" id="dosage_qty" class="form-control ">
                            </div>
                            <div class="col-md-9 col-sm-9">
                                <select class="form-control " id="dosagetype_sel" >
                                    <option value="">Select one...</option>
                                    <option value="Tabs">Tabs</option>
                                    <option value="Mls">Mls</option>
                                    <option value="Capsules">Capsules</option>
                                    <option value="Suspensions">Suspensions</option>
                                    <option value="Elixirs">Elixirs</option>
                                    <option value="Syrups">Syrups</option>
                                    <option value="Creams">Creams</option>
                                    <option value="Ointments">Ointments</option>
                                    <option value="Suppositories">Suppositories</option>
                                    <option value="Inhalers">Inhalers</option>
                                    <option value="Vials">Vials</option>
                                    <option value="Patch">Patch</option>
                                    <option value="Pessaries">Pessaries</option>
                                    <option value="Ampoule"></option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-sm-6">
                            <label for="field-ta" class="col-md-12 col-sm-12 " ><?php echo get_phrase('route:'); ?></label>
                            <div class="col-md-12 col-sm-12">
                                <select class="form-control" id="route_sel" style="">
                                    <option value="">Select one...</option>
                                    <option value="Oral">Oral</option>
                                    <option value="Rectal">Rectal</option>
                                    <option value="I.V">I.V</option>
                                    <option value="I.M">I.M</option>
                                    <option value="S.C">S.C</option>
                                    <option value="Intraspinal Injection">Intraspinal Injection</option>
                                    <option value="Inhalation">Inhalation</option>
                                    <option value="Vaginal">Vaginal</option>
                                    <option value="Aural">Aural</option>
                                    <option value="Intranasal">Intranasal</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label for="field-ta" class="col-sm-12" ><?php echo get_phrase('frequency:'); ?></label>
                            <div class="col-md-12 col-sm-12">
                                <select class="form-control" id="freq_sel" style="">
                                    <option value="">Select one...</option>
                                    <option value="1">stat</option>
                                    <option value="1">n/a</option>
                                    <option value="24">Once Hourly</option>
                                    <option value="1">Once Daily</option>
                                    <option value="2">Twice Daily</option>
                                    <option value="3">Thrice Daily</option>
                                    <option value="4">Four Times Daily</option>
                                    <option value="0.1429">Once Weekly</option>
                                    <option value="0.2857">Twice Weekly</option>
                                    <option value="0.4286">Thrice Weekly</option>
                                    <option value="0.5714">Four Times Weekly</option>
                                    <option value="1">Mane</option>
                                    <option value="1">Nocte</option>
                                    <option value="4">Qid/Qds</option>
                                    <option value="1">P.R.N</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <label for="field-ta" class="col-sm-12" ><?php echo get_phrase('duration:'); ?></label>
                            <div class="col-sm-3 col-md-3">
                                <input type="text"  name="duration_qty" id="duration_qty" class="form-control" >
                            </div>
                            <div class="col-sm-9 col-md-9">
                                <select class="form-control" id="duration_type" >
                                    <option value="">Select one...</option>
                                    <option value="1">stat</option>
                                    <option value="1">n/a</option>
                                    <option value="0.04167">Hours</option>
                                    <option value="1">days</option>
                                    <option value="7">weeks</option>
                                    <option value="30">months</option>
                                    <option value="1">Single Dose</option>
                                    <option value="1">Continous</option>
                                    <option value="1">When Needed</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-ta" class="col-md-3 control-label" ><?php echo get_phrase('note:'); ?></label>
                        <div class="col-md-9 compose-message-editor">
                            <textarea row="25" class="form-control" name="medication" 
                                id="medication_note" style="height:50px"></textarea>
                        </div>
                    </div>
                    <h4 class="add-patient-sub-title pull-left"><?php echo get_phrase('prescription_list'); ?></h4>
                    <a href="#" id="add_presc" class="btn btn-success btn-md pull-right" style="margin-top:10px"><?php echo get_phrase('add_prescription'); ?></a>
                    <div style="clear:both"></div>
                    <div class="form-group" style="height:300px">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-striped datatable" id="table-presc-list">
                                <thead>
                                    <tr>
                                        <th style="width:50px"><?php echo get_phrase('no');?></th>
                                        <th><?php echo get_phrase('prescription');?></th>
                                        <th style="width:100px"><?php echo get_phrase('action');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
                
            </div>

      </div>
    </div>
</div>
<script>
    jQuery(window).load(function(){
        $=jQuery;
        // pharmacy save
        //prescription table in pharmacy
        var prescTboby = $("#table-presc-list").find("tbody");

        pharmacy_cart=[];
        globalPharmacyCartNum=0;
        $("#add_presc").on("click",function(e){
            e.preventDefault();
            var cart={},presc="";
            cart["drug_id"]=$("#drug-select").val();
            if ($("#drug-select").val()==""){
                $.alert("please select drug","Error");
                return;
            };
            presc += $("#drug-select").find("option:selected").text();
            cart["dosage_qty"]=eval($("#dosage_qty").val())||0;
            if (cart["dosage_qty"]==0) return;
            cart["dosage_type"]=$("#dosagetype_sel").val()||"";
            if (cart["dosage_type"].length==0) return;
            presc += " - " + cart["dosage_qty"] + " " + cart["dosage_type"];
            cart["route"]=$("#route_sel").val()||"";
            if (cart["route"].length==0) return;
            presc += " - " + cart["route"];
            cart["freq_val"]=eval($("#freq_sel").val())||0;
            if (cart["freq_val"]==0) return;
            cart["freq"]=$("#freq_sel").find("option:selected").text()||"";
            presc += " - " + cart["freq"];
            cart["dura_qty"]=eval($("#duration_qty").val())||0;
            if (cart["dura_qty"]==0) return;
            cart["dura_type"]=$("#duration_type").find("option:selected").text()||"";
            cart["dura_type_val"]=eval($("#duration_type").val())||0;
            if (cart["dura_type_val"]==0) return;
            cart["drug_qty"]=Math.round(cart["dura_qty"]*cart["dosage_qty"]*cart["dura_type_val"]*cart["freq_val"]);
            if (cart["drug_qty"]==0) return;
            presc += " - " + cart["dura_qty"] + " " + cart["dura_type"];
            presc += " - " + cart["drug_qty"];
            cart["note"] = $("#medication_note").val();
            cart["prescription"] = presc;
            presc += "<br/>" + cart["note"];
            cart["status"]=0;
            pharmacy_cart.push(cart);
            globalPharmacyCartNum++;
            //insert tabel list
            var $tr = $("<tr></tr>").appendTo(prescTboby);
            $("<td></td>").html(pharmacy_cart.length).appendTo($tr);
            $("<td></td>").html(presc).appendTo($tr);
            var aTag = "<a href='#' id='del_cart_item_"+globalPharmacyCartNum+"' class=\"btn btn-danger btn-sm btn-icon icon-left\"><i class=\"entypo-cancel\"></i>Delete</a>";
            $("<td></td>").html(aTag).appendTo($tr);
            //delete cart item function
            $("#del_cart_item_"+globalPharmacyCartNum).on("click",function(e){
                e.preventDefault();
                var nTr=$(this).parents('tr')[0];
                var id = eval($(nTr).children().eq(0).text())-1;
                var recarts = [],num=0;
                $.each(pharmacy_cart,function(n){
                    if (n!=id) {
                        recarts[recarts.length] = this;
                        prescTboby.find("tr").eq(n).children().eq(0).html(recarts.length);    
                    }
                });
                pharmacy_cart = recarts;
                nTr.remove();
            });
        });
        savePharmacy = function(b){
          //  if (consID.length>0){
            var data={}, val = $("#patient-select").val().split("-");
            if (val.length==0){
                $.alert("please select reception information");
                return;
            }
            data["cons_id"]="";
            data["recept_id"]= val[0];
            data["patient_id"] = val[1];
            data["presc_list"] = function(){
                var res=[];
                $.each(pharmacy_cart,function(n){
                    if (this["status"]==0) {
                        res[res.length] = this;
                    }
                });
                return res;
            }();
            if (data["presc_list"].length<1) return;
            $.post("<?php echo base_url();?>"+"index.php?modal/savepharmacy",data,function(res){
                if (res=="success"){
                    $.alert("Sent pharmacy request to pharmacist successfully","Success");
                    $html = "Today" +"<hr/>";
                    $.each(pharmacy_cart,function(id){
                        $html += (id+1)+". "+this["prescription"] +"<br/>";
                        $html += this["note"]+"<br/>";
                    });
                    $("#pharmacy_summary").prepend( $html);
                    pharmacy_cart=[];
                    prescTboby.find("tr").remove();
                }
            });
          //  }
        };
        //send pharmacy request to pharmacist
        $("#send-pharmacy").on("click",function(){
            e.preventDefault();
            savePharmacy();
        });
    });
</script>