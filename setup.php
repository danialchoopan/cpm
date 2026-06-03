<?php

if (php_sapi_name() !== 'cli') {
    die("This script must be run from the CLI.\n");
}

echo "--- CPM Car System Setup ---\n";

function ask($question, $default = '') {
    $prompt = $default ? "[$default]" : "";
    echo "$question $prompt: ";
    $input = trim(fgets(STDIN));
    return $input ?: $default;
}

$db_type = ask("Database Type (sqlite/mysql)", "sqlite");
$env_content = "DB_CONNECTION=$db_type\n";

if ($db_type === 'mysql') {
    $db_host = ask("MySQL Host", "localhost");
    $db_name = ask("Database Name", "cpm");
    $db_user = ask("Database Username", "root");
    $db_pass = ask("Database Password", "");

    $env_content .= "DSN_PDO=mysql:host=$db_host;dbname=$db_name;charset=utf8mb4\n";
    $env_content .= "USERNAME_DB=$db_user\n";
    $env_content .= "PASSWORD_DB=$db_pass\n";
} else {
    $db_path = ask("SQLite DB Path (relative to root)", "database.sqlite");
    $full_path = realpath(__DIR__) . '/' . $db_path;
    $env_content .= "DB_DATABASE=$full_path\n";

    // Create sqlite file if not exists
    if (!file_exists($full_path)) {
        touch($full_path);
    }
}

$site_url = ask("Site URL", "http://localhost:8000/");
if (substr($site_url, -1) !== '/') $site_url .= '/';
$env_content .= "SITE_URL=$site_url\n";

// Add dummy Mailgun keys for now
$env_content .= "MAILGUN_API_KEY=key-xxxx\n";
$env_content .= "MAILGUN_DOMAIN_NAME=mg.example.com\n";
$env_content .= "KAVENEGAR_API_KEY=xxxx\n";

file_put_contents('.env', $env_content);
echo ".env file created successfully.\n";

echo "Running migrations and seeding...\n";
require_once 'vendor/autoload.php';

// Load env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// We need a way to run the SQL. We'll use a temporary class that extends DatabaseConnection.
require_once 'app/database/DatabaseConnection.php';

class Migrator extends \App\database\DatabaseConnection {
    public function run($sql) {
        try {
            // Split SQL by semicolon, but be careful with strings.
            // Simple split for this specific seed file.
            $statements = explode(';', $sql);
            foreach ($statements as $stmt) {
                $stmt = trim($stmt);
                if ($stmt) {
                    $this->databaseConnection->exec($stmt);
                }
            }
            return true;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
            return false;
        }
    }
}

$sql = file_get_contents('app/database/seed_data.sql');

// Handle cross-database SQL compatibility
if ($db_type === 'mysql') {
    $sql = str_replace('AUTOINCREMENT', 'AUTO_INCREMENT', $sql);
}

$migrator = new Migrator();
if ($migrator->run($sql)) {
    echo "Database setup completed successfully!\n";
} else {
    echo "Database setup failed.\n";
}

echo "Setup finished. You can now run: php -S localhost:8000 -t public\n";
