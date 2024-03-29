<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>All Activities</title>

		   @include("scripts.headscripts")

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
          <div class="card-header pl-0 pt-0">
            <h3 class="m-0 " style="float: left;margin-right: 15px !important;">Activity Designs</h3>
            <div class="pt-2 pb-2 pt-2 pl-0">
              <?php
                $pdd = null;
                $prd = null;
                $pfd = null;
                $kmd = null;
                $all = null;
                
                if ($divid != null) { 
                  if ($divid == 1) {
                    $pdd = 'text-bold';
                    $pdd = 'active';
                  }

                  if ($divid == 2) {
                    $prd = 'text-bold';
                    $prd = 'active';
                  }

                  if ($divid == 3) {
                    $pfd = 'text-bold';
                    $pfd = 'active';
                  }

                  if ($divid == 4) {
                    $kmd = 'text-bold';
                    $kmd = 'active';
                  }
                } else {
                  $all = 'text-bold';
                  $all = 'active';
                }
              ?>

              <ul class="nav nav-pills" style="margin-top: -10px;">
                <li class="nav-item"><a class="nav-link <?php echo $all; ?>" href="{{url('activities')}}">All</a></li>
                <li class="nav-item"><a class="nav-link <?php echo $pdd; ?>" href="{{url('activities/1')}}" >PDD</a></li>
                <li class="nav-item"><a class="nav-link <?php echo $prd; ?>" href="{{url('activities/2')}}">PRD</a></li>
                <li class="nav-item"><a class="nav-link <?php echo $pfd; ?>" href="{{url('activities/3')}}">PFD</a></li>
                <li class="nav-item"><a class="nav-link <?php echo $kmd; ?>" href="{{url('activities/4')}}">KMD</a></li>
              </ul>
<!-- 
              <a href="{{url('activities')}}" class="card-link <?php echo $all; ?>"/>All</a>
              <a href="{{url('activities/1')}}" class="card-link <?php echo $pdd; ?>"/>PDD</a>
              <a href="{{url('activities/2')}}" class="card-link <?php echo $prd; ?>"/>PRD</a>
              <a href="{{url('activities/3')}}" class="card-link <?php echo $pfd; ?>"/>PFD</a>
              <a href="{{url('activities/4')}}" class="card-link <?php echo $kmd; ?>"/>KMD</a> -->
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
<!--             <div class="col-lg-3">
              <div class="card">
                <div class="card-header">
                  <h6> Division </h6>
                </div>
                <div class="card-body">
                  <ul class="nav nav-pills flex-row">
                    <li class="nav-item"> 
                      <a> hello </a>
                    </li>
                    <li class="nav-item"> 
                      <a> hello </a>
                    </li>
                    <li class="nav-item"> 
                      <a> hello </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div> -->

              <div class="col-lg-12">
              	<div class="card">
              	  <div class="card-header">
                    <!-- <h1 class="card-title"> Activity Designs </h1> -->
                    
                    <div class="card-tools" style="float:left;">
                      <a href="" class="card-link"/>1st Quarter</a>
                      <a href="" class="card-link"/>2nd Quarter</a>
                      <a href="" class="card-link"/>3rd Quarter</a>
                      <a href="" class="card-link"/>4th Quarter</a>
                    </div>
                    <!-- <div class="card-tools">
                      <a href="#" class="btn btn-tool btn-sm">
                        <i class="fas fa-download"></i>
                      </a>
                      <a href="#" class="btn btn-tool btn-sm">
                        <i class="fas fa-bars"></i>
                      </a>
                    </div> -->
                 </div>	
                 <div class="card-content">
                  <div class="row">
          
                      <div class="col-lg-12">
                          <!-- <div class="card-header">
                            <div class="card-tools">
                              <a href="#" class="btn btn-tool btn-sm">
                                <i class="fas fa-download"></i>
                              </a>
                              <a href="#" class="btn btn-tool btn-sm">
                                <i class="fas fa-bars"></i>
                              </a>
                            </div>
                          </div> -->
                          <div class="card-body table-responsive p-0">
                            <table class="table table-bordered table-striped dataTable dtr-inline" id="activitiestbl">
                              <thead>
                              <tr>
                                <th> Last Touch </th>
                                <th> Maturity </th>
                                <th> Activity Design </th> 
                                <!-- <th> Plan </th> -->
                                <th> Cost </th>
                                <th> Actual Cost</th>
                                <th> Date released </th>
                                <th> OC date received </th>
                                <th> OC date released </th>
                                <th> Procurement date received </th>
                                <th> P.O. Released </th>
                                <th> Status </th>
                                <th> Division </th>
                                <!-- <th> Charge to </th> {$a->lastpoint} {$a->maturity} -->
                              </tr>
                              </thead>
                              <tbody>
                              
                                 <?php 
                                    if (count($activities) > 0) {
                                      foreach($activities as $a) {
                                        echo "<tr>";
                                          echo "<td> {$a->lastpoint} </td> ";
                                          echo "<td> {$a->maturity} </td> ";
                                          echo "<td> {$a->activitytitle} </td>";
                                          echo "<td>". number_format($a->initialcost,2)."</td>";
                                          echo "<td>". number_format($a->acost,2)."</td>";
                                          echo "<td>";
                                            if ($a->daterelease == null) {
                                              echo "no data";
                                            } else {
                                              echo date("M. d, Y", strtotime($a->daterelease));
                                            }
                                          echo "</td>";
                                          echo "<td>";
                                            if ($a->daterecvbyoc == null) {
                                              echo "no data";
                                            } else {
                                              echo date("M. d, Y", strtotime($a->daterecvbyoc));
                                            } 
                                          echo "</td>";
                                          echo "<td>";
                                            if ($a->datereleasedbyoc == null) {
                                              echo "no data";
                                            } else {
                                              echo date("M. d, Y", strtotime($a->datereleasedbyoc));
                                            } 
                                          echo "</td>";
                                          echo "<td>";
                                            if ($a->daterecvbyproc == null) {
                                              echo "no data";
                                            } else {
                                              echo date("M. d, Y", strtotime($a->daterecvbyproc));
                                            } 
                                          echo "</td>";
                                          echo "<td>";
                                            if ($a->date_po == null) {
                                              echo "no data";
                                            } else {
                                              echo date("M. d, Y", strtotime($a->date_po));
                                            } 
                                          echo "</td>";
                                          echo "<td>";

                                          $thecolor = null;

                                          switch($a->status) {
                                            case "100": $thecolor = "bg-success"; break;
                                            case "80": $thecolor  = "bg-primary"; break;
                                            case "60": $thecolor  = "bg-info"; break;
                                            case "40": $thecolor  = "bg-warning"; break;
                                            case "20": $thecolor  = "bg-default"; break;
                                            case "0": $thecolor   = "bg-danger"; break;
                                          }
                                          echo "
                                            <div class='progress progress-xs progress-striped active'>
                                              <div class='progress-bar {$thecolor}' style='width: {$a->status}%'></div>
                                            </div>
                                            <span class='badge {$thecolor}'>{$a->status}%</span>";
                                          echo "</td>";
                                          echo "<td> {$a->divaccr} </td>";
                                          // echo "<td> {$a->chargingname} </td>";
                                        echo "</tr>";
                                      }
                                    }
                                 ?>
                              
                              </tbody>
                            </table>
                          </div>
                      </div>
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

<style>
  .table-bordered td, .table-bordered th {
    font-size: 14px;
  }

  .dataTables_filter label{
    margin:5px;
    float: right;
  }

  .dataTables_filter input[type="search"] {
    border: 1px solid #e2e2e2;
    margin-left: 11px;
    padding: 5px;
  }

  #activitiestbl_info {
    float:left;
    margin:5px;
  }

  #activitiestbl_paginate {
    float:right;
    margin:10px;
  }

  #activitiestbl_previous, #activitiestbl_next {
    background: #fff;
    color:#333;
    padding:5px 10px;
    border:1px solid #ccc;
  }

   #activitiestbl_previous {
    border-radius: 5px 0px 0px 5px;
   }

   #activitiestbl_next {
    border-radius: 0px 5px 5px 0px;
   }

  .paginate_button {
    border:1px solid #007bff;
    padding:5px;
  }

  .current {
    background: #007bff;
    color:#fff;
  }

</style>

<script>
  $(function () {
    $("#activitiestbl").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#activitiestbl_wrapper');
  });
</script>

</body>
</html>