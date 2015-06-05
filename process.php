<?php 
	session_start();

	require('new-connection.php');

//----- is set -----//
	if(isset($_POST['action']) && $_POST['action'] == 'register'){
			register_user($_POST);
		}
	elseif(isset($_POST['action']) && $_POST['action'] == 'login'){
			login_user($_POST);
		}
	elseif(isset($_POST['action']) && $_POST['action'] == 'post_message'){
			user_message($_POST);
		}
	elseif(isset($_POST['action']) && $_POST['action'] == 'post_comment'){
			user_comment($_POST);
		} else {
			session_destroy();
			header('location: index.php');
			die();
		}

//----- Functions -----//

	function register_user($post){
				//-----Begin validation-----//
			$_SESSION['error'] = array();
			if (empty($post['first_name'])) 
				{
					$_SESSION['error'][] = "Need first name!";
				}
			if (empty($post['last_name'])) 
				{
					$_SESSION['error'][] = "Need last name!";
				}
			if (empty($post['email'])) 
				{
					$_SESSION['error'][] = "Need email!";
				}
			if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL))
				{
					$_SESSION['error'][] = "Email is incorrect!";
				}
			if (empty($post['password'])) 
				{
					$_SESSION['error'][] = "Password is required!";
				}
			if($post['password'] !== $post['confirm_password'])
				{
					$_SESSION['error'][] = "Passwords must match!";			
				}

				//-----begin extras-----//
			if(strlen($post['password']) < 6)
				{
					$_SESSION['error'][] = "Password is too short!";
				}
			if(ctype_alpha($post['password']))
				{
					$_SESSION['error'][] = "Password must contain a number!";
				}
			if(!ctype_alpha($post['first_name']))
				{
					$_SESSION['error'][] = "First Name can't contain a number!";
				}
			if(!ctype_alpha($post['last_name']))
				{
					$_SESSION['error'][] = "Last Name can't contain a number!";
				}
				//-----end extras-----//
				
				//-----End validation-----//

			if (count($_SESSION['error']) > 0) //if any errors..
				{
					header('location: index.php');
					die();
				}
			else //insert data into DB
				{
					//encryption
					$password = md5($_POST['password']); 
					$email = escape_this_string($_POST['email']);
					$query = "INSERT INTO users (first_name, last_name, email, password, created_at, updated_at) VALUES ('{$_POST['first_name']}', 
						'{$_POST['last_name']}','{$email}', '{$password}', NOW(), NOW())";
					run_mysql_query($query);
					$_SESSION['success'] = 'User succesfully created!';
					header('location: index.php');
					die();
				}
			// header('location: index.php');
			// die();
		}

	function login_user($post){
			$crypted_password = md5($post['password']);
			$query = "SELECT * FROM users WHERE users.password = '{$crypted_password}' AND users.email = '{$post['email']}'";
			$user = fetch_all($query); //go and attempt to grab user with above credentials!

			if(count($user) > 0)
				{
					$_SESSION['user_id'] = $user[0]['id'];
					$_SESSION['first_name'] = $user[0]['first_name'];
					$_SESSION['logged_in'] = TRUE;
					header('location: results.php');
				}
			else
				{
					$_SESSION['error'][] = "Try again";
					header('location: index.php');	
				}	
		}

	function user_message($post){
			$query = "INSERT INTO messages (message, users_id, created_at) VALUES ('{$_POST['message']}', '{$_SESSION['user_id']}', NOW())";
			run_mysql_query($query);
			// echo $query;
			// die();
			header("location: results.php");

			// if(isset($_POST['deleteItem']) and is_numeric($_POST['deleteItem']))
			// 	{

			// 	}

		}

	function user_comment($post){
			$query = "INSERT INTO comments (comment, messages_id, users_id, created_at) VALUES ('{$_POST['comment']}', '{$_POST['message_id']}', '{$_SESSION['user_id']}', NOW())";
			run_mysql_query($query);
			header("location: results.php");	
			// echo $query;
			// die();
		}


?>

