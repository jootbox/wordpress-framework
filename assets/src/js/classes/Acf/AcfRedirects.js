const $ = jQuery;

export default class AcfRedirects {

	constructor() {
		if ( ! this.setVars() ) {
			return;
		}

		this.setEvents();
	}

	setVars() {
		this.section = document.querySelector( '.acf-field[data-name="wpf_rewrites_list"]' );
		if ( ! this.section ) {
			return;
		}

		return true;
	}

	setEvents() {
		$( this.section ).on( 'click', '[data-event="remove-row"]', ( e ) => {
			e.currentTarget.click();
		} );
	}
}
