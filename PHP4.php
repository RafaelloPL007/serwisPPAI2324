<?php
    session_start();
    if(isset($_SESSION['uID'])){
        echo "Witamy!";
        //wylogowanie:
        session_unset(); //usunięcie wszystkich danych sesji
        session_destroy(); //usunięcie samej sesji
    }else{
        echo "Spadaj!!!";
    }
?>