<?php // phpcs:ignore

namespace WooViews\Block\Style;

use ToolsetCommonEs\Block\Style\Attribute\Factory as FactoryStyleAttribute;
use ToolsetCommonEs\Block\Style\Block\Common;
use ToolsetCommonEs\Block\Style\Block\IBlock;
use ToolsetCommonEs\Block\Style\Block\IFactory;
use ToolsetCommonEs\Utils\Config\Toolset;

/**
 * Class Factory
 *
 * Maps block array comming from WordPress to our Style/Block class. The array can be filtered, so it's important
 * to prove every key before use.
 */
class Factory implements IFactory {
	/**
	 * Factory Style Attribute
	 *
	 * @var FactoryStyleAttribute
	 */
	private $factory_style_attribute;

	/** @var Toolset */
	private $config_toolset;

	/**
	 * Constructor
	 *
	 * @param FactoryStyleAttribute $factory_attribute Factory Style Attribute.
	 * @param Toolset $config
	 */
	public function __construct( FactoryStyleAttribute $factory_attribute, Toolset $config ) {
		$this->factory_style_attribute = $factory_attribute;
		$this->config_toolset = $config;
	}

	/**
	 * Get block by array
	 *
	 * @param array $array Data.
	 * @return IBlock
	 */
	public function get_block_by_array( $array ) {
		if (
			! is_array( $array ) ||
			! array_key_exists( 'blockName', $array ) ||
			! array_key_exists( 'attrs', $array )
		) {
			return;
		}

		$block_name = $array['blockName'];
		$block_attributes = $array['attrs'];

		switch ( $block_name ) {
			case 'woocommerce-views/product-price':
				return new ProductPrice( $block_attributes, $this->get_block_config( 'product-price' ) );
			case 'woocommerce-views/product-image':
			case 'woocommerce-views/category-image':
				return new ProductImage( $block_attributes, $this->get_block_config( 'product-image' ) );
			case 'woocommerce-views/add-to-cart':
				return new AddToCart( $block_attributes );
			case 'woocommerce-views/cart-count':
				return new CartCount( $block_attributes );
			case 'woocommerce-views/cart-message':
				return new CartMessage( $block_attributes, $this->get_block_config( 'cart-message' ) );
			case 'woocommerce-views/breadcrumb':
				return new Breadcrumb( $block_attributes, $this->get_block_config( 'breadcrumb' ) );
			case 'woocommerce-views/product-tabs':
				return new ProductTabs( $block_attributes, $this->get_block_config( 'product-tabs' ) );
			case 'woocommerce-views/list-attributes':
				return new ListAttributes( $block_attributes, $this->get_block_config( 'list-attributes' ) );
			case 'woocommerce-views/product-meta':
				return new ProductMeta( $block_attributes, $this->get_block_config( 'product-meta' ) );
			case 'woocommerce-views/ratings':
				return new Ratings( $block_attributes, $this->get_block_config( 'ratings' ) );
			case 'woocommerce-views/related-products':
				return new RelatedProducts( $block_attributes, $this->get_block_config( 'related-products' ) );
			case 'woocommerce-views/reviews':
				return new Reviews( $block_attributes, $this->get_block_config( 'reviews' ) );
			default:
				return;
		}
	}

	private function get_block_config( $block ) {
		return $this->config_toolset->get_block_config( $block, 'woocommerceViews' );
	}
}
