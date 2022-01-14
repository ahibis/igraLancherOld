postPhotos=[];
function imgRemote(){
	$("img").click(function(){
		if(!$(this).hasAttr("!Show")){
			ob=this
			$('#sPhoto').attr("src",$(this).attr("src"))
			$("#showphoto").modal("show")
			$('#showphoto').on('shown.bs.modal', function (e) {
				$('#sPhoto').attr("src",$(ob).attr("src"))
			})
		}
	})
}
$(document).ready(function(){
	if (myAcc){
		$("#address").suggestions({
		    token: "5eba447183215d9884ae28a8b17a027af1ac3751",
		    type: "ADDRESS",
		    onSelect: function(city) {
		       	data=city.data;
		        cityData={
		            city_fias_id:data.city_fias_id,
		            city_kladr_id:data.city_kladr_id,
		            city:data.city_with_type,
		            country:data.country,
		            region:data.region_with_type,
		            geo_lat:data.geo_lat,
		            geo_lon:data.geo_lon,
		            address:city.value
		        }
		        changefields(cityData);
		    }
		});
		$(".field").each(function(){
			//console.log($(this).attr("name"))
			$(this).attr("contenteditable","true");
			$(this).attr("title","нажмите чтобы изменить поле");
		})
		$(".field").on('input',function(){changefield($(this).attr("name"),$(this).html())});
		$(".accaunt").find("input").change(function(){changefield($(this).attr("name"),$(this).val())});
		$(".accaunt").find("select").change(function(){changefield($(this).attr("name"),$(this).val())});
	}else{
		$("input[type='date']").each(function(){
			$(this).after(getDate($(this).val()))
			$(this).remove()
		})
	}
	imgRemote()
})

function changeEvent(){
	data={}
	$(".field").each(function(){
		data[$(this).attr("name")]=$(this).html();
	})
}
function getDate($date){
	if ($date!=''){
		mn=['января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря']
		parts=$date.split("-")
		return parts[2]*1+' '+mn[parts[1]-1]+' '+parts[0]+' года';
	}else{
		return 'дата не указана';
	}
}
function loadAva(){
	limg = document.createElement("input");
	limg.setAttribute("type", "file");
	limg.click()
	$(limg).change(function(){
		sendFiles(limg,urlApi("setAvatar"),function (data){
			console.log(data)
			if (data.status=="success"){
				console.log(data.files.length)
				if (data.files.length>0){
					$("#ava").attr("src","avaimg/"+data.files[0])
					changefield("src","avaimg/"+data.files[0]);
				}
			}
		})
	})
}
function nextPhoto(){
	src=$("#sPhoto").attr("src").split('/');
	if (src[0]=='photos'){
		i=photos.indexOf(src[2])
		if (i<photos.length-1){
			i+=1
			$("#sPhoto").attr('src','photos/'+user_id+'/'+photos[i])
			
		}
	}
}
function prevPhoto(){
	src=$("#sPhoto").attr("src").split('/');
	if (src[0]=='photos'){
		i=photos.indexOf(src[2])
		if (i>0){
			i-=1
			$("#sPhoto").attr('src','photos/'+user_id+'/'+photos[i])
		}
	}
}
function addPhoto(){
	limg = document.createElement("input");
	limg.setAttribute("type", "file");
	limg.setAttribute("multiple","true");
	limg.click()
	$(limg).change(function(){
		sendFiles(limg,urlApi("addPhoto"),function (data){
			console.log(data)
			if (data.status=="success"){
				photos=data.photos
				$('#cf').html('фото('+photos.length+')')
				if (data.files.length>0){
					for (photo in data.files){
						if ($(".photos").find("img").length<4){
							$(".photos").append("<img src='photos/"+user_id+"/"+data.files[photo]+"' class='col-3'>");
						}
					}
				}
			}
		})
	})
}
function savePostPhotos(){
	limg = document.createElement("input");
	limg.setAttribute("type", "file");
	limg.setAttribute("multiple","true");
	limg.click()
	$(limg).change(function(){
		sendFilesPost(limg,urlApi("savePostPhotos"),{page_id:user_id},function (data){
			if (data.status=="success"){
				for (i in data.files){
					var img = new Image();
					img.onload = function() {
					    postPhotos.push({'w':this.width,'h':this.height,'s':this.src})
					    loadPostImg(postPhotos,$("#postPhotos"),$("#cf").width())
					};
					img.src = 'postPhotos/'+user_id+'/'+data.files[i];
				}
			}
		})
	})
}
function loadPostImg(photos,elementJquery,WIDTH){
	for (i in photos){
		if (i==0){
			h=photos[i].h
			maxPostWidth=photos[i].w
		}else{
			maxPostWidth+=photos[i].w*h/photos[i].h
		}
	}
	elementJquery.html('');
	for (i in photos){
		w=~~(WIDTH*(photos[i].w/maxPostWidth)*(h/photos[i].h))
		elementJquery.append("<img src='"+photos[i].s+"' style='width:"+w+"px'>")
	}
}
class POST{
	canLoadPost=1;
	posts=[];
	users={};
	needUserLoad=0;
	userLoaded=0;
	count=10;
	lastPostId=9999999999;
	type='load';
	send(){
		if (this.canLoadPost==1){
			this.canLoadPost=0
			this.users={}
			this.type='new';
			var text=$('#postText').val();
			api("sendPost",{text:text,photos:JSON.stringify(postPhotos),page_id:user_id},function(data){
				$('#postText').val('');
				$("#postPhotos").html('');
				console.log(data)
				Post.load(data)
			})
		}
	}
	nextLoads(){
		if (this.canLoadPost==1){
			this.canLoadPost=0
			this.users={}
			this.type='load';
			api("getPosts",{offset:this.lastPostId,page_id:user_id,count:this.count},this.load)
		}
	}
	load(data){
		console.log(data)
		Post.posts=JSON.parse(data).posts;
		for (i in Post.posts){
			var from_id=Post.posts[i].from_id
			if (from_id in Post.users){}else{
				Post.users[from_id]=1
				Post.needUserLoad+=1
			}
		}
		for (var i in Post.users){
			User.load(i,Post.userLoad)
		}
	}
	userLoad(user){
		Post.userLoaded+=1;
		if (Post.userLoaded==Post.needUserLoad){
			Post.creates()
		}
	}
	creates(){
		for (var i in this.posts){
			var post=this.posts[i]
			var user=User.get(post.from_id)
			var template=`
				<div class='post'>
					<div class='row'>
						<div class='col-2'><img src='`+user.src+`' width='100%' class='postAva'></div>
						<div class='col-10'>
							<a href="/`+user.login+`" class="namePost">`+user.name+` `+user.sname+`</a><br>
							<div class="dataPost">`+getFullTime(post.time*1000)+`</div>
						</div>
					</div>
					<div class='textPost'>`+post.text+`</div>
					<div class='postImg'></div>
				</div>`
			if (this.type=='load'){$("#posts").append(template);this.lastPostId=post.id;}else{$("#posts").prepend(template);}
			this.loadImg(post.photos)
		}
	}
	loadImg(photos){
		if (photos!='[]'){
			if (this.type=='load'){
				var lastPost=$('.postImg').last();
			}else{
				var lastPost=$('.postImg').eq(0);
			}
			var photos=JSON.parse(photos)
			loadPostImg(photos,lastPost,lastPost.width())
			imgRemote()
		}
		this.canLoadPost=1;
	}
}
Post=new POST();
Post.nextLoads()