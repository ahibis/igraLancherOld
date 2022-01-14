cityData=undefined
$.fn.hasAttr = function(name) {
   return this.attr(name) !== undefined;
};
function post(Url,data,func){$.post('/'+Url,data,func);}
function api(method,data,func){$.post('./api/'+method+'.php',data,func);}
function urlApi(method){return './api/'+method+'.php';}
function sendFiles(element,Url,func){
   files = element.files;
   var data = new FormData();
   $.each( files, function( key, value ){
      data.append( key, value );
  });
  data.append( 'my_file_upload', 1 );
  $.ajax({
      url         :  Url,
      type        : 'POST', // важно!
      data        : data,
      cache       : false,
      //dataType    : 'json',
      processData : false,
      contentType : false, 
      success     : function( answer, status, jqXHR ){// ОК - файлы загружены
      	//console.log(answer)
      	func(JSON.parse(answer))
      },
      error: function( jqXHR, status, errorThrown ){// функция ошибки ответа сервера
        console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
      }
    });
}
function sendFilesPost(element,Url,DATA,func){
   files = element.files;
   var data = new FormData();
   $.each( files, function( key, value ){
      data.append( key, value );
  });
  data.append( 'my_file_upload', 1 );
  for (key in DATA){
     data.append(key,DATA[key])
  }
  $.ajax({
      url         :  Url,
      type        : 'POST', // важно!
      data        : data,
      cache       : false,
      //dataType    : 'json',
      processData : false,
      contentType : false, 
      success     : function( answer, status, jqXHR ){// ОК - файлы загружены
      	console.log(answer)
      	func(JSON.parse(answer))
      },
      error: function( jqXHR, status, errorThrown ){// функция ошибки ответа сервера
        console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
      }
    });
}
function showError(text){
	$("#error").html('<button class="btn btn-danger">'+text+'</button>')
}
function delError(){
	$("#error").html("")
}
function changefield(field,value){
	DATA={}
	DATA[field]=value;
	api("changeData",DATA,function(data){
		console.log(data)
	})
}
function changefields(DATA){
	api("changeData",DATA,function(data){
		console.log(data)
	})
}
class Accaunt{
	reload(){
		document.location.href=document.location.href;
	}
	leave(){
		api("leave",{},function (data){
			accaunt.reload()
		})
	}
	goTo(where){
		api("goTo",{type:where},function (data){
			accaunt.reload()
		})
	}
	registration(){
		delError()
		var data={}
		if (cityData!=undefined){
			data=cityData;
		}
		$('#registration').find("input").each(function(){
			if ($(this).val()==""){
				$(this).css('border',' 1px solid #dc3545');
			}else{
				data[$(this).attr("id")]=$(this).val();
				$(this).css('border',' 1px solid #ced4da');
			}
		})
		$('#registration').find("select").each(function(){
			if ($(this).val()==0){
				$(this).css('border',' 1px solid #dc3545');
			}else{
				data[$(this).attr("id")]=$(this).val();
				$(this).css('border',' 1px solid #ced4da');
			}
		})
		api("registration",data,function (data){
			console.log(data);
			var json=JSON.parse(data)
			if (json.status=="success"){
				accaunt.reload()
			}else{
				showError(json.error)
			}
		})
	}
	login(){
		delError()
		var data={}
		$('#login').find("input").each(function(){
			if ($(this).val()==""){
				$(this).css('border',' 1px solid #dc3545');
			}else{
				data[$(this).attr("id")]=$(this).val();
				$(this).css('border',' 1px solid #ced4da');
			}
		})
		api("login",data,function (data){
			console.log(data);
			var json=JSON.parse(data)
			if (json.status=="success"){
				accaunt.reload()
			}else{
				showError(json.error)
			}
		})
	}
}
accaunt=new Accaunt()
class USER{
	users={}
	load(user_id,func){
		if (user_id in this.users){
			func(this.users[user_id])
		}else{
			api('getUser',{user_id:user_id},function(data){
				//console.log(data)
				var user=JSON.parse(data).user;
				User.users[user.id]=user;
				func(user)
			})
		}
	}
	get(user_id){
		//console.log(this)
		if (user_id in this.users){
			return this.users[user_id]
		}
	}
}
User=new USER()
function getFullTime(time){
	date=new Date(time)
	mounths=['января','февраля','марта','апреля','мая','июня','июля','августа','сеньтября','октября','ноября','декабря']
	return date.getDate()+' '+mounths[date.getMonth()]+' '+date.getFullYear()+' в '+date.getHours()+':'+date.getMinutes();
}