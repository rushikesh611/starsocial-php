<?php
require_once 'header.php';
echo <<<_END
<script>
  function checkUser(user)
    {
    if (user.value == '')
    {
    $('#used').html('&nbsp;')
    return
    }
    $.post
    (
    'checkuser.php',
    { user : user.value },
    function(data)
    {
    $('#used').html(data)
    }
    )
  }
</script>
_END;
$error = $user = $pass = "";
if (isset($_SESSION['user'])) destroySession();
if (isset($_POST['user']))
{
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
    if ($user == "" || $pass == "") $error = 'Not all fields were entered<br><br>';
    else
    {
        $result = queryMysql("SELECT * FROM members WHERE user='$user'");
        if ($result->num_rows) $error = 'That username already exists<br><br>';
        else
        {
            queryMysql("INSERT INTO members VALUES('$user', '$pass')");
            die('<h4>Account created</h4>Please log in.</div></body></html>');
        }
    }
}
echo <<<_END

    <main class="px-5">
<form method='post' action='signup.php'>$error
  <div data-role='fieldcontain'>
    <label></label>
    Please enter your details to sign up
  </div>
  <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" maxlength='16' name='user' value='$user' placeholder="username" onBlur="checkUser(this)">
    <label style="color: white;"></label><div id='used'></div>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" maxlength='16' name='pass' value='$pass' placeholder="password">
  </div>
  <br>
  <button data-transition='slide' value='Sign Up' type="submit" class="btn btn-primary">Sign Up</button>
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


