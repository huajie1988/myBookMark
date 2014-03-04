function createMarkList(type,where){
	var html="";
	var classes="";
		if(where=="" || where==null){
			where=1;
		}


		if(type==1){
			classes='col-12 col-sm-12 col-lg-12';
		}else{
			classes='col-6 col-sm-6 col-lg-4';
		}

          $.ajax({
                 type: "POST",
                 url: "/operate/controller.php",
                 data: {where:where,class:'operate',func:'getmark'},
                 dataType: "json",
                 success: function(data){
                    if(data.status==0){
                      for (var i = 0; i < data.data.length; i++) {
                      		var tags=data.data[i]['tags'];
                      		if(tags=="null" || tags==null || tags=="")
                      			tags="未分类";
					    	html+='<div class="segmentation '+classes+'"><h3><a href="'+data.data[i]['url']+'"  target="_blank">'+data.data[i]['title']+'</a><span class="fr static">'+getLocalTime(data.data[i]['createtime'])+'</span></h3><p style="margin-top:10px;">'+data.data[i]['note']+'<span class="fr static">'+tags+'</span></p>';
					        html+='<p class="segmentation"><a class="btn btn-default" href="javascript:void(0)" role="button">查看详情»</a></p></div>';
					    };
					$("#marklist").append(html);
                    }else{
                      alert(data.msg);
                    }
                }
             });	
}


function getLocalTime(nS) {     
   return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');     
}   