@extends('layouts.master')
@section('content')
<section class="content-header">
          <h1>
            Profil
            <small>Lütfen profil bilgilerini eksiksiz dolduurunuz!</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Anasayfa</a></li>
            <li><a href="#" class="active">Profil</a></li>
          </ol>
        </section>
<!-- Main content -->
<section class="content">
  
  <div class="box box-primary">
	<div class="box-header">
	  <h3 class="box-title">Profil Bilgisi</h3>
	</div><!-- /.box-header -->
	<!-- form start -->
	{!!Form::open(array('url' => 'auth/update', 'files' => true,'method' => 'post'))!!}
	{!! csrf_field() !!}
	
		<div class="box-body">
		
		<div class="form-group">
		  <label for="exampleInputPassword1">Şifre</label>
		  {!! Form::password('password',['placeholder'=>'Şifrenizi Giriniz','class'=>'form-control']) !!}
		</div>
		<div class="form-group">
		  <label for="exampleInputPassword1">Şifre Tekrar</label>
		  {!! Form::password('password_confirmation',['placeholder'=>'Şifrenizi Tekrar  Giriniz','class'=>'form-control']) !!}
		</div>
		<div class="form-group">
		  <label for="exampleInputPassword1">Ad ve Soyadınız</label>
		  {!! Form::text('name',Input::old('name',isset($user) ? $user->name : ''),['placeholder'=>'Ad ve Soyadınızı Giriniz','class'=>'form-control']) !!}
		</div>
		<div class="form-group">
		  <label for="exampleInputPassword1">Adres</label>
		  {!! Form::text('adres',Input::old('adres',isset($user) ? $user->adres : ''),['placeholder'=>'Adres Giriniz','class'=>'form-control']) !!}
		</div>
		<div class="form-group">
		  <label for="exampleInputPassword1">İş/Ev Telefon</label>
		  {!! Form::text('tel',Input::old('tel',isset($user) ? $user->tel : ''),['placeholder'=>'İş veya Ev Telefonunuz','class'=>'form-control']) !!}
		</div>
		<div class="form-group">
		  <label for="exampleInputPassword1">Gsm</label>
		  {!! Form::text('gsm',Input::old('gsm',isset($user) ? $user->gsm : ''),['placeholder'=>'Gsm Telefonunuz','class'=>'form-control']) !!}
		</div>
		<div class="form-group">
		  <label for="exampleInputFile">Avatar</label>
		  <input type="file" name="file">
		  <p class="help-block">Lütfen jpg formatı tercih ediniz!</p>
		</div>
		
	  </div><!-- /.box-body -->

	  <div class="box-footer">
		<button type="submit" class="btn btn-primary">Kaydet</button>
	  </div>
	{!!Form::close()!!}
  </div><!-- /.box -->
  
  
</section><!-- /.content -->
@endsection