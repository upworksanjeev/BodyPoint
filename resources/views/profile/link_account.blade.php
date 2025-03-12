<x-mainpage-layout>
    @section('title', 'Link Account - '.config('app.name', 'Bodypoint'))
    <x-cart-nav />

    <div class="">
        <div class="sm:px-3 lg:px-8">
                <div class="flex flex-col sm:justify-center items-center py-5 md:py-10">
                 @include('profile.partials.link-account')
                </div>
        </div>

    </div>
@push('other-scripts')
<script src="{{ asset('assets/js/cropper.js') }}"></script>
@endpush
</x-mainpage-layout>
