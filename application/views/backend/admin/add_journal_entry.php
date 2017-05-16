<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('add_journal_entry'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form id="jrform" role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/journalentry/create" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Debit_SubLedger:'); ?></label>

                        <div class="col-sm-5">
                            <?php 
                                $ledger_list = $this->db->query("select * from ledgers where ledgerid!=601 order by name")->result_array();
                            ?>
                            <select id="drid-select" name="drid" class="form-control " placeholder=<?php echo get_phrase('type_search_debit');?>>
                                <option value=""><?php echo get_phrase('type_search_debit'); ?></option>
                                <optgroup label="<?php echo get_phrase('debit'); ?>">
                                    <?php 
                                        foreach ($ledger_list as $item){ ?>
                                        <option value="<?php echo $item['ledgerid']; ?>" data-category="<?php echo $item['category'];?>"><?php echo $item['name']; ?></option>        
                                    <?php } ?>
                                </optgroup>    
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Credit_SubLedger'); ?></label>
                        <div class="col-sm-5">
                            <select id="crid-select" name="crid" class="form-control " placeholder=<?php echo get_phrase('type_search_credit');?>>
                                <option value=""><?php echo get_phrase('type_search_crdeit'); ?></option>
                                <optgroup label="<?php echo get_phrase('credit'); ?>">
                                    <?php 
                                        foreach ($ledger_list as $item){ ?>
                                        <option value="<?php echo $item['ledgerid']; ?>" data-category="<?php echo $item['category'];?>"><?php echo $item['name']; ?></option>        
                                    <?php } ?>
                                </optgroup>    
                            </select>
                        </div>
                    </div>
                    <div class="form-group hidden" id="bankdiv">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('bank:'); ?></label>
                        <div class="col-sm-5">
                            <select id="bank-select" name="bank" class="form-control select2" placeholder=<?php echo get_phrase('type_search_bank');?>>
                                <option value=""><?php echo get_phrase('type_search_bank'); ?></option>
                                <optgroup label="<?php echo get_phrase('bank'); ?>">
                                    <?php
                                        $this->db->order_by("name");
                                        $list = $this->db->get("banktbl")->result_array();
                                        foreach ($list as $item){ ?>
                                        <option value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>        
                                    <?php } ?>
                                </optgroup>    
                            </select>
                        </div>
                    </div>
                    <div class="form-group hidden" id="medicdiv">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Medic:'); ?></label>
                        <div class="col-sm-5">
                            <select id="medic-select" name="medic" class="form-control " placeholder="<?php echo get_phrase('type_search_medic');?>">
                                <option value=""><?php echo get_phrase('type_search_medic'); ?></option>
                                <optgroup label="<?php echo get_phrase('medic'); ?>">
                                    <?php 
                                        $this->db->order_by("name");
                                        $list = $this->db->get("extmedics")->result_array();
                                        foreach ($list as $item){ ?>
                                        <option value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>        
                                    <?php } ?>
                                </optgroup>    
                            </select>
                        </div>
                    </div>
                    <div class="form-group hidden"  id="schemediv">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Scheme:'); ?></label>
                        <div class="col-sm-5">
                            <select id="schemes-select" name="schemes" class="form-control " placeholder="<?php echo get_phrase('type_search_Scheme');?>">
                                <option value=""><?php echo get_phrase('type_search_Scheme'); ?></option>
                                <optgroup label="<?php echo get_phrase('Scheme'); ?>">
                                    <?php 
                                        $this->db->order_by("SchemeName");
                                        $list = $this->db->get("schemes")->result_array();
                                        foreach ($list as $item){ ?>
                                        <option value="<?php echo $item['SchemeId']; ?>"><?php echo $item['SchemeName']; ?></option>        
                                    <?php } ?>
                                </optgroup>    
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('amount:'); ?></label>

                        <div class="col-sm-5">
                            <input type="text" name="amount" class="form-control" id="amount" >
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('note:'); ?></label>

                        <div class="col-sm-9">
                            <textarea name="note" class="form-control" id="field-ta"></textarea>
                        </div>
                    </div>

                    <div class="col-sm-3 control-label col-sm-offset-2">
                        <input type="submit" class="btn btn-success" value="Submit">
                    </div>
                    <input type="hidden" name="bankid" value="">
                    <input type="hidden" name="accname" value="">
                </form>

            </div>

        </div>

    </div>
</div>

<script>
        function showOtherSelecor(cat){
            if (cat == "Bank"){
                $("#bankdiv").removeClass("hidden");
                $("#medicdiv").addClass("hidden");
                $("#schemediv").addClass("hidden");
            }else if(cat=="Extmedics"){
                $("#bankdiv").addClass("hidden");
                $("#medicdiv").removeClass("hidden");
                $("#schemediv").addClass("hidden");

            }else if(cat=="Insurance"){
                $("#bankdiv").addClass("hidden");
                $("#medicdiv").addClass("hidden");
                $("#schemediv").removeClass("hidden");
            }else{
                $("#bankdiv").addClass("hidden");
                $("#medicdiv").addClass("hidden");
                $("#schemediv").addClass("hidden");
            }
        }
        $("#drid-select").on("change",function(){
            var $this= $(this);
            var cat = $this.find("option:selected").data("category");
            showOtherSelecor(cat);
        });
        $("#crid-select").on("change",function(){
            var $this= $(this);
            var cat = $this.find("option:selected").data("category");
            showOtherSelecor(cat);
        });
        $("#jrform").submit(function(){
            var dr = $("#drid-select").val();
            var cr = $("#crid-select").val();
            var bank = $("#bank-select").val(),
                medic = $("#medic-select").val(),
                scheme = $("#schemes-select").val(),
                amount = $("#amount").val();
            
            if (dr==""||cr==""||amount==""||
            (!$("#bankdiv").hasClass("hidden")&&bank=="")||
            (!$("#medicdiv").hasClass("hidden")&&medic=="")||
            (!$("#schemediv").hasClass("hidden")&&scheme=="")){
                $.alert("All the fields are required!","Error");
                return false;
            };
            if(cr==dr){
                $.alert("Transactions cannot be carried out between the same ledger!","Error");
                return false;
            };
            var amv = eval(amount)||0;
            if (amv==0){
                $.alert("Invalid amount!","Error");
                $("#amount").focus();
                return false;
            };
            if (!$("#bankdiv").hasClass("hidden")){
                $("#bankid").val(bank); 
                $("#accname").val($("#bank-select").find("option:selected").text())
            }else if (!$("#medicdiv").hasClass("hidden")){
                $("#bankid").val(medic); 
                $("#accname").val($("#medic-select").find("option:selected").text())
            }else if (!$("#schemediv").hasClass("hidden")){
                $("#bankid").val(scheme); 
                $("#accname").val($("#schemes-select").find("option:selected").text())
            };
            return true;
        })
  
</script>