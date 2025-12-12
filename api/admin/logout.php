<?php
require_once __DIR__ . '/../../server/config.php';
session_destroy();
json_out(['ok'=>true]);
