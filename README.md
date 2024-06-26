# WP Block Creator

Gutenberg Block Creator for themes.

[![CI/CD for PHP Library](https://github.com/hametuha/wp-block-creator/actions/workflows/wordpress.yml/badge.svg)](https://github.com/hametuha/wp-block-creator/actions/workflows/wordpress.yml)

## Installation

```bash
composer require hametuha/wp-block-creator
```

## How to Use

Suppose your theme:

- Use [wp-enqueue-manager] ready headers.
- Your theme's PHP is ready for [PSR-0](https://www.php-fig.org/psr/psr-0/).
- Every block inherits `Hametuha\WpBlockCreator\Patter\AbstractBlock`.
- Directory structure is like below.

```
your-theme
├src/YourTeam/YourTheme/Blocks
│├ExampleBlock.php
│└AnotherBlock.php
└dist
　├css/blocks
　│├example-block.css
　│└another-block.css
　└js/blocks
　　├example-block.js
　　└another-block.js
```

Then, call static method in your `functions.php`.

```php
<?php

// Register blocks assets.
\Hametuha\WpBlockCreator::register( [
	'namespace' => "YourTeam\\YourTheme\\Blocks",
	'dir'       => get_template_directory() . '/src/YourTeam/YourTheme/Blocks',
	'scripts'   => get_template_directory() . '/dist/js/blocks',
	'styles'    => get_template_directory() . '/dist/css/blocks',
	'prefix'    => 'your-theme-',
] );
```

Now all block will be automatically included.
You don't have to load 1 by 1.
Add new block anytime you want.

Every JavaScripts and Stylesheets will be resgistered with the power of [wp-enqueue-manager](https://github.com/hametuha/wp-enqueue-manager). Write proper header like below:

```js
/*!
 * Header description here.
 *
 * deps=jquery,wp-element,wp-api-fetch
 */
```

```css
/**
 * Header comment.
 * 
 * deps=bootstrap
 */
```


For more details, see [README.md](https://github.com/hametuha/wp-enqueue-manager) of `wp-enqueue-manager`.

## License

GPL 3.0 or later. Compatible with WordPress.
