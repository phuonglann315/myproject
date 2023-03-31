function CHECK() {

    $("#USERNAME").removeClass("error-field");
    $("#PASS").removeClass("error-field");
    $("#CFPASS").removeClass("error-field");


    $("#EMAIL").removeClass("error-field");
    $("#PHONE").removeClass("error-field");


    let USERNAME = $("#USERNAME").val();
    let PASS = $("#PASS").val();
    let CFPASS = $("#CFPASS").val();


    let EMAIL = $("#EMAIL").val();
    let PHONE = $("#PHONE").val();


    $("#message-info").html("").hide();

    $("#USERNAME-info").html("").hide();
    $("#PASS-info").html("").hide();
    $("#CFPASS-info").html("").hide();

    $("#EMAIL-info").html("").hide();
    $("#PHONE-info").html("").hide();

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
    if ((USERNAME.trim().length < 6) || (USERNAME.trim().length > 25)) {
        $("#USERNAME-info").html("Username need the length from 6 to 25 characters").css("color", "#ee0000").show();
        $("#USERNAME").addClass("error-field");
        return false;
    }
    if ((USERNAME.split(" ").length - 1) != 0) {
        $("#USERNAME-info").html("Username do not allow spaces").css("color", "#ee0000").show();
        $("#USERNAME").addClass("error-field");
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
    if (checkForSpecialChar(USERNAME)) {
        $("#USERNAME-info").html("Username do not allow unicode").css("color", "#ee0000").show();
        $("#USERNAME").addClass("error-field");
        return false;
    }
    if (checkForSpecialChar1(USERNAME)) {
        $("#USERNAME-info").html("Username do not allow special character").css("color", "#ee0000").show();
        $("#USERNAME").addClass("error-field");
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

    if (!(PASS === CFPASS)) {
        $("#CFPASS-info").html("Kindly re-confirm your password").css("color", "#ee0000").show();
        $("#CFPASS").addClass("error-field");
        return false;
    }


// khảo sát email
    let specialChars3 = "<>!#$%^&*()_+[]{}?:;|'\"\\,/~`-=";
    let checkForSpecialChar3 = function (string) {
        for (i = 0; i < specialChars3.length; i++) {
            if (string.indexOf(specialChars3[i]) > -1) {
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
    if ((aCong < 1) || (dauCham < aCong + 2) || (dauCham + 2 > EMAIL.length)) {
        $("#EMAIL-info").html(`Email must have the @ character,Before @ has at least 1 character,Must have at least 1 "." after @,has at least 1 letter character between @ and .must not be last`).css("color", "#ee0000").show();
        $("#EMAIL").addClass("error-field");
        return false;

    }
    if (checkForSpecialChar(EMAIL)) {
        $("#EMAIL-info").html("Email do not allow unicode").css("color", "#ee0000").show();
        $("#EMAIL").addClass("error-field");
        return false;
    }
    if (checkForSpecialChar3(EMAIL)) {
        $("#EMAIL-info").html("sorry, only letters(a-z), number(0-9),and preriods (.) are allowed ").css("color", "#ee0000").show();
        $("#EMAIL").addClass("error-field");
        return false;
    }
// khảo sát phone
    if (PHONE === "") {
        $("#PHONE-info").html("kindly input your phone number ").css("color", "#ee0000").show();
        $("#PHONE").addClass("error-field");
        return false;
    }
    if (PHONE.trim().length < 10) {
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

    return true;
}

function abc() {

    $("#FULLNAME").removeClass("error-field");

    $("#ADDRESS").removeClass("error-field");


    let FULLNAME = $("#FULLNAME").val();

    let ADDRESS = $("#ADDRESS").val();


    $("#FULLNAME-info").html("").hide();

    $("#ADDRESS-info").html("").hide();

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
    if ((FULLNAME.trim().length < 3) || (FULLNAME.trim().length > 50)) {
        $("#FULLNAME-info").html("fullname need the length from 6 to 15 characters").css("color", "#ee0000").show();
        $("#FULLNAME").addClass("error-field");
        return false;
    } else if ((FULLNAME.split(" ").length - 1) == 0) {
        $("#FULLNAME-info").html("fullname needs at least one spaces").css("color", "#ee0000").show();
        $("#FULLNAME").addClass("error-field");
        return false;
    } else if (checkForSpecialChar1(FULLNAME)) {
        $("#FULLNAME-info").html("fullname do not allow special character ").css("color", "#ee0000").show();
        $("#FULLNAME").addClass("error-field");
        return false;
    } else if (/[0-9]/g.test(FULLNAME)) {
        $("#FULLNAME-info").html("fullname do not allow the number ").css("color", "#ee0000").show();
        $("#FULLNAME").addClass("error-field");
        return false;
    }
    if (ADDRESS === "") {
        $("#ADDRESS-info").html("kindly input your address ").css("color", "#ee0000").show();
        $("#ADDRESS").addClass("error-field");
        return false;
    } else if (ADDRESS.trim().length < 15) {
        $("#ADDRESS-info").html("The address need the length from 30 character").css("color", "#ee0000").show();
        $("#ADDRESS").addClass("error-field");
        return false;
    } else if ((ADDRESS.split(" ").length - 1) == 0) {
        $("#ADDRESS-info").html("The address needs at least one spaces").css("color", "#ee0000").show();
        $("#ADDRESS").addClass("error-field");
        return false;
    }

    return true;
}