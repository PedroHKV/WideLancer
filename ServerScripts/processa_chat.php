<?php
    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        $chat_id = $_POST["chat"];
        session_start();
        $_SESSION["chat_id"] = $chat_id;
        echo "200";
    }
?>