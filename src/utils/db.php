<?php
// echo "<p>hellooooo from db.php!</p>";

$db_host = getenv("DB_HOST");
$db_name = getenv("DB_NAME");
$db_user = getenv("DB_USER");
$db_pass = getenv("DB_PASSWORD");

$errorMessages = [];
$successMessages = [];

try {

    $dbConnection = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
    $msg = "Connected successfully";
    array_push($successMessages, $msg);
} catch (PDOException $e) {
    // echo $e->getMessage();
    $msg = $e->getMessage();
    array_push($errorMessages, $msg);
}

try {

    $sqlCreateTable = "CREATE TABLE IF NOT EXISTS `users` (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30) NOT NULL,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(50),
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    $sqlDropTable = "DROP TABLE IF EXISTS users";

    $sqlAlterTable = "ALTER TABLE `users` ADD COLUMN `avatar` VARCHAR(255) NULL AFTER `email`";
    $sqlDropColumn = "ALTER TABLE `users` DROP COLUMN `avatar`";


    $sqlQueryType = "CREATE TABLE";

    switch ($sqlQueryType) {
        case "CREATE TABLE":
            $sql = $sqlCreateTable;
            break;
        case "ALTER TABLE":
            $sql = $sqlAlterTable;
            break;
        case "DROP TABLE":
            $sql = $sqlDropTable;
            break;
        case "DROP COLUMN":
            $sql = $sqlDropColumn;
            break;
        default:
            $sql = null;
    }

    if ($sql) {
        $dbConnection->exec($sql);
        // echo "action $sqlQueryType done successfully";
        $msg = "action $sqlQueryType done successfully";
        array_push($successMessages, $msg);
    } else {
        // echo "no action taken";
        $msg = "no action taken";
        array_push($errorMessages, $msg);
    }
} catch (PDOException $e) {
    // echo $e->getMessage();
    $msg = $e->getMessage();
    array_push($errorMessages, $msg);
}

function addUser($username, $password, $email, $conn)
{
    $dbConnection = $conn;
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    try {
        // check if user exists
        $checkUserQuery = "SELECT COUNT(*) FROM users WHERE username = :username";
        $checkUserStmt = $dbConnection->prepare($checkUserQuery);
        $checkUserStmt->bindParam(':username', $username);
        $checkUserStmt->execute();
        $userExists = $checkUserStmt->fetchColumn();

        if ($userExists) {

            // echo "Username already exists";
            return [
                "status" => "error",
                "message" => "Username already exists"
            ];
        } else {
            // if not, add user
            $sql = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
            $stmt = $dbConnection->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password_hash);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // echo "User added successfully";
            return [
                "status" => "success",
                "message" => "User added successfully"
            ];
        }
    } catch (PDOException $e) {
        // echo $e->getMessage();
        $msg = $e->getMessage();
        return [
            "status" => "error",
            "message" => $msg
        ];
    }
}

$res = addUser("NextUser", "test", "email@mail.com", $dbConnection);

if ($res["status"] === "error") {
    array_push($errorMessages, $res["message"]);
} else if ($res["status"] === "success") {
    array_push($successMessages, $res["message"]);
}

function displayMessages(string $status, array $messages)
{

    echo "<h3>$status:</h3>";
    echo "<ul>";
    foreach ($messages as $message) {
        echo "<li>$message</li>";
    }
    echo "</ul>";
}

if ($successMessages) {
    displayMessages("Errors", $errorMessages);
}

if ($errorMessages) {
    displayMessages("Success", $successMessages);
}

function login($username, $password, $conn)
{

    $dbConnection = $conn;

    $sanetizedUsername = filter_var($username, FILTER_SANITIZE_STRING);
    $sanetizedPassword = filter_var($password, FILTER_SANITIZE_STRING);

    try {
        // check if user exists
        $checkUserQuery = "SELECT * FROM users WHERE username = :username";
        $checkUserStmt = $dbConnection->prepare($checkUserQuery);
        $checkUserStmt->bindParam(':username',  $sanetizedUsername);
        $checkUserStmt->execute();
        $user = $checkUserStmt->fetch();

        if (!$user) {
            // echo "Username doesn't exist";
            return false;
        }

        $loginCorrect = password_verify($sanetizedPassword, $user["password"]);
        if ($loginCorrect) {
            // echo "Login successful";
            return true;
        } else {
            // echo "Login failed";
            return false;
        }
    } catch (PDOException $e) {
        // echo $e->getMessage();
        return false;
    }
}

if (login("NextUser", "test", $dbConnection)) {
    echo "login successful";
} else {
    echo "login failed";
}
