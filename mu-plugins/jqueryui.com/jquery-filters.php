<?php

add_filter( 'the_content', function( $content ) {
	global $post;

	$demoContent = '';
	$demoPos = strpos( $content, '<!--demos-->');
	if ( $demoPos === false ) {
		return $content;
	}

	$plugin = $post->post_name;
	$demoList = json_decode( file_get_contents( GW_RESOURCE_DIR . '/demos/demo-list.json' ) );
	$defaultDemo = $demoList->$plugin->default;

	$demoContent .= '<ul class="demo-list">';
	foreach ( $demoList->$plugin as $filename => $demo ) {
		$demoContent .=
			'<li>' .
				'<a href="/resources/demos/' . $plugin . '/' . $filename . '.html">' .
					$demo->title .
				'</a>' .
			'</li>';
	}
	$demoContent .= '</ul>';

	$demoContent .= '<iframe src="/resources/demos/' . $plugin . '/default.html" class="demo-frame"></iframe>';
	$demoContent .= '<div class="demo-description">' . $defaultDemo->description . '</div>';

	$demoContent .=
		'<div class="view-source">' .
			'<a tabindex="0">view source<a>' .
			'<pre>' .
				htmlspecialchars( file_get_contents( GW_RESOURCE_DIR . '/demos/' . $plugin . '/default.html' ) ) .
			'</pre>' .
		'</div>';

	return str_replace( $content, '<!--demos-->', $demoContent );
} );

?>
