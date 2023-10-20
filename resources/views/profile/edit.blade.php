<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#008c99] leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="sm:px-6 lg:px-8 space-y-6">
          
                <div class="min-h-[65vh]  flex flex-col sm:justify-center items-center pt-10 pb-10 mt-4 sm:pt-0 ">
                 @include('profile.partials.update-user-form')
                </div> 
        </div>

    </div>

</x-app-layout>
