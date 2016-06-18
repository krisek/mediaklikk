<?php

#valid streamids
$streamid="mtv4live";
#$streamid="dunalive";
#$streamid="mtv2live";
#$streamid="mtv1live";

foreach( $argv as $argument ) {
        if( $argument == $argv[ 0 ] ) continue;

        $pair = explode( "=", $argument );
        $variableName = substr( $pair[ 0 ], 2 );
        $variableValue = $pair[ 1 ];
        echo $variableName . " = " . $variableValue . "\n";
        // Optionally store the variable in $_REQUEST
        $_REQUEST[ $variableName ] = $variableValue;
}


if($_REQUEST[streamid] != ""){
    $streamid = $_REQUEST[streamid];
    }

$redirect=FALSE;

if($_REQUEST[redirect] != ""){
    $redirect = TRUE;
    }

$rewrite="";

if($_REQUEST[rewrite] != ""){
    $rewrite = $_REQUEST[rewrite];
    }


$site=file_get_contents("http://player.mediaklikk.hu/player/player-inside-full2.php?streamid=$streamid&userid=mtva");

#print $site;

preg_match_all("/(http:\/\/.*connectmedia.*)/",$site,$match);

$url=preg_replace("/\'.*/","",$match[0][0]);

if($rewrite != ""){
    $url=preg_replace("/http:\/\/.*connectmedia.hu\//","$rewrite",$url);
}
if($redirect === FALSE){
    $url=preg_replace("/index.*/","",$url);
    print "$url/01.m3u8\n";
    print "$url/02.m3u8\n";
    print "$url/03.m3u8\n";
    print "$url/04.m3u8\n";
    print "$url/05.m3u8\n";
    
}
else{
    header("Location: $url");
    }

?>
