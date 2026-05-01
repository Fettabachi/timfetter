## ACF Admin UI Dependencies

When porting ACF blocks to another theme/site, confirm the following admin/editor assets are available:

- Dashicons are loaded in the WP admin.
- ACF Link/Image/Repeater field controls render their edit/remove icons correctly.
- If ACF icons display as broken characters, add the shared ACF admin UI helper:

```php
add_action('admin_enqueue_scripts', function () {
	wp_enqueue_style('dashicons');
});

add_action('acf/input/admin_head', function () {
	?>
	<style>
		.acf-icon::before {
			font-family: dashicons !important;
			font-style: normal;
			font-weight: 400;
			line-height: 1;
			text-transform: none;
		}

		.acf-icon.-pencil::before {
			content: "\f464" !important;
		}

		.acf-icon.-cancel::before {
			content: "\f335" !important;
		}
	</style>
	<?php
});
```
