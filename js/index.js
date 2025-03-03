$(document).ready(function(){
    $("#loginForm").submit(function(e){
        //this prevent the form from passing info to the url
        e.preventDefault();
        // this calls the login function
        login();
    });
});

function login() {
    let url = "php/login.php";
    let data = $("#loginForm").serialize();

    $.post(url, data,
        function(response){
            let decodedJson = JSON.parse(response);
            if(decodedJson.success == 1){  // Fixed typo: 'sucess' to 'success'
                $.toast('Login successful');
                window.location.href = "/landing.html";  // Redirect to landing.html
            }else{
                $.toast(decodedJson.message);  // Fixed typo: 'massage' to 'message'
            }
        });
}
