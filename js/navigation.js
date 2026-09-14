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

// The Cart page itself uses the WooCommerce Cart block (Store API): quantity
// updates and item removal go through /wp-json/wc/store/v1/cart/*, managed
// by the public "wc/store/cart" data store (the same one the core Mini Cart
// block reads from). Subscribe to it directly and keep the badge in sync
// from its actual state. Our script has no declared dependency on whichever
// script registers that store, so it may not exist yet the instant this
// file runs - poll briefly rather than checking only once.
( function pollForCartStore( attemptsLeft ) {
	var cartStoreAvailable = window.wp && wp.data && typeof wp.data.subscribe === 'function' && wp.data.select( 'wc/store/cart' );

	if ( ! cartStoreAvailable ) {
		if ( attemptsLeft > 0 ) {
			setTimeout( function () {
				pollForCartStore( attemptsLeft - 1 );
			}, 200 );
		}

		return;
	}

	var lastCartItemsCount = null;

	wp.data.subscribe( function () {
		var cartStore = wp.data.select( 'wc/store/cart' );
		var cartData = cartStore && cartStore.getCartData ? cartStore.getCartData() : null;

		if ( ! cartData || typeof cartData.itemsCount === 'undefined' || cartData.itemsCount === lastCartItemsCount ) {
			return;
		}

		lastCartItemsCount = cartData.itemsCount;

		document.querySelectorAll( '.cart-contents-count' ).forEach( function ( el ) {
			el.textContent = cartData.itemsCount;
		} );
	} );
} )( 25 );
