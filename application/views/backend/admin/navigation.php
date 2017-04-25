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


    <div style="border-top:1px solid #03bdb0;"></div>	
    <ul id="main-menu" class="">
        <!-- add class "multiple-expanded" to allow multiple submenus to open -->
        <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->


        <!-- DASHBOARD -->
        <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/dashboard">
                <i class="fa fa-desktop"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>
        
        <li class="<?php if ($page_name == 'manage_department') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/department">
                <i class="fa fa-sitemap"></i>
                <span><?php echo get_phrase('department'); ?></span>
            </a>
        </li>
        
        <li class="<?php if ($page_name == 'manage_doctor') echo 'active'; ?>">
            <a href="<?php echo base_url(); ?>index.php?admin/doctor">
                <i class="fa fa-user-md"></i>
                <span><?php echo get_phrase('doctor'); ?></span>
            </a>
        </li>

        <li class="<?php if ($page_name == 'edit_reception') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/reception/register">
                <i class="fa fa-th-list"></i>
                <span><?php echo get_phrase('add_reception'); ?></span>
            </a>
        </li>
        <li class="<?php if ($page_name == 'add_patient') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/patient/register">
                <i class="fa fa-user-plus"></i>
                <span><?php echo get_phrase('add_patient'); ?></span>
            </a>
        </li>
        
        <li class="<?php if ($page_name == 'manage_nurse') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/nurse">
                <i class="fa fa-plus-square"></i>
                <span><?php echo get_phrase('nurse'); ?></span>
            </a>
        </li>
        
        <li class="<?php if ($page_name == 'manage_pharmacist') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/pharmacist">
                <i class="fa fa-medkit"></i>
                <span><?php echo get_phrase('pharmacist'); ?></span>
            </a>
        </li>
        
        <li class="<?php if ($page_name == 'manage_laboratorist') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/laboratorist">
                <i class="fa fa-user"></i>
                <span><?php echo get_phrase('laboratorist'); ?></span>
            </a>
        </li>
        
        <li class="<?php if ($page_name == 'manage_accountant') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/accountant">
                <i class="fa fa-money"></i>
                <span><?php echo get_phrase('accountant'); ?></span>
            </a>
        </li>
        
        <li class="<?php if ($page_name == 'manage_receptionist') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/receptionist">
                <i class="fa fa-plus-square"></i>
                <span><?php echo get_phrase('receptionist'); ?></span>
            </a>
        </li>
        
        <li class="<?php if ($page_name == 'show_payment_history'   || $page_name == 'show_bed_allotment'
                            || $page_name == 'show_blood_bank'      || $page_name == 'show_blood_donor'
                            || $page_name == 'show_medicine'        || $page_name == 'show_operation_report' 
                            || $page_name == 'show_birth_report'    || $page_name == 'show_death_report') 
                        echo 'opened active';?> ">
            <a href="#">
                <i class="entypo-target"></i>
                <span><?php echo get_phrase('monitor_hospital'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'show_payment_history') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/payment_history">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('payment_history'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'show_bed_allotment') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/bed_allotment">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('bed_allotment'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'show_blood_bank') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/blood_bank">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('blood_bank'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'show_blood_donor') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/blood_donor">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('blood_donor'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'show_medicine') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/medicine">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('medicine'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'show_operation_report') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/operation_report">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('operation_report'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'show_birth_report') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/birth_report">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('birth_report'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'show_death_report') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/death_report">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('death_report'); ?></span>
                    </a>
                </li>
            </ul>
        </li>
        
        <li class="<?php
            if ($page_name == 'payroll_add' || $page_name == 'payroll_add_view'
                || $page_name == 'payroll_list')
                echo 'opened active has-sub'; ?>">
            <a href="#">
                <i class="entypo-tag"></i>
                <span><?php echo get_phrase('payroll'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'payroll_add' || $page_name == 'payroll_add_view') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/payroll">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('create_payroll'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'payroll_list') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/payroll_list">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('payroll_list'); ?></span>
                    </a>
                </li>
            </ul>
        </li>
        
        <li class="<?php if ($page_name == 'manage_notice') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/notice">
                <i class="entypo-doc-text-inv"></i>
                <span><?php echo get_phrase('noticeboard'); ?></span>
            </a>
        </li>

        <!-- SETTINGS -->
        <li class="<?php if ($page_name == 'system_settings' || $page_name == 'manage_language' ||
                            $page_name == 'sms_settings') echo 'opened active';?> ">
            <a href="#">
                <i class="fa fa-wrench"></i>
                <span><?php echo get_phrase('settings'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'system_settings') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/system_settings">
                        <span><i class="fa fa-h-square"></i> <?php echo get_phrase('system_settings'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_language') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/manage_language">
                        <span><i class="fa fa-globe"></i> <?php echo get_phrase('language_settings'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'sms_settings') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/sms_settings">
                        <span><i class="entypo-paper-plane"></i> <?php echo get_phrase('sms_settings'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- ACCOUNT -->
        <li class="<?php if ($page_name == 'manage_profile') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/manage_profile">
                <i class="entypo-lock"></i>
                <span><?php echo get_phrase('account'); ?></span>
            </a>
        </li>



    </ul>

</div>