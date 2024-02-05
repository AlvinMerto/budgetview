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
      <div class="content-header">
        <div class="container-fluid">
           <h4> Programs  </h4>
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <input type='text' class="form-control"/>
                        <input type='button' value="Save" class="btn btn-primary mt-2"/>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"> Programs  </h5>
                        </div>
                        <div class="card-content">
                            <ul class="nav nav-pills flex-column">
                                <?php foreach($programs as $p) { ?>
                                    <li class="nav-item">
                                        <a href='#' class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <?php echo $p->theprograms; ?>
                                        </a> 
                                    </li>
                                <?php } ?>
                                <!--<li class="nav-item"> 
                                    <a href='' class="nav-link"> MindaNow </a> 
                                </li> -->
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                   <div class="card">
                        <div class="card-header">

                        </div>
                        <div class="card-content">

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