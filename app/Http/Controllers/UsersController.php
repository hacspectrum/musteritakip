<?php namespace App\Http\Controllers;

class UsersController extends Controller
{
    public function getIndex(){
		if (\Auth::check()) {
			return view('index');
		}else{
			return view('login');
		}
		return;
	}
	public function postLogin(){
		if (\Auth::attempt(['email' => \Input::get('email'), 'password' => bcrypt(\Input::get('password')),'durum'=>1])) {
            $user=\DB::table('users')->find(\Auth::id());
			\Session::put('firma',$user->firma_id);
			\Session::put('name',$user->name);
			\Session::put('firmaadi',\DB::table('firma')->find($user->firma_id)->firmaadi);
			return view('index');
        }
		return \Redirect::to('/');
	}
	public function getCreate(){
		$post=\Input::all();
		return \DB::table('users')->insert(array(
		'email'=>$post['email'],
		'password'=>bcrypt($post['password']),
		'created_at'=>date('Y-m-d H:i:s'),
		'updated_at'=>date('Y-m-d H:i:s'),
		'name'=>$post['name']
		));
	}
	public function postUpdate(){
		$post=\Input::all();
		
		$validator =  \Validator::make($post, [
            'name' => 'required|max:255',
            'password' => 'required|confirmed|min:6',
			'gsm' => 'required|numeric|min:10',
			'tel' => 'numeric|min:10',
        ]);

        if ($validator->fails()) {
            return \Redirect::to('/auth/profile')
                        ->withErrors($validator)
                        ->withInput(\Input::all());
        }else
		{
			$snc=\App\Ica::upload(array('folder'=>'dist/img/users','type'=>'picture','filename'=>md5(\Auth::id())));
			
			\DB::table('users')->where('id',\Auth::id())->update(array(
			'updated_at'=>date('Y-m-d H:i:s'),
			'name'=>$post['name'],
			'adres'=>$post['adres'],
			'tel'=>$post['tel'],
			'gsm'=>$post['gsm']
			));
		}
		return \Redirect::to('/auth/profile')->with('success','Profil bilgileriniz güncellendi.');
	}
	public function getLogout(){
		\Auth::logout();
		return \Redirect::to('/');
	}
	public function getProfile(){
		$user=\DB::table('users')->where('firma_id',\Session::get('firma'))->where('id',\Auth::id())->first();
		return view('profile',compact('user'));
	}
	public function getTodo($type='',$id=0){
		$post=\Input::all();
		if($type=='confirm'){
			\DB::table('gunluk')->where('firma_id',\Session::get('firma'))->where('id',$id)->update(array('durum'=>1,'updated_at'=>date('Y-m-d H:i:s')));
		}elseif($type=='destroy'){
			\DB::table('gunluk')->where('firma_id',\Session::get('firma'))->where('id',$id)->delete();
			return \Redirect::to('/auth/')->with('success','Günlük program silindi!');
		}
		return \Redirect::to('/auth/')->with('success','Günlük program yapıldı!');
	}
	public function postTodo(){
		$post=\Input::all();
		$validator =  \Validator::make($post, [
            'aciklama' => 'required|max:150',
        ]);
        if ($validator->fails()) {
            return \Redirect::to('/auth')
			->withErrors($validator)
			->withInput(\Input::all());
        }else{	
		
			if(\DB::table('gunluk')->insert(array(
				'firma_id'=> \Session::get('firma'),
				'user_id'=> \Auth::id(),
				'aciklama'=> $post['aciklama']))){
				return \Redirect::to('auth/')->with('success','Günlük Eklendi');
			}
		}
		return view('index');
	}
}