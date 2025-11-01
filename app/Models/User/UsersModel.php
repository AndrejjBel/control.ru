<?php

namespace App\Models\User;

use Hleb\Base\Model;
use Hleb\Static\DB;
use App\Models\Myorm\MyormModel;
use PDO;

class UsersModel extends Model
{
    public static function getUsersAll(int $page, int $limit, $sheet = ''): array|false
    {
        $string = "ORDER BY id ASC LIMIT";
        $start  = ($page - 1) * $limit;
        $sql = "SELECT * FROM users $string :start, :limit";
        return DB::run($sql, ['start' => $start, 'limit' => $limit])->fetchAll();
    }

    public static function getUser()
    {
        $db = MyormModel::dbc();
        $auth = new \Delight\Auth\Auth($db);
        $id = $auth->getUserId();

        $sth = $db->prepare("SELECT * FROM `users` WHERE `id` = ?");
        $sth->execute(array($id));
        $array = $sth->fetch(PDO::FETCH_ASSOC);
        return $array;
    }

    public static function userId()
    {
        $db = MyormModel::dbc();
        $auth = new \Delight\Auth\Auth($db);
        $user_id = ($auth->getUserId())? $auth->getUserId() : 0;
        return $user_id;
    }

    public static function setUserMeta($params)
    {
        $sql = "INSERT INTO usermeta(user_id, meta) VALUES(:user_id, :meta) ON DUPLICATE KEY UPDATE meta = :meta2";
        DB::run($sql, $params);
        $sql_last_id =  DB::run("SELECT LAST_INSERT_ID() as last_id")->fetch();
        return $sql_last_id['last_id'];
    }

    public static function setUserMetaNew($params)
    {
        $sql = "INSERT INTO usermeta_new(user_id, meta) VALUES(:user_id, :meta) ON DUPLICATE KEY UPDATE meta = :meta2";
        DB::run($sql, $params);
        $sql_last_id =  DB::run("SELECT LAST_INSERT_ID() as last_id")->fetch();
        return $sql_last_id['last_id'];
    }

    public static function updateUserSettings($params)
    {
        $sql = "UPDATE users SET first_name = :first_name, last_name = :last_name WHERE id = :id";
        return DB::run($sql, $params);
    }

    public static function updateUserPass($oldPassword, $newPassword)
    {
        $db = MyormModel::dbc();
        $auth = new \Delight\Auth\Auth($db);
        $error = [];
        $error['message'] = [];
        try {
            $auth->changePassword($oldPassword, $newPassword);
            $error['type'] = 'success';
            $error['message'][] = 'Password has been changed';
        }
        catch (\Delight\Auth\NotLoggedInException $e) {
            $error['type'] = 'error';
            $error['message'][] = 'Not logged in';
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            $error['type'] = 'error';
            $error['message'][] = 'Invalid password(s)';
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            $error['type'] = 'error';
            $error['message'][] = 'Too many requests';
        }
        return $error;
    }

    public static function updateUserPassAdmin($user_id, $new_pass)
    {
        $db = MyormModel::dbc();
        $auth = new \Delight\Auth\Auth($db);
        $error = [];
        $error['message'] = [];
        try {
            $auth->admin()->changePasswordForUserById($user_id, $new_pass);
            $error['type'] = 'success';
            $error['message'][] = 'Password changed';
        }
        catch (\Delight\Auth\UnknownIdException $e) {
            $error['type'] = 'error';
            $error['message'][] = 'Unknown ID';
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            $error['type'] = 'error';
            $error['message'][] = 'Invalid password';
        }
        return $error;
    }

    public static function updateUserTokensOai($params)
    {
        $sql = "UPDATE users SET c_tokens = c_tokens + :c_tokens, p_tokens = p_tokens + :p_tokens WHERE id = :id";
        return DB::run($sql, $params);
    }

    public static function updateUserExpenses($params)
    {
        $sql = "UPDATE users SET expenses = expenses + :expenses WHERE id = :id";
        return DB::run($sql, $params);
    }

    public static function setUserTokensOai($params)
    {
        $sql = "INSERT INTO usertokens(user_id, token_name, token_value, token_type) VALUES(:user_id, :token_name, :token_value, :token_type)";
        DB::run($sql, $params);
        $sql_last_id =  DB::run("SELECT LAST_INSERT_ID() as last_id")->fetch();
        return $sql_last_id['last_id'];
    }

    public static function getUserTokensOai()
    {
        $db = MyormModel::dbc();
        $auth = new \Delight\Auth\Auth($db);
        $id = $auth->getUserId();

        $sth = $db->prepare("SELECT c_tokens, p_tokens FROM `users` WHERE `id` = ?");
        $sth->execute(array($id));
        $array = $sth->fetch(PDO::FETCH_ASSOC);
        return $array;
    }

    public static function getUserTokensOaiForId($id)
    {
        $db = MyormModel::dbc();
        // $auth = new \Delight\Auth\Auth($db);
        // $id = $auth->getUserId();

        $sth = $db->prepare("SELECT c_tokens, p_tokens FROM `users` WHERE `id` = ?");
        $sth->execute(array($id));
        $array = $sth->fetch(PDO::FETCH_ASSOC);
        return $array;
    }

    public static function getUserNew()
    {
        $db = MyormModel::dbc();
        $auth = new \Delight\Auth\Auth($db);
        $user_id = $auth->getUserId();
        $sql = "SELECT * FROM users WHERE id = :user_id";
        return DB::run($sql, ['user_id' => $user_id])->fetchAll();
    }

    public static function updateUserMeta($params)
    {
        $params_ins = $params;
        unset($params_ins['meta_value']);
        $result = '';
        $sql = "SELECT * FROM usermeta WHERE user_id = :user_id AND meta_key = :meta_key";
        $sql_result = DB::run($sql, $params_ins)->fetch();

        if ($sql_result) {
            $sql = "UPDATE usermeta SET meta_key = :meta_key, meta_value = :meta_value WHERE user_id = :user_id";
            DB::run($sql, $params);
            $result = 'update';
        } else {
            $sql = "INSERT INTO usermeta(user_id, meta_key, meta_value) VALUES(:user_id, :meta_key, :meta_value)";
            DB::run($sql, $params);
            $sql_last_id =  DB::run("SELECT LAST_INSERT_ID() as last_id")->fetch();
            $result = 'insert';
        }
        return $result;
    }

    public static function userAllDataMeta()
    {
        $db = MyormModel::dbc();
        $auth = new \Delight\Auth\Auth($db);
        $user_id = $auth->getUserId();

        $sql_user = "SELECT * FROM users WHERE id = :user_id";
        $user = DB::run($sql_user, ['user_id' => $user_id])->fetch();

        $sql_user_meta = "SELECT * FROM usermeta WHERE user_id = :user_id";
        $user_meta = DB::run($sql_user_meta, ['user_id' => $user_id])->fetchAll();

        if ($user_meta) {
            $um = [];
            foreach ($user_meta as $key => $meta) {
                $um[$meta['meta_key']] = $meta['meta_value'];
            }
            // array_push($user, ['meta' => $um]);
            $user['meta'] = $um;
        }
        return $user;
    }
}
