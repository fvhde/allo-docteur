// app/controllers/login.js
import Controller from '@ember/controller';
import { inject as service } from '@ember/service';
import { action } from "@ember/object";

export default class LoginController extends Controller {
  @service session;

  @action
  async authenticate(e) {
    e.preventDefault();
    const credentials = this.getProperties('username', 'password');
    const authenticator = 'authenticator:token'; // or 'authenticator:jwt'

    this.session.authenticate(authenticator, credentials);
  }
};
