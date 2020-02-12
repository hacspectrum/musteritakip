<?php

namespace App;

class ica {
    /*
     * Upload Fonksiyonu
     * 
     * Array olarak dışardan değer alabilir
     * name= input name 'i yoksa file olarak default alır
     * folder= public altında atılacak klasör default upload alır
     * filename= dosya ismi başına istediğiniz bir ek kullanabilirsiniz yoksa random olarak 6 karakter alır
     * type= picture,file olarak type göre filtre yapabilirsiniz.
     * 
     */
	
	 
	public static function csv_export($table)
	{
		$output='';
		foreach ($table as $row) {
			$output.=implode(";",$row)."\n";
		}
		$headers = array(
			'Content-Encoding' => 'UTF-8',
			'Content-Type' => 'text/csv;charset=UTF-8',
			'Content-Disposition' => 'attachment; filename="Export.csv"',
		);
		return Response::make("\xEF\xBB\xBF".rtrim($output, "\n"), 200, $headers);
	}

    public static function excel($data){

        $file=$data['file'];
        $type=pathinfo($file);
        $path=public_path().'/excel/'.$file;

        switch($type['extension']){

            case 'xls':
                error_reporting(0);
                $sayfa=0;
                @require_once(public_path().'/include/excel_reader2.php');
                $data = new Spreadsheet_Excel_Reader($path);
                $excel=$data->sheets[0]['cells'];
                $sutunlar=$excel[$sayfa]['cells'][1];
                $sayfalar=$data->boundsheets;
                break;
            case 'xlsx':
                $sayfa=1;
                @include(public_path().'/include/simplexlsx.class.php');
                $getWorksheetName = array();
                $data = new SimpleXLSX($path);
                $sayfalar = $data->getWorksheetName();
                $sutunlar=$data->rows($sayfa);
                $excel=$sutunlar[1];
                break;

        }

        return $v=array('tip'=>$type['extension'],'sutun'=>$sutunlar,'data'=>$excel,'sayfa'=>$sayfalar);

    }
	
	public static function upload($data){
        
        if(isset($data['name'])){
            $file = \Input::file($data['name']);
        }else $file = \Input::file('file');
        
        
        if(isset($data['folder'])){
            $destinationPath = public_path() . "/".$data['folder']."/";
        }else $destinationPath = public_path() . "/upload/";
        
        if(isset($data['filename'])){
            $f=explode('.',$file->getClientOriginalName());
            $filename = $data['filename'].'.'.$f[1];
        }else $filename = str_random(6) . '_' . $file->getClientOriginalName();
        
        
        
        $filetype = $file->getClientMimeType();
        $file_types = [
            'application/octet-stream', // txt etc
            'application/msword', // doc
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', //docx
            'application/vnd.ms-excel', // xls
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // xlsx
            'application/pdf', // pdf
            'image/jpeg',
            'image/png',
            'image/gif',
        ];
        $picture_types=array("image/jpeg","image/png","image/gif");
        
        
        if(isset($data['type'])){
            
            // Dosya Tipi Kontrol Ediliyor
            if($data['type']=='file'){
                if(!in_array($filetype,$file_types)){
                    return array('status'=>0,'desc'=>'Sadece XLS veya XLSX formatındaki dosyaları destekler','type'=>$filetype,'file'=>$file->getClientOriginalName());
                }
            }elseif($data['type']=='picture'){
                if(!in_array($filetype,$picture_types)){
                    return array('status'=>0,'desc'=>'Sadece resim formatındaki dosyaları destekler','type'=>$filetype,'file'=>$file->getClientOriginalName());
                }
            }
            
        }

        $uploadSuccess = $file->move($destinationPath, $filename);

        if ($uploadSuccess) {
            return array('status'=>1,'desc'=>$uploadSuccess,'type'=>$filetype,'file'=>$filename);
        }else{
            return array('status'=>0,'desc'=>$uploadSuccess,'type'=>$filetype,'file'=>$file->getClientOriginalName());
        }
        
    }
    
    
    public static function rakam($deger){
        $snc=preg_replace("/[^0-9]/","",$deger);
        return $snc;
    }
    
    public static function gsm($gsm,$d=false) {
        $snc = false;
        if (preg_match('/^[0-9]*$/', ($gsm)) && strlen($gsm) == 10 && substr($gsm, 0, 1) == '5') {
            $snc = true;
        }
		if($d){
			$gsm=preg_replace('/\D/',' ',$gsm);
			$gsm=str_replace(' ','',$gsm);
			if(strlen($gsm)==10){
				return $gsm;
			}elseif(strlen($gsm)==11 && substr($gsm,0,1)==0){
				return substr($gsm,1,10);
			}
		}
        return $snc;
    }
    
    
    public static function kisalt($mesaj, $boy = 30) {
        $bosluk = strpos($mesaj, ' ');
        $uzunluk = strlen($mesaj);
        if ($boy > $bosluk) {

            $bosluk_yeni = strpos(substr($mesaj, $bosluk, $uzunluk), ' ');
            if ($bosluk_yeni == 0) {
                $msj = substr($mesaj, $bosluk, $uzunluk) . '...';
            } else {
                $msj = substr($mesaj, 0, $bosluk_yeni) . '...';
            }
        } else
            $msj = substr($mesaj, $bosluk, $uzunluk) . '...';
        return $msj;
    }

    public static function temizle($msj) {
        # Türkçe Mesaj ise;
        if(Input::exists('inputTurkce')){
            return $msj;
        }
        $turkce = array("ş", "Ş", "ı", "ü", "Ü", "ö", "Ö", "ç", "Ç", "ş", "Ş", "ı", "ğ", "Ğ", "İ", "ö", "Ö", "Ç", "ç", "ü", "Ü");
        $duzgun = array("s", "S", "i", "u", "U", "o", "O", "c", "C", "s", "S", "i", "g", "G", "I", "o", "O", "C", "c", "u", "U");
        $tr1 = str_replace($turkce, $duzgun, $msj);
        $tr1 = preg_replace("@[^a-z0-9\-_.!\'şıüğçİŞĞÜÇ]+@i", " ", $tr1);
        return $tr1;
    }

    public static function git($url, $array = array()) {
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        if (isset($array['data'])) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $array['data']);
        }
        if (isset($array['xml']))
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120 );
	
        $output = @curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if(isset($array['data'])){
            $data = $array['data'];
        }else $data=$url;

        # Değişken içini temizle
        $array = array();

        if(curl_errno($ch)) {
            $desc = curl_error($ch);
        }else $desc='';

        if ($status == 200) {
            $array[] = array('snc' => $output, 'status' => 1, 'desc' => '');
        } else
            $array[] = array('snc' => $output, 'code' => $status, 'desc' => $desc);

        curl_close($ch);

        DB::table('log')->insert(array('pr1' => $output, 'pr2' => $data));

        return $array;
    }

    # Sms Sitesi Kredi Bilgileri

    
	public static function configset($yol,$deger,$sabit=''){
		$getir=Config::get($yol,$sabit);
		return $getir[urldecode($deger)];
	}
	
	public static function DbTableHtml($name,$columns,$thwidth='',$flt=true,$opt=array()){
        isset($opt['class']) ?:$opt['class']="table table-striped table-bordered table-hover";
        isset($opt['style']) ?:$opt['style']="";
        isset($opt['thclass'])?$thclass=explode(',',$opt['thclass']):$thclass=array();
        isset($opt['thstyle'])?$thstyle=explode(',',$opt['thstyle']):$thstyle=array();
        isset($thwidth)?$width=explode(',',$thwidth):$width=array();
        $kolonlar=explode(',',$columns);
        foreach ($kolonlar as $id=>$kolon){
            $kx='<th ';
            if ((isset($thclass[$id])) && ($thclass[$id]!="")) $kx.=' class="'.$thclass[$id].'"';
            if ((isset($thstyle[$id])) && ($thstyle[$id]!="")) $kx.=' style="'.$thstyle[$id].'"';
            if ((isset($width[$id])) && ($width[$id]!="")) $kx.=' width="'.$width[$id].'"';
            $kx.='>'.$kolon.'</th>';
            $kolonx[]=$kx;
        };
        $flt ? $flt='<thead class="filters"><tr>'.implode("\n",$kolonx).'</tr></thead>' : $flt='';
        return '<table id="'.$name.'" class="'.$opt['class'].'"><thead><tr>'.implode("\n",$kolonx).'</tr></thead>'.$flt.'<tbody></tbody></table>';
    }
	
    public static function DbTableJs($name,$ajax,$columns,$opt=array()){
        isset($opt['lengthMenu']) ?:$opt['lengthMenu']="Görüntülenen _MENU_ Kayıt Sayısı";
        isset($opt['zeroRecords']) ?:$opt['zeroRecords']="Üzgünüm uygun kayıt bulunamadı!";
        isset($opt['info'])        ?:$opt['info']="Görüntülenen Sayfa _PAGE_ ile _PAGES_";
        isset($opt['infoEmpty'])   ?:$opt['infoEmpty']="Kayıt Bulunamadı!";
        isset($opt['infoFiltered'])?:$opt['infoFiltered']="(filtrelenen _MAX_ toplam kayıt)";
        isset($opt['decimal'])     ?:$opt['decimal']=",";
        isset($opt['thousands'])   ?:$opt['thousands']=".";
        isset($opt['processing'])  ?:$opt['processing']="true";
        isset($opt['serverSide'])  ?:$opt['serverSide']="true";
        isset($opt['order'])       ?:$opt['order']="[[0,'asc']]";
		isset($opt['dom'])       ?:$opt['dom']='';
        isset($opt['cName'])?$cName=explode(',',$opt['cName']):$cName=array();
        isset($opt['cTitle'])?$cTitle=explode(',',$opt['cTitle']):$cTitle=array();
        isset($opt['cClass'])?$cClass=explode(',',$opt['cClass']):$cClass=array();
        isset($opt['cOrder'])?$cOrder=explode(',',$opt['cOrder']):$cOrder=array();
        isset($opt['cSearch'])?$cSearch=explode(',',$opt['cSearch']):$cSearch=array();
        isset($opt['filters'])?$opt['filters']=false :$opt['filters']=true;
        $kolonlar=explode(',',$columns);
        foreach ($kolonlar as $id=>$kolon){
            $kx='{ "data" : "'.$kolon.'","name" : "'.$kolon.'" ';
            if ((isset($cName[$id])) && ($cName[$id]!="")) $kx.=',"name":"'.$cName[$id].'" ';
            if ((isset($cTitle[$id])) && ($cTitle[$id]!="")) $kx.=',"title":"'.$cTitle[$id].'" ';
            if ((isset($cClass[$id])) && ($cClass[$id]!="")) $kx.=',"class":"'.$cClass[$id].'" ';
            if ((isset($cOrder[$id])) && (($cOrder[$id]=="0") ||($cOrder[$id]=="false"))) $kx.=',"orderable":false'; else $kx.=',"orderable":true';
            if ((isset($cSearch[$id])) && (($cSearch[$id]=="0") ||($cSearch[$id]=="false"))) $kx.=',"searchable":false'; else $kx.=',"searchable":true';
            $kx.='}
            ';
            $kolonx[]=$kx;
        }
        if ($opt['filters']){
            $kz='$("#'.$name.' .filters th").each( function () {
                    var title = $("#'.$name.' .filters th").eq( $(this).index()).text();'."\n";
            if (isset($opt['filter'])){
                //Eğer filitre sahaları özelleştirildiyse
                foreach ($kolonlar as $id=>$kolon){
                    if (isset($opt['filter'][$id]))  $kz.='if ($(this).index() == '.$id.') { $(this).html(\''.$opt['filter'][$id].'\');}'."\n".' else ';
                }
                $kz.='{ $(this).html(\'<input type="text" class="form-control"  placeholder="\'+title+\' Arama" />\'); }'."\n";
            } else {
                $kz.='$(this).html(\'<input type="text" class="form-control"  placeholder="\'+title+\' Arama" />\');'."\n";
            }
            $kz.='});
            table'.$name.'.columns().eq( 0 ).each( function ( colIdx ) {
                $(\'input,select\', $(\'#'.$name.' .filters th\')[colIdx] ).on(\'keyup change\', function () {
                    table'.$name.'
                    .column( colIdx )
                    .search( this.value )
                    .draw();
                } );
            } );';
        } else $kz='';
        $snc='var table'.$name.' = $("#'.$name.'").DataTable({
			'.$opt['dom'].'
			responsive: true,
            "language": {"lengthMenu": "'.$opt['lengthMenu'].'","zeroRecords": "'.$opt['zeroRecords'].'",
                "info": "'.$opt['info'].'","infoEmpty": "'.$opt['infoEmpty'].'",
                "infoFiltered": "'.$opt['infoFiltered'].'","decimal": "'.$opt['decimal'].'","thousands": "'.$opt['thousands'].'"
            },"processing": '.$opt['processing'].',"serverSide": '.$opt['serverSide'].',
            "ajax": "'.$ajax.'","order": '.$opt['order'].',
            "columnDefs": [{"targets": "_all","defaultContent": "Veri Yok" }],
            "columns":['.implode(',',$kolonx).']});'.$kz;
        return $snc;
    }
	
	public static function simdi($time_ago)
	{
		$time_ago = strtotime($time_ago);
		$cur_time   = time();
		$time_elapsed   = $cur_time - $time_ago;
		$seconds    = $time_elapsed ;
		$minutes    = round($time_elapsed / 60 );
		$hours      = round($time_elapsed / 3600);
		$days       = round($time_elapsed / 86400 );
		$weeks      = round($time_elapsed / 604800);
		$months     = round($time_elapsed / 2600640 );
		$years      = round($time_elapsed / 31207680 );
		// Seconds
		if($seconds <= 60){
			return "hemen şimdi";
		}
		//Minutes
		else if($minutes <=60){
			if($minutes==1){
				return "1 dakika önce";
			}
			else{
				return "$minutes dakika önce";
			}
		}
		//Hours
		else if($hours <=24){
			if($hours==1){
				return "an hour ago";
			}else{
				return "$hours saat önce";
			}
		}
		//Days
		else if($days <= 7){
			if($days==1){
				return "dün";
			}else{
				return "$days gün önce";
			}
		}
		//Weeks
		else if($weeks <= 4.3){
			if($weeks==1){
				return "bir hafta önce";
			}else{
				return "$weeks haftalar önce";
			}
		}
		//Months
		else if($months <=12){
			if($months==1){
				return "bir ay önce";
			}else{
				return "$months aylar önce";
			}
		}
		//Years
		else{
			if($years==1){
				return "bir yıl önce";
			}else{
				return "$years yıllar önce";
			}
		}
	}

    public static function d_img($file,$folder){
		if(file_exists(public_path()."/$folder/".$file)){
			return url('/')."/$folder/".$file;
		}else{
			return url('/')."/$folder/default.jpg";
		}
	}
	
	public static function ozelfiyat($urunid,$musteri_id=0){
		if($musteri_id==0) $musteri_id=\Auth::id();
		$bolge_id=\DB::table('users')->find(\Auth::id())->bolge_id;
		if($bolge_id>0){
			$fiyat=\DB::table('urun_fiyat')
			->whereIn('musteri_id',[$musteri_id,0])
			->whereIn('bolge_id',[$bolge_id,0])
			->where('firma_id',\Session::get('firma'))
			->where('urun_id',$urunid)
			->orderBy('tip','DESC')->take(1)->pluck('fiyat');	
		}else{
			$fiyat=\DB::table('urun_fiyat')
			->whereIn('musteri_id',[$musteri_id,0])
			->where('firma_id',\Session::get('firma'))
			->where('urun_id',$urunid)
			->orderBy('tip','DESC')->take(1)->pluck('fiyat');							
		}
		return $fiyat;
	}
}
