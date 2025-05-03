<?php

class StaticPageController
{
    public function show_map()
    {
        include __DIR__ . '/../views/pages/map.php';
		
    }
	
	public function show_SuccessRegister($email){
		
		$urlEmail = urlencode($email);
		
		include __DIR__ . "/../views/pages/successRegisterPage.php";
		
	}
	
	public function ShowErrorPage(){
		
		include __DIR__ . "/../views/pages/404.php";
		
	}
	
}
