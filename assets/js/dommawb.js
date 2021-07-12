
$(document).ready(function(){
	
	var addDomForm = $("#updateMAWBdatas");
	
	var validator = addDomForm.validate({
		
	});
	
	
	$( ".datetimepicker" ).datetimepicker({
		format: 'm/d/Y H:i',
		formatTime: 'H:i',
		formatDate: 'm/d/Y',
		step: 30,
		timepicker: true,
		datepicker: true,
		yearStart: 2021,
	});
	
	$( ".dateonlypicker" ).datetimepicker({
		format: 'm/d/Y',
		formatDate: 'm/d/Y',
		timepicker: false,
		datepicker: true,
		yearStart: 2021,
	});
	
	$( ".timepicker" ).datetimepicker({
		format: 'H:i',
		formatTime: 'H:i',
		step: 30,
		timepicker: true,
		datepicker: false,
		yearStart: 2021,
	});

});


function chooseVendor(mainid, subid, parentid, cid, cnumber, cname, filnum){
	
	$('#'+parentid+' #'+mainid).val(cnumber);
	$('#'+parentid+' #'+subid).val(cid);
	
	$('#myModaloverlap').modal('toggle');
}

function chooseAirport(cid, cnumber, mainid, subid, parentid){
	
	$('#'+parentid+' #'+mainid).val(cnumber);
	$('#'+parentid+' #'+subid).val(cid);
	
	$('#myModaloverlap').modal('toggle');
}




function searchpopup(){
	var searchTextPop = $('#searchTextPop').val();
	var is_shipper = $('#is_shipper').val();
	var is_bill_to = $('#is_bill_to').val();
	var is_consignee = $('#is_consignee').val();
	var is_sales = $('#is_sales').val();
	$(".displaycontentpopup").html("");
	$.ajax({
		type: "POST",
		url: baseURL+'checkCustomerpopup',
		data: {
		
			is_shipper: is_shipper,
			is_bill_to:is_bill_to,
			is_consignee:is_consignee,
			is_sales:is_sales,
			search:searchTextPop,
		},
		success: function (response) {
			$(".displaycontentpopup").html(response);
		}
	});
}


function loadVendors(mainid, subid, atype, parentid){
	if(atype == 'all'){
		var searchTextPop = '';
	}else{
		var searchTextPop = $('#searchTextPop').val();
	}
	var p_v_type_id = $('#p_v_type_id').val();
	$(".displaycontentpopup_overlap").html("");
	 $.ajax({
		type: "POST",
		url: baseURL+'loadVendors',
		data: {
			search:searchTextPop,
			p_v_type_id:p_v_type_id,
			mainid:mainid,
			subid:subid,
			parentid:parentid,
		},
		success: function (response) {
			$(".displaycontentpopup_overlap").html(response);
		}
	});
}

function loadSelectedVendors(id){
	$.ajax({
		type: "POST",
		url: baseURL+'loadSelectedVendors',
		data: {
			shipment_id:id,
		},
		success: function (response) {
			$(".perm_vendor_table").html(response);
		}
	});

}

function loadFlightOrigin(mainid, subid, atype, parentid){
	if(atype == 'all'){
		var searchTextPop = '';
	}else{
		var searchTextPop = $('#searchTextPop').val();
	}
	
	$(".displaycontentpopup_overlap").html("");
	$.ajax({
		type: "POST",
		url: baseURL+'loadAirports',
		data: {
			search:searchTextPop,
			mainid:mainid,
			subid:subid,
			parentid:parentid,
		},
		success: function (response) {
			$(".displaycontentpopup_overlap").html(response);
		}
	});
} 

function changemawbData(from, type, shipmentid){ 
	
	 $.ajax({
		url: baseURL+'getCustomerDatawithShip/'+shipmentid+'/'+type+'/'+from,
		type: "GET",
		dataType: "json",
		success:function(data) {
			if(data.customer_id == 'undefined' || data.customer_id === undefined){
				alert('Please add pickup/delivery vendor in Vendor Tab!');
			}
				if(from == 'delivery'){
					if(data.s_shipper_id != 'undefined' && data.s_shipper_id != undefined){
						$('#c_id').val(data.customer_id);
						$('#c_name').val(data.customer_name);
						$('#c_address_1').val(data.s_address_1);
						$('#c_address_2').val(data.s_address_2);
						$('#c_city').val(data.s_city);
						$('#c_zip').val(data.s_zip);
						$('#c_country').val(data.s_country);
						
						$('#c_default_ref').val(data.s_default_ref);
						$('#c_contact').val(data.s_contact);
						$('#c_phone').val(data.s_phone);
						
						$.ajax({
							url: baseURL+'statecheck/'+data.s_country,
							type: "GET",
							dataType: "json",
							success:function(datas) {
								$('#c_state').empty();
								$.each(datas, function(key, value) {
									$('#c_state').append('<option value="'+ value.state_id +'">'+ value.state_name +'</option>');
								});
								$('#c_state').val(data.s_state);
								
							}
						});
						
					}else{
						$('#c_id').val(data.customer_id);
						$('#c_name').val(data.customer_name);
						$('#c_address_1').val(data.c_address_1);
						$('#c_address_2').val(data.c_address_2);
						$('#c_city').val(data.c_city);
						$('#c_zip').val(data.c_zip);
						$('#c_country').val(data.c_country);
						
						$('#c_default_ref').val(data.c_default_ref);
						$('#c_contact').val(data.c_contact);
						$('#c_phone').val(data.c_phone);
						
						$.ajax({
							url: baseURL+'statecheck/'+data.c_country,
							type: "GET",
							dataType: "json",
							success:function(datas) {
								$('#c_state').empty();
								$.each(datas, function(key, value) {
									$('#c_state').append('<option value="'+ value.state_id +'">'+ value.state_name +'</option>');
								});
								$('#c_state').val(data.c_state);
								
							}
						});
					}

				}else{
					if(data.s_shipper_id != 'undefined' && data.s_shipper_id != undefined){
						$('#s_id').val(data.customer_id);
						$('#s_name').val(data.customer_name);
						$('#s_address_1').val(data.s_address_1);
						$('#s_address_2').val(data.s_address_2);
						$('#s_city').val(data.s_city);
						$('#s_zip').val(data.s_zip);
						$('#s_country').val(data.s_country);
						
						$('#s_default_ref').val(data.s_default_ref);
						$('#s_contact').val(data.s_contact);
						$('#s_phone').val(data.s_phone);
						
						$.ajax({
							url: baseURL+'statecheck/'+data.s_country,
							type: "GET",
							dataType: "json",
							success:function(datas) {
								$('#s_state').empty();
								$.each(datas, function(key, value) {
									$('#s_state').append('<option value="'+ value.state_id +'">'+ value.state_name +'</option>');
								});
								$('#s_state').val(data.s_state);
								
							}
						});
						
						
					}else{
						$('#s_id').val(data.customer_id);
						$('#s_name').val(data.customer_name);
						$('#s_address_1').val(data.c_address_1);
						$('#s_address_2').val(data.c_address_2);
						$('#s_city').val(data.c_city);
						$('#s_zip').val(data.c_zip);
						$('#s_country').val(data.c_country);
						
						$('#s_default_ref').val(data.c_default_ref);
						$('#s_contact').val(data.c_contact);
						$('#s_phone').val(data.c_phone);
						
						$.ajax({
							url: baseURL+'statecheck/'+data.c_country,
							type: "GET",
							dataType: "json",
							success:function(datas) {
								$('#s_state').empty();
								$.each(datas, function(key, value) {
									$('#s_state').append('<option value="'+ value.state_id +'">'+ value.state_name +'</option>');
								});
								$('#s_state').val(data.c_state);
								
							}
						});
					}
				}
			
		}
	});		
}
