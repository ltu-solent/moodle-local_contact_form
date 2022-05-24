define(['jquery', 'core/str', 'core/notification'], function($, str, notification) {

    return {
        init: function() {
            $("input[name='querytype']").click(function(){
                var radioValue = $("input[name='querytype']:checked").val();
                if(radioValue){
                    var adviceText = str.get_strings([
                        {key: radioValue,
                            component: 'local_contact_form'
                       },
                    ]);
                    $.when(adviceText).done(function() {
                         $('#querytypehelp').html(M.util.get_string(radioValue, 'local_contact_form'));
                    }).fail(notification.exception);
               }
            });
        }
    };
});