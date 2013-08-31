<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>TextMe Message Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="http://getbootstrap.com/2.3.2/assets/css/bootstrap.css"
  rel="stylesheet" type="text/css">
  <link href=
  "http://getbootstrap.com/2.3.2/assets/css/bootstrap-responsive.css"
  rel="stylesheet" type="text/css">
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
  require_once('Services/Twilio.php');
require_once('lib/globals.inc.php');
$client = new Services_Twilio($sid, $token);
$message = $client->account->sms_messages->create(
						  '2105260430', // From a valid Twilio number
						  $_POST['phone'], // Text this number
						  $_POST['textmessage']
						  );

print $message->status;
  print_r($_POST);
        } ?>

        <form class="form-horizontal" id="registerHere" method='post'
        action=''>
          <fieldset>
            <legend>TextMe Message</legend>

            <div class="control-group">
              <label class="control-label" for="input01">Send Message
              to</label>

              <div class="controls">
                <select name="phone" id="phone">
                  <option value="all">
                    All
                  </option>

                  <option value="">
                    -------
                  </option>

   <?php
                      require_once('lib/functions.inc.php');

                      $sql = "SELECT first_name, last_name, email, phone FROM users WHERE enabled=1";
                    try {
                      $db = getConnection();
                      $stmt = $db->prepare($sql);
                      $stmt->execute();
                      while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . $result['phone'] . '">' . $result['email'] . "</option>\n";
                      }
                      $db = null;
                    } catch(PDOException $e) {
                      error_log($e->getMessage());
                      }
                      ?>
                </select>
              </div>

              <div class="control-group">
                <label class="control-label" for="input01">Message</label>

                <div class="controls">
                  <input type="textarea" class="span6 input-xlarge" id="textmessage"
                  name="textmessage" rows="6" cols="160" placeholder="Please enter a short message (< 160 characters)" rel="popover"></textarea>
                </div>
              </div>

              <div class="control-group">
                <div class="controls">
                  <button type="submit" class="btn btn-success" rel=
                  "tooltip" title="first tooltip">Send Message</button>
                </div>
              </div>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div><!--/row-->
  <!--/span-->
  <!--/row-->
  <hr>

  <footer>
    <div class="container">
      <p>© 2012 Robert Collazo</p>
    </div>
  </footer><!--/.fluid-container-->
  <!-- Le javascript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="http://getbootstrap.com/2.3.2/assets/js/jquery.js"
  type="text/javascript">
</script><script src=
"http://getbootstrap.com/2.3.2/assets/js/bootstrap-transition.js"
type="text/javascript">
</script><script src=
"http://getbootstrap.com/2.3.2/assets/js/bootstrap-alert.js" type=
"text/javascript">
</script><script src=
"http://getbootstrap.com/2.3.2/assets/js/bootstrap-modal.js" type=
"text/javascript">
</script><script src=
"http://getbootstrap.com/2.3.2/assets/js/bootstrap-dropdown.js"
  type="text/javascript">
</script><script src=
"http://getbootstrap.com/2.3.2/assets/js/bootstrap-scrollspy.js"
  type="text/javascript">
</script><script src=
"http://getbootstrap.com/2.3.2/assets/js/bootstrap-tab.js" type=
"text/javascript">
</script><script src=
"http://getbootstrap.com/2.3.2/assets/js/bootstrap-tooltip.js"
  type="text/javascript">
</script><script src=
"http://getbootstrap.com/2.3.2/assets/js/bootstrap-popover.js"
  type="text/javascript">
</script><script type="text/javascript" src=
"http://jzaefferer.github.com/jquery-validation/jquery.validate.js">
</script><script type="text/javascript">
        $(document).ready(function(){
                        $('input').hover(function()
                        {
                        $(this).popover('show')
                });
                        $("#registerHere").validate({
                                rules:{
                            phone:"required",
				textmessage:{
			      required:true,
				  minlength: 5,
				  maxlength: 160
                                        }
                            },
                                messages:{
                            phone:"Select someone to send a message to",
                                        textmessage:{
                                                required:"A text message is required",
				  minlength:"The message has to be at least 5 characters",
                                                maxlength:"The message can't be longer than 160 characters"
                                        }

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
