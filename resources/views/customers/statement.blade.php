<?php $Ica = new \App\Ica; ?>
@extends('layouts.master')
@section('content')
<section class="content-header">
          <h1>
            Sayın {!!$user->name!!} Hesap Dökümünüz
            <small>hesaplarınızı inceleyebilirsiniz.</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Anasayfa</a></li>
            <li class="active"><a href="#">Hesap Listesi</a></li>
          </ol>
        </section>
<!-- Main content -->
<section class="content">
<div class="box box-primary">
	<div class="box-header">
	  <h3 class="box-title">Hesap Özeti</h3>
	</div><!-- /.box-header -->
	<div class="box-body table-responsive no-padding">
	  <table class="table table-hover">
		<tr>
		  <th>ID</th>
		  <th>Tarih</th>
		  <th>Tip</th>
		  <th>Açıklama</th>
		  <th>Tutar</th>
		  <th>Bakiye</th>
		</tr>
		<?php $i=1; ?>
		@foreach($veri as $value)
		<tr>
		  <td>{{$i++}}</td>
		  <td>{{date('d-m-Y H:i',strtotime($value->tarih))}}</td>
		  <td>{{$value->tip}}</td>
		  <td>{{$value->aciklama}}</td>
		  <td>{{$value->tutar}} TL</td>
		  <td>
			  @if($value->tutar>0)
				<font color="red">{{$bakiye}} TL</font>
			  @else
				<font color="blue">{{$bakiye}} TL</font>
			  @endif
			   <?php $bakiye=number_format($bakiye-$value->tutar,2); ?> 
		  </td>
		</tr>
		@endforeach
		
	  </table>
	</div><!-- /.box-body -->
  </div><!-- /.box -->
</section><!-- /.content -->
@endsection