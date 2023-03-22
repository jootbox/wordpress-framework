const $ = jQuery;

export default class ToolsStats {

	constructor() {
		if ( ! this.setVars() ) {
			return;
		}

		this.setEvents();
	}

	setVars() {
		this.box = document.querySelector( '.wpfStatsBox' );
		if ( ! this.box ) {
			return;
		}

		this.buttons = this.box.querySelectorAll( '.button' );
		this.tables  = this.box.querySelectorAll( '.wpfStatsBox__table' );

		return true;
	}

	setEvents() {
		const { length } = this.buttons;
		for ( let i = 0; i < length; i++ ) {

			this.buttons[ i ].addEventListener( 'click', ( e ) => {
				e.preventDefault();
				this.openTab( i );
			} );

		}
	}

	openTab( index ) {
		$( this.buttons ).removeClass( 'button-primary' );
		$( this.tables ).removeClass( 'wpfStatsBox__table--active' );

		$( this.buttons[ index ] ).addClass( 'button-primary' );
		$( this.tables[ index ] ).addClass( 'wpfStatsBox__table--active' );
	}
}
