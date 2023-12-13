<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PPPDO Budget View</title>
    @include("scripts.headscripts")
	</head>
<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  @include("navigation_top")

  @include("navigation_left")

    <?php
      use App\Models\loginControl;

      $user        = Auth::user();
      $id          = Auth::id();

      $atype       = loginControl::where("userid",$id)->get("accounttype");
      $accounttype = $atype[0]->accounttype;
      // echo "hello".$accounttype[0]->accounttype;
    ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header pt-0 pb-0">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
<!--               <div class="card-header pl-0 pb-0">
                <h3 class="m-0 ">Dashboard</h3>
                  <div class="pt-2 pb-2 pt-2 pl-0">
                    <a href="{{route('budget')}}" class="card-link text-bold border-right pr-4">Main Dashboard</a>

                    <?php if ($accounttype == "1") { ?>
                      <a href="{{route('activities')}}" class="card-link border-right pr-4">Activity Designs</a>
                    <?php } ?>

                    <a href="{{route('charges')}}" class="card-link "/>Charges</a>
                  </div>
              </div> -->
              <div class="pt-3 pb-0">
                <div class="row">
                  <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box shadow mb-2">
                      <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">Total Spent</span>
                        <h5 class="description-header text-bold text-lg"><?php echo number_format($spent,2); ?> PHp</h5>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                  </div>

                  <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box shadow mb-2">
                      <span class="info-box-icon bg-primary"><i class="far fa-copy"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">Remaining Balance</span>
                        <h5 class="description-header text-bold text-lg"><?php echo number_format($lefttospend,2) ?> PHp</h5>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                  </div>

                  <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box shadow mb-2">
                      <span class="info-box-icon"  style="background:#adadad;"><i class="far fa-copy"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">Current Budget</span>
                        <h5 class="description-header text-bold text-lg"><?php echo number_format($actual,2); ?> PHp</h5>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                  </div>

                  <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box shadow mb-2">
                      <span class="info-box-icon" style="background:#adadad;"><i class="far fa-copy"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">Proposed</span>
                        <h5 class="description-header text-bold text-lg"><?php echo number_format($planned,2); ?> PHp</h5>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                  </div>
                </div>
                <!-- /.row -->
              </div>
          </div><!-- /.col -->
<!--           <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v3</li>
            </ol>
          </div> -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-4">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Office Budget Utilization</h3>
                  <!-- <a href="javascript:void(0);">View Report</a> -->
                </div>
              </div>
              <div class="card-body pt-0">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg"> &nbsp; </span>
                    <span>Budget Utilization Rate</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success text-bold text-lg">
                     &nbsp;
                      <!-- <i class="fas fa-arrow-up"></i> 12.5% -->
                    </span>
                    <span class="text-muted"> <small> as of &nbsp; </small> <?Php echo date("l, M d. Y"); ?> </span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <!-- <canvas id="visitors-chart" height="200"></canvas> -->
                  <canvas id="office-budget-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Utilization
                  </span>

                  <!-- <span>
                    <i class="fas fa-square text-gray"></i> Last Week
                  </span> -->
                </div>
              </div>
            </div>
            <!-- /.card -->

            
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-8">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Budget Utilization per Division</h3>
                  <!-- <a href="javascript:void(0);">View Report</a> -->
                </div>
              </div>
              <div class="card-body pt-0">
                <div class="d-flex">
                   <p class="d-flex flex-column">
                   <span class="text-bold text-lg"> &nbsp;</span>
                   <span>Budget Utilization Rate per Budget Line</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success text-bold text-lg">
                      &nbsp;
                    </span>
                    <span class="text-muted"> <small> as of &nbsp; </small> <?Php echo date("l, M d. Y"); ?> </span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="sales-chart" height="200"></canvas> 
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Remaining Balance
                  </span>

                  <span>
                    <i class="fas fa-square" style="color:#5dcac0;"></i> Current Budget
                  </span>

                  <span class="ml-2">
                    <i class="fas fa-square text-gray"></i> Spent
                  </span>

                </div>
              </div>
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col-md-6 -->
        </div>
        <div class="row">
        	<div class="col-lg-12">
        		<div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Activity Designs</h3>
                <div class="card-tools">
                  <!-- <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a> -->
                  <a href="{{url('activities')}}" class="btn btn-tool btn-sm">
                    <i class="fas fa-bars"></i>
                  </a>
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th> Activity Design </th> 
                    <!-- <th> Plan </th> -->
                    <th> Cost </th>
                    <th> Actual Cost</th>
                    <th> Date released </th>
                    <th> OC date received </th>
                    <th> OC date released </th>
                    <th> Procurement date received </th>
                    <th> Status </th>
                    <th> Division </th>
                    <!-- <th> Charge to </th> -->
                  </tr>
                  </thead>
                  <tbody>
                  
                     <?php 
                        if (count($activities) > 0) {
                          foreach($activities as $a) {
                            echo "<tr>";
                              echo "<td> {$a->activitytitle} </td>";
                              echo "<td>". number_format($a->initialcost,2)."</td>";
                              echo "<td>". number_format($a->acost,2)."</td>";
                              echo "<td>". date("M. d, Y", strtotime($a->daterelease))."</td>";
                              echo "<td>". date("M. d, Y", strtotime($a->daterecvbyoc))."</td>";
                              echo "<td>". date("M. d, Y", strtotime($a->datereleasedbyoc))."</td>";
                              echo "<td>". date("M. d, Y", strtotime($a->daterecvbyproc))."</td>";
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
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">

  </footer>
</div>
<!-- ./wrapper -->

		@include("scripts.footscripts")
	</body>
</html>