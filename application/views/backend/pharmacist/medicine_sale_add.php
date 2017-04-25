<ol class="breadcrumb" style="margin-bottom: 0px;">
    <li>
        <a href="<?php echo base_url() ?>index.php?pharmacist">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
    <li>
        <a href="<?php echo base_url(); ?>index.php?pharmacist/medicine_sale">
            <?php echo get_phrase('medicine_sales') ?>
        </a>
    </li>
    <li><?php echo get_phrase('add_medicine_sale') ?></li>
</ol>
<br>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('add_medicine_sale'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?pharmacist/medicine_sale/create" method="post"
                    enctype="multipart/form-data">
                    
                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('patient'); ?></label>

                        <div class="col-sm-4">
                            <select name="patient_id" class="form-control select2">
                                <option value=""><?php echo get_phrase('select_a_patient'); ?></option>
                                <?php
                                $patients = $this->db->get('patient')->result_array();
                                foreach ($patients as $row) { ?>
                                    <option value="<?php echo $row['patient_id']; ?>"><?php echo $row['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <span id="medicine">
                        <br>
                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('medicines'); ?></label>

                            <div class="col-sm-2">
                                <select name="medicine_id[]" class="form-control" onchange="get_available_quantity(this.value, 1)" required>
                                    <option value=""><?php echo get_phrase('select_a_medicine'); ?></option>
                                    <?php
                                    $medicines = $this->db->get('medicine')->result_array();
                                    foreach ($medicines as $row) {
                                        $available_quantity = $row['total_quantity'] - $row['sold_quantity'];
                                        if($available_quantity > 0) { ?>
                                            <option value="<?php echo $row['medicine_id']; ?>">
                                                <?php echo $row['name']; ?>
                                            </option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>

                            <div class="col-sm-2">
                                <input type="number" class="form-control" name="medicine_quantity[]" id="medicine_quantity_1" min="1" max="999" value="" placeholder="Select Quantity" />
                            </div>

                            <div class="col-sm-2">
                                <input type="hidden" class="form-control" id="medicine_price_1" value="" readonly />
                            </div>
                        </div>
                    </span>

                    <span id="medicine_input">
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-2">
                                <select name="medicine_id[]" class="form-control" onchange="get_available_quantity(this.value)" id="medicine_id" >
                                    <option value=""><?php echo get_phrase('select_a_medicine'); ?></option>
                                    <?php
                                    $medicines = $this->db->get('medicine')->result_array();
                                    foreach ($medicines as $row) {
                                        $available_quantity = $row['total_quantity'] - $row['sold_quantity'];
                                        if($available_quantity > 0) { ?>
                                            <option value="<?php echo $row['medicine_id']; ?>">
                                                <?php echo $row['name']; ?>
                                            </option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>

                            <div class="col-sm-2">
                                <input type="number" class="form-control" name="medicine_quantity[]" id="medicine_quantity" min="1" max="999" value="" placeholder="Select Quantity" />
                            </div>

                            <div class="col-sm-2">
                                <button type="button" class="btn btn-default"
                                    id="medicine_delete" onclick="deletemedicineParentElement(this)">
                                    <i class="entypo-trash"></i>
                                </button>
                            </div>

                            <div class="col-sm-2">
                                <input type="hidden" class="form-control" id="medicine_price" value="" readonly />
                            </div>
                        </div>
                    </span>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="button" class="btn btn-default btn-sm btn-icon icon-left" onClick="add_medicine()">
                                <?php echo get_phrase('add_medicine'); ?>
                                <i class="entypo-plus"></i>
                            </button>

                            <button type="button" class="btn btn-info btn-sm" onClick="calculate_total_price()">
                                <?php echo get_phrase('calculate_total_price'); ?>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('total_price'); ?></label>

                        <div class="col-sm-2">
                            <input type="text" name="total_amount" class="form-control" id="total_amount" value="0" readonly />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-3">
                            <input type="submit" class="btn btn-success" value="Submit">
                        </div>
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>

<script type="text/javascript">

    var medicine_count      = 1;
    var total_amount        = 0;
    var deleted_medicines   = [];

    function get_available_quantity(medicine_id, append_id)
    {
        if(medicine_id != '') {
            $.ajax({
                url     : '<?php echo base_url(); ?>index.php?pharmacist/get_available_quantity/' + medicine_id,
                success : function(response)
                {
                    $('#medicine_quantity_' + append_id).attr('max', response);
                }
            });

            $.ajax({
                url     : '<?php echo base_url(); ?>index.php?pharmacist/get_medicine_price/' + medicine_id,
                success : function(response)
                {
                    $('#medicine_price_' + append_id).attr('value', response);
                }
            });
        }
    }
    
    $('#medicine_input').hide();
    
    // CREATING BLANK medicine INPUT
    var blank_medicine = '';
    $(document).ready(function () {
        blank_medicine = $('#medicine_input').html();
    });

    function add_medicine()
    {
        medicine_count++;
        $("#medicine").append(blank_medicine);

        $('#medicine_id').attr('id', 'medicine_id_' + medicine_count);
        $('#medicine_id_' + medicine_count).attr('onchange', 'get_available_quantity(this.value, ' + medicine_count + ')');

        $('#medicine_quantity').attr('id', 'medicine_quantity_' + medicine_count);
        $('#medicine_price').attr('id', 'medicine_price_' + medicine_count);

        $('#medicine_delete').attr('id', 'medicine_delete_' + medicine_count);
        $('#medicine_delete_' + medicine_count).attr('onclick', 'deletemedicineParentElement(this, ' + medicine_count + ')');
    }

    // REMOVING medicine INPUT
    function deletemedicineParentElement(n, medicine_count) {
        n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
        deleted_medicines.push(medicine_count);
    }
    
    function calculate_total_price()
    {
        var amount;
        for(i = 1; i <= medicine_count; i++) {
            if(jQuery.inArray(i, deleted_medicines) == -1)
            {
                quantity    = $('#medicine_quantity_' + i).val();
                if(quantity == '')
                    quantity = 0;
                amount      = $('#medicine_price_' + i).val() * quantity;
                if(amount != '') {
                    amount = parseInt(amount);
                    total_amount = amount + total_amount;
                    $('#total_amount').attr('value', total_amount);
                }
            }
        }
        total_amount = 0;
    }

</script>




















