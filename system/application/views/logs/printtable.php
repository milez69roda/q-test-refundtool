	
	<link rel="stylesheet" href="css/themes/ui-lightness/jquery-ui-1.8.16.custom.css" type="text/css" />
	
	<script  type="text/javascript" src="js/jquery/jquery-ui-1.8.16.custom.min.js"></script>
	<script  type="text/javascript" src="js/jquery/jquery.validate.js"></script>
	

	
	<style  type="text/css">
		
		.form .field {
			margin-bottom: 0.5em !important;
		}	

		#invoice ul{
			width: 50% !important;
		}	
		
		/* #wrapper{
			position: relative;
			left: -9999px;
		
		}
		
		#invoice{
			position: relative;
			left: 9999px;
			top:-130px !important;
		
		} */
		
	</style>

	<script type="text/javascript">
		
		$(function(){
			
			//$("#wrapper").hide();
			//$(".portlet-content").show();
		
		})
	
	</script>
	
	<div id="content" class="xfluid">
				
		<div class="portlet x12" id="invoice">
			<div class="portlet-header">			
				<h4>Refund</h4>
		
			</div>
			<div class="error" style="display:none; padding: 5px 0px 0px 90px; color:red"><span></span></div>
			
			<div class="portlet-content">
			
				<form name="newForm" id="newForm" action="logsajax/saveUpdate" method="post" class="form label-inline">
					
					<table>
						<tr>
							<td>
								<div class="field"><label for="custfname">Customer Name: </label><?php echo $refund->cust_fname." ".$refund->cust_lname ?></div>
								<div class="field"><label for="addrline2">Address Line 2: </label> <?php echo $refund->address_line2; ?></div>
								<div class="field"><label for="addrline3">Address Line 3: </label> <?php echo $refund->address_line3 ?></div>
								<div class="field"><label for="country">Country: </label> <?php echo $refund->country ?></div>
								<div class="field"><label for="city">City: </label> <?php echo $refund->city ?></div>
								<div class="field"><label for="state">State: </label> <?php echo $refund->state; ?> </div>						
								<div class="field"><label for="zip">Zip Code: </label> <?php echo $refund->zip ?></div>								
							</td>
							<td>
								<div class="field"><label for="invdate">Invoice Date: </label> <?php echo $refund->invoice_date ?> </div>
								<div class="field"><label for="webcsr">WebCSR ticket #: </label> <?php echo $refund->webcsr ?> </div>
								<div class="field"><label for="supplier">Supplier Num: </label> <?php echo $refund->supplier_num; ?> </div>
								<div class="field"><label for="supsitenum">Supplier Site Num: </label> <?php echo $refund->supplier_site_num ?></div>
								<div class="field"><label for="invnum">Kana ID/Invoice #: </label> <?php echo $refund->invoice_num ?></div>						
								<div class="field"><label for="brand">Brand: </label><?php  echo $refund->brand; ?></div>
								<div class="field"><label for="glaccount">GL Account: </label><?php echo $refund->gl_account ?></div>
								
							</td>							
						</tr>
					</table>
					<ul class="client_details">
						<li><div class="field"><label for="custfname">Customer Name </label><?php echo $refund->cust_fname." ".$refund->cust_lname ?></div></li>
						<li><div class="field"><label for="addrline2">Address Line 2 </label> <?php echo $refund->address_line2; ?></div></li>
						<li><div class="field"><label for="addrline3">Address Line 3</label> <?php echo $refund->address_line3 ?></div></li>
						<li><div class="field"><label for="country">Country</label> <?php echo $refund->country ?></div></li>
						<li><div class="field"><label for="city">City </label> <?php echo $refund->city ?></div></li>
						<li><div class="field"><label for="state">State </label> <?php echo $refund->state; ?> </div></li>						
						<li><div class="field"><label for="zip">Zip Code </label> <?php echo $refund->zip ?></div></li>						
					</ul>
					
					<ul class="invoice_details">
						<li><div class="field"><label for="invdate">Invoice Date </label> <?php echo $refund->invoice_date ?> </div></li>
						<li><div class="field"><label for="webcsr">WebCSR ticket # </label> <?php echo $refund->webcsr ?> </div></li>
						<li><div class="field"><label for="supplier">Supplier Num </label> <?php echo $refund->supplier_num; ?> </div></li>
						<li><div class="field"><label for="supsitenum">Supplier Site Num </label> <?php echo $refund->supplier_site_num ?></div></li>
						<li><div class="field"><label for="invnum">Kana ID/Invoice # </label> <?php echo $refund->invoice_num ?></div></li>						
						<li><div class="field"><label for="brand">Brand </label><?php  echo $refund->brand; ?></div></li>
						<li><div class="field"><label for="glaccount">GL Account </label><?php echo $refund->gl_account ?></div></li>
						
					</ul>
					
					<div class="field"><label for="invdescer">Invoice Description</label><?php echo $refund->invoice_descer ?></div>
					<div class="field"><label for="reason">Reason </label> <?php echo $refund->reason ?> </div>
					
					
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
								<tr>
									
									<td><?php echo $row->qty;?></td>			
									<td><?php echo $row->item_num; ?></td>
									<td><?php echo $row->description; ?></td>
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
									<td class="sub">Tax: <?php echo $refund->sales_tax_percent;?>% </td>
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
					 

					
				</form>
				
			</div>
			
			<!--<div style="width: 90%; float:left; padding-bottom: 8px">
				<button type="button" class="btn"  value="back" style="float: right" onclick="javascript:history.go(-1)">Back</button>
				<button type="submit" class="btn" name="savebtn" id="savebtn" value="save" style="float: right">Print</button>								
			</div>	-->
			
		</div>
		
	</div> <!-- #content -->