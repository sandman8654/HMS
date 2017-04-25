<?php
$edit_data = $this->db->get_where('doctor', array('doctor_id' => $param2))->result_array();
foreach ($edit_data as $row):
?>
<div class="row" id="information_print">
            <div class="col-md-12">

                <div class="panel panel-primary" data-collapsed="0">
                        
                    <div class="panel-body">
                            
                        <b><?php echo get_phrase('name'); ?> :</b>
                        
                        <p><?php echo $row['name']; ?></p>
                            
                        <b><?php echo get_phrase('address'); ?> :</b>
                        
                        <p><?php echo $row['address']; ?></p>
                        
                        <b><?php echo get_phrase('department'); ?> :</b>
                        
                        <p><?php echo $this->db->get_where('department',array('department_id'=>$row['department_id']))->row()->name; ?></p>
                        
                        <b><?php echo get_phrase('phone'); ?> :</b>
                        
                        <p><?php echo $row['phone']; ?></p>
                            
                        <b><?php echo get_phrase('profile'); ?> :</b>
                        
                        <p><?php echo $row['profile']; ?></p>
                        
                    </div>

                </div>

            </div>
        </div>

    <a onClick="PrintElem('#information_print')" class="btn btn-primary btn-icon icon-left hidden-print">
        Print Information
        <i class="entypo-doc-text"></i>
    </a>


<?php endforeach; ?>




<script type="text/javascript">

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'information', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Information</title>');
        mywindow.document.write('<link rel="stylesheet" href="assets/css/neon-theme.css" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }

</script>