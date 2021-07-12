<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

use QuickBooksOnline\API\Core\ServiceContext;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\PlatformService\PlatformService;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Customer as Customer1;
use QuickBooksOnline\API\Facades\Vendor as Vendor1;
use QuickBooksOnline\API\Core\OAuth\OAuth2\OAuth2LoginHelper;
use QuickBooksOnline\API\Facades\Item;
use QuickBooksOnline\API\Facades\Invoice;
use QuickBooksOnline\API\Facades\Payment;
use QuickBooksOnline\API\Facades\Account;

const INCOME_ACCOUNT_TYPE = "Income";
const INCOME_ACCOUNT_SUBTYPE = "SalesOfProductIncome";
const EXPENSE_ACCOUNT_TYPE = "Cost of Goods Sold";
const EXPENSE_ACCOUNT_SUBTYPE = "SuppliesMaterialsCogs";
const ASSET_ACCOUNT_TYPE = "Other Current Asset";
const ASSET_ACCOUNT_SUBTYPE = "Inventory"; /*Inventory*/

class Shipment_model extends CI_Model
{ 
	public function __construct() {

		parent::__construct();

		$this->load->model('Customer_model');

	}
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function domesticShipmentListingCount($searchdata)
    {
        $this->db->select('BaseTbl.shipment_id');
		$this->db->from('tbl_domestic_shipments as BaseTbl');
		$this->db->join('tbl_airports as orginap', 'orginap.airport_id = BaseTbl.origin_airport_id','left');
		$this->db->join('tbl_airports as destap', 'destap.airport_id = BaseTbl.dest_airport_id','left');
		$this->db->join('tbl_service_levels as slevel', 'slevel.service_id = BaseTbl.service_level','left');
        if(!empty($searchdata['searchText'])) {
            $likeCriteria = "(BaseTbl.file_number  LIKE '%".$searchdata['searchText']."%'
                            OR  BaseTbl.waybill  LIKE '%".$searchdata['searchText']."%')";
            $this->db->where($likeCriteria);
        }
		if(!empty($searchdata['searchCode'])) {
            $likeCriteria = "(orginap.airport_code  LIKE '%".$searchdata['searchCode']."%'
                            OR  destap.airport_code  LIKE '%".$searchdata['searchCode']."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
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
    function domesticShipmentListing($searchdata, $page, $segment)
    {
        $this->db->select('BaseTbl.*, orginap.airport_code as origin_airport_code,destap.airport_code as dest_airport_code, slevel.service_name,slevel.short_code as service_short_code');
        $this->db->from('tbl_domestic_shipments as BaseTbl');
		$this->db->join('tbl_airports as orginap', 'orginap.airport_id = BaseTbl.origin_airport_id','left');
		$this->db->join('tbl_airports as destap', 'destap.airport_id = BaseTbl.dest_airport_id','left');
		$this->db->join('tbl_service_levels as slevel', 'slevel.service_id = BaseTbl.service_level','left');
        if(!empty($searchdata['searchText'])) {
            $likeCriteria = "(BaseTbl.file_number  LIKE '%".$searchdata['searchText']."%'
                            OR  BaseTbl.waybill  LIKE '%".$searchdata['searchText']."%')";
            $this->db->where($likeCriteria);
        }
		if(!empty($searchdata['searchCode'])) {
            $likeCriteria = "(orginap.airport_code  LIKE '%".$searchdata['searchCode']."%'
                            OR  destap.airport_code  LIKE '%".$searchdata['searchCode']."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.ready_date_time', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $results = $query->result_array();   
		$orderstats = $this->getOrderStatus();
		
		if(!empty($results)){
			foreach($results as $key=> $result){
				$results[$key]['shipper_data'] = (array)  json_decode($result['shipper_data']);
				$results[$key]['consignee_data'] = (array) json_decode($result['consignee_data']);
				$results[$key]['bill_to_data'] = (array) json_decode($result['bill_to_data']);
				$results[$key]['spchk_datas'] = (array) json_decode($result['spchk_datas']);
				$results[$key]['sp_ins_datas'] = (array) json_decode($result['sp_ins_datas']);
				$results[$key]['status_name'] = '-';
				foreach($orderstats as $orderstat){
					if($orderstat['status_id'] == $result['order_status']){
						$results[$key]['status_name'] = $orderstat['status_name'];
					}
				}
			}
		}
		
		
        return $results;
				
    }
	
	function getDomesticBaseInfo($shipmentid)
    {
        $this->db->select('BaseTbl1.*'); 
        $this->db->from('tbl_domestic_shipments as BaseTbl1');		
        $this->db->where('BaseTbl1.isDeleted', 0);
        $this->db->where('BaseTbl1.shipment_id', $shipmentid);
        $query1 = $this->db->get();
        
		$result = $query1->row_array();
		if(!empty($result)){
			$result['shipper_data'] = (array)  json_decode($result['shipper_data']);
			$result['shipper_data']['customer_data'] = (array) $this->Customer_model->getCustomerInfo($result['shipper_data']['org_s_shipper_id']);
			
			$result['consignee_data'] = (array) json_decode($result['consignee_data']);
			$result['consignee_data']['customer_data'] = (array) $this->Customer_model->getCustomerInfo($result['consignee_data']['org_c_shipper_id']);

			$result['bill_to_data'] = (array) json_decode($result['bill_to_data']);
			$result['bill_to_data']['customer_data'] = (array) $this->Customer_model->getCustomerInfo($result['bill_to_data']['org_b_shipper_id']);
		
		}
		
        return $result;
    }
	
	function getDomesticInfo($shipmentid)
    {
        $this->db->select('BaseTbl.*, orginap.airport_code as origin_airport_code, orginap.city as origin_airport_city,destap.airport_code as dest_airport_code,destap.city as dest_airport_city, slevel.service_name,slevel.short_code as service_short_code, tsales.customer_name as sales_person_name, tsales.customer_number as sales_person_number,dtr.track_id,dtr.pod_date,dtr.pod_time,dtr.pod_name,dtr.pod_delivered,dtr.freight_city,dtr.freight_state'); 
        $this->db->from('tbl_domestic_shipments as BaseTbl');
		$this->db->join('tbl_airports as orginap', 'orginap.airport_id = BaseTbl.origin_airport_id','left');
		$this->db->join('tbl_airports as destap', 'destap.airport_id = BaseTbl.dest_airport_id','left');
		$this->db->join('tbl_service_levels as slevel', 'slevel.service_id = BaseTbl.service_level','left');
		$this->db->join('tbl_customers as tsales', 'tsales.customer_id = BaseTbl.sales_person','left');
		
		//$this->db->join('tbl_domestic_tracking as dtr', 'dtr.track_id = (select max(track_id) from tbl_domestic_tracking as dtr2 where dtr2.shipping_id = '.$shipmentid.')', 'left');
		
		$this->db->join('tbl_domestic_tracking as dtr', 'dtr.track_id = (select track_id from tbl_domestic_tracking as dtr2 where dtr2.shipping_id = '.$shipmentid.' order by dtr2.updated_time DESC LIMIT 1)', 'left');
		
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.shipment_id', $shipmentid);
        $query1 = $this->db->get();
        
		$result = $query1->row_array();
		$orderstats = $this->getOrderStatus();
		if(!empty($result)){
			$result['shipper_data'] = (array)  json_decode($result['shipper_data']);
			$result['shipper_data']['state_name'] = $this->getStateName($result['shipper_data']['s_state']);
			$result['shipper_data']['country_name'] = $this->getCountryName($result['shipper_data']['s_country']);
			$result['shipper_data']['ref_name'] = $this->getRefName($result['shipper_data']['s_def_ref_type']);
			$result['shipper_data']['customer_data'] = (array) $this->Customer_model->getCustomerInfo($result['shipper_data']['org_s_shipper_id']);
			
			$result['consignee_data'] = (array) json_decode($result['consignee_data']);
			$result['consignee_data']['state_name'] = $this->getStateName($result['consignee_data']['c_state']);
			$result['consignee_data']['country_name'] = $this->getCountryName($result['consignee_data']['c_country']);
			$result['consignee_data']['ref_name'] = $this->getRefName($result['consignee_data']['c_def_ref_type']);
			$result['consignee_data']['customer_data'] = (array) $this->Customer_model->getCustomerInfo($result['consignee_data']['org_c_shipper_id']);
			
			$result['bill_to_data'] = (array) json_decode($result['bill_to_data']);
			$result['bill_to_data']['state_name'] = $this->getStateName($result['bill_to_data']['b_state']);
			$result['bill_to_data']['country_name'] = $this->getCountryName($result['bill_to_data']['b_country']);
			$result['bill_to_data']['ref_name'] = $this->getRefName($result['bill_to_data']['b_def_ref_type']);
			$result['bill_to_data']['customer_data'] = (array) $this->Customer_model->getCustomerInfo($result['bill_to_data']['org_b_shipper_id']);
			
			$result['freight_datas'] = (array) json_decode($result['freight_datas']);
			foreach($orderstats as $orderstat){
				if($orderstat['status_id'] == $result['order_status']){
					$result['status_name'] = $orderstat['status_name'];
				}
			}
			
			$result['spchk_datas'] = (array) json_decode($result['spchk_datas']);
			$result['sp_ins_datas'] = (array) json_decode($result['sp_ins_datas']);
			
			$result['tot_extra_charge'] = $this->getTotalExtraCharge($result['shipment_id']);
			
		}
		
        return $result;
    }
	
	function getTotalExtraCharge($shipmentid)
    {
        $this->db->select('SUM(BaseTbl.charge_code_total_cost) as total');
        $this->db->from('tbl_domestic_extra_charges as BaseTbl');
        $this->db->where('BaseTbl.shipment_id', $shipmentid);
        $query = $this->db->get();
		$result = '0.00';
        if(isset($query->row()->total)){
			$result = $query->row()->total; 
		}
        return $result;				
    }
	
	function getStateName($stateid)
    {
        $this->db->select('BaseTbl.state_name');
        $this->db->from('tbl_states as BaseTbl');
        $this->db->where('BaseTbl.state_id', $stateid);
        $query = $this->db->get();
		$result = '';
        if(isset($query->row()->state_name)){
			$result = $query->row()->state_name; 
		}		
        return $result;				
    }
	
	function loadSpecialInstructions($podata){
	
		$this->db->select('sp_ins_datas');
        $this->db->from('tbl_domestic_shipments');
        $this->db->where('shipment_id', $podata['sid']);
        $query = $this->db->get();
		
		$result = array();
        if(isset($query->row()->sp_ins_datas)){
			$result = (array)  json_decode($query->row()->sp_ins_datas);
		}		
        return $result;	
	} 
	
	function getCountryName($cid)
    {
        $this->db->select('BaseTbl.country_code');
        $this->db->from('tbl_countries as BaseTbl');
        $this->db->where('BaseTbl.country_id', $cid);
        $query = $this->db->get();
        
		$result = '';
        if(isset($query->row()->country_code)){
			 $result = $query->row()->country_code; 
		}
         
        return $result;				
    }
	
	function getRefName($cid)
    {
        $this->db->select('BaseTbl.ref_name');
        $this->db->from('tbl_ref_types as BaseTbl');
        $this->db->where('BaseTbl.ref_id', $cid);
        $query = $this->db->get();
        
        $result = '';
        if(isset($query->row()->ref_name)){
			 $result = $query->row()->ref_name; 
		}
        return $result;				
    }
	
	function checkairportCode($postData){

		 $response = array();
		
		 if(isset($postData['search']) ){
		   // Select record

			$this->db->select('BaseTbl.*');
			$this->db->from('tbl_airports as BaseTbl');
			
			if(!empty($postData['search'])) {
				
				$likeCriteria = "(BaseTbl.airport_code  LIKE '%".$postData['search']."%'
                            OR  BaseTbl.airport_name  LIKE '%".$postData['search']."%')";
				$this->db->where($likeCriteria);
			}
			
			if(isset($postData['country_id']) && !empty($postData['country_id'])) {
				
				$likeCriteria = "BaseTbl.country_id = ".$postData['country_id'];
				$this->db->where($likeCriteria);
			}

			$query = $this->db->get();
			
			$records = $query->result();  
			if(!empty($records)){
				foreach($records as $row ){
				  $response[] = array("airport_id"=>$row->airport_id,"airport_code"=>$row->airport_code,"label"=>'['.$row->airport_code .'] '.$row->airport_name .','.$row->city . ','.$row->state);
				}
			}else{
				$response[] = array("airport_id"=>0,"airport_code"=>'',"label"=>'No Airport Code Found');
			}

		 }

		 return $response;
	  }
	  
	function internationalShipmentListingCount($searchdata)
    {
        $this->db->select('BaseTbl.shipment_id');
		$this->db->from('tbl_international_shipments as BaseTbl');
       
        $this->db->where('BaseTbl.isDeleted', 0);
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
    function internationalShipmentListing($searchdata, $page, $segment)
    {
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_international_shipments as BaseTbl');
        
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.shipment_id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();   
		
        return $result; 
				
    }
	
	function getServicelevels()
    {
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_service_levels as BaseTbl');
        $this->db->where('BaseTbl.is_active', 1);
        $this->db->order_by('BaseTbl.service_id', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result(); 
		$singleArray = []; 
		foreach ($result as $value) 
		{ 
			$singleArray[] = (array) $value; 
		} 
		
        return $singleArray;
    }
	
	function getAirlineServicelevels()
    {
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_airline_service_levels as BaseTbl');
        $this->db->where('BaseTbl.is_active', 1);
        $this->db->order_by('BaseTbl.service_id', 'ASC');
        $query = $this->db->get();
        
		$result = $query->result_array(); 
			
        return $result;
    }
	
	function getOrderStatus()
    {        
		$ordersteps[] = array('status_id' => 1, 'status_name' => 'Alert Confirmed');
		$ordersteps[] = array('status_id' => 2, 'status_name' => 'Alert faxed, please confirm');
		$ordersteps[] = array('status_id' => 3, 'status_name' => 'Cancelled Per Customer');
		$ordersteps[] = array('status_id' => 4, 'status_name' => 'Delivered - Awaiting Charges');
		$ordersteps[] = array('status_id' => 5, 'status_name' => 'Delivered - Awaiting POD');
		$ordersteps[] = array('status_id' => 6, 'status_name' => 'Delivered');
		$ordersteps[] = array('status_id' => 7, 'status_name' => 'Driver Onsite Shipper');
		$ordersteps[] = array('status_id' => 8, 'status_name' => 'Dipatched for Pickup');
		$ordersteps[] = array('status_id' => 9, 'status_name' => 'Dropped at Carrier');
		$ordersteps[] = array('status_id' => 10, 'status_name' => 'Faxed Pick up slip');
		$ordersteps[] = array('status_id' => 11, 'status_name' => 'In transit to Destination');
		$ordersteps[] = array('status_id' => 12, 'status_name' => 'New Shipment');
		$ordersteps[] = array('status_id' => 13, 'status_name' => 'No Freight - Freight Forced');
		$ordersteps[] = array('status_id' => 14, 'status_name' => 'On Hand Destination Agent');
		$ordersteps[] = array('status_id' => 15, 'status_name' => 'Out for Delivery');
		$ordersteps[] = array('status_id' => 16, 'status_name' => 'On Hand Destination A/P');
		$ordersteps[] = array('status_id' => 17, 'status_name' => 'On Hand Transfer Station');
		$ordersteps[] = array('status_id' => 18, 'status_name' => 'Picked up from Shipper');
		$ordersteps[] = array('status_id' => 19, 'status_name' => 'Internet Booking');
				
        return $ordersteps;
    }
	
	function getFrieghtTypes()
    {        
		$atypes[] = array('type_id' => 1, 'type_name' => 'Piece');
		$atypes[] = array('type_id' => 2, 'type_name' => 'Pallet');
		$atypes[] = array('type_id' => 3, 'type_name' => 'Crate');
		$atypes[] = array('type_id' => 4, 'type_name' => 'Skid');
				
        return $atypes;
    }
	
	function getwaybillno($shipment_id = 0)
    {
        $this->db->select("waybill");
        $this->db->from("tbl_domestic_shipments");
        $this->db->where("isDeleted", 0);
        $this->db->where("auto_assign", 1);
        if($shipment_id != 0){
            $this->db->where("shipment_id !=", $shipment_id);
        }
		$this->db->order_by('waybill', 'DESC');
        $query = $this->db->get();
		$adata = $query->row();
		$waybill_no = 314100;/*345000*/
		if(!empty($adata)){
		if($adata->waybill){ 
			$waybill_no = $adata->waybill + 3;
		}
		}
        return $waybill_no;
    }
	
	function saveNewDomesticShipping($shipInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_domestic_shipments', $shipInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
	
	 function updateDomesticShipment($shipInfo, $shipment_id)
    {
        $this->db->where('shipment_id', $shipment_id);
        $this->db->update('tbl_domestic_shipments', $shipInfo);
        
        return TRUE;
    }
	
	 function updateDomesticShipping($shipInfo, $shipment_id)
    {
        $this->db->where('shipment_id', $shipment_id);
        $this->db->update('tbl_domestic_shipments', $shipInfo);
        
        return TRUE;
    }
	
	function loadChargeCode($postData){

		$response = array();

		$this->db->select('BaseTbl.*');
		$this->db->from('tbl_charge_codes as BaseTbl');

		if(!empty($postData['search'])) {
			$likeCriteria = "(BaseTbl.charge_code  LIKE '%".$postData['search']."%'
						OR  BaseTbl.description  LIKE '%".$postData['search']."%')";
			$this->db->where($likeCriteria);
		}
		$this->db->order_by('BaseTbl.charge_id', 'ASC');
		$query = $this->db->get();
		
		$records = $query->result();  
			
		 return $records;
	  }
	  
	  function loadExtraCharges($postData){

		$this->db->select('BaseTbl.*,t2.charge_id,t2.charge_code as charge_code_name');
		$this->db->from('tbl_domestic_extra_charges as BaseTbl');
		$this->db->join('tbl_charge_codes as t2', 't2.charge_id = BaseTbl.charge_code_id','left');
		
		$this->db->where("BaseTbl.shipment_id  = ". $postData['shipment_id']);
		
		//$this->db->order_by('BaseTbl.charge_code_id', 'ASC');
		$this->db->order_by('FIELD(t2.charge_id, 21) DESC , t2.charge_id ASC');
		
		$query = $this->db->get();
		
		$records = $query->result();  

		return $records;
		
	  }
	  
	  function loadVendorType($postData){

		$response = array();

		$this->db->select('BaseTbl.*');
		$this->db->from('tbl_vendor_types as BaseTbl');

		if(!empty($postData['search'])) {
			$likeCriteria = "(BaseTbl.vendor_type  LIKE '%".$postData['search']."%'
						OR  BaseTbl.vendor_short_code  LIKE '%".$postData['search']."%')";
			$this->db->where($likeCriteria);
		}
		$this->db->order_by('BaseTbl.v_type_id', 'ASC'); 
		$query = $this->db->get();
		
		$records = $query->result();  
			
		 return $records;
	  }
	  
	 function loadTransferAlert($shipment_id){

		$this->db->select('BaseTbl.*');
		$this->db->from('tbl_domestic_transfer_datas as BaseTbl');
		$this->db->where("BaseTbl.shipment_id  = ". $shipment_id);
		$this->db->order_by('BaseTbl.data_id', 'ASC');
		$query = $this->db->get();
		$record = $query->row();  
		
		$record = (array) $record;
		if(!empty($record)){
			$record['r_data'] = (array)  json_decode($record['r_data']);
			$record['t_data'] = (array)  json_decode($record['t_data']);
		}
		return $record;
	 }
	 
	 function loadRoutingAlert($shipment_id){

		$this->db->select('BaseTbl.*, u.name as sysname');
		$this->db->from('tbl_domestic_routing_datas as BaseTbl');
		$this->db->join('tbl_users as u', 'u.userId = BaseTbl.generate_by','left');
		$this->db->where("BaseTbl.shipment_id  = ". $shipment_id);
		$this->db->order_by('BaseTbl.route_id', 'ASC');
		$query = $this->db->get();
		$record = $query->row();  
		
		$record = (array) $record;
		
		if(!empty($record)){
			$record['r_f_data'] = (array)  json_decode($record['r_f_data']);
			
			$record['r_f_data']['customer_data'] = (array) $this->Customer_model->getCustomerInfo($record['r_id']);
			$record['r_f_data']['state_name'] = $this->getStateName($record['r_f_data']['r_state']);
			$record['r_f_data']['country_name'] = $this->getCountryName($record['r_f_data']['r_country']);
			
			$record['t_f_data'] = (array)  json_decode($record['t_f_data']);
			$record['t_f_data']['customer_data'] = (array) $this->Customer_model->getCustomerInfo($record['t_id']);
			$record['t_f_data']['state_name'] = $this->getStateName($record['t_f_data']['t_state']);
			$record['t_f_data']['country_name'] = $this->getCountryName($record['t_f_data']['t_country']);
			
			$record['airline_datas'] = (array)  json_decode($record['airline_datas']);
		}
		
		return $record;
	 }
	  
	  
	 function getDomesticVendorbyId($domid){
	 
		$this->db->select("BaseTbl.*,t2.customer_number,t2.customer_name,t2.c_address_1,t2.c_address_2,t2.c_city,t2.c_state,t2.c_zip,t2.c_country,t2.c_phone,tst.state_name,tcn.country_code,t3.airport_code as origin_airport_code,t4.airport_code as dest_airport_code");
		$this->db->from("tbl_domestic_vendors as BaseTbl");
		$this->db->join('tbl_customers as t2', 't2.customer_id = BaseTbl.p_vendor_id','left');
		$this->db->join('tbl_airports as t3', 't3.airport_id = BaseTbl.v_origin_id','left');
		$this->db->join('tbl_airports as t4', 't4.airport_id = BaseTbl.v_destination_id','left');
		$this->db->join('tbl_states as tst', 'tst.state_id = t2.c_state','left');
		$this->db->join('tbl_countries as tcn', 'tcn.country_id = t2.c_country','left');
		$this->db->where("BaseTbl.dom_id =", $domid);
		$query = $this->db->get();
		$adata = $query->row();
		
		$aResult = (array) $adata;
		if(!empty($aResult)){
			$aResult['vendor_airline_datas'] = (array) json_decode($aResult['vendor_airline_datas']);
		}
		return $aResult;
	 }
	function getRateBasis()
    {
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_rate_basis as BaseTbl');
        $this->db->where('BaseTbl.is_active', 1);
        $this->db->order_by('BaseTbl.rate_basis_id', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result_array(); 
        return $result;
    }

	function loadVendorsCount($postData = '')
	{
		$shipperairporcode = $shipperid = $consigneeairporcode = $consigneeid ='';
		
		if(isset($postData['shipment_id']) && !empty($postData['shipment_id'])){
			$shipInfo = $this->getDomesticBaseInfo($postData['shipment_id']);
			if(isset($shipInfo['shipper_data']['customer_data']['default_airport_code'])){
				$shipperairporcode = $shipInfo['shipper_data']['customer_data']['default_airport_code'];
				$shipperid = $shipInfo['shipper_data']['customer_data']['customer_id'];
			}
			if(isset($shipInfo['consignee_data']['customer_data']['default_airport_code'])){
				$consigneeairporcode = $shipInfo['consignee_data']['customer_data']['default_airport_code'];
				$consigneeid = $shipInfo['consignee_data']['customer_data']['customer_id'];
			}
		}
		
		$this->db->select('BaseTbl.customer_id');
		$this->db->from('tbl_customers as BaseTbl');
		$this->db->join('tbl_customer_secondary as csec', 'csec.customer_id = BaseTbl.customer_id','left');
		$this->db->join('tbl_states as tst', 'tst.state_id = BaseTbl.c_state','left');
		if(!empty($postData['search'])) {
			$likeCriteria = "(BaseTbl.c_email  LIKE '%".$postData['search']."%'
						OR  BaseTbl.customer_name  LIKE '%".$postData['search']."%'
						OR  BaseTbl.c_phone  LIKE '%".$postData['search']."%')";
			$this->db->where($likeCriteria);
		}
		
		//$this->db->where("(csec.is_pickup_delivery  = 1 OR csec.is_line_haul  = 1 OR csec.is_airline  = 1 OR csec.is_truckload  = 1 OR csec.is_ltl  = 1 OR csec.is_customs_broker  = 1)");
		
		$this->db->where('(BaseTbl.category_id = 2 OR BaseTbl.category_id = 3)'); 
		$this->db->where('BaseTbl.isDeleted', 0);
		
		if($postData['p_v_type_id'] == 1){
			$this->db->where("csec.is_customs_broker = 1"); 
		}elseif($postData['p_v_type_id'] == 2){
			$this->db->where("csec.is_ltl = 1"); 
		}elseif($postData['p_v_type_id'] == 4){
			$this->db->where("csec.is_truckload = 1"); 
		}elseif($postData['p_v_type_id'] == 5){
			$this->db->where("csec.is_pickup_delivery = 1"); 
			
			if($shipperairporcode != ''){
				$this->db->where("BaseTbl.default_airport_code = ".$shipperairporcode." AND BaseTbl.customer_id != ".$shipperid); 
			}
			
		}elseif($postData['p_v_type_id'] == 6){
			$this->db->where("csec.is_airline = 1"); 
		}elseif($postData['p_v_type_id'] == 7){
			$this->db->where("csec.is_line_haul = 1"); 
		}elseif($postData['p_v_type_id'] == 8){
			$this->db->where("csec.is_pickup_delivery = 1"); 
			
			if($consigneeairporcode != ''){
				$this->db->where("BaseTbl.default_airport_code = ".$consigneeairporcode." AND BaseTbl.customer_id != ".$consigneeid); 
			}
		}elseif($postData['p_v_type_id'] == '000'){
			$this->db->where("(csec.is_airline = 1 OR csec.is_line_haul = 1)"); 
		}
				
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	function loadVendors($postData, $page, $segment){

		$shipperairporcode = $shipperid = $consigneeairporcode = $consigneeid ='';
		
		if(isset($postData['shipment_id']) && !empty($postData['shipment_id'])){
			$shipInfo = $this->getDomesticBaseInfo($postData['shipment_id']);
			if(isset($shipInfo['shipper_data']['customer_data']['default_airport_code'])){
				$shipperairporcode = $shipInfo['shipper_data']['customer_data']['default_airport_code'];
				$shipperid = $shipInfo['shipper_data']['customer_data']['customer_id'];
			}
			if(isset($shipInfo['consignee_data']['customer_data']['default_airport_code'])){
				$consigneeairporcode = $shipInfo['consignee_data']['customer_data']['default_airport_code'];
				$consigneeid = $shipInfo['consignee_data']['customer_data']['customer_id'];
			}
		}
		
		 $response = array();
	
	   // Select record

		$this->db->select('BaseTbl.*, tst.state_name,tcn.country_code');
		$this->db->from('tbl_customers as BaseTbl');
		$this->db->join('tbl_customer_secondary as csec', 'csec.customer_id = BaseTbl.customer_id','left');
		$this->db->join('tbl_states as tst', 'tst.state_id = BaseTbl.c_state','left');
		$this->db->join('tbl_countries as tcn', 'tcn.country_id = BaseTbl.c_country','left');
		if(!empty($postData['search'])) {
			$likeCriteria = "(BaseTbl.c_email  LIKE '%".$postData['search']."%'
						OR  BaseTbl.customer_name  LIKE '%".$postData['search']."%'
						OR  BaseTbl.customer_number  LIKE '%".$postData['search']."%'
						OR  BaseTbl.c_phone  LIKE '%".$postData['search']."%')";
			$this->db->where($likeCriteria);
		}
		
		//$this->db->where("(csec.is_pickup_delivery  = 1 OR csec.is_line_haul  = 1 OR csec.is_airline  = 1 OR csec.is_truckload  = 1 OR csec.is_ltl  = 1 OR csec.is_customs_broker  = 1)");
		
		$this->db->where('(BaseTbl.category_id = 2 OR BaseTbl.category_id = 3)'); 
		$this->db->where('BaseTbl.isDeleted', 0);
		
		if($postData['p_v_type_id'] == 1){
			$this->db->where("csec.is_customs_broker = 1"); 
		}elseif($postData['p_v_type_id'] == 2){
			$this->db->where("csec.is_ltl = 1"); 
		}elseif($postData['p_v_type_id'] == 4){
			$this->db->where("csec.is_truckload = 1"); 
		}elseif($postData['p_v_type_id'] == 5){
			$this->db->where("csec.is_pickup_delivery = 1"); 
			
			if($shipperairporcode != ''){
				$this->db->where("BaseTbl.default_airport_code = ".$shipperairporcode." AND BaseTbl.customer_id != ".$shipperid); 
			}
			
		}elseif($postData['p_v_type_id'] == 6){
			$this->db->where("csec.is_airline = 1"); 
		}elseif($postData['p_v_type_id'] == 7){
			$this->db->where("csec.is_line_haul = 1"); 
		}elseif($postData['p_v_type_id'] == 8){
			$this->db->where("csec.is_pickup_delivery = 1"); 
			
			if($consigneeairporcode != ''){
				$this->db->where("BaseTbl.default_airport_code = ".$consigneeairporcode." AND BaseTbl.customer_id != ".$consigneeid); 
			}
			
		}elseif($postData['p_v_type_id'] == '000'){
			$this->db->where("(csec.is_airline = 1 OR csec.is_line_haul = 1)"); 
		}  
		
		
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

		
		return $records;
	 }
	 
	 
	 function loadAirportsCount($postData = '')
	{
		$this->db->select('BaseTbl.airport_id');
		$this->db->from('tbl_airports as BaseTbl');
		
		if(!empty($postData['search'])) {
			$likeCriteria = "(BaseTbl.airport_code  LIKE '%".$postData['search']."%'
                            OR  BaseTbl.airport_name  LIKE '%".$postData['search']."%')";
			$this->db->where($likeCriteria);
		}
	
		if(isset($postData['country_id']) && !empty($postData['country_id'])) {
				
			$likeCriteria = "BaseTbl.country_id = ".$postData['country_id'];
			$this->db->where($likeCriteria);
		}
		$this->db->where('BaseTbl.is_active', 1);
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	function loadAirports($postData, $page, $segment){

		 $response = array();
	
	   // Select record

		$this->db->select('BaseTbl.*');
		$this->db->from('tbl_airports as BaseTbl');
		if(!empty($postData['search'])) {
			$likeCriteria = "(BaseTbl.airport_code  LIKE '%".$postData['search']."%'
                            OR  BaseTbl.airport_name  LIKE '%".$postData['search']."%')";
			$this->db->where($likeCriteria);
		}
		if(isset($postData['country_id']) && !empty($postData['country_id'])) {
				
			$likeCriteria = "BaseTbl.country_id = ".$postData['country_id'];
			$this->db->where($likeCriteria);
		}
		
		$this->db->where('BaseTbl.is_active', 1);
		
		$this->db->limit($segment, $page);
		$this->db->order_by('BaseTbl.airport_id', 'ASC');
		$query = $this->db->get();
		
		$records = $query->result();  
		//echo $this->db->last_query();die();
		
		return $records;
	 }
	 
	 function checkandInsertVendor($postData){
			
			$aVals = $postData['vendor_data'];
			
			$this->db->select("*");
			$this->db->from("tbl_domestic_vendors");

			$this->db->where("shipment_id =", $aVals['shipment_id']);
			$this->db->where("p_v_type_id =", $aVals['p_v_type_id']);
			$query = $this->db->get();
			$adata = $query->row();
			
			 if($aVals['p_v_type_id'] == 6 ||$aVals['p_v_type_id'] == 7 ){
				if(!empty($aVals['v_mawb'])){
					$p_ref_name =  $aVals['v_mawb'];
				}else{
					$p_ref_name =  $aVals['p_ref_name'];
				}
			}else{
				$p_ref_name = $aVals['p_ref_name'];
			}
			 
			if(!empty($adata)){
				$shipInfo = array(
					'p_vendor_id'=> $aVals['p_vendor_id'], 
					'p_ref_name'=> $p_ref_name, 
					'rate_basis'=> $aVals['rate_basis'], 
					'p_qty'=> (isset($aVals['p_qty']) ? $aVals['p_qty'] : ''),
					'p_rate'=> (isset($aVals['p_rate']) ? $aVals['p_rate'] : ''), 
					'p_cost'=> (isset($aVals['p_cost']) ? $aVals['p_cost'] : ''),
					'p_extra'=> (isset($aVals['p_extra']) ? $aVals['p_extra'] : ''),
					'p_tax'=> (isset($aVals['p_tax']) ? $aVals['p_tax'] : ''),
					'p_total_cost'=> (isset($aVals['p_total_cost']) ? $aVals['p_total_cost'] : ''), 
					'p_finalize'=> (isset($aVals['p_finalize']) ? $aVals['p_finalize'] : 0), 
					
					'v_origin_id'=> (isset($aVals['v_origin_id']) ? $aVals['v_origin_id'] : 0), 
					'v_destination_id'=> (isset($aVals['v_destination_id']) ? $aVals['v_destination_id'] : 0), 
					'v_mawb'=> (isset($aVals['v_mawb']) ? $aVals['v_mawb'] : 0), 
					'v_auto_assign'=> (isset($aVals['v_auto_assign']) ? $aVals['v_auto_assign'] : 0), 
					'v_account'=> (isset($aVals['v_account']) ? $aVals['v_account'] : 0), 
					'v_cut_off_time'=> (!empty($aVals['v_cut_off_time']) ? date('Y-m-d H:i:s',strtotime($aVals['v_cut_off_time'])) : null), 
					'v_departure_time'=> (!empty($aVals['v_departure_time']) ? date('Y-m-d H:i:s',strtotime($aVals['v_departure_time'])) : null), 
					'v_arrival_time'=> (!empty($aVals['v_arrival_time']) ? date('Y-m-d H:i:s',strtotime($aVals['v_arrival_time'])) : null), 
					'v_airline'=> (isset($aVals['v_airline']) ? $aVals['v_airline'] : 0), 
					'v_service_level'=> (isset($aVals['v_service_level']) ? $aVals['v_service_level'] : 0), 
				 );

				 $addVals = (isset($postData['vendor_airline']) ? $postData['vendor_airline'] : null);
				 
				 $vendor_airline = array();
				 
				 if(isset($addVals['carrier_name']) && !empty($addVals['carrier_name'])){
					foreach($addVals['carrier_name'] as $key => $cnt){
						if(!empty($cnt) && !empty($addVals['flight_name'][$key]) && !empty($addVals['flight_origin'][$key]) && !empty($addVals['flight_dest'][$key])){
						
							$vendor_airline[$key]['carrier_name'] = $cnt;
							
							$vendor_airline[$key]['carrier_id'] = (isset($addVals['carrier_id'][$key]) ? $addVals['carrier_id'][$key] : '');
							
							$vendor_airline[$key]['flight_name'] = (isset($addVals['flight_name'][$key]) ? $addVals['flight_name'][$key] : '');
							
							$vendor_airline[$key]['flight_origin'] = (isset($addVals['flight_origin'][$key]) ? $addVals['flight_origin'][$key] : '');
							
							$vendor_airline[$key]['flight_origin_id'] = (isset($addVals['flight_origin_id'][$key]) ? $addVals['flight_origin_id'][$key] : '');
							
							$vendor_airline[$key]['flight_dest'] = (isset($addVals['flight_dest'][$key]) ? $addVals['flight_dest'][$key] : '');
							
							$vendor_airline[$key]['flight_dest_id'] = (isset($addVals['flight_dest_id'][$key]) ? $addVals['flight_dest_id'][$key] : '');
							
							$vendor_airline[$key]['flight_dept'] = (isset($addVals['flight_dept'][$key]) ? $addVals['flight_dept'][$key] : '');
							
							$vendor_airline[$key]['flight_arrival'] = (isset($addVals['flight_arrival'][$key]) ? $addVals['flight_arrival'][$key] : '');
													
						}
					}
				}
			 
				$vendor_airline = json_encode($vendor_airline);
				
				$shipInfo['vendor_airline_datas'] = $vendor_airline;
				
				$this->db->where('dom_id', $adata->dom_id);
				$this->db->update('tbl_domestic_vendors', $shipInfo);
				
				return $adata->dom_id;
			}else{
			
				$shipInfo = array(
					'shipment_id'=> $aVals['shipment_id'], 
					'p_v_type_id'=> $aVals['p_v_type_id'], 
					'p_vendor_id'=> $aVals['p_vendor_id'], 
					'p_ref_name'=> $p_ref_name, 
					'rate_basis'=> $aVals['rate_basis'], 
					'p_qty'=> (isset($aVals['p_qty']) ? $aVals['p_qty'] : ''),
					'p_rate'=> (isset($aVals['p_rate']) ? $aVals['p_rate'] : ''), 
					'p_cost'=> (isset($aVals['p_cost']) ? $aVals['p_cost'] : ''),
					'p_extra'=> (isset($aVals['p_extra']) ? $aVals['p_extra'] : ''),
					'p_tax'=> (isset($aVals['p_tax']) ? $aVals['p_tax'] : ''),
					'p_total_cost'=> (isset($aVals['p_total_cost']) ? $aVals['p_total_cost'] : ''), 
					'p_finalize'=> (isset($aVals['p_finalize']) ? $aVals['p_finalize'] : 0), 
					
					'v_origin_id'=> (isset($aVals['v_origin_id']) ? $aVals['v_origin_id'] : 0), 
					'v_destination_id'=> (isset($aVals['v_destination_id']) ? $aVals['v_destination_id'] : 0), 
					'v_mawb'=> (isset($aVals['v_mawb']) ? $aVals['v_mawb'] : 0), 
					'v_auto_assign'=> (isset($aVals['v_auto_assign']) ? $aVals['v_auto_assign'] : 0), 
					'v_account'=> (isset($aVals['v_account']) ? $aVals['v_account'] : 0), 
					'v_cut_off_time'=> (isset($aVals['v_cut_off_time']) ? $aVals['v_cut_off_time'] : null), 
					'v_departure_time'=> (isset($aVals['v_departure_time']) ? $aVals['v_departure_time'] : null), 
					'v_arrival_time'=> (isset($aVals['v_arrival_time']) ? $aVals['v_arrival_time'] : null), 
					'v_airline'=> (isset($aVals['v_airline']) ? $aVals['v_airline'] : 0), 
					'v_service_level'=> (isset($aVals['v_service_level']) ? $aVals['v_service_level'] : 0), 
				 );
				 
				 $addVals = (isset($postData['vendor_airline']) ? $postData['vendor_airline'] : null);
				 
				 $vendor_airline = array();
				 
				 if(isset($addVals['carrier_name']) && !empty($addVals['carrier_name'])){
					foreach($addVals['carrier_name'] as $key => $cnt){
						if(!empty($cnt) && !empty($addVals['flight_name'][$key]) && !empty($addVals['flight_origin'][$key]) && !empty($addVals['flight_dest'][$key])){
						
							$vendor_airline[$key]['carrier_name'] = $cnt;
							
							$vendor_airline[$key]['carrier_id'] = (isset($addVals['carrier_id'][$key]) ? $addVals['carrier_id'][$key] : '');
							
							$vendor_airline[$key]['flight_name'] = (isset($addVals['flight_name'][$key]) ? $addVals['flight_name'][$key] : '');
							
							$vendor_airline[$key]['flight_origin'] = (isset($addVals['flight_origin'][$key]) ? $addVals['flight_origin'][$key] : '');
							
							$vendor_airline[$key]['flight_origin_id'] = (isset($addVals['flight_origin_id'][$key]) ? $addVals['flight_origin_id'][$key] : '');
							
							$vendor_airline[$key]['flight_dest'] = (isset($addVals['flight_dest'][$key]) ? $addVals['flight_dest'][$key] : '');
							
							$vendor_airline[$key]['flight_dest_id'] = (isset($addVals['flight_dest_id'][$key]) ? $addVals['flight_dest_id'][$key] : '');
							
							$vendor_airline[$key]['flight_dept'] = (isset($addVals['flight_dept'][$key]) ? $addVals['flight_dept'][$key] : '');
							
							$vendor_airline[$key]['flight_arrival'] = (isset($addVals['flight_arrival'][$key]) ? $addVals['flight_arrival'][$key] : '');
													
						}
					}
				}
			 
				$vendor_airline = json_encode($vendor_airline);
				
				$shipInfo['vendor_airline_datas'] = $vendor_airline;
				
				$this->db->trans_start();
				$this->db->insert('tbl_domestic_vendors', $shipInfo);
				
				$insert_id = $this->db->insert_id();
				
				$this->db->trans_complete();
				
				return $insert_id;
			}
	 } 
	 
	 function savespecialInstructions($postData){
			
			$aVals = $postData;
			
			$this->db->select("*");
			$this->db->from("tbl_domestic_shipments");
			$this->db->where("shipment_id =", $aVals['org_ship_id']);
			$query = $this->db->get();
			$adata = $query->row();
			
		
			if(!empty($adata)){
				$spins_datas = array();
				if(isset($aVals['spdatas']) && !empty($aVals['spdatas'])){
					$spins_datas = $aVals['spdatas'];
				}

				$spchk_datas = array();
				if(isset($aVals['spdatas']['sp_pickup_instructions']) && !empty($aVals['spdatas']['sp_pickup_instructions'])){
					$spchk_datas['sp_p'] = 1;
				}
				if(isset($aVals['spdatas']['sp_delivery_instructions']) && !empty($aVals['spdatas']['sp_delivery_instructions'])){
					$spchk_datas['sp_d'] = 1;
				}
				if(isset($aVals['spdatas']['sp_special_instructions']) && !empty($aVals['spdatas']['sp_special_instructions'])){
					$spchk_datas['sp_s'] = 1;
				}
				if(isset($aVals['spdatas']['sp_quote_notes']) && !empty($aVals['spdatas']['sp_quote_notes'])){
					$spchk_datas['sp_q'] = 1;
				}
				if(isset($aVals['spdatas']['sp_invoice_notes']) && !empty($aVals['spdatas']['sp_invoice_notes'])){
					$spchk_datas['sp_i'] = 1;
				}
				if(isset($aVals['spdatas']['sp_transfer_instructions']) && !empty($aVals['spdatas']['sp_transfer_instructions'])){
					$spchk_datas['sp_t'] = 1;
				}
				
				
				$shipInfo = array(
					'sp_ins_datas'=>json_encode($spins_datas), 
					'spchk_datas'=>json_encode($spchk_datas), 
				);
								
				$this->db->where('shipment_id', $adata->shipment_id);
				$this->db->update('tbl_domestic_shipments', $shipInfo);
				
				return $adata->shipment_id;
			}
			
	 } 
	 
	 
	 function checkandInsertMAWBdatas($amawbdata){
					
			$this->db->select("*");
			$this->db->from("tbl_domestic_mawb_datas");

			$this->db->where("shipment_id =", $amawbdata['shipment_id']);
			$query = $this->db->get();
			$adata = $query->row();

			if(!empty($adata)){
				
				$this->db->where('mawb_id', $adata->mawb_id);
				$this->db->update('tbl_domestic_mawb_datas', $amawbdata);
				
				return $adata->mawb_id;
			}else{

				$this->db->trans_start();
				$this->db->insert('tbl_domestic_mawb_datas', $amawbdata);
				
				$insert_id = $this->db->insert_id();
				
				$this->db->trans_complete();
				
				return $insert_id;
			}
	 } 
	 
	 function checkandInsertTrasferAlert($postData){
			
			$aVals = $postData;
			
			$this->db->select("*");
			$this->db->from("tbl_domestic_transfer_datas");

			$this->db->where("shipment_id =", $postData['shipment_id']);
			$query = $this->db->get();
			$adata = $query->row();
			
			 
			 
			if(!empty($adata)){
				$shipInfo = array(
					'r_id'=> $aVals['r_data']['r_id'], 
					't_id'=> $aVals['t_data']['t_id'], 
					'recover_from'=>  (isset($aVals['r_id']['recover_from']) ? $aVals['r_id']['recover_from'] : ''),
					'transfer_to'=>  (isset($aVals['t_id']['transfer_to']) ? $aVals['t_id']['transfer_to'] : ''),
					'instructions'=> (isset($aVals['instructions']) ? $aVals['instructions'] : ''),
					'r_data'=> json_encode($aVals['r_data']), 
					't_data'=> json_encode($aVals['t_data']),
				 );
				
				$this->db->where('data_id', $adata->data_id);
				$this->db->update('tbl_domestic_transfer_datas', $shipInfo);
				
				return $adata->data_id;
			}else{
			
				$shipInfo = array(
					'shipment_id'=> $postData['shipment_id'], 
					'r_id'=> $aVals['r_data']['r_id'], 
					't_id'=> $aVals['t_data']['t_id'], 
					'recover_from'=>  (isset($aVals['r_id']['recover_from']) ? $aVals['r_id']['recover_from'] : ''),
					'transfer_to'=>  (isset($aVals['t_id']['transfer_to']) ? $aVals['t_id']['transfer_to'] : ''), 
					'instructions'=> (isset($aVals['instructions']) ? $aVals['instructions'] : ''),
					'r_data'=> json_encode($aVals['r_data']), 
					't_data'=> json_encode($aVals['t_data']),
				 );

				$this->db->trans_start();
				$this->db->insert('tbl_domestic_transfer_datas', $shipInfo);
				
				$insert_id = $this->db->insert_id();
				
				$this->db->trans_complete();
				
				return $insert_id;
			}
	 } 
	 
	 function checkandInsertRoutingAlert($postData){
			
			$aVals = $postData;
			
			$this->db->select("*");
			$this->db->from("tbl_domestic_routing_datas");

			$this->db->where("shipment_id =", $postData['shipment_id']);
			$query = $this->db->get();
			$adata = $query->row();
			
			 
			 $addVals = (isset($postData['airline_datas']) ? $postData['airline_datas'] : null);
				 
			 $vendor_airline = array();
			 
			 if(isset($addVals['carrier_name']) && !empty($addVals['carrier_name'])){
				foreach($addVals['carrier_name'] as $key => $cnt){
					if(!empty($cnt) && !empty($addVals['flight_name'][$key]) && !empty($addVals['flight_origin'][$key]) && !empty($addVals['flight_dest'][$key])){
					
						$vendor_airline[$key]['carrier_name'] = $cnt;
						
						$vendor_airline[$key]['carrier_id'] = (isset($addVals['carrier_id'][$key]) ? $addVals['carrier_id'][$key] : '');
						
						$vendor_airline[$key]['flight_name'] = (isset($addVals['flight_name'][$key]) ? $addVals['flight_name'][$key] : '');
						
						$vendor_airline[$key]['flight_origin'] = (isset($addVals['flight_origin'][$key]) ? $addVals['flight_origin'][$key] : '');
						
						$vendor_airline[$key]['flight_origin_id'] = (isset($addVals['flight_origin_id'][$key]) ? $addVals['flight_origin_id'][$key] : '');
						
						$vendor_airline[$key]['flight_dest'] = (isset($addVals['flight_dest'][$key]) ? $addVals['flight_dest'][$key] : '');
						
						$vendor_airline[$key]['flight_dest_id'] = (isset($addVals['flight_dest_id'][$key]) ? $addVals['flight_dest_id'][$key] : '');
						
						$vendor_airline[$key]['flight_dept'] = (isset($addVals['flight_dept'][$key]) ? $addVals['flight_dept'][$key] : '');
						
						$vendor_airline[$key]['flight_arrival'] = (isset($addVals['flight_arrival'][$key]) ? $addVals['flight_arrival'][$key] : '');
												
					}
				}
			}
				
			if(!empty($adata)){
				$shipInfo = array(
					'r_id'=> $aVals['r_f_data']['r_id'], 
					't_id'=> $aVals['t_f_data']['t_id'], 
					'route_from'=> (isset($aVals['r_f_data']['route_from']) ? $aVals['r_f_data']['route_from'] : ''), 
					'route_to'=> (isset($aVals['t_f_data']['route_to']) ? $aVals['t_f_data']['route_to'] : ''), 
					
					'r_f_data'=> json_encode($aVals['r_f_data']), 
					't_f_data'=> json_encode($aVals['t_f_data']),
					'airbill_station'=> (isset($aVals['val']['airbill_station']) ? $aVals['val']['airbill_station'] : ''),
					'airbill_number'=> (isset($aVals['val']['airbill_number']) ? $aVals['val']['airbill_number'] : ''),
					'ro_station'=> (isset($aVals['val']['ro_station']) ? $aVals['val']['ro_station'] : ''),
					'ro_origin_id'=> (isset($aVals['val']['ro_origin_id']) ? $aVals['val']['ro_origin_id'] : ''),
					'ro_dest_id'=> (isset($aVals['val']['ro_dest_id']) ? $aVals['val']['ro_dest_id'] : ''),
					'ro_airline'=> (isset($aVals['val']['ro_airline']) ? $aVals['val']['ro_airline'] : ''),
					'ro_mawb'=> (isset($aVals['val']['ro_mawb']) ? $aVals['val']['ro_mawb'] : ''),
					'ro_lockout_time'=> (isset($aVals['val']['ro_lockout_time']) ? $aVals['val']['ro_lockout_time'] : ''),
					'ro_account'=> (isset($aVals['val']['ro_account']) ? $aVals['val']['ro_account'] : ''),
					'airline_datas'=> (isset($aVals['val']['airline_datas']) ? $aVals['val']['airline_datas'] : ''),
					'airline_datas'=> json_encode($vendor_airline),
					'generate_by' => $this->session->userdata('userId')
				 );
				
				$this->db->where('route_id', $adata->route_id);
				$this->db->update('tbl_domestic_routing_datas', $shipInfo);
				
				return $adata->route_id;
			}else{
			
				$shipInfo = array(
					'shipment_id'=> $postData['shipment_id'], 
					'r_id'=> $aVals['r_f_data']['r_id'], 
					't_id'=> $aVals['t_f_data']['t_id'], 
					'route_from'=> (isset($aVals['r_f_data']['route_from']) ? $aVals['r_f_data']['route_from'] : ''), 
					'route_to'=> (isset($aVals['t_f_data']['route_to']) ? $aVals['t_f_data']['route_to'] : ''), 
					
					'r_f_data'=> json_encode($aVals['r_f_data']), 
					't_f_data'=> json_encode($aVals['t_f_data']),
					'airbill_station'=> (isset($aVals['val']['airbill_station']) ? $aVals['val']['airbill_station'] : ''),
					'airbill_number'=> (isset($aVals['val']['airbill_number']) ? $aVals['val']['airbill_number'] : ''),
					'ro_station'=> (isset($aVals['val']['ro_station']) ? $aVals['val']['ro_station'] : ''),
					'ro_origin_id'=> (isset($aVals['val']['ro_origin_id']) ? $aVals['val']['ro_origin_id'] : ''),
					'ro_dest_id'=> (isset($aVals['val']['ro_dest_id']) ? $aVals['val']['ro_dest_id'] : ''),
					'ro_airline'=> (isset($aVals['val']['ro_airline']) ? $aVals['val']['ro_airline'] : ''),
					'ro_mawb'=> (isset($aVals['val']['ro_mawb']) ? $aVals['val']['ro_mawb'] : ''),
					'ro_lockout_time'=> (isset($aVals['val']['ro_lockout_time']) ? $aVals['val']['ro_lockout_time'] : ''),
					'ro_account'=> (isset($aVals['val']['ro_account']) ? $aVals['val']['ro_account'] : ''),
					'airline_datas'=> (isset($aVals['val']['airline_datas']) ? $aVals['val']['airline_datas'] : ''),
					'airline_datas'=> json_encode($vendor_airline),
				 );

				$this->db->trans_start();
				$this->db->insert('tbl_domestic_routing_datas', $shipInfo);
				
				$insert_id = $this->db->insert_id();
				
				$this->db->trans_complete();
				
				return $insert_id;
			}
	 } 
	 
	 
	 function checkandInsertChargeCode($postData){
			$aVals = $postData;
			
			$this->db->select("*");
			$this->db->from("tbl_domestic_charge_codes");

			$this->db->where("shipment_id =", $aVals['shipment_id']);
			$this->db->where("charge_code_id =", $aVals['charge_code_id']);
			$query = $this->db->get();
			$adata = $query->row();
			
			 
			 
			if(!empty($adata)){
				$shipInfo = array(
					'shipment_id'=> $aVals['shipment_id'], 
					'charge_code_id'=> $aVals['charge_code_id'], 
					'charge_code_description'=> $aVals['charge_code_description'], 
					'charge_code_rate_basis'=> $aVals['charge_code_rate_basis'], 
					'charge_code_qty'=> (isset($aVals['charge_code_qty']) ? $aVals['charge_code_qty'] : ''),
					'charge_code_rate'=> (isset($aVals['charge_code_rate']) ? $aVals['charge_code_rate'] : ''), 
					'charge_code_charge'=> (isset($aVals['charge_code_charge']) ? $aVals['charge_code_charge'] : ''),
					'charge_code_total_cost'=> (isset($aVals['charge_code_total_cost']) ? $aVals['charge_code_total_cost'] : ''),
				 );

				$this->db->where('p_id', $adata->p_id);
				$this->db->update('tbl_domestic_charge_codes', $shipInfo);
				
				return $adata->p_id;
			}else{
			
				$shipInfo = array(
					'shipment_id'=> $aVals['shipment_id'], 
					'charge_code_id'=> $aVals['charge_code_id'], 
					'charge_code_description'=> $aVals['charge_code_description'], 
					'charge_code_rate_basis'=> $aVals['charge_code_rate_basis'], 
					'charge_code_qty'=> (isset($aVals['charge_code_qty']) ? $aVals['charge_code_qty'] : ''),
					'charge_code_rate'=> (isset($aVals['charge_code_rate']) ? $aVals['charge_code_rate'] : ''), 
					'charge_code_charge'=> (isset($aVals['charge_code_charge']) ? $aVals['charge_code_charge'] : ''),
					'charge_code_total_cost'=> (isset($aVals['charge_code_total_cost']) ? $aVals['charge_code_total_cost'] : ''),
				 );
			 
				$this->db->trans_start();
				$this->db->insert('tbl_domestic_charge_codes', $shipInfo);
				
				$insert_id = $this->db->insert_id();
				
				$this->db->trans_complete();
				
				return $insert_id;
			}
	 } 
	 
	function updateChargeCode($updateinfo, $p_id)
    {
        $this->db->where('p_id', $p_id);
        $this->db->update('tbl_domestic_charge_codes', $updateinfo);
        
        return TRUE;
    }
	 
	 function checkandInsertExtraChargeCode($postData){
			$aVals = $postData;
			
			$this->db->select("*");
			$this->db->from("tbl_domestic_extra_charges");

			$this->db->where("shipment_id =", $aVals['shipment_id']);
			$this->db->where("charge_code_id =", $aVals['charge_code_id']);
			$query = $this->db->get();
			$adata = $query->row();
			
			 
			 
			if(!empty($adata)){
				$shipInfo = array(
					'shipment_id'=> $aVals['shipment_id'], 
					'charge_code_id'=> $aVals['charge_code_id'], 
					'charge_code_description'=> $aVals['charge_code_description'], 
					'charge_code_rate_basis'=> $aVals['charge_code_rate_basis'], 
					'charge_code_qty'=> (isset($aVals['charge_code_qty']) ? $aVals['charge_code_qty'] : ''),
					'charge_code_rate'=> (isset($aVals['charge_code_rate']) ? $aVals['charge_code_rate'] : ''), 
					'charge_code_charge'=> (isset($aVals['charge_code_charge']) ? $aVals['charge_code_charge'] : ''),
					'charge_code_total_cost'=> (isset($aVals['charge_code_total_cost']) ? $aVals['charge_code_total_cost'] : ''),
				 );

				$this->db->where('c_id', $adata->c_id);
				$this->db->update('tbl_domestic_extra_charges', $shipInfo);
				
				return $adata->c_id;
			}else{
			
				$shipInfo = array(
					'shipment_id'=> $aVals['shipment_id'], 
					'charge_code_id'=> $aVals['charge_code_id'], 
					'charge_code_description'=> $aVals['charge_code_description'], 
					'charge_code_rate_basis'=> $aVals['charge_code_rate_basis'], 
					'charge_code_qty'=> (isset($aVals['charge_code_qty']) ? $aVals['charge_code_qty'] : ''),
					'charge_code_rate'=> (isset($aVals['charge_code_rate']) ? $aVals['charge_code_rate'] : ''), 
					'charge_code_charge'=> (isset($aVals['charge_code_charge']) ? $aVals['charge_code_charge'] : ''),
					'charge_code_total_cost'=> (isset($aVals['charge_code_total_cost']) ? $aVals['charge_code_total_cost'] : ''),
				 );
			 
				$this->db->trans_start();
				$this->db->insert('tbl_domestic_extra_charges', $shipInfo);
				
				$insert_id = $this->db->insert_id();
				
				$this->db->trans_complete();
				
				return $insert_id;
			}
	 } 
	 
	 
	 function updateTrackInfo($trackInfo, $aVals, $shipment_id){ 
			
			$this->db->select("*");
			$this->db->from("tbl_domestic_tracking");
			$this->db->where('shipping_id', $shipment_id);
			$this->db->where('current_status', $aVals['current_status']);
			$query = $this->db->get();
			$adata = $query->row();
			
			$trackInfo['updated_time'] = date('Y-m-d H:i:s');
			if(!empty($adata)){
			
				$this->db->where('track_id', $adata->track_id);
				$this->db->update('tbl_domestic_tracking', $trackInfo);
				
				return $adata->track_id;
				
			}else{
				$this->db->trans_start();
				$this->db->insert('tbl_domestic_tracking', $trackInfo);
				
				$insert_id = $this->db->insert_id();
				
				$this->db->trans_complete();
				
				return $insert_id;
			}
			
	 } 
	 
	 function loadSelectedChargeCodes($shipment_id){
	 
		$this->db->select('BaseTbl.*,t2.charge_id,t2.charge_code as charge_code_name');
		$this->db->from('tbl_domestic_charge_codes as BaseTbl');
		$this->db->join('tbl_charge_codes as t2', 't2.charge_id = BaseTbl.charge_code_id','left');
		
		$this->db->where("BaseTbl.shipment_id  = ". $shipment_id);
		
		$this->db->order_by('FIELD(t2.charge_id, 21) DESC , t2.charge_id ASC');
		$query = $this->db->get();
		
		$records = $query->result();  

		return $records;
	 }
	 
	 function loadSelectedExtraChargeCodes($shipment_id){
	 
		$this->db->select('BaseTbl.*,t2.charge_id,t2.charge_code as charge_code_name');
		$this->db->from('tbl_domestic_extra_charges as BaseTbl');
		$this->db->join('tbl_charge_codes as t2', 't2.charge_id = BaseTbl.charge_code_id','left');
		
		$this->db->where("BaseTbl.shipment_id  = ". $shipment_id);
		
		$this->db->order_by('FIELD(t2.charge_id, 21) DESC , t2.charge_id ASC');
		
		$query = $this->db->get();
		
		$records = $query->result();  

		return $records;
	 }
	 
	 function loadlastTrackingRecord($shipment_id){
	 
		$this->db->select('BaseTbl.*');
		$this->db->from('tbl_domestic_tracking as BaseTbl');
		$this->db->where("BaseTbl.shipping_id  = ". $shipment_id);
		
		$this->db->order_by('BaseTbl.updated_time', 'DESC');
		
		$query = $this->db->get();
	
		$result = $query->row_array();  

		return $result;
	 }
	 
	 
	 function loadlastMAWBdatas($shipment_id){
	 
		$this->db->select('BaseTbl.*, u.name as sysname');
		$this->db->from('tbl_domestic_mawb_datas as BaseTbl');
		$this->db->join('tbl_users as u', 'u.userId = BaseTbl.generate_by','left');
		$this->db->where("BaseTbl.shipment_id  = ". $shipment_id);
		
		$this->db->order_by('BaseTbl.mawb_id', 'DESC');
		
		$query = $this->db->get();
	
		$result = $query->row_array();  
		if(!empty($result)){
			$result['s_data'] = (array)  json_decode($result['s_data']);
			$result['s_data']['customer_data'] = (array) $this->Customer_model->getCustomerInfo($result['s_data']['s_id']);
			$result['s_data']['state_name'] = $this->getStateName($result['s_data']['s_state']);
			$result['s_data']['country_name'] = $this->getCountryName($result['s_data']['s_country']);
			
			$result['c_data'] = (array)  json_decode($result['c_data']);
			$result['c_data']['customer_data'] = (array) $this->Customer_model->getCustomerInfo($result['c_data']['c_id']);
			$result['c_data']['state_name'] = $this->getStateName($result['c_data']['c_state']);
			$result['c_data']['country_name'] = $this->getCountryName($result['c_data']['c_country']);
			
			$result['a_data'] = (array)  json_decode($result['a_data']);
			$result['a_data']['state_name'] = $this->getStateName($result['a_data']['a_state']);
			$result['a_data']['country_name'] = $this->getCountryName($result['a_data']['a_country']);
			
			$result['issued_by_data'] = (array) $this->Customer_model->getCustomerInfo($result['issued_by_id']);
			$result['issued_by_data']['state_name'] = $this->getStateName((isset($result['issued_by_data']['c_state']) ? $result['issued_by_data']['c_state'] : ''));
			$result['issued_by_data']['country_name'] = $this->getCountryName((isset($result['issued_by_data']['c_country']) ? $result['issued_by_data']['c_country'] : ''));
			
			$result['ap_data'] = (array)  json_decode($result['ap_data']);
			$result['charge_data'] = (array)  json_decode($result['charge_data']);
			
			$fr_datas = (array) json_decode($result['fr_data']);
			$frarray = array();
			foreach($fr_datas as $id => $frdata) {
			  
			  $frarray[$id] = (array) $frdata;
			}
			$result['fr_data'] =$frarray;
			
		}
		return $result;
	 }
	 
	 function loadSelectedVendors($shipment_id){
	 
		$this->db->select('BaseTbl.*,t2.vendor_type,t2.vendor_short_code,t3.customer_number, t3.customer_name as agent_name,t3.c_phone as agent_phone,t3.c_fax as agent_fax,t3.account_no as agent_account_no, t4.airport_code as origin_airport_code,t4.city as origin_airport_city,t5.airport_code as dest_airport_code,t5.city as dest_airport_city');
		$this->db->from('tbl_domestic_vendors as BaseTbl');
		$this->db->join('tbl_vendor_types as t2', 't2.v_type_id = BaseTbl.p_v_type_id','left');
		$this->db->join('tbl_customers as t3', 't3.customer_id = BaseTbl.p_vendor_id','left');
		$this->db->join('tbl_airports as t4', 't4.airport_id = BaseTbl.v_origin_id','left');
		$this->db->join('tbl_airports as t5', 't5.airport_id = BaseTbl.v_destination_id','left');
		
		$this->db->where("BaseTbl.shipment_id  = ". $shipment_id);
		
		$this->db->order_by('BaseTbl.p_v_type_id', 'ASC');
		
		$query = $this->db->get();
		
		$records = $query->result();  

		return $records;
	 }
	 
	 function loadSelectedVendorsbasedonid($shipment_id, $typeid){
	 
		$this->db->select('BaseTbl.*,t2.vendor_type,t2.vendor_short_code,t3.customer_number, t3.customer_name as agent_name,t3.c_phone as agent_phone,t3.c_fax as agent_fax');
		$this->db->from('tbl_domestic_vendors as BaseTbl');
		$this->db->join('tbl_vendor_types as t2', 't2.v_type_id = BaseTbl.p_v_type_id','left');
		$this->db->join('tbl_customers as t3', 't3.customer_id = BaseTbl.p_vendor_id','left');
		
		$this->db->where("BaseTbl.shipment_id  = ". $shipment_id);
		$this->db->where("BaseTbl.p_v_type_id  = ". $typeid);
		$this->db->limit(1);
		$this->db->order_by('BaseTbl.p_v_type_id', 'ASC');
		
		$query = $this->db->get();
		
		$records = $query->row();  

		return (array)$records;
	 }
	 
	 function removeVendorType($domid){
	 
		$this->db->where('dom_id', $domid);
		
		$this->db->delete('tbl_domestic_vendors');
		
		return true;
	 }
	 
	 function removeChargeCode($pid){
	 
		$this->db->where('p_id', $pid);
		
		$this->db->delete('tbl_domestic_charge_codes');
		
		return true;
	 }

	 function removeExtraChargeCode($pid){
	 
		$this->db->where('c_id', $pid);
		
		$this->db->delete('tbl_domestic_extra_charges');
		
		return true;
	 } 
	 
	function deleteDomesticShipment($shipment_id)
    {
        $this->db->where('shipment_id', $shipment_id)->delete('tbl_domestic_shipments');
		
        $this->db->where('shipment_id', $shipment_id)->delete('tbl_domestic_vendors');
		
        $this->db->where('shipment_id', $shipment_id)->delete('tbl_domestic_charge_codes');
		
        $this->db->where('shipment_id', $shipment_id)->delete('tbl_domestic_extra_charges');
		
        $this->db->where('shipping_id', $shipment_id)->delete('tbl_domestic_tracking');
		
        $this->db->where('shipment_id', $shipment_id)->delete('tbl_domestic_transfer_datas');
		
        $this->db->where('shipment_id', $shipment_id)->delete('tbl_domestic_mawb_datas');
		
        $this->db->where('shipment_id', $shipment_id)->delete('tbl_domestic_routing_datas');
		 
        return true; 
    }
	
	function deleteTransferAlert($shipment_id)
    {
        $this->db->where('shipment_id', $shipment_id)->delete('tbl_domestic_transfer_datas');
        return true;
    }
	
	function deleteRoutingAlert($shipment_id)
    {
        $this->db->where('shipment_id', $shipment_id)->delete('tbl_domestic_routing_datas');
        return true;
    }
	
	function deleteAirport($airport_id)
    {
        $this->db->where('airport_id', $airport_id)->delete('tbl_airports');
		
        return true;
    }  
	
	function saveAirport($aInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_airports', $aInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
	
	function updateAirport($aInfo, $airport_id)
    {
        $this->db->where('airport_id', $airport_id);
        $this->db->update('tbl_airports', $aInfo);
        
        return TRUE;
    }
	
	function checkAirportCodeExist($airport_code, $airportid = null)
    {
        $this->db->select('BaseTbl.airport_id');
        $this->db->from('tbl_airports as BaseTbl');
        $this->db->where('BaseTbl.airport_code', $airport_code);
		if(!empty($airportid)){
			$this->db->where('BaseTbl.airport_id !=', $airportid);
		}
        $query = $this->db->get();
		$result = '';
        if(isset($query->row()->airport_id)){
			$result = $query->row()->airport_id; 
		}		
        return $result;				
    }
	
	function getAirportInfo($airport_id)
    {
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_airports as BaseTbl');
        $this->db->where('BaseTbl.airport_id', $airport_id);
        $query = $this->db->get();
        
        return $query->row();
    }
	
	function shipquickbook(){
		echo "here";
	}
	
	function updateExtraCosttoQuickbook($shipment_id){
	
		$shipInfo = $this->shipment_model->getDomesticInfo($shipment_id);
		
		if(empty($shipInfo)){
			$aReturn['response_message'] = 'Not a valid shipment data';
			$aReturn['response_status'] = 'error';
			return $aReturn;
		}
		
		/* if($shipInfo['is_finalize'] == 1){
		
			$dataService = DataService::Configure(array(
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
			
			//$aVenRecords = $this->shipment_model->loadSelectedVendors($shipment_id);
			$aChargeRecords = $this->shipment_model->loadSelectedChargeCodes($shipment_id);
			if(!empty($aChargeRecords)){
				$customerRef = $this->getCustomerObj($dataService, $shipInfo['bill_to_data']['customer_data']['customer_id']);

				$itemRef = $this->getItemObj($dataService, $shipment_id, $customerRef);
			}
			
			$aReturn['response_message'] = 'Invoice Added';
			$aReturn['response_status'] = 'success';
			return $aReturn;
		} */ 
		
		
		$aReturn['response_message'] = 'Data not finalized!';
		$aReturn['response_status'] = 'success';
		return $aReturn;
	}
	
	
	function getCustomerObj($dataService, $customerid) {

		$aResponse = $this->customer_model->updateCustomertoQuickbook($customerid);
		if ($aResponse['response_status'] = 'success') {
			//echo "Created Customer with Id={$customerResponseObj->Id}.\n\n";
			$uUpdateInfo = array(
				'quickbook_id' => $aResponse['quickbook_id'],
			);
			
			$this->customer_model->updateCustomer($uUpdateInfo, $customerid);
			return $aResponse['quickbook_response'];
		} else {
			logError($aResponse['response_status']);
		}
	}


	/*
	   Find if an Item is present , if not create new Item
	 */
	function getItemObj($dataService, $shipment_id, $customerRef) {

		
		$aChargeRecords = $this->shipment_model->loadSelectedChargeCodes($shipment_id);
		
		if(!empty($aChargeRecords)){
			foreach($aChargeRecords as $aChargeRecord){
			
				if($aChargeRecord->qp_invoice_id == 0){
				
					$itemName = $aChargeRecord->charge_code_name;
					$itemArray = $dataService->Query("select * from Item WHERE Name='" . $itemName . "'");
					$error = $dataService->getLastError();
					
					if ($error) {
						logError($error);
					}else{
						if (is_array($itemArray) && sizeof($itemArray) > 0) {
						
							$resultingItemObj = current($itemArray);
							
						}else{
							
							// Fetch IncomeAccount, ExoenseAccount and AssetAccount Refs needed to create an Item
							$incomeAccount = $this->getIncomeAccountObj($dataService);
							$expenseAccount = $this->getExpenseAccountObj($dataService);
							$assetAccount = $this->getAssetAccountObj($dataService);

							// Create Item
							$dateTime = new \DateTime('NOW');
							$ItemObj = Item::create([
								"Name" => $itemName,
								"Description" => $aChargeRecord->charge_code_description,
								"Active" => true,
								"FullyQualifiedName" => $aChargeRecord->charge_code_description . '('.$itemName.')',
								"Taxable" => false,
								"UnitPrice" => $aChargeRecord->charge_code_rate,
								"Type" => "Service",
								"IncomeAccountRef"=> [
									"value"=>  $incomeAccount->Id
								],
								"PurchaseDesc"=> "Custom Charges",
								"PurchaseCost"=> $aChargeRecord->charge_code_total_cost,
								"ExpenseAccountRef"=> [
									"value"=> $expenseAccount->Id
								],
								"AssetAccountRef"=> [
									"value"=> $assetAccount->Id
								],
								"TrackQtyOnHand" => false,
								"QtyOnHand"=> $aChargeRecord->charge_code_qty,
								"InvStartDate"=> $dateTime
							]);
							$resultingItemObj = $dataService->Add($ItemObj);
						}
						
						$invoiceObj = Invoice::create([
							"Line" => [
								"Description" => $aChargeRecord->charge_code_description,
								"Amount" => $aChargeRecord->charge_code_total_cost,
								"DetailType" => "SalesItemLineDetail",
								"SalesItemLineDetail" => [
									"Qty" => $aChargeRecord->charge_code_qty,
									"ItemRef" => [
										"value" => $resultingItemObj->Id
									]
								]
							],
							"CustomerRef"=> [
								"value"=> $customerRef->Id
							],
							"BillEmail" => [
								"Address" => (isset($customerRef->PrimaryEmailAddr->Address) ? $customerRef->PrimaryEmailAddr->Address : '')
							]
						]);
						$resultingInvoiceObj = $dataService->Add($invoiceObj);
						$invoiceId = $resultingInvoiceObj->Id;
						if($invoiceId){
							$uUpdateInfo = array(
								'qp_invoice_id' => $invoiceId
							);
							
							$this->shipment_model->updateChargeCode($uUpdateInfo, $aChargeRecord->p_id);
						}
					}
				}
			}
		}
		
	}
	
	function getGUID()
	{
		if (function_exists('com_create_guid')){
			return com_create_guid();
		}else{
			mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
			$charid = strtoupper(md5(uniqid(rand(), true)));
			$hyphen = chr(45);// "-"
			$uuid = // "{"
				$hyphen.substr($charid, 0, 8);
			return $uuid;
		}
	}
	
	/*
	  Find if an account of Income type exists, if not, create one
	*/
	function getIncomeAccountObj($dataService) {

		$accountArray = $dataService->Query("select * from Account where AccountType='" . INCOME_ACCOUNT_TYPE . "' and AccountSubType='" . INCOME_ACCOUNT_SUBTYPE . "'");
		$error = $dataService->getLastError();
		if ($error) {
			logError($error);
		} else {
			if (is_array($accountArray) && sizeof($accountArray) > 0) {
				return current($accountArray);
			}
		}

		// Create Income Account
		$incomeAccountRequestObj = Account::create([
			"AccountType" => INCOME_ACCOUNT_TYPE,
			"AccountSubType" => INCOME_ACCOUNT_SUBTYPE,
			"Name" => "IncomeAccount-" . getGUID()
		]);
		$incomeAccountObject = $dataService->Add($incomeAccountRequestObj);
		$error = $dataService->getLastError();
		if ($error) {
			logError($error);
		} else {
			//echo "Created Income Account with Id={$incomeAccountObject->Id}.\n\n";
			return $incomeAccountObject;
		}

	}

	/*
	  Find if an account of "Cost of Goods Sold" type exists, if not, create one
	*/
	function getExpenseAccountObj($dataService) {

		$accountArray = $dataService->Query("select * from Account where AccountType='" . EXPENSE_ACCOUNT_TYPE . "' and AccountSubType='" . EXPENSE_ACCOUNT_SUBTYPE . "'");
		$error = $dataService->getLastError();
		if ($error) {
			logError($error);
		} else {
			if (is_array($accountArray) && sizeof($accountArray) > 0) {
				return current($accountArray);
			}
		}

		// Create Expense Account
		$expenseAccountRequestObj = Account::create([
			"AccountType" => EXPENSE_ACCOUNT_TYPE,
			"AccountSubType" => EXPENSE_ACCOUNT_SUBTYPE,
			"Name" => "ExpenseAccount-" . getGUID()
		]);
		$expenseAccountObj = $dataService->Add($expenseAccountRequestObj);
		$error = $dataService->getLastError();
		if ($error) {
			logError($error);
		} else {
			//echo "Created Expense Account with Id={$expenseAccountObj->Id}.\n\n";
			return $expenseAccountObj;
		}

	}

	/*
	  Find if an account of "Other Current Asset" type exists, if not, create one
	*/
	function getAssetAccountObj($dataService) {

		$accountArray = $dataService->Query("select * from Account where AccountType='" . ASSET_ACCOUNT_TYPE . "' and AccountSubType='" . ASSET_ACCOUNT_SUBTYPE . "'");
		$error = $dataService->getLastError();
		if ($error) {
			logError($error);
		} else {
			if (is_array($accountArray) && sizeof($accountArray) > 0) {
				return current($accountArray);
			}
		}

		// Create Asset Account
		$assetAccountRequestObj = Account::create([
			"AccountType" => ASSET_ACCOUNT_TYPE,
			"AccountSubType" => ASSET_ACCOUNT_SUBTYPE,
			"Name" => "AssetAccount-" . getGUID()
		]);
		$assetAccountObj = $dataService->Add($assetAccountRequestObj);
		$error = $dataService->getLastError();
		if ($error) {
			logError($error);
		} else {
			//echo "Created Asset Account with Id={$assetAccountObj->Id}.\n\n";
			return $assetAccountObj;
		}

	}

	
}

  