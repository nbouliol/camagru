function ajaxRequest(target, tab) {
    xhttp = new XMLHttpRequest();
    xhttp.open("POST", target, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    var i = 0;
    var str = "";
    for(var index in tab) {
        var attr = tab[index];

        if (i >= 1) { str += "&"; }
        str += index + "=" + attr;
        i++;

    }

    // console.log(str);
    xhttp.send(str);

    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            // console.log(xhttp.responseText);
            // location.reload(true);
            window.location = window.location;
        }
    }
}
