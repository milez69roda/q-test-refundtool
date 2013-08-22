
	
	<style  type="text/css">
		
		.form .field {
			margin-bottom: 0.5em !important;
		}	

		#invoice ul{
			width: 50% !important;
		}	
		
		#info{
			text-align:left;
		}
		
		#info  td{
			padding: 2px 20px;
		}
		
	</style>

	<script type="text/javascript">
		

	
	</script>	
	
	<div id="content" class="xfluid">
				
		<div class="portlet x12" id="invoice">
			<div class="portlet-header">			
				<h4>Refund</h4>
		
			</div>
			<div class="error" style="display:none; padding: 5px 0px 0px 90px; color:red"><span></span></div>
			
			<div class="portlet-content">
			
				<form name="newForm" id="newForm" action="logsajax/saveUpdate" method="post" class="form label-inline">
					
					
					<table id="info" cellspacing="0" cellpadding="0" border="0">
						<tr>
							<th>Customer Name:</th>
							<td><?php echo $refund->cust_fname." ".$refund->cust_lname; ?></td>
							<th>Invoice Date: </th>
							<td><?php echo $refund->invoice_date; ?></td>
						</tr>
						<tr>
							<th>Address Line 2: </th>
							<td><?php echo $refund->address_line2; ?></td>
							<th>WebCSR ticket #: </th>
							<td><?php echo $refund->webcsr; ?></td>
						</tr>
						<tr>
							<th>Address Line 3: </th>
							<td><?php echo $refund->address_line3; ?></td>
							<th>Supplier Num: </th>
							<td><?php echo $refund->supplier_num; ?></td>
						</tr>
						<tr>
							<th>Country: </th>
							<td><?php echo $refund->country; ?></td>
							<th>Supplier Site Num: </th>
							<td><?php echo $refund->supplier_site_num; ?></td>
						</tr>
						<tr>
							<th>City:  </th>
							<td><?php echo $refund->city; ?></td>
							<th>Kana ID/Invoice #: </th>
							<td><?php echo $refund->invoice_num; ?></td>
						</tr>
						<tr>
							<th>State: </th>
							<td><?php echo $refund->state; ?></td>
							<th>Brand: </th>
							<td><?php echo $refund->brand; ?></td>
						</tr>
						<tr>

							<th>Zip Code  </th>
							<td><?php echo $refund->zip; ?></td>							
							<th>GL Account: </th>
							<td><?php echo $refund->gl_account; ?></td>
						</tr>

					</table>
					
					<div class="field"><label for="invdescer"><strong>Invoice Description:  </strong></label><?php echo $refund->invoice_descer ?></div>
					<div class="field"><label for="reason"><strong>Reason:  </strong> </label> <?php echo $refund->reason ?> </div>
					
					
					
					
					<div class="xbreak"></div>	
					<br />	
					<div id="invoice_items">
						 
						<table id="info" cellpadding="0" cellspacing="0" border="0" >
							
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
	
</div> <!-- #wrapper -->

