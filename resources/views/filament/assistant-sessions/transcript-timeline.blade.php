@php
    use App\Models\AssistantSession;

    /** @var AssistantSession $record */
    $entries = $record->transcriptEntries();
@endphp

<div class="acremann-assistant-timeline">
    @forelse($entries as $entry)
        @php
            $event = $entry['event'] ?? 'event';
            $meta = AssistantSession::eventMeta($event);
            $data = $entry['data'] ?? null;
        @endphp
        <div class="acremann-assistant-timeline-item">
            <div class="acremann-assistant-timeline-marker fi-color-{{ $meta['color'] }}">
                <x-filament::icon :icon="$meta['icon']" class="h-4 w-4" />
            </div>
            <div class="acremann-assistant-timeline-body">
                <div class="acremann-assistant-timeline-head">
                    <span class="acremann-assistant-timeline-title">{{ $meta['title'] }}</span>
                    @if($time = AssistantSession::formatEventTime($entry['at'] ?? null))
                        <time class="acremann-assistant-timeline-time" datetime="{{ $entry['at'] ?? '' }}">{{ $time }}</time>
                    @endif
                </div>
                @if(filled($entry['label'] ?? null))
                    <p class="acremann-assistant-timeline-label">{{ $entry['label'] }}</p>
                @endif
                @if(filled($entry['step'] ?? null) || filled($entry['journey'] ?? null))
                    <p class="acremann-assistant-timeline-meta">
                        @if(filled($entry['step'] ?? null))
                            <span>Step: {{ $entry['step'] }}</span>
                        @endif
                        @if(filled($entry['journey'] ?? null))
                            <span>Intent: {{ str_replace('_', ' ', $entry['journey']) }}</span>
                        @endif
                    </p>
                @endif
                @if(is_array($data) && $data !== [])
                    <dl class="acremann-assistant-timeline-data">
                        @foreach($data as $key => $value)
                            @if(filled($value) && ! in_array($key, ['consent'], true))
                                <div>
                                    <dt>{{ ucfirst(str_replace('_', ' ', (string) $key)) }}</dt>
                                    <dd>{{ is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value }}</dd>
                                </div>
                            @endif
                        @endforeach
                    </dl>
                @endif
            </div>
        </div>
    @empty
        <div class="acremann-assistant-timeline-empty">
            <x-filament::icon icon="heroicon-o-chat-bubble-left-ellipsis" class="h-8 w-8 text-gray-400" />
            <p>No events recorded for this session yet.</p>
        </div>
    @endforelse
</div>
