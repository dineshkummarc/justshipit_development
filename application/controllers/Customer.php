<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';



class Customer extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('shipment_model');
        $this->load->model('customer_model');
        $this->isLoggedIn(); 
		$this->load->library('Ajax_pagination');
        $this->perPage = 20;
        $this->aQuickConfigData = $this->aQuickConfig;

		$this->load->config('quickbooks');
		
		$this->load->model('qbdesktop_model');
		
		$this->qbdesktop_model->dsn('mysqli://' . $this->db->username . ':' . $this->db->password . '@' . $this->db->hostname . '/' . $this->db->database);
		
    }
    

    
    /**
     * This function is used to load the user list
     */
    function customerListing($rowno=0)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {        
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $searchCode = $this->security->xss_clean($this->input->post('searchCode'));
            $searchCity = $this->security->xss_clean($this->input->post('searchCity'));
			
			$sortBy="customer_id";
			$order="desc";
			$rowperpage = 15;
			
			if($this->input->get('sort_by')){
				$sortBy=$this->input->get('sort_by');
			}
			
			if($this->input->get('order')){
				$order=$this->input->get('order');
			}
			
			if($rowno != 0){ 
			   $rowno = ($rowno-1) * $rowperpage; 
			}
            $data['searchText'] = $searchText;
            $data['searchCode'] = $searchCode;
            $data['searchCity'] = $searchCity;
            $data['aorder'] = $order;
            $this->load->library('pagination');
            
            $count = $this->customer_model->customerListingCount($data);

			$returns = $this->paginationCompress ( "customerListing/", $count, $rowperpage );
            
            $data['customerRecords'] = $this->customer_model->customerListing($data, $returns["page"], $returns["segment"], $sortBy,$order);
            
            $this->global['pageTitle'] = 'JustShipIt : Customer Listing';
            
            $this->loadViews("customers/customers", $this->global, $data, NULL);
        }
    }
	
	function vendorListing($rowno=0)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {        
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $searchCode = $this->security->xss_clean($this->input->post('searchCode'));
            $searchCity = $this->security->xss_clean($this->input->post('searchCity'));
			
            $sortBy="customer_id";
			$order="desc";
			$rowperpage = 15;
			
			if($this->input->get('sort_by')){
				$sortBy=$this->input->get('sort_by');
			}
			
			if($this->input->get('order')){
				$order=$this->input->get('order');
			}
			
			if($rowno != 0){ 
			   $rowno = ($rowno-1) * $rowperpage; 
			}
            $data['searchText'] = $searchText;
            $data['searchCode'] = $searchCode;
            $data['searchCity'] = $searchCity;
            $data['aorder'] = $order;
            $this->load->library('pagination');
            
            $count = $this->customer_model->vendorListingCount($data);

			$returns = $this->paginationCompress ( "vendorListing/", $count, $rowperpage );
            
            $data['customerRecords'] = $this->customer_model->vendorListing($data, $returns["page"], $returns["segment"], $sortBy,$order);
            
            $this->global['pageTitle'] = 'JustShipIt : Vendor Listing';
            
            $this->loadViews("customers/vendors", $this->global, $data, NULL);
        }
    }
	
	public function checkCustomer(){
		// POST data
		$postData = $this->input->post();

		// Get data
		$datas = $this->customer_model->checkCustomer($postData);

		echo json_encode($datas);
	}
	
	public function checkCustomerpopup(){
		// POST data
		$postData = $this->input->post();
            
		$totalRec = $this->customer_model->checkCustomerpopupCount($postData);
		
		if(!empty($postData['is_shipper'])) {
			$data['popup_title'] = 'Shippers Customer Datas';
		}
		if(!empty($postData['is_bill_to'])) {
			$data['popup_title'] = 'Bill To Customer Datas';
		}
		if(!empty($postData['is_consignee'])) {
			$data['popup_title'] = 'Consignee Customer Datas';
		}
		
		if(!empty($postData['is_sales'])) {
			$data['popup_title'] = 'Sale Person Datas';
		}
		
		//pagination configuration
        $config['first_link']  = 'First';
        $config['target']      = '.customer_div_ref'; //parent div tag id
        $config['base_url']    = base_url().'ajaxCustomerData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['extraParam']  = $postData;
        
        $this->ajax_pagination->initialize($config);
		
		$data['customerRecords'] = $this->customer_model->checkCustomerpopup($postData, $offset=0, $this->perPage);
		$data['postData'] = $postData;
		
		$this->load->view("customers/customerspopup", $data);		
		//$this->loadViews("customers/customerspopup", $this->global, $data, NULL);
	}
	
	public function ajaxCustomerData(){
	
		$postData = $this->input->post();
		
		$page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //total rows count
        $totalRec = $this->customer_model->checkCustomerpopupCount($postData);
        
        //pagination configuration
         $config['first_link']  = 'First';
        $config['target']      = '.customer_div_ref'; //parent div tag id
        $config['base_url']    = base_url().'ajaxCustomerData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['extraParam']  = $postData;
        
        $this->ajax_pagination->initialize($config);
        
		$data['customerRecords'] = $this->customer_model->checkCustomerpopup($postData, $offset, $this->perPage);
		$data['postData'] = $postData;
		
        //load the view
        $this->load->view('customers/customerAjax', $data);
	}
  
	function addNewCustomer($catid = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('customer_model');
            $data['cus_datas'] = array();
            $data['countries'] = $this->customer_model->getCountries();
			$data['airports'] = $this->customer_model->getAirports();
            $data['states'] = array();
            $data['reftypes'] = $this->customer_model->getRefTypes();
            
			$data['stations'] = $this->customer_model->getStations(); 
			
			$data['pay_terms'] = $this->customer_model->getPayTerms(); 
			$data['catid'] = $catid; 
			
            $this->global['pageTitle'] = 'JustShipIt : Add New Customer';

            $this->loadViews("customers/addNewCustomer", $this->global, $data, NULL);
        }
    }

	function getStateList($id){
		$states = $this->customer_model->getStateList($id);
		echo json_encode($states);
	}
	
	function getCustomerData($id){
		$userInfo = $this->customer_model->getCustomerInfo($id);
		
		echo json_encode($userInfo);
	}
	
	function getCustomerDatawithShip($shipid, $type, $from){
		
		$shipInfo = $this->shipment_model->getDomesticInfo($shipid);
		
		$userInfo = array();
		if($type == 1){
			/*$userInfo = $this->customer_model->getCustomerInfo($shipInfo['shipper_data']['org_s_shipper_id']);*/
			$userInfo = $shipInfo['shipper_data'];
			$userInfo['customer_id'] = $shipInfo['shipper_data']['org_s_shipper_id'];
			$userInfo['customer_name'] = $shipInfo['shipper_data']['shipper_name'];
		}elseif($type == 2){
			/* $userInfo = $this->customer_model->getCustomerInfo($shipInfo['consignee_data']['org_c_shipper_id']); */
			$userInfo = $shipInfo['consignee_data'];
			$userInfo['customer_id'] = $shipInfo['consignee_data']['org_c_shipper_id'];
			$userInfo['customer_name'] = $shipInfo['consignee_data']['c_shipper_name'];
		}elseif($type == 3){

			if($from == 'delivery'){
				$aVenRecord = $this->shipment_model->loadSelectedVendorsbasedonid($shipid, 8);
				if(!empty($aVenRecord)){
					$userInfo = $this->customer_model->getCustomerInfo($aVenRecord['p_vendor_id']);
				}
			}else{
				$aVenRecord = $this->shipment_model->loadSelectedVendorsbasedonid($shipid, 5);
				if(!empty($aVenRecord)){
					$userInfo = $this->customer_model->getCustomerInfo($aVenRecord['p_vendor_id']);
				}
			}
			
		}elseif($type == 0){
			$userInfo = array(
				's_shipper_id' => 0,
				'customer_id' => 0,
				'customer_name' => 'Fastline Logistics LLC',
				's_address_1' => 'P.O Box 266',
				's_address_2' => '',
				's_city' => 'Centerton',
				's_zip' => '72719',
				's_country' => 2,
				's_default_ref' => 0,
				's_contact' => 'Chris Ringhausen',
				's_phone' => '1-800-540-6100',
				's_state' => 3,			
			);
			
		}
		
		echo json_encode($userInfo);
	}
	
	function saveNewCustomer()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('customer_name','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('c_address_1','Address','trim|required|max_length[300]');
            $this->form_validation->set_rules('c_city','City','trim|required|max_length[128]');
            //$this->form_validation->set_rules('c_email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('c_country','Country','trim|required|numeric');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewCustomer();
            }
            else
            {
				$customer_name = ucwords($this->security->xss_clean($this->input->post('customer_name')));
				$category_id = $this->input->post('category_id');
				$c_address_1 = $this->input->post('c_address_1');
				$isExist = $this->customer_model->getCustomerExist($customer_name, $c_address_1, $customer_id=0, $category_id);
				
                if(!empty($isExist)){
					if($category_id == 2){
						$this->session->set_flashdata('error', 'Vendor Data Already Exist!');
					}else{
						$this->session->set_flashdata('error', 'Customer Data Already Exist!');
					}
					$this->addNewCustomer();
					return;
				}
				
                $c_email = strtolower($this->security->xss_clean($this->input->post('c_email')));
                $c_ap_email = strtolower($this->security->xss_clean($this->input->post('c_ap_email')));
                
                $c_address_2 = $this->input->post('c_address_2');
                $c_city = ucwords(strtolower($this->security->xss_clean($this->input->post('c_city'))));
                $c_state = $this->input->post('c_state');
                $c_zip = $this->input->post('c_zip');
                $c_country = $this->input->post('c_country');
                $c_phone = $this->security->xss_clean($this->input->post('c_phone'));
                $c_toll_free_phone = $this->security->xss_clean($this->input->post('c_toll_free_phone'));
                $c_fax = $this->input->post('c_fax');
                $c_contact = $this->input->post('c_contact');
                $c_default_ref = $this->input->post('c_default_ref');
                $c_def_ref_type = $this->input->post('c_def_ref_type');
                $account_no = $this->input->post('account_no');
                $account_ein = $this->input->post('account_ein');
                $default_airport_code = $this->input->post('default_airport_code');
                $default_area = $this->input->post('default_area');
                $most_recent_ship_date = $this->input->post('most_recent_ship_date');
                $fist_ship_date = $this->input->post('fist_ship_date');
                $same_address = ($this->input->post('same_address') ? $this->input->post('same_address') : 0);
                $is_active = $this->input->post('is_active');
                $inactivate_date = $this->input->post('inactivate_date');
                
				$extraapcodes = array();
				$extra_ap_codes = $this->input->post('extra_ap_codes');
                if(!empty($extra_ap_codes)){
					foreach($extra_ap_codes['default_airport_code'] as $key => $cnt){
						if(!empty($cnt)){
							$extraapcodes[$key]['airport_name'] = ($extra_ap_codes['default_airport_name'][$key] ? $extra_ap_codes['default_airport_name'][$key] : '');
							$extraapcodes[$key]['airport_code'] = $cnt;
						}
					}
				}
				$extraapcodes = json_encode($extraapcodes);
				
				if($same_address == 1){
					$r_name = $customer_name;
					$r_email = $c_email;
					$r_address_1 = $c_address_1;
					$r_address_2 = $c_address_2;
					$r_city = $c_city;
					$r_state = $c_state;
					$r_zip = $c_zip;
					$r_country = $c_country;
					$r_phone = $c_phone;
					$r_fax = $c_fax;
				}else{
					$r_name = ucwords($this->security->xss_clean($this->input->post('r_name')));
					$r_email = strtolower($this->security->xss_clean($this->input->post('r_email')));
					$r_address_1 = $this->input->post('r_address_1');
					$r_address_2 = $this->input->post('r_address_2');
					$r_city = ucwords(strtolower($this->security->xss_clean($this->input->post('r_city'))));
					$r_state = $this->input->post('r_state');
					$r_zip = $this->input->post('r_zip');
					$r_country = $this->input->post('r_country');
					$r_phone = $this->security->xss_clean($this->input->post('r_phone'));
					$r_fax = $this->input->post('r_fax');
				}
				
                $userInfo = array(
					'customer_name'=> $customer_name, 
					'c_email'=> $c_email, 
					'c_ap_email'=>$c_ap_email, 
					'c_address_1'=>$c_address_1, 
					'c_address_2'=>$c_address_2, 
					'c_city'=>$c_city, 
					'c_state'=>$c_state, 
					'c_zip'=>$c_zip, 
					'c_country'=>$c_country, 
					'c_phone'=>$c_phone, 
					'c_toll_free_phone'=>$c_toll_free_phone, 
					'c_fax'=>$c_fax, 
					'c_contact'=>$c_contact, 
					'c_default_ref'=>$c_default_ref, 
					'c_def_ref_type'=>$c_def_ref_type, 
					'account_no'=>$account_no, 
					'account_ein'=>$account_ein, 
					'default_airport_code'=>$default_airport_code, 
					'default_area'=>$default_area, 
					'most_recent_ship_date'=>($most_recent_ship_date ? date('Y-m-d',strtotime($most_recent_ship_date)) : null),
					'fist_ship_date'=>($fist_ship_date ? date('Y-m-d',strtotime($fist_ship_date)) : null),
					'same_address' => $same_address,
					'r_name' => $r_name,
					'r_email' => $r_email,
					'r_address_1' => $r_address_1,
					'r_address_2' => $r_address_2,
					'r_city' => $r_city,
					'r_state' => $r_state,
					'r_zip' => $r_zip,
					'r_country' => $r_country,
					'r_phone' => $r_phone,
					'r_fax' => $r_fax,
					'is_active' => ($is_active ? $is_active : 0),
					'inactivate_date' => ($inactivate_date ? date('Y-m-d',strtotime($inactivate_date)) : null),
					'createdBy'=>$this->vendorId,
					'createdDtm'=>date('Y-m-d H:i:s'),
					'category_id'=>$category_id,
					'extra_ap_codes'=>$extraapcodes
				);
               
                $this->load->model('customer_model');
                $result = $this->customer_model->saveNewCustomer($userInfo);
                
                if($result > 0)
                {
					
					if(!empty($default_airport_code)){
						$aInfo = $this->shipment_model->getAirportInfo($default_airport_code);
						$airportname = strtoupper($aInfo->airport_code);
					}else{
						$airportname = strtoupper('AAA');
					}
					$customer_name = str_replace(' ', '', $customer_name);
					$custname = strtoupper(substr($customer_name,0,4));
					$customernumber = $custname.$airportname;
					$finalCustomerNumber = $this->customer_model->generateCustomerCode($customernumber);
					$userUpdateInfo = array(
						'file_number' => 'JS'.str_pad($result, 5, '0', STR_PAD_LEFT),
						'customer_number' => $finalCustomerNumber
					);
					
					$this->customer_model->updateCustomer($userUpdateInfo, $result);
					
					
					$userSecondaryInfo = array(
						'customer_id' => $result,
						'is_shipper' => ($this->input->post('is_shipper')? $this->input->post('is_shipper') : 0),
						'is_consignee' => ($this->input->post('is_consignee')? $this->input->post('is_consignee') : 0),
						'is_bill_to' => ($this->input->post('is_bill_to')? $this->input->post('is_bill_to') : 0),
						'is_pickup_delivery' => ($this->input->post('is_pickup_delivery')? $this->input->post('is_pickup_delivery') : 0),
						'is_line_haul' => ($this->input->post('is_line_haul') ? $this->input->post('is_line_haul') : 0),
						'is_airline' => ($this->input->post('is_airline') ? $this->input->post('is_airline') : 0),
						'is_truckload' => ($this->input->post('is_truckload') ? $this->input->post('is_truckload') : 0),
						'is_ltl' => ($this->input->post('is_ltl') ? $this->input->post('is_ltl') : 0),
						'is_customs_broker' => ($this->input->post('is_customs_broker')? $this->input->post('is_customs_broker') : 0),
						'is_sales' => ($this->input->post('is_sales')? $this->input->post('is_sales') : 0),
						'sales_commission_percent' => $this->input->post('sales_commission_percent'),
						'is_miscellaneous' => ($this->input->post('is_miscellaneous')? $this->input->post('is_miscellaneous') : 0),
						'sales_person' => $this->input->post('sales_person'),
						'bill_customer_number' => $this->input->post('bill_customer_number'),
						'station' => $this->input->post('station'),
						'qb_list_id' => $this->input->post('qb_list_id'),
						'credit_limit' => $this->input->post('credit_limit'),
						'requested_credit_limit' => $this->input->post('requested_credit_limit'),
						'credit_score' => $this->input->post('credit_score'),
						'payment_term' => $this->input->post('payment_term'),
						'invoicing' => ($this->input->post('invoicing')? $this->input->post('invoicing') : 0),
						'itemized_charges' => ($this->input->post('itemized_charges')? $this->input->post('itemized_charges') : 0),
						'requirements' => $this->input->post('requirements'),
						'special_instructions' => $this->input->post('special_instructions'),
						'after_hours' => $this->input->post('after_hours'),
						'handling_instructions' => $this->input->post('handling_instructions'),
						'pickup_instructions' => $this->input->post('pickup_instructions'),
						'invoice_notes' => $this->input->post('invoice_notes'),
						'delivery_instructions' => $this->input->post('delivery_instructions'),
						'notes_of_interest' => $this->input->post('notes_of_interest'),
						'tsa_known_shipper' => ($this->input->post('tsa_known_shipper')? $this->input->post('tsa_known_shipper') : 0),
						'tsa_approved_vendor' => ($this->input->post('tsa_approved_vendor')? $this->input->post('tsa_approved_vendor') : 0),
						'ksms_verification_date' => ($this->input->post('ksms_verification_date')? date('Y-m-d',strtotime($this->input->post('ksms_verification_date'))) : null),
						'revalidation_date' => ($this->input->post('revalidation_date')? date('Y-m-d',strtotime($this->input->post('revalidation_date'))) : null),
						'blanket_screening_letter' => ($this->input->post('blanket_screening_letter')? $this->input->post('blanket_screening_letter') : 0),
						'ksms_id' => $this->input->post('ksms_id'),
						'reverified_by' => $this->input->post('reverified_by'),
						'cannot_known_shipper' => ($this->input->post('cannot_known_shipper')? $this->input->post('cannot_known_shipper') : 0),
					);
					
					$this->customer_model->saveSecondaryInfo($userSecondaryInfo);
					
										
					/* $this->customer_model->updateCustomertoQuickbook($result); */
					
					if($category_id == 2){
						$this->qbdesktop_model->enqueue(QUICKBOOKS_ADD_VENDOR, $result);
					}else{
						$this->qbdesktop_model->enqueue(QUICKBOOKS_ADD_CUSTOMER, $result);
					}
					
					$quickerror = '';
					
					/* if($aResponse['response_status'] == 'success'){
						$uUpdateInfo = array(
							'quickbook_id' => $aResponse['quickbook_id'],
						);
						
						$this->customer_model->updateCustomer($uUpdateInfo, $result);
					}
					
					
					if($aResponse['response_status'] == 'error'){
						$quickerror = ' Quickbook connection failed! ERROR :'.$aResponse['response_message'];
					} */
					
					if($category_id == 2){
						$this->session->set_flashdata('success', 'New Vendor created successfully'.$quickerror);
					}else{
						$this->session->set_flashdata('success', 'New Customer created successfully'.$quickerror);
					}
					
                }
                else
                {
					if($category_id == 2){
						$this->session->set_flashdata('error', 'Vendor creation failed');
					}else{
						$this->session->set_flashdata('error', 'Customer creation failed');
					}
                }
                
				if($category_id == 2){
					redirect('vendorListing');
				}else{
					redirect('customerListing');
				}
            }
        }
    }
	
	function checkCustomerEmailExists()
    {
        $customer_id = $this->input->post("customer_id");
        $email = $this->input->post("c_email");

        if(empty($customer_id)){
            $result = $this->customer_model->checkCustomerEmailExists($email);
        } else {
            $result = $this->customer_model->checkCustomerEmailExists($email, $customer_id);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
	
	function deleteCustomer()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $customerid = $this->input->post('customerid');
            $userInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->customer_model->deleteCustomer($customerid, $userInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	function editOldCustomer($customerid = NULL)
    {
        if($this->isAdmin() == TRUE )
        {
            $this->loadThis();
        }
        else
        {
            if($customerid == null)
            {
                redirect('customerListing');
            }
            $data['cus_datas'] = array();
            $data['countries'] = $this->customer_model->getCountries();
            $data['airports'] = $this->customer_model->getAirports();
			
            $data['states'] = array();
            $data['rstates'] = array();
			
            $data['reftypes'] = $this->customer_model->getRefTypes();
			
			$data['stations'] = $this->customer_model->getStations(); 
			
            $data['pay_terms'] = $this->customer_model->getPayTerms(); 
			
            $userInfo = $this->customer_model->getCustomerInfo($customerid);
			
			if(!empty($userInfo->r_country)){
				$data['rstates'] = $this->customer_model->getStateList($userInfo->r_country);
			}
			
			if(!empty($userInfo->c_country)){
				$data['states'] = $this->customer_model->getStateList($userInfo->c_country);
			}
			
            $data['userInfo'] = $userInfo;
               
			$data['extra_ap_codes'] = (array) json_decode($userInfo->extra_ap_codes);
			  
            $this->global['pageTitle'] = 'JustShipIt : Edit Customer';
            
            $this->loadViews("customers/editOldCustomer", $this->global, $data, NULL);
        }
    }
	
	function saveOldCustomer()
    { 
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        { 
            $this->load->library('form_validation');
            
            $customer_id = $this->input->post('customer_id');
            
            $this->form_validation->set_rules('customer_name','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('c_address_1','Address','trim|required|max_length[300]');
            $this->form_validation->set_rules('c_city','City','trim|required|max_length[128]');
            //$this->form_validation->set_rules('c_email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('c_country','Country','trim|required|numeric');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOldCustomer($customer_id);
            }
            else
            {

				$customer_name = ucwords($this->security->xss_clean($this->input->post('customer_name')));
				$category_id = $this->input->post('category_id');
				$c_address_1 = $this->input->post('c_address_1');
				
				$isExist = $this->customer_model->getCustomerExist($customer_name, $c_address_1, $customer_id, $category_id);
				
                if(!empty($isExist)){
					
					if($category_id == 2){
						$this->session->set_flashdata('error', 'Vendor Data Already Exist!');
					}else{
						$this->session->set_flashdata('error', 'Customer Data Already Exist!');
					}
					$this->editOldCustomer($customer_id);
					return;
				}
                
                $c_email = strtolower($this->security->xss_clean($this->input->post('c_email')));
                $c_ap_email = strtolower($this->security->xss_clean($this->input->post('c_ap_email')));
                
                $c_address_2 = $this->input->post('c_address_2');
                $c_city = ucwords(strtolower($this->security->xss_clean($this->input->post('c_city'))));
                $c_state = $this->input->post('c_state');
                $c_zip = $this->input->post('c_zip');
                $c_country = $this->input->post('c_country');
                $c_phone = $this->security->xss_clean($this->input->post('c_phone'));
                $c_toll_free_phone = $this->security->xss_clean($this->input->post('c_toll_free_phone'));
                $c_fax = $this->input->post('c_fax');
                $c_contact = $this->input->post('c_contact');
                $c_default_ref = $this->input->post('c_default_ref');
                $c_def_ref_type = $this->input->post('c_def_ref_type');
                $account_no = $this->input->post('account_no');
                $account_ein = $this->input->post('account_ein');
                $default_airport_code = $this->input->post('default_airport_code');
                $default_area = $this->input->post('default_area');
                $most_recent_ship_date = $this->input->post('most_recent_ship_date');
                $fist_ship_date = $this->input->post('fist_ship_date');
                $same_address = ($this->input->post('same_address') ? $this->input->post('same_address') : 0);
                $is_active = $this->input->post('is_active');
                $inactivate_date = $this->input->post('inactivate_date');
                
                
				$extraapcodes = array();
				$extra_ap_codes = $this->input->post('extra_ap_codes');
                if(!empty($extra_ap_codes)){
					foreach($extra_ap_codes['default_airport_code'] as $key => $cnt){
						if(!empty($cnt)){
							$extraapcodes[$key]['airport_name'] = ($extra_ap_codes['default_airport_name'][$key] ? $extra_ap_codes['default_airport_name'][$key] : '');
							$extraapcodes[$key]['airport_code'] = $cnt;
						}
					}
				}
				$extraapcodes = json_encode($extraapcodes);
				
				if($same_address == 1){
					$r_name = $customer_name;
					$r_email = $c_email;
					$r_address_1 = $c_address_1;
					$r_address_2 = $c_address_2;
					$r_city = $c_city;
					$r_state = $c_state;
					$r_zip = $c_zip;
					$r_country = $c_country;
					$r_phone = $c_phone;
					$r_fax = $c_fax;
				}else{
					$r_name = ucwords($this->security->xss_clean($this->input->post('r_name')));
					$r_email = strtolower($this->security->xss_clean($this->input->post('r_email')));
					$r_address_1 = $this->input->post('r_address_1');
					$r_address_2 = $this->input->post('r_address_2');
					$r_city = ucwords(strtolower($this->security->xss_clean($this->input->post('r_city'))));
					$r_state = $this->input->post('r_state');
					$r_zip = $this->input->post('r_zip');
					$r_country = $this->input->post('r_country');
					$r_phone = $this->security->xss_clean($this->input->post('r_phone'));
					$r_fax = $this->input->post('r_fax');
				}
				
                $userInfo = array(
					'customer_name'=> $customer_name, 
					'c_email'=> $c_email, 
					'c_ap_email'=>$c_ap_email, 
					'c_address_1'=>$c_address_1, 
					'c_address_2'=>$c_address_2, 
					'c_city'=>$c_city, 
					'c_state'=>$c_state, 
					'c_zip'=>$c_zip, 
					'c_country'=>$c_country, 
					'c_phone'=>$c_phone, 
					'c_toll_free_phone'=>$c_toll_free_phone, 
					'c_fax'=>$c_fax, 
					'c_contact'=>$c_contact, 
					'c_default_ref'=>$c_default_ref, 
					'c_def_ref_type'=>$c_def_ref_type, 
					'account_no'=>$account_no, 
					'account_ein'=>$account_ein, 
					'default_airport_code'=>$default_airport_code, 
					'default_area'=>$default_area, 
					'most_recent_ship_date'=>($most_recent_ship_date ? date('Y-m-d',strtotime($most_recent_ship_date)) : null),
					'fist_ship_date'=>($fist_ship_date ? date('Y-m-d',strtotime($fist_ship_date)) : null),
					'same_address' => $same_address,
					'r_name' => $r_name,
					'r_email' => $r_email,
					'r_address_1' => $r_address_1,
					'r_address_2' => $r_address_2,
					'r_city' => $r_city,
					'r_state' => $r_state,
					'r_zip' => $r_zip,
					'r_country' => $r_country,
					'r_phone' => $r_phone,
					'r_fax' => $r_fax,
					'is_active' => ($is_active ? $is_active : 0),
					'inactivate_date' => ($inactivate_date ? date('Y-m-d',strtotime($inactivate_date)) : null),
					'updatedBy'=>$this->vendorId, 
                    'updatedDtm'=>date('Y-m-d H:i:s'),
					'category_id'=>$category_id,
					'extra_ap_codes'=>$extraapcodes
				);
                
				if(!empty($default_airport_code)){
					$aInfo = $this->shipment_model->getAirportInfo($default_airport_code);
					$airportname = strtoupper($aInfo->airport_code);
				}else{
					$airportname = strtoupper('AAA');
				}
				
				$defuserInfo = $this->customer_model->getCustomerInfo($customer_id);
				
				if(empty($defuserInfo->customer_number) || ($default_airport_code != $defuserInfo->default_airport_code)){
					$customer_name = str_replace(' ', '', $customer_name);
					$custname = strtoupper(substr($customer_name,0,4));
					$customernumber = $custname.$airportname;
					$finalCustomerNumber = $this->customer_model->generateCustomerCode($customernumber, $customer_id);
					$userInfo['customer_number'] = $finalCustomerNumber;
				}
				
                $result = $this->customer_model->updateCustomer($userInfo, $customer_id);
                
                if($result == true)
                {
				
					
					
					$count = $this->customer_model->checkSecondaryInfo($customer_id);
					
					$userSecondaryInfo = array(
						'customer_id' => $customer_id,
						'is_shipper' => ($this->input->post('is_shipper')? $this->input->post('is_shipper') : 0),
						'is_consignee' => ($this->input->post('is_consignee')? $this->input->post('is_consignee') : 0),
						'is_bill_to' => ($this->input->post('is_bill_to')? $this->input->post('is_bill_to') : 0),
						'is_pickup_delivery' => ($this->input->post('is_pickup_delivery')? $this->input->post('is_pickup_delivery') : 0),
						'is_line_haul' => ($this->input->post('is_line_haul') ? $this->input->post('is_line_haul') : 0),
						'is_airline' => ($this->input->post('is_airline') ? $this->input->post('is_airline') : 0),
						'is_truckload' => ($this->input->post('is_truckload') ? $this->input->post('is_truckload') : 0),
						'is_ltl' => ($this->input->post('is_ltl') ? $this->input->post('is_ltl') : 0),
						'is_customs_broker' => ($this->input->post('is_customs_broker')? $this->input->post('is_customs_broker') : 0),
						'is_sales' => ($this->input->post('is_sales')? $this->input->post('is_sales') : 0),
						'sales_commission_percent' => $this->input->post('sales_commission_percent'),
						'is_miscellaneous' => ($this->input->post('is_miscellaneous')? $this->input->post('is_miscellaneous') : 0),
						'sales_person' => $this->input->post('sales_person'),
						'bill_customer_number' => $this->input->post('bill_customer_number'),
						'station' => $this->input->post('station'),
						'qb_list_id' => $this->input->post('qb_list_id'),
						'credit_limit' => $this->input->post('credit_limit'),
						'requested_credit_limit' => $this->input->post('requested_credit_limit'),
						'credit_score' => $this->input->post('credit_score'),
						'payment_term' => $this->input->post('payment_term'),
						'invoicing' => ($this->input->post('invoicing')? $this->input->post('invoicing') : 0),
						'itemized_charges' => ($this->input->post('itemized_charges')? $this->input->post('itemized_charges') : 0),
						'requirements' => $this->input->post('requirements'),
						'special_instructions' => $this->input->post('special_instructions'),
						'after_hours' => $this->input->post('after_hours'),
						'handling_instructions' => $this->input->post('handling_instructions'),
						'pickup_instructions' => $this->input->post('pickup_instructions'),
						'invoice_notes' => $this->input->post('invoice_notes'),
						'delivery_instructions' => $this->input->post('delivery_instructions'),
						'notes_of_interest' => $this->input->post('notes_of_interest'),
						'tsa_known_shipper' => ($this->input->post('tsa_known_shipper')? $this->input->post('tsa_known_shipper') : 0),
						'tsa_approved_vendor' => ($this->input->post('tsa_approved_vendor')? $this->input->post('tsa_approved_vendor') : 0),						
						'ksms_verification_date' => ($this->input->post('ksms_verification_date')? date('Y-m-d',strtotime($this->input->post('ksms_verification_date'))) : null),
						'revalidation_date' => ($this->input->post('revalidation_date')? date('Y-m-d',strtotime($this->input->post('revalidation_date'))) : null),
						'blanket_screening_letter' => ($this->input->post('blanket_screening_letter')? $this->input->post('blanket_screening_letter') : 0),
						'ksms_id' => $this->input->post('ksms_id'),
						'reverified_by' => $this->input->post('reverified_by'),
						'cannot_known_shipper' => ($this->input->post('cannot_known_shipper')? $this->input->post('cannot_known_shipper') : 0),
					);
					
					if($count >= 1){
						$this->customer_model->updateSecondaryInfo($userSecondaryInfo, $customer_id);
						
					}else{
						$this->customer_model->saveSecondaryInfo($userSecondaryInfo);
					}
					
					$this->customer_model->changeCDataToActiveShipments($customer_id);
					
                    
					$aResponse = $this->customer_model->updateCustomertoQuickbook($customer_id); 
					
					if($aResponse['response_status'] == 'success'){
						/*$uUpdateInfo = array(
							'quickbook_id' => $aResponse['quickbook_id'],
						);
						
						$this->customer_model->updateCustomer($uUpdateInfo, $customer_id);*/
					}
					
					$quickerror = '';
					if($aResponse['response_status'] == 'error'){
						$quickerror = ' Quickbook connection failed! ERROR :'.$aResponse['response_message'];
					}
					
					if($category_id == 2){
						$this->session->set_flashdata('success', 'Vendor updated successfully'.$quickerror);
					}else{
						$this->session->set_flashdata('success', 'Customer updated successfully'.$quickerror);
					}
					
                }
                else
                {
					if($category_id == 2){
						$this->session->set_flashdata('error', 'Vendor updation failed');
					}else{
						$this->session->set_flashdata('error', 'Customer updation failed');
					}
                    
                }
                
                if($category_id == 2){
					redirect('vendorListing');
				}else{
					redirect('customerListing');
				}
            }
        }

    }
	
	public function customerquickbook(){ 
		/*moved to cusomter model page*/
		$this->customer_model->customerquickbook();
	}
	
	
   
}

?>