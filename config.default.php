<?php
// Please put your own configurations in config.php
$config = array(
	"username" => "Put bot username here - affects command parsing",
	"explicitaddress" => false,
	"key" => "Put Telegram Bot API key here",
	"admins" => array( "Put ops' IDs in this array" ),
	"developers" => array(),
	"bootstrap" => "",
	"commands" => array(
		"\\Feng\\JeraBot\\Commands\\StartCommand",
		"\\Feng\\JeraBot\\Commands\\HelpCommand",
		"\\Feng\\JeraBot\\Commands\\MyidCommand",
		"\\Feng\\JeraBot\\Commands\\MyinfoCommand",
		"\\Feng\\JeraBot\\Commands\\StatsCommand",
		"\\Feng\\JeraBot\\Commands\\CheckinCommand",
		"\\Feng\\JeraBot\\Commands\\AssocCommand",
		"\\Feng\\JeraBot\\Commands\\FindCommand",
		"\\Feng\\JeraBot\\Commands\\KdCommand",
		"\\Feng\\JeraBot\\Commands\\SendCommand",
		"\\Feng\\JeraBot\\Commands\\AnyConnectCloseCommand",
		"\\Feng\\JeraBot\\Commands\\AnyConnectCommand",
	),
);

@include( __DIR__ . "/config.php" );
