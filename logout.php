<?php
require_once 'header.php';
if (isset($_SESSION['user']))
{
    destroySession();
    echo "<main class='px-5'><div class='center'>You have been logged out. Please
<a data-transition='slide' href='index.php'>click here</a>
to refresh the screen.</div>
            </main> 
            <footer class='mt-auto text-white-50'>
            <p>Thank you for visiting. All rights reserved.</p>
        </footer>
    </div>
    </body>
    </html>";
}
else echo "<main class='px-5'><div class='center'>You cannot log out because
 you are not logged in</div>
 </main> 
            <footer class='mt-auto text-white-50'>
            <p>Thank you for visiting. All rights reserved.</p>
        </footer>
    </div>
    </body>
    </html>";
?>
  </div>
  </body>
 </html>
