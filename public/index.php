<?php
/**
 * Created by PhpStorm.
 * User: krsnaa
 * Date: 3/9/16
 * Time: 3:59 PM
 */

require_once '../vendor/autoload.php';

echo 'hello world';

$database = new medoo([
    'database_type' => 'sqlite',
    'database_file' => '../storage/database.db'
]);

dump($database);