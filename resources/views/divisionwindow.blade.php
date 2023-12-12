<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PPPDO Division Input</title>

		   @include("scripts.headscripts")

	</head>
<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

    <!-- Preloader -->

  @include("navigation_top")

  @include("navigation_left")

  <?php 
    $selectedname         = null; 
    $selecteddivision     = null;
  ?>
  
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">

        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-3">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title"> Budget </h3>
                  <div class="card-tools">
                    @if (session('status'))
                      <p class="m-0" style="color: green;">
                          {{ session('status') }}
                      </p>
                    @endif
                  </div>
                </div>
                <div class="card-content pl-2">
                  <form action="{{route('postbudgetentry')}}" method="post">
                    @csrf
                    <table class="table"> 
                      <tbody>
                        <tr>
                          <td> Division </td>
                          <td> 
                            <div class="input-group">
                              <select class="form-control" name="chargingdivision">
                                <?php
                                  foreach($division as $div) {
                                    $id = $div['divisionid'];
                                    echo "<option value='{$id}'>{$div['divfullname']}</option>";
                                  }
                                ?>
                              </select>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td> Budget Name </td>
                          <td> 
                            <div class="input-group">
                              <input type='text' class="form-control" name="budgetname" required ='required'/> 
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td> Planned Amount </td>
                          <td> 
                            <div class="input-group">
                              <input type='text' class="form-control" name="plannedamount" required ='required'/> 
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td> Actual Amount </td>
                          <td> 
                            <div class="input-group">
                              <input type='text' class="form-control" name="actualamount" required ='required'/> 
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td> Year </td>
                          <td> 
                            <div class="input-group">
                              <input type='text' class="form-control" name="budgetyear" required ='required'/> 
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <!-- <td> &nbsp; </td> -->
                          <td colspan="2" class="pb-0"> 
                            <input type='submit' value="Create Budget Line" class="btn btn-block btn-primary"/> 
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </form>
                </div>
              </div>
              <div class="card">
                <div class="card-header">
                  <h6 class="card-title"> Active Budget Lines </h6>
                  <!-- <div class="card-tools">
                    <small> show inactive </small>
                  </div> -->
                </div>
                <div class="card-content pl-1">
                  <ul class="nav nav-pills flex-column">
                    <?php
                      foreach($budgetlines as $b) {
                        if ($tab == null) {
                          $tab = "information";
                        }

                        $url = url("divisionwindow/{$b->chargingid}/{$tab}");
                        $selected     = null;
                        
                        if ($b->chargingid == $chargingid) {
                          $selected             = "text-bold";
                          $selectedname         = $b->chargingname;
                          $selecteddivision     = "";
                        }

                        echo "<li class='nav-item'> <a href='{$url}' class='nav-link {$selected}'/> {$b->chargingname} </a> </li>";
                      }
                    ?>
                    <!-- <li class="nav-item"> <a href="#" class="nav-link"/> KMD Regular </a> </li>
                    <li class="nav-item"> <a href="#" class="nav-link"/> KMD Continuing </a> </li> -->
                  </ul>
                </div>
              </div>
              <div class="card">
                <div class="card-header">
                  <h6 class="card-title"> Inactive Budget Lines </h6>
                  <!-- <div class="card-tools">
                    <small> show inactive </small>
                  </div> -->
                </div>
                <div class="card-content pl-1">
                  <ul class="nav nav-pills flex-column">
                    <?php
                      foreach($inactivebudgetlines as $ibl) {
                        if ($tab == null) {
                          $tab = "information";
                        }

                        $url = url("divisionwindow/{$ibl->chargingid}/{$tab}");
                        $selected     = null;
                        
                        if ($ibl->chargingid == $chargingid) {
                          $selected             = "text-bold";
                          $selectedname         = $ibl->chargingname;
                          $selecteddivision     = "";
                        }

                        echo "<li class='nav-item'> <a href='{$url}' class='nav-link {$selected}'/> {$ibl->chargingname} </a> </li>";
                      }
                    ?>
                    <!-- <li class="nav-item"> <a href="#" class="nav-link"/> KMD Regular </a> </li>
                    <li class="nav-item"> <a href="#" class="nav-link"/> KMD Continuing </a> </li> -->
                  </ul>
                </div>
              </div>
            </div>

            <?php if ($displayright != false) { ?>
            
            <div class="col-lg-9">
              <div class="card_">
                <div class="card-header">
                  <h3 class="card-title"> <?php echo $selectedname; ?> </h3>
                  <div class="card-tools">
                    @if (session('infoupdate'))
                       <p class="m-0" style="color: green;">
                          {{ session('infoupdate') }}
                      </p>
                    @endif
                  </div>
                </div>
                <div class="card-content">
                  <div class="pb-0 pt-1 pb-1 pl-3">
                    <?php 
                      $taburl = url("divisionwindow/{$chargingid}");
                      $b_info = null;
                      $b_acti = null;
                      $b_char = null;

                      if ($tab == "information") { $b_info = "text-bold"; }
                      elseif ($tab == "activities") { $b_acti = "text-bold"; }
                      elseif ($tab == "charging") { $b_char = "text-bold"; }
                    ?>

                    <a href="<?php echo $taburl; ?>/information" class="card-link border-right pr-4 <?php echo $b_info; ?>"/>Information</a>
                    <a href="<?php echo $taburl; ?>/activities" class="card-link border-right pr-4 <?php echo $b_acti; ?>"/>Activities</a>
                    <a href="<?php echo $taburl; ?>/charging" class="card-link <?php echo $b_char; ?>"/>Charges</a>

                  </div>
                  <?php if ($displayright == "information"): ?>
                    <div class="row pl-3 pr-3 pb-3 pt-2">
                      <div class="col-lg-6">
                       <div class="card">
                        <div class="card-body">
                          <table class="table">
                            <tr> 
                              <td> Budget Name </td>
                              <td class="text-bold"> <?php echo $selectedname; ?> </td>
                            </tr>
                            <tr> 
                              <td> Budget Year </td>
                              <td class="text-bold"><?php echo $year; ?> </td>
                            </tr>
                          </table>
                        </div>
                       </div>
                       <div class="card">
                          <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                              <h3 class="card-title">Budget Utilization</h3>
                              <!-- <a href="javascript:void(0);">View Report</a> -->
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="d-flex">
                              <p class="d-flex flex-column">
                                <!-- <span class="text-bold text-lg">820</span> -->
                                <span>Remaining Budget</span>
                              </p>
                              <p class="ml-auto d-flex flex-column text-right">
                                <span class="text-success text-bold text-lg">
                                  <?php echo number_format($leftospend,2); ?> PHp
                                  <!-- <i class="fas fa-arrow-up"></i> 12.5% -->
                                </span>
                                <!-- <span class="text-muted">This months expenditure</span> -->
                              </p>
                            </div>
                            <!-- /.d-flex -->

                            <div class="position-relative mb-4">
                              <!-- <canvas id="visitors-chart" height="200"></canvas> -->
                              <canvas id="division-budget-chart" height="200"></canvas>
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
                      </div>
                      <div class="col-lg-6">
                        <form action="{{route('postupdatebudget')}}" method="post">
                        @csrf 
                        <input type="hidden" id="chargingid" value="<?php echo $chargingid; ?>" name="chargingid"/>
                        <table class="table"> 
                          <tbody>
                            <tr class="bg-lightblue">
                              <td> Status </td>
                              <td> 
                                <div class="input-group">
                                  <select class="form-control" name="isactive">
                                    <?php
                                      $active   = null;
                                      $inactive = null; 
                                      
                                      if (count($budgetlinestatus) > 0) {
                                        if ($budgetlinestatus[0]->isactive == 1) {
                                          $active = "selected";
                                        } else if ($budgetlinestatus[0]->isactive == 0) {
                                          $inactive = "selected";
                                        }
                                      }
                                    ?>
                                    <option value="1" <?php echo $active; ?> > Active </option>
                                    <option value="0" <?php echo $inactive; ?> > Inactive </option>
                                  </select> 
                                </div>
                              </td>
                            </tr>

                            <tr>
                              <td> Division </td>
                              <td> 
                                <div class="input-group">
                                  <select class="form-control" name="update_chargingdivision">
                                    <?php
                                      foreach($division as $div) {
                                        $id       = $div['divisionid'];
                                        $selected = null;

                                        if ($selecteddiv == $id) {
                                          $selected = "selected";
                                        }

                                        echo "<option value='{$id}' {$selected}>{$div['divfullname']}</option>";
                                      }
                                    ?>
                                  </select>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td> Budget Name </td>
                              <td> 
                                <div class="input-group">
                                  <input type='text' class="form-control" name="update_budgetname" value="<?php echo $selectedname; ?>"/> 
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td> Year </td>
                              <td> 
                                <div class="input-group">
                                  <input type='text' class="form-control" name="update_budgetyear" value="<?php echo $year; ?>"/> 
                                </div>
                              </td>
                            </tr>
                            <tr>
                            
                            <tr>
                              <td> Planned Budget </td>
                              <td> 
                                <div class="input-group">
                                  <?php $planned = number_format($planned,2); ?>
                                  <input type='text' class="form-control" name="update_plannedamount" value="<?php echo $planned; ?>"/> 
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td> Actual Budget </td>
                              <td> 
                                <div class="input-group">
                                  <?php $actual = number_format($actual,2); ?>
                                  <input type='text' class="form-control" name="update_actualamount" value="<?php echo $actual; ?>"/> 
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td> Spent </td>
                              <td> 
                                <div class="input-group">
                                  <h6 class="text-lg text-bold"> PHp <?php echo number_format($spent,2); ?> </h6>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td> Remaining </td>
                              <td> 
                                <div class="input-group">
                                  <h6 class="text-lg text-bold"> PHp <?php echo number_format($leftospend,2); ?> </h6>
                                </div>
                              </td>
                            </tr>
                            
                            <tr>
                              <!-- <td> &nbsp; </td> -->
                              <td colspan="2" class="pb-0"> 
                                <input type='submit' value="Update Budget Line" class="btn btn-block btn-default"/> 
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </form>
                      </div>
                  </div>
                  <?php endif; ?>
                  <?php if ($displayright == "activities"): ?>
                      <div class="">
                        <table class="table" id="allactivities_perdiv">
                          <thead>
                            <tr> 
                              <th> Activity Title </th>
                              <th> Activity Date </th>
                              <th> Status </th>
                              <th> Action </th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              foreach($activities as $a) {
                                $init_cost = number_format($a->initialcost,2);
                                echo "<tr>";
                                  echo "<td> {$a->activitytitle} </td>";
                                  echo "<td> {$a->dateofactivity} </td>";
                                  echo "<td> {$init_cost} </td>";
                                  echo "<td> {$a->activitytitle} </td>";
                                  echo "<td>";
                                  echo "
                                    <div class='progress progress-xs progress-striped active'>
                                    <div class='progress-bar bg-primary' style='width:{$a->status}%'></div>
                                    </div>
                                    <span class='badge bg-primary'>{$a->status}%</span>";
                                  echo "</td>";
                                  echo "<td> <a href='{{route('inputwindow')}}/{$a->activitygrpid}' target='_blank'/>View</a> </td>";
                                echo "</tr>";
                              }
                            ?>
                          </tbody>
                        </table>
                      </div>
                  <?php endif; ?>

                  <?php if ($displayright == "charging"): ?>
                    <div class="p-0">
                      <div class="">
                          <table class="table" id="allactivities_perdiv">
                            <thead>
                              <tr>
                                <th> Charging Division </th>
                                <th> Item Charged </th>
                                <th> Charged Amount </th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach($charges as $cs) { ?>
                                <tr>
                                  <td> <?php echo $cs->divfullname; ?> </td>
                                  <td> <?php echo $cs->chargename; ?> </td>
                                  <td> PHp <?php echo number_format($cs->actualcost,2); ?> </td>
                                </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                      </div>
                    </div>
                  <?php endif; ?>

                </div>
              </div>
            </div>

            <?php } ?>
          </div>
        </div>
      </div>
  </div>

  @include("scripts.footscripts")
  <script src="{{ asset('dist/js/pages/division.js')}}"></script>
<style>
  .dataTables_filter label{
    margin:5px;
    float: right;
  }

  .dataTables_filter input[type="search"] {
    border: 1px solid #e2e2e2;
    margin-left: 11px;
    padding: 5px;
  }

  #allactivities_perdiv_info {
    float:left;
    margin:5px;
  }

  #allactivities_perdiv_paginate {
    float:right;
    margin:10px;
  }

  #allactivities_perdiv_previous, #allactivities_perdiv_next {
    background: #fff;
    color:#333;
    padding:5px 10px;
    border:1px solid #ccc;
  }

   #allactivities_perdiv_previous {
    border-radius: 5px 0px 0px 5px;
   }

   #allactivities_perdiv_next {
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
    $("#allactivities_perdiv").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#allactivities_perdiv_wrapper');
  });
</script>

</div>

</body>
</html>