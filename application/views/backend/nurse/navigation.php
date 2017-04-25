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
            <a href="<?php echo base_url(); ?>index.php?nurse">
                <i class="fa fa-desktop"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>
        
        <li class="<?php if ($page_name == 'manage_patient') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?nurse/patient">
                <i class="fa fa-user"></i>
                <span><?php echo get_phrase('patient'); ?></span>
            </a>
        </li>
        
        <li class="<?php if ($page_name == 'manage_bed' || $page_name == 'manage_bed_allotment') echo 'opened active has-sub'; ?> ">
            <a href="#">
                <i class="fa fa-hdd-o"></i>
                <span><?php echo get_phrase('bed_/_ward'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'manage_bed') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>index.php?nurse/bed">
                        <i class="fa fa-hdd-o"></i>
                        <span><?php echo get_phrase('manage_bed'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_bed_allotment') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>index.php?nurse/bed_allotment">
                        <i class="fa fa-wrench"></i>
                        <span><?php echo get_phrase('bed_allotment'); ?></span>
                    </a>
                </li>
            </ul>
        </li>
        
        <li class="<?php if ($page_name == 'manage_blood_bank' || $page_name == 'manage_blood_donor') echo 'opened active has-sub'; ?> ">
            <a href="#">
                <i class="fa fa-tint"></i>
                <span><?php echo get_phrase('blood_bank'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'manage_blood_bank') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>index.php?nurse/blood_bank">
                        <i class="fa fa-tint"></i>
                        <span><?php echo get_phrase('manage_blood_bank'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_blood_donor') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>index.php?nurse/blood_donor">
                        <i class="fa fa-user"></i>
                        <span><?php echo get_phrase('blood_donor'); ?></span>
                    </a>
                </li>
            </ul>
        </li>
        
        <li class="<?php if ($page_name == 'manage_report') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?nurse/report">
                <i class="fa fa-hospital-o"></i>
                <span><?php echo get_phrase('report'); ?></span>
            </a>
        </li>

        <!-- PAYROLL -->
        <li class="<?php if ($page_name == 'payroll_list') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/payroll_list">
                <span><i class="entypo-tag"></i> <?php echo get_phrase('payroll'); ?></span>
            </a>
        </li>
        
        <li class="<?php if ($page_name == 'edit_profile') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?nurse/manage_profile">
                <i class="entypo-lock"></i>
                <span><?php echo get_phrase('profile'); ?></span>
            </a>
        </li>

    </ul>

</div>