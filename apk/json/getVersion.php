<?php

require_once 'connect_db.php';
require 'useful_functions.php';
$fetch = array();

$fetch['application_version']['av'] = getVersionOfApk();
echo json_encode($fetch);