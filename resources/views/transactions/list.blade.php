<?php $Ica = new \App\Ica; ?>
@extends('layouts.master')
@section('content')
<section class="content-header">
          <h1>
            Hesap Hareketleri
            <small>hareketlerde arama yapabilirsiniz.</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Anasayfa</a></li>
            <li class="active"><a href="#">Hareketler Listesi</a></li>
          </ol>
        </section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box box-primary">
	<div class="box-header">
	  <h3 class="box-title">Hareketler</h3>
	</div><!-- /.box-header -->
	<!-- form start -->
	  <div class="box-body">
	  @if($type=='sales')
		  {!!$Ica->DbTableHtml('hesaplar','ID,Tarih,Müşteri,Açıklama,Miktar,Tutar,İşlem','30,,75,75',true)!!}
	  @else
		  {!!$Ica->DbTableHtml('hesaplar','ID,Tarih,Tip,Müşteri,Açıklama,Tutar,İşlem','30,,75,75',true)!!}
	  @endif
	  </div><!-- /.box-body -->
	  <div class="box-footer">
	  </div>
  </div><!-- /.box -->
</section><!-- /.content -->
@endsection

<?php
    $opt['cClass']=',,,';
	$opt['filter'][0]='<input type="hidden">';
	$opt['filter'][1]='<input type="hidden">';
	$opt['filter'][2]=\Form::select('',['SATIS'=>'Satış','ODEME'=>'Ödeme','TAHSILAT'=>'Tahsilat','TRANSFER'=>'Transfer','MASRAF'=>'Masraf'],'',['class'=>'form-control']);
	$opt['filter'][3]=\Form::select('',\DB::table('users')->where('firma_id',\Session::get('firma'))->orderBy('name','ASC')->lists('name','id'),'',['class'=>'form-control']);;
	//$opt['filter'][4]='<input type="hidden">';
	$opt['filter'][5]='<input type="hidden">';
	$opt['filter'][6]='<input type="hidden">';
    $opt['dom']='"dom": \'<"top">rt<"bottom"p><"clear">\',';
?>
@section('js')
<script>
jQuery(document).ready(function() {
	@if($type=='sales')
		{!!$Ica->DbTableJs('hesaplar',URL::to('/data/hesaplar/'.$type),'id,tarih,musteri_id,aciklama,miktar,tutar,islem',$opt)!!}
	@else
		{!!$Ica->DbTableJs('hesaplar',URL::to('/data/hesaplar/'.$type),'id,tarih,tip,musteri_id,aciklama,tutar,islem',$opt)!!}
	@endif
});
</script>
@stop