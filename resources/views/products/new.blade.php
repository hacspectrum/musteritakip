@extends('layouts.master')
@section('content')
<section class="content-header">
          <h1>
            Yeni Ürün Kaydı
            <small>Lütfen formu eksiksiz doldurunuz!</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Anasayfa</a></li>
            <li><a href="#" class="active">Ürün Kayıt</a></li>
          </ol>
        </section>
<!-- Main content -->
<section class="content">
  
  <div class="box box-primary">
	<div class="box-header">
	  <h3 class="box-title">Ürün Kayıt</h3>
	</div><!-- /.box-header -->
	<!-- form start -->
	<form role="form" action="/products/create" method="post">
	{!! Form::hidden('id',isset($product) ? $product->id : '') !!}
	{!! csrf_field() !!}
	  <div class="box-body">
		<div class="form-group">
		  <label for="exampleInputEmail1">Ürün Adı</label>
		  {!! Form::text('urunadi',Input::old('urunadi',isset($product) ? $product->urunadi : ''),['placeholder'=>'Ürün Adı Giriniz','class'=>'form-control']) !!}
		</div>
		<div class="form-group">
		  <label for="exampleInputEmail1">Fiyat</label>
		  {!! Form::number('fiyat',Input::old('fiyat',isset($product) ? $product->fiyat : ''),['step'=>'0.01','placeholder'=>'Ürün Fiyat Giriniz','class'=>'form-control'])!!}
		</div>
		<div class="form-group">
		  <label for="exampleInputEmail1">Birim</label>
		  {!! Form::select('birim',array(''=>'Birim Seçiniz')+DB::table('ozellik')->where('grup','birim')->lists('ad','deger'),isset($product) ? $product->birim : '',['class'=>'form-control']) !!}
		</div>
		<!--
		<div class="form-group">
		  <label for="exampleInputFile">Avatar</label>
		  <input type="file" id="exampleInputFile">
		  <p class="help-block">Lütfen jpg formatı tercih ediniz!</p>
		</div>
		-->
	  </div><!-- /.box-body -->

	  <div class="box-footer">
		<button type="submit" class="btn btn-primary">Kaydet</button>
	  </div>
	</form>
  </div><!-- /.box -->
  
  
</section><!-- /.content -->
@endsection