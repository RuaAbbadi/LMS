<?php

function start_session() {
    if (session_status() == PHP_SESSION_NONE) {
        session_name('jawwal_go_sid');
        session_start();
    }
}

function login($row){
    start_session();
    session_regenerate_id();
    $_SESSION['alogin']=$row['emp_id'];
    $_SESSION['arole']=$row['department'];
}


