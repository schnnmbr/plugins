<?php
$widget_title =  wp_kses_post($instance['widget_title']);
?>


<?php if ($widget_title) { ?>
    <h3 class="widget-title">
        <span><?php echo $widget_title ?></span>
    </h3>
<?php } ?>


<ul class="soua-accordion">
    <?php foreach( $instance['toggle_repeater'] as $i => $toggle_repeater ) : ?>
    <li>
        <a><?php echo $toggle_repeater['toggle_title'] ?></a>
        <p> <?php echo $toggle_repeater['toggle_content'] ?></p>
    </li>
    <?php endforeach; ?>
</ul> <!-- / accordion -->

