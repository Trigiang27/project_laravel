@extends('admin.master')
@section('content')
<style type="text/css">
    .img_current {width: 200px;margin-bottom: 20px; }
    .icon_del {position: relative;top: -75px;left: -33px;}
    #addImages {margin-bottom: 20px;}
</style>
<form action="" method="POST" name="frmEditProduct" enctype="multipart/form-data">
    <div class="col-lg-7" style="padding-bottom:120px">
    @include('admin.blocks.error')
    <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
        <div class="form-group">
            <label>Category Parent</label>
            <select class="form-control" name="sltParent">
                <option value="0">Please Choose Category</option>
                <?php cate_parent ($parent, 0,"--",$data['cate_id']); ?>
            </select>
        </div>
        <div class="form-group">
            <label>Name</label>
            <input class="form-control" name="txtName" placeholder="Please Enter Username" value="{!! old('txtName',$data['name']) !!}" />
        </div>
        <div class="form-group">
            <label>Price</label>
            <input class="form-control" name="txtPrice" placeholder="Please Enter Password" value="{!! old('txtPrice',$data['price']) !!}" />
        </div>
        <div class="form-group">
            <label>Intro</label>
            <textarea class="form-control" rows="3" name="txtIntro">{!! old('txtIntro',$data['intro']) !!}</textarea>
            <script type="text/javascript">ckeditor('txtIntro')</script>
        </div>
        <div class="form-group">
            <label>Content</label>
            <textarea class="form-control" rows="3" name="txtContent">{!! old('txtContent',$data['content']) !!}</textarea>
            <script type="text/javascript">ckeditor('txtContent')</script>
        </div>
        <div class="form-group">
            <label>Images Current</label>
            <img src="{!! asset('resources/upload/'.$data['image']) !!}" class="img_current" />
        </div>
        <div class="form-group">
            <label>Images</label>
            <input type="file" name="fImages">
        </div>
        <div class="form-group">
            <label>Product Keywords</label>
            <input class="form-control" name="txtKeywords" placeholder="Please Enter Category Keywords" value="{!! old('txtKeywords',$data['keywords']) !!}" />
        </div>
        <div class="form-group">
            <label>Product Description</label>
            <textarea class="form-control" rows="3" name="txtDescription">{!! old('txtDescription',$data['description']) !!}</textarea>
        </div>
        <button type="submit" class="btn btn-default">Product Edit</button>
        <button type="reset" class="btn btn-default">Reset</button>
    </div>
<div class="col-md-1"></div>
<div class="col-md-4">
    @foreach($product_image as $key => $item)
        <div class="form-group" id="{!! $key !!}">
            <img src="{!! asset('resources/upload/detail/'.$item['image']) !!}" class="img_current" idHinh="{!! $item['id'] !!}" id="{!! $key !!}" />
            <a href="javascript:void(0)" type="button" id="del_img_demo" class="btn btn-danger btn-circle icon_del"><i class="fa fa-times"></i></a>
        </div>
    @endforeach
    <button type="button" class="btn btn-primary" id="addImages">Add Images</button>
    <div id="insert"></div>
</div>
<form>
@endsection()
                