export default class ScriptsFiles {

	constructor( instance, config ) {
		this.instance = instance;
		this.config   = config;
	}

	uploadFiles( key, isMultiple = false ) {
		const { files, old_files } = this.instance.$refs[ key ];

		let list = ( old_files !== undefined ) ? old_files : [];
		if ( isMultiple ) {
			this.instance.$refs[ key ].old_files = list;
		}

		const { length } = files;
		for ( let i = 0; i < length; i++ ) list.push( files[ i ] );

		this.instance.$validator.validate( key, list ).then( ( response ) => {
			this.instance.$data.form[ key ] = list;
			this.triggerFileChangeEvent( this.instance.$refs[ key ], list );
		} );
	}

	removeFile( name, index ) {
		let list = this.instance.$data.form[ name ];
		if ( index !== undefined ) {
			list.splice( index, 1 );
		} else {
			list = [];
		}

		this.instance[ name ] = list;
		this.triggerFileChangeEvent( this.instance.$refs[ name ], list );
		if ( list[ 0 ] ) {
			return;
		}

		this.instance.$refs[ name ].value = [];
		this.instance.$validator.validate( name );
	}

	triggerFileChangeEvent( input, files ) {
		window.dispatchEvent( new CustomEvent( 'wpfFormUploadFiles', {
			detail: {
				form_id: this.config.form_id,
				handle: this.instance,
				input,
				list: files,
			},
		} ) );
	}
}
