/**
 * Plugin front end scripts
 *
 * @package Pootle_Business_Pack
 * @version 1.0.0
 */
jQuery(function ($) {

	var animate_increment = function ( num, target, $el ) {
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

	$( 'body:not(.pootle-live-editor-active) .ppb-biz-number-counter .ppb-biz-number' ).each( function () {
		var
			$t = $( this ),
			num = parseInt( $t.text() );
		$t.text( 0 );
		animate_increment( num % 5, num, $t );
	} );

	ppbBizProContent = {
		tabs: function( e, t, i ) {
			e.preventDefault();
			var
				$t = $( t ),
				$p = $t.closest( '.ppb-biz-tabs' );
			$t.addClass('active').siblings().removeClass('active');
			$p.find( '.ppb-biz-content' ).removeClass('active').eq( i ).addClass('active');
		},
		accordion: function( e, t ) {
			e.preventDefault();
			$( t ).toggleClass( 'active' ).next('.ppb-biz-content').slideToggle();
		}
	};
});