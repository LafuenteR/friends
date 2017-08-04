
		 					@foreach($comments as $comment)
		 					@foreach($accounts as $acc)
		 					<table>
		 					@if($comment->post_id == $post->id && $comment->user_id == $acc->id)
		 						<tr>
		 							<td class="col-md-1">
		 								<img src='{{asset("$acc->avatar")}}' width="30px;" style="margin-bottom: 10px;" class="img-circle">
		 							</td>
		 							<td class="col-md-2" style="padding-left: 0px;padding-right: 0px;">
		 								<a href='{{"/profile/$acc->id"}}' style="font-size: 10px;">{{$acc->name}}</a>		 			
		 							</td>
		 							<td class="col-md-5">
		 								{{$comment->comment}}
		 							</td>
		 							<td class="col-md-2" style="padding-left: 0px;padding-right: 0px;">
		 								<span style="font-size: 8px;">{{$comment->created_at->diffForHumans()}}</span>
		 						 	</td>
		 							<td class="col-md-1">
		 								<a role="button" style="font-size: 8px;">Delete</a>
		 							</td>
		 						</tr>		 		
		 					@endif
		 					</table>
		 					@endforeach
		 					@endforeach