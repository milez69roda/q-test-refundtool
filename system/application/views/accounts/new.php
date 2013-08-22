	
	<script  type="text/javascript" src="js/jquery/jquery.validate.js"></script>
	<script  type="text/javascript" src="js/accounts/account.js"></script>
	
	<style  type="text/css">
		
		input.error, select.error{		
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
			
			account.init();
			
			jQuery.validator.messages.required = "";
			$("#agentForm").validate({
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
						minlength: 3,
						maxlength: 30
					},
					lname: {
						required: true,
						minlength: 3,
						maxlength: 30						
					},
					username: {
						required: true,
						minlength: 5,
						maxlength: 20,
						remote: {
							url: "auth/username_check2",
							type: "post",
							data: {
								username: function() {
									return $("#username").val();
								}
							}
						}
        
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
				<h4>Create New Account</h4>
				<ul class="portlet-tab-nav">
					<li class="portlet-tab-nav-active"><a href="#agent" rel="tooltip" title="Create New Agent">Agent</a></li>
					<?php if( $this->session->userdata('DX_role_id') == 2 ):?>		
					<li class=""><a href="#supervisor" rel="tooltip" title="Create New Supervisor.">Auditor/Sup</a></li>
					<?php 
						endif; 
						if( $this->session->userdata('DX_role_id') == 2 ):
					?>
					<li class=""><a href="#auditoruser" rel="tooltip" title="Create Visitor User">Visitor</a></li>
					<li class=""><a href="#miamiuser" rel="tooltip" title="Create New Miami User">Admin</a></li>
					<?php endif; ?>
				</ul>			
			</div>
			<div class="error" style="display:none; padding: 5px 0px 0px 90px; color:red"><span></span></div>
			<div class="portlet-content">
			
				<div id="agent" class="portlet-content">				
												
					<form  name="agentForm" id="agentForm" action="auth/adduser/" method="post" class="form label-inline">
						
						<input type="hidden" name="type" id="type" value="3" />
					
						<div class="field">
							<label for="centers">Center </label>
							<select id="centers1" name="centers" class="medium required">

								<optgroup label="Select Center">
									<?php foreach($centers as $row): ?>
										<option value="<?php echo $row->centerid; ?>"><?php echo $row->centerdesc; ?></option>
									<?php endforeach; ?>
			
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
						</div>-->
						<div class="field"><label for="username">Username <span class="req">*</span></label> <input id="username" name="username"  type="text" class="medium required" /></div>
						<div class="field"><label for="password">Password <span class="req">*</span></label> <input id="password"  name="password" type="text" class="medium required" /></div>						
						
						<div class="field"><label for="fname">First Name <span class="req">*</span></label> <input id="fname" name="fname"  type="text" class="medium required" /></div>		
						<div class="field"><label for="lname">Last Name <span class="req">*</span></label> <input id="lname" name="lname"  type="text" class="medium required" /></div>					
						

						<br />
						<div class="buttonrow">
							<button class="btn">Save</button>
						</div>

					</form>

					<br /><br />
					<br /><br />
					
				</div>
				<?php if( $this->session->userdata('DX_role_id') == 2 ):?>					
				<div id="supervisor" class="portlet-content">
					
												
					<form name="supervisorform" action="auth/adduser/" method="post" class="form label-inline">
						
						<input type="hidden" name="type" id="type" value="4" />
					
						<div class="field">
							<label for="type">Center </label>
							<select id="centers2" name="centers" class="medium">

								<optgroup label="Select Center">
									<?php foreach($centers as $row): ?>
										<option value="<?php echo $row->centerid; ?>"><?php echo $row->centerdesc; ?></option>
									<?php endforeach; ?>
			
								</optgroup>
							</select>
						</div>					
						
						<div class="field"><label for="username">Username <span class="req">*</span></label> <input id="username" name="username"  type="text" class="medium" /></div>
						<div class="field"><label for="password">Password <span class="req">*</span></label> <input id="password"  name="password" type="text" class="medium" /></div>
						
						<div class="field"><label for="fname">First Name <span class="req">*</span></label> <input id="fname" name="fname"  type="text" class="medium" /></div>		
						<div class="field"><label for="lname">Last Name <span class="req">*</span></label> <input id="lname" name="lname"  type="text" class="medium" /></div>					

						<br />
						<div class="buttonrow">
							<button class="btn">Save</button>
						</div>

					</form>

					<br /><br />
					<br /><br />
					
				</div>	

				<?php 
					endif; 
					if( $this->session->userdata('DX_role_id') == 2 ):
				?>				
				<div id="auditoruser" class="portlet-content">
					

					<form name="auditoruserform" id="auditoruserform" action="auth/adduser/" method="post" class="form label-inline">
						
						<input type="hidden" name="type" id="type" value="5" />
						<div class="field">
							<label for="type">Center </label>
							<select id="centers4" name="centers" class="medium">

								<optgroup label="Select Center">
									<?php foreach($centers as $row): ?>
										<option value="<?php echo $row->centerid; ?>"><?php echo $row->centerdesc; ?></option>
									<?php endforeach; ?>
			
								</optgroup>
							</select>
						</div>		

						<div class="field"><label for="username">Username <span class="req">*</span></label> <input id="username" name="username"  type="text" class="medium" /></div>
						<div class="field"><label for="password">Password <span class="req">*</span></label> <input id="password"  name="password" type="text" class="medium" /></div>

						<div class="field"><label for="fname">First Name <span class="req">*</span></label> <input id="fname" name="fname"  type="text" class="medium" /></div>		
						<div class="field"><label for="lname">Last Name <span class="req">*</span></label> <input id="lname" name="lname"  type="text" class="medium" /></div>	

						<br />
						<div class="buttonrow">
							<button class="btn">Save</button>
						</div>

					</form>

					<br /><br />
					<br /><br />
					
				</div>	

				<div id="miamiuser" class="portlet-content">
					
												
					<form name="miamiuserform" id="miamiuserform" action="auth/adduser/" method="post" class="form label-inline">
						
						<input type="hidden" name="type" id="type" value="2" />
						<input type="hidden" name="centers" id="center3" value="7" />
								
						<div class="field"><label for="username">Username <span class="req">*</span></label> <input id="username" name="username"  type="text" class="large" /></div>
						<div class="field"><label for="password">Password <span class="req">*</span></label> <input id="password"  name="password" type="text" class="large" /></div>
						
						<div class="field"><label for="fname">First Name <span class="req">*</span></label> <input id="fname" name="fname"  type="text" class="medium" /></div>		
						<div class="field"><label for="lname">Last Name <span class="req">*</span></label> <input id="lname" name="lname"  type="text" class="medium" /></div>					

						<br />
						<div class="buttonrow">
							<button class="btn">Save</button>
						</div>

					</form>

					<br /><br />
					<br /><br />
					
				</div>	
				
				<?php
					endif;
				?>
				
			</div>
		</div>
		
		
		<!--<div class="portlet x3">
			<div class="portlet-header"><h4>Sidebar</h4></div>
			
			<div class="portlet-content">
				
				<p></p>
				
			</div>			
		</div>-->
		
		
	</div> <!-- #content -->
