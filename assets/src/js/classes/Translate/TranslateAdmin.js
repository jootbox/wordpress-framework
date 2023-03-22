export default class TranslateAdmin {

	constructor() {
		if ( ! this.setVars() ) {
			return;
		}

		this.setEvents();
	}

	setVars() {
		this.switcher = document.querySelector( 'select[name=post_lang_choice]' );
		if ( ! this.switcher ) {
			return;
		}

		this.default = this.switcher.value;
		this.alert   = wpF.adminTranslate.polylang_switcher;

		return true;
	}

	setEvents() {
		this.switcher.addEventListener( 'change', ( e ) => {
			this.lockChange( e );
		} );
	}

	lockChange( e ) {
		const answer = confirm( this.alert );

		if ( ! answer ) {
			this.switcher.value = this.default;
			e.preventDefault();
		} else {
			this.default = this.switcher.value;
		}
	}
}
