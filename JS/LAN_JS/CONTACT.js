function changePic() {
    NAMEIM.src = URL.createObjectURL(event.target.files[0]);
}

//Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        mybutton.style.display = "block";
    } else {
        mybutton.style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
function checkForm(){
    //check name
    let str = document.getElementById("name").value;
    var letters = /^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/;
    if (str.length === 0) {
        document.getElementById("info").innerHTML = "Fullname cannot be blank!";
        document.getElementById("name").focus();
        return false;
    }

    if (str.trim().length < 5 || str.trim().length > 20) {
        document.getElementById("info").innerHTML = "Fullname must has at least 5 characters and less than 20 characters!";
        document.getElementById("name").focus();
        return false;
    }
    if (str.match(letters)) {
        console.log(str);
    } else {
        document.getElementById("info").innerHTML = "Please input alphabet characters only";
        document.getElementById("name").focus();
        return false;
    }
    //check phone

    let str1 = document.getElementById("phone").value;
    var numbers = /^[0-9]+$/;
    if (str1.trim().length === 0) {
        document.getElementById("info1").innerHTML = "Phone number cannot be blank!";
        document.getElementById("phone").focus();
        return false;
    }
    if (str1.trim().length !== 10) {
        document.getElementById("info1").innerHTML = "Your phone number not valid!";
        document.getElementById("phone").focus();
        return false;
    }
    if (str1.trim().match(numbers)) {
        console.log(str1);
    } else {
        document.getElementById("info1").innerHTML = "Please input numeric characters only";
        document.getElementById("phone").focus();
        return false;
    }

    return true;
}