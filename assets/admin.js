/**
 * Created by shramee on 09/02/17.
 */

window.ppbModules.ppbBizTestimonial = function($t, ed, $ed) {
	var sampleContent = 'Replace_this_with_testimonial_content';
	ed.execCommand(
		'mceInsertContent', false,
		'<div class="ppb-biz-testimonial"><i class="fa fa-comments"><span style="display: none;">testimonial</span></i>' +
		'<p>' + sampleContent + '</p>' +
		'<div class="ppb-biz-testimonial-author" style="text-align: right;">&#8212; Testimonial_author_name</div>' +
		'</div>' );

};

window.ppbModules.ppbBizNumber = function($t, ed, $ed) {
	var num = parseInt( prompt( 'Type in the number to count to...' ) );
	while ( ! num ) {
		num = parseInt( prompt( 'Input should be a number...' ) );
	}
	ed.execCommand(
		'mceInsertContent', false,
		'<div class="ppb-biz-number-counter"><span class="ppb-biz-number">' + num + '</span></div>'
	);
};

ppbBizProCustomField = function() {
	alert( 'Works...' );
}