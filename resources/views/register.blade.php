<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Müşteri Takip Sistemi | Üye Girişi</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="../../plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
    <body class="register-page">
    <div class="register-box">
      <div class="register-logo">
        <a href="../../index2.html"><b>Müşteri</b>Takip</a>
      </div>

      <div class="register-box-body">
        <p class="login-box-msg">Yeni Firma Başvurusu</p>
        <form action="{{URL::to('/company/add/')}}" method="post">
		{!! csrf_field() !!}
          <div class="form-group has-feedback">
            {!!Form::text('firma',\Input::old('firma',''),['class'=>'form-control','placeholder'=>'Firma Adını Giriniz'])!!}
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            {!!Form::text('yetkili',\Input::old('yetkili',''),['class'=>'form-control','placeholder'=>'Firma Yetkilisi Ad ve Soyadını Giriniz'])!!}
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            {!!Form::email('email',\Input::old('email',''),['class'=>'form-control','placeholder'=>'Eposta Adresinizi Giriniz'])!!}
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            {!!Form::text('telefon',\Input::old('telefon',''),['class'=>'form-control','placeholder'=>'Cep Telefon Numarınızı Giriniz'])!!}
          </div>
		  <div class="form-group has-feedback">
            {!!Form::select('uyetip',array(''=>'Üyelik Süresi Seçiniz.')+\DB::table('ozellik')->where('grup','paket')->lists('ad','id'),\Input::old('uyetip',''),['class'=>'form-control'])!!}
          </div>
          <div class="row">
            <div class="col-xs-8">    
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Sözleşmeyi okudum <a href="#">onaylıyorum.</a>
                </label>
              </div>                        
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Kaydet</button>
            </div><!-- /.col -->
          </div>
        </form>        

        <div class="social-auth-links text-center">
          <p>- Diğer -</p>
          <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Facebook ile Kaydol</a>
          <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Google+ ile Kaydol</a>
        </div>

        <a href="{{URL::to('/')}}" class="text-center">Ben zaten üyeyim!</a>
      </div><!-- /.form-box -->
    </div><!-- /.register-box -->

    <!-- jQuery 2.1.4 -->
    <script src="{{URL::to('/')}}/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{URL::to('/')}}/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="{{URL::to('/')}}/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
	<script src="{{URL::to('/')}}/bootstrap/js/bootstrap-notify.min.js" type="text/javascript"></script>
	
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
	<script>
	@if ($errors->count() > 0)
		@foreach ($errors->all() as $msg)
			var notify = $.notify('{{$msg}}', {
				allow_dismiss: true,
				type:'danger'
			});
		@endforeach
	@elseif(Session::get('success'))
		  var notify = $.notify('{{Session::get('success')}}', {
				allow_dismiss: true,
				type:'success'
			});
	@endif
	</script>
	<?php Session::forget('success','errors'); ?>
  </body>
</html>