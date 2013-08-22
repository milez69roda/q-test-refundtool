	
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
						<li><div class="field"><label for="custfname">Customer Name: </label><?php echo $refund->cust_fname." ".$refund->cust_lname; ?></div></li>
						<li><div class="field"><label for="addrline2">Address Line 2: </label><?php echo $refund->address_line2 ?> </div></li>
						<li><div class="field"><label for="addrline3">Address Line 3: </label><?php echo $refund->address_line3 ?></div></li>
						<li><div class="field"><label for="country">Country: </label><?php echo $refund->country ?></div></li>
						<li><div class="field"><label for="city">City: </label><?php echo $refund->city ?></div></li>
						<li><div class="field"><label for="state">State: </label> <?php echo $refund->state ?></div></li>						
						<li><div class="field"><label for="zip">Zip Code: </label><?php echo $refund->zip ?></div></li>
						
					</ul>
					
					<ul class="invoice_details">
						<li><div class="field"><label for="invdate">Invoice Date: </label><?php echo $refund->invoice_date ?></div></li>
						<li><div class="field"><label for="webcsr">WebCSR ticket #: </label><?php echo $refund->webcsr ?></div></li>
						<li><div class="field"><label for="supplier">Supplier Num: </label> <?php echo $refund->supplier_num; ?></div></li>
						<li><div class="field"><label for="supsitenum">Supplier Site Num : </label><?php echo $refund->supplier_site_num ?></div></li>
						<li><div class="field"><label for="invnum">Kana ID/Invoice #:</label><?php echo $refund->invoice_num ?></div></li>						
						<li><div class="field"><label for="brand">Brand: </label><?php echo $refund->brand ?></div></li>
						<li><div class="field"><label for="glaccount">GL Account: </label><?php echo $refund->gl_account ?></div></li>
						<!--<li><div class="field"><label for="invdescer">Invoice Description  <input id="invdescer"  name="invdescer" type="text" class="medium required" /></div></li>-->
						
					</ul>
					
					<div class="field"><label for="invdescer">Invoice Description: </label> 
						<?php echo $refund->invoice_descer ?>
					</div>
					<div class="field"><label for="reason">Reason:  </label> 						
						<?php echo $refund->reason ?>
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
								
								</tr>
							</thead>	
							
							<tbody>
							<?php
								foreach( $refundItems as $row ):
							?>
								<tr id="tr_<?php echo $row->itemid;?>" class="TR_Not_Deleted">
									<input type="hidden" id="itemstatus_<?php echo $row->itemid;?>" name="itemstatus_<?php echo $row->itemid;?>_u" value="1" >
									<td><?php echo $row->qty;?></td>			
									<td><?php echo $row->item_num; ?></td>
									<td id="tddesc_<?php echo $row->itemid;?>"> <?php echo $row->description;?> </td>
									<td class="price"><?php echo $row->unit_price;?></td>
									<td class="total"><?php echo $row->line_total;?></td>
								
								</tr>
							<?php
								endforeach;
							?>								
							</tbody>

							<tfoot>
								<tr>
									<td class="sub_total" colspan="3">&nbsp;</td>
									<td class="sub_total">Subtotal:</td>
									<td class="sub_total" style="padding-right:10px"><?php echo $refund->invoice_sub_total;?></td>
									<td></td>
								</tr>
								<tr>
									<td class="sub" colspan="2">&nbsp;</td>
									<td class="sub">Tax % <?php echo $refund->sales_tax_percent;?></td>
									<td class="sub">Sales Tax:</td>
									<td class="sub" style="padding-right:10px"><?php echo $refund->sales_tax;?></td>
									<td></td>
								</tr>

								<tr>
									<td class="sub" colspan="2">&nbsp;</td>
									<td class="sub">&nbsp;</td>
									<td class="sub">Other</td>
									<td class="sub" style="padding-right:10px"><?php echo $refund->other_tax;?></td>
									<td></td>
								</tr>								
								<tr>
									<td class="grand_total" colspan="3"></td>
									<td class="grand_total">Total:</td>
									<td class="grand_total" style="padding-right:10px"><?php echo $refund->invoice_amount;?></td>
									<td></td>
								</tr>								
							</tfoot>
						</table>

						
					</div>
				
					<div class="xbreak"></div>	
					
					<?php echo $auditform; ?>
					
					<div style="width: 90%; float:left; padding-bottom: 8px">
						<button type="button" class="btn"  value="back" style="float: right" onclick="javascript:history.go(-1)">Back</button>
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