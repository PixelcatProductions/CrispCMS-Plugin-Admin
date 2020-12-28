<?php

/*
 * Copyright (C) 2020 Justin Back <jback@pixelcatproductions.net>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace crisp\plugin\admin;

use \PDO;
use \PDOException;
use \PDORow;
use \PDOStatement;

/**
 * Interact with Phoenix
 */
class Phoenix {

    private static ?PDO $Database_Connection = null;

    public function __construct() {
        self::initDB();
    }

    /**
     * Initiate the database, else Database_Connection is null :-)
     */
    private static function initDB() {
        $DB = new \crisp\core\Postgres();
        self::$Database_Connection = $DB->getDBConnector();
    }

    /**
     * Fetches all users from the database.
     */
    public static function fetchAll() {
        if (self::$Database_Connection === null) {
            self::initDB();
        }
        $statement = self::$Database_Connection->prepare("SELECT * FROM users");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function fetchByID($ID) {
        if (self::$Database_Connection === null) {
            self::initDB();
        }
        $statement = self::$Database_Connection->prepare("SELECT * FROM users WHERE id = :ID");
        $statement->execute(array(":ID" => $ID));

        if ($statement->rowCount() === 0) {
            return false;
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function fetchCaseCommentsDistinctSpam() {

        if (self::$Database_Connection === null) {
            self::initDB();
        }
        $statement = self::$Database_Connection->prepare("SELECT DISTINCT(user_id), case_id, id, summary FROM case_comments WHERE (summary LIKE '%<a href%' OR summary LIKE '%<a title%' OR summary LIKE '%<a herf%') AND id NOT IN (SELECT spammable_id FROM spams)");
        $statement->execute();

        if ($statement->rowCount() === 0) {
            return array();
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function fetchTopicCommentsDistinctSpam() {

        if (self::$Database_Connection === null) {
            self::initDB();
        }
        $statement = self::$Database_Connection->prepare("SELECT DISTINCT(user_id), topic_id, id, summary FROM topic_comments WHERE (summary LIKE '%<a href%' OR summary LIKE '%<a title%' OR summary LIKE '%<a herf%') AND id NOT IN (SELECT spammable_id FROM spams)");
        $statement->execute();

        if ($statement->rowCount() === 0) {
            return array();
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function fetchServiceCommentsDistinctSpam() {

        if (self::$Database_Connection === null) {
            self::initDB();
        }
        $statement = self::$Database_Connection->prepare("SELECT DISTINCT(user_id), service_id, id, summary FROM service_comments WHERE (summary LIKE '%<a href%' OR summary LIKE '%<a title%' OR summary LIKE '%<a herf%') AND id NOT IN (SELECT spammable_id FROM spams)");
        $statement->execute();

        if ($statement->rowCount() === 0) {
            return array();
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function fetchPointCommentsDistinctSpam() {

        if (self::$Database_Connection === null) {
            self::initDB();
        }
        $statement = self::$Database_Connection->prepare("SELECT DISTINCT(user_id), point_id, id, summary FROM point_comments WHERE (summary LIKE '%<a href%' OR summary LIKE '%<a title%' OR summary LIKE '%<a herf%') AND id NOT IN (SELECT spammable_id FROM spams)");
        $statement->execute();

        if ($statement->rowCount() === 0) {
            return array();
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function fetchCaseCommentsByUser($ID) {
        if (self::$Database_Connection === null) {
            self::initDB();
        }
        $statement = self::$Database_Connection->prepare("SELECT * FROM case_comments WHERE user_id = :ID AND id NOT IN (SELECT spammable_id FROM spams)");
        $statement->execute(array(":ID" => $ID));

        if ($statement->rowCount() === 0) {
            return array();
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function fetchDocumentCommentsByUser($ID) {
        if (self::$Database_Connection === null) {
            self::initDB();
        }
        $statement = self::$Database_Connection->prepare("SELECT * FROM document_comments WHERE user_id = :ID AND id NOT IN (SELECT spammable_id FROM spams)");
        $statement->execute(array(":ID" => $ID));

        if ($statement->rowCount() === 0) {
            return array();
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function fetchTopicCommentsByUser($ID) {
        if (self::$Database_Connection === null) {
            self::initDB();
        }
        $statement = self::$Database_Connection->prepare("SELECT * FROM topic_comments WHERE user_id = :ID AND id NOT IN (SELECT spammable_id FROM spams)");
        $statement->execute(array(":ID" => $ID));

        if ($statement->rowCount() === 0) {
            return array();
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function fetchPointCommentsByUser($ID) {
        if (self::$Database_Connection === null) {
            self::initDB();
        }
        $statement = self::$Database_Connection->prepare("SELECT * FROM point_comments WHERE user_id = :ID AND id NOT IN (SELECT spammable_id FROM spams)");
        $statement->execute(array(":ID" => $ID));

        if ($statement->rowCount() === 0) {
            return array();
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function isInSpams($ID, $Type) {
        if (self::$Database_Connection === null) {
            self::initDB();
        }
        $statement = self::$Database_Connection->prepare("SELECT * FROM spams WHERE spammable_id = :ID AND spammable_type = :Type;");
        $statement->execute(array(":ID" => $ID, ":Type" => $Type));

        if ($statement->rowCount() === 0) {
            return array();
        }
        return true;
    }

    public static function fetchSpams() {
        if (self::$Database_Connection === null) {
            self::initDB();
        }
        $statement = self::$Database_Connection->prepare("SELECT * FROM spams;");
        $statement->execute();

        if ($statement->rowCount() === 0) {
            return array();
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function fetchServiceCommentsByUser($ID) {
        if (self::$Database_Connection === null) {
            self::initDB();
        }
        $statement = self::$Database_Connection->prepare("SELECT * FROM service_comments WHERE user_id = :ID AND id NOT IN (SELECT spammable_id FROM spams)");
        $statement->execute(array(":ID" => $ID));

        if ($statement->rowCount() === 0) {
            return array();
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function addSpamComment($ID, $Type) {
        if (self::$Database_Connection === null) {
            self::initDB();
        }
        $statement = self::$Database_Connection->prepare("INSERT INTO spams (spammable_type, spammable_id, flagged_by_admin_or_curator, created_at, updated_at) VALUES (:Type, :ID, true, NOW(), NOW())");
        $statement->execute(array(":ID" => $ID, ":Type" => $Type));

        if ($statement->rowCount() === 0) {
            return false;
        }

        return true;
    }

    public static function fetchByEmail($Email) {
        if (self::$Database_Connection === null) {
            self::initDB();
        }
        $statement = self::$Database_Connection->prepare("SELECT * FROM users WHERE email = :Email");
        $statement->execute(array(":Email" => $Email));

        if ($statement->rowCount() === 0) {
            return false;
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function fetchByUsername($Username) {
        if (self::$Database_Connection === null) {
            self::initDB();
        }
        $statement = self::$Database_Connection->prepare("SELECT * FROM users WHERE username = :Username");
        $statement->execute(array(":Username" => $Username));

        if ($statement->rowCount() === 0) {
            return false;
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

}
