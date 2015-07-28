<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $ThemifyBuilder;
?>

<div class="themify_builder_content-<?php echo $builder_id; ?> themify_builder">

	<?php
	foreach ( $builder_output as $rows => $row ) :
		if ( 0 == count( $row ) ) continue;
		echo $ThemifyBuilder->get_template_row( $rows, $row, $builder_id, false, false );

	endforeach; // end row loop
	?>

</div>