<?php
    session_unset();
	require_once  'controller/conferenceController.php';		
    $controller = new conferenceController();	
    $controller->mvcHandler();
?>