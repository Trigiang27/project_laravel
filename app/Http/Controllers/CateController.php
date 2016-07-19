<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\CateRequest;
use App\Cate;
class CateController extends Controller {


	public function getList () {
		$data = Cate::select('id','name','parent_id')->orderBy('id','DESC')->get()->toArray();
		return view('admin.cate.list',compact('data'));
	}

	public function getAdd () {
		$parent = Cate::select('id','name','parent_id')->get()->toArray();
		return view('admin.cate.add',compact('parent'));
	}
	public function postAdd (CateRequest $Request) {
		$cate = new Cate;
		$cate->name 		= $Request->txtCateName;
		$cate->alias 		= changeTitle($Request->txtCateName);
		$cate->order 		= $Request->txtOrder;
		$cate->parent_id 	= $Request->sltParent;
		$cate->keywords 	= $Request->txtKeywords;
		$cate->description 	= $Request->txtDescription;
		$cate->save();
		return redirect()->route('admin.cate.list')->with(['flash_level'=> 'success','flash_message'=>'Success !! Complete Add Category.']);
	}

	public function getDelete($id) {
		$parent = Cate::where('parent_id',$id)->count();
		if ($parent == 0) {
			$cate = Cate::find($id);
			$cate->delete();
			return redirect()->route('admin.cate.list')->with(['flash_level'=>'success','flash_message'=>'Success !! Complete Delete Category.']);
		} else {
			echo "<script type='text/javascript'>
				alert('Sorry ! You Can Not Delete This Category.');
				window.location = '";
					echo route('admin.cate.list');
				echo"'
			</script>";
		}
		
	}

	public function getEdit ($id) {
		$data = Cate::findOrFail($id)->toArray();
		$parent = Cate::select('id','name','parent_id')->get()->toArray();
		return view('admin.cate.edit',compact('parent','data'));
	}

	public function postEdit (Request $Request,$id) {
		$this->validate($Request, 
			["txtCateName" => "required"],
			["txtCateName.required" => "Please Enter Name Category 1"]
		);
		$data = Cate::findOrFail($id);
		$data->parent_id 	= $Request->sltParent;
		$data->alias 		= changeTitle($Request->txtCateName);
		$data->name 		= $Request->txtCateName;
		$data->order 		= $Request->txtOrder;
		$data->keywords 	= $Request->txtKeywords;
		$data->description 	= $Request->txtDescription;
		$data->save();
		return redirect()->route('admin.cate.list')->with(['flash_level'=>'success','flash_message'=>'Success !! Complete Edit Category.']);
	}
}
