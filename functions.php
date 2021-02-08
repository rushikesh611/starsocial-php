<?php
$dbhost = 'localhost';
$dbname = 'starsocial';
$dbuser = 'root';
$dbpass = '';

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error) die("Fatal Error");

function createTable($name, $query)
{
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists.<br>";
}

function queryMysql($query)
{
    global $connection;
    $result = $connection->query($query);
    if (!$result) die("Fatal Error");
    return $result;
}

function destroySession()
{
    $_SESSION = array();
    if (session_id() != "" || isset($_COOKIE[session_name() ])) setcookie(session_name() , '', time() - 2592000, '/');
    session_destroy();
}

function sanitizeString($var)
{
    global $connection;
    $var = strip_tags($var);
    $var = htmlentities($var);
    // if (get_magic_quotes_gpc()) $var = stripslashes($var);
    return $connection->real_escape_string($var);
}

function showProfile($user)
{
    if (file_exists("$user.jpg")) 
    echo <<< profile
    <main class="px-7">
    <div class="card mb-3" style="max-width: 606px;">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="$user.jpg" alt="Profile Picture">
            </div>
        <div class="col-md-8">
        <div class="card-body">
        <h5 class="card-title" style='color: black;'></h5>
        <p class="card-text" style='color: black;'>
    profile;
    $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");
    if ($result->num_rows)
    {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo stripslashes($row['text']) . '</p>';
    }
    else echo "<p>Nothing to see here, yet</p><br>";
    echo <<< continue
        </div>
        </div>
    </div>
    </div>
    </main>
continue;
}
?>

      
        
        
      