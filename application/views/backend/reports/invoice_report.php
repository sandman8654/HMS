<div class="DTTT_PrintMessage">
    <div class="col-sm-12 print-header">
        <p>Official Invoice Report</p>
        <p>Date: <?php echo date("m/d/Y"); ?> </p>
        <p>From: <?php echo $from." ",$fromtime; ?> To: <?php echo $to." ".$totime; ?> </p>
    </div>
</div> 
<table class="table table-bordered table-striped datatable">
           
    <thead>
        <tr>
            <th><?php echo get_phrase('date');?></th>
            <th><?php echo get_phrase('patient_id');?></th>
            <th><?php echo get_phrase('patient_name');?></th>
            <th><?php echo get_phrase('pay_mode');?></th>
            <th><?php echo get_phrase('company');?></th>
            <th><?php echo get_phrase('Rcpt/Invoice_No');?></th>
            <th><?php echo get_phrase('Amount');?></th>
            <th><?php echo get_phrase('Time');?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($invoice_list as $item){ ?> 
            <tr>
                <td><?php echo $item['date'];?></td>
                <td><?php echo $item['patient_id'];?></td>
                <td><?php echo $item['patient_name'];?></td>
                <td><?php echo $item['pay_mode'];?></td>
                <td><?php echo $item['company'];?></td>
                <td><?php echo $item['inv_No'];?></td>
                <td><?php echo $item['amount'];?></td>
                <td><?php echo $item['time'];?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<div class="DTTT_PrintMessage">
    <div class="col-sm-2 print-header">
        <hr/>
        <p>General Summary</p>
        <hr/>
        <p>Total amount: <?php echo $cash+$credit+$bank+$comp; ?> </p>
        <hr/>
            <p>Cashier's' Summary</p>
        <hr/>
        <p>Cash Held: <?php echo $cash; ?> </p>
        <p>Companies: <?php echo $comp; ?> </p>
        <p>Bank: <?php echo $bank; ?> </p>
        <p>Credit: <?php echo $credit; ?> </p>
    </div>
</div> 
