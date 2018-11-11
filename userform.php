<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src = 'http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js'></script>    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
</head>
<body>   

	<!---<?php require_once 'db.php'; ?>--->

	<script type="text/javascript">

		function deleteUsers() {	
			
			
			var ids_string = $("input[name='checks']:checked").map(function(index, element) { 
				return $(this).prop('id');
			})
			.get()
			.join(',');

			window.location.href = "userform.php?act=delete&ids=" + ids_string;
		}


		function lockUsers() {
			var ids_string = $("input[name='checks']:checked").map(function(index, element) { 
				return $(this).prop('id');
			})
			.get()
			.join(',');

			window.location.href = "userform.php?act=lock&ids=" + ids_string;
		}


		function unlockUsers() {
			var ids_string = $("input[name='checks']:checked").map(function(index, element) { 
				return $(this).prop('id');
			})
			.get()
			.join(',');

			window.location.href = "userform.php?act=unlock&ids=" + ids_string;
		}

	</script>


	
	<?php

		//$connection = new PDO('mysql:host=localhost;dbname=users_db', 'root', '');
	  
//var_dump($_POST);
	    if(isset($_POST['action']))
	    {
	    	echo "yes";
	    }

	    if (isset($_GET['act'])) {
	    	switch ($_GET['act']) {

	    		case 'delete':
	    			if (empty($_GET['ids'])) {
	    				echo 'Не указано, кого удалить';
	    			} else {
	    				$stmt = $connection->prepare('DELETE FROM users WHERE id = ?');
	    				$stmt->execute([$id]);	    		
	    			}

	    			break;

				case 'lock':
	    			if (empty($_GET['ids'])) {
	    				echo 'Не указано, кого заблокировать';
	    			} else {
	    				$stmt = $connection->prepare('UPDATE users Set state="Заблокирован" WHERE id = ?');
	    				$stmt->execute([$_GET['ids']]);
	    				//var_dump($stmt->errorInfo());
	    			}

	    			break;

	    		case 'unlock':
	    			if (empty($_GET['ids'])) {
	    				echo 'Не указано, кого разблокировать';
	    			} else {
	    				$stmt = $connection->prepare('UPDATE users Set state="Активен" WHERE id = ?');
	    				$stmt->execute([$_GET['ids']]);
	    				//var_dump($stmt->errorInfo());
	    			}

	    			break;	    		

	    	}
	    }
	?>

	<p>		
	<pre>  <button onclick="deleteUsers()">Удалить</button>   <button onclick="lockUsers()">Блокировать</button>   <button onclick="unlockUsers()">Разлокировать</button></pre>

		<?php			
			require_once 'db.php';     

		    if(isset($_COOKIE['username']))
			{
				$stml=$connection->prepare('UPDATE users Set date_of_entering=:date_of_entering WHERE username=:username');
				$stml->execute(['date_of_entering' => date('Y-m-d H:i:s'), 'username' => $_COOKIE['username']]);
				
				/*$name = $_SESSION['logged_user'];
				$user=R::findOne('users','username=?',[$name]);
				$user->date_of_entering=date('Y-m-d H:i:s');
				R::store($user);*/		
				
			}

			$sql='SELECT * FROM users';
				    
			$rows = $connection->query($sql);
				    //print_r($connection->errorInfo());
			echo '<table class="table table-hower"><thead><tr><th></th><th>Имя пользователя</th><th>Дата регистрации</th><th>Дата последнего посещения</th><th>Состояние</th></thead><tbody>';

			$k=0;
			while ($row = $rows->fetch(PDO::FETCH_ASSOC))
			{		
				echo '<tr class="gr"><td><input type="checkbox" name="checks" onclick="getChecks()" id='.$row['id'].'></td> <td>' . $row['username'] . '</td><td>'.$row['date_of_creating'].'</td><td>'.$row['date_of_entering'].'</td><td>'.$row['state'].'</td></tr>';
				$k+=1;
			}
			echo '</tbody></table>'; 
			
   		?>
	

</body>
</html>