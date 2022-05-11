<?php
include_once MODX_CORE_PATH . 'components/custom/functions/helper.php';

$homepage = getWebsiteUrl();
$profilepage = $homepage . '/profile.html';
$user = $modx->getAuthenticatedUser('web');

/** 
 * Check if the user is already authorized.
 * If it's true redirect him to the home page.
 * 
 */
if ($user) {
    header("location: $homepage");
}

/**
 * Check request method
 * Init the login fields
 * Check password matching
 * Call register user function
 */
if ($_POST) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];

    $passwordMatch = checkPassword($modx, $password, $confirmpassword);

    if(!$passwordMatch) {
        return;
    }

    registerUser($modx, $profilepage, $password, $email, $username);
}

/**
 * Check if password matches
 *
 * @param Object $modx
 * @param String $password
 * @param String $confirmpassword
 * @return Bool
 */
function checkPassword(Object $modx, String $password, String $confirmpassword): Bool
{
    if ($password === $confirmpassword) {
        return true;
    }
    $msg = 'Пароли не совпадают';
    getMessageChunk($modx, $msg, 'danger');
    return false;
}

/**
 * Render message
 *
 * @param Object $modx
 * @param String $msg
 * @param String $type
 * @return void
 */
function getMessageChunk(Object $modx, String $msg, String $type = 'info')
{
    $output = $modx->getChunk('message', array(
        'msg' => $msg,
        'type' => $type
    ));
    echo $output;
}

/**
 * Register user
 *
 * @param Object $modx
 * @param String $profilepage
 * @param String $password
 * @param String $email
 * @param String $username
 * @return void
 */
function registerUser(Object $modx, String $profilepage, String $password, String $email, String $username)
{
    $fields = array();
    $fields['active'] = true;
    $fields['username'] =  $username;
    $fields['password'] = $password;
    $fields['passwordnotifymethod'] = 'e';
    $fields['email'] = $email;

    $response = $modx->runProcessor('security/user/create', $fields);

    if ($response->isError()) {
        $error = $response->getResponse()['errors'];
        $msg = $error[0]['msg'];
        getMessageChunk($modx, $msg, 'danger');
        return;
    }

    $success = $response->getResponse()['success'];

    if($success) {
        header("location: $profilepage");
    }
}