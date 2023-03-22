export default class ScriptsRecaptcha {

	constructor( instance, config ) {
		this.instance = instance;
		this.config   = config;
	}

	onCaptchaExpired() {
		this.resetRecaptcha();
		this.instance.$validator.validate( this.config.recaptcha_key );
	}

	onCaptchaVerified( recaptchaToken ) {
		this.instance.$data.form[ this.config.recaptcha_key ]  = recaptchaToken;
		this.instance.$refs[ this.config.recaptcha_key ].value = recaptchaToken;
		this.instance.$validator.validate( this.config.recaptcha_key );
	}

	resetRecaptcha() {
		if ( ! this.config.recaptcha_key ) {
			return;
		}

		this.instance.$data.form[ this.config.recaptcha_key ]  = '';
		this.instance.$refs[ this.config.recaptcha_key ].value = '';
		this.instance.$refs[ `${ this.config.recaptcha_key }-widget` ].reset();
	}
}
