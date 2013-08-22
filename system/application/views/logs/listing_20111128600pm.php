	<link rel="stylesheet" href="css/themes/ui-lightness/jquery-ui-1.8.16.custom.css" type="text/css" />
	
	<script  type="text/javascript" src="js/jquery/jquery-ui-1.8.16.custom.min.js"></script>
	<script  type="text/javascript" src="js/jquery/FixedHeader.min.js"></script>
	<!--<script  type="text/javascript" src="js/jquery/FixedHeader.min.js"></script>-->
	<!--<script  type="text/javascript" src="js/jquery/jquery.dataTables.columnFilter.js"></script>-->
	
	
	<script type="text/javascript">
	
	
		
	
		$(document).ready(function() {
		
			$("#dfrom").datepicker({ dateFormat: 'yy-mm-dd',
									onSelect: function(dateText, inst) { oTable.fnDraw(); }
								});	
			$("#dto").datepicker({ dateFormat: 'yy-mm-dd',
									onSelect: function(dateText, inst) { oTable.fnDraw(); }
								});			

			

	
			var oTable =  $('#example').dataTable( {
				"bProcessing": true,
				"bServerSide": true,
				"sScrollX": "110%",
				"sScrollXInner": "350%",
				/*"bScrollCollapse": true, */
				"sAjaxSource": "logsajax/getLogListing1"/*,
				
				"sScrollX": "100%" ,		
				"sScrollXInner": "300%" ,
				"fnInitComplete": function () {
							new FixedColumns( oTable, {
								"iLeftColumns": 2,
								"iLeftWidth": 300
								}  
							); 
				} */,"fnServerParams": function ( aoData ) {
						
						if( $("#dfrom").val() != ""){
							aoData.push( { "name": "dfrom", "value": $('#dfrom').val() } );
							aoData.push( { "name": "dto", "value": $('#dto').val() } );
							
						}
						aoData.push( { "name": "logstatus", "value": $('#logstatus').val() } );
				}/*,
				 "aoColumnDefs": [
								//{ "bSearchable": false, "bVisible": false, "aTargets": [ 17 ] }
								{ "bSortable": false, "aTargets": [ 0 ] }
							]	*/		
				
			} );		
			
			oTable.fnSort( [ [20,'desc']] );
			//oTable.fnDraw();	
		
			<?php if( ($this->roleId == 2)): ?>
				$('<div />').addClass('UnSelectAllButton11').css({'float' : 'right'}).attr({'id' : 'UnSelectAllButton11'}).appendTo($('#example_length'));
				$('<button />').attr({
					'id' : 'actPrint'
				})
				.html('Printable')
				.appendTo($('#UnSelectAllButton11'));
				$("button", ".UnSelectAllButton11").button();				
			
 
				$('<div />').addClass('UnSelectAllButton3').css({'float' : 'right'}).attr({'id' : 'UnSelectAllButton3'}).appendTo($('#example_length'));
				$('<button />').attr({
					'id' : 'actComplete'
				})
				.html('Complete')
				.appendTo($('#UnSelectAllButton3'));
				$("button", ".UnSelectAllButton3").button();				
			
			<?php endif; ?>
			
			
			$('<div />').addClass('UnSelectAllButton').css({'float' : 'right'}).attr({'id' : 'UnSelectAllButton'}).appendTo($('#example_length'));
				$('<button />').attr({
					'id' : 'actSelectRow'
				})
				.html('Edit')
				.appendTo($('#UnSelectAllButton'));
				$("button", ".UnSelectAllButton").button();
			
			
			<?php 
			
			if( ($this->roleId == 4) OR ($this->roleId == 2)  ): ?>
			
			$('<div />').addClass('UnSelectAllButton1').css({'float' : 'right'}).attr({'id' : 'UnSelectAllButton1'}).appendTo($('#example_length'));
				$('<button />').attr({
					'id' : 'actAuditRow'
				})
				.html('Audit')
				.appendTo($('#UnSelectAllButton1'));
				$("button", ".UnSelectAllButton1").button();				

			<?php endif;  
			
			
			if( $this->roleId == 2 ): ?>
			
			$('<div />').addClass('UnSelectAllButton2').css({'float' : 'right'}).attr({'id' : 'UnSelectAllButton2'}).appendTo($('#example_length'));
				$('<button />').attr({
					'id' : 'actExport'
				})
				.html('Export to Excel')
				.appendTo($('#UnSelectAllButton2'));
				$("button", ".UnSelectAllButton2").button();			
				
			<?php endif; ?>	
				

			/* $('tr', oTable.fnGetNodes()).click( function() {
				var iCol = $('td').index(this) % 5;
				var nTrs = oTable.fnGetNodes();
				$('td:nth-child('+(iCol+1)+')', nTrs).addClass( 'highlighted' );
				
			}, function() {
				$('td.highlighted', oTable.fnGetNodes()).removeClass('highlighted');
			} ); */		

			
			/* Add a click handler to the rows - this could be used as a callback */
			$("#example tbody").click(function(event) {
				$(oTable.fnSettings().aoData).each(function (){
					$(this.nTr).removeClass('row_selected');
					
				});
				$(event.target.parentNode).addClass('row_selected');
			});			
			
			
			/* Add a click handler  for update*/
			$('#actSelectRow').click( function() {
				var anSelected = fnGetSelected( oTable );
				//oTable.fnDeleteRow( anSelected[0].id );
				
				try{
					rowid = anSelected[0].id;
					//alert(rowid);
					window.location = "<?php echo base_url()?>dashboard/update/"+rowid;
				}catch(e){
					alert("Please select a log");
				}
			} );	

			/* Add a click handler for audit*/
			$('#actAuditRow').click( function() {
				var anSelected = fnGetSelected( oTable );
				//oTable.fnDeleteRow( anSelected[0].id );
				
				try{
					var rowid = anSelected[0].id;
					
					window.location = "<?php echo base_url()?>dashboard/audit/"+rowid+"#divAudit";
				}catch(e){
					alert("Please select a log");
				}
			} );
			
			

			/* Add a click handler for printing*/
			$('#actPrint').click( function() {
				var anSelected = fnGetSelected( oTable ); 
				
				try{
					var rowid = anSelected[0].id; 
					//window.open ("<?php echo base_url()?>dashboard/printable/"+rowid,"Refund Log");
					window.location = "<?php echo base_url()?>dashboard/printable/"+rowid;
				}catch(e){
					alert("Please select a log");
				}
			} );			
			
			
			
			/* Add a click handler for complete*/
			$('#actComplete').click( function() {
				
				var con = confirm("Do you want to change the status of the log to Complete");
				
				if( con ){
				var anSelected = fnGetSelected( oTable );
				
					try{
						var rowid = anSelected[0].id;
						//updateCompleteStatus
						//alert(rowid);
						
						$.ajax({
							type:"POST",
							url: "logsajax/updateCompleteStatus/"+rowid,
							success: function(data, xhr){
								var c = jQuery.parseJSON(data);
								if(c.status) {
									alert("Successfully Updated to Complete");
									oTable.fnDraw();	
								}else alert("Failed to Update it to Complete. \nPlease make sure that the log status is Audited-Approved");
							}
						});		

						
					}catch(e){
						alert("Please select a log");
					} 
				}
			} );

			
					
			/* Add a click handler for export*/
			$('#actExport').click( function() {
				
				/*var anSelected = fnGetSelected( oTable );
				try{
					var rowid = anSelected[0].id;
					alert(rowid);
				}catch(e){
					alert("Please select a log");
				}*/
				var tempf = $("#dfrom").attr("value");
				var tempt = $("#dto").attr("value");
				var lstatus = $("#logstatus").attr("value");
				
				var from = tempf.split("-");
				var to   = tempt.split("-");
				
				
				var myfrom =new Date();
				myfrom.setFullYear(from[0],(from[1])-1,from[2]);				
				
				var myto=new Date();
				myto.setFullYear(to[0],(to[1])-1,to[2]);
				
				if( myto >= myfrom ){
					//window.location = "<?php echo base_url(); ?>logsajax/download/"+tempf+"/"+tempt;
					$.ajax({
						type:"POST",
						url: "logsajax/download/"+tempf+"/"+tempt+"/"+lstatus,
						success: function(data, xhr){
							window.location = "<?php echo base_url()?>"+data;
						}
					});
				}else{
					alert("Invalid Date Range");
				}
				
			});	

			$("#logstatus").change( function(){
				oTable.fnDraw();
			})
			
		});


		/* Get the rows which are currently selected */
		function fnGetSelected( oTableLocal ) {
			var aReturn = new Array();
			var aTrs = oTableLocal.fnGetNodes();
			
			for ( var i=0 ; i<aTrs.length ; i++ ) {
				if ( $(aTrs[i]).hasClass('row_selected') ) {
					aReturn.push( aTrs[i] );
				}
			}
			
			return aReturn;
		}
		
	</script>
	
	<style type="text/css">
	
		.form .field {
			margin-bottom: 0.5em !important;
		}
		
		.ui-datepicker{
			z-index: 200 !important;
		}
		
		
		.dataTables_scrollHead{
			clear:both;
		}	

		.dataTables_filter {		
			width: 30% !important;
		}
		
		.dataTables_length {
			width: 60% !important;
		}
		
		#invoice{
			border-top: 0 !important;
		}
		
		#invoice .invoice_details{
			float: left !important;
		}
		
	</style>
	
	<div id="content" class="xfluid">
		
		<div class="portlet x12">
			<div class="portlet-header"><h4>Refund Log List</h4></div>
			
			<div class="portlet-content">

						
				<form name="miamiuserform" id="miamiuserform" action="" method="post" class="form label-inline">
					<div id="invoice">
						<ul class="client_details" style="width: 40% !important;">
							<li><div class="field"><label for="dfrom">Date From: </label> <input id="dfrom" name="dfrom"  type="text" class="medium" /></div></li>
							<li><div class="field"><label for="dto">Date To: </label> <input id="dto" name="dto"  type="text" class="medium" /></div></li>
						</ul>
						<ul class="invoice_details" style="width: 40% !important;">
							<li>
								<label for="logstatus"> Status </label>
								<select id="logstatus" name="logstatus" class="medium required">	
									<option value=""> - - - Select - - - </option>	
									<?php foreach($logstatus as $status): 				
											
									?>
									<option value="<?php echo $status->rstatusid; ?>"><?php echo $status->rstatus_name; ?></option>
									<?php 	
										endforeach; ?>
										
								</select>							
							</li>
						</ul>
					</div>
				</form>
				<div id="dynamic">
					<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
						<thead>
							<tr>								
								<th>First Name</th>
								<th>Last Name</th>
								<th>Status</th>
								<th>Audited By</th>
								<th>Supplier Num</th>
								<th>Supplier Site Num</th>
								<th>Address Line 1</th>
								<th>Address Line 2</th>
								<th>Address Line 3</th>
								<th>City</th>
								<th>State</th>
								<th>Zip</th>
								<th>Country</th>
								<th>Kana ID/Invoice #</th>
								<th>WebCSR ticket #</th>
								<th>Invoice Date</th>
								<th>Invoice Amount</th>								
								<th>Invoice Descer</th>
								<th>Brand</th>
								<th>GL Account</th>		
								<th>Date Updated</th>		
								<th>Updated By</th>		
								<th>Date Created</th>										
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="22" class="dataTables_empty">Loading data from server</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>						
								<th>First Name</th>
								<th>Last Name</th>
								<th>Status</th>
								<th>Audited By</th>
								<th>Supplier Num</th>
								<th>Supplier Site Num</th>
								<th>Address Line 1</th>
								<th>Address Line 2</th>
								<th>Address Line 3</th>
								<th>City</th>
								<th>State</th>
								<th>Zip</th>
								<th>Country</th>
								<th>Kana ID/Invoice #</th>
								<th>WebCSR ticket #</th>
								<th>Invoice Date</th>
								<th>Invoice Amount</th>								
								<th>Invoice Descer</th>
								<th>Brand</th>
								<th>GL Account</th>		
								<th>Date Updated</th>	
								<th>Updated By</th>										
								<th>Date Created</th>								
							</tr>
						</tfoot>
					</table>
				</div>
				<div class="spacer"></div>
			
			</div>
		</div>
		

		
	</div> <!-- #content -->