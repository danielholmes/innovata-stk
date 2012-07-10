<?php

//require_once __DIR__ . '/app/bootstrap.php.cache';
//require_once __DIR__.'/app/AppKernel.php';
$VENDOR_DIR = __DIR__ . '/vendor/pear-pear.phpunit.de';

// This should really be part of composer
set_include_path(get_include_path() . PATH_SEPARATOR . $VENDOR_DIR . '/File_Iterator');
set_include_path(get_include_path() . PATH_SEPARATOR . $VENDOR_DIR . '/PHP_CodeCoverage');
set_include_path(get_include_path() . PATH_SEPARATOR . $VENDOR_DIR . '/PHPUnit');
set_include_path(get_include_path() . PATH_SEPARATOR . $VENDOR_DIR . '/PHPUnit_MockObject');
set_include_path(get_include_path() . PATH_SEPARATOR . $VENDOR_DIR . '/PHP_Timer');
set_include_path(get_include_path() . PATH_SEPARATOR . $VENDOR_DIR . '/PHP_TokenStream');
set_include_path(get_include_path() . PATH_SEPARATOR . $VENDOR_DIR . '/Text_Template');
// end of composer

require_once($VENDOR_DIR . '/PHPUnit/bin/phpunit');