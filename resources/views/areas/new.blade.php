@extends('layouts.master')
@section('content')
<section class="content-header">
          <h1>
            Yeni Bölge
            <small>Lütfen formu eksiksiz doldurunuz!</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Anasayfa</a></li>
            <li><a href="#" class="active">Yeni Bölge</a></li>
          </ol>
        </section>
<!-- Main content -->
<section class="content">
  
  <div class="box box-primary">
	<div class="box-header">
	  <h3 class="box-title">Bölge Kayıt</h3>
	</div><!-- /.box-header -->
	<!-- form start -->
	<form role="form" action="/areas/create" method="post">
	{!! csrf_field() !!}
	{!! Form::hidden('id',Input::old('id',isset($area) ? $area->id : '')) !!}
	  <div class="box-body">
		<div class="form-group">
		  <label for="exampleInputEmail1">Bölge Adı</label>
		  {!! Form::text('bolge',Input::old('bolge',isset($area) ? $area->bolgeadi : ''),['placeholder'=>'Bölge Adı Giriniz','class'=>'form-control']) !!}
		</div>
		<div class="form-group">
		  <label for="exampleInputPassword1">Ürün Adı</label>
		  {!! Form::select('urun',array(''=>'Ürün Seçiniz')+DB::table('urun')->where('firma_id',Session::get('firma'))->lists('urunadi','id'),Input::old('urun',isset($area) ? $area->urun_id : ''),['class'=>'form-control']) !!}
		</div>
		<div class="form-group">
		  <label for="exampleInputEmail1">Fiyat</label>
		  {!! Form::number('fiyat',Input::old('fiyat',isset($area) ? $area->birimfiyat : ''),['step'=>'0.01','placeholder'=>'Bölge Fiyatı Giriniz','class'=>'form-control']) !!}
		</div>
	  </div><!-- /.box-body -->

	  <div class="box-footer">
		<button type="submit" class="btn btn-primary">Kaydet</button>
	  </div>
	</form>
  </div><!-- /.box -->
  
  
</section><!-- /.content -->
@endsection