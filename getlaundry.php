<?php
    include "db_connect.php";
    try{
        $qry = $conn->query("SELECT * FROM laundry_list WHERE id =".$_POST['id']);
        $returnArr = array();
        $row = $qry -> fetch_array(MYSQLI_ASSOC);
        if($row){
            $returnArr[] = array(
                "first_name" => $row["first_name"],
                "last_name" => $row["last_name"],
                "customer_address" => $row["customer_address"],
                "contact" => $row["contact"],
                "status" => $row["status"],
                "queue" => $row["queue"],
                "total_amount" => $row["total_amount"],
                "pay_status" => $row["pay_status"],
                "amount_tendered" => $row["amount_tendered"],
                "amount_change" => $row["amount_change"],
                "remarks" => $row["remarks"],
                "washing_id" => $row["washing_id"],
                "date_created" => $row["date_created"],
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