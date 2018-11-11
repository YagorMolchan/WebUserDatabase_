<?php
    
    require 'db.php';

    function F()
    {
        echo "Yes";
    }
    


    if(isset($_POST['delete']))
    {
        deleteUsers();
    }

    function deleteUsers()
    {
        $ids = getCheckedBoxes();
        $stml=$connection->prepare('Delete from users Where id=?');                
        $stml->execute($ids);
        $smsg = "Пользователи успешно удалены!!!";
    }



    function getCheckedBoxes()
    {
        $array_id=array();
        $index=0;
        if(!empty($_POST[$chkname]))
        {
            foreach($_POST[$chkname] as $chkval)
            {
                $array[$index]=$chkval;
                $index+=1;
            }
        }
        return $array;
    }

?>














