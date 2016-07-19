<?php namespace App\Http\Controllers;
use DB,Mail,Request,Cart;
use App\Product;
class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index ()
	{
		$product = DB::table('products')->select('id','name','price','image','alias')->orderBy('id','DESC')->skip(0)->take(4)->get();
		$productlast = DB::table('products')->select('id','name','price','image','alias')->orderBy('id','DESC')->skip(0)->take(4)->get();
		return view('user.pages.home',compact('product','productlast'));
	}

	public function loaisanpham ($id) {
		$product_cate = DB::table('products')->select('id','name','price','alias','cate_id','image')->where('cate_id',$id)->paginate(2);
		$cate = DB::table('cates')->select('parent_id')->where('id',$id)->get();
		$menu_cate = DB::table('cates')->select('name')->where('parent_id', $cate[0]->parent_id)->get();
		$lastest_product = DB::table('products')->select('id','name','price','image','alias','cate_id')->orderBy('id','DESC')->take(3)->get();
		foreach($lastest_product as $product) {
			$data = DB::table('cates')->select('name')->where('id',$product->cate_id)->get();
			$cate_product[] = $data[0]->name;	
		}
		return view('user.pages.cate',compact('product_cate','menu_cate','lastest_product','cate_product'));
	}

	public function chitietsanpham ($id) {
		$product_detail = Product::findOrFail($id);
		$image = DB::table('product_images')->select('image')->where('product_id',$id)->take(3)->get();
		$product_cate = DB::table('products')->where('cate_id',$product_detail->cate_id)->where('id','<>',$id)->take(4)->get();
		return view('user.pages.detail',compact('product_detail','image','product_cate'));
	}

	public function get_lienhe () {
		return view('user.pages.contact');
	}

	public function post_lienhe (Request $request) {
		$data = ['name'=>Request::input('name'),'content'=>Request::input('message')];
		Mail::send('emails.blanks',$data,function ($msg) {
			$msg->from('nguyentrigiang19911@gmail.com','Customer');
			$msg->to('nguyentrigiang19911@gmail.com','Admin')->subject('Email Lien He');
		});
		echo "<script>
			alert('Cam on ban da lien he. Chung toi se lien he lai voi ban trong thoi gian som nhat.');
			window.location = '".url('/')."'
		</script>";
	}

	public function muahang ($id) {
		$product_buy = DB::table('products')->where('id',$id)->first();
		Cart::add(array('id'=>$product_buy->id,'name'=>$product_buy->name,'qty'=>1,'price'=>$product_buy->price,'options'=>array('img'=>$product_buy->image)));
		//$content = Cart::content();
		return redirect()->route('giohang');
	}	
	public function giohang () {
		$content = Cart::content();
		$total = Cart::total();
		return view('user.pages.shopping',compact('content','total'));
	}

	public function xoasanpham ($id) {
		Cart::remove($id);
		return redirect()->route('giohang');
	}
	public function capnhat () {
		if(Request::ajax()) {
			$id = Request::get('id');
			$qty = Request::get('qty');
			Cart::update($id,$qty);
			echo "OK";
		}
	}
}
