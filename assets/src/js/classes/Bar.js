import AdminBar from './Admin/AdminBar';

class Core {

	constructor() {
		window.addEventListener( 'load', () => { new AdminBar(); } );
	}
}

new Core();
