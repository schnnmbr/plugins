<?php
$query = siteorigin_widget_post_selector_process_query($instance['posts']);
$the_query = new WP_Query($query);
$widget_title = wp_kses_post($instance['widget_title']);
?>

<?php if ($widget_title) { ?>
    <h3 class="widget-title">
        <span><?php echo $widget_title ?></span>
    </h3>
<?php } ?>

<?php while ($the_query->have_posts()) : $the_query->the_post(); ?>


    <div class="blog_one_style clearfix">

         <div class="col-md-4 col-sm-4 image alpha">
         <?php if(has_post_thumbnail()){
             the_post_thumbnail();
         } ?>
         </div>

        <div class="col-md-8 col-sm-8 content">
        <h4><?php the_title(); ?></h4>
        <?php the_excerpt(); ?>
        </div>

        <div class="clearfix"></div>

        <div class="meta col-md-12 col-xs-12 col-sm-12 clearfix">
            <div class="left-style">
            by <?php the_author(); ?> | <?php echo get_the_date(); ?> | <?php the_category(', '); ?>
            </div>
            <div class="right-style">
            <a href="<?php the_permalink(); ?>">Read More </a>
            </div>
        </div>
    </div>


<?php endwhile; ?>