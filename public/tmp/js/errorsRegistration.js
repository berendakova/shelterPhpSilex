/*
$(document).ready(function () {
    $("#reg").click(function () {
            $.ajax({
                url : 'Registration',
                data : {
                    user_name: ${
                }
            })
        }
    );
}
*/


function validate(email) {

    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    if(!reg.test(email)) {
        return "not correct email";
    }
    else{
        return "ok";
    }
}

function okPassword(password1, password2) {
    var answ ;
    if(password1===password2 && password1.length() >= 6){
        answ = "true";
    }
    else if (password1.length() < 6){
        answ = "must be > 6";
    }
    else if (password1 !== password2){
        answ = "not equalse passwords";
    }
    return answ;
}