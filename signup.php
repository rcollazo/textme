<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>TextMe Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="http://getbootstrap.com/2.3.2/assets/css/bootstrap.css" rel="stylesheet">
    <link href="http://getbootstrap.com/2.3.2/assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
  </head>
  <body>	  
	
  <div class="container">
	
  <div class="row">
	
	
  <div class="span8">

   <?php if($_POST) {

    require_once('lib/functions.inc.php');

    $sql = "INSERT INTO users (first_name, last_name, email, phone, password) VALUES (:first_name, :last_name, :email, :phone, :password)";
  try {
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->bindParam("first_name", $_POST['first_name']);
    $stmt->bindParam("last_name", $_POST['last_name']);
    $stmt->bindParam("email", $_POST['user_email']);
    $stmt->bindParam("phone", $_POST['phone']);
    $stmt->bindParam("password", createPassword($_POST['user_email'],$_POST['pwd']));

    $stmt->execute();
    $textme_id = $db->lastInsertId();
    $db = null; ?>
	<div class="alert alert-success">
	  Well done! You have successfully created your account.
	</div>
	   <?php
  } catch(PDOException $e) {
    error_log($e->getMessage());
    ?>
	<div class="alert alert-error">
	  Something went wrong! Please try again.
	</div>
	   <?php
    }

} ?>

	<form class="form-horizontal" id="registerHere" method='post' action=''>
	  <fieldset>
	    <legend>TextMe Registration</legend>
	    <div class="control-group">
	      <label class="control-label" for="input01">First Name</label>
	      <div class="controls">
	        <input type="text" class="input-xlarge" id="first_name" name="first_name" rel="popover">
	        
	      </div>
	</div>

	    <div class="control-group">
	      <label class="control-label" for="input01">Last Name</label>
	      <div class="controls">
	        <input type="text" class="input-xlarge" id="last_name" name="last_name" rel="popover">
	        
	      </div>
	</div>

	
	 <div class="control-group">
		<label class="control-label" for="input01">Email</label>
	      <div class="controls">
	        <input type="text" class="input-xlarge" id="user_email" name="user_email" rel="popover">
	       
	      </div>
	</div>

	 <div class="control-group">
		<label class="control-label" for="input01">Phone Number</label>
	      <div class="controls">
	        <input type="text" class="input-xlarge" id="phone" name="phone" rel="popover">
	       
	      </div>
	</div>

	
	<div class="control-group">
		<label class="control-label" for="input01">Password</label>
	      <div class="controls">
	        <input type="password" class="input-xlarge" id="pwd" name="pwd" rel="popover">
	       
	      </div>
	</div>
	<div class="control-group">
		<label class="control-label" for="input01">Confirm Password</label>
	      <div class="controls">
	        <input type="password" class="input-xlarge" id="cpwd" name="cpwd" rel="popover">
	       
	      </div>
	</div>
	
		
	<div class="control-group">
		<label class="control-label" for="input01"></label>
	      <div class="controls">
	       <button type="submit" class="btn btn-success" rel="tooltip" title="first tooltip">Create My Account</button>
	       
	      </div>
	
	</div>
	
	
	   
	  </fieldset>
	</form>
	</div>
	
		</div>
        
        
          </div><!--/row-->
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
	 <div class="container">
        <p>&copy; 2012 Robert Collazo</p>
</div>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://getbootstrap.com/2.3.2/assets/js/jquery.js"></script>
    <script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-transition.js"></script>
    <script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-alert.js"></script>
    <script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-modal.js"></script>
    <script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-dropdown.js"></script>
    <script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-scrollspy.js"></script>
    <script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-tab.js"></script>
    <script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-tooltip.js"></script>
    <script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-popover.js"></script>
	<script type="text/javascript" src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script>
	  <script type="text/javascript">
	  $(document).ready(function(){
			$('input').hover(function()
			{
			$(this).popover('show')
		});
			$("#registerHere").validate({
				rules:{
					first_name:"required",
					last_name:"required",
					user_email:{
							required:true,
							email: true
						},
					pwd:{
						required:true,
						minlength: 8
					},
					cpwd:{
						required:true,
						equalTo: "#pwd"
					},
				phone:{
			      required:true,
				  number: true,
				  minlength: 10,
				  maxlength: 10
			      }
				},
				messages:{
					first_name:"Enter your first name",
					last_name:"Enter your last name",
					user_email:{
						required:"Enter your email address",
						email:"Enter valid email address"
					},
					pwd:{
						required:"Enter your password",
						minlength:"Password must be minimum 8 characters"
					},
					cpwd:{
						required:"Enter confirm password",
						equalTo:"Password and Confirm Password must match"
					},
					phone:"Enter your phone number (numbers only please!)"
				},
				errorClass: "help-inline",
				errorElement: "span",
				highlight:function(element, errorClass, validClass) {
					$(element).parents('.control-group').addClass('error');
				},
				unhighlight: function(element, errorClass, validClass) {
					$(element).parents('.control-group').removeClass('error');
					$(element).parents('.control-group').addClass('success');
				}
			});
		});
	  </script>


  

  </body>
</html>
