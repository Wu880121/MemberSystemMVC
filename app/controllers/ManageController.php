<?php

require_once  __DIR__. '/../models/user.php';
require_once  __DIR__. '/RegisterRequest.php';

class Manage{
	
    public function manage()
    
	  {
		
		$usersmodle= new User();
		
		
	   
		
		$page = isset($_GET['page']) ? $_GET['page']:1;
		$perPage = 20;
		$offset = ($page-1)*$perPage;
		
		$results = $usersmodle->getDataByPage($offset, $perPage); 
		
		$totalCount = $usersmodle->getAllCount();
		$totalPages = ceil($totalCount/$perPage);
		
		
		include __DIR__ . '/../views/pages/manage.php';
	}
	
	
	 public function ManageSearch(){
		 
		 $search = trim($_GET['search'] ?? ' ');
		 $page = (int) ($_GET['page'] ?? ' ') ; 
		$perPage = 20;
		$offset = max(0,($page-1)*$perPage);
		
		 $userModel = new User;
		 $results = $userModel->ManageSearch($search,$offset,$perPage);
		 $totalCount =  $userModel->ManageGetSearchCount($search);
		 $totalPages = ceil($totalCount / $perPage);
		 //var_dump($search);
        // exit;
		  include __DIR__ . '/../views/pages/manage.php';
	 }
	
	
	public function edit(){
		
		if ($_SERVER['REQUEST_METHOD']==='GET'){
			
			$id = $_GET['id'];
			
			
			if($id){
				
				$usermodel = new User();
				
				$results = $usermodel->selectById($id);
				
				include __DIR__ . '/../views/pages/edit.php';
			}
			
		}
			
			if ($_SERVER['REQUEST_METHOD']==='POST'){
			
			$id = $_POST['id'];
			$username = $_POST['username'];
			$password = $_POST['password'];
			$email = $_POST['email'];
			$tel = $_POST['tel'];
			$birthdate = $_POST['birthdate'];
			$sex = $_POST['sex'];
			$city = $_POST['city'];
			$street = $_POST['street'];
			$role = $_POST['role'];
			$data = $_POST;
			 
			$errors = RegisterRequest::validate($data);
				
			if(!empty($errors)){
				
				$_SESSION['alert']=[
					
					'status'=>'error_edit',
					'message'=>implode(' / ',$errors )
				];
				
				header ("Location: index.php?route=edit&id=".$id);
				exit;
			}
			
			$usermodel = new User(); 
			$OldPassword = $usermodel->selectOldPasswordFromId($id);
			
			if (isset($OldPassword) && password_verify($password,$OldPassword['password'])){
				
				$_SESSION['alert']=[
					
					'status' => 'PasswordCantSame',
					'message' =>'新密碼與舊密碼不能一樣'
					
				];				
				
				header ("Location: index.php?route=edit&id=".$id);
				exit;
			}
			
			if(!empty($password)){
				
				$password = password_hash($password, PASSWORD_DEFAULT);		
			}else{
				
				$password = NULL;
			}
			
			$usermodel = new User();
			
			$edit = $usermodel->edit($id,$username,$password,$email,$tel,$birthdate,$sex,$city,$street,$role);
			
			if($edit!==false){
				
				$_SESSION['alert']=[
				
				'status'=>'success_edit',
				'message'=>'成功修改完成!'
				];
				
				header('Location: index.php?route=manage');
				exit;
			}
		}
		
	}
	
	public function ManageDelete(){
		
		
		if ($_SERVER['REQUEST_METHOD']==='GET'){
			
			$id = isset($_GET['id']) ? $_GET['id'] : null;
			
			if (!empty($id)){
				
				$userModel = new User();
				
				$results = $userModel->selectById($id);
			    
				require_once __DIR__ . '/../views/pages/ManageDelete.php';
			}
		}
		
		if ($_SERVER['REQUEST_METHOD']==='POST'){
			
			$delete = isset($_POST['id']) ? $_POST['id'] : null;
			
			if ($delete==true){
				
				$userModel = new User();
				$userModel->UserDelete($delete);
				
				$_SESSION['alert']=[
				
					'status'=>'DeleteSucess',
					'message'=>'刪除成功!'
				];
				
				header('Location: index.php?route=manage');
				exit;
			}
		}
		
	}
	
	
	public function ManageCreate(){
		
		if($_SERVER['REQUEST_METHOD']=='GET'){
			
			require_once __DIR__. "/../views/pages/ManageCreate.php";
			return;
		}
		
		
		if ($_SERVER['REQUEST_METHOD']==='POST'){
				
			$name = $_POST['name'];
			$username = $_POST['username'];
			$password = $_POST['password'];
			$confirm_password = $_POST['confirm_password'];
			$email = $_POST['email'];
			$tel = $_POST['tel'];
			$birthdate = $_POST['birthdate'];
			$sex = $_POST['sex'];
			$city = $_POST['city'];
			$street = $_POST['street'];
			$data = $_POST;
			
			if (!empty($data)){
				
				$errors = (New RegisterRequest)->validate($data);
				
				if(!empty($errors)){
				
				$_SESSION['alert'] = [
					
					'status' => 'register_error',
					'message' =>implode( '/', $errors)
				
				      ];
				header("Location: index.php?route=create");
				exit;
				}
				
				if (empty($errors) && $confirm_password == $password ){
				

				$password = password_hash($password , PASSWORD_DEFAULT);
				
				$create = new User();
				$create -> ManageCreat($name,$username,$password,$email,$tel,$birthdate,$sex,$city,$street);
				
				if ($create){
					
					$_SESSION['alert']=[
						
						'status' => 'ManageCreateSuccess',
						'message' => "新增完成!"
					
					];
					header("Location: index.php?route=manage");
					exit;
				  }else{
					  
					  	$_SESSION['alert']=[
						
						'status' => 'ManageCreateError',
						'message' => "發生錯誤，請重新填寫!"
					
					];
					header("Location: index.php?route=create");
					exit;
					  
				  }
				}
			}
		}
		
		
	}
	
	
}
 