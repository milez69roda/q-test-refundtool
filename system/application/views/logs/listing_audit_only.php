	<link rel="stylesheet" href="css/themes/ui-lightness/jquery-ui-1.8.16.custom.css" type="text/css" />
	
	<script  type="text/javascript" src="js/jquery/jquery-ui-1.8.16.custom.min.js"></script>
	<script  type="text/javascript" src="js/jquery/FixedColumns.min.js"></script>
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
				"sScrollXInner": "300%",
				/* "sScrollX": "110%",
				"sScrollXInner": "300%",
				"bScrollCollapse": true, */
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
				}/*,
				 "aoColumnDefs": [
								//{ "bSearchable": false, "bVisible": false, "aTargets": [ 17 ] }
								{ "bSortable": false, "aTargets": [ 0 ] }
							]	*/		
				
			} );		
			oTable.fnSort( [ [18,'desc']] );

		
			
			$('<div />').addClass('UnSelectAllButton').css({'float' : 'right'}).attr({'id' : 'UnSelectAllButton'}).appendTo($('#example_length'));
				$('<button />').attr({
					'id' : 'actSelectRow'
				})
				.html('Update')
				.appendTo($('#UnSelectAllButton'));
				$("button", ".UnSelectAllButton").button();

			$('<div />').addClass('UnSelectAllButton1').css({'float' : 'right'}).attr({'id' : 'UnSelectAllButton1'}).appendTo($('#example_length'));
				$('<button />').attr({
					'id' : 'actAuditRow'
				})
				.html('Audit')
				.appendTo($('#UnSelectAllButton1'));
				$("button", ".UnSelectAllButton1").button();
				


			
			/* Add a click handler to the rows - this could be used as a callback */
			$("#example tbody").click(function(event) {
				$(oTable.fnSettings().aoData).each(function (){
					$(this.nTr).removeClass('row_selected');
					
				});
				$(event.target.parentNode).addClass('row_selected');
			});			
			
			
			/* Add a click handler */
			$('#actSelectRow').click( function() {
				var anSelected = fnGetSelected( oTable );
				//oTable.fnDeleteRow( anSelected[0].id );
				
				try{
					rowid = anSelected[0].id;
					//alert(rowid);
					window.location = "<?php echo base_url()?>dashboard/update/"+rowid;
				}catch(e){
					
				}
			} );
			
			/* Add a click handler*/
			$('#actAuditRow').click( function() {
				var anSelected = fnGetSelected( oTable );
				//oTable.fnDeleteRow( anSelected[0].id );
				
				try{
					rowid = anSelected[0].id;
					//alert(rowid);
					window.location = "<?php echo base_url()?>dashboard/audit/"+rowid+"#divAudit";
				}catch(e){
					
				}
			} );			
			
		} );
				
		/* Get the rows which are currently selected */
		function fnGetSelected( oTableLocal )
		{
			var aReturn = new Array();
			var aTrs = oTableLocal.fnGetNodes();
			
			for ( var i=0 ; i<aTrs.length ; i++ )
			{
				if ( $(aTrs[i]).hasClass('row_selected') )
				{
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
		
		.row_selected td{
			background-color: #FF9900 !important;
			text-decoration: solid;
		}		
		
		.dataTables_scrollHead{
			clear:both;
		}		
		
	</style>
	
	<div id="content" class="xfluid">
		
		<div class="portlet x12">
			<div class="portlet-header"><h4>Refund Log List</h4></div>
			
			<div class="portlet-content">

						
				<form name="miamiuserform" id="miamiuserform" action="" method="post" class="form label-inline">
		
					<div class="field"><label for="dfrom">Date From: </label> <input id="dfrom" name="dfrom"  type="text" class="medium" /></div>		
					<div class="field"><label for="dto">Date To: </label> <input id="dto" name="dto"  type="text" class="medium" /></div>					

				</form>
				<div id="dynamic">
					<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
						<thead>
							<tr>								
								<th>First Name</th>
								<th>Last Name</th>
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
								<th>Date Created</th>		
								
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="19" class="dataTables_empty">Loading data from server</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>						
								<th>First Name</th>
								<th>Last Name</th>
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
								<th>Date Created</th>								
							</tr>
						</tfoot>
					</table>
				</div>
				<div class="spacer"></div>
			
			</div>
		</div>
		

		
	</div> <!-- #content -->