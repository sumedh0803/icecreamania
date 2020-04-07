$(document).ready(function(){
    $.ajax({
        url: "./includes/displayMenu.php",
        success: function(data){
            var product = JSON.parse(data);

            for(var i = 0; i < product.length;i++) {
                var itemid = product[i]['itemid'];
                var itemname = product[i]['itemname'];
                var category = product[i]['category'];
                var description = product[i]['description'];
                var rate = product[i]['rate'];
                var special = product[i]['special'];
                var imagepath = product[i]['imagepath'];
                
                if(special == "0")
                {

                    console.log(imagepath);
                    
                    var s = `
                    <div class = "product-container">
                        <div><span class="product-category" style="position: absolute;">`+category+`</span></div>
                        <div class = product-img>
                            <img src = "`+imagepath.substring(1)+`" width="225">
                        </div>
                        <div class = "product-title gotu" style="width: 225px;">`+itemname+`</div>
                        <div class = "product-price gotu" style="width: auto;">$ `+rate+`</div>
                        <div class = "product-desc" style="width: 225px;overflow: hidden; display:-webkit-box;-webkit-line-clamp: 3;-webkit-box-orient: vertical;">`+description+`</div>
                        <div><button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" style = "width:100%;margin-bottom: 10px;">
                            Customize and Add to cart
                        </button></div>
                        <div><button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" style = "width:100%;">
                            Edit item
                        </button></div>
                    </div>
                    `;
                    
                    var htmlObject = $(s); 
                    $(htmlObject).appendTo(".main-card");
                    //console.log(tag);
                }
                else
                {
                    var s = `
                    <div class = "product-container">
                        <div>
                            <span class="product-category" style="position: absolute;float:left">`+category+`</span>
                        </div>
                        <div class = product-img>
                            <img src = "`+imagepath.substring(1)+`" width="225px;">
                        </div>
                        <div class = "product-title gotu" style="width: 225px;">`+itemname+`</div>
                        <div class = "product-price gotu" style="width: auto;">$ `+rate+`<span class="material-icons favourite" >favorite</span></div>
                        <div class = "product-desc">`+description+`</div>
                        <div><button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" style = "width:100%;margin-bottom: 10px;">
                            Customize and Add to cart
                        </button></div>
                        <div><button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" style = "width:100%;">
                            Edit item
                        </button></div>
                    </div>
                    `;
                    var htmlObject = $(s); 
                    $(htmlObject).appendTo(".main-card");
                    //$(".main-card").appendT(htmlObject);
                }
                
              }
              //console.log(tag);
              //$(".main-card").html(tag);
            // for(product in jsonData)
            // {
                
                
            // }
            /**
             * <div class = "product-container">
                    <div class = product-img>
                        <span class="product-category" style="position: absolute;">Scoops</span><span class="material-icons favourite">favorite</span>
                        <img src = "./productImages/SC001.png" width="200px;">
                    </div>
                    <div class = "product-title gotu" style="width: 200px;">Strawberry Shortcake Sundae</div>
                    <div class = "product-price gotu" style="width: auto;">$ 5.99</div>
                    <div class = "product-desc" style="width: 200px;overflow: hidden; display:-webkit-box;-webkit-line-clamp: 3;-webkit-box-orient: vertical;">Ice Creamania's Strawberry Shortcake Sundae is a real treat. Fresh strawberries are put in the spotlight in this delectable sundae. We start with a fresh baked vanilla bundt cake made at our own Braum’s bakery, cover it in Strawberry Topping, add vanilla ice cream covered with Strawberry Topping, then we add whipped cream and crown with a cherry. Now that’s ‘strawberries’ and what makes this sundae so popular.</div>
                    <div><button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" style = "width:100%;margin-bottom: 10px;">
                        Customize and Add to cart
                    </button></div>
                    <div><button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" style = "width:100%;">
                        Edit item
                    </button></div>
                </div>
             * 
             */

        },
        error: function(data){
            console.log("Error: "+data);
        }
});
})