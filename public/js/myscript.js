

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


$(document).ready(function(){
	$('.finish-subtask').click(function(){
		
		var sid = $(event.target).parent().parent().attr('id');
		var mid = $("#mtaskid").val();
		var poststr="id="+sid;
		//alert(sid);
		$.ajax({
                type: 'post',
                url: 'http://localhost:8000/test/'+mid,
                data: poststr,
                beforeSend: function() { 
                    //$("#aa").hide(); 
                },
                success: function(data) {
                    if(data.success == false)
                    {
                        alert("something wrong");
                    } 
                    else 
                    {
                        if(data == "success"){
                        	var html = "<span>Finished</span>"
                        	$("#finish"+sid).html(html);
                        }
                        else if(data == "failed"){
                        	alert("Subtask doesnot belong to you");
                        }
                        else{
                        	alert(data);
                        }
                    }
                },
                error: function(xhr, textStatus, thrownError) {
                    alert('Something went to wrong.Please Try again later...');
                }
         });
	});
});
