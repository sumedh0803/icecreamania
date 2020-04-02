<?php
    require_once "navigation_bar.php";
    if(isset($_SESSION["cartItemsList"])){
        $totalPrice = 0;
        foreach($_SESSION["cartItemsList"] as $key => $value){
            $totalPrice += $_SESSION["cartItemsList"][$key]["rate"] * $_SESSION["cartItemsList"][$key]["quantity"];
        ?>
            <div class="product">
                <div class="product-tile-footer">
                <div class="product-title">
                    <?php echo $_SESSION["cartItemsList"][$key]["itemname"]; ?>
                </div>
                <div class="product-price">
                    <?php echo "$".$_SESSION["cartItemsList"][$key]["rate"]; ?>
                </div>
                <div class="cart-action">
                    <?php echo $_SESSION["cartItemsList"][$key]["quantity"]; ?>
                </div>
            </div>
        <?php
        }
        echo "Total price is $". $totalPrice;
    }
    else{
        echo "Your cart is empty!";
    }
?>