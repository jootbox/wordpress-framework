const $ = jQuery;

export default class AdminPublishbox {

	constructor() {
		if ( ! this.setVars() ) {
			return;
		}

		this.restoreScrollPosition();
		this.setEvents();
	}

	setVars() {
		this.section = document.querySelector( 'form[action="post.php"]' );
		if ( ! this.section ) {
			return;
		}

		this.side       = this.section.querySelector( '#side-sortables' );
		this.box        = this.side.querySelector( '#submitdiv' );
		this.saveButton = this.box.querySelector( '#publish' );
		this.adminBar   = document.querySelector( '#wpadminbar' );

		this.config = {
			offset: ( this.side.getBoundingClientRect().top + window.pageYOffset + this.side.offsetHeight ) - this.adminBar.offsetHeight,
			optionPage: 'wpfPublishboxPage',
			optionValue: 'wpfPublishboxValue',
		};

		return true;
	}

	setEvents() {
		window.addEventListener( 'scroll', () => {
			this.sideBoxSticky();
		} );

		this.saveButton.addEventListener( 'click', () => {
			this.saveScrollPosition();
		} );
	}

	restoreScrollPosition() {
		let page                               = localStorage[ this.config.optionPage ];
		localStorage[ this.config.optionPage ] = null;
		if ( page !== window.location.search ) {
			return;
		}

		let value = localStorage[ this.config.optionValue ];
		value     = parseInt( value ) + this.getNoticesHeight();
		window.scrollTo( 0, value );
	}

	sideBoxSticky() {
		const scrollTop = document.body.scrollTop || document.documentElement.scrollTop;
		if ( scrollTop >= this.config.offset ) {
			$( this.box ).addClass( 'sticky' );
		} else {
			$( this.box ).removeClass( 'sticky' );
		}
	}

	saveScrollPosition() {
		const value                             = ( document.body.scrollTop || document.documentElement.scrollTop ) - this.getNoticesHeight();
		localStorage[ this.config.optionPage ]  = window.location.search;
		localStorage[ this.config.optionValue ] = value;
	}

	getNoticesHeight() {
		const notices = document.querySelectorAll( '#wpbody-content > .wrap > .notice' );
		let heights   = 0;

		const { length } = notices;
		for ( let i = 0; i < length; i++ ) {
			if ( $( notices[ i ] ).hasClass( 'hidden' ) ) {
				continue;
			}

			const styles = getComputedStyle( notices[ i ] );
			const height = notices[ i ].offsetHeight + parseInt( styles.marginTop ) + parseInt( styles.marginBottom );

			heights += height;
		}
		return heights;
	}
}
