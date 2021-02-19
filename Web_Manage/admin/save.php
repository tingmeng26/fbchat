<?php
include('_config.php');
$errorhandle = new coderErrorHandle();
try {
    $id = post('id');
    if ($id > 0) {
        $method = 'edit';
        $active = '編輯';
    } else {
        $method = 'add';
        $active = '新增';
        $fhelp->setAttr('username', 'validate', array('required' => 'yes', 'maxlength' => '20', 'minlength' => 3));
        $fhelp->setAttr('password', 'validate', array('required' => 'yes', 'maxlength' => '20', 'minlength' => 6));
    }
    $data = $fhelp->getSendData();
    $error = $fhelp->vaild($data);

    if (count($error) > 0) {
        $msg = implode('\r\n', $error);
        throw new Exception($msg);
    }

    if (isset($data['auth'])) {
        $_auth = array_sum(explode(',', $data['auth']));
        $data['auth'] = $_auth;
    }

    $data['admin'] = $adminuser['username'];
    $data['updatetime'] = datetime();

    if (!coderAdmin::isAuth('admin')) {
        unset($data['ispublic']);
        unset($data['isadmin']);
        unset($data['auth']);
        unset($data['branch_auth']);
    }

    $db = Database::DB();
    if ($method == 'edit') {
        $s_username = $adminuser['username'];
        $username = post('username', 1);
        unset($data['username']);

        if ($data['password'] == '') {
            unset($data['password']);
        } else {
            $data['password'] = sha1($data['password']);
        }

        $db->query_update($table, $data, " id=:id ", array(':id' => $id));
        if ($s_username === $username) {
            coderAdmin::change_admin_data($username);
        }
    } else {
        $username = $data['username'];
        $email = $data['email'];
        $data['password'] = sha1($data['password']);
        if ($db->isExisit($table, 'username', $username)) {
            throw new Exception('帳號' . $username . '重覆,請重新輸入一組帳號');
        }
        if ($db->isExisit($table, 'email', $email)) {
            throw new Exception('E-mail' . $email . '重覆,請重新輸入一組E-mail');
        }
        $data['mid'] = getmid();
        $id = $db->query_insert($table, $data);
    }
    echo showParentSaveNote($auth['name'], $active, $username, "manage.php?username={$username}&id={$id}");
    coderAdminLog::insert($adminuser['username'], $logkey, $method, $username);
    $db->close();
} catch (Exception $e) {
    $errorhandle->setException($e); // 收集例外
}

if ($errorhandle->isException()) {
    $errorhandle->showError();
}

function getmid()
{
    global $db, $table;
    $mid = md5(uniqid(rand()));
    if ($db->isExisit($table, 'mid', $mid)) {
        return getmid();
    } else {
        return $mid;
    }
}

?>