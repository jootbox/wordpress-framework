export default class AdminBar {

	constructor() {
		if ( ! this.setVars() ) {
			return;
		}

		this.setEvents();
	}

	setVars() {
		this.bar = document.querySelector( '#wpadminbar' );
		if ( ! this.bar ) {
			return;
		}

		this.toggleButton = this.bar.querySelector( '#wp-admin-bar-wp-logo > .ab-item' );
		this.showBar      = ( localStorage.adminBar && ( localStorage.adminBar === '1' ) );

		return true;
	}

	setEvents() {
		if ( this.showBar ) {
			this.bar.classList.add( 'open' );
		}

		this.toggleButton.addEventListener( 'click', ( e ) => {
			e.preventDefault();
			this.toggleBar();
		} );
	}

	toggleBar() {
		if ( ! this.showBar ) {
			this.bar.classList.add( 'open' );
			localStorage.adminBar = '1';
			this.showBar          = true;
		} else {
			this.bar.classList.remove( 'open' );
			localStorage.adminBar = '0';
			this.showBar          = false;
		}
	}
}
