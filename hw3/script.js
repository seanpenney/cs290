$(document).ready(function(){
	$("form").submit(function(e){
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
	
	function errFunction(a,b) {	
		alert("error:"+a+"/"+b);
	}
	
	function updateUI(data) {
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
		}
	}
});