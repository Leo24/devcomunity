jQuery(document).ready(function($){
	var settings = $('#mass_messaging_in_buddypress_settings');
	var form = settings.find('form');
	var mode = settings.find('.nav-tab-wrapper .nav-tab-active').first().html();
	var table = form.find('table');
	var rows = table.find('tbody').find('tr');
	
	var ordering = [$('#ordering_first'), $('#ordering_second'), $('#ordering_third')];
	
	function toggle(checkbox, disable){
		var checked = checkbox.is(':checked');
		if(disable){
			checkbox
				.data('check', checked)
				.prop({
					checked: !disable,
					disabled: disable
				});
		}else{
			checkbox
				.prop({
					checked: checkbox.data('check'),
					disabled: disable
				});
		}
	}
	
	function featuresChange(event){
		var featureOn = !event.data.feature.is(':checked');
		
		toggle(event.data.a, featureOn);
		toggle(event.data.b, featureOn);
	}
	
	function updateFeatures(){
		var features = table.find('.ordering');
		
		features.each(function(index){
			ordering[index].val($(this).data('feature'));
		});
	}
		
	if(mode === 'Features'){
		var features = [];
					
		rows.each(function(){
			var feature = $(this).children('th').text();
			if(feature !== ""){
				feature = feature.toLowerCase();
				features.unshift(feature);
			}
		});
		
		$.each(features, function(index, value){
			var feature = rows.find('#enable_' + value);
			
			if(feature.length){
				var allFeatures = rows.find('#enable_all_' + value),
				showAllFeatures = rows.find('#enable_show_all_' + value);
								
				feature.closest('tr').nextAll().andSelf().slice(0, 3)
					.wrapAll('<tbody class="ordering" data-feature="' + value + '" />').parent().prependTo(table)
					.find('tr').first().find('th').addClass('handle');
				
				var theData = {feature: feature, a: allFeatures, b: showAllFeatures};
				
				feature.on('change', theData, featuresChange);
				featuresChange({ data: theData });
			}
		});
		
		rows.find('#ordering_first, #ordering_second, #ordering_third').closest('tr').css('display', 'none');
				
		table.sortable({
			forcePlaceholderSize: true,
			handle: '.handle',
			items: '.ordering',
			start: function(event, ui){
				ui.placeholder.find('td').height(ui.item.height() - 30);
			},
			update: function(){
				updateFeatures();
			}
		});
		
		updateFeatures();
				
	}else if(mode === 'Access'){
		
	}
});