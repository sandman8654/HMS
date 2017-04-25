<hr />

<?php echo form_open(base_url() . 'index.php?admin/payroll_selector'); ?>
    
    <div class="row">
        
        <div class="col-md-offset-1 col-md-3">
            <div class="form-group">
                <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('employee'); ?></label>
                <select name="employee_id" class="form-control select2" required>

                    <option value=""><?php echo get_phrase('select_an_employee'); ?></option>
                    <?php
                    $user_types = array('doctor', 'nurse', 'pharmacist', 'laboratorist', 'receptionist', 'accountant');
                    foreach($user_types as $user_type) { ?>
                        <optgroup label="<?php echo get_phrase($user_type); ?>">
                            <?php
                            $user_info = $this->db->get($user_type)->result_array();
                            
                            foreach ($user_info as $row) { ?>

                                <option value="<?php echo $user_type . '-' . $row[$user_type . '_id']; ?>">
                                    - <?php echo $row['name']; ?></option>

                            <?php } ?>
                        </optgroup>
                    <?php } ?>
                </select>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" style="margin-bottom: 11px;"><?php echo get_phrase('month'); ?></label>
                <select name="month" class="form-control selectboxit" required>
                    <option value=""><?php echo get_phrase('select_a_month'); ?></option>
                    <?php
                    for ($i = 1; $i <= 12; $i++):
                        if ($i == 1)
                            $m = get_phrase('january');
                        else if ($i == 2)
                            $m = get_phrase('february');
                        else if ($i == 3)
                            $m = get_phrase('march');
                        else if ($i == 4)
                            $m = get_phrase('april');
                        else if ($i == 5)
                            $m = get_phrase('may');
                        else if ($i == 6)
                            $m = get_phrase('june');
                        else if ($i == 7)
                            $m = get_phrase('july');
                        else if ($i == 8)
                            $m = get_phrase('august');
                        else if ($i == 9)
                            $m = get_phrase('september');
                        else if ($i == 10)
                            $m = get_phrase('october');
                        else if ($i == 11)
                            $m = get_phrase('november');
                        else if ($i == 12)
                            $m = get_phrase('december'); ?>
                        <option value="<?php echo $i; ?>">
                            <?php echo $m; ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
        
        <div class="col-md-2">
            <div class="form-group">
                <label class="control-label" style="margin-bottom: 11px;"><?php echo get_phrase('year'); ?></label>
                <select name="year" class="form-control selectboxit" required>
                    <option value=""><?php echo get_phrase('select_a_year'); ?></option>
                    <?php
                    for($i = 2017; $i <= 2026; $i++): ?>
                        <option value="<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>

        <div class="col-md-2" style="margin-top: 27px;">
            <button type="submit" class="btn btn-info" style="width: 100%;">
                <?php echo get_phrase('submit'); ?></button>
        </div>

    </div>

<?php echo form_close(); ?>

<script type="text/javascript">

    $(document).ready(function () {

        // SelectBoxIt Dropdown replacement
        if ($.isFunction($.fn.selectBoxIt))
        {
            $("select.selectboxit").each(function (i, el)
            {
                var $this = $(el),
                        opts = {
                            showFirstOption: attrDefault($this, 'first-option', true),
                            'native': attrDefault($this, 'native', false),
                            defaultText: attrDefault($this, 'text', ''),
                        };

                $this.addClass('visible');
                $this.selectBoxIt(opts);
            });
        }

    });

</script>