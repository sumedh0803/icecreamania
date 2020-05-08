<?php 
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['userid']) && isset($_SESSION['usertype']))
{
  $username =  $_SESSION['username'];
  $userid = $_SESSION['userid'];
  $usertype = $_SESSION['usertype'];  
  ?>
  <script>
      usertype = "<?php echo $usertype ?>"
      username = "<?php echo $username ?>"
      userid = "<?php echo $userid ?>"
      canSeeMenu = "1";
  </script>
  <?php
}
else
{
  $username =  "Guest";
  $userid = "999";
  $usertype = "user";
?>
<script>
  alert("Please sign in first");
  canSeeMenu = "0"
  usertype = "user"
  username = "Guest"
  userid = "999"</script>;
<?php 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Spicy+Rice&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Gotu&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.pink-blue.min.css">
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/menu.css">
    <script src = "https://code.jquery.com/jquery-3.4.1.js"></script>
    <link rel="icon" href="./images/ice-cream-shop.png"/>
    <title>Ice Creamania! | Menu</title>
    <script src="./js/menu.js"></script>
</head>
<body>

<dialog id="customize" class = "gotu">
      <span class="material-icons close-icon" style="position: relative;float:right;z-index=10;" id="dialog-close">close</span>
      <div class = "" style = "width:60%;float:left;overflow:hidden">
        <div class = "prod-title gotu"></div>
        <div class = "prod-price gotu"></div>
        <div class = "prod-desc gotu"></div>
        <div class = "prod-extra"></div> 
      </div>
      <div class = "prod-image">
        <img width = 250>
        <div class="input-group">
            <input type="button" value="-" class="button-minus-cust" data-field="quantity" style = "width:33%">
            <input type="number" step="1" max="10" value="1" name="quantity" class="quantity-field-cust" style = "width:31%">
            <input type="button" value="+" class="button-plus-cust" data-field="quantity" style = "width:33%">
        </div>
        <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" style="width: 100%;" id = "addtocart" itemid = "">
          Add to cart
        </button>
      </div>
</dialog>
<dialog id="edit" class = "gotu">
  <div class = "title">Add Products:</div>
  <span class="material-icons close-icon" style="position: relative;top: 0;left: 67%;" id="edit-close">close</span>
  <form class="productsform" enctype="multipart/form-data" method = "post">
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 70%;">
          <input class="mdl-textfield__input" name = "itemname" type="text" id="itemname">
          <label class="mdl-textfield__label" for="itemname" style="font-size:13px;">Product Name</label>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 25%;margin-left: 5px;">
          <input class="mdl-textfield__input" name = "invqty" type="number" id="invqty">
          <label class="mdl-textfield__label" for="invqty" style="font-size:13px;">Quantity</label>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 70%;">
          <select class="mdl-textfield__input" id="category" name="category">
              <option></option>               
              <option value="Bucket (1 Quart)">Bucket (1 Quart)</option>
              <option value="Cakes">Cakes</option>
              <option value="Cappuccino Blast">Cappuccino Blast</option>
              <option value="Floats and Freezes">Floats and Freezes</option>
              <option value="Milk Shakes">Milk Shakes</option>
              <option value="Scoops">Scoops</option>
              <option value="Smoothies">Smoothies</option>
              <option value="Sundae">Sundae</option>
              <option value="Warm Desserts">Warm Desserts</option>
          </select>
          <label class="mdl-textfield__label" for="category" style="font-size:13px;">Category</label>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 25%; margin-left: 5px;">
          <input class="mdl-textfield__input" name = "rate" type="number" id="rate">
          <label class="mdl-textfield__label" for="rate" style="font-size:13px;">Rate</label>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 50%;">
          <textarea class="mdl-textfield__input" name = "description" type="text" rows= "3" id="description"></textarea>
          <label class="mdl-textfield__label" for="description" style="font-size:13px;">Product Description</label>
        </div>
        <div class="productimage">
            <img id="product-preview" src="./images/product-preview.png" alt="Product-Preview">
            <div class="centered">Preview</div>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--file--floating-label mdl-textfield--floating-label" style="width: 50%;">
          <input class="mdl-textfield__input" type="text" id="uploadFile" style="float:left;width:90%;"/>
          <label class="mdl-textfield__label" for="uploadfile" style="font-size:13px;">Product Image</label>
          <div class="mdl-button mdl-button--primary mdl-button--icon mdl-button--file" style="bottom:0%;float:right">
            <i class="material-icons">attach_file</i><input type="file" id="uploadBtn">
          </div>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 30%;">
          <input class="mdl-textfield__input" name = "itemid" type="text" id="itemid">
          <label class="mdl-textfield__label" for="itemid" style="font-size:13px;">Product ID</label>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield" style="width:10%;margin-left:30px;">
          <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect special" for="special">
              <input type="checkbox" id="special" name="special" class="mdl-checkbox__input" style="line-height:10px;">
              <span class="mdl-checkbox__label">Special</span>
          </label>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield" style="width:10%;margin-left:30px;">
          <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect delete" for="delete">
              <input type="checkbox" id="delete" name="delete" class="mdl-checkbox__input" style="line-height:10px;">
              <span class="mdl-checkbox__label">Delete</span>
          </label>
        </div>
        <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored updatebtn" style="width: 100%; margin-top: 20px;">
          UPDATE INVENTORY
        </button>
        <div id="p2" class="mdl-progress mdl-js-progress mdl-progress__indeterminate mdl-progress-accent progress-inventory" style="width: 100%;visibility: hidden;"></div>
      </form>        
</dialog>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <div class = "top-bar gotu" style="padding-bottom: 5px;">🎉Earn 1 point for $1 spent! Redeem 100 points to get 1 free Sundae!🎉<span class="material-icons" style="float: right;right: 10px;position: relative;top: -2px;" id = "top-bar-close">close</span>
    </div>
      <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
          <!-- Title -->
          <a href = "index.php" style = "color:white;"><span class="mdl-layout-title">Ice Creamania!</span></a>
          <!-- Add spacer, to align navigation to the right (add spacer if no search bar)
          <div class="mdl-layout-spacer"></div> -->
          <div class="mdh-expandable-search mdl-cell--hide-phone" style="margin-left:190px;">
            
            <form action="#" style = "margin-bottom: 0px;">
              <input type="text" placeholder="Search" size="1" id="search-bar">
            </form>
            <i class="material-icons search">search</i>
            <i class="material-icons clear">clear</i>
          </div>
          

          <ul class = "sugg-box">
           
          </ul>
          <!-- Navigation. We hide it in small screens. -->
          <nav class="mdl-navigation mdl-layout--large-screen-only">
              <button class="mdl-button mdl-js-button gotu top-bar-btn" id = "adminpanel">Adminpanel</button>
              <div class="userprofile">
                  <button class="mdl-button mdl-js-button gotu top-bar-btn" id = "profile" >Hello, <?php echo $username; ?></button>
                  <div class="signout gotu" style="display: none;">
                    <div class="myprofile"><a href="userprofile.php">My Profile</a></div>
                    <div class="sinout"><a href="signout.php">Sign Out</a></div>
                  </div> 
              </div>
              <span id="cart-wrapper">
                <span class="mdl-badge gotu top-bar-btn" style="font-size:14px;margin-left:15px;cursor:pointer" data-badge="0" id = "cart">CART</span>
              </span>

          </nav>
        </div>
      </header>
        
        <main class="mdl-layout__content">
          <div class="page-content"><!-- Your content goes here -->
            <div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer">
                <div class="mdl-layout__drawer  custom-side-bar">
                  <div class = "gotu" style = "padding: 20px 40px 5px 40px;margin: 0px;">Choose one or more categories</div>
                  <nav class="mdl-navigation category-list">
                    <a class="mdl-navigation__link" >Bucket (1 Quart)</a>
                    <a class="mdl-navigation__link" >Cakes</a>
                    <a class="mdl-navigation__link" >Cappuccino Blast</a>
                    <a class="mdl-navigation__link" >Floats and Freezes</a>
                    <a class="mdl-navigation__link" >Milk Shakes</a>
                    <a class="mdl-navigation__link" >Scoops</a>
                    <a class="mdl-navigation__link" >Smoothies</a>
                    <a class="mdl-navigation__link" >Sundae</a>
                    <a class="mdl-navigation__link" >Warm Desserts</a>
                  </nav>
                  <a class="mdl-navigation__link spl-select" style = "border-top:1.5px solid #aaa;cursor: pointer;">Ice-Creamania! Specials</a>
                </div>
                <main class="mdl-layout__content" style="margin-left: 20%;">
                    <div class="page-content" style="height: 100%; position: relative;">
                        <div class = "bg-gradient" style="padding:5%">
                            <div class="card main-card">
                                <div class = "pagination" style="margin: 10px 0px;"></div>
                                <div class="mdl-spinner mdl-spinner--single-color mdl-js-spinner is-active spinner" style = "display:block"></div>
                                <div class = "products" style="overflow: hidden;">
                                  
                                </div>

                                <!-- CONTENT LOADED BY JS -->
                            </div>
                        </div>
                    </div>
                </main>
              </div>

            </div>
           
        </main>
        
      </div>
      
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    
</body>
</html>