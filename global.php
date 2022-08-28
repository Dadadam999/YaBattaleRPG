<?php
function line( string $line, array $args = [] ) : string
{
    $result = LINES[$line];

    foreach ( $args as $key => $value )
        $result = str_replace( $key, $value, $result );

    return $result;
}
?>
