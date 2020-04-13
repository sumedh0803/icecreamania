$(document).ready(function (){
    window.location = "index.html?#";
    var dialog = $("#dialog");
    var dialogDelivery = $("#dialog-delivery");
    var dialogNoDelivery = $("#dialog-no-delivery");
    
    $("#login").click(function (){
        //dialog.show();
        dialog.fadeIn(100);
        $(".mdl-layout__container").addClass("blur-filter");
      
        imageSources = ["Ice Cream Icons-01.png", "Ice Cream Icons-02.png",
        "Ice Cream Icons-03.png","Ice Cream Icons-04.png","Ice Cream Icons-05.png",
        "Ice Cream Icons-06.png","Ice Cream Icons-07.png","Ice Cream Icons-08.png",
        "Ice Cream Icons-09.png","Ice Cream Icons-10.png","Ice Cream Icons-11.png",
        "Ice Cream Icons-12.png","Ice Cream Icons-13.png","Ice Cream Icons-14.png",
        "Ice Cream Icons-15.png","Ice Cream Icons-16.png"]
        index = 0
        timeout = setInterval(function(){ 
            if(index == imageSources.length)
                index = 0;
                $('#images').attr('src', './images/'+imageSources[index]);
                //$('#images').$("#test p").delay(1000).animate({ opacity: 1 }, 700);​
                index++;

             },
             2000);
        
        
    });
    $("#dialog-close-1").click(function (){
        dialog.hide();
        $(".mdl-layout__container").removeClass("blur-filter");
        clearTimeout(timeout);
    });
    $("#dialog-close-2").click(function (){
        dialogDelivery.hide();
        $(".mdl-layout__container").removeClass("blur-filter");
    });
    $("#dialog-close-3").click(function (){
        dialogNoDelivery.hide();
        $(".mdl-layout__container").removeClass("blur-filter");
    });

    $(".addr").on("click",function()
    {
        var address = $('#address').val();
        $.ajax({
            type:"POST",
            url:"getDistance.php",
            data: { address: address },
            success: function (data){
                if(data == "T")
                {
                    dialogDelivery.fadeIn(100); 
                    $(".mdl-layout__container").addClass("blur-filter");
                }
                else
                {
                    dialogNoDelivery.fadeIn(100);
                    $(".mdl-layout__container") .addClass("blur-filter");
                }
            },
            error: function (data){
                alert(data.message);
            }
        });
    });

    $("#login-btn").on("click",function(){
        $.ajax({
            type:"POST",
            url:"includes/login.php",
            data: { email: $("#email").val(),
                    pwd: $("#password").val()
                },
            success: function (data){
                console.log(data);  
                var res = data.split(",");
                if(res[0] == "admin")
                {
                    //redir to admin
                    window.location = "menu.php";
                }
                else if(res[0] == "user")
                {
                    window.location = "menu.php";
                }
                else if(res[0] == "error")
                {
                    //error msg
                    alert("Please check your credentials");
                    
                }
            },
            error: function (data){
                alert(data.message);
            }
        });
    })

    
});

