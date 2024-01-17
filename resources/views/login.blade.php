<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PPPKDO Budget Tracking</title>

  	@include("scripts.headscripts")
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
  	<img class="animation__wobble" src="dist/img/PPPDO_minda.png" alt="PPPDO Budget System" height="45" width="210" style="margin-left: 10px;">
    <!-- <a href="../../index2.html"><b>Admin</b>LTE</a> -->
  </div>
  <!-- User name -->
  <div class="lockscreen-name mb-3">Please enter your credentials </div>

<form action="{{route('postlogin')}}" method="post">
	@csrf
  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item_">
    <!-- lockscreen image -->
<!--     <div class="lockscreen-image">
      <img src="../../dist/img/user1-128x128.jpg" alt="User Image">
    </div> -->
    <!-- /.lockscreen-image -->

    <!-- lockscreen credentials (contains the form) -->
    <form class="lockscreen-credentials">
      <div class="input-group mb-2">
      	 <input type="text" class="form-control" name="email" placeholder="email">
      </div>
      <div class="input-group">
        <input type="password" class="form-control" name="password" placeholder="password">

        <div class="input-group-append">
          <button type="submit" class="btn">
            <i class="fas fa-arrow-right text-muted"></i>
          </button>
        </div>
      </div>
    </form>
    <!-- /.lockscreen credentials -->

      @if (session('status'))
	  	<div class="lockscreen-name mb-3" style="color:red;">{{session('status')}}</div>
	  @endif
</form>

  </div>
  <!-- /.lockscreen-item -->
<!--   <div class="help-block text-center">
    or sign up for an account
  </div>
  <div class="text-center">
    <a href="login.html">sign up</a>
  </div> -->
  <div class="lockscreen-footer text-center">
  	Budget tracking of PPPKDO <br/> <br/>
    To request an account, click <b><a href="{{route('request')}}" class="text-black">Account Request</a></b>
    <!-- All rights reserved -->
  </div>
</div>
<!-- /.center -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
