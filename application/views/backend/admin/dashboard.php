<script>
    var IncomeExpenseChartData ='<?php echo $this->crud_model->get_data_for_income_expense_chart(); ?>';
    var patientChartData = '<?php  echo $this->crud_model->get_data_for_patient_chart(); ?>';
</script>
<div class="row">
    <!-- amchart library-->
    <script src="assets/js/amcharts/amcharts.js"></script>
    <script src="assets/js/amcharts/serial.js"></script>
    <script src="assets/js/amcharts/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="assets/js/amcharts/plugins/export/export.css" type="text/css" media="all" />
    <script src="assets/js/amcharts/themes/light.js"></script>
    <!-- custom chart -->
    <script src="assets/js/custom/dashboard-chat.js"></script>
    
    
    <!-- Patients Views CHART -->
	<div class="col-sm-6">

		<div class="panel panel-primary" id="charts_env">
			<div class="panel-heading">
				<div class="panel-title">
					<i class="entypo-chart-bar"></i>
					<?php echo get_phrase('patient'); ?> Graph (monthly)
				</div>
			</div>
            <div class="panel-body">
				<div id="bar_Patientschartdiv"></div>
				<center><?php echo get_phrase('patient'); ?></center>
			</div>
		</div>
	</div>
	<!-- INCOME-EXPENSE COMPARISON CHART -->
	<div class="col-sm-6">
		<div class="panel panel-primary" id="charts_env">
			<div class="panel-heading">
				<div class="panel-title">
					<i class="entypo-chart-bar"></i>
					Income Expense Comparison (monthly)
				</div>
			</div>
			<div class="panel-body">
				<div id="bar_IncomeExpensechartdiv"></div>
				<center>Incomes & Expenses</center>
			</div>
		</div>
	</div>


</div>
<div class="row">

	<!-- Queue Mangement Panel -->
	<div class="col-sm-6">
        <div class="panel panel-primary" id="charts_env">
			<div class="panel-heading">
				<div class="panel-title">
					<i class="entypo-chart-pie"></i>
					Queue Management
				</div>

			</div>
			<div class="panel-body">
				<div id="queuemngpanel">
                    <?php 
                        $queue_list = $this->crud_model->get_alarm_list(); 
                        if(count($queue_list)==0){ ?>
                    <div> No data display. </div>         
                    <?php } else{ ?>
                        <ul class="queue">
                            <?php foreach ($queue_list["alarm_list"] as $row): ?>
                            <li class="queue-list">
                                <a href="<?php echo $row['url']?>">
                                        <strong><?php echo $row["message"]." - ". $row["count"]; ?></strong>
                                </a>
                                <ul class="sub-queue">
                                    <?php foreach($row["desc_list"] as $descitem) { ?>
                                        <li class="sub-queue-list">
                                            <a href="<?php echo $row['url']."/".((isset($descitem["suburl"])&&$descitem["suburl"]!="")?$descitem["suburl"]:'edit')."/".$descitem["id"]?>">
                                                        <?php
                                                        echo $descitem["desc"]."</a>";
                                                        if ($descitem['date']!="")
                                                            echo "<span class='date'>(".$descitem['date'].")</span>";
                                                        ?>
                                            
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php } ?>
                        
                    
                </div>
			</div>
		</div>
	</div>

	<!-- EVENT CALENDAR OF CURRENT MONTH -->
	<div class="col-sm-6">
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
    <script type="text/javascript">
        $(document).ready(function(){
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
</div>
<div class="row">
    <div class="col-sm-3">
        <a href="<?php echo base_url(); ?>index.php?admin/doctor">
            <div class="tile-stats tile-white tile-white-primary">
                <div class="icon"><i class="fa fa-user-md"></i></div>
                <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('doctor'); ?>"
                     data-duration="1500" data-delay="0">0 </div>
                <h3><?php echo get_phrase('doctor') ?></h3>
            </div>
        </a>
    </div>

    <div class="col-sm-3">
        <a href="<?php echo base_url(); ?>index.php?admin/patient">
            <div class="tile-stats tile-white-red">
                <div class="icon"><i class="fa fa-user"></i></div>
                <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('patient'); ?>" 
                     data-duration="1500" data-delay="0">0 </div>
                <h3><?php echo get_phrase('patient') ?></h3>
            </div>
        </a>
    </div>

    <div class="col-sm-3">
        <a href="<?php echo base_url(); ?>index.php?admin/nurse">
            <div class="tile-stats tile-white-aqua">
                <div class="icon"><i class="fa fa-plus-square"></i></div>
                <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('nurse'); ?>" 
                     data-duration="1500" data-delay="0">0 </div>
                <h3><?php echo get_phrase('nurse') ?></h3>
            </div>
        </a>
    </div>

    <div class="col-sm-3">
        <a href="<?php echo base_url(); ?>index.php?admin/pharmacist">
            <div class="tile-stats tile-white-blue">
                <div class="icon"><i class="fa fa-medkit"></i></div>
                <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('pharmacist'); ?>" 
                     data-duration="1500" data-delay="0">0</div>
                <h3><?php echo get_phrase('pharmacist') ?></h3>
            </div>
        </a>
    </div>
</div>

<br />

<div class="row">
    <div class="col-sm-3">
        <a href="<?php echo base_url(); ?>index.php?admin/laboratorist">
            <div class="tile-stats tile-white-cyan">
                <div class="icon"><i class="fa fa-user"></i></div>
                <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('laboratorist'); ?>" 
                     data-duration="1500" data-delay="0">0 </div>
                <h3><?php echo get_phrase('laboratorist') ?></h3>
            </div>
        </a>
    </div>

    <div class="col-sm-3">
        <a href="<?php echo base_url(); ?>index.php?admin/accountant">
            <div class="tile-stats tile-white-purple">
                <div class="icon"><i class="fa fa-money"></i></div>
                <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('accountant'); ?>" 
                     data-duration="1500" data-delay="0">0 </div>
                <h3><?php echo get_phrase('accountant') ?></h3>
            </div>
        </a>
    </div>

    <div class="col-sm-3">
     <!--   <a href="<?php echo base_url(); ?>index.php?admin/payment_history">-->
            <div class="tile-stats tile-white-pink">
                <div class="icon"><i class="fa fa-list-alt"></i></div>
                <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('sales'); ?>" 
                     data-duration="1500" data-delay="0">0</div>
                <h3><?php echo get_phrase('payment') ?></h3>
            </div>
     <!--   </a>-->
    </div>

    <div class="col-sm-3">
     <!--   <a href="<?php echo base_url(); ?>index.php?admin/medicine">-->
            <div class="tile-stats tile-white-orange">
                <div class="icon"><i class="fa fa-medkit"></i></div>
                <div class="num" data-start="0" data-end="<?php 
                    $med = $this->db->get_where("items",array("Category"=>"PHARMACEUTICALS","Type"=>"GOOD"));
                    echo $med->num_rows(); 
                ?>" 
                     data-duration="1500" data-delay="0">0</div>
                <h3><?php echo get_phrase('medicine') ?></h3>
            </div>
      <!--  </a> -->
    </div>
</div>

<br />

<div class="row">
    <div class="col-sm-3">
        <a href="<?php echo base_url(); ?>index.php?admin/operation_report">
            <div class="tile-stats tile-white-green">
                <div class="icon"><i class="fa fa-wheelchair"></i></div>
                <div class="num" data-start="0" data-end="<?php echo count($this->db->get_where('report', array('type' => 'operation'))->result_array());?>" 
                     data-duration="1500" data-delay="0"></div>
                <h3><?php echo get_phrase('operation_report') ?></h3>
            </div>
        </a>
    </div>

    <div class="col-sm-3">
        <a href="<?php echo base_url(); ?>index.php?admin/birth_report">
            <div class="tile-stats tile-white-brown">
                <div class="icon"><i class="fa fa-github-alt"></i></div>
                <div class="num" data-start="0" data-end="<?php echo count($this->db->get_where('report', array('type' => 'birth'))->result_array());?>" 
                     data-duration="1500" data-delay="0"></div>
                <h3><?php echo get_phrase('birth_report') ?></h3>
            </div>
        </a>
    </div>

    <div class="col-sm-3">
        <a href="<?php echo base_url(); ?>index.php?admin/death_report">
            <div class="tile-stats tile-white-plum">
                <div class="icon"><i class="fa fa-ban"></i></div>
                <div class="num" data-start="0" data-end="<?php echo count($this->db->get_where('report', array('type' => 'death'))->result_array());?>" 
                     data-duration="1500" data-delay="0"></div>
                <h3><?php echo get_phrase('death_report') ?></h3>
            </div>
        </a>
    </div>

    <div class="col-sm-3">
        <a href="<?php echo base_url(); ?>index.php?admin/system_settings">
            <div class="tile-stats tile-white-gray">
                <div class="icon"><i class="fa fa-h-square"></i></div>
      <!--          <div class="num">&nbsp;</div>-->
                <h3><?php echo get_phrase('settings') ?></h3>
            </div>
        </a>
    </div>
</div>