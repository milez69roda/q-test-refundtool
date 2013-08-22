	
	<script  type="text/javascript" src="js/jquery/jquery.validate.js"></script>
	
	<style  type="text/css">
		
		input.error, select.error{		
			border: 1px solid red !important;		
		}
		
		label.error{
			display:none !important;
		}
	</style>

	<script type="text/javascript">
		
		$(function(){
			
			
			jQuery.validator.messages.required = "";
			$("#changepassForm").validate({
				invalidHandler: function(e, validator) {
					var errors = validator.numberOfInvalids();
					if (errors) {
						var message = errors == 1
							? 'You missed 1 field. It has been highlighted below'
							: 'You missed ' + errors + ' fields.  They have been highlighted below';
						$("div.error span").html(message);
						$("div.error").show();
					} else {
						$("div.error").hide();
					}
				},
				rules: {
					newpassword: {
						required: true,
						minlength: 5,
						maxlength: 20
					}
				}
			});
			
			
		})
		
		
	</script>
	
	<div id="content" class="xfluid">
				
		<div class="portlet x9">
			<div class="portlet-header">			
				<h4>Acount Information</h4>
		
			</div>
			<div class="error" style="display:none; padding: 5px 0px 0px 90px; color:red"><span></span></div>
			<div class="portlet-content">

				<div id="changepass" class="portlet-content">
					
												
					<form name="changepassForm" id="changepassForm" action="account/changepassword/" method="post" class="form label-inline">
						
						<input type="hidden" name="type" id="type" value="2" />
						<input type="hidden" name="center" id="center3" value="7" />
								
						<div class="field"><label for="fname">First Name </label><?php echo $info->fname; ?></div>		
						<div class="field"><label for="lname">Last Name </label><?php echo $info->lname; ?></div>					
						<div class="field"><label for="username">Username</label><?php echo $info->username; ?></div>
						<div class="field"><label for="password">Password</label><?php echo $info->password; ?></div>
						<div class="field"><label for="newpassword">New Password</label> <input id="newpassword"  name="newpassword" type="text" class="large required" /></div>
						<br />
						<div class="buttonrow">
							<button class="btn" name="changepassbtn" value="Change Password">Change Password</button>
						</div>

					</form>

					<br /><br />
					<br /><br />
					
				</div>					
				
				
			</div>
		</div>
		
		
		<div class="portlet x3">
			<div class="portlet-header"><h4>Note</h4></div>
			
			<div class="portlet-content">
				
				<p style="color:red">Password must be at least 5 characters</p>
				
			</div>			
		</div>
		
	</div> <!-- #content -->