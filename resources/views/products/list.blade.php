<?php $Ica = new \App\Ica; ?>
@extends('layouts.master')
@section('content')
<section class="content-header">
          <h1>
            Ürün Listesi
            <small>ürünlerinizde arama yapabilirsiniz.</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Anasayfa</a></li>
            <li class="active"><a href="#">Ürün Listesi</a></li>
          </ol>
        </section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box box-primary">
	<div class="box-header">
	  <h3 class="box-title">Ürünler</h3>
	</div><!-- /.box-header -->
	<!-- form start -->
	  <div class="box-body">
		{!!$Ica->DbTableHtml('urun','ID,Ad,Fiyat,İşlem','30,75,,125',true)!!}
	  </div><!-- /.box-body -->

	  <div class="box-footer">
		
	  </div>
	
  </div><!-- /.box -->
</section><!-- /.content -->
@endsection

<?php
    $opt['cClass']=',,,';
	$opt['filter'][0]='<input type="hidden">';
	//$opt['filter'][1]='<input type="hidden">';
	$opt['filter'][2]='<input type="hidden">';
	$opt['filter'][3]='<input type="hidden">';
    $opt['dom']='"dom": \'<"top">rt<"bottom"p><"clear">\',';
?>
@section('js')
<script>
jQuery(document).ready(function() {
	{!!$Ica->DbTableJs('urun',URL::to('/data/urunler'),'id,urunadi,fiyat,islem',$opt)!!}
});
</script>
@stop