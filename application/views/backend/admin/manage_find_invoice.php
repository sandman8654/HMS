<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3 id="test-date"><?php echo get_phrase('invoices'); ?></h3>
                </div>
            </div>
            
            <div class="panel-body">
                <div class="col-md-12 col-sm-12">
                    <form role="form" class="form-horizontal form-groups-bordered" >
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('paitient_select:'); ?></label>
                            <div class="col-sm-9">
                                <select id="patient_select" name="drname" class="form-control select2" placeholder="<?php echo get_phrase('type_search_term');?>">
                                    <option value=""><?php echo get_phrase('type_search_term'); ?></option>
                                    <optgroup label="<?php echo get_phrase('patients'); ?>">
                                        <?php 
                                            $this->db->where("paymode","Companies");
                                            $this->db->group_by("invno");
                                            $all_items_info= $this->db->get('receipts')->result_array();
                                            foreach ($all_items_info as $item){ ?>
                                            <option value=<?php echo $item['invno']; ?>><?php echo $this->crud_model->select_patient_info_by_patient_id($item['patient_id'])[0]["name"]." - ".$item['patient_id']." - ".$item["invno"]; ?></option> 
                                        <?php } ?>
                                    </optgroup>    
                                </select>
                            </div>
                        </div>
                        <h4 class="add-patient-sub-title"><?php echo get_phrase('Invoice_information'); ?></h4>
                        <table class="table table-bordered table-striped datatable" id="table-inv-list">
                            <thead>
                                <tr>
                                    <th><?php echo get_phrase('no.');?></th>
                                    <th><?php echo get_phrase('Date');?></th>
                                    <th><?php echo get_phrase('Invoice_no');?></th>
                                    <th><?php echo get_phrase('Patient_name');?></th>
                                    <th><?php echo get_phrase('paitent_id');?></th>
                                    <th><?php echo get_phrase('report');?></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </form>
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
        
        // Replace Checboxes
        $(".pagination a").click(function (ev)
        {
            replaceCheckboxes();
        }); 
        getinvoiceinfor();
        function getinvoiceinfor(invno){
            invno=invno||"";
            $.get("<?php echo base_url();?>"+"index.php?modal/getreceiptsinvoice/"+invno,function(res){
                var data = eval(res),
                    tb = $("#table-inv-list").dataTable();
                tb.fnClearTable(true) ;
                $.each(data,function(id){
                    tb.fnAddData([
                        this["id"],
                        this["date"],
                        this["invno"],
                        this["pname"],
                        this["pid"],
                        "<a href='#' class='btn btn-success btn-sm'>View Report</a>"
                    ]);
                });
            });
        }
        $("#patient_select").on("change",function(){
            var pid = $(this).val();
            getinvoiceinfor(pid);
        });
    });
</script>

