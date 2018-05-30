import Cookies from 'universal-cookie';

export default class Auth {

	constructor () {
		this._cookies = new Cookies();
		this._token = this._getTokenData();
		this._setAxiosAuthorization();
	}

	_setAxiosAuthorization() {
		if (this._token.access_token) {
			window.axios.defaults.headers.common['Authorization'] = this._token.token_type + ' ' + this._token.access_token;
		}
	}

	_getTokenData() {
		return {
			access_token: this._cookies.get('access_token') || null,
			expires_in: this._cookies.get('expires_in') || null,
			refresh_token: this._cookies.get('refresh_token') || null,
			token_type: this._cookies.get('token_type') || null
		}
	}

	removeTokenData() {
		//Remove cookie token data
		for (var i in this._token) {
			if (this._token[i] != null) {
				this._cookies.remove(i);
			}
		}
		this._token = this._getTokenData();
	}

	isAuthenticated() {
		return this._token.access_token ? true : false;
	}

	setTokenData(token_data, remember) {
		token_data = token_data || null
		remember = remember || false;

		if (token_data != null) {
			this._token = {
				access_token: token_data.access_token || null,
				expires_in: token_data.expires_in || null,
				refresh_token: token_data.refresh_token || null,
				token_type: token_data.token_type || null
			}

			if (remember) {
				let expires = new Date(new Date().valueOf());
				expires.setDate(expires.getDate() + 365);

				for (var i in this._token) {
					if (this._token[i] != null) {
						this._cookies.set(i, this._token[i], {
							expires: expires
						});
					}
				}

				//Set axios authorization
				this._setAxiosAuthorization();
				return this;
			}

			//Save token data in cookies
			for (var i in this._token) {
				if (this._token[i] != null) {
					this._cookies.set(i, this._token[i]);
				}
			}

			//Set axios authorization
			this._setAxiosAuthorization();
		}

		return this;
	}
}