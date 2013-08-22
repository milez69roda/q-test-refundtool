	<link rel="stylesheet" href="css/themes/ui-lightness/jquery-ui-1.8.16.custom.css" type="text/css" />
	
	<script  type="text/javascript" src="js/jquery/jquery-ui-1.8.16.custom.min.js"></script>
	<script  type="text/javascript" src="js/jquery/FixedHeader.min.js"></script>
	<script  type="text/javascript" src="js/jquery/TableTools.js"></script>
	<!--<script  type="text/javascript" src="js/jquery/FixedHeader.min.js"></script>-->
	<!--<script  type="text/javascript" src="js/jquery/jquery.dataTables.columnFilter.js"></script>-->
	<link rel="stylesheet" href="css/TableTools.css" type="text/css" media="screen" />
	
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
				"sAjaxSource": "logsajax/getLogListing1","fnServerParams": function ( aoData ) {
						
						if( $("#dfrom").val() != ""){
							aoData.push( { "name": "dfrom", "value": $('#dfrom').val() } );
							aoData.push( { "name": "dto", "value": $('#dto').val() } );
							
						}
						aoData.push( { "name": "logstatus", "value": $('#logstatus').val() } );
				},
				"sDom": 'T<"clear">lfrtip',
				"oTableTools": {
					"sRowSelect": "multi",
					"aButtons": [ "select_all", "select_none"]
				}
			} );		
			
			oTable.fnSort( [ [21,'desc']] );
			//oTable.fnDraw();	
		
		
		
				/* $('<div />').addClass('UnSelectAllButton1Note').css({'float' : 'right'}).attr({'id' : 'UnSelectAllButton1Note'}).appendTo($('#example_length'));
			$('<button />').attr({
				'id' : 'actAuditNote'
			})
			.html("Auditor Note")
			.appendTo($('#UnSelectAllButton1Note'));
			$("button", ".UnSelectAllButton1Note").button();			
				 */
				
				
				$(".DTTT_container").prepend('<button class="DTTT_button" id="spacer"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></button>');
				
				$(".DTTT_container").prepend('<button class="DTTT_button DTTT_button_text_modified"  id="actAuditNote"><span>Auditor Note</span></button>');

		
		
			<?php if( ($this->roleId == 2)): ?>
				/* $('<div />').addClass('UnSelectAllButton11').css({'float' : 'right'}).attr({'id' : 'UnSelectAllButton11'}).appendTo($('#example_length'));
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
				$("button", ".UnSelectAllButton3").button(); */		
				$(".DTTT_container").prepend('<button class="DTTT_button DTTT_button_text_modified" id="actPrint"><span>Printable</span></button>');
				$(".DTTT_container").prepend('<button class="DTTT_button DTTT_button_text_modified" id="actComplete"><span>Complete</span></button>');
								
			
			<?php endif; ?>
			
			
			/* $('<div />').addClass('UnSelectAllButton').css({'float' : 'right'}).attr({'id' : 'UnSelectAllButton'}).appendTo($('#example_length'));
				$('<button />').attr({
					'id' : 'actSelectRow'
				})
				.html('Edit')
				.appendTo($('#UnSelectAllButton'));
				$("button", ".UnSelectAllButton").button(); */
				$(".DTTT_container").prepend('<button class="DTTT_button DTTT_button_text_modified" id="actSelectRow"><span>Edit</span></button>');
			
			
			<?php 
			
			if( ($this->roleId == 4) OR ($this->roleId == 2)  ): ?>
			
				/*$('<div />').addClass('UnSelectAllButton1').css({'float' : 'right'}).attr({'id' : 'UnSelectAllButton1'}).appendTo($('#example_length'));
				$('<button />').attr({
					'id' : 'actAuditRow'
				})
				.html('Audit')
				.appendTo($('#UnSelectAllButton1'));
				$("button", ".UnSelectAllButton1").button();	 */		
				
				$(".DTTT_container").prepend('<button class="DTTT_button DTTT_button_text_modified" id="actAuditRow"><span>Audit</span></button>');

			<?php endif;  
			
			
			if( $this->roleId == 2 ): ?>
			
				/* $('<div />').addClass('UnSelectAllButton2').css({'float' : 'right'}).attr({'id' : 'UnSelectAllButton2'}).appendTo($('#example_length'));
				$('<button />').attr({
					'id' : 'actExport'
				})
				.html('Export to Excel')
				.appendTo($('#UnSelectAllButton2'));
				$("button", ".UnSelectAllButton2").button(); */		
				
				$(".DTTT_container").prepend('<button class="DTTT_button DTTT_button_text_modified" id="actExport"><span>Export to Excel</span></button>');
				$(".DTTT_container").prepend('<button class="DTTT_button DTTT_button_text_modified" id="actDelete"><span>Delete</span></button>');
				
			<?php endif; ?>	
				

			/* $('tr', oTable.fnGetNodes()).click( function() {
				var iCol = $('td').index(this) % 5;
				var nTrs = oTable.fnGetNodes();
				$('td:nth-child('+(iCol+1)+')', nTrs).addClass( 'highlighted' );
				
			}, function() {
				$('td.highlighted', oTable.fnGetNodes()).removeClass('highlighted');
			} ); */		

			
			/* Add a click handler to the rows - this could be used as a callback */
			/* $("#example tbody").click(function(event) {
				$(oTable.fnSettings().aoData).each(function (){
					$(this.nTr).removeClass('row_selected');
					
				});
				$(event.target.parentNode).addClass('row_selected');
			});	 */		
			
			
			/* Add a click handler  for update*/
			$('#actSelectRow').click( function() {
				var anSelected = fnGetSelected( oTable );
				//oTable.fnDeleteRow( anSelected[0].id );
				if( anSelected.length == 1 ||  anSelected.length < 1){
				try{
					rowid = anSelected[0].id;
					//alert(rowid);
					window.location = "<?php echo base_url()?>dashboard/update/"+rowid;
				}catch(e){
					alert("Please select a log");
				}
				}else{
					alert("Please select only 1 row");
				}
			} );	

			/* Add a click handler for audit*/
			$('#actAuditRow').click( function() {
				var anSelected = fnGetSelected( oTable );
				//oTable.fnDeleteRow( anSelected[0].id );
				
				if( anSelected.length == 1 ||  anSelected.length < 1){
				try{
					var rowid = anSelected[0].id;
					
					window.location = "<?php echo base_url()?>dashboard/audit/"+rowid+"#divAudit";
				}catch(e){
					alert("Please select a log");
				}
				}else{
					alert("Please select only 1 row");
				}
			} );
			
			

			/* Add a click handler for printing*/
			$('#actPrint').click( function() {
				var anSelected = fnGetSelected( oTable ); 
				
				if( anSelected.length == 1 ||  anSelected.length < 1){
				try{
					var rowid = anSelected[0].id; 
					//window.open ("<?php echo base_url()?>dashboard/printable/"+rowid,"Refund Log");
					window.location = "<?php echo base_url()?>dashboard/printable/"+rowid;
				}catch(e){
					alert("Please select a log");
				}
				}else{
					alert("Please select only 1 row");
				}
			} );			
			
			
			/* Add a click handler for delete*/
			$('#actDelete').click( function() {
			
				var anSelected = fnGetSelected( oTable ); 
				
				if( anSelected.length == 1 ||  anSelected.length < 1){
				
					var con = confirm("Do you want to delete the selected log?");
					
					if(con){
						try{
						
							var rowid = anSelected[0].id; 
							
							$.ajax({
								type:"GET",
								url: "logsajax/deletelog/"+rowid,
								success: function(data, xhr){
									var c = jQuery.parseJSON(data);
									if(c.status) {
										oTable.fnDraw();	
									}else alert("Faild to delete");
								}
							});	
							
						}catch(e){
							alert("Please select a log");
						}
					}
					
				}else{
					alert("Please select only 1 row");
				}
			} );				
			
			
			/* Add a click handler for complete*/
			$('#actComplete').click( function() {
				
				var con = confirm("Do you want to change the status of the log to Complete");
				
				if( con ){
				
				var anSelected = fnGetSelected( oTable );
				
					if( anSelected.length > 0){
					
						var fstatus = true;
						var rowids = "";
						for( i=0; i<anSelected.length; i++ ){
							
							if( !$("#"+anSelected[i].id).hasClass("tr_approved_status") ){
								fstatus = false;
							}
							rowids += anSelected[i].id+"_";
						} 					
						
						if( fstatus ){
							rowids = rowids.substr(0,rowids.length-1);
							//alert(rowids);
						
						$.ajax({
							type:"POST",
								url: "logsajax/updateCompleteStatus/"+rowids,
							success: function(data, xhr){
								var c = jQuery.parseJSON(data);
								if(c.status) {
										alert(c.message);
									oTable.fnDraw();	
								}else alert("Failed to Update it to Complete. \nPlease make sure that the log status is Audited-Approved");
							}
						});		

						}else{
							alert("Please make sure that the log status is Audited-Approved");
						}
						
					}else{
						alert("Please select one or more rows. \nPlease make sure that the log status is Audited-Approved");
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
							//console.log("<?php echo base_url()?>"+data);
						}
					});
				}else{
					alert("Invalid Date Range");
				}
				
			});	

			
			
			/* Add a click handler for Auditor Note*/
			$('#actAuditNote').click( function() {
				

				var anSelected = fnGetSelected( oTable );
				
					if( anSelected.length == 1 ||  anSelected.length < 1){
					
					try{
						var rowid = anSelected[0].id;
						
						$.ajax({
							type:"POST",
							url: "logsajax/getAuditorNote/"+rowid,
							success: function(data, xhr){
								var c = jQuery.parseJSON(data);
				
								if( c.status ){
									$( "#dialog:ui-dialog" ).dialog( "destroy" );
								
									$( "<div>"+c.auditornote+"</div>" ).dialog({
										modal: true,
										title: "Auditor's Note",
										buttons: {
											Ok: function() {
												$( this ).dialog( "close" );
											}
										}
									});
								}else{
									alert("Auditor's Note Empty");
								}

							}
						});
	
					}catch(e){
						alert("Please select a log");
					} 
					}else{
						alert("Please select only 1 row");
					}
			} );			
			
			
			$("#logstatus").change( function(){
				oTable.fnDraw();
			})
			
		});


		/* Get the rows which are currently selected */
		function fnGetSelected( oTableLocal ) {
			var aReturn = new Array();
			var aTrs = oTableLocal.fnGetNodes();
			
			for ( var i=0 ; i<aTrs.length ; i++ ) {
				//if ( $(aTrs[i]).hasClass('row_selected') ) {
				if ( $(aTrs[i]).hasClass('DTTT_selected') ) {
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
								<!--<th>Audit Reason</th>-->
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
								<!--<th>Audit Reason</th>-->
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