<?php
$edit_data = $this->db->get_where('invoice', array('invoice_id' => $param2))->result_array();
foreach ($edit_data as $row):
?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title" >
                        <i class="entypo-plus-circled"></i>
                        <?php echo get_phrase('edit_invoice'); ?>
                    </div>
                </div>
                <div class="panel-body">

                    <?php echo form_open(base_url() . 'index.php?accountant/invoice_manage/update/' . $param2, array('class' => 'form-horizontal form-groups validate invoice-edit', 'enctype' => 'multipart/form-data')); ?>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('invoice_title'); ?></label>

                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="title" id="title" data-validate="required" 
                                   data-message-required="<?php echo get_phrase('value_required'); ?>" 
                                   value="<?php echo $row['title']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('invoice_number'); ?></label>

                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="invoice_number"  value="<?php echo $row['invoice_number']; ?>"  readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('patient'); ?></label>

                        <div class="col-sm-5">
                            <select name="patient_id" class="select2">
                                <option><?php echo get_phrase('select_a_patient'); ?></option>
                                <?php
                                $patients = $this->db->get('patient')->result_array();
                                foreach ($patients as $row2):
                                    ?>
                                    <option value="<?php echo $row2['patient_id']; ?>"	
                                        <?php if ($row['patient_id'] == $row2['patient_id']) echo 'selected'; ?>>
                                            <?php echo $row2['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('creation_date'); ?></label>

                        <div class="col-sm-5">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="entypo-calendar"></i></span>
                                <input type="text" class="form-control datepicker" name="creation_timestamp"  
                                       value="<?php echo $row['creation_timestamp']; ?>" >
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('due_date'); ?></label>

                        <div class="col-sm-5">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="entypo-calendar"></i></span>
                                <input type="text" class="form-control datepicker" name="due_timestamp"  
                                       value="<?php echo $row['due_timestamp']; ?>" >
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('vat_percentage'); ?></label>

                        <div class="col-sm-5">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="entypo-info-circled"></i></span>
                                <input type="text" class="form-control" name="vat_percentage"  
                                       value="<?php echo $row['vat_percentage']; ?>" >
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('discount_amount'); ?></label>

                        <div class="col-sm-5">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="entypo-info-circled"></i></span>
                                <input type="text" class="form-control" name="discount_amount"  
                                       value="<?php echo $row['discount_amount']; ?>" >
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('payment_status'); ?></label>

                        <div class="col-sm-5">
                            <select name="status" class="selectboxit">
                                <option><?php echo get_phrase('select_a_status'); ?></option>
                                <option value="paid" <?php if ($row['status'] == 'paid') echo 'selected'; ?>>
                                    <?php echo get_phrase('paid'); ?>
                                </option>
                                <option value="unpaid"<?php if ($row['status'] == 'unpaid') echo 'selected'; ?>>
                                    <?php echo get_phrase('unpaid'); ?>
                                </option>
                            </select>
                        </div>
                    </div>

                    <hr>
                    <!-- INVOICE ENTRY STARTS HERE-->
                    <div id="invoice_entry">
                        <?php
                        $invoice_entries = json_decode($row['invoice_entries']);
                        foreach ($invoice_entries as $invoice_entry) {
                            ?>
                            <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label">
                                    <?php echo get_phrase('invoice_entry'); ?></label>

                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="entry_description[]"  
                                           value="<?php echo $invoice_entry->description; ?>" 
                                           placeholder="<?php echo get_phrase('description'); ?>" >
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="entry_amount[]"  
                                           value="<?php echo $invoice_entry->amount; ?>" 
                                           placeholder="<?php echo get_phrase('amount'); ?>" >
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-default" onclick="deleteParentElement(this)">
                                        <i class="entypo-trash"></i>
                                    </button>
                                </div>

                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <!-- INVOICE ENTRY ENDS HERE-->

                    <!-- TEMPORARY INVOICE ENTRY STARTS HERE-->
                    <div id="invoice_entry_temp">
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('invoice_entry'); ?></label>

                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="entry_description[]"  value="" 
                                       placeholder="<?php echo get_phrase('description'); ?>" >
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="entry_amount[]"  value="" 
                                       placeholder="<?php echo get_phrase('amount'); ?>" >
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-default" onclick="deleteParentElement(this)">
                                    <i class="entypo-trash"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                    <!-- TEMPORARY INVOICE ENTRY ENDS HERE-->


                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-8">
                            <button type="button" class="btn btn-default btn-sm btn-icon icon-left"
                                    onClick="add_entry()">
                                        <?php echo get_phrase('add_invoice_entry'); ?>
                                <i class="entypo-plus"></i>
                            </button>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-8">
                            <button type="submit" class="btn btn-info" id="submit-button">
                                <?php echo get_phrase('update_invoice'); ?></button>
                            <span id="preloader-form"></span>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>	



<script>

    // CREATING BLANK INVOICE ENTRY
    var blank_invoice_entry = '';
    $(document).ready(function () {
        blank_invoice_entry = $('#invoice_entry_temp').html();
        $('#invoice_entry_temp').remove();
    });

    function add_entry()
    {
        $("#invoice_entry").append(blank_invoice_entry);
    }

    // REMOVING INVOICE ENTRY
    function deleteParentElement(n) {
        n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
    }

</script>
