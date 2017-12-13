<?php
/**
 * This file serves the quick preview for
 * the 'General Colors' customizer. It was given
 * '.php' extension to serve dynamic contents from
 * our library ('collections.php')
 *
 * @since 1.0
 */
header('Content-Type:application/javascript');

require_once __DIR__ . '/collections.php';

// Regulars.
$primary_color_tags  = thrive_colors_tags( 'primary' );
// Primary Colors Shade.
$primary_color_shaded_tags = thrive_colors_tags( 'primary_shade' );
// Primary Background Colors.
$primary_background_tags = thrive_colors_tags( 'primary_background' );
// Secondary Colors.
$secondary_colors = thrive_colors_tags( 'secondary' );
// Secondary Background Colors.
$secondary_background_colors = thrive_colors_tags( 'secondary_background' );

ob_start();

?>
( function( $ ) {

	wp.customize( 'thrive_primary_color', function( value ) {
		value.bind( function( to ) {
			$( "<?php echo $primary_color_tags; ?>" ).css( 'color', to );
			$( "<?php echo $primary_background_tags; ?>" ).css( 'background', to );
		} );
	} );

	wp.customize( 'thrive_primary_color_shade', function( value, data ) {
		value.bind( function( to ) {
			$( '<?php echo addslashes( $primary_color_shaded_tags ); ?>' ).css( 'background', to );
		});
	});

	wp.customize( 'thrive_secondary_color', function( value, data ){
		value.bind( function( to ) {
			$( '<?php echo $secondary_colors; ?>' ).css( 'color', to );
			$( '<?php echo $secondary_background_colors; ?>' ).css( 'background', to );
		});
	} );

	wp.customize( 'thrive_dark_menu', function( value, to ) {
		value.bind( function( isChecked ) {
			if (isChecked) {
				$('#sidebar-wrapper').addClass('dark');
			} else {
				$('#sidebar-wrapper').removeClass('dark');
			}
		});
	});

} )( jQuery );
<?php
echo ob_get_clean();
