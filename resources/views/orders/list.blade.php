<?php $Ica = new \App\Ica; ?>
@extends('layouts.master')
@section('content')
<section class="content-header">
          <h1>
            Sipariş Listesi
            <small>Sipariş listenizde arama yapabilirsiniz.</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Anasayfa</a></li>
            <li class="active"><a href="#">Sipariş Listesi</a></li>
          </ol>
        </section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box box-primary">
	<div class="box-header">
	  <h3 class="box-title">Siparişler</h3>
	</div><!-- /.box-header -->
	<!-- form start -->
	  <div class="box-body">
		{!!$Ica->DbTableHtml('siparisler','ID,Müşteri,Ürün,Miktar,Fiyat,Toplam,Açıklama,Durum,İşlem','30,100,100,50,50,50,,50,150',true)!!}
	  </div><!-- /.box-body -->

	  <div class="box-footer">
		
	  </div>
	
  </div><!-- /.box -->
</section><!-- /.content -->
@endsection

<?php
    $opt['cClass']=',,,';
	$opt['filter'][0]='<input type="hidden">';
	$opt['filter'][1]=\Form::select('',\DB::table('users')->where('firma_id',\Session::get('firma'))->orderBy('name','ASC')->lists('name','id'),'',['class'=>'form-control']);
	$opt['filter'][2]=\Form::select('',\DB::table('urun')->where('firma_id',\Session::get('firma'))->orderBy('urunadi','ASC')->lists('urunadi','id'),'',['class'=>'form-control']);
	$opt['filter'][3]='<input type="hidden">';
	$opt['filter'][4]='<input type="hidden">';
	$opt['filter'][5]='<input type="hidden">';
	//$opt['filter'][6]='<input type="hidden">';
	$opt['filter'][7]=\Form::select('',[0=>'Beklemede',1=>'Onaylandı',2=>'İptal'],'',['class'=>'form-control']);
	$opt['filter'][8]='<input type="hidden">';
    $opt['dom']='"dom": \'<"top">rt<"bottom"p><"clear">\',';
?>
@section('js')
<script>
jQuery(document).ready(function() {
	{!!$Ica->DbTableJs('siparisler',URL::to('/data/siparisler'),'id,musteri_id,urun_id,miktar,fiyat,tutar,aciklama,durum,islem',$opt)!!}
});
</script>
@stop