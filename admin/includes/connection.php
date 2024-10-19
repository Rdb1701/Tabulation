<?php
 $db = mysqli_connect('localhost', 'root', '') or
        die ('Unable to connect. Check your connection parameters.');
        mysqli_select_db($db, 'tabulation' ) or die(mysqli_error($db));

        session_start();
?>