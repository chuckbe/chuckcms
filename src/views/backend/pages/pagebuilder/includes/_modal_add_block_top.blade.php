<div id="modal_add_block_top" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal">&times;</button>
        	<h4 class="modal-title">Voeg Pagina Block Toe:</h4>
      	</div>
      	<div class="modal-body">
      		<form action="">
      			<div class="panel-group">
      				@foreach($blocks as $bKey => $bValue)
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" href="#{{ $bKey }}" style="text-transform:capitalize">{{ str_replace('-', ' ', $bKey) }}</a>
							</h4>
						</div>
						<div id="{{ $bKey }}" class="panel-collapse collapse">
							<div class="panel-body">
								<div class="col-sm-12">
									@foreach($bValue as $block)
									
                  <div class="col-sm-3">
										<a class="pb_add_block_top_button" data-location="{{ $block['location'] }}" data-name="{{ $block['name'] }}">
                      <p class="text-center">{{ $block['name'] }}</p>
											<img src="{{ URL::to($block['img']) }}" class="img-responsive text-center" alt="{{ $block['name'] }}" style="margin:0 auto 0 auto;">
										</a>
									</div>
                  
                  @if($loop->iteration % 4 == 0)
                    <div class="clearfix"></div>
                    <br><br>
                  @endif
									
                  @endforeach
								</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
      		</form>
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
        	<button type="button" class="btn btn-success" data-dismiss="modal">Toevoegen</button>
      	</div>
    </div>

  </div>
</div>