<?php

include '../components/connection.php';
session_start();

if(isset($_POST['place_order'])){
    $orders = $_POST['orders'];
    $userId = $_SESSION['id'];
    $total = $_POST['total'];
    $payment = $_POST['payment'];


        $create_transaction = "INSERT INTO `transactions`(`total`, `status`, `userId`, `employeeId`, `inventoryId`) VALUES (DEFAULT, DEFAULT, $userId,DEFAULT,1);";
        $createResult = mysqli_query($conn, $create_transaction);
        $transactionId = mysqli_insert_id($conn);
        $_SESSION['transaction_id'] = $transactionId;

        $create_ordertab = "INSERT INTO order_tab(`transaction_id`, `status`) VALUES ($transactionId, '$payment')";
        mysqli_query($conn, $create_ordertab);
        $tab_id = mysqli_insert_id($conn);
        $_SESSION['tab_id'] = $tab_id;

        $check = "SELECT *, (carts.id) AS cartId ,(price * qty) AS total FROM carts 
        INNER JOIN products ON productId = products.id WHERE userId = $userId;";
        $result = mysqli_query($conn, $check);

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            
            if(in_array($row['productId'], $orders)){
                    $productId = $row['productId'];
                    $cartId = $row['cartId'];
                    $total = $row['total'];
                    $qty = $row['qty'];
                    
                    $create_order = "INSERT INTO `orders`(`productId`, `qty`, `total`, `transactionId`)
                    VALUES ($productId, $qty, $total, $transactionId)";
                    $setOrder = mysqli_query($conn, $create_order);

                    $cartsql = "DELETE FROM carts WHERE id = $cartId";
                    $removeCart = mysqli_query($conn, $cartsql);
            }
        }

        $updatesql = "UPDATE transactions SET total = $total WHERE id = $transactionId";
        $updatetransaction = mysqli_query($conn, $updatesql);
        
        header("Location: receipt.php?transactionId=".$transactionId);
}


?>