$(document).ready(function(){

    checkStore();

    function checkStore(){
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