define(['jquery'], function($) {
    return {
        init: function() {
             // Put whatever you like here. $ is available
            // to you as normal.
            $('#id_querytype_Assessment').click(function() {
                // alert('clicked');
                if ($("#id_courselist").val() === "0") {
                    alert('Must select a course');
}
            });

        }
    };
});