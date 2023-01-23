class HandleOnPageLinks {
	constructor() {
		this.handleOnPageLinks();
	}

	handleOnPageLinks() {
		(function ($) {
			// jQuery( document ).ready( function( $ ) {

				$( '.menu-toggle, #menu-main-menu li a' ).click( function() {
					var menu = $( '#menu-main-menu' );
					if ( menu.hasClass( 'mobile-menu' ) ) {
						menu.removeClass( 'mobile-menu' );
					} else {
						menu.addClass( 'mobile-menu' );
					}
				});
			
			
				if ( $( 'body' ).hasClass( 'home' ) ) {
					$( '.site-logo, .head-p-name' ).click( function( e ) {
						e.preventDefault();
						$( 'html, body' ).animate({scrollTop: 0}, '500' );
					});
				}
			
				$( function() {
					var headerHeight = $("#masthead").height();
			
					$( 'a[href*="#"]:not([href="#"])' ).on("click", function() {
						if ( location.pathname.replace( /^\//, '' ) == this.pathname.replace( /^\//, '' ) && location.hostname == this.hostname ) {
							var target = $( this.hash );
							target = target.length ? target : $( '[name=' + this.hash.slice( 1 ) + ']' );
							if ( target.length ) {
								$( 'html, body' ).animate({
									scrollTop: target.offset().top - headerHeight
								}, 300, 'linear' );
								return false;
							}
						}
					});
				});
			
			// });        
		})(jQuery);
	}
}

export default HandleOnPageLinks;


