<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Qbdesktop extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
		
		$this->load->config('quickbooks');
		
		$this->load->model('qbdesktop_model');
		
		$this->load->model('customer_model');
		
		$this->load->model('shipment_model');
		
		$this->qbdesktop_model->dsn('mysqli://' . $this->db->username . ':' . $this->db->password . '@' . $this->db->hostname . '/' . $this->db->database);
		
    }

	function customercreateconfig(){
		$name = 'Justship QuickBooks';			// A name for your server (make it whatever you want)
		$descrip = 'Justship QuickBooks';		// A description of your server 

		$appurl = 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . 'qbwc';		// This *must* be httpS:// (path to your QuickBooks SOAP server)
		$appsupport = $appurl; 		// This *must* be httpS:// and the domain name must match the domain name above

		$username = $this->config->item('quickbooks_user');		// This is the username you stored in the 'quickbooks_user' table by using QuickBooks_Utilities::createUser()

		$fileid = QuickBooks_WebConnector_QWC::fileID();		// Just make this up, but make sure it keeps that format
		$ownerid = QuickBooks_WebConnector_QWC::ownerID();		// Just make this up, but make sure it keeps that format

		$qbtype = QUICKBOOKS_TYPE_QBFS;	// You can leave this as-is unless you're using QuickBooks POS

		$readonly = false; // No, we want to write data to QuickBooks

		$run_every_n_seconds = 60; // Run every 600 seconds (10 minutes)

		// Generate the XML file
		$QWC = new QuickBooks_WebConnector_QWC($name, $descrip, $appurl, $appsupport, $username, $fileid, $ownerid, $qbtype, $readonly, $run_every_n_seconds);
		$xml = $QWC->generate();

		// Send as a file download
		//header('Content-type: text/xml');
		header('Content-Disposition: attachment; filename="justship-quickbooks-wc-file.qwc"');
		print($xml);
		exit;
	}
	
	function customerdesktopqbwc(){
		
		$user = $this->config->item('quickbooks_user');
		$pass = $this->config->item('quickbooks_pass');
		
		// Memory limit
		ini_set('memory_limit', $this->config->item('quickbooks_memorylimit'));
		
		// We need to make sure the correct timezone is set, or some PHP installations will complain
		if (function_exists('date_default_timezone_set'))
		{
			// * MAKE SURE YOU SET THIS TO THE CORRECT TIMEZONE! *
			// List of valid timezones is here: http://us3.php.net/manual/en/timezones.php
			date_default_timezone_set($this->config->item('quickbooks_tz'));
		}
				
		// Map QuickBooks actions to handler functions
		$map = array(
			QUICKBOOKS_ADD_CUSTOMER => array( array( $this, '_addCustomerRequest' ), array( $this, '_addCustomerResponse' ) ),
			QUICKBOOKS_ADD_VENDOR => array( array( $this, '_addCustomerRequest' ), array( $this, '_addCustomerResponse' ) ),
			QUICKBOOKS_ADD_INVOICE => array( array( $this, '_addInvoiceRequest' ), array( $this, '_addInvoiceResponse' ) ),
		);
		
		// Catch all errors that QuickBooks throws with this function 
		$errmap = array(
			'*' => array( $this, '_catchallErrors' ),
			);
		
		// Call this method whenever the Web Connector connects
		$hooks = array(
			//QuickBooks_WebConnector_Handlers::HOOK_LOGINSUCCESS => array( array( $this, '_loginSuccess' ) ), 	// Run this function whenever a successful login occurs
			);
		
		// An array of callback options
		$callback_options = array();
		
		// Logging level
		$log_level = $this->config->item('quickbooks_loglevel');
		
		// What SOAP server you're using 
		//$soapserver = QUICKBOOKS_SOAPSERVER_PHP;			// The PHP SOAP extension, see: www.php.net/soap
		$soapserver = QUICKBOOKS_SOAPSERVER_BUILTIN;		// A pure-PHP SOAP server (no PHP ext/soap extension required, also makes debugging easier)
		
		$soap_options = array(		// See http://www.php.net/soap
			);
		
		$handler_options = array(
			'deny_concurrent_logins' => false, 
			'deny_reallyfast_logins' => false, 
			);		// See the comments in the QuickBooks/Server/Handlers.php file
		
		$driver_options = array(		
			// See the comments in the QuickBooks/Driver/<YOUR DRIVER HERE>.php file ( i.e. 'Mysql.php', etc. )
			'max_log_history' => 32000,	// Limit the number of quickbooks_log entries to 1024
			'max_queue_history' => 1024, 	// Limit the number of *successfully processed* quickbooks_queue entries to 64
		);
		 
		// Build the database connection string
		
		//$dsn = 'mysql://root:password@localhost/your_database';				// Connect to a MySQL database with user 'root' and password 'password'
		//$dsn = 'mysqli://root:@localhost/quickbooks_mysqli';					// Connect to a MySQL database using the PHP MySQLi extension
		//$dsn = 'mssql://kpalmer:password@192.168.18.128/your_database';		// Connect to MS SQL Server database
		//$dsn = 'pgsql://pgsql:password@localhost/your_database';				// Connect to a PostgreSQL database 
		//$dsn = 'pearmdb2.mysql://root:password@localhost/your_database';		// Connect to MySQL using the PEAR MDB2 database abstraction library
		//$dsn = 'sqlite://example.sqlite';										// Connect to an SQLite database
		//$dsn = 'sqlite:///Users/keithpalmerjr/Projects/QuickBooks/docs/example.sqlite';
		
		$dsn = 'mysqli://' . $this->db->username . ':' . $this->db->password . '@' . $this->db->hostname . '/'.$this->db->database;
		//mysqli://root:@localhost/quickbooks_mysqli
		
		// Check to make sure our database is set up 
		if (!QuickBooks_Utilities::initialized($dsn))
		{
			// Initialize creates the neccessary database schema for queueing up requests and logging
			QuickBooks_Utilities::initialize($dsn);
			
			// This creates a username and password which is used by the Web Connector to authenticate
			QuickBooks_Utilities::createUser($dsn, $user, $pass);
	
		}
		
		// Set up our queue singleton
		QuickBooks_WebConnector_Queue_Singleton::initialize($dsn);
		
		// Create a new server and tell it to handle the requests
		// __construct($dsn_or_conn, $map, $errmap = array(), $hooks = array(), $log_level = QUICKBOOKS_LOG_NORMAL, $soap = QUICKBOOKS_SOAPSERVER_PHP, $wsdl = QUICKBOOKS_WSDL, $soap_options = array(), $handler_options = array(), $driver_options = array(), $callback_options = array()
		$Server = new QuickBooks_WebConnector_Server($dsn, $map, $errmap, $hooks, $log_level, $soapserver, QUICKBOOKS_WSDL, $soap_options, $handler_options, $driver_options, $callback_options);
		$response = $Server->handle(true, true);
		
		/* $this->load->library('email');

		$this->email->from('admin@justshipit.com', 'Admin');
		$this->email->to('vigneshwaran.m@phpmasterminds.com');

		$this->email->subject('Handle Response');
		$this->email->message('Testing the email class Handle - ');

		$this->email->send(); */
		
	} 
	
	/**
	 * Issue a request to QuickBooks to add a customer
	 */
	public function _addCustomerRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
	{
		$userInfo = $this->customer_model->getCustomerInfo($ID);
		
		//$Driver = QuickBooks_Driver_Factory::create($dsn);	
		
		if(empty($userInfo)){
			return false;
		}
		
		$this->load->library('email');
		$this->email->from('admin@justshipit.com', 'Admin');
		$this->email->to('vigneshwaran.m@phpmasterminds.com');
		$this->email->subject('Customer Request');
		$this->email->message('creating request'); 
		$this->email->send();
		
		if($userInfo->category_id == 2){
		
			if($userInfo->same_address ==1){
				$address1 = $userInfo->c_address_1;
				$address2 = $userInfo->c_address_2;
				$city = $userInfo->c_city;
				$country_name = $userInfo->country_name;
				$state_code = $userInfo->state_code;
				$zip = $userInfo->c_zip;
			}else{
				$address1 = ($userInfo->r_address_1 ? $userInfo->r_address_1 : $userInfo->c_address_1);
				$address2 = ($userInfo->r_address_2 ? $userInfo->r_address_2 : $userInfo->c_address_2);
				$city = ($userInfo->r_city ? $userInfo->r_city : $userInfo->c_city);
				$country_name = ($userInfo->r_country_name ? $userInfo->r_country_name : $userInfo->country_name);
				$state_code = ($userInfo->r_state_code ? $userInfo->r_state_code : $userInfo->state_code);
				$zip = ($userInfo->r_zip ? $userInfo->r_zip : $userInfo->c_zip);
			}
			
			// Build the qbXML request from $data
				$xml = '<?xml version="1.0" encoding="utf-8"?>
				<?qbxml version="2.0"?>
				<QBXML>
					<QBXMLMsgsRq onError="stopOnError">
						<VendorAddRq requestID="' . $requestID . '">
							<VendorAdd>
								<Name>'.$userInfo->customer_name.'</Name>
								<CompanyName>'.$userInfo->customer_name.'</CompanyName>
								<FirstName>'.$userInfo->c_contact.'</FirstName>
								<LastName></LastName>
								<BillAddress>
									<Addr1>'.$address1.'</Addr1>
									<Addr2>'.$address2.'</Addr2>
									<City>'.$city.'</City>
									<State>'.$state_code.'</State>
									<PostalCode>'.$zip.'</PostalCode>
									<Country>'.$country_name.'</Country>
								</BillAddress>
								<VendorAddress>
									<Addr1>'.$address1.'</Addr1>
									<Addr2>'.$address2.'</Addr2>
									<City>'.$city.'</City>
									<State>'.$state_code.'</State>
									<PostalCode>'.$zip.'</PostalCode>
									<Country>'.$country_name.'</Country>
								</VendorAddress>
								<Phone>'.$userInfo->c_phone.'</Phone>
								<Fax>'.$userInfo->c_fax .'</Fax>
								<Email>'.$userInfo->c_email .'</Email>
								<Contact>'.$userInfo->c_contact .'</Contact>
								<AccountNumber >'.$userInfo->account_no .'</AccountNumber> 
							</VendorAdd>
						</VendorAddRq>
					</QBXMLMsgsRq>
				</QBXML>';
			
				return $xml;
				
		}else{
		
				$invoice_notes = $userInfo->invoice_notes;
				
				$s_address1 = $userInfo->c_address_1;
				$s_address2 = $userInfo->c_address_2;
				$s_city = $userInfo->c_city;
				$s_country_name = $userInfo->country_name;
				$s_state_code = $userInfo->state_code;
				$s_zip = $userInfo->c_zip;
					
				if($userInfo->same_address ==1){
					$address1 = $userInfo->c_address_1;
					$address2 = $userInfo->c_address_2;
					$city = $userInfo->c_city;
					$country_name = $userInfo->country_name;
					$state_code = $userInfo->state_code;
					$zip = $userInfo->c_zip;
				}else{
					$address1 = ($userInfo->r_address_1 ? $userInfo->r_address_1 : $userInfo->c_address_1);
					$address2 = ($userInfo->r_address_2 ? $userInfo->r_address_2 : $userInfo->c_address_2);
					$city = ($userInfo->r_city ? $userInfo->r_city : $userInfo->c_city);
					$country_name = ($userInfo->r_country_name ? $userInfo->r_country_name : $userInfo->country_name);
					$state_code = ($userInfo->r_state_code ? $userInfo->r_state_code : $userInfo->state_code);
					$zip = ($userInfo->r_zip ? $userInfo->r_zip : $userInfo->c_zip);
				}
			

				// Build the qbXML request from $data
				$xml = '<?xml version="1.0" encoding="utf-8"?>
				<?qbxml version="2.0"?>
				<QBXML>
					<QBXMLMsgsRq onError="stopOnError">
						<CustomerAddRq requestID="' . $requestID . '">
							<CustomerAdd>
								<Name>'.$userInfo->customer_name.'</Name>
								<CompanyName>'.$userInfo->customer_name.'</CompanyName>
								<FirstName>'.$userInfo->c_contact.'</FirstName>
								<LastName></LastName>
								<BillAddress>
									<Addr1>'.$address1.'</Addr1>
									<Addr2>'.$address2.'</Addr2>
									<City>'.$city.'</City>
									<State>'.$state_code.'</State>
									<PostalCode>'.$zip.'</PostalCode>
									<Country>'.$country_name.'</Country>
								</BillAddress>
								<ShipAddress>
									<Addr1>'.$s_address1.'</Addr1>
									<Addr2>'.$s_address2.'</Addr2>
									<City>'.$s_city.'</City>
									<State>'.$s_state_code.'</State>
									<PostalCode>'.$s_zip.'</PostalCode>
									<Country>'.$s_country_name.'</Country>
								</ShipAddress>
								<Phone>'.$userInfo->c_phone.'</Phone>
								<Fax>'.$userInfo->c_fax .'</Fax>
								<Email>'.$userInfo->c_email .'</Email>
								<Contact>'.$userInfo->c_contact .'</Contact>
							</CustomerAdd>
						</CustomerAddRq>
					</QBXMLMsgsRq>
				</QBXML>';
			
				return $xml;
		}
	}

	/**
	 * Handle a response from QuickBooks indicating a new customer has been added
	 */	
	public function _addCustomerResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		
		$this->load->library('email');
		$this->email->from('admin@justshipit.com', 'Admin');
		$this->email->to('vigneshwaran.m@phpmasterminds.com');
		$this->email->subject('Customer Response');
		$this->email->message(var_export($idents, true)); 
		$this->email->send();
		
		/*$ID - our database user id, $requestID - qp id*/
		$uUpdateInfo = array(
			'quickbook_id' => $idents['ListID'],
			'qb_editsequence' => $idents['EditSequence']
		);
		
		$this->customer_model->updateCustomer($uUpdateInfo, $ID);
		
		// Do something here to record that the data was added to QuickBooks successfully 
		
		return true; 
	}
	
	
	public function _addInvoiceRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
	{
		
		
		$shipInfo = $this->shipment_model->getDomesticInfo($ID);
		
		
		
		//$Driver = QuickBooks_Driver_Factory::create($dsn);	
		
		if(empty($shipInfo)){
			return false;
		}
		
		if($shipInfo['is_qp_upload'] == 1 || $shipInfo['is_qp_upload'] == 2 && $shipInfo['bill_to_data']['customer_data']['quickbook_id'] != 0){
		
			$aChargeRecords = $this->shipment_model->loadSelectedChargeCodes($shipInfo['shipment_id']);	
			$venRecords = $this->shipment_model->loadSelectedVendors($shipInfo['shipment_id']);
			
			$totalchargecost = $totalchargerate = $totalqty = 0;
			$totalvendorcost = $totalvendorrate = $totalvendorqty = 0;
			
			if(!empty($aChargeRecords) || !empty($venRecords)){
			
				if(!empty($aChargeRecords)){
					foreach($aChargeRecords as $key => $aChargeRecord){
						$totalchargecost = $totalchargecost + $aChargeRecord->charge_code_total_cost;
						$totalchargerate = $totalchargerate + $aChargeRecord->charge_code_rate;
						$totalqty = $totalqty + $aChargeRecord->charge_code_qty;
					}
				}
				
				if(!empty($venRecords)){
					foreach($venRecords as $key => $venRecord){
						$totalvendorcost = $totalvendorcost + $aChargeRecord->p_total_cost;
						$totalvendorrate = $totalvendorrate + $aChargeRecord->p_cost;
						$totalvendorqty = $totalvendorqty + $aChargeRecord->p_qty;
					}
				}
			
			
				if($shipInfo['bill_to_data']['customer_data']['same_address'] ==1){
					$address1 = $shipInfo['bill_to_data']['customer_data']['c_address_1'];
					$address2 = $shipInfo['bill_to_data']['customer_data']['c_address_2'];
					$city = $shipInfo['bill_to_data']['customer_data']['c_city'];
					$country_name = $shipInfo['bill_to_data']['customer_data']['country_name'];
					$state_code = $shipInfo['bill_to_data']['customer_data']['state_code'];
					$zip = $shipInfo['bill_to_data']['customer_data']['c_zip'];
				}else{
					$address1 = ($shipInfo['bill_to_data']['customer_data']['r_address_1'] ? $shipInfo['bill_to_data']['customer_data']['r_address_1'] : $shipInfo['bill_to_data']['customer_data']['c_address_1']);
					$address2 = ($shipInfo['bill_to_data']['customer_data']['r_address_2'] ? $shipInfo['bill_to_data']['customer_data']['r_address_2'] : $shipInfo['bill_to_data']['customer_data']['c_address_2']);
					$city = ($shipInfo['bill_to_data']['customer_data']['r_city'] ? $shipInfo['bill_to_data']['customer_data']['r_city'] : $shipInfo['bill_to_data']['customer_data']['c_city']);
					$country_name = ($shipInfo['bill_to_data']['customer_data']['r_country_name'] ? $shipInfo['bill_to_data']['customer_data']['r_country_name'] : $shipInfo['bill_to_data']['customer_data']['country_name']);
					$state_code = ($shipInfo['bill_to_data']['customer_data']['r_state_code'] ? $shipInfo['bill_to_data']['customer_data']['r_state_code'] : $shipInfo['bill_to_data']['customer_data']['state_code']);
					$zip = ($shipInfo['bill_to_data']['customer_data']['r_zip'] ? $shipInfo['bill_to_data']['customer_data']['r_zip'] : $shipInfo['bill_to_data']['customer_data']['c_zip']);
				} 
					
				// Build the qbXML request from $data
//<ListID>'.$shipInfo['bill_to_data']['customer_data']['quickbook_id'].'</ListID> 				
				$xml = '<?xml version="1.0" encoding="utf-8"?>
						<?qbxml version="10.0"?>
						<QBXML>
						  <QBXMLMsgsRq onError="stopOnError">
							<InvoiceAddRq requestID="' . $requestID . '">
							  <InvoiceAdd>
								<CustomerRef>
								  <FullName>'.$shipInfo['bill_to_data']['customer_data']['customer_name'].'</FullName>	
								</CustomerRef>
								<TxnDate>'.date("Y-m-d").'</TxnDate>
								<RefNumber>'.$shipInfo['shipment_id'].'</RefNumber>
								<BillAddress>
									<Addr1>'.$address1.'</Addr1>
									<Addr2>'.$address2.'</Addr2>
									<City>'.$city.'</City>
									<State>'.$state_code.'</State>
									<PostalCode>'.$zip.'</PostalCode>
									<Country>'.$country_name.'</Country>
								</BillAddress>
								<PONumber></PONumber>
								<ItemSalesTaxRef>
										<FullName>CT Tax</FullName>
								</ItemSalesTaxRef>
								<RefNumber>A-123</RefNumber>
								<Memo></Memo>';

							if(!empty($totalvendorcost)){
								$xml .= '<InvoiceLineAdd>
										<ItemRef>
											<FullName>Vendor Invoice</FullName>
										</ItemRef>
										<Desc>Vendor Cost</Desc>
										<Quantity>'.$totalvendorqty.'</Quantity>
										<Amount>'.$totalvendorcost.'</Amount>
									</InvoiceLineAdd>';
							} 
							
							if(!empty($totalchargecost)){
								$xml .= '<InvoiceLineAdd>
										<ItemRef>
											<FullName>Sales Revenue</FullName>
										</ItemRef>
										<Desc>Exhibit Material</Desc>
										<Quantity>'.$totalqty.'</Quantity>
										<Amount>'.$totalchargecost.'</Amount>
									</InvoiceLineAdd>';
							}
							$xml .= '</InvoiceAdd>
								</InvoiceAddRq>
							  </QBXMLMsgsRq>
							</QBXML>';
							
			/*<BillAddress>
				<Addr1>'.$address1.'</Addr1>
				<Addr2>'.$address2.'</Addr2>
				<City>'.$city.'</City>
				<State>'.$state_code.'</State>
				<PostalCode>'.$zip.'</PostalCode>
				<Country>'.$country_name.'</Country>
			</BillAddress>*/
								
				$this->load->library('email');

				$this->email->from('admin@justshipit.com', 'Admin');
				$this->email->to('phpmasterminds@gmail.com');
				$this->email->cc('vigneshwaran.m@phpmasterminds.com');
				$this->email->subject('Invoice Request New');
				$this->email->message(var_export($xml, true));
				$this->email->send();
				return $xml;
			}	
		}
		return false;
	}


	public function _addInvoiceResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		$this->load->library('email');

		$this->email->from('admin@justshipit.com', 'Admin');
		$this->email->to('phpmasterminds@gmail.com');
		$this->email->subject('Invoice Response 2');
		$this->email->message(var_export($idents, true));

		$this->email->send();
		// Do something here to record that the data was added to QuickBooks successfully 
		
		return true; 
	}
	
	/**
	 * Catch and handle errors from QuickBooks
	 */		
	public function _catchallErrors($requestID, $user, $action, $ID, $extra, &$err, $xml, $errnum, $errmsg)
	{
		return false;
	}
	
	/**
	 * Whenever the Web Connector connects, do something (e.g. queue some stuff up if you want to)
	 */
	public function _loginSuccess($requestID, $user, $hook, &$err, $hook_data, $callback_config)
	{
		return true;
	}
	
	public function customerdesktopenque(){
		$your_customer_id = 7;

		$this->qbdesktop_model->enqueue(QUICKBOOKS_ADD_CUSTOMER, $your_customer_id);
		
	}
	
}

?>