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

	$(document).find(".deletethis").on("click",function(){
		var conf = confirm("Are you sure you want to delete this?");

		if (!conf) {
			return;
		}

		var id  = $(this).data("id");
		var tbl = $(this).data("table");

		$.ajax({
			url 	 : url+"/delete",
			type     : "POST",
			data     : { id : id, table : tbl  },
			dataType : "json",
			success  : function(data){
				Alert("deleted");
				window.location.reload();
			}, error : function(){
				alert("error deleting")
			}
		})
	})

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

	$(document).find("#status").on("change", function(){
		var selected = $(this).val();

		if (selected < 49) {
			$(document).find("#daterelease").hide();
			$(document).find(".ocdate").hide();
			$(document).find("#inprocurement").hide();
		}

		if (selected >= 50) {
			$(document).find("#daterelease").show();

			$(document).find(".ocdate").hide();
			$(document).find("#inprocurement").hide();
		}

		if (selected >= 75) {
			$(document).find("#daterelease").show();
			$(document).find(".ocdate").show();

			$(document).find("#inprocurement").hide();
		}

		if (selected == 100) {
			$(document).find("#daterelease").show();
			$(document).find(".ocdate").show();
			$(document).find("#inprocurement").show();
		}
	});
})