var cookie = {
    setCookie: function (cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toGMTString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    },
    getCookie: function (cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i].trim();
            if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
        }
        return "";
    },
    // checkCookie: function () {
    //     var username = getCookie("username");
    //     if (username != "") {
    //         alert("Welcome again " + username);
    //     }
    //     else {
    //         username = prompt("Please enter your name:", "");
    //         if (username != "" && username != null) {
    //             setCookie("username", username, 365);
    //         }
    //     }
    // }
};