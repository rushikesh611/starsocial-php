<?php  
require_once 'header.php';
if (!$loggedin) die("</div></body></html>");
if (isset($_GET['view'])) $view = sanitizeString($_GET['view']);
else $view = $user;
if (isset($_POST['text']))
{
    $text = sanitizeString($_POST['text']);
    if ($text != "")
    {
        $pm = substr(sanitizeString($_POST['pm']) , 0, 1);
        $time = time();
        queryMysql("INSERT INTO messages VALUES(NULL, '$user',
'$view', '$pm', $time, '$text')");
    }
}
if ($view != "")
{
    if ($view == $user) $name1 = $name2 = "Your";
    else
    {
        $name1 = "<a href='members.php?view=$view'>$view</a>'s";
        $name2 = "$view's";
    }
    echo "<main class='px-6'><h3>$name1 Messages</h3>";
    // showProfile($view);
    echo <<<_END
    <div class="col-md-8 col-lg-12 con-main">            
    <div class="card con-card">
          <div class="card-header">
             <h5 class="card-title" style="color:black;">Type here to leave a message</h5>
          </div>
          <div class="card-body">
             <form method='post' action='messages.php?view=$view'>
                   <div class="form-check form-check-inline">
                      <input type='radio' name='pm' class="form-check-input" id='public' value='0' checked='checked'>
                      <label for="public" style="color:black;" class="form-check-label">Public</label>
                   </div>
                   <div class="form-check form-check-inline">
                      <input type='radio' class="form-check-input" name='pm' id='private' value='1'>
                      <label for="private" style="color:black;" class="form-check-label" >Private</label>
                   </div>
                   <div class="w-80 p-2">
                      <textarea name='text' style="width: 100%; max-width: 100%;"></textarea>
                   </div>
                   <div class="btn-toolbar mx-auto">
                      <div class="btn-group">                
                         <input data-transition='slide' class="btn btn-primary" type='submit' value='Post Message'>
                      </div>
                </form>
             </div>
       </div>
   </div> 
    <br>

_END;
    date_default_timezone_set('UTC');
    if (isset($_GET['erase']))
    {
        $erase = sanitizeString($_GET['erase']);
        queryMysql("DELETE FROM messages WHERE id=$erase AND recip='$user'");
    }
    $query = "SELECT * FROM messages WHERE recip='$view' ORDER BY time DESC";
    $result = queryMysql($query);
    $num = $result->num_rows;
    for ($j = 0;$j < $num;++$j)
    {
        echo <<< listview
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center" style="color: black;">
        listview;
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if ($row['pm'] == 0 || $row['auth'] == $user || $row['recip'] == $user)
        {
            echo date('M jS \'y g:ia:', $row['time']);
            echo " <a href='messages.php?view=" . $row['auth'] . "'>" . $row['auth'] . "</a> ";
            if ($row['pm'] == 0) echo "wrote: &quot;" . $row['message'] . "&quot; ";
            else echo "whispered: <span class='whisper'>&quot;" . $row['message'] . "&quot;</span> ";
            if ($row['recip'] == $user) echo "<a href='messages.php?view=$view" . "&erase=" . $row['id'] . "'>
                    <button type='button' class='btn btn-danger'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                    <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
                  </svg>
                    </button>
                </a>";
            echo "<br>";
            echo <<< continue
            </li>
            </ul>
            continue;
        }
    }
}
if (!$num) echo "<br><span class='info'>No messages yet</span><br><br>";
echo "<br><a data-role='button'
href='messages.php?view=$view'>Refresh messages</a>";
?>
 </main>
<footer class="mt-auto text-white-50">
    <p>All rights reserved.</p>
</footer>
</body>
</html>
