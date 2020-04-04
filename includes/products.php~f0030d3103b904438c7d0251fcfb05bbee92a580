<?php
    require_once "navigation_bar.php";
    if(!empty($_GET["action"])){
        $getProductDetails = $dbcontroller -> runQuery("Select * from inventory where itemid = '". $_GET["productId"] ."'");
        $productDetailsResult = mysqli_fetch_assoc($getProductDetails);
        $cartItem = array();
        $cartItem[$productDetailsResult["itemid"]] = array('itemname' => $productDetailsResult["itemname"], 'rate' => $productDetailsResult["rate"], 'imagepath' => $productDetailsResult["imagepath"], 'quantity' => $_POST["quantity"]);
        if(isset($_SESSION["cartItemsList"])){
            if(in_array($productDetailsResult["itemid"],array_keys($_SESSION["cartItemsList"]))){
                foreach($_SESSION["cartItemsList"] as $key => $value){
                    if($productDetailsResult["itemid"] == $key){
                        if(empty($_SESSION["cartItemsList"][$key]["quantity"])){
                            $_SESSION["cartItemsList"][$key]["quantity"] = 0;
                        }
                        $_SESSION["cartItemsList"][$key]["quantity"] += $_POST["quantity"];
                    }
                }
            }
            else{
                $_SESSION["cartItemsList"] += $cartItem;
            }
        }
        else{
            $_SESSION["cartItemsList"] = $cartItem;
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="../css/base.css">
    </head>
    <body>
        <br/>
        <div>
            <div class="row row-cols-3 row-cols-md-3 card-deck">
                <?php
                    //Get products which are not deleted by the admin
                    $resultSet = $dbcontroller -> runQuery("Select * from inventory where deleteitem = 0 order by itemid ASC");
                    if(!$resultSet -> num_rows === 0){
                        echo "No Products found!";
                    }
                    else{
                        while($row = mysqli_fetch_assoc($resultSet)) {
                ?>
                            <div class="col mb-4">
                                <div class="card">
                                <img src="<?php echo $row["imagepath"]; ?>" class="card-img-top" alt="..." style="width:30%;height:30%;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row["itemname"]; ?></h5>
                                    <p class="card-text">
                                        <?php echo $row["description"]; ?></br>
                                        <?php echo "Price : $".$row["rate"]; ?></br>
                                        <form action="products.php?action=addItem&productId=<?php echo $row["itemid"]?>" method="post">
                                            <input type="text" class="product-quantity" name="quantity" value="1" size="2" />
                                            <!--<input type="submit" value="Add to Cart" class="btnAddAction" />-->
                                            <button type="submit" class="btn btn-outline-info" value="Add to Cart">Add to Cart</button>
                                        </form>
                                    </p>
                                </div>
                                </div>
                            </div>
                <?php
                        }
                    }
                ?>
            </div>
        </div>
    </body>
</html>
