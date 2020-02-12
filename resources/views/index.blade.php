<?php $Ica = new \App\Ica; ?>
@extends('layouts.master')
@section('content')
<section class="content">
          <!-- Small boxes (Stat box) -->
          <div class="row">
		    @if(\Auth::user()->tip!=0)
				<div class="col-lg-3 col-xs-6">
				  <!-- small box -->
				  <div class="small-box bg-aqua">
					<div class="inner">
					  <h3>{!!DB::table('siparis')->where('firma_id',Session::get('firma'))->where('durum',0)->count('id')!!}</h3>
					  <p>Yeni Sipariş</p>
					</div>
					<div class="icon">
					  <i class="ion ion-bag"></i>
					</div>
					<a href="{!!URL::to('orders/list')!!}" class="small-box-footer">Sipariş Detayı <i class="fa fa-arrow-circle-right"></i></a>
				  </div>
				</div><!-- ./col -->
				<div class="col-lg-3 col-xs-6">
				  <!-- small box -->
				  <div class="small-box bg-green">
					<div class="inner">
					  <h3>{!!DB::table('users')->where('firma_id',Session::get('firma'))->count('id')!!}</h3>
					  <p>Müşteri</p>
					</div>
					<div class="icon">
					  <i class="ion ion-stats-bars"></i>
					</div>
					<a href="{!!URL::to('customers/list')!!}" class="small-box-footer">Müşteriler <i class="fa fa-arrow-circle-right"></i></a>
				  </div>
				</div><!-- ./col -->
				<div class="col-lg-3 col-xs-6">
				  <!-- small box -->
				  <div class="small-box bg-yellow">
					<div class="inner">
					  <h3>{!!DB::table('urun')->where('firma_id',Session::get('firma'))->count('id')!!}</h3>
					  <p>Ürünler</p>
					</div>
					<div class="icon">
					  <i class="ion ion-person-add"></i>
					</div>
					<a href="{!!URL::to('products/list')!!}" class="small-box-footer">Ürün Bilgisi <i class="fa fa-arrow-circle-right"></i></a>
				  </div>
				</div><!-- ./col -->
				<div class="col-lg-3 col-xs-6">
				  <!-- small box -->
				  <div class="small-box bg-red">
					<div class="inner">
					  <h3>{!!DB::table('hesap')->where('firma_id',Session::get('firma'))->where('tip','ODEME')->count('id')!!}</h3>
					  <p>Ödeme Hareketleri</p>
					</div>
					<div class="icon">
					  <i class="ion ion-pie-graph"></i>
					</div>
					<a href="{!!URL::to('transactions/list/payment')!!}" class="small-box-footer">tümü <i class="fa fa-arrow-circle-right"></i></a>
				  </div>
				</div><!-- ./col -->
			@else
				<div class="col-lg-3 col-xs-6">
				  <!-- small box -->
				  <div class="small-box bg-aqua">
					<div class="inner">
					  <h3>{!!DB::table('siparis')->where('firma_id',Session::get('firma'))->where('musteri_id',\Auth::id())->where('durum',0)->count('id')!!}</h3>
					  <p>Onay Bekleyen Sipariş</p>
					</div>
					<div class="icon">
					  <i class="ion ion-bag"></i>
					</div>
					<a href="{!!URL::to('orders/list')!!}" class="small-box-footer">Sipariş Detayı <i class="fa fa-arrow-circle-right"></i></a>
				  </div>
				</div><!-- ./col -->
				<div class="col-lg-3 col-xs-6">
				  <!-- small box -->
				  <div class="small-box bg-green">
					<div class="inner">
					  <h3>{!!DB::table('siparis')->where('firma_id',Session::get('firma'))->where('musteri_id',\Auth::id())->where('durum',0)->sum('tutar')!!} TL</h3>
					  <p>Bekleyen Tutar</p>
					</div>
					<div class="icon">
					  <i class="ion ion-stats-bars"></i>
					</div>
					<a href="{!!URL::to('transactions/list/sales')!!}" class="small-box-footer">Sipariş Tutarı <i class="fa fa-arrow-circle-right"></i></a>
				  </div>
				</div><!-- ./col -->
				<div class="col-lg-3 col-xs-6">
				  <!-- small box -->
				  <div class="small-box bg-yellow">
					<div class="inner">
					  <h3>{!!\DB::table('hesap')->select('tutar')->where('firma_id',\Session::get('firma'))->where('musteri_id',\Auth::id())->where('durum',1)->sum('tutar')!!} TL</h3>
					  <p>Bakiye</p>
					</div>
					<div class="icon">
					  <i class="ion ion-person-add"></i>
					</div>
					<a href="{!!URL::to('customers/statement')!!}" class="small-box-footer">Hesap Özeti <i class="fa fa-arrow-circle-right"></i></a>
				  </div>
				</div><!-- ./col -->
				<div class="col-lg-3 col-xs-6">
				  <!-- small box -->
				  <div class="small-box bg-red">
					<div class="inner">
					  <h3>{!!DB::table('hesap')->where('firma_id',Session::get('firma'))->where('tip','ODEME')->count('id')!!}</h3>
					  <p>Ödeme Hareketleri</p>
					</div>
					<div class="icon">
					  <i class="ion ion-pie-graph"></i>
					</div>
					<a href="{!!URL::to('transactions/list/payment')!!}" class="small-box-footer">tümü <i class="fa fa-arrow-circle-right"></i></a>
				  </div>
				</div><!-- ./col -->
			@endif
		  </div><!-- /.row -->
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <section class="col-lg-12 connectedSortable">
         

              <!-- TO DO List -->
              <div class="box box-primary">
                <div class="box-header">
                  <i class="ion ion-clipboard"></i>
                  <h3 class="box-title">Günlük Program</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <ul class="todo-list">
					@foreach(\DB::table('gunluk')->where('firma_id',\Session::get('firma'))->where('user_id',\Auth::id())->take(10)->get() as $val)
                    <li>
                      <!-- drag handle -->
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                      <!-- todo text -->
                      <span class="text">
					  @if($val->durum==1) <strike> @endif
					  {{$val->aciklama}}
					  @if($val->durum==1) </strike> @endif
					  </span>
                      <!-- Emphasis label -->
                      <small class="label label-danger"><i class="fa fa-clock-o"></i> {{$Ica->simdi($val->created_at)}}</small>
                      <!-- General tools such as edit or delete-->
                      <div class="tools">
                        <i class="fa fa-edit" onclick="window.location='{!!URL::to('auth/todo/confirm/'.$val->id)!!}'"></i>
                        <i class="fa fa-trash-o" onclick="window.location='{!!URL::to('auth/todo/destroy/'.$val->id)!!}'"></i>
                      </div>
                    </li>
					@endforeach
					<li id="new" style="display:none;">
					  <form action="{!!URL::to('/auth/todo')!!}" method="post">
					  {!! csrf_field() !!}
                      <!-- drag handle -->
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                      <!-- todo text -->
                      <div class="input-group">
						{!!Form::text('aciklama','',['class'=>'form-control','placeholder'=>'Günlük mesajınızı girebilirsiniz'])!!}
						<div class="input-group-btn">
						  <button class="btn btn-success"><i class="fa fa-plus"></i></button>
						</div>
					  </div>
					  </form>
                    </li>
                  </ul>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix no-border">
                  <button class="btn btn-default pull-right" onclick="$('#new').show()"><i class="fa fa-plus"></i> Yeni Günlük</button>
                </div>
              </div><!-- /.box -->

              <!-- quick email widget 
              <div class="box box-info">
                <div class="box-header">
                  <i class="fa fa-envelope"></i>
                  <h3 class="box-title">Quick Email</h3>
                  
                  <div class="pull-right box-tools">
                    <button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <form action="#" method="post">
                    <div class="form-group">
                      <input type="email" class="form-control" name="emailto" placeholder="Email to:"/>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" name="subject" placeholder="Subject"/>
                    </div>
                    <div>
                      <textarea class="textarea" placeholder="Message" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                    </div>
                  </form>
                </div>
                <div class="box-footer clearfix">
                  <button class="pull-right btn btn-default" id="sendEmail">Send <i class="fa fa-arrow-circle-right"></i></button>
                </div>
              </div><!-- tools box -->

            </section><!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-5 connectedSortable">

              
			  <!--
              <div class="box box-solid bg-teal-gradient">
                <div class="box-header">
                  <i class="fa fa-th"></i>
                  <h3 class="box-title">Sales Graph</h3>
                  <div class="box-tools pull-right">
                    <button class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body border-radius-none">
                  <div class="chart" id="line-chart" style="height: 250px;"></div>
                </div>
                <div class="box-footer no-border">
                  <div class="row">
                    <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                      <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60" data-fgColor="#39CCCC"/>
                      <div class="knob-label">Mail-Orders</div>
                    </div>
                    <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                      <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60" data-fgColor="#39CCCC"/>
                      <div class="knob-label">Online</div>
                    </div>
                    <div class="col-xs-4 text-center">
                      <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60" data-fgColor="#39CCCC"/>
                      <div class="knob-label">In-Store</div>
                    </div>
                  </div>
                </div>
              </div><!-- /.box -->
			  
			  
              <!-- Calendar 
              <div class="box box-solid bg-green-gradient">
                <div class="box-header">
                  <i class="fa fa-calendar"></i>
                  <h3 class="box-title">Calendar</h3>
                  <!-- tools box 
                  <div class="pull-right box-tools">
                    <!-- button with a dropdown 
                    <div class="btn-group">
                      <button class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i></button>
                      <ul class="dropdown-menu pull-right" role="menu">
                        <li><a href="#">Add new event</a></li>
                        <li><a href="#">Clear events</a></li>
                        <li class="divider"></li>
                        <li><a href="#">View calendar</a></li>
                      </ul>
                    </div>
                    <button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div><!-- /. tools 
                </div><!-- /.box-header 
                <div class="box-body no-padding">
                  <!--The calendar 
                  <div id="calendar" style="width: 100%"></div>
                </div><!-- /.box-body 
                <div class="box-footer text-black">
                  <div class="row">
                    <div class="col-sm-6">
                      <!-- Progress bars 
                      <div class="clearfix">
                        <span class="pull-left">Task #1</span>
                        <small class="pull-right">90%</small>
                      </div>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 90%;"></div>
                      </div>

                      <div class="clearfix">
                        <span class="pull-left">Task #2</span>
                        <small class="pull-right">70%</small>
                      </div>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 70%;"></div>
                      </div>
                    </div><!-- /.col 
                    <div class="col-sm-6">
                      <div class="clearfix">
                        <span class="pull-left">Task #3</span>
                        <small class="pull-right">60%</small>
                      </div>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 60%;"></div>
                      </div>

                      <div class="clearfix">
                        <span class="pull-left">Task #4</span>
                        <small class="pull-right">40%</small>
                      </div>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 40%;"></div>
                      </div>
                    </div><!-- /.col 
                  </div><!-- /.row 
                </div>
              </div><!-- /.box -->

            </section><!-- right col -->
          </div>
		  <!-- /.row (main row) -->

        </section>
@endsection
@section('js')
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Morris.js charts -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{URL::to('/')}}/plugins/morris/morris.min.js" type="text/javascript"></script>
<!-- Sparkline -->
<script src="{{URL::to('/')}}/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- jvectormap -->
<script src="{{URL::to('/')}}/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
<script src="{{URL::to('/')}}/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
<!-- jQuery Knob Chart -->
<script src="{{URL::to('/')}}/plugins/knob/jquery.knob.js" type="text/javascript"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js" type="text/javascript"></script>
<script src="{{URL::to('/')}}/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{URL::to('/')}}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{URL::to('/')}}/dist/js/pages/dashboard.js" type="text/javascript"></script>    
@endsection
@section('css')
<link href="{{URL::to('/')}}/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
<!-- iCheck -->
<link href="{{URL::to('/')}}/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
<!-- Morris chart -->
<link href="{{URL::to('/')}}/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
<!-- jvectormap -->
<link href="{{URL::to('/')}}/plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
<!-- Date Picker -->
<link href="{{URL::to('/')}}/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
<!-- Daterange picker -->
<link href="{{URL::to('/')}}/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<!-- bootstrap wysihtml5 - text editor -->
<link href="{{URL::to('/')}}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
@endsection