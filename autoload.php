<?php
spl_autoload_register( function($classname)
{
    if ( strpos( $classname, 'YaGame' ) !== false )
    {
        $path = __DIR__ . '/Core/';
        $file = explode( '\\', $classname );

        if ( count($file) > 2 )
            for ( $i = 1; $i < ( count($file ) - 1); $i++ )
                $path .= $file[$i] . '/';

        $file = $file[ count( $file ) - 1 ] . '.php';

        if ( file_exists( $path.$file ) )
            require_once $path.$file;
    }
});
?>
