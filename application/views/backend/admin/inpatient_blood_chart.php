<?php
    $bp_list = $this->db->get_where("inpatient_measure_blood_press",array("patient_id"=>$patient_id))->result_array();
?>
<div class="row">
            
    <div class="col-sm-12" >
        <form role="form" class="form-horizontal form-groups-bordered" >
            <h4 class="add-patient-sub-title pull-left"><?php echo get_phrase('boold_press_chart');?></h4>
            <div class="pull-right" style="margin-bottom:5px;margin-right:30px;">
                <a href="<?php echo base_url()."index.php?admin/$patient_type";?>" class="btn btn-danger btn-md">Exit</a>
            </div>
            <div style="clear:both; margin-bottom:10px"></div>
            <input type="radio" name="bpview" value="0" checked style="margin-left:10px; margin-right:10px">Table View</view>
            <input type="radio" name="bpview" value="1" style="margin-left:10px; margin-right:10px">Chart View</view>
            <div style="margin-bottom:10px"></div>
            
            <div class="col-sm-12 col-md-12" id="table-bp-div">
                <a onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/add_inpatient_blood_chart/<?php echo $patient_id?>');" 
                    class="btn btn-primary " >
                        <?php echo get_phrase('add_data'); ?>
                </a>
               <div style="clear:both;"></div>
                <br>
                <table class="table table-bordered table-striped datatable" id="table-bp">
                    
                    <thead>
                        <tr>
                            <th><?php echo get_phrase('date');?></th>
                            <th><?php echo get_phrase('time');?></th>
                            <th><?php echo get_phrase('bp');?></th>
                            <th><?php echo get_phrase('done_by');?></th>
                            <th><?php echo get_phrase('Options');?></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach($bp_list as $item){ ?>
                            <tr>
                                <td><?php echo $item['date'];?></td>
                                <td><?php echo $item['time'];?></td>
                                <td><?php echo $item['bp'];?></td>
                                <td><?php 
                                    $actype = $item["doneby_account_type"];
                                    $acid = $item["doneby_account_id"];
                                    $doneby_name = $this->db->get_where($actype,array($actype."_id",$acid))->row()->name;
                                    echo $doneby_name;
                                ?></td>
                                <td>
                                    <a  onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/edit_inpatient_blood_chart/<?php echo $item["id"]; ?>');" 
                                        class="btn btn-default btn-sm btn-icon icon-left">
                                            <i class="entypo-pencil"></i>
                                            <?php echo get_phrase('edit'); ?>

                                    </a>
                                    <a  href="<?php echo base_url();?>index.php?admin/inpatients/delete/<?php echo $item["id"].'/bloodchart'; ?>" 
                                        class="btn btn-danger btn-sm btn-icon icon-left" onclick="return checkDelete();" >
                                            <i class="entypo-cancel"></i>
                                            <?php echo get_phrase('delete'); ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
             <div class="col-sm-12 hidden" id="bp-chart" style="height: 500px;">
        
             </div>
        </form>
    </div>
   
</div>
<script type="text/javascript">
//bp tab process
    jQuery(window).load(function ()
    {
        var $ = jQuery;
        $("#table-bp").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Highlighted rows
        $("#table-bp tbody input[type=checkbox]").each(function (i, el)
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
        
        $("input[name='bpview']").on("click",function(){
            if ($(this).val()=="1"){
                $("#bp-chart").removeClass("hidden");
                $("#table-bp-div").addClass("hidden");
            }else{
                $("#table-bp-div").removeClass("hidden");
                $("#bp-chart").addClass("hidden");
            }
               
        });
    });

</script>

<script>
    var bpchart = AmCharts.makeChart("bp-chart", {
    "type": "serial",
    "theme": "light",
    "marginRight": 40,
    "marginLeft": 40,
    "autoMarginOffset": 20,
    "mouseWheelZoomEnabled":true,
    "dataDateFormat": "YYYY-MM-DD HH:NN",
    "valueAxes": [{
        "id": "v1",
        "axisAlpha": 0,
        "position": "left",
        "maximum":280,
        "minimum":0,
        "ignoreAxisWidth":true
    }],
    "balloon": {
        "borderThickness": 1,
        "shadowAlpha": 0
    },
    "graphs": [{
        "id": "g1",
        "balloon":{
          "drop":true,
          "adjustBorderColor":false,
          "color":"#ffffff"
        },
        "bullet": "round",
        "bulletBorderAlpha": 1,
        "bulletColor": "#FFFFFF",
        "bulletSize": 5,
        "hideBulletsCount": 50,
        "lineThickness": 2,
        "title": "red line",
        "useLineColorForBulletBorder": true,
        "valueField": "value",
        "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
    }],
    "chartScrollbar": {
        "graph": "g1",
        "oppositeAxis":false,
        "offset":30,
        "scrollbarHeight": 80,
        "backgroundAlpha": 0,
        "selectedBackgroundAlpha": 0.1,
        "selectedBackgroundColor": "#888888",
        "graphFillAlpha": 0,
        "graphLineAlpha": 0.5,
        "selectedGraphFillAlpha": 0,
        "selectedGraphLineAlpha": 1,
        "autoGridCount":true,
        "color":"#AAAAAA"
    },
    "chartCursor": {
        "pan": true,
        "valueLineEnabled": true,
        "valueLineBalloonEnabled": true,
        "cursorAlpha":1,
        "cursorColor":"#258cbb",
        "limitToGraph":"g1",
        "valueLineAlpha":0.2,
        "categoryBalloonDateFormat": "MMM DD, YYYY HH:NN" ,
        "valueZoomable":true
    },
    "valueScrollbar":{
      "oppositeAxis":false,
      "offset":50,
      "scrollbarHeight":10
    },
    "categoryField": "date",
    "categoryAxis": {
        "parseDates": true,
        "dashLength": 1,
        "minorGridEnabled": true,
        "minPeriod":"mm",
        "autoGridCount":false,
        "gridCount":30,
        
    },
    "export": {
        "enabled": true
    },
    "dataProvider": [<?php 
        $this->db->order_by("date","asc");
        $this->db->order_by("time","asc");
        $list = $this->db->get_where("inpatient_measure_blood_press", array("patient_id"=>$patient_id))->result_array();
        foreach ($list as $row){
            $stamp = $row["date"]." ".$row["time"];
            $bp = $row["bp"];
            echo "{'date':'$stamp','value':$bp},";
        }
    ?>] 
});

bpchart.addListener("rendered", bpzoomChart);

bpzoomChart();

function bpzoomChart() {
    bpchart.zoomToIndexes(bpchart.dataProvider.length - 40, bpchart.dataProvider.length - 1);
}
</script>