@extends("../layout/master")

@section("main_content")
	@if (Auth::check())
	<div class="col-md-8 col-md-offset-2">
	<div class="panel-group">
		<div class="panel panel-default">
			<div class="panel-heading">
				<form class="form-inline" method="POST" action='{{url("/home")}}' enctype="multipart/form-data">
					{{csrf_field()}}
					<div class="form-group" style="background-color: white; width: 100%;">
					<input type="text" name="description" placeholder="POST....." class="form-control" style="width: 100%;">
					
					<input type="file" name="img" style="width: 100%;">
					
					
					<input type="submit" name="post" value="Post" class="btn btn-primary">	
					</div>			
				</form>
			</div>
		</div>
	</div>
	</div>
		@foreach ($posts as $post)
		@if($friends->contains($post->user_id) || (Auth::user()->id) == ($post->user_id))
			<div class="col-md-8 col-md-offset-2">
		<div class="panel-group">
			<div class="panel panel-default">

				<div class="panel-body" style="position: relative;">
					<div class="col-md-1" style="padding-left: 0;">
						<img src="{{$post->user->avatar}}" style="height: 40px;width: 40px;" class="img-circle">
					</div>
					<div class="col-md-11 dropdown">
						<a href='{{"/profile/$post->user_id"}}' style="margin-bottom: 0;">{{$post->user->name}}</a>
						<a  class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" style="position: absolute; right: 0;border-color:transparent; color: #3097d1;">
   						<span class="caret"></span></a>
   						<ul class="dropdown-menu" style="position: absolute;left: 65%; width: 50px;">
					      <li ><a href="#">Edit</a></li>
					      <li><a href="#">Delete</a></li>
					    </ul>
						<p style="font-size: 10px;">{{$post->created_at->diffForHumans()}}</p>

					</div>
					<div class="col-md-12" style="padding-left: 0;">
						
						<p>{{$post->description}}</p>
						@if (!empty($post->img))
						<div style="text-align: center;">
						<img src='{{asset("$post->img")}}' style="width:100%;">
						</div>
						@endif
												
						<hr style="margin: 10px 0px ;">
						@if(!Auth::user()->likes()->where('post_id',$post->id)->first())		 				<a role="button" name="like" onclick="like({{$post->id}});" id="like{{$post->id}}">Like</a>
						@else
		 					<a role="button" name="unlike" onclick="like({{$post->id}});" id="like{{$post->id}}">Unlike</a>
		 				@endif
		 				<!-- <span style="margin-left: 20px;"> -->
		 					<a role="button" name="comment" id="comment{{$post->id}}" onclick="comment({{$post->id}})" style="margin-left: 10%;">Comment</a>
		 				<!-- </span> -->
		 				<!-- <form id="form{{$post->id}}" style="display: none;"> -->
		 				<div class="form{{$post->id}}" style="display: none;">
		 					<input id="form{{$post->id}}" type="text" name="commentEnter" class="col-md-12 commentEnter">
		 					<div id="commentBox">
		 						@include("social.commentbox")
		 					</div>
		 					
		 				</div>
		 					<input type="hidden" id="token" value="{{csrf_token()}}">
		 					<!-- <input type="submit" name="Enter" class="col-md-3"> -->
		 				<!-- </form> -->
						</div>
				</div>
				
			</div>
		</div></div>
			@endif
			@endforeach
			<script type="text/javascript">
			 function like(id){
			 	// alert(id);
			 		var token = '{{ csrf_token() }}';
			 		// alert(token);
			if($('#like'+id).attr('name')=='like'){ 
			 	$.post('/like',{
			 		_token : token,
			 		id : id,
			 	},function(data){
			 		$('#like'+id).attr('name','unlike');
			 		$('#like'+id).html('Unlike');
			 	});
			 } 
			 else {
			 	$.post('/unlike',{
			 		_token : token,
			 		id : id,
			 	},function(data){
			 		$('#like'+id).attr('name','like');
			 		$('#like'+id).html('Like');
			 });


			 }
}
			function comment(id){
				$('.form'+id).toggle();
				// $('#comment'+id).toggle();
			}
			$('.commentEnter').keypress(function(event){
				console.log("hello")
				var id = this.id.substring(4);
				var comment_value = $(id).val();

				var token = $('#token').val();
				// alert(comment_value);
				if(event.keyCode == 13){
					var content = this.value;
					// alert(content);
					$.ajax({
						url: '/addComment',
						method: "POST",
						data: {
						_token : token,
						id : id,
						content : content
						},
						success: function(data){
							$('#commentBox').html(data);
							$('.commentEnter').val("");
							console.log(data);
						},
						error: function(response,data){
							console.log(response)
							console.log(data)
						}
					});

				}
			});
											
				
			</script>
			@endif

@endsection


@section("right_sidebar")
	@if (Auth::check())
	<div class="panel-group">
		<div class="panel panel-default">
			<div class="panel-heading" style="padding-bottom:20px">
				<span class="col-md-9" style="font-size: 12px;padding: 0;">
					Friend Request
				</span>
				<span class="col-md-3
				" style="font-size: 12px;padding: 0;">
					<a href="#">See All </a>
				</span>
			</div>
			<div class="panel-body">
			<table>
			@foreach($accounts as $account)
			@foreach($pending_requests as $pending)
			
			@if($pending->id == $account->id)
			<tr>
				<td class="col-md-3" style="padding-left: 0;padding-right: 0;">
					<img src="{{$pending->avatar}}" style="width: 30px;height: 30px;margin-bottom: 10px;" class="img-circle">	
				</td>
				<td class="col-md-7">
					<a href= '{{"/profile/$account->id"}}'>{{$pending->name}}</a>	
				</td>
				<td class="col-md-1">
					<span class="fa fa-check"></span>
				</td>
				<td class="col-md-1">
					<span class="fa fa-times"></span>
				</td>
			</tr>
			@endif
			@endforeach
			@endforeach
			</table>
			</div>
		</div>
	</div>
@endif

@endsection


@extends('layouts.app')


