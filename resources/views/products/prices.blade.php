@extends('layouts.master')
@section('content')
<section class="content-header">
          <h1>
            Özel Fiyat
            <small>Lütfen formu eksiksiz doldurunuz!</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Anasayfa</a></li>
            <li><a href="#" class="active">Özel Fiyat</a></li>
          </ol>
        </section>
<!-- Main content -->
<section class="content">
  
  <div class="box box-primary">
	<div class="box-header">
	  <h3 class="box-title">
	  @if(isset($product))
		{!!\DB::table('urun')->where('firma_id',Session::get('firma'))->where('id',$product->id)->pluck('urunadi')!!} Özel Fiyat</h3>
	  @endif
	</div><!-- /.box-header -->
	<!-- form start -->
	<form role="form" action="/products/prices" method="post">
	{!! Form::hidden('id',Input::old('id',isset($prices) ? $prices->id : ''))!!}
	{!! Form::hidden('urun',Input::old('urun',isset($product) ? $product->id : ''))!!}
	{!! csrf_field() !!}
	  <div class="box-body">
		<div class="form-group">
		  <label for="exampleInputEmail1">Müşteri</label>
		  {!! Form::select('musteri',array(''=>'Müşteri Seçiniz')+DB::table('users')->where('firma_id',Session::get('firma'))->lists('name','id'),isset($prices) ? $prices->musteri_id : '',['class'=>'form-control']) !!}
		</div>
		<div class="form-group">
		  <label for="exampleInputEmail1">Fiyat</label>
		  {!! Form::number('fiyat',Input::old('fiyat',isset($product) ? $product->fiyat : ''),['placeholder'=>'Ürün Fiyat Giriniz','class'=>'form-control'])!!}
		</div>
	  </div><!-- /.box-body -->
	  <div class="box-footer">
		<button type="submit" class="btn btn-primary">Kaydet</button>
	  </div>
	</form>
  </div><!-- /.box -->
</section><!-- /.content -->
@endsection