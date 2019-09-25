<?php

namespace Hametuha;


use Hametuha\WpBlockCreator\Pattern\AbstractBlock;
use Symfony\Component\Finder\Finder;

/**
 * Assets manager for WordPress.
 *
 * @package wp-block-creator
 */
class WpBlockCreator {
	
	/**
	 * Constructor forbidden.
	 */
	final private function __construct() {}
	
	/**
	 * Register JavaScripts.
	 *
	 * @param array $args
	 * * namespace string e.g. Hametuha\MyBlock
	 * * dir       string Path to PSR-0 ready directory.
	 * * scripts   string Path to javascript directory.
	 * * js_vars   string Path to JS vars directory.
	 * * styles    stirng Path to CSS directory.
	 * * version   string Library version. Default is file's timestamp.
	 */
	public static function register( $args = [] ) {
		$args = wp_parse_args( $args, [
			'namespace' => '',
			'dir'       => '',
			'scripts'   => '',
			'js_vars'   => '',
			'styles'    => '',
			'prefix'    => 'my-',
			'version'   => null,
		] );
		if ( $args['scripts'] && is_dir( $args['scripts'] ) ) {
			WpEnqueueManager::register_js( $args['scripts'], $args['prefix'], $args['version'], true );
			if ( $args['js_vars'] && is_dir( $args['js_vars'] ) ) {
				WpEnqueueManager::register_js_var_files( $args['js_vars'] );
			}
		}
		if ( $args['styles'] && is_dir( $args['styles'] ) ) {
			WpEnqueueManager::register_styles( $args['styles'], $args['prefix'], $args['version'] );
		}
		if ( $args['namespace'] && is_dir( $args['dir'] ) ) {
			$finder = new Finder();
			foreach ( $finder->in( $args['dir'] )->name( '*.php' )->files() as $file ) {
				/** @var \SplFileInfo $file */
				$base_class = $file->getBasename( '.php' );
				$full_class = "{$args['namespace']}\\{$base_class}";
				// Does class exists?
				if ( ! class_exists( $full_class ) ) {
					continue;
				}
				// Is this class a proper subclass?
				$reflection = new \ReflectionClass( $full_class );
				if ( ! $reflection->isSubclassOf( AbstractBlock::class ) ) {
					continue;
				}
				// Initialize block.
				$full_class::get_instance()->set_prefix( $args['prefix'] );
			}
		}
	}
}
