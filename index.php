<?php
session_start();
require_once 'header.php';
// if ($loggedin) echo " $user, you are logged in";
// else echo ' please sign up or log in';
echo <<<_END
        <main class="px-3">
            <h1>Influence and inspire.</h1>
            <p class="mt-auto text-white-50">(You must be logged in to use this app)</p>
            <p class="lead">
            <a href="login.php" class="btn btn-lg btn-secondary fw-bold border-white bg-white">Connect</a>
            </p>
        </main>
        <footer class="mt-auto text-white-50">
            <p>Thank you for visiting. All rights reserved.</p>
        </footer>
    </div>
    </body>
    </html>
 _END;

?>
