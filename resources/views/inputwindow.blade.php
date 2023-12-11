<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PPPDO Input View</title>

		   @include("scripts.headscripts")

		   <style>
		   	.hideit {
		   		display: none;
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
	          <div class="col-lg-6">
	          	<div class="card">
	          		<div class="card-header">
	          				<h6 class="m-0"> Activity Information </h6>
	          		</div>

	          		<form action="{{route('saveactivity')}}" method="post">
	          			@csrf
	          		<div class="card-content p-3">
	          			<input type='hidden' name="activitygrpid" value="<?php echo $grpid; ?>"/>
	          			<div class="mb-2">
	          				<h6> Activity Title </h6>
			         			<div class="input-group">
			         				<textarea class="form-control" rows="3" id="activitytitle" name="activitytitle"><?php if (count($details)>0) { echo $details[0]->activitytitle; }?></textarea>
			          		</div>
			          	</div>
			          	<table class="table m-0">
			          		<tr> 
			          			<td style="vertical-align: middle; text-align: right;"> Division </td>
			          			<td>
			          				<select class="form-control" name="divisionselect">
				          				<?php foreach($division as $d) { ?>
				          					<option value="<?php echo $d->divisionid; ?>"> <?php echo $d->divfullname; ?> </option>
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
				                  		if (count($details)>0) { 
				                  			$initialcost = number_format( $details[0]->initialcost,2); 
				                  		}
				                  ?>
				                  <input type="text" class="form-control" id="initialcost" name='initialcost' value="{{$initialcost}}">
				                  <!-- <div class="input-group-append">
				                    <span class="input-group-text">.00</span>
				                  </div> -->
				                </div>
			          			</td>
			          		</tr>
			          		<tr>
			          			<td style="vertical-align: middle; text-align: right;"> Date of Activity </td>
			          			<td> 
			          				<div class="input-group date" id="" data-target-input="nearest">
		                        <input type="text" class="form-control" id="dateofactivity" name="dateofactivity" value="<?php if (count($details)>0) { echo $details[0]->dateofactivity; }?>">
		                        <!-- <div class="input-group-append" data-target="#dateofactivity" data-toggle="datetimepicker">
		                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
		                        </div> -->
		                    </div>
			          			</td>
			          		</tr>
			          		<tr>
			          			<td style="vertical-align: middle; text-align: right;"> Status </td>
			          			<td> 
			          				<select class="form-control" id="status" name='status'>
			          					<option value="25"> on-going </option>
			          					<option value="50"> Approved by Director </option>
			          					<option value="75"> for OC's signature </option>
			          					<option value="100"> for Procurement </option>
			          					<!-- <option value="100"> Approved </option> -->
			          				</select>
			          			</td>
			          		</tr>
			          			<tr id="daterelease" class="hideit">
				          			<td style="vertical-align: middle; text-align: right;"> 
				          				Date Release from PPPDO 
				          				<dt class="m-0"><?php if (count($details)>0) { echo date('M. d, Y', strtotime($details[0]->daterelease)); }?></dt>
				          			</td>
				          			<td> 
				          				<input type="date" class="form-control" id="daterelease" name="daterelease" 
				          							 value="<?php if (count($details)>0) { echo $details[0]->daterelease; }?>">

				          				<!-- <div class="input-group date" id="reservationdate" data-target-input="nearest">
			                        <input type="text" class="form-control datetimepicker-input" 
			                        			 data-target="#reservationdate" id="daterelease" name="daterelease"
			                        			 value="">
			                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
			                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
			                        </div>
			                    </div> -->
			                    
				          			</td>
				          		</tr>
				          		<tr class="ocdate hideit">
				          			<td style="vertical-align: middle; text-align: right;"> 
				          				Date Received by OC 
				          				<dt class="m-0"> <?php if (count($details)>0) { echo date('M. d, Y', strtotime($details[0]->daterecvbyoc)); }?> </dt>
				          			</td>
				          			<td> 
				          				<input type="date" class="form-control" 
			                        			 data-target="#rcvdbyoc" id="daterecvdbyoc" name="daterecvdbyoc"
			                        			 value="<?php if (count($details)>0) { echo $details[0]->daterecvbyoc; }?>">
				          				<!-- <div class="input-group date" id="rcvdbyoc" data-target-input="nearest">
			                        <input type="text" class="form-control datetimepicker-input" 
			                        			 data-target="#rcvdbyoc" id="daterecvdbyoc" name="daterecvdbyoc"
			                        			 value="">
			                        <div class="input-group-append" data-target="#rcvdbyoc" data-toggle="datetimepicker">
			                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
			                        </div>
			                    </div> -->
				          			</td>
				          		</tr>
				          		<tr class="ocdate hideit">
				          			<td style="vertical-align: middle; text-align: right;"> 
				          				Date Released by OC 
				          				<dt class="m-0"> <?php if (count($details)>0) { echo date('M. d, Y', strtotime($details[0]->datereleasedbyoc)); }?> </dt>
				          			</td>
				          			<td> 
				          				 <input type="date" class="form-control" 
			                        			 data-target="#rlsdbyoc" id="datereleasedbyoc" name="datereleasedbyoc"
			                        			 value="<?php if (count($details)>0) { echo $details[0]->datereleasedbyoc; }?>">
				          				<!-- <div class="input-group date" id="rlsdbyoc" data-target-input="nearest">
			                        <input type="text" class="form-control datetimepicker-input" 
			                        			 data-target="#rlsdbyoc" id="datereleasedbyoc" name="datereleasedbyoc"
			                        			 value="">
			                        <div class="input-group-append" data-target="#rlsdbyoc" data-toggle="datetimepicker">
			                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
			                        </div>
			                    </div> -->
			                    
				          			</td>
				          		</tr>
				          		<tr id="inprocurement" class="hideit">
				          			<td style="vertical-align: middle; text-align: right;"> 
				          				Date Received by Procurement 
				          				<dt class="m-0"> <?php if (count($details)>0) { echo date('M. d, Y', strtotime($details[0]->daterecvbyproc)); }?> </dt>
				          			</td>
				          			<td> 
				          				<input type="date" class="form-control" 
			                        			 data-target="#rcvddbyproc" id="datercvdbyproc" name="datercvdbyproc"
			                        			 value="<?php if (count($details)>0) { echo $details[0]->daterecvbyproc; }?>">
				          				<!-- <div class="input-group date" id="rcvddbyproc" data-target-input="nearest">
			                        <input type="text" class="form-control datetimepicker-input" 
			                        			 data-target="#rcvddbyproc" id="datercvdbyproc" name="datercvdbyproc"
			                        			 value="">
			                        <div class="input-group-append" data-target="#rcvddbyproc" data-toggle="datetimepicker">
			                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
			                        </div>
			                    </div> -->
				          			</td>
				          		</tr>
			          		
			          	</table>
		          	</div>
		          	<div class="card-footer">
		          		<?php if (count($details) > 0) { ?>
		          			<button class="btn btn-block btn-primary" id="updatebtn" name="updatebtn"> Update </button>
		          		<?php } else { ?>
	          				<button class="btn btn-block btn-primary" id="savebtn" name="savebtn"> Save </button>
	          			<?php } ?>
	          		</div>
	          		</form>
	          	</div>
	          </div>
	       <?php if (count($details) > 0) { ?>
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
				              			<option value="1"> Entire Activity </option>
				              			<option value="2"> Remaining Activity </option>
				              			<option value="3"> Travel </option>
				              			<option value="4"> Food </option>
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
			          				<button class="btn btn-block btn-default" id="addcharging" name="addcharging" data-grpid="<?php echo $grpid; ?>"> Add Charging </button>
			          			</td>
			          		</tr>
				          	</table>
				          	</form>
	          			</div>
	          		
	          		</div>
	          		<div class="card">
	          			<div class="card-header">
	          				<h6 class="m-0"> Charge to </h6>
	          			</div>
	          			<div class="card-content">
	          				<div id="chargewindow" class="p-3">
	          					<table class="table">
	          						<thead>
	          							<th> Item </th>
	          							<th> Amount </th>
	          							<th> Charged to </th>
	          							<th> Action </th>
	          						</thead>
	          						<tbody>
	          							<?php
			          						foreach($charging as $cg) {
			          							$cost = number_format($cg->actualcost,2);
			          							$url  = url("delete/{$cg->chargeid}/charging");
			          							echo "<tr>";
			          								echo "<td> {$cg->chargename} </td>";
			          								echo "<td> {$cost} </td>";
			          								echo "<td> {$cg->chargingname} </td>";
			          								echo "<td> <small class='deletethis' style='cursor:pointer;' data-id='{$cg->chargeid}' data-table='charging'> Delete </small> </td>";
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

	  @include("scripts.footscripts")
	  <script src="{{ asset('dist/js/pages/domstyle.js')}}"></script>
		<script src="{{ asset('dist/js/pages/inputwindow.js')}}"></script>
</div>

</body>
</html>