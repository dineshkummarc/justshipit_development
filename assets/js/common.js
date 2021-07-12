/**
 * @author Kishor Mali
 */


jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteUser", function(){
		var userId = $(this).data("userid"),
			hitURL = baseURL + "deleteUser",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this user ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { userId : userId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("User successfully deleted"); }
				else if(data.status = false) { alert("User deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	
	jQuery(document).on("click", ".deleteCustomer", function(){
		var customerid = $(this).data("customerid"),
			hitURL = baseURL + "deleteCustomer",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this customer ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { customerid : customerid } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Customer successfully deleted"); }
				else if(data.status = false) { alert("Customer deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	
	jQuery(document).on("click", ".deleteDomesticShipment", function(){
		var shipment_id = $(this).data("shipment_id"),
			hitURL = baseURL + "deleteDomesticShipment",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this customer ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { shipment_id : shipment_id } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Shipment successfully deleted"); }
				else if(data.status = false) { alert("Shipment deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	
	
	jQuery(document).on("click", ".searchList", function(){
		
	});
	
	jQuery(document).on("click", ".deleteAirport", function(){
		var airport_id = $(this).data("airport_id"),
			hitURL = baseURL + "deleteAirport",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this airport ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { airport_id : airport_id } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Airport successfully deleted"); }
				else if(data.status = false) { alert("Airport deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	
	
	jQuery('.com_country').on('change', function() {
            var countryId = $(this).val();
            var parentid = $(this).attr("data-parentid") ;
            if(countryId) {
                $.ajax({
                    url: baseURL+'statecheck/'+countryId,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $(parentid+' .com_state').empty();
                        $.each(data, function(key, value) {
                            $(parentid+' .com_state').append('<option value="'+ value.state_id +'">'+ value.state_name +'</option>');
                        });
                    }
                });
            }else{
                $(parentid+' .com_state').empty();
            }
        });
	
});
