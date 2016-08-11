<?php
$retrive = new DB_retrival;
echo consolemenu();
echo '<div id="page"><div class="center">Welcome '; echo $retrive->realname($_COOKIE['userID']); echo '!
<br />
<br />Please select an option above to continue.</div></div>'
?>