<?php
    session_start();
    /* Check Session */
    // check if there is an existing session

    session_unset();
    session_destroy();
    include("login/index.php");
    