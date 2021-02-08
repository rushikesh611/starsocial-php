<?php
require_once 'header.php';
if (!$loggedin) die("</main> 
                        <footer class='mt-auto text-white-50'>
                            <p>All rights reserved.</p>
                        </footer>
                    </div>
                    </body>
                    </html>");
if (isset($_GET['view']))
{
    $view = sanitizeString($_GET['view']);
    if ($view == $user) $name = "Your";
    else $name = "$view's";
    echo "<main class='px-5'><h3>$name Profile</h3><br>";
    showProfile($view);
    echo "<a class='button' data-transition='slide'
href='messages.php?view=$view'>View $name messages</a>";
    die("</main> 
            <footer class='mt-auto text-white-50'>
                <p>All rights reserved.</p>
            </footer>
        </div>
        </body>
        </html>");
}
if (isset($_GET['add']))
{
    $add = sanitizeString($_GET['add']);
    $result = queryMysql("SELECT * FROM friends
WHERE user='$add' AND friend='$user'");
    if (!$result->num_rows) queryMysql("INSERT INTO friends VALUES ('$add', '$user')");
}
elseif (isset($_GET['remove']))
{
    $remove = sanitizeString($_GET['remove']);
    queryMysql("DELETE FROM friends WHERE user='$remove' AND friend='$user'");
}
$result = queryMysql("SELECT user FROM members ORDER BY user");
$num = $result->num_rows;
echo "<main class='px-5'> <h3>Other Members</h3><ul class='list-group'>";
for ($j = 0;$j < $num;++$j)
{
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if ($row['user'] == $user) continue;
    echo "<li class='list-group-item d-flex justify-content-between align-items-center' style='color: black !important;'><a data-transition='slide' href='members.php?view=" . $row['user'] . "'>" . $row['user'] . "</a>";
    $follow = "<button type='button' class='btn btn-primary btn-sm'>Follow</button>";
    $result1 = queryMysql("SELECT * FROM friends WHERE
user='" . $row['user'] . "' AND friend='$user'");
    $t1 = $result1->num_rows;
    $result1 = queryMysql("SELECT * FROM friends WHERE
user='$user' AND friend='" . $row['user'] . "'");
    $t2 = $result1->num_rows;
    if (($t1 + $t2) > 1) echo " &harr; is a mutual friend";
    elseif ($t1) echo " &larr; you are following";
    elseif ($t2)
    {
        echo " &rarr; is following you";
        $follow = "<button type='button' class='btn btn-primary btn-sm'>Recip</button>";
    }
    if (!$t1) echo "<a data-transition='slide'
href='members.php?add=" . $row['user'] . "'>$follow</a>";
    else echo "<a data-transition='slide'
href='members.php?remove=" . $row['user'] . "'><button type='button' class='btn btn-primary btn-sm'>Drop</button></a>";
}
?>
 </ul>
 </main>
<footer class="mt-auto text-white-50">
<p>All rights reserved.</p>
</footer>
</div>

</body>
</html>
