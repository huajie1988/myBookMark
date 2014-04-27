function createMarkList(type,where,limit){
	$("#marklist").html("");
	var html="";
	var classes="";
	var pagebarhtml="";
		if(where=="" || where==null){
			where=1;
		}
		
		if(limit=="" || limit==null){
			limit=0;
		}


		if(type==1){
			classes='col-12 col-sm-12 col-lg-12';
		}else{
			classes='col-6 col-sm-6 col-lg-4';
		}

          $.ajax({
                 type: "POST",
                 url: "/operate/controller.php",
                 data: {where:where,limit:limit,class:'operate',func:'getmark'},
                 dataType: "json",
                 success: function(data){
                    if(data.status==0){
                    	var ret = data.data['ret'];
                    	var Page = data.data['Page'];
                    	var prev_can=!(Page['pagenow']==1);
                    	var next_can=!(Page['pagenow']==Page['page']);
                    	
                      for (var i = 0; i < ret.length; i++) {
                      		var tags=ret[i]['tags'];
                          var note=ret[i]['note'];
                          var is_like=ret[i]['is_like'];
                          var is_like_class="star_like";
                          var is_private=ret[i]['is_private'];
                          var is_private_class="locked";
                      		if(tags=="null" || tags==null || tags=="")
                      			tags="未分类";
                          if(note=="null" || note==null || note=="")
                            note="&nbsp;";
                          if(is_like=="null" || is_like==null || is_like=="" || is_like==0)
                            is_like_class="star";
                          if(is_private=="null" || is_private==null || is_private=="" || is_private==0)
                            is_private_class="unlock";
					    	html+='<div class="segmentation '+classes+' myBorder"><h3><div class="squaredFour" onclick="showOperate();"><input type="checkbox" value="'+ret[i]['id']+'" id="squaredFour'+ret[i]['id']+'" name="mark_id[]"><label for="squaredFour'+ret[i]['id']+'"></label></div><a  class="listTitle" href="'+ret[i]['url']+'"  target="_blank">'+ret[i]['title']+'</a><span class="fr static">'+getLocalTime(ret[i]['createtime'])+'</span></h3><p style="margin-top:10px;" id="note_'+ret[i]['id']+'">'+note+'</p>';
					        html+='<p class="segmentation"><a class="btn btn-default static_b" href="javascript:void(0)" data-show="false" data-shortnote="" onclick="showAllnote('+ret[i]['id']+',this);" role="button">(っ﹏-) .｡o</a><a href="javascript:void(0);" alt="是否喜欢" onclick="changeLike('+ret[i]['id']+',this);"><span class="'+is_like_class+'">&nbsp;</span></a><a href="javascript:void(0);" alt="是否公共" onclick="changePrivate('+ret[i]['id']+',this);"><span class="'+is_private_class+'">&nbsp;</span></a><span class="fr static"><span onclick="changeTags(this);">'+tags+'</span><input type="text" style="display:none;" class="input_transparent static" value="'+tags+'" onblur="saveTags('+ret[i]['id']+",this"+');"/></span></p></div>';
					    /*<div class="squaredFour"><input type="checkbox" value="None" id="squaredFour" name="check[]"><label for="squaredFour"></label></div>*/
              };
              
              		
              	if(ret.length>0){
              		pagebarhtml+='<div class="fr"><ul class="pagination"><li class="'+(prev_can?"":"disabled")+'"><a href="javascript:void(0);" '+( prev_can ?' onclick="createMarkList(1,'+"'"+Page['where']+"',"+((parseInt(Page['pagenow'])-2)*parseInt(Page['pagesize']))+');"':"")+'>&laquo;</a></li>';
              		var pagehtml="";
              		for (var j = 0; j< Page['page'];j++) {
              			var pageNo=(j+1);
              			var now_can=true;
              			if(pageNo>10 && parseInt(Page['pagenow'])<10)
              				break;
              			var classPageNow="";
              			if(pageNo==parseInt(Page['pagenow'])){
              				classPageNow="active";
              				now_can=false;
              			}
              			
              			if(pageNo%10==0 && parseInt(Page['pagenow'])>=10){
              				pagehtml="";              				
              			}else{
              				
              			}
              			pagehtml+='<li class="'+classPageNow+'" '+( now_can ?' onclick="createMarkList(1,'+"'"+Page['where']+"',"+((pageNo-1)*parseInt(Page['pagesize']))+');"':"")+'><a href="javascript:void(0);">'+pageNo+'<span class="sr-only">(current)</span></a></li>'
              			          			
              		}
              		pagebarhtml+=pagehtml
              		pagebarhtml+='<li class="'+(next_can?"":"disabled")+'"><a href="javascript:void(0);" '+(next_can ? ' onclick="createMarkList(1,'+"'"+Page['where']+"',"+((parseInt(Page['pagenow']))*parseInt(Page['pagesize']))+');"':"")+'>»</a></li></ul></div>';
					html+=pagebarhtml;
					}
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
            area : ['550px' , '440px'],
            offset : ['100px','']
            });
      }

  function logout(){
          delCookie("username");
          delCookie("nologin_id");
          delCookie("status");
          delCookie("user_id");
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
    var id="";
    var where = "";
       switch(type)
        {
        case "favorite":
          // 执行代码块 1
          where="favorites_id="+val;
          id="#fav_id"+val;
          break;
        case "tags":
          where="tag_id="+val;
          break;
        case "like":
          where="is_like=1";
          id="#is_like";
          break;
        case "file":
          where='FROM_UNIXTIME(createtime, "%Y年%m月")=\''+val+"'";
          id="#file";
          val=-1;
          break;
        default:
          // n 与 case 1 和 case 2 不同时执行的代码
        }
        $("#marklist").html("");
        if(val!=-1){
          $(id).siblings().removeClass("active");
          $("#home").siblings().removeClass("active");
          $("#home").addClass("active");  
        }else{
          $("#sidebar").find("a").removeClass("active");          
        }

        $(id).addClass("active");
        createMarkList(1,where,0);
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
      // if(type=="All"){
      //     e.checked=true;
      //     $(o).attr("data-type","Anti");
      //     $(o).html("反选");
      // }else if(type=="Anti"){
      //      e.checked=!e.checked;
      //      if($("input[type=checkbox]:checked").length<=0){
      //         $("#operatePanel").hide(500);
      //         $(o).html("全选");
      //         $(o).attr("data-type","All");
      //      }else{
      //         $(o).attr("data-type","unAll");
      //         $(o).html("全不选");
      //      }
      // }else{
      //       e.checked=false;
      //       $(o).attr("data-type","All");
      //       $("#operatePanel").hide(500);
      //       $(o).html("全选");
      // }
      if(type=="All"){
          e.checked=true;
          $(o).attr("data-type","Anti");
          $(o).html("反选");
      }else{
           e.checked=!e.checked;
           if($("input[type=checkbox]:checked").length<=0){
              $("#operatePanel").hide(500);
              $(o).html("全选");
              $(o).attr("data-type","All");
           }
      }
     }
}

function showOperate () {
   var checkboxs=$("input[type=checkbox]:checked");
   if(checkboxs.length<=0){
        $("#operatePanel").hide(500);
        $("#operatePanel").children().eq(0).html("全选");
        $("#operatePanel").children().eq(0).attr("data-type","All");
    }
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
//              var color="#"+timeStr.substring(timeStr.length-2,timeStr.length)+(parseInt(data.data[i]['id'])+15).toString(16).substr(0, 2)+Math.round(16+Math.random()*255).toString(16).substr(0, 2);
                var color="#"+(Math.floor(Math.random()*255).toString(16))+(Math.floor(Math.random()*255).toString(16))+(Math.floor(Math.random()*255).toString(16));
                var fontSize=data.data[i]['weights'];
                fontSize=Math.round(100+fontSize*10)+"";
                fontSize=parseInt(fontSize.substr(0, 2))/12+0.8;
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


function saveTags (url_id,o) {
      $.ajax({
         type: "POST",
         url: "/operate/controller.php",
         data: {class:'operate',func:'saveTags',url_id:url_id,tags:$(o).val()},
         dataType: "json",
         success: function(data){
            if(data.status==0){
             layer.msg(data.msg , 3, 1);
             $(o).prev().html($(o).val());
             $(o).prev().show();
             $(o).hide();
            }else{
              layer.alert(data.msg,5,!1);
            }
        }
     });
}
function changeTags (o) {
     $(o).next().show().focus();
     $(o).hide();
   }

function changeLike (id,o) {
    $.ajax({
         type: "POST",
         url: "/operate/controller.php",
         data: {class:'operate',func:'changeLike',url_id:id},
         dataType: "json",
         success: function(data){
            if(data.status==0){
             layer.msg(data.msg , 3, 1);
             if(data.data['is_like']==1)
                $(o).children().attr("class","star_like");
             else
                $(o).children().attr("class","star");
            }else{
              layer.alert(data.msg,5,!1);
            }
        }
     });
}

function changePrivate(id,o) {
    $.ajax({
         type: "POST",
         url: "/operate/controller.php",
         data: {class:'operate',func:'changePrivate',url_id:id},
         dataType: "json",
         success: function(data){
            if(data.status==0){
             layer.msg(data.msg , 3, 1);
             if(data.data['is_private']==1)
                $(o).children().attr("class","locked");
             else
                $(o).children().attr("class","unlock");
            }else{
              layer.alert(data.msg,5,!1);
            }
        }
     });
}

function getMarkByDate () {
    var html="";
    $.ajax({
         type: "POST",
         url: "/operate/controller.php",
         data: {class:'operate',func:'getMarkByDate'},
         dataType: "json",
         success: function(data){
            if(data.status==0){
              $("#marklist").html("");
              html+="<div class='segmentation col-12 col-sm-12 col-lg-12 myBorder'>";
              for (var i = 0; i < data.data.length; i++) {
                html+="<a href='javascript:void(0);' onclick=searchMark('file','"+data.data[i]['month_short']+"');><div class='col-3 col-sm-3 col-lg-3 listTitle'>"+data.data[i]['month']+"&nbsp;["+data.data[i]['markNum']+"]</div></a>";
                if(i%3==0 && i!=0){
                  html+="</div><div class='segmentation col-12 col-sm-12 col-lg-12 myBorder'>";
                }
              }
              html+="</div>";
              $("#marklist").html(html);
              $("#sidebar").find("a").removeClass("active");
              $("#file").addClass("active");
            }else{
              layer.alert(data.msg,5,!1);
            }
        }
     });
}

function delMark () {
    var dataArgs=$("#marklist  input[type=checkbox]:checked").serialize();
    dataArgs+="&class=operate&func=delMark";

    $.layer({
        shade : [0], //不显示遮罩
        area : ['auto','auto'],
        dialog : {
                msg:'确定要删除该书签吗？删除后不可恢复',
                btns : 2, 
                type : 0,
                btn : ['确定','取消'],
                yes : function(){
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
                },
        }
    });
}



function createFavoriteChangeList(){
  var html="";
  var classes="";
  var where=1;

          $.ajax({
                 type: "POST",
                 url: "/operate/controller.php",
                 data: {where:where,class:'operate',func:'getFavorite'},
                 dataType: "json",
                 success: function(data){
			            if(data.status==0){
			              $("#marklist").html("");
  			              html+="<div class='segmentation col-12 col-sm-12 col-lg-12 myBorder'>";
  			              var br=1;
  			              for (var i = 0; i < data.data.length; i++) {
  			                html+="<div class='col-3 col-sm-3 col-lg-3 listTitle'><a href='javascript:void(0);' onclick=searchMark('favorite',"+data.data[i]['id']+");>"+data.data[i]['name']+"&nbsp;[";
  			                html+=+data.data[i]['favNum']+"]</a><br><span class='fl'><a href='javascript:void(0);' data-show='1' class='is_show' onclick='changeFavorite("+data.data[i]['id']+",this)'><img class='edit' src='../images/edit.png' /></a><a href='javascript:void(0);' onclick='deleteFavorite("+data.data[i]['id']+",this)'><img class='delete' src='../images/delete.png' /></a></span></div>";
  			                if(br%4==0){
  			                  html+="</div><div class='segmentation col-12 col-sm-12 col-lg-12 myBorder'>";
  			                }
  			                br++;
  			              }
  			              html+="</div>";
  			              $("#marklist").html(html);
  			              $("#sidebar").find("a").removeClass("active");
              			  $("#home").addClass("active");
			            }else{
			              layer.alert(data.msg,5,!1);
			            }
                }
             });  
}


function changeFavorite(id,o){
	var is_show = parseInt($(o).attr("data-show"));
	if(is_show){
		$("#favoriteChangeSaveDiv").remove();
		var favoriteName=$(o).parent().prev().prev().text().split("[");
		favoriteName=favoriteName[0];
		var html='<div id="favoriteChangeSaveDiv"><div class="col-lg-12 segmentation" ><input type="text" class="form-control" value=\''+favoriteName+'\'></div>';
		html+='<div class="col-lg-12 segmentation" ><button class="btn btn-primary btn-lg btn-block" type="button" onclick="favoriteChangeSave('+id+');">保存</button></div></div>';
		$(o).parent().parent().parent().append(html);
		$(".is_show").attr("data-show","1");
		$(o).attr("data-show","0");
	}else{
		$("#favoriteChangeSaveDiv").remove();
		$(".is_show").attr("data-show","1");
	}
	
}



function favoriteChangeSave(favorite_id){
		  var favoriteName= $("#favoriteChangeSaveDiv").find("input[type=text]").val();
          $.ajax({
                 type: "POST",
                 url: "/operate/controller.php",
                 data: {favorite_id:favorite_id,favoriteName:favoriteName,class:'operate',func:'favoriteChangeSave'},
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

function deleteFavorite(favorite_id,o){
	  $.layer({
        shade : [0], //不显示遮罩
        area : ['auto','auto'],
        dialog : {
                msg:'确定要删除该收藏夹吗？删除后不可恢复',
                btns : 2, 
                type : 0,
                btn : ['确定','取消'],
                yes : function(){
                      $.ajax({
                         type: "POST",
                         url: "/operate/controller.php",
                         data: {favorite_id:favorite_id,class:'operate',func:'deleteFavorite'},
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
                },
        }
    });
}


function createWeather(){
	$.ajax({
		 type: "POST",
		 url: "/operate/controller.php",
		 data: {class:'weather',func:'run'},
		 dataType: "json",
		 success: function(data){
		    if(data.status==0){
		    	var myDate = new Date();
		    	var ret=data.data;
		    	 for(var key in ret){
		    	 	if(key=="city" || key=="nowTemp")
		    	 		continue;
		    	 	var id="#"+key;
		    	 	var content=$(id).text()+":";
		    	 	content+=ret[key];
		    	 	$(id).text(content);
		    	 }
		    	 $("#city").text(ret['city']);
		    	 $("#date").text(myDate.toLocaleDateString());
		    	 var html="";
		    	 var imgsrc="";
		    	 var a="1";
		    	 if(myDate.getHours()>=6 && myDate.getHours()<=18){
		    	 	imgsrc=ret['dayImg'];
		    	 }else{
		    	 	imgsrc=ret['nightImg'];
		    	 }
  		    	 html+="<div><img src='"+imgsrc+"' /><span style='float:right;margin-top:1px;margin-left:10px;'>"+ret['nowTemp']+"℃</span></div>";
		    	 $("#nowTemp").html(html);    
		    }else{
		          layer.alert(data.msg,5,!1);
		        }
		    }
	});	
}

function exportBookMark(){
	var dataArgs=$("#marklist  input[type=checkbox]:checked").serialize();
    dataArgs+="&class=operate&func=exportBookMark";
    window.open('/operate/controller.php?'+dataArgs);
}

function exportBookMarkAll(){
    window.open('/operate/controller.php?class=operate&func=exportBookMark&all=1&mark_id[]=0');
}

function showAllnote(url_id,o){
   var id="#note_"+url_id;
   var is_show=$(o).attr("data-show");
   if(is_show=="false")
	   $.ajax({
	         type: "POST",
	         url: "/operate/controller.php",
	         data: {url_id:url_id,class:'operate',func:'showAllnote'},
	         dataType: "json",
	         success: function(data){
		            if(data.status==0){
		            	if(data.data['note']!=""){
			              var shortnote = $(id).text();
			              var fun="changeNote("+url_id+",this);";
			              $(o).attr("data-shortnote",shortnote);
		            	  $(id).text(data.data['note']);
		            	  $(id).attr("onclick",fun);
  		            	  $(o).attr("data-show","true");
		            	  $(o).text("Σ( ° △ °)");
		            	}else{
//		            	  var shortnote = $(id).text();
			              var fun="changeNote("+url_id+",this);";
//			              $(o).attr("data-shortnote",shortnote);
		            	  $(id).text("你好像很懒，什么都没留下。。。");
		            	  $(id).attr("onclick",fun);
  		            	  $(o).attr("data-show","true");
		            	  $(o).text("Σ( ° △ °)");
		            	}

	//    			  setTimeout("location.href='/ucenter.html';",2000); 
		            }else{
		              layer.alert(data.msg,5,!1);
		            }
	        }
	     });
	else{
		var note=$(o).attr("data-shortnote");
		if(note=="")
			note="　　";//两个全角空格会认为是字符，可以用来输出空行
		$(id).text(note);
		$(o).attr("data-show","false");
		$(o).text("(っ﹏-) .｡o");
		$(id).removeAttr("onclick");
		changeNoteSave(url_id);
	}
}


function changeNote(url_id,o){
	var note=$(o).text();
	var html='<div id="chmarkNote" class="col-lg-12 segmentation"><textarea class="form-control chmarkNote" name="chmarkNote" >'+note+'</textarea></div>';
	$(o).hide();
	$(o).after(html);
	$("#chmarkNote").find("textarea").css("height","200px");
}

function changeNoteSave(url_id){
	var id="#note_"+url_id;
	if($("#chmarkNote").length>0){
//		此时只能取val，而不能用text，否则新增加的内容无法传递 2014-04-27 12:30 Huajie
		var note = $("#chmarkNote").find("textarea").val();
		$.ajax({
	         type: "POST",
	         url: "/operate/controller.php",
	         data: {url_id:url_id,note:note,class:'operate',func:'changeNoteSave'},
	         dataType: "json",
	         success: function(data){
		            if(data.status==0){
		            	layer.msg(data.msg , 3, 1);
						$("#chmarkNote").remove();
						
						$(id).text(note==""?'　　':note.substr(0,20));
						$(id).show();
		            }else{
		              layer.alert(data.msg,5,!1);
		            }
	        }
	     });	
	}
}

function showUserInfo(){
	var ret="";
	$.ajax({
         type: "POST",
         async:false,
         url: "/operate/controller.php",
         data: {class:'operate',func:'getUserInfo'},
         dataType: "json",
         success: function(data){
	            if(data.status==0){
	            	ret=data.data;
	            }else{
	              layer.alert(data.msg,5,!1);
	            }
        }
     });
	$("#marklist").html("");
	var html="<form action='' id=user_info_form>";
	html+='<div class="segmentation col-12 col-sm-12 col-lg-12 myBorder "><div class="listTitle col-2 col-sm-2 col-lg-2">用户名</div><div class="col-4 col-sm-4 col-lg-4"><input size="16" class="form-control" name="user_name" type="text" value="'+ret['username']+'"></div><div class="listTitle col-2 col-sm-2 col-lg-2">出生年月</div><div class="col-4 col-sm-4 col-lg-4 date form_datetime"><input size="16" class="form-control" type="text" name="birthday" value="'+(ret['birthday']==null?'':ret['birthday'])+'" readonly><span class="add-on"><i class="icon-th"></i></span></div></div>';
	html+='<div class="segmentation col-12 col-sm-12 col-lg-12 "><div class="listTitle col-2 col-sm-2 col-lg-2">性别</div><div class="col-4 col-sm-4 col-lg-4"><input name="sex" type="radio" value="1"><span class="font_gray fontlarge b segmentation_r">男</span><input name="sex" type="radio" value="2"><span class="font_gray fontlarge b segmentation_r">女</span><input name="sex" type="radio" value="3"><span class="font_gray fontlarge b segmentation_r">秀吉</span></div></div>';
	html+='<div class="segmentation col-12 col-sm-12 col-lg-12 myBorder "><div class="listTitle col-2 col-sm-2 col-lg-2">注册邮箱</div><div class="col-4 col-sm-4 col-lg-4"><input size="16" class="form-control" name="reg_email" readonly type="text" value="'+ret['email']+'"></div><div class="listTitle col-2 col-sm-2 col-lg-2">密保邮箱</div><div class="col-4 col-sm-4 col-lg-4"><input size="16" class="form-control" name="bind_email" type="text" value="'+(ret['bind_email']==null?'':ret['bind_email'])+'"></div></div>';
	html+='<div class="segmentation col-12 col-sm-12 col-lg-12 myBorder "><div class="listTitle col-2 col-sm-2 col-lg-2">密码</div><div class="col-4 col-sm-4 col-lg-4"><input size="16" class="form-control" readonly type="text" value="据说这行是密码哎！你相信吗？"><!--你居然不相信！这行真的是密码呀！密码是mosquito 什么？你问为什么是蚊子？嗯，这是一个很有趣的问题， 因为她有一种神奇的力量啊>_<--></div><div class="listTitle col-2 col-sm-2 col-lg-2"><button class="btn btn-primary btn-block" type="button" onclick="showChangePassword();">修改密码</button></div></div>';
	html+='<div id="changePassword" style="display:none;"><div class="segmentation col-12 col-sm-12 col-lg-12  "><div class="listTitle col-2 col-sm-2 col-lg-2">原密码</div><div class="col-4 col-sm-4 col-lg-4"><input size="16" class="form-control"  type="password" name="password_prev" value=""></div></div>';
	html+='<div class="segmentation col-12 col-sm-12 col-lg-12  "><div class="listTitle col-2 col-sm-2 col-lg-2">现密码</div><div class="col-4 col-sm-4 col-lg-4"><input size="16" class="form-control"  type="password" name="password_new" value=""></div></div>';
	html+='<div class="segmentation col-12 col-sm-12 col-lg-12  "><div class="listTitle col-2 col-sm-2 col-lg-2">确认密码</div><div class="col-4 col-sm-4 col-lg-4"><input size="16" class="form-control"  type="password" name="password_check" value=""></div></div></div>';
	html+='<div class="segmentation col-12 col-sm-12 col-lg-12  "><div class="listTitle col-2 col-sm-2 col-lg-2">密保问题</div><div class="col-4 col-sm-4 col-lg-4"><input size="16" class="form-control"  type="text" name="find_password_q" value="'+(ret['find_pwd_q']==null?'':ret['find_pwd_q'])+'"></div></div>';
	html+='<div class="segmentation col-12 col-sm-12 col-lg-12  "><div class="listTitle col-2 col-sm-2 col-lg-2">答案</div><div class="col-4 col-sm-4 col-lg-4"><input size="16" class="form-control"  type="text" name="find_password_a" value="'+(ret['find_pwd_a']==null?'':ret['find_pwd_a'])+'"></div></div>';
	html+='<div class="segmentation col-12 col-sm-12 col-lg-12  "><div class="listTitle col-6 col-sm-6 col-lg-6"><button class="btn btn-primary btn-block" type="button" onclick="saveUserInfo();">保存</button></div></div>';
	html+="</form>";
	$("#marklist").html(html);
	
	if(ret['sex']==null){
		$("input[type=radio]").eq(0).attr("checked","ckecked");
	}else{
		var sex=parseInt(ret['sex'])-1;
		$("input[type=radio]").eq(sex).attr("checked","ckecked");		
	}
	$(".form_datetime").datetimepicker({
                language:  'zh-CN',
		        weekStart: 1,
		        todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				minView: 2,
				forceParse: 0,
				format: 'yyyy-mm-dd'
    });
}


function showChangePassword(){
	$("#changePassword").toggle();
}

function saveUserInfo(){
	var dataArgs=$("#user_info_form").serialize();
    dataArgs+="&class=operate&func=saveUserInfo";
	$.ajax({
         type: "POST",
         async:false,
         url: "/operate/controller.php",
         data: dataArgs,
         dataType: "json",
         success: function(data){
	            if(data.status==0){
	            	layer.msg(data.msg , 3, 1);
              		logout(); 
	            }else{
	              layer.alert(data.msg,5,!1);
	            }
        }
     });
}
