(function($){
    /*---------------------------
		RECOMMENDATION POPUP
	---------------------------*/

    $('.open-recommendation-form').click(function () {
       $('#positive_ord_id').val($(this).data('order'));
       $('#negative_ord_id').val($(this).data('order'));
    });

    $('.open-recommendation-form').magnificPopup({

        type: 'inline',
        removalDelay: 300,
		mainClass: 'mfp-fade',
        closeMarkup: '<div class="close-btn mfp-close"><svg class="svg-plus"><use xlink:href="#svg-plus"></use></svg></div>',

    });

})(jQuery);