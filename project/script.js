$(document).ready(function() {
	$.ajax({
		method: "post",
		url: "get_username.php",
		dateType: "json",
		success: updateUsername,
		error: errFunction
	});
	$("#module_search").submit(function(e) {
		var mydata = {
			name: $("#module_name").val()
		};
		$.ajax({
			method: "post",
			url: "query_modules.php",
			data: mydata,
			dateType: "json",
			success: updateUI,
			error: errFunction
		});
		e.preventDefault();
		return false;
	});
	$("#module_search_tag").submit(function(e) {
		var mydata = {
			tag: $("#module_tag").val()
		};
		$.ajax({
			method: "post",
			url: "query_modules_tag.php",
			data: mydata,
			dateType: "json",
			success: updateUI,
			error: errFunction
		});
		e.preventDefault();
		return false;
	});
	$("#module_add").submit(function(e) {
		var mydata = {
			name: $("#new_module_name").val(),
			url: $("#new_module_url").val(),
			functionality: $("#new_module_functionality").val(),
			tag: $("#new_module_tag").val()
		};
		$.ajax({
			method: "post",
			url: "add_module.php",
			data: mydata,
			dataType: "json",
			success: addSuccess,
			error: errFunction
		});
		e.preventDefault();
		return false;
	});
	$("#module_review").submit(function(e) {
		var mydata = {
			name: $("#rate_module_name").val(),
			rating: $("#module_rating").val()
		};
		$.ajax({
			method: "post",
			url: "rate_module.php",
			data: mydata,
			dataType: "json",
			success: reviewSuccess,
			error: errFunction
		});
		e.preventDefault();
		return false;
	});
	$("#register_form").submit(function(e) {
		var mydata = {
			username: $("#register_name").val(),
			password: $("#register_password").val()
		};
		$.ajax({
			method: "post",
			url: "register.php",
			data: mydata,
			dataType: "json",
			success: registerSuccess,
			error: errFunction
		});
		e.preventDefault();
		return false;
	});
	$("#login").submit(function(e) {
		var mydata = {
			username: $("#login_username").val(),
			password: $("#login_password").val()
		};
		$.ajax({
			method: "post",
			url: "login.php",
			data: mydata,
			dataType: "json",
			success: loginSuccess,
			error: errFunction
		});
		e.preventDefault();
		return false;
	});

	function errFunction(a, b) {
		alert("error:" + a + "/" + b);
	}

	function addSuccess(data) {
		alert(data.message);
	}

	function reviewSuccess(data) {
		alert(data.message);
	}

	function registerSuccess(data) {
		alert(data.message);
		window.location.replace("http://web.engr.oregonstate.edu/~penneys/bluetooth/home.html");
	}

	function loginSuccess(data) {
		alert(data.message);
		window.location.replace("http://web.engr.oregonstate.edu/~penneys/bluetooth/home.html");
	}

	function updateUsername(data) {
		$("#welcome_message").text(data.message);
	}

	function updateUI(data) {
		if (data.message == "ERROR") {
			alert("No modules with that name");
		}
		var tbody = $("#modules tbody");
		tbody.empty();
		for (var i = 0; i < data.length; i++) {
			var obj = data[i];
			var tr = $("<tr></tr>");
			/* name, functionality, tag, rating just need text */
			tr.append($("<td></td>").text(obj.name));
			/*setup link*/
			$("<td><a id='link' href=''>Link</a></td>").appendTo(tr);
			tr.append($("<td></td>").text(obj.functionality));
			tr.append($("<td></td>").text(obj.tag));
			tr.append($("<td></td>").text(obj.rating));
			tbody.append(tr);
			/*insert link from JSON*/
			var link = $("#link");
			link.attr("href", obj.link);
			link.attr("title", 'Download from Github');
		}
	}
});