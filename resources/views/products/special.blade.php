<?php $Ica = new \App\Ica; ?>
@extends('layouts.master')
@section('content')
<section class="content-header">
          <h1>
            Özel Fiyatlar
            <small>özel fiyatlarda arama yapabilirsiniz.</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Anasayfa</a></li>
            <li class="active"><a href="#">Özel Fiyatlar</a></li>
          </ol>
        </section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box box-primary">
	<div class="box-header">
	  <h3 class="box-title">Özel Fiyatlar</h3>
	</div><!-- /.box-header -->
	<!-- form start -->
	  <div class="box-body">
		{!!$Ica->DbTableHtml('ozelfiyat','ID,Müşteri,Ürün,Fiyat','30,,,125,50',true)!!}
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
	$opt['filter'][2]='<input type="hidden">';
	$opt['filter'][3]='<input type="hidden">';
	$opt['filter'][4]='<input type="hidden">';
    //$opt['dom']='"dom": \'<"top">rt<"bottom"p><"clear">\',';
?>
@section('js')
<script>
jQuery(document).ready(function() {
	{!!$Ica->DbTableJs('ozelfiyat',URL::to('/data/ozelfiyat'),'id,musteri_id,urun_id,fiyat',$opt)!!}
});
</script>
@stop