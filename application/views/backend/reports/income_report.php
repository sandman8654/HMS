<div class="DTTT_PrintMessage">
    <div class="col-sm-12 print-header">
        <p>Official Income Report</p>
        <p>Date: <?php echo date("m/d/Y"); ?> </p>
        <p>From: <?php echo $from; ?> To: <?php echo $to; ?> </p>
    </div>
</div> 
<table class="table table-bordered table-striped datatable">
    <thead>
        <tr>
            <th><?php echo get_phrase('trans_date');?></th>
            <th><?php echo get_phrase('patient_name');?></th>
            <th><?php echo get_phrase('item_name');?></th>
            <th><?php echo get_phrase('unit_price');?></th>
            <th><?php echo get_phrase('qty');?></th>
            <th><?php echo get_phrase('vat');?></th>
            <th><?php echo get_phrase('discount');?></th>
            <th><?php echo get_phrase('total_sale');?></th>
            <th><?php echo get_phrase('posted');?></th>
            <th><?php echo get_phrase('cashier');?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($income_list as $item){ ?> 
            <tr>
                <td><?php echo $item['trans_date'];?></td>
                <td><?php echo $item['patient_name'];?></td>
                <td><?php echo $item['item_name'];?></td>
                <td><?php echo $item['unit_price'];?></td>
                <td><?php echo $item['qty'];?></td>
                <td><?php echo $item['vat'];?></td>
                <td><?php echo $item['discount'];?></td>
                <td><?php echo $item['total_sale'];?></td>
                <td><?php echo $item['posted'];?></td>
                <td><?php echo $item['cashier'];?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<div class="DTTT_PrintMessage">
    <div class="col-sm-2 print-header">
        <hr/>
        <p>General Summary</p>
        <hr/>
        <p>Total Vat: <?php echo $vat; ?> </p>
        <p>Total Discount: <?php echo $discount; ?> </p>
        <p>Total Cost: <?php echo $cost; ?> </p>
        <p>Total Sales: <?php echo $sales; ?> </p>
        <p>Net Income: <?php echo $sales-$cost; ?> </p>
    </div>
</div> 
