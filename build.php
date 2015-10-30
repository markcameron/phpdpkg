<?php

$src_root = __DIR__ ."/src";
$build_root = __DIR__ ."/build";

ini_set("phar.readonly", 'Off');
$phar = new Phar($build_root . "/phpdpkg.phar",
	FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME, "phpdpkg.phar");

$phar["index.php"] = file_get_contents($src_root . "/index.php");
$phar["phpdpkg.php"] = file_get_contents($src_root . "/PhpdpkgCommand.php");

$phar->setStub($phar->createDefaultStub("index.php"));
