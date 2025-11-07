<?php

// to Remove Wordpress version
function remove_version_from_assets( $src ) {
    if ( strpos( $src, 'ver=' ) !== false ) {
        $src = remove_query_arg( 'ver', $src );
    }
    return $src;
}
add_filter( 'style_loader_src', 'remove_version_from_assets', 9999 );
add_filter( 'script_loader_src', 'remove_version_from_assets', 9999 );

