<?php
/**
 * Admin class for the Soliloquy Featured Content Addon.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy-Featured-Content
 * @author	Thomas Griffin
 */
class Tgmsp_FC_Admin {

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * Constructor. Hooks all interactions to initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		self::$instance = $this;

		/** Return early if Soliloquy is not active */
		if ( Tgmsp_FC::soliloquy_is_not_active() )
			return;

		add_action( 'admin_init', array( $this, 'deactivation' ) );
		add_action( 'admin_init', array( $this, 'upgrade_plugin_internals' ) );
		add_action( 'tgmsp_slider_type', array( $this, 'type' ) );
		add_action( 'tgmsp_before_upload_area', array( $this, 'fc_settings' ) );
		add_action( 'save_post', array( $this, 'save_settings' ), 10, 2 );

	}

	/**
	 * Deactivate the plugin if Soliloquy is not active and update the recently
	 * activate plugins with our plugin.
	 *
	 * @since 1.0.0
	 */
	public function deactivation() {

		/** Don't deactivate when doing a Soliloquy update or when editing Soliloquy from the Plugin Editor */
		if ( Tgmsp_FC::soliloquy_is_not_active() ) {
			$recent = (array) get_option( 'recently_activated' );
			$recent[plugin_basename( Tgmsp_FC::get_file() )] = time();
			update_option( 'recently_activated', $recent );
			deactivate_plugins( plugin_basename( Tgmsp_FC::get_file() ) );
		}

	}

	/**
	 * Generic utility to for upgrading any internal plugin pieces when a new update
	 * requires it.
	 *
	 * @since 1.5.0
	 */
	public function upgrade_plugin_internals() {

        $done_update = get_option( 'soliloquy_fc_108' );

		// Upgrade the content type selection process for all available sliders.
		if ( ! $done_update ) :
			// Grab all sliders to be processed.
			$sliders = Tgmsp::get_sliders();
			if ( $sliders ) :
				foreach ( $sliders as $slider ) :
					$meta = get_post_meta( $slider->ID, '_soliloquy_fc', true );

					// If the meta does not exist, simply pass over the slider.
					if ( ! $meta )
					    continue;

                    // If no post content is selected, update the proper option.
                    if ( empty( $meta['post_content'] ) || ! $meta['post_content'] )
                        $meta['content_type'] = 'none';
                    else
                        $meta['content_type'] = 'post-content';

                    // Update the post meta to reflect the slider data.
                    update_post_meta( $slider->ID, '_soliloquy_fc', $meta );
				endforeach;
			endif;

			// Update the option to reflect that the version has been updated.
			update_option( 'soliloquy_fc_108', true );
		endif;

	}

	/**
	 * Set the option to select a featured content slider.
	 *
	 * @since 1.0.0
	 *
	 * @param object $post The current post object
	 */
	public function type( $post ) {

		?>
		<label for="soliloquy-featured-slider"><input id="soliloquy-featured-slider" type="radio" name="_soliloquy_settings[type]" value="featured" <?php checked( Tgmsp_Admin::get_custom_field( '_soliloquy_settings', 'type' ), 'featured' ); ?> /> <?php echo Tgmsp_FC_Strings::get_instance()->strings['featured_label']; ?></label>
		<?php

	}

	/**
	 * Within this method, we determine what type of slider we want to create: a normal
	 * slider or a dynamically generated slider based on content selection.
	 *
	 * @since 1.0.0
	 *
	 * @param object $post The current post object
	 */
	public function fc_settings( $post ) {

		?>
		<div class="soliloquy-fc-create">
			<?php wp_nonce_field( 'soliloquy_fc', 'soliloquy_fc' ); ?>
			<p class="soliloquy-fc-intro"><?php echo Tgmsp_FC_Strings::get_instance()->strings['intro']; ?></p>
			<h2 class="soliloquy-fc-title"><?php echo Tgmsp_FC_Strings::get_instance()->strings['query']; ?></h2>
			<table id="soliloquy-fc-query" class="form-table">
				<tbody>
					<tr id="soliloquy-fc-post-type-box" valign="middle">
						<th scope="row"><label for="soliloquy-fc-post-type"><?php echo Tgmsp_FC_Strings::get_instance()->strings['step_one']; ?></label></th>
						<td>
							<select id="soliloquy-fc-post-type" name="_soliloquy_fc[post_types][]" multiple="multiple" data-placeholder="<?php echo Tgmsp_FC_Strings::get_instance()->strings['step_one_hold']; ?>">
								<?php
									$post_types = get_post_types( array( 'public' => true ) );
									$post_types = array_filter( $post_types, array( $this, 'exclude_post_types' ) );

									foreach ( (array) $post_types as $post_type ) {
										$object = get_post_type_object( $post_type );
										echo '<option value="' . esc_attr( $post_type ) . '"' . selected( $post_type, in_array( $post_type, Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'post_types' ) ) ? $post_type : '', false ) . '>' . esc_html( $object->labels->singular_name ) . '</option>';
									}
								?>
							</select>
						</td>
					</tr>
					<tr id="soliloquy-fc-terms-box" valign="middle">
						<th scope="row"><label for="soliloquy-fc-terms"><?php echo Tgmsp_FC_Strings::get_instance()->strings['step_two']; ?></label></th>
						<td>
							<select id="soliloquy-fc-terms" name="_soliloquy_fc[terms][]" multiple="multiple" data-placeholder="<?php echo Tgmsp_FC_Strings::get_instance()->strings['step_two_hold']; ?>">
								<?php
									$taxonomies = get_taxonomies( array( 'public' => true ), 'objects' );
									$taxonomies = array_filter( $taxonomies, array( $this, 'exclude_taxonomies' ) );

									foreach ( $taxonomies as $taxonomy ) {
										$terms = get_terms( $taxonomy->name );

										echo '<optgroup label="' . esc_attr( $taxonomy->labels->name ) . '">';
											foreach ( $terms as $term )
												echo '<option value="' . esc_attr( strtolower( $taxonomy->name ) . '|' . $term->term_id . '|' . $term->slug ) . '"' . selected( strtolower( $taxonomy->name ) . '|' . $term->term_id . '|' . $term->slug, in_array( strtolower( $taxonomy->name ) . '|' . $term->term_id . '|' . $term->slug, (array) Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'terms' ) ) ? strtolower( $taxonomy->name ) . '|' . $term->term_id . '|' . $term->slug : '', false ) . '>' . esc_html( ucwords( $term->name ) ) . '</option>';
										echo '</optgroup>';
									}
								?>
							</select>
						</td>
					</tr>
					<tr id="soliloquy-fc-include-exclude-box" valign="middle">
						<th scope="row"><label for="soliloquy-fc-include-exclude"><?php echo sprintf( Tgmsp_FC_Strings::get_instance()->strings['step_three'], '<select id="soliloquy-fc-choose-query" name="_soliloquy_fc[query]"><option value="include"' . selected( 'include', Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'query' ), false ) . '>' . Tgmsp_FC_Strings::get_instance()->strings['include'] . '</option><option value="exclude"' . selected( 'exclude', Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'query' ), false ) . '>' . Tgmsp_FC_Strings::get_instance()->strings['exclude'] . '</option></select>' ); ?></label></th>
						<td>
							<select id="soliloquy-fc-include-exclude" name="_soliloquy_fc[include_exclude][]" multiple="multiple" data-placeholder="<?php echo Tgmsp_FC_Strings::get_instance()->strings['step_three_hold']; ?>">
								<?php
									$post_types = get_post_types( array( 'public' => true ) );
									$post_types = array_filter( $post_types, array( $this, 'exclude_post_types' ) );

									foreach ( (array) $post_types as $post_type ) {
										$object = get_post_type_object( $post_type );
										$posts = get_posts( array( 'post_type' => $post_type, 'posts_per_page' => apply_filters( 'tgmsp_fc_max_queried_posts', 500 ), 'no_found_rows' => true, 'cache_results' => false ) );

										echo '<optgroup label="' . esc_attr( $object->labels->name ) . '">';
											foreach ( $posts as $post )
												echo '<option value="' . esc_attr( $post->ID ) . '"' . selected( $post->ID, in_array( $post->ID, Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'include_exclude' ) ) ? $post->ID  : '', false ) . '>' . esc_html( ucwords( $post->post_title ) ) . '</option>';
										echo '</optgroup>';
									}
								?>
							</select>
						</td>
					</tr>
					<tr id="soliloquy-fc-orderby-box" valign="middle">
						<th scope="row"><label for="soliloquy-fc-orderby"><?php echo Tgmsp_FC_Strings::get_instance()->strings['step_four']; ?></label></th>
						<td>
							<select id="soliloquy-fc-orderby" name="_soliloquy_fc[orderby]">
								<?php
									$orderby = array(
										array(
											'name'	=> Tgmsp_FC_Strings::get_instance()->strings['date'],
											'value'	=> 'date'
										),
										array(
											'name'	=> Tgmsp_FC_Strings::get_instance()->strings['id'],
											'value'	=> 'ID'
										),
										array(
											'name'	=> Tgmsp_FC_Strings::get_instance()->strings['author'],
											'value'	=> 'author'
										),
										array(
											'name'	=> Tgmsp_FC_Strings::get_instance()->strings['title'],
											'value'	=> 'title'
										),
										array(
											'name'	=> Tgmsp_FC_Strings::get_instance()->strings['menu_order'],
											'value'	=> 'menu_order'
										),
										array(
											'name'	=> Tgmsp_FC_Strings::get_instance()->strings['random'],
											'value'	=> 'rand'
										),
										array(
											'name'	=> Tgmsp_FC_Strings::get_instance()->strings['comments'],
											'value'	=> 'comment_count'
										),
										array(
											'name'	=> Tgmsp_FC_Strings::get_instance()->strings['post_slug'],
											'value'	=> 'name'
										),
										array(
											'name'	=> Tgmsp_FC_Strings::get_instance()->strings['modified_date'],
											'value'	=> 'modified'
										),
									);

									foreach ( (array) $orderby as $array => $data )
										echo '<option value="' . esc_attr( $data['value'] ) . '"' . selected( $data['value'], Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'orderby' ), false ) . '>' . esc_html( $data['name'] ) . '</option>';
								?>
							</select>
						</td>
					</tr>
					<tr id="soliloquy-fc-order-box" valign="middle">
						<th scope="row"><label for="soliloquy-fc-order"><?php echo Tgmsp_FC_Strings::get_instance()->strings['step_five']; ?></label></th>
						<td>
							<select id="soliloquy-fc-order" name="_soliloquy_fc[order]">
								<?php
									$order = array(
										array(
											'name'	=> Tgmsp_FC_Strings::get_instance()->strings['desc'],
											'value'	=> 'DESC'
										),
										array(
											'name'	=> Tgmsp_FC_Strings::get_instance()->strings['asc'],
											'value'	=> 'ASC'
										)
									);

									foreach ( (array) $order as $array => $data )
										echo '<option value="' . esc_attr( $data['value'] ) . '"' . selected( $data['value'], Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'order' ), false ) . '>' . esc_html( $data['name'] ) . '</option>';
								?>
							</select>
						</td>
					</tr>
					<tr id="soliloquy-fc-number-box" valign="middle">
						<th scope="row"><label for="soliloquy-fc-number"><?php echo Tgmsp_FC_Strings::get_instance()->strings['step_six']; ?></label></th>
						<td>
							<input id="soliloquy-fc-number" type="text" name="_soliloquy_fc[number]" value="<?php echo esc_attr( Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'number' ) ); ?>" />
						</td>
					</tr>
					<tr id="soliloquy-fc-offset-box" valign="middle">
						<th scope="row"><label for="soliloquy-fc-offset"><?php echo Tgmsp_FC_Strings::get_instance()->strings['step_seven']; ?></label></th>
						<td>
							<input id="soliloquy-fc-offset" type="text" name="_soliloquy_fc[offset]" value="<?php echo absint( Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'offset' ) ); ?>" />
						</td>
					</tr>
					<tr id="soliloquy-fc-post-status-box" valign="middle">
						<th scope="row"><label for="soliloquy-fc-post-status" class="soliloquy-fc-step-title"><?php echo Tgmsp_FC_Strings::get_instance()->strings['step_eight']; ?></label></th>
						<td>
							<select id="soliloquy-fc-post-status" name="_soliloquy_fc[post_status]">
								<?php
									$post_stati = get_post_stati( array( 'internal' => false ), 'objects' );
									foreach ( $post_stati as $status )
										echo '<option value="' . esc_attr( $status->name ) . '"' . selected( $status->name, Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'post_status' ), false ) . '>' . esc_html( $status->label ) . '</option>';
								?>
							</select>
						</td>
					</tr>
				</tbody>
			</table>

			<h2 class="soliloquy-fc-title"><?php echo Tgmsp_FC_Strings::get_instance()->strings['content']; ?></h2>
			<table id="soliloquy-fc-content" class="form-table">
				<tbody>
					<tr id="soliloquy-fc-post-url-box" valign="middle">
						<th scope="row"><label for="soliloquy-fc-post-url"><?php echo Tgmsp_FC_Strings::get_instance()->strings['post_url']; ?></label></th>
						<td>
							<?php
								if ( '' === Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'post_url' ) ) { ?>
									<input id="soliloquy-fc-post-url" type="checkbox" name="_soliloquy_fc[post_url]" value="1" checked="checked" /> <?php } else { ?>
									<input id="soliloquy-fc-post-url" type="checkbox" name="_soliloquy_fc[post_url]" value="<?php echo esc_attr( Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'post_url' ) ); ?>" <?php checked( Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'post_url' ), 1 ); ?> /> <?php } ?>
									<span class="description"><?php echo Tgmsp_FC_Strings::get_instance()->strings['post_url_desc']; ?></span>
						</td>
					</tr>
					<tr id="soliloquy-fc-post-title-box" valign="middle">
						<th scope="row"><label for="soliloquy-fc-post-title"><?php echo Tgmsp_FC_Strings::get_instance()->strings['post_title']; ?></label></th>
						<td>
							<?php
								if ( '' === Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'post_title' ) ) { ?>
									<input id="soliloquy-fc-post-title" type="checkbox" name="_soliloquy_fc[post_title]" value="1" checked="checked" /> <?php } else { ?>
									<input id="soliloquy-fc-post-title" type="checkbox" name="_soliloquy_fc[post_title]" value="<?php echo esc_attr( Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'post_title' ) ); ?>" <?php checked( Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'post_title' ), 1 ); ?> /> <?php } ?>
									<span class="description"><?php echo Tgmsp_FC_Strings::get_instance()->strings['post_title_desc']; ?></span>
						</td>
					</tr>
					<tr id="soliloquy-fc-post-title-link-box" valign="middle">
						<th scope="row"><label for="soliloquy-fc-post-title-link"><?php echo Tgmsp_FC_Strings::get_instance()->strings['post_title_link']; ?></label></th>
						<td>
							<?php
								if ( '' === Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'post_title_link' ) ) { ?>
									<input id="soliloquy-fc-post-title-link" type="checkbox" name="_soliloquy_fc[post_title_link]" value="1" checked="checked" /> <?php } else { ?>
									<input id="soliloquy-fc-post-title-link" type="checkbox" name="_soliloquy_fc[post_title_link]" value="<?php echo esc_attr( Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'post_title_link' ) ); ?>" <?php checked( Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'post_title_link' ), 1 ); ?> /> <?php } ?>
									<span class="description"><?php echo Tgmsp_FC_Strings::get_instance()->strings['post_title_link_desc']; ?></span>
						</td>
					</tr>
					<tr id="soliloquy-fc-content-type-box" valign="middle">
						<th scope="row"><label for="soliloquy-fc-content-type"><?php echo Tgmsp_FC_Strings::get_instance()->strings['content_type']; ?></label></th>
						<td>
							<select id="soliloquy-fc-content-type" name="_soliloquy_fc[content_type]">
								<?php
									$types = array(
									    array(
									        'name'  => Tgmsp_FC_Strings::get_instance()->strings['no_content'],
									        'value' => 'none'
									    ),
									    array(
									        'name'  => Tgmsp_FC_Strings::get_instance()->strings['post_content'],
									        'value' => 'post-content'
									    ),
									    array(
									        'name'  => Tgmsp_FC_Strings::get_instance()->strings['post_excerpt'],
									        'value' => 'post-excerpt'
									    )
									);
									foreach ( $types as $type => $data )
										echo '<option value="' . esc_attr( $data['value'] ) . '"' . selected( $data['value'], Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'content_type' ), false ) . '>' . esc_html( $data['name'] ) . '</option>';
								?>
							</select>
						</td>
					</tr>
					<tr id="soliloquy-fc-post-content-length-box" valign="middle">
						<th scope="row"><label for="soliloquy-fc-post-content-length"><?php echo Tgmsp_FC_Strings::get_instance()->strings['post_content_length']; ?></label></th>
						<td>
							<input id="soliloquy-fc-post-content-length" type="text" name="_soliloquy_fc[post_content_length]" value="<?php echo esc_attr( Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'post_content_length' ) ); ?>" />
							<span class="description"><?php echo Tgmsp_FC_Strings::get_instance()->strings['post_content_length_desc']; ?></span>
						</td>
					</tr>
					<tr id="soliloquy-fc-ellipses-box" valign="middle">
						<th scope="row"><label for="soliloquy-fc-ellipses"><?php echo Tgmsp_FC_Strings::get_instance()->strings['ellipses']; ?></label></th>
						<td>
							<?php
								if ( '' === Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'ellipses' ) ) { ?>
									<input id="soliloquy-fc-ellipses" type="checkbox" name="_soliloquy_fc[ellipses]" value="1" checked="checked" /> <?php } else { ?>
									<input id="soliloquy-fc-ellipses" type="checkbox" name="_soliloquy_fc[ellipses]" value="<?php echo esc_attr( Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'ellipses' ) ); ?>" <?php checked( Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'ellipses' ), 1 ); ?> /> <?php } ?>
									<span class="description"><?php echo Tgmsp_FC_Strings::get_instance()->strings['ellipses_desc']; ?></span>
						</td>
					</tr>
					<tr id="soliloquy-fc-read-more-box" valign="middle">
						<th scope="row"><label for="soliloquy-fc-read-more"><?php echo Tgmsp_FC_Strings::get_instance()->strings['read_more']; ?></label></th>
						<td>
							<?php
								if ( '' === Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'read_more' ) ) { ?>
									<input id="soliloquy-fc-read-more" type="checkbox" name="_soliloquy_fc[read_more]" value="1" checked="checked" /> <?php } else { ?>
									<input id="soliloquy-fc-read-more" type="checkbox" name="_soliloquy_fc[read_more]" value="<?php echo esc_attr( Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'read_more' ) ); ?>" <?php checked( Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'read_more' ), 1 ); ?> /> <?php } ?>
									<span class="description"><?php echo Tgmsp_FC_Strings::get_instance()->strings['read_more_desc']; ?></span>
						</td>
					</tr>
					<tr id="soliloquy-fc-read-more-text-box" valign="middle">
						<th scope="row"><label for="soliloquy-fc-read-more-text"><?php echo Tgmsp_FC_Strings::get_instance()->strings['read_more_text']; ?></label></th>
						<td>
							<input id="soliloquy-fc-read-more-text" type="text" name="_soliloquy_fc[read_more_text]" value="<?php echo esc_attr( Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'read_more_text' ) ); ?>" />
							<span class="description"><?php echo Tgmsp_FC_Strings::get_instance()->strings['read_more_text_desc']; ?></span>
						</td>
					</tr>
					<tr id="soliloquy-fc-fallback-box" valign="middle">
						<th scope="row"><label for="soliloquy-fc-fallback"><?php echo Tgmsp_FC_Strings::get_instance()->strings['fallback']; ?></label></th>
						<td>
							<input id="soliloquy-fc-fallback" type="text" name="_soliloquy_fc[fallback]" value="<?php echo esc_url( Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'fallback' ) ); ?>" />
							<span class="description"><?php echo Tgmsp_FC_Strings::get_instance()->strings['fallback_desc']; ?></span>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<?php

	}

	/**
	 * Save our featured content slider settings.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id The current post ID
	 * @param object $post The current post object
	 */
	public function save_settings( $post_id, $post ) {

		/** Bail out if we fail a security check */
		if ( ! isset( $_POST[sanitize_key( 'soliloquy_fc' )] ) || ! wp_verify_nonce( $_POST[sanitize_key( 'soliloquy_fc' )], 'soliloquy_fc' ) )
			return $post_id;

		/** Bail out if running an autosave, ajax or a cron */
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
			return;
		if ( defined( 'DOING_CRON' ) && DOING_CRON )
			return;

		/** Bail out if the user doesn't have the correct permissions to update the slider */
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return $post_id;

		/** Let's sanitize and store our data */
		$settings = isset( $_POST['_soliloquy_fc'] ) ? $_POST['_soliloquy_fc'] : '';

		/** Set default if needed and sanitize post type selection */
		if ( ! isset( $settings['post_types'] ) ) {
			$settings['post_types'][] = 'post'; // Default to post if no option is selected
		} else {
			foreach ( (array) $settings['post_types'] as $post_type )
				$post_type = esc_attr( $post_type );
		}

		/** Set default if needed and sanitize terms selection */
		if ( ! isset( $settings['terms'] ) ) {
			$settings['terms'][] = ''; // Default to everything if not option is selected
		} else {
			foreach ( (array) $settings['terms'] as $term )
				$term = esc_attr( $term );
		}

		$settings['query'] = esc_attr( $settings['query'] );

		/** Set default if needed and sanitize terms selection */
		if ( ! isset( $settings['include_exclude'] ) ) {
			$settings['include_exclude'][] = null; // Default to nothing
		} else {
			foreach ( (array) $settings['include_exclude'] as $post )
				$post = esc_attr( $post );
		}

		$settings['orderby'] 				= esc_attr( $settings['orderby'] );
		$settings['order'] 					= esc_attr( $settings['order'] );
		$settings['number'] 				= absint( $settings['number'] );
		$settings['offset'] 				= absint( $settings['offset'] );
		$settings['post_status']			= esc_attr( $settings['post_status'] );

		/** Now sanitize content settings */
		$settings['post_url']				= isset( $settings['post_url'] ) ? 1 : 0;
		$settings['post_title']				= isset( $settings['post_title'] ) ? 1 : 0;
		$settings['post_title_link']		= isset( $settings['post_title_link'] ) ? 1 : 0;
		$settings['content_type']			= isset( $settings['content_type'] ) ? esc_attr( $settings['content_type'] ) : 'none';
		$settings['post_content_length'] 	= absint( $settings['post_content_length'] );
		$settings['ellipses']				= isset( $settings['ellipses'] ) ? 1 : 0;
		$settings['read_more']				= isset( $settings['read_more'] ) ? 1 : 0;
		$settings['read_more_text']			= strip_tags( $settings['read_more_text'] );
		$settings['fallback']				= esc_url( $settings['fallback'] );

		/** Update our post meta fields */
		update_post_meta( $post_id, '_soliloquy_fc', $settings );

	}

	/**
	 * Callback method to exclude post types from appearing from the dropdown select box.
	 *
	 * @since 1.0.0
	 *
	 * @param string $post_type The name of the post type
	 */
	private function exclude_post_types( $post_type ) {

		$post_types = apply_filters( 'tgmsp_fc_excluded_post_types', array( 'attachment', 'soliloquy' ) );
		return ! in_array( $post_type, (array) $post_types );

	}

	/**
	 * Callback method to exclude taxonomies from appearing from the dropdown select box.
	 *
	 * @since 1.0.0
	 *
	 * @param string $taxonomy The name of the taxonomy
	 */
	private function exclude_taxonomies( $taxonomy ) {

		$taxonomies = apply_filters( 'tgmsp_fc_excluded_taxonomies', array( 'nav_menu' ) );
		return ! in_array( $taxonomy, (array) $taxonomies );

	}

	/**
	 * Getter method for retrieving the object instance.
	 *
	 * @since 1.0.0
	 */
	public static function get_instance() {

		return self::$instance;

	}

}