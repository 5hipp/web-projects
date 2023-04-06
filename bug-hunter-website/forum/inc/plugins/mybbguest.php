<?php

// Disallow direct access to this file for security reasons
if(!defined("IN_MYBB"))
{
	die("Direct initialization of this file is not allowed.");
}

$plugins->add_hook("index_start", "mybbguest_page");

function mybbguest_info()
{
	$codename = str_replace('.php', '', basename(__FILE__));
	
	return array(
		"name"			=> "MyBB Guest Home",
		"description"	=> "Show homepage for guest.",
		"website"		=> "https://sinfulsite.com",
		"author"		=> "YASAKA",
		"authorsite"	=> "https://sinfulsite.com/@YASAKA",
		"version"		=> "1.0",
		"guid" 			=> "",
		"codename"		=> $codename,
		"compatibility" => "18*"
	);
}

function mybbguest_is_installed()
{
	global $mybb;

	if(isset($mybb->settings['mybbguest_onoff']))
	{
	    return true;
	}
	
	return false;
}

function mybbguest_install()
{
	mybbguest_install_settings();
	mybbguest_install_templates();
}

function mybbguest_uninstall()
{
	mybbguest_uninstall_settings();
	mybbguest_uninstall_templates();
}

function mybbguest_install_settings()
{
	global $db;

	$group = array(
        "name" => "mybbguest",
        "title" => "MyBB Guest Home",
        "description" => "Show homepage for guest.",
        "disporder" => 1,
        "isdefault" => 0
    );
    $gid = $db->insert_query("settinggroups", $group);

    $setting = array(
        "sid"            => NULL,
        "name"            => "mybbguest_onoff",
        "title"            => "MyBB Guest Home",
        "description"    => "Enable or disable this plugin.",
        "optionscode"    => "onoff",
        "value"            => "1",
        "disporder"        => 0,
        "gid"            => $gid
    );
    $db->insert_query("settings", $setting);

    rebuild_settings();
}

function mybbguest_uninstall_settings()
{
	global $db;

	$db->delete_query('settings', "name IN ('mybbguest_onoff')");
	$db->delete_query('settinggroups', "name = 'mybbguest'");

	rebuild_settings();
}

function mybbguest_install_templates()
{
	global $db;

	$template = '<html>
<head>
<title>{$mybb->settings[\'bbname\']}</title>
{$headerinclude}
</head>
<body>
{$header}
<div align="center" style="width: 50%; margin: auto; height: 100vw">
	<h1>Welcome to {$mybb->settings[\'bbname\']}</h1>
	<h2>Home of Bug Hunting!</h2>
	<h4>Welcome to the Bug Hunter forums, please register or sign in below to access the Virtual Machines and Challenges within the forums.</h4>

	<a class="button" href="{$mybb->settings[\'bburl\']}/member.php?action=login" onclick="$(\'#quick_login\').modal({ fadeDuration: 250, keepelement: true, zIndex: (typeof modal_zindex !== \'undefined\' ? modal_zindex : 9999) }); return false;" style="margin-right:10px">Login</a>
	<a href="{$mybb->settings[\'bburl\']}/member.php?action=register" class="button">Register</a>

</div>
{$footer}
</body>
</html>';
	$insert_array = array(
	    'title' => 'index_guest',
	    'template' => $db->escape_string($template),
	    'sid' => '-1',
	    'version' => '',
	    'dateline' => time()
	);
	$db->insert_query('templates', $insert_array);
}

function mybbguest_uninstall_templates()
{
	global $db;

	$db->delete_query("templates", "title = 'index_guest'");
}

function mybbguest_page()
{
	global $mybb, $db, $templates, $lang, $header, $headerinclude, $footer, $theme;

	$uid = $mybb->user['uid'];

	if($mybb->settings['mybbguest_onoff'] == "1" && $uid <= "0")
	{
		eval('$index = "'.$templates->get('index_guest').'";');
		output_page($index);
		die();
	}
}