$(document).ready(function() {
    
    getCartCount();   
    
    //Check if admin is logged in. If yes, then show the "ADMINPANEL" button on nav bar
    if(usertype == "admin")
    {
        $("#adminpanel").on("click", function() {
            window.location.href = "adminpanel.php?userid="+userid+"&username="+username;
        });
        $("#cart").hide();
    }
    else
    {
        $("#adminpanel").hide();
        $(".mdh-expandable-search").css("margin-left","50px");
        $(".top-bar").slideDown("500");
        $("#top-bar-close").on("click",function(){
            $(".top-bar").slideUp("500")
        })
        .on("mouseover",function(){
            $(this).css("cursor", "pointer")
            .css("background","rgba(206, 206, 206, 0.22)")
            .css("border-radius", "5px");

        })
        .on("mouseout",function(){
            $(this).css("background","none");
        });
    }
    //========================================================================//

    if (username != "Guest")
    {
        if(usertype == "user")
        {
        
            $("#profile").on("click", function() {
                $(".signout").toggle();
            });

        }
        else if(usertype == "admin")
        {
            $("#profile").on("click", function() {
                $(".signout").toggle()
                $(".myprofile").hide();
            });
        }

    }

    //====Functions related to search bar===//
    //This ajax call populates the suggestion box with names containing the searchQuery
    $("#search-bar").on("keyup",function(){
        if($(this).val() == "")
            $(".clear").css("visibility","hidden");
        else
            $(".clear").css("visibility","visible");
        $(".sugg-box").show();
        var searchQuery = $(this).val();
        $.ajax({
            url: "./includes/searchResults.php",
            data: { searchQuery: searchQuery,
                    usertype: usertype},
            success: function(data){
                items = data.split(",")
                $(".sugg-box").empty();
                for(i = 0; i < items.length; i++)
                {
                    var li = document.createElement("li");
                    $(li).attr("id",i+1);
                    $(li).attr("class","search-item");
                    $(li).attr("onclick","search('"+items[i]+"')");
                    $(li).text(items[i]);
                    $(".sugg-box").append(li);
                }
            }
        });
    });
    $(".clear").on("click",function(){
        window.location = window.location.href;
    });

    $('.search').click(function(event){
        searchQuery = $('#search-bar').val();
        search(searchQuery)
        
    });
    //========================================================================//


    $.ajax({
        url: "./includes/manageCart.php",
        data: { 
        },
        success: function(data){
            loadCart(data);
        }
    });

    $("#dialog-close").click(function (){
        $("#customize").hide();
        $(".mdl-layout__content").removeClass("blur-filter");
    });

    $("#placeOrder").click(function(){
        addr = $('input[name=addr]:checked', '#myForm').val(); 
        $.ajax({
            url: "./includes/manageCart.php",
            data: { 
                action: "placeOrder",
                uaid: addr
            },
            success: function(data){
                
                $("#customize").hide();
                $(".mdl-layout__content").removeClass("blur-filter");
                window.location.href = "./includes/orderDetails.php?orderId="+data;
            }
        });
    });
});

function loadCart(data){
    console.log(data);
    var products = JSON.parse(data);
    if(products!=null && products!=undefined && products.length > 0){
        var s = `
        <div class="pb-5 bg" style = "overflow: auto;padding: 5% 0 5% 0;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 main-card" style = "padding: 3rem 3rem 1rem 3rem;">
                        <div class="table-responsive" id="cartContent">
                            <table class="table">
                            <thead>
                                <tr>
                                <th scope="col" class="border-0 bg-light gotu" style="text-align:center;" >
                                    <div class="p-2 px-3 text-uppercase">Product</div>
                                </th>
                                <th scope="col" class="border-0 bg-light gotu" style="text-align:center;">
                                    <div class="py-2 text-uppercase">Price</div>
                                </th>
                                <th scope="col" class="border-0 bg-light gotu" style="text-align:center;">
                                    <div class="py-2 text-uppercase">Quantity</div>
                                </th>
                                <th scope="col" class="border-0 bg-light gotu" style="text-align:center;">
                                    <div class="py-2 text-uppercase">Subtotal</div>
                                </th>
                                <th scope="col" class="border-0 bg-light gotu">
                                    <div class="py-2 text-uppercase"></div>
                                </th>
                                </tr>
                            </thead>
                            <tbody>`;
                            var disableCoupon = false;
                            var totalPrice = 0;
                            var totalQuantity = 0;
                            var couponApplied = products[0]['couponApplied'];
                            var couponCode = products[0]['couponCode'];
                            var couponMessage = products[0]['couponMessage'];
                            if(couponApplied){
                                
                                if(couponMessage === "" || couponMessage === "expired" || couponMessage === "invalid" ||  couponMessage.includes("above")  ){
                                    disableCoupon = false;
                                }
                                else{
                                    disableCoupon = true;
                                }
                            }
                            for(var i = 0; i < products.length ; i++){
                                
                                totalQuantity +=parseInt(products[i]['quantity']);
                                extrasTotal = 0;
                                extrasItem = "";
                                if(products[i]['cartItemExtras']!=null && products[i]['cartItemExtras']!=undefined && products[i]['cartItemExtras'].length > 0){
                                    
                                    var extras = products[i]['cartItemExtras'];
                                    
                                    
                                    for(var j = 0 ; j < extras.length; j++){
                                        
                                        extrasTotal += parseFloat(extras[j]['rate']) * parseInt(extras[j]['qty']);
                                        extrasItem += extras[j]['ename'] + ", "
                                        console.log(extras[j]['ename'] + ": "+extrasTotal)
                                    }
                                    extrasItem = extrasItem.substring(0, extrasItem.length - 2);
                                }
                                totalPrice += (parseFloat(products[i]['rate'])+ parseFloat(extrasTotal)) * parseInt(products[i]['quantity']);


                                s += `<tr class = "">
                                    <th scope="row" class="border-0 gotu">
                                        <div class="p-2">
                                            <img src="`+products[i]['imagepath'].substring(1)+`" alt="" width="70" class="img-fluid rounded shadow-sm">
                                            <div class="ml-3 d-inline-block align-middle">
                                                <div class="text-dark align-middle">`+products[i]['itemname']+`</div>
                                                <div class=" align-middle" style = "font-size:14px;color:#aaa;">With: `+extrasItem+`</div>
                                                <span class="text-muted font-weight-normal font-italic d-block"></span>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="border-0 align-middle gotu" style="text-align:center;">
                                        <div class="text-dark align-middle">$`+products[i]['rate']+`</div>
                                        <div class=" align-middle" style = "font-size:14px;color:#aaa;">$`+parseFloat(extrasTotal).toFixed(2)+`</div>
                                    </th>
                                    <td class="border-0 align-middle gotu" style="text-align:center;"><strong>
                                    <div class="input-group gotu" style="text-align:center;">
                                        <input type="button" value="-" class="button-minus" data-field="quantity" onclick="subtractItem('`+products[i]["productId"]+`');">
                                        <input type="number" step="1" readonly="readonly" max="`+products[i]['invqty']+`" value="`+products[i]['quantity']+`" name="quantity" class="quantity-field">
                                        <input type="button" value="+" class="button-plus" data-field="quantity" onclick="addItem('`+products[i]["productId"]+`');">
                                    </div></strong></td>
                                    <td class="border-0 align-middle gotu" style="text-align:center;"><strong>$`+((parseFloat(products[i]['rate']) +  parseFloat(extrasTotal)) * parseInt(products[i]['quantity'])).toFixed(2)+`</strong></td>
                                    <td class="border-0 align-middle gotu" style="text-align:center;">
                                        <button class="btn btn-danger" onclick="removeItem('`+products[i]["productId"]+`');" ><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>`;
                                
                            }
                            s += `</tbody>
                            <tfoot>
                                <tr>
                                    <td><button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" onclick = "window.location.href='menu.php'" style = "margin-top:20px;"><i class="fa fa-angle-left"></i> Continue shopping</button></td>
                                    <td colspan="4" class="hidden-xs"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="row py-5 p-4 main-card" style = "margin-top: 5%;">
                    <div class="col-lg-6">
                        <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold gotu" style="font-size:24px;">Coupon code</div>
                        <div class="p-4">
                            <p class="mb-4" style="font-size:16px;">If you have a coupon code, please enter it in the box below</p>
                            <div class="input-group mb-4 border p-2">`;
                            if(disableCoupon){
                                s+=`<input type="text" placeholder="Apply coupon" id="couponCode" disabled aria-describedby="button-addon3" class="form-control"  value="`+couponCode+`" style="border: 1.5px solid #b3d4fc">`;
                            }
                            else{
                                s+=`<input type="text" placeholder="Apply coupon" onkeydown="hideMsg();" id="couponCode" aria-describedby="button-addon3" class="form-control"  value="`+couponCode+`" style="border: 1.5px solid #b3d4fc">`;
                            }
                            s+=`<div class="input-group-append border-0">`;
                            if(couponMessage != ""){
                                s+=`<button id="button-addon3" type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" id="coupon" onclick="removeCoupon();"><i class="fa fa-trash mr-2"></i>Remove coupon</button>`;
                            }
                            else{
                                s+=`<button id="button-addon3" type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" id="coupon" onclick="applyCoupon();"><i class="fa fa-gift mr-2"></i>Apply coupon</button>`;
                            }
                            if(couponApplied){
                                if(disableCoupon){
                                    s += `<span class = "gotu" style="color:#00c853;font-weight:bolder;padding:10px" id="msg">Coupon successfully applied!</span>`;
                                }
                                else{
                                    if(couponMessage != ""){
                                        s += `<span class = "gotu" style="color:rgb(229, 57, 53);font-weight:bolder;padding:10px" id="msg">Coupon is  `+couponMessage+`</span>`;
                                    }
                                }
                            }
                            s+=`</div>
                        </div>
                    </div>
                    <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold gotu" style="font-size:24px;">Instructions for seller</div>
                    <div class="p-4">
                        <p class="mb-4" style="font-size:16px;">If you have some information for the seller you can leave them in the box below</p>
                        <textarea name="" cols="30" rows="2" class="form-control"></textarea>
                    </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold gotu" style="font-size:24px;">Order summary </div>
                    <div class="p-4">
                        <p class="mb-4" style="font-size:16px;">Shipping and additional costs are calculated based on values you have entered.</p>
                        <ul class="list-unstyled mb-4">
                        <li class="d-flex justify-content-between py-3 border-bottom" style="font-size:18px;"><strong class="text-muted">Order Subtotal </strong><strong>$`+totalPrice.toFixed(2)+`</strong></li>
                        <li class="d-flex justify-content-between py-3 border-bottom" style="font-size:18px;"><strong class="text-muted">Tax</strong><strong>$`+(totalPrice*0.1).toFixed(2)+`</strong></li>
                        <li class="d-flex justify-content-between py-3 border-bottom" style="font-size:18px;"><strong class="text-muted">Service Charges</strong><strong>$2.5</strong></li>`
                        totalPrice = totalPrice + totalPrice * 0.1 + 2.5;                       
                         if(disableCoupon){
                            s+=`<li class="d-flex justify-content-between py-3 border-bottom" style="font-size:18px;"><strong class="text-muted">Coupon Discount</strong><strong style="font-size:18px;">-$`+(totalPrice * parseInt(couponMessage) / 100).toFixed(2)+`</strong></li>`;
                        }                        
                        s+= `<li class="d-flex justify-content-between py-3 border-bottom"><strong class="gotu" style="font-size: 24px; margin-top:20px;">Total</strong>
                            <h5 class="font-weight-bold gotu" style="font-size:24px;">$`;
                        if(disableCoupon){
                            s+= (totalPrice - totalPrice * couponMessage / 100).toFixed(2);
                        }
                        else{
                            s+= totalPrice.toFixed(2);
                        }
                        s+=`</h5>
                        </li>
                        </ul><button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" onclick="checkout();" style="width:100%;">Proceed to checkout</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>`;
        $("#results").html(s);
    }
    else{
        var s = `
        <div class="pb-5 bg" style = "overflow: hidden;padding: 2% ;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 p-5 main-card">
                        <div class="table-responsive" id="cartContent">
                            <script>
                                imageSources = ["Ice Cream Icons-01.png", "Ice Cream Icons-02.png",
                                "Ice Cream Icons-03.png","Ice Cream Icons-04.png","Ice Cream Icons-05.png",
                                "Ice Cream Icons-06.png","Ice Cream Icons-07.png","Ice Cream Icons-08.png",
                                "Ice Cream Icons-09.png","Ice Cream Icons-10.png"]
                                index = 0
                                timeout = setInterval(function(){ 
                                    if(index == imageSources.length)
                                        index = 0;
                                        $('#images').attr('src', './images/'+imageSources[index]);
                                        index++;
                                    },
                                    1500);
                            </script>
                            <div class="mdl-grid">
                                <div class="mdl-layout-spacer"></div>
                                <div class="mdl-cell mdl-cell--4-col">
                                    <div class="img-switcher-cart ">
                                        <img src="./images/Ice Cream Icons-01.png" alt="ice creams" width="100%;" id="images"><br/>
                                        <div class ="product-title gotu" style="width:100%">Your Cart Is Currently Empty!</div>
                                        
                                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" onclick = "window.location.href='menu.php'" style = "margin-top:20px;">Return to Shop</button>
                                    </div>
                                </div>
                                <div class="mdl-layout-spacer"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
        $("#results").html(s);
    }
}

function removeItem(itemId){
    $.ajax({
        url: "./includes/manageCart.php",
        data: { 
            action: "remove",
            productId: itemId
        },
        success: function(data){
            loadCart(data);
        }
    });
    getCartCount();
}

function addItem(itemId){
    $.ajax({
        url: "./includes/manageCart.php",
        data: { 
            action: "add",
            productId: itemId
        },
        success: function(data){
            loadCart(data);
            getCartCount();
        }
    });
   
}

function subtractItem(itemId){
    $.ajax({
        url: "./includes/manageCart.php",
        data: { 
            action: "subtract",
            productId: itemId
        },
        success: function(data){
            loadCart(data);
            getCartCount();
        }
    });
    
}

function checkout(){
    $.ajax({
        url: "./includes/manageCart.php",
        data: { 
            action: "checkout"
        },
        success: function(data){
            if(data == 1){
                alert("Please sign in first");
            }
            else{
                if(data!=null && data!=undefined){
                    var addresses = JSON.parse(data);
                    if(addresses!=null && addresses.length > 0){
                        var s = ``;
                        for(var i = 0 ; i < addresses.length ; i++){
                            s+=`<form id="myForm"><label class="mdl-radio mdl-js-radio mdl-js-ripple-effect radio-block">`;
                            if(i == 0){
                                s+=`<input type="radio" class="mdl-radio__button" name="addr" checked value="`+addresses[i]['uaid']+`"></input>`;
                            }
                            else{
                                s+=`<input type="radio" class="mdl-radio__button" name="addr" value="`+addresses[i]['uaid']+`"></input>`;
                            }
                                    
                                s+= `<span class="mdl-radio__label">
                                        `+addresses[i]['addr1']+`, 
                                        `+addresses[i]['addr2']+`,
                                        `+addresses[i]['city']+`, 
                                        `+addresses[i]['zip']+`
                                </span>
                            </label></br>`;
                        }
                        s+= `</form>`;
                        $(".prod-desc").html(s);
                    }
                    else{

                    }
                }
                $("#customize").fadeIn();
                $(".mdl-layout__content").addClass("blur-filter");
            }
        }
    });
}

function applyCoupon(){
    var coupon = $("#couponCode").val().toUpperCase();
    if(coupon!=null && coupon!=undefined && coupon!=""){
        $.ajax({
            url: "./includes/manageCart.php",
            data: { 
                action: "applyCoupon",
                coupon: coupon
            },
            success: function(data){
                loadCart(data);
                $("#msg").show();
            }
        });
    }
}

function removeCoupon(){
    $.ajax({
        url: "./includes/manageCart.php",
        data: { 
            action: "removeCoupon"
        },
        success: function(data){
            loadCart(data);
            $("#couponCode").val("");
        }
    });
}

function getCartCount()
    {
        $.ajax({
            url: "./includes/getCartCount.php",
            data: { 
            },
            success: function(data){
                console.log(data)
                $("#cart").attr("data-badge",data);
            }
        });
}

//The function takes searchQueries and passes it to showProducts to display only specific products
function search(searchQuery)
{
    window.location = "menu.php?searchQuery="+searchQuery;
    //showProducts("s",null,null,searchQuery,categories);
}