<div class="row">
    <div class="col-sm-12 col-md-8 col-md-offset-2">
        <h4 class="add-patient-sub-title pull-left"><?php echo get_phrase('radiology_summary');?></h4>
        <div class="pull-right" >
            <a href="<?php echo base_url()."index.php?admin/$patient_type";?>" class="btn btn-danger btn-md">Exit</a>
        </div>
        <div style="clear:both"></div>
        <div class="col-md-12 " id="lab_summary_editor" style="height:465px; margin-left:15px;overflow:auto">
            <?php
                $arr_req = $this->db->get_where("rad_request",array("patient_id"=>$patient_id))->result_array();
                if (count($arr_req)==0){
                    echo "No data display.";
                }else{
                    $arr_status = array("Pending","Process","Complete");
                    foreach($arr_req as $row){
                        $icode = $row["itemcode"];
                        $iname = $this->db->get_where("items",array("ItemCode"=>$icode))->result_array()[0]["ItemName"];
                        $time = date("Y-m-d",$row["end_time"]);
                        $status = $row["status"];
                        echo "<a href='".base_url()."index.php?admin/radreq/register/".$row["id"]."'>";
                        echo "Date : ".$time."<hr/>";
                        echo "Rad Request - [".$arr_status[$status]."]<br/>";
                        echo $iname."<hr/>";
                        echo "Rad Result"."<br/>";
                        echo $row["rad_result"]."<br/>";
                        echo "</a><br/><br/>";
                    }
                }
            ?>
        </div>
    </div>
</div>