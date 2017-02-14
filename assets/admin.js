/**
 * Created by shramee on 09/02/17.
 */
jQuery( function ( $ ) {
	var $html = $( 'html' );

	if (window.ppbModules) {
		window.ppbModules.ppbBizTestimonial = function ( $t, ed, $ed ) {
			var sampleContent = 'Replace_this_with_testimonial_content';
			ed.execCommand(
				'mceInsertContent', false,
				'<div class="ppb-biz-testimonial"><i class="fa fa-comments"><span style="display: none;">testimonial</span></i>' +
				'<p>' + sampleContent + '</p>' +
				'<div class="ppb-biz-testimonial-author" style="text-align: right;">&#8212; Testimonial_author_name</div>' +
				'</div>' );

		};

		window.ppbModules.ppbBizNumber = function ( $t, ed, $ed ) {
			var num = parseInt( prompt( 'Type in the number to count to...' ) );
			while ( ! num ) {
				num = parseInt( prompt( 'Input should be a number...' ) );
			}
			ed.execCommand(
				'mceInsertContent', false,
				'<div class="ppb-biz-number-counter"><span class="ppb-biz-number">' + num + '</span></div>'
			);
		};
	}

	addSectionFields = function ( $field, values ) {
		values = values ? values : {};
		var $fields = $( '<div class="ppb-business-pack-pro-section-fields">' + $field.find( '.ui-section-ref' ).html() + '</div>' );
		$fields.find( '.ppb-biz-multi-setting-field' ).each( function() {
			var
				$t = $( this ),
				val = values[ $t.attr( 'placeholder' ) ];
			if ( typeof val == 'string' ) {
				$t.val( val );
			}
		} );
		$field.find('section').append( $fields );
	};

	ppbBizProCustomField = function ( t ) {
		addSectionFields( $( t ).closest( '.field' ) );
	};

	$( "[dialog-field='ppb-business-pack-pro-tabs_accordion_data']" ).change( function () {
		var
			$t = $( this ),
			$p = $t.closest( '.field' );

		$p.find( 'section' ).find( 'div' ).remove();

		if ( ! $t.val() ) return;
		var json = JSON.parse( $t.val() );

		$.each( json, function( i, v ) {
			addSectionFields( $p, v );
		} );

	} );

	$( ".field_type-ppb-business-pack-pro section" ).on( "change", "input,textarea", function () {
		var
			$t = $( this ),
			$p = $t.closest( '.field' ),
			json = [];

		$p.find( '.ppb-business-pack-pro-section-fields' ).each( function() {
			var section = {}, saveSection = false;
			$( this ).find( 'input,textarea' ).each( function () {
				var $t = $( this ),
					val = $t.val();
				section[$t.attr( 'placeholder' )] = val;
				if ( val ) {
					saveSection = true; // Save section if atleast 1 value is set
				}
			} );
			if ( saveSection ) {
				json.push( section )
			}
		} );

		$p.find( '[type="hidden"]' ).val( JSON.stringify( json ) );
	} );
} );