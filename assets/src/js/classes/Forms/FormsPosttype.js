const $ = jQuery;

export default class FormsPosttype {

	constructor() {
		if ( ! this.setVars() ) {
			return;
		}

		this.regenerateShortcodes();
		this.setEvents();
	}

	setVars() {
		this.section = document.querySelector( '.acf-field-repeater[data-name="fields"]' );
		if ( ! this.section ) {
			return;
		}

		this.wrapper = this.section.querySelector( ':scope > .acf-input > .acf-repeater > .acf-table > tbody' );
		this.info    = this.section.parentNode.querySelector( '.acf-field-message .acf-input' );

		return true;
	}

	setEvents() {
		$( 'body' ).on( 'keyup', '.acf-field-repeater[data-name="fields"] .acf-field-text[data-name="name"] input', () => {
			this.regenerateShortcodes();
		} );
	}

	regenerateShortcodes() {
		const items = this.wrapper.querySelectorAll( ':scope > .acf-row' );
		const list  = [];

		const { length } = items;
		for ( let i = 0; i < length; i++ ) {

			if ( items[ i ].getAttribute( 'data-id' ) === 'acfcloneindex' ) {
				continue;
			}

			const { value } = items[ i ].querySelector( '.acf-field-text[data-name="name"] input' );
			list.push( value );

		}

		const inner         = list.join( ']</strong><strong>[' );
		const message       = list ? `<strong>[${ inner }]</strong>` : '';
		this.info.innerHTML = message;
	}
}
