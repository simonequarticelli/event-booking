<x-mail::message>
# Hello {{ $user->name }}
## Below you will find the outcome of your transaction uuid: TODO

{{ $user }}
___
{{ $transaction }}
___
{{ $stateSlug }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
