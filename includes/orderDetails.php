<?php
    session_start();
    require_once "dbcontroller.php";
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
        <link rel="stylesheet" href="../css/base.css">
        <link rel="stylesheet" href="../css/orderDetails.css">
        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <script src = "../js/orderDetails.js">  </script>
        <link rel="icon" href="../images/ice-cream-shop.png"/>
        <title>Ice Creamania! | My Order</title>
    </head>
    <body style= "display:block">
        <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <!-- Title -->
                    <a href = "../index.php" style = "color:white;text-decoration:none"><span class="mdl-layout-title">Ice Creamania!</span></a>
                    <!-- Add spacer, to align navigation to the right (add spacer if no search bar)
                    <div class="mdl-layout-spacer"></div> -->
                    <div class="mdh-expandable-search mdl-cell--hide-phone" style="margin-left:-20px;">
                    
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
                    <div class="userprofile">
                        <button class="mdl-button mdl-js-button gotu top-bar-btn" id = "profile" >Hello, <?php echo $username; ?></button>
                        <div class="signout gotu" style="display: none;">
                            <div class="myprofile"><a href="../userprofile.php">My Profile</a></div>
                            <div class="sinout"><a href="../signout.php">Sign Out</a></div>
                        </div> 
                    </div>
                    </nav>
                </div>
            </header>
            <main class="mdl-layout__content">
                <div class="page-content" style="height: 100%; position: relative;">
                    <?php
                    if(isset($_GET["orderId"])){
                        $dbcontroller = new DBController();
                        $dbcontroller -> connectDb();
                        $orderId = $_GET["orderId"];
                        $sql = "SELECT oid,quantity,itemname,o.price,imagepath, t.price as 'finalprice' from orders as o,inventory,transaction as t where t.tid = $orderId and o_itemid = itemid and o.tid = t.tid";
                        $orderDetails = $dbcontroller -> runQuery($sql);
                        

                        $totalPrice = 0;
                        $totalQuantity = 0;
                    ?>
                    <div class = "bg-orders" style="height: 100%;padding:5%">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 main-card" style = "padding: 3rem 3rem 1rem 3rem;">
                                    <h3 class="gotu" style="margin-left: 2%;font-size:28px">Your order is confirmed!</h3>
                                    <div class="table-responsive">
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
                                            <tbody>
                                                <?php
                                                if($orderDetails -> num_rows > 0){
                                                    while($row = mysqli_fetch_assoc($orderDetails)) {
                                                        $totalPrice = $row["finalprice"];
                                                        $oid = $row["oid"];
                                                        $sql = "SELECT e.ename as 'name',e.rate as 'rate' FROM order_customization as oc, extras as e WHERE oc.oc_oid = $oid and oc.oc_eid = e.eid";
                                                        
                                                        $extrasResult = $dbcontroller -> runQuery($sql);
                                                        $extrasName = "";
                                                        $extrasTotal = 0;
                                                        if($extrasResult -> num_rows > 0)
                                                        {
                                                            while($row1 = mysqli_fetch_assoc($extrasResult)) 
                                                            {
                                                                $extrasName .= $row1['name'] . ", ";
                                                                $extrasTotal += $row1['rate'];
                                                            }
                                                            $extrasName = substr($extrasName,0,strlen($extrasName)-2);
                                                            
                                                        }
                                                        else
                                                        {
                                                            $extrasName = "No Extras";
                                                            $extrasTotal = 0;
                                                        }
                                                        ?>
                                                        <tr>
                                                            <th scope="row" class="border-0 gotu">
                                                                <div class="p-2">
                                                                    <img src="<?php echo $row["imagepath"]; ?>" alt="" width="70" class="img-fluid rounded shadow-sm">
                                                                    <div class="ml-3 d-inline-block align-middle">
                                                                        <div class="text-dark align-middle"><?php echo $row["itemname"]; ?></div>
                                                                        <div class=" align-middle" style = "font-size:14px;color:#aaa;">With: <?php echo $extrasName; ?></div>
                                                                        <span class="text-muted font-weight-normal font-italic d-block"></span>
                                                                    </div>
                                                                </div>
                                                            </th>
                                                            <th class="border-0 align-middle gotu" style="text-align:center;">
                                                                <div class="text-dark align-middle">$<?php echo $row["price"]; ?></div>
                                                                <div class=" align-middle" style = "font-size:14px;color:#aaa;">$<?php echo $extrasTotal; ?></div>
                                                            </th>
                                                            <th class="border-0 align-middle gotu" style="text-align:center;"><?php echo $row["quantity"]; ?></th>
                                                            <th class="border-0 align-middle gotu" style="text-align:center;">$<?php echo ($row["price"]+$extrasTotal) * $row["quantity"]; ?></th>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td><button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" onclick = "window.location.href='../menu.php'" style = "margin-top:20px;"><i class="fa fa-angle-left"></i> Continue shopping</button>
                                                    <td colspan="2" class="hidden-xs"></td>
                                                    <td class="hidden-xs text-center gotu"  style="text-align:center;"><strong>Total $ <?php echo $totalPrice;?> </strong> <br>(Incl. of all taxes, service charges and discounts*)</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                    else{
                        echo "No order details to display";
                    }
                ?>
                </div>
            </main>
        </div>
    </body>
</html>
