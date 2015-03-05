function createAjaxRequest(jqueryObj) {
	jQuery.ajax({
		type: "POST",
  		cache: false,
		url: jqueryObj[0].getAttribute('aref'),
		data: jqueryObj.serialize(),
		beforeSend: function(jqXHR, settings){
			beforeFunction(jqueryObj);
		},
		success: function (data, textStatus, jqXHR) {
			successFunction(jqXHR, jqueryObj);
		}
	});
}

function createFormSubmitRequest(jqueryObj) {
	/* default url - value of form's action attribute */
	var formSubmitOptions = {
		//target:        '#'+jqueryObj[0].target,
	    beforeSubmit:  function(){
			beforeFunction(jqueryObj);
	    },
	    success: function (data, textStatus, jqXHR) {
			successFunction(jqXHR, jqueryObj);
		}
    };
	jqueryObj.ajaxSubmit(formSubmitOptions);
}


function beforeFunction(jqueryObj) {
	var target = jqueryObj[0].target;
	if (jqueryObj.attr('la_target')) target = jqueryObj.attr('la_target');
	var el = jQuery("#"+target);
	if (el[0].tagName.toLowerCase()=='div' && !el.hasClass("general_error") && !el.hasClass("error") && el.parents("#header").length == 0) {
		var body = $("html, body");
		if (el) {
			var offset = el.offset().top;
			body.stop().animate({scrollTop:offset-100}, '500', 'swing');
		}
	}
	el.attr('stored_content', el.html()); // store the form innerHTML
	if (el[0].tagName.toLowerCase()=='form') { // store the form serialized data
		el[0].stored_content_data = el.serializeArray();
	}
	el.html('<image src="'+image_path+'img/loader.gif" alt="loader.gif" />');
	return true;
}

function successFunction(jqXHR, jqueryObj) {
	//try{
	var response=(new Function('return '+jqXHR.responseText))();
	//}catch(e){alert(jqXHR.responseText)} //json
    if (response.obj['sys_win']) {Popup.sys_win(response.obj['sys_win'], response.obj['callbacks'], response.obj['closeOnBG']);}
    if (response.obj['not_close_sys_win']) {Popup.not_close_sys_win(response.obj['not_close_sys_win'], response.obj['callbacks'], response.obj['closeOnBG']);}
    if (response.obj['alert']) {Popup.alert(response.obj['alert'], response.obj['callbacks'], response.obj['closeOnBG']);}
    if (response.obj['confirm']) {Popup.confirm(response.obj['confirm']['content'], response.obj['confirm']['confirm_action_id'], response.obj['callbacks'], response.obj['closeOnBG']);}
	var target = jqueryObj[0].target;
	if (jqueryObj.attr('la_target')) target = jqueryObj.attr('la_target');
	
	if (!response.obj['failure']) {
		var glob_target=jQuery("#"+jqueryObj[0].target).html(response.text);
	}
	else {
		jQuery(jQuery("#"+target)).html(jQuery("#"+target).attr('stored_content'));
		var fields = jQuery("#"+target)[0].stored_content_data; // restore form fields values
        if (fields&&fields.length) {
		    jQuery.each(fields, function(i, field){
			    var fieldSelector = jQuery("#"+target).find('[name='+field.name+']');
	            if (fieldSelector[0].tagName.toLowerCase()=='textarea') {
				    fieldSelector.html(field.value);
	            }
	            if (fieldSelector[0].tagName.toLowerCase()=='input') {
				    if (fieldSelector.attr('type')=='text') {
					    fieldSelector.attr('value', field.value);
				    }
	            }
	        });
        }
	}
	jQuery("#"+target).attr('stored_content', '');
	jQuery("#"+target).attr('stored_content_data', '');
	
	/*if (jqueryObj[0].parentNode && jqueryObj[0].parentNode.tagName.toLowerCase() == 'li') {
		jqueryObj.parent().parent().find('.active').removeClass('active');
		jqueryObj.parent().addClass('active');
	}*/
	if (response.obj['field_error']) {
        jqueryObj.find('.error').removeClass('error');
		jQuery.each(response.obj['field_error'], function(i,v){
			jqueryObj.find(':input[name="'+i+'"]').parent().addClass('error');
            try
            {
                if (i=='data[SolarProjectAttachment][file]'){
					jQuery('.file_select_button').addClass('error');
				}
            }
            catch(e)
            {}

		});
		if ( jqueryObj.find('.error')[0]) {
			var body = $("html, body"),
				offset = jQuery(jqueryObj.find('.error')[0]).parents(".section").offset().top;
			body.stop().animate({scrollTop:offset}, '500', 'swing');
		}
	}

	if (response.obj['section_error']) {
        jqueryObj.find('.general_error').html('');
		jQuery.each(response.obj['section_error'], function(i,v){
            if (jqueryObj.find('#'+i).next().hasClass("hide")) jqueryObj.find('#'+i).next().parent().find(".showhide").trigger("click");
			jqueryObj.find('#'+i).next().find('.general_error').html(v);
		});
		if ( jqueryObj.find('.general_error')[0]) {
			var body = $("html, body");
			if (jQuery(jqueryObj.find('.error')[0])) {
				var parentS = jQuery(jqueryObj.find('.error')[0]).parents(".section");
				if (parentS.length > 0) {
					var offset = parentS.offset().top;
					body.stop().animate({scrollTop:offset}, '500', 'swing');
				}
			}
		}
	}

	//if (jQuery(response.text).find('.progressbar').length) { initProgressbar(); }

    jQuery(glob_target).find('[autoload_old_version]').click();
	
    if (jQuery(response.text).attr('autoload')) {
        createAjaxRequest(jQuery(response.text));
    }
    if (jQuery(response.text).find('[autoload]').length) {
        createAjaxRequest(jQuery(response.text).find('[autoload]'));
    }

    initSelectFields();
    initDatepikcer();
    zIndexReset();
	submitOnEnter();
    
	if (ajax_debug) {
		jQuery("#"+target).append('<br /><a href="#" class="ajax_debug_link" title="resend AJAX request"><image src="'+image_path+'img/loader_debug.gif" alt="reload" /></a>');
		jQuery("#"+target).find('.ajax_debug_link').bind('click', function(){
			(jqueryObj[0].tagName.toLowerCase() == 'form')?(jqueryObj.submit()):(jqueryObj.click());
			return false;
		});
	}

	return false;
}