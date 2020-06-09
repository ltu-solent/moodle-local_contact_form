define(['jquery'], function($) {
    $("input[name='querytype']").click(function(){
        var radioValue = $("input[name='querytype']:checked").val();
        if(radioValue){
            // return(radiovalue);
            alert("Your are a - " + radioValue);

            if(radioValue === 'Assessment_Missing_Dates_Incorrect') {
                alert('yes');
            } else if(radioValue === 'Assessment_Other') {
                alert('No');
            } else if(radioValue === 'Unit_leader_enrolment') {

            } else if (radioValue === 'Staff_other') {

            } else if (radioValue === 'Access/account/password') {

            } else if (radioValue === '') {
                
            }



            return radioValue;
       }
    });
});