<?php

function sendQuery ($sql) {
    try {
        $db = Pimcore_Resource::get();
        $db->query($sql);
    } catch (Exception $e) {
        echo $e->getMessage();
        echo "Please execute the following query manually: <br />";
        echo "<pre>" . $sql . "</pre><hr />";
    }
}

sendQuery("RENAME TABLE `events` TO `pimcore`.`notes`;");
sendQuery("RENAME TABLE `events_data` TO `pimcore`.`notes_data`;");
