<?php

class HeadwayUtilityBlock extends HeadwayBlockAPI {
	
	
	public $id = 'utility-block';
	
	public $name = 'Utility Block';
	
	public $options_class = 'HeadwayUtilityBlockOptions';
	
	static public $block = null;
	
	public $html_tag = 'div';

	public $description = 'Create blocks using shortcodes of many common page elements and then position and style them.';
	
	/**
	 * When this block's class is instantiated, we need to setup a few things
	 * for our shortcodes to work and also modify the html tag
	 **/
	function __construct() {
		$utility_blocks = HeadwayBlocksData::get_blocks_by_type('utility-block');
		
		/* add shortcodes */		
		add_shortcode('logo', array($this, 'logo_shortcode'));
		add_shortcode('tagline', array($this, 'tagline_shortcode'));
		add_shortcode('pagetitle', array($this, 'pagetitle_shortcode'));
		add_shortcode('page_subtitle', array($this, 'page_subtitle_shortcode'));
		add_shortcode('social', array($this, 'social_shortcode'));
		add_shortcode('menu', array($this, 'menu_shortcode'));
		add_shortcode('totop', array($this, 'totop_shortcode'));
		add_shortcode('datetime', array($this, 'datetime_shortcode'));
		add_shortcode('copyright', array($this, 'copyright_shortcode'));
		add_shortcode('search', array($this, 'search_shortcode'));
				
		/* return if there are not blocks for this type.. else do the foreach */
		if ( !isset($utility_blocks) || !is_array($utility_blocks) )
			return;
		
		foreach ($utility_blocks as $block_id => $layout_id) {
			$block = HeadwayBlocksData::get_block($block_id);
			$this->html_tag = $this->get_setting($block, 'block-html-tag');
		}
	}
		
	/**
	 * Use this to enqueue styles or scripts for your block.  This method will be execute when the block type is on 
	 * the current page you are viewing.  Also, not only is it page-specific, the method will execute for every instance
	 * of that block type on the current page.
	 * 
	 * This method will be executed at the WordPress 'wp' hook
	 *
	 * You would commonly use wordpress' wp_enqueue_script() and wp_enqueue_style() here
	 * 
	 **/ 
	function enqueue_action($block_id, $block = false) {
		/* get the block's data using the ID */					
		if ( !$block )
			$block = HeadwayBlocksData::get_block($block_id);

		wp_enqueue_style('headway-utility-block', plugins_url(basename(dirname(__FILE__))) . '/css/utility-styles.css');

		wp_enqueue_style('headway-utility-block-menu', plugins_url(basename(dirname(__FILE__))) . '/css/menus.css');

		/* SelectNav... Responsive Select */
			if ( HeadwayResponsiveGrid::is_active() && parent::get_setting($block, 'responsive-select', true) ) {

				wp_enqueue_script('headway-selectnav', headway_url() . '/library/blocks/navigation/js/selectnav.js', array('jquery'));

			}
		
		HeadwayNavigationBlock::enqueue_action($block_id, $block);	
						
	}
	
	
	/**
	 * Use this method to register sidebars, menus, or anything to that nature.  This method executes for every single block that
	 * has this method defined.
	 * 
	 * The method will execute for every single block on every single layout.
	 **/
	function init_action($block_id, $block = false) {
		
		$block = HeadwayBlocksData::get_block($block_id);
		
		/* since headway already has a navigation block that does what we need we may 
		 * as well call that blocks init_action() method as it will do what we need
		 */
		if (self::has_menu($block)) :
			return HeadwayNavigationBlock::init_action($block_id, $block);
		endif;
		
	}
	
	/**
	 * Use this to define elements with css selectors so users can style them in the design editor
	 * eg: add styling to the #logo selector
	 * Select from the following: array('fonts', 'text-shadow', 'box-shadow', 'background', 'borders', 'rounded-corners' )
	 **/
	function setup_elements() {
		
		$utility_blocks = HeadwayBlocksData::get_blocks_by_type('utility-block');
		
		/* return if there are not blocks for this type.. else do the foreach */
		if ( !isset($utility_blocks) || !is_array($utility_blocks) )
			return;
		
		/* The old way we do it before 3.4.5 multi instances */		
		foreach ($utility_blocks as $block_id => $layout_id) {
		
			$block = HeadwayBlocksData::get_block($block_id);
			$utilities = parent::get_setting($block, 'utilities');

			if ( method_exists( 'HeadwayBlocksData', 'get_legacy_id' ) ) { 
				$block_id = HeadwayBlocksData::get_legacy_id($block);
			}
		
			if (self::has_shortcode('/\[logo\]/', $utilities)) :
				$this->register_block_element(array(
					'id' => 'logo-text'.$block_id,
					'name' => 'Logo (block-'.$block_id.')',
					'selector' => '#utility-block-'.$block_id.' .logo-utility a',
					'properties' => array('fonts', 'background', 'borders', 'rounded-corners', 'box-shadow', 'text-shadow'),
					'supports-instances' => false
				));
			endif;
			
			if (self::has_shortcode('/\[tagline\]/', $utilities)) :
				$this->register_block_element(array(
					'id' => 'tagline-text'.$block_id,
					'name' => 'Tagline (block-'.$block_id.')',
					'selector' => '#utility-block-'.$block_id.' .tagline-utility',
					'properties' => array('fonts', 'background', 'borders', 'rounded-corners', 'box-shadow', 'text-shadow'),
					'supports-instances' => false
				));
			endif;
			
			if (self::has_shortcode('/\[menu\]/', $utilities)) :

				$this->register_block_element(array(
					'id' => 'menu-list-item'.$block_id,
					'name' => 'Top Level Menu Item (block-'.$block_id.')',
					'selector' => '#utility-block-'.$block_id.' .menu-utility ul.menu > li',
					'supports-instances' => false
				));
			
				$this->register_block_element(array(
					'id' => 'menu-item'.$block_id,
					'name' => 'Top Level Menu Link (block-'.$block_id.')',
					'selector' => '#utility-block-'.$block_id.' .menu-utility ul.menu li a',
					'states' => array(
						'Selected' => '
							#utility-block-' .$block_id. ' nav.menu-utility .menu .active, 
							#utility-block-' .$block_id. ' nav.menu-utility .menu .current_page_item a,
							#utility-block-' .$block_id. ' nav.menu-utility .menu li.current_page_parent > a, 
							#utility-block-' .$block_id. ' nav.menu-utility .menu li.current_page_ancestor > a',
						'Hover' => '
							#utility-block-' .$block_id. ' nav.menu-utility .menu li:hover,
							#utility-block-' .$block_id. ' nav.menu-utility .menu li.sfHover,
							#utility-block-' .$block_id. ' nav.menu-utility .menu a:focus,
							#utility-block-' .$block_id. ' nav.menu-utility .menu a:hover',
						'Clicked' => '
							#utility-block-' .$block_id. ' nav.menu-utility .menu .active, 
							#utility-block-'.$block_id.' .menu-utility ul.menu li a:active',
					),
					'supports-instances' => false
				));

				$this->register_block_element(array(
					'id' => 'sub-nav-menu'.$block_id,
					'name' => 'Sub Nav Drop Down (block-'.$block_id.')',
					'selector' => '#utility-block-'.$block_id.' .menu-utility ul.sub-menu',
					'properties' => array('background', 'borders', 'rounded-corners', 'box-shadow', 'text-shadow'),
					'supports-instances' => false
				));

				$this->register_block_element(array(
					'id' => 'sub-nav-menu-items'.$block_id,
					'name' => 'Drop Down Items (block-'.$block_id.')',
					'selector' => '#utility-block-' .$block_id. ' nav.menu-utility .sub-menu ul li',
					'properties' => array('background', 'borders', 'rounded-corners', 'box-shadow', 'text-shadow'),
					'states' => array(
						'Hover' => '
							#utility-block-' .$block_id. ' nav.menu-utility .menu ul li.sfHover,
							#utility-block-' .$block_id. ' nav.menu-utility .menu ul li a:focus,
							#utility-block-' .$block_id. ' nav.menu-utility .sub-menu li:hover,
							#utility-block-' .$block_id. ' nav.menu-utility .sub-menu li.sfHover,
							#utility-block-' .$block_id. ' nav.menu-utility .sub-menu a:focus,
							#utility-block-' .$block_id. ' nav.menu-utility .sub-menu a:hover'
					),
					'supports-instances' => false
				));
				
				$this->register_block_element(array(
					'id' => 'menu-item-link'.$block_id,
					'name' => 'Drop Down Item Link (block-'.$block_id.')',
					'selector' => '#utility-block-'.$block_id.' .menu-utility ul.sub-menu li a',
					'supports-instances' => false
				));
			endif;
			
			if (self::has_shortcode('/\[copyright\]/', $utilities)) :
				$this->register_block_element(array(
					'id' => 'copyright-text'.$block_id,
					'name' => 'Copyright Text (block-'.$block_id.')',
					'selector' => '#utility-block-'.$block_id.' .copyright-utility',
					'properties' => array('fonts', 'text-shadow'),
					'inherit-location' => 'inherit-text',
					'supports-instances' => false
				));
			endif;
			
			if (self::has_shortcode('/\[pagetitle\]/', $utilities)) :
				$this->register_block_element(array(
					'id' => 'pagetitle-text'.$block_id,
					'name' => 'Page Title Text (block-'.$block_id.')',
					'selector' => '#utility-block-'.$block_id.' .pagetitle-utility',
					'properties' => array('fonts', 'text-shadow'),
					'inherit-location' => 'inherit-text',
					'supports-instances' => false
				));
			endif;
			
			if (self::has_shortcode('/\[page_subtitle\]/', $utilities)) :
				$this->register_block_element(array(
					'id' => 'page_subtitle-text'.$block_id,
					'name' => 'Page Title Text (block-'.$block_id.')',
					'selector' => '#utility-block-'.$block_id.' .page_subtitle-utility',
					'properties' => array('fonts', 'text-shadow'),
					'inherit-location' => 'inherit-text',
					'supports-instances' => false
				));
			endif;
			
			if (self::has_shortcode('/\[search\]/', $utilities)) :
				$this->register_block_element(array(
					'id' => 'search-text'.$block_id,
					'name' => 'Search Input Box (block-'.$block_id.')',
					'selector' => '#utility-block-'.$block_id.' .search-utility input',
					'states' => array(
						'Focus' => '.search-utility input:focus'
					),
					'properties' => array('fonts', 'background', 'borders', 'rounded-corners', 'box-shadow'),
					'inherit-location' => 'inherit-text',
					'supports-instances' => false
				));
			endif;
			
			if (self::has_shortcode('/\[totop\]/', $utilities)) :
				$this->register_block_element(array(
					'id' => 'back-to-top-text'.$block_id,
					'name' => 'Go To Top Link (block-'.$block_id.')',
					'selector' => '#utility-block-'.$block_id.' .totop-utility',
					'states' => array(
						'Hover' => '#utility-block-'.$block_id.' .totop-utility:hover'
					),
					'properties' => array('fonts', 'background', 'borders', 'rounded-corners', 'box-shadow'),
					'inherit-location' => 'inherit-text',
					'supports-instances' => false
				));
			endif;
			
			if (self::has_shortcode('/\[datetime\]/', $utilities)) :
				$this->register_block_element(array(
					'id' => 'datetime-text'.$block_id,
					'name' => 'Date & Time Text (block-'.$block_id.')',
					'selector' => '#utility-block-'.$block_id.' .datetime-utility',
					'properties' => array('fonts', 'background', 'borders', 'rounded-corners', 'box-shadow'),
					'inherit-location' => 'inherit-text',
					'supports-instances' => false
				));
			endif;			
			
		}
	
	}
	
	/**
	 * Use this to insert dynamic JS into the page needed.  This is perfect for initializing instances of jQuery Cycle, jQuery Tabs, etc.
	 * You can mix in javascript with any php variables here
	 * The code added in here is output in the "headaway_general_css" css file
	 **/
	function dynamic_js($block_id, $block = false) {

		if ( !$block )
			$block = HeadwayBlocksData::get_block($block_id);
			$js = '';
			// add menu css if needed
			if (self::has_menu($block)) {
				//If there are no sub menus in the navigation, then do not output the Superfish JS.
				if ( self::does_menu_have_subs('navigation_block_' . $block_id) ) {
					$animation = parent::get_setting($block, 'superfish-animation', 'both');
					if ($animation == 'slide') :
						$animation = 'height:\'show\'';		
					elseif($animation == 'fade') :
						$animation = 'opacity:\'show\'';
					elseif($animation == 'both') :
						$animation = 'height:\'show\', opacity:\'show\'';
					endif;
					
					$speed = parent::get_setting($block, 'superfish-speed', '600');
					$delay = parent::get_setting($block, 'superfish-delay', '600');
					
					$js .= '
					jQuery(document).ready(function(){
					if ( typeof jQuery().superfish != "function" )
							return false; 
					jQuery("#block-' . $block_id . '").find("ul.menu").superfish({
						animation: {' . $animation . '},
						delay: '.$delay.',
						speed: '.$speed.',
						onBeforeShow: function() {
								var parent = jQuery(this).parent();
								
								var subMenuParentLink = jQuery(this).siblings(\'a\');
								var subMenuParents = jQuery(this).parents(\'.sub-menu\');

								if ( subMenuParents.length > 0 || jQuery(this).parents(\'.nav-vertical\').length > 0 ) {
									jQuery(this).css(\'marginLeft\',  parent.outerWidth());
									jQuery(this).css(\'marginTop\',  -subMenuParentLink.outerHeight());
								}
							}
						});		
					});
					' . "\n\n";
				}
				
				/* SelectNav */
				if ( HeadwayResponsiveGrid::is_active() && parent::get_setting($block, 'responsive-select', true) ) {

					$js .= 'jQuery(document).ready(function(){

						if ( typeof window.selectnav != "function" )
							return false;

						selectnav(jQuery("#block-' . $block_id . '").find("ul.menu")[0], {
							label: "-- ' . __('Navigation', 'headway') . ' --",
							nested: true,
							indent: "-",
							activeclass: "current-menu-item"
						});

						jQuery("#block-' . $block_id . '").find("ul.menu").addClass("selectnav-active");

					});' . "\n\n";

				}

			}
		return $js;
	}
	
	/**
	 * Use this to insert dynamic CSS into the page needed.  This is perfect for initializing instances of jQuery Cycle, jQuery Tabs, etc.
	 * You can mix in css with any php variables here
	 * The code added in here is output in the "headaway_general_css" css file
	 **/
	function dynamic_css($block_id, $block = false) {
		
		if ( !$block )
			$block = HeadwayBlocksData::get_block($block_id);
			
			
			$css= '';	
			$css .= '
			.utilities-wrapper {
				position: relative;
			}
			.utility {
				position: absolute;
			}';
			
			//first the menu
			$forcemenu = parent::get_setting($block, 'menu-options-force-right', false);
			$menuposition = $forcemenu ? 'right' : 'left';
			$menualign = $forcemenu ? 'menuright' : 'menuleft';
			if (parent::get_setting($block, 'menuright') || parent::get_setting($block, 'menuleft') || parent::get_setting($block, 'menutop')) :
				$css .= '#block-'.$block_id.' .menu-utility {position:'.(parent::get_setting($block, 'menu-positioning') == 1 ? 'static' : 'absolute').';'.$menuposition.':'.parent::get_setting($block, $menualign, '0').'px; top:'.parent::get_setting($block, 'menutop', '0').'px}';
			endif;
			
			
			if (parent::get_setting($block, 'logoleft') || parent::get_setting($block, 'logotop')) :
				$css .= '#block-'.$block_id.' .logo-utility {position:'.(parent::get_setting($block, 'logo-positioning') == 1 ? 'static' : 'absolute').';left:'.parent::get_setting($block, 'logoleft', '0').'px; top:'.parent::get_setting($block, 'logotop', '0').'px}';
			endif;
			if (parent::get_setting($block, 'taglineleft') || parent::get_setting($block, 'taglinetop')) :
				$css .= '#block-'.$block_id.' .tagline-utility {position:'.(parent::get_setting($block, 'tagline-positioning') == 1 ? 'static' : 'absolute').';left:'.parent::get_setting($block, 'taglineleft', '0').'px; top:'.parent::get_setting($block, 'taglinetop', '0').'px}';
			endif;
			if (parent::get_setting($block, 'copyrightleft') || parent::get_setting($block, 'copyrighttop')) :
				$css .= '#block-'.$block_id.' .copyright-utility {position:'.(parent::get_setting($block, 'copyright-positioning') == 1 ? 'static' : 'absolute').';left:'.parent::get_setting($block, 'copyrightleft', '0').'px; top:'.parent::get_setting($block, 'copyrighttop', '0').'px}';
			endif;
			if (parent::get_setting($block, 'pagetitleleft') || parent::get_setting($block, 'pagetitletop')) :
				$css .= '#block-'.$block_id.' .pagetitle-utility {position:'.(parent::get_setting($block, 'pagetitle-positioning') == 1 ? 'static' : 'absolute').';left:'.parent::get_setting($block, 'pagetitleleft', '0').'px; top:'.parent::get_setting($block, 'pagetitletop', '0').'px}';
			endif;
			if (parent::get_setting($block, 'page_subtitleleft') || parent::get_setting($block, 'page_subtitletop')) :
				$css .= '#block-'.$block_id.' .page_subtitle-utility {position:'.(parent::get_setting($block, 'page_subtitle-positioning') == 1 ? 'static' : 'absolute').';left:'.parent::get_setting($block, 'page_subtitleleft', '0').'px; top:'.parent::get_setting($block, 'page_subtitletop', '0').'px}';
			endif;
			if (parent::get_setting($block, 'socialleft') || parent::get_setting($block, 'socialtop')) :
				$css .= '#block-'.$block_id.' .social-utility {position:'.(parent::get_setting($block, 'social-positioning') == 1 ? 'static' : 'absolute').';left:'.parent::get_setting($block, 'socialleft', '0').'px; top:'.parent::get_setting($block, 'socialtop', '0').'px}';
			endif;
			if (parent::get_setting($block, 'searchleft') || parent::get_setting($block, 'searchtop')) :
				$css .= '#block-'.$block_id.' .search-utility {position:'.(parent::get_setting($block, 'search-positioning') == 1 ? 'static' : 'absolute').';left:'.parent::get_setting($block, 'searchleft', '0').'px; top:'.parent::get_setting($block, 'searchtop', '0').'px}';
			endif;
			if (parent::get_setting($block, 'totopleft') || parent::get_setting($block, 'totoptop')) :
				$css .= '#block-'.$block_id.' .totop-utility {position:'.(parent::get_setting($block, 'totop-positioning') == 1 ? 'static' : 'absolute').';left:'.parent::get_setting($block, 'totopleft', '0').'px; top:'.parent::get_setting($block, 'totoptop', '0').'px}';
			endif;
			if (parent::get_setting($block, 'datetimeleft') || parent::get_setting($block, 'datetimetop')) :
				$css .= '#block-'.$block_id.' .datetime-utility {position:'.(parent::get_setting($block, 'datetime-positioning') == 1 ? 'static' : 'absolute').';left:'.parent::get_setting($block, 'datetimeleft', '0').'px; top:'.parent::get_setting($block, 'datetimetop', '0').'px}';
			endif;
			
			if (parent::get_setting($block, 'block-min-height') != null) :
				$css .= '#block-'.$block_id.'.block {min-height:'.parent::get_setting($block, 'block-min-height', '0').'px;}';
			endif;
			
			$utilities = parent::get_setting($block, 'utilities');
			if (self::has_shortcode('/\[social\]/', $utilities)) :
				$css .= '#block-'.$block_id.' .social-utility li {
					margin-left: '.parent::get_setting($block, 'social-spacing', '10').'px;
				}
				';		
			endif;

			$responsive_assist_auto = parent::get_setting($block, 'responsive-assistance-auto', 1);
			$responsive_assist_center = parent::get_setting($block, 'responsive-assistance-center', 1);
			$max_width = parent::get_setting($block, 'responsive-max-width', '769');
			$responsive_spacing = parent::get_setting($block, 'responsive-spacing', '20');

			if ($responsive_assist_auto) :
				$css .= '
			@media only screen 
			and (max-width : ' . $max_width . 'px) {';

				if ($responsive_assist_center) {
					$css .= 'body #block-'.$block_id.' .social-utility,
					body #block-'.$block_id.' .menu-utility ul.menu {text-align: center;}
					#block-'.$block_id.' .utility {text-align: center}

					body #block-'.$block_id.' .social-utility li,
					body #block-'.$block_id.' .menu-utility ul.menu a,
					body #utility-block-'.$block_id.' .menu-utility ul.menu > li {display: inline-block; float: none}';
				}

				$css .= '
				#block-'.$block_id.' .utility {
					position: static;
					clear: both;
					display: block;
					margin: 0 0 '. $responsive_spacing .'px 0;
				}
			}
				';		
			endif;
		
		return $css;
		
	}
	

	/** 
	 * Output blocks content
	 **/
	function content($block) {
		/* this is a very important line of code. It sets the $block variable
		*  so it can be used anywhere in this class 
		*/
		self::$block = $block;
		
		$menuclass = (self::has_menu($block)) ? 'has-menu' : '';
		$content = parent::get_setting($block, 'utilities');	
			
		if ( $content != null ) : ?>
			<div id="utility-block-<?php echo $block['id']; ?>" class="utilities-wrapper clearfix<?php echo $menuclass; ?>">
				<?php echo headway_parse_php(do_shortcode(stripslashes($content))); ?>
			</div>
			<?php 
		else :
			echo '<div style="margin: 5px;" class="alert alert-yellow"><p>This is an empty Utility Builder Block. To get utilities to show up here. Open the Utility Builder Tab in the blocks settings and add one of the shortcodes. <strong>[logo] [tagline] [pagetitle]  [page_subtitle] [copyright] [menu] [search] [totop] [social] [datetime] </strong></p></div>';
		endif;
		
	}
	
	/* all methods from here down are custom for this block only */
	
	function does_menu_have_subs($location) {
		
		$menu = wp_nav_menu(array(
			'theme_location' => $location,
			'echo' => false
		));	
				
		if ( preg_match('/class=[\'"]sub-menu[\'"]/', $menu) || preg_match('/class=[\'"]children[\'"]/', $menu) )
			return true;
			
		return false;
		
	}
	
	function home_link_filter($menu) {
			
		$block = self::$block;
		
		if ( parent::get_setting($block, 'utility-hide-home-link') )
			return $menu;
		
		if ( get_option('show_on_front') == 'posts' ) {
	
			$current = (is_home() || is_front_page()) ? ' current_page_item' : null;
			$home_text = ( parent::get_setting($block, 'utility-home-link-text') ) ? parent::get_setting($block, 'utility-home-link-text') : 'Home';
	
			/* If it's not the grid, then do not add the extra <span>'s */
			if ( !HeadwayRoute::is_grid() && !headway_get('ve-live-content-query', $block) )
				$home_link = '<li class="menu-item-home' . $current . '"><a href="' . home_url() . '">' . $home_text . '</a></li>';
			
			/* If it IS the grid, add extra <span>'s so it can be automatically vertically aligned */
			else
				$home_link = '<li class="menu-item-home' . $current . '"><a href="' . home_url() . '"><span>' . $home_text . '</span></a></li>';
			
		} else {
			
			$home_link = null;
			
		}
	
		return $home_link . $menu;
		
	}
	
	
	function fix_legacy_nav($menu) {
		
		$menu = preg_replace('/<ul class=[\'"]children[\'"]/', '<ul class="sub-menu"', trim($menu)); //Change sub menu class
		$menu = preg_replace('/<div class=[\'"]menu[\'"]>/', '', $menu, 1); //Remove opening <div>
		$menu = str_replace('<ul>', '<ul class="menu">', $menu); //Add menu class to main <ul>
				
		return substr(trim($menu), 0, -6); //Remove the closing </div>
		
	}
	
	public static function has_shortcode($shortcode, $subject) {
		if (preg_match($shortcode, $subject)) :
			return true;			
		else:
			return false;
		endif;
	}
	
	public static function has_menu($block) {
		$utilities = parent::get_setting($block, 'utilities');
		return self::has_shortcode('/\[menu\]/', $utilities);
	}
	
	function logo_shortcode() {

		$block = self::$block;

		$logo_tag 			= parent::get_setting($block, 'logo-html-tag', 'h1');
		$logo_path 			= parent::get_setting($block, 'logo-image');
		$logo_class 		= !$logo_path ? 'text-logo' : 'image-logo';

		$blog_title = get_bloginfo('name');
		$logo_text = (parent::get_setting($block, 'logo-text') != '') ? parent::get_setting($block, 'logo-text') : $blog_title;
		$forced_logo_url = parent::get_setting($block, 'logo-alt-url');
		$logo_url = !empty($forced_logo_url) ? $forced_logo_url : home_url();
		
		$return = '
			<' . $logo_tag . ' class="logo-utility utility">
				<a href="' . $logo_url . '" class="logo ' . $logo_class . '">
			';

				if ( $logo_path )
					$return .= '<img src="' . $logo_path . '" alt="' . $blog_title .'" />';
				else
					$return .= $logo_text;

			$return .= '
				</a>
			</' . $logo_tag . '>
			';

		if (parent::get_setting($block, 'logo-show', '0') == 0)
			return $return;

	}
	
	function tagline_shortcode() { 
		$block = self::$block;
		$tagline = parent::get_setting($block, 'tagline-text');
		$blog_desc = get_bloginfo('description');
		$tagline = ($tagline == null) ? $blog_desc : $tagline;
		$return = '';
		$return .= '<h2 class="h5 tagline-utility utility">'
			. $tagline .
		'</h2>';

		if (parent::get_setting($block, 'tagline-show', '0') == 0)
			return $return;
	}
	
	function pagetitle_shortcode()
	{
		global $post;
		$block = self::$block;
		$markup = parent::get_setting($block, 'pagetitle-markup', 'h1');
		if (!wp_title('',false,'')) :
			if (HeadwayLayoutOption::get($post->ID, 'page_title_alias', false, true)) :
				$title = HeadwayLayoutOption::get($post->ID, 'page_title_alias', false, true);			
			else :
				$title = 'Current Page Title';
			endif;
		else: 
			$wptitle = wp_title('',false,'');
			if (HeadwayLayoutOption::get($post->ID, 'page_title_alias', false, true) == false) :
				/* headway adds | site name by default after the page title by modifying wp_title
				 * so we have to remove this for us to get only the page title*/
				$title = substr($wptitle, 0, strpos($wptitle, "|"));
			else :
				$title = HeadwayLayoutOption::get($post->ID, 'page_title_alias', false, true);
			endif;
		endif;
		if (parent::get_setting($block, 'pagetitle-show', '0') == 0)
			return '<'.$markup.' class="pagetitle-utility utility">'.$title.'</'.$markup.'>';
	}
	
	function page_subtitle_shortcode()
	{
		global $post;
		$block = self::$block;
		$markup = parent::get_setting($block, 'page_subtitle-markup', 'h2');
		if (!HeadwayLayoutOption::get($post->ID, 'page_sub_title_alias', false, true)) :
			$title = 'Sub title placeholder | Add text in the post sub title options to add here';
		else :
			$title = HeadwayLayoutOption::get($post->ID, 'page_sub_title_alias', false, true);
		endif;
		if (parent::get_setting($block, 'page_subtitle-show', '0') == 0)
			return '<'.$markup.' class="page_subtitle-utility utility">'.$title.'</'.$markup.'>';
	}
	
	function totop_shortcode()
	{
		$return = '';
		$block = self::$block;
		$text = parent::get_setting($block, 'to-top-text', 'Back to top');
		$totop_img = parent::get_setting($block, 'totop-img');?>
		<?php 
			if ($totop_img == null) : ?>
			<?php $return .= '<a class="totop-utility utility" href="#">' . $text . '</a>'; ?>
		<?php elseif ($totop_img != null) : 
		$return .= '<a class="totop-utility utility" href="#"><img src="' . $totop_img . '" alt="' . $text .'" /></a>';?>
		<?php endif;
		if (parent::get_setting($block, 'totop-show', '0') == 0)
			return $return;
	}
	
	function menu_shortcode()
	{
		$block = self::$block;
		/* Add filter to add home link */
		add_filter('wp_nav_menu_items', array(__CLASS__, 'home_link_filter'));
		add_filter('wp_list_pages', array(__CLASS__, 'home_link_filter'));
		add_filter('wp_page_menu', array(__CLASS__, 'fix_legacy_nav'));
		
		/* Variables */
		$vertical = parent::get_setting($block, 'utility-vert-nav-box', false);
		$alignment = parent::get_setting($block, 'utility-alignment', 'left');
				
		/* Classes */
		$nav_classes = array();
		
		$nav_classes[] = $vertical ? 'nav-vertical' : 'nav-horizontal';
		$nav_classes[] = 'nav-align-' . $alignment;
		
			
		$nav_classes = trim(implode(' ', array_unique($nav_classes)));
		$nav_location = 'navigation_block_' . $block['id'];
		$return = '';
		$return .=  '<nav role="navigation" class="' . $nav_classes . ' menu-utility utility">';
		
				$nav_menu_args = array(
					'theme_location' => $nav_location,
					'menu_class' => 'menu superfish clearfix',
					'container_class' => 'superfish clearfix',
					'echo' => false
				);
				
				if ( HeadwayRoute::is_grid() || headway_get('ve-live-content-query', $block) ) {
					
					$nav_menu_args['link_before'] = '<span>';
					$nav_menu_args['link_after'] = '</span>';
					
				}
			
				$return .= wp_nav_menu(apply_filters('headway_navigation_block_query_args', $nav_menu_args, $block));
		
		$return .= '</nav><!-- .' . $nav_classes . ' -->';		
				
		/* Remove filter for home link so other non-navigation blocks are modified */
		remove_filter('wp_nav_menu_items', array(__CLASS__, 'home_link_filter'));
		remove_filter('wp_list_pages', array(__CLASS__, 'home_link_filter'));
		remove_filter('wp_page_menu', array(__CLASS__, 'fix_legacy_nav'));
		
		if (parent::get_setting($block, 'menu-show', '0') == 0)
			return $return;
	}
	
	function datetime_shortcode() {
		$block = self::$block;
		$format = parent::get_setting($block, 'datetime-format', "Y-m-d, t");
		if (parent::get_setting($block, 'datetime-show', '0') == 0)
			return '<div class="datetime-utility utility">' . date_i18n($format) . '</div>';
	}
	
	function social_shortcode() {
		$block = self::$block;
		$count = 11;	
		for ($i = 1; $i < $count; $i++) {
			if ($i == 1) :
				$def_title = "twitter";
				$def_link = "http://www.twitter.com/";	
			else :
				$def_title = "";
				$def_link = "";
			endif;
			$social_title{$i} = parent::get_setting($block, "social-title".$i."", $def_title);
			$social_link{$i}	= parent::get_setting($block, "social-link".$i."", $def_link);
			$social_image{$i}	= parent::get_setting($block, "social-image".$i."");
			$social_class{$i} 	= parent::get_setting($block, "social-class".$i."");
			$social_class{$i} 	= ($social_class{$i} == '') ? '' : 'class="' . $social_class{$i} . '"';
			$social_text{$i} = ($social_image{$i} != '') ? '<img src="' . $social_image{$i} . '" alt="' . $social_title{$i} . '" />' : $social_title{$i};
			$social_new_window = parent::get_setting($block, "social-new-window", false);
		}
		
		$return = '<ul class="social-utility utility">';
		for ($i = 1; $i < $count; $i++) {
			$firstclass = ($i == 1) ? 'class="first"' : '';
			$new_window = ($social_new_window) ? 'target="_blank"' : '';
			if ($social_link{$i} || $social_title{$i} || $social_image{$i}) :
				$return .= '<li '.$firstclass.'><a href="' . $social_link{$i} . '" ' . $social_class{$i} . ' title="' . $social_title{$i} . '" ' . $new_window . '>' . $social_text{$i} . '</a></li>';		
			endif;
		}
		$return .= '</ul>';
		if (parent::get_setting($block, 'social-show', '0') == 0)
			return $return;
		
	}
	
	function search_shortcode() {
		$block = self::$block;
		$text = parent::get_setting($block, 'search-text', 'search for something...');
		if (parent::get_setting($block, 'search-show', '0') == 0)
			return '<form method="get" id="searchform" action="'. esc_url( home_url( '/' ) ) .'" class="search-utility utility">
				<input type="text" id="s" name="s" value="'. $text .'" onfocus="if(this.value==&apos;'. $text .'&apos;)this.value=&apos;&apos;;" onblur="if(this.value==&apos;&apos;)this.value=&apos;'. $text .'&apos;;">
				<!--<input type="submit" value="Search" id="searchsubmit">-->
			</form>';
	}
	
	function copyright_shortcode() {
		$block = self::$block;
		$text = parent::get_setting($block, 'copyright-text');
		$copyright = '<div class="copyright-utility utility">';
		if (empty($text)) :
			$copyright .= __('Copyright', 'headway') . ' &copy; ' . date('Y') . ' ' . get_bloginfo('name');
		else :
			$copyright .= $text;
		endif;
		$copyright .= '</div>';
		if (parent::get_setting($block, 'copyright-show', '0') == 0)
			return $copyright;
	}
	
	//a helper method to get a value to use in other block files
	public static function get_setting($block, $setting, $default = null) {
		return parent::get_setting($block, $setting, $default);
	}

}