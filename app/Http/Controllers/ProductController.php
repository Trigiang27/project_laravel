<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;


//use Illuminate\Http\Request;
use Auth;
use App\Cate;
use App\Product;
use App\ProductImage;
use App\Http\Requests\ProductRequest;
use Input,File;
use Request;
class ProductController extends Controller {

	public function getAdd () {
		$cate = Cate::select('id','name','parent_id')->get()->toArray();
		return view('admin.product.add',compact("cate"));
	}

	public function postAdd (ProductRequest $product_request) {
		$file_name = $product_request->file('fImages')->getClientOriginalName();
		$product = new Product();
		$product->name 			= $product_request->txtName;
		$product->alias 		= changeTitle($product_request->txtName);
		$product->price 		= $product_request->txtPrice;
		$product->intro 		= $product_request->txtIntro;
		$product->content 		= $product_request->txtContent;
		$product->image 		= $file_name;
		$product->keywords 		= $product_request->txtKeywords;
		$product->description 	= $product_request->txtDescription;
		$product->user_id		= Auth::user()->id;
		$product->cate_id 		= $product_request->sltParent;
		$product_request->file('fImages')->move('resources/upload/',$file_name);
		$product->save();
		$product_id = $product->id;
		if(Input::hasFile('fProductDetail')) {
			foreach(Input::file('fProductDetail') as $file) {
				$product_img = new ProductImage();
				if(isset($file)) {
					$product_img->image = $file->getClientOriginalName();
					$product_img->product_id = $product_id;
					$file->move('resources/upload/detail/',$file->getClientOriginalName());
					$product_img->save();
					
				}
			}
		}
		return redirect()->route('admin.product.list')->with(['flash_level'=> 'success','flash_message'=>'Success !! Complete Add Product.']);
	}

	public function getList () {
		$data = Product::select('id','name','price','cate_id','created_at')->orderBy('id','DESC')->get()->toArray();
		return view('admin.product.list',compact('data'));
	}

	public function getDelete ($id) {
		$images_detail = Product::Find($id)->product_image->toArray();
		foreach ($images_detail as $value) {
			File::delete('resources/upload/detail/'.$value['image']);
		}
		$product = Product::find($id);
		File::delete('resources/upload/'.$product->image);
		$product->delete($id);
		return redirect()->route('admin.product.list')->with(['flash_level'=> 'success','flash_message'=>'Success !! Complete Delete Product.']);
	}

	public function getEdit ($id) {
		$data = Product::find($id)->toArray();
		$parent = Cate::select('id','name','parent_id')->get()->toArray();
		$product_image = Product::find($id)->product_image->toArray();
		return view('admin.product.edit',compact('data','parent','product_image'));
	}

	public function postEdit ($id, Request $request) {

		$product = Product::find($id);
		
		// Edit hinh anh chinh
		if (!empty(Request::file('fImages'))) {
			$img_current = 'resources/upload/'.$product->image;
			if (File::exists($img_current)) {
				File::delete($img_current);
			}
			$file_name = Request::file('fImages')->getClientOriginalName();
			$product->image = $file_name;
			Request::file('fImages')->move('resources/upload/',$file_name);
		} 

		// Edit cac thong tin con lai
		$product->name			= Request::input('txtName');
		$product->alias			= changeTitle(Request::input('txtName'));
		$product->price			= Request::input('txtPrice');
		$product->intro			= Request::input('txtIntro');
		$product->content		= Request::input('txtContent');
		$product->keywords		= Request::input('txtKeywords');
		$product->description	= Request::input('txtDescription');
		$product->user_id		= Auth::user()->id;
		$product->cate_id		= Request::input('sltParent');
		$product->save();

		// Edit nhung hinh anh phu
		if (!empty(Request::file('fDetail'))) {
			foreach (Request::file('fDetail') as $file) {
				$product_image = new ProductImage();
				if (isset($file)) {
					$product_image->image 		= $file->getClientOriginalName();
					$product_image->product_id 	= $id;
					$file->move('resources/upload/detail/',$file->getClientOriginalName());
					$product_image->save();
				}
			}
			
		}
		return redirect()->route('admin.product.list')->with(['flash_level'=> 'success','flash_message'=>'Success !! Complete Update Product.']);
	}

	public function getDelImg ($id) {
		if (Request::ajax()) {
			$idHinh = (int)Request::get('idHinh'); 
			$image_detail = ProductImage::find($idHinh);
			if (!empty($image_detail)) {
				$img = 'resources/upload/detail/'.$image_detail->image;
				if (File::exists($img)) {
					File::delete($img);
				}
				$image_detail->delete();
			}
			return "Ok"; 
		}
	}
}
