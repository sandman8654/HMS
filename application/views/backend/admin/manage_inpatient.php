<a href="<?php echo base_url();?>index.php?admin/patient/register" 
    class="btn btn-primary pull-right">
        <?php echo get_phrase('add_patient'); ?>
</a>
<div style="clear:both;"></div>
<br>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th><?php echo get_phrase('image');?></th>
            <th><?php echo get_phrase('name');?></th>
            <th><?php echo get_phrase('email');?></th>
            <th><?php echo get_phrase('phone');?></th>
            <th><?php echo get_phrase('sex');?></th>
            <th><?php echo get_phrase('birth_date');?></th>
            <th><?php echo get_phrase('blood_group');?></th>
            <th><?php echo get_phrase('register_date');?></th>
            <th><?php echo get_phrase('bed_allotment');?></th>
            <th><?php echo get_phrase('options');?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($patient_info as $row) { ?>   
            <tr>
                <td><img src="<?php echo $this->crud_model->get_image_url('patient' , $row['patient_id']);?>" class="img-circle" width="40px" height="40px">
                <?php if ($row['status']==0){ ?>
                <div class="patient-new-badge">new</div>
                <?php } ?>
                </td>
                <td><?php echo $row['name']?></td>
                <td><?php echo $row['email']?></td>
                <td><?php echo $row['phone']?></td>
                <td><?php echo $row['sex']?></td>
                <td><?php echo date('m/d/Y', $row['birth_date']); ?></td>
                <td><?php echo $row['blood_group']?></td>
                <td><?php echo date('m/d/Y', $row['registered_date']); ?></td>
                <td>
                    <?php 
                        if ($this->session->userdata('admin_login')==1 ){
                            $list= $this->db->get_where("bed_allotment",array("patient_id"=>$row["patient_id"]));
                            if($list->num_rows()==0){ ?>
                                <a  onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/add_bed_allotment/<?php echo $row["patient_id"]?>');" 
                                    class="btn btn-danger btn-sm">
                                        <?php echo get_phrase('add_bed'); ?>
                                </a>
                        <?php   }else{ ?>
                                <a  onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/edit_bed_allotment/<?php echo $list->row()->bed_allotment_id; ?>');" 
                                    class="btn btn-success btn-sm ">
                                        Edit Bed
                                </a>
                    <?php    } }
                    ?>
                </td>
                <td>
                    <a  href="<?php echo base_url();?>index.php?admin/inpatients/edit/<?php echo $row['patient_id']?>" 
                        class="btn btn-default btn-sm btn-icon icon-left">
                            <i class="entypo-pencil"></i>
                            Edit Info
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script type="text/javascript">
    jQuery(window).load(function ()
    {
        var $ = jQuery;

        $("#table-2").dataTable({
            "sPaginationType": "bootstrap",
            aaSorting:[[9,"desc"]],
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
</script>