$(document).ready(function(){
	$("#module_search").submit(function(e){
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
	
	$("#module_search_tag").submit(function(e){
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
	
	$("#module_add").submit(function(e){
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
	
	$("#module_review").submit(function(e){
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
	
	function errFunction(a,b) {	
		alert("error:"+a+"/"+b);
	}
	
	function addSuccess(data) {
		alert("Module added");
	}
	
	function reviewSuccess(data) {
		alert("Review Submitted");
	}
	
	function updateUI(data) {
		if (data.message == "ERROR") {
			alert("ERROR " + data.code + ", No modules with that name");
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