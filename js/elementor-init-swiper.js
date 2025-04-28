jQuery(window).on('elementor/frontend/init',function (){
	function alm_elementor_load_swiper($scope,$on = false){
        let swiper = $scope.find('.swiper[data-settings]:not(.custom-init)');
        if (swiper.length){
            let defaultOptions = {
                breakpointsInverse: true,
                observer: true
            };
			if($on){
				defaultOptions.on = $on;
			}
            let settings_data = swiper.attr('data-settings');
            if (settings_data){
                let settings = JSON.parse(settings_data);

				settings.on={
					...$on,
					resize: function(){
						const nextVisible = this.navigation.nextEl && $(this.navigation.nextEl).is(':visible');
						const prevVisible = this.navigation.prevEl && $(this.navigation.prevEl).is(':visible');
						let slider_wrapper = $(this.el).closest('.slider-wrapper');

						if(slider_wrapper){
							if(nextVisible || prevVisible){
								if(!slider_wrapper.is('.alm-visible-navigation'))
									slider_wrapper.addClass('alm-visible-navigation')
							}else{
								if(slider_wrapper.is('.alm-visible-navigation'))
									slider_wrapper.removeClass('alm-visible-navigation')
							}
						}
					}
				}

				let extended_options = $.extend({}, defaultOptions, settings);


                let swiperInstance = new Swiper(swiper[0],extended_options);


				swiperInstance.$containerEl = swiper;
            }
        }
    }

	elementorFrontend.hooks.addAction( 'frontend/element_ready/alm_categories_slider.default', function( $scope ) {alm_elementor_load_swiper($scope)} );
	elementorFrontend.hooks.addAction( 'frontend/element_ready/alm_products_slider.default', function( $scope ) {alm_elementor_load_swiper($scope)} );
	elementorFrontend.hooks.addAction( 'frontend/element_ready/alm_posts_slider.default', function( $scope ) {alm_elementor_load_swiper($scope)} );
	elementorFrontend.hooks.addAction( 'frontend/element_ready/alm_comments_slider.default', function( $scope ) {alm_elementor_load_swiper($scope)} );
	elementorFrontend.hooks.addAction( 'frontend/element_ready/alm_custom_products_slider.default', function( $scope ) {
		alm_elementor_load_swiper($scope,{
			init: function(){
				const nextVisible = this.navigation.nextEl && $(this.navigation.nextEl).is(':visible');
				const prevVisible = this.navigation.prevEl && $(this.navigation.prevEl).is(':visible');
				let slider_wrapper = $(this.el).closest('.slider-wrapper');

				if(slider_wrapper){
					if(nextVisible || prevVisible){
						if(!slider_wrapper.is('.alm-visible-navigation'))
							slider_wrapper.addClass('alm-visible-navigation')
					}else{
						if(slider_wrapper.is('.alm-visible-navigation'))
							slider_wrapper.removeClass('alm-visible-navigation')
					}
				}


				let containerEl = $(this.el);
				let activeIndex = this.activeIndex;
				let currentSlide = this.slides[activeIndex];
				let imgBox = containerEl.closest('.slider-wrapper').find('.alm-custom-product-image');
				if(imgBox){
					let imgSource = $(currentSlide).data('img');
					if(imgSource){
						imgBox.html(`<img src="${imgSource}"/>`);
					}else{
						imgBox.html('');
					}
				}
			} ,
			slideChange: function(){
				let containerEl = $(this.el);
				let activeIndex = this.activeIndex;
				let currentSlide = this.slides[activeIndex];


				let imgBox = containerEl.closest('.slider-wrapper').find('.alm-custom-product-image');
				if(imgBox){
					let imgSource = $(currentSlide).data('img');
					if(imgSource){
						imgBox.html(`<img src="${imgSource}"/>`);
					}else{
						imgBox.html('');
					}
				}
			},
			resize: function(){
				const nextVisible = this.navigation.nextEl && $(this.navigation.nextEl).is(':visible');
				const prevVisible = this.navigation.prevEl && $(this.navigation.prevEl).is(':visible');
				let slider_wrapper = $(this.el).closest('.slider-wrapper');

				if(slider_wrapper){
					if(nextVisible || prevVisible){
						if(!slider_wrapper.is('.alm-visible-navigation'))
							slider_wrapper.addClass('alm-visible-navigation')
					}else{
						if(slider_wrapper.is('.alm-visible-navigation'))
							slider_wrapper.removeClass('alm-visible-navigation')
					}
				}
			}
		})
	} );
	elementorFrontend.hooks.addAction( 'frontend/element_ready/alm_product_brands.default', function( $scope ) {alm_elementor_load_swiper($scope)} );

})
