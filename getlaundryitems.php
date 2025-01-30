<?php
include "db_connect.php";
    try{
        $returnArr = array();
        $id= $_GET['id'];
        $msgQry = $conn->query("SELECT 
        c.name AS 'cname', 
        i.weight AS 'weight', 
        i.unit_price AS 'price', 
        i.amount AS 'amount' 
        FROM laundry_items AS i 
        INNER JOIN laundry_categories AS c 
        ON c.id = i.laundry_category_id 
        WHERE i.laundry_id = ".$id." GROUP BY c.id ORDER BY c.id DESC");
        while($row2 = $msgQry->fetch_array(MYSQLI_ASSOC)){
            $returnArr[] = array(
                "categoryName" => $row2['cname'],
                "weight" => $row2['weight'],
                "unitPrice" => $row2['price'],
                "amount" => $row2['amount']
            );
        }
    }catch (PDOException $e) {
        $returnArr[] = array(
            "error" => $e->getMessage()
        );
    } finally {
        // Encoding array in JSON format
        echo json_encode($returnArr);
    }