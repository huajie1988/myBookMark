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
                          var note=data.data[i]['note'];
                      		if(tags=="null" || tags==null || tags=="")
                      			tags="未分类";
                          if(note=="null" || note==null || note=="")
                            note="&nbsp;";
					    	html+='<div class="segmentation '+classes+'"><h3><a href="'+data.data[i]['url']+'"  target="_blank">'+data.data[i]['title']+'</a><span class="fr static">'+getLocalTime(data.data[i]['createtime'])+'</span></h3><p style="margin-top:10px;">'+note+'</p>';
					        html+='<p class="segmentation"><a class="btn btn-default" href="javascript:void(0)" role="button">查看详情»</a><span class="fr static">'+tags+'</span></p></div>';
					    /*<div class="squaredFour"><input type="checkbox" value="None" id="squaredFour" name="check[]"><label for="squaredFour"></label></div>*/
              };
					$("#marklist").append(html);
                    }else{
                      alert(data.msg);
                    }
                }
             });	
}

function createFavoriteList(where){
  var html="";
  var classes="";
    if(where=="" || where==null){
      where=1;
    }

          $.ajax({
                 type: "POST",
                 url: "/operate/controller.php",
                 data: {where:where,class:'operate',func:'getFavorite'},
                 dataType: "json",
                 success: function(data){
                    if(data.status==0){
                      for (var i = 0; i < data.data.length; i++) {
                          var name=data.data[i]['name'];
                          if(name=="null" || name==null || name=="")
                              name="未分类";

                html+='<a href="javascript:void(0);" class="list-group-item" id="fav_id'+data.data[i]['id']+'" onclick="searchMark(\'favorite\','+data.data[i]['id']+')">'+name+'<span class="badge pull-right">'+data.data[i]['favNum']+'</span></a>';
              };
                $("#favorite").append(html);
                    }else{
                      alert(data.msg);
                    }
                }
             });  
}

function getLocalTime(nS) {     
   return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');     
}


  function login()
      {
          $.layer({
            type : 2,
            title : '登录',
            iframe : {src : './login.html'},
            area : ['550px' , '330px'],
            offset : ['100px','']
            });
      }

  function logout(){
          delCookie("username");
          delCookie("nologin_id");
          delCookie("status");
          // location.reload();
          window.location.href='/index.html';
      }

  function getCookie(name)
      {
        var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
        if(arr=document.cookie.match(reg)) return unescape(arr[2]);
        else return null;
      }
  function delCookie(name)//删除cookie
      {
          var exp = new Date();
          exp.setTime(exp.getTime() - 1);
          var cval=getCookie(name);
          if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
      }

  function searchMark (type,val) {
    var id="#fav_id"+val;
    $(id).siblings().removeClass("active");
    $(id).addClass("active");
    var where = "";
       switch(type)
        {
        case "favorite":
          // 执行代码块 1
          where="favorites_id="+val;
          break;
        case "tags":
          // 执行代码块 2
          break;
        default:
          // n 与 case 1 和 case 2 不同时执行的代码
        }
        $("#marklist").html("");
        createMarkList(1,where);
     }




     function createFavorite (o) {
          var flag = $(o).attr("data-value");
          if(flag=="true"){
              $("#favoriteName").parent().slideDown(500);
              $(o).attr("data-value","false");
          }
          else{
            $(o).attr("data-value","true");
            $("#favoriteName").parent().slideUp(500);
          }

        }
    function saveFavorite (o) {
         var html="";
         var favoriteName = $(o).parent().find("input").val();
         if(!favoriteName){
            layer.alert("请输入收藏夹名称",5,!1);
            return false;
         }


        $.ajax({
                 type: "POST",
                 url: "/operate/controller.php",
                 data: {favoriteName:favoriteName,class:'operate',func:'saveFavorite'},
                 dataType: "json",
                 success: function(data){
                    if(data.status==0){
                      $(o).parent().slideUp(500);
                      html+='<a href="javascript:void(0);" class="list-group-item" id="fav_id'+data.data['favorites_id']+'" onclick="searchMark(\'favorite\','+data.data['favorites_id']+')">'+data.data["name"]+'<span class="badge pull-right">0</span></a>';
                      $("#favorite").append(html);
                      $("#addFavorite").attr("data-value","true");
                    }else{
                      layer.alert(data.msg,5,!1);
                    }
                }
             });


       }   