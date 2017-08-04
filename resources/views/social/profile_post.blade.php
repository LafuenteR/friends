@extends("social.profile")

@section("profile_section")
		@if(!empty($accounts->id))
		
		@foreach($posts as $post)
		@if($accounts->id == $post->user_id)
		<!-- $accounts->id = Auth::user()->id; -->
		<div class="panel-group">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="col-md-1" style="padding-left: 0;">
						<img src="/{{$accounts->avatar}}"" style="width: 40px;height: 40px;"
						 class="img-circle">
					</div>
					<div class="col-md-11">
						<span style="margin-bottom: 0;">{{$accounts->name}}</span>
						<p style="font-size: 10px;">{{$post->created_at->diffForHumans()}}</p>

					</div>
					<div class="col-md-12">
						<p>{{$post->description}}</p>
						@if (!empty($post->img))
						<div style="text-align: center">
						<img src='{{asset("$post->img")}}' style="width: 100%;">
						</div>
						@endif
								
						<hr style="margin: 10px 0px ;">
		 				<!-- <button>Like</button>
						<button>Comment</button>
						<button>Edit</button>
						<button>Delete</button>
 -->					</div>
				</div>
			</div>
		</div>
		@endif
		@endforeach
		<!-- @endif -->


@endsection
