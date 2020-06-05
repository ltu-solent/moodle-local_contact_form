define(['jquery'], function($) {
    return {
        init: function() {
             // Put whatever you like here. $ is available
            // to you as normal.
            // $('input[name="name_of_your_radiobutton"]:checked').val();
            // $('input[name="querytype"]:checked').on('change', function(){
            //     alert($('input[name=querytype]:checked', '.mform').val());
            // });
            // $('[name="querytype"').on('change', function() {
                // alert($('input[name=querytype]:checked', '.mform').val());
            // });

            $("input[type='radio']").click(function(){
                var radioValue = $("input[name='querytype']:checked").val();
                if(radioValue){
                    alert("Your are a - " + radioValue);
                }
            });
        }
    };
});