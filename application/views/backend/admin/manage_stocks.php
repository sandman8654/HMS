<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3 id="test-date"><?php echo get_phrase('stocks_management'); ?></h3>
                </div>
            </div>
            
            <div class="panel-body">
                <div class="col-md-12 col-sm-12">
                    <ul class="nav nav-tabs bordered">
                        <li class="<?php if ($page_subname=="manage_stock_items") echo 'active';?>"><a href="#tabs-1" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('stock_items'); ?></span></a></li>
                        <li class="<?php if ($page_subname=="manage_stock_request") echo 'active';?>"><a href="#tabs-2" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('stock_request'); ?></span></a></li>
                        <li class="<?php if ($page_subname=="manage_stock_transfer") echo 'active';?>"><a href="#tabs-3" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('stock_transfer'); ?></span></a></li>
                        <!--<li><a href="#tabs-4" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('stock_taking'); ?></span></a></li>-->
                        <li class="<?php if ($page_subname=="manage_stock_adjustment") echo 'active';?>"><a href="#tabs-5" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('stock_adjustment'); ?></span></a></li>
                        <li class="<?php if ($page_subname=="manage_stock_valuation") echo 'active';?>"><a href="#tabs-6" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('stock_valuation'); ?></span></a></li>
                        <li class="<?php if ($page_subname=="manage_stock_usage_register") echo 'active';?>"><a href="#tabs-7" data-toggle="tab"><span class="hidden-xs"><?php echo get_phrase('stock_usage_register'); ?></span></a></li>
                    </ul>
                    <div  class="tab-content recep-tab">
                        <div id="tabs-1" class="tab-pane <?php if ($page_subname=="manage_stock_items") echo 'active';?>">
                           <?php include 'manage_stock_items.php'; ?>
                        </div>
                        <div id="tabs-2" class="tab-pane <?php if ($page_subname=="manage_stock_request") echo 'active';?>">
                            <?php include 'manage_stock_request.php'; ?>
                        </div>
                        <div id="tabs-3" class="tab-pane <?php if ($page_subname=="manage_stock_transfer") echo 'active';?>">
                            <?php include 'manage_stock_transfer.php'; ?>
                        </div>
                        <div id="tabs-5" class="tab-pane <?php if ($page_subname=="manage_stock_adjustment") echo 'active';?>">
                            <?php include 'manage_stock_adjustment.php'; ?>
                        </div>
                        <div id="tabs-6" class="tab-pane <?php if ($page_subname=="manage_stock_valuation") echo 'active';?>">
                            <?php include 'manage_stock_valuation.php'; ?>
                        </div>
                        <div id="tabs-7" class="tab-pane <?php if ($page_subname=="manage_stock_usage_register") echo 'active';?>">
                            <?php include 'manage_stock_usage_register.php'; ?>
                        </div>
                    </div>
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
        $("#table-creditor-list").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Highlighted rows
        $("#table-creditor-list tbody input[type=checkbox]").each(function (i, el)
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

