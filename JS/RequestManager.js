
class RequestManager {

    constructor() {
        let array = location.pathname.split("/");
        this.path = array[array.length - 1] == "" || array[array.length - 1].split("?")[0] == "index.php" || array[array.length - 1].split("?")[0] == "mainpage.php" ? "." : "..";
    }

    // true -> post, false -> get
    request(url, argObj, callbackFunction, method) {
        argObj.path = this.path;
        return $.ajax({
            url: url,
            data: argObj,
            method: method ? 'POST' : 'GET',
            error: () => { console.log('Ajax request error'); }
        }).done(callbackFunction);
    }

}
