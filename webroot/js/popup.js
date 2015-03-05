var Popup={
    init:function(){
        var _this=this;
        this.inited = true;
        jQuery('body').append('<div id="dialog"><div class="popup_body"></div></div>');
    },
    sizeAssociativeArray: function(obj) {
        var size = 0, key;
        for (key in obj) {
            if (obj.hasOwnProperty(key)) size++;
        }
        return size;
    },
    show:function(content, popup_type, action_id, callbacks, closeOnBG) {
        var t = this;
        if (!this.inited) this.init();
        var button = {};
        var showModal = true;
        switch(popup_type)
        {
            case 'sys_win':
                button_funcs = { };
                //showModal = false;
                break;
            case 'not_close_sys_win':
                button_funcs = { };
                //showModal = false;
                break;
            case 'alert':
                //alert(ok_button);
                button_funcs = { ok: function() { jQuery(this).dialog("close"); } };
                //showModal = false;
                break;
            case 'confirm':
                button_funcs = {
                    ok: function() {
                        if (action_id) {
                            if (jQuery('#'+action_id).is('form.ajax_submit')) {
                                createFormSubmitRequest(jQuery('#'+action_id));
                            } else {
                                createAjaxRequest(jQuery('#'+action_id));
                            }
                            jQuery(this).dialog("close");
                            return false;
                        }
                    },
                    cancel: function() {
                        jQuery(this).dialog("close"); return false;
                    }
                };
                break;
            default:
                button_funcs = { };
        }

        for(var i in button_funcs){
            button[button_text[i]]=button_funcs[i];
        }
        jQuery('#dialog .popup_body').html(content);
        jQuery('#dialog').attr('title', 'Popup');
        jQuery('#dialog').dialog({
            autoOpen: false,
            width: 'auto',
            buttons: button,
            modal:showModal,
            closeOnEscape: false
        });


        if (callbacks && this.sizeAssociativeArray(callbacks) > 0) {

            // callbacks: any event name which jquery ui dialog has, such as beforeClose, close, create, focus, open etc.

            for (var key in callbacks) {
                if (typeof callbacks[key] == "string") {
                    var fn = (new Function(callbacks[key]));
                    jQuery('#dialog').dialog("option", key, fn);
                } else if (typeof callbacks[key] == "function") {
                    jQuery('#dialog').dialog("option", key, callbacks[key]);
                }
            }
        }

        jQuery('#dialog .popup_body').removeClass('info_window');
        if ($.browser.msie  && parseInt($.browser.version, 10) === 7) { // for ie7 close button
            jQuery(".ui-dialog .ui-dialog-titlebar-close").css({ 'right':'', 'left': '' });
        }
        if (jQuery('#dialog .popup_body').find('.body').length <= 0) {
            jQuery('#dialog .popup_body').addClass('info_window');
            jQuery('#dialog').parent().find('.ui-dialog-buttonpane').addClass('buttons_top');
        }  else {

        }

        jQuery('#dialog').dialog('open');

        if ($.browser.msie  && parseInt($.browser.version, 10) === 7) { // for ie7 close button
            jQuery(".ui-dialog .ui-dialog-titlebar-close").css({ 'right':'auto', 'left': jQuery('#dialog .popup_body').width()+'px' });
        }
        if(popup_type == 'not_close_sys_win'){
            jQuery(".ui-dialog .ui-dialog-titlebar-close").css({ 'display':'none'});
        }


        if (closeOnBG) {
            $(".ui-widget-overlay").click(function(){
                $(".ui-dialog-titlebar-close").trigger('click');
            });
        }

        return false;
    },
    close:function(){
        jQuery('#dialog').dialog('close');
        return false;
    },
    alert:function(content, callbacks, closeOnBG){
        this.show(content, 'alert', null, callbacks, closeOnBG);
        return false;
    },
    confirm:function(content, action_id, callbacks, closeOnBG){
        this.show(content, 'confirm', action_id, callbacks, closeOnBG);
        return false;
    },
    sys_win:function(content, callbacks, closeOnBG){
        this.show(content, 'sys_win', null, callbacks, closeOnBG);
        return false;
    },
    not_close_sys_win:function(content, callbacks, closeOnBG){
        this.show(content, 'not_close_sys_win', null, callbacks, closeOnBG);
        return false;
    },
    checkPopupHeight:function(){
        var dH = jQuery("#dialog").height()+jQuery("#dialog").offset().top,
            oH = jQuery(".ui-widget-overlay").height();
        if (dH > oH) jQuery(".ui-widget-overlay").height(oH+(dH-oH)+20);
    }
}