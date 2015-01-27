<?php
/**
 * These tests are about PHP SPL types, @link http://php.net/manual/en/book.spl-types.php
 *
 * The extension spl_types is NOT part of PHP core.
 * You need to download compiled extension, @link http://pecl.php.net/package/SPL_Types or better, compile it by your own,
 * @link http://php.net/manual/en/spl-types.installation.php
 *    sudo apt-get install libpcre3-dev
 *    sudo apt-get install php5-dev
 *    sudo pecl install SPL_Types
 *
 * (for Windows its the compilation quite complicated and currently unknown for me)
 **/
if (!extension_loaded('spl_types')) {
    throw new \LogicException('PHP extension spl_types is not loaded. Tests can not run.');
}
