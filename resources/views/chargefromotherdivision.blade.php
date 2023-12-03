<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PPPDO Charging</title>

		   @include("scripts.headscripts")

	</head>
<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->


    <div class="" style="width:80%;margin:auto;">
    <!-- Content Header (Page header) -->
	    <div class="content-header">
	      <div class="container-fluid">
	      	@if (session('status'))
	      		 <p class="m-0" style="color: red;">
              {{ session('status') }}
             </p>
	      	@endif
	      </div>
    	</div>
	    <div class="content">
	    	<div class="container-fluid">
	        <div class="row">
	        	<?php 
	        		$col = "col-lg-12";

	        		if (count($inputwindow) > 0) {
	        			$col = "col-lg-6";
	        		}
	        	?>
	          <div class="{{$col}}">
	          	<div class="card">
	          		<div class="card-header">
	          				<h6 class="m-0"> Activity Information </h6>
	          		</div>

	          		<form action="{{route('saveactivity')}}" method="post">
	          			@csrf
	          			<input type = "hidden" name='redirectoutside' value="true"/>
	          		<div class="card-content p-3">
	          			<div class="mb-2">
	          				<h6> Activity Title </h6>
			         			<div class="input-group">
			         				<?php
			         					$activitytitle = null;
			         					if (count($inputwindow) > 0) {
			         						$activitytitle = $inputwindow[0]->activitytitle;
			         					}
			         				?>
			         				<textarea class="form-control" rows="3" id="activitytitle" name="activitytitle" required="required"><?php echo $activitytitle; ?></textarea>
			          		</div>
			          	</div>
			          	<table class="table m-0">
			          		<tr> 
			          			<td style="vertical-align: middle; text-align: right;"> Originating Division </td>
			          			<td>
			          				<select class="form-control" name="divisionselect">
			          					<?php
			          						$origdiv = null;

			          						if (count($inputwindow) > 0) {
			          							$origdiv  = $inputwindow[0]->division;
			          						}
			          					?>
				          				<?php foreach($division as $d) { 
				          					$selected = null;

				          					if ($origdiv == $d->divisionid) {
				          						$selected = "selected";
				          					}
				          					?>
				          					<option value="<?php echo $d->divisionid; ?>" {{$selected}}> [ <?php echo $d->divaccr; ?> ] - <?php echo $d->divfullname; ?> </option>
				          				<?php } ?>
			          				</select>
			          			</td>
			          		</tr>
			          		<tr>
			          			<td style="vertical-align: middle; text-align: right;"> Initial Activity Cost </td>
			          			<td>
			          				<div class="input-group">
				                  <div class="input-group-prepend">
				                    <span class="input-group-text">PHp</span>
				                  </div>
				                  <?php
				                  	$initialcost = null;
				                  	if (count($inputwindow) > 0) {
				                  		$initialcost = number_format($inputwindow[0]->initialcost,2); 
				                  	}
				                  ?>
				                  <input type="text" class="form-control" id="initialcost" name='initialcost' value="<?php echo $initialcost; ?>"/>
				                </div>
			          			</td>
			          		</tr>
			          		<tr>
			          			<td style="vertical-align: middle; text-align: right;"> Status </td>
			          			<td> 
			          				<select class="form-control" id="status" name='status'>
			          					<option value="100"> Approved </option>
			          				</select>
			          			</td>
			          		</tr>

			          			<input type='hidden' name="dateofactivity"/>
				          		<input type='hidden' name="daterelease"/>
				          		<input type='hidden' name="daterecvdbyoc"/>
				          		<input type='hidden' name="datereleasedbyoc"/>
				          		<input type='hidden' name="datercvdbyproc"/>
			          		
			          	</table>
		          	</div>
		          	<div class="card-footer">
		          		<?php if (count($inputwindow) == 0) { ?>
		          			<button class="btn btn-block btn-primary" id="savebtn" name="savebtn_outside"> Save </button>
		          		<?php } ?>
	          		</div>
	          		</form>
	          	</div>
	          </div>
	       <?php if (count($inputwindow) > 0) { ?>
	          	<div class="col-lg-6">
	          		<div class="card">
	          			<div class="card-content">
	          				 <form action="{{route('savecharging')}}" method="post">
					          	@csrf
					          	<input type='hidden' name="activitygrpid" value="<?php echo $grpid; ?>"/>
					          	<input type="hidden" name="chargetype" value="1"/>
					          	
	          				<table class="table">
		          				<tr>
			          			<td colspan='10'> Charging </td>
			          		</tr>
			          		<tr> 
			          			<td style="vertical-align: middle; text-align: right;"> Charge to </td>
			          			<td>
			          				<select class="form-control" id="charging" name="chargeto">
			          					<?php foreach($chargingtables as $ct) { ?>
			          						<option value="<?php echo $ct->chargingid; ?>"> <?php echo $ct->chargingname; ?> </option>
			          					<?php } ?>
				         					<!-- <option value="1"> PDD </option>
				         					<option value="2"> PRD </option>
				         					<option value="3"> PFD </option>
				         					<option value="4"> KMD </option>
				         					<option value="5"> MRB-NEXUS </option> -->
				         				</select>
			          			</td>
			          		</tr>
			          		<tr> 
			          			<td style="vertical-align: middle; text-align: right;"> What to charge? </td>
			          			<td>
			          				<select class="form-control pb-2" id="whattocharge" name="chargewhat">
			          					  <option> --- </option>
			          					  <?php
			          					  	foreach($chargewhat as $cw) {
			          					  		echo "<option value='{$cw->chargetypeid}'>{$cw->chargename}</option>";
			          					  	}
			          					  ?>
				              			<!-- <option value="1"> Entire Activity </option>
				              			<option value="2"> Remaining Activity </option>
				              			<option value="3"> Travel </option>
				              			<option value="4"> Food </option> -->
				              		</select>
			          			</td>
			          		</tr>
			          		<tr>
			          			<td style="vertical-align: middle; text-align: right;"> Amount to charge </td>
			          			<td>
				          			<div class="input-group">
					              		<div class="input-group-prepend">
					                    <span class="input-group-text">PHp</span>
					                  </div>
					                  <input type="text" class="form-control" id="chargeamount" name="actualcost">
					              </div>
				            	</td>
			          		</tr>
			          		<tr>
			          			<td> </td>
			          			<td>
			          				<button class="btn btn-block btn-default" id="addcharging" name="addcharging_outside" data-grpid=""> Add Charging </button>
			          			</td>
			          		</tr>
				          	</table>
				          	</form>
	          			</div>
	          		
	          		</div>
	          		<div class="card">
	          			<div class="card-header">
	          				<h6 class="m-0"> Charges </h6>
	          			</div>
	          			<div class="card-content">
	          				<div id="chargewindow" class="p-3">
	          					<table class="table">
	          						<thead>
	          							<th> Item </th>
	          							<th> Amount </th>
	          							<th> Charged to </th>
	          							<!-- <th> Action </th> -->
	          						</thead>
	          						<tbody>
	          							<?php
			          						foreach($charges as $cg) {
			          							$cost = number_format($cg->actualcost,2);
			          							
			          							echo "<tr>";
			          								echo "<td> {$cg->chargename} </td>";
			          								echo "<td> {$cost} </td>";
			          								echo "<td> {$cg->chargingname} </td>";
			          							echo "</tr>";
			          						}
			          					?>	
	          						</tbody>
	          					</table>
	          				</div>
	          			</div>
	          		</div>
	          </div>
	        <?php } ?> 
	        </div>

       	</div>
	    </div>
	  </div>

</div>

</body>
</html>