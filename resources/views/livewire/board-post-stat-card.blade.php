<div>
    <div class="col mb-3" wire:poll.5s>
        <div class="card border-start border-4 border-left-{{ $stat['color'] }} shadow-sm py-1">
            <div class="card-body d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="font-weight-bold text-muted text-uppercase">{{ $stat['title'] }}</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{  (isset($stat['progress'])) ? $stat['value'].' %' : $stat['value'] }}</div>
                    </div>
                    <div class="text-{{ $stat['color'] }}">
                        <i class="{{ $stat['icon'] }} fa-1x"></i>
                    </div>
                </div>

                @if(isset($stat['progress']))
                <div class="progress mt-2" style="height: 4px;">
                    <div class="progress-bar bg-{{ $stat['color'] }}" role="progressbar" style="width: {{ $stat['progress'] }}%;"
                        aria-valuenow="{{ $stat['progress'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
