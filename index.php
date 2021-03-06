<?php 
session_start();
if(isset($_SESSION['username']))
{
  $username = $_SESSION['username'];
  $usertype = $_SESSION['usertype'];
}
else
{
  $username = "Guest";
  $usertype = "Guest";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.pink-blue.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/index.css">
    <script>
      username = "<?php echo $username; ?>"
      usertype = "<?php echo $usertype; ?>"
    </script>
    <script src="./js/index.js"></script>
    <link rel="icon" href="./images/ice-cream-shop.png"/>
    <title>Ice Creamania!</title>
</head>
<body>
    
    <dialog id="dialog">
      <span class="material-icons close-icon" style="position: relative;top: 0;left: 97%;" id="dialog-close-1">close</span>
      <div class = "">
        <div class="img-switcher ">
          <img src="./images/Ice Cream Icons-01.png" alt="ice creams" width="85%;" id="images" style = "margin: auto;margin-top: 20px;">                
        </div>
        <div class="login-form-container">
          
          <div class="login-form">
            <div style="font-size: xx-large;font-weight: bold;margin-bottom: 20px;" class = "gotu">Log In</div>
            <div style="margin-bottom: 10px;" class="">Log in to Ice Creamania! to view our lip smacking menu, get offers and much more!</div>
          <form action="#">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <input class="mdl-textfield__input" type="email" id="email">
              <label class="mdl-textfield__label" for="email">Email Address</label>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <input class="mdl-textfield__input" type="password" id="password">
              <label class="mdl-textfield__label" for="password">Password</label>
            </div>
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored login" id = "login-btn">
              Log In
            </button>
            <div style="margin-top: 10px;">Not registered yet? <a href="#">Sign Up</a> now!</div>
          </form>
        </div>
        </div> 
        
      </div> 
    </dialog>
    <dialog id="dialog-delivery">
      <span class="material-icons close-icon" style="position: relative;top: 0;left: 97%;" id="dialog-close-2">close</span>
      <div class = "">
        <div style="float: left;width: 30%;text-align: center;">
          <img src="./images/ice-cream-menu.png" alt="ice creams" width="120px;" id="images" style="text-align: center;">                
        </div>
        <div style = "float: right;width: 68%;border-left: 1px solid #e6e6e6;">
          
          <div class="login-form">
            <div style="font-size: large;font-weight: bold;margin-bottom: 5px;line-height: 30px;" class = "gotu">Your Ice Cream won't melt!</div>
            <div style="font-size: large;"><a href = "menu.php">Check out our menu NOW!</a></div>
            
          
        </div>
        </div> 
        
      </div> 
    </dialog>
    <dialog id="dialog-no-delivery" style="height: 28vh;">
      <span class="material-icons close-icon" style="position: relative;top: 0;left: 97%;" id="dialog-close-3">close</span>
      <div class = "">
        <div style="float: left;width: 30%;text-align: center;">
          <img src="./images/melting.png" alt="ice creams" width="120px;" id="images" style="text-align: center;">                
        </div>
        <div style = "float: right;width: 68%;border-left: 1px solid #e6e6e6;">
          
          <div class="login-form" style="margin: 6% 5%;">
            <div style="font-size: large;font-weight: bold;margin-bottom: px;line-height: 30px;" class = "gotu">Your Ice Cream would melt!</div>
            <div style="font-size: large;"><a href = "menu.php">You can still check out our menu</a>.</div>
            <div>And, feel free to visit our store :)</div>
            
          
        </div>
        </div> 
        
      </div> 
    </dialog>

    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <div class = "top-bar gotu" style="padding-bottom: 5px;"><b>COVID-19 ADVISORY:</b> Don't head out! Stay indoors. Order now and enjoy your favourite Ice Creams at home!🎉<span class="material-icons" style="float: right;right: 10px;position: relative;top: -2px;" id = "top-bar-close">close</span>
      </div>
        <header class="mdl-layout__header">
          <div class="mdl-layout__header-row">
            <!-- Title -->
            <a href = "index.html" style = "color:white;"><span class="mdl-layout-title">Ice Creamania!</span></a>
            <!-- Add spacer, to align navigation to the right -->
            <div class="mdl-layout-spacer"></div>
            <!-- Navigation. We hide it in small screens. -->
            <nav class="mdl-navigation mdl-layout--large-screen-only">
                <a class="mdl-button mdl-js-button gotu top-bar-btn" id = "menu" href = "menu.php">Menu</a>
                <a class="mdl-button mdl-js-button gotu top-bar-btn" id = "login">Login</a>
                <div class="userprofile">
                  <button class="mdl-button mdl-js-button gotu top-bar-btn" id = "profile" >Hello, <?php echo $username; ?></button>
                  <div class="signout gotu" style="display: none;">
                    <div class="myprofile"><a href="userprofile.php">My Profile</a></div>
                    <div class="sinout"><a href="signout.php">Sign Out</a></div>
                  </div> 
              </div>
                <a class="mdl-button mdl-js-button gotu top-bar-btn" href = "signup.html" id = "signup">Sign Up</a>
            </nav>
          </div>
        </header>
        
        <main class="mdl-layout__content">
          <div class="page-content"><!-- Your content goes here -->
            
            <div class="landing-cover">
                <div class = "title">Ice Creamania!</div>
            </div>
            <div class="landing-cover-r">
              <div>
                <img src="./images/ice-cream-shop.png" alt="" srcset="" class="" width="250" style="margin-top: 50px;">
                <div class = "landing-text gotu">Want it delivered? Check if we can reach you before your Ice Cream melts!</div>
              </div>
              <form action="#">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input gotu" type="text" id="address">
                  <label class="mdl-textfield__label gotu" for="address">Address</label>
                </div>
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored addr">
                  Check Address
                </button>
              </form>
            </div>

          </div>
          
        </main>        
      </div>
      
      <link href="https://fonts.googleapis.com/css2?family=Spicy+Rice&display=swap" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Gotu&display=swap" rel="stylesheet">
    
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</body>
</html>