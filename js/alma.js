jQuery(document).ready(function($){
	$('#preloader').hide();

	$('body').append('<div id="cart-popup" style="display:none"></div>');

	$(document.body).on('added_to_cart', function(event, fragments, cart_hash, button) {
		var message = 'محصول به سبد خرید افزوده شد.';

		$('#cart-popup').html(message).fadeIn();

		setTimeout(function() {
			$('#cart-popup').fadeOut();
		}, 3000); // Hide after 3 seconds
	});

	$(document).on('click','.alm-open-modal[data-target]',function () {
        let el = $(this)
        let target_selector = el.data('target');
        let target = $(target_selector)
        if (target.hasClass('alm-hide')) {
            // $('body').addClass('alm-overflow-always-hidden')
            target.removeClass('alm-hide')
        }
    })
    $(document).on('click','.alm-modal-wrapper[id]',function (event) {
        let elm = $(this);
        let id = elm.attr('id');

        if (id && !$(event.target).closest(`#${id} .alm-modal`).length) {
            elm.addClass('alm-hide');
        }
    });

	$('.alm-archive-sort').on('click','.alm-archive-sort-button',function(e){
		e.preventDefault();
		let elm = $(this);
		let sort_box = elm.closest('.alm-archive-sort');
		if(sort_box){
			sort_box.toggleClass('alm-archive-open-sort');
		}
	})

	$('.alm-archive-sort-select').each(function() {
		let $select = $(this);
		let $sortForm = $select.closest('.alm-archive-sort-form');
		let $sortBox = $select.closest('.alm-archive-sort');


		// Create the ul element
		let $ul = $('<ul>', {
		  'class': 'alm-archive-sort-items'
		});

		let initialValue = $select.val();

		// Iterate through each option in the select
		$select.find('option').each(function() {
		  let $option = $(this);
		  let $li = $('<li>', {
			'data-sort': $option.val(),
			'text': $option.text()
		  });

		  if ($option.val() === initialValue) {
			$li.addClass('alm-archive-current-sort');
		  }

		  $ul.append($li);
		});

		// Append the new ul after the select
		$sortForm.append($ul);

		$ul.on('click', 'li', function() {
			let selectedValue = $(this).data('sort');
			$select.val(selectedValue).trigger('change');

			// Optional: Add active class to clicked li and remove from others
			$ul.find('li').removeClass('alm-archive-current-sort');
			$(this).addClass('alm-archive-current-sort');

			$sortBox.removeClass('alm-archive-open-sort');

			$sortForm.submit();
		  });
	  })

	$('.swiper.alm-swiper[data-settings]:not(.custom-init)').each(function(){
		let swiper = $(this);
		let defaultOptions = {
			breakpointsInverse: true,
			observer: true
		};
		let settings_data = swiper.attr('data-settings');
		if (settings_data){
			let settings = JSON.parse(settings_data);

			settings.on={
				init: function () {
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
				},
				slideChange:function(){
					let slider_wrapper = $(this.el).closest('.slider-wrapper');
					const allSlides = slider_wrapper[0].querySelectorAll('.swiper-slide');
					let slider = this;
					setTimeout(function(){
						let isLast = slider.isEnd;
						let isStart = slider.isBeginning;

						allSlides.forEach((slide) => {
							  slide.classList.remove('first-visible', 'last-visible');
							});

							const visibleSlides = slider_wrapper[0].querySelectorAll(
								'.swiper-slide.swiper-slide-visible'
							);

							if (visibleSlides.length > 0) {
								if(!isStart && !isLast){
									console.log('add class first visible');
									visibleSlides[0].classList.add('first-visible');
								}
								// Add the `last-visible` class to the last visible slide
								if(!isStart && !isLast){
									console.log('add class last visible');
									visibleSlides[visibleSlides.length - 1].classList.add('last-visible');
								}
							}
					},300);
				},
				// breakpoint: function(){
				// 	updatePaddingBasedOnSlidesResize(this);
				// }
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



			new Swiper(swiper[0],$.extend({}, defaultOptions, settings));
		}
	})

	const scrollBox = $('.flex-control-nav.flex-control-thumbs');

    let isDragging = false;
    let startX;
    let scrollLeft;

    // Mouse down event to start dragging
    $(document).on('mousedown','.flex-control-nav.flex-control-thumbs', function(e) {
		let scrollBox = $(this);
        isDragging = true;
        startX = e.pageX - scrollBox.offset().left;
        scrollLeft = scrollBox.scrollLeft();
        scrollBox.css('cursor', 'grabbing'); // Change cursor to grabbing
        e.preventDefault();
		scrollBox.attr('data-drag','dragging');
    });

    // Mouse move event to perform horizontal scrolling
    $(document).on('mousemove','.flex-control-nav.flex-control-thumbs', function(e) {
		let scrollBox = $(this);
        if (!scrollBox.is('[data-drag="dragging"]')) return; // Only scroll when dragging
        const x = e.pageX - scrollBox.offset().left;
        const walk = (x - startX) * 1.5; // Adjust multiplier for scroll speed
        scrollBox.scrollLeft(scrollLeft - walk);
    });

    // Mouse up event to stop dragging
    $(document).on('mouseup', function() {
		let scrollBox = $(this);
        $('.flex-control-nav.flex-control-thumbs').attr('data-drag','');
        $('.flex-control-nav.flex-control-thumbs').css('cursor', 'auto'); // Change cursor back to grab
    });


	$(document).on('click', '.alm-change-quantity-plus', function (event) {
        event.preventDefault();
        let el = $(this);
        let quantity_input = el.parent().find('.qty');
        let minus_button = el.parent().find('.alm-change-quantity-minus');
        let step = 1;
        if (quantity_input.is('[step]')) {
            step = parseInt(quantity_input.attr('step'));
        }
        if (quantity_input.length) {
            let quantity_value = 1;
            if (quantity_input.val().length) {
                quantity_value = quantity_input.val();
            }
            let quantity = parseInt(quantity_value) + step;
            if ((quantity_input.is('[max]') && quantity_input.attr('max').length && quantity > parseInt(quantity_input.attr('max'))) || (quantity_input.is('[min]') && quantity_input.attr('min').length && quantity < quantity_input.attr('min'))) {
                return;
            }

            let old_quantity = quantity_input.val();
            quantity_input.val(quantity);
            if (old_quantity != quantity)
                quantity_input.trigger('change');


            let can_plus = true;
            if (quantity_input.is('[max]') && quantity_input.attr('max').length && quantity + step > parseInt(quantity_input.attr('max'))) {
                can_plus = false;
            }
            let can_minus = true;
            if (quantity_input.is('[min]') && quantity_input.attr('min').length && quantity - step < parseInt(quantity_input.attr('min'))) {
                can_minus = false;
            }

            el.prop('disabled', !can_plus);
            minus_button.prop('disabled', !can_minus);
        }
    })

    $(document).on('click', '.alm-change-quantity-minus', function (event) {
        event.preventDefault();
        let el = $(this);
        let quantity_input = el.parent().find('.qty');
        let plus_button = el.parent().find('.alm-change-quantity-plus');
        let step = 1;
        if (quantity_input.is('[step]')) {
            step = parseInt(quantity_input.attr('step'));
        }
        if (quantity_input.length) {
            let quantity_value = 1;
            if (quantity_input.val().length) {
                quantity_value = quantity_input.val();
            }
            let quantity = parseInt(quantity_value) - step;
            if ((quantity_input.is('[max]') && quantity_input.attr('max').length && quantity > parseInt(quantity_input.attr('max'))) || (quantity_input.is('[min]') && quantity_input.attr('min').length && quantity < quantity_input.attr('min'))) {
                return;
            }

            let old_quantity = quantity_input.val();
            quantity_input.val(quantity);
            if (old_quantity != quantity)
                quantity_input.trigger('change');

            let can_plus = true;
            if (quantity_input.is('[max]') && quantity_input.attr('max').length && quantity + step > parseInt(quantity_input.attr('max'))) {
                can_plus = false;
            }
            let can_minus = true;
            if (quantity_input.is('[min]') && quantity_input.attr('min').length && quantity - step < parseInt(quantity_input.attr('min'))) {
                can_minus = false;
            }

            el.prop('disabled', !can_minus);
            plus_button.prop('disabled', !can_plus);

        }
    })

	$('.alm-change-quantity-plus').each(function () {
        let el = $(this);
        let quantity_input = el.parent().find('.qty');
        updatePlusButtonStatus($(this));
    });

    $('.alm-change-quantity-minus').each(function () {
        updateMinusButtonStatus($(this));
    });

    $('.qty').on('input', function () {
        let el = $(this);
        let minus_button = el.parent().find('.alm-change-quantity-minus');
        let plus_button = el.parent().find('.alm-change-quantity-plus');
        if (minus_button.length)
            updateMinusButtonStatus(minus_button);
        if (plus_button.length)
            updatePlusButtonStatus(plus_button);
    });

	$(document).on('submit','.alm-otp-form-step-1',function(e){
		e.preventDefault();
		let form = $(this);
        let data = $(this).serialize();
		let wrapper = form.closest('.alm-otp-wrapper');

		if(form.is('.alm-loading-form')){
			return;
		}

		data += "&action=alm_request_otp_token&security=" + alma_obj.security;
		form.addClass('alm-loading-form');
		$.ajax({
			type:'post',
            url:alma_obj.ajax_url,
            dataType:'json',
			data:data,
			success:function(response){
				if(!response.success){
					let errors_box = form.find('.alm-otp-form-errors');
					if(response.data){

						let errors_html = `<div class='alm-otp-form-error'>${response.data}</div>`;
						if(!errors_box.length){

							let title_elm = form.find('.alm-otp-form-title');
							if(title_elm.length){
								errors_html = `<div class='alm-otp-form-errors'>${errors_html}</div>`;
								$(errors_html).insertAfter(title_elm);
							}
						}else{
							errors_box.html(errors_html);
						}
					}

				}else if(response.success && response?.data?.verify_code){
					form.replaceWith(response.data.verify_code);
					if(wrapper){
						let timerElement = wrapper.find('.alm-form-otp-timer[data-remain]');
						startTimer(timerElement);
					}
				}
			},
			complete: function(){
				form.removeClass('alm-loading-form');
			}
		});
	});

	$('.alm-otp-wrapper').on('click','.alm-otp-form-resend-button',function(e){
		e.preventDefault();

		let resend_button = $(this);
		if(resend_button.is('.alm-loading-button')){
			return;
		}

		let form = $(this).closest('.alm-otp-form-step-2');
		let wrapper = form.closest('.alm-otp-wrapper');
		if(form){
			let otp_input = form.find('input[name="otp_input"]');
			if(otp_input){
				form.find('input[name="otp_verification_code"]').val('');
				data = "otp_input=" + otp_input.val() + "&action=alm_request_resend_otp_token&security=" + alma_obj.security;
				resend_button.addClass('alm-loading-button');
				$.ajax({
					type:'post',
					url:alma_obj.ajax_url,
					dataType:'json',
					data:data,
					success:function(response){
						if(response.success && response?.data?.verify_code){
							form.replaceWith(response.data.verify_code);
							if(wrapper){
								let timerElement = wrapper.find('.alm-form-otp-timer[data-remain]');
								startTimer(timerElement);
							}
						}
					},
					complete:function(){
						resend_button.removeClass('alm-loading-button');
					}
				})

			}
		}
	});

	$(document).on('submit','.alm-otp-form-step-2',function(e){
		e.preventDefault();
		let form = $(this);
        let data = $(this).serialize();
		let wrapper = form.closest('.alm-otp-wrapper');

		if(form.is('.alm-loading-form')){
			return;
		}


		data += "&action=alm_verify_otp_token&security=" + alma_obj.security;
		form.addClass('alm-loading-form');
		$.ajax({
			type:'post',
            url:alma_obj.ajax_url,
            dataType:'json',
			data:data,
			success:function(response){
				if(response.success){
					window.location.reload(true);
				}else{
					let errors_box = form.find('.alm-otp-form-errors');
					if(response.data){

						let errors_html = `<div class='alm-otp-form-error'>${response.data}</div>`;
						if(!errors_box.length){

							let title_elm = form.find('.alm-otp-form-title');
							if(title_elm.length){
								errors_html = `<div class='alm-otp-form-errors'>${errors_html}</div>`;
								$(errors_html).insertAfter(title_elm);
							}
						}else{
							errors_box.html(errors_html);
						}
					}
				}
			},
			complete: function(){
				form.removeClass('alm-loading-form');
			}
		});
	})

	$(document).on('click','.alm-open-otp-modal[data-otp]',function(e){
		e.preventDefault();
		$('#alm-otp-modal').removeClass('alm-hide');
	});

	$(document).on('click','.alm-otp-modal-close-button',function(e){
		e.preventDefault();
		let modal = $(this).closest('.alm-otp-modal');
		if(modal && !modal.is('.alm-hide')){
			modal.addClass('alm-hide');
		}
	});

	$(document).on('change','input.alm-img-field-input[type="file"]',function(){
		var input = this;
		var url = $(this).val();
		var preview_items = $(this).closest('.alm-img-field-preview').find('.alm-img-field-preview-items');
		var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
		if (preview_items && input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
		 {
			var reader = new FileReader();

			reader.onload = function (e) {

				remove_text = alma_obj.translations.remove_text;
				remove_text = remove_text.replace("%s", abstractFilename(input.files[0].name));

				var preview_items_html = preview_items.html();
				preview_items_html = `<div class="alm-img-field-preview-item"><img src="${e.target.result}"/><button class="alm-img-field-remove-button">${remove_text}</button></div>`;
				preview_items.html(preview_items_html);

			//    $('#img').attr('src', e.target.result);
			}
		   reader.readAsDataURL(input.files[0]);

		   $(this).closest('.alm-img-field-preview').find('input[name="keep_avatar"]').prop('checked',false);
		   $(this).closest('.alm-img-field-preview').find('input[name="use_default_avatar"]').prop('checked',false);
		}
		else
		{
		//   $('#img').attr('src', '/assets/no_preview.png');
		}
	});

	$(document).on('click','.alm-img-field-remove-button',function(e){
		e.preventDefault();
		var preview_field = $(this).closest('.alm-img-field-preview');
		var file_input = preview_field.find('.alm-img-field-input');
		if(preview_field){
			var preview_items = preview_field.find('.alm-img-field-preview-items');
			if(preview_items)
				preview_items.html(`<div class="alm-img-field-upload-button"><h3 class="alm-upload-main-text">${alma_obj.translations.upload_main_text}</h3><h4 class="alm-upload-avatar-condition">${alma_obj.translations.upload_avatar_condition}</h4></div>`);
			if(file_input)
				file_input.val('');

			preview_field.find('input[name="keep_avatar"]').prop('checked',false);
			preview_field.find('input[name="use_default_avatar"]').prop('checked',true);


		}
	})

	$(document).on('change','.woocommerce-checkout #payment ul.payment_methods input[name="payment_method"]',function(){
		$(this).closest('.wc_payment_methods').find('.wc_payment_method .alm-wc_payment_method-image label.selected-payment').removeClass('selected-payment');
		$(this).closest('label').addClass('selected-payment');
	});

	$(document).on('click','.alm-woocommecre-notification-toggle',function(){
		$(this).closest('.alm-woocommecre-notification').toggleClass('alm-show-notification');
	});

	$(document).on('click','.alm-toggle-navigation',function(){
		let navigation = $(this).closest('.woocommerce').find('.alm-navigation-card');
		if(navigation && !navigation.is('.alm-show-navigation-card')){
			navigation.addClass('alm-show-navigation-card');
		}
	});

	$(document).on('click','.alm-close-navigation-modal',function(){
		$(this).closest('.alm-navigation-card').removeClass('alm-show-navigation-card');
	});


	/* */
	let searchTimer;
	let searchCurrentRequest = null;
	let loader_html = '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>';
	$('.alm-default-advanced-search').on('input','.alm-default-search-box-input',function(event){
		let el = $(this);
		let searchTerm = el.val();
		let resultsContainer = el.closest('.alm-default-advanced-search').find('.alm-default-search-results');
		searchTimer = setTimeout(function() {
			if(searchTerm.length<1){
				return;
			}
			clearTimeout(searchTimer);
			if (searchCurrentRequest !== null) {
				searchCurrentRequest.abort();
			}
			searchCurrentRequest = jQuery.ajax({
				url: alma_obj.ajax_url,
				type: 'post',
				data: {
					action: 'alm_ajax_search',
					post_type: ['product'],
					search: searchTerm
				},
				beforeSend: function() {
					resultsContainer.html(loader_html);
					resultsContainer.removeClass('alm-hide');
				},
				success: function(response) {
					resultsContainer.html(response);
				},
				error: function(){
					resultsContainer.html(`<p>${alma_obj.translations.failed}</p>`);
				},
				complete: function() {
					currentRequest = null;
				}
			});
		},500);
	});
	$('.alm-default-advanced-search').on('focus','.alm-default-search-box-input',function(event){
		let el = $(this);
		let resultsContainer = el.closest('.alm-default-advanced-search').find('.alm-default-search-results');
		let result_html = resultsContainer.html();
		if(result_html){
			resultsContainer.removeClass('alm-hide');
		}
	});
	$(document).click(function(){
		$(document).click(function(event){
			let target = jQuery(event.target);
			let count = target.closest('.alm-default-advanced-search').length;
			if(count < 1){
				jQuery('.alm-default-search-results:not(.alm-hide)').addClass('alm-hide');
			}
		})
	});

	$('.alm-default-newsletter-form').on('submit',function (e){
        e.preventDefault();
        let data = $(this).serialize();
        let messages_box = $(this).find('.alm-newsletter-message');
        data += "&action=alm_register_newsletter&security=" + alma_obj.newletter_security
        $.ajax({
            type:'post',
            url:alma_obj.ajax_url,
            dataType:'json',
            data:data,
            success:function (response){
                let message_html;
                if (messages_box) {
                    let messages_html = '';
                    if (response.success) {
                        message_html = `<div class="alm-success-message">${response.data}</div>`;
                    } else {
                        message_html = `<div class="alm-error-message">${response.data}</div>`;
                    }
                    messages_box.html(message_html);
                    messages_box.removeClass('alm-hide');
                }

            }
        });
    })

	$('#alm-mobile-menu-modal').on('click','.alm-mobile-menu li a',function(event){
		let el = $(this)
		if (!$(event.target).closest('.alm-link-content').length) {
			event.preventDefault();
			el.closest('li').toggleClass('alm-extend-mobile-menu-item');
		}
	});

});

function addDashToPriceFilter(priceFilter) {
    if (!priceFilter.querySelector('.price-filter-dash')) {
        const dash = document.createElement('span');
        dash.classList.add('price-filter-dash');
        dash.textContent = '-';
        priceFilter.insertBefore(dash, priceFilter.lastElementChild);
    }
}


function observePriceFilters() {
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.type === 'childList') {
                mutation.addedNodes.forEach((node) => {
                    if (node.nodeType === Node.ELEMENT_NODE) {
                        if (node.classList.contains('wc-block-price-filter__range-text')) {
                            addDashToPriceFilter(node);
                        } else {
                            const priceFilters = node.querySelectorAll('.wc-block-price-filter__range-text');
                            priceFilters.forEach(addDashToPriceFilter);
                        }
                    }
                });
            }
        });
    });

    observer.observe(document.body, { childList: true, subtree: true });
}

document.addEventListener('DOMContentLoaded', function() {
    const initialPriceFilters = document.querySelectorAll('.wp-block-woocommerce-price-filter');
    initialPriceFilters.forEach(addDashToPriceFilter);
    observePriceFilters();
});

function calculateElementPosition($elm) {
	var offset = $elm.offset();

	return {
		top: offset?.top??0,
		left: offset?.left??0
	};
}

function throttle(func, limit) {
	let inThrottle;
	return function() {
		const args = arguments;
		const context = this;
		if (!inThrottle) {
			func.apply(context, args);
			inThrottle = true;
			setTimeout(() => inThrottle = false, limit);
		}
	}
}

// Debounce function
function debounce(func, wait) {
	let timeout;
	return function() {
		const context = this;
		const args = arguments;
		clearTimeout(timeout);
		timeout = setTimeout(() => func.apply(context, args), wait);
	}
}


function updatePlusButtonStatus(el) {
	let quantity_input = el.parent().find('.qty');
	let minus_button = el.parent().find('.alm-change-quantity-minus');
	let step = 1;
	if (quantity_input.is('[step]')) {
		step = parseInt(quantity_input.attr('step'));
	}
	if (quantity_input.length) {
		let quantity = 1;
		if (quantity_input.val().length) {
			quantity = parseInt(quantity_input.val());
		} else {
			quantity_input.val(1);
		}

		let can_plus = true;
		if (quantity_input.is('[max]') && quantity_input.attr('max').length && quantity + step > parseInt(quantity_input.attr('max'))) {
			can_plus = false;
		}
		let can_minus = true;
		if (quantity_input.is('[min]') && quantity_input.attr('min').length && quantity - step < parseInt(quantity_input.attr('min'))) {
			can_minus = false;
		}

		el.prop('disabled', !can_plus);
		minus_button.prop('disabled', !can_minus);
	}
}

function updateMinusButtonStatus(el) {
	let quantity_input = el.parent().find('.qty');
	let plus_button = el.parent().find('.alm-change-quantity-plus');
	let step = 1;
	if (quantity_input.is('[step]')) {
		step = parseInt(quantity_input.attr('step'));
	}
	if (quantity_input.length) {
		let quantity = 1;
		if (quantity_input.val().length) {
			quantity = parseInt(quantity_input.val());
		} else {
			quantity_input.val(1);
		}

		let can_plus = true;
		if (quantity_input.is('[max]') && quantity_input.attr('max').length && quantity + step > parseInt(quantity_input.attr('max'))) {
			can_plus = false;
		}
		let can_minus = true;
		if (quantity_input.is('[min]') && quantity_input.attr('min').length && quantity - step < parseInt(quantity_input.attr('min'))) {
			can_minus = false;
		}

		el.prop('disabled', !can_minus);
		plus_button.prop('disabled', !can_plus);

	}
}

function startTimer(timerElement) {
    let remainingTime = parseInt(timerElement.attr('data-remain'));


    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${minutes < 10 ? '0' : ''}${minutes}:${secs < 10 ? '0' : ''}${secs}`;
    }

    function updateTimer() {
        if (remainingTime > 0) {
            remainingTime--;
            timerElement.html(formatTime(remainingTime));
        } else {
            clearInterval(timerInterval);
			let resend = '<button type="button" class="alm-otp-form-resend-button">ارسال مجدد کد برای شما</button>';
            timerElement.closest('.alm-otp-form-time-box').html(resend);
        }
    }

    // Initial display of the timer
    timerElement.textContent = formatTime(remainingTime);

    // Update the timer every second
    const timerInterval = setInterval(updateTimer, 1000);
}

function abstractFilename(filename, maxLength = 15) {
	if (filename.length <= maxLength) return filename;

	const extIndex = filename.lastIndexOf(".");
	const namePart = filename.slice(0, extIndex);
	const extension = filename.slice(extIndex);

	const visibleChars = Math.floor((maxLength - 3) / 2);
	return `${namePart.slice(0, visibleChars)}...${namePart.slice(-visibleChars)}${extension}`;
  }
