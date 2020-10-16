/**
 * front.js
 *
 * Handles behaviour of the theme
 */
 ( function( $, window ) {
    'use strict';

    var is_rtl = $('body,html').hasClass('rtl');

    $( window ).on( "initComplete.cbp filterComplete.cbp", function() {
        if ( is_rtl ) {
            $('.u-cubeportfolio .cbp-item').each( function() {
                $(this).attr( 'style', $(this).attr('style').replace( 'left', 'right' ) );
            }); 
        }
    });

    $( "#jumpToDropdownInvoker" ).click( function() {
        if ( is_rtl ) {
            let selector = $( "#jumpToDropdown" );
            selector.css( "left", "0" );
            selector.css( "right", "unset" );
        }
    });

    $(window).on('load', function () {
        // initialization of HSMegaMenu component
        if( typeof $.fn.HSMegaMenu !== "undefined" ) {
            $('.js-mega-menu').HSMegaMenu({
                event: $('.js-mega-menu').data( 'dropdown-trigger' ) === 'click' ? 'click': 'hover',
                pageContainer: $('.container'),
                breakpoint: 767.98,
                hideTimeOut: 0
            });
        }

        // initialization of svg injector module
        if ( $.HSCore.components.hasOwnProperty( 'HSSVGIngector' ) ) {
            $.HSCore.components.HSSVGIngector.init('.js-svg-injector');
        }

        // initialization of autonomous popups
        if ( $.HSCore.components.hasOwnProperty( 'HSModalWindow' ) ) {
            $.HSCore.components.HSModalWindow.init('[data-modal-target]', '.js-modal-window', {
                autonomous: true
            });
        }

        // initialization of HSScrollNav component
        if ( $.HSCore.components.hasOwnProperty( 'HSScrollNav' ) ) {
            $.HSCore.components.HSScrollNav.init($('.js-scroll-nav'), {
                duration: 700,
                parent: $('.u-header')
            });
        }
    });

    $(document).on('ready', function () {
        // initialization of header
        if ( $.HSCore.components.hasOwnProperty( 'HSHeader' ) ) {
            $.HSCore.components.HSHeader.init($('#header'));
        }

        // initialization of header fullscreen
        if ( $.HSCore.components.hasOwnProperty( 'HSHeaderFullscreen' ) ) {
            $.HSCore.components.HSHeaderFullscreen.init($('#fullscreen'));
        }

        // initialization of hamburgers
        if ( $.HSCore.components.hasOwnProperty( 'HSHamburgers' ) ) {
            $.HSCore.components.HSHamburgers.init('#hamburgerTrigger', {
                afterClose: function() {
                    $('.collapse.show').trigger('click');
                }
            });
        }

        // initialization of unfold component
        if ( $.HSCore.components.hasOwnProperty( 'HSUnfold' ) ) {
            $.HSCore.components.HSUnfold.init($('[data-unfold-target]'), {
                beforeClose: function () {
                    $('#hamburgerTrigger').removeClass('is-active');
                },
                afterClose: function() {
                    $('#headerSidebarList .collapse.show').collapse('hide');
                }
            });
        }

        $('#headerSidebarList [data-toggle="collapse"]').on('click', function (e) {
            e.preventDefault();

            var target = $(this).data('target');

            if($(this).attr('aria-expanded') === "true") {
                $(target).collapse('hide');
            } else {
                $(target).collapse('show');
            }
        });

        // Navbar collapse closing on 'ESC' keyboard and 'close' hamburger button
        $('#headerToggler').on('click', function(e) {
            $('#fullscreenNav .collapse').collapse('hide');
        });

        $(document).on('keydown', function (e) {
            if (e.keyCode && e.keyCode === 27) {
                $('#fullscreenNav .collapse').collapse('hide');
            }
        });

        // initialization of slick carousel
        if ( $.HSCore.components.hasOwnProperty( 'HSSlickCarousel' ) ) {
            $.HSCore.components.HSSlickCarousel.init('.js-slick-carousel');
            $('.js-slick-carousel').slick('slickSetOption', 'rtl', $('body,html').hasClass('rtl'), true )

        }

        // initialization of malihu scrollbar
        if ( $.HSCore.components.hasOwnProperty( 'HSMalihuScrollBar' ) ) {
            $.HSCore.components.HSMalihuScrollBar.init($('.js-scrollbar'));
        }

        // initialization of show animations
        if ( $.HSCore.components.hasOwnProperty( 'HSShowAnimation' ) ) {
            $.HSCore.components.HSShowAnimation.init('.js-animation-link', {
                afterShow: function() {
                    $('.js-slick-carousel').slick('setPosition');
                }
            });
        }

        // initialization of video player
        if ( $.HSCore.components.hasOwnProperty( 'HSVideoPlayer' ) ) {
            $.HSCore.components.HSVideoPlayer.init('.js-inline-video-player');
        }

        // initialization of forms
        if ( $.HSCore.components.hasOwnProperty( 'HSFocusState' ) ) {
            $.HSCore.components.HSFocusState.init();
        }

        // initialization of go to
        if ( $.HSCore.components.hasOwnProperty( 'HSGoTo' ) ) {
            $.HSCore.components.HSGoTo.init('.js-go-to');
        }

        // initialization of cubeportfolio
        if ( $.HSCore.components.hasOwnProperty( 'HSCubeportfolio' ) ) {
            $.HSCore.components.HSCubeportfolio.init('.cbp');    
        }

        // initialization of sticky blocks
        if ( $.HSCore.components.hasOwnProperty( 'HSStickyBlock' ) ) {
            $.HSCore.components.HSStickyBlock.init('.js-sticky-block');
        }

        // initialization of popups
        if ( $.HSCore.components.hasOwnProperty( 'HSFancyBox' ) ) {
            $.HSCore.components.HSFancyBox.init('.js-fancybox');
        }

         // initialization of datatables
        if ( $.HSCore.components.hasOwnProperty( 'HSDatatables' ) ) {
            $.HSCore.components.HSDatatables.init('.js-datatable');
        }

        // initialization of select picker
        if ( $.HSCore.components.hasOwnProperty( 'HSSelectPicker' ) ) {
            $.HSCore.components.HSSelectPicker.init('.js-select');
        }

        // initialization of quantity counter
        if ( $.HSCore.components.hasOwnProperty( 'HSQantityCounter' ) ) {
            $.HSCore.components.HSQantityCounter.init('.js-quantity');
        }

        // // initialization of horizontal progress bars
        if ( $.HSCore.components.hasOwnProperty( 'HSProgressBar' ) ) {
            $.HSCore.components.HSProgressBar.init('.js-hr-progress');
        }

        if ( $.HSCore.components.hasOwnProperty('HSRangeSlider') ) {
            $.HSCore.components.HSRangeSlider.init('.js-range-slider');
        }

        if ( $.HSCore.components.hasOwnProperty('HSBgVideo') ) {
            $.HSCore.components.HSBgVideo.init('.js-bg-video');
        }

        // initialization of charts
        if ( $.HSCore.components.hasOwnProperty('HSChartistAreaChart') ) {
            $.HSCore.components.HSChartistAreaChart.init('.js-area-chart');
        }

        // initialization of chartist bar charts
        if ( $.HSCore.components.hasOwnProperty('HSChartistBarChart') ) {
            $.HSCore.components.HSChartistBarChart.init('.js-bar-chart');
        }

        // initialization of horizontal progress bars
        if ( $.HSCore.components.hasOwnProperty('HSProgressBar') ) {
            $.HSCore.components.HSProgressBar.init( '.js-hr-progress', {
                direction: 'horizontal',
                indicatorSelector: '.js-hr-progress-bar'
            } )
        }

        // initialization of chart pies
        if ( $.HSCore.components.hasOwnProperty('HSChartPie') ) {
            $.HSCore.components.HSChartPie.init('.js-pie');
        }

        //initialization of HSCountdown component
        if ( $.HSCore.components.hasOwnProperty('HSCountdown') ) {
            var countdowns = $.HSCore.components.HSCountdown.init('.js-countdown', {
                yearsElSelector: '.js-cd-years',
                monthsElSelector: '.js-cd-months',
                daysElSelector: '.js-cd-days',
                hoursElSelector: '.js-cd-hours',
                minutesElSelector: '.js-cd-minutes',
                secondsElSelector: '.js-cd-seconds'
            });
        }

        // initialization of text animation (typing)
        if( typeof Typed !== "undefined" ) {
            $('.u-text-animation').each( function() {
                var strings = $.map( $( this ).text().split('|'), $.trim );
                if( strings.length ) {
                    $( this ).addClass( "u-text-animation-initializd" )
                    $( this ).text('');
                    var typed = new Typed( this, {
                        strings: strings,
                        typeSpeed: 60,
                        loop: true,
                        backSpeed: 25,
                        backDelay: 1500
                    });
                }
            });
        }

        $( '.login-register-tab-switcher' ).on( 'click', function (e) {
            e.preventDefault();
            $( '#customer_login > .woocommerce-notices-wrapper' ).hide();
            $( this ).removeClass( 'active' );
            $( this ).tab( 'show' )
        });

        var hash_value = window.location.hash;

        switch( hash_value ) {
            case '#customer-login-form': 
            case '#customer-register-form':
                $( 'a.login-register-tab-switcher[href="' + hash_value + '"]' ).trigger( 'click' );
            break;
        }

        $( document.body ).on( 'wc-password-strength-added', function() {
            $(".woocommerce-password-strength").attr("id","passwordStrengthProgress");
        } );

        // initialization of countdowns
        // var countdowns = $.HSCore.components.HSCountdown.init('.js-countdown', {
        //     yearsElSelector: '.js-cd-years',
        //     monthsElSelector: '.js-cd-months',
        //     daysElSelector: '.js-cd-days',
        //     hoursElSelector: '.js-cd-hours',
        //     minutesElSelector: '.js-cd-minutes',
        //     secondsElSelector: '.js-cd-seconds'
        // });

        /*===================================================================================*/
        /*  Block UI Defaults
        /*===================================================================================*/
        if( typeof $.blockUI !== "undefined" ) {
            $.blockUI.defaults.message                      = null;
            $.blockUI.defaults.overlayCSS.background        = '#fff url(' + front_options.ajax_loader_url + ') no-repeat center';
            $.blockUI.defaults.overlayCSS.backgroundSize    = '16px 16px';
            $.blockUI.defaults.overlayCSS.opacity           = 0.6;
        }

        /*===================================================================================*/
        /*  Add to Cart animation
        /*===================================================================================*/

        $( 'body' ).on( 'adding_to_cart', function( e, $btn, data){
            $btn.closest( '.product' ).block();
        });

        $( 'body' ).on( 'added_to_cart', function(){
            $( '.product' ).unblock();
        });

        $( document.body ).on( 'wc_fragments_refreshed wc_fragments_loaded', function() {
            if( $( '#shoppingCartDropdown' ).length ) {
                if( $( '#shoppingCartDropdown' ).find( '.woocommerce-mini-cart__empty-message' ).length ) {
                    $( '#shoppingCartDropdown' ).removeClass( 'p-0' );
                    $( '#shoppingCartDropdown' ).addClass( 'text-center' );
                    $( '#shoppingCartDropdown' ).addClass( 'p-7' );
                    $( '#shoppingCartDropdown' ).css( { "min-width":"250px", "width":"" } );
                } else {
                    $( '#shoppingCartDropdown' ).removeClass( 'text-center' );
                    $( '#shoppingCartDropdown' ).removeClass( 'p-7' );
                    $( '#shoppingCartDropdown' ).addClass( 'p-0' );
                    $( '#shoppingCartDropdown' ).css( { "min-width":"", "width":"350px" } );
                }
            }
        });

        /*===================================================================================*/
        /*  YITH Wishlist
        /*===================================================================================*/

        $( document ).on( 'click', '.add_to_wishlist', function() {
            $( this ).closest( '.product' ).block();
        });

        $( document ).on( 'added_to_wishlist', function() {
            $( '.product' ).unblock();
        });

        /*===================================================================================*/
        /*  Shop Grid/List Switcher
        /*===================================================================================*/

        $( '.shop-view-switcher' ).on( 'click', '.nav-link', function() {
            $( '[data-toggle="shop-products"]' ).attr( 'data-view', $(this).data( 'archiveClass' ) );
        } );

        /*===================================================================================*/
        /*  HideMaxListItems
        /*===================================================================================*/
        if( typeof $.fn.hideMaxListItems !== "undefined" ) {
            $('.woocommerce-widget-layered-nav ul').hideMaxListItems( front_options.hide_max_list_items_args );
        }

        /*===================================================================================*/
        /*  Job Grid/List Switcher
        /*===================================================================================*/
        $( '#front-job-view-switcher-grid' ).on( 'click', function(e) {
           e.preventDefault();
           $( this ).addClass( 'active' );
           $( '#front-job-view-switcher-list' ).removeClass( 'active' );
           $( '.job_listings' ).removeClass( 'list-view' );
           $( '.job_listings' ).addClass( 'grid-view' );
        } );

        $( '#front-job-view-switcher-list' ).on( 'click', function(e) {
           e.preventDefault();
           $( this ).addClass( 'active' );
           $( '#front-job-view-switcher-grid' ).removeClass( 'active' );
           $( '.job_listings' ).removeClass( 'grid-view' );
           $( '.job_listings' ).addClass( 'list-view' );
        } );

        /*===================================================================================*/
        /*  Resume Grid/List Switcher
        /*===================================================================================*/
        $( '#front-resume-view-switcher-grid' ).on( 'click', function(e) {
           e.preventDefault();
           $( this ).addClass( 'active' );
           $( '#front-resume-view-switcher-list' ).removeClass( 'active' );
           $( '.resume_listings' ).removeClass( 'list-view' );
           $( '.resume_listings' ).addClass( 'grid-view' );
        } );

        $( '#front-resume-view-switcher-list' ).on( 'click', function(e) {
           e.preventDefault();
           $( this ).addClass( 'active' );
           $( '#front-resume-view-switcher-grid' ).removeClass( 'active' );
           $( '.resume_listings' ).removeClass( 'grid-view' );
           $( '.resume_listings' ).addClass( 'list-view' );
        } );

        /*===================================================================================*/
        /*  WP Job Manager Repeated Field
        /*===================================================================================*/
        $( '.wp-job-manager-add-row' ).click(function() {
            var $wrap     = $(this).closest('.field');
            var max_index = 0;

            $wrap.find('input.repeated-row-index').each(function(){
                if ( parseInt( $(this).val() ) > max_index ) {
                    max_index = parseInt( $(this).val() );
                }
            });

            var html          = $(this).data('row').replace( /%%repeated-row-index%%/g, max_index + 1 );
            $(this).before( html );
            return false;
        });
        $( '#submit-job-form' ).on('click', '.wp-job-manager-remove-row', function() {
            if ( confirm( front_options.wp_job_manager_submission.i18n_confirm_remove ) ) {
                $(this).closest( 'div.wp-job-manager-data-row' ).remove();
            }
            return false;
        });
    });

    $( '.fr-tabs > li > a' ).on( 'click', function() {
        if ( location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname ) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');

            if ( target.length ) {

                scrollTo = target.offset().top;

                if ( $('.sticky-wrapper > .stuck' ).length > 0 ) {
                    scrollTo = scrollTo - 40;
                }

                $('html, body').animate({
                    scrollTop: scrollTo
                }, 1000);
            }
        }
    });

    $('[data-ride="front-slick-carousel"]').each( function() {
        var $slick_target = false;

        if ( $(this).data( 'slick' ) !== 'undefined' && $(this).find( $(this).data( 'wrap' ) ).length > 0 ) {
            $slick_target = $(this).find( $(this).data( 'wrap' ) );
            $slick_target.data( 'slick', $(this).data( 'slick' ) );
        } else if ( $(this).data( 'slick' ) !== 'undefined' && $(this).is( $(this).data( 'wrap' ) ) ) {
            $slick_target = $(this);
        }

        if( $slick_target ) {
            $slick_target.slick();
        }
    });

    $('a.front-pp-add-change').on('click', function(e) {
        e.preventDefault();
        var file_frame,
            self = $(this);

        // If the media frame already exists, reopen it.
        if ( file_frame ) {
            file_frame.open();
            return;
        }

        // Create the media frame.
        file_frame = wp.media.frames.file_frame = wp.media({
            title: jQuery( this ).data( 'uploader_title' ),
            library: {
                type: 'image',
            },
            button: {
                text: jQuery( this ).data( 'uploader_button_text' )
            },
            multiple: false
        });

        // When an image is selected, run a callback.
        file_frame.on( 'select', function() {
            var attachment = file_frame.state().get('selection').first().toJSON();

            var wrap = self.closest('.front-pp-wrap');
            wrap.find('input.front-pp-file-field').val(attachment.id);
            wrap.find('img.img-fluid').attr('src', attachment.url);
            wrap.find('a.front-pp-remove').removeClass('d-none');
        });

        // Finally, open the modal
        file_frame.open();
    });

    $('a.front-pp-remove').on('click', function(e) {
        e.preventDefault();
        self = $(this);
        self.addClass('d-none');
        var wrap = self.closest('.front-pp-wrap');
        wrap.find('input.front-pp-file-field').val(0);

        var gurl = wrap.find('#metronet_default_pic').attr('value');
        wrap.find('img.img-fluid').attr('src', gurl);
    });

 } )( jQuery, window );