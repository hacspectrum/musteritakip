<section class="content">
  
  <div class="box box-primary">
	<div class="box-header">
	  <h3 class="box-title">Müşteri Kayıt</h3>
	</div><!-- /.box-header -->
	<!-- form start -->
	<form role="form" action="/customers/create" method="post">
	{!! csrf_field() !!}
	  <div class="box-body">
		<div class="form-group">
		  <label for="exampleInputEmail1">Eposta Adresi</label>
		  <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email adresinizi Giriniz!">
		</div>
		<div class="form-group">
		  <label for="exampleInputPassword1">Şifre</label>
		  <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Şifrenizi Giriniz!">
		</div>
		<div class="form-group">
		  <label for="exampleInputPassword1">Şifre Tekrar</label>
		  <input type="password" name="password_confirmation" class="form-control" id="exampleInputPassword2" placeholder="Şifrenizi Tekrar Giriniz!">
		</div>
		<div class="form-group">
		  <label for="exampleInputEmail1">Bölge Seçimi</label>
		  {!! Form::select('bolge',array(''=>'Bölge Seçiniz')+DB::table('bolge')->where('firma_id',1)->lists('bolgeadi','id'),'',['class'=>'form-control']) !!}
		</div>
		<div class="form-group">
		  <label for="exampleInputPassword1">Ad ve Soyadınız</label>
		  <input type="text" name="name" class="form-control" placeholder="Adınızı ve Soyadınızı Giriniz">
		</div>
		<div class="form-group">
		  <label for="exampleInputPassword1">Adres</label>
		  <input type="text" name="adres" class="form-control" placeholder="Adınızı ve Soyadınızı Giriniz">
		</div>
		<div class="form-group">
		  <label for="exampleInputPassword1">İş/Ev Telefon</label>
		  <input type="text" name="tel" class="form-control" placeholder="İş veya Ev Telefonunuz">
		</div>
		<div class="form-group">
		  <label for="exampleInputPassword1">Gsm</label>
		  <input type="text" name="gsm" class="form-control" placeholder="Gsm Numaranız">
		</div>
		<div class="form-group">
		  <label for="exampleInputFile">Avatar</label>
		  <input type="file" id="exampleInputFile">
		  <p class="help-block">Lütfen jpg formatı tercih ediniz!</p>
		</div>
		
	  </div><!-- /.box-body -->

	  <div class="box-footer">
		<button type="submit" class="btn btn-primary">Kaydet</button>
	  </div>
	</form>
  </div><!-- /.box -->
  
  
</section><!-- /.content -->
