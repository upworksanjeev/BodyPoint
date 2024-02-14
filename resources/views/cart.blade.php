<x-mainpage-layout>

    <section class="py-[30px] md:py-[60px]">
        <div class="ctm-container">
           Cart Details
		       @foreach ($cart as $ct)
                                {{ $ct['name'] ?? '' }}
                               
                            @endforeach
        </div>
    </section>
  


  
</x-mainpage-layout>
