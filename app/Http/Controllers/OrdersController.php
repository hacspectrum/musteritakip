<?php namespace App\Http\Controllers;

class OrdersController extends Controller
{
    public function getIndex(){
		return view('orders.new');
	}	
	public function getEdit($id){
		$user=\DB::table('siparis')->where('firma_id',1)->where('id',$id)->first();
		return view('orders.new',compact('user'));
	}
	public function postCreate(){
		
		$post=\Input::all();
		
		// Eğer Müşteri ise
		if(\Auth::user()->tip!=0) $post['musteri']=\Auth::id();
		
		 $validator =  \Validator::make($post, [
            'musteri' => 'required|numeric',
			'urun' => 'required|numeric',
			'miktar' => 'required|numeric',
			'aciklama' => 'max:255',
        ]);

        if ($validator->fails()) {
            return \Redirect::to('/orders/')
                        ->withErrors($validator)
                        ->withInput(\Input::all());
        }else{
			
			$fiyat=\App\Ica::ozelfiyat($post['urun'],$post['musteri']);
			$toplam=$fiyat*$post['miktar'];
			
			
			$db=array(
			'musteri_id'=>$post['musteri'],
			'urun_id'=>$post['urun'],
			'firma_id'=>\Session::get('firma'),
			'miktar'=>$post['miktar'],
			'fiyat'=>$fiyat,
			'tutar'=>$toplam,
			'aciklama'=>$post['aciklama'],
			'created_at'=>date('Y-m-d H:i:s')
			);
			
			if(isset($post['id']) && is_numeric($post['id'])){
				\Session::put('success','Sipariş kaydı güncellendi.');
				\DB::table('siparis')->where('id',$post['id'])->update($db);
			}else{
				\Session::put('success','Sipariş kaydı başarıyla oluşturdu.');
				\DB::table('siparis')->insert($db);
			}
			return \Redirect::to('/orders/list');
		}		
	}
	public function getList(){
		return view('orders.list');
	}
	public function getConfirm($durum=0,$id){
		
		$db=array('user_id'=>\Auth::id());
		
		if($durum==1){
			$db['durum']=1;
			$m=' sipariş onaylandı! ';
		}elseif($durum==2){
			$db['durum']=2;
			$m=' sipariş iptal edildi! ';
		}
		
		$siparis=\DB::table('siparis')->where('id',$id)->where('firma_id',\Session::get('firma'))->first();
		if($siparis->durum==0){
			if(\DB::table('siparis')->where('id',$id)->where('firma_id',\Session::get('firma'))->where('durum',0)->update($db)){
				\DB::table('hesap')->insert(
				array(
					'musteri_id'=>$siparis->musteri_id,
					//'user_id'=>\Auth::id(),
					'firma_id'=>\Session::get('firma'),
					'tip'=>'SATIS',
					'tarih'=>date('Y-m-d H:i:s',strtotime($siparis->updated_at)),
					'aciklama'=>$siparis->aciklama,
					'urun_id'=>$siparis->urun_id,
					'miktar'=>$siparis->miktar,
					'fiyat'=>$siparis->fiyat,
					'tutar'=>$siparis->tutar,
					'user_id'=>$siparis->user_id,
					'siparis_id'=>$siparis->id,
					'durum'=>$db['durum']
					)
				);
				return \Redirect::to('orders/list')->with('success',$m);
			}
		}
	}
}