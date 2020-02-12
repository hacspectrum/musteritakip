<?php namespace App\Http\Controllers;

class AreasController extends Controller
{
    public function getIndex(){
		return view('areas.new');
	}
	public function getEdit($id){
		$area=\DB::table('bolge')->where('firma_id',1)->where('id',$id)->first();
		return view('areas.new',compact('area'));
	}
	public function postCreate(){
		
		$post=\Input::all();
		
		 $validator =  \Validator::make($post, [
            'bolge' => 'required',
			'fiyat' => 'required|numeric',
			'urun' => 'required|numeric',
		]);

        if ($validator->fails()) {
            return \Redirect::to('/areas/')
                        ->withErrors($validator)
                        ->withInput(\Input::all());
        }else{
			
			$db=array(
			'bolgeadi'=>$post['bolge'],
			'urun_id'=>$post['urun'],
			'birimfiyat'=>$post['fiyat'],
			'firma_id'=>\Session::get('firma')
			);
			
			if(isset($post['id']) && is_numeric($post['id'])){
				\Session::put('success','Bölge kaydı güncellendi.');
				\DB::table('bolge')->where('id',$post['id'])->update($db);
				// Ürün Fiyat Tablosunu Güncelle
				\DB::table('urun_fiyat')->where('urun_id',$post['urun'])->where('bolge_id',$post['id'])->where('firma_id',\Session::get('firma'))->update(array('fiyat'=>$post['fiyat']));
			}else{
				\Session::put('success','Bölge kaydı başarıyla oluşturdu.');
				\DB::table('bolge')->insert($db);
				// Ürün Fiyat Tablosu Oluştur
				$id=\DB::table('bolge')->max('id');
				\DB::table('urun_fiyat')->insert(array('urun_id'=>$post['urun'],'tip'=>1,'fiyat'=>$post['fiyat'],'bolge_id'=>$id,'firma_id'=>\Session::get('firma')));
			}
			return \Redirect::to('/areas/');
		}		
	}
	public function getList(){
		return view('areas.list');
	}
}