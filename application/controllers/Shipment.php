<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Shipment extends BaseController
{ 
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('shipment_model');
        $this->load->model('customer_model');
        $this->load->model('user_model');
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
    function domesticShipment()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {        
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $searchCode = $this->security->xss_clean($this->input->post('searchCode'));
			
            $data['searchText'] = $searchText;
            $data['searchCode'] = $searchCode;
            
            $this->load->library('pagination');
            
            $count = $this->shipment_model->domesticShipmentListingCount($data);

			$returns = $this->paginationCompress ( "domesticShipment/", $count, 10 ); 
            
            $data['domesticRecords'] = $this->shipment_model->domesticShipmentListing($data, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'JustShipIt : Domestic Shipments';
            
            $this->loadViews("shipment/domestic", $this->global, $data, NULL);
        }
    }
	
	function addDomesticShipment()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('shipment_model');

            $data['countries'] = $this->customer_model->getCountries();
            $data['states'] = array();
            $data['reftypes'] = $this->customer_model->getRefTypes();
			
			$data['servicelevels'] = $this->shipment_model->getServicelevels();
			$data['orderstatus'] = $this->shipment_model->getOrderStatus();
			$data['types'] = $this->shipment_model->getFrieghtTypes();
			$data['classes'] = $this->customer_model->getClasses();
			
            $this->global['pageTitle'] = 'JustShipIt : Add New Domestic Shipment';

            $this->loadViews("shipment/addDomesticShipment", $this->global, $data, NULL);
        }
    }
	
	function editDomesticShipment($shipmentid = NULL)
    {
		
		//return false;
		$aGetData = $this->input->get();
		
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('shipment_model');

            $data['countries'] = $this->customer_model->getCountries();
            $data['states'] = array();
            $data['reftypes'] = $this->customer_model->getRefTypes();
			$data['servicelevels'] = $this->shipment_model->getServicelevels();
			$data['airservicelevels'] = $this->shipment_model->getAirlineServicelevels();
			$data['orderstatus'] = $this->shipment_model->getOrderStatus();
			$data['types'] = $this->shipment_model->getFrieghtTypes();
			$data['classes'] = $this->customer_model->getClasses();
			
			$shipInfo = $this->shipment_model->getDomesticInfo($shipmentid);
			 
			$data['shipInfo'] = $shipInfo;
			
			$data['opentab'] = (isset($aGetData['showtab']) ? $aGetData['showtab'] : 'home-tab');
			
			$data['aVenRecords'] = $this->shipment_model->loadSelectedVendors($shipmentid);
			
			$data['aChargeRecords'] = $this->shipment_model->loadSelectedChargeCodes($shipmentid);
			
			$data['trackrecords'] = $this->shipment_model->loadlastTrackingRecord($shipmentid);
			
			$data['rate_basis'] = $this->shipment_model->getRateBasis(); 
			
			$data['s_states'] = $this->customer_model->getStateList($shipInfo['shipper_data']['s_country']);
			$data['c_states'] = $this->customer_model->getStateList($shipInfo['consignee_data']['c_country']);
			$data['b_states'] = $this->customer_model->getStateList($shipInfo['bill_to_data']['b_country']);
			
            $this->global['pageTitle'] = 'JustShipIt : Edit Domestic Shipment';

            $this->loadViews("shipment/editDomesticShipment", $this->global, $data, NULL);
        }
    }
	
	function saveNewDomesticShipment(){
		if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
			$this->load->library('form_validation');
            
			$aVals = $this->input->post();
			
			$this->form_validation->set_rules('shipper_data[org_s_shipper_id]','Shipper ID','trim|required');
			$this->form_validation->set_rules('shipper_data[shipper_name]','Shipper Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('shipper_data[s_address_1]',' Shipper Address','trim|required|max_length[300]');
            $this->form_validation->set_rules('shipper_data[s_city]','Shipper City','trim|required|max_length[128]');
           // $this->form_validation->set_rules('shipper_data[s_email]','Shipper Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('shipper_data[s_country]','Shipper Country','trim|required|numeric');
			
			$this->form_validation->set_rules('consignee_data[org_c_shipper_id]','Consignee ID','trim|required');
			$this->form_validation->set_rules('consignee_data[c_shipper_name]','Consignee Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('consignee_data[c_address_1]','Consignee Address','trim|required|max_length[300]');
            $this->form_validation->set_rules('consignee_data[c_city]','Consignee City','trim|required|max_length[128]');
            //$this->form_validation->set_rules('consignee_data[c_email]','Consignee Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('consignee_data[c_country]','Consignee Country','trim|required|numeric');
			
			$this->form_validation->set_rules('bill_to_data[org_b_shipper_id]','Billto ID','trim|required');
			$this->form_validation->set_rules('bill_to_data[b_shipper_name]','Billto Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('bill_to_data[b_address_1]','Billto Address','trim|required|max_length[300]');
            $this->form_validation->set_rules('bill_to_data[b_city]','Billto City','trim|required|max_length[128]');
            //$this->form_validation->set_rules('bill_to_data[b_email]','Billto Email','trim|required|valid_email|max_length[128]'); 
            $this->form_validation->set_rules('bill_to_data[b_country]','Billto Country','trim|required|numeric');
			
            $this->form_validation->set_rules('ready_date_time','Ready Date/Time','required');
            $this->form_validation->set_rules('close_date_time','Close Date/Time','required');
            $this->form_validation->set_rules('schedule_date_time','Schedule Date/Time','required');
            $this->form_validation->set_rules('station','Station','required');
            //$this->form_validation->set_rules('total_dim_factor','Total Dim Factor','required');
            $this->form_validation->set_rules('service_level','Service Level','trim|required|numeric');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addDomesticShipment();
            }
            else
            {
			
				$total_pieces = 0;
				if(!empty($aVals['freight']['pieces'])){
					foreach($aVals['freight']['pieces'] as $cnt){
						if(!empty($cnt)){
							$total_pieces = $total_pieces + $cnt;
						}
					}
				}
				
				$total_dim_weight = 0;
				if(!empty($aVals['freight']['length'])){
					foreach($aVals['freight']['length'] as $key => $cnt){
						if(!empty($cnt)){
							$apieces = $aVals['freight']['pieces'][$key];
							$alength = $aVals['freight']['length'][$key];
							$awidth = $aVals['freight']['width'][$key];
							$aheight = $aVals['freight']['height'][$key];
							$dim_factor = $aVals['freight']['dim_factor'][$key];
							if(empty($dim_factor)){
								$dim_factor = 194;
							}
							$totdimweight = ((int)($apieces*$alength*$awidth*$aheight) / $dim_factor);
							$totdimweight = round($totdimweight, 2);
							$total_dim_weight = $total_dim_weight + $totdimweight;
						}
					}
				}
				
				$total_weight = 0;
				if(!empty($aVals['freight']['weight'])){
					foreach($aVals['freight']['weight'] as $cnt){
						if(!empty($cnt)){
							$total_weight = $total_weight + $cnt;
						}
					}
				}
				
				if($total_dim_weight > $total_weight){
					$totalchargeableweight = $total_dim_weight;
				}else{
					$totalchargeableweight = $total_weight;
				}
				
				$afrDatas = array();
				if(!empty($aVals['freight']['pieces'])){
					foreach($aVals['freight']['pieces'] as $key => $cnt){
						if(!empty($cnt)){
							$afrDatas[$key]['pieces'] = $cnt;
							$afrDatas[$key]['types'] = ($aVals['freight']['types'][$key] ? $aVals['freight']['types'][$key] : '');
							$afrDatas[$key]['haz'] = (isset($aVals['freight']['haz'][$key]) ? $aVals['freight']['haz'][$key] : 0);
							$afrDatas[$key]['description'] = ($aVals['freight']['description'][$key] ? $aVals['freight']['description'][$key] : '');
							$afrDatas[$key]['weight'] = ($aVals['freight']['weight'][$key] ? $aVals['freight']['weight'][$key] : '');
							$afrDatas[$key]['length'] = ($aVals['freight']['length'][$key] ? $aVals['freight']['length'][$key] : '');
							$afrDatas[$key]['width'] = ($aVals['freight']['width'][$key] ? $aVals['freight']['width'][$key] : '');
							$afrDatas[$key]['height'] = ($aVals['freight']['height'][$key] ? $aVals['freight']['height'][$key] : '');
							$afrDatas[$key]['class_id'] = ($aVals['freight']['class_id'][$key] ? $aVals['freight']['class_id'][$key] : '');
							$afrDatas[$key]['dim_factor'] = ($aVals['freight']['dim_factor'][$key] ? $aVals['freight']['dim_factor'][$key] : 194);
							
							if(!$afrDatas[$key]['length']){$afrDatas[$key]['length'] = 0;}
							if(!$afrDatas[$key]['width']){$afrDatas[$key]['width'] = 0;}
							if(!$afrDatas[$key]['height']){$afrDatas[$key]['height'] = 0;}
							if(!$afrDatas[$key]['dim_factor']){$afrDatas[$key]['dim_factor'] = 0;}
							if(!$afrDatas[$key]['pieces']){$afrDatas[$key]['pieces'] = 0;}
							
							$totdimweight = ((int)($afrDatas[$key]['pieces']*$afrDatas[$key]['length']*$afrDatas[$key]['width']*$afrDatas[$key]['height']) / $afrDatas[$key]['dim_factor']);
							$totdimweight = round($totdimweight, 2);
														
							$afrDatas[$key]['t_dim_weight'] = $totdimweight;
						}
					}
				}
				$afrDatas = json_encode($afrDatas);
				
				$spchk_datas = array();
				if(isset($aVals['spchk']) && !empty($aVals['spchk'])){
					$spchk_datas = $aVals['spchk'];
				}
				
				$spins_datas = array();
				if(isset($aVals['spdatas']) && !empty($aVals['spdatas'])){
					$spins_datas = $aVals['spdatas'];
				}
				
                $shipInfo = array(
					'org_s_shipper_id'=> $aVals['shipper_data']['org_s_shipper_id'], 
					'org_c_shipper_id'=> $aVals['consignee_data']['org_c_shipper_id'], 
					'org_b_shipper_id'=> $aVals['bill_to_data']['org_b_shipper_id'], 
					'shipper_data'=> json_encode($aVals['shipper_data']), 
					'consignee_data'=> json_encode($aVals['consignee_data']), 
					'bill_to_data'=> json_encode($aVals['bill_to_data']), 
					
					'ready_date_time'=>($aVals['ready_date_time'] ? date('Y-m-d H:i:s',strtotime($aVals['ready_date_time'])) : null), 
					'close_date_time'=>($aVals['close_date_time'] ? date('Y-m-d H:i:s',strtotime($aVals['close_date_time'])): null), 
					'service_level'=>$aVals['service_level'], 
					'schedule_date_time'=> ($aVals['schedule_date_time'] ? date('Y-m-d H:i:s',strtotime($aVals['schedule_date_time'])): null), 
					'schedule_between_time'=> ($aVals['schedule_between_time'] ? date('H:i:s',strtotime($aVals['schedule_between_time'])): null), 
					'status_time'=>($aVals['status_time'] ? date('Y-m-d H:i:s',strtotime($aVals['status_time'])): null), 
					
					'order_status'=>$aVals['order_status'], 
					'station'=>$aVals['station'], 
					'waybill'=>$aVals['waybill'],
					'sales_person'=>$aVals['sales_person'],
					'emergency_contact'=>$aVals['emergency_contact'],
					'account_manager'=>$aVals['account_manager'],
					'origin_airport_id'=>$aVals['origin_airport_id'],
					'dest_airport_id'=>$aVals['dest_airport_id'],
					'cod_value'=>$aVals['cod_value'],
					'insured_value'=>$aVals['insured_value'],
					'call_in_company'=>$aVals['call_in_company'],
					'call_in_name'=>$aVals['call_in_name'],
					'call_in_phone'=>$aVals['call_in_phone'],
					'ext'=>$aVals['ext'],
					'call_in_email'=>$aVals['call_in_email'],
					//'total_dim_factor'=>$aVals['total_dim_factor'],
					
					'schedule_by'=>(isset($aVals['schedule_by']) ? $aVals['schedule_by'] : 0),
					'special_delivery'=>(isset($aVals['special_delivery']) ? $aVals['special_delivery'] : 0),
					'auto_assign'=>(isset($aVals['auto_assign']) ? $aVals['auto_assign'] : 0),
					'fccod'=>(isset($aVals['fccod']) ? $aVals['fccod'] : 0),
					'dangerous_goods'=>(isset($aVals['dangerous_goods']) ? $aVals['dangerous_goods'] : 0),
					'dim_factor_override'=>(isset($aVals['dim_factor_override']) ? $aVals['dim_factor_override'] : 0),
					'bill_to'=>(isset($aVals['bill_to']) ? $aVals['bill_to'] : 0),

					'freight_datas' => $afrDatas,
					
					'total_pieces' => $total_pieces,
					'total_actual_weight' => $total_weight,
					'total_dim_weight' => $total_dim_weight,
					'total_chargeable_weight' => $totalchargeableweight,
					
					'createdBy'=>$this->vendorId,
					'createdDtm'=>date('Y-m-d H:i:s'),
					
					'spchk_datas'=>json_encode($spchk_datas), 
					'sp_ins_datas'=>json_encode($spins_datas), 
				);
               
                $this->load->model('shipment_model');
                $result = $this->shipment_model->saveNewDomesticShipping($shipInfo);
                
                if($result > 0)
                {
					
					$userUpdateInfo = array(
						'file_number' => 'F'.str_pad($result, 6, '0', STR_PAD_LEFT)
					);
					
					$this->shipment_model->updateDomesticShipping($userUpdateInfo, $result);

					
					if(isset($aVals['order_status']) && !empty($aVals['order_status'])){
					
						$trackInfo = array(
							'shipping_id'=>$result,
							'current_status'=>$aVals['order_status'],
							'event_date'=>($aVals['status_time'] ? date('Y-m-d',strtotime($aVals['status_time'])): null),
							'event_time'=>($aVals['status_time'] ? date('H:i:s',strtotime($aVals['status_time'])): null),
							'freight_city'=>(isset($aVals['shipper_data']['s_city']) ? $aVals['shipper_data']['s_city'] : null),
							'freight_state'=>(isset($aVals['shipper_data']['s_state']) ? $aVals['shipper_data']['s_state'] : null),
							'pod_date'=> null,
							'pod_time'=>null,
							'pod_name'=>null,
							'pod_delivered'=>0,
							't_comments'=>'',
						);
						
						$this->shipment_model->updateTrackInfo($trackInfo, $trackInfo, $result); 
						
					}
				
				
                    $this->session->set_flashdata('success', 'New Shipment created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Shipment creation failed');
                }
                
                
				redirect('editDomesticShipment/'.$result);
            }
        }
	
	}
	
	
	function updateDomesticShipment()
    {  
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            
            $shipment_id = $this->input->post('shipment_id');
            
            $this->load->library('form_validation');
            
			$aVals = $this->input->post();
			
			$this->form_validation->set_rules('shipper_data[org_s_shipper_id]','Shipper ID','trim|required');
			$this->form_validation->set_rules('shipper_data[shipper_name]','Shipper Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('shipper_data[s_address_1]',' Shipper Address','trim|required|max_length[300]');
            $this->form_validation->set_rules('shipper_data[s_city]','Shipper City','trim|required|max_length[128]');
           // $this->form_validation->set_rules('shipper_data[s_email]','Shipper Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('shipper_data[s_country]','Shipper Country','trim|required|numeric');
			
			$this->form_validation->set_rules('consignee_data[org_c_shipper_id]','Consignee ID','trim|required');
			$this->form_validation->set_rules('consignee_data[c_shipper_name]','Consignee Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('consignee_data[c_address_1]','Consignee Address','trim|required|max_length[300]');
            $this->form_validation->set_rules('consignee_data[c_city]','Consignee City','trim|required|max_length[128]');
            //$this->form_validation->set_rules('consignee_data[c_email]','Consignee Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('consignee_data[c_country]','Consignee Country','trim|required|numeric');
			
			$this->form_validation->set_rules('bill_to_data[org_b_shipper_id]','Billto ID','trim|required');
			$this->form_validation->set_rules('bill_to_data[b_shipper_name]','Billto Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('bill_to_data[b_address_1]','Billto Address','trim|required|max_length[300]');
            $this->form_validation->set_rules('bill_to_data[b_city]','Billto City','trim|required|max_length[128]');
            //$this->form_validation->set_rules('bill_to_data[b_email]','Billto Email','trim|required|valid_email|max_length[128]'); 
            $this->form_validation->set_rules('bill_to_data[b_country]','Billto Country','trim|required|numeric');
			
            $this->form_validation->set_rules('ready_date_time','Ready Date/Time','required');
            $this->form_validation->set_rules('close_date_time','Close Date/Time','required');
            $this->form_validation->set_rules('schedule_date_time','Schedule Date/Time','required');
            $this->form_validation->set_rules('station','Station','required');
            //$this->form_validation->set_rules('total_dim_factor','Total Dim Factor','required');
            $this->form_validation->set_rules('service_level','Service Level','trim|required|numeric');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editDomesticShipment($shipment_id);
            }
            else
            {
				$shipInfo = $this->shipment_model->getDomesticBaseInfo($shipment_id);
				
				$orderstatus = $aVals['order_status'];
				$statustime = ($aVals['status_time'] ? date('Y-m-d H:i:s',strtotime($aVals['status_time'])): null);
				if($shipInfo['order_status'] != $aVals['track']['current_status'] && !empty($aVals['track']['current_status'])){
					$orderstatus = $aVals['track']['current_status'];
					$atime = ($aVals['track']['event_time'] ? date('H:i:s',strtotime($aVals['track']['event_time'])): null);
					$statustime = ($aVals['track']['event_date'] ? date('Y-m-d',strtotime($aVals['track']['event_date'])).' '.$atime : null);
				}
				$aVals['track']['current_status'] = $orderstatus;
				$aVals['track']['freight_city'] = $aVals['shipper_data']['s_city'];
				$aVals['track']['freight_state'] = $aVals['shipper_data']['s_state'];
				
                $total_pieces = 0;
				if(!empty($aVals['freight']['pieces'])){
					foreach($aVals['freight']['pieces'] as $cnt){
						if(!empty($cnt)){
							$total_pieces = $total_pieces + $cnt;
						}
					}
				}
				
				$total_dim_weight = 0;
				if(!empty($aVals['freight']['length'])){
					foreach($aVals['freight']['length'] as $key => $cnt){
						if(!empty($cnt)){
							$apieces = $aVals['freight']['pieces'][$key];
							$alength = $aVals['freight']['length'][$key];
							$awidth = $aVals['freight']['width'][$key];
							$aheight = $aVals['freight']['height'][$key];
							$dim_factor = $aVals['freight']['dim_factor'][$key];
							if(empty($dim_factor)){
								$dim_factor = 194;
							}
							$totdimweight = ((int)($apieces*$alength*$awidth*$aheight) / $dim_factor);
							$totdimweight = round($totdimweight, 2);
							$total_dim_weight = $total_dim_weight + $totdimweight;
						}
					}
				}
				
				$total_weight = 0;
				if(!empty($aVals['freight']['weight'])){
					foreach($aVals['freight']['weight'] as $cnt){
						if(!empty($cnt)){
							$total_weight = $total_weight + $cnt;
						}
					}
				}
				
				if($total_dim_weight > $total_weight){
					$totalchargeableweight = $total_dim_weight;
				}else{
					$totalchargeableweight = $total_weight;
				}
				$afrDatas = array();
				if(!empty($aVals['freight']['pieces'])){
					foreach($aVals['freight']['pieces'] as $key => $cnt){
						
						
						$afrDatas[$key]['pieces'] = $cnt;
						$afrDatas[$key]['types'] = ($aVals['freight']['types'][$key] ? $aVals['freight']['types'][$key] : '');
						$afrDatas[$key]['haz'] = (isset($aVals['freight']['haz'][$key]) ? $aVals['freight']['haz'][$key] : 0);
						$afrDatas[$key]['description'] = ($aVals['freight']['description'][$key] ? $aVals['freight']['description'][$key] : '');
						$afrDatas[$key]['weight'] = ($aVals['freight']['weight'][$key] ? $aVals['freight']['weight'][$key] : '');
						$afrDatas[$key]['length'] = ($aVals['freight']['length'][$key] ? $aVals['freight']['length'][$key] : '');
						$afrDatas[$key]['width'] = ($aVals['freight']['width'][$key] ? $aVals['freight']['width'][$key] : '');
						$afrDatas[$key]['height'] = ($aVals['freight']['height'][$key] ? $aVals['freight']['height'][$key] : '');
						
						$afrDatas[$key]['dim_factor'] = ($aVals['freight']['dim_factor'][$key] ? $aVals['freight']['dim_factor'][$key] : 194);
						
						if(!$afrDatas[$key]['length']){$afrDatas[$key]['length'] = 0;}
						if(!$afrDatas[$key]['width']){$afrDatas[$key]['width'] = 0;}
						if(!$afrDatas[$key]['height']){$afrDatas[$key]['height'] = 0;}
						if(!$afrDatas[$key]['dim_factor']){$afrDatas[$key]['dim_factor'] = 0;}
						if(!$afrDatas[$key]['pieces']){$afrDatas[$key]['pieces'] = 0;}
						
						$totdimweight = ((int)($afrDatas[$key]['pieces']*$afrDatas[$key]['length']*$afrDatas[$key]['width']*$afrDatas[$key]['height']) / $afrDatas[$key]['dim_factor']);
						$totdimweight = round($totdimweight, 2);
						
						$afrDatas[$key]['t_dim_weight'] = $totdimweight;
						
						$afrDatas[$key]['class_id'] = ($aVals['freight']['class_id'][$key] ? $aVals['freight']['class_id'][$key] : '');
					}
				}
				$afrDatas = json_encode($afrDatas);
				
				$spchk_datas = array();
				if(isset($aVals['spchk']) && !empty($aVals['spchk'])){
					$spchk_datas = $aVals['spchk'];
				}
				
				$spins_datas = array();
				if(isset($aVals['spdatas']) && !empty($aVals['spdatas'])){
					$spins_datas = $aVals['spdatas'];
				}
				
                $shipInfo = array(
					'org_s_shipper_id'=> $aVals['shipper_data']['org_s_shipper_id'], 
					'org_c_shipper_id'=> $aVals['consignee_data']['org_c_shipper_id'], 
					'org_b_shipper_id'=> $aVals['bill_to_data']['org_b_shipper_id'], 
					'shipper_data'=> json_encode($aVals['shipper_data']), 
					'consignee_data'=> json_encode($aVals['consignee_data']), 
					'bill_to_data'=> json_encode($aVals['bill_to_data']), 
					
					'ready_date_time'=>($aVals['ready_date_time'] ? date('Y-m-d H:i:s',strtotime($aVals['ready_date_time'])) : null), 
					'close_date_time'=>($aVals['close_date_time'] ? date('Y-m-d H:i:s',strtotime($aVals['close_date_time'])): null), 
					'service_level'=>$aVals['service_level'], 
					'schedule_date_time'=> ($aVals['schedule_date_time'] ? date('Y-m-d H:i:s',strtotime($aVals['schedule_date_time'])): null), 
					'schedule_between_time'=> ($aVals['schedule_between_time'] ? date('H:i:s',strtotime($aVals['schedule_between_time'])): null), 
					
					'status_time'=>$statustime, 
					'order_status'=>$orderstatus,
					
					'station'=>$aVals['station'], 
					'waybill'=>$aVals['waybill'],
					'sales_person'=>$aVals['sales_person'],
					'emergency_contact'=>$aVals['emergency_contact'],
					'account_manager'=>$aVals['account_manager'],
					'origin_airport_id'=>$aVals['origin_airport_id'],
					'dest_airport_id'=>$aVals['dest_airport_id'],
					'cod_value'=>$aVals['cod_value'],
					'insured_value'=>$aVals['insured_value'],
					'call_in_company'=>$aVals['call_in_company'],
					'call_in_name'=>$aVals['call_in_name'],
					'call_in_phone'=>$aVals['call_in_phone'],
					'ext'=>$aVals['ext'],
					'call_in_email'=>$aVals['call_in_email'],
					//'total_dim_factor'=>$aVals['total_dim_factor'],
					
					'schedule_by'=>(isset($aVals['schedule_by']) ? $aVals['schedule_by'] : 0),
					'special_delivery'=>(isset($aVals['special_delivery']) ? $aVals['special_delivery'] : 0),
					'auto_assign'=>(isset($aVals['auto_assign']) ? $aVals['auto_assign'] : 0),
					'fccod'=>(isset($aVals['fccod']) ? $aVals['fccod'] : 0),
					'dangerous_goods'=>(isset($aVals['dangerous_goods']) ? $aVals['dangerous_goods'] : 0),
					'dim_factor_override'=>(isset($aVals['dim_factor_override']) ? $aVals['dim_factor_override'] : 0),
					'bill_to'=>(isset($aVals['bill_to']) ? $aVals['bill_to'] : 0),

					'freight_datas' => $afrDatas,
					'total_pieces' => $total_pieces,
					'total_actual_weight' => $total_weight,
					'total_dim_weight' => $total_dim_weight,
					'total_chargeable_weight' => $totalchargeableweight,
					
					'updatedBy'=>$this->vendorId, 
                    'updatedDtm'=>date('Y-m-d H:i:s'),
					
					'spchk_datas'=>json_encode($spchk_datas), 
					'sp_ins_datas'=>json_encode($spins_datas),
					'is_ready_invoicing'=>(isset($aVals['is_ready_invoicing']) ? $aVals['is_ready_invoicing'] : 0),
					'is_invoice_printed'=>(isset($aVals['is_invoice_printed']) ? $aVals['is_invoice_printed'] : 0),
					'is_finalize'=>(isset($aVals['is_finalize']) ? $aVals['is_finalize'] : 0),
					'is_qp_upload'=>(isset($aVals['is_qp_upload']) ? $aVals['is_qp_upload'] : 0),
				);
                
                $result = $this->shipment_model->updateDomesticShipment($shipInfo, $shipment_id);
                
				if(isset($aVals['track']) && !empty($aVals['track'])){
					$trVals = $aVals['track'];
					
					if(isset($orderstatus) && !empty($orderstatus)){
					
						$trackInfo = array(
							'shipping_id'=>$shipment_id,
							'current_status'=>$orderstatus,
							'event_date'=>(isset($statustime) ?  date('Y-m-d',strtotime($statustime)) : null),
							'event_time'=>(isset($statustime) ? date('H:i:s',strtotime($statustime)) : null),
							'freight_city'=>(isset($trVals['freight_city']) ? $trVals['freight_city'] : null),
							'freight_state'=>(isset($trVals['freight_state']) ? $trVals['freight_state'] : null),
							'pod_date'=>((isset($trVals['pod_date']) && !empty($trVals['pod_date'])) ? date('Y-m-d',strtotime($trVals['pod_date'])) : null),
							'pod_time'=>((isset($trVals['pod_time']) && !empty($trVals['pod_date'])) ? $trVals['pod_time'] : null),
							'pod_name'=>(isset($trVals['pod_name']) ? $trVals['pod_name'] : null),
							'pod_delivered'=>(isset($trVals['pod_delivered']) ? $trVals['pod_delivered'] : 0),
							't_comments'=>(isset($trVals['t_comments']) ? $trVals['t_comments'] : ''),
						);
						
						$this->shipment_model->updateTrackInfo($trackInfo, $trVals, $shipment_id); 
						
					}
				}
				
				//$aResponse = $this->shipment_model->updateExtraCosttoQuickbook($shipment_id);
				if(isset($aVals['is_qp_upload']) && $aVals['is_qp_upload'] == 1){
					$this->qbdesktop_model->enqueue(QUICKBOOKS_ADD_INVOICE, $shipment_id);
					
					$this->shipment_model->updateDomesticShipment(array('is_qp_upload' => 2), $shipment_id);
				}
								
				$quickerror = '';
				/* if($aResponse['response_status'] == 'error'){
					$quickerror = ' Quickbook connection failed! ERROR :'.$aResponse['response_message'];
				} */
					
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Shipment updated successfully'.$quickerror);
                }
                else
                {
                    $this->session->set_flashdata('error', 'Shipment updation failed'.$quickerror);
                }
                
				redirect('editDomesticShipment/'.$shipment_id);
            }
        }

    }
	
	function inernationalShipment()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {        
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $searchCode = $this->security->xss_clean($this->input->post('searchCode'));
			
            $data['searchText'] = $searchText;
            $data['searchCode'] = $searchCode;
            
            $this->load->library('pagination');
            
            $count = $this->shipment_model->internationalShipmentListingCount($data);

			$returns = $this->paginationCompress ( "inernationalShipment/", $count, 10 );
            
            $data['domesticRecords'] = $this->shipment_model->internationalShipmentListing($data, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'JustShipIt : International Shipments';
            
            $this->loadViews("shipment/international", $this->global, $data, NULL);
        }
    }
	
	function getwaybillno(){
		$shipmentid = $this->input->post("shipmentid");
		$waybillno = $this->shipment_model->getwaybillno($shipmentid);
		echo json_encode($waybillno); 
	}
	
    function checkairportCode(){
		// POST data
		$postData = $this->input->post();

		// Get data
		$datas = $this->shipment_model->checkairportCode($postData);

		echo json_encode($datas);
	} 
	
	
	public function loadChargeCode(){
		// POST data
		$postData = $this->input->post();
            
		$data['popup_title'] = 'Charge Codes';
			
		$data['aRecords'] = $this->shipment_model->loadChargeCode($postData);
		
		$data['postData'] = $postData;
		
		$this->load->view("shipment/loadChargeCode", $data);		

	} 
	
	public function loadExtraChargeCode(){
		// POST data
		$postData = $this->input->post();
            
		$data['popup_title'] = 'Charge Codes';
			
		$data['aRecords'] = $this->shipment_model->loadChargeCode($postData);
		
		$data['postData'] = $postData;
		
		$this->load->view("shipment/loadExtraChargeCode", $data);		

	} 
	
	public function loadVendorType(){
		// POST data
		$postData = $this->input->post();
            
		$data['popup_title'] = 'Vendor Types';
		
		$shipInfo = $this->shipment_model->getDomesticInfo($postData['shipment_id']);
		$data['shipData'] = $shipInfo;
		
		$data['aRecords'] = $this->shipment_model->loadVendorType($postData);
		
		$data['postData'] = $postData;
		
		$data['rate_basis'] = $this->shipment_model->getRateBasis(); 
	
		$this->load->view("shipment/loadVendorType", $data);		

	} 
	
	public function loadTransferAlert(){
		// POST data
		$postData = $this->input->post();
            
		$data['popup_title'] = 'Transfer Alert';
		
		$shipInfo = $this->shipment_model->getDomesticInfo($postData['shipment_id']);
		
		$aRecords = $this->shipment_model->loadTransferAlert($postData['shipment_id']);
		$data['aRecords'] = $aRecords;		
		
		$data['shipInfo'] = $shipInfo;
		
		$data['postData'] = $postData;
		
		$data['rate_basis'] = $this->shipment_model->getRateBasis(); 
		$data['countries'] = $this->customer_model->getCountries();
        $data['states'] =array();
		
		if(!empty($aRecords)){
			$data['t_states'] = $this->customer_model->getStateList($aRecords['t_data']['t_country']);
			$data['r_states'] = $this->customer_model->getStateList($aRecords['r_data']['r_country']);
		}
		$this->load->view("shipment/loadTransferAlert", $data);		

	} 
	
	public function loadRoutingAlert(){
		// POST data
		$postData = $this->input->post();
            
		$data['popup_title'] = 'Routing Alert';
		
		$shipInfo = $this->shipment_model->getDomesticInfo($postData['shipment_id']);
		
		$aRecords = $this->shipment_model->loadRoutingAlert($postData['shipment_id']);

		$data['aRecords'] = $aRecords;		
		
		$data['shipInfo'] = $shipInfo;
		
		$data['postData'] = $postData;
		
		$data['rate_basis'] = $this->shipment_model->getRateBasis(); 
		$data['countries'] = $this->customer_model->getCountries();
        $data['states'] =array();
		
		
		
		
		$data['aVenRecords'] = $this->shipment_model->loadSelectedVendors($postData['shipment_id']);
		
		$neededVendorData['v_airline'] = $neededVendorData['agent_account_no'] = $neededVendorData['v_cut_off_time'] = $neededVendorData['v_mawb'] = $neededVendorData['p_total_cost'] = $neededVendorData['v_origin_id'] = $neededVendorData['origin_airport_code'] = $neededVendorData['dest_airport_code'] = $neededVendorData['v_destination_id'] = $neededVendorData['v_account'] = '';
		$showAirline = false;
		
		$deliveryVenData['vendor_id'] =$deliveryVenData['name'] = $deliveryVenData['address_1'] = $deliveryVenData['address_2']= $deliveryVenData['city']= $deliveryVenData['state_name']= $deliveryVenData['zip']= $deliveryVenData['country_name']=$deliveryVenData['phone']= $deliveryVenData['contact'] =$deliveryVenData['c_country'] =$deliveryVenData['c_state'] = '';
		
		if(!empty($data['aVenRecords'])){
			foreach($data['aVenRecords'] as $venrecord){

				if($venrecord->p_v_type_id == 6){
					$neededVendorData['v_airline'] = $venrecord->v_airline;
					$neededVendorData['v_mawb'] = $venrecord->v_mawb;
					$neededVendorData['v_cut_off_time'] = $venrecord->v_cut_off_time;
					$neededVendorData['v_account'] = $venrecord->v_account;
					$neededVendorData['p_total_cost'] = $venrecord->p_total_cost;
					$neededVendorData['v_origin_id'] = $venrecord->v_origin_id;
					$neededVendorData['origin_airport_code'] = $venrecord->origin_airport_code;
					$neededVendorData['dest_airport_code'] = $venrecord->dest_airport_code;
					$neededVendorData['v_destination_id'] = $venrecord->v_destination_id;
					$neededVendorData['vendor_airline_datas'] = (array) json_decode($venrecord->vendor_airline_datas);
					
					$showAirline = true;
				}
				
				if($venrecord->p_v_type_id == 7 && !$showAirline){
					$neededVendorData['v_airline'] = $venrecord->v_airline;
					$neededVendorData['v_mawb'] = $venrecord->v_mawb;
					$neededVendorData['v_cut_off_time'] = $venrecord->v_cut_off_time;
					$neededVendorData['v_account'] = $venrecord->v_account;
					$neededVendorData['p_total_cost'] = $venrecord->p_total_cost;
					$neededVendorData['v_origin_id'] = $venrecord->v_origin_id;
					$neededVendorData['origin_airport_code'] = $venrecord->origin_airport_code;
					$neededVendorData['dest_airport_code'] = $venrecord->dest_airport_code;
					$neededVendorData['v_destination_id'] = $venrecord->v_destination_id;
					$neededVendorData['vendor_airline_datas'] = array();
				}
				
				if($venrecord->p_v_type_id == 8){
										
					$delVenData = (array) $this->Customer_model->getCustomerInfo($venrecord->p_vendor_id);
					
					$deliveryVenData['vendor_id'] = $delVenData['customer_id'];
					$deliveryVenData['name'] = $delVenData['customer_name'];
					$deliveryVenData['address_1'] = $delVenData['c_address_1'];
					$deliveryVenData['address_2'] = $delVenData['c_address_2'];
					$deliveryVenData['address_2'] = $delVenData['c_address_2'];
					$deliveryVenData['city'] = $delVenData['c_city'];
					$deliveryVenData['zip'] = $delVenData['c_zip'];
					$deliveryVenData['phone'] = $delVenData['c_phone'];
					$deliveryVenData['contact'] = $delVenData['c_contact'];
					$deliveryVenData['c_country'] = $delVenData['c_country'];
					$deliveryVenData['c_state'] = $delVenData['c_state'];
					$deliveryVenData['state_name'] = $this->shipment_model->getStateName($delVenData['c_state']);
					$deliveryVenData['country_name'] = $this->shipment_model->getCountryName($delVenData['c_country']);
					
				}
			}
		}
		$data['showAirline'] = $showAirline;
		$data['neededVendorData'] = $neededVendorData;
		$data['deliveryVenData'] = $deliveryVenData;
		
		$data['r_states'] = $this->customer_model->getStateList((isset($aRecords['r_f_data']['r_country']) ? $aRecords['r_f_data']['r_country'] : 2));
		$data['t_states'] = $this->customer_model->getStateList((isset($aRecords['t_f_data']['c_country']) ? $aRecords['t_f_data']['c_country'] : $deliveryVenData['c_country']));
		
		$this->load->view("shipment/loadRoutingAlert", $data);		

	} 
	
	public function editVendorType(){
		// POST data
		$postData = $this->input->post();
            
		$data['popup_title'] = 'Edit Vendor';
				
		$aVendorData = $this->shipment_model->getDomesticVendorbyId($postData['dom_id']);
		
		$shipInfo = $this->shipment_model->getDomesticInfo($aVendorData['shipment_id']);
		
		$data['aVendorData'] = $aVendorData;
		
		$data['shipData'] = $shipInfo;
		
		$data['aRecords'] = $this->shipment_model->loadVendorType($postData);
		
		$data['postData'] = $postData;
		
		$data['servicelevels'] = $this->shipment_model->getAirlineServicelevels();
		
		$data['rate_basis'] = $this->shipment_model->getRateBasis(); 
	
		$this->load->view("shipment/editVendorType", $data);		

	} 
	
	public function addVendorShipment(){
		// POST data
		$postData = $this->input->post();
        $aVals = $postData['vendor_data'];
		$shipInfo = $this->shipment_model->getDomesticInfo($aVals['shipment_id']);
	
		if($shipInfo){
				$this->load->library('form_validation');
				$this->form_validation->set_rules('vendor_data[p_v_type_id]', 'Vendor Type', 'trim|required');
				$this->form_validation->set_rules('vendor_data[p_vendor_id]', 'Vendor', 'trim|required');
				
				
				if ($this->form_validation->run() == false) {
					$response = array(
						'status' => 'error',
						'message' => validation_errors()
					);
				}
				else {
					
					$this->shipment_model->checkandInsertVendor($postData); 

					$response = array(
						'status' => 'success',
						'message' => "<h3 class='m-0'>Vendor added successfully.</h3>"
					);
				}

				$this->output
					->set_content_type('application/json')
					->set_output(json_encode($response));
					
		}else{
			$response = array(
				'status' => 'error',
				'message' => "Something went wrong! please try again later!"
			);
			$this->output
					->set_content_type('application/json')
					->set_output(json_encode($response));
		}
		
			
		
	}
	
	public function savespecialInstructions(){
		// POST data
		$postData = $this->input->post();
        $aVals = $postData;
		$shipInfo = $this->shipment_model->getDomesticInfo($aVals['org_ship_id']);
	
		if($shipInfo){
				$this->load->library('form_validation');
				$this->form_validation->set_rules('org_ship_id', 'Shipper Id', 'required');				
				
				if ($this->form_validation->run() == false) {
					$response = array(
						'status' => 'error',
						'message' => validation_errors()
					);
				}
				else {
					
					$this->shipment_model->savespecialInstructions($postData); 

					$response = array(
						'status' => 'success',
						'message' => "<h3 class='m-0'>Special Instruction updated successfully.</h3>"
					);
				}

				$this->output
					->set_content_type('application/json')
					->set_output(json_encode($response));
					
		}else{
			$response = array(
				'status' => 'error',
				'message' => "Something went wrong! please try again later!"
			);
			$this->output
					->set_content_type('application/json')
					->set_output(json_encode($response));
		}
		
			
		
	}
	
	public function addTransferAlert(){
		// POST data
		$postData = $this->input->post();
		$shipInfo = $this->shipment_model->getDomesticInfo($postData['shipment_id']);
	
		if($shipInfo){
				$this->load->library('form_validation');
				$this->form_validation->set_rules('r_data[r_id]', 'Recover From Shipper', 'trim|required');
				$this->form_validation->set_rules('t_data[t_id]', 'Transfer To Consignee', 'trim|required');
								
				if ($this->form_validation->run() == false) {
					$response = array(
						'status' => 'error',
						'message' => validation_errors()
					);
				}
				else {
					
					$this->shipment_model->checkandInsertTrasferAlert($postData); 

					$response = array(
						'status' => 'success',
						'message' => "<h3 class='m-0'>Transfer Alert added successfully.</h3>"
					);
				}

				$this->output
					->set_content_type('application/json')
					->set_output(json_encode($response));
					
		}else{
			$response = array(
				'status' => 'error',
				'message' => "Something went wrong! please try again later!"
			);
			$this->output
					->set_content_type('application/json')
					->set_output(json_encode($response));
		}
		
			
		
	}
	
	public function addRoutingAlert(){
		// POST data
		$postData = $this->input->post();
		$shipInfo = $this->shipment_model->getDomesticInfo($postData['shipment_id']);
	
		if($shipInfo){
				$this->load->library('form_validation');
				$this->form_validation->set_rules('val[shipment_id]', 'ShipmentID', 'trim|required');
				$this->form_validation->set_rules('t_f_data[t_id]', 'Consignee', 'trim|required');
				$this->form_validation->set_rules('val[airbill_station]', 'Airbill Station', 'trim|required');
				$this->form_validation->set_rules('val[airbill_number]', 'Airbill Number', 'trim|required');
				$this->form_validation->set_rules('val[ro_origin_id]', 'Origin', 'trim|required');
				$this->form_validation->set_rules('val[ro_dest_id]', 'Destination', 'trim|required');
				
				if ($this->form_validation->run() == false) {
					$response = array(
						'status' => 'error',
						'message' => validation_errors()
					);
				}
				else {
					
					$this->shipment_model->checkandInsertRoutingAlert($postData); 

					$response = array(
						'status' => 'success',
						'message' => "<h3 class='m-0'>Routing Data added successfully.</h3>"
					);
				}

				$this->output
					->set_content_type('application/json')
					->set_output(json_encode($response));
					
		}else{
			$response = array(
				'status' => 'error',
				'message' => "Something went wrong! please try again later!"
			);
			$this->output
					->set_content_type('application/json')
					->set_output(json_encode($response));
		}
		
			
		
	}
	
	
	public function updateMAWBdatas(){
		if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
			$this->load->library('form_validation');
            
			$aVals = $this->input->post();
			
			$this->form_validation->set_rules('s_data[s_id]','Shipper ID','trim|required');
			$this->form_validation->set_rules('s_data[s_name]','Shipper Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('s_data[s_address_1]',' Shipper Address','trim|required|max_length[300]');
            $this->form_validation->set_rules('s_data[s_city]','Shipper City','trim|required|max_length[128]');
            $this->form_validation->set_rules('s_data[s_country]','Shipper Country','trim|required|numeric');
			
			$this->form_validation->set_rules('c_data[c_id]','Consignee ID','trim|required');
			$this->form_validation->set_rules('c_data[c_name]','Consignee Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('c_data[c_address_1]','Consignee Address','trim|required|max_length[300]');
            $this->form_validation->set_rules('c_data[c_city]','Consignee City','trim|required|max_length[128]');
            $this->form_validation->set_rules('c_data[c_country]','Consignee Country','trim|required|numeric');
			
			$this->form_validation->set_rules('a_data[a_name]','Agent Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('a_data[a_address_1]','Agent Address','trim|required|max_length[300]');
            $this->form_validation->set_rules('a_data[a_city]','Agent City','trim|required|max_length[128]');
            $this->form_validation->set_rules('a_data[a_country]','Agent Country','trim|required|numeric');
			
            if($this->form_validation->run() == FALSE)
            {
                $this->dommawb($aVals['val']['shipment_id']);
            }
            else
            {

				$afrDatas = array();
				if(!empty($aVals['fr_data']['fr_pieces'])){
					foreach($aVals['fr_data']['fr_pieces'] as $key => $cnt){
						if(!empty($cnt)){
							$afrDatas[$key]['fr_pieces'] = $cnt;
							$afrDatas[$key]['fr_weight'] = ($aVals['fr_data']['fr_weight'][$key] ? $aVals['fr_data']['fr_weight'][$key] : '');
							$afrDatas[$key]['lb_kg'] = ($aVals['fr_data']['lb_kg'][$key] ? $aVals['fr_data']['lb_kg'][$key] : '');
							$afrDatas[$key]['item_no'] = ($aVals['fr_data']['item_no'][$key] ? $aVals['fr_data']['item_no'][$key] : '');
							$afrDatas[$key]['chargeable_wt'] = ($aVals['fr_data']['chargeable_wt'][$key] ? $aVals['fr_data']['chargeable_wt'][$key] : '');
							$afrDatas[$key]['r_charge'] = ($aVals['fr_data']['r_charge'][$key] ? $aVals['fr_data']['r_charge'][$key] : '');
							$afrDatas[$key]['fr_total'] = ($aVals['fr_data']['fr_total'][$key] ? $aVals['fr_data']['fr_total'][$key] : '');
							$afrDatas[$key]['n_q_goods'] = ($aVals['fr_data']['n_q_goods'][$key] ? $aVals['fr_data']['n_q_goods'][$key] : '');
							
						}
					}
				}
				$afrDatas = json_encode($afrDatas);

                $amawbdata = array(
					'shipment_id'=> $aVals['val']['shipment_id'], 
					's_data'=> json_encode($aVals['s_data']), 
					'c_data'=> json_encode($aVals['c_data']), 
					'a_data'=> json_encode($aVals['a_data']), 
					'ap_data'=> json_encode($aVals['ap_data']), 
					'charge_data'=> json_encode($aVals['charge_data']), 
					'issued_by_name'=> (isset($aVals['val']['issued_by_name']) ? $aVals['val']['issued_by_name'] : ''),
					'issued_by_id'=> (isset($aVals['val']['issued_by_id']) ? $aVals['val']['issued_by_id'] : ''),
					'account_information'=> (isset($aVals['val']['account_information']) ? $aVals['val']['account_information'] : ''),
					'reference_number'=> (isset($aVals['val']['reference_number']) ? $aVals['val']['reference_number'] : ''),
					'opt_shipp_info'=> (isset($aVals['val']['opt_shipp_info']) ? $aVals['val']['opt_shipp_info'] : ''),
					'opt_sci_info'=> (isset($aVals['val']['opt_sci_info']) ? $aVals['val']['opt_sci_info'] : ''),
					'handling_info'=> (isset($aVals['val']['handling_info']) ? $aVals['val']['handling_info'] : ''),
					'itn'=> (isset($aVals['val']['itn']) ? $aVals['val']['itn'] : ''),
					'xtn'=> (isset($aVals['val']['xtn']) ? $aVals['val']['xtn'] : ''),
					'hawb_note'=> (isset($aVals['val']['hawb_note']) ? $aVals['val']['hawb_note'] : ''),					
					'fr_data' => $afrDatas,
					'generate_by' => $this->vendorId
				);
               
                $this->load->model('shipment_model');
                $result = $this->shipment_model->checkandInsertMAWBdatas($amawbdata);
                
                if($result > 0)
                {
					
                    $this->session->set_flashdata('success', 'MAWB Data added successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'MAWB Data creation failed');
                }
                
              
				redirect('dommawb/'.$amawbdata['shipment_id']);
            }
        }
		
			
		
	}
	
	function deleteDomesticShipment()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $shipment_id = $this->input->post('shipment_id');
            
            $result = $this->shipment_model->deleteDomesticShipment($shipment_id);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	function deleteTransferAlert()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $shipid = $this->input->post('shipid');
            
            $result = $this->shipment_model->deleteTransferAlert($shipid);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	function deleteRoutingAlert()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $shipid = $this->input->post('shipid');
            
            $result = $this->shipment_model->deleteRoutingAlert($shipid);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	public function addChargeCode(){
		// POST data
		$postData = $this->input->post();
        $aVals = $postData['charge_code'];
		$shipInfo = $this->shipment_model->getDomesticInfo($aVals['shipment_id']);
		
		if($shipInfo){				
				if(!empty($aVals['charge_code_id'])){
					$chargeCODEerror = $chargeQTYerror = $chargeRBerror = $chargeRateerror = false;
					foreach($aVals['charge_code_id'] as $key => $cnt){
						if(empty($cnt)){
							$chargeCODEerror = true;
						}
						if(empty($aVals['charge_code_qty'][$key])){
							$chargeQTYerror = true;
						}
						if(empty($aVals['charge_code_rate_basis'][$key])){
							//$chargeRBerror = true;
						}
						if(empty($aVals['charge_code_charge'][$key]) && empty($aVals['charge_code_rate'][$key]) && !empty($aVals['charge_code_qty'][$key])){
							$chargeRateerror = true;
						}
					}
					
					if($chargeCODEerror || $chargeQTYerror || $chargeRateerror){
						if($chargeCODEerror){
							$response = array(
								'status' => 'error',
								'message' => "Please enter Charge Code"
							);
							$this->output->set_content_type('application/json')->set_output(json_encode($response));
						}
						
						if($chargeQTYerror){
							$response = array(
								'status' => 'error',
								'message' => "Please enter Quantity"
							);
							$this->output->set_content_type('application/json')->set_output(json_encode($response));
						}
						
						if($chargeRateerror){
							$response = array(
								'status' => 'error',
								'message' => "Please enter rate"
							);
							$this->output->set_content_type('application/json')->set_output(json_encode($response));
						}
						return false;
					}
					
					foreach($aVals['charge_code_id'] as $key => $cnt){
						if(!empty($cnt) && !empty($aVals['charge_code_qty'][$key])){
						
							$afrDatas['shipment_id'] = $aVals['shipment_id'];
							$afrDatas['charge_code_id'] = $cnt;
							$afrDatas['charge_code_description'] = ($aVals['charge_code_description'][$key] ? $aVals['charge_code_description'][$key] : '');
							$afrDatas['charge_code_rate_basis'] = (isset($aVals['charge_code_rate_basis'][$key]) ? $aVals['charge_code_rate_basis'][$key] : '');
							$afrDatas['charge_code_qty'] = ($aVals['charge_code_qty'][$key] ? $aVals['charge_code_qty'][$key] : '');
							$afrDatas['charge_code_rate'] = ($aVals['charge_code_rate'][$key] ? $aVals['charge_code_rate'][$key] : '');
							$afrDatas['charge_code_charge'] = ($aVals['charge_code_charge'][$key] ? $aVals['charge_code_charge'][$key] : '');
							$afrDatas['charge_code_total_cost'] = ($aVals['charge_code_total_cost'][$key] ? $aVals['charge_code_total_cost'][$key] : '');
							
							
							$aid = $this->shipment_model->checkandInsertChargeCode($afrDatas); 

							if($aid){
								$response = array(
									'status' => 'success',
									'message' => "<h3 class='m-0'>Charge Code added successfully.</h3>"
								);
								
								$this->output->set_content_type('application/json')
											->set_output(json_encode($response));
							}
						}else{
							$response = array(
								'status' => 'error',
								'message' => "Something went wrong! please enter again later!"
							);
							$this->output->set_content_type('application/json')->set_output(json_encode($response));
						}
					}
				}else{
					$response = array(
						'status' => 'error',
						'message' => "Please add anyone charge code"
					);
					$this->output->set_content_type('application/json')->set_output(json_encode($response));
				}		
		}else{
			$response = array(
				'status' => 'error',
				'message' => "Something went wrong! please try again later!"
			);
			$this->output
					->set_content_type('application/json')
					->set_output(json_encode($response));
		}
		
			
		
	} 
	
	public function addExtraChargeCode(){
		// POST data
		$postData = $this->input->post();
        $aVals = $postData['extracharge_code'];
		$shipInfo = $this->shipment_model->getDomesticInfo($aVals['shipment_id']);
		
		if($shipInfo){				
				if(!empty($aVals['charge_code_id'])){
				
					$chargeCODEerror = $chargeQTYerror = $chargeRBerror = $chargeRateerror = false;
					foreach($aVals['charge_code_id'] as $key => $cnt){
						if(empty($cnt)){
							$chargeCODEerror = true;
						}
						if(empty($aVals['charge_code_qty'][$key])){
							$chargeQTYerror = true;
						}
						if(empty($aVals['charge_code_rate_basis'][$key])){
							//$chargeRBerror = true;
						}
						if(empty($aVals['charge_code_charge'][$key]) && empty($aVals['charge_code_rate'][$key]) && !empty($aVals['charge_code_qty'][$key])){
							$chargeRateerror = true;
						}
					}
					
					if($chargeCODEerror || $chargeQTYerror || $chargeRateerror){
						if($chargeCODEerror){
							$response = array(
								'status' => 'error',
								'message' => "Please enter Charge Code"
							);
							$this->output->set_content_type('application/json')->set_output(json_encode($response));
						}
						
						if($chargeQTYerror){
							$response = array(
								'status' => 'error',
								'message' => "Please enter Quantity"
							);
							$this->output->set_content_type('application/json')->set_output(json_encode($response));
						}
						
						if($chargeRateerror){
							$response = array(
								'status' => 'error',
								'message' => "Please enter rate"
							);
							$this->output->set_content_type('application/json')->set_output(json_encode($response));
						}
						return false;
					}
					
					foreach($aVals['charge_code_id'] as $key => $cnt){
						if(!empty($cnt) && !empty($aVals['charge_code_qty'][$key])){
						
							$afrDatas['shipment_id'] = $aVals['shipment_id'];
							$afrDatas['charge_code_id'] = $cnt;
							$afrDatas['charge_code_description'] = ($aVals['charge_code_description'][$key] ? $aVals['charge_code_description'][$key] : '');
							$afrDatas['charge_code_rate_basis'] = (isset($aVals['charge_code_rate_basis'][$key]) ? $aVals['charge_code_rate_basis'][$key] : '');
							$afrDatas['charge_code_qty'] = ($aVals['charge_code_qty'][$key] ? $aVals['charge_code_qty'][$key] : '');
							$afrDatas['charge_code_rate'] = ($aVals['charge_code_rate'][$key] ? $aVals['charge_code_rate'][$key] : '');
							$afrDatas['charge_code_charge'] = ($aVals['charge_code_charge'][$key] ? $aVals['charge_code_charge'][$key] : '');
							$afrDatas['charge_code_total_cost'] = ($aVals['charge_code_total_cost'][$key] ? $aVals['charge_code_total_cost'][$key] : '');
							
							
							$aid = $this->shipment_model->checkandInsertExtraChargeCode($afrDatas); 

							if($aid){
								$response = array(
									'status' => 'success',
									'message' => "<h3 class='m-0'>Extra Charge Code added successfully.</h3>"
								);
								
								$this->output->set_content_type('application/json')
											->set_output(json_encode($response));
							}
						}else{
							$response = array(
								'status' => 'error',
								'message' => "Something went wrong! please try again later!"
							);
							$this->output->set_content_type('application/json')->set_output(json_encode($response));
						}
					}
				}else{
					$response = array(
						'status' => 'error',
						'message' => "Please add anyone charge code"
					);
					$this->output->set_content_type('application/json')->set_output(json_encode($response));
				}		
		}else{
			$response = array(
				'status' => 'error',
				'message' => "Something went wrong! please try again later!"
			);
			$this->output
					->set_content_type('application/json')
					->set_output(json_encode($response));
		}
		
			
		
	} 
	
	public function loadVendors(){
		// POST data
		$postData = $this->input->post();

		$totalRec = $this->shipment_model->loadVendorsCount($postData);

				
		$data['popup_title'] = 'Vendors Datas';
		
		//pagination configuration
        $config['first_link']  = 'First';
        $config['target']      = '.vendor_div_ref'; //parent div tag id
        $config['base_url']    = base_url().'ajaxVendorData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['extraParam']  = $postData;
        
        $this->ajax_pagination->initialize($config);
		
		$data['aRecords'] = $this->shipment_model->loadVendors($postData, $offset=0, $this->perPage);
		$data['postData'] = $postData;
		
		$this->load->view("shipment/vendorspopup", $data);		
	}
	
	public function ajaxVendorData(){
	
		$postData = $this->input->post();
		
		$page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //total rows count
        $totalRec = $this->shipment_model->loadVendorsCount($postData);
        
        //pagination configuration
        $config['first_link']  = 'First';
        $config['target']      = '.vendor_div_ref'; //parent div tag id
        $config['base_url']    = base_url().'ajaxVendorData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['extraParam']  = $postData;
        
        $this->ajax_pagination->initialize($config);
        
		$data['aRecords'] = $this->shipment_model->loadVendors($postData, $offset, $this->perPage);
		$data['postData'] = $postData;
		
        //load the view
        $this->load->view('shipment/vendorAjax', $data);
	}
	
	public function loadExtraCharges(){
		// POST data
		$postData = $this->input->post();
		
		$data['popup_title'] = 'Extra Charges';
		
		
		$data['aRecords'] = $this->shipment_model->loadExtraCharges($postData);
		$data['rate_basis'] = $this->shipment_model->getRateBasis();
		$data['types'] = $this->shipment_model->getFrieghtTypes();			
		$data['postData'] = $postData;
		
		$this->load->view("shipment/loadextracharges", $data);		
	}
	
	public function loadAirports(){
		// POST data
		$postData = $this->input->post();
            
		$totalRec = $this->shipment_model->loadAirportsCount($postData);
		
		$data['popup_title'] = 'Airports';
		
		//pagination configuration
        $config['first_link']  = 'First';
        $config['target']      = '.airport_div_ref'; //parent div tag id
        $config['base_url']    = base_url().'ajaxAirportData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['extraParam']  = $postData;
        
        $this->ajax_pagination->initialize($config);
		
		
		$data['aRecords'] = $this->shipment_model->loadAirports($postData, $offset=0, $this->perPage);
		$data['postData'] = $postData;
		
		$this->load->view("shipment/airportpopup", $data);		
	}
	
	public function ajaxAirportData(){
	
		$postData = $this->input->post();
		
		$page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //total rows count
        $totalRec = $this->shipment_model->loadAirportsCount($postData);
        
        //pagination configuration
        $config['first_link']  = 'First';
        $config['target']      = '.airport_div_ref'; //parent div tag id
        $config['base_url']    = base_url().'ajaxAirportData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
		$config['extraParam']  = $postData;
        
        $this->ajax_pagination->initialize($config);
        
		$data['aRecords'] = $this->shipment_model->loadAirports($postData, $offset, $this->perPage);
		$data['postData'] = $postData;
		
        //load the view
        $this->load->view('shipment/airportAjax', $data);
	}
	
	public function airports(){
	
		if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {        
            $search = $this->security->xss_clean($this->input->post('search'));
            $data['search'] = $search;
            
            $this->load->library('pagination');
            
            $count = $this->shipment_model->loadAirportsCount($data);

			$returns = $this->paginationCompress ( "airports/", $count, 20 );
            
            $data['aRecords'] = $this->shipment_model->loadAirports($data, $returns["segment"], $returns["page"]);
           
            $this->global['pageTitle'] = 'JustShipIt : Airports';
            
            $this->loadViews("shipment/airports", $this->global, $data, NULL);
			
        }
		
					
	} 
	
	
	function deleteAirport()
    { 
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $airport_id = $this->input->post('airport_id');
           
            $result = $this->shipment_model->deleteAirport($airport_id);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	
	function shipquickbook(){
		$this->shipment_model->shipquickbook();
	}
	
	function addAirport()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('shipment_model');
            $data['countries'] = $this->customer_model->getCountries();
            $data['states'] =array();
			
            $this->global['pageTitle'] = 'JustShipIt : Add New Airport';

            $this->loadViews("shipment/addAirport", $this->global, $data, NULL);
        }
    }
	
	function saveAirport()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('airport_name','Airport Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('airport_code','Airport Code','trim|required|max_length[4]');
            $this->form_validation->set_rules('city','City','trim|required|max_length[128]');

            $this->form_validation->set_rules('com_country','Country','trim|required|numeric');
            $this->form_validation->set_rules('com_state','State','trim|required|numeric');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addAirport();
            }
            else
            {
                $airport_name = ucwords(strtolower($this->security->xss_clean($this->input->post('airport_name'))));
                $airport_code = strtoupper($this->security->xss_clean($this->input->post('airport_code')));
               
                $city = ucwords(strtolower($this->security->xss_clean($this->input->post('city'))));
                $com_state = $this->input->post('com_state');
                $com_country = $this->input->post('com_country');
                $com_state_name = $this->shipment_model->getStateName($com_state);
				
                $isCodeExist = $this->shipment_model->checkAirportCodeExist($airport_code);
				;
				if($isCodeExist){
					
					$this->session->set_flashdata('error', 'Airport Code Already Exist!');
					$this->addAirport();
					return false;
				}else{
					$aInfo = array(
						'airport_name'=> $airport_name, 
						'airport_code'=> $airport_code, 
						'city'=>$city, 
						'state'=>$com_state_name, 
						'state_id'=>$com_state, 
						'country_id'=>$com_country, 
						'is_active' => 1
					);
				   
					$this->load->model('shipment_model');
					$result = $this->shipment_model->saveAirport($aInfo);
                }
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New Airport created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Airport creation failed');
                }
                
                redirect('airports');
            }
        }
    }
	
	function updateAirport()
    { 
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $airport_id = $this->input->post('airport_id');
            
            $this->form_validation->set_rules('airport_name','Airport Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('airport_code','Airport Code','trim|required|max_length[4]');
            $this->form_validation->set_rules('city','City','trim|required|max_length[128]');

            $this->form_validation->set_rules('com_country','Country','trim|required|numeric');
            $this->form_validation->set_rules('com_state','State','trim|required|numeric');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editAirport($airport_id);
            }
            else
            {

                $airport_name = ucwords(strtolower($this->security->xss_clean($this->input->post('airport_name'))));
                $airport_code = strtoupper($this->security->xss_clean($this->input->post('airport_code')));
               
                $city = ucwords(strtolower($this->security->xss_clean($this->input->post('city'))));
                $com_state = $this->input->post('com_state');
                $com_country = $this->input->post('com_country');
                $com_state_name = $this->shipment_model->getStateName($com_state);
				
                $isCodeExist = $this->shipment_model->checkAirportCodeExist($airport_code, $airport_id);
				;
                if($isCodeExist){
					
					$this->session->set_flashdata('error', 'Airport Code Already Exist!');
					$this->addAirport();
					return false;
				}else{
				
					$aInfo = array(
						'airport_name'=> $airport_name, 
						'airport_code'=> $airport_code, 
						'city'=>$city, 
						'state'=>$com_state_name, 
						'state_id'=>$com_state, 
						'country_id'=>$com_country, 
					);
				   
					$this->load->model('shipment_model');
					
					$result = $this->shipment_model->updateAirport($aInfo, $airport_id);
                }
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Airport updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Airport updation failed');
                }
                
                redirect('airports');
            }
        }

    }
	
	function editAirport($airportid = NULL)
    {
        if($this->isAdmin() == TRUE )
        {
            $this->loadThis();
        }
        else
        {
            if($airportid == null)
            {
                redirect('airports');
            }
            $data['countries'] = $this->customer_model->getCountries();
			
            $data['states'] = array();			
            $aInfo = $this->shipment_model->getAirportInfo($airportid);
			
			if(!empty($aInfo->country_id)){
				$data['states'] = $this->customer_model->getStateList($aInfo->country_id);
			}
			
            $data['aInfo'] = $aInfo;
               
            $this->global['pageTitle'] = 'JustShipIt : Edit Airport';
            
            $this->loadViews("shipment/editAirport", $this->global, $data, NULL);
        }
    }
	
	public function loadSpecialInstructions(){
		// POST data
		$postData = $this->input->post();		
		$data['popup_title'] = 'Special Instructions';
		
		$data['aRecords'] = $this->shipment_model->loadSpecialInstructions($postData);
		$data['postData'] = $postData;
		
		$this->load->view("shipment/specialinstructions", $data);		
	}
	
	public function loadSelectedVendors(){
		// POST data
		$postData = $this->input->post();

		$this->load->library('pagination');
            
		$data['aVenRecords'] = $this->shipment_model->loadSelectedVendors($postData['shipment_id']);
		$data['postData'] = $postData;
		
		$this->load->view("shipment/selectedvendors", $data);		
	}
	
	public function loadSelectedChargeCodes(){
		// POST data
		$postData = $this->input->post();

		$this->load->library('pagination');
            
		$data['aChargeRecords'] = $this->shipment_model->loadSelectedChargeCodes($postData['shipment_id']);
		$data['rate_basis'] = $this->shipment_model->getRateBasis(); 
		$data['postData'] = $postData;
		
		$this->load->view("shipment/selectedchargecodes", $data);		
	}
	
	public function loadSelectedExtraChargeCodes(){
		// POST data
		$postData = $this->input->post();

		$this->load->library('pagination');
            
		$data['aRecords'] = $this->shipment_model->loadSelectedExtraChargeCodes($postData['shipment_id']);
		$data['rate_basis'] = $this->shipment_model->getRateBasis(); 
		$data['postData'] = $postData;
		
		$this->load->view("shipment/selectedextrachargecodes", $data);		
	}
	
	public function loadCloneOption(){
		// POST data
		$postData = $this->input->post();
            
		$data['popup_title'] = 'Clone Options';
			
		$data['shipdata'] =  $this->shipment_model->getDomesticInfo($postData['shipment_id']);
		
		$data['postData'] = $postData;
		
		$this->load->view("shipment/loadCloneOption", $data);		

	}
	
	function removeVendorType()
	{
		if($this->isAdmin() == TRUE)
		{
			echo(json_encode(array('status'=>'access')));
		}
		else
		{
			$dom_id = $this->input->post('dom_id');
						
			$result = $this->shipment_model->removeVendorType($dom_id);
			
			if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
			else { echo(json_encode(array('status'=>FALSE))); }
		}
	} 
	
	function removeChargeCode()
	{
		if($this->isAdmin() == TRUE)
		{
			echo(json_encode(array('status'=>'access')));
		}
		else
		{
			$pid = $this->input->post('pid');
						
			$result = $this->shipment_model->removeChargeCode($pid);
			
			if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
			else { echo(json_encode(array('status'=>FALSE))); }
		}
	} 
	
	function removeExtraChargeCode()
	{
		if($this->isAdmin() == TRUE)
		{
			echo(json_encode(array('status'=>'access')));
		}
		else
		{
			$pid = $this->input->post('pid');
						
			$result = $this->shipment_model->removeExtraChargeCode($pid);
			
			if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
			else { echo(json_encode(array('status'=>FALSE))); }
		}
	} 
	
   function billLadingPdf($shipmentid = NULL){
   
		$this->load->library('pdf');
		
		$shipInfo = $this->shipment_model->getDomesticInfo($shipmentid);
		//print_r($shipInfo);die();
		$data['shipInfo'] = $shipInfo;
		$data['types'] = $this->shipment_model->getFrieghtTypes();	
		$data['aVenRecords'] = $this->shipment_model->loadSelectedVendors($shipmentid);
		$data['aChargeRecords'] = $this->shipment_model->loadSelectedChargeCodes($shipmentid);
		$data['trackrecords'] = $this->shipment_model->loadlastTrackingRecord($shipmentid);
		
        $html = $this->load->view('shipment/billLadingPdf', $data, true);
		
		echo $html;
		//$this->mpdf->createPDF($html, 'billofLading', $download=false);
		/* dompdf design issue so changed to print.js*/
        /*$this->pdf->createPDF($html, 'billofLading', $download=false);*/

   }

   function deliveryAlertPdf($shipmentid = NULL){
   
		$this->load->library('pdf');
		
		$shipInfo = $this->shipment_model->getDomesticInfo($shipmentid);
		
		$data['shipInfo'] = $shipInfo;
		$data['types'] = $this->shipment_model->getFrieghtTypes();	
		$data['aVenRecords'] = $this->shipment_model->loadSelectedVendors($shipmentid);
		$data['aChargeRecords'] = $this->shipment_model->loadSelectedChargeCodes($shipmentid);
		$data['trackrecords'] = $this->shipment_model->loadlastTrackingRecord($shipmentid);
		
        $html = $this->load->view('shipment/deliveryAlertPdf', $data, true);
		
		echo $html;
		//$this->mpdf->createPDF($html, 'billofLading', $download=false);
		/* dompdf design issue so changed to print.js*/
        /*$this->pdf->createPDF($html, 'billofLading', $download=false);*/

   }
   
   function bolLabel($shipmentid = NULL){
   
		$this->load->library('pdf');
		
		$shipInfo = $this->shipment_model->getDomesticInfo($shipmentid);
		
		$data['shipInfo'] = $shipInfo;
		$data['types'] = $this->shipment_model->getFrieghtTypes();	
		$data['aVenRecords'] = $this->shipment_model->loadSelectedVendors($shipmentid);
		$data['aChargeRecords'] = $this->shipment_model->loadSelectedChargeCodes($shipmentid);
		$data['trackrecords'] = $this->shipment_model->loadlastTrackingRecord($shipmentid);
		$data['sysname'] = $this->global ['name'];
		
        $html = $this->load->view('shipment/bolLabelPdf', $data, true);
		
		echo $html;
		
		/* dompdf design issue so changed to print.js*/
        /*$this->pdf->createPDF($html, 'deliveryAlertPdf', $download=false);*/

   }

   function pickupAlertPdf($shipmentid = NULL){
   
		//$this->load->library('pdf');
		
		$shipInfo = $this->shipment_model->getDomesticInfo($shipmentid);
		
		$data['shipInfo'] = $shipInfo;
		$data['types'] = $this->shipment_model->getFrieghtTypes();	
		$data['aVenRecords'] = $this->shipment_model->loadSelectedVendors($shipmentid);
		$data['aChargeRecords'] = $this->shipment_model->loadSelectedChargeCodes($shipmentid);
		$data['trackrecords'] = $this->shipment_model->loadlastTrackingRecord($shipmentid);
		$data['sysname'] = $this->global ['name'];
        $html = $this->load->view('shipment/pickupAlertPdf', $data, true);
		
		echo $html;
		
		/* dompdf design issue so changed to print.js*/
        /*$this->pdf->createPDF($html, 'pickupAlert', $download=false);*/

   }
   
   function transferAlertPdf($shipmentid = NULL){
   
		//$this->load->library('pdf');
		
		$shipInfo = $this->shipment_model->getDomesticInfo($shipmentid);
		
		$aRecords = $this->shipment_model->loadTransferAlert($shipmentid);
		$data['aRecords'] = $aRecords;		
		
		$data['shipInfo'] = $shipInfo;
		
		$data['postData'] = $shipmentid;
		
		$data['rate_basis'] = $this->shipment_model->getRateBasis(); 
		$data['countries'] = $this->customer_model->getCountries();
        $data['states'] =array();
		
		if(!empty($aRecords)){
			$data['t_states'] = $this->customer_model->getStateList($aRecords['t_data']['t_country']);
			$data['r_states'] = $this->customer_model->getStateList($aRecords['r_data']['r_country']);
		}
		$data['sysname'] = $this->global['name'];
        $html = $this->load->view('shipment/transferAlertPdf', $data, true);
		
		echo $html;
		
		/* dompdf design issue so changed to print.js*/
        /*$this->pdf->createPDF($html, 'pickupAlert', $download=false);*/

   } 
   
   function dommawb($shipmentid = NULL){
		$data['countries'] = $this->customer_model->getCountries();
		$data['states'] = array();
		$data['reftypes'] = $this->customer_model->getRefTypes();
		$data['servicelevels'] = $this->shipment_model->getServicelevels();
		$data['orderstatus'] = $this->shipment_model->getOrderStatus();
		$data['types'] = $this->shipment_model->getFrieghtTypes();
		$data['classes'] = $this->customer_model->getClasses();
		$data['currencies'] = $this->customer_model->getAllCurrencies();
		
		$shipInfo = $this->shipment_model->getDomesticInfo($shipmentid);
		
		$data['shipInfo'] = $shipInfo;
		
		$data['opentab'] = (isset($aGetData['showtab']) ? $aGetData['showtab'] : 'home-tab');
		
		$data['aVenRecords'] = $this->shipment_model->loadSelectedVendors($shipmentid);
		
		$data['aChargeRecords'] = $this->shipment_model->loadSelectedChargeCodes($shipmentid);
		
		$data['trackrecords'] = $this->shipment_model->loadlastTrackingRecord($shipmentid);
		
		$data['rate_basis'] = $this->shipment_model->getRateBasis(); 
		
		$aRecords = $this->shipment_model->loadlastMAWBdatas($shipmentid);
		$data['aRecords'] = $aRecords;
		
		
		
		$data['issuedbyname'] = $data['issued_by_id'] = $data['issued_ref_no'] = $data['agent_account_no'] = $data['origin_airport_city'] = $data['dest_airport_city'] = $data['mawb_first'] = $data['mawb_second'] = $data['mawb_full'] = $data['dest_airport_code'] = $data['origin_airport_code'] = $data['agent_address_carrier'] = $data['req_flight_date'] = $data['req_flight_no'] = $data['vendor_name'] = $data['v_account'] = '';
		
		$deliveryVenData['vendor_id'] =$deliveryVenData['name'] = $deliveryVenData['address_1'] = $deliveryVenData['address_2']= $deliveryVenData['city']= $deliveryVenData['state_name']= $deliveryVenData['zip']= $deliveryVenData['country_name']=$deliveryVenData['phone']= $deliveryVenData['contact'] =$deliveryVenData['c_country'] =$deliveryVenData['c_state'] = '';
		
		if(!empty($data['aVenRecords'])){
			foreach($data['aVenRecords'] as $venrecord){
				
				if($venrecord->p_v_type_id == 6 || $venrecord->p_v_type_id == 7){
					$data['issuedbyname'] = $venrecord->customer_number;
					$data['vendor_name'] = $venrecord->agent_name;
					$data['issued_by_id'] = $venrecord->p_vendor_id;
					$data['issued_ref_no'] = $venrecord->p_ref_name;
					$data['agent_account_no'] = $venrecord->agent_account_no;
					$data['origin_airport_code'] = $venrecord->origin_airport_code;
					$data['origin_airport_city'] = $venrecord->origin_airport_city;
					$data['dest_airport_code'] = $venrecord->dest_airport_code;
					$data['dest_airport_city'] = $venrecord->dest_airport_city;
					$data['agent_address_carrier'] = $venrecord->origin_airport_code .'/'. $venrecord->origin_airport_city;
					$data['v_account'] = $venrecord->v_account;
					
					if($venrecord->p_v_type_id == 6){
						$v_mawb = explode('-',$venrecord->v_mawb);
						if((isset($v_mawb[1])) && !empty($v_mawb[1])){
							$data['mawb_first'] = $v_mawb[0];
							$data['mawb_second'] = (isset($v_mawb[1]) ? $v_mawb[1] : $v_mawb[0]);
						}else{
							$data['mawb_first'] = substr($venrecord->v_mawb,0,3);
							$data['mawb_second'] = substr($venrecord->v_mawb,3);
						}
						$data['mawb_full'] = $venrecord->v_mawb;
						
						if(!empty($venrecord->vendor_airline_datas)){
							$airrecs = (array) json_decode($venrecord->vendor_airline_datas);
							
							foreach($airrecs as $airdata){
								/* loading last flight name*/
								if(!empty($airdata->flight_name)){
									$data['req_flight_no'] = $airdata->flight_name;
								}
								/* loading last flight_arrival*/
								if(!empty($airdata->flight_dept)){
									$data['req_flight_date'] = $airdata->flight_dept;
								}
							}
						}
					}
					if($venrecord->p_v_type_id == 7){
						$data['mawb_full'] = $data['mawb_second'] = $venrecord->v_mawb;
					}
				}
				
				if($venrecord->p_v_type_id == 8){
										
					$delVenData = (array) $this->Customer_model->getCustomerInfo($venrecord->p_vendor_id);
					
					$deliveryVenData['vendor_id'] = $delVenData['customer_id'];
					$deliveryVenData['name'] = $delVenData['customer_name'];
					$deliveryVenData['address_1'] = $delVenData['c_address_1'];
					$deliveryVenData['address_2'] = $delVenData['c_address_2'];
					$deliveryVenData['address_2'] = $delVenData['c_address_2'];
					$deliveryVenData['city'] = $delVenData['c_city'];
					$deliveryVenData['zip'] = $delVenData['c_zip'];
					$deliveryVenData['phone'] = $delVenData['c_phone'];
					$deliveryVenData['contact'] = $delVenData['c_contact'];
					$deliveryVenData['c_country'] = $delVenData['c_country'];
					$deliveryVenData['c_state'] = $delVenData['c_state'];
					$deliveryVenData['state_name'] = $this->shipment_model->getStateName($delVenData['c_state']);
					$deliveryVenData['country_name'] = $this->shipment_model->getCountryName($delVenData['c_country']);
					
				}
			}
		}
		
		$data['deliveryVenData'] = $deliveryVenData;
		
		$data['s_states'] = $this->customer_model->getStateList((isset($aRecords['s_data']['s_country']) ? $aRecords['s_data']['s_country'] : 2));
		$data['c_states'] = $this->customer_model->getStateList((isset($aRecords['c_data']['c_country']) ? $aRecords['c_data']['c_country'] : $deliveryVenData['c_country']));
		
		if(isset($aRecords['sysname']) && !empty($aRecords['sysname'])){
			$data['sysname'] = $aRecords['sysname'];
		}else{
			$data['sysname'] = $this->global ['name'];
		}
		$this->global['pageTitle'] = 'JustShipIt : Edit Domestic Shipment';
		
		$this->loadViews("shipment/dommawb", $this->global, $data, NULL);
   }
   
   function mawbPdf($shipmentid = NULL){
		$data['countries'] = $this->customer_model->getCountries();
		$data['states'] = array();
		$data['reftypes'] = $this->customer_model->getRefTypes();
		$data['servicelevels'] = $this->shipment_model->getServicelevels();
		$data['orderstatus'] = $this->shipment_model->getOrderStatus();
		$data['types'] = $this->shipment_model->getFrieghtTypes();
		$data['classes'] = $this->customer_model->getClasses();
		$data['currencies'] = $this->customer_model->getAllCurrencies();
		
		$shipInfo = $this->shipment_model->getDomesticInfo($shipmentid);
		
		$data['shipInfo'] = $shipInfo;
		
		$data['opentab'] = (isset($aGetData['showtab']) ? $aGetData['showtab'] : 'home-tab');
		
		$data['aVenRecords'] = $this->shipment_model->loadSelectedVendors($shipmentid);
		
		$data['aChargeRecords'] = $this->shipment_model->loadSelectedChargeCodes($shipmentid);
		
		$data['trackrecords'] = $this->shipment_model->loadlastTrackingRecord($shipmentid);
		
		$data['rate_basis'] = $this->shipment_model->getRateBasis(); 
		
		$aRecords = $this->shipment_model->loadlastMAWBdatas($shipmentid);
		$data['aRecords'] = $aRecords;
		
		$data['s_states'] = $this->customer_model->getStateList((isset($aRecords['s_data']['s_country']) ? $aRecords['s_data']['s_country'] : 2));
		$data['c_states'] = $this->customer_model->getStateList((isset($aRecords['c_data']['c_country']) ? $aRecords['c_data']['c_country'] : $shipInfo['consignee_data']['c_country']));
		
		$data['issuedbyname'] = $data['issued_by_id'] = $data['issued_ref_no'] = $data['agent_account_no'] = $data['origin_airport_city'] = $data['dest_airport_city'] = $data['mawb_first'] = $data['mawb_second'] = $data['mawb_full'] = $data['dest_airport_code'] = $data['origin_airport_code'] = $data['agent_address_carrier'] = $data['req_flight_date'] = $data['req_flight_no'] = $data['vendor_name'] = $data['v_account'] = '';
		
		if(!empty($data['aVenRecords'])){
			foreach($data['aVenRecords'] as $venrecord){
				
				if($venrecord->p_v_type_id == 6 || $venrecord->p_v_type_id == 7){
					$data['issuedbyname'] = $venrecord->customer_number;
					$data['vendor_name'] = $venrecord->agent_name;
					$data['issued_by_id'] = $venrecord->p_vendor_id;
					$data['issued_ref_no'] = $venrecord->p_ref_name;
					$data['agent_account_no'] = $venrecord->agent_account_no;
					$data['origin_airport_code'] = $venrecord->origin_airport_code;
					$data['origin_airport_city'] = $venrecord->origin_airport_city;
					$data['dest_airport_code'] = $venrecord->dest_airport_code;
					$data['dest_airport_city'] = $venrecord->dest_airport_city;
					$data['agent_address_carrier'] = $venrecord->origin_airport_code .'/'. $venrecord->origin_airport_city;
					$data['v_account'] = $venrecord->v_account;
					
					if($venrecord->p_v_type_id == 6){
						$v_mawb = explode('-',$venrecord->v_mawb);
						if((isset($v_mawb[1])) && !empty($v_mawb[1])){
							$data['mawb_first'] = $v_mawb[0];
							$data['mawb_second'] = (isset($v_mawb[1]) ? $v_mawb[1] : $v_mawb[0]);
						}else{
							$data['mawb_first'] = substr($venrecord->v_mawb,0,3);
							$data['mawb_second'] = substr($venrecord->v_mawb,3);
						}
						$data['mawb_full'] = $venrecord->v_mawb;
						
						if(!empty($venrecord->vendor_airline_datas)){
							$airrecs = (array) json_decode($venrecord->vendor_airline_datas);
							
							foreach($airrecs as $airdata){
								/* loading last flight name*/
								if(!empty($airdata->flight_name)){
									$data['req_flight_no'] = $airdata->flight_name;
								}
								/* loading last flight_arrival*/
								if(!empty($airdata->flight_dept)){
									$data['req_flight_date'] = $airdata->flight_dept;
								}
							}
						}
					}
					if($venrecord->p_v_type_id == 7){
						$data['mawb_full'] = $data['mawb_second'] = $venrecord->v_mawb;
					}
				}
			}
		}
		
		if(isset($aRecords['sysname']) && !empty($aRecords['sysname'])){
			$data['sysname'] = $aRecords['sysname'];
		}else{
			$data['sysname'] = $this->global ['name'];
		}
        $html = $this->load->view('shipment/mawbPdf', $data, true);
		
		echo $html;
   }
   
   public function routingAlertPdf($shipmentid = NULL){
		// POST data
	            		
		$shipInfo = $this->shipment_model->getDomesticInfo($shipmentid);
		
		$aRecords = $this->shipment_model->loadRoutingAlert($shipmentid);

		$data['aRecords'] = $aRecords;		
		
		$data['shipInfo'] = $shipInfo;
		
		
		$data['rate_basis'] = $this->shipment_model->getRateBasis(); 
		$data['countries'] = $this->customer_model->getCountries();
        $data['states'] =array();
		
		
		
		
		$data['aVenRecords'] = $this->shipment_model->loadSelectedVendors($shipmentid);
		
		$neededVendorData['v_airline'] = $neededVendorData['agent_account_no'] = $neededVendorData['v_cut_off_time'] = $neededVendorData['v_mawb'] = $neededVendorData['p_total_cost'] = $neededVendorData['v_origin_id'] = $neededVendorData['origin_airport_code'] = $neededVendorData['dest_airport_code'] = $neededVendorData['v_destination_id'] = $neededVendorData['v_account'] = '';
		$showAirline = false;
		
		$deliveryVenData['vendor_id'] =$deliveryVenData['name'] = $deliveryVenData['address_1'] = $deliveryVenData['address_2']= $deliveryVenData['city']= $deliveryVenData['state_name']= $deliveryVenData['zip']= $deliveryVenData['country_name']=$deliveryVenData['phone']= $deliveryVenData['contact'] =$deliveryVenData['c_country'] =$deliveryVenData['c_state'] = '';
		
		if(!empty($data['aVenRecords'])){
			foreach($data['aVenRecords'] as $venrecord){

				if($venrecord->p_v_type_id == 6){
					$neededVendorData['v_airline'] = $venrecord->v_airline;
					$neededVendorData['v_mawb'] = $venrecord->v_mawb;
					$neededVendorData['v_cut_off_time'] = $venrecord->v_cut_off_time;
					$neededVendorData['v_account'] = $venrecord->v_account;
					$neededVendorData['p_total_cost'] = $venrecord->p_total_cost;
					$neededVendorData['v_origin_id'] = $venrecord->v_origin_id;
					$neededVendorData['origin_airport_code'] = $venrecord->origin_airport_code;
					$neededVendorData['dest_airport_code'] = $venrecord->dest_airport_code;
					$neededVendorData['v_destination_id'] = $venrecord->v_destination_id;
					$neededVendorData['vendor_airline_datas'] = (array) json_decode($venrecord->vendor_airline_datas);
					
					$showAirline = true;
				}
				
				if($venrecord->p_v_type_id == 7 && !$showAirline){
					$neededVendorData['v_airline'] = $venrecord->v_airline;
					$neededVendorData['v_mawb'] = $venrecord->v_mawb;
					$neededVendorData['v_cut_off_time'] = $venrecord->v_cut_off_time;
					$neededVendorData['v_account'] = $venrecord->v_account;
					$neededVendorData['p_total_cost'] = $venrecord->p_total_cost;
					$neededVendorData['v_origin_id'] = $venrecord->v_origin_id;
					$neededVendorData['origin_airport_code'] = $venrecord->origin_airport_code;
					$neededVendorData['dest_airport_code'] = $venrecord->dest_airport_code;
					$neededVendorData['v_destination_id'] = $venrecord->v_destination_id;
					$neededVendorData['vendor_airline_datas'] = array();
				}
				
				if($venrecord->p_v_type_id == 8){
										
					$delVenData = (array) $this->Customer_model->getCustomerInfo($venrecord->p_vendor_id);
					
					$deliveryVenData['vendor_id'] = $delVenData['customer_id'];
					$deliveryVenData['name'] = $delVenData['customer_name'];
					$deliveryVenData['address_1'] = $delVenData['c_address_1'];
					$deliveryVenData['address_2'] = $delVenData['c_address_2'];
					$deliveryVenData['address_2'] = $delVenData['c_address_2'];
					$deliveryVenData['city'] = $delVenData['c_city'];
					$deliveryVenData['zip'] = $delVenData['c_zip'];
					$deliveryVenData['phone'] = $delVenData['c_phone'];
					$deliveryVenData['contact'] = $delVenData['c_contact'];
					$deliveryVenData['c_country'] = $delVenData['c_country'];
					$deliveryVenData['c_state'] = $delVenData['c_state'];
					$deliveryVenData['state_name'] = $this->shipment_model->getStateName($delVenData['c_state']);
					$deliveryVenData['country_name'] = $this->shipment_model->getCountryName($delVenData['c_country']);
					
				}
			}
		}
		$data['showAirline'] = $showAirline;
		$data['neededVendorData'] = $neededVendorData;
		$data['deliveryVenData'] = $deliveryVenData;
		
		$data['r_states'] = $this->customer_model->getStateList((isset($aRecords['r_f_data']['r_country']) ? $aRecords['r_f_data']['r_country'] : 2));
		$data['t_states'] = $this->customer_model->getStateList((isset($aRecords['t_f_data']['c_country']) ? $aRecords['t_f_data']['c_country'] : $deliveryVenData['c_country']));

		
		if(isset($aRecords['sysname']) && !empty($aRecords['sysname'])){
			$data['sysname'] = $aRecords['sysname'];
		}else{
			$data['sysname'] = $this->global ['name'];
		}
        $html = $this->load->view('shipment/routingAlertPdf', $data, true);
		
		echo $html;

	} 
	
	function dominvoicepdf($shipmentid = NULL){

		$shipInfo = $this->shipment_model->getDomesticInfo($shipmentid);
		
		if(!empty($shipInfo)){
			$upinfo = array('is_invoice_printed'=>1);
                
            $result = $this->shipment_model->updateDomesticShipment($upinfo, $shipmentid);
		}
		//print_r($shipInfo);die();
		$data['shipInfo'] = $shipInfo;
		$data['types'] = $this->shipment_model->getFrieghtTypes();	
		$data['aVenRecords'] = $this->shipment_model->loadSelectedVendors($shipmentid);
		$data['aChargeRecords'] = $this->shipment_model->loadSelectedChargeCodes($shipmentid);
		$data['trackrecords'] = $this->shipment_model->loadlastTrackingRecord($shipmentid);
		$data['rate_basis'] = $this->shipment_model->getRateBasis(); 
        $html = $this->load->view('shipment/dominvoicepdf', $data, true);
		
		echo $html;

   }
   
   function sendmail($alerttype, $shipmentid){

		$shipInfo = $this->shipment_model->getDomesticInfo($shipmentid);
		if(empty($shipInfo)){
			$response = array(
				'status' => 'success',
				'message' => "<h3 class='m-0'>Not a valid shipment!</h3>"
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
			return false;
		}
		$userInfo = $this->user_model->getAdminuserInfo(1);
		
		$types = $this->shipment_model->getFrieghtTypes();	
		$aVenRecords = $this->shipment_model->loadSelectedVendors($shipmentid);
		$aChargeRecords = $this->shipment_model->loadSelectedChargeCodes($shipmentid);
		$trackrecords = $this->shipment_model->loadlastTrackingRecord($shipmentid);
		$rate_basis = $this->shipment_model->getRateBasis(); 
       
		$to_email = 'vigneshwaran.m@phpmasterminds.com'; 

				
		if($alerttype == 'pickup'){
			$subject = 'Pickup Alert Reference#'.$shipInfo['waybill'];
			
			$message = 'New Pickup Alert <br/>';
			$message .= 'Pick-up at:<br/>';	
			$message .= $shipInfo['shipper_data']['shipper_name']. '<br/>' .$shipInfo['shipper_data']['s_address_1']. '<br/>'.(!empty($shipInfo['shipper_data']['s_address_2']) ? $shipInfo['shipper_data']['s_address_2'].'<br/>' : ''). $shipInfo['shipper_data']['s_city']. (isset($shipInfo['shipper_data']['state_name']) ? ', '.$shipInfo['shipper_data']['state_name']. ' '.$shipInfo['shipper_data']['s_zip'] : ''). (isset($shipInfo['shipper_data']['country_name']) ? ', '.$shipInfo['shipper_data']['country_name'] : ''). '<br/>'.(!empty($shipInfo['shipper_data']['show_name']) ? $shipInfo['shipper_data']['show_name'].'<br/>' : '').(!empty($shipInfo['shipper_data']['exhibitor_name']) ? $shipInfo['shipper_data']['exhibitor_name'].'<br/>' : '').(!empty($shipInfo['shipper_data']['booth_name']) ? 'Booth #'.$shipInfo['shipper_data']['booth_name'].'<br/>' : '').(!empty($shipInfo['shipper_data']['decorator_name']) ? $shipInfo['shipper_data']['decorator_name'].'<br/>' : '');
			
			$alink = base_url().'pickupAlertPdf/'.$shipInfo['shipment_id'];
			$message .= 'Please click below link to access <br/>';
			$message .= '<a href="'.$alink.'">'.$alink.'</a>';
			
		}elseif($alerttype == 'delivery'){
			$subject = 'Pickup Alert Reference#'.$shipInfo['waybill'];
			
			$message = 'New Pickup Alert <br/>';
			$message .= 'Pick-up at:<br/>';			
			$message .= $shipInfo['shipper_data']['shipper_name']. '<br/>' .$shipInfo['shipper_data']['s_address_1']. '<br/>'.(!empty($shipInfo['shipper_data']['s_address_2']) ? $shipInfo['shipper_data']['s_address_2'].'<br/>' : ''). $shipInfo['shipper_data']['s_city']. (isset($shipInfo['shipper_data']['state_name']) ? ', '.$shipInfo['shipper_data']['state_name']. ' '.$shipInfo['shipper_data']['s_zip'] : ''). (isset($shipInfo['shipper_data']['country_name']) ? ', '.$shipInfo['shipper_data']['country_name'] : ''). '<br/>'.(!empty($shipInfo['shipper_data']['show_name']) ? $shipInfo['shipper_data']['show_name'].'<br/>' : '').(!empty($shipInfo['shipper_data']['exhibitor_name']) ? $shipInfo['shipper_data']['exhibitor_name'].'<br/>' : '').(!empty($shipInfo['shipper_data']['booth_name']) ? 'Booth #'.$shipInfo['shipper_data']['booth_name'].'<br/>' : '').(!empty($shipInfo['shipper_data']['decorator_name']) ? $shipInfo['shipper_data']['decorator_name'].'<br/>' : '');
			
			
		}elseif($alerttype == 'mawb'){
			$subject = 'MAWB Alert Reference#'.$shipInfo['waybill'];
		}else{
			$subject = 'Alert Reference#'.$shipInfo['waybill'];
		}
		$from_email = $userInfo['email']; 
		$this->load->library('email'); 
		$this->email->from($from_email, 'Fastline Logistics'); 
		$this->email->to($to_email);
		$this->email->subject($subject); 
		$this->email->message($message); 

		//Send mail 
		if($this->email->send()){
			$response = array(
				'status' => 'success',
				'message' => "<h3 class='m-0'>Email sent successfully.</h3>"
			);
		}else {
			$response = array(
				'status' => 'success',
				'message' => "<h3 class='m-0'>Error in sending Email.</h3>"
			);
		}
		
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
					
   }
}

?>