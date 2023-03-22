export default class AdminMenu {

	constructor() {
		if ( ! this.setVars() ) {
			return;
		}

		this.addAttribute();
	}

	setVars() {
		this.link = document.querySelector( '#adminmenu .wp-submenu a[href="https://framework.gbiorczyk.pl"]' );
		if ( ! this.link ) {
			return;
		}

		return true;
	}

	addAttribute() {
		this.link.setAttribute( 'target', '_blank' );
	}
}
