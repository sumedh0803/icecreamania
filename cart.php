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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Spicy+Rice&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Gotu&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.pink-blue.min.css">
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/cart.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <!-- <script src="./js/menu.js"></script> -->
    <script src ="./js/manageCart.js"></script>
    <link rel="icon" href="./images/ice-cream-shop.png"/>
    <title>Ice Creamania! | My Cart</title>
</head>
<body>
<dialog id="customize" class = "gotu">
    <span class="material-icons close-icon" style="position: relative;float:right;z-index=10;" id="dialog-close">close</span>
    <div style = "float:left">
        <div class = "prod-title gotu">Please select an address</div>
        <div class = "prod-desc gotu"></div>
    </div>
    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" style="width: 50%;margin-left: 25%;" id = "placeOrder">
          Place order
        </button>
</dialog>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header">
    <div class="mdl-layout__header-row">
        <!-- Title -->
        <a href = "index.php" style = "color:white;text-decoration:none;"><span class="mdl-layout-title">Ice Creamania!</span></a>
        <!-- Add spacer, to align navigation to the right (add spacer if no search bar)
        <div class="mdl-layout-spacer"></div> -->
        <div class="mdh-expandable-search mdl-cell--hide-phone">
        
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
            <button class="mdl-button mdl-js-button gotu top-bar-btn" id = "menu" onclick= "window.location.href = 'menu.php';">Menu</button>
            <span class="mdl-badge gotu top-bar-btn" style="font-size:14px;margin-left:15px;cursor:pointer" data-badge="0" id = "cart">CART</span>
        </nav>
    </div>
    </header>
    <main class="mdl-layout__content">
        <div class="page-content">
            <div id="results">
                <!--results will be populated using ajax call-->
            </div>
        </div>
    </main>
    </div>
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</body>
</html>
