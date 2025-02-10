<section class="bg-[#f5f5f7]">
	<div class="max-w-screen-xl mx-auto py-[30px] md:py-[60px] lg:px-0 px-5">
		<div class="flex items-center justify-between mb-1 lg:flex-row flex-col">
			<h2 class="text-[#333] text-[30px] font-[700] lg:mb-0">Success Stories</h2>
			<button class="bg-[#FE7300] rounded-lg text-white text-base font-medium min-w-[180px] py-2 px-3 lg:block hidden" data-modal-target="share-modal" data-modal-toggle="share-modal">Share Your Story</button>
		</div>

		
		<div class="grid lg:grid-cols-3 gap-6 lg:mb-0 mb-6">
		@foreach($product['SuccessStory'] as $k=>$v)
			
			<div>
				<div class="rounded-[24px] relative overflow-hidden mb-6">
					<img src="{{ $v['image']!=''?url('storage/'.$v['image']):'/img/image-1.png' }}" alt="" class="w-full" />
					<div class="absolute top-0 bottom-0 left-0 right-0 z-10 flex items-center justify-center cursor-pointer" data-modal-target="video-modal-{{ $v['id'] }}" data-modal-toggle="video-modal-{{ $v['id'] }}">
						<x-icons.play />

					</div>
				</div>
				<div>
					<p class="text-base font-bold text-[#00838f] mb-3">Success Story</p>

					<h4 class="text-[24px] leading-8 font-bold text-black mb-6">{{ $v['title'] }}</h4>
					<a data-modal-target="story-modal-{{ $v['id'] }}"  data-modal-toggle="story-modal-{{ $v['id'] }}" class="text-sm font-light text-[#00838f] mb-3 flex items-center underline group cursor-pointer">Read Full Story <x-icons.next-arrow-blue /> </a>
				</div>
			</div>
			
			@endforeach
		</div>
		

</section>

<!-- Main modal -->
<div id="share-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
	<div class="relative p-4 w-full max-w-2xl max-h-full">
		<!-- Modal content -->
		<div class="relative bg-white rounded-lg shadow">
			<!-- Modal header -->
			<div class="flex items-center justify-between absolute right-0 mt-[-16px] me-[-12px]">
				<button type="button" class="text-white bg-[#00838f] w-[40px] h-[40px] rounded-full hover:bg-[#FE7300] hover:text-white text-sm ms-auto inline-flex justify-center items-center" data-modal-hide="share-modal">

					<x-icons.close /> 

					<span class="sr-only">Close modal</span>
				</button>
			</div>
			<!-- Modal body -->
			<div class="p-4 md:p-6 space-y-4">

				<form class="max-w-sm mx-auto" method="post" action="{{ route('add-success-story') }}" enctype='multipart/form-data'>
				 <input type="hidden" value="<?= csrf_token() ?>" name="_token">
					<div class="mb-5">
						<label for="title" class="block mb-2 text-sm font-medium text-gray-900">Add Title</label>
						<input  type="text"  name="title" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="" required />
					</div>
					<div class="mb-5">
						<label for="image" class="block mb-2 text-sm font-medium text-gray-900">Upload File</label>
						<input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" id="image"  name="image"type="file">
					</div>
					<div class="mb-5">
						<label for="youtube" class="block mb-2 text-sm font-medium text-gray-900">Youtube Link</label>
						<input type="text" name="youtube" id="youtube" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="" required />
					</div>
					<div class="mb-5">
						<label for="story" class="block mb-2 text-sm font-medium text-gray-900">Your Story</label>
						<textarea id="story" name="story" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Write your success story here..."></textarea>
					</div>		
					<input type="hidden" name="product_id" value="{{ $product['id'] ?? '' }}">
					<input type="hidden" name="product_slug" value="{{ $product['slug'] ?? '' }}">

					<button type="submit" class="text-white bg-[#FE7300] hover:bg-[#FE7300] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
				</form>

			</div>
		</div>
	</div>
</div>


<!-- Main modal -->
@foreach($product['SuccessStory'] as $k=>$v)
<div id="video-modal-{{ $v['id'] }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">

	<div class="relative p-4 w-full max-w-2xl max-h-full">
		<!-- Modal content -->
		<div class="relative bg-white rounded-lg shadow">
			<!-- Modal header -->
			<div class="flex items-center justify-between absolute right-0 mt-[-16px] me-[-12px]">

				<button type="button" class="text-white bg-[#00838f] w-[40px] h-[40px] rounded-full hover:bg-[#FE7300] hover:text-white text-sm ms-auto inline-flex justify-center items-center" data-modal-hide="video-modal-{{ $v['id'] }}">
					<x-icons.close /> 

					<span class="sr-only">Close modal</span>
				</button>
			</div>
			<!-- Modal body -->
			<div class="p-4 md:p-6 space-y-4">

				<iframe class="w-full aspect-video rounded-lg" src="{{ $v['youtube'] }}" title="{{ $v['title'] }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
			</div>
		</div>
	</div>
</div>

<div id="story-modal-{{ $v['id'] }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
	<div class="relative p-4 w-full max-w-2xl max-h-full">
		<!-- Modal content -->
		<div class="relative bg-white rounded-lg shadow">
			<!-- Modal header -->
			<div class="flex items-center justify-between absolute right-0 mt-[-16px] me-[-12px]">
				<button type="button" class="text-white bg-[#00838f] w-[40px] h-[40px] rounded-full hover:bg-[#FE7300] hover:text-white text-sm ms-auto inline-flex justify-center items-center" data-modal-hide="story-modal-{{ $v['id'] }}">
					<x-icons.close /> 
					<span class="sr-only">Close modal</span>
				</button>
			</div>
			<!-- Modal body -->
			<div class="p-4 md:p-6 space-y-4">
				{{ $v['story'] }}
			</div>
		</div>
	</div>
</div>
@endforeach

