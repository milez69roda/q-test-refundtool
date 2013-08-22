<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Refund Log</title>	
	<base href="<?php echo base_url()?>"/>
	
	<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="no title" charset="utf-8" />	
	<link rel="stylesheet" href="css/plugin.css" type="text/css" media="screen" title="no title" charset="utf-8" />	
	<link rel="stylesheet" href="css/custom.css" type="text/css" media="screen" title="no title" charset="utf-8" />		
	
		
	
		
	<style type="text/css" media="screen">
	
	</style>

	<script  type="text/javascript" src="js/jquery/jquery.1.4.2.min.js"></script>
	<script  type="text/javascript" src="js/slate/slate.js"></script>
	<script  type="text/javascript" src="js/slate/slate.portlet.js"></script>
	<script  type="text/javascript" src="js/plugin.js"></script>

	<script type="text/javascript" charset="utf-8">
	
		$(function () 
		{
			slate.init ();
			slate.portlet.init ();	
		});
	
	</script>
	
	
</head>

<body>
	
<div id="wrapper" class="clearfix">
	
	<div id="top">
		<div id="header">
			<h1><a href="">Refund Logger Tool</a></h1>
			
			<div id="info">
				<h4>Welcome <?php echo $this->session->userdata('DX_firstname'); ?></h4>
				
				<p>
					Logged in as <?php echo $this->session->userdata('DX_role_name'); ?>(<a href="auth/logout">Logout</a>)
					<br />
					<!--You have <a href="javascript:;">5 messages</a>-->
				</p>
				
				<img src="images/avatar.jpg" alt="avatar" />
			</div> <!-- #info -->
					
		</div> <!-- #header -->	
		
		
		<div id="nav">	
	
			<ul class="mega-container mega-grey">
				<!-- current -->
				<!--<li class="mega mega-">
					<a href="" class="mega-link">Dashboard</a>	
				</li>-->
				<!--
				<li class="mega">				
					<a href="dashboard/newlog" class="mega-link">New</a>
				</li>-->
				<?php if( $this->session->userdata('DX_role_id') != 5): ?> 
				<li class="mega">				
					<a href="dashboard/newtemp" class="mega-link">New</a>
				</li>	
				<?php endif; ?>
				<li class="mega">				
					<a href="dashboard/listing" class="mega-link">Logs</a>
				</li>	

				<li class="mega">				
					<a href="javascript:;" class="mega-tab">
						Manage Accounts
					</a>
					
					<div class="mega-content mega-menu ">
						<ul>
							<?php 
								if( $this->session->userdata('DX_role_id') != 3 AND $this->session->userdata('DX_role_id') != 5):
							?>
							<li><a href="account/">Listing</a></li>
							<li><a href="account/newaccount">Create Account</a></li>
							<?php
								endif;
							?>
							<li><a href="account/changepassword">Change My Password</a></li>
						</ul>
					</div>						
				</li>				
				
			</ul>
		</div> <!-- #nav -->
	</div> <!-- #top -->
