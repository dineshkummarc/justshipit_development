<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Class : User_model (User Model)
 * User model class to get to handle user related data 
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Customer_model extends CI_Model
{
	 
    
	
	public function __construct()
    {
		
    }
	
	 function checkCustomer($postData){

		 $response = array();
		
		 if(isset($postData['search']) ){
		   // Select record

			$this->db->select('BaseTbl.*');
			$this->db->from('tbl_customers as BaseTbl');
			$this->db->join('tbl_customer_secondary as csec', 'csec.customer_id = BaseTbl.customer_id','left');
			if(!empty($postData['search'])) {
				$likeCriteria = "(BaseTbl.customer_number  LIKE '%".$postData['search']."%')";
				$this->db->where($likeCriteria);
			}
			if(!empty($postData['is_shipper'])) {
				$this->db->where("csec.is_shipper  = 1");
			}
			if(!empty($postData['is_bill_to'])) {
				$this->db->where("csec.is_bill_to  = 1");
			}
			if(!empty($postData['is_consignee'])) {
				$this->db->where("csec.is_consignee  = 1");
			}
			$this->db->where('BaseTbl.isDeleted', 0);
			$this->db->order_by('BaseTbl.customer_id', 'DESC');
			$query = $this->db->get();
			
			$records = $query->result();  
		    
			if(!empty($records)){
				foreach($records as $row ){
				  $response[] = array("customer_id"=>$row->customer_id,"customer_number"=>$row->customer_number,"label"=>$row->customer_name);
				}
			}else{
				$response[] = array("customer_id"=>0,"customer_number"=>'',"label"=>'No Data Found');
			}

		 }

		 return $response;
	  } 
	  
	  function checkCustomerpopupCount($postData = '')
		{
			$this->db->select('BaseTbl.customer_id');
			$this->db->from('tbl_customers as BaseTbl');
			$this->db->join('tbl_customer_secondary as csec', 'csec.customer_id = BaseTbl.customer_id','left');

			if(!empty($postData['search'])) {
				$likeCriteria = "(BaseTbl.c_email  LIKE '%".$postData['search']."%'
                            OR  BaseTbl.customer_name  LIKE '%".$postData['search']."%'
                            OR  BaseTbl.c_phone  LIKE '%".$postData['search']."%')";
				$this->db->where($likeCriteria);
			}
			if(!empty($postData['is_shipper'])) {
				$this->db->where("csec.is_shipper  = 1");
			}
			if(!empty($postData['is_bill_to'])) {
				$this->db->where("csec.is_bill_to  = 1");
			}
			if(!empty($postData['is_consignee'])) {
				$this->db->where("csec.is_consignee  = 1");
			}
			if(!empty($postData['is_sales'])) {
				$this->db->where("csec.is_sales  = 1");
			}
			$this->db->where('BaseTbl.isDeleted', 0);
			$query = $this->db->get();
			
			return $query->num_rows();
		}
	
	  function checkCustomerpopup($postData, $page, $segment){

		 $response = array();
		
		   // Select record

			$this->db->select('BaseTbl.*, csec.tsa_known_shipper, csec.revalidation_date');
			$this->db->from('tbl_customers as BaseTbl');
			$this->db->join('tbl_customer_secondary as csec', 'csec.customer_id = BaseTbl.customer_id','left');

			if(!empty($postData['search'])) {
				$likeCriteria = "(BaseTbl.c_email  LIKE '%".$postData['search']."%'
                            OR  BaseTbl.customer_name  LIKE '%".$postData['search']."%'
                            OR  BaseTbl.c_phone  LIKE '%".$postData['search']."%')";
				$this->db->where($likeCriteria);
			}
			if(!empty($postData['is_shipper'])) {
				$this->db->where("csec.is_shipper  = 1");
			}
			if(!empty($postData['is_bill_to'])) {
				$this->db->where("csec.is_bill_to  = 1");
			}
			if(!empty($postData['is_consignee'])) {
				$this->db->where("csec.is_consignee  = 1");
			}
			if(!empty($postData['is_sales'])) {
				$this->db->where("csec.is_sales  = 1");
			} 
			$this->db->where('BaseTbl.isDeleted', 0);
			$this->db->limit($segment, $page);
			
			$columnsname = 'customer_name';
			$columnorder = 'ASC';
			if(isset($postData['columnName']) && !empty($postData['columnName'])){
				$columnsname = $postData['columnName'];
			}
			if(isset($postData['sort']) && !empty($postData['sort'])){
				$columnorder = $postData['sort'];
			}
			$this->db->order_by('BaseTbl.'.$columnsname, $columnorder); 
			$query = $this->db->get();
			
			$records = $query->result();  
			//$records = $query->result_array();  
			
		 return $records;
	  }
  
	function checkSecondaryInfo($customerid)
    {
        $this->db->select('csec.customer_id');
		$this->db->from('tbl_customer_secondary as csec');
		$this->db->where('csec.customer_id', $customerid);
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
	
	/**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function customerListingCount($searchdata)
    {
        $this->db->select('BaseTbl.customer_id');
		$this->db->from('tbl_customers as BaseTbl');
		$this->db->join('tbl_customer_secondary as csec', 'csec.customer_id = BaseTbl.customer_id','left');
		$this->db->join('tbl_airports as tair', 'tair.airport_id = BaseTbl.default_airport_code','left');
		
       if(!empty($searchdata['searchText'])) {
            $likeCriteria = "(BaseTbl.c_email  LIKE '%".$searchdata['searchText']."%'
                            OR  BaseTbl.customer_name  LIKE '%".$searchdata['searchText']."%'
                            OR  BaseTbl.c_phone  LIKE '%".$searchdata['searchText']."%')";
            $this->db->where($likeCriteria);
        }
		if(!empty($searchdata['searchCode'])) {
            $likeCriteria = "tair.airport_code  LIKE '%".$searchdata['searchCode']."%'";
            $this->db->where($likeCriteria);
        }
		if(!empty($searchdata['searchCity'])) {
            $likeCriteria = "BaseTbl.c_city  LIKE '%".$searchdata['searchCity']."%'";
            $this->db->where($likeCriteria);
        }
		$this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('(BaseTbl.category_id = 1 OR BaseTbl.category_id = 3)'); 
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function customerListing($searchdata, $page, $segment, $sortBy, $order)
    {
        $this->db->select('BaseTbl.*, csec.*, BaseTbl.customer_id,tair.airport_code,tair.airport_name,tair.airport_id,tair.city as airport_city');  
        $this->db->from('tbl_customers as BaseTbl');
		$this->db->join('tbl_customer_secondary as csec', 'csec.customer_id = BaseTbl.customer_id','left');
		$this->db->join('tbl_airports as tair', 'tair.airport_id = BaseTbl.default_airport_code','left');
        if(!empty($searchdata['searchText'])) {
            $likeCriteria = "(BaseTbl.c_email  LIKE '%".$searchdata['searchText']."%'
                            OR  BaseTbl.customer_name  LIKE '%".$searchdata['searchText']."%'
                            OR  BaseTbl.c_phone  LIKE '%".$searchdata['searchText']."%')";
            $this->db->where($likeCriteria);
        }
		if(!empty($searchdata['searchCode'])) {
            $likeCriteria = "tair.airport_code  LIKE '%".$searchdata['searchCode']."%'";
            $this->db->where($likeCriteria);
        }
		if(!empty($searchdata['searchCity'])) {
            $likeCriteria = "BaseTbl.c_city  LIKE '%".$searchdata['searchCity']."%'";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
		$this->db->where('(BaseTbl.category_id = 1 OR BaseTbl.category_id = 3)'); 
		
		if($sortBy == 'airport_code'){
			$this->db->order_by('tair.'.$sortBy, $order); 
		}else{
			$this->db->order_by('BaseTbl.'.$sortBy, $order); 
		}
		
        $this->db->limit($page,$segment);
        $query = $this->db->get();
       
        $result = $query->result();   
		
        return $result;
				
    }
	
	
	/**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function vendorListingCount($searchdata)
    {
        $this->db->select('BaseTbl.customer_id');
		$this->db->from('tbl_customers as BaseTbl');
		$this->db->join('tbl_customer_secondary as csec', 'csec.customer_id = BaseTbl.customer_id','left');
		$this->db->join('tbl_airports as tair', 'tair.airport_id = BaseTbl.default_airport_code','left');
        if(!empty($searchdata['searchText'])) {
            $likeCriteria = "(BaseTbl.c_email  LIKE '%".$searchdata['searchText']."%'
                            OR  BaseTbl.customer_name  LIKE '%".$searchdata['searchText']."%'
                            OR  BaseTbl.c_phone  LIKE '%".$searchdata['searchText']."%')";
            $this->db->where($likeCriteria);
        }
		if(!empty($searchdata['searchCode'])) {
            $likeCriteria = "tair.airport_code  LIKE '%".$searchdata['searchCode']."%'";
            $this->db->where($likeCriteria);
        }
		if(!empty($searchdata['searchCity'])) {
            $likeCriteria = "BaseTbl.c_city  LIKE '%".$searchdata['searchCity']."%'";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
		$this->db->where('(BaseTbl.category_id = 2 OR BaseTbl.category_id = 3)'); 
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function vendorListing($searchdata, $page, $segment, $sortBy, $order)
    {
        $this->db->select('BaseTbl.*, csec.*, BaseTbl.customer_id,tair.airport_code,tair.airport_name,tair.airport_id,tair.city as airport_city');
        $this->db->from('tbl_customers as BaseTbl');
		$this->db->join('tbl_customer_secondary as csec', 'csec.customer_id = BaseTbl.customer_id','left');
		$this->db->join('tbl_airports as tair', 'tair.airport_id = BaseTbl.default_airport_code','left');
         if(!empty($searchdata['searchText'])) {
            $likeCriteria = "(BaseTbl.c_email  LIKE '%".$searchdata['searchText']."%'
                            OR  BaseTbl.customer_name  LIKE '%".$searchdata['searchText']."%'
                            OR  BaseTbl.c_phone  LIKE '%".$searchdata['searchText']."%')";
            $this->db->where($likeCriteria);
        }
		if(!empty($searchdata['searchCode'])) {
            $likeCriteria = "tair.airport_code  LIKE '%".$searchdata['searchCode']."%'";
            $this->db->where($likeCriteria);
        }
		if(!empty($searchdata['searchCity'])) {
            $likeCriteria = "BaseTbl.c_city  LIKE '%".$searchdata['searchCity']."%'";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
		$this->db->where('(BaseTbl.category_id = 2 OR BaseTbl.category_id = 3)'); 
       
	    if($sortBy == 'airport_code'){
			$this->db->order_by('tair.'.$sortBy, $order); 
		}else{
			$this->db->order_by('BaseTbl.'.$sortBy, $order); 
		}
		
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();   
		
        return $result;
				
    }
	
	
	function getRefTypes(){
		$this->db->select('BaseTbl.*');
        $this->db->from('tbl_ref_types as BaseTbl');
        $this->db->where('BaseTbl.is_active', 1);
        $this->db->order_by('BaseTbl.ref_id', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result_array(); 
		
        return $result;
	}
	
	function getClasses(){
		$this->db->select('BaseTbl.*');
        $this->db->from('tbl_classes as BaseTbl');
        $this->db->where('BaseTbl.is_active', 1);
        $this->db->order_by('BaseTbl.class_id', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result_array(); 
		
        return $result;
	}
	
	function getAllCurrencies(){ 
		$this->db->select('BaseTbl.*');
        $this->db->from('tbl_currencies as BaseTbl');
        $this->db->where('BaseTbl.is_active', 1);
        $this->db->order_by('BaseTbl.currency_id', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result_array(); 
		
        return $result;
	}
	
	function getCountries()
    {
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_countries as BaseTbl');
        $this->db->where('BaseTbl.is_active_country', 1);
        $this->db->order_by('BaseTbl.country_name', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result(); 
		$singleArray = []; 
		foreach ($result as $value) 
		{ 
			$singleArray[] = (array) $value; 
		} 
		
        return $singleArray;
    }
	
	function getAirports()
    {
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_airports as BaseTbl');
        $this->db->where('BaseTbl.is_active', 1);
        $this->db->order_by('BaseTbl.airport_id', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result(); 
		$singleArray = []; 
		foreach ($result as $value) 
		{ 
			$singleArray[] = (array) $value; 
		} 
		
        return $singleArray;
    }
	
	function getStations()
    {
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_stations as BaseTbl');
        $this->db->where('BaseTbl.is_active', 1);
        $this->db->order_by('BaseTbl.station_id', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result_array(); 
        return $result;
    }
	
	function getPayTerms()
    {
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_pay_terms as BaseTbl');
        $this->db->where('BaseTbl.is_active', 1);
        $this->db->order_by('BaseTbl.term_id', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result_array(); 
        return $result;
    }
	
	function getStateList($countryid)
    {
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_states as BaseTbl');
        $this->db->where('BaseTbl.country_id', $countryid);
        $this->db->order_by('BaseTbl.state_name', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result(); 
		$singleArray = []; 
		foreach ($result as $value) 
		{ 
			$singleArray[] = (array) $value; 
		} 
		
        return $singleArray;
    }
    

    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $customer_id : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkCustomerEmailExists($email, $customer_id = 0)
    {
        $this->db->select("c_email");
        $this->db->from("tbl_customers");
        $this->db->where("c_email", $email);   
        $this->db->where("isDeleted", 0);
        if($customer_id != 0){
            $this->db->where("customer_id !=", $customer_id);
        }
        $query = $this->db->get();

        return $query->result();
    }
    
    
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function saveNewCustomer($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_customers', $userInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
	
	function saveSecondaryInfo($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_customer_secondary', $userInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get user information by id
     * @param number $customer_id : This is user id
     * @return array $result : This is user information
     */
    function getCustomerInfo($customer_id)
    {
        $this->db->select('BaseTbl.*,csec.*, BaseTbl.customer_id,tair.airport_code,tair.airport_name,tair.airport_id,tair.city as airport_city,tsales.customer_name as sales_person_name,tbill.customer_name as bill_customer_name, tpay.name as payment_term_name, tpay.p_days as payment_term_days,tst.state_name,tst.state_code,tcn.country_code,tcn.country_name,tst_2.state_name as r_state_name,tst_2.state_code as r_state_code,tcn_2.country_code as r_country_code,tcn_2.country_name as r_country_name');
        $this->db->from('tbl_customers as BaseTbl');
		$this->db->join('tbl_customer_secondary as csec', 'csec.customer_id = BaseTbl.customer_id','left');
		$this->db->join('tbl_airports as tair', 'tair.airport_id = BaseTbl.default_airport_code','left');
		$this->db->join('tbl_customers as tsales', 'tsales.customer_id = csec.sales_person','left');
		$this->db->join('tbl_customers as tbill', 'tbill.customer_id = csec.bill_customer_number','left');
		$this->db->join('tbl_pay_terms as tpay', 'tpay.term_id = csec.payment_term','left');
		$this->db->join('tbl_states as tst', 'tst.state_id = BaseTbl.c_state','left');
		$this->db->join('tbl_countries as tcn', 'tcn.country_id = BaseTbl.c_country','left');
		$this->db->join('tbl_states as tst_2', 'tst_2.state_id = BaseTbl.r_state','left');
		$this->db->join('tbl_countries as tcn_2', 'tcn_2.country_id = BaseTbl.r_country','left');
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.customer_id', $customer_id);
        $query = $this->db->get();
        
		
        return $query->row();
    }
    
    
	function generateCustomerCode($customernumber, $customerid = null)
    {

		$this->db->select('BaseTbl.customer_id');
        $this->db->from('tbl_customers as BaseTbl');
        $this->db->where('BaseTbl.customer_number LIKE "%'.$customernumber.'%"');
		if(!empty($customerid)){
			$this->db->where('BaseTbl.customer_id !=', $customerid);
		}
        $query = $this->db->get();
        
        $numrows = $query->num_rows();
		
		if($numrows == 0){
			$finalnumber = $customernumber;
		}else{
			$finalnumber = $customernumber.($numrows+1);
			
			$finalnumber = $this->generateCustomerCode($finalnumber, $customerid);
		}

        return $finalnumber;				
    }
	
    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $customer_id : This is user id
     */
    function updateCustomer($userInfo, $customer_id)
    {
        $this->db->where('customer_id', $customer_id);
        $this->db->update('tbl_customers', $userInfo);
        
        return TRUE;
    }
	
	function updateSecondaryInfo($userInfo, $customer_id)
    {
        $this->db->where('customer_id', $customer_id);
        $this->db->update('tbl_customer_secondary', $userInfo);
        
        return TRUE;
    }
    
     
    /**
     * This function is used to delete the user information
     * @param number $customer_id : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteCustomer($customer_id, $userInfo)
    {
        $this->db->where('customer_id', $customer_id);
        $this->db->update('tbl_customers', $userInfo);
        
        return $this->db->affected_rows();
    }

    /**
     * This function used to get user information by id
     * @param number $customer_id : This is user id
     * @return array $result : This is user information
     */
    function getCustomerInfoById($customer_id)
    {
		
		$this->db->select('BaseTbl.*,csec.*, BaseTbl.customer_id');
        $this->db->from('tbl_customers as BaseTbl');
		$this->db->join('tbl_customer_secondary as csec', 'csec.customer_id = BaseTbl.customer_id','left');
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.customer_id', $customer_id);
        $query = $this->db->get();
        
        return $query->row();
    }

	function changeCDataToActiveShipments($customer_id){
		$customerdata = (array) $this->getCustomerInfoById($customer_id);
		
		
		/* taking shipment record and update*/
		$this->db->select('sibtbl.shipment_id, sibtbl.org_s_shipper_id, sibtbl.shipper_data');
		$this->db->from('tbl_domestic_shipments as sibtbl');
		$this->db->where('sibtbl.org_s_shipper_id',$customer_id);
		$query = $this->db->get();
		 
		$shiprecords = $query->result_array();  
		
		if(!empty($shiprecords)){
			foreach($shiprecords as $shiprecord){
				
				$aShipData = (array) json_decode($shiprecord['shipper_data']);
				
				$shipperdata['s_shipper_id'] = $customerdata['file_number'];
				$shipperdata['shipper_name'] = $customerdata['customer_name'];
				$shipperdata['org_s_shipper_id'] = $customerdata['customer_id'];
				$shipperdata['s_address_1'] = $customerdata['c_address_1'];
				$shipperdata['s_address_2'] = $customerdata['c_address_2'];
				$shipperdata['s_city'] = $customerdata['c_city'];
				$shipperdata['s_state'] = $customerdata['c_state'];
				$shipperdata['s_zip'] = $customerdata['c_zip'];
				$shipperdata['s_country'] = $customerdata['c_country'];
				$shipperdata['s_phone'] = (!empty($customerdata['c_phone']) ? $customerdata['c_phone'] : $aShipData['s_phone']);
				$shipperdata['s_fax'] = (!empty($customerdata['c_fax']) ? $customerdata['c_fax'] : $aShipData['s_fax']);
				$shipperdata['s_contact'] = (!empty($customerdata['c_contact']) ? $customerdata['c_contact'] : $aShipData['s_contact']);
				$shipperdata['s_email'] = (!empty($customerdata['c_email']) ? $customerdata['c_email'] : $aShipData['s_email']);
				$shipperdata['s_default_ref'] = (!empty($customerdata['c_default_ref']) ? $customerdata['c_default_ref'] : $aShipData['s_default_ref']);
				$shipperdata['s_def_ref_type'] =(!empty($customerdata['c_def_ref_type']) ? $customerdata['c_def_ref_type'] : $aShipData['s_def_ref_type']);
				$shipperdata['show_name'] = $aShipData['show_name'];
				$shipperdata['exhibitor_name'] = $aShipData['exhibitor_name'];
				$shipperdata['booth_name'] = $aShipData['booth_name'];
				$shipperdata['decorator_name'] = $aShipData['decorator_name'];
				$shipperdata['s_store_number'] = $aShipData['s_store_number'];
				$shipperdata['shipper_trade_show'] = $aShipData['shipper_trade_show'];
				
				$shipInfo = array(
					'shipper_data'=> json_encode($shipperdata), 
				);
				
				$this->db->where('shipment_id', $shiprecord['shipment_id']);
				$this->db->update('tbl_domestic_shipments', $shipInfo);
		
			}
		}
		
		
		/* taking consignee record and update*/
		$this->db->select('sibtbl.shipment_id, sibtbl.org_c_shipper_id, sibtbl.consignee_data');
		$this->db->from('tbl_domestic_shipments as sibtbl');
		$this->db->where('sibtbl.org_c_shipper_id',$customer_id);
		$query = $this->db->get();
		 
		$consignRecords = $query->result_array();  
		
		if(!empty($consignRecords)){
			foreach($consignRecords as $consignRecord){
				
				$aConsigneeData = (array) json_decode($consignRecord['consignee_data']);
				
				$conData['c_shipper_id'] = $customerdata['file_number'];
				$conData['c_shipper_name'] = $customerdata['customer_name'];
				$conData['org_c_shipper_id'] = $customerdata['customer_id'];
				$conData['c_address_1'] = $customerdata['c_address_1'];
				$conData['c_address_2'] = $customerdata['c_address_2'];
				$conData['c_city'] = $customerdata['c_city'];
				$conData['c_state'] = $customerdata['c_state'];
				$conData['c_zip'] = $customerdata['c_zip'];
				$conData['c_country'] = $customerdata['c_country'];
				$conData['c_phone'] = (!empty($customerdata['c_phone']) ? $customerdata['c_phone'] : $aConsigneeData['c_phone']);
				$conData['c_fax'] = (!empty($customerdata['c_fax']) ? $customerdata['c_fax'] : $aConsigneeData['c_fax']);
				$conData['c_contact'] = (!empty($customerdata['c_contact']) ? $customerdata['c_contact'] : $aConsigneeData['c_contact']);
				$conData['c_email'] = (!empty($customerdata['c_email']) ? $customerdata['c_email'] : $aConsigneeData['c_email']);
				$conData['c_default_ref'] = (!empty($customerdata['c_default_ref']) ? $customerdata['c_default_ref'] : $aConsigneeData['c_default_ref']);
				$conData['c_def_ref_type'] =(!empty($customerdata['c_def_ref_type']) ? $customerdata['c_def_ref_type'] : $aConsigneeData['c_def_ref_type']);
				$conData['show_name'] = $aConsigneeData['show_name'];
				$conData['exhibitor_name'] = $aConsigneeData['exhibitor_name'];
				$conData['booth_name'] = $aConsigneeData['booth_name'];
				$conData['decorator_name'] = $aConsigneeData['decorator_name'];
				$conData['c_store_number'] = $aConsigneeData['c_store_number'];
				$conData['consignee_trade_show'] = $aConsigneeData['consignee_trade_show'];
				
				$conInfo = array(
					'consignee_data'=> json_encode($conData), 
				);
				
				$this->db->where('shipment_id', $consignRecord['shipment_id']);
				$this->db->update('tbl_domestic_shipments', $conInfo);
		
			}
		}
		
		/* taking billto record and update*/
		$this->db->select('sibtbl.shipment_id, sibtbl.org_b_shipper_id, sibtbl.bill_to_data');
		$this->db->from('tbl_domestic_shipments as sibtbl');
		$this->db->where('sibtbl.org_b_shipper_id',$customer_id);
		$query = $this->db->get();
		 
		$billtoRecords = $query->result_array();  
		
		if(!empty($billtoRecords)){
			foreach($billtoRecords as $billtoRecord){
				
				$aShipData = (array) json_decode($billtoRecord['bill_to_data']);
				
				$billtodata['b_shipper_id'] = $customerdata['file_number'];
				$billtodata['b_shipper_name'] = $customerdata['customer_name'];
				$billtodata['org_b_shipper_id'] = $customerdata['customer_id'];
				$billtodata['b_address_1'] = $customerdata['c_address_1'];
				$billtodata['b_address_2'] = $customerdata['c_address_2'];
				$billtodata['b_city'] = $customerdata['c_city'];
				$billtodata['b_state'] = $customerdata['c_state'];
				$billtodata['b_zip'] = $customerdata['c_zip'];
				$billtodata['b_country'] = $customerdata['c_country'];
				$billtodata['b_phone'] = (!empty($customerdata['c_phone']) ? $customerdata['c_phone'] : $aShipData['b_phone']);
				$billtodata['b_fax'] = (!empty($customerdata['c_fax']) ? $customerdata['c_fax'] : $aShipData['b_fax']);
				$billtodata['b_contact'] = (!empty($customerdata['c_contact']) ? $customerdata['c_contact'] : $aShipData['b_contact']);
				$billtodata['b_email'] = (!empty($customerdata['c_email']) ? $customerdata['c_email'] : $aShipData['b_email']);
				$billtodata['b_default_ref'] = (!empty($customerdata['c_default_ref']) ? $customerdata['c_default_ref'] : $aShipData['b_default_ref']);
				$billtodata['b_def_ref_type'] =(!empty($customerdata['c_def_ref_type']) ? $customerdata['c_def_ref_type'] : $aShipData['b_def_ref_type']);
				
				
				$billInfo = array(
					'bill_to_data'=> json_encode($billtodata), 
				);
				
				$this->db->where('shipment_id', $billtoRecord['shipment_id']);
				$this->db->update('tbl_domestic_shipments', $billInfo);
		
			}
		}
		
	}
	
		
	function updateCustomertoQuickbook($userid){
	
		$userInfo = $this->getCustomerInfo($userid);

		
		if(empty($userInfo)){
			$aReturn['response_message'] = 'Not a valid user';
			$aReturn['response_status'] = 'error';
			return $aReturn;
		}
		
				
		/*$dataService = DataService::Configure(array(
			'auth_mode' => 'oauth2',
			'ClientID' => $this->aQuickConfigData['client_id'],
			'ClientSecret' =>  $this->aQuickConfigData['client_secret'],
			'RedirectURI' => $this->aQuickConfigData['oauth_redirect_uri'],
			'scope' => $this->aQuickConfigData['oauth_scope'],
			'baseUrl' => $this->aQuickConfigData['base_url'],
			'QBORealmID' => $this->aQuickConfigData['qbo_realm_id']
		));
		$accessToken = $_SESSION['sessionAccessTokenQB'];
		$dataService->setLogLocation("/Users/hlu2/Desktop/newFolderForLog");

		$dataService->throwExceptionOnError(true);
		$dataService->updateOAuth2Token($accessToken);

		if($userInfo->category_id == 2){
		
			if($userInfo->same_address ==1){
				$address1 = $userInfo->c_address_1;
				$address2 = $userInfo->c_address_2;
				$city = $userInfo->c_city;
				$country_name = $userInfo->country_name;
				$state_code = $userInfo->state_code;
				$zip = $userInfo->c_zip;
			}else{
				$address1 = $userInfo->r_address_1;
				$address2 = $userInfo->r_address_2;
				$city = $userInfo->r_city;
				$country_name = $userInfo->r_country_name;
				$state_code = $userInfo->r_state_code;
				$zip = $userInfo->r_zip;
			}
			if(empty($entities)){
			
					$vendorObj = Vendor1::create([
					 "BillAddr" => [
						 "Line1"=>  $address1,
						 "Line2" => $address2,
						 "City"=>  $city,
						 "Country"=>  $country_name,
						 "CountrySubDivisionCode"=>  $state_code,
						 "PostalCode"=>  $zip,
					 ],
					 "Notes" =>  $userInfo->invoice_notes,
					 "Title"=>  "Mr",
					 "GivenName"=>  $userInfo->c_contact,
					 "MiddleName"=>  "",
					 "FamilyName"=>  "",
					 "Suffix"=>  "",
					 "FullyQualifiedName"=>  $userInfo->customer_name,
					 "CompanyName"=>  $userInfo->customer_name,
					 "DisplayName"=>  $userInfo->customer_name,
					 "AcctNum"=>  $userInfo->account_no,
					 "PrimaryPhone"=>  [
						 "FreeFormNumber"=>  $userInfo->c_phone,
					 ],
					 "Fax"=>  [
						 "FreeFormNumber"=>  $userInfo->c_fax,
					 ],
					 "PrimaryEmailAddr"=>  [
						 "Address" => $userInfo->c_email,
					 ]
					]);
					$resultingCustomerObj = $dataService->Add($vendorObj);
					$error = $dataService->getLastError();
					
					$error = '';
					if ($error) {
						$aReturn['response_message'] = $error->getResponseBody();
						$aReturn['response_status'] = 'error';			
					}else{
						$aReturn['response_message'] = 'Vendor Saved to Quickbook';
						$aReturn['response_status'] = 'success';
						$aReturn['quickbook_id'] = $resultingCustomerObj->Id;
						$aReturn['quickbook_response'] = $resultingCustomerObj;
					}
					
				}else{
				
					
					$theVendor = reset($entities);
					
					$updateVendor = Vendor1::update($theVendor, [
					"BillAddr" => [
						 "Line1"=>  $address1,
						 "Line2" => $address2,
						 "City"=>  $city,
						 "Country"=>  $country_name,
						 "CountrySubDivisionCode"=>  $state_code,
						 "PostalCode"=>  $zip,
					 ],
					 "Notes" =>  $userInfo->invoice_notes,
					 "Title"=>  "Mr",
					 "GivenName"=>  $userInfo->c_contact,
					 "MiddleName"=>  "",
					 "FamilyName"=>  "",
					 "Suffix"=>  "",
					 "FullyQualifiedName"=>  $userInfo->customer_name,
					 "CompanyName"=>  $userInfo->customer_name,
					 "DisplayName"=>  $userInfo->customer_name,
					 "AcctNum"=>  $userInfo->account_no,
					 "PrimaryPhone"=>  [
						 "FreeFormNumber"=>  $userInfo->c_phone,
					 ],
					 "Fax"=>  [
						 "FreeFormNumber"=>  $userInfo->c_fax,
					 ],
					 "PrimaryEmailAddr"=>  [
						 "Address" => $userInfo->c_email,
					 ]
					]);
					$resultingCustomerUpdatedObj = $dataService->Update($updateVendor);
					$error = $dataService->getLastError();
					$error = '';
					if ($error) {
						$aReturn['response_message'] = $error->getResponseBody();
						$aReturn['response_status'] = 'error';			
					}else{
						$aReturn['response_message'] = 'Vendor Saved to Quickbook';
						$aReturn['response_status'] = 'success';
						$aReturn['quickbook_id'] = $theVendor->Id;
						$aReturn['quickbook_response'] = $theVendor;
					}
				}
		}else{
		
				if($userInfo->same_address ==1){
					$address1 = $userInfo->c_address_1;
					$address2 = $userInfo->c_address_2;
					$city = $userInfo->c_city;
					$country_name = $userInfo->country_name;
					$state_code = $userInfo->state_code;
					$zip = $userInfo->c_zip;
				}else{
					$address1 = $userInfo->r_address_1;
					$address2 = $userInfo->r_address_2;
					$city = $userInfo->r_city;
					$country_name = $userInfo->r_country_name;
					$state_code = $userInfo->r_state_code;
					$zip = $userInfo->r_zip;
				}
			
				if(empty($entities)){
			
					$customerObj = Customer1::create([
					 "BillAddr" => [
						 "Line1"=>  $userInfo->c_address_1,
						 "Line2" => $userInfo->c_address_2,
						 "City"=>  $userInfo->c_city,
						 "Country"=>  $userInfo->country_name,
						 "CountrySubDivisionCode"=>  $userInfo->state_code,
						 "PostalCode"=>  $userInfo->c_zip,
					 ],
					 "ShipAddr" => [
						 "Line1"=>  $address1,
						 "Line2" => $address2,
						 "City"=>  $city,
						 "Country"=>  $country_name,
						 "CountrySubDivisionCode"=>  $state_code,
						 "PostalCode"=>  $zip,
					 ],
					 "Notes" =>  $userInfo->invoice_notes,
					 "Title"=>  "Mr",
					 "GivenName"=>  $userInfo->c_contact,
					 "MiddleName"=>  "",
					 "FamilyName"=>  "",
					 "Suffix"=>  "",
					 "RootCustomerRef"=>  $userInfo->customer_id,
					 "FullyQualifiedName"=>  $userInfo->customer_name,
					 "CompanyName"=>  $userInfo->customer_name,
					 "DisplayName"=>  $userInfo->customer_name,
					 "PrimaryPhone"=>  [
						 "FreeFormNumber"=>  $userInfo->c_phone,
					 ],
					 "Fax"=>  [
						 "FreeFormNumber"=>  $userInfo->c_fax,
					 ],
					 "PrimaryEmailAddr"=>  [
						 "Address" => $userInfo->c_email,
					 ]
					]);
					$resultingCustomerObj = $dataService->Add($customerObj);
					$error = $dataService->getLastError();
					$error = '';
					if ($error) {
						$aReturn['response_message'] = $error->getResponseBody();
						$aReturn['response_status'] = 'error';			
					}else{
						$aReturn['response_message'] = 'Customer Saved to Quickbook';
						$aReturn['response_status'] = 'success';
						$aReturn['quickbook_id'] = $resultingCustomerObj->Id;
						$aReturn['quickbook_response'] = $resultingCustomerObj;
					}
					
				}else{
				
					
					$theCustomer = reset($entities);
					
					$updateCustomer = Customer1::update($theCustomer, [
						"BillAddr" => [
						 "Line1"=>  $userInfo->c_address_1,
						 "Line2" => $userInfo->c_address_2,
						 "City"=>  $userInfo->c_city,
						 "Country"=>  $userInfo->country_name,
						 "CountrySubDivisionCode"=>  $userInfo->state_code,
						 "PostalCode"=>  $userInfo->c_zip,
					 ],
					 "ShipAddr" => [
						 "Line1"=>  $address1,
						 "Line2" => $address2,
						 "City"=>  $city,
						 "Country"=>  $country_name,
						 "CountrySubDivisionCode"=>  $state_code,
						 "PostalCode"=>  $zip,
					 ],
					 "Notes" =>  $userInfo->invoice_notes,
					 "Title"=>  "Mr",
					 "GivenName"=>  $userInfo->c_contact,
					 "MiddleName"=>  "",
					 "FamilyName"=>  "",
					 "Suffix"=>  "",
					 "RootCustomerRef"=>  $userInfo->customer_id,
					 "FullyQualifiedName"=>  $userInfo->customer_name,
					 "CompanyName"=>  $userInfo->customer_name,
					 "DisplayName"=>  $userInfo->customer_name,
					 "PrimaryPhone"=>  [
						 "FreeFormNumber"=>  $userInfo->c_phone,
					 ],
					 "Fax"=>  [
						 "FreeFormNumber"=>  $userInfo->c_fax,
					 ],
					 "PrimaryEmailAddr"=>  [
						 "Address" => $userInfo->c_email,
					 ]
					]);
					$resultingCustomerUpdatedObj = $dataService->Update($updateCustomer);
					$error = $dataService->getLastError();
					$error = '';
					if ($error) {
						$aReturn['response_message'] = $error->getResponseBody();
						$aReturn['response_status'] = 'error';			
					}else{
						$aReturn['response_message'] = 'Customer Saved to Quickbook';
						$aReturn['response_status'] = 'success';
						$aReturn['quickbook_id'] = $theCustomer->Id;
						$aReturn['quickbook_response'] = $theCustomer;
					}
				}
		} */
		
		$aReturn['response_status'] = 'ok';
		return $aReturn;
		
	}
	function callbackdata()
	{
		
	} 
	function customerquickbook(){
	
		
		/*demo and test purpose*/ 
		/* $dataService = DataService::Configure(array(
			'auth_mode' => 'oauth2',
			'ClientID' => $this->aQuickConfigData['client_id'],
			'ClientSecret' =>  $this->aQuickConfigData['client_secret'],
			'RedirectURI' => $this->aQuickConfigData['oauth_redirect_uri'],
			'scope' => $this->aQuickConfigData['oauth_scope'],
			'baseUrl' => $this->aQuickConfigData['base_url'],
			'QBORealmID' => $this->aQuickConfigData['qbo_realm_id']
		));
		$accessToken = $_SESSION['sessionAccessTokenQB'];
		$dataService->setLogLocation("/Users/hlu2/Desktop/newFolderForLog");

		$dataService->throwExceptionOnError(true);
		$dataService->updateOAuth2Token($accessToken); */
		
		//$refreshedAccessTokenObj = $OAuth2LoginHelper->refreshToken();
		//$dataService->updateOAuth2Token($refreshedAccessTokenObj);
		/* $accessTokenObj = $OAuth2LoginHelper->refreshAccessTokenWithRefreshToken($this->aaconfig['refreshTokenKey']);
		$dataService->updateOAuth2Token($accessTokenObj); */
		//$accessTokenValue = $accessTokenObj->getAccessToken();
		//$refreshTokenValue = $accessTokenObj->getRefreshToken();

		/* $allCustomers = $dataService->FindAll('Customer', 0, 100);
		foreach($allCustomers as $customer){
			print_r($customer->DisplayName);
			echo "<br/>";
		}
		die(); */
		
		$i = 0;
	}

	function getCustomerExist($username, $address, $customer_id = 0, $category_id)
    {
        $this->db->select("customer_id");
        $this->db->from("tbl_customers");
        $this->db->where("customer_name", $username);   
        $this->db->where("c_address_1", $address);   
        $this->db->where("isDeleted", 0);
        if($customer_id != 0){
            $this->db->where("customer_id !=", $customer_id);
        }
		if($category_id == 1){
			$this->db->where('(category_id = 1 OR category_id = 3)'); 
		}elseif($category_id == 2){
			$this->db->where('(category_id = 2 OR category_id = 3)');
		}elseif($category_id == 3){
			$this->db->where('(category_id = 1 OR category_id = 2 OR category_id = 3)');
		}
		
        $query = $this->db->get();

        return $query->result();
    } 

}

  