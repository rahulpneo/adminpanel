@extends('layouts.admin.base')

@section('content')
    

<div class="page-content">
	<div class="row">
		<div class="col-md-12">
			
			<div class="tabbable-line boxless tabbable-reversed">
				<div class="portlet box blue-hoki">
					<div class="portlet-title">
						<div class="caption">
							Articles
						</div>
					</div>

					<div class="portlet light portlet-fit bordered">
						<div class="portlet-title">
							
								@if(Session::has('success'))
							        <div class="note note-success">
							            <p>{{ Session::get('success') }}</p>
							        </div>
							    @elseif(Session::has('error'))
							    	<div class="note note-danger">
							            <p>{{ Session::get('error') }}</p>
							        </div>    
							    @endif
							
							<div id="not-status"></div>
					        <a class="label-info btn-outline btn-circle btn-sm pull-right" href="{{ route('admin.articles.create') }}" style="color:#fff;text-decoration:none"><i class="glyphicon glyphicon-plus"></i> Create</a>
					       
						</div>
						<div class="portlet-body">
							<div class="mt-element-list">
								
								<div class="mt-list-container list-news ext-2">
									@if($articles->count())
									<ul>
										@foreach($articles as $article)
										<li class="mt-list-item">
											
											<div class="list-datetime bold uppercase font-yellow-casablanca">
												{{date('d M, Y',strtotime($article->created_at))}}
											</div>
											
											<div class="list-thumb">
												<a href="javascript:void(0);"> 
													<img alt="{{$article->title}}" src="{{asset('uploads/articles/'.$article->image)}}"> 
												</a>
											</div>
											<div class="list-item-content ">
												<div class="list-icon-container pull-right">
													<a href="javascript:void(0);"> 
													
				                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.articles.show', $article->id) }}" style="color:#fff;"><i class="glyphicon glyphicon-eye-open"></i> View</a>
				                                    <a class="btn btn-xs btn-warning" href="{{ route('admin.articles.edit', $article->id) }}" style="color:#fff;"><i class="glyphicon glyphicon-edit"></i> Edit</a>
				                                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
				                                        <input type="hidden" name="_method" value="DELETE">
				                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
				                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button>
				                                    </form>
				                                <!-- Notification -->
												    <a class="btn btn-xs btn-warning" href="{{ url('admin/notification') }}" style="color:#fff;"><i class="glyphicon glyphicon-edit"></i> Notification</a>
				                                    @if(isset($nfstatus))
				                                   <?php // echo "here";exit;?>
																	<!-- Notifikasi Script -->
													<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>				
																<script type ="text/javascript">
																$(document).ready(function() { 
																		checknotif();
																	setInterval(function(){ checknotif(); }, 5000);
																});
																function checknotif() {
																if (Notification.permission != "granted"){
																		Notification.requestPermission();
																	}else {
																		
																		var notifikasi = new Notification('new message from alex', {
																			icon: '',
																			body: 'how are you',
																			});
																			notifikasi.onclick = function () {
																				window.open('http://localhost:8000/admin/articles'); 
																				notifikasi.close();     
																			};
																				setTimeout(function(){
																				notifikasi.close();
																			}, 3000);
																					

																	}
																};
																</script>
				                                   @endif
												<!-- end notification -->		
													</a>
												</div>
												<h3 class="uppercase bold"><a href="{{ route('admin.articles.show', $article->id) }}">{{myTruncate($article->title,50," ")}}</a></h3>
												<p>
													{!! truncate($article->final_content,100) !!}
												</p>
											</div>
										</li>
										@endforeach
									</ul>
									
									
								</div>
								<div class="text-center">
								{!! $articles->render() !!}
								</div>
					            @else
					                <h3 class="text-center alert alert-info">No records found!</h3>
					            @endif
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

    <!--<div class="row">
        <div class="col-md-12">
            @if($articles->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>USER_ID</th>
                        <th>USER_ID</th>
                        <th>RAW_CONTENT</th>
                        <th>FINAL_CONTENT</th>
                        <th>IMAGE</th>
                        <th>META_CATEGORY_ID</th>
                        <th>META_CATEGORY_ID</th>
                        <th>TEMPLATE_ID</th>
                        <th>TEMPLATE_ID</th>
                        <th>DEFAULT_LIKES</th>
                            <th class="text-right">OPTIONS</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($articles as $article)
                            <tr>
                                <td>{{$article->id}}</td>
                                <td>{{$article->user_id}}</td>
                    <td>{{$article->user_id}}</td>
                    <td>{{$article->raw_content}}</td>
                    <td>{{$article->final_content}}</td>
                    <td>{{$article->image}}</td>
                    <td>{{$article->meta_category_id}}</td>
                    <td>{{$article->meta_category_id}}</td>
                    <td>{{$article->template_id}}</td>
                    <td>{{$article->template_id}}</td>
                    <td>{{$article->default_likes}}</td>
                                <td class="text-right">
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.articles.show', $article->id) }}"><i class="glyphicon glyphicon-eye-open"></i> View</a>
                                    <a class="btn btn-xs btn-warning" href="{{ route('admin.articles.edit', $article->id) }}"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $articles->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif

        </div>
    </div>-->

@endsection
