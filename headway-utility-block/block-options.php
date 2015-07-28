<?php
	
class HeadwayUtilityBlockOptions extends HeadwayBlockOptionsAPI {

	function __construct() {
		$this->set_social_inputs();
	}	
	
	/* I found this useful method modify_arguments() in the headway files. Useful to modify the arguments of the options class
	 * we will use this to add a more dynamic messages to the menu page
	 * we will also use this to fix an issue where the slider max-height needs to be equal to the 
	 * blocks height set in the editor. So we can get the blocks height and then modify this parameter
	 */
	function modify_arguments($args) {
		
		/* modify tabs */
		$this->tab_notices['menu-options'] = 'To add items to this navigation menu, go to <a href="' . admin_url('nav-menus.php') . '" target="_blank">WordPress Admin &raquo; Appearance &raquo; Menus</a>.  Then, create a menu and assign it to <em>' . HeadwayBlocksData::get_block_name($args['block_id']) . '</em> in the <strong>Theme Locations</strong> box.';
		
		$this->tab_notices['utility-builder-options'] = '
			<a href="" class="addtag" rel="[logo]" active="0">logo</a>
			<a href="" class="addtag" rel="[tagline]" active="0">tagline</a>
			<a href="" class="addtag" rel="[pagetitle]" active="0">pagetitle</a>
			<a href="" class="addtag" rel="[page_subtitle]" active="0">page_subtitle</a>
			<a href="" class="addtag" rel="[social]" active="0">social</a>
			<a href="" class="addtag" rel="[menu]" active="0">menu</a>
			<a href="" class="addtag" rel="[copyright]" active="0">copyright</a>
			<a href="" class="addtag" rel="[search]" active="0">search</a>
			<a href="" class="addtag" rel="[totop]" active="0">totop</a>
			<a href="" class="addtag" rel="[datetime]" active="0">datetime</a>
		
				<script type="text/javascript">
						//TODO: find better place to include this JS
						(function($) {
							$(document).ready(function() {
								var value = $("#block-' . $args['block_id'] . '-tab #input-utilities textarea").text();
								addRemoveOptions(value, "' . $args['block_id'] . '");
								addHeadings("' . $args['block_id'] . '");
								
								//add tags on click
								var block'.$args['block_id'].'textarea = $("#input-'.$args['block_id'].'-utilities");
								var block'.$args['block_id'].'toggler = $("#block-'.$args['block_id'].'-tab .sub-tabs-content a.addtag");

								$(".addtag").each(function(){
									var addval = $(this).attr("rel");
									var isContains = $(block'.$args['block_id'].'textarea).val().indexOf(addval) > -1;
									if(isContains)
									$(this).attr("active", "1").addClass("active");
								})
																
								block'.$args['block_id'].'toggler.click(function() {
									var active = $(this).attr("active");
									var addval = $(this).attr("rel");
									
									if(active == 0) {
										$(this).attr("active", "1").addClass("active");
										var origin'.$args['block_id'].' = block'.$args['block_id'].'textarea.val();
										block'.$args['block_id'].'textarea.val(origin'.$args['block_id'].' +  addval)
									} else if(active == 1) {
										$(this).attr("active", "0").removeClass("active");
										block'.$args['block_id'].'textarea.val( block'.$args['block_id'].'textarea.val().replace(addval, "") );
									}
								
									//force save 
									block'.$args['block_id'].'textarea.focus()
									block'.$args['block_id'].'toggler.focus()
									return false;
								});
								
								
							});
						})(jQuery);
				</script>
		';
		
		/* modify inputs */
		$this->inputs['utility-builder-options']['builder-input'] = array(
			'type' => 'textarea',
			'name' => 'utilities',
			'label' => 'Utility Builder',
			'default' => '',
			'callback' => 'addRemoveOptions(value, "' . $args['block_id'] . '")'
		);
		
		$this->inputs['datetime-options']['datetime-format-field']['options'] = array(
			'wordpress-default' => 'WordPress Default',
			'F j, Y' => date('F j, Y'),
			'm/d/y' => date('m/d/y'),
			'd/m/y' => date('d/m/y'),
			'M j' => date('M j'),
			'M j, Y' => date('M j, Y'),
			'F j' => date('F j'),
			'F jS' => date('F jS'),
			'F jS, Y' => date('F jS, Y')
		);
		
		/* changed as per note on Headway 3.5 */
		$block = HeadwayBlocksData::get_block($args['block']);
						
		/* set max-height for slider based on actual block heights */
		$height = (HeadwayUtilityBlock::get_setting($block, 'block-min-height')) ? HeadwayUtilityBlock::get_setting($block, 'block-min-height') : HeadwayBlocksData::get_block_height($block);
		
		$this->inputs['logo-options']['logo-options-input-top-offset']['slider-max'] = $height;
		$this->inputs['tagline-options']['tagline-options-input-top-offset']['slider-max'] = $height;
		$this->inputs['pagetitle-options']['pagetitle-options-input-top-offset']['slider-max'] = $height;
		$this->inputs['page_subtitle-options']['page_subtitle-options-input-top-offset']['slider-max'] = $height;
		$this->inputs['copyright-options']['copyright-options-input-top-offset']['slider-max'] = $height;
		$this->inputs['menu-options']['menu-options-input-top-offset']['slider-max'] = $height;
		$this->inputs['search-options']['search-options-input-top-offset']['slider-max'] = $height;
		$this->inputs['totop-options']['totop-options-input-top-offset']['slider-max'] = $height;
		$this->inputs['social-options']['social-options-input-top-offset']['slider-max'] = $height;
		$this->inputs['datetime-options']['datetime-options-input-top-offset']['slider-max'] = $height; 
		
	}
	public $tab_notices = array(
		'logo-options' => 'These settings control the Logo element added using the [logo] shortcode.',
//		'datetime-options' => 'This uses <a title="view date info" target="_blank" href="http://php.net/manual/en/function.date.php">standard php date format codes</a>. You can follow these guidelines outlined on that page to format the date. Some examples: "Y-m-d, t" or "D M j G:i:s Y" or "F j, Y, g:i a" or "l jS \of F Y"',
		'utility-builder-options' => '',
			
			);
			
	
	public $tabs = array(
		'utility-builder-options' => "Utility Builder",
		'responsive' => 'Responsive',
		'logo-options' 			=> 'Logo Options',
		'tagline-options' 		=> 'Tagline Options',
		'pagetitle-options'		=> 'Page Title Options',
		'page_subtitle-options'	=> 'Page Sub Title Options',
		'copyright-options'		=> 'Copyright Options',
		'social-options'			=> 'Social Options',
		'menu-options'				=> 'Menu Options',
		'totop-options'			=> 'To Top Options',
		'datetime-options'		=> 'Date and Time Options',
		'search-options'			=> 'Search Input Options',
		
	);

	public $inputs = array(
		'utility-builder-options' => array(
			
			'builder-input' => array(
				'type' => 'textarea',
				'name' => 'utilities',
				'label' => 'Utility Builder',
				'default' => '',
				'callback' => "addRemoveOptions(value)"
			),
			
			'block-html-tag' => array(
				'type' => 'select',
				'name' => 'block-html-tag',
				'label' => 'HTML tag for this block\'s container',
				'tooltip' => 'Select the most appropriate html tag for this blocks content. If you have a logo and tagline, then its best to set it to "header" and if you are adding credits and a footer nav, set it to "footer" for example. If you use "section" be sure that the block has an H1 heading first to name the section as per HTML5 specs',
				'options' => array(
					'div' => '&lt;div&gt;',
					'section' => '&lt;section&gt;',
					'header' => '&lt;header&gt;',
					'footer' => '&lt;footer&gt;',
					'aside' => '&lt;aside&gt;',
				),
			),
			
			'block-min-height' => array(
				'type' => 'text',
				'name' => 'block-min-height',
				'label' => 'Set Block Minimum Height',
				'default' => false,
				'callback' => '
					id = $(input).attr("block_id");
					stylesheet.update_rule("#block-" + id + ".block", {"min-height": $(input).attr("value") + "px"});
				',
				'tooltip' => 'If you set a value here, it will override the default headway block height created in the grid builder with this value. This is needed if .'
			),
			
		),

		'responsive' => array(
			
			'responsive-assistance-auto' => array(
				'type' => 'checkbox',
				'name' => 'responsive-assistance-auto',
				'label' => 'Enable Responsive Assistance',
				'default' => 1,
				'tooltip' => 'If selected, all utilities arrangement in the block will change at the specified max width you set. Utilities loose all positioning settings and will stack ontop of each other.',
				'toggle'    => array(
					'true' => array(
						'show' => array(
							'#input-responsive-max_width',
							'#input-responsive-assistance-center',
							'#input-responsive-spacing'
						),
					),
					'false' => array(
						'hide' => array(
							'#input-responsive-max_width',
							'#input-responsive-assistance-center',
							'#input-responsive-spacing'
						),
					)
				),
			),

			'responsive-max-width' => array(
				'type' => 'slider',
				'name' => 'responsive-max-width',
				'label' => 'Max width ',
				'default' => 769,
				'slider-min' => 0,
				'slider-max' => 1200,
				'slider-interval' => 1,
				'unit' => 'px',
			),

			'responsive-assistance-center' => array(
				'type' => 'checkbox',
				'name' => 'responsive-assistance-center',
				'default' => 1,
				'label' => 'Center Utilities',
				'tooltip' => 'This will center all utilities on the page when the browser is smaller than the specified max width.'
			),

			'responsive-spacing' => array(
				'type' => 'text',
				'name' => 'responsive-spacing',
				'label' => 'Bottom spacing',
				'default' => '20',
				'tooltip' => 'Sets the vertical spacing between utilities.'
			)
			
		),

		'logo-options' => array(
		
			'logo-show' => array(
				'type' => 'checkbox',
				'name' => 'logo-show',
				'label' => 'Hide [logo]',
				'default' => 0,
				'tooltip' => 'If selected, this utility will be hidden even if you have the [logo] shortcode in the builder. Ideal for testing without having to add and remove the code each time '
			),
			
			'logo-html-tag' => array(
				'type' => 'select',
				'name' => 'logo-html-tag',
				'label' => 'Logo title heading HTML tag',
				'options' => array(
					'h1' => '&lt;H1&gt;',
					'h2' => '&lt;H2&gt;',
					'h3' => '&lt;H3&gt;',
					'h4' => '&lt;H4&gt;',
					'h5' => '&lt;H5&gt;',
					'h6' => '&lt;H6&gt;',
					'span' => '&lt;span&gt;'
				)
			),
			
			'logo-disable-positioning' => array(
				'type' => 'checkbox',
				'name' => 'logo-positioning',
				'label' => 'Disable Positioning',
				'tooltip' => 'If selected you will need to manually add CSS to position this utility',
				'callback' => '
					togglePositioning(value, block, "logo", input);
				'
			),
			
			'logo-options-input' => array(
				'type' => 'slider',
				'name' => 'logoleft', //This will be the setting you retrieve from the database.
				'label' => 'Logo Left Position',
				'default' => 0,
				'slider-min' => 0,
				'slider-max' => 940,
				'slider-interval' => 1,
				'unit' => 'px'
			),
			'logo-options-input-top-offset' => array(
				'type' => 'slider',
				'name' => 'logotop', //This will be the setting you retrieve from the database.
				'label' => 'Logo Top Position',
				'default' => 0,
				'slider-min' => 0,
				'slider-max' => 900,
				'slider-interval' => 1,
				'unit' => 'px'
			),
			
			'logo-text' => array(
				'type' => 'text',
				'name' => 'logo-text',
				'label' => 'Logo Text',
				'default' => false,
				'tooltip' => 'Set text for the logo, if left blank it will use the site name. It is important to set this even if you are using an image as it is the text that will be seen when images are disabled and will form a text based logo fallback.'
			),

			'logo-alt-url' => array(
				'type' => 'text',
				'name' => 'logo-alt-url',
				'label' => 'Logo Alternat URL',
				'default' => false,
				'tooltip' => 'Set a different url for the logo.'
			),
			
			'logo-image' => array(
				'type' => 'image',
				'name' => 'logo-image',
				'label' => 'Logo Image',
				'tooltip' => 'Select an image for the logo.',
				'default' => null
			),
			
		),
		
		'tagline-options' => array(
		
			'tagline-show' => array(
				'type' => 'checkbox',
				'name' => 'tagline-show',
				'default' => 0,
				'label' => 'Hide [tagline]',
				'tooltip' => 'If selected, this utility will be hidden even if you have the [tagline] shortcode in the builder. Ideal for testing without having to add and remove the code each time ',
				'options' => array(
					0 => 'No',
					1 => 'Yes',
				)
			),
			
			'tagline-text' => array(
				'type' => 'text',
				'name' => 'tagline-text',
				'label' => 'Set Tagline Text',
				'default' => false, //bloginfo('description'),
				'tooltip' => 'Set text for the tagline, if left blank it will use the site description.'
			),
			
			'tagline-disable-positioning' => array(
				'type' => 'checkbox',
				'name' => 'tagline-positioning',
				'label' => 'Disable Positioning',
				'tooltip' => 'If selected you will need to manually add CSS to position this utility',
				'callback' => '
					togglePositioning(value, block, "tagline", input);
				'
			),
			
			'tagline-options-input' => array(
				'type' => 'slider',
				'name' => 'taglineleft', //This will be the setting you retrieve from the database.
				'label' => 'Tagline Left Position',
				'default' => 0,
				'slider-min' => 0,
				'slider-max' => 940,
				'slider-interval' => 1,
				'unit' => 'px'
			),
			'tagline-options-input-top-offset' => array(
				'type' => 'slider',
				'name' => 'taglinetop', //This will be the setting you retrieve from the database.
				'label' => 'Tagline Top Position',
				'default' => 0,
				'slider-min' => 0,
				'slider-max' => 900,
				'slider-interval' => 1,
				'unit' => 'px'
			)
		),
		
		'copyright-options' => array(
		
			'copyright-show' => array(
				'type' => 'checkbox',
				'name' => 'copyright-show',
				'label' => 'Hide [copyright]',
				'default' => 0,
				'tooltip' => 'If selected, this utility will be hidden even if you have the [copyright] in the builder. Ideal for testing without having to add and remove the code each time ',
				'options' => array(
					0 => 'No',
					1 => 'Yes',
				)
			),
			
			'copyright-text-field' => array(
				'type' => 'text',
				'name' => 'copyright-text',
				'label' => 'Set Copyright Text',
				'default' => '',
				'tooltip' => 'Set text for the copyright, if left blank it will use "Copyright © {this year} {sitename}".'
			),
			
			'copyright-disable-positioning' => array(
				'type' => 'checkbox',
				'name' => 'copyright-positioning',
				'label' => 'Disable Positioning',
				'tooltip' => 'If selected you will need to manually add CSS to position this utility',
				'callback' => '
					togglePositioning(value, block, "copyright", input);
				'
			),
			
			'copyright-options-input' => array(
				'type' => 'slider',
				'name' => 'copyrightleft', //This will be the setting you retrieve from the database.
				'label' => 'Copyright Left Position',
				'default' => 0,
				'slider-min' => 0,
				'slider-max' => 940,
				'slider-interval' => 1,
				'unit' => 'px'
			),
			'copyright-options-input-top-offset' => array(
				'type' => 'slider',
				'name' => 'copyrighttop', //This will be the setting you retrieve from the database.
				'label' => 'Copyright Top Position',
				'default' => 0,
				'slider-min' => 0,
				'slider-max' => 900,
				'slider-interval' => 1,
				'unit' => 'px'
			),
			
		),
		
		'pagetitle-options' => array(
		
			'pagetitle-show' => array(
				'type' => 'checkbox',
				'name' => 'pagetitle-show',
				'label' => 'Hide [pagetitle]',
				'default' => 0,
				'tooltip' => 'If selected, this utility will be hidden even if you have the [pagetitle] in the builder. Ideal for testing without having to add and remove the code each time ',
				'options' => array(
					0 => 'No',
					1 => 'Yes',
				)
			),
			
			'pagetitle-markup' => array(
				'type' => 'select',
				'name' => 'pagetitle-markup',
				'label' => 'Page title heading markup',
				'options' => array(
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6'
				),
				'default' => 'h1'
			),
			
			'pagetitle-disable-positioning' => array(
				'type' => 'checkbox',
				'name' => 'pagetitle-positioning',
				'label' => 'Disable Positioning',
				'tooltip' => 'If selected you will need to manually add CSS to position this utility',
				'callback' => '
					togglePositioning(value, block, "pagetitle", input);
				'
			),
			
			'pagetitle-options-input' => array(
				'type' => 'slider',
				'name' => 'pagetitleleft', //This will be the setting you retrieve from the database.
				'label' => 'Page Title Left Position',
				'default' => 0,
				'slider-min' => 0,
				'slider-max' => 940,
				'slider-interval' => 1,
				'unit' => 'px'
			),
			'pagetitle-options-input-top-offset' => array(
				'type' => 'slider',
				'name' => 'pagetitletop', //This will be the setting you retrieve from the database.
				'label' => 'Page Title Top Position',
				'default' => 0,
				'slider-min' => 0,
				'slider-max' => 900,
				'slider-interval' => 1,
				'unit' => 'px'
			),
			
		),
		
		'page_subtitle-options' => array(
		
			'page_subtitle-show' => array(
				'type' => 'checkbox',
				'name' => 'page_subtitle-show',
				'label' => 'Hide [page_subtitle]',
				'default' => 0,
				'tooltip' => 'If selected, this utility will be hidden even if you have the [page_subtitle] in the builder. Ideal for testing without having to add and remove the code each time ',
				'options' => array(
					0 => 'No',
					1 => 'Yes',
				)
			),
			
			'page_subtitle-markup' => array(
				'type' => 'select',
				'name' => 'page_subtitle-markup',
				'label' => 'Page title heading markup',
				'options' => array(
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6'
				)
			),
			
			'page_subtitle-disable-positioning' => array(
				'type' => 'checkbox',
				'name' => 'page_subtitle-positioning',
				'label' => 'Disable Positioning',
				'tooltip' => 'If selected you will need to manually add CSS to position this utility',
				'callback' => '
					togglePositioning(value, block, "page_subtitle", input);
				'
			),
			
			'page_subtitle-options-input' => array(
				'type' => 'slider',
				'name' => 'page_subtitleleft', //This will be the setting you retrieve from the database.
				'label' => 'Page Title Left Position',
				'default' => 0,
				'slider-min' => 0,
				'slider-max' => 940,
				'slider-interval' => 1,
				'unit' => 'px'
			),
			'page_subtitle-options-input-top-offset' => array(
				'type' => 'slider',
				'name' => 'page_subtitletop', //This will be the setting you retrieve from the database.
				'label' => 'Page Title Top Position',
				'default' => 0,
				'slider-min' => 0,
				'slider-max' => 900,
				'slider-interval' => 1,
				'unit' => 'px'
			),
			
		),
		
		'social-options' => array(
			
//			'social-item-count' => array(
//				'type' => 'select',
//				'name' => 'social-item-count',
//				'label' => 'Number of items to configure',
//				'options' => array(
//					'1' => '1',
//					'2' => '2',
//					'3' => '3',
//					'4' => '4',
//					'5' => '5',
//					'6' => '6'
//				)
//			),

			'social-show' => array(
				'type' => 'checkbox',
				'name' => 'social-show',
				'label' => 'Hide [social]',
				'default' => 0,
				'tooltip' => 'If selected, this utility will be hidden even if you have the [social] in the builder. Ideal for testing without having to add and remove the code each time ',
				'options' => array(
					0 => 'No',
					1 => 'Yes',
				)
			),
			
			'social-disable-positioning' => array(
				'type' => 'checkbox',
				'name' => 'social-positioning',
				'label' => 'Disable Positioning',
				'tooltip' => 'If selected you will need to manually add CSS to position this utility',
				'callback' => '
					togglePositioning(value, block, "social", input);
				'
			),
			
			'social-options-input' => array(
				'type' => 'slider',
				'name' => 'socialleft', //This will be the setting you retrieve from the database.
				'label' => 'Social Left Position',
				'default' => 0,
				'slider-min' => 0,
				'slider-max' => 940,
				'slider-interval' => 1,
				'unit' => 'px'
			),
			'social-options-input-top-offset' => array(
				'type' => 'slider',
				'name' => 'socialtop', //This will be the setting you retrieve from the database.
				'label' => 'Social Top Position',
				'default' => 0,
				'slider-min' => 0,
				'slider-max' => 900,
				'slider-interval' => 1,
				'unit' => 'px',
				'callback' => '
					var social = block.find(".block-content .social-utility");
					id = social.parent().parent().parent().attr("id");
					stylesheet.update_rule("#" + id + " .social-utility", {"top": $(input).attr("value") + "px"});
				'
			),
			'social-spacing' => array(
				'type' => 'slider',
				'name' => 'social-spacing', //This will be the setting you retrieve from the database.
				'label' => 'Spacing between icons',
				'default' => 10,
				'slider-min' => 0,
				'slider-max' => 100,
				'slider-interval' => 5,
				'callback' => '
					id = $(input).attr("block_id");
					stylesheet.update_rule("#block-" + id + ".block .social-utility li", {"margin-left": $(input).attr("value") + "px"});
					stylesheet.update_rule("#block-" + id + ".block .social-utility li.first", {"margin-left": "0px"});
				'
			),

			'social-new-window' => array(
				'type' => 'checkbox',
				'name' => 'social-new-window',
				'label' => 'Open in new window?',
			)
						
		),
		
		'totop-options' => array(
		
			'totop-show' => array(
				'type' => 'checkbox',
				'name' => 'totop-show',
				'label' => 'Hide [totop]',
				'default' => 0,
				'tooltip' => 'If selected, this utility will be hidden even if you have the [totop] in the builder. Ideal for testing without having to add and remove the code each time ',
				'options' => array(
					0 => 'No',
					1 => 'Yes',
				)
			),
			
			'totop-text-field' => array(
				'type' => 'text',
				'name' => 'to-top-text',
				'label' => 'Set To Top Text',
				'default' => null,
				'callback' => "block.find('.block-content .totop-utility input').text(value)",
				'tooltip' => 'Set text for the back to top link.'
			),
			
			'totop-disable-positioning' => array(
				'type' => 'checkbox',
				'name' => 'totop-positioning',
				'label' => 'Disable Positioning',
				'tooltip' => 'If selected you will need to manually add CSS to position this utility',
				'callback' => '
					togglePositioning(value, block, "totop", input);
				'
			),
			
			'totop-options-input' => array(
				'type' => 'slider',
				'name' => 'totopleft', //This will be the setting you retrieve from the database.
				'label' => 'ToTop Left Position',
				'default' => 0,
				'slider-min' => 0,
				'slider-max' => 940,
				'slider-interval' => 1,
				'unit' => 'px'
			),
			'totop-options-input-top-offset' => array(
				'type' => 'slider',
				'name' => 'totoptop', //This will be the setting you retrieve from the database.
				'label' => 'ToTop Top Position',
				'default' => 0,
				'slider-min' => 0,
				'slider-max' => 900,
				'slider-interval' => 1,
				'unit' => 'px',
				'callback' => '
					var totop = block.find(".block-content .totop-utility");
					id = totop.parent().parent().parent().attr("id");
					stylesheet.update_rule("#" + id + " .totop-utility", {"top": $(input).attr("value") + "px"});
				'
			),
			'totop-img' => array(
				'type' => 'image',
				'name' => 'totop-img',
				'label' => 'To Top Image',
				'tooltip' => 'Select an image for the back to top link. If you select an icon/image the image will replace the text. If images are disabled, then the text will show instead of the image.',
				'default' => null
			),
			
		),
		
		'search-options' => array(
		
			'search-show' => array(
				'type' => 'checkbox',
				'name' => 'search-show',
				'label' => 'Hide [search]',
				'default' => 0,
				'tooltip' => 'If selected, this utility will be hidden even if you have the [search] in the builder. Ideal for testing without having to add and remove the code each time ',
				'options' => array(
					0 => 'No',
					1 => 'Yes',
				)
			),
			
			'search-text-field' => array(
				'type' => 'text',
				'name' => 'search-text',
				'label' => 'Set search text',
				'default' => 'Search for something..',
				'width'		=> '300',
				'callback' => "block.find('.block-content .search-utility input').value(value)",
				'tooltip' => 'Set text for the search'
			),
			
			'search-disable-positioning' => array(
				'type' => 'checkbox',
				'name' => 'search-positioning',
				'label' => 'Disable Positioning',
				'tooltip' => 'If selected you will need to manually add CSS to position this utility',
				'callback' => '
					togglePositioning(value, block, "search", input);
				'
			),
			
			'search-options-input' => array(
				'type' => 'slider',
				'name' => 'searchleft', //This will be the setting you retrieve from the database.
				'label' => 'Search Left Position',
				'default' => 0,
				'slider-min' => 0,
				'slider-max' => 940,
				'slider-interval' => 1,
				'unit' => 'px'
			),
			'search-options-input-top-offset' => array(
				'type' => 'slider',
				'name' => 'searchtop', //This will be the setting you retrieve from the database.
				'label' => 'Search Top Position',
				'default' => 0,
				'slider-min' => 0,
				'slider-max' => 900,
				'slider-interval' => 1,
				'unit' => 'px',
				'callback' => '
					var search = block.find(".block-content .search-utility");
					id = search.parent().parent().parent().attr("id");
					stylesheet.update_rule("#" + id + " .search-utility", {"top": $(input).attr("value") + "px"});
				'
			),
			
		),
		
		
		'datetime-options' => array(
		
			'datetime-show' => array(
				'type' => 'checkbox',
				'name' => 'datetime-show',
				'label' => 'Hide [datetime]',
				'default' => 0,
				'tooltip' => 'If selected, this utility will be hidden even if you have the [datetime] in the builder. Ideal for testing without having to add and remove the code each time ',
				'options' => array(
					0 => 'No',
					1 => 'Yes',
				)
			),
		
			'datetime-format-field' => array(
				'type' => 'select',
				'name' => 'datetime-format',
				'label' => 'Datetime format',
				'default' => 'D j M Y',
				'width'		=> '300',
				'tooltip' => 'Set format for the datetime'
			),
			
			'datetime-disable-positioning' => array(
				'type' => 'checkbox',
				'name' => 'datetime-positioning',
				'label' => 'Disable Positioning',
				'tooltip' => 'If selected you will need to manually add CSS to position this utility',
				'callback' => '
					togglePositioning(value, block, "datetime", input);
				'
			),
			
			'datetime-options-input' => array(
				'type' => 'slider',
				'name' => 'datetimeleft', //This will be the setting you retrieve from the database.
				'label' => 'Datetime Left Position',
				'default' => 0,
				'slider-min' => 0,
				'slider-max' => 940,
				'slider-interval' => 1,
				'unit' => 'px'
			),
			'datetime-options-input-top-offset' => array(
				'type' => 'slider',
				'name' => 'datetimetop', //This will be the setting you retrieve from the database.
				'label' => 'Datetime Top Position',
				'default' => 0,
				'slider-min' => 0,
				'slider-max' => 900,
				'slider-interval' => 1,
				'unit' => 'px'
			),
			
			
		),
		
		
		'menu-options' => array(
		
			'menu-show' => array(
				'type' => 'checkbox',
				'name' => 'menu-show',
				'label' => 'Hide [menu]',
				'default' => 0,
				'tooltip' => 'If selected, this utility will be hidden even if you have the [menu] in the builder. Ideal for testing without having to add and remove the code each time ',
				'options' => array(
					0 => 'No',
					1 => 'Yes',
				)
			),
			
			'menu-disable-positioning' => array(
				'type' => 'checkbox',
				'name' => 'menu-positioning',
				'label' => 'Disable Positioning',
				'tooltip' => 'If selected you will need to manually add CSS to position this utility',
				'callback' => '
					togglePositioning(value, block, "menu", input);
				'
			),
		
			'menu-options-force-right' => array(
				'type' => 'checkbox',
				'name' => 'menu-options-force-right',
				'label' => 'Force position from right?',
				'tooltip' => 'If your menu is positioned to the right then check this option so it expands inwards from right to left as menu items are added. if it is positioned from the left you will need to re position it each time you add new menu items.',
				'options' => array(
					0 => 'No',
					1 => 'Yes',
				),
				'toggle' => array(
					'true' => array(
						'show' => array(
							'#input-menuright'
						),
						'hide' => array(
							'#input-menuleft'
						)
					),
					'false' => array(
						'show' => array(
							'#input-menuleft'
						),
						'hide' => array(
							'#input-menuright'
						)
					)
				)
			),
			
			'menu-options-input' => array(
				'type' => 'slider',
				'name' => 'menuleft', //This will be the setting you retrieve from the database.
				'label' => 'Menu Left Position',
				'default' => 0,
				'slider-min' => 0,
				'slider-max' => 940,
				'slider-interval' => 1,
				'unit' => 'px'
			),
			'menu-options-input-right' => array(
				'type' => 'slider',
				'name' => 'menuright', //This will be the setting you retrieve from the database.
				'label' => 'Menu Right Position',
				'default' => 0,
				'slider-min' => 0,
				'slider-max' => 940,
				'slider-interval' => 1
			),
			'menu-options-input-top-offset' => array(
				'type' => 'slider',
				'name' => 'menutop', //This will be the setting you retrieve from the database.
				'label' => 'Menu Top Position',
				'default' => 0,
				'slider-min' => 0,
				'slider-max' => 900,
				'slider-interval' => 1,
				'unit' => 'px'
			),
			
//			'alignment' => array(
//				'type' => 'select',
//				'name' => 'utility-alignment',
//				'label' => 'Alignment',
//				'default' => 'left',
//				'options' => array(
//					'left' => 'Left',
//					'right' => 'Right',
//					'center' => 'Center'
//				)
//			),
//			
//			'vert-nav-box' => array(
//				'type' => 'checkbox',
//				'name' => 'utility-vert-nav-box',
//				'label' => 'Vertical Navigation',
//				'default' => false,
//				'tooltip' => 'Instead of showing navigation horizontally, you can make the navigation show vertically.  <em><strong>Note:</strong> You may have to resize the block to make the navigation items fit correctly.</em>'
//			),
			
			'hide-home-link' => array(
				'type' => 'checkbox',
				'name' => 'utility-hide-home-link', 
				'label' => 'Hide Home Link',
				'default' => false
			),
			
			'home-link-text' => array(
				'name' => 'utility-home-link-text',
				'label' => 'Home Link Text',
				'type' => 'text',
				'tooltip' => 'If you would like the link to your homepage to say something other than <em>Home</em>, enter it here!',
				'default' => 'Home'
			),
			
			'animation' => array(
				'type' => 'select',
				'name' => 'superfish-animation',
				'label' => 'Animation',
				'default' => 'both',
				'options' => array(
					'slide' => 'Slide Down',
					'fade' => 'Fade In',
					'both' => 'Slide and Fade',

				)
			),
			
			'superfish-speed' => array(
				'name' => 'superfish-speed',
				'label' => 'Menu animation speed',
				'type' => 'text',
				'tooltip' => 'Set the speed of the menu animation',
				'default' => 600
			),
			
			'superfish-delay' => array(
				'name' => 'superfish-delay',
				'label' => 'Menu delay speed',
				'type' => 'text',
				'tooltip' => 'Set the speed of the menu delay. This is the time it takes for the drop down to dissapear',
				'default' => 600,
			),

			'responsive-header' => array(
				'type' => 'heading',
				'name' => 'responsive-header',
				'label' => 'Responsive',
			),

			'responsive-select' => array(
				'type' => 'checkbox',
				'name' => 'responsive-select',
				'label' => 'Responsive Select Menu',
				'default' => true,
				'tooltip' => 'When enabled, your navigation will turn into a mobile-friendly select menu when your visitors are viewing your site on a mobile device (phones, not tablets).'
			),
			
		),
	);
	
	
	public function set_social_inputs() {
		 $return = '';
		 $count = 11;
		 for ($i = 1; $i < $count; $i++) {
		 	$return .= $this->inputs['social-options']['social-title'.$i.''] = array(
		 		'type' => 'text',
		 		'name' => 'social-title'.$i.'',
		 		'label' => 'Title',
		 		'default' => null
		 	);
		 	
		 	$return .= $this->inputs['social-options']['social-link'.$i.''] = array(
		 		'type' => 'text',
		 		'name' => 'social-link'.$i.'',
		 		'label' => 'Link',
		 		'tooltip' => 'Add url with http:// to social website profile page',
		 		'default' => null
		 	);
		 	
		 	$return .= $this->inputs['social-options']['social-class'.$i.''] = array(
		 		'type' => 'text',
		 		'name' => 'social-class'.$i.'',
		 		'label' => 'CSS Class',
		 		'tooltip' => 'If you want to use sprites to add your images, then add a class here to use css to add your icons.',
		 		'default' => null
		 	);
		 	
		 	$return .= $this->inputs['social-options']['social-image'.$i.''] = array(
		 		'type' => 'image',
		 		'name' => 'social-image'.$i.'',
		 		'label' => 'Social icon img',
		 		'default' => null
		 	);
		 }
		 
		
		return $return;
	}
	
	
}
