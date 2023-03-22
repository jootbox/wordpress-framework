const $ = jQuery;

export default class AcfLayouts {

	constructor() {
		if ( ! this.setVars() ) {
			return;
		}

		this.setEvents();
		this.hideLayouts();
	}

	setVars() {
		this.layouts    = document.querySelectorAll( '.acf-flexible-content > .values > .layout' );
		this.saveButton = document.querySelector( '#publish' );
		if ( ! this.layouts.length || ! this.saveButton ) {
			return;
		}

		this.config  = {
			optionPage: 'wpfLayoutsPage',
		};
		this.classes = {
			collapsed: '-collapsed',
		};

		return true;
	}

	setEvents() {
		this.saveButton.addEventListener( 'click', () => {
			localStorage[ this.config.optionPage ] = window.location.search;
		} );
	}

	hideLayouts() {
		const page                             = localStorage[ this.config.optionPage ];
		localStorage[ this.config.optionPage ] = null;
		if ( page === window.location.search ) {
			return;
		}

		const { length } = this.layouts;
		for ( let i = 0; i < length; i++ ) {
			this.layouts[ i ].classList.add( this.classes.collapsed );
		}
	}
}
