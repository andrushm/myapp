jQuery(function() {
    if (jQuery('#box-slider').length) {
        Slideshow.autostart=true;
        Slideshow.showControls=false;
        Slideshow.showAdditionalInfo=true;
        Slideshow.slideChangeDelay=4000;
        Slideshow.transitionEffectDelay=600;
        Slideshow.init();
    }
    
    initSelectFields();
    initDatepikcer();
    zIndexReset();
    submitOnEnter();


     if (jQuery(".colorpicker-input").length > 0) {
         var f = $.farbtastic('#picker');
         var elem = $('#picker');
         var p = elem.css('opacity', 0.25);
         var selected;
         jQuery(".colorpicker-input")
             .each(function (i) {
                 f.linkTo(this); $(this).css('opacity', 0.75);

                 $(this).focus(function() {
                     if (selected) {
                         $(selected).removeClass('colorwell-selected');
                     }
                     f.linkTo(this);
                     p.css('opacity', 1);
                     $(selected = this).addClass('colorwell-selected');

                     var pos = $(this).offset().top-$(this).parents("form").offset().top-elem.height()/4;
                     var prevPos = 0;
                     if ($(jQuery(".colorpicker-input")[i-1]) && i > 0) prevPos = $(jQuery(".colorpicker-input")[i-1]).offset().top-$(jQuery(".colorpicker-input")[i-1]).parents("form").offset().top-elem.height()/3;
                     if (prevPos < 0)prevPos=0;
                     if (pos < 0) pos=0;
                     if (pos > prevPos) pos=prevPos;
                     elem.animate({
                         marginTop: pos
                     }, 'quick');
                 });
             });

     }

    function str_replace(search, replace, subject, count) {
        //  discuss at: http://phpjs.org/functions/str_replace/

        var i = 0,
            j = 0,
            temp = '',
            repl = '',
            sl = 0,
            fl = 0,
            f = [].concat(search),
            r = [].concat(replace),
            s = subject,
            ra = Object.prototype.toString.call(r) === '[object Array]',
            sa = Object.prototype.toString.call(s) === '[object Array]';
        s = [].concat(s);
        if (count) {
            this.window[count] = 0;
        }

        for (i = 0, sl = s.length; i < sl; i++) {
            if (s[i] === '') {
                continue;
            }
            for (j = 0, fl = f.length; j < fl; j++) {
                temp = s[i] + '';
                repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0];
                s[i] = (temp)
                    .split(f[j])
                    .join(repl);
                if (count && s[i] !== temp) {
                    this.window[count] += (temp.length - s[i].length) / f[j].length;
                }
            }
        }
        return sa ? s : s[0];
    }

    function enterSymbols(obj) {
        var sep = "";
        if (numericType && numericType == "metric") {sep="."} else if (numericType && numericType == "imperial"){sep = ","}
        var newstr = str_replace(sep, "", $(obj).val());
        var newStr = newstr.formatNum();
        if ($(obj).val().length > 0) $(obj).val(newStr);
    }

    function slideRange(obj, range, rangeValues) {
        var sep = "";
        if (numericType && numericType == "metric") {sep="."} else if (numericType && numericType == "imperial"){sep = ","}
        var newstr = str_replace(sep, "", $(obj).val());
        var objV = newstr;
        var num = 0;

        if (parseInt(objV) > rangeValues[1]) {
            if (!range.hasClass("year_range")) {
                $(obj).val(rangeValues[1].toString().formatNum());
            } else {
                $(obj).val(rangeValues[1]);
            }
        } else if (parseInt(objV) < rangeValues[0]) {
            if (!range.hasClass("year_range")) {
                $(obj).val(rangeValues[0].toString().formatNum());
            } else {
                $(obj).val(rangeValues[0]);
            }
        }
        if ($(obj).hasClass("amount_1")){
            num = 0;
            if (parseInt(newstr) > str_replace(sep, "", $(obj).parent().find(".amount_2").val())) {
                var vall = str_replace(sep, "", $(obj).parent().find(".amount_2").val());
                (!range.hasClass("year_range"))?$(obj).val(vall.formatNum()):$(obj).val(vall);
                newstr = vall;
            }
        } else if ($(obj).hasClass("amount_2")){
            num=1;
            if (parseInt(newstr) < str_replace(sep, "", $(obj).parent().find(".amount_1").val())) {
                var vall = str_replace(sep, "", $(obj).parent().find(".amount_1").val());
                (!range.hasClass("year_range"))?$(obj).val(vall.formatNum()):$(obj).val(vall);
                newstr = vall;
            }
        }
        range.slider("values", num, newstr);
    }

    if (jQuery('.slider_box').length) {
        jQuery('.slider_range').each(function() {
            var t = jQuery(this);
            var amount_1 = jQuery(this).parent().find(".amount_1");
            var amount_2 = jQuery(this).parent().find(".amount_2");
            var range_options_field = jQuery(this).parent().find(".range_options");
            var min_value = parseInt(range_options_field.attr('min_value'));
            var max_value = parseInt(range_options_field.attr('max_value'));
            var value_1 = min_value;
            var value_2 = max_value;
            
            var step = 1;
            if (range_options_field.attr('step')!='')
                step = parseInt(range_options_field.attr('step'));
            if (range_options_field.attr('value_1')!='')
                value_1 = parseInt(range_options_field.attr('value_1'));
            if (range_options_field.attr('value_2')!='')
                value_2 = parseInt(range_options_field.attr('value_2'));
            //var measurement = ' '+range_options_field.attr('measurement');
//            amount_1.keyup(function() {sliderValueSeparator(this);});
            var measurement = '';
            jQuery(this).slider({
                range: true,
                min: min_value,
                max: max_value,
                values: [value_1, value_2],
                step:step,
                slide: function(event,ui) {
                    amount_1.val(ui.values[0]+measurement); 
                    amount_2.val(ui.values[1]+measurement);
                    var _this = jQuery(this);
                    if (!t.hasClass("year_range")) {
                        enterSymbols(amount_1[0]);
                        enterSymbols(amount_2[0]);
                    }
/*                     var delay = function() {
                        amount_1.css('left', _this.find('a:eq(0)').css('left'));
                        amount_2.css('left', _this.find('a:eq(1)').css('left'));
                    };
                    setTimeout(delay, 5); */
                }
            });
            amount_1.val(jQuery(this).slider("values",0)+measurement);
            amount_2.val(jQuery(this).slider("values",1)+measurement);
            amount_1.blur(function() {slideRange(this, t, [min_value,max_value]);});
            amount_2.blur(function() {slideRange(this, t, [min_value,max_value]);});
            if (!jQuery(this).hasClass("year_range")) {
                enterSymbols(amount_1[0]);
                enterSymbols(amount_2[0]);
                amount_1.keyup(function(event) {
                    if((event.which >= 48 && event.which <= 57) || (event.which >= 96 && event.which <= 105) || (event.which == 8))
                    {
                        enterSymbols(this);
                    }
                });
                amount_2.keyup(function(event) {
                    if((event.which >= 48 && event.which <= 57) || (event.which >= 96 && event.which <= 105) || (event.which == 8))
                    {
                        enterSymbols(this);
                    }

                });
            }

            /*             amount_1.css('left', jQuery(this).find('a:eq(0)').css('left'));
                        amount_2.css('left', jQuery(this).find('a:eq(1)').css('left')); */
        });
    }
    
     if (jQuery(".contact_box").length||jQuery(".projects_viewed").length) {
        var output_prevent_width = 1260;
        if (jQuery(window).width()>output_prevent_width) {
            jQuery("#main").css('left', '-100px');
        }
    }
    
    jQuery('[aref]').live('click', function(){
        createAjaxRequest(jQuery(this));
        return false;
    });
    
    jQuery("form.ajax_submit").live('submit', function(event){
        event.preventDefault();
        createFormSubmitRequest(jQuery(this));
        return false;
    });

    jQuery('[autoload]').click();
    
    jQuery('.showhide').live('click', function(){
        jQuery(this).next().slideToggle(500, function (){
            jQuery(this).toggleClass('hide');
        });
        jQuery(this).toggleClass('show');
    });
    
    jQuery('.filter_expand').live('click', function(){
        if (jQuery(this).hasClass('filter_more')) { jQuery(this).addClass('hide'); }
        if (jQuery(this).hasClass('filter_less')) { jQuery('.filter_expand.filter_more').removeClass('hide'); }
        jQuery(jQuery(this).attr('href')).toggleClass('hide');
        jQuery('#last_active_filter_expand_id').attr('value', jQuery(this).attr('id'));
		return false;
    });
    
    //if (jQuery('.progressbar').length) { initProgressbar(); }
	jQuery('.file_select_input').live('change', function(){
		jQuery(this).parent().parent().parent().find('.file_select_name').html(jQuery(this).attr('value').replace(/.*\\([^\\\/]+)$/,"$1")).addClass('show');
		jQuery(".file_select_button").removeClass('error');
		jQuery(".general_error").html('');
	});
	/*
    jQuery('.file_select_button').live('click', function(){
        jQuery(this).parent().find('input[type="file"]').click();
        return false;
    });
	*/
    
    FieldSwitcher.init();
	
    jQuery('.projects_viewed .list').jcarousel({
        vertical: true,
        scroll: 4
    });
	
	switch(jQuery('.projects_viewed .list > li').length) {
		case 1:jQuery('.projects_viewed .jcarousel-clip-vertical').css('height', '169px'); break
		case 2:jQuery('.projects_viewed .jcarousel-clip-vertical').css('height', '343px'); break
		case 3:jQuery('.projects_viewed .jcarousel-clip-vertical').css('height', '517px'); break			
	}
	
/* 	if (jQuery('.projects_viewed .list > li').length == 3) {
		
	}
	else if */
	
    jQuery('.detail_view ul').jcarousel({
        scroll: 4
    });
	
	jQuery("#filter_tabs").tabs({
        select: function(event, ui) {
            jQuery(this).find('input.last_active_tab_index').attr('value', ui.index);
        }
    });
    		
	jQuery(".fancybox-img").fancybox({
		'overlayShow'	: false,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic',
		'titlePosition' : 'inside'
	});

	jQuery('.checkAll').click(function () {
		jQuery(this).parents('#project-list').find(':checkbox').attr('checked', this.checked);
	});
	
	jQuery("#project-list input:checkbox").click(function(){
		if(jQuery("#project-list input:checkbox").is(":checked"))
			jQuery(".form-bar").slideDown();
		else 
			jQuery(".form-bar").slideUp();
	});
	
	
	jQuery( ".tabs" ).tabs().scrollabletab();
	
	jQuery("#nav").after(jQuery("#block-top").wrapInner());
	
    jQuery(".project-tabs li").click(function(){
		jQuery(".project-tabs li").removeClass('active');
		jQuery(this).addClass('active');
	});	
    	
    jQuery(".with_hint .radio").hover(
        function(){
            var obj = jQuery(this).find(".hint");
            this.tm = setTimeout(function(){obj.css("display", "block")} , 1000);
        }, 
        function(){
            jQuery(this).find(".hint").css("display", "none");
            if(this.tm) clearTimeout(this.tm);
    });
    jQuery(".with_hint .checkbox").hover(
        function(){
            var obj = jQuery(this).find(".hint");
            this.tm = setTimeout(function(){obj.css("display", "block")} , 1000);
        },
        function(){
            jQuery(this).find(".hint").css("display", "none");
            if(this.tm) clearTimeout(this.tm);
        });
	
	jQuery(".radio_switcher.size_1 .input").click(function(){
		jQuery(".radio_switcher.size_2 .input").removeClass("active");
	});
    
    jQuery('input[placeholder]').each(function() {
        inputPlaceholder(jQuery(this)[0]);
    });
	
	// Currency Sign 
	jQuery('.currency_signs select').change(function(){
         var value = jQuery(this).children("option:selected").attr('value');
		 var penny = jQuery(this).children("option:selected").attr('penny');
         jQuery('.currency_sign').text(value);
		 jQuery('.currency_penny').text(penny);
	});

    scrollPageTo('body');
	
});
