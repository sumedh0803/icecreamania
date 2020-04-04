$(document).ready(function(){
    $(".nav").on("click",function(e)
    {  
        var redir = $(this).attr("redir");
        $(".container").load(redir);
    });

    

    $("#signout").on("click",function(){
        $.ajax({
            type:"POST",
            url:"includes/signout.php",
            success: function (data){
                console.log(data);
                window.location.replace("index.html");
            },
            error: function (data){
                alert(data.message);
            }
        });
    })

    document.getElementById("uploadBtn").onchange = function () {
        document.getElementById("uploadFile").value = this.files[0].name;
        $("[for=uploadfile]").text(" ");
    };

    // Ajax call for adding new products
    $(".productbtn").on("click",function(e){
        e.preventDefault();
        var file_data = $('#uploadBtn').prop('files')[0];
        var formData = new FormData();
        formData.append('file', file_data);
        formData.append('itemname', $("#itemname").val());
        formData.append('category', $("#category").val());
        formData.append('description', $("#description").val());
        formData.append('invqty', $("#invqty").val());
        formData.append('rate', $("#rate").val());
        $.ajax({
            type:"POST",
            url:"includes/addProduct.php",
            cache: false,
        contentType: false,
        processData: false,
            data: formData,
            success: function(data){
                if(data == "1")
                {
                    $(".productbtn").html("Product successfully added to inventory");
                    setTimeout(function(){
                        //fade back
                        $(".productbtn").html("Add to inventory");
                        //$(e).html(text);
                        $(".productsform").trigger('reset');
                        $("[for=uploadfile]").text("Product Image");
                        $(".productsform").children().removeClass("is-dirty");
                    }, 1000);
                }
                else
                {
                    console.log(data)
                }
            },
            error: function (data){
                alert(data.message);
            }
        });
    });



    // Ajax call for adding coupons
    $(".couponbtn").on("click",function(e){
        e.preventDefault();
        $.ajax({
            type:"POST",
            url:"includes/addCoupon.php",
            data: { cname: $("#cname").val(),
                    amtoff: $("#amtoff").val(),
                    dateadded: $("#dateadded").val(),
                    duedate: $("#duedate").val(),
                    lmt: $("#lmt").val()},
            success: function(data){
                if(data == "1")
                {
                    $(".couponbtn").html("Coupon added successfully");
                    setTimeout(function(){
                        //fade back
                        $(".couponbtn").html("Add Coupon");
                        $(".productsform1").trigger('reset');
                        $(".mdl-textfield").removeClass("is-dirty"); 
                    }, 1000);
                }
            },
            error: function (data){
                alert(data.message);
            }
        });
    });







});