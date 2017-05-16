@extends('layouts.admin.base')
@section('styles')
  <link href="{{asset('admin_design/css/validationEngine.jquery.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('admin_design/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('admin_design/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('admin_design/global/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css')}}" rel="stylesheet" type="text/css" />	
@stop
@section('content')
    
    <div class="page-content">
      <div class="row">
        <div class="col-md-12">
        <div class="tabbable-line boxless tabbable-reversed">
        <div class="portlet box blue-hoki">
          <div class="portlet-title">
            <div class="caption">Edit Article</div>
          </div>
            
          <div class="portlet-body form" style="display: block;">
            @include('error')
            <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" id="update_article" class="form-horizontal" enctype="multipart/form-data">
                <div class="form-body">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="_method" value="PUT">
                  <div class="form-group @if($errors->has('title')) has-error @endif">
                    <label class="col-md-3 control-label" for="slug-field">Title *</label>
                    <div class="col-md-9">
                    <input type="text" id="title-field" name="title" class="form-control validate[required]" value="{{ is_null(old("title")) ? $article->title : old("title") }}"/>
                      @if($errors->has("title"))
                        <span class="help-block">{{ $errors->first("title") }}</span>
                      @endif
                    </div>
                  </div>
                  
                  <div class="form-group @if($errors->has('content')) has-error @endif">
                    <label class="col-md-3 control-label" for="title-field">Content *</label>
                    <div class="col-md-9">
                      <textarea class="raw_content form-control validate[required]" name="content" rows="6">{{ is_null(old("content")) ? $article->final_content : old("content") }}</textarea>
                      <!-- <input type="text" id="raw_content-field" name="raw_content" class="form-control" value="{{ old("raw_content") }}"/> -->
                      @if($errors->has("raw_content"))
                      <span class="help-block">{{ $errors->first("content") }}</span>
                      @endif
                    </div>  
                  </div>
                  
                  <div class="form-group @if($errors->has('image')) has-error @endif">
                    <label class="col-md-3 control-label" for="image-field">Image </label>
                    <div class="col-md-6">
                    <!-- <input type="text" id="image-field" name="image" class="form-control" value="{{ old("image") }}"/> -->
                    <!-- <label class="custom-file">
					  <input type="file" name="image" id="file" class="custom-file-input">
					  <span class="custom-file-control"></span>
					</label> -->
					
					<div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="input-group input-large">
                            <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                <span class="fileinput-filename"> </span>
                            </div>
                            <span class="input-group-addon btn default btn-file">
                                <span class="fileinput-new"> Select file </span>
                                <span class="fileinput-exists"> Change </span>
                                <input type="file" name="image"> </span>
                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                        </div>
                    </div>
                    
                     @if($errors->has("image"))
                      <span class="help-block">{{ $errors->first("image") }}</span>
                     @endif
                    </div>
                    <div class="col-md-3">
                    	<div class="fileinput fileinput-new fileinput-preview thumbnail">
                    		<img alt="{{$article->title}}" src="{{asset('uploads/articles/'.$article->image)}}">
                    	</div>	
                    </div>	
                    
                    
                  </div>
                  
                  <div class="form-group @if($errors->has('tag_id')) has-error @endif">
                    <label class="col-md-3 control-label" for="tag_id-field">Tags *</label>
                    <div class="col-md-9">
                      <?php 
                      $tags_arr = array();
                      if($article->tag->count()>0):
					  
                      	foreach($article->tag as $old_tag)
						{
							$tags_arr[] = $old_tag->id;
						}
                      	
                      endif;
                      //echo "<pre>";print_r($tags_arr);echo "</pre>";exit;
                      $old_tags = is_null(old("tag_id")) ? $tags_arr : old("tag_id")
                      
                      ?>
                      <select name="tag_id[]" id="tag_id" class="form-control validate[required]" multiple> 
                        <option value="">Select</option>
                        @if($tags->count() > 0)
                          @foreach($tags as $tag)
                            <option value="{{$tag->id}}" {{(in_array($tag->id,$old_tags) === true )?'selected':''}}>{{$tag->title}}</option>
                          @endforeach
                        @endif
                      </select>
                      <!-- <input type="text" id="meta_category_id-field" name="" class="form-control" value="{{ old("meta_category_id") }}"/> -->
                     @if($errors->has("tag_id"))
                      <span class="help-block">{{ $errors->first("tag_id") }}</span>
                     @endif
                    </div>
                  </div>
                  
                  <div class="form-group @if($errors->has('meta_category_id')) has-error @endif">
                    <label class="col-md-3 control-label" for="meta_category_id-field">Meta Category *</label>
                    <div class="col-md-9">
                      @php 
                      $old_meta_category = is_null(old("meta_category_id")) ? $article->meta_category_id : old("meta_category_id")
                      
                      @endphp	
                      <select name="meta_category_id" id="meta_category_id" class="form-control validate[required]"> 
                        <option value="">Select</option>
                        @if($meta_categories->count() > 0)
                          @foreach($meta_categories as $meta_category)
                            <option value="{{$meta_category->id}}" {{($old_meta_category==$meta_category->id)?'selected':''}}>{{$meta_category->title}}</option>
                          @endforeach
                        @endif
                      </select>  
                      <!-- <input type="text" id="meta_category_id-field" name="" class="form-control" value="{{ old("meta_category_id") }}"/> -->
                     @if($errors->has("meta_category_id"))
                      <span class="help-block">{{ $errors->first("meta_category_id") }}</span>
                     @endif
                    </div>
                  </div>
                  
                  <div class="form-group @if($errors->has('template_id')) has-error @endif">
                    <label class="col-md-3 control-label" for="template_id-field">Template *</label>
                    <div class="col-md-9">  
                      @php 
                      	$old_template = is_null(old("template_id")) ? $article->template_id : old("template_id")
                      @endphp	
                      <input type="hidden" id="old_template_id" value="{{$old_template}}"/>
                      <select name="template_id" id="select_templates" class="form-control validate[required]"> 
                        <option value="">Select Template</option>
                        @if($templates->count()>0)
                        	@foreach($templates as $template)
                        		@if($template->meta_category_id == $old_meta_category)
                        			<option value="{{$template->id}}" {{($article->template_id==$template->id)?'selected':''}}>{{$template->title}}</option>
                        		@endif
                        	@endforeach
                        @endif
                      </select>
                      <!-- <input type="text" id="template_id-field" name="template_id" class="form-control" value="{{ old("template_id") }}"/> -->
                     @if($errors->has("template_id"))
                      <span class="help-block">{{ $errors->first("template_id") }}</span>
                     @endif
                    </div> 
                  </div>
                  
                  <div class="form-group @if($errors->has('default_likes')) has-error @endif">
                    <label class="col-md-3 control-label"  for="default_likes-field">Default likes</label>
                    <div class="col-md-9">
                      <input type="number" id="default_likes-field" name="default_likes" class="form-control" value="{{ is_null(old("default_likes")) ? $article->default_likes : old("default_likes") }}"/>
                       @if($errors->has("default_likes"))
                        <span class="help-block">{{ $errors->first("default_likes") }}</span>
                       @endif
                    </div>   
                  </div>
                  <div class="form-actions">
                    <div class="row">
                      <div class="col-md-offset-3 col-md-9">
                      <button type="submit" class="btn btn-primary">Update</button>
                      <a class="btn default" href="{{ route('admin.articles.index') }}">Back</a>
                      </div>
                    </div>
                  </div>  
                </div>
              </form>
            </div>
            </div>
        </div>
      </div>
      </div>
  </div>    
    
    
@endsection
@section('scripts')
	<script src="{{asset('admin_design/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js')}}" type="text/javascript"></script>
	<script src="{{asset('admin_design/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js')}}" type="text/javascript"></script>
	<script src="{{asset('admin_design/js/jquery.validationEngine.js')}}" type="text/javascript"></script>
	<script src="{{asset('admin_design/js/jquery.validationEngine-en.js')}}" type="text/javascript"></script>
    <script src="{{asset('admin_design/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
   	
   	<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
   	<script src="{{asset('admin_design/global/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js')}}" type="text/javascript"></script>
    <script src="{{asset('admin_design/pages/scripts/components-bootstrap-multiselect.min.js')}}" type="text/javascript"></script>
    
    <script>
      $('#tag_id').multiselect({
      	buttonWidth: '100%',
      	enableFiltering: true,
        includeSelectAllOption: true,
        
      });
      
      $("#update_article").validationEngine({scroll: false});
      
      $('#meta_category_id').trigger('change');
      
      $('#meta_category_id').change(function(){
       var meta_category_id = $(this).val();
       var url = "<?php echo url('/admin/ajax_get_templates/');?>/"+meta_category_id;
       
       $.ajax({
        url: url,
        method: "GET",
        success: function(result){
        	$('#select_templates').html(result);
          }
        });
      });
      
      CKEDITOR.replace( 'content' );
    </script>
@endsection