<?php $Ica = new \App\Ica; ?>
@extends('layouts.master')
@section('content')
<section class="content-header">
          <h1>
            Müşteri Listesi
            <small>müşterilerilerinizde arama yapabilirsiniz.</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Anasayfa</a></li>
            <li class="active"><a href="#">Müşteri Listesi</a></li>
          </ol>
        </section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box box-primary">
	<div class="box-header">
	  <h3 class="box-title">Müşteriler</h3>
	</div><!-- /.box-header -->
	<!-- form start -->
	  <div class="box-body">
		{!!$Ica->DbTableHtml('musteriler','ID,Bölge,Ad,Bakiye,İşlem','30,,,75,',true)!!}
	  </div><!-- /.box-body -->

	  <div class="box-footer">
		
	  </div>
	
  </div><!-- /.box -->
</section><!-- /.content -->
@endsection

<?php
    $opt['cClass']=',,,';
	$opt['filter'][0]='<input type="hidden">';
	$opt['filter'][1]=\Form::select('',\DB::table('bolge')->where('firma_id',\Session::get('firma'))->orderBy('bolgeadi','ASC')->lists('bolgeadi','id'),'',['class'=>'form-control']);
	//$opt['filter'][2]='<input type="hidden">';
	$opt['filter'][3]='<input type="hidden">';
	$opt['filter'][4]='<input type="hidden">';
    $opt['dom']='"dom": \'<"top">rt<"bottom"p><"clear">\',';
?>
@section('js')
<script>
jQuery(document).ready(function() {
	{!!$Ica->DbTableJs('musteriler',URL::to('/data/musteriler'),'id,bolge_id,name,bakiye,islem',$opt)!!}
});
</script>
@stop