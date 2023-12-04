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
          <div class="">
          	<div class="card">
          		<div class="card-header">
          			<h4> Are you sure you want to delete? </h4>
          		</div>
          		<div class="card-body">
          			<a href='' class="btn btn-danger"/>Proceed</a>
          			<a href='' class="btn btn-default"/>Cancel</a>
          		</div>
          	</div>
          </div>
        </div>
      </div>
  </div>
</div>
</body>
</html>
