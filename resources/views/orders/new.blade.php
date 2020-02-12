@extends('layouts.master')
@section('content')
<section class="content-header">
  <h1>
	Yeni Sipariş Kaydı
	<small>Lütfen formu eksiksiz doldurunuz!</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> Anasayfa</a></li>
	<li><a href="#" class="active">Sipariş Kayıt</a></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  
  <div class="box box-primary">
	<div class="box-header">
	  <h3 class="box-title">Sipariş Formu</h3>
	</div><!-- /.box-header -->
	<!-- form start -->
	<form role="form" action="{{URL::to('/orders/create')}}" method="post">
	{!! Form::hidden('id',Input::old('id',isset($user) ? $user->id : '')) !!}
	{!! csrf_field() !!}
	  <div class="box-body">
		@if(\Auth::user()->tip!=0)
		<div class="form-group">
		  <label for="exampleInputEmail1">Müşteri</label>
		  {!! Form::select('musteri',array(''=>'Müşteri Seçiniz')+DB::table('users')->where('firma_id',Session::get('firma'))->lists('name','id'),isset($user) ? $user->musteri_id : 0,['class'=>'form-control']) !!}
		</div>
		@else
		{!! Form::hidden('musteri',\Auth::id()) !!}	
		@endif
		<div class="form-group">
		  <label for="exampleInputPassword1">Ürün Adı</label>
		  {!! Form::select('urun',array(''=>'Ürün Seçiniz')+DB::table('urun')->where('firma_id',Session::get('firma'))->lists('urunadi','id'),Input::old('urun',isset($user) ? $user->urun_id : ''),['class'=>'form-control']) !!}
		</div>
		<div class="form-group">
		  <label for="exampleInputPassword1">Miktar</label>
		  {!! Form::number('miktar',Input::old('miktar',isset($user) ? $user->miktar : ''),['step'=>'0.01','placeholder'=>'Adet Giriniz','class'=>'form-control']) !!}
		</div>
		<div class="form-group">
		  <label for="exampleInputPassword1">Açıklama</label>
		  {!! Form::text('aciklama',Input::old('aciklama',isset($user) ? $user->aciklama : ''),['placeholder'=>'Açıklama Giriniz','class'=>'form-control']) !!}
		</div>
	  </div><!-- /.box-body -->
	  <div class="box-footer">
		<button type="submit" class="btn btn-primary">Kaydet</button>
	  </div>
	</form>
  </div><!-- /.box -->
  
  
</section><!-- /.content -->
@endsection