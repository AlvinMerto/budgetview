<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Application for Leave</title>

		   @include("scripts.headscripts")
<style>
	.thedates {
		background:#ccc;
		padding:5px;
		border-radius: 3px;
		margin-right: 5px;
	}

	#dateselected {
		margin-top:5px;
	}
</style>

	</head>
<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

    <!-- Preloader -->

  @include("navigation_top")

  @include("navigation_left")

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
        	<div class="row">
        		<div class="col-md-7">
		        	<div class="card">
		        		<form method="post" action="{{route('postsaveleave')}}">
		        			@csrf
		        		<input type="hidden" id="selecteddates" name="selecteddates"/>
			        		<div class="card-header">
			        			<h4 class="card-title"> Application for Leave </h4>
			        		</div>
			        		<div class="card-body">
					        	<div class="form-group">
				        			<label> Name: </label>
				        			<p> <?php echo $ownername; ?> </p>
				        			<input type='hidden' value="<?php echo $ownerid; ?>" name="userid"/>
					        	</div>
				        		<div class="form-group">
				        			<label> Dates </label>
				        			<input type="date" id = "leavedate" class="form-control"/>
				        			<div id="dateselected">
				        				<?php
				        					if ($update == true) {
				        						foreach($leave as $l) {
				        							echo "<small class='thedates'>";
				        								echo $l->dates;
				        							echo "</small>";
				        						}
				        					}
				        				?>
				        			</div>
				        		</div>
				        		<div class="form-group">
				        			<label> Type of Leave </label>
				        			<select class="form-control" name="leavetype">
				        				<optgroup label="Leave Attendance Form">
					        				<option value="1"> Vacation Leave </option>
													<option value="2"> Mandatory/Forced Leave </option>
													<option value="3"> Sick Leave </option>
													<option value="4"> Maternity Leave</option>
													<option value="5"> Paternity Leave</option>
													<option value="6"> Special Privilege Leave</option>
													<option value="7"> Solo Parent Leave</option>
													<option value="8"> Study Leave</option>
													<option value="9"> 10-day VAWC Leave</option>
													<option value="10"> Rehabilitation Privilege</option>
													<option value="11"> Special Leave Benefits for Women</option>
													<option value="12"> Special Emergency (Calamity Leave)</option>
													<option value="13"> Adoption Leave</option>
												</optgroup>
												<optgroup label="Pass Slip">
													<option value="14"> Personal </option>
													<option value="15"> Official </option>
												</optgroup>
				        			</select>
				        		</div>
				        		<div class="form-group">
				        			<label>Reason</label>
				        			<textarea class="form-control" style="min-height:150px;" name="reasontxt"></textarea>
				        		</div>
			        		</div>
			        		<div class="card-footer">
			        			<?php if (!$update) { ?>
				        			<button class="btn btn-primary" id="applyforleave"> Apply for Leave </button>
				        		<?php } else {?>
				        			<p class="btn btn-default mb-0"> Download the File </p>
				        		<?php } ?>
				        	</div>
				        </form>
		        	</div>
	        	</div>
	        	<?php if ($update) { ?>
	        	<div class="col-md-5">
	        		<div class="card">
	        			<div class="card-header">
	        				<h4 class="card-title"> Document Details </h4>
	        			</div>
	        			<div class="card-body">
	        				<table class="table table-bordered">
	        					<tbody>
	        						<tr>
	        							<th> Status </th>
	        							<td> 
	        								<select class="form-control">
	        									<option> Approved </option>
	        									<option> Disapproved </option>
	        								</select>
	        							</td>
	        						</tr>
	        					</tbody>
	        				</table>
	        			</div>
	        			<div class="card-footer">
	        				<button class="btn btn-default"> Save Status </button>
	        			</div>
	        		</div>
	        	</div>
	        	<?php } ?>
	        </div>
        </div>
      </div>
  </div>
</div>
@include("scripts.footscripts")
<script src="{{ asset('dist/js/pages/domstyle.js')}}"></script>
<script>
	var theselecteddates = [];

	$(document).on("change","#leavedate", function(){
		var datesel = $(this).val();

            let indx  = theselecteddates.indexOf( $(this).val() );

            if (indx == -1) {
            	savethedate(datesel);
            } 

	});

	$(document).on("click",".thedates", function(){
		var thisdate = $(this).text();

		let indx = theselecteddates.indexOf(thisdate);

		theselecteddates.splice(indx,1);

		$(this).remove();
		$(document).find("#selecteddates").val(JSON.stringify(theselecteddates));
	})

	function savethedate(datesel) {
		theselecteddates.push( datesel );

        $("<small class='thedates'>"+datesel+"</small>").appendTo("#dateselected");
        $(document).find("#selecteddates").val(JSON.stringify(theselecteddates));
	}

</script>
</body>
</html>