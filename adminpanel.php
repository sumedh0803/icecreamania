<?php 

session_start();
$_SESSION["usertype"] = "admin";
$_SESSION["userid"] = $_REQUEST['userid'];
$_SESSION["username"] = $_REQUEST['username'];

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
    <link rel="stylesheet" href="./css/adminpanel.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="./js/adminpanel.js"></script>
    
    <link rel="icon" href="./images/ice-cream-shop.png"/>
    <title>Ice Creamania! | Admin Panel</title>
</head>
<body>

    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
          <!-- Title -->
          <a class="mdl-layout-title" href = "index.php">Ice Creamania!</a>
          
          <!-- Add spacer, to align navigation to the right -->
          <div class="mdl-layout-spacer"></div>
          <!-- Navigation. We hide it in small screens. -->
          <nav class="mdl-navigation mdl-layout--large-screen-only">
              <a class="mdl-button mdl-js-button gotu top-bar-btn" id = "signout" href = "signout.php">Sign Out</a>
          </nav>
        </div>
      </header>
        
      <main class="mdl-layout__content">
        <div class="main1 bg">
          <div class = "admintitle gotu">
            <div class = "adminname">Welcome, Admin - <?php echo $_SESSION["username"];?></div> <span class = "adminid">Admin ID: #<?php echo $_SESSION["userid"]; ?></span> 
            </div>
            
            <div class="main1-left">
                    <div id="dialog" class = "gotu">
                          <div class = "title">Add Products:</div>
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
                                    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="special">
                                        <input type="checkbox" id="special" name="special" class="mdl-checkbox__input" style="line-height:10px;">
                                        <span class="mdl-checkbox__label">Special</span>
                                    </label>
                                  </div>
                                  <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored productbtn" style="width: 100%; margin-top: 10px;">
                                    ADD TO INVENTORY
                                  </button>
                                  <div id="p2" class="mdl-progress mdl-js-progress mdl-progress__indeterminate mdl-progress-accent progress-inventory" style="width: 100%;visibility: hidden;"></div>
                                </form>        
                </div>
            </div>
                

            <div class="main1-right">
              <div id="dialog" class = "gotu">
                <div class = "title">Add Coupons:</div>
                  <form class="productsform1" method="POST">
                      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 70%;">
                          <input class="mdl-textfield__input" name = "cname" type="text" id="cname">
                          <label class="mdl-textfield__label" for="cname" style="font-size:13px;">Coupon Name</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 25%;margin-left: 5px;">
                          <input class="mdl-textfield__input" name = "amtoff" type="number" id="amtoff">
                          <label class="mdl-textfield__label" for="amtoff" style="font-size:13px;">Amount Off</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 48%; margin-left: 5px;">
                          <input class="mdl-textfield__input date" name = "dateadded" type="date" id="dateadded">
                          <label class="mdl-textfield__label" for="dateadded" style="font-size:13px;">Date Added</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 48%; margin-left: 5px;">
                          <input class="mdl-textfield__input date" name = "duedate" type="date" id="duedate">
                          <label class="mdl-textfield__label" for="duedate" style="font-size:13px;">Due Date</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 25%;margin-left: 5px;">
                          <input class="mdl-textfield__input" name = "lmt" type="number" id="lmt">
                          <label class="mdl-textfield__label" for="lmt" style="font-size:13px;">Limit</label>
                        </div>
                        
                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored couponbtn" style="width: 100%; margin-top: 10px;">
                          ADD COUPON
                        </button>
                        <div id="p2" class="mdl-progress mdl-js-progress mdl-progress__indeterminate mdl-progress-accent progress-coupon" style="width: 100%;visibility: hidden;"></div>
                      </form>


                
              </div>


              <div id="dialog" class = "gotu">
                <div class = "title">Add Extras:</div>
                  <form class="productsform2" method="POST">
                      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 30%;">
                          <input class="mdl-textfield__input" name = "eid" type="text" id="eid">
                          <label class="mdl-textfield__label" for="eid" style="font-size:13px;">Extra ID</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 68%;margin-left: 5px;">
                          <input class="mdl-textfield__input" name = "ename" type="text" id="ename">
                          <label class="mdl-textfield__label" for="ename" style="font-size:13px;">Extra Name</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 70%;">
                                    <select class="mdl-textfield__input" id="category1" name="category1">
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
                                    <label class="mdl-textfield__label" for="category1" style="font-size:13px;">Category</label>
                                  </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 25%;margin-left: 5px;">
                          <input class="mdl-textfield__input" name = "rate1" type="number" id="rate1">
                          <label class="mdl-textfield__label" for="rate1" style="font-size:13px;">Rate</label>
                        </div>
                        
                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored extrabtn" style="width: 100%; margin-top: 10px;">
                          ADD EXTRA
                        </button>
                        <div id="p2" class="mdl-progress mdl-js-progress mdl-progress__indeterminate mdl-progress-accent progress-extra" style="width: 100%;visibility: hidden;"></div>
                      </form> 
              </div>
           </div>
          </div>

          
        </div>
  
      </main>
      </div>
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</body>
</html>