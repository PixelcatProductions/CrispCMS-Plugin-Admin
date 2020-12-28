<?php

include __DIR__ . '/Phoenix.php';

echo "Cron for admin plugin" . PHP_EOL;
switch ($_CRON["Data"]->name) {
    case "spam_by_comments":
        echo "Cleaning spam comments" . PHP_EOL;

        $PointComments = crisp\plugin\admin\Phoenix::fetchPointCommentsDistinctSpam();

        foreach ($PointComments as $Comment) {
            echo "Added $Comment[id] to Spam!" . PHP_EOL;
            $Array[] = (crisp\plugin\admin\Phoenix::addSpamComment($Comment["id"], "PointComment"));
        }



        $CaseComments = crisp\plugin\admin\Phoenix::fetchCaseCommentsDistinctSpam();

        foreach ($CaseComments as $Comment) {
            echo "Added $Comment[id] to Spam!" . PHP_EOL;
            $Array[] = (crisp\plugin\admin\Phoenix::addSpamComment($Comment["id"], "CaseComment"));
        }


        $TopicComments = crisp\plugin\admin\Phoenix::fetchTopicCommentsDistinctSpam();

        foreach ($TopicComments as $Comment) {
            echo "Added $Comment[id] to Spam!" . PHP_EOL;
            $Array[] = (crisp\plugin\admin\Phoenix::addSpamComment($Comment["id"], "TopicComment"));
        }
        

        $ServiceComments = crisp\plugin\admin\Phoenix::fetchServiceCommentsDistinctSpam();

        foreach ($ServiceComments as $Comment) {
            echo "Added $Comment[id] to Spam!" . PHP_EOL;
            $Array[] = (crisp\plugin\admin\Phoenix::addSpamComment($Comment["id"], "ServiceComment"));
        }
        echo count($Array) . " comments marked as spam!" . PHP_EOL;

        break;
}
