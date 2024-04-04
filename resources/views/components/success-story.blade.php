<section class="bg-[#f5f5f7]">
	<div class="max-w-screen-xl mx-auto py-[30px] md:py-[60px] lg:px-0 px-5">
		<div class="flex items-center justify-between mb-10 lg:flex-row flex-col">
			<h2 class="text-[#333] text-[30px] font-[700] lg:mb-0">Success Stories</h2>
			<button class="bg-[#FE7300] rounded-lg text-white text-base font-medium min-w-[180px] p-4 lg:block hidden" data-modal-target="share-modal" data-modal-toggle="share-modal">Share Your Story</button>
		</div>
		<div class="grid lg:grid-cols-3 gap-6 lg:mb-0 mb-6">
			<div>
				<div class="rounded-[24px] relative overflow-hidden mb-6">
					<img src="/img/image-1.png" alt="" class="w-full" />
					<div class="absolute top-0 bottom-0 left-0 right-0 z-10 flex items-center justify-center cursor-pointer" data-modal-target="video-modal" data-modal-toggle="video-modal">
						<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50" fill="none">
							<path d="M18.1818 14.7727V35.2273L35.2272 25L18.1818 14.7727Z" stroke="white" stroke-width="1.5" stroke-linejoin="round" />
							<circle cx="25" cy="25" r="24" stroke="white" stroke-width="2" />
						</svg>
					</div>
				</div>
				<div>
					<p class="text-base font-bold text-[#008C99] mb-3">Success Story</p>
					<h4 class="text-[24px] leading-8 font-bold text-black mb-6">Lorem Ipsum is simply dummy text
						of the printing and industry. </h4>
					<a href="#" class="text-sm font-light text-[#008C99] mb-3 flex items-center underline group">Read Full Story <svg class="ms-2 translate-x-0 relative transition duration-150 ease-in-out group-hover:transition group-hover:duration-150 group-hover:ease-in-out group-hover:translate-x-2" xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10" fill="none">
							<path d="M11 5H1" stroke="#008C99" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
							<path d="M7 9L11 5L7 1" stroke="#008C99" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
						</svg></a>
				</div>
			</div>
			<div class="flex items-center justify-between mb-10 lg:flex-row flex-col" data-modal-target="share-modal" data-modal-toggle="share-modal">
				<button class="bg-[#FE7300] rounded-lg text-white text-base font-medium lg:min-w-[180px] w-full p-4 lg:hidden block">Share Your Story</button>
			</div>
		</div>
</section>

<!-- Main modal -->
<div id="share-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
	<div class="relative p-4 w-full max-w-2xl max-h-full">
		<!-- Modal content -->
		<div class="relative bg-white rounded-lg shadow">
			<!-- Modal header -->
			<div class="flex items-center justify-between absolute right-0 mt-[-16px] me-[-12px]">
				<button type="button" class="text-white bg-[#008c99] w-[40px] h-[40px] rounded-full hover:bg-[#FE7300] hover:text-white text-sm ms-auto inline-flex justify-center items-center" data-modal-hide="share-modal">
					<svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
					</svg>
					<span class="sr-only">Close modal</span>
				</button>
			</div>
			<!-- Modal body -->
			<div class="p-4 md:p-6 space-y-4">
				<form class="max-w-sm mx-auto">
					<div class="mb-5">
						<label for="title" class="block mb-2 text-sm font-medium text-gray-900">Add Title</label>
						<input type="title" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="" required />
					</div>
					<div class="mb-5">
						<label for="image" class="block mb-2 text-sm font-medium text-gray-900">Upload File</label>
						<input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" aria-describedby="user_avatar_help" id="user_avatar" type="file">
					</div>
					<div class="mb-5">
						<label for="video" class="block mb-2 text-sm font-medium text-gray-900">Add Video Link</label>
						<input type="video" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="" required />
					</div>
					<div class="mb-5">
						<label for="message" class="block mb-2 text-sm font-medium text-gray-900">Your message</label>
						<textarea id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Leave a comment..."></textarea>
					</div>					
					<button type="submit" class="text-white bg-[#FE7300] hover:bg-[#FE7300] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
				</form>

			</div>
		</div>
	</div>
</div>
<!-- Main modal -->
<div id="video-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
	<div class="relative p-4 w-full max-w-2xl max-h-full">
		<!-- Modal content -->
		<div class="relative bg-white rounded-lg shadow">
			<!-- Modal header -->
			<div class="flex items-center justify-between absolute right-0 mt-[-16px] me-[-12px]">
				<button type="button" class="text-white bg-[#008c99] w-[40px] h-[40px] rounded-full hover:bg-[#FE7300] hover:text-white text-sm ms-auto inline-flex justify-center items-center" data-modal-hide="video-modal">
					<svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
					</svg>
					<span class="sr-only">Close modal</span>
				</button>
			</div>
			<!-- Modal body -->
			<div class="p-4 md:p-6 space-y-4">
				<iframe class="w-full aspect-video rounded-lg" src="https://www.youtube.com/embed/-Yb6Ahx3gB8?si=VLqRP1cHtEV4cVVP" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
			</div>
		</div>
	</div>
</div>