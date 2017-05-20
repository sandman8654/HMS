<div class="DTTT_PrintMessage">
    <div class="col-sm-12 print-header">
        <p>OFFICIAL GOODS RETURNED NOTE</p>
        <p>Date: <?php echo date("m/d/Y"); ?> </p>
        <p>Supplier:<?php echo $supplier; ?></p>
        <p>Invoice No:<?php echo $invno; ?></p>
        <p>GRN No:<?php echo $refno; ?></p>
    </div>
</div> 
<table class="table table-bordered table-striped datatable">
    <thead>
        <tr>
            <th><?php echo get_phrase('item_name');?></th>
            <th><?php echo get_phrase('pack');?></th>
            <th><?php echo get_phrase('batch_no');?></th>
            <th><?php echo get_phrase('unit');?></th>
            <th><?php echo get_phrase('part');?></th>
            <th><?php echo get_phrase('purchase_price');?></th>
            <th><?php echo get_phrase('total');?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($grn_list as $item){ ?> 
            <tr>
                <td><?php echo $item['item_name'];?></td>
                <td><?php echo $item['pack'];?></td>
                <td><?php echo $item['batchno'];?></td>
                <td><?php echo $item['unit'];?></td>
                <td><?php echo $item['part'];?></td>
                <td><?php echo $item['pprice'];?></td>
                <td><?php echo $item['total'];?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<div class="DTTT_PrintMessage">
    <div class="col-sm-12 print-header">
        <p>Total Cost: <?php echo $total_cost; ?> </p>
    </div>
</div> 
