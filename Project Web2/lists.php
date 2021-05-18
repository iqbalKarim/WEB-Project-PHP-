<?php
    require_once "./db.php";

    header("Content-Type: application/json");

    if ($_SERVER["REQUEST_METHOD"] == "GET" ){
        $res = getLists($_GET["email"]);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $res = addLists($_POST["name"], $_POST["email"]);
    }

    echo json_encode($res);


    function getLists($email){
        global $db;

        $rs = $db->prepare("select * from lists where email = ?");
        $rs->execute([$email]);

        $all = $rs->fetchAll(PDO::FETCH_ASSOC);

        $out = [];

        foreach($all as $list){
            $row = [
                "email" => $list["email"],
                "list" => $list["list_name"]
            ];
            array_push($out, $row);
        }
        return $out;
    }

    function addLists($name, $email){
        global $db;

        try{
            $rs = $db->prepare("insert into lists (email, list_name) values (?, ?)");
            $rs->execute([$email, $name]);
            
            return ["valid"=> true];

        }catch(PDOException $ex){
            return ["valid"=> false];
        }
    }
    
?>