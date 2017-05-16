<div class="row">
    <div class="col-sm-12 col-md-8 col-md-offset-2">
        <h4 class="add-patient-sub-title pull-left"><?php echo get_phrase('laboratory_summary');?></h4>
        <div class="pull-right" >
            <a href="<?php echo base_url()."index.php?admin/$patient_type";?>" class="btn btn-danger btn-md">Exit</a>
        </div>
        <div style="clear:both"></div>
        <div class="col-md-12 " id="lab_summary_editor" style="height:465px; margin-left:15px;overflow:auto">
            <?php
                $arr_req = $this->db->get_where("lab_request",array("patient_id"=>$patient_id))->result_array();
                if (count($arr_req)==0){
                    echo "No data display.";
                }else{
                    $arr_status = array("Pending","Process","Complete");
                    foreach($arr_req as $req){
                        $icode = $req["itemcode"];
                        $iname = $this->db->get_where("items",array("ItemCode"=>$icode))->result_array()[0]["ItemName"];
                        $time = date("Y-m-d H:i:s",$req["end_time"]);
                        $status = $req["status"];
                        echo "<a href='".base_url()."index.php?admin/labreq/edit/".$req["id"]."'>";
                        echo "Date : ".$time."<br/><br/>";
                        echo "Lab Request - [".$arr_status[$status]."]<br/>";
                        echo $iname."<br/><br/>";
                        echo "Lab Result"."<br/>";
                        $result = $this->db->get_where("lab_result",array("req_id"=>$req["id"]))->row()->result;
                        echo $result;
                        echo "</a>";
                        echo "<br/><hr/>";
                    }
                }
            ?>
        </div>
    </div>
</div>