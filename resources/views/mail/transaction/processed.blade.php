<x-mail::message>
## Hello {{ $user->name }}

Below you will find the outcome of your transaction

UUID: ***{{$transaction->uuid}}***<br>
State: ***{{$transaction->state->name}}***<br>
Amount: ***{{$transaction->amount}}€***<br>

## Tickets:
@foreach($transaction->tickets as $ticket)
- Event name: **{{$ticket->event->name}}**
- Venue: **{{$ticket->event->venue->name}}**
- Price: **{{$ticket->price}}€**
___
@endforeach
<br>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
