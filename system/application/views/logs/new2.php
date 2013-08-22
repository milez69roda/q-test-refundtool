	
	<link rel="stylesheet" href="css/themes/ui-lightness/jquery-ui-1.8.16.custom.css" type="text/css" />
	
	<script  type="text/javascript" src="js/jquery/jquery-ui-1.8.16.custom.min.js"></script>
	<script  type="text/javascript" src="js/jquery/jquery.validate.js"></script>
	

	
	<style  type="text/css">
		
		textarea.error, input.error, select.error{		
			border: 1px solid red !important;		
		}
		
		label.error{
			display:none !important;
		}
		
		.form .field {
			margin-bottom: 0.5em !important;
		}	

		span.req{
			color:red;
			font-weight: bold;
		}
		
		#invoice ul{
			width: 50% !important;
		}	

		#invoice_actions a{
			text-decoration:none !important;
		}		

	</style>

	<script type="text/javascript">
		
		$(function(){
			
			$("#invdate").datepicker({ dateFormat: 'yy-mm-dd' ,
										onSelect: function(dateText, inst) { 
													$("#supplier").focus();
												}
									});
			
			jQuery.validator.messages.required = "";
			
			$("#newForm").validate({
				submitHandler: function(form) {
					var con = confirm("Do you want to save this log?");
					if( con ){
						$("#submitloading").show();			
						var data = $("#newForm").serialize();
						$.ajax({
							type:"POST",
							url: "<?php echo base_url(); ?>logsajax/savebasicInfo",
							data: data,
							success: function(data, xhr){
								var result = jQuery.parseJSON(data);
								
								if( result.status){
									$("#submitloading").hide();			
									alert("Successfully Save");
									window.location = "<?php echo base_url(); ?>dashboard/listing";
								}
							}
						});							
					}	
						
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
				}

				
			});
			

			
			$("#brand").change( function(){
				 var gl = $("#brand option:selected").attr("data");
				 $("#glaccount").attr("value", gl);
			})
			

			
			$("#custfname").blur( function(){
				
				var fname = jQuery.trim($(this).val()).substr(0,1).toLowerCase();
				var lname = jQuery.trim($("#custlname").val()).toLowerCase();
				
				$("#supsitenum").attr("value", lname+fname);
				
			});
			
			$("#custlname").blur( function(){ 
				
				var fname  = jQuery.trim($("#custfname").val()).substr(0,1).toLowerCase();
				var lname = jQuery.trim($(this).val()).toLowerCase();
				
				$("#supsitenum").attr("value", lname+fname);
				
			});
			
			$("#invoice_btn").click( function(){
				$("#invoice_items").toggle();
				$("#additem_btn").toggle();
				
				return false;
			});
			
			addItem();
			
			$(".add1").live("click",function(){
				addItem();
				return false;
			});
			
 			
			//calculate the qty * unit price
			$(".calprice").live("keyup", function(){
				
				var id = ($(this).attr("id")).split("_");
				
				var qty = $("#qty_"+id[1]).val();
				var price = $("#price_"+id[1]).val();
				
				var total = (qty*price);
				$("#total_"+id[1]).attr("value", total.toFixed(2));
				
				calculate();
			})
			
			$(".del1").live("click", function(){
				
				var rowCount = $('#invoice_item_row >tbody >tr').length;
				
				if( rowCount > 1 ){
					var id = ($(this).attr("id")).split("_");
					$("#tr_"+id[1]).remove().fadeOut("normal");
				}
				
				calculate();
				
				return false;
			})
			
		});
		
		function addItem(){
		
			var myDate = new Date();
			var newDate = myDate.getTime() + 2 * 24 * 60 * 60 * 1000;
						
			$.ajax({
				type:"GET",
				url: "logsajax/itemstemplate/"+newDate,
				success: function(data, xhr){
					$("#invoice_item_row tbody").append(data);
				}
			});

		}
		
		function calculate(){
		
			var linetotal = 0;
			var saletax = 0;
			var grandtotal = 0;
			
			$(".linetotal").each( function(index){
				
				
				var stat = $(this).attr("data");			
				var curVal = $(this).val();
				if( stat == 1 ){

					if( isNumeric(curVal)){ 
						linetotal += parseFloat($(this).val());	
					
					}
				}				
			})
			
			var taxpercent = ($("#taxtpercent").attr("value") != "")?parseFloat($("#taxtpercent").attr("value"))/100:0;
			
			linetotal = parseFloat(linetotal);				
			$("#subtotal").attr("value", linetotal.toFixed(2));
			
			saletax = parseFloat(linetotal * taxpercent);
			$("#saletax").attr("value", saletax.toFixed(2));
			
			var otherTaxes = parseFloat($("#otherTaxes").attr("value"));
			
			grandtotal = parseFloat(saletax+linetotal+otherTaxes);
			$("#grandtotal").attr("value", grandtotal.toFixed(2));	
		
		}
		
		function itemchange(obj){
		
			var name = obj.value;
		
			var id = (obj.id).split("_");
			

			$.ajax({
				type:"GET",
				url: "logsajax/itemscatdesctpl/"+name,
				success: function(data, xhr){
					$("#tddesc_"+id[1]).html('<input type="text" id="itemdesc_'+id[1]+'" name="itemdesc_'+id[1]+'" class="xxlarge required" value="'+data+'"/>');
				}
			});
			
		}
		
	function isNumeric(input) {
		var number = /^\-{0,1}(?:[0-9]+){0,1}(?:\.[0-9]+){0,1}$/i;
		var regex = RegExp(number);
		return regex.test(input) && input.length>0;
	}		
		

	</script>
	
	<div id="content" class="xfluid">
				
		<div class="portlet x12" id="invoice">
			<div class="portlet-header">			
				<h4><?php echo $hTitle; ?></h4>
		
			</div>
			<div class="error" style="display:none; padding: 5px 0px 0px 90px; color:red"><span></span></div>
			
			<div class="portlet-content">
			
				<form name="newForm" id="newForm" action="<?php echo base_url(); ?>logsajax/savebasicInfo" method="post" class="form label-inline">
				
					<ul class="client_details">
						<li>
							<div class="field">
								<label for="custfname">Customer Name <span class="req">*</span></label> 
								<input id="custfname"  name="custfname" type="text" class="small required" />
								<input id="custlname"  name="custlname" type="text" class="small required" />
							</div>						
						</li>
						<li><div class="field"><label for="addrline2">Address Line 2 <span class="req">*</span></label> <input id="addrline2"  name="addrline2" type="text" class="medium required" /></div></li>
						<li><div class="field"><label for="addrline3">Address Line 3</label> <input id="addrline3"  name="addrline3" type="text" class="medium" /></div></li>
						<li><div class="field"><label for="country">Country <span class="req">*</span></label></label> <input id="country"  name="country" type="text" class="medium required" /></div></li>
						<li><div class="field"><label for="city">City <span class="req">*</span></label> <input id="city"  name="city" type="text" class="medium required" /></div></li>
						<li><div class="field">
						<label for="state">State <span class="req">*</span></label> 
						<select class="required" name="state" id="state">
							<option value=""> --- Select State --- </option>
							<?php 							
								$us= '';
								$canada = '';
								foreach( $states as $srow): 
									
									if($srow->country == 0){
									//	$us .= '<option value="'.$srow->state_usps.'">'.$srow->state_usps.' - '.$srow->state_desc.'</option>';
										$us .= '<option value="'.$srow->state_usps.'">'.$srow->state_usps.'</option>';
									}	
									if($srow->country == 1)
										///$canada .= '<option value="'.$srow->state_usps.'">'.$srow->state_usps.' - '.$srow->state_desc.'</option>';
										$canada .= '<option value="'.$srow->state_usps.'">'.$srow->state_usps.'</option>';
								?>
								
							<?php endforeach; ?>
							<optgroup label="US"><?php echo $us; ?></optgroup>
							<optgroup label="Canada"><?php echo $canada; ?></optgroup>
						</select>
						</div></li>						
						<li><div class="field"><label for="zip">Zip Code <span class="req">*</span></label> <input id="zip"  name="zip" type="text" class="medium required" /></div></li>
						
					</ul>
					
					<ul class="invoice_details">
						<li><div class="field"><label for="invdate">Invoice Date <span class="req">*</span></label> <input id="invdate" readonly="readonly"  name="invdate" type="text" class="medium required" /></div></li>
						<li><div class="field"><label for="webcsr">WebCSR ticket #  <span class="req">*</span></label> <input id="webcsr"  name="webcsr" type="text" class="medium required" /></div></li>
						<li>
							<div class="field">
								<label for="supplier">Supplier Num <span class="req">*</span></label>
								<select id="supplier" name="supplier" class="medium required">								
									<?php foreach($supplier as $row): ?>
									<option value="<?php echo $row->supplier_name; ?>"><?php echo $row->supplier_name; ?></option>
									<?php endforeach; ?>
										
								</select>
							</div>							
						</li>
						<li><div class="field"><label for="supsitenum">Supplier Site Num <span class="req">*</span></label> <input id="supsitenum" readonly="readonly"  name="supsitenum" type="text" class="medium required" /></div></li>
						<li><div class="field"><label for="invnum">Kana ID/Invoice # <span class="req">*</span></label> <input id="invnum"  name="invnum" type="text" class="medium required" /></div></li>						
						<li>
							<div class="field">
								<label for="brand">Brand <span class="req">*</span></label>
								<select id="brand" name="brand" class="medium required">
									<option data="" value=""> ---select--- </option>
									<?php foreach($brand as $row): ?>
									<option value="<?php echo $row->brand_name; ?>" data="<?php echo $row->gl_account; ?>" ><?php echo $row->brand_name; ?></option>
									<?php endforeach; ?>
								</select>
							</div>							
						</li>
						<li><div class="field"><label for="glaccount">GL Account <span class="req">*</span></label> <input id="glaccount" name="glaccount" type="text" readonly="readonly" class="medium required" /></div></li>
						
						
					</ul>
					
					<div class="field"><label for="invdescer">Invoice Description <span class="req">*</span></label> 						
						<textarea name="invdescer" cols="50" rows="3" class="required"></textarea>
					</div>
					<div class="field"><label for="reason">Reason <span class="req">*</span></label> 						
						<textarea name="reason" cols="50" rows="4" class="required"></textarea>
					</div>
					
					
					<br />
					<div style="width: 90%; float:left; padding-bottom: 8px">

					</div>
					
					<div class="xbreak"></div>	
				
					<div id="invoice_items">
						 
						<table id="invoice_item_row" cellpadding="0" cellspacing="0" border="0" >
							
							<thead>
								<tr>
									<th>Qty</th>
									<th>Item #</th>
									<th>Description</th>
									<th class="price">Unit Price</th>
									<th class="total">Line Total</th>
									<th>Action</th>
								</tr>
							</thead>	
							
							<tbody>
							</tbody>
							
							<tfoot>
								<tr>
									<td class="sub_total" colspan="3">&nbsp;</td>
									<td class="sub_total">Subtotal:</td>
									<td class="sub_total" style="padding-right:10px"><input type="text" class="small" name="subtotal" id="subtotal"  readonly="readonly" value="" /> </td>
									<td></td>
								</tr>
								<tr>
									<td class="sub" colspan="2">&nbsp;</td>
									<td class="sub">Tax %  <span class="req">*</span> <input type="text" style="width:40px;" class="small calprice required" name="taxtpercent" id="taxtpercent" value="0"/></td>
									<td class="sub">Sales Tax:</td>
									<td class="sub" style="padding-right:10px"><input type="text" class="small" name="saletax" id="saletax" readonly="readonly"  value="" /></td>
									<td></td>
								</tr>

								<tr>
									<td class="sub" colspan="2">&nbsp;</td>
									<td class="sub">&nbsp;</td>
									<td class="sub">Other</td>
									<td class="sub" style="padding-right:10px"><input type="text" class="small calprice" name="otherTaxes" id="otherTaxes"  value="0.00" /></td>
									<td></td>
								</tr>								
								<tr>
									<td class="grand_total" colspan="3"></td>
									<td class="grand_total">Total:</td>
									<td class="grand_total" style="padding-right:10px"><input type="text" class="small" name="grandtotal" id="grandtotal"  readonly="readonly" value="" /></td>
									<td></td>
								</tr>								
							</tfoot>
						</table>
						<div style="width: 90%; float:left; padding-bottom: 8px">
							<!--<button type="submit" class="btn" name="savebtn" value="save" style="float: right">Save</button>	-->
							
							<div id="submitloading" style="display:none; font-weight:bold; color: green">Please wait, saving....</div>		
							<input type="submit" class="btn" name="savebtn" value="save" style="float: right" />
						</div>
						
					</div>
				
				</form>
				
			</div>
			
		
		</div>
		
		<!--
		<div class="portlet x2">
			<div class="portlet-header"><h4>Information</h4></div>
			
			<div class="portlet-content">
				
				
				<p><strong>Customer Name </strong> - {First Name, Last Name}</p>
				
				<p><strong>Address Line 2 </strong> - Customer's Street Address</p>
				<p><strong>Address Line 3 </strong> - Apt #</p>
				
				<br />
				<br />
				
				<p>Mark <span class="req">*</span> Fields are required</p>
				
			</div>			
		</div>-->
		
	</div> <!-- #content -->