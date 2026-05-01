/**
 * VESARA Testimonials Carousel
 * Pure vanilla JS — no dependencies.
 */
(function () {
    'use strict';

    function VesaraCarousel( wrapper ) {
        if ( wrapper.classList.contains( 'vsw-carousel-ready' ) ) return;
        wrapper.classList.add( 'vsw-carousel-ready' );

        var track       = wrapper.querySelector( '.vesara-testimonials-track' );
        var cards       = Array.prototype.slice.call( wrapper.querySelectorAll( '.vesara-testimonial-card' ) );
        var dots        = Array.prototype.slice.call( wrapper.querySelectorAll( '.vesara-carousel-dot' ) );
        var prevBtn     = wrapper.querySelector( '.vesara-carousel-prev' );
        var nextBtn     = wrapper.querySelector( '.vesara-carousel-next' );
        var autoAdv     = wrapper.getAttribute( 'data-auto' ) === 'yes';
        var interval    = parseInt( wrapper.getAttribute( 'data-interval' ), 10 ) * 1000 || 5000;
        var columns     = parseInt( wrapper.getAttribute( 'data-columns' ), 10 ) || 3;

        if ( cards.length < 1 ) return;

        var current    = 0;
        var total      = cards.length;
        var timer      = null;
        var touchStartX = 0;

        /* Compute per-card width based on columns and gap */
        function getCardWidth() {
            var outer   = wrapper.querySelector( '.vesara-testimonials-track-outer' );
            var gap     = 16; // 8px margin each side
            var visCol  = Math.min( columns, total );
            if ( window.innerWidth <= 600 )  visCol = 1;
            else if ( window.innerWidth <= 1024 ) visCol = Math.min( 2, visCol );
            return ( outer.offsetWidth - gap * ( visCol - 1 ) ) / visCol;
        }

        function setTrackWidth() {
            var cw = getCardWidth() + 16; // +16 for margins (8px each side)
            track.style.width = ( cw * total ) + 'px';
            cards.forEach( function ( card ) {
                card.style.flex = '0 0 ' + ( getCardWidth() ) + 'px';
                card.style.margin = '0 8px';
            } );
        }

        function goTo( idx ) {
            current = ( ( idx % total ) + total ) % total;
            var cw   = getCardWidth() + 16;
            var maxOff = ( total - Math.min( columns, total ) );
            if ( window.innerWidth <= 600 ) maxOff = total - 1;
            else if ( window.innerWidth <= 1024 ) maxOff = total - Math.min( 2, columns );
            var safeIdx = Math.min( current, maxOff );
            track.style.transform = 'translateX(-' + ( cw * safeIdx ) + 'px)';
            dots.forEach( function ( d, i ) { d.classList.toggle( 'active', i === current ); } );
        }

        function startAuto() {
            if ( ! autoAdv ) return;
            stopAuto();
            timer = setInterval( function () {
                if ( ! document.body.contains( wrapper ) ) { stopAuto(); return; }
                goTo( current + 1 );
            }, interval );
        }

        function stopAuto() {
            if ( timer ) { clearInterval( timer ); timer = null; }
        }

        setTrackWidth();
        goTo( 0 );

        if ( prevBtn ) prevBtn.addEventListener( 'click', function () { goTo( current - 1 ); startAuto(); } );
        if ( nextBtn ) nextBtn.addEventListener( 'click', function () { goTo( current + 1 ); startAuto(); } );

        dots.forEach( function ( dot, i ) {
            dot.addEventListener( 'click', function () { goTo( i ); startAuto(); } );
        } );

        // Touch/swipe
        wrapper.addEventListener( 'touchstart', function ( e ) {
            touchStartX = e.touches[0].clientX;
        }, { passive: true } );
        wrapper.addEventListener( 'touchend', function ( e ) {
            var dx = touchStartX - e.changedTouches[0].clientX;
            if ( Math.abs( dx ) > 50 ) {
                dx > 0 ? goTo( current + 1 ) : goTo( current - 1 );
                startAuto();
            }
        }, { passive: true } );

        // Keyboard
        wrapper.setAttribute( 'tabindex', '0' );
        wrapper.addEventListener( 'keydown', function ( e ) {
            if ( e.key === 'ArrowLeft' )  { goTo( current - 1 ); startAuto(); }
            if ( e.key === 'ArrowRight' ) { goTo( current + 1 ); startAuto(); }
        } );

        // Resize
        window.addEventListener( 'resize', function () { setTrackWidth(); goTo( current ); } );

        startAuto();
    }

    window.VesaraCarousel = VesaraCarousel;
})();
