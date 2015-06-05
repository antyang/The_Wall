<?php 
	session_start();
	require('new-connection.php');
	
	$messages = fetch_all("SELECT users.first_name, users.last_name, messages.id, messages.message, messages.created_at 
							FROM messages 
							LEFT JOIN users ON users.id = messages.users_id
							-- AND messages.deleted_at IS NULL 
							ORDER BY messages.id DESC");


	if(!isset($_SESSION['logged_in'])){
		header("location: index.php");
	}

 ?>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<div class="container">
	
	<h4 align="right">Hello <?= $_SESSION['first_name'] ?>
	<a href="process.php">Log Off</a>
	</h4>

	<h1 align="center">My Wall</h1>
		

<div class="row">

	<div class="col-md-12">
		<label>Post A Message</label>
		<form action="process.php" method="post">
			<textarea name="message"></textarea>
			<input type="hidden" name="action" value="post_message">
			<input type="submit" class="btn btn-primary" value="Post a message">
		</form>
	</div>
	

<?php
	foreach($messages as $message) {
		// var_dump($message);
?>
		
	<h3 align="right" class="container"><?= $message['message'] ?></h3>
	<p align="right" class="container">Message by <?= $message['first_name'] ?> <?= $message['last_name'] ?> (<?= $message['created_at'] ?>)</p>

	<!-- delete button -->
	<!-- <?php echo "<p><input type='submit' name='deleteItem' value='Delete' {$message['id']}' /></p>"; ?> -->


<?php
	$comments = fetch_all("SELECT users.first_name, users.last_name, comments.comment, comments.created_at
							FROM comments 
							LEFT JOIN users ON users.id = comments.users_id 
							WHERE comments.messages_id = '{$message['id']}' 
							-- AND comments.deleted_at IS NULL
							ORDER BY comments.id ASC");
	
	foreach($comments as $comment){ 
?>
	<h4 align="right" class="container"><?= $comment['comment'] ?></h4>
	<p align="right" class="container ">Comment by 
				<?= $comment['first_name'] ?> 
				<?= $comment['last_name'] ?> 
				<?= $comment['created_at'] ?>
	</p>


<?php
	} 
?>
	<div align="right" class="container">
		<form action="process.php" method="post">
			<textarea name="comment"></textarea>
			<input type="hidden" name="action" value="post_comment">
			<input type="hidden" name="message_id" value="<?= $message['id'] ?>">
			<input type="submit" class="btn btn-success" value="Post a comment">
		</form>
	</div>

</div>
</div>

<?php
	}
?>

<style>
	textarea{
		width: 100%;
		height: 100px;
	}
	.btn{
		margin-top: 10px;
	}
</style>