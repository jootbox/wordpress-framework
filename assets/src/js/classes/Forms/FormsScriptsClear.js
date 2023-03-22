export default class ScriptsClear {

	constructor( instance, config ) {
		this.instance = instance;
		this.config   = config;
		this.defaults = JSON.stringify( config.data.form );
	}

	clearForm() {
		if ( this.config.options.submit_no_clear ) {
			return;
		}

		this.instance.$validator.pause();

		const defaults = JSON.parse( this.defaults );
		for ( const key in defaults ) {
			this.instance.$data.form[ key ] = defaults[ key ];

			if ( this.instance.$refs[ key ] === undefined ) {
				continue;
			}
			this.instance.$refs[ key ].value = defaults[ key ];
			if ( this.instance.$refs[ key ].old_files !== undefined ) {
				this.instance.$refs[ key ].old_files = [];
			}
			this.sendEventAfterClear( this.instance.$refs[ key ] );

			if ( this.instance.$refs[ key ].getAttribute( 'type' ) === 'file' ) {
				this.instance.$files.triggerFileChangeEvent( this.instance.$refs[ key ], [] );
			}
		}

		this.instance.$recaptcha.resetRecaptcha();
		this.instance.$nextTick( () => {
			this.instance.$validator.reset();
			this.instance.$validator.resume();
			this.instance.errors.clear();
		} );
	}

	sendEventAfterClear( input ) {
		const event = document.createEvent( 'Event' );
		event.initEvent( 'change', true, true );
		input.dispatchEvent( event );
	}
}
