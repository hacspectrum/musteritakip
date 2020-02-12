<?php namespace App\Http\Controllers;

class CustomersController extends Controller
{
    public function getIndex(){
		return view('customers.new');
	}
	public function getEdit($id){
		$user=\DB::table('users')->where('firma_id',\Session::get('firma'))->where('id',$id)->first();
		return view('customers.new',compact('user'));
	}
	public function postLogin(){
		if (\Auth::attempt(['email' => \Input::get('email'), 'password' => \Input::get('password')])) {
            return view('index');
        }
		return \Redirect::to('/');
	}
	public function getDestory($id){
		if(is_numeric($id) && \Auth::user()->tip==1){
			if(\DB::table('users')->where('firma_id',\Session::get('firma'))->where('id',$id)->where('tip',0)->update(array('durum'=>2))){
				return \Redirect::to('customers/list')->with('success','Müşteri kaydınız durdurulmuştur');
			}
		}
		return \Redirect::to('customers/list');
	}
	public function postCreate(){
		
		$post=\Input::all();
		
		if(isset($post['id']) && is_numeric($post['id'])){
			$validator =  \Validator::make($post, [
			'name' => 'required|max:255',
			'gsm' => 'required|numeric|min:10',
			'bolge' => 'numeric',
		]);
		}else{
			
			$array=[
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'gsm' => 'required|numeric|min:10',
			'bolge' => 'required|numeric',
			];
			
			if($post['password']!=''){
				$array['password']='required|confirmed|min:6';
			}
			
			$validator =  \Validator::make($post, $array);
		}
		 
        if ($validator->fails()) {
            return \Redirect::to('/customers/')
			->withErrors($validator)
			->withInput(\Input::all());
        }else{
			
			$db=array(
			'adres'=>$post['adres'],
			'tel'=>$post['tel'],
			'gsm'=>$post['gsm'],
			'name'=>$post['name'],
			'bolge_id'=>$post['bolge'],
			'firma_id'=>\Session::get('firma')
			);
			
			\Session::put('success','Müşteri kaydı başarıyla oluşturdu.');
			if(isset($post['id']) && is_numeric($post['id'])){
				if($post['password']!='') $db=array('password'=>bcrypt($post['password']));
				\DB::table('users')->where('firma_id',\Session::get('firma'))->where('id',$post['id'])->update($db);
			}else{
				$db['email']=$post['email'];
				$db['password']=bcrypt($post['password']);
				$db['created_at']=date('Y-m-d H:i:s');
				\DB::table('users')->insert($db);
			}
			return \Redirect::to('customers/list')->with('success','Müşteri kaydı güncellendi veya kaydedildi');
		}		
	}
	public function getList(){
		return view('customers.list');
	}
	public function getStatement($id=0){
		if(\Auth::user()->tip==0) $id=\Auth::id(); 
		$user=\DB::table('users')->where('firma_id',\Session::get('firma'))->where('id',$id)->first();
		$bakiye=\DB::table('hesap')->select('tutar')->where('firma_id',\Session::get('firma'))->where('musteri_id',$id)->where('durum',1)->sum('tutar');
		$veri = \DB::table('hesap')->select(['id','tarih','tip','aciklama','tutar'])
		->where('durum',1)
        ->where('firma_id',\Session::get('firma'))
		->where('musteri_id',$id)
		->orderBy('tarih','DESC')->take(30)->get();
		return view('customers.statement',compact('user','veri','bakiye'));
	}
}