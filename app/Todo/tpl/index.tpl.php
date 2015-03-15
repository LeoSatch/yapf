<?php
print_r( static::$_aData );
$sPage = '';
foreach ( static::$_aData[ 'todoList' ] as $key => $value ) {
    $sPage .= <<<EOD
$key => $value


EOD;
}

