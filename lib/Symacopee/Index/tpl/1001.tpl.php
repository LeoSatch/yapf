<?php
$sPage = "<h2>Liste des applications disponibles </h2>";
foreach( self::$_aData['apps'] as $sTmp ) {
    $sPage .= <<<EOD
    <a href='/$sTmp/index/'>$sTmp</a><br>
    
EOD;
}
?>