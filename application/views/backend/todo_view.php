<?php 
    $this->db->order_by("todo_order");
    $todo_list = $this->db->get("todo_list")->result_array();
?>
<div id="chat" class="fixed" style="min-height: 932px;">

    <div class="chat-inner" tabindex="5000" style="overflow: hidden; outline: none;">
        <h2 style="color: #EFF3F4;font-weight: 100;text-align: center; margin-top:42px;">
            <?php 
                $now = date("D <br> S F, Y"); 
                echo date("l")."<br/>";
                echo date("jS F, Y");
            ?> </h2>
        <h3 style="color: #fff;background-color:rgba(35, 154, 146, 0.69);font-size: 12px;padding: 5px; font-weight:200;">

            <i class="entypo-list"></i>
            To do list
        </h3>
        
        <div class="row">
            <div class="col-md-12">
                <form action="<?php echo base_url(); ?>index.php?admin/todo/add" class="form-horizontal form-groups validate todo-add" enctype="multipart/form-data" method="post" accept-charset="utf-8" novalidate="novalidate">
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-1">
                            <input class="form-control" type="text" name="title" id="title" placeholder="+ Add todo list" style="background-color: #fff;border: 1px solid #03bdb0 ;color: #2f2f2f; " data-validate="required" autofocus="">
                        </div>
                        <input type="submit" value="" class="btn btn-primary btn-xs" style="width:0px; height:0px;display:none;">
                    </div>
                    <table style="width: 83%;margin-left: 22px;">
                        <tbody>
                            <?php foreach($todo_list as $item){
                                $id = $item["id"];
                                $name = $item["todo_name"];
                                $status = $item["status"];
                                
                                ?>
                            <tr> 
                            <td>
                                <li id="todo_<?php echo $id;?>" style="font-size: 13px;color: #fff;<?php if ($status==1) echo 'text-decoration: line-through;'; ?>;"><?php echo $name;?></li>
                            </td>
                            <td style="text-align:right;">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle " data-toggle="dropdown" style="padding:0px;background-color: #03bdb0;border: 0px;-ms-transform: rotate(90deg);-webkit-transform: rotate(90deg); /* Chrome, Safari, Opera */transform: rotate(90deg);">
                                        <i class="entypo-dot-2" style="color:#efefef;"></i> 
                                        <span class="" style="visibility:hidden; width:0px;"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu" style="text-align:left;">
                                        <li>
                                        
                                            <?php if ($status ==0) { ?>
                                                <a href="#" onclick="mark_as_done('<?php echo $id;?>');">
                                                    <i class="entypo-check"></i>
                                                    Mark Completed</a> <?php }else{ ?>
                                                <a href="#" onclick="mark_as_undone('<?php echo $id;?>');">
                                                    <i class="entypo-cancel"></i>
                                                    Mark incompleted</a> <?php } ?>
                                        </li>
                                        <li>
                                            <a href="#" onclick="swap('up', '<?php echo $id;?>')">
                                                <i class="entypo-up"></i>
                                                Move Up</a>
                                            <a href="#" onclick="swap('down', '<?php echo $id;?>')">
                                                <i class="entypo-down"></i>
                                                Move Down</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="#" onclick="delete_todo('<?php echo $id;?>');">
                                                <i class="entypo-trash"></i>
                                                Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="baseurl" data-url="<?php echo base_url(); ?>"></div>
<script>
    
    // Custom functions for todo starts here.
    jQuery(document).ready(function ($){
        var options = {
            beforeSubmit: validate_todo_add,
            success: show_response_todo_add,
            resetForm: true
        };
        $('.todo-add').submit(function () {
            $(this).ajaxSubmit(options);
            return false;
        });
    });
    var baseurl = $("#baseurl").data("url");
    
    function validate_todo_add(formData, jqForm, options) {
        if (!jqForm[0].title.value)
        {
            return false;
        }
    }

    function show_response_todo_add(responseText, statusText, xhr, $form) {
        reload_todo_body();
    }

    function reload_todo_body()
    {

        $.ajax({
            url: baseurl+'index.php?admin/todo/reload/',
            success: function (response)
            {
                jQuery('.todo_data').html(response);
            }
        });

        $.ajax({
            url: baseurl+'index.php?admin/todo/reload_incomplete_todo/',
            success: function (response)
            {
                jQuery('#incomplete_todo_number').html(response);
            }
        });

    }
    
    function mark_as_done(todo_id)
    {
        $.ajax({
            url: baseurl+'index.php?admin/todo/mark_as_done/'+todo_id,
            success: function ()
            {
                reload_todo_body();
            }
        });
    }
    
    function mark_as_undone(todo_id)
    {
        $.ajax({
            url: baseurl+'index.php?admin/todo/mark_as_undone/'+todo_id,
            success: function ()
            {
                reload_todo_body();
            }
        });
    }
    
    function delete_todo(todo_id)
    {
        $.ajax({
            url: baseurl+'index.php?admin/todo/delete/'+todo_id,
            success: function ()
            {
                reload_todo_body();
            }
        });
    }
    
    function swap(swap_with, todo_id)
    {
        $.ajax({
            url: baseurl+'index.php?admin/todo/swap/'+todo_id+'/'+swap_with,
            success: function ()
            {
                reload_todo_body();
            }
        });
    }
    // Custom functions for todo ends here.
</script>  
