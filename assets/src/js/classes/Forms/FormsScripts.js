import Vue from 'vue/dist/vue.js';
import VeeValidate from 'vee-validate';
import VueRecaptcha from 'vue-recaptcha';
import ScriptsClear from './FormsScriptsClear';
import ScriptsFiles from './FormsScriptsFiles';
import ScriptsRecaptcha from './FormsScriptsRecaptcha';
import ScriptsSend from './FormsScriptsSend';

export default class WordPressFrameworkForms {

  constructor(config) {
    this.config = config;
    if (!this.setVars()) {
      return;
    }

    this.setEvents();
  }

  setVars() {
    this.section = document.querySelector(`#wpf-contact-form-${this.config.form_id}`);
    if (!this.section) {
      return;
    }

    this.lockSubmit = false;
    this.initializeElements = this.initializeElements.bind(this);

    return true;
  }

  setEvents() {
    window.addEventListener('mouseover', this.initializeElements);
    window.addEventListener('keydown', this.initializeElements);
    window.addEventListener('touchmove', this.initializeElements);
    window.addEventListener('touchstart', this.initializeElements);
  }

  removeEvents() {
    window.removeEventListener('mouseover', this.initializeElements);
    window.removeEventListener('keydown', this.initializeElements);
    window.removeEventListener('touchmove', this.initializeElements);
    window.removeEventListener('touchstart', this.initializeElements);
  }

  initializeElements() {
    this.removeEvents();
    this.loadRecaptchaApi();
    this.initValidate();
    this.initVue();
  }

  /* ---
   reCAPTCHA
   --- */

  loadRecaptchaApi() {
    const url = 'https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded';
    if (!this.config.recaptcha_key || document.querySelector(`script[src="${url}"]`)) {
      return;
    }

    const script = document.createElement('script');
    script.setAttribute('src', url);
    document.body.appendChild(script);
  }

  /* ---
   Validate
   --- */

  initValidate() {
    VeeValidate.Validator.localize({
      en: {
        name: 'en',
        messages: this.getValidateMessages(),
        attributes: {},
      },
    });

    this.initCustomValidateRules();
    Vue.use(VeeValidate, {
      locale: 'en',
    });
  }

  getValidateMessages() {
    const list = {};

    for (const key in this.config.messages.validate) {

      const message = this.config.messages.validate[key];
      if (!message) {
        continue;
      }

      if (message.indexOf('%s') > -1) {
        const parts = message.split('%s');
        list[key] = (field, [value]) => {
          const replace = (key === 'date_format') ? value.toUpperCase() : value;
          return parts[0] + replace + parts[1];
        };
      } else {
        list[key] = (field) => message;
      }

    }

    return list;
  }

  initCustomValidateRules() {
    VeeValidate.Validator.extend('numeric', {
      validate(value, args) {
        return /^([+-](?=\.?\d))?(\d+)?(\.\d+)?$/.test(String(value));
      },
    });

    VeeValidate.Validator.extend('step', {
      validate(value, args) {
        const number = Math.round((value - args[1]) * 1e5);
        const step = Math.round(args[0] * 1e5);
        return (number % step === 0);
      },
    });
  }

  /* ---
   Vue.js app
   --- */

  initVue() {
    const _this = this;
    const wrapper = `#wpf-contact-form-${this.config.form_id}`;

    const base = {
      el: wrapper,
      components: { VueRecaptcha },
      mounted() {
        this.$files = new ScriptsFiles(this, _this.config);
        this.$recaptcha = new ScriptsRecaptcha(this, _this.config);
        this.$clear = new ScriptsClear(this, _this.config);
        this.$send = new ScriptsSend(this, _this.config);

        this.$on('removeFile', this.removeFile);
        setTimeout(() => {
          this.sendEvent('wpfFormReady');
        }, 0);
      },
      updated() {
        setTimeout(() => {
          this.sendEvent('wpfFormUpdate');
        }, 0);
      },
      data() {
        return _this.config.data;
      },
      watch: {
        errors: {
          handler(value) {
            const { status } = this.$data;
            const count = value.items.length;
            status.errors_validation = (count > 0);
            status.errors = ((count > 0) || status.errors_response);
          },
          deep: true,
        },
        status: {
          handler() {
            if (this.$data.status.sending) {
              this.$data.status.type = 'sending';
            } else if (this.$data.status.errors) {
              this.$data.status.type = 'errors';
            } else if (this.$data.status.sent) {
              this.$data.status.type = 'sent';
            } else {
              this.$data.status.type = '';
            }
          },
          deep: true,
        },
      },
      methods: {
        showValidate(rules, condition) {
          if (!condition) {
            return rules;
          }
          rules['required'] = false;
          return rules;
        },
        showError(errors, fieldName, regexMessage) {
          const { length } = errors;
          for (let i = 0; i < length; i++) {
            if (errors[i].field !== fieldName) {
              continue;
            }
            return ((errors[i].rule === 'regex') && regexMessage) ? regexMessage : errors[i].msg;
          }
          return null;
        },
        uploadFiles(key, isMultiple = false) {
          this.$files.uploadFiles(key, isMultiple);
        },
        removeFile(name, index) {
          this.$files.removeFile(name, index);
        },
        onCaptchaExpired(recaptchaToken) {
          this.$recaptcha.onCaptchaVerified(recaptchaToken);
        },
        onCaptchaVerified(recaptchaToken) {
          this.$recaptcha.onCaptchaVerified(recaptchaToken);
        },
        onSubmit(e) {
          if (this.$send.submitForm(e) === false) {
            e.preventDefault();
          }
        },
        sendEvent(name) {
          let args = {
            form_id: _this.config.form_id,
            wrapper: this.$el,
          };
          if (name === 'wpfFormReady') {
            args.fields = this.$data.form;
            args.status = this.$data.status;
            args.response = this.$data.response;
            args.config = _this.config;
          }

          window.dispatchEvent(new CustomEvent(name, {
            detail: args,
          }));
        },
      },
    };

    new Vue(base);
  }
};
