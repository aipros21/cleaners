/**
 * FindMyCleaner - Main JavaScript
 */
(function($) {
    'use strict';

    // ==========================================
    // INITIALIZATION
    // ==========================================
    $(document).ready(function() {
        initMegaMenu();
        initBackToTop();
        initSearchAutocomplete();
        initFormValidation();
        initAOS();
        initSliders();
        initSelect2();
        initLazyLoad();
        initNewsletterForm();
    });

    // ==========================================
    // MEGA MENU
    // ==========================================
    function initMegaMenu() {
        var $megaItem = $('.mega-menu-item');

        // Desktop: show on hover
        if (window.innerWidth >= 992) {
            $megaItem.on('mouseenter', function() {
                $(this).addClass('show').find('.mega-menu').addClass('show');
            }).on('mouseleave', function() {
                $(this).removeClass('show').find('.mega-menu').removeClass('show');
            });
        }
    }

    // ==========================================
    // BACK TO TOP
    // ==========================================
    function initBackToTop() {
        var $btn = $('#backToTop');

        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 300) {
                $btn.fadeIn();
            } else {
                $btn.fadeOut();
            }
        });

        $btn.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({ scrollTop: 0 }, 600);
        });
    }

    // ==========================================
    // SEARCH AUTOCOMPLETE
    // ==========================================
    function initSearchAutocomplete() {
        var $searchInput = $('#heroSearch, #searchInput');
        var timer;

        $searchInput.on('keyup', function() {
            var query = $(this).val().trim();
            var $results = $(this).siblings('.search-autocomplete');

            clearTimeout(timer);

            if (query.length < 2) {
                $results.hide().empty();
                return;
            }

            timer = setTimeout(function() {
                $.getJSON('/api/handle_search.php', { q: query }, function(data) {
                    if (data.results && data.results.length) {
                        var html = '';
                        $.each(data.results, function(i, item) {
                            html += '<a href="' + item.url + '" class="autocomplete-item">';
                            if (item.type === 'category') html += '<i class="ti-tag mr-2"></i>';
                            else if (item.type === 'cleaner') html += '<i class="ti-user mr-2"></i>';
                            else html += '<i class="ti-file mr-2"></i>';
                            html += item.name + '</a>';
                        });
                        $results.html(html).show();
                    } else {
                        $results.hide().empty();
                    }
                });
            }, 300);
        });

        // Close autocomplete on click outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-wrapper').length) {
                $('.search-autocomplete').hide();
            }
        });
    }

    // ==========================================
    // FORM VALIDATION & AJAX SUBMISSION
    // ==========================================
    function initFormValidation() {
        // AJAX form handler with reCAPTCHA v3
        $(document).on('submit', 'form[data-ajax]', function(e) {
            e.preventDefault();
            var $form = $(this);
            var $btn = $form.find('[type="submit"]');
            var originalText = $btn.html();

            $btn.prop('disabled', true).html('<i class="ti-reload ti-spin"></i> Processing...');
            $form.find('.alert').remove();

            function submitForm() {
                $.ajax({
                    url: $form.attr('action'),
                    method: $form.attr('method') || 'POST',
                    data: $form.serialize(),
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            if (data.redirect) {
                                window.location.href = data.redirect;
                            } else if (data.message) {
                                $form.prepend('<div class="alert alert-success">' + data.message + '</div>');
                                if ($form.data('reset')) $form[0].reset();
                            }
                        } else {
                            $form.prepend('<div class="alert alert-danger">' + (data.error || 'Something went wrong.') + '</div>');
                        }
                    },
                    error: function() {
                        $form.prepend('<div class="alert alert-danger">Server error. Please try again.</div>');
                    },
                    complete: function() {
                        $btn.prop('disabled', false).html(originalText);
                    }
                });
            }

            // Get reCAPTCHA v3 token if available
            var $recaptchaField = $form.find('input[name="g-recaptcha-response"]');
            if ($recaptchaField.length && typeof getRecaptchaToken === 'function') {
                var action = $form.data('recaptcha-action') || 'submit';
                getRecaptchaToken(action).then(function(token) {
                    $recaptchaField.val(token);
                    submitForm();
                });
            } else {
                submitForm();
            }
        });

        // Multi-step form
        $(document).on('click', '.step-next', function() {
            var $step = $(this).closest('.form-step');
            var isValid = true;

            $step.find('[required]').each(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            if (isValid) {
                var nextStep = $step.data('step') + 1;
                $step.hide();
                $('.form-step[data-step="' + nextStep + '"]').show();
                updateProgressBar(nextStep);
            }
        });

        $(document).on('click', '.step-prev', function() {
            var $step = $(this).closest('.form-step');
            var prevStep = $step.data('step') - 1;
            $step.hide();
            $('.form-step[data-step="' + prevStep + '"]').show();
            updateProgressBar(prevStep);
        });
    }

    function updateProgressBar(step) {
        var totalSteps = $('.form-step').length;
        var percent = ((step) / totalSteps) * 100;
        $('.progress-bar').css('width', percent + '%').attr('aria-valuenow', percent);
        $('.step-indicator').removeClass('active');
        for (var i = 1; i <= step; i++) {
            $('.step-indicator[data-step="' + i + '"]').addClass('active');
        }
    }

    // ==========================================
    // AOS (Animate on Scroll)
    // ==========================================
    function initAOS() {
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 800,
                once: true,
                offset: 100
            });
        }
    }

    // ==========================================
    // SLICK SLIDERS
    // ==========================================
    function initSliders() {
        if ($.fn.slick) {
            $('.testimonial-slider').slick({
                dots: true,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 5000,
                slidesToShow: 3,
                slidesToScroll: 1,
                responsive: [
                    { breakpoint: 992, settings: { slidesToShow: 2 } },
                    { breakpoint: 576, settings: { slidesToShow: 1 } }
                ]
            });

            $('.featured-slider').slick({
                dots: false,
                arrows: true,
                autoplay: true,
                autoplaySpeed: 4000,
                slidesToShow: 4,
                slidesToScroll: 1,
                prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>',
                nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>',
                responsive: [
                    { breakpoint: 992, settings: { slidesToShow: 3 } },
                    { breakpoint: 768, settings: { slidesToShow: 2 } },
                    { breakpoint: 576, settings: { slidesToShow: 1 } }
                ]
            });
        }
    }

    // ==========================================
    // SELECT2
    // ==========================================
    function initSelect2() {
        if ($.fn.select2) {
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: $(this).data('placeholder') || 'Select...',
                allowClear: true
            });
        }
    }

    // ==========================================
    // LAZY LOADING
    // ==========================================
    function initLazyLoad() {
        if ('IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        observer.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img.lazy').forEach(function(img) {
                observer.observe(img);
            });
        }
    }

    // ==========================================
    // NEWSLETTER FORM
    // ==========================================
    function initNewsletterForm() {
        $('#newsletterForm').on('submit', function(e) {
            e.preventDefault();
            var $form = $(this);
            var $btn = $form.find('button[type="submit"]');
            var email = $form.find('input[type="email"]').val();

            $btn.prop('disabled', true).text('...');

            $.post('/api/handle_contact.php', {
                type: 'newsletter',
                email: email
            }, function(data) {
                if (data.success) {
                    $form.html('<small class="text-success"><i class="ti-check mr-1"></i> Thanks for subscribing!</small>');
                } else {
                    $btn.prop('disabled', false).text('Subscribe');
                    $form.find('.newsletter-error').remove();
                    $form.append('<small class="text-danger newsletter-error d-block mt-1">' + (data.error || 'Please try again.') + '</small>');
                }
            }, 'json').fail(function() {
                $btn.prop('disabled', false).text('Subscribe');
                $form.find('.newsletter-error').remove();
                $form.append('<small class="text-danger newsletter-error d-block mt-1">Something went wrong. Please try again.</small>');
            });
        });
    }

    // ==========================================
    // PHOTO GALLERY (Magnific Popup)
    // ==========================================
    window.initGallery = function() {
        if ($.fn.magnificPopup) {
            $('.photo-gallery').magnificPopup({
                delegate: 'a',
                type: 'image',
                gallery: { enabled: true },
                image: { titleSrc: 'title' }
            });
        }
    };

    // ==========================================
    // UTILITY: Format phone on input
    // ==========================================
    $(document).on('input', 'input[type="tel"]', function() {
        var val = $(this).val().replace(/\D/g, '');
        if (val.length > 0) {
            if (val.length <= 3) val = '(' + val;
            else if (val.length <= 6) val = '(' + val.substring(0,3) + ') ' + val.substring(3);
            else val = '(' + val.substring(0,3) + ') ' + val.substring(3,6) + '-' + val.substring(6,10);
        }
        $(this).val(val);
    });

})(jQuery);
