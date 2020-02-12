<?php namespace App\Http\Controllers;

class ProductsController extends Controller
{
    public function getIndex(){
		return view('products.new');
	}
	public function getEdit($id){
		$product=\DB::table('urun')->where('firma_id',1)->where('id',$id)->first();
		return view('products.new',compact('product'));
	}
	public function postCreate(){
		
		$post=\Input::all();
		
		 $validator =  \Validator::make($post, [
            'urunadi' => 'required',
			'fiyat' => 'required|numeric',
			'birim' => 'required',
		]);

        if ($validator->fails()) {
            return \Redirect::to('/products/')
                        ->withErrors($validator)
                        ->withInput(\Input::all());
        }else{
			
			$db=array(
			'urunadi'=>$post['urunadi'],
			'fiyat'=>$post['fiyat'],
			'firma_id'=>\Session::get('firma'),
			'birim'=>$post['birim']
			);
			
			if(isset($post['id']) && is_numeric($post['id'])){
				\Session::put('success','Ürün kaydı güncellendi.');
				\DB::table('urun')->where('id',$post['id'])->update($db);
				\DB::table('urun_fiyat')->where('urun_id',$post['id'])->where('firma_id',\Session::get('firma'))->update(array('fiyat'=>$post['fiyat']));
			}else{
				\Session::put('success','Ürün kaydı başarıyla oluşturdu.');
				\DB::table('urun')->insert($db);
				$id=\DB::table('urun')->max('id');
				\DB::table('urun_fiyat')->insert(array('tip'=>0,'fiyat'=>$post['fiyat'],'urun_id'=>$id,'firma_id'=>\Session::get('firma')));
			}
			return \Redirect::to('/products/list');
		}		
	}
	public function getList(){
		return view('products.list');
	}
	public function getPrices($urun=0,$ozel_fiyat_id=0){
		if(is_numeric($urun) && $urun>0){
			$product=\DB::table('urun')->where('firma_id',\Session::get('firma'))->where('id',$urun)->first();
		}
		if(is_numeric($urun) && $urun>0){
			$prices=\DB::table('urun_fiyat')->where('firma_id',\Session::get('firma'))->where('urun_id',$urun)->where('id',$ozel_fiyat_id)->first();
		}
		return view('products.prices',compact('product','prices'));
	}
	public function postPrices(){
		$post=\Input::all();
		
		$validator =  \Validator::make($post, [
            'urun' => 'required|numeric',
			'musteri' => 'required|numeric',
			'fiyat' => 'required|numeric',
		]);
        
		if ($validator->fails()) {
            return \Redirect::to('/products/prices/'.$post['id'].'/')
			->withErrors($validator)
			->withInput(\Input::all());
        }else{			
			\DB::table('urun_fiyat')->where('firma_id',\Session::get('firma'))->where('musteri_id',$post['musteri'])->delete();
			\DB::table('urun_fiyat')->insert(array('tip'=>2,'fiyat'=>$post['fiyat'],'musteri_id'=>$post['musteri'],'urun_id'=>$post['urun'],'firma_id'=>\Session::get('firma')));
		}
		return \Redirect::to('/products/prices/'.$post['urun'].'/')->with('success','Fiyat güncellendi.');
	}
	public function getSpecial(){
		return view('products.special');
	}
}