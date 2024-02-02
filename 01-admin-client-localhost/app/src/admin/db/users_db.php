<?php

class users_db {
    public static function GetUsersQuery()
    {
        $sql ="select u.*,concat(u.UserName,'(',u.Name,')') as DispName from users u left join user_types ut on u.user_type=ut.id order by u.UserID"; //added_date
        return $sql;
    }

    public static function GetImportedUsersQuery()
    {
        $sql ="select u.*,concat(u.UserName,u.Name) as DispName from v_imported_users u order by name,surname";
        return $sql;
    }
	
}
?>
