            <?php
                if(isset($_GET['category'])){
?>
<ul class="product-list itemlist-padding">
<?php
                    $category = $_GET['category'];
                    $result = "";
                    if($category == "New Arrival"){
                        $sql = "SELECT * FROM `products` ORDER BY `products`.`id` DESC LIMIT 10";
                        $result = mysqli_query($conn, $sql);

                    }elseif($category == "Accessories"){
                        $sql = "SELECT * FROM `products` WHERE category LIKE '%Accessories%'";
                        $result = mysqli_query($conn, $sql);

                    }else{
                        $sql = "SELECT * FROM products WHERE category = '$category'";
                        $result = mysqli_query($conn, $sql);
                    }

            if(!$result) return;
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){

                    ?>
                    
                    <li class="product-item">
                        <div class="product-card" tabindex="0">

                            <figure class="card-banner">
                            <img src="products/<?=$row['category']?>/<?=$row['path']?>" width="312" height="350" loading="lazy"
                                alt="Product Picture" class="image-contain">

                            <div class="card-badge">New</div>

                            <ul class="card-action-list">

                                <li class="card-action-item">
                                    <form method="post" id="item-form">
                                        <input type="hidden" id="productId" value="<?=$row['id']?>">
                                        <button class="card-action-btn toCartbtn" aria-labelledby="card-label-1">
                                    </form>
                                    
                                    <ion-icon name="cart-outline"></ion-icon>
                                    </button>

                                    <div  class="card-action-tooltip" id="card-label-1">Add to Cart</div>
                                </li>

                                <li class="card-action-item heart-option" value="choy">
                                <input type="hidden" class="productId" value="<?=$row['id']?>">
                                    <?php 
                                        if(in_array($row['id'], $_SESSION['wishlist'])){
                                    ?>
                                    <button class="card-action-btn liked" style="pointer-events: none;" aria-labelledby="card-label-2">
                                        <ion-icon name="heart-outline" style="color: white"></ion-icon>
                                    </button>
                                    <?php 
                                        }else{
                                            ?>
                                    <button class="card-action-btn toWishlistBtn" aria-labelledby="card-label-2">
                                        <ion-icon name="heart-outline"></ion-icon>
                                    </button>
                                            <?php
                                        }
                                    ?>

                                <div class="card-action-tooltip" id="card-label-2">Add to Whishlist</div>
                                </li>

                                <li class="card-action-item">
                                <button class="card-action-btn quick-view" aria-labelledby="card-label-3">
                                    <ion-icon name="eye-outline"></ion-icon>
                                </button>

                                <div class="card-action-tooltip" id="card-label-3">Quick View</div>
                                </li>

                                <!-- <li class="card-action-item">
                                <button class="card-action-btn compare-btn" aria-labelledby="card-label-4">
                                    <ion-icon name="repeat-outline"></ion-icon>
                                </button>

                                <div class="card-action-tooltip" id="card-label-4">Compare</div>
                                </li> -->

                            </ul>

                            </figure>

                            <div class="card-content">

                            <div class="card-cat">
                                <a href="items.php?category=<?=$row['category']?>" class="card-cat-link"><?=$row['category']?></a>
                            </div>

                            <h3 class="h3 card-title">
                                <a href="#"><?=$row['name']?></a>
                            </h3>

                            <data class="card-price">$<?=$row['price']?></data>

                            </div>

                        </div>
                    </li> 
                    
                    <?php

                    } 
                }
            
        ?>
</ul>
<?php 
    }
    if(isset($_POST['liked'])){
        $liked = $_POST['liked'];

        if($liked){
        ?>
            <button class="card-action-btn liked" style="pointer-events: none;" aria-labelledby="card-label-2">
                <ion-icon name="heart-outline" style="color: white"></ion-icon>
            </button>
        <?php
        }else{
         ?>
            <button class="card-action-btn toWishlistBtn" aria-labelledby="card-label-2">
                <ion-icon name="heart-outline"></ion-icon>
            </button>
         <?php
        }
    }
?>

