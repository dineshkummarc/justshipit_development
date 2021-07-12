
$(document).ready(function(){
	
	var editCustomerForm = $("#editCustomer");
	
	var validator = editCustomerForm.validate({
		
		rules:{
			customer_name :{ required : true },
			c_address_1 :{ required : true },
			c_city :{ required : true },
			//c_email : { required : true, email : true, remote : { url : baseURL + "checkCustomerEmailExists", type :"post", data : { customer_id : function(){ return $("#customer_id").val(); } } } },
			//c_phone : { required : true, digits : true },
			c_country : { required : true, selected : true}
		},
		messages:{
			customer_name :{ required : "This field is required" },
			c_address_1 :{ required : "This field is required" },
			c_city :{ required : "This field is required" },
			//c_email : { required : "This field is required", email : "Please enter valid email address", remote : "Email already taken" },
			//c_phone : { required : "This field is required", digits : "Please enter numbers only" },
			c_country : { required : "This field is required", selected : "Please select country option" }			
		}
	});
	
	$( ".datepicker" ).datepicker(
		{ 
			dateFormat: 'dd-mm-yy' 
		}
	);
	
	$( ".dateonlypicker" ).datetimepicker({
		format: 'm/d/Y',
		formatDate: 'm/d/Y',
		timepicker: false,
		datepicker: true,
		yearStart: 2021,
		startDate:new Date(),
	});
	
	jQuery(document).on("click", "#same_address", function(){
	
		if($(this).is(':checked')){
			$('.secondary_address').hide('slow');
			$('#r_name').val($('#customer_name').val());
			$('#r_address_1').val($('#c_address_1').val());
			$('#r_address_2').val($('#c_address_2').val());
			$('#r_city').val($('#c_city').val());
			$('#r_state').val($('#c_state').val());
			$('#r_zip').val($('#c_zip').val());
			$('#r_country').val($('#c_country').val());
			$('#r_phone').val($('#c_phone').val());
			$('#r_fax').val($('#c_fax').val());
			$('#r_email').val($('#c_email').val());
		}else{
			$('.remit_data').val('');
			$('.secondary_address').show('slow');
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
		
		$('#r_country').on('change', function() {
            var countryId = $(this).val();
            if(countryId) {
                $.ajax({
                    url: baseURL+'statecheck/'+countryId,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('#r_state').empty();
                        $.each(data, function(key, value) {
                            $('#r_state').append('<option value="'+ value.state_id +'">'+ value.state_name +'</option>');
                        });
                    }
                });
            }else{
                $('#r_state').empty();
            }
        }); 
		
		$( "#default_airport_name" ).autocomplete({
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
			  $('#default_airport_name').val(ui.item.airport_code);
			  $('#default_airport_code').val(ui.item.airport_id);
			  return false;
			}
      }); 
	
});

function loadBilltoPerson(){
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

function chooseCustomerType(cid, cnumber, cname){
	var is_shipper = $('.input-group #is_shipper').val();
	var is_bill_to = $('.input-group #is_bill_to').val();
	var is_consignee = $('.input-group #is_consignee').val();
	var is_sales = $('.input-group #is_sales').val();
	if(is_bill_to == 1){
		$('#bill_customer_number').val(cid);
		$('#bill_customer_name').val(cname);
	}else if(is_sales == 1){
		$('#sales_person').val(cid);
		$('#sales_person_name').val(cname);
	}
	$('#myModal').modal('toggle');
}

function loadFlightOrigin(mainid, subid, atype, parentid){
	if(atype == 'all'){
		var searchTextPop = '';
	}else{
		var searchTextPop = $('#searchTextPop').val();
	}
	var countryId = $('#c_country').val();
	
	$(".displaycontentpopup_overlap").html("");
	$.ajax({
		type: "POST",
		url: baseURL+'loadAirports',
		data: {
			search:searchTextPop,
			mainid:mainid,
			subid:subid,
			parentid:parentid,
			country_id:countryId,
		},
		success: function (response) {
			$(".displaycontentpopup_overlap").html(response);
		}
	});
}
function chooseAirport(cid, cnumber, mainid, subid, parentid){
	
	$('#'+parentid+' #'+mainid).val(cnumber);
	$('#'+parentid+' #'+subid).val(cid);
	
	$('#myModaloverlap').modal('toggle');
}

function changeCategoryData(ctype){
	$('.add_airport_code_icon, .extra_airport_code').show();
	if(ctype == 3){
		$('.customer_option').show();
		$('.vendor_option').show();
	}else if(ctype == 1){
		$('.customer_option').show();
		
		$('.vendor_option').hide();
		$('.add_airport_code_icon, .extra_airport_code').hide();
		$('.vendor_option').find('input').prop('checked', false); 
	}else{
		$('.vendor_option').show();
		
		$('.customer_option').hide();
		$('.customer_option').find('input').prop('checked', false); 
	}
}

function cloneAirportCode(){
	var numItems = $('.airport_demo_tr').length;
	if(numItems < 6){
		var oTpl = $('#vendor_airport_div .airport_demo_tr').clone();
		$('.extra_airport_code').append(oTpl);
	}else{
		alert('Maxmimum Limit Reached!');
	}
		
	$('.extra_airport_code .airport_demo_tr .airport_name_container').each(function(index, value) {
		$(this).attr('id' , 'default_airport_name_'+index);
		$(this).attr('data-id' , index);
	});
	
	$('.extra_airport_code .airport_demo_tr .airport_id_container').each(function(index, value) {
		$(this).attr('id' , 'default_airport_code_'+index);
		$(this).attr('data-id' , index);
	});
	
	$('.extra_airport_code .airport_demo_tr .airport_click_container').each(function(index, value) {
		$(this).attr('onclick' , "loadFlightOrigin('default_airport_name_"+index+"', 'default_airport_code_"+index+"', 'all','airportab' );");
	});
	resetAirportContainer();
}

function removeNewAirport(oObj){
	$(oObj).parents('.airport_demo_tr').remove(); 
}

function resetAirportContainer(){
	$( ".airport_name_container" ).autocomplete({
		source: function( request, response ) {
		  // Fetch data
		  var countryId = $('#c_country').val();
		  
		  $.ajax({
			url: baseURL+'checkairportCode',
			type: 'post',
			dataType: "json",
			data: {
			  search: request.term,
			  country_id:countryId
			},
			success: function( datas ) {
			  response( datas );
			}
		  });
		},
		select: function (event, ui) {
		  var dataid = $(this).attr('data-id');
		  $('#default_airport_name_'+dataid).val(ui.item.airport_code);
		  $('#default_airport_code_'+dataid).val(ui.item.airport_id);
		  return false;
		}
  }); 
}