<form action="{{ route('product-search') }}" method="post" id="formsearch">
<input type="hidden" value="<?= csrf_token() ?>" name="_token"> 
<div class="relative flex items-center w-full h-10 pl-5 pr-2 overflow-hidden ctm-search bg-[#f8f8f8] rounded-3xl">
   <input class="peer h-full w-full outline-none border-none focus:ring-0 text-sm text-gray-700 pr-2 bg-[#f8f8f8]"
        type="text" id="searchinput" name="searchinput" placeholder="Search" />
    <div class="grid place-items-center h-full w-12" id="searchicon">
	<x-icons.search />
    </div>
</div>
</form>