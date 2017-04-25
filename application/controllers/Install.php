<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*	
 *	@author : Joyonto Roy
 *	30th November, 2014
 *	Creative Item
 *	www.creativeitem.com
 *	http://codecanyon.net/user/Creativeitem
 */
 

class Install extends CI_Controller {

	function __construct()
    {
        parent::__construct();	
		$this->load->helper('url');
		$this->load->helper('file');
		// Cache control
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
	}
	
	function index()
	{
		$this->load->view('backend/install');
	}
	
	// -----------------------------------------------------------------------------------
	
	/*
	 * Install the script here
	 */
	function do_install()
	{
		$db_verify				=	$this->check_db_connection();
		$purchase_verify		=	$this->verify_purchase();
		
		if($purchase_verify == true && $db_verify == true)
		{
			// Replace the database settings

			$db_name 		=	$this->input->post('db_name');
			$db_uname 		=	$this->input->post('db_uname');
			$db_password 	=	$this->input->post('db_password');
			$db_hname 		=	$this->input->post('db_hname');

			$data 			= read_file('./application/config/database.php');
			$data 			= str_replace('db_name',		$db_name,		$data);
			$data 			= str_replace('db_uname',		$db_uname,		$data);
			$data 			= str_replace('db_password',	$db_password,	$data);						
			$data 			= str_replace('db_hname',		$db_hname,		$data);
			write_file('./application/config/database.php', $data);
			
			// Replace new default routing controller
			$data2 			= read_file('./application/config/routes.php');
			$data2 			= str_replace('install','login',$data2);
			write_file('./application/config/routes.php', $data2);
			
			
			// Run the installer sql schema		
			$link 			= @mysql_connect( $db_hname , $db_uname , $db_password);
			mysql_select_db($db_name);
			$temp_line 		= '';
			$lines 			= file('uploads/install.sql');
			foreach ($lines as $line)
			{
				if (substr($line, 0, 2) == '--' || $line == '')
					continue;
				$temp_line .= $line;
				if (substr(trim($line), -1, 1) == ';')
				{
					mysql_query($temp_line) or print('Error performing query \'<strong>' . $temp_line . '\': ' . mysql_error() . '<br /><br />');
					$temp_line = '';
				}			

			}


			// Replace the admin login credentials
				 
			$this->load->database();
			$this->db->where('admin_id' , 1);
			$this->db->update('admin' , array('email'	=>	$this->input->post('email'),
												'password'	=>	sha1($this->input->post('password'))));
			
			// Replace the system name						
			$this->db->where('type', 'system_name');
			$this->db->update('settings', array(
				'description' => $this->input->post('system_name')
			));
			
			// Replace the system title
			$this->db->where('type', 'system_title');
			$this->db->update('settings', array(
				'description' => $this->input->post('system_name')
			));
			
			// Save the buyer username
			$this->db->where('type', 'buyer');
			$this->db->update('settings', array(
				'description' => $this->input->post('buyer')
			));
			
			// Save the buyer purchase code
			$this->db->where('type', 'purchase_code');
			$this->db->update('settings', array(
				'description' => $this->input->post('purchase_code')
			));
			
			// Redirect to login page after completing installation
			$this->session->set_flashdata('installation_result' , 'success');
			redirect(base_url().'index.php?admin', 'refresh');
		}
		else 
		{
			$this->session->set_flashdata('installation_result' , 'failed');
			redirect(base_url().'index.php?install' , 'refresh');
		}
	}
	
	// -------------------------------------------------------------------------------------------------
	
	/* 
	 * Database validation check from user input settings
	 */
	function check_db_connection()
	{
		$link	=	@mysql_connect($this->input->post('db_hname'),
						$this->input->post('db_uname'),
							$this->input->post('db_password'));
		if(!$link)
		{
			@mysql_close($link);
		 	return false;
		}
		
		$db_selected	=	mysql_select_db($this->input->post('db_name'), $link);
		if (!$db_selected)
		{
			@mysql_close($link);
		 	return false;
		}
		
		@mysql_close($link);
		return true;
	}
	
	// ------------------------------------------------------------------------------------------------
	
	/* 
	 * Item purchase verification by envato api
	 */
	function verify_purchase()
	{
		ini_set('user_agent', 'Mozilla/5.0');
		$buyer				=	$this->input->post('buyer');
		$purchase_code		=	$this->input->post('purchase_code');
		
		$url = "http://marketplace.envato.com/api/v3/Creativeitem/t3593ia0r3xbxcx85b4zve2j53y7zzrr/verify-purchase:".$purchase_code.".json";
		$purchase_data = json_decode(file_get_contents($url), true);
		if ( isset($purchase_data['verify-purchase']['buyer']) && $purchase_data['verify-purchase']['buyer'] == $buyer)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
}

/* End of file install.php */
/* Location: ./system/application/controllers/install.php */