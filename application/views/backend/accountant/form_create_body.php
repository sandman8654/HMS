<div id="invoice_entry">
    <div class="form-group">
        
        <div id="form_element"></div>
        
        <div class="col-sm-2">
            <button type="button" class="btn btn-default" onclick="deleteParentElement(this)">
                <i class="entypo-trash"></i>
            </button>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php echo form_open('index.php?accountant/invoice_add/create', array('class' => 'form-horizontal form-groups validate invoice-add', 'enctype' => 'multipart/form-data')); ?>
        <div class="form-group">
            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('type'); ?></label>

            <div class="col-sm-3">
                <select name="type" class="form-control" id="element_type">
                    <option value="text"><?php echo get_phrase('text'); ?></option>
                    <option value="textarea"><?php echo get_phrase('textarea'); ?></option>
                </select>
            </div>
            
            <div class="col-sm-3">
                <button type="button" class="btn btn-default btn-sm btn-icon icon-left"
                        onClick="add_entry()">
                            <?php echo get_phrase('add_form_element'); ?>
                    <i class="entypo-plus"></i>
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script>

    // CREATING BLANK INVOICE ENTRY
    var blank_invoice_entry = '';
    $(document).ready(function () {
        blank_invoice_entry = $('#invoice_entry').html();
        $('#invoice_entry').remove();
    });

    function add_entry()
    {
        var element_type = document.getElementById("element_type").value;
        
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?accountant/get_form_element/' + element_type,
                        success: function (response)
                        {
                            //jQuery('.main_data').html(response);
                            //document.write(response);
                            $("#form_element").append(response);
                        }
                    });
        
    }

    // REMOVING INVOICE ENTRY
    function deleteParentElement(n) {
        n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
    }

</script>