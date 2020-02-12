<?php namespace App\Http\Controllers;

class CompanyController extends Controller
{
    public function getIndex(){
		return view('register');
	}
	
	public function postAdd(){
		
		$post=\Input::all();
		$validator =  \Validator::make($post, [
            'yetkili' => 'required|max:50',
			'firma' => 'required|max:50',
            'email' => 'required|email|unique:firma',
			'telefon' => 'required|numeric|min:10',
			'uyetip' => 'required|numeric',
        ],
		[
			'firma.required' => 'Lütfen Firma Adını Giriniz!',
			'firma.max' => 'Lütfen Firma Adını Maksimum 50 karakteri geçirmeyiniz!',
			'yetkili.required' => 'Lütfen Yetkili Kişi Ad ve Soyadınızı Giriniz!',
			'yetkili.max' => 'Lütfen Yetkili Kişi Ad ve Soyadınız Maksimum 50 karakteri geçirmeyiniz!',
			'email.required' => 'Lütfen Email adresinizi boş geçmeyiniz!',
			'email.email' => 'Lütfen Email adresinizi doğru giriniz!',
			'email.unique' => 'Aynı Email adresi sistemimizde kayıtlıdır. Lütfen bizimle iletişime geçiniz!',
			'email.required' => 'Lütfen Email adresinizi boş geçmeyiniz!',
			'telefon.required' => 'Lütfen Gsm numaranızı giriniz!',
			'telefon.numeric' => 'Lütfen Gsm numaranızı rakamlardan giriniz!',
			'uyetip.required' => 'Lütfen bir üyelik tipi seçiniz.',
			'uyetip.numeric' => 'Lütfen doğru bir üyelik tipi seçiniz.',
		]);

        if ($validator->fails()) {
            return \Redirect::to('/company')
			->withErrors($validator)
			->withInput(\Input::all());
        }else
		{
			$zaman=\DB::table('ozellik')->find($post['uyetip'])->deger;
			$zaman=strtotime('now')+($zaman*86400);
			$array=array('firmaadi'=>$post['firma'],'yetkili'=>$post['yetkili'],'email'=>$post['email'],'telefon'=>$post['telefon'],'bitis_tarihi'=>$zaman);
			if(\DB::table('firma')->insert($array)){
				return \Redirect::to('/company')->with('success','Firma kaydınız başarıyla gerçekleşti. Lütfen tanımlı email adresinizi kontrol ediniz...');
			}
		}
		
	}
	
}