<?php
$config = __DIR__ . '/../config/config.php';
$apiClientConfigDist = __DIR__ . '/../config/api-client-config.php.dist';

if (!file_exists($config)) {
    copy($apiClientConfigDist, $config);
}