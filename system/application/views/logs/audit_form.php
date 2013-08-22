<?php
	if( $this->session->userdata('DX_role_id') == 4 OR $this->session->userdata('DX_role_id') == 2):
?>
<div class="portlet-content" id="divAudit">
	<div class="portlet-header">			
		<h4>Audit Form</h4>					
	</div>	
	<input	type="hidden" name="logsname" id="logsname" value="<?php echo $logs[0]->rstatus_name?>" />
	<!--<input	type="hidden" name="savebtn"  value="save" />-->
	<div class="field">
		<label for="logstatus_audit">Audit Status <span class="req">*</span></label>
		<select id="logstatus_audit" name="logstatus_audit" class="medium required">								
			<?php foreach($logs as $status): 				
					if( $status->rstatusid != 4 ):
			?>
			<option value="<?php echo $status->rstatusid; ?>"><?php echo $status->rstatus_name; ?></option>
			<?php 	endif;
				endforeach; ?>
				
		</select>
	</div>	
	<div class="field"><label for="statusdesc">Audit Reason: </label> 
		
		<textarea name="statusdesc" id="statusdesc" cols="50" rows="4" class=""></textarea>
	</div>
</div>

<?php
	endif;
?>