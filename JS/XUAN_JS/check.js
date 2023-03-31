function CHECK() {

    $("#NEWPASS").removeClass("error-field");

    $("#CFPASS").removeClass("error-field");


    let NEWPASS = $("#NEWPASS").val();

    let CFPASS = $("#CFPASS").val();



    $("#NEWPASS-info").html("").hide();

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
    let specialChars = "àảãáạăằẳẵắặâầẩẫấậÀẢÃÁẠĂẰẲẴẮẶÂẦẨẪẤẬđĐèẻẽéẹêềểễếệÈẺẼÉẸÊỀỂỄẾỆìỉĩíịÌỈĨÍỊòỏõóọôồổỗốộơờởỡớợÒỎÕÓỌÔỒỔỖỐỘƠỜỞỠỚỢùủũúụưừửữứựÙỦŨÚỤƯỪỬỮỨỰỳỷỹýỵỲỶỸÝỴ";
    let checkForSpecialChar = function (string) {
        for (i = 0; i < specialChars.length; i++) {
            if (string.toString().indexOf(specialChars[i]) > -1) {
                return true
            }
        }
        return false;
    }
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
    return true;
}
