@if ($message = Session::get('primary'))
    <div x-data="{ open: true }" x-show="open" class="alert message-alert bg-blue-100 text-blue-800 border border-blue-400 rounded-lg p-4 relative" role="alert">
        {!! $message !!}
        <button @click="open = false" type="button" class="absolute top-0 bottom-0 right-0 mr-4 mt-2 text-blue-800 focus:outline-none" aria-label="Close">&times;</button>
    </div>
@endif

@if ($message = Session::get('success'))
    <div x-data="{ open: true }" x-show="open" class="alert message-alert bg-green-100 text-green-800 border border-green-400 rounded-lg p-4 relative" role="alert">
        {!! $message !!}
        <button @click="open = false" type="button" class="absolute top-0 bottom-0 right-0 mr-4 mt-2 text-green-800 focus:outline-none" aria-label="Close">&times;</button>
    </div>
@endif

@if ($message = Session::get('info'))
    <div x-data="{ open: true }" x-show="open" class="alert message-alert bg-blue-100 text-blue-800 border border-blue-400 rounded-lg p-4 relative" role="alert">
        {!! $message !!}
        <button @click="open = false" type="button" class="absolute top-0 bottom-0 right-0 mr-4 mt-2 text-blue-800 focus:outline-none" aria-label="Close">&times;</button>
    </div>
@endif

@if ($message = Session::get('warning'))
    <div x-data="{ open: true }" x-show="open" class="alert message-alert bg-yellow-100 text-yellow-800 border border-yellow-400 rounded-lg p-4 relative" role="alert">
        {!! $message !!}
        <button @click="open = false" type="button" class="absolute top-0 bottom-0 right-0 mr-4 mt-2 text-yellow-800 focus:outline-none" aria-label="Close">&times;</button>
    </div>
@endif

@if ($message = Session::get('error'))
    <div id="error_alert" x-data="{ open: true }" x-show="open" class="alert message-alert bg-red-100 text-red-800 border border-red-400 rounded-lg p-4 relative" role="alert">
        {!! $message !!}
        <button @click="open = false" type="button" class="absolute top-0 bottom-0 right-0 mr-4 mt-2 text-red-800 focus:outline-none" aria-label="Close">&times;</button>
    </div>
@endif

@if ($message = Session::get('verify-error'))
    <div x-data="{ open: true }" x-show="open" class="alert message-alert bg-red-100 text-red-800 border border-red-400 rounded-lg p-4 relative" role="alert">
        {!! $message !!}
        <button @click="open = false" type="button" class="absolute top-0 bottom-0 right-0 mr-4 mt-2 text-red-800 focus:outline-none" aria-label="Close">&times;</button>
    </div>
@endif
