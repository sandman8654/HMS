<div class="sidebar-menu">
    <header class="logo-env" >

        <!-- logo -->
        <div class="logo" style="">
            <a href="<?php echo base_url(); ?>">
                <img src="assets/images/logo.png"  style="max-height:60px;"/>
            </a>
        </div>

        <!-- logo collapse icon -->
        <div class="sidebar-collapse" style="">
            <a href="#" class="sidebar-collapse-icon with-animation">

                <i class="entypo-menu"></i>
            </a>
        </div>

        <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
        <div class="sidebar-mobile-menu visible-xs">
            <a href="#" class="with-animation">
                <i class="entypo-menu"></i>
            </a>
        </div>
    </header>
    <div class="sidebar-user-info">

        <div class="sui-normal">
            <a href="#" class="user-link">
                <img src="<?php echo $this->crud_model->get_image_url($this->session->userdata('login_type'), $this->session->userdata('login_user_id'));?>" alt="" class="img-circle" style="height:44px;">

                <span><?php echo get_phrase('welcome'); ?>,</span>
                <strong><?php
                    echo $this->db->get_where($this->session->userdata('login_type'), array($this->session->userdata('login_type') . '_id' =>
                        $this->session->userdata('login_user_id')))->row()->name;
                    ?>
                </strong>
            </a>
        </div>

        <div class="sui-hover inline-links animate-in"><!-- You can remove "inline-links" class to make links appear vertically, class "animate-in" will make A elements animateable when click on user profile -->				
            <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/manage_profile">
                <i class="entypo-pencil"></i>
                <?php echo get_phrase('edit_profile'); ?>
            </a>

            <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/manage_profile">
                <i class="entypo-lock"></i>
                <?php echo get_phrase('change_password'); ?>
            </a>

            <span class="close-sui-popup">×</span><!-- this is mandatory -->			
        </div>
    </div>


    <div style="border-top:1px solid rgba(69, 74, 84, 0.7);"></div>	
    <ul id="main-menu" class="">
        <!-- add class "multiple-expanded" to allow multiple submenus to open -->
        <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->

        <!-- DASHBOARD -->
        <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?patient">
                <i class="fa fa-desktop"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>
        
        <li class="<?php if ($page_name == 'show_appointment' || $page_name == 'show_pending_appointment')
            echo 'opened active'; ?> ">
                <a href="#">
                    <i class="fa fa-edit"></i>
                    <span><?php echo get_phrase('appointment'); ?></span>
                </a>
                <ul>
                    <li class="<?php if ($page_name == 'show_appointment') echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>index.php?patient/appointment">
                            <i class="entypo-dot"></i>
                            <span><?php echo get_phrase('appointment_list'); ?></span>
                        </a>
                    </li>
                    <li class="<?php if ($page_name == 'show_pending_appointment') echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>index.php?patient/appointment_pending">
                            <i class="entypo-dot"></i>
                            <span><?php echo get_phrase('pending_appointments'); ?></span>
                        </a>
                    </li>
                </ul>
        </li>
        
        <li class="<?php if ($page_name == 'show_all_prescription') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?patient/prescription">
                <i class="fa fa-stethoscope"></i>
                <span><?php echo get_phrase('prescription'); ?></span>
            </a>
        </li>
        
        <li class="<?php if ($page_name == 'show_doctor') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?patient/doctor">
                <i class="fa fa-user-md"></i>
                <span><?php echo get_phrase('doctor'); ?></span>
            </a>
        </li>
        
        <li class="<?php if ($page_name == 'show_blood_bank') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?patient/blood_bank">
                <i class="fa fa-tint"></i>
                <span><?php echo get_phrase('blood_bank'); ?></span>
            </a>
        </li>
        
        <li class="<?php if ($page_name == 'show_admit_history') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?patient/admit_history">
                <i class="fa fa-hdd-o"></i>
                <span><?php echo get_phrase('admit_history'); ?></span>
            </a>
        </li>
        
        <li class="<?php if ($page_name == 'show_operation_history') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?patient/operation_history">
                <i class="fa fa-hospital-o"></i>
                <span><?php echo get_phrase('operation_history'); ?></span>
            </a>
        </li>
        
        <li class="<?php if ($page_name == 'show_all_invoice') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?patient/invoice">
                <i class="fa fa-credit-card"></i>
                <span><?php echo get_phrase('invoice'); ?></span>
            </a>
        </li>
        
        <!-- MESSAGE -->
        <li class="<?php if ($page_name == 'message') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?patient/message">
                <i class="entypo-mail"></i>
                <span><?php echo get_phrase('message'); ?></span>
            </a>
        </li>
        
        <li class="<?php if ($page_name == 'edit_profile') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?patient/manage_profile">
                <i class="entypo-lock"></i>
                <span><?php echo get_phrase('profile'); ?></span>
            </a>
        </li>

    </ul>

</div>