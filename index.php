<?php
if( is_front_page() ) {
    $title = '';
} else {
    $title = get_the_archive_title();
}

$context = array(
	'title' => $title
);

rila_view( 'index', $context )->render();
