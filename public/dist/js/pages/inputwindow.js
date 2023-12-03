$(function(){

	var values  = new Object();
	
	$(document).find("#addcharging__").on("click", function(){
		var chargewhat   = $("#whattocharge :selected").text();
		var chargewhatid = $("#whattocharge").val();

		var amount 		 = $("#chargeamount").val();
		
		var chargeto  	 = $("#charging :selected").text();
		var chargetoid   = $("#charging").val();

		var grpid        = $(this).data("grpid");
		var actualcost   = $("#chargeamount").val();

        var chargetype 	 = 1;

		$.ajax({
			url 	 : url+"/savecharging",
			type     : "post",
			data     : { activitygrpid : grpid, 
						 chargeto : chargetoid, 
						 actualcost : actualcost , 
						 chargewhat : chargewhatid , 
						 chargetype : chargetype },
			dataType : "html",
			success  : function(actualcost) {
				$("<p class='m-0'> <i class='fa fa-times' aria-hidden='true' ></i> "+
		 		  "<strong>"+chargewhat+"</strong> with an amount of <strong>"+actualcost+
		 		  " PHp</strong> is charge to <strong>"+chargeto+"</strong></p>")
				.on("click",function(){

				}).appendTo("#chargewindow");
			}, error : function() {
				alert("error");	
			}
		})

	});

	$(document).find("#savebtn").on("click",function(){
		// activitytitle
		// initialcost
		// dateofactivity
		// status

		// daterelease	
		// daterecvdbyoc
		// datereleasedbyoc
		// datercvdbyproc

		
	});
})