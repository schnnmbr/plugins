<?php
/* This class must be included in another file and included later so we don't get an error about HeadwayBlockAPI class not existing. */

class HeadwayArticleBuilderBlock extends HeadwayBlockAPI {
	
	public $id = 'article-builder';
	
	public $name = 'Article Builder';
	
	public $options_class = 'HeadwayArticleBuilderBlockOptions';

	static public $block = null;

	function __construct() {
		
		$blocks = HeadwayBlocksData::get_blocks_by_type('article-builder-block');

		/* return if there are not blocks for this type.. else do the foreach */
		if ( !isset($blocks) || !is_array($blocks) )
			return;
		
		foreach ($blocks as $block_id => $layout_id) {
			self::$block = HeadwayBlocksData::get_block($block_id);
		}

	}

	function init() {
		require_once 'content-display.php';
	}

	static function add_builder_css($general_css_fragments) {
		$general_css_fragments[] = dirname(__FILE__).'/css/builder.css';
		return $general_css_fragments;
	}

	static function enqueue_action($block_id, $block) {

		add_filter('headway_general_css', array(__CLASS__, 'add_builder_css'));

		if ( version_compare('3.2', HEADWAY_VERSION, '<=') ) {
			add_filter('headway_general_css', array(__CLASS__, 'add_builder_css'));
		} else {
			add_filter('headaway_general_css', array(__CLASS__, 'add_builder_css'));
		}

		$hover_overlay = parent::get_setting($block, 'thumb-hover-overlay', false);
		$align = parent::get_setting($block, 'thumb-align', 'none');

		if ($hover_overlay || $align == 'center')
		wp_enqueue_script('headway-builder-overlay', plugins_url(basename(dirname(__FILE__))) . '/js/hover-overlay.js', array('jquery'));	

		return;
		
	}
	
	static function dynamic_js($block_id, $block = false) {

		if ( !$block )
			$block = HeadwayBlocksData::get_block($block_id);
			
			$hover_overlay = parent::get_setting($block, 'thumb-hover-overlay', false);
			$align = parent::get_setting($block, 'thumb-align', 'none');

			$js = '';

			if ($hover_overlay)
			$js .= '
				jQuery(function() {
					jQuery(\'#block-' . $block_id . ' .articles > article\').hoverdir();
				});
			';
			if ($align == 'center')
			$js .= '
			(function ($) {
				$(document).ready(function() {
					$(\'#block-' . $block_id . ' .articles > article figure.aligncenter a\').hAlign();
				});
			})(jQuery);';


			if ( HeadwayResponsiveGrid::is_enabled() ) {
				
				/* Add's and removes classes for break points */
				$responsive_options = parent::get_setting($block, 'responsive-controls', array());

				$options = self::get_repeater_options($responsive_options, 'responsive-breakpoint', 'off');

				if($options) {

					$js .= '
					function debouncer( func , timeout ) {
					   var timeoutID , timeout = timeout || 200;
					   return function () {
					      var scope = this , args = arguments;
					      clearTimeout( timeoutID );
					      timeoutID = setTimeout( function () {
					          func.apply( scope , Array.prototype.slice.call( args ) );
					      } , timeout );
					   }
					}

					(function ($) {
						$(document).ready(function() {
							$( window ).resize( debouncer( function ( e ) {

								$("#block-' . $block_id . ' .articles").removeAttr("id");';

								foreach ( $options as $option ) {

									$breakpoint_smartphone = headway_fix_data_type(headway_get('responsive-breakpoint', $option, '600'));
									
									$custom_width = headway_fix_data_type(headway_get('custom-width', $option, ''));

									if($custom_width && $breakpoint_smartphone == 'custom')
										$breakpoint_smartphone = $custom_width;

									$breakpoint_min_max = headway_fix_data_type(headway_get( 'breakpoint-min-or-max', $option, 'min'));

									$operator = ($breakpoint_min_max == 'min') ? '>' : '<';

									if ($breakpoint_smartphone == 'off')
									  		continue;

							  		$js .= '
										if ($(window).width() ' . $operator . '= parseInt("' . $breakpoint_smartphone . '") ) {
									        $("div.articles").attr("id", "' . $breakpoint_min_max . '-width-' . $breakpoint_smartphone . '");
									      }
							  		';

							  	}

				  	$js .= '
				  			}));
				  		});
					})(jQuery);';

				}

				if($options) {

					$js .= '
					(function ($) {
						$(document).ready(function() {';

							foreach ( $options as $option ) {

								$breakpoint_smartphone = headway_fix_data_type(headway_get('responsive-breakpoint', $option, '600'));

								$custom_width = headway_fix_data_type(headway_get('custom-width', $option, ''));

								if($breakpoint_smartphone == 'custom')
									$breakpoint_smartphone = $custom_width;

								$breakpoint_min_max = headway_fix_data_type(headway_get( 'breakpoint-min-or-max', $option, 'min'));

								$operator = ($breakpoint_min_max == 'min') ? '>' : '<';

								if ($breakpoint_smartphone == 'off')
							  		continue;

							  	$js .= '
										if ($(window).width() ' . $operator . '= parseInt("' . $breakpoint_smartphone . '") ) {
									        $("div.articles").attr("id", "' . $breakpoint_min_max . '-width-' . $breakpoint_smartphone . '");
									      }
							  		';

						  	}
								

				  	$js .= '
				  		});
					})(jQuery);';

				}

			}

			return $js;
		
	}
	
	static function dynamic_css($block_id, $block = false) {

		if ( !$block )
			$block = HeadwayBlocksData::get_block($block_id);

			$stack_or_float = parent::get_setting($block, 'stack-or-float', 'float');
			$gutter_width   = parent::get_setting($block, 'gutter-width', '20');
			$min_height     = parent::get_setting($block, 'minimum-height');

			/* A little maths to work out which items will be the first item in a row */
			$count = parent::get_setting($block, 'posts-per-block', '4');
			$columns = parent::get_setting($block, 'columns', '4');

			$css ='';
			/* css if the items are floated as a grid */
			if ($stack_or_float == 'float') {
				$css .= '#block-' . $block_id . ' .article {
				margin-left: ' . self::widthAsPercentage($gutter_width, $block) . '%;
				float:left;
				width: ' . self::widthAsPercentage(self::getColumnWidth($block, $columns), $block) . '%;
				}';

				/* remove margin on first items */
				$css .= '#block-' . $block_id . ' .article:nth-child('.$columns.'n + 1) {margin-left: 0;clear: left;}';

			} else if ($stack_or_float == 'stack') {
				$css .= '#block-' . $block_id . ' .article {
				margin-left:0;
				width: 100%;
				}';
			}
			$css .= '#block-' . $block_id . ' .article {';
			
			$css .= 'margin-bottom: ' . parent::get_setting($block, 'bottom-margin', '20') . 'px;';

			if ($min_height)
				$css .= 'min-height: ' . parent::get_setting($block, 'minimum-height') . 'px;';

			$css .= '}';

			/* Thumb alignment */
			$auto_size = parent::get_setting($block, 'thumb-size-auto', false);
			$position = parent::get_setting($block, 'thumb-align', 'none');
			$position_css = 'float: ' . $position . '';

				/* Output Thumb CSS */
				if ($position != 'left' || $position != 'right')
				$position_css = false;
				$css .= '#block-' . $block_id . ' .article figure a.post-thumbnail { 
					' . $position_css;
				if (!$auto_size)
				$css .= '
					width: '. parent::get_setting($block, 'thumb-width', '200') .'px;
					height: auto;';
				$css .= '
				}'; /* end thumb css */

			/* Overlay */
			if ( $position = parent::get_setting($block, 'overlay-contents-position', 'center_center') ) {
				$position_properties = array(
				'top_left' => 'left: 0; top: 0;',
				'top_center' => 'left: 0; top: 0; right: 0;',
				'top_right' => 'top: 0; right: 0;',

				'center_center' => 'bottom: 0; left: 0; top: 0; right: 0;',
				'center_left' => 'bottom: 0; left: 0; top: 0;',
				'center_right' => 'bottom: 0; top: 0; right: 0;',
				
				'bottom_left' => 'bottom: 0; left: 0;',
				'bottom_center' => 'bottom: 0; left: 0; right: 0;',
				'bottom_right' => 'bottom: 0;right: 0;'
			);
			
			$overlay_content_height = parent::get_setting($block, 'overlay-contents-height', '36');
			$overlay_content_width = parent::get_setting($block, 'overlay-contents-width', '36');
			$overlay_content_unit = parent::get_setting($block, 'overlay-contents-unit', 'px');
			
			$css .= '
				#block-' . $block_id . ' .article figure div.overlay {
					margin: auto;
				   position: absolute;  
				    ' . headway_get($position, $position_properties) . '
				    width: '. $overlay_content_width . $overlay_content_unit . ';
				    height: '. $overlay_content_height . $overlay_content_unit . ';
				}
			';

			}

			
			$hover_overlay = parent::get_setting($block, 'thumb-hover-overlay', false);
			$icon_size = parent::get_setting($block, 'thumb-overlay-iconsize', 36);
			$icon_class = self::get_setting($block, 'thumb-hover-iconclass', 'right-circle');
			if($hover_overlay)
				$css .= '
					@font-face {
				  font-family: \'fontello\';
				  src: url(\''.plugins_url(false, __FILE__).'/css/font/fontello.eot\');
				  src: url(\''.plugins_url(false, __FILE__).'/css/font/fontello.eot?#iefix\') format(\'embedded-opentype\'), url(\''.plugins_url(false, __FILE__).'/css/font/fontello.woff\') format(\'woff\'), url(\''.plugins_url(false, __FILE__).'/css/font/fontello.ttf\') format(\'truetype\'), url(\''.plugins_url(false, __FILE__).'/css/font/fontello.svg#fontello\') format(\'svg\');
				  font-weight: normal;
				  font-style: normal;
				}
				@font-face {
	  font-family: \'fontello\';
	  src: url("data:application/octet-stream;base64,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") format(\'woff\'), url("data:application/octet-stream;base64,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sAIlRlBYIDxZLrEkARQrLbA2LCMgLkawAiVGUlggPFkjIC5GsAIlRlBYIDxZLrEkARQrLbA3LLAuKyMgLkawAiVGUlggPFkusSQBFCstsDgssC8riiAgPLAEI0KKOCMgLkawAiVGUlggPFkusSQBFCuwBEMusCQrLbA5LLAAFrAEJbAEJiAuRyNHI2GwBkUrIyA8IC4jOLEkARQrLbA6LLEJBCVCsAAWsAQlsAQlIC5HI0cjYSCwBCNCsAZFKyCwYFBYILBAUVizAiADIBuzAiYDGllCQiMgR7AEQ7CAYmAgsAArIIqKYSCwAkNgZCOwA0NhZFBYsAJDYRuwA0NgWbADJbCAYmGwAiVGYTgjIDwjOBshICBGI0ewACsjYTghWbEkARQrLbA7LLAuKy6xJAEUKy2wPCywLyshIyAgPLAEI0IjOLEkARQrsARDLrAkKy2wPSywABUgR7AAI0KyAAEBFRQTLrAqKi2wPiywABUgR7AAI0KyAAEBFRQTLrAqKi2wPyyxAAEUE7ArKi2wQCywLSotsEEssAAWRSMgLiBGiiNhOLEkARQrLbBCLLAJI0KwQSstsEMssgAAOistsEQssgABOistsEUssgEAOistsEYssgEBOistsEcssgAAOystsEgssgABOystsEkssgEAOystsEossgEBOystsEsssgAANystsEwssgABNystsE0ssgEANystsE4ssgEBNystsE8ssgAAOSstsFAssgABOSstsFEssgEAOSstsFIssgEBOSstsFMssgAAPCstsFQssgABPCstsFUssgEAPCstsFYssgEBPCstsFcssgAAOCstsFgssgABOCstsFkssgEAOCstsFossgEBOCstsFsssDArLrEkARQrLbBcLLAwK7A0Ky2wXSywMCuwNSstsF4ssAAWsDArsDYrLbBfLLAxKy6xJAEUKy2wYCywMSuwNCstsGEssDErsDUrLbBiLLAxK7A2Ky2wYyywMisusSQBFCstsGQssDIrsDQrLbBlLLAyK7A1Ky2wZiywMiuwNistsGcssDMrLrEkARQrLbBoLLAzK7A0Ky2waSywMyuwNSstsGossDMrsDYrLbBrLCuwCGWwAyRQeLABFTAtAABLuADIUlixAQGOWbkIAAgAYyCwASNEILADI3CyBCgJRVJEswoLBgQrsQYBRLEkAYhRWLBAiFixBgNEsSYBiFFYuAQAiFixBgFEWVlZWbgB/4WwBI2xBQBE") format(\'truetype\');
	}
					#block-' . $block_id . ' .icon-'. $icon_class .' {width:' . $icon_size . 'px;height:' . $icon_size . 'px;}
					#block-' . $block_id . ' .icon-'. $icon_class .':before { font-size: ' . $icon_size . 'px;}
				';

			if ( HeadwayResponsiveGrid::is_enabled() ) {
				/* Add's and removes classes for break points */
				$responsive_options = parent::get_setting($block, 'responsive-controls', array());

				$options = self::get_repeater_options($responsive_options, 'responsive-breakpoint', 'off');

				if($options)
			  	foreach ( $options as $option ) {

		  			/* Responsive CSS - some magic to make the columns work with the smartphone setting */
					$breakpoint_smartphone = headway_fix_data_type(headway_get('responsive-breakpoint', $option, '600'));
					$custom_width = headway_fix_data_type(headway_get('custom-width', $option, ''));

					if($custom_width && $breakpoint_smartphone == 'custom')
						$breakpoint_smartphone = $custom_width;

					$smartphone_columns = headway_fix_data_type(headway_get('columns-smartphone', $option, '4'));

					$mobile_min_height = headway_fix_data_type(headway_get( 'mobile-minimum-height', $option, ''));
					$mobile_auto_center = headway_fix_data_type(headway_get( 'mobile-center-elements', $option, true));
					$breakpoint_min_max = headway_fix_data_type(headway_get( 'breakpoint-min-or-max', $option, 'min'));

					/* Output Mobile CSS */
					$css .= '@media screen and ('. $breakpoint_min_max .'-width: ' . $breakpoint_smartphone . ' ) { ';
					
					$css .= '#block-' . $block_id . ' .article {';
						if (headway_fix_data_type(headway_get('columns-smartphone', $option)) == '1') :
							$css .= 
							'width: 99.6%;
							float: none;
							margin-left: 0;';
						else :
							$css .= 
							'margin-left: '.self::widthAsPercentage($gutter_width, $block).'%;
							width: '.self::widthAsPercentage(self::getColumnWidth($block, $smartphone_columns), $block).'%;';
							if ($mobile_min_height)
								$css .= 'min-height: ' . $mobile_min_height . 'px;';
							if ($mobile_auto_center)
								$css .= 'text-align: center;';
						endif;
					
					$css .= '}';//close .article

					$auto_size = headway_fix_data_type(headway_get('thumb-size-auto', $option, true));


					if ($auto_size)
						$css .= '#block-' . $block_id . ' .article img { width: 100% }';

					if (!$auto_size)
						$css .= '#block-' . $block_id . ' .article img { max-width: 100% }';


					/* First re apply left margin that is previously zeroed out  */
					$css .= '#block-' . $block_id . ' .article:nth-child('.$columns.'n + 1) {clear: none;margin-left: '.self::widthAsPercentage($gutter_width, $block).'%;}';

					/* now apply the mobile left 0 to correct articles */

					$css .= '#block-' . $block_id . ' #' . $breakpoint_min_max . '-width-' . $breakpoint_smartphone . ' .article:nth-child('.$smartphone_columns.'n + 1) {margin-left: 0;clear: none;}';

					$css .= '}';//close media query

			  	}
			}


		return $css;
		
	}
	
	function content($block) {

		self::$block = $block;
		
		$block_display = new HeadwayPostListingsBlockDisplay($block);
		echo parent::get_setting($block, 'before-content', false);
		$block_display->display($block);
		echo parent::get_setting($block, 'after-content', false);
		
	}

	static function get_repeater_options($options, $default) {

		$has_options = false;

		if ($options) {
			
			foreach ( $options as $option )
				if ( $option[$default] ) {
					$has_options = true;
					break;
				}		

			if ( $has_options )
			  	return $options;

		}

	}

	static function getColumnWidth($block, $columns) {
		$block_width = HeadwayBlocksData::get_block_width($block);

		$gutter_width = parent::get_setting($block, 'gutter-width', '20');

		$total_gutter = $gutter_width * ($columns-1);

		$columns_width = (($block_width - $total_gutter) / $columns);

		return $columns_width; 
	}

	/* To make the layout responsive
	 * Works out a percentage value equivalent of the px value 
	 * using common responsive formula: target_width / container_width * 100
	 */	
	static function widthAsPercentage($target = '', $block) {
		$block_width = HeadwayBlocksData::get_block_width($block);
		
		if ($block_width > 0 )
			return ($target / $block_width)*100;

		return false;
	}

	function setup_elements() {
		
		$this->register_block_element(array(
			'id' => 'articles-wrapper',
			'name' => 'Articles Wrapper',
			'selector' => '.articles'
		));

		$this->register_block_element(array(
			'id' => 'article-container',
			'name' => 'Article Container',
			'selector' => 'article',
			'states' => array(
				'Hover' => 'article:hover',
				'Hover all children' => 'article:hover *'
			),
			'properties' => array('fonts', 'borders', 'background', 'padding', 'rounded-corners', 'box-shadow', 'text-shadow'),
		));

		$this->register_block_element(array(
			'id' => 'article-header',
			'parent' => 'article-container',
			'name' => 'Article Header',
			'selector' => 'article header'
		));

		$this->register_block_element(array(
			'id' => 'article-section',
			'parent' => 'article-container',
			'name' => 'Article Section',
			'selector' => 'article section'
		));

		$this->register_block_element(array(
			'id' => 'article-footer',
			'parent' => 'article-container',
			'name' => 'Artice Footer',
			'selector' => 'article footer'
		));

		$this->register_block_element(array(
			'id' => 'article-title',
			'name' => 'Article Title (Heading not link)',
			'selector' => 'article .entry-title'
		));

		$this->register_block_element(array(
			'id' => 'article-title-link',
			'parent' => 'article-title',
			'name' => 'Article Title (Link)',
			'selector' => 'article .entry-title a',
			'states' => array(
				'Hover' => 'article .entry-title a:hover'
			)
		));

		$this->register_block_element(array(
			'id' => 'article-thumb',
			'name' => 'Article Thumb',
			'selector' => 'article figure img'
		));

		$this->register_block_element(array(
			'id' => 'thumb-overlay',
			'parent' => 'article-thumb',
			'name' => 'Thumb Overlay',
			'selector' => '.article figure > div',
			'properties' => array('background')
		)); 

		$this->register_block_element(array(
			'id' => 'thumb-overlay-contents',
			'parent' => 'article-thumb',
			'name' => 'Thumb Overlay Contents',
			'selector' => '.article figure > div div'
		));

		$this->register_block_element(array(
			'id' => 'thumb-overlay-icon',
			'parent' => 'article-thumb',
			'name' => 'Thumb Overlay Icon',
			'selector' => '.articles article figure div i',
			'properties' => array('fonts', 'text-shadow')
		));

		$this->register_block_element(array(
			'id' => 'article-author-link',
			'name' => 'Author Link',
			'selector' => 'article .author-link'
		));

		$this->register_block_element(array(
			'id' => 'article-author-avatar-link',
			'name' => 'Author Avatar Link',
			'selector' => 'article .author-avatar'
		));

		$this->register_block_element(array(
			'id' => 'article-author-avatar-img',
			'name' => 'Author Avatar Image',
			'selector' => 'article .author-avatar img'
		));

		$this->register_block_element(array(
			'id' => 'article-link',
			'name' => 'Article Link',
			'selector' => 'article a',
			'inspectable' => false,
			'states' => array(
				'Hover' => 'article a:hover'
			)
		));

		$this->register_block_element(array(
			'id' => 'article-more-link',
			'name' => 'Read More Link',
			'selector' => 'article .more-link',
			'states' => array(
				'Hover' => 'article .more-link:hover'
			),
		));

		$this->register_block_element(array(
			'id' => 'article-date',
			'name' => 'Date Text',
			'selector' => 'article .date'
		));

		$this->register_block_element(array(
			'id' => 'article-comments-link',
			'name' => 'Comments Link',
			'selector' => 'article a.entry-comments'
		));

		$this->register_block_element(array(
			'id' => 'article-comments-time',
			'name' => 'Time Text',
			'selector' => 'article .entry-time'
		));

		$this->register_block_element(array(
			'id' => 'article-time-since-wrapper',
			'name' => 'Time Since Wrapper',
			'selector' => 'article .time-since'
		));

		$this->register_block_element(array(
			'id' => 'article-time-since',
			'name' => 'Time Since Link',
			'selector' => 'article .time-since a'
		));

		$this->register_block_element(array(
			'id' => 'article-categories-wrapper',
			'name' => 'Categories Wrapper',
			'selector' => 'article .categories-wrap'
		));

		$this->register_block_element(array(
			'id' => 'article-categories',
			'parent' => 'article-categories-wrapper',
			'name' => 'Categories Links',
			'selector' => 'article a.categories'
		));

		$this->register_block_element(array(
			'id' => 'article-excerpt',
			'name' => 'Excerpt Text',
			'selector' => 'article .excerpt'
		));

		$this->register_block_element(array(
			'id' => 'articles-pagination',
			'name' => 'Pagination',
			'selector' => '.loop-navigation'
		));

		$this->register_block_element(array(
			'id' => 'articles-pagination-previous',
			'parent' => 'articles-pagination',
			'name' => 'Pagination Previous Link',
			'selector' => '.loop-navigation .nav-previous a'
		));

		$this->register_block_element(array(
			'id' => 'articles-pagination-next',
			'parent' => 'articles-pagination',
			'name' => 'Pagination Next Link',
			'selector' => '.loop-navigation .nav-next a'
		));
		
	}
	
	
}