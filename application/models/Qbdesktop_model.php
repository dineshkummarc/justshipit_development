<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class Qbdesktop_model extends CI_Model
{
	 
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('Customer_model');
	}
	/**
	 * Set the DSN connection string for the queue class
	 */
	public function dsn($dsn)
	{
		$this->_dsn = $dsn;
	}
	
	/**
	 * Queue up a request for the Web Connector to process
	 */
	public function enqueue($action, $ident, $priority = 0, $extra = null, $user = null)
	{
		$userInfo = $this->Customer_model->getCustomerInfo($ident);

		
		if(empty($userInfo)){
			$aReturn['response_message'] = 'Not a valid user';
			$aReturn['response_status'] = 'error';
			return $aReturn;
		}
			
		$Queue = new QuickBooks_WebConnector_Queue($this->_dsn);
		
		return $Queue->enqueue($action, $ident, $priority, $extra, $user); 
	}
	
	 

}

  