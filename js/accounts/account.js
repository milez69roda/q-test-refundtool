account = function ()
{
	var pub = {};
	var self = {};
	
	pub.init = function ()
	{
		//$('.portlet-closable .portlet-header').live ( 'click', self.togglePortlet );
		//$('.portlet-tab-nav a').live ( 'click' , self.selectTabContent );

		
		var center = $('#centers1 option:first').val();
		//$.get('accountajax/supervisorDropdown/'+center, self.getSupervisorDropdowns );
		
		$('#centers1').live('change', self.onCenterOnChange);
	}
	
	self.getSupervisorDropdowns = function(data){

		$("#supervisor1 optgroup").html(data);
		$("#supervisor1 option:first").attr("selected","selected");
		
		return false;
	}
	
	self.onCenterOnChange = function(){
		var center = $(this).val();
		$.get('accountajax/supervisorDropdown/'+center, self.getSupervisorDropdowns );
	}
	
	
	/*self.selectTabContent = function ()
	{
		$(this).parents ('ul').find ('li').removeClass ('portlet-tab-nav-active');
		$(this).parents ('li').addClass ('portlet-tab-nav-active');
		var $portlet = $(this).parents ('.portlet');
		$portlet.find ('#' + $(this).attr ('href') ).show ().siblings ().hide ();
		return false;
	}
	
	self.togglePortlet = function ()
	{
		var $this = $(this);	
		var $portlet = $this.parent ();
		var $content = $portlet.find ('.portlet-content');
		
		var browser = $.browser.msie + $.browser.version;
		if ( browser == 'true7.0' )
			$content.toggle ();
		else
			$content.slideToggle ();
		
		$portlet.toggleClass ('portlet-state-closed');
		return false;
	}*/

	
	return pub;
	
}();