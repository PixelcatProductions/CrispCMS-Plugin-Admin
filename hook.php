<?php

/*
 * Copyright 2020 Pixelcat Productions <support@pixelcatproductions.net>
 * @author 2020 Justin René Back <jback@pixelcatproductions.net>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

$this->registerUninstallHook(function($Callback) {
    echo "Removing SQL Tables" . PHP_EOL;
    $SQL = "DROP TABLE `Sessions`;";

    echo $SQL . PHP_EOL;

    $Mysql = new \crisp\core\MySQL();

    $DB = $Mysql->getDBConnector();

    $DB->beginTransaction();

    $DB->query($SQL);

    $DB->commit();
});
include __DIR__ . '/includes/Users.php';
include __DIR__ . '/includes/PhoenixUser.php';

if (CURRENT_UNIVERSE == \crisp\Universe::UNIVERSE_TOSDR) {
    \crisp\core\Theme::addtoNavbar("admin", '<span class="badge badge-danger"><i class="fas fa-shield-alt"></i> ADMIN</span>', "/admin_dashboard", "_self", -1, "right");
} else {
    \crisp\core\Theme::addtoNavbar("login", $this->getTranslation("login"), "/login", "_self", 99);
}

if (isset($_SESSION[\crisp\core\Config::$Cookie_Prefix . "session_login"])) {

    $User = new \crisp\plugin\admin\PhoenixUser($_SESSION[\crisp\core\Config::$Cookie_Prefix . "session_login"]["User"]);

    if (!$User->isSessionValid() || CURRENT_UNIVERSE !== crisp\Universe::UNIVERSE_TOSDR) {
        unset($_SESSION[\crisp\core\Config::$Cookie_Prefix . "session_login"]);
        crisp\Universe::changeUniverse(crisp\Universe::UNIVERSE_PUBLIC);
    }
}
