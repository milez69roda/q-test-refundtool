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

	<script type="text/javascript">
		
		var t=setTimeout("alertMsg()",1000);
		
		function alertMsg(){
			window.location = "<?php echo base_url()?>dashboard/";
		}
	</script>
</head>

<body >

<div id="login">
	
	<h1 id="title"><a href="#">Slate Admin</a></h1>
	
	<div id="login-body" class="clearfix"> 

			<div class="content_front">

				<div class="pad">
					
					<p style="color:red">
						<?php echo $auth_message; ?>
					</p>
				</div>
			</div>


	</div>

</div> <!-- #login -->

</body>

</html>