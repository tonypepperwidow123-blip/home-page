/**
 * VESARA Elementor Addon — Widget Handlers
 * Bootstraps all frontend interactivity.
 */
( function ( $ ) {
    'use strict';

    // ── Testimonials carousel ────────────────────────────────────────────────
    function initCarousel( $scope ) {
        var wrapper = $scope[0].querySelector( '.vesara-testimonials-wrapper' );
        if ( wrapper && typeof window.VesaraCarousel === 'function' ) {
            setTimeout( function () {
                window.VesaraCarousel( wrapper );
            }, 80 );
        }
    }

    // ── Wishlist toggle (localStorage) ─────────────────────────────────────
    function initWishlist( $scope ) {
        $scope.find( '.vesara-wishlist-btn' ).each( function () {
            var btn = this;
            var pid = btn.getAttribute( 'data-product-id' );
            if ( ! pid ) return;

            var stored = JSON.parse( localStorage.getItem( 'vesara_wishlist' ) || '[]' );
            if ( stored.indexOf( pid ) !== -1 ) {
                btn.classList.add( 'active' );
            }

            btn.addEventListener( 'click', function ( e ) {
                e.preventDefault();
                var list = JSON.parse( localStorage.getItem( 'vesara_wishlist' ) || '[]' );
                var idx  = list.indexOf( pid );
                if ( idx === -1 ) {
                    list.push( pid );
                    btn.classList.add( 'active' );
                } else {
                    list.splice( idx, 1 );
                    btn.classList.remove( 'active' );
                }
                localStorage.setItem( 'vesara_wishlist', JSON.stringify( list ) );
            } );
        } );
    }

    // ── Elementor Frontend hooks ─────────────────────────────────────────────
    $( window ).on( 'elementor/frontend/init', function () {

        if ( typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks ) {

            elementorFrontend.hooks.addAction(
                'frontend/element_ready/vesara_testimonials.default',
                function ( $scope ) {
                    initCarousel( $scope );
                }
            );

            elementorFrontend.hooks.addAction(
                'frontend/element_ready/vesara_new_arrivals.default',
                function ( $scope ) {
                    initWishlist( $scope );
                }
            );

        }
    } );

    // ── Fallback for non-Elementor / server-rendered pages ──────────────────
    document.addEventListener( 'DOMContentLoaded', function () {
        var inEditor = ( typeof elementorFrontend !== 'undefined' &&
                        typeof elementorFrontend.isEditMode === 'function' &&
                        elementorFrontend.isEditMode() );

        if ( ! inEditor ) {
            document.querySelectorAll( '.vesara-testimonials-wrapper' ).forEach( function ( w ) {
                if ( typeof window.VesaraCarousel === 'function' ) {
                    window.VesaraCarousel( w );
                }
            } );
            document.querySelectorAll( '.vesara-wishlist-btn' ).forEach( function ( btn ) {
                var pid = btn.getAttribute( 'data-product-id' );
                if ( ! pid ) return;
                var list = JSON.parse( localStorage.getItem( 'vesara_wishlist' ) || '[]' );
                if ( list.indexOf( pid ) !== -1 ) btn.classList.add( 'active' );
                btn.addEventListener( 'click', function ( e ) {
                    e.preventDefault();
                    var l = JSON.parse( localStorage.getItem( 'vesara_wishlist' ) || '[]' );
                    var i = l.indexOf( pid );
                    if ( i === -1 ) { l.push( pid ); btn.classList.add( 'active' ); }
                    else            { l.splice( i, 1 ); btn.classList.remove( 'active' ); }
                    localStorage.setItem( 'vesara_wishlist', JSON.stringify( l ) );
                } );
            } );
        }
    } );

} )( jQuery );
