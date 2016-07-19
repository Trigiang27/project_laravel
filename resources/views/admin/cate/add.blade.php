@extends('admin.master')
@section('content')

<div class="col-lg-7" style="padding-bottom:120px">
    @include('admin.blocks.error')
    <form action="{!! route('admin.cate.getAdd') !!}" method="POST">
        <input type='hidden' name='_token' value="{!! csrf_token() !!}"/>
        <div class="form-group">
            <label>Category Parent</label>
            <select class="form-control" name="sltParent" value="{!! old('sltParent') !!}" >
                <option value="0">Please Choose Category</option>
                <?php cate_parent($parent,0,"--",old('sltParent')); ?>
            </select>
        </div>
        <div class="form-group">
            <label>Category Name</label>
            <input class="form-control" name="txtCateName" placeholder="Please Enter Category Name" />
        </div>
        <div class="form-group">
            <label>Category Order</label>
            <input class="form-control" name="txtOrder" placeholder="Please Enter Category Order" value="{!! old('txtOrder') !!}"/>
        </div>
        <div class="form-group">
            <label>Category Keywords</label>
            <input class="form-control" name="txtKeywords" placeholder="Please Enter Category Keywords" value="{!! old('txtKeywords') !!}"/>
        </div>
        <div class="form-group">
            <label>Category Description</label>
            <textarea class="form-control" rows="3" name='txtDescription'>{!! old('txtDescription') !!}</textarea>
        </div>
        <button type="submit" class="btn btn-default">Category Add</button>
        <button type="reset" class="btn btn-default">Reset</button>
    <form>
</div>
@endsection()               