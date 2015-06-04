

function eleteSubcheck(i,j)
{
	//alert("ksdjfh");
	var id = i+'sub'+j;
	var tid = _('subcheckdelid'+j).value;//for task id checking cheklist belongs to the task
	alert(tid);
	var ajax = ajaxObj("POST", "http://localhost:8000/user/task/"+tid+"/postsubcheckdelete");
	ajax.onreadystatechange = function() {
		console.log(ajax.responseText);
		if(ajaxReturn(ajax) == true) {
			var datArray = ajax.responseText.trim();
			alert(datArray);
		}
		else
		{
			alert(tid+"klkl");
		}
	}
	ajax.send("checkid="+i+"&subcheckid="+j+"&taskid="+tid);
}


