<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link @if(request()->url() == route('events.show', $eventId)) active @elseif(request()->url() == route('events.show.edit', $eventId)) active @endif"
           href="{{ route('events.show', $eventId) }}">Event</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(request()->url() == route('events.show.comments', $eventId)) active @endif"
           href="{{ route('events.show.comments', $eventId) }}">Comments</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(request()->url() == route('events.show.questions', $eventId)) active @endif"
           href="{{ route('events.show.questions', $eventId) }}">Questions</a>
    </li>
</ul>
