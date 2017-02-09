/**
 * Plugin front end scripts
 *
 * @package Pootle_Pagebuilder_Business_Pack
 * @version 1.0.0
 */
jQuery(function ($) {

	var animate_increment = function ( num, target, $el ) {

		console.log( num, target, $el );
		var increment = Math.floor( ( target - num ) / 30 );
		var interval = setInterval( function () {
			num += increment;
			$el.text( num );
			if ( num >= target ) {
				$el.text( target );
				clearInterval( interval );
			}
		}, 40 );
	};

	$( '.ppb-biz-number-counter .ppb-biz-number' ).each( function () {
		var
			$t = $( this ),
			num = parseInt( $t.text() );
		$t.text( 0 );
		animate_increment( num % 5, num, $t );
	} );

});