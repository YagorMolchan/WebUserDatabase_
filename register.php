<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
</head>
<body>
<?php
	require 'db.php';
	$data=$_POST;
   
    if(isset($_POST["submit"])) {

    	$user=R::findOne('users','username=?',[$data['username']]);

        /*$stml = $connection->prepare("Insert into users(username,date_of_creatng,date_of_entering,state,password) 
        Values(:username,:date_of_creating,:date_of_entering,:state,:password)");*/

        /*$stml = $connection->prepare('Select * Where username=:username');
        $stml->execute(['username' => $data['username']]);
        $rows = $stml->fetch();*/


    	
    	if(empty($data["username"]))
    	{
    		$fmsg="Введите имя пользователя!";
    	}
    	if(empty(["password1"]))
    	{
    		$fmsg="Введите пароль";
    	}
    	if($data["password2"] != $data["password1"])
    	{
    		$fmsg="Повторный пароль введен неверно!";
    	}
    	if(!empty($user))
    	{
    		$fmsg="Пользователь с данным именем уже существует!";
    	}
    	else 
    	{
            $user=R::dispense('users');
            $user->username=$data['username'];
            $user->date_of_creating=date('Y-m-d H:i:s');
            $user->date_of_entering=date('Y-m-d H:i:s');
            $user->state="Активен";
            $user->password=$data['password1'];
            $id=R::store($user);
            if($id)
            {
                $smsg="Регистрация завершена успешно!";
            }
    		/*$connection = new PDO('mysql:host=localhost;dbname=users_db', 'root', '');
            $stml = $connection->prepare("Insert into users(username,date_of_creatng,date_of_entering,state,password) 
            Values(:username,:date_of_creating,:date_of_entering,:state,:password)");
    		$stml->execute(['username'=>$data['username'], 'date_of_creating' => date('Y-m-d H:i:s'), 'date_of_entering' => date('Y-m-d H:i:s'), 'state' => 'Активен', 'password' => $data['password1']]);*/

            

    		
    	}
        
    }    
?>
<content>
    <div class="container">
        <form class="form-signin" method="post">
            <h1>Регистрация</h1> 
            <?php if(isset($smsg)){?><div class="alert alert-success" role="alert"> <?php echo $smsg;?></div><?php }?>
			<?php if(isset($fmsg)){?><div class="alert alert-danger" role="alert"> <?php echo $fmsg;?></div><?php }?>
            <input type="text" class="form-control" name="username" placeholder="Имя польователя" required>
            <input type="password" class="form-control" name="password1" placeholder="Пароль" required>
            <input type="password" class="form-control" name="password2" placeholder="Подтверждение пароля" required>
            <button type="submit" class="btn btn-lg btn-primary btn-block" name="submit">Зарегистрироваться</button>
            <a href="index.php">Вход</a>
        </form>
    </div>
</content>
</body>
</html>
