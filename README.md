# wp-block-creator

Gutenberg Block Creator for themes.

[![Travis CI](https://travis-ci.org/hametuha/wp-block-creator.svg?branch=master)](https://travis-ci.org/hametuha/wp-block-creator)

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

## License

GPL 3.0 or later. Compatible with WordPress.