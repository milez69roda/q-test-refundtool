<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Refund Log</title>
	<base href="<?php echo base_url()?>"/>
	<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="no title" charset="utf-8" />	
	<link rel="stylesheet" href="css/plugin.css" type="text/css" media="screen" title="no title" charset="utf-8" />	
	<link rel="stylesheet" href="css/custom.css" type="text/css" media="screen" title="no title" charset="utf-8" />
	<link rel="stylesheet" href="css/login.css" type="text/css" media="screen" title="no title" charset="utf-8" />

</head>

<body >

<div id="login">
	
	<h1 id="title"><a href="#">Slate Admin</a></h1>
	
<div id="login-body" class="clearfix"> 

	         
	<!--<form action="index2.html" name="login" id="login_form" method="post">-->
	<?php //echo form_open($this->uri->uri_string()) ?>	
	
	<form action="auth/login" name="login" id="login_form" method="post">
		<?php echo form_error("username"); ?>
		<?php echo form_error("password"); ?>
	    <div class="content_front">

	        <div class="pad">
	        	
	        	<div class="field">
					<label>Username:</label>
					
					<div class="">
						<span class="input" style="text-align:left !important">
							<input name="username" id="login_email" class="text" type="text" value="" />
							
						</span>
					</div>
				</div> <!-- .field -->
				
				<div class="field">
					<label>Password:</label>

					<div class="">
						<span class="input">
							<input name="password" id="login_password" class="text" type="password" value="" /> 
							<!--<a style="" href="javascript:;" id="forgot_my_password">Forgot password?</a>-->
							
						</span>
					</div>
				</div> <!-- .field -->
		
				<div class="checkbox">
					
					<span class="label">&nbsp;</span>					
					<div class=""><!--<input name="remember" id="remember" class="checkbox" value="1" type="checkbox" /> &nbsp;&nbsp;<label style="display: inline;" for="remember">Remember me on this computer</label>--></div>
				</div><!-- .field -->

				
				<div class="field">
					<br />
					<span class="label">&nbsp;</span>					
					<div class="">
					<!--<button type="submit" class="btn" name="login" value="login">Login</button>	-->
					<input type="submit" class="btn" name="login" value="login" />
					</div>
				</div> <!-- .field -->
		

	        </div>
	    </div>

		
	</form>

</div>

</div> <!-- #login -->

</body>

</html>