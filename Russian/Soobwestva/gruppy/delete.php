<?
include_once '../sys/inc/start.php';
include_once '../sys/inc/compress.php';
include_once '../sys/inc/sess.php';
include_once '../sys/inc/home.php';
include_once '../sys/inc/settings.php';
include_once '../sys/inc/db_connect.php';
include_once '../sys/inc/ipua.php';
include_once '../sys/inc/fnc.php';
include_once '../sys/inc/user.php';

if (isset($_GET['id']) && mysql_result(mysql_query("SELECT COUNT(*) FROM `zakaz` WHERE `id` = '".intval($_GET['id'])."'"),0)==1)
{
$post=mysql_fetch_assoc(mysql_query("SELECT * FROM `zakaz` WHERE `id` = '".intval($_GET['id'])."' LIMIT 1"));

if ($post['id_user']==0)
{
$ank['id']=0;
$ank['pol']='zakaz';
$ank['level']=0;
$ank['nick']='Гость';
}
else
$ank=get_user($post['id_user']);
if (user_access('guest_delete'))
{
admin_log('Гостевая','Удаление сообщения',"Удаление сообщения от $ank[nick]");

mysql_query("DELETE FROM `zakaz` WHERE `id` = '$post[id]'");
}

}

if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!=NULL)
header("Location: ".$_SERVER['HTTP_REFERER']);
else
header("Location: index.php?".SID);

?>