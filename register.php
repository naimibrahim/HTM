<!DOCTYPE html>
<html lang="en">
  <head>
	<?php include 'head.php'; ?>
  </head>

  <body>

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

	  <div id="login-page">
	  	<div class="container">
	  	
		      <form class="form-login" action="register_process.php" method="post">
		        <h2 class="form-login-heading">Register</h2>
		        <div class="login-wrap">
		            <input type="email" class="form-control" placeholder="Email" autofocus id='username_reg'  name="username_reg">
		            <br><input type="password" class="form-control" placeholder="Password" id='password_reg' name="password_reg">
		            <br><input type="text" class="form-control" placeholder="Your Name" autofocus id='name'  name="name">
		            <br><input type="text" class="form-control" placeholder="Age" autofocus id='age'  name="age">
		            <br><div class="radio">
						  <label>
						    <input type="radio" name="sex" id="sex" value="male" checked>
						    Male
						  </label>
						</div>
		            	<div class="radio">
						  <label>
						    <input type="radio" name="sex" id="sex" value="female" >
						    Female
						  </label>
						</div>
		            <label class="checkbox">
		                <span class="pull-right">
		                    
		
		                </span>
		            </label>
		            <button class="btn btn-theme btn-block" href="index.html" type="submit"><i class="fa fa-lock"></i>REGISTER</button>
		            <hr>
		            
		            <div class="registration">
		            <a data-toggle="modal" href="login.html#myModal"> Already Register?</a>
		                
		            </div>
		
		        </div>
		
		          <!-- Modal -->
		          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
		              <div class="modal-dialog">
		                  <div class="modal-content">
		                      <div class="modal-header">
		                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                          <h4 class="modal-title"></h4>
		                      </div>
		                      <div class="modal-body">
		                          <p>Enter your e-mail address below to reset your password.</p>
		                          <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
		
		                      </div>
		                      <div class="modal-footer">
		                          <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
		                          <button class="btn btn-theme" type="submit">Submit</button>
		                      </div>
		                  </div>
		              </div>
		          </div>
		          <!-- modal -->
		
		      </form>	  	
	  	
	  	</div>
	  </div>

<?php include 'bottom.php';?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-3309406-9', 'auto');
  ga('send', 'pageview');

</script>
  </body>
</html>
