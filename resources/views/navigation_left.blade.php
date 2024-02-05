<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('budget')}}" class="brand-link">
      <img class="animation__wobble__" src="{{ asset('dist/img/PPPDO_minda.png')}}" alt="PPPDO Budget System" height="45" width="210" style="margin-left: 10px;">
      <!-- <h3 class="brand-text font-weight-light mb-0" style="text-align: center;">PPPDKMO</h3> -->
    </a>

    <?php
      use App\Models\loginControl;

      $user        = Auth::user();
      $id          = Auth::id();

      $atype       = loginControl::where("userid",$id)->get("accounttype");
      $accounttype = $atype[0]->accounttype;
      // echo "hello".$accounttype[0]->accounttype;
    ?>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <!-- <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
        </div>
        <div class="info">
          <a href="#" class="d-block">
            <?php
              echo $user->name;
            ?>
          </a>
        </div>
      </div>

      <!-- Sidebar Menu  http://localhost:8000/budget  -->
      <?php 
        $budget         = null;
        $allads         = null;
        $divisionwindow = null;
        $adminwindow    = null;
        $inputwindow    = null;
        $allactivity    = null;
        $menuopen       = null;
        $menu_href      = null;
        $charges        = null;

        $uri    = explode("/",Request::url())[3];
        switch($uri) {
          case "activities":
            $allads         = "active";
            break;
          case "budget":
            $budget = "active";
            break;
          case "divisionwindow":
            $divisionwindow = "active";
            $menuopen       = "menu-open";
            $menu_href      = "active";
            break;
          case "adminwindow":
            $adminwindow = "active";
            break;
          case "inputwindow":
            $inputwindow = "active";
            $menuopen    = "menu-open";
            $menu_href   = "active";
            break;
          case "allactivities":
            $allactivity = "active";
            $menuopen    = "menu-open";
            $menu_href   = "active";
            break;
          case "charge":
            $charges     = "active";
            $menuopen    = "menu-open";
            $menu_href   = "active";
            break;
        }
      ?>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <?php //if ($accounttype == 1 ||$accounttype == 2 ||$accounttype == 3 ||$accounttype == 4) {?>
            <li class="nav-header">LEAVE ADMINISTRATION</li>
            <li class="nav-item">
              <?php $theyear = date("Y"); $url = route("monitoring", $theyear); ?>
              <a href="<?php echo $url; ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p> Leave Monitoring </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('applyleave')}}" class="nav-link">
                <i class="nav-icon far fa-envelope"></i>
                <p>
                  Leave Cabinet
                </p>
              </a>
            </li>
          <?php //} ?>
          
          <?php //if ($accounttype == "2" || $accounttype == "1") { ?>
          <li class="nav-header">OFFICE ADMIN</li>
          <li class="nav-item">
            <a href="{{route('budget')}}" class="nav-link <?php echo $budget; ?>">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                Budget View
                <!-- <span class="badge badge-info right">2</span> -->
              </p>
            </a>
          </li>
          <?php //} ?>
          
          <?php //if ($accounttype == "2" || $accounttype == "1") { ?>
            <li class="nav-item">
              <a href="{{route('activities')}}" class="nav-link <?php echo $allads; ?>">
                <i class="nav-icon fas fa-calendar-alt"></i>
                <p>
                  All Activity Designs
                </p>
              </a>
            </li>
          <?php //} ?>


          <?php if ($accounttype == "1") { ?>
            <li class="nav-item">
              <a href="{{route('adminwindow')}}" class="nav-link <?php echo $adminwindow; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Admin Window</p>
              </a>
            </li>
          <?php } ?>
          
          <?php if ($accounttype == "1" || $accounttype == "3" || $accounttype == "2") { ?>
          <li class="nav-header">BOARDS</li>
          <li class="nav-item <?php echo $menuopen; ?>">
            <a href="#" class="nav-link <?php echo $menu_href; ?>">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                My Division
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php if ($accounttype == "1" || $accounttype == "3") { ?>
              <li class="nav-item">
                <a href="{{route('allactivities')}}" class="nav-link <?php echo $allactivity; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Activities</p>
                </a>
              </li>
              <?php } ?>

              <li class="nav-item">
                <a href="{{route('charge')}}" class="nav-link <?php echo $charges; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Charges</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="http://localhost:8000/divisionwindow/14/division/1" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p> Division Budget </p>
                </a>
              </li>

              <?php if ($accounttype == "1" || $accounttype == "3") { ?>
              <li class="nav-item">
                <a href="{{route('inputwindow')}}" class="nav-link <?php echo $inputwindow; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Enter Activity Design</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('divisionwindow')}}" class="nav-link <?php echo $divisionwindow; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Mother Activity Designs</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('programs')}}" class="nav-link <?php echo $inputwindow; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Programs</p>
                </a>
              </li>
              <?php } ?>
            </ul>
          </li>
          <?php } ?>
         
        </ul>
      </nav>
      <nav class="mt-2" style="position: absolute;bottom: 0px;">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
              <a href="{{route('logout')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
                <p> Sign out </p>
              </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>