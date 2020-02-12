<?php $Ica = new \App\Ica; ?>
<section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="{!!$Ica->d_img(md5(Auth::id()).'.jpg','dist/img/users')!!}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p>{{Session::get('name')}}</p>
			  <a href="#"><i class="fa fa-circle text-success"></i> Online ({{Session::get('firmaadi')}})</a>
          </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Aranacak Kelime..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MENÜLER</li>
			@if(\Auth::user()->tip!=0)
            <li class="treeview">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Müşteriler</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{URL::to('/customers')}}"><i class="fa fa-circle-o"></i> Yeni Müşteri</a></li>
                <li><a href="{{URL::to('/customers/list')}}"><i class="fa fa-circle-o"></i> Müşteriler</a></li>
              </ul>
            </li>
			@endif
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Siparişler</span>
                <span class="label label-primary pull-right">
				@if(\Auth::user()->tip!=0)
					{!!DB::table('siparis')->where('firma_id',Auth::user()->firma_id)->where('durum',0)->count('id')!!}
				@else
					{!!DB::table('siparis')->where('firma_id',Auth::user()->firma_id)->where('musteri_id',\Auth::id())->where('durum',0)->count('id')!!}
				@endif
				</span>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{URL::to('/orders')}}"><i class="fa fa-circle-o"></i> Yeni Sipariş</a></li>
                <li><a href="{{URL::to('/orders/list')}}"><i class="fa fa-circle-o"></i> Siparişler</a></li>
              </ul>
            </li>
			@if(\Auth::user()->tip!=0)
            <li class="treeview">
              <a href="#">
                <i class="fa fa-pie-chart"></i>
                <span>Ürünler</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{URL::to('/products')}}"><i class="fa fa-circle-o"></i> Yeni Ürün</a></li>
                <li><a href="{{URL::to('/products/list')}}"><i class="fa fa-circle-o"></i> Ürünler</a></li>
				<li><a href="{{URL::to('/products/special')}}"><i class="fa fa-circle-o"></i> Özel Fiyatlar</a></li>
              </ul>
            </li> 
			@endif
			
            <li class="treeview">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Hesap Hareketleri</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
			  @if(\Auth::user()->tip!=0)
                <li><a href="{{URL::to('/transactions')}}"><i class="fa fa-circle-o"></i> Yeni İşlem</a></li>
			  @endif
                <li><a href="{{URL::to('/transactions/list/sales')}}"><i class="fa fa-circle-o"></i> Satış</a></li>
                <li><a href="{{URL::to('/transactions/list/payment')}}"><i class="fa fa-circle-o"></i> Ödeme</a></li>
                <li><a href="{{URL::to('/transactions/list/expense')}}"><i class="fa fa-circle-o"></i> Tahsilat</a></li>
                <li><a href="{{URL::to('/transactions/list/transfer')}}"><i class="fa fa-circle-o"></i> Transfer</a></li>
                <li><a href="{{URL::to('/transactions/list/expense')}}"><i class="fa fa-circle-o"></i> Masraf</a></li>
              </ul>
            </li>
			
			@if(\Auth::user()->tip!=0)
				
			<li class="treeview">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Raporlar</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
			    <li><a href="{{URL::to('/reports/sales')}}"><i class="fa fa-circle-o"></i> Satış Raporları</a></li>
                <li><a href="{{URL::to('/reports/payments')}}"><i class="fa fa-circle-o"></i> Ödeme Raporları</a></li>
              </ul>
            </li>
			
            <li class="treeview">
              <a href="#">
                <i class="fa fa-edit"></i> <span>Bölgeler</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{URL::to('/areas')}}"><i class="fa fa-circle-o"></i> Yeni Bölge</a></li>
                <li><a href="{{URL::to('/areas/list')}}"><i class="fa fa-circle-o"></i> Bölgeler</a></li>
              </ul>
            </li>
            <li class="treeview" style="display:none;">
              <a href="#">
                <i class="fa fa-table"></i> <span>Tanımlar</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Ayarlar</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Tanımlamalar</a></li>
              </ul>
            </li>
            <li style="display:none;">
              <a href="#">
                <i class="fa fa-calendar"></i> <span>Takvim</span>
                <small class="label pull-right bg-red">0</small>
              </a>
            </li>
            @endif
          </ul>
        </section>