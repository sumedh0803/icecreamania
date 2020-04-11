$(document).ready(function(){
    if(usertype == "admin")
    {
        $("#adminpanel").on("click", function() {
            window.location.href = "adminpanel.php?userid="+userid+"&username="+username;
        });
    }
    else{
        $("#adminpanel").hide();
        $(".mdh-expandable-search").css("margin-left","50px");
    }
    

    customize = $("#customize");
    edit = $("#edit");
    $("#dialog-close").click(function (){
        customize.hide();
        $(".mdl-layout__container").removeClass("blur-filter");
    });
    $("#edit-close").click(function (){
        edit.hide();
        $(".mdl-layout__container").removeClass("blur-filter");
    });

    $(".favourite").on("mouseout",function(){
        $(".tooltip").css("display","none");
    });

    $('.button-plus-cust').on('click', function(e) {
        parent = $(this).parent();
        qtyField = $(this).siblings(".quantity-field-cust");
        currentVal = parseInt(qtyField.val()); 
        if(currentVal >= 1)
        {
            parent.find('.button-minus-cust').val("-").css('background-color','#e53935');
            parent.find('.button-minus-cust').val("-").css('cursor','pointer');
            parent.find('.button-minus-cust').removeAttr("disabled");
        }
        if(currentVal < 10) 
        {
            qtyField.val(currentVal + 1);
            parent.find(".button-plus-cust").val("+").css('color','#000000');
            parent.find(".button-plus-cust").val("+").css('cursor','pointer');
            if(currentVal + 1 == 10)
            {
                parent.find(".button-plus-cust").val("+").css('background-color','#aaa');
                parent.find(".button-plus-cust").val("+").css('cursor','not-allowed');
            }
        }      
    });
    $('.button-minus-cust').on('click', function(e) {
        parent = $(this).parent();
        qtyField = $(this).siblings(".quantity-field-cust");
        currentVal = parseInt(qtyField.val()); 
        if(currentVal <= 10)
        {
            parent.find(".button-plus-cust").val("+").css('background-color','#00c853');
            parent.find(".button-plus-cust").val("+").css('cursor','pointer');
        }
        if(currentVal > 1) 
        {
            qtyField.val(currentVal - 1);
            parent.find('.button-minus-cust').val("-").css('color','#000000');
            parent.find('.button-minus-cust').val("-").css('cursor','pointer');
            if(currentVal - 1 == 1)
            {
                parent.find('.button-minus-cust').val("-").css('background-color','#aaa');
                parent.find('.button-minus-cust').val("-").css('cursor','not-allowed');
            }
        } 
        
    });

    
    let searchParams = new URLSearchParams(window.location.search)
    if(searchParams.has('searchQuery'))
    {
        //alert(searchParams.get('searchQuery'));
        showProducts("s",null,null,searchParams.get('searchQuery'),null);
        $("#search-bar").val(searchParams.get('searchQuery'));
        $(".clear").css("visibility","visible");

    }
    else
    {
        showProducts("l",0,12,null,null);   
   
        $.ajax({
            url: "./includes/displayMenu.php?getCount=1&usertype="+usertype,
            success: function(data){
                //var pages = Math.ceil(parseInt(data) / 12);
                makePagination(parseInt(data));
            },
            error: function(data){
                console.log("Error: "+data);
            }
        });
    }

    $(".clear").on("click",function(){
        window.location = window.location.href.split("?")[0];
    });

    $('.search').click(function(event){
         searchQuery = $('#search-bar').val();
         window.location.href = "menu.php?searchQuery="+searchQuery;
        //alert("test");
        
    });
    
    categories = new Array();
    $(".category-list>a").on("click", function(e){
        e.preventDefault();
        $(".products").empty();
        $(this).toggleClass("category-selected");
        $(this).css("color","black");
        //alert($(this).text());
        if($.inArray($(this).text() , categories ) > -1)
        {
            //elem exists
            categories.splice($.inArray($(this).text() , categories ),1);
            if(categories.length == 0)
            {
                window.location = window.location.href.split("?")[0];
            }
        }
        else
        {
            categories.push($(this).text());
            $("#search-bar").val("");
        }
        console.log(categories);
        showProducts("c",null,null,null,categories);

    });
    $(".category-list>a").on("mousedown",function(){
        $(this).addClass("mdl-color--pink-700");
        $(this).css("color","white");
    });
    $(".category-list>a").on("mouseup",function(){
        $(this).removeClass("mdl-color--pink-700");
        $(this).css("color","");
    });
    $(".category-list>a").on("key", function(e){
        e.preventDefault();
        $(this).toggleClass("category-selected");
    });
   
    $(".spinner").css("display","block");
   
    

    $("#search-bar").on("keyup",function(){
        if($(this).val() == "")
            $(".clear").css("visibility","hidden");
        else
            $(".clear").css("visibility","visible");
        $(".sugg-box").show();
        var searchQuery = $(this).val();
        console.log(searchQuery);
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
    // $("#search-bar").on("blur",function(){
    //     $(".sugg-box").hide();
    // });
    $("#addtocart").on("click",function(){
        sibling = $(this).siblings(".input-group");
        qtyField = sibling.find(".quantity-field-cust");
        qty = parseInt(qtyField.val()); 
        extraStr = extraitems.join(",");
        var itemid = $(this).attr("itemid");
        $.ajax({
            url: "./includes/addToCart.php",
            data: { userid : userid,
                itemid : itemid,
                qty: qty,
                extras: extraStr
            },
            success: function(data){
                console.log(data);

            },
            error: function (error){
                console.log(error);
            }
        });
    });
});


function search(searchQuery)
{
    //alert("menu.html?searchQuery="+searchQuery);
    window.location.href = "menu.php?searchQuery="+searchQuery+"&usertype="+usertype;
}

function load(elem)
{
    $(".spinner").css("display","block");
    $(".products").empty();
    var pgNo = $(elem).attr("id");
    var end = pgNo * 12;
    var start = end - 12;
    console.log(start);
    console.log(end);
    showProducts("p",start,end,null,categories);
    $(".active").removeClass("active");
    $(elem).addClass("active");
}

function showProducts(caller,start,end,searchQuery,category)
{
    $.ajax({
        url: "./includes/displayMenu.php",
        data: { start: start == null? "" : start,
                end: end == null? "" : end,
                searchQuery: searchQuery == null? "" : searchQuery,
                category: category == null? "" : category.join(),
                usertype: usertype},
        success: function(data){
            $(".spinner").css("display","none");
            var product = JSON.parse(data);
            if(caller == "l" || caller == "c"   )
                makePagination(product.length);
            limit = (product.length < 12) ? product.length : 12;
            for(var i = 0; i < limit ; i++) {
                var itemid = product[i]['itemid'];
                var itemname = product[i]['itemname'];
                var category = product[i]['category'];
                var description = product[i]['description'];
                var rate = product[i]['rate'];
                var special = product[i]['special'];
                var imagepath = product[i]['imagepath'];
                var invqty = parseInt(product[i]['invqty']);
                limit = Math.min(limit,10);
                if(special == "0")
                {
                    var s = `
                    <div class = "product-container">
                    <div><span class="product-category" style="position: absolute;">`+category+`</span></div>
                    <div class = product-img>
                        <img src = "`+imagepath.substring(1)+`" width="225" height = "250">
                    </div>
                    <div class = "product-title gotu" style="width: 225px;">`+itemname+`</div>
                    <div class = "product-price gotu" style="width: auto;">$ `+rate+`</div>
                    <div class = "product-desc" style="width: 225px;overflow: hidden; display:-webkit-box;-webkit-line-clamp: 3;-webkit-box-orient: vertical;">`+description+`</div>`;
                    if(usertype == "admin")
                    {
                        s += `
                        <div><button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" style = "width:100%;margin-bottom: 10px;cursor:not-allowed;" disabled>
                            Customize & Add to cart
                            </button></div>
                            <div><button  class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored admin-edit" style = "width:100%;" id = `+itemid+`>
                                Edit item
                            </button></div>
                        </div>`;
                    }
                    else
                    {
                        s += `
                        <div class="input-group">
                            <input type="button" value="-" class="button-minus" data-field="quantity">
                            <input type="number" step="1" max="`+invqty+`" value="1" name="quantity" class="quantity-field">
                            <input type="button" value="+" class="button-plus" data-field="quantity">
                        </div>
                        <div><button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent addtocart" style = "width:100%;margin-bottom: 10px;" id = `+itemid+`>
                        Customize & Add to cart
                        </button></div>`;
                    }
                    var htmlObject = $(s); 
                    $(htmlObject).appendTo(".products");
                }
                else
                {
                    var s = `
                    <div class = "product-container">
                        <div>
                            <span class="product-category" style="position: absolute;float:left">`+category+`</span>
                        </div>
                        <div class = product-img>
                            <img src = "`+imagepath.substring(1)+`" width="225px" height = "250">
                        </div>
                        <div class = "product-title gotu" style="width: 225px;">`+itemname+`</div>
                        <div class = "product-price gotu" style="width: auto;">$ `+rate+`<span class = "tooltip favourite">Our Special</span><span class="material-icons favourite" >favorite</span></div>
                        <div class = "product-desc">`+description+`</div>`;
                        if(usertype == "admin")
                        {
                            s += `
                            <div><button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" style = "width:100%;margin-bottom: 10px;cursor:not-allowed;" disabled>
                            Customize & Add to cart
                            </button></div>
                            <div><button  class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored admin-edit" style = "width:100%;" id = `+itemid+`>
                                Edit item
                            </button></div>
                        </div>
                        `;
                        }
                        else
                        {
                            s += `
                            <div class="input-group">
                                <input type="button" value="-" class="button-minus" data-field="quantity" disabled>
                                <input type="number" step="1" max="10" value="1" name="quantity" class="quantity-field">
                                <input type="button" value="+" class="button-plus" data-field="quantity">
                            </div>
                            <div><button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent addtocart" style = "width:100%;margin-bottom: 10px;" id = `+itemid+`>
                            Customize & Add to cart
                            </button></div>`;
                        }
                    var htmlObject = $(s); 
                    $(htmlObject).appendTo(".products");
                    //$(".main-card").appendT(htmlObject);
                }
              }
              $('.input-group').on('click', '.button-plus', function(e) {
                incrementValue(e,invqty);
              });
              $('.input-group').on('click', '.button-minus', function(e) {
                decrementValue(e,invqty);
                });
            $(".addtocart").on("click", function(){
                qty = $(this).closest('div').siblings(".input-group").find(".quantity-field").val();
                var id = $(this).attr("id");
                addToCart(qty,id);
            })
            $(".admin-edit").on("click", function(e){
                var id = $(this).attr("id");
                editProduct(id);
            })
          
        },
        error: function(data){
            console.log("Error: "+data);
        }
        
});

}

function makePagination(itemCount)
{
    pages = Math.ceil(itemCount / 12);
    $(".pagination").empty();
    var ul = document.createElement("ul");
    
    for(var i = 0; i < pages; i++)
    {
        var li = document.createElement("li");
        $(li).attr("id",i+1);
        $(li).attr("class","page");
        $(li).attr("onclick","load(this)");
        $(li).text(i+1);
        ul.appendChild(li);
    }
    $(ul).attr("class","pagination-container");
    $(ul).appendTo(".pagination");
    $("li#1").addClass("active");
}

function incrementValue(e,invqty) 
{
    e.preventDefault();
    
     var fieldName = $(e.target).data('field');
    var parent = $(e.target).closest('div');
    var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val());
    if(currentVal >= 1)
    {
        parent.find('.button-minus').val("-").css('background-color','#e53935');
        parent.find('.button-minus').val("-").css('cursor','pointer');
        parent.find('.button-minus').removeAttr("disabled");
    }
    if(currentVal < invqty) 
    {
        parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
        parent.find(".button-plus").val("+").css('color','#000000');
        parent.find(".button-plus").val("+").css('cursor','pointer');
        if(currentVal + 1 == invqty)
        {
            parent.find(".button-plus").val("+").css('background-color','#aaa');
            parent.find(".button-plus").val("+").css('cursor','not-allowed');
        }
    }
  }
  
function decrementValue(e,invqty) {
    e.preventDefault();
    var fieldName = $(e.target).data('field');
    var parent = $(e.target).closest('div');
    var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);
  
    if(currentVal <= invqty)
    {
        parent.find(".button-plus").val("+").css('background-color','#00c853');
        parent.find(".button-plus").val("+").css('cursor','pointer');
    }
    if(currentVal > 1) 
    {
        parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
        parent.find('.button-minus').val("-").css('color','#000000');
        parent.find('.button-minus').val("-").css('cursor','pointer');
        if(currentVal - 1 == 1)
        {
            parent.find('.button-minus').val("-").css('background-color','#aaa');
            parent.find('.button-minus').val("-").css('cursor','not-allowed');
        }
    }
}

function addToCart(qty,id)
{
    // customize.find("#prodId").text(id);
    extraitems = new Array();
    $(".mdl-layout__container").addClass("blur-filter");
    $.ajax({
        url: "./includes/getProduct.php",
        data: { id : id},
        success: function(data){
            var product = JSON.parse(data);
            productData = product[0];
            extras = product[1];
            $(".quantity-field-cust").val(qty);
            if(qty > 1 && qty < 10)
            {
                $('.button-minus-cust').val("-").css('background-color','#e53935');
                $('.button-minus-cust').val("-").css('cursor','pointer');
                $('.button-minus-cust').removeAttr("disabled");

                $('.button-plus-cust').val("+").css('background-color','#00c853');
                $('.button-plus-cust').val("+").css('cursor','pointer');
                $('.button-plus-cust').removeAttr("disabled");
            }
            else if(qty == 10)
            {
                $('.button-plus-cust').val("+").css('background-color','#aaa');
                $('.button-plus-cust').val("+").css('cursor','not-allowed');
                $('.button-plus-cust').attr("disabled");

                $('.button-minus-cust').val("-").css('background-color','#e53935');
                $('.button-minus-cust').val("-").css('cursor','pointer');
                $('.button-minus-cust').removeAttr("disabled");
            }
            else if(qty == 1)
            {
                
                $('.button-minus-cust').val("-").css('background-color','#aaa');
                $('.button-minus-cust').val("-").css('cursor','not-allowed');

                $('.button-plus-cust').val("+").css('background-color','#00c853');
                $('.button-plus-cust').val("+").css('cursor','pointer');
                $('.button-plus-cust').removeAttr("disabled");
    
            }
            $("#addtocart").attr("itemid",id);
            $(".prod-title").text(productData['itemname']);
            $(".prod-price").text("$"+productData['rate']);
            $(".prod-desc").text(productData['description']);
            $(".prod-image>img").attr("src",productData['imagepath'].substring(1));
            $(".prod-extra").empty();
            if(extras.length > 0)
            {
                $(".prod-extra").append(`<div style = "border-top:1px solid #aaa;font-size:24px;line-height:30px;">Make your dessert even more tastier with our unique toppings!</div>`);
                for(i = 0; i<extras.length;i++)
                {
                    var label = document.createElement('label');
                    label.className = 'mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect';
                    label.for = extras[i]['eid'];
                    label.style.marginTop = "10px"
                    label.style.marginBottom = "10px"
                    label.style.paddingRight = "15px"
                    label.style.fontSize = "26px";

                    var input = document.createElement('input');
                    input.type = "checkbox";
                    input.id = extras[i]['eid'];
                    input.className = 'mdl-checkbox__input extras';
                    
                    var div = document.createElement('div');
                    div.className = 'mdl-checkbox__label';
                    div.innerHTML = extras[i]['ename'];
                    
                    var span = document.createElement('span');
                    span.style.float = "right";
                    span.innerHTML = "$"+extras[i]['rate'];

                    div.appendChild(span);

                    label.appendChild(input)
                    label.appendChild(div);

                    $(".prod-extra").append(label);
                    componentHandler.upgradeElement(label);              
                }
            }
            else
            {
                $(".prod-extra").append(`<div class = "" style = "border-top:1px solid #aaa;font-size:24px;padding:1%;line-height: 30px;">This dessert doesn't need any toppings! It's already awesome!</div>`);
            }

            $(".extras").on("click",function(){
                eid = $(this).attr("id");
                if(extraitems.includes(eid))
                {
                    extraitems.splice(extraitems.indexOf(eid),1);
                }
                else
                {
                    extraitems.push(eid);
                }
                
            });

            customize.fadeIn(100);
            
        },
        error: function (error){
            console.log(error);
        }
    });
}


// Admin part-----------------------------------------------------------------------------


function editProduct(id)
{
    $(".updatebtn").on("click", function(e){
        updateInventory(e);
        e.stopPropogation();
    }); 
    $(".productsform").children().addClass("is-dirty");
    edit.fadeIn(100);
    $(".mdl-layout__container").addClass("blur-filter");
    $.ajax({
        url: "./includes/editProduct.php",
        data: { id: id},
        success: function(data){
            var edit = JSON.parse(data);
            var itemname = edit[0]['itemname'];
            var invqty = edit[0]['invqty'];
            var category = edit[0]['category'];
            var rate = edit[0]['rate'];
            var description = edit[0]['description'];
            var file = edit[0]['imagepath'];
            var special = edit[0]['special'];
            deleteitem = edit[0]['deleteitem'];
            
            $("#special").change(function(){
                if ($(this).is(':checked')) {
                    special = 1;
                }
                else {
                    special = 0;
                }
            });

           
            $("#delete").change(function(){
                if ($(this).is(':checked')) {
                    deleteitem = 1;
                }
                else {
                    deleteitem = 0;
                }
            });

            if(special == 1)
            {
                document.querySelector('.special').MaterialCheckbox.check();
            }
            else
            {
                document.querySelector('.special').MaterialCheckbox.uncheck();
            }
            if(deleteitem == 1)
            {
                document.querySelector('.delete').MaterialCheckbox.check();
            }
            else
            {
                document.querySelector('.delete').MaterialCheckbox.uncheck();
            }
            $("#itemname").val(itemname);
            $("#invqty").val(invqty);
            $("#category").val(category);
            $("#rate").val(rate);
            $("#description").val(description);
            $("#itemid").val(id).prop("disabled", true);
            $("#uploadFile").val(itemname+".png");
            //alert($("#uploadFile").val());
            //$("#product-preview").remove();
            $(".centered").remove();
            $("#product-preview").attr("src",file.substring(1));
            $("#product-preview").css("filter","none");
            $("[for=uploadfile]").text(" ");

            document.getElementById("uploadBtn").onchange = function () {
                 document.getElementById("uploadFile").value = this.files[0].name;
                 //$("#product-preview").remove();
                 $(".centered").remove();
                 //$(".productimage").appendChild('<img id="product-image" src="#" alt="Product-Image">');
                 $("[for=uploadfile]").text(" ");
             };

             // To display the updated product image
            function readURL(input) {
                
                if(input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                    $('#product-preview').attr('src', e.target.result);
                    }     
                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }

            $("#uploadBtn").change(function() {
                readURL(this);
            });

            spl = 0;

            $("#special").change(function(){
                if ($(this).is(':checked')) {
                        spl = 1;
                }
                else {
                        spl = 0;
                }
            });
            $(".updatebtn").on("click", function(e){
                updateInventory(e);
            })

        },
        error: function (error){
            console.log(error);
        }
    });
}


 // Ajax call for updating the exsisting products
 function updateInventory(e)
 {
    $(".progress-inventory").css("visibility","visible");
    e.preventDefault();
    var file_data = $('#uploadBtn').prop('files')[0];
    var formData = new FormData();
    formData.append('file', file_data);
    formData.append('itemname', $("#itemname").val());
    formData.append('category', $("#category").val());
    formData.append('description', $("#description").val());
    formData.append('invqty', $("#invqty").val());
    formData.append('rate', $("#rate").val());
    formData.append('itemid', $("#itemid").val());
    formData.append('special', special);
    formData.append('delete', deleteitem);    
    $.ajax({
        type:"POST",
        url:"includes/updateProduct.php",
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        success: function(data){
            alert(data);
            if(data == "1")
            {
                $(".updatebtn").html("Product successfully updated to inventory");
                 setTimeout(function(){
                    //fade back
                    $(".updatebtn").html("UPDATE INVENTORY");
                    $(".progress-inventory").css("visibility","hidden");
                    $(".productsform").trigger('reset');
                    $("[for=uploadfile]").text("Product Image");
                    $(".productsform").children().removeClass("is-dirty");
                    $("#product-preview").attr("src","./images/product-preview.png");
                    $("#product-preview").css("filter","blur(2px)");
                    $(".product-preview").prepend('<div class="centered">Preview</div>');
                    document.querySelector('.special').MaterialCheckbox.uncheck();
                    document.querySelector('.delete').MaterialCheckbox.uncheck();
                    special = 0;
                    deleteitem = 0;
                }, 2000);
                location.reload();
            }
            else
            {
                console.log(data);
            }
        },
        error: function (data){
            alert(data.message);
        }
    });
}