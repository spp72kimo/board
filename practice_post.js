
let request = new XMLHttpRequest();
request.open('POST', "https://reqres.in/api/users", true);
request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
let params = encodeURIComponent("name=Steven$job=richMan");
request.send(params);
request.onload = function() {
	if(request.status >= 200 && request.status <400){
		let resp = request.response;
	 	resp = JSON.parse(resp);
		console.log(resp);
	}
	else
		console.log('error1');
};

request.onerror = function() {
	console.log("error2");
};

