<?php
return apply_filters( 'ninja_forms_builder_tutorials',
	array(
		'example3' => array(
		    'id' => 'example3',
		    'title' => 'Example',
		    'video_url' => 'https://www.youtube.com/embed/O-nvBpss6Z8',
		    'description' => '<h2>' . __( 'This is an example', 'ninja-forms' ) . '</h2><p>TEST THIS OUT!</p>',
		    'trigger' => 'render:builder',
		    'priority' => 10
		),
	)
);