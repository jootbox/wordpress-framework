import axios from 'axios';

export default class ScriptsSend {

	constructor( instance, config ) {
		this.instance   = instance;
		this.config     = config;
		this.lockSubmit = false;
	}

	submitForm( e ) {
		if ( this.lockSubmit ) {
			return false;
		}

		this.setFlags( false, false, true, false );
		this.instance.$validator.validateAll().then( ( response ) => {
			if ( ! response ) {
				this.showValidateError( e );
			} else {
				this.sendAjax( e );
			}
		} ).catch( () => {
			this.showValidateError( e );
		} );
	}

	showValidateError( e ) {
		e.preventDefault();
		this.setFlags( true, false, false, false );

		this.instance.response.submit_error   = this.config.messages.send.validate;
		this.instance.response.submit_success = '';
	}

	sendAjax( e ) {
		if ( this.instance.$refs._form.getAttribute( 'action' ) !== null ) {
			return;
		}

		e.preventDefault();
		if ( ! this.actionBeforeSend() ) {
			this.setFlags( false, false, false, false );
			return;
		}

		axios.post( this.config.api_url,
			this.getFormData(),
			{
				headers: {
					'Content-Type': 'multipart/form-data',
				},
			}
		).then( ( response ) => {
			const message = ( ( response || {} ).data || {} ).message || null;
			this.showSendSuccess( message );
		} ).catch( ( error ) => {
			const message = ( ( ( error || {} ).response || {} ).data || {} ).message || null;
			this.showSendError( message );
		} );
	}

	getFormData() {
		const formData   = new FormData();
		const { length } = this.config.fields_keys;
		for ( let i = 0; i < length; i++ ) {

			const key = this.config.fields_keys[ i ];
			if ( typeof this.instance.$data.form[ key ] === 'object' ) {
				const count = this.instance.$data.form[ key ].length;
				if ( count === 0 ) {
					formData.append( key, [] );
				} else {
					for ( let j = 0; j < count; j++ ) formData.append( `${ key }[]`, this.instance.$data.form[ key ][ j ] );
				}
			} else {
				formData.append( key, this.instance.$data.form[ key ] );
			}

		}

		return formData;
	}

	showSendError( message = null ) {
		this.setFlags( false, true, false, false );

		this.instance.response.submit_error   = message ? message : this.config.messages.send.error;
		this.instance.response.submit_success = '';

		this.actionAfterSend( false );
	}

	showSendSuccess( message = null ) {
		this.setFlags( false, false, false, true );

		this.instance.response.submit_error   = '';
		this.instance.response.submit_success = message ? message : this.config.messages.send.success;

		this.instance.$clear.clearForm();
		this.actionAfterSend( true );
	}

	actionBeforeSend() {
		const event = new CustomEvent( 'wpfFormSendBefore', {
			detail: {
				form: this.instance.$el,
				form_id: this.config.form_id,
				data: this.instance.$data.form,
			},
			cancelable: true,
		} );

		return window.dispatchEvent( event );
	}

	actionAfterSend( isSuccess ) {
		if ( this.instance.$recaptcha !== undefined ) {
			this.instance.$recaptcha.resetRecaptcha();
		}

		const event = new CustomEvent( 'wpfFormSendAfter', {
			detail: {
				form: this.instance.$el,
				form_id: this.config.form_id,
				data: this.instance.$data.form,
				success: isSuccess,
			},
		} );
		window.dispatchEvent( event );
	}

	setFlags( validation = false, response = false, sending = false, sent = false ) {
		this.instance.status.errors            = ( validation || response );
		this.instance.status.errors_validation = validation;
		this.instance.status.errors_response   = response;
		this.instance.status.sending           = sending;
		this.instance.status.sent              = sent;

		this.lockSubmit = sending;
	}
}
