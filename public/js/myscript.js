

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

	$('.filedelete').click(function(){
		
		var fid = $(event.target).attr('id');
		var tid = $(event.target).parent().attr('myattr');
		var poststr="id="+fid+"&tid="+tid;
		//alert(sid);
		$.ajax({
                type: 'post',
                url: 'http://localhost:8000/user/task/'+tid+'/postfiledelete',
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
                        	$("#file"+fid).remove();
                        }
                        else if(data == "failed"){
                        	alert("File doesnot belong to you");
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
