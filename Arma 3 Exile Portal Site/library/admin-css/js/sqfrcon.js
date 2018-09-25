	var execute = true;
	var parameters = {
		protocol: "protocol",
		url: "address",
		port: "port",
		username: "username",
		password: "password",
		code: "script"
	};
	if (execute) {
		remoteExecute(
			((document.getElementById('protocol').value) + (document.getElementById('url').value) + ":" + (document.getElementById('port').value)),
			(document.getElementById('code').value),
			(document.getElementById('username').value),
			(document.getElementById('password').value)
		);
	}

function remoteExecute(url, data, username, password) {

	var jqxhr = $.post(url, {
		user: username,
		pass: password,
		script: data
		})
}
