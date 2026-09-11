(function () {
	var toggle = document.querySelector( '.menu-toggle' );
	var nav = document.querySelector( '.main-navigation' );

	if ( ! toggle || ! nav ) {
		return;
	}

	function openNav() {
		nav.classList.add( 'is-open' );
		toggle.setAttribute( 'aria-expanded', 'true' );
	}

	function closeNav() {
		nav.classList.remove( 'is-open' );
		toggle.setAttribute( 'aria-expanded', 'false' );
	}

	toggle.addEventListener( 'click', function ( event ) {
		event.stopPropagation();

		if ( nav.classList.contains( 'is-open' ) ) {
			closeNav();
		} else {
			openNav();
		}
	} );

	// Close after a menu link is clicked.
	nav.addEventListener( 'click', function ( event ) {
		if ( event.target.tagName === 'A' ) {
			closeNav();
		}
	} );

	// Close on outside click.
	document.addEventListener( 'click', function ( event ) {
		if ( nav.classList.contains( 'is-open' ) && ! nav.contains( event.target ) && event.target !== toggle ) {
			closeNav();
		}
	} );

	// Close on Escape.
	document.addEventListener( 'keydown', function ( event ) {
		if ( event.key === 'Escape' && nav.classList.contains( 'is-open' ) ) {
			closeNav();
		}
	} );
})();
