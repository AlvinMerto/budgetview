<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Activity Tracking System</title>

		   @include("scripts.headscripts")

		   <style>
		   	.hideit {
		   		display: none;
		   	}
		   </style>
	</head>
	<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
		<div class="wrapper">
			
					<div class="row" style="justify-content: center;">
						<div class="col-md-6">
							<div class="card">
								<div class="card-header">
									<p> Tracking System </p>
								</div>
								<div class="card-content">
									<?php
										$stoppedat = null;
										$labels = [
											"daterelease"			  => "Released from PPPDO Office",
											"daterecvbyoc"			  => "For OC's Signature",
											"datereleasedbyoc" 		  => "Release from OC",
											"daterecvbyproc" 		  => "Received by Procurement",
											"date_po" 			  	  => "P.O. Released"
										];

										echo "<table class='table'>";
											$datecreated = date("M d. Y", strtotime($collection[0]['created_at']));
											echo "
											<tr>
												<td style='text-align: right; width: 50%;'> Activity Title: </td>
												<td class='text-bold'> {$collection[0]['activitytitle']} </td>
											</tr> 
											<tr>
												<td style='text-align: right;''> Date Created: </td>
												<td class='text-bold'> {$datecreated} </td>
											</tr> ";

											foreach($labels as $key => $l) {
												if ($collection[0][$key] != null ) {
													$updateddate = date("M d. Y", strtotime($collection[0][$key]));
													echo "<tr>";
														echo "<td style='text-align: right;' > {$l} </td>";
														echo "<td class='text-bold'> {$updateddate} </td>";
													echo "</tr>";
												} else {
													$stoppedat = $key;
													break;
												}
											}
										echo "</table>";
									?>
									<!-- <table class="table">
										<tr>
											<td style="text-align: right;"> Activity Title: </td>
											<td class='text-bold'> Lorem Ipsum Dolor Set amit</td>
										</tr>
										<tr>
											<td style="text-align: right;"> Created: </td>
											<td class='text-bold'> January 1, 2040 </td>
										</tr>
										<tr>
											<td style="text-align: right;"> Released from PPPDO Office: </td>
											<td class='text-bold'> January 1, 2040 </td>
										</tr>
										<tr>
											<td style="text-align: right;"> For OC's Signature : </td>
											<td class='text-bold'> January 1, 2040 </td>
										</tr>
										<tr>
											<td style="text-align: right;"> Release from OC: </td>
											<td class='text-bold'> January 1, 2040 </td>
										</tr>
										<tr>
											<td style="text-align: right;"> Received by Procurement: </td>
											<td class='text-bold'> January 1, 2040 </td>
										</tr>
										<tr>
											<td style="text-align: right;"> P.O. Released: </td>
											<td class='text-bold'> January 1, 2040 </td>
										</tr>
									</table> -->
								</div>
								<div class="card-footer" style="display:flex; justify-content: center;">
									<form method="post" action="{{route('posttrackit')}}">
										@csrf
										<input type='hidden' value="<?php echo $code; ?>" name='qid'/>
										<input type='hidden' value="<?php echo $stoppedat; ?>" name='fld'/>
										<button class='btn btn-primary'> Accept the Document </button>
									</form>
								</div>

								@if (session('msg'))
									<div class="card-footer" style="display:flex; justify-content: center;">
										<p class="m-0" style="color: red;">
							              {{ session('msg') }}
							             </p>
									</div>
								@endif
							</div>
						</div>
					</div>	
				
		</div>
	</body>
</html>
