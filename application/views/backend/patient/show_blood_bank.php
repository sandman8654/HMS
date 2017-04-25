<div class="row">

    <div class="col-md-12">

        <ul class="nav nav-tabs bordered"><!-- available classes "bordered", "right-aligned" -->
            <li class="active">
                <a href="#blood_donor_list" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-home"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('blood_donor_list');?></span>
                </a>
            </li>
            <li>
                <a href="#blood_bank_status" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-user"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('blood_bank_status');?></span>
                </a>
            </li>
        </ul>

        <div class="tab-content">
            
            <div class="tab-pane active" id="blood_donor_list">
                    
                <table class="table table-bordered table-striped datatable" id="table-1">
                    <thead>
                        <tr>
                            <th><?php echo get_phrase('name'); ?></th>
                            <th><?php echo get_phrase('age'); ?></th>
                            <th><?php echo get_phrase('sex'); ?></th>
                            <th><?php echo get_phrase('blood_group'); ?></th>
                            <th><?php echo get_phrase('last_donation_date'); ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($blood_donor_info as $row) { ?>   
                            <tr>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['age'] ?></td>
                                <td><?php echo $row['sex'] ?></td>
                                <td><?php echo $row['blood_group'] ?></td>
                                <td><?php echo date("m/d/Y", $row['last_donation_timestamp']) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
            
            <div class="tab-pane" id="blood_bank_status">
                
                <table class="table table-bordered table-striped datatable" id="table-2">
                    <thead>
                        <tr>
                            <th><?php echo get_phrase('blood_group'); ?></th>
                            <th><?php echo get_phrase('status'); ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($blood_bank_info as $row) { ?>   
                            <tr>
                                <td><?php echo $row['blood_group'] ?></td>
                                <td><?php echo $row['status'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                
            </div>
            
        </div>
        
    </div>
    
</div>

<?php for($count=1; $count<=2; $count++){ ?>
    <script type="text/javascript">
        jQuery(window).load(function ()
        {
            var $ = jQuery;

            $("#table-<?php echo $count ?>").dataTable({
                "sPaginationType": "bootstrap",
                "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
            });

            $(".dataTables_wrapper select").select2({
                minimumResultsForSearch: -1
            });

            // Highlighted rows
            $("#table-<?php echo $count ?> tbody input[type=checkbox]").each(function (i, el)
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
<?php } ?>