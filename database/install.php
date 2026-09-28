<?php
/**
 * php database/install.php
 * Creates the database (if missing) and runs database/schema.sql against the
 * 'first' connection from config/database.php. Re-runnable: a statement that
 * fails (e.g. table already exists) is reported and skipped, not fatal.
 */
define('ROOT_PATH', dirname(__DIR__) . '/');
require ROOT_PATH . 'vendor/autoload.php';
require_once ROOT_PATH . 'config.php';

use Easysite\Library\Config;

$db = Config::get('database')->getConfigByAliase('first');
if (!$db) {
    fwrite(STDERR, "No 'first' connection in config/database.php\n");
    exit(1);
}

$pdo = new PDO(
    sprintf('mysql:host=%s;port=%s;charset=%s', $db->getHost(), $db->getPort(), $db->getCharset()),
    $db->getUserName(),
    $db->getPassword(),
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$dbName = $db->getDbName();
$pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4");
$pdo->exec("USE `{$dbName}`");

$sql = file_get_contents(ROOT_PATH . 'database/schema.sql');
foreach (array_filter(array_map('trim', explode(';', $sql))) as $statement) {
    try {
        $pdo->exec($statement);
        echo "OK: " . strtok($statement, "\n") . "\n";
    } catch (PDOException $e) {
        echo "SKIP: " . $e->getMessage() . "\n";
    }
}

echo "Done.\n";
