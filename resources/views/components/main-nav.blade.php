 <nav x-data="{ open: false }">
     <div class="ctm-pt relative flex flex-wrap items-center justify-between pb-3">

         <div
             class="inset-y-0 left-0 flex items-center lg:hidden justify-end lg:justify-start w-6/12 lg:w-1/12 xl:w-1/12">
             <!-- Mobile menu button-->
             <button @click="open = ! open"
                 class="inline-flex items-center justify-center py-2 rounded-md text-white hover:text-white focus:outline-none focus:ring-2 focus:ring-inset transition ease-in-out duration-150 text-[40px]">
                 <x-icons.mobile-menu />
             </button>
         </div>
         <div
             class="flex flex-1 items-center justify-start order-first lg:order-none lg:justify-between shift-logo w-6/12 lg:w-6/12 xl:w-9/12 ">
             <div class="flex flex-shrink-0 items-center">
                 <a href="{{ config('bodypoint.home_url') }}"> <img class="h-[38px] md:h-[45px] w-auto"
                         src="{{ asset('img/logo-1.png') }}" alt="Body Point" /> </a>
             </div>
             <div class="hidden sm:ml-6 lg:block">
                 <div class="flex space-x-4 nav-links mr-5 ">
                     <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                     <div class="dropdown flex">
                         <a href="{{ route('home') }}"
                             class="px-2 py-2 font-thin text-[18px] text-white hover:text-[#fe7300] transition duration-150 ease-in-out"
                             aria-current="page">Products <i class="fa fa-chevron-down text-[14px]"></i></a>
                         <div class="dropdown-content">
                             <h5 class="ctmH2 text-[22px] text-[#00838f] font-[500] mb-4">Products</h5>

                             <div class="ctm-grd-one">
                                 <div class="ctm-grd-two">
                                     <a class="" href="<?php echo url('/category/upper-body'); ?>">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Upper Body.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px] text-[#333] hover:text-[#00838f] mb-2"
                                             href="<?php echo url('/category/upper-body'); ?>">Upper Body</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/upper-body/4-point-upper-body-support'); ?>">4 Point Upper Body Support</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/upper-body/2-point-upper-body-support'); ?>">2 Point Upper Body Support</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/upper-body/arm-supports'); ?>">Arm Supports</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/upper-body/upper-body-options'); ?>">Upper Body Options</a></p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="<?php echo url('/category/pelvic-positioning'); ?>">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Pelvic Positioning.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="<?php echo url('/category/pelvic-positioning'); ?>">Pelvic Positioning</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/pelvic-positioning/hip-belts'); ?>">Hip Belts</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/pelvic-positioning/leg-harnesses'); ?>">Leg Harnesses</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/pelvic-positioning/options'); ?>">Pelvic Positioning Options</a></p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="<?php echo url('/category/lower-body'); ?>">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Lower Body.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="<?php echo url('/category/lower-body'); ?>">Lower Body</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/lower-body/ankle-huggers'); ?>">Ankle Huggers</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/lower-body/calf-supports'); ?>">Calf Supports</a></p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="<?php echo url('/category/power-chair-components'); ?>">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Powerchair.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="<?php echo url('/category/power-chair-components'); ?>">Power Chair Components</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/power-chair-components/joystick-handles'); ?>">Joystick Handles</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/power-chair-components/midline-joystick-mounting'); ?>">Midline Joystick Mounting</a></p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="<?php echo url('/category/bath-and-shower'); ?>">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Shower.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="<?php echo url('/category/bath-and-shower'); ?>">Bath and Shower</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/bath-and-shower/aeromesh-bath-belt'); ?>">Aeromesh Bath Belt</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/bath-and-shower/shower-chair-calf-supports'); ?>">Shower Chair Calf Supports</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/bath-and-shower/bath-and-shower-options'); ?>">Bath and Shower Options</a></p>
                                     </div>
                                 </div>

                                 <div class="ctm-grd-two">
                                     <a class="" href="<?php echo url('/category/hardware'); ?>">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Hardware.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="<?php echo url('/category/hardware'); ?>">Hardware</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/hardware/clamps'); ?>">Clamps</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/hardware/mounting-attachments'); ?>">Mounting Attachments</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/hardware/hardware-options'); ?>">Hardware Options</a></p>

                                     </div>
                                 </div>

                                 <div class="ctm-grd-two">
                                     <a class="" href="<?php echo url('/category/tool-free-accessories'); ?>">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Specialty.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="<?php echo url('/category/tool-free-accessories'); ?>">Tool-Free Accessories</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/tool-free-accessories/elastic-mobility-straps'); ?>">Elastic Mobility Straps</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/tool-free-accessories/lifestyle'); ?>">Lifestyle</a></p>
                                     </div>
                                 </div>

                             </div>
                         </div>
                     </div>

                     <div class="dropdown flex">
                         <a href="{{ config('bodypoint.home_url') }}/company-overview/"
                             class="px-2 py-2 font-thin text-[18px] text-white hover:text-[#fe7300] transition duration-150 ease-in-out"
                             aria-current="page">About <i class="fa fa-chevron-down text-[14px]"></i></a>
                         <div class="dropdown-content">
                             <h5 class="ctmH2 text-[22px] text-[#00838f]  font-[500]">About</h5>

                             <div class="ctm-grd-one">

                                 <div class="ctm-grd-two">
                                     <a class="" href="{{ config('bodypoint.home_url') }}/company-overview/">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/overview.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/company-overview/">Overview</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Every wheeler deserves all the
                                             safety, comfort and function we can provide.</p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="{{ config('bodypoint.home_url') }}/quality-policy/">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Quality Policy.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/quality-policy/">Quality
                                             Policy</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Our supports are tested to
                                             ANSI/RESNA, EN and ISO standards.</p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="{{ config('bodypoint.home_url') }}/company-culture/">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Culture.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/company-culture/">Culture</a>
                                         <p class="text-[14px] text-[#333] font-[400]">We celebrate innovation, while
                                             fostering consistency.</p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="{{ config('bodypoint.home_url') }}/standards/">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Standards.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/standards/">Standards</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Standards illuminate the
                                             performance of our products.</p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="{{ config('bodypoint.home_url') }}/events/">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Events.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/events/">Events</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Stop by and chat!</p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="{{ config('bodypoint.home_url') }}/advocacy/">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/ADVOCACY - Web Icons.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/advocacy/">Advocacy</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Bodypoint interacts with the
                                             industry, community and users.</p>


                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="{{ config('bodypoint.home_url') }}/success-stories/">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Success Stories.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/success-stories/">Success
                                             Stories</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Our postural supports change
                                             lives.</p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="{{ config('bodypoint.home_url') }}/newsletter/">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Newsletter.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/newsletter/">Newsletter</a>
                                         <p class="text-[14px] text-[#333] font-[400]">To the Point - News that
                                             supports you!</p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                         href="{{ config('bodypoint.home_url') }}/contact-us/">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Contact.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/contact-us/">Contact Us</a>
                                         <p class="text-[14px] text-[#333] font-[400]">How can we help?</p>

                                     </div>
                                 </div>





                             </div>
                         </div>
                     </div>
                     <div class="dropdown flex">
                         <a href="{{ config('bodypoint.home_url') }}/resources/"
                             class="px-2 py-2 font-thin text-[18px] text-white hover:text-[#fe7300] transition duration-150 ease-in-out"
                             aria-current="page">Resources <i class="fa fa-chevron-down text-[14px]"></i></a>
                         <div class="dropdown-content">
                             <h5 class="ctmH2 text-[22px] text-[#00838f]  font-[500] mb-5">Resources</h5>

                             <div class="grid grid-cols-4 column-gap gap-x-4 gap-y-2">
                                 <div class="ctm-grd-two">
                                     <a class="" href="{{ config('bodypoint.home_url') }}/faqs/">
                                         <div class="prd-img px-2 rounded flex items-start justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/FAQ - Web Icons.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/faqs/">FAQ's</a>
                                         <p class="text-[14px] text-[#333] font-[400]">
                                         </p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class=""
                                         href="{{ config('bodypoint.home_url') }}/why-positioning-matters/">
                                         <div class="prd-img px-2 rounded flex items-start justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/wheelchair.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/why-positioning-matters/">Positioning
                                             Matters</a>
                                         <p class="text-[14px] text-[#333] font-[400]"></p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="{{ config('bodypoint.home_url') }}/literature/">
                                         <div class="prd-img px-2 rounded flex items-start justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/LITERATURE - Icons.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>

                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/literature/">Literature</a>
                                         <p class="text-[14px] text-[#333] font-[400]">
                                         </p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="<?php echo url('/category/dealer-tools-&-accessories'); ?>">
                                         <div class="prd-img px-2 rounded flex items-start justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Dealer Tools.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="<?php echo url('/category/dealer-tools-&-accessories'); ?>">Dealer Tools</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/all-tools'); ?>"></a></p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                         href="{{ config('bodypoint.home_url') }}/terms-conditions/">
                                         <div class="prd-img px-2 rounded flex items-start justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Terms and Conditions.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/terms-conditions/">Terms &
                                             Conditions</a>
                                         <p class="text-[14px] text-[#333] font-[400]"></p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="{{ config('bodypoint.home_url') }}/education-series/">
                                         <div class="prd-img px-2 rounded flex items-start justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/_Education Series.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/education-series/">Education
                                             Series</a>
                                         <p class="text-[14px] text-[#333] font-[400]"></p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="https://www.youtube.com/user/BodypointInc">
                                         <div class="prd-img px-2 rounded flex items-start justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Training.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="https://www.youtube.com/user/BodypointInc">Training</a>
                                         <p class="text-[14px] text-[#333] font-[400]"></p>

                                     </div>
                                 </div>




                                 <div class="ctm-grd-two">
                                     <a class="" href="{{ config('bodypoint.home_url') }}/feedback/">
                                         <div class="prd-img px-2 rounded flex items-start justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Feedback.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/feedback/">Leave Feedback</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/all-tools'); ?>"></a></p>

                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>

                     </ul>
                 </div>
             </div>
         </div>
         <div
             class="hidden flex items-center pr-2 sm:static sm:inset-auto sm:pr-0 w-full lg:w-2/12 xl:w-2/12 lg:block">

             <x-header-search class='w-full' />

         </div>
     </div>

     <!-- Responsive Navigation Menu -->
     <div :class="{ 'block': open, 'hidden': !open }"
         class="mobileLeft-Sidebar hidden transition ease-in-out duration-300" id="mySidepanel" x-show="open"
         x-transition x-transition:duration.500ms>


         <!-- Responsive Settings Options -->
         <div class="pt-6 pb-1 border-t border-gray-200">
             <div class="space-y-1 px-2 pb-3 pt-2">
                 <div class="space-y-1 px-2 pb-3 h-77">
                     <a class="closebtn text-[#333] text-[22px] absolute top-[15px] right-[15px] cursor-pointer"
                         @click="open = ! open">X</a>
                 </div>
                 @if (!Auth::check())
                 <div class="px-3 py-2">
                     <x-responsive-nav-link :href="route('login')">
                         <button
                             class="rounded-lg flex items-center text-[#333] text-[18px] font-light hover:text-[#fe7300] transition duration-150 ease-in-out">
                             <i class="fa fa-lock pr-2 text-[18px]"></i> {{ __('Partner Login') }}
                         </button>
                     </x-responsive-nav-link>
                 </div>
                 @endif

                 <div class="mobile-dropdown" x-data="{ open: false, toggle() { this.open = !this.open } }">
                     <x-nav-link-custom @click="toggle()"
                         classes="transition ease-in-out duration-150 rounded-md px-3 font-light text-[#333] hover:text-[#fe7300] block py-2 text-[18px] font-[300] flex justify-between items-center cursor-pointer"
                         aria-current="page">
                         {{ __('Products') }} <i class="fa fa-caret-down"></i>
                         </x-responsive-nave-link>
                         <div class="mobile-dropdown-content" x-show="open">

                             <div class="ctm-grd-one">
                                 <div class="ctm-grd-two">
                                     <a class="" href="<?php echo url('/category/upper-body'); ?>">
                                         <div
                                             class="prd-img px-2 rounded flex items-center justify-center   bg-[#fff]">
                                             <img class="" src="{{ asset('img/Upper Body.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px] text-[#333] hover:text-[#00838f] mb-2"
                                             href="<?php echo url('/category/upper-body'); ?>">Upper Body</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/upper-body/4-point-upper-body-support'); ?>">4 Point Upper Body Support</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/upper-body/2-point-upper-body-support'); ?>">2 Point Upper Body Support</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/upper-body/arm-supports'); ?>">Arm Supports</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/upper-body/upper-body-options'); ?>">Upper Body Options</a></p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="<?php echo url('/category/pelvic-positioning'); ?>">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Pelvic Positioning.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="<?php echo url('/category/pelvic-positioning'); ?>">Pelvic Positioning</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/pelvic-positioning/hip-belts'); ?>">Hip Belts</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/pelvic-positioning/leg-harnesses'); ?>">Leg Harnesses</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/pelvic-positioning/options'); ?>">Pelvic Positioning Options</a></p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="<?php echo url('/category/lower-body'); ?>">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Lower Body.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="<?php echo url('/category/lower-body'); ?>">Lower Body</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/lower-body/ankle-huggers'); ?>">Ankle Huggers</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/lower-body/calf-supports'); ?>">Calf Supports</a></p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="<?php echo url('/category/power-chair-components'); ?>">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Powerchair.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="<?php echo url('/category/power-chair-components'); ?>">Power Chair Components</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/joystick-handles'); ?>">Joystick Handles</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/midline-joystick-mounting'); ?>">Midline Joystick Mounting</a></p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="<?php echo url('/category/bath-and-shower'); ?>">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Shower.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="<?php echo url('/category/bath-and-shower'); ?>">Bath and Shower</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/bath-and-shower/aeromesh-bath-belt'); ?>">Aeromesh Bath Belt</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/bath-and-shower/shower-chair-calf-supports'); ?>">Shower Chair Calf Supports</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/bath-and-shower/bath-and-shower-options'); ?>">Bath and Shower Options</a></p>
                                     </div>
                                 </div>

                                 <div class="ctm-grd-two">
                                     <a class="" href="<?php echo url('/category/hardware'); ?>">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Hardware.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="<?php echo url('/category/hardware'); ?>">Hardware</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/hardware/clamps'); ?>">Clamps</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/hardware/mounting-attachments'); ?>">Mounting Attachments</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/hardware/hardware-options'); ?>">Hardware Options</a></p>

                                     </div>
                                 </div>

                                 <div class="ctm-grd-two">
                                     <a class="" href="<?php echo url('/category/tool-free-accessories'); ?>">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Specialty.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="<?php echo url('/category/tool-free-accessories'); ?>">Tool-Free Accessories</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/tool-free-accessories/elastic-mobility-straps'); ?>">Elastic Mobility Straps</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/tool-free-accessories/lifestyle'); ?>">Lifestyle</a></p>

                                     </div>
                                 </div>

                             </div>


                         </div>

                 </div>

                 <div class="mobile-dropdown" x-data="{ open: false, toggle() { this.open = !this.open } }">
                     <x-nav-link-custom @click="toggle()"
                         classes="transition duration-150 ease-in-out rounded-md px-3 font-light text-[#333] hover:text-[#fe7300] block py-2 text-[18px] font-[300] flex justify-between items-center cursor-pointer"
                         aria-current="page">
                         {{ __('About') }} <i class="fa fa-caret-down"></i>
                         </x-responsive-nave-link>
                         <div class="mobile-dropdown-content" x-show="open">

                             <div class="ctm-grd-one">

                                 <div class="ctm-grd-two">
                                     <a class="" href="{{ config('bodypoint.home_url') }}/company-overview/">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/overview.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/company-overview/">Overview</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Every wheeler deserves all the
                                             safety, comfort and function we can provide.</p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="{{ config('bodypoint.home_url') }}/quality-policy/">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Quality Policy.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/quality-policy/">Quality
                                             Policy</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Our supports are tested to
                                             ANSI/RESNA, EN and ISO standards.</p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="{{ config('bodypoint.home_url') }}/company-culture/">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Culture.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/company-culture/">Culture</a>
                                         <p class="text-[14px] text-[#333] font-[400]">We celebrate innovation, while
                                             fostering consistency.</p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="{{ config('bodypoint.home_url') }}/standards/">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Standards.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/standards/">Standards</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Standards illuminate the
                                             performance of our products.</p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="{{ config('bodypoint.home_url') }}/events/">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Events.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/events/">Events</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Stop by and chat!</p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="{{ config('bodypoint.home_url') }}/advocacy/">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/ADVOCACY - Web Icons.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/advocacy/">Advocacy</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Bodypoint interacts with the
                                             industry, community and users.</p>


                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="{{ config('bodypoint.home_url') }}/success-stories/">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Success Stories.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/success-stories/">Success
                                             Stories</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Our postural supports change
                                             lives.</p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="{{ config('bodypoint.home_url') }}/newsletter/">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Newsletter.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/newsletter/">Newsletter</a>
                                         <p class="text-[14px] text-[#333] font-[400]">To the Point - News that
                                             supports you!</p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                         href="{{ config('bodypoint.home_url') }}/contact-us/">
                                         <div class="prd-img px-2 rounded flex items-center justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Contact.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/contact-us/">Contact Us</a>
                                         <p class="text-[14px] text-[#333] font-[400]">How can we help?</p>

                                     </div>
                                 </div>





                             </div>
                         </div>
                 </div>


                 <div class="mobile-dropdown" x-data="{ open: false, toggle() { this.open = !this.open } }">
                     <x-nav-link-custom @click="toggle()"
                         classes="transition duration-150 ease-in-out rounded-md px-3 font-light text-[#333] hover:text-[#fe7300] block py-2 text-[18px] font-[300] flex justify-between items-center cursor-pointer"
                         aria-current="page">
                         {{ __('Resources') }} <i class="fa fa-caret-down"></i>
                         </x-responsive-nave-link>
                         <div class="mobile-dropdown-content" x-show="open">

                             <div class="ctm-grd-one">

                                 <div class="ctm-grd-two">
                                     <a class="" href="{{ config('bodypoint.home_url') }}/faqs/">
                                         <div class="prd-img px-2 rounded flex items-start justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/FAQ - Web Icons.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/faqs/">FAQ's</a>
                                         <p class="text-[14px] text-[#333] font-[400]">
                                         </p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class=""
                                         href="{{ config('bodypoint.home_url') }}/why-positioning-matters/">
                                         <div class="prd-img px-2 rounded flex items-start justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/wheelchair.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/why-positioning-matters/">Positioning
                                             Matters</a>
                                         <p class="text-[14px] text-[#333] font-[400]"></p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="{{ config('bodypoint.home_url') }}/literature/">
                                         <div class="prd-img px-2 rounded flex items-start justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/LITERATURE - Icons.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>

                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/literature/">Literature</a>
                                         <p class="text-[14px] text-[#333] font-[400]">
                                         </p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="<?php echo url('/category/dealer-tools-&-accessories'); ?>">
                                         <div class="prd-img px-2 rounded flex items-start justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Dealer Tools.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="<?php echo url('/category/dealer-tools-&-accessories'); ?>">Dealer Tools</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/all-tools'); ?>"></a></p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                         href="{{ config('bodypoint.home_url') }}/terms-conditions/">
                                         <div class="prd-img px-2 rounded flex items-start justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Terms and Conditions.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/terms-conditions/">Terms &
                                             Conditions</a>
                                         <p class="text-[14px] text-[#333] font-[400]"></p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="{{ config('bodypoint.home_url') }}/education-series/">
                                         <div class="prd-img px-2 rounded flex items-start justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/_Education Series.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/education-series/">Education
                                             Series</a>
                                         <p class="text-[14px] text-[#333] font-[400]"></p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <a class="" href="https://www.youtube.com/user/BodypointInc">
                                         <div class="prd-img px-2 rounded flex items-start justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Training.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="https://www.youtube.com/user/BodypointInc">Training</a>
                                         <p class="text-[14px] text-[#333] font-[400]"></p>

                                     </div>
                                 </div>




                                 <div class="ctm-grd-two">
                                     <a class="" href="{{ config('bodypoint.home_url') }}/feedback/">
                                         <div class="prd-img px-2 rounded flex items-start justify-center  bg-[#fff]">
                                             <img class="" src="{{ asset('img/Feedback.png') }}"
                                                 alt="Your Company" />
                                         </div>
                                     </a>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#00838f] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/feedback/">Leave Feedback</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#00838f]"
                                                 href="<?php echo url('/category/all-tools'); ?>"></a></p>

                                     </div>
                                 </div>
                             </div>
                         </div>
                 </div>

                 @if (Auth::check())
                 <div class="px-3 py-2">
                     <div class="pt-4 pb-1 border-t border-gray-200">
                         <div class="flex gap-4 items-center">
                             <div class="rounded-full h-[35px] w-[35px] overflow-hidden rounded-full">
                                 <img src="{{ FunHelper::getUserProfile() ? url('storage/' . FunHelper::getUserProfile()) : asset('img/profile.png') }}"
                                     class="h-[35px] w-[35px] rounded-full object-cover" alt="">
                             </div>
                             <div class="px-4">
                                 {{-- <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}
                             </div> --}}
                             <div class="font-medium text-base text-gray-800">{{ session()->get('customer_details') ? session()->get('customer_details')['CustomerName'] : "" }}</div>
                             <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                         </div>
                     </div>

                     <div class="mt-3 space-y-1">
                         {{-- @if (Auth::user()->hasPermissionTo('orderHistory')) --}}
                         <x-responsive-nav-link :href="route('order')">
                             {{ __('My Orders') }}

                         </x-responsive-nav-link>
                         {{-- @endif --}}
                         <x-responsive-nav-link :href="route('profile.edit')">
                             {{ __('Profile') }}
                         </x-responsive-nav-link>

                         <!-- Authentication -->
                         <form method="POST" action="{{ route('logout') }}">
                             @csrf

                             <x-responsive-nav-link :href="route('logout')"
                                 onclick="event.preventDefault();
                        this.closest('form').submit();">
                                 {{ __('Log Out') }}
                             </x-responsive-nav-link>
                         </form>
                     </div>
                 </div>
             </div>
             @endif
         </div>
     </div>
     </div>
     </div>
 </nav>