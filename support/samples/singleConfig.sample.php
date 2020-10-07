<?php

/* Auto Generate Complete Config File */
if (!file_exists(__ROOT__ . '/var/cache/config.php')) {
  ConfigCollector::generateFile('config', '/var/cache/config.php', __ROOT__ . '/.env');
}

/* Load the Complete Config */
$config = require __ROOT__ . '/var/cache/config.php';

/* Dynamically Loaded Config Files */
$config = mergeConfigEnv(__ROOT__ . '/config/config.php', __ROOT__ . '/.env');
