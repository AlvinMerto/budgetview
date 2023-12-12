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

        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-3">
              <div class="card">
                <div class="card-header">
                  <h6> Division </h6>
                </div>
                <div class="card-body">
                  <ul class="nav nav-pills flex-column">
                    <li class="nav-item"> 
                      <?php 
                        foreach($division as $d) {
                          $url  = url("allactivities/{$d->divisionid}");

                          echo "<a href='{$url}'> {$d->divfullname} </a>";
                        }
                      ?>
                      <!-- <a href="http://localhost:8000/divisionwindow/9/information" class="nav-link text-bold"> KMD Regular </a>  -->
                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <?php if ($divid != null) { ?>
              <div class="col-lg-9">
              	<div class="card">
              	 <div class="card-header">
                  <h1 class="card-title"> All Activities </h1>
                 </div>	
                 <div class="card-body pt-2">
                    <table class="table" id='allactivities_perdiv'>
                      <thead>
                        <tr>
                          <th> Activity Title </th>
                          <th> Status </th>
                          <th> Action </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          foreach($activities as $a) {
                            $thelink = url("inputwindow/{$a->activitygrpid}");
                            echo "<tr>";
                              echo "<td>{$a->activitytitle}</td>"; ?>
                              <td>
                                  <div class='col-lg-3'> 
                                  <div class='progress progress-xs progress-striped active'>
                                  <div class='progress-bar bg-primary' style='width: <?php echo $a->status; ?>%'></div>
                                  </div>
                                  <span class='badge bg-primary'><?php echo $a->status; ?>%</span>
                                </div>
                              </td>
                            <?php 
                              echo "<td> <a href='{$thelink}' class='card-link' target='_blank'> view </a> </td>";
                            echo "</tr>";
                          }
                        ?>
                      </tbody>
                    </table>
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


</body>
</html>