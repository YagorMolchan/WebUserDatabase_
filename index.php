<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
</head>
<body>
<?php
    require 'db.php';

    $data=$_POST;
    
    if(isset($data['submit'])){

        //echo "Yes";
        $stml = $connection->prepare('Select username,password, state from users Where username=:username');
        $stml->execute(['username' => $data['username']]);
        $rows = $stml->fetch(PDO::FETCH_ASSOC);
        /*if($rows)
        {
            echo $rows['username'];
        }*/


        if($rows)
        {    
            if($rows['state']=="Заблокирован")
            {
                $fmsg = "Пользователь заблокирован!";
            }
            if($data['password']==$rows['password'] && $rows['state']=="Активен")
            {
                setcookie('username',$data['username'],time()+60);
                header('Location: userform.php');
                /*session_start();
                $_SESSION['logged_user']=$data['username'];
                if(isset($_SESSION['logged_user']))
                {
                    header('Location: userform.php');
                }*/                
                
                //$connection = new PDO('mysql:host=localhost;dbname=users_db', 'root', '');                 
                //$_SESSION['logged_user']=$data['username'];
                           
                $smsg="Вы успешно авторизованы!";
                //setcookie('submit',$data['submit'],time()+60);               
            }
            if($data['password']!=$rows['password'] )
            {
                 $fmsg="Неверный пароль!";
            }
            
        }
        else
        {
            $fmsg="Пользователь с таким именем не найден!";
        }

    }
?>

<content>
    <div class="container">
        <form method="post" class="form-signin" action="index.php">
            <h1>Вход на сайт</h1>
            <?php if(isset($smsg)){?><div class="alert alert-success" role="alert"> <?php echo $smsg;?></div><?php }?>
            <?php if(isset($fmsg)){?><div class="alert alert-danger" role="alert"> <?php echo $fmsg;?></div><?php }?>
            <input type="text" class="form-control" name="username" placeholder="Имя польователя" required>
            <input type="password" class="form-control" name="password" placeholder="Пароль" required>            
            <button type="submit" class="btn btn-lg btn-primary btn-block" name="submit">Войти</button>
            <a href="register.php">Регистрация</a>           
        </form>
    </div>    
</content>
</body>
</html>
