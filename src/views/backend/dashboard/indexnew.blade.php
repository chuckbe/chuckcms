@extends('chuckcms::backend.layouts.admin')

@section('title')
	E-commerce
@endsection

@section('breadcrumbs')
	<ol class="breadcrumb">
		<li class="breadcrumb-item active"><a href="{{ route('dashboard.module.ecommerce.index') }}">Overzicht</a></li>
	</ol>
@endsection

@section('content')

<!-- START ROW -->
<div class="row">
  <div class="col-lg-6 col-sm-12  d-flex flex-column">
    
    <!-- START WIDGET widget_weekly_sales_card-->
    <div class="card no-border widget-loader-bar m-b-10">
      <div class="container-xs-height full-height">
        <div class="row-xs-height">
          <div class="col-xs-height col-top">
            <div class="card-header  top-left top-right">
              <div class="card-title">
                <span class="font-montserrat fs-11 all-caps">
                	Opbrengst Laatste 7 Dagen <i class="fa fa-chevron-right"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="row-xs-height">
          <div class="col-xs-height col-top">
            <div class="p-l-20 p-t-50 p-b-40 p-r-20">
              <h3 class="no-margin p-b-5">{{ ChuckEcommerce::totalSalesLast7Days() }}</h3>
              <span class="small hint-text pull-left">{{ ChuckEcommerce::totalSalesLast7DaysQty() }} bestellingen</span>
            </div>
          </div>
        </div>

      </div>
    </div>
    <!-- END WIDGET -->

    <!-- START WIDGET widget_weekly_sales_card-->
    <div class="card no-border widget-loader-bar m-b-10">
      <div class="container-xs-height full-height">
        <div class="row-xs-height">
          <div class="col-xs-height col-top">
            <div class="card-header  top-left top-right">
              <div class="card-title">
                <span class="font-montserrat fs-11 all-caps">Bestellingen <i class="fa fa-chevron-right"></i>
	                        </span>
              </div>
              <div class="card-controls">
                <ul>
                  <li><a href="#" class="portlet-refresh text-black" data-toggle="refresh"><i class="portlet-icon portlet-icon-refresh"></i></a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="row-xs-height">
          <div class="col-xs-height col-top">
            <div class="p-l-20 p-t-50 p-b-40 p-r-20">
              <h3 class="no-margin p-b-5">{{ $orders_count }}</h3>
              <span class="small hint-text pull-left">Totaal</span>
            </div>
          </div>
        </div>
        
      </div>
    </div>
    <!-- END WIDGET -->
  </div>

  <div class="col-lg-6 m-b-10 d-flex">
    <!-- START WIDGET widget_pendingComments.tpl-->
    <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
      <div class="card-header top-right">
        <div class="card-controls">
          <ul>
            <li><a data-toggle="refresh" class="portlet-refresh text-black" href="#"><i
							class="portlet-icon portlet-icon-refresh"></i></a>
            </li>
          </ul>
        </div>
      </div>
      <div class="padding-25">
        <div class="pull-left">
          <h2 class="text-success no-margin">{{ ChuckSite::getSite('name') }}</h2>
          <p class="no-margin">Laatste 30 bestellingen</p>
        </div>
        <div class="pull-right">
			<p class="no-margin ">Totaalomzet</p>
        	<div class="clearfix"></div>
        	<h3 class=" semi-bold">
        		{{ ChuckEcommerce::totalSales() }}
			</h3>
		</div>
      </div>
      <div class="auto-overflow widget-11-2-table">
        <table class="table table-condensed table-hover">
          <tbody>
          	@foreach($orders as $order)
            <tr>
              <td class="font-montserrat all-caps fs-12 w-75">Bestelling #{{ $order->json['order_number'] }}</td>
              <td class="w-25 b-l b-dashed b-grey">
                <span class="font-montserrat fs-18">{{ ChuckEcommerce::formatPrice($order->final) }}</span>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="padding-25 mt-auto">
        <p class="small no-margin">
          <a href="{{ route('dashboard.module.ecommerce.orders.index') }}"><i class="fa fs-16 fa-arrow-circle-o-down text-success m-r-10"></i></a>
          <span class="hint-text ">Bekijk alle bestellingen</span>
        </p>
      </div>
    </div>
    <!-- END WIDGET -->
  </div>
</div>
<!-- END ROW -->

@endsection

@section('scripts')

@endsection