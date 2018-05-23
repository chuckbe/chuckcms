@extends('chuckcms::backend.layouts.admin')

@section('title')
	Dashboard
@endsection

@section('breadcrumbs')
	<ol class="breadcrumb">
		<li class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></li>
	</ol>
@endsection

@section('content')
<div class="card-block">
	<div class="row">
		<div class="col-lg-4">
			<div class="card card-default">
				<div class="card-header  separator">
					<div class="card-title">Portlet Three</div>
				</div>
				<div class="card-block">
					<h3>
						<span class="semi-bold">With</span> Separator
					</h3>
					<p>When it comes to digital design, the lines between functionality, aesthetics, and psychology are inseparably blurred. Without the constraints of the physical world, there’s no natural form to fall back on, and every bit of constraint and affordance must be introduced intentionally. Good design makes a product useful. A product is bought to be used. </p>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection