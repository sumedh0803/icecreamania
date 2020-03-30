$(document).ready(function(){
    $(".nav").on("click",function(e)
    {  
        var redir = $(this).attr("redir");
        $(".container").load(redir);
    }) 

    // Ajax call for adding new products
    $(".productbtn").on("click",function(e){
        e.preventDefault();
        $.ajax({
            type:"POST",
            url:"includes/addProduct.php",
            data: { itemname: $("#itemname").val(),
                    category: $("#category").val(),
                    description: $("#description").val(),
                    invqty: $("#invqty").val(),
                    rate: $("#rate").val()},
            success: function(data){
                if(data == "1")
                {

                    $(".productbtn").html("Product successfully added to inventory");
                    setTimeout(function(){
                        //fade back
                        $(".productbtn").html("Add to inventory");
                        //$(e).html(text);
                        $(".productsform").trigger('reset');
                    }, 1000);
                }
            },
            error: function (data){
                alert(data.message);
            }
        });
    })

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
    })





});