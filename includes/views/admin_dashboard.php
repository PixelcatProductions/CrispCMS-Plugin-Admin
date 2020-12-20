<?php

if (!isset($_SESSION[\crisp\core\Config::$Cookie_Prefix . "session_login"])) {
    header("Location: /login");
    exit;
}

$User = new crisp\plugin\admin\User($_SESSION[\crisp\core\Config::$Cookie_Prefix . "session_login"]["User"]);

if (!$User->isSessionValid() || CURRENT_UNIVERSE != crisp\Universe::UNIVERSE_TOSDR) {
    header("Location: /login?oldtoken=" . $_SESSION[\crisp\core\Config::$Cookie_Prefix . "session_login"]["Token"]);
    exit;
}