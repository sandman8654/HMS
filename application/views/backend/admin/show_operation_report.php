<table class="table table-bordered table-striped datatable" id="table-1">
    <thead>
        <tr>
            <th><?php echo get_phrase('description'); ?></th>
            <th><?php echo get_phrase('date'); ?></th>
            <th><?php echo get_phrase('patient'); ?></th>
            <th><?php echo get_phrase('doctor'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php
        $report_info = $this->db->get_where('report', array('type' => 'operation'))->result_array();
        foreach ($report_info as $row) { ?>   
            <tr>
                <td><?php echo $row['description'] ?></td>
                <td><?php echo date("m/d/Y", $row['timestamp']) ?></td>
                <td>
                    <?php
                    $name = $this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->name;
                    echo $name;
                    ?>
                </td>
                <td>
                    <?php
                    $name = $this->db->get_where('doctor', array('doctor_id' => $row['doctor_id']))->row()->name;
                    echo $name;
                    ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script type="text/javascript">
    jQuery(window).load(function ()
    {
        var $ = jQuery;

        $("#table-1").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Replace Checboxes
        $(".pagination a").click(function (ev)
        {
            replaceCheckboxes();
        });
    });
</script>