<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Post;
use App\User;
use Datatables;
use Illuminate\Http\Request;
use DB;

class DatatableController  extends Controller {
    
	public function getMusteriler(){
        
		$veri = DB::table('users')->select(['id','bolge_id','name','gsm'])
            ->where('firma_id',\Session::get('firma'))->whereIn('durum',array(0,1));
        return Datatables::of($veri)
			->addColumn('islem', function ($users) {
                return '
				<a href="'.\URL::to('customers/edit/'.$users->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Düzenle</a> 
				<a href="'.\URL::to('transactions/add/order/'.$users->id).'" class="btn btn-xs btn-danger"><i class="fa fa-shopping-cart"></i> Sipariş</a> 
				<a href="'.\URL::to('transactions/add/payment/'.$users->id).'" class="btn btn-xs btn-success"><i class="fa fa-money"></i> Ödeme</a> 
				<a href="'.\URL::to('customers/statement/'.$users->id).'" class="btn btn-xs btn-info"><i class="fa fa-reorder"></i> Hesap Özeti</a>
				<a href="'.\URL::to('customers/destory/'.$users->id).'" class="btn btn-xs btn-danger"><i class="fa fa-remove"></i> Sil</a>
				';
            })
			->editColumn('bolge_id', function ($users) {
                return \DB::table('bolge')->where('firma_id',\Session::get('firma'))->where('id',$users->bolge_id)->pluck('bolgeadi');
            })
			->addColumn('bakiye', function ($users) {
                return \DB::table('hesap')->select('tutar')->where('firma_id',\Session::get('firma'))->where('musteri_id',$users->id)->where('durum',1)->sum('tutar');
            })
			->make(true);
    }
	public function getSiparisler(){
    	// Müşteri İse
		if(\Auth::user()->tip==0){
			$veri = DB::table('siparis')->select(['id','musteri_id','urun_id','miktar','fiyat','tutar','aciklama','durum'])
			->where('musteri_id',\Auth::id())
			->where('firma_id',\Session::get('firma'));
		}else{
		// Yetkili İse
			$veri = DB::table('siparis')->select(['id','musteri_id','urun_id','miktar','fiyat','tutar','aciklama','durum'])
			->where('firma_id',\Session::get('firma'));
			
		}	
        return Datatables::of($veri)
		
			->editColumn('musteri_id', function ($product) {
                return DB::table('users')->find($product->musteri_id)->name;
            })
			->editColumn('urun_id', function ($product) {
                return DB::table('urun')->find($product->urun_id)->urunadi;
            })
			->addColumn('islem', function ($product) {
				if($product->durum==0){
					$d='<a href="'.\URL::to('orders/edit/'.$product->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Düzenle</a> ';
					if(\Auth::user()->tip!=0){
						$d.='<a href="'.\URL::to('orders/confirm/1/'.$product->id).'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-fa-check"></i> Onayla</a> ';
						$d.='<a href="'.\URL::to('orders/confirm/2/'.$product->id).'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-fa-remove"></i> İptal</a>';
					}
					return $d;
				}
				return ''; 				
				
            })
			->editColumn('durum', function ($product) {
				$array=[0=>'Beklemede',1=>'Onaylandı',2=>'İptal'];
                return $array[$product->durum];
            })
			->make(true);
    }
	public function getUrunler(){
        
		$veri = DB::table('urun')->select(['id','urunadi','fiyat'])
            ->where('firma_id',\Session::get('firma'));
        return Datatables::of($veri)
			->addColumn('islem', function ($product) {
                return '<a href="'.\URL::to('products/edit/'.$product->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Düzenle</a>
				<a href="'.\URL::to('products/prices/'.$product->id).'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-edit"></i> Özel Fiyat</a>';
            })
			->make(true);
    }
	public function getBolgeler(){
        
		$veri = DB::table('bolge')->select(['id','bolgeadi','birimfiyat'])
            ->where('firma_id',\Session::get('firma'));
        return Datatables::of($veri)
			->addColumn('islem', function ($product) {
                return '<a href="'.\URL::to('areas/edit/'.$product->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Düzenle</a>';
            })
			->make(true);
    }
	public function getHesaplar($type='sales'){
		$array=['sales'=>'SATIS','payment'=>'ODEME','expense'=>'TAHSILAT','transfer'=>'TRANSFER','expense'=>'MASRAF'];
        
		if(\Auth::user()->tip==0){
			if($type=='sales'){
				$veri = DB::table('hesap')->select(['id','tarih','musteri_id','aciklama','miktar','tutar'])->orderBy('tarih','DESC')
				->where('firma_id',\Session::get('firma'))->where('musteri_id',\Auth::id())->where('tip',$array[$type]);
			}else{
				$veri = DB::table('hesap')->select(['id','tarih','tip','musteri_id','aciklama','tutar'])->orderBy('tarih','DESC')
				->where('firma_id',\Session::get('firma'))->where('musteri_id',\Auth::id())->where('tip',$array[$type]);
			} 			
		}else{
			if($type=='sales'){
			$veri = DB::table('hesap')->select(['id','tarih','musteri_id','aciklama','miktar','tutar'])->orderBy('tarih','DESC')
			->where('firma_id',\Session::get('firma'))->where('tip',$array[$type]);
			}else{
				$veri = DB::table('hesap')->select(['id','tarih','tip','musteri_id','aciklama','tutar'])->orderBy('tarih','DESC')
				->where('firma_id',\Session::get('firma'))->where('tip',$array[$type]);
			} 
		}
		
        return Datatables::of($veri)
			->addColumn('islem', function ($product) {
				if(\Auth::user()->tip==0) return '';
                return '<a href="'.\URL::to('transactions/edit/'.$product->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Düzenle</a>
				<a href="'.\URL::to('transactions/destory/'.$product->id).'" class="btn btn-xs btn-danger"><i class="fa fa-remove"></i> Sil</a>
				';
            })
			->editColumn('musteri_id', function ($product) {
                return @\DB::table('users')->select('name')->find($product->musteri_id)->name;
            })
			->editColumn('tutar', function ($product) {
                return @$product->tutar<0 ? '<font color=red>'.$product->tutar.'</font>' : $product->tutar;
            })
			->make(true);
    }
	public function getOzelfiyat(){
		$veri = DB::table('urun_fiyat')->select(['id','musteri_id','urun_id','fiyat'])->where('tip',2)
            ->where('firma_id',\Session::get('firma'));
        return Datatables::of($veri)
			->addColumn('islem', function ($product) {
                return '<a href="'.\URL::to('areas/edit/'.$product->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Düzenle</a>';
            })
			->editColumn('musteri_id', function ($product) {
                return \DB::table('users')->select('name')->where('id',$product->musteri_id)->pluck('name');
            })
			->editColumn('urun_id', function ($product) {
                return \DB::table('urun')->select('urunadi')->where('id',$product->urun_id)->pluck('urunadi');
            })
			->make(true);
    }
    
}