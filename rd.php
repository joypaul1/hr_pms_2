<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>jQuery Create a "Please Wait, Loading..." Animation</title>
<style>
    .overlay{
        display: none;
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 999;
        background: rgba(255,255,255,0.8) url("/examples/images/loader.gif") center no-repeat;
    }
    body{
        text-align: center;
    }
    /* Turn off scrollbar when body element has the loading class */
    body.loading{
        overflow: hidden;   
    }
    /* Make spinner image visible when body element has the loading class */
    body.loading .overlay{
        display: block;
    }
</style>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
// Initiate an Ajax request on button click
$(document).on("click", "button", function(){
    // Adding timestamp to set cache false
    $.get("/examples/php/customers.php?v="+ $.now(), function(data){
        $("body").html(data);
    });       
});

// Add remove loading class on body element depending on Ajax request status
$(document).on({
    ajaxStart: function(){
        $("body").addClass("loading"); 
    },
    ajaxStop: function(){ 
        $("body").removeClass("loading"); 
    }    
});
</script>
</head>
<body>
    <button type="button">Get Customers Details</button>
    <h3>Click the above button to get the customers details from the web server via Ajax.</h3>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam eu sem tempor, varius quam at, luctus dui. Mauris magna metus, dapibus nec turpis vel, semper malesuada ante. Vestibulum id metus ac nisl bibendum scelerisque non non purus. Suspendisse varius nibh non aliquet sagittis. In tincidunt orci sit amet elementum vestibulum. Vivamus fermentum in arcu in aliquam. Quisque aliquam porta odio in fringilla. Vivamus nisl leo, blandit at bibendum eu, tristique eget risus. Integer aliquet quam ut elit suscipit, id interdum neque porttitor. Integer faucibus ligula.</p>
    <div class="overlay"></div>
</body>
</html> 