{php}
/**
* @package HipPhp
* @author     Shane Barron <admin@hipphp.com>
*/

denyDirect();

$current_tab = pageArray(1);
if (!$current_tab) {
$current_tab = "notifications";
}
$tabs = Usersetting::listTabs();
$body = <<<HTML
<div>
<ul class="nav nav-pills">
HTML;
if ($tabs) {
foreach ($tabs as $tab) {
if ($tab) {
$label = translate("user_setting:$tab");
$body .= <<<HTML
<li role="presentation" class="active"><a href="#">$label</a></li>
</ul>
HTML;
}
}
$body .= <<<HTML
<hr>
</div>
HTML;
$body .= drawForm([
"name"   => "user_settings",
"method" => "post",
"action" => "updateUserSettings"
]);
}
echo drawPage([
"header" => "My Settings",
"body"   => $body
]);
{/php}