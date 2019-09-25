<?php

namespace Hametuha\WpBlockCreator\Pattern;


use Hametuha\SingletonPattern\Singleton;
use Hametuha\StringUtility\NamingConventions;
use Hametuha\StringUtility\Path;

/**
 * Abstract block.
 *
 * @package wp-block-creator
 * @method string render_callback( array $attributes, string $content )
 */
abstract class AbstractBlock extends Singleton {

	use NamingConventions, Path;
	
	protected $prefix = '';
	
	protected $block_name = '';
	
	/**
	 * @var bool If set to true, skip this block.
	 */
	protected $disabled = false;
	
	/**
	 * {@inheritDoc}
	 */
	protected function init() {
		if ( $this->disabled || ! function_exists( 'register_block_type' ) ) {
			return;
		}
		add_action( 'init', [ $this, 'register_assets' ] );
		add_action( 'init', [ $this, 'register_block' ] );
		add_action( 'enqueue_block_assets', [ $this, 'enqueue_block_assets' ] );
		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_block_editor_assets' ] );
	}
	
	/**
	 * Enqueue something both editor and front end.
	 */
	public function enqueue_block_assets() {}
	
	/**
	 * Enqueue something only on editor.
	 */
	public function enqueue_block_editor_assets() {}

	/**
	 * Register scripts on init hook
	 *
	 * If registered scripts are required, override here.
	 */
	public function register_assets() {
		do_action( 'hametuha_block_creator_register_assets', $this->get_block_base() );
	}
	
	/**
	 * Register block.
	 */
	public function register_block() {
		$args = [];
		if ( method_exists( $this, 'render_callback' ) ) {
			$args['render_callback'] = [ $this, 'render_callback' ];
		}
		$args['editor_script'] = $this->get_script();
		if ( $style = $this->get_style() ) {
			$args['editor_style'] = $style;
		}
		$args = apply_filters( 'hametuha_block_creator_attributes', $this->filter_attributes( $args ), $this->get_block_name() );
		register_block_type( $this->get_block_name(), $args );
	}
	
	/**
	 * Filter attributes.
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	protected function filter_attributes( $args ) {
		return $args;
	}
	
	/**
	 * Set prefix.
	 *
	 * @param string $prefix
	 */
	public function set_prefix( $prefix ) {
		$this->prefix = preg_replace( '/-$/u', '', $prefix );
	}
	
	/**
	 * Get scripts for block.
	 *
	 * @return string
	 */
	abstract protected function get_script();
	
	/**
	 * Get style to include.
	 *
	 * @return string
	 */
	protected function get_style() {
		return '';
	}
	
	/**
	 * Use property or kebab case of class name.
	 *
	 * @return string
	 */
	protected function get_block_base() {
		if ( $this->block_name ) {
			return $this->block_name;
		}
		list( $class_name ) = array_reverse( explode( "\\", get_called_class() ) );
		
		return $this->camel_to_kebab( $class_name );
	}
	
	/**
	 * Get block name.
	 *
	 * @return string
	 */
	protected function get_block_name() {
		return $this->prefix . '/' . $this->get_block_base();
	}
}
