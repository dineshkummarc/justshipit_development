
$(document).ready(function(){
	
	var addDomForm = $("#addDomesticShipment");
	
	var validator = addDomForm.validate({
		
		rules:{
			shipper_name :{ required : true },
			s_address_1 :{ required : true },
			s_city :{ required : true },
			s_country : { required : true, selected : true},
			
			c_shipper_name :{ required : true },
			c_address_1 :{ required : true },
			c_city :{ required : true },
			ready_date_time :{ required : true },
			close_date_time :{ required : true },
			service_level :{ required : true ,selected : true},
			schedule_date_time :{ required : true },
			c_country : { required : true, selected : true}
		},
		messages:{
			shipper_name :{ required : "This field is required" },
			s_address_1 :{ required : "This field is required" },
			s_city :{ required : "This field is required" },
			s_country : { required : "This field is required", selected : "Please select country option" },
			
			c_shipper_name :{ required : "This field is required" },
			c_address_1 :{ required : "This field is required" },
			c_city :{ required : "This field is required" },
			ready_date_time :{ required : "This field is required" },
			close_date_time :{ required : "This field is required" },
			service_level :{ required : "This field is required" , selected : "Please select one option" },
			schedule_date_time :{ required : "This field is required" },
			c_country : { required : "This field is required", selected : "Please select country option" }			
		}
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
	
	$( ".datenoyeartimepicker" ).datetimepicker({
		format: 'Y/m/d H:i',
		formatTime: 'H:i',
		formatDate: 'Y/m/d',
		step: 30,
		timepicker: true,
		datepicker: true,
		minDate:0,
		startDate:new Date(),
		yearStart: 2021
	});
	
	$( "#ready_date_time" ).datetimepicker({
		format: 'm/d/Y H:i',
		formatTime: 'H:i',
		formatDate: 'm/d/Y',
		step: 30,
		timepicker: true,
		datepicker: true,
		yearStart: 2021,
		onShow:function( ct ){
		   this.setOptions({
			maxDate:jQuery('#close_date_time').val()?jQuery('#close_date_time').val():false
		   })
		 },
		 //disabledWeekDays:[0,6]
	});
	
	$( "#close_date_time" ).datetimepicker({
		format: 'm/d/Y H:i',
		formatTime: 'H:i',
		formatDate: 'm/d/Y',
		step: 30,
		timepicker: true,
		datepicker: true,
		yearStart: 2021,
		onShow:function( ct ){
		   this.setOptions({
			minDate:jQuery('#ready_date_time').val()?jQuery('#ready_date_time').val():false
		   })
		},
		//disabledWeekDays:[0,6]
	});
	
	 $('#s_country').on('change', function() {
            var countryId = $(this).val();
            if(countryId) {
                $.ajax({
                    url: baseURL+'statecheck/'+countryId,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('#s_state').empty();
                        $.each(data, function(key, value) {
                            $('#s_state').append('<option value="'+ value.state_id +'">'+ value.state_name +'</option>');
                        });
                    }
                });
            }else{
                $('#s_state').empty();
            }
        });
		
		$('#c_country').on('change', function() {
            var countryId = $(this).val();
            if(countryId) {
                $.ajax({
                    url: baseURL+'statecheck/'+countryId,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('#c_state').empty();
                        $.each(data, function(key, value) {
                            $('#c_state').append('<option value="'+ value.state_id +'">'+ value.state_name +'</option>');
                        });
                    }
                });
            }else{
                $('#c_state').empty();
            }
        });

		$('#b_country').on('change', function() {
            var countryId = $(this).val();
            if(countryId) {
                $.ajax({
                    url: baseURL+'statecheck/'+countryId,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('#b_state').empty();
                        $.each(data, function(key, value) {
                            $('#b_state').append('<option value="'+ value.state_id +'">'+ value.state_name +'</option>');
                        });
                    }
                });
            }else{
                $('#b_state').empty();
            }
        });
		
		$('#auto_assign').on('click', function() {
			var bChecked = document.getElementById('auto_assign').checked;
            if(bChecked) {
                $.ajax({
                    url: baseURL+'getwaybillno/',
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('#waybill').attr('readonly' , true);
                        $('#waybill').val(data);
                    }
                });
            }else{ 
				$('#waybill').removeAttr('readonly');
                $('#waybill').val('');
            }
        });
		
		$( "#s_shipper_id" ).autocomplete({
			source: function( request, response ) {
			  // Fetch data
			  $.ajax({
				url: baseURL+'checkCustomer',
				type: 'post',
				dataType: "json",
				data: {
				  search: request.term,
				  is_shipper:1
				},
				success: function( datas ) {
				  response( datas );
				}
			  });
			},
			select: function (event, ui) {
			  $('#shipper_name').val(ui.item.label);
			  $('#s_shipper_id').val(ui.item.customer_number);
			  $('#org_s_shipper_id').val(ui.item.customer_id);
			  changeshipperdetails();
			  return false;
			}
      });
	  
	  

	  $( "#origin_airport" ).autocomplete({
			source: function( request, response ) {
			  // Fetch data
			  $.ajax({
				url: baseURL+'checkairportCode',
				type: 'post',
				dataType: "json",
				data: {
				  search: request.term,
				},
				success: function( datas ) {
				  response( datas );
				}
			  });
			},
			select: function (event, ui) {
			  $('#origin_airport').val(ui.item.airport_code);
			  $('#origin_airport_id').val(ui.item.airport_id);
			  return false;
			}
      }); 
	  
	  $( "#dest_airport" ).autocomplete({
			source: function( request, response ) {
			  // Fetch data
			  $.ajax({
				url: baseURL+'checkairportCode',
				type: 'post',
				dataType: "json",
				data: {
				  search: request.term,
				},
				success: function( datas ) {
				  response( datas );
				}
			  });
			},
			select: function (event, ui) {
			  $('#dest_airport').val(ui.item.airport_code);
			  $('#dest_airport_id').val(ui.item.airport_id);
			  return false;
			}
      }); 
	
	  
		
	  $( "#c_shipper_id" ).autocomplete({
			source: function( request, response ) {
			  // Fetch data
			  $.ajax({
				url: baseURL+'checkCustomer',
				type: 'post',
				dataType: "json",
				data: {
				  search: request.term,
				  is_consignee:1
				},
				success: function( datas ) {
				  response( datas );
				}
			  });
			},
			select: function (event, ui) {
			  $('#c_shipper_name').val(ui.item.label);
			  $('#c_shipper_id').val(ui.item.customer_number);
			  $('#org_c_shipper_id').val(ui.item.customer_id);
			  changecosigneedetails();
			  return false;
			}
      }); 
	  
	  $( "#b_shipper_id" ).autocomplete({
			source: function( request, response ) {
			  // Fetch data
			  $.ajax({
				url: baseURL+'checkCustomer',
				type: 'post',
				dataType: "json",
				data: {
				  search: request.term,
				  is_bill_to:1
				},
				success: function( datas ) {
				  response( datas );
				}
			  });
			},
			select: function (event, ui) {
			  $('#b_shipper_name').val(ui.item.label);
			  $('#b_shipper_id').val(ui.item.customer_number);
			  $('#org_b_shipper_id').val(ui.item.customer_id);
			  changebilltodetails();
			  return false;
			}
      }); 
	  
	  var opentab = $("#opentab").val();
	  if(opentab != ''){
		$('#'+opentab).click();
	  }
	  
	  setInterval(function(){  
		addTotalWeight();
		addTotalPiece();
		addTotalDimWeight();
	  }, 5000); 
	  
	  $('.mawb_num_format').usPhoneFormat({
		format: 'xxx-xxxxxxxx',
	  });
});

function changeScheduleTime(){
	var ready_date_time = $('#ready_date_time').val();
	var service_level = $('#service_level').val();
	var d = $('#ready_date_time').datetimepicker('getValue');
	var stardate = new Date(d);

	/* If the service level is 2nd day, the schedule date is 2 days later. If the service level is 3-5 day, the scheduled date is 5 days later Weekend days do not count */

	if(ready_date_time != '' && service_level != 0){
				 
		var endDate = "", noOfDaysToAdd = 0, count = 0;
		
		if(service_level == 1){
			var noOfDaysToAdd = 0;
			endDate = new Date(stardate.setDate(stardate.getDate() + 1));
		}else if(service_level == 2){
			var noOfDaysToAdd = 1;
		}else if(service_level == 3){
			var noOfDaysToAdd = 2;
		}else if(service_level == 4){
			var noOfDaysToAdd = 5;
		}
		
		while(count < noOfDaysToAdd){
			endDate = new Date(stardate.setDate(stardate.getDate() + 1));
			if(endDate.getDay() != 0 && endDate.getDay() != 6){
			   //Date.getDay() gives weekday starting from 0(Sunday) to 6(Saturday)
			   count++;
			}
		}
			
		var endmonth = endDate.getMonth()+1;
		var endday = endDate.getDate();
		var scdatetime =  (endmonth<10 ? '0' : '') + endmonth + '/' + (endday<10 ? '0' : '') + endday + '/' +  endDate.getFullYear()+ ' 17:00';
	
		if(service_level != 1 && service_level != ''){
			$('#schedule_date_time').val(scdatetime);
		}else{
			$('#schedule_date_time').val(ready_date_time);
		}
		
	}
}

function addTotalPiece(){
	var totalpiece = 0;
	$('.org_freight_div .piecesinput').each(function() {
		var curval =  this.value;
		if(curval != ''){
			totalpiece = parseInt(totalpiece) + parseInt(curval);
		}
	});
	$('#total_pieces').html(totalpiece);
}

function addTotalWeight(){
	var totalweight = 0;
	$('.org_freight_div .weightinput').each(function() {
		var curval =  this.value;
		if(curval != ''){
			totalweight = parseFloat(totalweight) + parseFloat(curval);
		}
	});
	$('#total_actual_weight').html(totalweight);
}

function addTotalDimWeight(){
	var totaldimweight = 0;
	$('.org_freight_div .t_dim_weight').each(function() {
		var curval =  this.value;
		if(curval != ''){
			totaldimweight = parseFloat(totaldimweight) + parseFloat(curval);
		}
	});
	$('#total_dim_weight').html(totaldimweight.toFixed(2));
	
	var totdimweight = $('#total_dim_weight').html();
	var totactualweight = $('#total_actual_weight').html();
	
	if(parseFloat(totdimweight) > parseFloat(totactualweight)){
		$('#total_chargeable_weight').html(totdimweight);
	}else{
		$('#total_chargeable_weight').html(totactualweight);
	}
}

function checkBetweenTime(){
		
	var schedule_by = $('#schedule_by:checked').val();
	$('#schedule_between_time').val('');
	if(schedule_by == 3){
		$('.betweendiv').removeClass('hide');
	}else{
		$('.betweendiv').addClass('hide');
	}
}


function loadChargeCode(ev){ 
	var idname = $(ev).parent('.charge_code_name_div').attr('id');
	
	$(".displaycontentpopup").html("");
	 $.ajax({
		type: "POST",
		url: baseURL+'loadChargeCode',
		data: "idname="+idname,
		success: function (response) {
			$(".displaycontentpopup").html(response);
		  
		}
	});
}

function loadExtraChargeCode(ev){ 
	var idname = $(ev).parent('.charge_code_name_div').attr('id');
	
	$(".displaycontentpopup_overlap2").html("");
	 $.ajax({
		type: "POST",
		url: baseURL+'loadExtraChargeCode',
		data: "idname="+idname,
		success: function (response) {
			$(".displaycontentpopup_overlap2").html(response);
		  
		}
	});
}

function loadVendorType(){ 
	var shipment_id = $('#shipment_id').val();
	$(".displaycontentpopup").html("");
	 $.ajax({
		type: "POST",
		url: baseURL+'loadVendorType',
		data: "shipment_id="+shipment_id,
		success: function (response) {
		$(".displaycontentpopup").html(response);
		  
		}
	});
}

function editVendorType(dom_id){ 

	$(".displaycontentpopup").html("");
	 $.ajax({
		type: "POST",
		url: baseURL+'editVendorType',
		data: "dom_id="+dom_id,
		success: function (response) {
			$(".displaycontentpopup").html(response);
		  
		}
	});
}

function setVendorType(typeid){

	$('.line_haul_div, .airline_div, .line_haul_div_holder, .airline_div_holder').hide();
	$('.line_haul_div_holder, .airline_div_holder').html('');
	
	
	$('#vendor_table').hide();
	$('#vendor_info_div').show();
	$('#p_v_type_id').val(typeid);
	
	if(typeid == 7){
		$('.line_haul_div, .line_haul_div_holder').show();
		$('.line_haul_div_holder').html($('.line_haul_div_content').html());
		resetDatetimepicker();
	}else if(typeid == 6){
		$('.airline_div, .airline_div_holder').show();
		$('.airline_div_holder').html($('.airline_div_content').html());
		resetDatetimepicker();
	}
	
	$('.localpickupbtn, .localdeliverybtn').hide();
	if(typeid == 5){
		$('.localpickupbtn').show();
	}else if(typeid == 8){
		$('.localdeliverybtn').show();
	}
}


function resetDatetimepicker(){
	$( ".datetimepicker" ).datetimepicker({
		format: 'm/d/Y H:i',
		formatTime: 'H:i',
		formatDate: 'm/d/Y',
		step: 30,
		timepicker: true,
		datepicker: true,
		yearStart: 2021,
	});
	$( ".datenoyeartimepicker" ).datetimepicker({
		format: 'Y/m/d H:i',
		formatTime: 'H:i',
		formatDate: 'Y/m/d',
		step: 30,
		timepicker: true,
		datepicker: true,
		minDate:0,
		startDate:new Date(),
		yearStart: 2021
	});
	$('.mawb_num_format').usPhoneFormat({
		format: 'xxx-xxxxxxxx',
	  });
	  
	 $('input.autocompleteflight').each(function() {
			var $el = $(this);
			
			$el.autocomplete({
				source: function( request, response ) {
				  // Fetch data
				  $.ajax({
					url: baseURL+'checkairportCode',
					type: 'post',
					dataType: "json",
					data: {
					  search: request.term,
					},
					success: function( datas ) {
					  response( datas );
					}
				  });
				},
				select: function (event, ui) {
				  $('#'+$el.data('parentid')+' #'+$el.data('mainid')).val(ui.item.airport_code);
				  $('#'+$el.data('parentid')+' #'+$el.data('subid')).val(ui.item.airport_id);
				  return false;
				}
			});
		});
}

function resetVendorType(typeid){
	$('.vendor_info_div_sub').find('input:text, select').val('');
	$('#vendor_table').show();
	$('#vendor_info_div').hide();
	$('#p_v_type_id').val('');
	$('#p_vendor_id').val('');
}

function loadShipper(){
	$(".displaycontentpopup").html("");
	 $.ajax({
		type: "POST",
		url: baseURL+'checkCustomerpopup',
		data: "is_shipper=1",
		success: function (response) {
		$(".displaycontentpopup").html(response);
		  
		}
	});
}

function loadExtraCharges(){
	var shipment_id = $('#shipment_id').val();
	
	$(".displaycontentpopup_overlap").html("");
	$.ajax({
		type: "POST",
		url: baseURL+'loadExtraCharges',
		data: "shipment_id="+shipment_id,
		success: function (response) {
			$(".displaycontentpopup_overlap").html(response);
		}
	});
}

function loadSalesPerson(){
	$(".displaycontentpopup").html("");
	 $.ajax({
		type: "POST",
		url: baseURL+'checkCustomerpopup',
		data: "is_sales=1",
		success: function (response) {
			$(".displaycontentpopup").html(response);
		  
		}
	});
}

function loadConsignee(){
	$(".displaycontentpopup").html("");
	 $.ajax({
		type: "POST",
		url: baseURL+'checkCustomerpopup',
		data: "is_consignee=1",
		success: function (response) {
		$(".displaycontentpopup").html(response);
		  
		}
	});
}

function loadBillto(){
	$(".displaycontentpopup").html("");
	 $.ajax({
		type: "POST",
		url: baseURL+'checkCustomerpopup',
		data: "is_bill_to=1",
		success: function (response) {
		$(".displaycontentpopup").html(response);
		  
		}
	});
}

function changeBilltoData(checid){
	if(checid == 1){
		var aid = $('#org_s_shipper_id').val();
		if(aid) {
			$('#org_b_shipper_id').val(aid);
			changebilltodetails();
		} 
	}else if(checid == 2){
		var aid = $('#org_c_shipper_id').val();
		if(aid) {
			$('#org_b_shipper_id').val(aid);
			changebilltodetails();
		} 
	}
}

function changeshipperdetails(){
	var aid = $('#org_s_shipper_id').val();
    if(aid) {
	
		 $.ajax({
			url: baseURL+'getCustomerData/'+aid,
			type: "GET",
			dataType: "json",
			success:function(data) {
				$('#shipper_name').val(data.customer_name);
				$('#s_address_1').val(data.c_address_1);
				$('#s_address_2').val(data.c_address_2);
				$('#s_city').val(data.c_city);
				$('#s_zip').val(data.c_zip);
				$('#s_country').val(data.c_country);
				
				$('#s_default_ref').val(data.c_default_ref);
				$('#s_def_ref_type').val(data.c_def_ref_type);
				$('#s_contact').val(data.c_contact);
				$('#s_email').val(data.c_email);
				$('#s_phone').val(data.c_phone);
				$('#s_fax').val(data.c_fax);
				$('#origin_airport').val(data.airport_code);
				$('#origin_airport_id').val(data.airport_id);
				
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
						
						var statename = $( "#s_state option:selected" ).text();
						var countrname = $( "#s_country option:selected" ).text();
						
						$('#shipper_address_url').attr('href', 'https://www.google.com/maps/search/?api=1&query='+data.c_address_1+','+data.c_city+','+statename+','+countrname);
						$('#shipper_address_url').attr('target', '_blank');
                    }
                });
				
				
				
			}
		});	
	}
}

function changecosigneedetails(){
	var aid = $('#org_c_shipper_id').val();
    if(aid) {
	
		 $.ajax({
			url: baseURL+'getCustomerData/'+aid,
			type: "GET",
			dataType: "json",
			success:function(data) {
				$('#c_shipper_name').val(data.customer_name);
				$('#c_address_1').val(data.c_address_1);
				$('#c_address_2').val(data.c_address_2);
				$('#c_city').val(data.c_city);
				$('#c_zip').val(data.c_zip);
				$('#c_country').val(data.c_country);
				
				$('#c_default_ref').val(data.c_default_ref);
				$('#c_def_ref_type').val(data.c_def_ref_type);
				$('#c_contact').val(data.c_contact);
				$('#c_email').val(data.c_email);
				$('#c_phone').val(data.c_phone);
				$('#c_fax').val(data.c_fax);
				
				$('#dest_airport').val(data.airport_code);
				$('#dest_airport_id').val(data.airport_id);
				
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
						
						var statename = $( "#c_state option:selected" ).text();
						var countrname = $( "#c_country option:selected" ).text();
						
						$('#consignee_address_url').attr('href', 'https://www.google.com/maps/search/?api=1&query='+data.c_address_1+','+data.c_city+','+statename+','+countrname);
						$('#consignee_address_url').attr('target', '_blank');
                    }
                });
				
				
			}
		});	
	}
}

function changebilltodetails(){
	var aid = $('#org_b_shipper_id').val();
    if(aid) {
	
		 $.ajax({
			url: baseURL+'getCustomerData/'+aid,
			type: "GET",
			dataType: "json",
			success:function(data) {
				var address1 = data.c_address_1;
				var address2 = data.c_address_2;
				var c_city = data.c_city;
				var c_zip = data.c_zip;
				var c_country = data.c_country;
				var c_email = data.c_email;
				var c_phone = data.c_phone;
				var c_fax = data.c_fax;
					
				if(data.r_address_1 != ''){var address1 = data.r_address_1;}
				
				if(data.r_address_2 != ''){
					var address2 = data.r_address_2;
				}else{
					var address2 = '';
				}
				if(data.r_city != ''){var c_city = data.r_city;}
				if(data.r_zip != ''){var c_zip = data.r_zip;}
				if(data.r_country != ''){var c_country = data.r_country;}
				if(data.r_email != ''){var c_email = data.r_email;}
				if(data.r_phone != ''){var c_phone = data.r_phone;}
				if(data.r_fax != ''){var c_fax = data.r_fax;}
				
				$('#b_shipper_id').val(data.customer_number);
				$('#b_shipper_name').val(data.customer_name);
				$('#b_address_1').val(address1);
				$('#b_address_2').val(address2);
				$('#b_city').val(c_city);
				$('#b_zip').val(c_zip);
				$('#b_country').val(c_country);
				
				$('#b_default_ref').val(data.c_default_ref);
				$('#b_def_ref_type').val(data.c_def_ref_type);
				$('#b_contact').val(data.c_contact);
				$('#b_email').val(c_email);
				$('#b_phone').val(c_phone);
				$('#b_fax').val(c_fax);
				
				$.ajax({
                    url: baseURL+'statecheck/'+c_country,
                    type: "GET",
                    dataType: "json",
                    success:function(datas) {
                        $('#b_state').empty();
                        $.each(datas, function(key, value) {
                            $('#b_state').append('<option value="'+ value.state_id +'">'+ value.state_name +'</option>');
                        });
						$('#b_state').val(data.c_state);
						
						var statename = $( "#b_state option:selected" ).text();
						var countrname = $( "#b_country option:selected" ).text();
						
						$('#billto_address_url').attr('href', 'https://www.google.com/maps/search/?api=1&query='+data.c_address_1+','+data.c_city+','+statename+','+countrname);
						$('#billto_address_url').attr('target', '_blank');
                    }
                });
				
				
			}
		});	
	}
}

function chooseCustomerType(cid, cnumber, cname){
	var is_shipper = $('#is_shipper').val();
	var is_bill_to = $('#is_bill_to').val();
	var is_consignee = $('#is_consignee').val();
	var is_sales = $('#is_sales').val();
	if(is_shipper == 1){
		$('#org_s_shipper_id').val(cid);
		$('#s_shipper_id').val(cnumber);
		changeshipperdetails();
	}else if(is_bill_to == 1){
		$('#org_b_shipper_id').val(cid);
		$('#b_shipper_id').val(cnumber);
		changebilltodetails();
	}else if(is_consignee == 1){
		$('#org_c_shipper_id').val(cid);
		$('#c_shipper_id').val(cnumber);
		changecosigneedetails();
	}else if(is_sales == 1){
		$('#sales_person').val(cid);
		$('#sales_person_name').val(cname);
	}
	$('#myModal').modal('toggle');
}

function chooseVendor(mainid, subid, parentid, cid, cnumber, cname, filnum, ev){
	
	$('#'+parentid+' #'+mainid).val(cnumber);
	$('#'+parentid+' #'+subid).val(cid);
	
	var datatitle = $(ev).attr('data-title');
	$('#'+parentid+' #'+mainid).attr('data-original-title' , datatitle);
	
	if(subid == 'p_vendor_id'){
		
		$('#addVendorShipment #v_account').val(filnum);
		
		$('#addVendorShipment #v_airline').val(cname);
		
		$('#addVendorShipment #carrier_name_1, #addVendorShipment #carrier_name_2').val(cname);
		$('#addVendorShipment #carrier_id_1, #addVendorShipment #carrier_id_2').val(cid);
	}
	
	$('#myModaloverlap').modal('toggle');
	
}

function chooseAirport(cid, cnumber, mainid, subid, parentid){
	
	$('#'+parentid+' #'+mainid).val(cnumber);
	$('#'+parentid+' #'+subid).val(cid);
	
	if(subid == 'v_origin_id'){
				
		$('#addVendorShipment #flight_origin_1, #addVendorShipment #flight_origin_2').val(cnumber);
		$('#addVendorShipment #flight_origin_id_1, #addVendorShipment #flight_origin_id_2').val(cid);
	}
	
	$('#myModaloverlap').modal('toggle');
}

function chooseChargeCode(cid, ccode, cidname, cdesc){
	
	$('#'+cidname+' #charge_code_name').val(ccode);
	$('#'+cidname+' #charge_code_id').val(cid);
	$('#'+cidname).closest('td').next().find('#charge_code_description').val(cdesc);
	
	$('#myModal').modal('toggle');
}

function chooseExtraChargeCode(cid, ccode, cidname, cdesc){
	
	$('#'+cidname+' #charge_code_name').val(ccode);
	$('#'+cidname+' #charge_code_id').val(cid);
	$('#'+cidname).closest('td').next().find('#charge_code_description').val(cdesc);
	
	$('#myModaloverlap2').modal('toggle');
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
function cloneFreight(){
	var numItems = $('.org_freight_div .freight_demo_tr').length;
	
	if(numItems <= 5){
		var oTpl = $('#freight_div_holder .freight_demo_tr').clone();
		$('#freight_total_div').before(oTpl);
	}else{
		alert('Maxmimum Limit Reached!');
	}
	
	$('.org_freight_div .freight_demo_name_div').each(function(index, value) {
		
		//console.log(index+'--'+value);
		//console.log(this.id);
		$(this).attr('id' , 'freight_div_name_'+index);
	});
	
	$('.org_freight_div .freight_haz_div').each(function(index, value) {
		$(this).attr('name' , 'freight[haz]['+index+']');
	});
}

function cloneChargeCode(){
	var numItems = $('.chargecode_demo_tr').length;
	if(numItems < 10){
		var oTpl = $('#freight_div_holder .chargecode_demo_tr').clone();
		$('#chargecode_total_div').before(oTpl);
	}else{
		alert('Maxmimum Limit Reached!');
	}
	
	$('#chargecode_total_div').show();
	
	$('.chargecode_div .charge_code_name_div').each(function(index, value) {
		
		//console.log(index+'--'+value);
		//console.log(this.id);
		$(this).attr('id' , 'charge_code_name_'+index);
	});
	
	$('.chargecode_div .charge_demo_name_div').each(function(index, value) {
		$(this).attr('id' , 'charge_div_name_'+index);
	});
}

function cloneExtraChargeCode(){
	var numItems = $('.extrachargecode_demo_tr').length;
	if(numItems < 10){
		var oTpl = $('#extracharge_freight_div_holder .extrachargecode_demo_tr').clone();
		$('#extrachargecode_total_div').before(oTpl);
	}else{
		alert('Maxmimum Limit Reached!');
	}
	
	$('#extrachargecode_total_div').show();
	
	$('.extrachargecode_div .charge_code_name_div').each(function(index, value) {
		$(this).attr('id' , 'charge_code_name_'+index);
	});
	$('.extrachargecode_div .extracharge_demo_name_div').each(function(index, value) {
		$(this).attr('id' , 'extracharge_div_name_'+index);
	});
}

function removeNewFreight(oObj)
{
	var numItems = $('.freight_demo_tr').length;
	if(numItems <= 1){
		alert("You can't Delete! Minimum one freight information required!");
	}else{
		$(oObj).parents('.freight_demo_tr').remove(); 
	}
	
	$('.org_freight_div .freight_demo_name_div').each(function(index, value) {
		$(this).attr('id' , 'freight_div_name_'+index);
	});
	
	$('.org_freight_div .freight_haz_div').each(function(index, value) {
		$(this).attr('name' , 'freight[haz]['+index+']');
	});
	
	addTotalWeight();
	addTotalPiece(); 
}

function removeNewChargeCode(oObj)
{
	var numItems = $('.chargecode_div .charge_code_name_div').length;
	
	$(oObj).parents('.chargecode_demo_tr').remove(); 
	
	if(numItems <= 1){
		$('#chargecode_total_div').hide();
	}
	
}
function removeNewExtraChargeCode(oObj)
{
	var numItems = $('.extrachargecode_div .charge_code_name_div').length;
	
	$(oObj).parents('.extrachargecode_demo_tr').remove(); 
	
	if(numItems <= 1){
		$('#extrachargecode_total_div').hide();
	}
	
}


function addChargeCode(){
	var shipment_id = $('#shipment_id').val();
	dataString =$(".chargecode_div").find("select, textarea, input").serialize()+ "&charge_code[shipment_id]=" + shipment_id;

	$.ajax({
		type: "POST",
		url: baseURL+"addChargeCode",
		data: dataString,
		success: function(data){
			$("#resultChargedata").html(data.message); 
			
			if(data.status == 'error'){
				$("#resultChargedata").addClass("alert alert-danger");
			}else{
				$("#resultChargedata").addClass("alert alert-success");
			}
			if(data.status == 'success'){
				setTimeout(function(){  
					//location.reload();
					loadSelectedChargeCodes(shipment_id);
				}, 1000); 
			}
		}
	});
}

function addExtraChargeCode(){
	var shipment_id = $('#shipment_id').val();
	dataString =$(".extrachargecode_div").find("select, textarea, input").serialize()+ "&extracharge_code[shipment_id]=" + shipment_id;

	$.ajax({
		type: "POST",
		url: baseURL+"addExtraChargeCode",
		data: dataString,
		success: function(data){
			$("#resultextraChargedata").html(data.message); 
			
			if(data.status == 'error'){
				$("#resultextraChargedata").addClass("alert alert-danger");
			}else{
				$("#resultextraChargedata").addClass("alert alert-success");
			}
			if(data.status == 'success'){
				setTimeout(function(){  
					//location.reload();
					loadSelectedExtraChargeCodes(shipment_id);
				}, 1000); 
			}
		}
	});
}

function addDimFactor(ev){
	var attid = $(ev).closest('tr').attr('id');
	
	if(attid == 'undefined'){
		attid = 'freight_div_name_0';
	}
	
	var trpieces = $('#'+attid+ ' #pieces').val();
	var trlength = $('#'+attid+ ' #length').val();
	var trwidth = $('#'+attid+ ' #width').val();
	var trheight = $('#'+attid+ ' #height').val();
	var trdim_factor = $('#'+attid+ ' #dim_factor').val();
	if(trdim_factor == '' || trdim_factor == 0){
		trdim_factor = 194;
	}
	if(trpieces != '' && trlength != '' && trwidth !='' && trheight != ''){
		var totdimweight = (parseInt(trpieces) * parseInt(trlength) * parseInt(trwidth) * parseInt(trheight)) /trdim_factor;
		
		$('#'+attid+ ' #t_dim_weight').val(totdimweight.toFixed(2));
	}
	
	addTotalDimWeight();
}

function toggleshippingTrader(){

	$('.shipper_trader_div').toggleClass('hide');
	
	if ($(".shipper_trader_div").hasClass("hide")) {
		$('#shipper_trade_show').val(0);
		$('.shipper_trade').val('');
	}else{
		$('#shipper_trade_show').val(1);
	}
	
}
function toggleConsigneeTrader(){

	$('.consignee_trader_div').toggleClass('hide');
	
	if ($(".consignee_trader_div").hasClass("hide")) {
		$('#consignee_trade_show').val(0);
		$('.consignee_trade').val('');
	}else{
		$('#consignee_trade_show').val(1);
	}
	
}

function loadSpecialInstructions(sid){
	$(".displaycontentpopup").html("");
	 $.ajax({
		type: "POST",
		url: baseURL+'loadSpecialInstructions',
		data: "sid="+sid,
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
	var shipment_id = $('#shipment_id').val();
	
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
			shipment_id:shipment_id,
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

function loadSelectedChargeCodes(id){
	$.ajax({
		type: "POST",
		url: baseURL+'loadSelectedChargeCodes',
		data: {
			shipment_id:id,
		},
		success: function (response) {
			$(".chargecode_div").html(response);
		}
	});

}

function loadSelectedExtraChargeCodes(id){
	$.ajax({
		type: "POST",
		url: baseURL+'loadSelectedExtraChargeCodes',
		data: {
			shipment_id:id,
		},
		success: function (response) {
			$(".extrachargecode_div").html(response);
			calculateextraChargeCode();
			$('#myModaloverlap').modal('toggle');
		}
	});

}

function removeVendorType(dom_id){
	var confirmation = confirm("Are you sure to remove this vendor type ?");
	if(confirmation)
	{
		jQuery.ajax({
		type : "POST",
		dataType : "json",
		url : baseURL + "removeVendorType",
		data : { dom_id : dom_id } 
		}).done(function(data){
			console.log(data);
			
			if(data.status = true) { 
				alert("Vendor successfully deleted"); 
				$('#vendor_div_'+dom_id).remove();
			}
			else if(data.status = false) { alert("Vendor deletion failed"); }
			else { alert("Access denied..!"); }
		});
	}
}

function removeChargeCode(pid){
	var confirmation = confirm("Are you sure to remove this charge code ?");
	if(confirmation)
	{
		jQuery.ajax({
		type : "POST",
		dataType : "json",
		url : baseURL + "removeChargeCode",
		data : { pid : pid } 
		}).done(function(data){
			console.log(data);
			
			if(data.status = true) { 
				alert("Charge Code successfully deleted"); 
				$('#charge_code_'+pid).remove();
				calculateChargeCode();
			}
			else if(data.status = false) { alert("Charge Code deletion failed"); }
			else { alert("Access denied..!"); }
		});
	}
}

function removeExtraChargeCode(pid){
	var confirmation = confirm("Are you sure to remove this charge code ?");
	if(confirmation)
	{
		jQuery.ajax({
		type : "POST",
		dataType : "json",
		url : baseURL + "removeExtraChargeCode",
		data : { pid : pid } 
		}).done(function(data){
			console.log(data);
			
			if(data.status = true) { 
				alert("Charge Code successfully deleted"); 
				$('#extracharge_code_'+pid).remove();
				calculateChargeCode();
			}
			else if(data.status = false) { alert("Charge Code deletion failed"); }
			else { alert("Access denied..!"); }
		});
	}
}

function calculateChargeCode(){
	var totalchargecost = 0;
	$('.charge_code_total_cost').each(function() {
		var curval =  this.value;
		if(curval != ''){
			totalchargecost = parseInt(totalchargecost) + parseInt(curval);
		}
	});
	$('#total_charge_code_cost').html(totalchargecost);

}
function calculateextraChargeCode(){
	var totalchargecost = 0;
	$('.extracharge_code_total_cost').each(function() {
		var curval =  this.value;
		if(curval != ''){
			totalchargecost = parseInt(totalchargecost) + parseInt(curval);
		}
	});
	$('#total_extracharge_code_cost').html(totalchargecost);
	$('#p_extra_front').val(totalchargecost);
	$('#p_extra').val(totalchargecost);
	changeVendorPrices();

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

function changeExtrachargePrices(ev){

	var attid = $(ev).closest('tr').attr('id');
	
	if(attid == 'undefined'){
		attid = 'extracharge_div_name_0';
	}
	
	var p_qty = $('#'+attid+' #charge_code_qty').val();
	var p_rate = $('#'+attid+' #charge_code_rate').val();
	var p_cost = $('#'+attid+' #charge_code_charge').val();
	
	if(p_qty == ''){p_qty =0;}
	if(p_rate == ''){p_rate =0;}
	if(p_cost == ''){p_cost =0;}

	
	var totalprice = 0;
	if(p_rate != '' && p_rate != 0 && p_rate != '0.00'){
		totalprice = parseFloat(p_qty * p_rate);
	}
	
	if(p_cost != '' && p_cost != 0 && p_cost != '0.00'){
		totalprice = parseFloat(p_cost);
	}
	
	$('#'+attid+ ' #charge_code_total_cost').val(totalprice.toFixed(2));
	
}

function changechargePrices(ev){

	var attid = $(ev).closest('tr').attr('id');
	
	if(attid == 'undefined'){
		attid = 'charge_div_name_0';
	}
	
	var p_qty = $('#'+attid+' #charge_code_qty').val();
	var p_rate = $('#'+attid+' #charge_code_rate').val();
	var p_cost = $('#'+attid+' #charge_code_charge').val();
	
	if(p_qty == ''){p_qty =0;}
	if(p_rate == ''){p_rate =0;}
	if(p_cost == ''){p_cost =0;}

	
	var totalprice = 0;
	if(p_rate != '' && p_rate != 0 && p_rate != '0.00'){
		totalprice = parseFloat(p_qty * p_rate);
	}
	
	if(p_cost != '' && p_cost != 0 && p_cost != '0.00'){
		totalprice = parseFloat(p_cost);
	}
	
	$('#'+attid+ ' #charge_code_total_cost').val(totalprice.toFixed(2));
	
}

function loadTransferAlert(evid){
	$(".displaycontentpopup_overlap").html("");
	 $.ajax({
		type: "POST",
		url: baseURL+'loadTransferAlert',
		data: "shipment_id="+evid,
		success: function (response) {
			$(".displaycontentpopup_overlap").html(response);
		}
	});
}

function loadRoutingAlert(evid){
	$(".displaycontentpopup").html("");
	 $.ajax({
		type: "POST",
		url: baseURL+'loadRoutingAlert',
		data: "shipment_id="+evid,
		success: function (response) {
			$(".displaycontentpopup").html(response);
		}
	});
}

function changeTransferData(from, type, shipmentid, parentid){
	
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
						$('#'+parentid+' #t_id').val(data.customer_id);
						$('#'+parentid+' #t_name').val(data.customer_name);
						$('#'+parentid+' #t_address_1').val(data.s_address_1);
						$('#'+parentid+' #t_address_2').val(data.s_address_2);
						$('#'+parentid+' #t_city').val(data.s_city);
						$('#'+parentid+' #t_zip').val(data.s_zip);
						$('#'+parentid+' #t_country').val(data.s_country);
						
						$('#'+parentid+' #t_default_ref').val(data.s_default_ref);
						$('#'+parentid+' #t_contact').val(data.s_contact);
						$('#'+parentid+' #t_phone').val(data.s_phone);
						
						$.ajax({
							url: baseURL+'statecheck/'+data.s_country,
							type: "GET",
							dataType: "json",
							success:function(datas) {
								$('#'+parentid+' #t_state').empty();
								$.each(datas, function(key, value) {
									$('#'+parentid+' #t_state').append('<option value="'+ value.state_id +'">'+ value.state_name +'</option>');
								});
								$('#'+parentid+' #t_state').val(data.s_state);
								
							}
						});
						
					}else{
						$('#'+parentid+' #t_id').val(data.customer_id);
						$('#'+parentid+' #t_name').val(data.customer_name);
						$('#'+parentid+' #t_address_1').val(data.c_address_1);
						$('#'+parentid+' #t_address_2').val(data.c_address_2);
						$('#'+parentid+' #t_city').val(data.c_city);
						$('#'+parentid+' #t_zip').val(data.c_zip);
						$('#'+parentid+' #t_country').val(data.c_country);
						
						$('#'+parentid+' #t_default_ref').val(data.c_default_ref);
						$('#'+parentid+' #t_contact').val(data.c_contact);
						$('#'+parentid+' #t_phone').val(data.c_phone);
						
						$.ajax({
							url: baseURL+'statecheck/'+data.c_country,
							type: "GET",
							dataType: "json",
							success:function(datas) {
								$('#'+parentid+' #t_state').empty();
								$.each(datas, function(key, value) {
									$('#'+parentid+' #t_state').append('<option value="'+ value.state_id +'">'+ value.state_name +'</option>');
								});
								$('#'+parentid+' #t_state').val(data.c_state);
								
							}
						});
					}

				}else{
					if(data.s_shipper_id != 'undefined' && data.s_shipper_id != undefined){
						$('#'+parentid+' #r_id').val(data.customer_id);
						$('#'+parentid+' #r_name').val(data.customer_name);
						$('#'+parentid+' #r_address_1').val(data.s_address_1);
						$('#'+parentid+' #r_address_2').val(data.s_address_2);
						$('#'+parentid+' #r_city').val(data.s_city);
						$('#'+parentid+' #r_zip').val(data.s_zip);
						$('#'+parentid+' #r_country').val(data.s_country);
						
						$('#'+parentid+' #r_default_ref').val(data.s_default_ref);
						$('#'+parentid+' #r_contact').val(data.s_contact);
						$('#'+parentid+' #r_phone').val(data.s_phone);
						
						$.ajax({
							url: baseURL+'statecheck/'+data.s_country,
							type: "GET",
							dataType: "json",
							success:function(datas) {
								$('#'+parentid+' #r_state').empty();
								$.each(datas, function(key, value) {
									$('#'+parentid+' #r_state').append('<option value="'+ value.state_id +'">'+ value.state_name +'</option>');
								});
								$('#'+parentid+' #r_state').val(data.s_state);
								
							}
						});
						
						
					}else{
						$('#'+parentid+' #r_id').val(data.customer_id);
						$('#'+parentid+' #r_name').val(data.customer_name);
						$('#'+parentid+' #r_address_1').val(data.c_address_1);
						$('#'+parentid+' #r_address_2').val(data.c_address_2);
						$('#'+parentid+' #r_city').val(data.c_city);
						$('#'+parentid+' #r_zip').val(data.c_zip);
						$('#'+parentid+' #r_country').val(data.c_country);
						
						$('#'+parentid+' #r_default_ref').val(data.c_default_ref);
						$('#'+parentid+' #r_contact').val(data.c_contact);
						$('#'+parentid+' #r_phone').val(data.c_phone);
						
						$.ajax({
							url: baseURL+'statecheck/'+data.c_country,
							type: "GET",
							dataType: "json",
							success:function(datas) {
								$('#'+parentid+' #r_state').empty();
								$.each(datas, function(key, value) {
									$('#'+parentid+' #r_state').append('<option value="'+ value.state_id +'">'+ value.state_name +'</option>');
								});
								$('#'+parentid+' #r_state').val(data.c_state);
								
							}
						});
					}
				}
			
		}
	});	
}

function deleteTransferAlert(shipid){
	var hitURL = baseURL + "deleteTransferAlert";
		
	var confirmation = confirm("Are you sure to delete?");
	
	if(confirmation)
	{
		jQuery.ajax({
		type : "POST",
		dataType : "json",
		url : hitURL,
		data : { shipid : shipid } 
		}).done(function(data){
			console.log(data);
			if(data.status = true) { 
				alert("Transfer Data successfully deleted"); 
				loadTransferAlert(shipid);
			}
			else if(data.status = false) { alert("Transfer Data deletion failed"); }
			else { alert("Access denied..!"); }
		});
	}
}

function deleteRoutingAlert(shipid){
	var hitURL = baseURL + "deleteRoutingAlert";
		
	var confirmation = confirm("Are you sure to delete?");
	
	if(confirmation)
	{
		jQuery.ajax({
		type : "POST",
		dataType : "json",
		url : hitURL,
		data : { shipid : shipid } 
		}).done(function(data){
			console.log(data);
			if(data.status = true) { 
				alert("Routing Data successfully deleted"); 
				loadRoutingAlert(shipid);
			}
			else if(data.status = false) { alert("Routing Data deletion failed"); }
			else { alert("Access denied..!"); }
		});
	}
} 