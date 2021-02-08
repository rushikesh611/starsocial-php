<?php
require_once 'header.php';
$error = $user = $pass = "";
if (isset($_POST['user']))
{
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
    if ($user == "" || $pass == "") $error = 'Not all fields were entered';
    else
    {
        $result = queryMySQL("SELECT user,pass FROM members
WHERE user='$user' AND pass='$pass'");
        if ($result->num_rows == 0)
        {
            $error = "Invalid login attempt";
        }
        else
        {
            $_SESSION['user'] = $user;
            $_SESSION['pass'] = $pass;
            die("<main class='px-5'>You are now logged in. Please <a data-transition='slide'
            href='members.php?view=$user'>click here</a> to continue.
            </main> 
            <footer class='mt-auto text-white-50'>
            <p>Thank you for visiting. All rights reserved.</p>
        </footer>
    </div>
    </body>
    </html>");
        }
    }
}

echo <<<_END

    
    <main class="px-5">
      <form method='post' action='login.php'>
        <div data-role='fieldcontain'>
          <label></label>
          <span class='error'>$error</span>
        </div>
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" maxlength='16' name='user' value='$user' id="username" placeholder="username">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" maxlength='16' name='pass' value='$pass' id="password" placeholder="password">
        </div>
        <div id="emailHelp" class="form-text">We'll never share your details with anyone else.</div>
        <br>
        <button data-transition='slide' value='Login' type="submit" class="btn btn-primary">Login</button>
      </form>
    </main>
    <footer class="mt-auto text-white-50">
    <p>Thank you for visiting. All rights reserved.</p>
    </footer>
    </div>

    </body>
    </html>

_END;

?>
