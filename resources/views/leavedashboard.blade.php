<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Leave Dashboard</title>

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

	.monitoringtable {
		border-collapse: collapse;
	}

	.monitoringtable thead tr {
		border-bottom: 2px solid #333;
	}

	.monitoringtable tbody tr td {
		border:1px solid #ccc;
		text-align: center;
	}

	.monitoringtable thead tr th{
		text-align: center;
		border-left: 1px solid #333;
		border-right: 1px solid #333;
		border-top: 1px solid #333;
	}

	.left-border {
		border-left: 1px solid #333;
	}

	.right-border {
		border-right: 1px solid #333;
	}
</style>
	
	</head>
<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
	<div class="wrapper">

	    <!-- Preloader -->

	  @include("navigation_top")

	  @include("navigation_left")

	  <div class="content-wrapper" style="background: #fff;">
	    <!-- Content Header (Page header) -->
	      <div class="content-header">
	        <div class="container-fluid">
	        	<div class="row">
	        		<div class="col-md-12">
	        			<div>
	        				<div class="card-header">
	        					<span class="text-bold text-lg"> Leave Monitoring </span>
	        					<select style="float: right;">
	        						<option> 2024 </option>
	        						<option> 2023 </option>
	        					</select>
	        				</div>
	        				<div class="card-body pl-0 pr-0">
	        					<table class="table monitoringtable">
	        						<thead>
	        							<tr>
		        							<th> Employee Name </th>
		        							<th colspan="5"> Jan </th>
		        							<th colspan="5"> Feb </th>
		        							<th colspan="5"> Mar </th>
		        							<th colspan="5"> Apr </th>
		        							<th colspan="5"> May </th>
		        							<th colspan="5"> Jun </th>
		        							<th colspan="5"> Jul </th>
		        							<th colspan="5"> Aug </th>
		        							<th colspan="5"> Sep </th>
		        							<th colspan="5"> Oct </th>
		        							<th colspan="5"> Nov </th>
		        							<th colspan="5"> Dec </th>
	        							</tr>
	        							<tr>
	        								<th> &nbsp; </th>

	        								<th class="left-border"> Sick </th>
	        								<th> Vacation </th>
	        								<th> PS: Official </th>
	        								<th class="right-border"> PS: Personal </th>
	        								<th> Other Leave </th>

	        								<th> Sick </th>
	        								<th> Vacation </th>
	        								<th> PS: Official </th>
	        								<th> PS: Personal </th>
	        								<th> Other Leave </th>

	        								<th> Sick </th>
	        								<th> Vacation </th>
	        								<th> PS: Official </th>
	        								<th> PS: Personal </th>
	        								<th> Other Leave </th>

	        								<th> Sick </th>
	        								<th> Vacation </th>
	        								<th> PS: Official </th>
	        								<th> PS: Personal </th>
	        								<th> Other Leave </th>

	        								<th> Sick </th>
	        								<th> Vacation </th>
	        								<th> PS: Official </th>
	        								<th> PS: Personal </th>
	        								<th> Other Leave </th>

	        								<th> Sick </th>
	        								<th> Vacation </th>
	        								<th> PS: Official </th>
	        								<th> PS: Personal </th>
	        								<th> Other Leave </th>

	        								<th> Sick </th>
	        								<th> Vacation </th>
	        								<th> PS: Official </th>
	        								<th> PS: Personal </th>
	        								<th> Other Leave </th>

	        								<th> Sick </th>
	        								<th> Vacation </th>
	        								<th> PS: Official </th>
	        								<th> PS: Personal </th>
	        								<th> Other Leave </th>

	        								<th> Sick </th>
	        								<th> Vacation </th>
	        								<th> PS: Official </th>
	        								<th> PS: Personal </th>
	        								<th> Other Leave </th>

	        								<th> Sick </th>
	        								<th> Vacation </th>
	        								<th> PS: Official </th>
	        								<th> PS: Personal </th>
	        								<th> Other Leave </th>

	        								<th> Sick </th>
	        								<th> Vacation </th>
	        								<th> PS: Official </th>
	        								<th> PS: Personal </th>
	        								<th> Other Leave </th>

	        								<th> Sick </th>
	        								<th> Vacation </th>
	        								<th> PS: Official </th>
	        								<th> PS: Personal </th>
	        								<th> Other Leave </th>
	        							</tr>
	        						</thead>
	        						<tbody>
	        							<?php
	        								$ms = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
	        								foreach($months as $key => $m) {
	        									echo "<tr>";
	        										echo "<td>";
	        											echo $m['name'];
	        										echo "</td>";
	        										foreach($ms as $mm) {
	        											if (isset($m[$mm])) {
	        												echo "<td>";
		        												if (isset($m[$mm]['sleave'])) {
				        											echo $m[$mm]['sleave'];
			        											}
		        											echo "</td>";

		        											echo "<td>";
			        											if (isset($m[$mm]['vleave'])) {
				        											echo $m[$mm]['vleave'];
			        											}
		        											echo "</td>";

		        											echo "<td>";
			        											if (isset($m[$mm]['psperson'])) {
				        											echo $m[$mm]['psperson'];
			        											}
		        											echo "</td>";

		        											echo "<td>";
			        											if (isset($m[$mm]['psoffic'])) {
				        											echo $m[$mm]['psoffic'];
			        											}
		        											echo "</td>";

		        											echo "<td>";
			        											if (isset($m[$mm]['oleave'])) {
				        											echo $m[$mm]['oleave'];
			        											}
		        											echo "</td>";
	        											}
	        										}
	        									echo "</tr>";
	        								}
	        							?>
	        						</tbody>
	        					</table>
	        				</div>
	        				<div class="">

	        				</div>
	        			</div>
	        		</div>
	        	</div>
	        	<div class="row">
	        		<div class="col-md-6">
	        			<div class="card">
	        				<div class="card-header">
	        					<div class="d-flex">
		                  <p class="d-flex flex-column mb-0">
		                    <span class="text-bold text-lg"> Leave distribution </span>
		                  </p>
		                </div>
	        				</div>
		        			<div class="card-body pt-0">
		               
		                <div class="position-relative mt-3">
		                  <canvas id="leave-distribution" height="200"></canvas>
		                </div>

	              	</div>
              	</div>
	        		</div>
	        		<div class="col-md-6">
	        			<div class="card">
	        				<div class="card-header">
	        					<div class="d-flex">
		                  <p class="d-flex flex-column mb-0">
		                    <span class="text-bold text-lg"> Employees with most 
			                    <select class="form-control">
			                    	<option> Vacation Leave </option>
			                    	<option> Sick Leave </option>
			                    	<option> PS: Official </option>
			                    	<option> PS: Personal </option>
			                    </select>
		                    </span>
		                  </p>
		                </div>
	        				</div>
		        			<div class="card-body pt-0">
		                <div class="position-relative mb-4">
		                  <table class="table">
		                  	<thead>
		                  		<th> Name </th>
		                  		<th> Count </th>
		                  	</thead>
		                  	<tbody>
		                  		<tbody>
		                  			<tr>
		                  				<td> Alvin Merto </td>
		                  				<td> 2 </td>
		                  			</tr>
		                  		</tbody>
		                  	</tbody>
		                  </table>
		                </div>

		                <div class="d-flex flex-row justify-content-end">
		                  <span class="mr-2">
		                    &nbsp;
		                    <!-- <i class="fas fa-square text-primary"></i> Utilization -->
		                  </span>
		                </div>
	              	</div>
	              </div>
	        		</div>
	        	</div>
	        </div>
	       </div>
	  </div>
	</div>
	@include("scripts.footscripts")
</body>
</html>