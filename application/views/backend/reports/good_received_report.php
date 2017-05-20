<div class="DTTT_PrintMessage">
    <div class="col-sm-12 print-header">
        <p>OFFICIAL GOODS RECEIVED REPORT</p>
        <p>Date: <?php echo date("m/d/Y"); ?> </p>
        <p>From: <?php echo $from; ?> To: <?php echo $to; ?> </p>
    </div>
</div> 
<table class="table table-bordered table-striped datatable">
    <thead>
        <tr>
            <th><?php echo get_phrase('trans_date');?></th>
            <th><?php echo get_phrase('GRN_no');?></th>
            <th><?php echo get_phrase('supplier');?></th>
            <th><?php echo get_phrase('item_name');?></th>
            <th><?php echo get_phrase('unit');?></th>
            <th><?php echo get_phrase('part');?></th>
            <th><?php echo get_phrase('price');?></th>
            <th><?php echo get_phrase('total');?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($grn_list as $item){ ?> 
            <tr>
                <td><?php echo $item['trans_date'];?></td>
                <td><?php echo $item['grnno'];?></td>
                <td><?php echo $item['supplier'];?></td>
                <td><?php echo $item['item_name'];?></td>
                <td><?php echo $item['unit'];?></td>
                <td><?php echo $item['part'];?></td>
                <td><?php echo $item['price'];?></td>
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
