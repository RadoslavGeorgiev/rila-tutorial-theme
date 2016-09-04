<?php
if( is_front_page() ) {
    $title = '';
} else {
    $title = get_the_archive_title();
}

rila_view( 'index', array(
    'title' => $title
));
