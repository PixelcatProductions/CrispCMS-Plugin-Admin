<?php

if (isset($_SESSION[\crisp\core\Config::$Cookie_Prefix . "session_login"])) {

    $User = new \crisp\plugin\admin\PhoenixUser($_SESSION[\crisp\core\Config::$Cookie_Prefix . "session_login"]["User"]);

    if (!$User->isSessionValid() || CURRENT_UNIVERSE != crisp\Universe::UNIVERSE_TOSDR) {
        unset($_SESSION[\crisp\core\Config::$Cookie_Prefix . "session_login"]);
        header("Location: /login?oldtoken=" . $_SESSION[\crisp\core\Config::$Cookie_Prefix . "session_login"]["Token"]);
        exit;
    }
    header("Location: /admin_dashboard");
    exit;
}
