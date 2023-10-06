import AcfFlexible from './Acf/AcfFlexible.js';
import AcfIcons from './Acf/AcfIcons.js';
import AcfLayouts from './Acf/AcfLayouts.js';
import AcfRedirects from './Acf/AcfRedirects.js';
// import AdminMenu from './Admin/AdminMenu.js';
import AdminPublishbox from './Admin/AdminPublishbox.js';
import FormsPosttype from './Forms/FormsPosttype.js';
import ToolsCategories from './Tools/ToolsCategories.js';
import ToolsStats from './Tools/ToolsStats.js';
import TranslateAdmin from './Translate/TranslateAdmin.js';

class Core {

	constructor() {
		new AcfFlexible();
		new AcfIcons();
		new AcfLayouts();
		new AcfRedirects();
		// window.addEventListener( 'load', () => { new AdminMenu(); } );
		window.addEventListener( 'load', () => { new AdminPublishbox(); } );
		window.addEventListener( 'load', () => { new FormsPosttype(); } );
		window.addEventListener( 'load', () => { new ToolsCategories(); } );
		window.addEventListener( 'load', () => { new ToolsStats(); } );
		new TranslateAdmin();
	}
}

new Core();
