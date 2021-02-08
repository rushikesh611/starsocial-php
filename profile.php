<?php
require_once 'header.php';
if (!$loggedin) die("
                    <footer class='mt-auto text-white-50'>
                        <p>All rights reserved.</p>
                    </footer>
                    </body>
                    </html>
");
echo "<h3>Your Profile</h3>";
$result = queryMysql("SELECT * FROM profiles WHERE user='$user'");
if (isset($_POST['text']))
{
    $text = sanitizeString($_POST['text']);
    $text = preg_replace('/\s\s+/', ' ', $text);
    if ($result->num_rows) queryMysql("UPDATE profiles SET text='$text' where user='$user'");
    else queryMysql("INSERT INTO profiles VALUES('$user', '$text')");
}
else
{
    if ($result->num_rows)
    {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $text = stripslashes($row['text']);
    }
    else $text = "";
}
$text = stripslashes(preg_replace('/\s\s+/', ' ', $text));
if (isset($_FILES['image']['name']))
{
    $saveto = "$user.jpg";
    move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
    $typeok = true;
    switch ($_FILES['image']['type'])
    {
        case "image/gif":
            $src = imagecreatefromgif($saveto);
        break;
        case "image/jpeg": // Both regular and progressive jpegs
            
        case "image/pjpeg":
            $src = imagecreatefromjpeg($saveto);
        break;
        case "image/png":
            $src = imagecreatefrompng($saveto);
        break;
        default:
            $typeok = false;
        break;
    }
    if ($typeok)
    {
        list($w, $h) = getimagesize($saveto);
        $max = 100;
        $tw = $w;
        $th = $h;
        if ($w > $h && $max < $w)
        {
            $th = $max / $w * $h;
            $tw = $max;
        }
        elseif ($h > $w && $max < $h)
        {
            $tw = $max / $h * $w;
            $th = $max;
        }
        elseif ($max < $w)
        {
            $tw = $th = $max;
        }
        $tmp = imagecreatetruecolor($tw, $th);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
        imageconvolution($tmp, array(
            array(-1, -1, -1
            ) ,
            array(-1,
                16, -1
            ) ,
            array(-1, -1, -1
            )
        ) , 8, 0);
        imagejpeg($tmp, $saveto);
        imagedestroy($tmp);
        imagedestroy($src);
    }
}
showProfile($user);
echo <<<_END
        <main class="px-7">
        <div class="card">
        <div class="card-body">
        <form data-ajax='false' method='post' action='profile.php' enctype='multipart/form-data'>
                    <div class="mb-3">
                        <label class="form-label" style='color: black !important;'>Enter or edit your details and/or upload an image</label>
                        <br>
                        <textarea class="form-control" name='text'>$text</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style='color: black !important;'>Image</label>
                        <input type="file" name='image' size='10' class="form-control">
                    </div>
                    <button type="submit" value='Save Profile' class="btn btn-primary">Save Profile</button>
                </form>
        </div>
        </div>
    </main>
    <footer class="mt-auto text-white-50">
        <p>All rights reserved.</p>
    </footer>
</div>
</body>
</html>
_END;
?>

