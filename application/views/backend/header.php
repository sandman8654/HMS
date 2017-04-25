<div class="row">
    <div class="col-md-12 col-sm-12 clearfix" style="text-align:center; margin-bottom:20px">
        <h2 style="font-weight:200; margin:0px; color:#03bdb0"><?php echo $system_name; ?></h2>
    </div>

    <!-- Navigation Menu -->
    <div class="col-md-12 col-sm-12 clearfix ">
        <div class="col-md-2 col-sm-2  pull-left">
            <ul class="list-inline links-list pull-left">
                <!-- Message Notifications -->
                <?php if($this->session->userdata('login_type') == 'doctor' || $this->session->userdata('login_type') == 'patient') { ?>
                <li class="notifications dropdown">
                    <?php
                    $total_unread_message_number = 0;
                    $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');

                    $this->db->where('sender', $current_user);
                    $this->db->or_where('reciever', $current_user);
                    $message_threads = $this->db->get('message_thread')->result_array();
                    foreach ($message_threads as $row) {
                        $unread_message_number = $this->crud_model->count_unread_message_of_thread($row['message_thread_code']);
                        $total_unread_message_number += $unread_message_number;
                    }
                    ?>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <i class="entypo-mail"></i>
                        <?php if ($total_unread_message_number > 0): ?>
                            <span class="badge badge-info"><?php echo $total_unread_message_number; ?></span>
                        <?php endif; ?>
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <ul class="dropdown-menu-list scroller">


                                <?php
                                $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
                                $this->db->where('sender', $current_user);
                                $this->db->or_where('reciever', $current_user);
                                $message_threads = $this->db->get('message_thread')->result_array();
                                foreach ($message_threads as $row):

                                    // defining the user to show
                                    if ($row['sender'] == $current_user)
                                        $user_to_show = explode('-', $row['reciever']);
                                    if ($row['reciever'] == $current_user)
                                        $user_to_show = explode('-', $row['sender']);
                                    $user_to_show_type = $user_to_show[0];
                                    $user_to_show_id = $user_to_show[1];
                                    $unread_message_number = $this->crud_model->count_unread_message_of_thread($row['message_thread_code']);
                                    if ($unread_message_number == 0)
                                        continue;

                                    // the last sent message from the opponent user
                                    $this->db->order_by('timestamp', 'desc');
                                    $last_message_row = $this->db->get_where('message', array('message_thread_code' => $row['message_thread_code']))->row();
                                    $last_unread_message = $last_message_row->message;
                                    $last_message_timestamp = $last_message_row->timestamp;
                                    ?>
                                    <li class="active">
                                        <a href="<?php echo base_url(); ?>index.php?<?php echo $this->session->userdata('login_type'); ?>/message/message_read/<?php echo $row['message_thread_code']; ?>">
                                            <span class="image pull-right">
                                                <img src="<?php echo $this->crud_model->get_image_url($user_to_show_type, $user_to_show_id); ?>" height="48" class="img-circle" />
                                            </span>

                                            <span class="line">
                                                <strong>
                                                    <?php echo $this->db->get_where($user_to_show_type, array($user_to_show_type . '_id' => $user_to_show_id))->row()->name; ?>
                                                </strong>
                                                - <?php echo date("d M, Y", $last_message_timestamp); ?>
                                            </span>

                                            <span class="line desc small">
                                                <!-- preview of the last unread message substring -->
                                                <?php
                                                echo substr($last_unread_message, 0, 50);
                                                ?>
                                            </span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>

                        <li class="external">
                            <a href="<?php echo base_url(); ?>index.php?<?php echo $this->session->userdata('login_type'); ?>/message">
                                <?php echo get_phrase('view_all_messages'); ?>
                            </a>
                        </li>				
                    </ul>
                </li>
                <?php } ?>
            </ul>     
        </div>
        <div class="col-md-8 col-sm-8 ">
            <nav class="navbar navbar-default top-menu">
                <div class="container-fluid">
                    <ul class="nav navbar-nav">
                        <li class="dropdown <?php if ($page_name == 'manage_patient'||$page_name == 'add_patient'||$page_name == 'edit_patient') echo 'active'; ?>"><a href="<?php echo base_url(); ?>index.php?admin/patient">
                            <div class="round"><i class="fa fa-user custom"></i></div><?php echo get_phrase('patient'); ?></a>
                        </li>
                        <li class="dropdown <?php if (strpos($page_name,'reception')>-1||
                                                      strpos($page_name,'triage')>-1||
                                                      strpos($page_name,'laboratory')>-1||
                                                      strpos($page_name,'consultation')>-1) echo 'active'; ?>">
                            <a href="#" data-hover="dropdown-hover" aria-haspopup="true" data-close-others="true"><div class="round"><i class="fa fa-heartbeat custom" ></i></div>activities</a>
                            <ul class="dropdown-menu">
                                <li class="dropdown  dropdown-submenu"><a href="<?php echo base_url(); ?>index.php?admin/reception"><?php echo get_phrase('reception'); ?></a>
                                    <ul class="dropdown-menu">
                                        <li ><a href="<?php echo base_url();?>index.php?admin/reception"><?php echo get_phrase('reception_list'); ?></a></li>    
                                        <li><a href="<?php echo base_url();?>index.php?admin/reception/register"><?php echo get_phrase('add_reception'); ?></a></li>    
                                    </ul>
                                </li>    
                                <li><a href="<?php echo base_url();?>index.php?admin/payment">Payment</a></li>    
                                <li class="dropdown  dropdown-submenu"><a href="<?php echo base_url(); ?>index.php?admin/triage" ><?php echo get_phrase('triage'); ?></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo base_url();?>index.php?admin/triage"><?php echo get_phrase('triage_list'); ?></a></li>    
                                        <li><a href="<?php echo base_url();?>index.php?admin/triage/register"><?php echo get_phrase('add_triage'); ?></a></li>    
                                    </ul>
                                </li>
                                <li><a href="<?php echo base_url();?>index.php?admin/consultation"><?php echo get_phrase('consultaions'); ?></a></li>
                                <li class="dropdown <?php if (strpos($page_name,'laboratory')>-1) echo 'active'; ?>"><a href="<?php echo base_url();?>index.php?admin/labreq"><?php echo get_phrase('laboratory'); ?></a>
                                   <!-- <ul class="dropdown-menu">
                                        <li><a href="<?php echo base_url();?>index.php?admin/laboratory/billing"><?php echo get_phrase('lab_billing'); ?></a></li>    
                                        <li><a href="<?php echo base_url();?>index.php?admin/laboratory/reception"><?php echo get_phrase('lab_reception'); ?></a></li>    
                                        <li><a href="<?php echo base_url();?>index.php?admin/laboratory/analysis"><?php echo get_phrase('lab_analysis'); ?></a></li>    
                                    </ul>-->
                                </li>
                                <li><a href="#">Radiology Billing</a></li>
                                <li><a href="#">Radiology Analysis</a></li>
                                <li><a href="#">Pharmacy</a></li>
                                <li><a href="#">Theatre</a></li>
                                <li><a href="#">Consolidate Invoice</a></li>
                                <li><a href="#">Patient History</a></li>
                                <li><a href="#">Manage Billing Service</a></li>
                                <li><a href="#">Reprint Receipt/Invoice</a></li>
                                <li><a href="#">Mother Child Health</a></li>
                                <li><a href="#">Comprehensive Care Center</a></li>
                                <li><a href="#">Nutrition</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#">Dental Clinic</a></li>
                                <li><a href="#">Paediatrics</a></li>
                                <li><a href="#">Emergencies</a></li>
                                <li><a href="#">HDU</a></li>
                                <li><a href="#">Dialysis</a></li>
                                <li><a href="#">Ambluance</a></li>
                                <li><a href="#">Surgicals Billing</a></li>
                                <li><a href="#">Socials works</a></li>
                                <li><a href="#">Physiotherapy</a></li>
                                <li><a href="#">Counselling</a></li>
                                
                            </ul>
                        </li>
                        <li class=""><a href="#" data-hover="dropdown-hover" aria-haspopup="true" data-close-others="true"><div class="round"><i class="fa fa-medkit custom"></i></div>Inventory</a>
                            <ul class="dropdown-menu">
                                <li class="dropdown  dropdown-submenu"><a href="#">Stock Management</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Add/Edit Stock Items</a></li>    
                                        <li><a href="#">Find Stock Items</a></li>
                                        <li><a href="#">Good Received Inwards</a></li>
                                        <li><a href="#">Stock Request </a></li>    
                                        <li><a href="#">Stock Transfer</a></li>    
                                        <li><a href="#">Stock Taking</a></li>    
                                        <li><a href="#">Random Stock Take</a></li>    
                                        <li><a href="#">Stock Adjustment</a></li>    
                                        <li><a href="#">Stock Validation</a></li>    
                                        <li><a href="#">Stock Usage Register</a></li>
                                        <li><a href="#">Good Returned Outwards</a></li>
                                        <li><a href="#">Local Purchase Order</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown  dropdown-submenu"><a href="#">Asset Management</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Add New Asset</a></li>
                                        <li><a href="#">Edit Asset Details</a></li>
                                        <li><a href="#">Delete Asset</a></li>
                                        <li><a href="#">Find Asset</a></li>
                                        <li><a href="#">Assign Asset</a></li>
                                        <li><a href="#">Return Asset</a></li>
                                        <li><a href="#">Deposit Asset</a></li>
                                        <li><a href="#">Manage Asset</a></li>
                                        <li><a href="#">Asset Count</a></li>    
                                    </ul>
                                </li>
                            </ul>    
                        </li>
                        <li class=""><a href="#"  data-hover="dropdown-hover" aria-haspopup="true" data-close-others="true"><div class="round"><i class="fa fa-users  custom"></i></div>employees</a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Add New Employee</a></li>    
                                <li><a href="#">Edit Employee Info</a></li>
                                <li><a href="#">Find Employee</a></li>
                                <li><a href="#">Delete Employee Record</a></li>
                                <li><a href="#">Emplyee Chart</a></li>
                                <li><a href="#">Terminate Employment</a></li>
                                <li><a href="#">Download H/R Documents</a></li>
                                <li><a href="#">Ex-employee panel</a></li>
                                <li><a href="#">Attendance Manager</a></li>
                                <li><a href="#">Request For Leave</a></li>
                                <li><a href="#">Authorize Leave</a></li>
                                <li><a href="#">Leave Calender</a></li>
                                <li><a href="#">New Payroll</a></li>
                                <li><a href="#">Edit Payroll</a></li>
                                <li><a href="#">Payroll setting</a></li>
                                <li><a href="#">Employee Benefits</a></li>
                                <li class="dropdown  dropdown-submenu"><a href="#">External Medics</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Add/Edit External Medics</a></li>
                                        <li><a href="#">Locums Register</a></li>
                                        <li><a href="#">Locums Check-in</a></li>
                                        <li><a href="#">Locums Check-out</a></li>    
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class=""><a href="#"  data-hover="dropdown-hover" aria-haspopup="true" data-close-others="true"><div class="round"><i class="fa fa-file-text-o custom"></i></div>reports</a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Cashier Daily Summary</a></li>   
                                <li><a href="#">Unposted Entries</a></li>   
                                <li><a href="#">Several Months Summary</a></li>   
                                <li><a href="#">Managerial Daily Summary</a></li>  
                                <li class="dropdown  dropdown-submenu"><a href="#">Financial Statements</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Trial Balance</a></li>    
                                        <li><a href="#">Income Statement</a></li>
                                        <li><a href="#">Balance Sheet</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown  dropdown-submenu"><a href="#">Income Report</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Today Income</a></li>
                                        <li><a href="#">All</a></li>
                                        <li><a href="#">With Profit</a></li>
                                        <li><a href="#">With Loss</a></li>
                                        <li><a href="#">By Cashier</a></li>
                                        <li><a href="#">By Item</a></li>
                                        <li><a href="#">By Department</a></li> 
                                        <li><a href="#">By Patient</a></li>
                                        <li><a href="#">By Doctor</a></li>
                                        <li><a href="#">Departmental Income</a></li>   
                                    </ul>
                                </li> 
                                <li class="dropdown  dropdown-submenu"><a href="#">Invoices Report</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Today Invoices</a></li>
                                        <li><a href="#">All Invoices</a></li>
                                        <li><a href="#">By Company</a></li>
                                        <li><a href="#">Receipts(Cash Paying)</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown  dropdown-submenu"><a href="#">Procurement</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Goods Received-All</a></li>
                                        <li><a href="#">Goods Received-By Item</a></li>
                                        <li><a href="#">Goods Received-By Supplier</a></li>
                                        <li><a href="#">Goods Returned-All</a></li>
                                        <li><a href="#">Goods Returned-By Item</a></li>
                                        <li><a href="#">Goods Returned-By Supplier</a></li>                                    
                                        <li><a href="#">Reprint GRN(Received)</a></li>
                                        <li><a href="#">Reprint GRN(Returned)</a></li>
                                        <li><a href="#">Reprint LPO</a></li>
                                        <li><a href="#">LPO Summaries</a></li>
                                        <li><a href="#">Invoice Listing-Inwards</a></li>
                                        <li><a href="#">Invoice Listing-Outwards</a></li>
                                        <li><a href="#">Summarized Bin Card</a></li>
                                        <li><a href="#">Inventory-All</a></li>
                                        <li><a href="#">Inventory-By Category</a></li>
                                        <li><a href="#">Inventory-By Supplier</a></li>
                                        <li><a href="#">Expiry Report</a></li>
                                        <li><a href="#">Reprint Variance Report</a></li>
                                        <li><a href="#">Variance Reports</a></li>
                                        <li><a href="#">Variance Summaries</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown  dropdown-submenu"><a href="#">Goods Price List</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">All</a></li>
                                        <li><a href="#">By Section</a></li>
                                    </ul>
                                </li> 
                                <li class="dropdown  dropdown-submenu"><a href="#">HR Reports</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Detailed Monthly Report</a></li>
                                        <li><a href="#">Monthly Bank Summary</a></li>
                                        <li><a href="#">Individual Bank Report</a></li>
                                        <li><a href="#">Salaries Summary</a></li>
                                        <li><a href="#">Employee Summary</a></li>
                                        <li><a href="#">Individual Pay Slips</a></li>
                                        <li><a href="#">All Pay Slips</a></li>
                                        <li><a href="#">Attendance Report</a></li>
                                        <li><a href="#">Leave Report</a></li>
                                        <li><a href="#">Employees List</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown  dropdown-submenu"><a href="#">Other Reports</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Stock Usage Report</a></li>
                                        <li><a href="#">Ledger Reports</a></li>
                                        <li><a href="#">Queue Reports</a></li>
                                        <li><a href="#">Message Reports</a></li>
                                        <li><a href="#">Activity Log-All</a></li>
                                        <li><a href="#">Activity Log By User</a></li>
                                        <li><a href="#">Debtors List</a></li>
                                        <li><a href="#">Creditors List</a></li>
                                        <li><a href="#">Stock Movement Report</a></li>
                                        <li><a href="#">System Users List</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown  dropdown-submenu"><a href="#">Assets Reports</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Asset List-All</a></li>
                                        <li><a href="#">Asset Tracking</a></li>
                                    </ul>
                                </li>       
                                <li class="dropdown  dropdown-submenu"><a href="#">Social Works Report</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Waiver Reports</a></li>
                                        <li><a href="#">Counselling Reports</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown  dropdown-submenu"><a href="#">Lab Reports</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">All Tests</a></li>
                                        <li><a href="#">By Source</a></li>
                                        <li><a href="#">By Test</a></li>
                                        <li><a href="#">By Sample</a></li>
                                        <li><a href="#">By Patient</a></li>
                                        <li><a href="#">By Section</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown  dropdown-submenu"><a href="#">Radiology Reports</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">All Tests</a></li>
                                        <li><a href="#">By Test</a></li>
                                        <li><a href="#">By Patient</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown  dropdown-submenu"><a href="#">Pharmacy Reports</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">All Prescriptions</a></li>
                                        <li><a href="#">By Patient</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown  dropdown-submenu"><a href="#">Theatre Reports</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">All Procedures</a></li>
                                        <li><a href="#">By Patient</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown  dropdown-submenu"><a href="#">Services Price List</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">All</a></li>
                                        <li><a href="#">By Dept</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown  dropdown-submenu"><a href="#">Records Reports</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Diagnosis Reports (OPD)</a></li>
                                        <li><a href="#">Births Reports</a></li>
                                        <li><a href="#">Deaths Reports</a></li>
                                        <li><a href="#">All Patients</a></li>
                                        <li><a href="#">Outpatients Summary</a></li>
                                        <li><a href="#">Deaths Reports</a></li>
                                        <li><a href="#">Unregistered Patients</a></li>
                                        <li><a href="#">Patients Review Report</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown  dropdown-submenu"><a href="#">Stock Transfer Report</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Stock Transfer-All</a></li>
                                        <li><a href="#">Stock Transfer-By Dept</a></li>
                                        <li><a href="#">Transfer Summaries</a></li>
                                        <li><a href="#">Bin Card</a></li>
                                        <li><a href="#">Re-Order Level-By Section</a></li>
                                        <li><a href="#">Re-Order Level-By Supplier</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li> 
                        <li class=""><a href="#" data-hover="dropdown-hover" aria-haspopup="true" data-close-others="true"><div class="round"><i class="fa fa-dollar custom"></i></div>accounts</a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Make Journal Entries</a></li>    
                                <li><a href="#">Find Journal Entries</a></li>
                                <li><a href="#">Ledgers Panel</a></li>
                                <li><a href="#">Debtors Management</a></li>
                                <li><a href="#">Creditors Mangement</a></li>
                                <li><a href="#">Find Invoices</a></li>
                                <li><a href="#">Cash Collection</a></li>
                                <li><a href="#">Expenses Mangement</a></li>
                                <li><a href="#">Bank Deposit</a></li>
                            </ul>
                        </li>
                        <li class=""><a href="#" data-hover="dropdown-hover" aria-haspopup="true" data-close-others="true"><div class="round"><i class="fa fa-gear  custom"></i></div>tools</a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Company Details</a></li>    
                                <li><a href="#">System User Manager</a></li>
                                <li><a href="#">Useer Access Rights</a></li>
                                <li><a href="#">Item Access Rights</a></li>
                                <li><a href="#">Change Password</a></li>
                                <li><a href="#">Edit System Variables</a></li>
                                <li><a href="#">Set Ward Beds</a></li>
                                <li><a href="#">Set up Banks</a></li>
                                <li><a href="#">Medical Notes</a></li>
                                <li><a href="#">Add/Edit Medical Data</a></li>
                                <li><a href="#">Import Database</a></li>
                                <li><a href="#">Export Database</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="col-md-2 col-sm-2  pull-left">
            <ul class="list-inline links-list pull-right" style="padding-top:10px; padding-bottom:0px;">
                <!-- PROFILE EDIT, PASSWORD CHANGE, LOGOUT BUTTON -->
                <li class="notifications dropdown tooltip-primary" data-toggle="tooltip" data-original-title="Account" data-placement="top" style="padding: 0px;">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-close-others="true">
                        <i style="color: #ccc;" class="entypo-user"></i>
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <a href="<?php echo base_url(); ?>index.php?admin/manage_profile">
                                <i class="entypo-pencil"></i>
                                <span>Edit Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php?admin/manage_profile">
                                <i class="entypo-key"></i>
                                <span>Change Password</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php?login/logout">
                                <i class="entypo-logout"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- RIGHT BAR TOGGLE BUTTON ICON-->
                <li class="notifications dropdown tooltip-primary" data-toggle="tooltip" data-original-title="To Do" data-placement="top" style="padding: 0px;">
                    <a href="#" class="dropdown-toggle" data-collapse-sidebar="1" data-toggle="chat" style="display:block;">
                        <i class="entypo-menu" style="color: #ccc;"></i>
                        <span id="incomplete_todo_number"></span>
                    </a>
                </li>

            </ul>
            <!--
            <ul class="list-inline links-list pull-left">
                 Language Selector 			
                <li class="dropdown language-selector">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-close-others="true">
                        <i class="entypo-user"></i> <?php echo $this->session->userdata('login_type'); ?>
                    </a>
                </li>
             </ul> -->      
        </div>
    </div>

</div>

<hr style="margin-top:0px;" />