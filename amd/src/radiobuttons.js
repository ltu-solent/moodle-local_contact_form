define(['jquery', 'core/str', 'core/notification'], function($, str, notification) {

    return {
        init: function() {
            $("input[name='querytype']").click(function(){
                var radioValue = $("input[name='querytype']:checked").val();
                if(radioValue){
                    // return(radiovalue);
                    alert("Your are a - " + radioValue);
                    var adviceText = str.get_strings([
                        {key: radioValue, component: 'local_contact_form'},
                    ]);
                    alert(adviceText);
                    // var stringargument = '';
                    // var adviceText = str.get_string(radioValue, 'local_contact_form', stringargument);
                    // as soon as the string is retrieved, i.e. the promise has been fulfilled,111
                    // edit the text of a UI element so that it then is the localized string
                    // Note: $.when can be used with an arbitrary number of promised things
                    // $.when(adviceText).done(function(localizedEditString) {
                    //      $(".form-control-static").text = localizedEditString;
                    // });
                    // alert(M.util.get_string(radioValue, 'local_contact_form'));
                    $.when(adviceText).done(function() {
                        // alert(M.util.get_string(radioValue, 'local_contact_form'));
                         $('.form-control-static').text(M.util.get_string(radioValue, 'local_contact_form'));
                    }).fail(notification.exception);
               }
            });
        }
    };
});