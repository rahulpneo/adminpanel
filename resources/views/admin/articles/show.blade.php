@extends('layouts.admin.base') <?php
$article = $article[0];
?>

@section('header')

@endsection

@section('content')

<div class="page-content">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header clearfix">
				<h1>Articles</h1>
				<form action="{{ route('admin.articles.destroy', $article['id']) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
					<input type="hidden" name="_method" value="DELETE">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="btn-group pull-right" role="group" aria-label="...">
						<a class="btn btn-primary" href="{{ route('admin.articles.index') }}">Back</a>
						<a class="btn btn-warning btn-group" role="group" href="{{ route('admin.articles.edit', $article['id']) }}"><i class="glyphicon glyphicon-edit"></i> Edit</a>
						<button type="submit" class="btn btn-danger">
							Delete <i class="glyphicon glyphicon-trash"></i>
						</button>
					</div>
				</form>

			</div>
			<div class="tabbable-line boxless tabbable-reversed">
				
					<div class="portlet-body">
						
								@include($article['template']['path'],array('article'=>$article))
							
					</div>
					
					
			</div>
		</div>
	</div>
</div>
@endsection