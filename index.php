<?php
    session_start();
    /* Check Session */
    // check if there is an existing session

    session_unset();
    session_destroy();
    header("location:/adminpanel");
    //header("location:https://lbpresources.com/");