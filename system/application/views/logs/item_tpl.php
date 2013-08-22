
<tr id="tr_<?php echo $now;?>" class="TR_Not_Deleted">
	
	<td><input type="text" class="xsmall required calprice rxReadOnly" value="1" name="qty_<?php echo $now;?>" id="qty_<?php echo $now;?>"/></td>			
	<td>
		<select class="small required itemsCat rxReadOnly" style="" id="type_<?php echo $now;?>" name="type_<?php echo $now;?>" onchange="itemchange(this);">										
			<option value=""></option>
			<?php echo $options; ?>
		</select>
	</td>
	<td id="tddesc_<?php echo $now;?>">

	</td>
	<td class="price"><input type="text" class="small required number calprice rxReadOnly"value="0" name="price_<?php echo $now;?>" id="price_<?php echo $now;?>" /></td>
	<td class="total"><input type="text" class="small required linetotal" data="1" readonly="readonly" value="0.00" style="" name="total_<?php echo $now;?>" id="total_<?php echo $now;?>"/></td>
	<td> 
		<div id="invoice_actions">
			<a class="del1" id="del_<?php echo $now;?>"  href="#">&nbsp;&nbsp;&nbsp;</a>
			<a class="add1" id="add_<?php echo $now;?>" href="#">&nbsp;&nbsp;&nbsp;</a>
		</div>									
	</td>
</tr>