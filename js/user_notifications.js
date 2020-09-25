$(document).ready(function(){

    sendRequest();

    function sendRequest(){
        $.ajax({
            url: "",
            success: function(data){
                console.log(data);
            },
            complete: function () {
                setInterval(sendRequest(),5000);
            }
        });
    }
});