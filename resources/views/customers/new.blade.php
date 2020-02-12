@extends('layouts.master')
@section('content')
<section class="content-header">
          <h1>
            Yeni Müşteri Kaydı
            <small>Lütfen formu eksiksiz doldurunuz!</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Anasayfa</a></li>
            <li><a href="#" class="active">Müşteri Kayıt</a></li>
          </ol>
        </section>
<!-- Main content -->
<section class="content">
  
  <div class="box box-primary">
	<div class="box-header">
	  <h3 class="box-title">Müşteri Kayıt</h3>
	</div><!-- /.box-header -->
	<!-- form start -->
	<form role="form" action="/customers/create" method="post">
	{!! Form::hidden('id',Input::old('id',isset($user) ? $user->id : '')) !!}
	{!! csrf_field() !!}
	  <div class="box-body">
		@if(!isset($user))
			<div class="form-group">
			  <label for="exampleInputEmail1">Eposta Adresi</label>
			  {!! Form::email('email',Input::old('email',isset($user) ? $user->email : ''),['placeholder'=>'Email adresinizi Giriniz','class'=>'form-control']) !!}
			</div>
		@endif
		<p align="right"><a href="javascript::void(0)" onclick="$('#sifrealani').toggle()">Şifre Tanımla</a></p>
		<div id="sifrealani" style="display:none;">
			<div class="form-group">
			  <label for="exampleInputPassword1">Şifre</label>
			  {!! Form::password('password',['placeholder'=>'Şifrenizi Giriniz','class'=>'form-control']) !!}
			</div>
			<div class="form-group">
			  <label for="exampleInputPassword1">Şifre Tekrar</label>
			  {!! Form::password('password_confirmation',['placeholder'=>'Şifrenizi Tekrar  Giriniz','class'=>'form-control']) !!}
			</div>
		</div>
		<div class="form-group">
		  <label for="exampleInputEmail1">Bölge Seçimi</label>
		  {!! Form::select('bolge',array(''=>'Bölge Seçiniz')+DB::table('bolge')->where('firma_id',Session::get('firma'))->lists('bolgeadi','id'),isset($user) ? $user->bolge_id : 0,['class'=>'select2 form-control']) !!}
		</div>
		<div class="form-group">
		  <label for="exampleInputPassword1">Ad ve Soyadınız</label>
		  {!! Form::text('name',Input::old('name',isset($user) ? $user->name:''),['placeholder'=>'Ad ve Soyadınızı Giriniz','class'=>'form-control']) !!}
		</div>
		<div class="form-group">
		  <label for="exampleInputPassword1">Adres</label>
		  {!! Form::text('adres',Input::old('adres',isset($user) ? $user->adres:''),['placeholder'=>'Adres Giriniz','class'=>'form-control']) !!}
		</div>
		<div class="form-group" style="display:none;">
		  <label for="exampleInputPassword1">İş/Ev Telefon</label>
		  {!! Form::text('tel',Input::old('tel',isset($user) ? $user->tel:''),['placeholder'=>'İş veya Ev Telefonunuz','class'=>'form-control']) !!}
		</div>
		<div class="form-group">
		  <label for="exampleInputPassword1">Gsm</label>
		  {!! Form::text('gsm',Input::old('gsm',isset($user) ? $user->gsm:''),['placeholder'=>'Gsm Telefonunuz','class'=>'form-control']) !!}
		</div>
		<!--
		<div class="form-group">
		  <label for="exampleInputFile">Avatar</label>
		  <input type="file" id="exampleInputFile">
		  <p class="help-block">Lütfen jpg formatı tercih ediniz!</p>
		</div>-->
		
	  </div><!-- /.box-body -->

	  <div class="box-footer">
		<button type="submit" class="btn btn-primary">Kaydet</button>
	  </div>
	</form>
  </div><!-- /.box -->
  
  
</section><!-- /.content -->
@endsection