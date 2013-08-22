	
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
		
		//Object itemCategory = new Object();
		
		$(function(){
		
			<?php if( $isAudit ): ?>
			
			$(".rxReadOnly").attr("readonly", "readonly");
			$(".del1").css("display", "none");
			$(".add1").css("display", "none");
			$(".req").css("display", "none");
			<?php endif;?>
			
			$("#invdate").datepicker({ dateFormat: 'yy-mm-dd' ,
										onSelect: function(dateText, inst) { 
													$("#supplier").focus();
												}
									});
			<?php if( !$isAudit ): ?>
			jQuery.validator.messages.required = "";
			$("#newForm").validate({
				submitHandler: function(form) {
					
					var con = confirm("Save Changes?");
					if( con ){
						//form.submit();
						var data = $("#newForm").serialize();
						$.ajax({
							type:"POST",
							url: "<?php echo base_url(); ?>logsajax/saveUpdate",
							data: data,
							success: function(data, xhr){
								var result = jQuery.parseJSON(data);
								
								if( result.status){
									alert("Updated Successfully");
									window.location = "<?php echo base_url(); ?>dashboard/listing";
								}
							}
						});							
					}
					/*var data = $("#newForm").serialize();
					$.ajax({
						type:"POST",
						url: "logsajax/saveUpdate",
						data: data,
						success: function(data, xhr){
							
						}
					});	*/					
						
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
			<?php else: ?>
				$("#savebtn").click( function(){
				
					var con = confirm("Do you want to save this log?");
					if( con ){
					
						var data = $("#newForm").serialize();
						
						//alert(data);
						$.ajax({
							type:"POST",
							url: "<?php echo base_url(); ?>logsajax/saveUpdate",
							data: data+"&savebtn=save",
							success: function(redata, xhr){
							
								var res = jQuery.parseJSON(redata);
								//console.log(redata);
								if( res.status ){
									alert("Updated Successfully");
									window.location = "<?php echo base_url(); ?>dashboard/listing";
								}else{
									alert("Failed to Updated");
								}
							}
						});	
						
						return false;
					}else{
						return false;
					}
					
				})
			<?php endif;?>
			
			
			/*  $("#brand").live( 'change',  function(){
				
				
				 var gl = $("#brand option:selected").attr("data");
				 $("#glaccount").attr("value", gl);

			}); */
			
			
			/* $("#state option").each( function(){
				var text = $(this).attr("text");
				
				$(this).attr("value", text);
			}) */
			
			
			$("#brand").change( function(){
				 var gl = $("#brand option:selected").attr("data");
				 $("#glaccount").attr("value", gl);
			})
			
			/* $("#brand").delegate(".portlet-content", "change", function() {
				var gl = $("#brand option:selected").attr("data");
				//$("#glaccount").attr("value", gl);			
				alert(gl);
				
			}); */

			
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
			
			//addItem();
			
			$(".add1").live("click",function(){
				addItem();
				return false;
			});
			

			
			/*$(".itemsCat").bind("onChange", function(){
				alert(1);
				var name = $(this).val();
				var id = ($(this).attr("id")).split("_");
				
				$.ajax({
					type:"GET",
					url: "logsajax/itemscatdesctpl/"+name,
					success: function(data, xhr){
						$("#tddesc_"+id[1]).html('<input type="text" id="itemdesc_'+id[1]+'" name="itemdesc_'+id[1]+'" class="xxlarge required" value="'+data+'"/>');
					}
				});	 	
			}) 	*/
			

			
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
				
				//var rowCount = $('#invoice_item_row >tbody >tr').length;
				var rowCount = $('.TR_Not_Deleted').length;
				
				if( rowCount > 1 ){
					
					var id = ($(this).attr("id")).split("_");
					
					$("#qty_"+id[1]).attr("data", 0);
					$("#qty_"+id[1]).removeClass("required");
					
					$("#price_"+id[1]).attr("data", 0);
					$("#price_"+id[1]).removeClass("required");
					
					$("#itemdesc_"+id[1]).removeClass("required");
					$("#type_"+id[1]).removeClass("required");
					
					$("#total_"+id[1]).attr("data", 0);
					$("#total_"+id[1]).removeClass("required");					
					
					$("#itemstatus_"+id[1]).attr("value", 0);
					
					$("#tr_"+id[1]).removeClass("TR_Not_Deleted");					
					$("#tr_"+id[1]).fadeOut("normal");
					
				}
				
				calculate();
				
				return false;
			})
			
			
			$("#logstatus_audit").change( function(){
				$("#logsname").attr("value", $("#"+$(this).attr("id")+" option:selected").text() );
				//alert( $("#"+$(this).attr("id")+" option:selected").text() );
				//alert( $("logsname").attr("value"));
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
			//var subtotal = 0;
			
			
			
			$(".linetotal").each( function(index){
				
				var stat = $(this).attr("data");			
				var curVal = $(this).val();
				if( stat == 1 ){
					//console.log( curVal+" "+isNumeric(curVal));
					if( isNumeric(curVal)){ 
						linetotal += parseFloat($(this).val());	
					
					}
				}
				
			});
			//alert(linetotal);
			
			var taxpercent = ($("#taxtpercent").attr("value") != "")?parseFloat($("#taxtpercent").attr("value"))/100:0;
			
			linetotal = parseFloat(linetotal);				
			$("#subtotal").attr("value", linetotal.toFixed(2));
			
			saletax = parseFloat(linetotal*taxpercent);
			$("#saletax").attr("value", saletax.toFixed(2));
			
			var otherTaxes = parseFloat($("#otherTaxes").attr("value"));
			
			grandtotal = parseFloat(saletax+linetotal+otherTaxes);
			$("#grandtotal").attr("value", grandtotal.toFixed(2));	

			//console.log(linetotal+" - "+saletax+" - "+grandtotal);			
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
			
				<form name="newForm" id="newForm" action="logsajax/saveUpdate" method="post" class="form label-inline">
					<input type="hidden" name="refId" id="refId"  value="<?php echo $refund->logid;?>" />
					<input type="hidden" name="isAudit"  value="<?php echo $isAudit ?>" />
					<input type="hidden" name="logstatus"  value="<?php echo $refund->log_status ?>" />
					<ul class="client_details">
						<li>
							<div class="field">
								<label for="custfname">Customer Name <span class="req">*</span></label> 
								<input id="custfname"  name="custfname" type="text" class="small required rxReadOnly" value="<?php echo $refund->cust_fname ?>" />
								<input id="custlname"  name="custlname" type="text" class="small required rxReadOnly" value="<?php echo $refund->cust_lname ?>"/>
							</div>						
						</li>
						<li><div class="field"><label for="addrline2">Address Line 2 <span class="req">*</span></label> <input id="addrline2"  name="addrline2" type="text" class="medium required rxReadOnly" value="<?php echo $refund->address_line2 ?>"/></div></li>
						<li><div class="field"><label for="addrline3">Address Line 3</label> <input id="addrline3"  name="addrline3" type="text" class="medium rxReadOnly" value="<?php echo $refund->address_line3 ?>"/></div></li>
						<li><div class="field"><label for="country">Country</label> <input id="country"  name="country" type="text" class="medium rxReadOnly" value="<?php echo $refund->country ?>"/></div></li>
						<li><div class="field"><label for="city">City <span class="req">*</span></label> <input id="city"  name="city" type="text" class="medium required rxReadOnly" value="<?php echo $refund->city ?>"/></div></li>
						<li><div class="field">
						<label for="state">State <span class="req">*</span></label> 
						<!--<input id="state"  name="state" type="text" class="medium required" />-->
						<!--<select id="state"  name="state" class="medium required" ><option value="">Select State</option><option value="AK">Alaska</option><option value="AL">Alabama</option><option value="AR">Arkansas</option><option value="AS">American Samoa</option><option value="AZ">Arizona</option><option value="CA">California</option><option value="CO">Colorado</option><option value="CT">Connecticut</option><option value="DC">D.C.</option><option value="DE">Delaware</option><option value="FL">Florida</option><option value="FM">Micronesia</option><option value="GA">Georgia</option><option value="GU">Guam</option><option value="HI">Hawaii</option><option value="IA">Iowa</option><option value="ID">Idaho</option><option value="IL">Illinois</option><option value="IN">Indiana</option><option value="KS">Kansas</option><option value="KY">Kentucky</option><option value="LA">Louisiana</option><option value="MA">Massachusetts</option><option value="MD">Maryland</option><option value="ME">Maine</option><option value="MH">Marshall Islands</option><option value="MI">Michigan</option><option value="MN">Minnesota</option><option value="MO">Missouri</option><option value="MP">Marianas</option><option value="MS">Mississippi</option><option value="MT">Montana</option><option value="NC">North Carolina</option><option value="ND">North Dakota</option><option value="NE">Nebraska</option><option value="NH">New Hampshire</option><option value="NJ">New Jersey</option><option value="NM">New Mexico</option><option value="NV">Nevada</option><option value="NY">New York</option><option value="OH">Ohio</option><option value="OK">Oklahoma</option><option value="OR">Oregon</option><option value="PA">Pennsylvania</option><option value="PR">Puerto Rico</option><option value="PW">Palau</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option><option value="SD">South Dakota</option><option value="TN">Tennessee</option><option value="TX">Texas</option><option value="UT">Utah</option><option value="VA">Virginia</option><option value="VI">Virgin Islands</option><option value="VT">Vermont</option><option value="WA">Washington</option><option value="WI">Wisconsin</option><option value="WV">West Virginia</option><option value="WY">Wyoming</option><option value="AA">Military Americas</option><option value="AE">Military Europe/ME/Canada</option><option value="AP">Military Pacific</option></select>						-->
						<!--<select class="required rxReadOnly" name="state" id="state"><option value=""> --- Select State --- </option><option value="Alaska">Alaska</option><option value="Alabama">Alabama</option><option value="Arkansas">Arkansas</option><option value="American Samoa">American Samoa</option><option value="Arizona">Arizona</option><option value="California">California</option><option value="Colorado">Colorado</option><option value="Connecticut">Connecticut</option><option value="D.C.">D.C.</option><option value="Delaware">Delaware</option><option value="Florida">Florida</option><option value="Micronesia">Micronesia</option><option value="Georgia">Georgia</option><option value="Guam">Guam</option><option value="Hawaii">Hawaii</option><option value="Iowa">Iowa</option><option value="Idaho">Idaho</option><option value="Illinois">Illinois</option><option value="Indiana">Indiana</option><option value="Kansas">Kansas</option><option value="Kentucky">Kentucky</option><option value="Louisiana">Louisiana</option><option value="Massachusetts">Massachusetts</option><option value="Maryland">Maryland</option><option value="Maine">Maine</option><option value="Marshall Islands">Marshall Islands</option><option value="Michigan">Michigan</option><option value="Minnesota">Minnesota</option><option value="Missouri">Missouri</option><option value="Marianas">Marianas</option><option value="Mississippi">Mississippi</option><option value="Montana">Montana</option><option value="North Carolina">North Carolina</option><option value="North Dakota">North Dakota</option><option value="Nebraska">Nebraska</option><option value="New Hampshire">New Hampshire</option><option value="New Jersey">New Jersey</option><option value="New Mexico">New Mexico</option><option value="Nevada">Nevada</option><option value="New York">New York</option><option value="Ohio">Ohio</option><option value="Oklahoma">Oklahoma</option><option value="Oregon">Oregon</option><option value="Pennsylvania">Pennsylvania</option><option value="Puerto Rico">Puerto Rico</option><option value="Palau">Palau</option><option value="Rhode Island">Rhode Island</option><option value="South Carolina">South Carolina</option><option value="South Dakota">South Dakota</option><option value="Tennessee">Tennessee</option><option value="Texas">Texas</option><option value="Utah">Utah</option><option value="Virginia">Virginia</option><option value="Virgin Islands">Virgin Islands</option><option value="Vermont">Vermont</option><option value="Washington">Washington</option><option value="Wisconsin">Wisconsin</option><option value="West Virginia">West Virginia</option><option value="Wyoming">Wyoming</option><option value="Military Americas">Military Americas</option><option value="Military Europe/ME/Canada">Military Europe/ME/Canada</option><option value="Military Pacific">Military Pacific</option></select>-->
						<select class="required" name="state" id="state">
							<option value=""> --- Select State --- </option>
							<?php 							
								foreach( $states as $srow): 
									$xssates = strtolower($refund->state);
								?>
								<option value="<?php echo $srow->state_usps; ?>" <?php echo ((strtolower($srow->state_usps) == trim($xssates))?'selected="selected"':""); ?>><?php echo $srow->state_usps; ?></option>
							<?php endforeach; ?>
						</select>    <?php echo $refund->state; ?>											
						</div></li>						
						<li><div class="field"><label for="zip">Zip Code <span class="req">*</span></label> <input id="zip"  name="zip" type="text" class="medium required" value="<?php echo $refund->zip ?>"/></div></li>
						
					</ul>
					
					<ul class="invoice_details">
						<li><div class="field"><label for="invdate">Invoice Date <span class="req">*</span></label> <input id="invdate" readonly="readonly"  name="invdate" type="text" class="medium required rxReadOnly" value="<?php echo $refund->invoice_date ?>"/></div></li>
						<li><div class="field"><label for="webcsr">WebCSR ticket #  <span class="req">*</span></label> <input id="webcsr"  name="webcsr" type="text" class="medium required rxReadOnly" value="<?php echo $refund->webcsr ?>"/></div></li>
						<li>
							<div class="field">
								<label for="supplier">Supplier Num <span class="req">*</span></label>
								<select id="supplier" name="supplier" class="medium required rxReadOnly">								
									<?php foreach($supplier as $row): 
										$xssupplier = strtolower($refund->supplier_num);
									?>
									<option value="<?php echo $row->supplier_name; ?>"  <?php echo ((strtolower($row->supplier_name) == trim($xssupplier))?'selected="selected"':""); ?>><?php echo $row->supplier_name; ?></option>
									<?php endforeach; ?>
										
								</select>
							</div>							
						</li>
						<li><div class="field"><label for="supsitenum">Supplier Site Num <span class="req">*</span></label> <input id="supsitenum" readonly="readonly"  name="supsitenum" type="text" class="medium required" value="<?php echo $refund->supplier_site_num ?>"/></div></li>
						<li><div class="field"><label for="invnum">Kana ID/Invoice # <span class="req">*</span></label> <input id="invnum"  name="invnum" type="text" class="medium required rxReadOnly" value="<?php echo $refund->invoice_num ?>"/></div></li>						
						<li>
							<div class="field">
								<label for="brand">Brand <span class="req">*</span></label>
								<select id="brand" name="brand" class="medium required rxReadOnly">
									<option data="" value=""> ---select--- </option>
									<?php foreach($brand as $row): 
										$xsbrand = strtolower($refund->brand);
									?>
									<option value="<?php echo $row->brand_name;?>" <?php echo ((strtolower($row->brand_name) == trim($xsbrand))?'selected="selected"':""); ?> data="<?php echo $row->gl_account; ?>" ><?php echo $row->brand_name; ?></option>
									<?php endforeach; ?>
								</select>
							</div>							
						</li>
						<li><div class="field"><label for="glaccount">GL Account <span class="req">*</span></label> <input id="glaccount" name="glaccount" type="text" readonly="readonly" class="medium required" value="<?php echo $refund->gl_account ?>" /></div></li>
						<!--<li><div class="field"><label for="invdescer">Invoice Description <span class="req">*</span></label> <input id="invdescer"  name="invdescer" type="text" class="medium required" /></div></li>-->
						
					</ul>
					
					<div class="field"><label for="invdescer">Invoice Description <span class="req">*</span></label> 						
						<textarea name="invdescer" cols="50" rows="3" class="required rxReadOnly"><?php echo $refund->invoice_descer ?></textarea>
					</div>
					<div class="field"><label for="reason">Reason <span class="req">*</span></label> 						
						<textarea name="reason" cols="50" rows="4" class="required rxReadOnly"><?php echo $refund->reason ?></textarea>
					</div>
					
					
					<br />
					<div style="width: 90%; float:left; padding-bottom: 8px">
						<!--<button class="btn  btn-grey" id="additem_btn" name="additembtn" value="add" style="float: left; display:none">Add Item</button>	-->
						<!--<button class="btn" id="invoice_btn" name="savebtn" value="save" style="float: right">Save</button>	-->
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
							<?php
								foreach( $refundItems as $row ):
							?>
								<tr id="tr_<?php echo $row->itemid;?>" class="TR_Not_Deleted">
									<input type="hidden" id="itemstatus_<?php echo $row->itemid;?>" name="itemstatus_<?php echo $row->itemid;?>_u" value="1" >
									<td><input type="text" class="xsmall required calprice rxReadOnly" data="1" value="<?php echo $row->qty;?>" name="qty_<?php echo $row->itemid;?>_u" id="qty_<?php echo $row->itemid;?>"/></td>			
									<td>
										<select class="small required itemsCat rxReadOnly" style="" id="type_<?php echo $row->itemid;?>" name="type_<?php echo $row->itemid;?>_u" onchange="itemchange(this);">										
											<option value=""></option>
											<?php foreach($itemsCat as $item): ?>
												<option value="<?php echo $item->item_name;?>" <?php echo (($item->item_name == trim($row->item_num))?'selected="selected"':""); ?> ><?php echo $item->item_name?></option>
											<?php endforeach; ?>	
										</select>
									</td>
									<td id="tddesc_<?php echo $row->itemid;?>">
										<input type="text" id="itemdesc_<?php echo $row->itemid;?>" name="itemdesc_<?php echo $row->itemid;?>_u" class="xxlarge required rxReadOnly" value="<?php echo $row->description;?>"/>
									</td>
									<td class="price"><input type="text" data="1" class="small required number calprice rxReadOnly" value="<?php echo $row->unit_price;?>" name="price_<?php echo $row->itemid;?>_u" id="price_<?php echo $row->itemid;?>" /></td>
									<td class="total"><input type="text" class="small required linetotal" data="1" readonly="readonly" value="<?php echo $row->line_total;?>" style="" name="total_<?php echo $row->itemid;?>_u" id="total_<?php echo $row->itemid;?>"/></td>
									<td> 
										<div id="invoice_actions">
											<a class="del1" id="del_<?php echo $row->itemid;?>"  href="#">&nbsp;&nbsp;&nbsp;</a>
											<a class="add1" id="add_<?php echo $row->itemid;?>" href="#">&nbsp;&nbsp;&nbsp;</a>
										</div>									
									</td>
								</tr>
							<?php
								endforeach;
							?>								
							</tbody>

							<tfoot>
								<tr>
									<td class="sub_total" colspan="3">&nbsp;</td>
									<td class="sub_total">Subtotal:</td>
									<td class="sub_total" style="padding-right:10px"><input type="text" class="small" name="subtotal" id="subtotal"  readonly="readonly" value="<?php echo $refund->invoice_sub_total;?>" /> </td>
									<td></td>
								</tr>
								<tr>
									<td class="sub" colspan="2">&nbsp;</td>
									<td class="sub">Tax % <span class="req">*</span> <input type="text" style="width:40px;" class="small calprice rxReadOnly" name="taxtpercent" id="taxtpercent" value="<?php echo $refund->sales_tax_percent;?>"/></td>
									<td class="sub">Sales Tax:</td>
									<td class="sub" style="padding-right:10px"><input type="text" class="small" name="saletax" id="saletax" readonly="readonly"  value="<?php echo $refund->sales_tax;?>" /></td>
									<td></td>
								</tr>

								<tr>
									<td class="sub" colspan="2">&nbsp;</td>
									<td class="sub">&nbsp;</td>
									<td class="sub">Other</td>
									<td class="sub" style="padding-right:10px"><input type="text" class="small calprice rxReadOnly" name="otherTaxes" id="otherTaxes"  value="<?php echo $refund->other_tax;?>" /></td>
									<td></td>
								</tr>								
								<tr>
									<td class="grand_total" colspan="3"></td>
									<td class="grand_total">Total:</td>
									<td class="grand_total" style="padding-right:10px"><input type="text" class="small" name="grandtotal" id="grandtotal"  readonly="readonly"value="<?php echo $refund->invoice_amount;?>" /></td>
									<td></td>
								</tr>								
							</tfoot>
						</table>

						
					</div>
				
					<div class="xbreak"></div>	
					
					<?php echo $auditform; ?>
					
					<div style="width: 90%; float:left; padding-bottom: 8px">
						<button type="button" class="btn"  value="back" style="float: right" onclick="javascript:history.go(-1)">Back</button>
						<!--<button type="submit" class="btn" name="savebtn" id="savebtn" value="save" style="float: right">Save</button>-->
						<input type="submit" class="btn" name="savebtn" id="savebtn" value="save" style="float: right" />		
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