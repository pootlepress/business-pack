/**
 * Plugin front end scripts
 *
 * @package Pootle_Business_Pack
 * @version 1.0.0
 */
jQuery(function ($) {

	var animate_increment = function ( target, $el ) {
		var increment = Math.max( 1, Math.floor( ( target ) / 20 ) );
		var num = target % increment;
		var interval = setInterval( function () {
			num += increment;
			if ( num >= target ) {
				num = target;
				clearInterval( interval );
			}
			$el.text( num );
		}, 40 );
	};

	$( 'body:not(.pootle-live-editor-active) .ppb-biz-number-counter .ppb-biz-number' ).each( function () {
		var
			$t = $( this ),
			target = parseInt( $t.text() );
		if ( ! isNaN( target ) ) {
			$t.text( 0 );
			animate_increment( target, $t );
		}
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