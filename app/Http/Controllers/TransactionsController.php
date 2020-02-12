<?php namespace App\Http\Controllers;

class TransactionsController extends Controller
{
    public function getIndex(){
		return view('transactions.new');
	}
    public function getAdd($type,$user=0){
		return view('transactions.new',compact('user','type'));
	}
	public function getEdit($id){
		$detail=\DB::table('hesap')->where('firma_id',\Session::get('firma'))->where('id',$id)->first();
		return view('transactions.new',compact('detail'));
	}
	public function getList($type='sales'){
		$user=\DB::table('hesap')->where('firma_id',\Session::get('firma'))->where('tip',$type)->first();
		return view('transactions.list',compact('user','type'));
	}
	public function getDestory($id){
		if(is_numeric($id) && \Auth::user()->tip==1){
			if(\DB::table('hesap')->where('firma_id',\Session::get('firma'))->where('id',$id)->where('user_id',\Auth::id())->delete()){
				return \Redirect::back()->with('success','Hesap hareketi kaydınız silinmiştir');
			}
		}else \Redirect::back()->with('error','Bu işlemi yapamaya yetkiniz bulunmuyor.');
		return;
	}
	public function postAjax($type=''){
		$post=\Input::all();
		//print_r($post);
		if($type=='fiyat'){
			if(is_numeric($post['u']) && is_numeric($post['k'])){
				
				$bolge_id=\DB::table('users')->find($post['k'])->bolge_id;
				
				if($bolge_id>0){
					$fiyat=\DB::table('urun_fiyat')
					->where('urun_id',$post['u'])->orWhere('urun_id',0)
					->where('musteri_id',$post['k'])->orWhere('musteri_id',0)
					->where('bolge_id',$bolge_id)->orWhere('bolge_id',0)
					->where('firma_id',\Session::get('firma'))->orderBy('tip','DESC')->take(1)->pluck('fiyat');	
				}else{
					$fiyat=\DB::table('urun_fiyat')
					->where('urun_id',$post['u'])->orWhere('urun_id',0)
					->where('musteri_id',$post['k'])->orWhere('musteri_id',0)
					->where('firma_id',\Session::get('firma'))->orderBy('tip','DESC')->take(1)->pluck('fiyat');						
				}
			}
			
			if(!isset($fiyat)){
				$fiyat=\DB::table('urun')->find($post['u'])->fiyat;
			}
			return $fiyat*1;
		}
	}
	public function postCreate(){
		
		 $post=\Input::all();
		 
		 $valid=[
            'musteri' => 'required|numeric',
			'tipi' => 'required',
			'tarih' => 'required',
			'durum' => 'required',
			'aciklama' => 'max:255',
         ];
		 if($post['tipi']=='SATIS'){
			 $valid=[
			 'urun' => 'required|numeric',
			 'miktar' => 'required|numeric',
			 'fiyat' => 'required|numeric',
			 ];
			 
		 }else{
			 $post['miktar']=0;$post['fiyat']=0;$post['urun_id']=0;
		 }
		 $validator =  \Validator::make($post, $valid);

        if ($validator->fails()) {
            return \Redirect::to('/transactions/')
			->withErrors($validator)
			->withInput(\Input::all());
        }else{
			
			if(\Auth::user()->tip!=0){
				$post['durum']=1;
			}
			
			
			if($post['tipi']=='ODEME' || $post['tipi']=='MASRAF' || $post['tipi']=='TAHSILAT'){
				$post['tutar']=$post['tutar']*-1;
			}
			
			$db=array(
			'musteri_id'=>$post['musteri'],
			'firma_id'=>\Session::get('firma'),
			'tip'=>$post['tipi'],
			'tarih'=>date('Y-m-d',strtotime($post['tarih'])).' '.date('H:i:s'),
			'aciklama'=>$post['aciklama'],
			'urun_id'=>$post['urun'] ,
			'miktar'=>$post['miktar'],
			'fiyat'=>$post['fiyat'],
			'tutar'=>$post['tutar'],
			'durum'=>$post['durum'],
			'user_id'=>\Auth::id()
			);
			
			if(isset($post['id']) && is_numeric($post['id'])){
				\Session::put('success','İşlem kaydı güncellendi.');
				\DB::table('hesap')->where('id',$post['id'])->where('firma_id',\Session::get('firma'))->update($db);
			}else{
				\Session::put('success','İşlem kaydı başarıyla oluşturdu.');
				\DB::table('hesap')->insert($db);
			}
			return \Redirect::to('/transactions/');
		}		
	}
}