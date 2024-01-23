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

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <h3> User Management </h3>
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-3">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title"> User Assignment </h3>
                  <div class="card-tools">
                    @if (session('status'))
                      <p class="m-0" style="color: green;">
                          {{ session('status') }}
                      </p>
                    @endif
                  </div>
                </div>
                <form action="{{route('postadduser')}}" method="post">
                  @csrf 
                <div class="card-body">
                  
                  <h3 class="card-title mt-1 pr-3" style="background-color: #fff;"> Select User </h3>
                  <hr/>
                  <select class="form-control" name="thename">
                    <?php
                      foreach($user as $u) {
                        echo "<option value='{$u->id}'> {$u->name} </option>";
                      }
                    ?>
                  </select>
                  <br/>
                  <h3 class="card-title mt-1 pr-3" style="background-color: #fff;"> Add to </h3>
                  <hr/>
                  <select class="form-control" name="thedivision">
                    <?php
                      foreach($division as $d) {
                        echo "<option value='{$d->divisionid}'>{$d->divfullname}</option>";
                      }
                    ?>
                  </select>
                  <br/>
                  <h3 class="card-title mt-1 pr-3" style="background-color: #fff;"> User Power </h3>
                  <hr/>
                  <select class="form-control" name="userpower">
                    <option value='1'> Super Administrator </option>
                    <option value='2'> Administrator </option>
                    <option value='3'> Division Attendant </option>
                    <option value='4'> Rank-in-file </option>
                  </select>
                  <hr/>
                  <input type="submit" value="Add User" name="adduser" class="btn btn-primary btn-block"/>
            
                </div>
                 </form>
              </div>
            </div>
            <div class="col-lg-9">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title"> User Administration </h3>
                </div>
                <div class="card-content">
                  <table class="table">
                    <thead>
                      <tr>
                        <th> User </th>
                        <th> Assigned to </th>
                        <th> Action </th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- <tr>  -->
                        <?php
                          foreach($assignment as $a) {
                            echo "<tr>";
                              echo "<td>{$a->name}</td>";
                              echo "<td>{$a->divfullname}</td>";
                              echo "<td>
                                  <div class='card-tools'>
                                    <i class='fa fa-trash'></i>
                                    <g> &nbsp; </g>
                                    <i class='fas fa-pencil-alt'></i>
                                  </div>
                                </td>";
                            echo "</tr>";
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
  @include("scripts.footscripts")
</body>
</html>