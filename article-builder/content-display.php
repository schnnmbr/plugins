<?php
class HeadwayPostListingsBlockDisplay {
		
	var $count = 0;	
		
	var $query = array();

	private static $block = null;
	
	function __construct($block) {
		self::$block = $block;

		/* Bring in the WordPress pagination variable. */
		$this->paged = get_query_var('paged') ? get_query_var('paged') : 1;

	}
	
	/**
	 * Created this function to make the call a little shorter.
	 **/
	public static function get_setting($setting, $default = null) {
		
		$block = self::$block;
		return HeadwayBlockAPI::get_setting($block, $setting, $default);
		
	}

	
	function display($args = array()) {
		
		$this->loop($args);
		wp_reset_query();
		
	}
	
	
	function loop($args = array()) {
						
		if ( !dynamic_loop() ) {
			
			$this->setup_query();
			
			echo '<div class="articles clearfix">';	
			
				while ( $this->query->have_posts() ) {
				
					$this->query->the_post();
					
					$this->count++;
		
					$this->display_item();
				
				}
									
			echo '</div>';

			$this->display_pagination();
			
		}
							
	}

	function display_item() {
		$builder_input_header = $this->get_setting('builder-input-header', '[title]');
		$builder_input_section = $this->get_setting('builder-input-section', '[thumb][excerpt]');
		$builder_input_footer = $this->get_setting('builder-input-footer', '[readmore]');
		
		global $post;
		$postid = $post->ID; ?>
		<article id="post-<?php the_ID(); ?>" class="article-<?php echo $this->count ?> article item clearfix hentry">
			
			<?php if(!empty($builder_input_header)) : ?>
			<header class="clearfix">
				<?php echo headway_parse_php(do_shortcode($this->parse_shortcodes(stripslashes($builder_input_header), $postid))); ?>
			</header>
			<?php endif; ?>
			
			<?php if(!empty($builder_input_section)) : ?>
			<section class="post-content clearfix">
				<?php echo headway_parse_php(do_shortcode($this->parse_shortcodes(stripslashes($builder_input_section), $postid))); ?>
			</section>
			<?php endif; ?>
			
			<?php if(!empty($builder_input_footer)) : ?>
			<footer class="post-meta clearfix">
				<?php echo headway_parse_php(do_shortcode($this->parse_shortcodes(stripslashes($builder_input_footer), $postid))); ?>
			</footer>
			<?php endif; ?>
		</article>
		<?php
	}
	
	function setup_query() {

		$mode = $this->get_setting('mode', 'custom_filter');
		
		if ( $mode == 'default' ) {
			
			global $wp_query;

			$this->query = $wp_query;

		//The mode is custom query so we have to set it all up.
		} else {
				
		/* Setup Query */
			$query_args = array();

			/* Pagination */
				$paged_var = get_query_var('paged') ? get_query_var('paged') : get_query_var('page');

			/* Categories */
				if ( $this->get_setting('categories-mode', 'include') == 'include' ) 
					$query_args['category__in'] = $this->get_setting('categories', array());

				if ( $this->get_setting('categories-mode', 'include') == 'exclude' ) 
					$query_args['category__not_in'] = $this->get_setting('categories', array());	

			$query_args['post_type'] = $this->get_setting('post-type', false);

			/* Pin limit */
				$query_args['posts_per_page'] = $this->get_setting('posts-per-block', 4);

			/* Author Filter */
				if ( is_array($this->get_setting('author')) )
					$query_args['author'] = trim(implode(',', $this->get_setting('author')), ', ');

			/* Order */
				$query_args['orderby'] = $this->get_setting('order-by', 'date');
				$query_args['order'] = $this->get_setting('order', 'DESC');
				$post_in = $this->get_setting('post_id', false);
				$query_args['post__in'] = ($post_in == true) ? explode(', ', $post_in) : false;

				$query_args['offset'] = $this->get_setting('offset', 0);

				if ( $this->get_setting('paginate', true) ) {
					
					$query_args['paged'] = $this->paged;

					if ($this->get_setting('offset', 0) >= 1 && $query_args['paged'] > 1){
						$query_args['offset'] = $this->get_setting('offset', 0) + $this->get_setting('posts-per-block', 10) * ($query_args['paged'] - 1);
					}
					
				}

			/* Query! */
				$this->query = new WP_Query($query_args);

				global $paged; /* Set paged to the proper number because WordPress pagination SUCKS!  ANGER! */
				$paged = $paged_var;
		/* End Query Setup */

		}
		
	}

	function get_overlay_contents($id) {

		$elements = self::get_setting('overlay-elements', array(array('overlay-element' => 'icon', 'overlay-element-align' => 'left')));
		
		$has_elements = false;

		foreach ( $elements as $element )
			if ( $element['overlay-element'] ) {
				$has_elements = true;
				break;
			}		

		$overlay_contents = '';

		if ( $has_elements )
	  	foreach ( $elements as $element ) {

	  		if ( !$element['overlay-element'] )
	  			continue;

	  		$overlay_element = headway_fix_data_type(headway_get('overlay-element', $element, 'icon'));

	  		$align = headway_fix_data_type(headway_get('overlay-element-align', $element, 'align-center'));

	  		$align = ($align !== 'align-none') ? ' ' . $align : null;

	  		$icon_class = self::get_setting('thumb-hover-iconclass', 'right-circle');

	  		$custom_icon_class = self::get_setting('thumb-hover-custom-iconclass', null);

	  		$custom_icon_class = $custom_icon_class ? ' ' . $custom_icon_class : null;

  			/* Open hyperlink if user added one for image */
  			if ( $overlay_element == 'icon' )
  				$overlay_contents .= '<a href="' . get_permalink() . '" title="' . get_the_title() . '"><i class="icon icon-' . $icon_class . $align . $custom_icon_class . '"></i></a>';

  			if ( $overlay_element == 'excerpt' )
  				$overlay_contents .= $this->article_excerpt($id, $align);

  			if ( $overlay_element == 'title' )
  				$overlay_contents .= $this->article_title($id, $align);

  			if ( $overlay_element == 'readmore' )
  				$overlay_contents .= $this->article_readmore($id, $align);

  			if ( $overlay_element == 'date' )
  				$overlay_contents .= $this->article_date($id, $align);

  			if ( $overlay_element == 'author' )
  				$overlay_contents .= $this->article_author($id, $align);

  			if ( $overlay_element == 'category' )
  				$overlay_contents .= $this->article_category($id, $align);

  			if ( $overlay_element == 'time' )
  				$overlay_contents .= $this->article_time($id, $align);

  			if ( $overlay_element == 'comments' )
  				$overlay_contents .= $this->article_comments($id, $align);

	  	}

		 return $overlay_contents;
	}

	function parse_shortcodes($position, $id) {

		$shortcodes = array(
			'title',
			'excerpt',
			'readmore',
			'thumb',
			'date',
			'time',
			'category',
			'author',
			'comments',
			'avatar'
		);

		$replacement = array();

		$align = null;

		foreach ( $shortcodes as $shortcode ) {

			if ( strpos($position, '[' . $shortcode . ']') === false )
				continue;

			switch ( $shortcode ) {

				case 'title':
					$replacement['title'] = $this->article_title($id, $align);

				break;

				case 'excerpt':

					$replacement['excerpt'] = $this->article_excerpt($id, $align);

				break;

				case 'readmore':

					$replacement['readmore'] = $this->article_readmore($id, $align);

				break;

				case 'thumb':

					$replacement['thumb'] = $this->article_image($id, $align);

				break;

				case 'date':

					$replacement['date'] = $this->article_date($id, $align);

				break;

				case 'time':

					$replacement['time'] = $this->article_time($id, $align);

				break;

				case 'category':

					$replacement['category'] = $this->article_category($id, $align);

				break;

				case 'author':

					$replacement['author'] = $this->article_author($id, $align);

				break;

				case 'comments':

					$replacement['comments'] = $this->article_comments($id, $align);

				break;

				case 'avatar':

					$replacement['avatar'] = $this->article_avatar($id, $align);

				break;

			}

			$position = str_replace('[' . $shortcode . ']', $replacement[$shortcode], $position);

		}

		return $position;
		
	}

	function article_image($id) {
		$image = '';
		if ( has_post_thumbnail()) {

			$block = self::$block;

			/* Thumb alignment */
			$thumb_align = self::get_setting('thumb-align', 'none');

			$auto_size = self::get_setting('thumb-size-auto', true);

			$crop_images_vertically = self::get_setting('thumb-crop-vertically', 'vertically');
			
			$columns = self::get_setting('columns', 3);
			$approx_img_width = (HeadwayBlocksData::get_block_width($block) / $columns);

			$thumbnail_id = get_post_thumbnail_id();  

			$thumbnail_width = $approx_img_width + 10; /* Add a 10px buffer to insure that image will be large enough */

			if ( $auto_size ) {

				/* all images height depends on ratios so set to '' */
				$thumbnail_height = '';
				/* if crop vertically make all images the same height */
				if ( $crop_images_vertically )
					$thumbnail_height = round($approx_img_width * (self::get_setting('post-thumbnail-height-ratio', 75) * .01));

				$thumbnail_object = wp_get_attachment_image_src($thumbnail_id, 'full'); 
				$thumbnail_url = headway_resize_image($thumbnail_object[0], $thumbnail_width, $thumbnail_height);

			} else {

				$thumbnail_width            = self::get_setting('thumb-width', '140');
				$thumbnail_height           = self::get_setting('thumb-height', '100');

				/* if crop vertically make all images the same height */
				if ( $crop_images_vertically )
					$thumbnail_height = round($thumbnail_height * (self::get_setting('post-thumbnail-height-ratio', 75) * .01));


				$thumbnail_object = wp_get_attachment_image_src($thumbnail_id, 'full');  
				$thumbnail_url    = headway_resize_image($thumbnail_object[0], $thumbnail_width, $thumbnail_height);

			}

			$overlay_contents = self::get_overlay_contents($id);

			$image .= '<figure class="align' . $thumb_align . '">';

				$image .= '<a href="' . get_permalink() . '" class="post-thumbnail" title="' . get_the_title() . '">';
					$image .= '<img src="' . esc_url($thumbnail_url) . '" alt="' . get_the_title() . '"  width="'.$thumbnail_width.'" height="'.$thumbnail_height.'"/>';
				$image .= '</a>';

				if (self::get_setting('thumb-hover-overlay', false))
					$image .= '<div><div class="overlay">' . $overlay_contents . '</div></div>';

			$image .= '</figure>';
		}

		return $image;
	}
	
	function article_excerpt($id, $align) {
		$content_to_show = self::get_setting('content-to-show', 'excerpt');
		if ( $content_to_show == 'excerpt' ) {

			$excerpt_length = self::get_setting('excerpt-length', '50');

			return '<p class="excerpt entry-content' . $align . '">' . self::get_trimmed_excerpt($excerpt_length) . '</p>';

		} elseif ( $content_to_show == 'content' ) {

			return '<div class="excerpt entry-content' . $align . '">' . self::get_formatted_content() . '</div>';

		}
	}

	function get_trimmed_excerpt($charlength) {
		$excerpt = get_the_excerpt();
		$charlength++;
		
		if (extension_loaded('mbstring')) {
			if ( mb_strlen( $excerpt ) > $charlength ) {
				/* If string needs to be trimmed */
				$subex = mb_substr( $excerpt, 0, $charlength - 5 );
				$exwords = explode( ' ', $subex );
				$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
				if ( $excut < 0 ) {
					$excerpt = mb_substr( $subex, 0, $excut );
				} else {
					$excerpt = $subex;
				}
				$excerpt = $excerpt.self::get_setting('excerpt-more', '...');
			} else {
				/* Nothing to trim */
				$excerpt = $excerpt;
			}
		} else {
			if ( strlen( $excerpt ) > $charlength ) {
				/* If string needs to be trimmed */
				$subex = substr( $excerpt, 0, $charlength - 5 );
				$exwords = explode( ' ', $subex );
				$excut = - ( strlen( $exwords[ count( $exwords ) - 1 ] ) );
				if ( $excut < 0 ) {
					$excerpt = substr( $subex, 0, $excut );
				} else {
					$excerpt = $subex;
				}
				$excerpt = $excerpt.self::get_setting('excerpt-more', '...');
			} else {
				/* Nothing to trim */
				$excerpt = $excerpt;
			}
		}
		
		return $excerpt;
	}
	
	function article_readmore($id, $align) {

		global $post;
		$excerpt_length = self::get_setting('excerpt-length', '50');
		$excerpt = get_the_excerpt();
		$excerpt_length++;

		$more_text = self::get_setting('read-more-text', 'Read more');

		$more_link = '<a href="'. get_permalink($post->ID) . '" class="more-link readon' . $align . '">' . $more_text . '</a>';
		
		if ( strlen( $excerpt ) > $excerpt_length ) {
			
			return $more_link;

		} else {
			
			return;
		}

	}
	
	function article_title($id, $align) {
		$html_tag = self::get_setting('title-html-tag', 'h1');
		$linked = self::get_setting('title-link', true);
		$shorten = self::get_setting('title-shorten', true);

		/* Shorten Title */
		$title_text = get_the_title($id);
		$title_length = mb_strlen($title_text);
		$limit = self::get_setting('title-limit', 20);
		$title = substr($title_text, 0, $limit);
		if ($title_length > $limit) 
			$title .= "...";

		if (!$shorten)
			$title = get_the_title($id);

		if($linked)
			return '<' . $html_tag . ' class="entry-title' . $align . '">
			<a href="'. get_permalink($id) .'" rel="bookmark" title="'. the_title_attribute (array('echo' => 0) ) .'">'. $title .'</a>
		</' . $html_tag . '>';
		return '<' . $html_tag . ' class="entry-title' . $align . '">
			'. $title .'
		</' . $html_tag . '>';
	}
	
	function article_date($id, $align) {
		$date_format = self::get_setting('meta-date-format', 'wordpress-default');
		$date = ($date_format != 'wordpress-default') ? get_the_time($date_format) : get_the_date();
		$before = self::get_setting('date-before-text', false);
		$before = $before != false ? '<span>' . $before . '</span>' : null;
		$date = '<span class="date post-meta' . $align . '"> ' . $before . ' <time datetime="'. get_the_time('c') .'">' . $date . '</time></span>';

		return $date;
	}

	function article_comments($id, $align) {
		if ( (int)get_comments_number($id) === 0 ) 
			$comments_format = stripslashes(self::get_setting('comment-format-0', '%num% Comments'));
		elseif ( (int)get_comments_number($id) == 1 ) 
			$comments_format = stripslashes(self::get_setting('comment-format-1', '%num% Comment'));
		elseif ( (int)get_comments_number($id) > 1 ) 
			$comments_format = stripslashes(self::get_setting('comment-format', '%num% Comments'));
		
		$before = self::get_setting('comments-before-text', false);
		$before = $before != false ? '<span>' . $before . '</span>' : null;

		$comments = str_replace('%num%', get_comments_number($id), $comments_format);
		
		$comments_link = '<a href="'.get_comments_link() . '" title="'.get_the_title() . ' Comments" class="entry-comments' . $align . '">' . $before . ' ' . $comments . '</a>';

		return $comments_link;
	}

	function article_time($id, $align) {
		$time_format = self::get_setting('meta-time-format', 'wordpress-default');
		$time = ($time_format != 'wordpress-default') ? get_the_time($time_format) : get_the_time();
		$before = self::get_setting('time-before-text', false);
		$before = $before != false ? '<span>' . $before . '</span>' : null;
		$timesince = self::get_setting('time-timesince', true);

		if ($timesince)
			return self::article_time_since($id, $align);

		return '<span class="entry-time' . $align . '">' . $before . ' ' . $time . '</span>';
	}
	
	function article_time_since($id, $align) {
		$before = self::get_setting('time-before-text', false);
		$before = $before != false ? '<span>' . $before . '</span>' : null;
		return '<time class="time-since post-meta" datetime="'. get_the_time('c') .'">
			' . $before . '
			<a href="'. get_post_permalink($id) .'" rel="bookmark" class="time post-meta' . $align . '" title="'. the_title_attribute (array('echo' => 0) ) .'">
				' . self::time_since(get_the_time('U')) .'
			</a>
		</time>';
	}

	/* time passed */
	function time_passed ($t1, $t2)
	{
		if($t1 > $t2) :
		  $time1 = $t2;
		  $time2 = $t1;
		else :
		  $time1 = $t1;
		  $time2 = $t2;
		endif;
		$diff = array(
		  'years' => 0,
		  'months' => 0,
		  'weeks' => 0,
		  'days' => 0,
		  'hours' => 0,
		  'minutes' => 0,
		  'seconds' =>0
		);
		$units = array('years','months','weeks','days','hours','minutes','seconds');
		foreach($units as $unit) :
		  while(true) :
		     $next = strtotime("+1 $unit", $time1);
		     if($next < $time2) :
		        $time1 = $next;
		        $diff[$unit]++;
		     else :
		        break;
		     endif;
		  endwhile;
		endforeach;
		return($diff);
	}

	function time_since($thetime) 
	{
		$diff = self::time_passed($thetime, strtotime('now'));
		$units = 0;
		$time_since = array();
		foreach($diff as $unit => $value) :
		   if($value != 0 && $units < 2) :
				if($value === 1) :
					$unit = substr($unit, 0, -1);
				endif;
			   $time_since[]= $value . ' ' .$unit;
			   ++$units;		
		    endif;
		endforeach;
		$time_since = implode(', ',$time_since);
		$time_since .= ' ago';
		$date = $time_since;
		return $date;
	}
	
	static function article_category($id, $align) {
		$cats = '';
		$i = '';
		$c = count(get_the_category($id));
		$before = self::get_setting('category-before-text', false);
		$before = $before != false ? '<span>' . $before . '</span>' : null;
		$cats .= '<span class="categories-wrap' . $align . '">' . $before;
		foreach((get_the_category($id)) as $category) {
 			$i++;
		    $cats .= '<a href="'.get_category_link($category->term_id).'" class="post-meta categories '. $category->slug .'">'.$category->cat_name.'</a>';
		    $cats .= ($i == $c) ? ' ' : ', ';
		};
		$cats .= '</span>';
		return $before .' '.$cats;
	}

	function article_author($id, $align) {
		global $authordata;
		$linked = self::get_setting('author-link', true);
		$before = self::get_setting('author-before-text', false);
		$before = $before != false ? '<span>' . $before . '</span>' : null;
		if(!$linked)
			return $authordata->display_name;
		return ' <a class="author-link fn nickname url' . $align . '" href="'.get_author_posts_url($authordata->ID) . '" title="View all posts by ' . $authordata->display_name . '">' . $before . ' ' . $authordata->display_name . '</a>';
	}

	function article_author_avatar($id) {
		global $authordata;
		$linked = self::get_setting('author-avatar-link', true);
		$before = self::get_setting('author-avatar-before-text', false);
		$before = $before != false ? '<span>' . $before . '</span>' : null;

		$avatar_size = self::get_setting('author-avatar-size', 32);
		
		$avatar_img = get_avatar( get_the_author_meta('email'), $avatar_size );

		if(!$linked)
			return $avatar_img;
		return ' <a class="author-avatar fn nickname url" href="'.get_author_posts_url($authordata->ID) . '" title="View all posts by ' . $authordata->display_name . '">' . $before . ' ' . $avatar_img . '</a>';
	}

	function display_pagination($position = 'below') {

	 	if ( $this->query->max_num_pages <= 1 || !$this->get_setting('paginate', true) )
			return;
					
		echo '<div id="nav-' . $position . '" class="loop-navigation loop-utility loop-utility-' . $position . '">';
			
			/* If wp_pagenavi() plugin is activated, just use it. */
			if ( function_exists('wp_pagenavi') ) {
				
				wp_pagenavi();
				
			} else {
				
				$older_posts_text = __('<span class="meta-nav">&larr;</span> Older posts', 'headway');
				$newer_posts_text = __('Newer posts <span class="meta-nav">&rarr;</span>', 'headway');
				
				echo '<div class="nav-previous">' . get_next_posts_link($older_posts_text, $this->query->max_num_pages) . '</div>';
				echo '<div class="nav-next">' . get_previous_posts_link($newer_posts_text) . '</div>';
				
			}
		
		echo '</div><!-- #nav-' . $position . ' -->';

		
	}

	function get_formatted_content () {
		$content = get_the_content();
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]>;', $content);
		return $content;
	}

	
	
}