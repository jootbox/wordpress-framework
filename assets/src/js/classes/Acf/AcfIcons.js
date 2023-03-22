const $ = jQuery;

export default class AcfIcons {

	constructor() {
		if ( ! this.setVars() ) {
			return;
		}

		this.setEvents();
	}

	setVars() {
		this.buttons = document.querySelectorAll( '.acf-field[data-name="icon"] .acf-input' );
		if ( ! this.buttons.length ) {
			return;
		}

		return true;
	}

	setEvents() {
		$( 'body' ).on( 'click', '.acf-field[data-name="icon"] .acf-input', () => {
			this.generateIcons();
		} );
	}

	generateIcons() {
		let wrapper      = document.querySelectorAll( '.select2-container--open' );
		const { length } = wrapper;
		if ( ! length ) {
			return;
		}

		wrapper    = wrapper[ length - 1 ];
		const list = wrapper.querySelector( '.select2-results__options' );

		$( wrapper ).addClass( 'select2-container--icons' );
		$( list ).addClass( 'select2-results__options--icons' );

		const icons       = list.querySelectorAll( '.select2-results__option' );
		const iconsLength = icons.length;

		for ( let i = 0; i < iconsLength; i++ ) {

			const icon = icons[ i ].innerHTML;
			$( icons[ i ] ).addClass( `icon-${ icon }` );

		}
	}
}
