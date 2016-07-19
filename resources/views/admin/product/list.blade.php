@extends('admin.master')
@section('content')
<table class="table table-striped table-bordered table-hover" id="dataTables-example">
    @include('admin.blocks.error')
    <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
    <thead>
        <tr align="center">
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Category</th>
            <th>Date</th>
            <th>Delete</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
        <?php $id = 0 ?>
        @foreach($data as $item)
            <tr class="odd gradeX" align="center">
                <td>{!! ++$id !!}</td>
                <td>{!! $item['name'] !!}</td>
                <td>{!! number_format($item['price'],0,",",".") !!} VNĐ</td>
                <td>
                    <?php 
                        $cate = DB::table('cates')->where('id',$item['cate_id'])->first(); 
                        echo $cate->name;
                    ?>
                </td>
                <td>{!! \Carbon\Carbon::createFromTimeStamp(strtotime($item["created_at"]))->diffForHumans() !!}</td>
                <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="{!! URL::route('admin.product.getDelete',$item['id']) !!}" onclick="return xacnhanxoa('Do You Want Delete This Product?')" > Delete</a></td>
                <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="{!! URL::route('admin.product.getEdit',$item['id']) !!}">Edit</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection()     