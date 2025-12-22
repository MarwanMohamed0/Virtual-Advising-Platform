    <?php
    /**
     * Database Configuration for MashouraX Virtual Advising Platform
     * 
     * This file contains database connection settings and utility functions
     */

    // Database configuration
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'mashourax_platform');
    define('DB_USER', 'root'); // Change this to your MySQL username
    define('DB_PASS', ''); // Change this to your MySQL password
    define('DB_CHARSET', 'utf8mb4');

    // PDO options
    $pdo_options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET
    ];

    /**
     * Get database connection
     * @return PDO Database connection object
     */
    function getDBConnection() {
        global $pdo_options;
        
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $pdo_options);
            return $pdo;
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            die("Database connection failed. Please check your configuration.");
        }
    }

    /**
     * Test database connection
     * @return bool True if connection successful, false otherwise
     */
    function testDBConnection() {
        try {
            $pdo = getDBConnection();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Initialize database tables
     * This function should be called once during setup
     */
    function initializeDatabase() {
        try {
            $pdo = getDBConnection();
            
            // Read and execute the schema file
            $schema = file_get_contents(__DIR__ . '/../database_schema.sql');
            $statements = explode(';', $schema);
            
            foreach ($statements as $statement) {
                $statement = trim($statement);
                if (!empty($statement)) {
                    $pdo->exec($statement);
                }
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Database initialization failed: " . $e->getMessage());
            return false;
        }
    }
    ?>
