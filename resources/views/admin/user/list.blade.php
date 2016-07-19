@extends('admin.master')
@section('content')
<table class="table table-striped table-bordered table-hover" id="dataTables-example">
    <thead>
        <tr align="center">
            <th>ID</th>
            <th>Username</th>
            <th>Level</th>
            <th>Delete</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
    <?php $stt = 0?>
        @foreach($data as $user)
        <tr class="odd gradeX" align="center">
            <td>{!! ++$stt !!}</td>
            <td>{!! $user['username'] !!}</td>
            <td>

                @if ($user['level'] === 1 && $user['id'] === 7)
                    SuperAdmin
                @elseif ($user['level'] === 1) 
                    Admin
                @else 
                    Member
                @endif
            </td>
            <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a onclick="return xacnhanxoa('Ban co chac muon xoa User nay khong?')" href="{!! URL::route('admin.user.getDelete',$user['id']) !!}"> Delete</a></td>
            <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="{!! URL::route('admin.user.getEdit',$user['id']) !!}">Edit</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection()
