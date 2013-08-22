	<link rel="stylesheet" href="css/themes/ui-lightness/jquery-ui-1.8.16.custom.css" type="text/css" />
	
	<script  type="text/javascript" src="js/jquery/jquery-ui-1.8.16.custom.min.js"></script>
	<script  type="text/javascript" src="js/jquery/jquery.validate.js"></script>
	
	
	<style  type="text/css">
		
		input.error, select.error{		
			border: 1px solid red !important;		
		}
		
		/*label.error{
			display:none !important;
		}*/
		
		.form .field {
			margin-bottom: 0.5em !important;
		}	

		span.req{
			color:red;
			font-weight: bold;
		}
	</style>

	<script type="text/javascript">
		
		$(function(){
			
			$("#inv_date").datepicker({ dateFormat: 'yy-mm-dd' });
			
			jQuery.validator.messages.required = "";
			$("#newForm").validate({
				submitHandler: function(form) {
					var con = confirm("Do you want to save this log?");
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
				}/*,  
				rules: {
					inv_amnt: {
					  required: true,
					  digits: true
					}
			  }*/

				
			});
			
			$("#brand").live( 'change',  function(){
				
				var gl = $("#brand option:selected").attr("data");
				$("#glaccount").attr("value", gl);

			});
			
			$("#custfname").blur( function(){
				
				var fname = jQuery.trim($(this).val()).substr(0,1).toLowerCase();
				var lname = jQuery.trim($("#custlname").val()).toLowerCase();
				
				$("#sup_site_num").attr("value", lname+fname);
				
			});
			
			$("#custlname").blur( function(){ 
				
				var fname  = jQuery.trim($("#custfname").val()).substr(0,1).toLowerCase();
				var lname = jQuery.trim($(this).val()).toLowerCase();
				
				$("#sup_site_num").attr("value", lname+fname);
				
			});
			
			
		})
		
		/* function brandOnchange(s){
			var gl = $("#brand option:selected").attr("data");
			$("#glaccount").attr("value", gl);
			//lert(s.id);
		}	 */	
		
	</script>
	
	<div id="content" class="xfluid">
				
		<div class="portlet x9">
			<div class="portlet-header">			
				<h4>Create New Log</h4>
		
			</div>
			<div class="error" style="display:none; padding: 5px 0px 0px 90px; color:red"><span></span></div>
			<div class="portlet-content">

				<div id="changepass" class="portlet-content">
					
												
					<form name="newForm" id="newForm" action="dashboard/newlog" method="post" class="form label-inline">
						
						<div class="field"><label for="custfname">Customer First Name <span class="req">*</span></label> <input id="custfname"  name="custfname" type="text" class="medium required" /></div>
						<div class="field"><label for="custlname">Customer Last Name <span class="req">*</span></label> <input id="custlname"  name="custlname" type="text" class="medium required" /></div>
						
						<div class="field">
							<label for="supplier">Supplier Num <span class="req">*</span></label>
							<select id="supplier" name="supplier" class="medium required">								
								<?php foreach($supplier as $row): ?>
								<option value="<?php echo $row->supplier_name; ?>"><?php echo $row->supplier_name; ?></option>
								<?php endforeach; ?>
									
							</select>
						</div>	

						<div class="field"><label for="sup_site_num">Supplier Site Num <span class="req">*</span></label> <input id="sup_site_num" readonly="readonly"  name="sup_site_num" type="text" class="medium required" /></div>
						<!--<div class="field"><label for="addr_line1">Address Line 1</label> <input id="addr_line1"  name="addr_line1" type="text" class="large required" /></div>-->
						<div class="field"><label for="addr_line2">Address Line 2 <span class="req">*</span></label> <input id="addr_line2"  name="addr_line2" type="text" class="xlarge required" /></div>
						<div class="field"><label for="addr_line3">Address Line 3</label> <input id="addr_line3"  name="addr_line3" type="text" class="medium" /></div>
						<div class="field"><label for="country">Country</label> <input id="country"  name="country" type="text" class="medium" /></div>
						<div class="field"><label for="state">State <span class="req">*</span></label> <input id="state"  name="state" type="text" class="medium required" /></div>
						<div class="field"><label for="city">City <span class="req">*</span></label> <input id="city"  name="city" type="text" class="medium required" /></div>
						<div class="field"><label for="zip">Zip Code <span class="req">*</span></label> <input id="zip"  name="zip" type="text" class="medium required" /></div>
						<div class="field"><label for="inv_num">Kana ID/Invoice # <span class="req">*</span></label> <input id="inv_num"  name="inv_num" type="text" class="medium required" /></div>
						<div class="field"><label for="inv_date">Invoice Date <span class="req">*</span></label> <input id="inv_date" readonly="readonly"  name="inv_date" type="text" class="medium required" /></div>
						<div class="field"><label for="inv_amnt">Invoice Amount <span class="req">*</span></label> <input id="inv_amnt"  name="inv_amnt" type="text" class="medium required" /></div>
						<div class="field"><label for="inv_descer">Invoice Description <span class="req">*</span></label> <input id="inv_descer"  name="inv_descer" type="text" class="medium required" /></div>
							
						<div class="field">
							<label for="brand">Brand <span class="req">*</span></label>
							<select id="brand" name="brand" class="medium required">
								<option data="" value=""> ---select--- </option>
								<?php foreach($brand as $row): ?>
								<option value="<?php echo $row->brand_name; ?>" data="<?php echo $row->gl_account; ?>" ><?php echo $row->brand_name; ?></option>
								<?php endforeach; ?>
							</select>
						</div>	
						
						<div class="field"><label for="glaccount">GL Account <span class="req">*</span></label> <input id="glaccount" name="glaccount" type="text" readonly="readonly" class="medium required" /></div>
						
						
						<br />
						<div class="buttonrow">
							<button class="btn" name="savebtn" value="save">Save</button>
						</div>

					</form>

					<br /><br />
					<br /><br />
					
				</div>					
				
				
			</div>
		</div>
		
		
		<div class="portlet x3">
			<div class="portlet-header"><h4>Information</h4></div>
			
			<div class="portlet-content">
				
				<!--<p><strong>Address Line 1 </strong> - Combination of customer's last name and first name initial</p>-->
				<p><strong>Address Line 2 </strong> - Customer's Street Address</p>
				<p><strong>Address Line 3 </strong> - Apt #</p>
				
				<br />
				<br />
				
				<p>Mark <span class="req">*</span> Fields are required</p>
				
			</div>			
		</div>
		
	</div> <!-- #content -->