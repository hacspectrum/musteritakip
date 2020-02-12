@extends('layouts.master')
@section('content')
<section class="content-header">
          <h1>
            Yeni İşlemler
            <small>Lütfen formu eksiksiz doldurunuz!</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Anasayfa</a></li>
            <li><a href="#" class="active">Yeni İşlemler</a></li>
          </ol>
        </section>
<!-- Main content -->
<section class="content">
  
  <div class="box box-primary">
	<div class="box-header">
	  <h3 class="box-title">İşlem Kayıt</h3>
	</div><!-- /.box-header -->
	<!-- form start -->
	<form role="form" action="/transactions/create" method="post">
	{!! csrf_field() !!}
	{!! Form::hidden('id',Input::old('id',isset($detail) ? $detail->id : '')) !!}
	  <div class="box-body">
		<div class="form-group">
		  <label for="exampleInputEmail1">Müşteriler</label>
		  @if(isset($user))
			   {!! Form::select('musteri',array(''=>'Müşteri Seçiniz')+DB::table('users')->where('firma_id',Session::get('firma'))->lists('name','id'),isset($user) ? array($user):'',['id'=>'musteri','class'=>'form-control']) !!}
		  @else
			   {!! Form::select('musteri',array(''=>'Müşteri Seçiniz')+DB::table('users')->where('firma_id',Session::get('firma'))->lists('name','id'),isset($detail) ? $detail->musteri_id : '',['id'=>'musteri','class'=>'form-control']) !!}
		  @endif
		</div>
		<div class="form-group">
		  <label for="exampleInputEmail1">İşlem Tipi</label>
		  {!! Form::select('tipi',array(''=>'İşlem Tipi Seçiniz')+DB::table('ozellik')->where('grup','islem')->lists('ad','deger'),isset($detail) ? $detail->tip : '',['id'=>'tipi','class'=>'form-control','onchange'=>'islem(this.value)']) !!}
		</div>
		<div id="transfer" style="display:none;">
			<div class="form-group">
			  <label for="exampleInputEmail1">Transfer Edilecek Kişi</label>
			  {!! Form::select('alici',array(''=>'Transfer Edilecek Kişi Seçiniz')+DB::table('users')->where('firma_id',Session::get('firma'))->lists('name','id'),'',['id'=>'musteri','class'=>'form-control']) !!}
			</div>
		</div>
		<div class="form-group">
		  <label for="exampleInputEmail1">Tarih</label>
		  {!! Form::text('tarih',Input::old('tarih',isset($detail) ? $detail->tarih : date('d/m/Y')),['id'=>'datetime','placeholder'=>'Tarih Giriniz','class'=>'form-control']) !!}
		</div>
		
		<div id="siparis" style="display:none;">
			<div class="form-group">
			  <label for="exampleInputEmail1">Ürün</label>
			  {!! Form::select('urun',DB::table('urun')->where('firma_id',1)->lists('urunadi','id'),Input::old('urun',isset($detail) ? $detail->urun_id : ''),['class'=>'form-control','id'=>'urun'])!!}
			</div>			
			<div class="form-group">
			  <label for="exampleInputEmail1">Miktar</label>
			  {!! Form::number('miktar',Input::old('miktar',isset($detail) ? $detail->miktar : ''),['step'=>'0.01','onchange'=>'hesapla(this.value)','placeholder'=>'Miktar Giriniz','class'=>'form-control']) !!}
			</div>			
			<div class="form-group">
			  <label for="exampleInputEmail1">Fiyat</label>
			  {!! Form::number('fiyat',Input::old('fiyat',isset($detail) ? $detail->fiyat : ''),['step'=>'0.01','id'=>'fiyat','placeholder'=>'Fiyat Giriniz','class'=>'form-control']) !!}
			</div>			
		</div>
		
		<div class="form-group">
			  <label for="exampleInputEmail1">Tutar</label>
			  {!! Form::number('tutar',Input::old('tutar',isset($detail) ? $detail->tutar : ''),['step'=>'0.01','id'=>'tutar','placeholder'=>'Tutar Giriniz','class'=>'form-control']) !!}
		</div>
		
		<div class="form-group">
		  <label for="exampleInputEmail1">Açıklama</label>
		  {!! Form::text('aciklama',Input::old('aciklama',isset($detail) ? $detail->aciklama : ''),['placeholder'=>'Açıklama Giriniz','class'=>'form-control']) !!}
		</div>
		
		<div class="form-group" style="display:none">
		  <label for="exampleInputEmail1">Durum</label>
		  {!! Form::select('durum',array(''=>'Durum Seçiniz')+DB::table('ozellik')->where('grup','onay')->lists('ad','deger'),isset($detail) ? $detail->durum : 0,['class'=>'form-control']) !!}
		</div>
		
	  </div><!-- /.box-body -->
	  <div class="box-footer">
		<button type="submit" class="btn btn-primary">Kaydet</button>
	  </div>
	</form>
  </div><!-- /.box -->
  
  
</section><!-- /.content -->
@endsection
@section('js')
<script>
	function islem(v){
	$('#siparis').hide();
	$('#odeme').hide();
	$('#transfer').hide();
		if(v=='SATIS'){
			$('#siparis').show();
			$('#odeme').hide();
		}else{
			$('#odeme').show();
		}
	}
	function hesapla(v){
		var adet=v;
		var urun=$('#urun').val();
		var kisi=$('#musteri').val();
		var _token = '{{ csrf_token() }}';
		$.post('{{URL::to('transactions/ajax/fiyat')}}','m='+adet+'&u='+urun+'&k='+kisi+'&_token='+_token,function(data){
			$('#fiyat').val(data);
			$('#tutar').val(data*adet);
			return data;
		});
	}
	@if(isset($detail))
		islem('{!!$detail->tip!!}');
	@elseif(isset($user) && $type=='payment')
		islem();
		$("#tipi").prop("selectedIndex",4);
	@elseif(isset($user) && $type=='order')
		islem('SATIS');
		$("#tipi").prop("selectedIndex",1);
	@endif
</script>
@endsection