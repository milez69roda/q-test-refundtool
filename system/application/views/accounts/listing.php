	<link rel="stylesheet" href="css/themes/ui-lightness/jquery-ui-1.8.16.custom.css" type="text/css" />
	
	<script  type="text/javascript" src="js/jquery/jquery-ui-1.8.16.custom.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
		
			var oTable = $('#example').dataTable( {
				"bProcessing": true,
				"bServerSide": true,
				"sAjaxSource": "accountajax/getAccountListing1"
			});
			oTable.fnSort( [ [7,'desc']] );
			
			/* Add a click handler to the rows - this could be used as a callback */
			$("#example tbody").click(function(event) {
				$(oTable.fnSettings().aoData).each(function (){
					$(this.nTr).removeClass('row_selected');
					
				});
				$(event.target.parentNode).addClass('row_selected');
			});			
				
				
			$('<div />').addClass('UnSelectAllButton').css({'float' : 'right'}).attr({'id' : 'UnSelectAllButton'}).appendTo($('#example_length'));
				$('<button />').attr({
					'id' : 'actEditBtn'
				})
				.html('Edit')
				.appendTo($('#UnSelectAllButton'));
				$("button", ".UnSelectAllButton").button();	
				
			$('<div />').addClass('UnSelectAllButton2').css({'float' : 'right'}).attr({'id' : 'UnSelectAllButton2'}).appendTo($('#example_length'));
				$('<button />').attr({
					'id' : 'actDelBtn'
				})
				.html('Delete')
				.appendTo($('#UnSelectAllButton2'));
				$("button", ".UnSelectAllButton2").button();					

			/* Add a click handler  for update*/
			$('#actEditBtn').click( function() {
				var anSelected = fnGetSelected( oTable );
				
				try{
					rowid = anSelected[0].id;

					window.location = "<?php echo base_url()?>account/update/"+rowid;
					
				}catch(e){
					alert("Please select a log");
				}
			} );			
			
			/* Add a click handler  for update*/
			$('#actDelBtn').click( function() {
				var anSelected = fnGetSelected( oTable );
				
				try{
					rowid = anSelected[0].id;
					var con = confirm("Delete the selected user?");
					
					if( con)
						window.location = "<?php echo base_url()?>account/delete/"+rowid;
					//window.location = "<?php echo base_url()?>account/update/"+rowid;
					
				}catch(e){
					alert("Please select a log");
				}
			} );

			
		} );
		
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
	
	<div id="content" class="xfluid">
		
		<div class="portlet x12">
			<div class="portlet-header"><h4>Account Listing</h4></div>
			
			<div class="portlet-content">
					
				<div id="dynamic">
					<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
						<thead>
							<tr>								
								<th >First Name</th>
								<th >Last Name</th>
								<th >Center</th>
								<th >Username</th>
								<th >Password</th>
								<th >Type</th>
								<th >Last Login</th>
								<th >Last Updated</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="7" class="dataTables_empty">Loading data from server</td>
							</tr>
						</tbody>
						<!--<tfoot>
							<tr>
								<th>Rendering engine</th>
								<th>Browser</th>
								<th>Platform(s)</th>
								<th>Engine version</th>
								<th>CSS grade</th>
							</tr>
						</tfoot>-->
					</table>
				</div>
				<div class="spacer"></div>
			
			</div>
		</div>
		

		
	</div> <!-- #content -->