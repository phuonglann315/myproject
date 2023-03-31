document.getElementById("abc").onclick = function () {
    document.getElementById("showmess").style.display = 'none';

};


function CHECK() {

    $("#NEWPASS").removeClass("error-field");
    $("#PASS").removeClass("error-field");
    $("#CFPASS").removeClass("error-field");


    let NEWPASS = $("#NEWPASS").val();
    let PASS = $("#PASS").val();
    let CFPASS = $("#CFPASS").val();



    $("#NEWPASS-info").html("").hide();
    $("#PASS-info").html("").hide();
    $("#CFPASS-info").html("").hide();


    let specialChars1 = "<>@!#$%^&*()_+[]{}?:;|'\"\\,./~`-=";
    let checkForSpecialChar1 = function (string) {
        for (i = 0; i < specialChars1.length; i++) {
            if (string.indexOf(specialChars1[i]) > -1) {
                return true
            }
        }
        return false;
    }
//khảo sát user name
    let specialChars = "àảãáạăằẳẵắặâầẩẫấậÀẢÃÁẠĂẰẲẴẮẶÂẦẨẪẤẬđĐèẻẽéẹêềểễếệÈẺẼÉẸÊỀỂỄẾỆìỉĩíịÌỈĨÍỊòỏõóọôồổỗốộơờởỡớợÒỎÕÓỌÔỒỔỖỐỘƠỜỞỠỚỢùủũúụưừửữứựÙỦŨÚỤƯỪỬỮỨỰỳỷỹýỵỲỶỸÝỴ";
    let checkForSpecialChar = function (string) {
        for (i = 0; i < specialChars.length; i++) {
            if (string.toString().indexOf(specialChars[i]) > -1) {
                return true
            }
        }
        return false;
    }
//     //khảo sát pass và confirm pass
    if ((PASS.trim().length < 8) || (PASS.trim().length > 32)) {
        $("#PASS-info").html("Password need the length from 8 to 32 characters").css("color", "#ee0000").show();
        $("#PASS").addClass("error-field");
        return false;
    }

    if (!checkForSpecialChar1(PASS)) {
        $("#PASS-info").html("Password needs at least one special character ").css("color", "#ee0000").show();
        $("#PASS").addClass("error-field");
        return false;
    }
    if (!/[0-9]/g.test(PASS)) {
        $("#PASS-info").html("Password needs at least 1 number ").css("color", "#ee0000").show();
        $("#PASS").addClass("error-field");
        return false;
    }
    if (!/[A-Z]/g.test(PASS)) {
        $("#PASS-info").html("Password needs at least 1 capital letter ").css("color", "#ee0000").show();
        $("#PASS").addClass("error-field");
        return false;
    }
    if (!/[a-z]/g.test(PASS)) {
        $("#PASS-info").html("Password needs at least 1 lower case letter ").css("color", "#ee0000").show();
        $("#PASS").addClass("error-field");
        return false;
    }
    if (checkForSpecialChar(PASS)) {
        $("#PASS-info").html("PASS do not allow unicode").css("color", "#ee0000").show();
        $("#PASS").addClass("error-field");
        return false;
    }
//===========
        if ((NEWPASS.trim().length < 8) || (NEWPASS.trim().length > 32)) {
            $("#NEWPASS-info").html("Password need the length from 8 to 32 characters").css("color", "#ee0000").show();
            $("#NEWPASS").addClass("error-field");
            return false;
        }

        if (!checkForSpecialChar1(NEWPASS)) {
            $("#NEWPASS-info").html("Password needs at least one special character ").css("color", "#ee0000").show();
            $("#NEWPASS").addClass("error-field");
            return false;
        }
        if (!/[0-9]/g.test(NEWPASS)) {
            $("#NEWPASS-info").html("Password needs at least 1 number ").css("color", "#ee0000").show();
            $("#NEWPASS").addClass("error-field");
            return false;
        }
        if (!/[A-Z]/g.test(NEWPASS)) {
            $("#NEWPASS-info").html("Password needs at least 1 capital letter ").css("color", "#ee0000").show();
            $("#NEWPASS").addClass("error-field");
            return false;
        }
        if (!/[a-z]/g.test(NEWPASS)) {
            $("#NEWPASS-info").html("Password needs at least 1 lower case letter ").css("color", "#ee0000").show();
            $("#NEWPASS").addClass("error-field");
            return false;
        }
        if (checkForSpecialChar(NEWPASS)) {
            $("#NEWPASS-info").html("Pass do not allow unicode").css("color", "#ee0000").show();
            $("#NEWPASS").addClass("error-field");
            return false;
        }

        if ((PASS === NEWPASS)) {
            $("#NEWPASS-info").html("new password look like current password, kindly recheck").css("color", "#ee0000").show();
            $("#NEWPASS").addClass("error-field");
            return false;
        }


    if (!(NEWPASS === CFPASS)) {
        $("#CFPASS-info").html("Kindly re-confirm your password").css("color", "#ee0000").show();
        $("#CFPASS").addClass("error-field");
        return false;
    }


// khảo sát email




    return true;
}

function CHECKPHONE() {

    $("#PHONE").removeClass("error-field");
    $("#NEWPHONE").removeClass("error-field");


    let PHONE = $("#PHONE").val();
    let NEWPHONE = $("#NEWPHONE").val();

    $("#PHONE-info").html("").hide();
    $("#NEWPHONE-info").html("").hide();

    let specialChars1 = "<>@!#$%^&*()_+[]{}?:;|'\"\\,./~`-=";
    let checkForSpecialChar1 = function (string) {
        for (i = 0; i < specialChars1.length; i++) {
            if (string.indexOf(specialChars1[i]) > -1) {
                return true
            }
        }
        return false;
    }

    let specialChars = "àảãáạăằẳẵắặâầẩẫấậÀẢÃÁẠĂẰẲẴẮẶÂẦẨẪẤẬđĐèẻẽéẹêềểễếệÈẺẼÉẸÊỀỂỄẾỆìỉĩíịÌỈĨÍỊòỏõóọôồổỗốộơờởỡớợÒỎÕÓỌÔỒỔỖỐỘƠỜỞỠỚỢùủũúụưừửữứựÙỦŨÚỤƯỪỬỮỨỰỳỷỹýỵỲỶỸÝỴ";
    let checkForSpecialChar = function (string) {
        for (i = 0; i < specialChars.length; i++) {
            if (string.toString().indexOf(specialChars[i]) > -1) {
                return true
            }
        }
        return false;
    }

// khảo sát phone
    if (PHONE === "") {
        $("#PHONE-info").html("kindly input your phone number ").css("color", "#ee0000").show();
        $("#PHONE").addClass("error-field");
        return false;
    }
    else if (PHONE.trim().length < 10){
        $("#PHONE-info").html("phone number need the length from 10 the number ").css("color", "#ee0000").show();
        $("#PHONE").addClass("error-field");
        return false;
    }
    let specialChars2 = "<>@!#$%^&*_[]{}?:;|'\"\\,/~`=";
    let checkForSpecialChar2 = function (string) {
        for (i = 0; i < specialChars2.length; i++) {
            if (string.indexOf(specialChars2[i]) > -1) {
                return true
            }
        }
        return false;
    }

    if (checkForSpecialChar2(PHONE)) {
        $("#PHONE-info").html("Phone number do not allow <>@!#$%^&*_[]{}?:;|'\"\\,/~`=  ").css("color", "#ee0000").show();
        $("#PHONE").addClass("error-field");
        return false;
    }
    if ((/[A-Z,a-z]/g.test(PHONE))) {
        $("#PHONE-info").html("Phone number do not allow character ").css("color", "#ee0000").show();
        $("#PHONE").addClass("error-field");
        return false;
    }
    if (checkForSpecialChar(PHONE)) {
        $("#PHONE-info").html("PASS do not allow unicode").css("color", "#ee0000").show();
        $("#PHONE").addClass("error-field");
        return false;
    }
//===============
    if (NEWPHONE === "") {
        $("#NEWPHONE-info").html("kindly input your phone number ").css("color", "#ee0000").show();
        $("#NEWPHONE").addClass("error-field");
        return false;
    }
    else if (NEWPHONE.trim().length < 10){
        $("#NEWPHONE-info").html("phone number need the length from 10 the number ").css("color", "#ee0000").show();
        $("#NEWPHONE").addClass("error-field");
        return false;
    }

    if (checkForSpecialChar2(NEWPHONE)) {
        $("#NEWPHONE-info").html("Phone number do not allow <>@!#$%^&*_[]{}?:;|'\"\\,/~`=  ").css("color", "#ee0000").show();
        $("#NEWPHONE").addClass("error-field");
        return false;
    }
    let specialChars7 = "aABbCcDdEeFfGghHIiKkLlMmNnOoPpQqRrSsTtVvWwUuSsXxZzYyJj";
    let checkForSpecialChar7 = function (string) {
        for (i = 0; i < specialChars7.length; i++) {
            if (string.indexOf(specialChars7[i]) > -1) {
                return true
            }
        }
        return false;
    }
    if (checkForSpecialChar7(NEWPHONE)) {
        $("#PHONE-info").html("Phone number do not allow character ").css("color", "#ee0000").show();
        $("#PHONE").addClass("error-field");
        return false;
    }
    if (checkForSpecialChar(NEWPHONE)) {
        $("#NEWPHONE-info").html("PASS do not allow unicode").css("color", "#ee0000").show();
        $("#NEWPHONE").addClass("error-field");
        return false;
    }

    return true;
}
function CHECKEMAIL() {


    $("#NEWEMAIL").removeClass("error-field");
    $("#EMAIL").removeClass("error-field");


    let NEWEMAIL = $("#NEWEMAIL").val();
    let EMAIL = $("#EMAIL").val();




    $("#NEWEMAIL-info").html("").hide();
    $("#EMAIL-info").html("").hide();



//khảo sát user name
    let specialChars = "àảãáạăằẳẵắặâầẩẫấậÀẢÃÁẠĂẰẲẴẮẶÂẦẨẪẤẬđĐèẻẽéẹêềểễếệÈẺẼÉẸÊỀỂỄẾỆìỉĩíịÌỈĨÍỊòỏõóọôồổỗốộơờởỡớợÒỎÕÓỌÔỒỔỖỐỘƠỜỞỠỚỢùủũúụưừửữứựÙỦŨÚỤƯỪỬỮỨỰỳỷỹýỵỲỶỸÝỴ";
    let checkForSpecialChar = function (string) {
        for (i = 0; i < specialChars.length; i++) {
            if (string.toString().indexOf(specialChars[i]) > -1) {
                return true
            }
        }
        return false;
    }

// khảo sát email
    let specialChars3 = "<>@!#$%^&*()_+[]{}?:;|'\"\\,/~`-=";
    let checkForSpecialChar3 = function (string) {
        for (i = 0; i < specialChars1.length; i++) {
            if (string.indexOf(specialChars1[i]) > -1) {
                return true
            }
        }
        return false;
    }
    let aCong = EMAIL.indexOf('@');
    let dauCham = EMAIL.lastIndexOf('.');
    if (EMAIL === "") {
        $("#EMAIL-info").html("kindly input your email ").css("color", "#ee0000").show();
        $("#EMAIL").addClass("error-field");
        return false;
    }
    else if ((aCong < 1) || (dauCham < aCong + 2) || (dauCham + 2 > EMAIL.length)) {
        $("#EMAIL-info").html(`Email must have the @ character,Before @ has at least 1 character,Must have at least 1 "." after @,has at least 1 letter character between @ and .must not be last`).css("color", "#ee0000").show();
        $("#EMAIL").addClass("error-field");
        return false;

    }
    if (checkForSpecialChar(EMAIL)) {
        $("#EMAIL-info").html("Email do not allow unicode").css("color", "#ee0000").show();
        $("#EMAIL").addClass("error-field");
        return false;
    }
    if (specialChars3(EMAIL)) {
        $("#EMAIL-info").html("sorry, only letters(a-z), number(0-9),and preriods (.) are allowed ").css("color", "#ee0000").show();
        $("#EMAIL").addClass("error-field");
        return false;
    }
    //NEW EMAIL

    let aCong1 = NEWEMAIL.indexOf('@');
    let dauCham1 = NEWEMAIL.lastIndexOf('.');
    if (NEWEMAIL === "") {
        $("#NEWEMAIL-info").html("kindly input your email ").css("color", "#ee0000").show();
        $("#NEWEMAIL").addClass("error-field");
        return false;
    }
    else if ((aCong1 < 1) || (dauCham1 < aCong + 2) || (dauCham1 + 2 > NEWEMAIL.length)) {
        $("#NEWEMAIL-info").html(`Email must have the @ character,Before @ has at least 1 character,Must have at least 1 "." after @,has at least 1 letter character between @ and .must not be last`).css("color", "#ee0000").show();
        $("#EMAIL").addClass("error-field");
        return false;

    }
    if (checkForSpecialChar(NEWEMAIL)) {
        $("#NEWEMAIL-info").html("Email do not allow unicode").css("color", "#ee0000").show();
        $("#NEWEMAIL").addClass("error-field");
        return false;
    }
    if (specialChars3(NEWEMAIL)) {
        $("#NEWEMAIL-info").html("sorry, only letters(a-z), number(0-9),and preriods (.) are allowed ").css("color", "#ee0000").show();
        $("#NEWEMAIL").addClass("error-field");
        return false;
    }



    return true;
}


