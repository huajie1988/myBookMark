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
					    	html+='<div class="segmentation '+classes+' myBorder"><h3><div class="squaredFour" onclick="showOperate();"><input type="checkbox" value="'+data.data[i]['id']+'" id="squaredFour'+data.data[i]['id']+'" name="mark_id[]"><label for="squaredFour'+data.data[i]['id']+'"></label></div><a  class="listTitle" href="'+data.data[i]['url']+'"  target="_blank">'+data.data[i]['title']+'</a><span class="fr static">'+getLocalTime(data.data[i]['createtime'])+'</span></h3><p style="margin-top:10px;">'+note+'</p>';
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
  var html_fav1="";
  var html_fav2="";
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

                html_fav1+='<a href="javascript:void(0);" class="list-group-item" id="fav_id'+data.data[i]['id']+'" onclick="searchMark(\'favorite\','+data.data[i]['id']+')">'+name+'<span class="badge pull-right">'+data.data[i]['favNum']+'</span></a>';
                html_fav2+='<a href="javascript:void(0);" class="list-group-item" id="favlist_id'+data.data[i]['id']+'" onclick="move2Favorite('+data.data[i]['id']+')">'+name+'<span class="badge pull-right">'+data.data[i]['favNum']+'</span></a>';
              };
                $("#favorite").append(html_fav1);
                $("#moveFavoriteList").append(html_fav2);
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
          where="tag_id="+val;
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
         var html2=""
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
                      html2+='<a href="javascript:void(0);" class="list-group-item" id="favlist_id'+data.data['favorites_id']+'" onclick="move2Favorite('+data.data['favorites_id']+')">'+data.data["name"]+'<span class="badge pull-right">0</span></a>';
                      $("#moveFavoriteList").append(html2);
                      $("#addFavorite").attr("data-value","true");
                    }else{
                      layer.alert(data.msg,5,!1);
                    }
                }
             });


       }


function selectAll (o) {
    var type=$(o).attr("data-type");
    var checkboxs=document.getElementsByName("mark_id[]");
    for (var i=0;i<checkboxs.length;i++) {
      var e=checkboxs[i];
      if(type=="All"){
          e.checked=true;
          $(o).attr("data-type","Anti");
          $(o).html("反选");
      }else if(type=="Anti"){
           e.checked=!e.checked;
           if($("input[type=checkbox]:checked").length<=0){
              $("#operatePanel").hide(500);
              $(o).html("全选");
              $(o).attr("data-type","All");
           }else{
              $(o).attr("data-type","unAll");
              $(o).html("全不选");
           }
      }else{
            e.checked=false;
            $(o).attr("data-type","All");
            $("#operatePanel").hide(500);
            $(o).html("全选");
      }
     }
}

function showOperate () {
   var checkboxs=$("input[type=checkbox]:checked");
   if(checkboxs.length<=0)
    $("#operatePanel").hide(500);
  else
    $("#operatePanel").show(500);
}

function showFavoritePanel () {
      var is_show = $("#selectfavdiv").attr("data-show");
      if(is_show=="false"){
        $("#selectfavdiv").slideDown(500);
        $("#selectfavdiv").attr("data-show","true");        
      }else{
        $("#selectfavdiv").slideUp(500);
        $("#selectfavdiv").attr("data-show","false");         
      }  
   }

function move2Favorite (favorite_id) {
    var dataArgs=$("#marklist  input[type=checkbox]:checked").serialize();
    dataArgs+="&favorite_id="+favorite_id+"&class=operate&func=move2Favorite";
    $.ajax({
         type: "POST",
         url: "/operate/controller.php",
         data: dataArgs,
         dataType: "json",
         success: function(data){
            if(data.status==0){
              layer.msg(data.msg , 3, 1);
              setTimeout("location.href='/ucenter.html';",2000); 
            }else{
              layer.alert(data.msg,5,!1);
            }
        }
     });
}

function createMyTagsCloud () {
  var html="";
      $.ajax({
         type: "POST",
         url: "/operate/controller.php",
         data: {class:'operate',func:'createMyTagsCloud'},
         dataType: "json",
         success: function(data){
            if(data.status==0){
              for (var i = 0; i < data.data.length; i++){
                var myDate = new Date();
                var timeStr = myDate.getFullYear()+myDate.getMonth()+myDate.getDate().toString(16);
                var color="#"+timeStr.substring(timeStr.length-2,timeStr.length)+(parseInt(data.data[i]['id'])+15).toString(16).substr(0, 2)+Math.round(16+Math.random()*255).toString(16).substr(0, 2);
                var fontSize=data.data[i]['weights'];
                fontSize=Math.round(100+fontSize*10)+"";
                fontSize=parseInt(fontSize.substr(0, 2))/10+0.8;
                // if(parseInt(fontSize)<50)
                //     fontSize=parseInt(fontSize)+20;
                html+='<a href=javascript:void(0); onclick="searchMark(\'tags\','+data.data[i]['id']+');" ><span style="color:'+color+';font-weight:bold;margin-left:10px;font-size:'+fontSize+'em;">'+data.data[i]['name']+'</span></a>';
              }
              $("#myTagsCloud").html(html);
            }else{
              layer.alert(data.msg,5,!1);
            }
        }
     });
}   