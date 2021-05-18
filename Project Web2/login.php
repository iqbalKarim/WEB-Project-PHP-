<?php 
    session_start();

    require_once "./db.php";
    extract ($_POST);
    var_dump($_POST);
    $rs = $db->prepare("select * from users where email = ?");
    $rs->execute([$email]);
    var_dump($rs);
    if ($rs->rowCount() ===  1){
        $user = $rs->fetch(PDO::FETCH_ASSOC);
        var_dump($user);
        if (password_verify($password, $user["password"])){
            $_SESSION["user"] = $user;
            header("Location: mainPage.php");
            exit;
        }
    }

    $_SESSION["error"] = "Invalid Credentials";
    header("Location: index.php");
?>