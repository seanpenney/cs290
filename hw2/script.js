function loadXMLDoc(url)
{
	var xmlhttp;
	var txt, x, xx, i;

	xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				txt="<table id=\"table1\"><tr><th>Favorite Courses</th><th>Instructor</th></tr>";
				x=xmlhttp.responseXML.documentElement.getElementsByTagName("COURSE");
				for (i=0; i < x.length; i++)
				{
					txt=txt + "<tr>";
					xx=x[i].getElementsByTagName("TITLE");
					txt = txt + "<td>" + xx[0].firstChild.nodeValue + "</td>";
					
					xx = x[i].getElementsByTagName("INSTRUCTOR");
					txt = txt + "<td>" + xx[0].firstChild.nodeValue + "</td";
					txt=txt + "</tr>";
				}
				txt=txt + "</table>";
				document.getElementById('courseInfo').innerHTML=txt;
			}
	}
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
}
