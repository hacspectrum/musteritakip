<?php namespace App\Http\Controllers;

class ReportsController extends Controller
{
    public function getSales(){
			return view('reports.sales');
	}
	public function getPayments(){
			return view('reports.payments');
	}
	public function postSales(){
			$post=\Input::all();
			$report=\DB::table('hesap')->select(\DB::raw('musteri_id,miktar,urun_id,aciklama,tutar,tarih,tip'))->where('firma_id',\Session::get('firma'))->where('tip','SATIS');
			if(isset($post['urun']) && is_numeric($post['urun'])){
				$report=$report->where('urun_id',$post['urun']);
			}
			if(isset($post['musteri']) && is_numeric($post['musteri'])){
				$report=$report->where('musteri_id',$post['musteri']);
			}
			if(isset($post['kullanici']) && is_numeric($post['kullanici'])){
				$report=$report->where('user_id',$post['kullanici']);
			}
			if(isset($post['baslangic']) && isset($post['bitis'])){
				$report=$report->where('tarih','>=',date('Y-m-d',strtotime($post['baslangic'])))->where('tarih','<=',date('Y-m-d',strtotime($post['bitis'])));
			}
			if(isset($post['grupla'])){
				if($post['grupla']=='urun'){
					$report=$report->groupBy('urun_id');
				}elseif($post['grupla']=='musteri'){
					$report=$report->groupBy('musteri_id');
				}
			}
			if(isset($post['sirala'])){
				if($post['sirala']=='tarihasc')
					$report=$report->orderBy('tarih','ASC');
				elseif($post['sirala']=='tarihdesc')
					$report=$report->orderBy('tarih','DESC');
				elseif($post['sirala']=='tutarasc')
					$report=$report->orderBy('tutar','ASC');
				elseif($post['sirala']=='tutardesc')
					$report=$report->orderBy('tutar','DESC');
			}
			$report=$report->get();

			return view('reports.sales',compact('report'));
	}
	public function postPayments(){
		$post=\Input::all();
			$report=\DB::table('hesap')->select(\DB::raw('musteri_id,urun_id,aciklama,tutar,tarih,tip'))
				->where('firma_id',\Session::get('firma'))
				->whereIn('tip',['TAHSILAT','TRANSTER','ODEME','MASRAF']);
			if(isset($post['musteri']) && is_numeric($post['musteri'])){
				$report=$report->where('musteri_id',$post['musteri']);
			}
			if(isset($post['kullanici']) && is_numeric($post['kullanici'])){
				$report=$report->where('user_id',$post['kullanici']);
			}
			if(isset($post['baslangic']) && isset($post['bitis'])){
				$report=$report->where('tarih','>=',date('Y-m-d',strtotime($post['baslangic'])))->where('tarih','<=',date('Y-m-d',strtotime($post['bitis'])));
			}
			if(isset($post['sirala'])){
				if($post['sirala']=='tarihasc')
					$report=$report->orderBy('tarih','ASC');
				elseif($post['sirala']=='tarihdesc')
					$report=$report->orderBy('tarih','DESC');
				elseif($post['sirala']=='tutarasc')
					$report=$report->orderBy('tutar','ASC');
				elseif($post['sirala']=='tutardesc')
					$report=$report->orderBy('tutar','DESC');
			}
			$report=$report->get();
			return view('reports.payments',compact('report'));
	}

}