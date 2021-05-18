<?php
    require_once "./db.php";

    header("Content-Type: application/json");

    if ($_SERVER["REQUEST_METHOD"] == "GET" ){
        $res = getImpo($_GET["email"]);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if ($_POST["state"] == "add"){
            $res = addToFav($_POST["name"]);
        }
         
    }

    
    echo json_encode($res);


    function addToFav($name){
        global $db;

        $rs = $db->prepare(`UPDATE listitems SET fav='yes' WHERE item = ?`);
        $rs->execute([$name]);

        return ["valid"=> true];
    }


    function getImpo($email){
        global $db;
        $rs = $db->prepare("select * from listitems where email = ? and fav = ? ");
        $rs->execute([$email, "yes"]);

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
    };
