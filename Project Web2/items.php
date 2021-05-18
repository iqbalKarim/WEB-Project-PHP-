<?php
    require_once "./db.php";

    header("Content-Type: application/json");

    if ($_SERVER["REQUEST_METHOD"] == "GET" ){
        $res = getItems($_GET["email"], $_GET["listName"]);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $res = addItem($_POST["listName"], $_POST["email"], $_POST["item"]);
    }


    echo json_encode($res);

    function getItems($email, $listName){
        global $db;

        $rs = $db->prepare("select * from listitems where email = ? and list_name = ?");
        $rs->execute([$email, $listName]);

        $all = $rs->fetchAll(PDO::FETCH_ASSOC);


        $out = [];

        foreach($all as $list){
            $row = [
                "email" => $list["email"],
                "list" => $list["list_name"],
                "item" => $list["item"],
                "fav" => $list["fav"]
            ];
            array_push($out, $row);
        }

        return $out;
    }

    function addItem($list_name, $email, $item){

        global $db;
        
        try{
            $rs = $db->prepare("insert into listitems (list_name, email, item, fav) values (?, ?, ?, ?)");
            #$rs->execute([$list_name, $email, $item, "no"]);
            
            return ["valid"=> true];

        }catch(PDOException $ex){
            return ["valid"=> false];
        }
    }
    

?>