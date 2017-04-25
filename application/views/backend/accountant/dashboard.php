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

            editable: false,
            firstDay: 1,
            height: 530,
            droppable: false,

            events:
            [
                <?php
                $notices   = $this->db->get('notice')->result_array();
                foreach ($notices as $row):
                ?>
                    {
                        title   :   "<?php echo $title = $this->db->get_where('notice' , 
                                        array('notice_id' => $row['notice_id'] ))->row()->title;?>",
                        start   :   new Date(<?php echo date('Y', $row['start_timestamp']); ?>, 
                                        <?php echo date('m', $row['start_timestamp']) - 1; ?>, 
                                        <?php echo date('d', $row['start_timestamp']); ?>),
                        end     :   new Date(<?php echo date('Y', $row['end_timestamp']); ?>, 
                                        <?php echo date('m', $row['end_timestamp']) - 1; ?>, 
                                        <?php echo date('d', $row['end_timestamp']); ?>),
                        allDay: true
                    },
                <?php endforeach ?>
            ]
        });
    });
</script>