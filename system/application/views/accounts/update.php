	
	<link rel="stylesheet" href="css/themes/ui-lightness/jquery-ui-1.8.16.custom.css" type="text/css" />	
	
	<script  type="text/javascript" src="js/jquery/jquery-ui-1.8.16.custom.min.js"></script>	
	<script  type="text/javascript" src="js/jquery/jquery.validate.js"></script>
	<!--<script  type="text/javascript" src="js/accounts/account.js"></script>-->
	
	<style  type="text/css">
		
		radio.error, input.error, select.error{		
			border: 1px solid red !important;		
		}
		
		label.error{
			display:none !important;
		}
		
		span.req{
			color:red;
			font-weight: bold;
		}		
	</style>
	
	<script type="text/javascript">
		
		$(function(){
			
			//account.init();
			
			jQuery.validator.messages.required = "";
			$("#agentForm").validate({
			submitHandler: function(form) {
					var con = confirm("Save Changes?");
					if( con )
						form.submit();
				},
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
					centers1: {
						required: true
					},
					supervisor1: {
						required: true
					},
					fname: {
						required: true,
						minlength: 2,
						maxlength: 30
					},
					lname: {
						required: true,
						minlength: 3,
						maxlength: 30						
					},
					password: {
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
				<h4>Update Account</h4>
		
			</div>
			<div class="error" style="display:none; padding: 5px 0px 0px 90px; color:red"><span></span></div>
			<div class="portlet-content">
			
				<div id="agent" class="portlet-content">				
												
					<form  name="agentForm" id="agentForm" action="auth/updateUser" method="post" class="form label-inline">
						
						
						<input type="hidden" name="userid" id="type" value="<?php echo $users->id; ?>" />
					

						
						<div class="field">						
							<label for="utype">User Access Type </label>
							<select id="utype" name="utype" class="medium required">
								<optgroup label="Select Access Type" >	
									<option value="3" <?php echo ($users->role_id == 3)?'selected="selected"':''; ?>>Agent</option>
									<option value="4" <?php echo ($users->role_id == 4)?'selected="selected"':''; ?>>Auditor/Sup</option>
                                                                        <option value="5" <?php echo ($users->role_id == 5)?'selected="selected"':''; ?>>Visitor</option>
									<option value="2" <?php echo ($users->role_id == 2)?'selected="selected"':''; ?>>Admin</option>
								</optgroup>	
							</select>		
						</div>
							
						<div class="field">
							<label for="centers">Center </label>
							<select id="centers1" name="centers" class="medium required">

								<optgroup label="Select Center">
									<?php foreach($centers as $row): 
										$selectedcenter = "";
										if( $row->centerid == $users->centerid ){
											$selectedcenter = 'selected="selected"';
										}
									?>
										<option value="<?php echo $row->centerid; ?>" <?php echo $selectedcenter; ?> ><?php echo $row->centerdesc; ?></option>
									<?php 									
										endforeach; 
									?>
			
								</optgroup>
							</select>
						</div>					
						
						<!--
						<div class="field">
							<label for="supervisor">Supervisor </label>
							<select id="supervisor1" name="supervisor"  class="medium required">
								<optgroup label="Select Supervisor">			
								</optgroup>
							</select>
						</div>				-->
						<div class="field"><label for="username">Username <span class="req">*</span></label> <input id="username" name="username"  type="text" class="medium required" readonly="readonly" value="<?php echo $users->username; ?>"/></div>
						<div class="field"><label for="password">Password <span class="req">*</span></label> <input id="password"  name="password" type="text" class="medium required" value="<?php echo $users->password; ?>" /></div>
						
						
						<div class="field"><label for="fname">First Name <span class="req">*</span></label> <input id="fname" name="fname"  type="text" class="medium required" value="<?php echo $users->fname; ?>"/></div>		
						<div class="field"><label for="lname">Last Name <span class="req">*</span></label> <input id="lname" name="lname"  type="text" class="medium required" value="<?php echo $users->lname; ?>" /></div>					

						<br />
						<div class="buttonrow">
							<button class="btn" type="submit" value="save">Save</button>
							<button class="btn" type="button" onclick="javascript:history.go(-1)">Cancel</button>
						</div>

					</form>

					<br /><br />
					<br /><br />
					
				</div>
				
			</div>
		</div>
		
		
		<!--<div class="portlet x3">
			<div class="portlet-header"><h4>Sidebar</h4></div>
			
			<div class="portlet-content">
				
				<p></p>
				
			</div>			
		</div>-->
		
		
	</div> <!-- #content -->
