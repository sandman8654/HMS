<button onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/add_appointment');" 
    class="btn btn-primary pull-right">
        <?php echo get_phrase('add_appointment'); ?>
</button>
<div style="clear:both;"></div>
<br>
<center>
    <form role="form" enctype="multipart/form-data" class="form-horizontal form-groups-bordered"
        action="<?php echo base_url(); ?>index.php?receptionist/appointment/filter" method="post">
    <table border="0" cellspacing="0" cellpadding="0" class="table">
        <tr>
            <td><?php echo get_phrase('select_doctor'); ?></td>
            <td><?php echo get_phrase('start_date'); ?></td>
            <td><?php echo get_phrase('end_date'); ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <select name="doctor_id" class="selectboxit">
                    <option value="all" <?php if($doctor_id == 'all') echo 'selected'; ?>>
                        <?php echo get_phrase('all_doctors'); ?></option>
                    <?php
                    $doctors = $this->db->get('doctor')->result_array();
                    foreach ($doctors as $row) { ?>
                        <option value="<?php echo $row['doctor_id']; ?>"
                            <?php if ($doctor_id == $row['doctor_id']) echo 'selected'; ?>>
                                <?php echo $row['name']; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td>
                <input type="text" name="start_timestamp" class="form-control datepicker" 
                    data-format="D, dd MM yyyy" placeholder="date here" 
                    value="<?php echo date("D, d M Y", $start_timestamp); ?>">
            </td>
            <td>
                <input type="text" name="end_timestamp" class="form-control datepicker" 
                    data-format="D, dd MM yyyy" placeholder="date here"
                    value="<?php echo date("D, d M Y", $end_timestamp); ?>">
            </td>
            <td>
                <input type="submit" value="<?php echo get_phrase('filter_appointments'); ?>" class="btn btn-info" />
            </td>
        </tr>
    </table>
    </form>
</center>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo get_phrase('date');?></th>
            <th><?php echo get_phrase('doctor');?></th>
            <th><?php echo get_phrase('patient');?></th>
        </tr>
    </thead>

    <tbody>
        <?php 
        $count = 1;
        foreach ($appointment_info as $row) { ?>   
            <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo date("d M, Y -  H:i", $row['timestamp']); ?></td>
                <td>
                    <?php $name = $this->db->get_where('doctor' , array('doctor_id' => $row['doctor_id'] ))->row()->name;
                        echo $name;?>
                </td>
                <td>
                    <?php $name = $this->db->get_where('patient' , array('patient_id' => $row['patient_id'] ))->row()->name;
                        echo $name;?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<div class="row">
    <!-- CALENDAR-->
    <div class="col-md-12 col-xs-12">    
        <div class="panel panel-primary " data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fa fa-calendar"></i>
                    <?php echo get_phrase('event_schedule'); ?>
                </div>
            </div>
            <div class="panel-body" style="padding:0px;">
                <div class="calendar-env">
                    <div class="calendar-body">
                        <div id="notice_calendar"></div>
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

        $("#table-2").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"      
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Highlighted rows
        $("#table-2 tbody input[type=checkbox]").each(function (i, el)
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
    
    $(document).ready(function()
    {
        var calendar = $('#notice_calendar');
				
        $('#notice_calendar').fullCalendar
        ({
            header:
            {
                left: 'title',
                right: 'month,agendaWeek,agendaDay today prev,next'
            },
            
            defaultView: 'agendaDay',

            //defaultView: 'basicWeek',

            editable: false,
            firstDay: 1,
            height: 530,
            droppable: false,

            events:
            [
                <?php
                foreach ($appointment_info as $row):
                ?>
                    {
                        title   :   "<?php  $doctor_name = $this->db->get_where('doctor' , 
                                                array('doctor_id' => $row['doctor_id'] ))->row()->name;
                                            $patient_name = $this->db->get_where('patient' , 
                                                array('patient_id' => $row['patient_id'] ))->row()->name;
                                            echo get_phrase('doctor_:_') . $doctor_name . '\n' . get_phrase('patient_:_') . $patient_name;?>",
                        start   :   new Date(<?php echo date('Y', $row['timestamp']); ?>, 
                                        <?php echo date('m', $row['timestamp']) - 1; ?>, 
                                        <?php echo date('d', $row['timestamp']); ?>,
                                        <?php echo date('H', $row['timestamp']); ?>),
                        allDay: false
                    },
                <?php endforeach ?>
            ]
        });
    });
</script>