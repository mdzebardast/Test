<?php
 //------------------check login-------------------------------------------------
$ClientString = $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'];
    if(isset($_SESSION['UserName']) && $_SESSION['ClientStr'] == md5($ClientString)):
?>
<div class="Menu">
<table> <tr><td height="23"> </td></tr>

	<ul title="منوي اصلي"  class="mainmenu">

        <tr><td class="menuitem"><a href="cp/index.php">ثبت موقعيت</a></td></tr>
		<tr><td class="menuitem"><a href="cp/street.php">ثبت خيابان</a></td></tr>
		<tr><td class="menuitem"><a href="cp/group.php">ثبت گروه</a></td></tr>
		<tr><td class="menuitem"><a href="cp/editposition.php">نمايش موقعيت(ويرايش)</a></td></tr>
    </ul>

</table>
</div>






<div class="settingmenu">
<table>
<tr><td height="24"> </td></tr>
<ul title="منوي تنظيمات"  class="settingmenu">
	<form method='post' action='index.php' ><tr><td><input type='submit' value='خروج' class="menuitem" name='btnlogout' /></td></tr></form>
</ul>
</table>
</div>
<?php endif; //else  :  header( "location: index.php" );     exit();   endif;    ?>