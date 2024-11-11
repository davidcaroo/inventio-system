<?php

if(isset($_SESSION["cart"])){
    $cart = $_SESSION["cart"];
    if(count($cart) > 0){
        $num_succ = 0;
        $process = false;
        $errors = array();

        foreach($cart as $c){
            $q = OperationData::getQYesF($c["product_id"]);
            if($c["q"] <= $q){
                if(isset($_POST["is_oficial"])){
                    $qyf = OperationData::getQYesF($c["product_id"]);
                    if($c["q"] <= $qyf){
                        $num_succ++;
                    } else {
                        $errors[] = array("product_id" => $c["product_id"], "message" => "No hay suficiente cantidad de producto para facturar en inventario.");
                    }
                } else {
                    $num_succ++;
                }
            } else {
                $errors[] = array("product_id" => $c["product_id"], "message" => "No hay suficiente cantidad de producto en inventario.");
            }
        }

        if($num_succ == count($cart)){
            $process = true;
        }

        if($process == false){
            $_SESSION["errors"] = $errors;
            echo '<script>window.location="index.php?view=sell";</script>';
            exit;
        }

        if($process == true){
            $sell = new SellData();
            $sell->user_id = $_SESSION["user_id"];
            $sell->total = $_POST["total"];
            $sell->discount = $_POST["discount"];

            // Agrega la nota de crédito desde el formulario
            $sell->note = isset($_POST["note"]) ? $_POST["note"] : "";

            if(isset($_POST["client_id"]) && $_POST["client_id"] != ""){
                $sell->person_id = $_POST["client_id"];
                $s = $sell->add_with_client();
            } else {
                $s = $sell->add();
            }

            foreach($cart as $c){
                $op = new OperationData();
                $op->product_id = $c["product_id"];
                $op->operation_type_id = OperationTypeData::getByName("salida")->id;
                $op->sell_id = $s[1];
                $op->q = $c["q"];

                if(isset($_POST["is_oficial"])){
                    $op->is_oficial = 1;
                }

                $op->add();
            }

            unset($_SESSION["cart"]);
            setcookie("selled", "selled");
            echo "<script>window.location='index.php?view=onesell&id={$s[1]}';</script>";
            exit;
        }
    }
}

?>
