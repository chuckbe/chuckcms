<div class="modal fade" id="siteSwitcherModal" tabindex="-1" aria-labelledby="siteSwitcherModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="siteSwitcherModalLabel">Kies een site</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="list-group">
          <button type="button" class="list-group-item list-group-item-action active" disabled>
            {{ ChuckSite::currentSite()->host }}
          </button>
          @foreach(ChuckSite::allSites() as $site)
          @if($site->id !== ChuckSite::currentSite()->id)
          <a href="{{ route('switch.site', ['site' => $site->id]) }}" class="list-group-item list-group-item-action">{{ $site->host }}</a>
          @endif
          @endforeach
          <button type="button" class="list-group-item list-group-item-action"><i class="fa fa-plus"></i> Nieuwe site toevoegen</button>
        </div>
      </div>
    </div>
  </div>
</div>