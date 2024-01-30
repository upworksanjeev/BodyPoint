 <nav x-data="{ open: false }">
     <div class="ctm-pt relative flex flex-wrap items-center justify-between pb-5">

         <div
             class="inset-y-0 left-0 flex items-center xl:hidden justify-end lg:justify-start w-6/12 lg:w-1/12 xl:w-1/12">
             <!-- Mobile menu button-->
             <button @click="open = ! open"
                 class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-white focus:outline-none focus:ring-2 focus:ring-inset transition ease-in-out duration-150 text-[40px]">
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48.43 26.94" class="fill-current h-4">
                     <defs>
                         <style>
                             .cls-1 {
                                 fill: #f8fbfb;
                             }

                             .cls-2 {
                                 fill: #fcfdfd;
                             }

                             .cls-3 {
                                 fill: #fefefe;
                             }
                         </style>
                     </defs>
                     <g id="Layer_2" data-name="Layer 2">
                         <g id="Layer_1-2" data-name="Layer 1">
                             <path class="cls-1"
                                 d="M24.2,11.29q10.64,0,21.28,0c1.53,0,3-.19,3,2.16s-1.36,2.2-2.92,2.2q-21.28,0-42.55,0c-1.54,0-2.95.19-3-2.16s1.37-2.2,2.93-2.19Q13.57,11.31,24.2,11.29Z" />
                             <path class="cls-2"
                                 d="M29.09,0H45.87c1.24,0,2.47-.19,2.54,1.76S47.46,4,45.89,4q-17,0-33.94,0c-1.42,0-2.38-.22-2.38-2s.92-2,2.36-2C17.65,0,23.37,0,29.09,0Z" />
                             <path class="cls-3"
                                 d="M32.72,26.93c-4.35,0-8.71,0-13.06,0-1.34,0-2.42,0-2.41-1.88,0-1.7.73-2.1,2.25-2.1Q32.74,23,46,23c1.36,0,2.35.11,2.41,1.93.07,2.13-1.18,2.05-2.63,2C41.43,26.91,37.07,26.93,32.72,26.93Z" />
                         </g>
                     </g>
                 </svg>

             </button>
         </div>
         <div
             class="flex flex-1 items-center justify-start order-first lg:order-none lg:justify-between shift-logo w-6/12 lg:w-6/12 xl:w-9/12 pb-1">
             <div class="flex flex-shrink-0 items-center">
                 <a href="{{ config('bodypoint.home_url') }}"> <img class="h-14 w-auto"
                         src="{{ asset('img/logo-1.png') }}" alt="Body Point" /> </a>
             </div>
             <div class="hidden sm:ml-6 lg:block">
                 <div class="flex space-x-4 nav-links mr-5 ">
                     <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                     <div class="dropdown flex">
                         <a href="#"
                             class="px-2 py-2 font-normal text-[18px] text-white hover:text-[#fe7300] transition duration-150 ease-in-out"
                             aria-current="page">Products <i class="fa fa-chevron-down text-[14px]"></i></a>
                         <div class="dropdown-content">
                             <h5 class="ctmH2 text-[22px] text-[#008C99]  font-[500]">Product</h5>

                             <div class="ctm-grd-one">

                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class="" src="{{ asset('img/c-one-1.png') }}" alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="<?php echo url('/category/upper-body'); ?>">Upper Body asas</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/shoulder-harness'); ?>">Shoulder Harness</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/chest-support'); ?>">Chest Support</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/options'); ?>">Options</a></p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class="" src="{{ asset('img/c-two.png') }}" alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="<?php echo url('/category/pelvic-positioning'); ?>">Pelvic Positioning</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/hip-belts'); ?>">Hip Belts</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/leg-harness'); ?>">Leg Harness</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/essentials-hip-belt'); ?>">Essentials Hip Belt</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/options'); ?>">Options</a></p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class="" src="{{ asset('img/speciality.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="<?php echo url('/category/specialty'); ?>">Specialty</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/shower'); ?>">Shower</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/pediatric'); ?>">Pediatric</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/sports-and-active-users'); ?>">Sports and Active Users</a></p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class="" src="{{ asset('img/c-four.png') }}" alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="<?php echo url('/category/power-chair-components'); ?>">Power Chair Components</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/midline-joystick-mounting'); ?>">Midline Joystick Mounting</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/joystick-handles'); ?>">Joystick Handles</a></p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class="" src="{{ asset('img/c-five.png') }}" alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="<?php echo url('/category/hardware'); ?>">Hardware</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/clamps'); ?>">Clamps</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/mounting-attachments'); ?>">Mounting Attachments</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/options'); ?>">Options</a></p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class="" src="{{ asset('img/c-three.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="<?php echo url('/category/lower-body'); ?>">Lower Body</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/ankle-huggers'); ?>">Ankle Huggers</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/calf-supports'); ?>">Calf Supports</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/universal-elastic-strap'); ?>">Universal Elastic Strap</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/options'); ?>">Options</a></p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class="" src="{{ asset('img/c-three.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="<?php echo url('/category/dealer-tools-&-accessories'); ?>">Dealer Tools & Accessories</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/all-tools'); ?>">All Tools</a></p>

                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="dropdown flex">
                         <a href="#"
                             class="px-2 py-2 font-normal text-[18px] text-white hover:text-[#fe7300] transition duration-150 ease-in-out"
                             aria-current="page">Wheelchair Positing <i
                                 class="fa fa-chevron-down text-[14px]"></i></a>
                         <div class="dropdown-content">
                             <h5 class="ctmH2 text-[22px] text-[#008C99]  font-[500]">Positions Are Personal</h5>
                             <p class="text-[#333] pt-[5px] text-[16px] mb-5">One person, one chair, one position.</p>
                             <div class="ctm-grd-one">
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class=""
                                             src="{{ asset('img/wheelchair-positioning-removebg-preview-1.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/why-positioning-matters/">Why
                                             Positioning Matters</a>
                                         <p class="text-[14px] text-[#333] font-[400]">We improve users' safety,
                                             comfort and function.</p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class=""
                                             src="{{ asset('img/wheelchair-standards-removebg-preview.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/standards/">Wheelchair Seating
                                             Standards</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Standards illuminate the
                                             performance of our products.</p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class=""
                                             src="{{ asset('img/success-stories-removebg-preview-1.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/success-stories/">Success
                                             Stories</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Our postural supports change
                                             lives.</p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class="" src="{{ asset('img/advocacy-removebg-preview.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/advocacy/">Advocacy</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Bodypoint interacts with the
                                             industry, community and users.</p>


                                     </div>
                                 </div>


                             </div>
                         </div>
                     </div>
                     <div class="dropdown flex">
                         <a href="#"
                             class="px-2 py-2 font-normal text-[18px] text-white hover:text-[#fe7300] transition duration-150 ease-in-out"
                             aria-current="page">Resources <i class="fa fa-chevron-down text-[14px]"></i></a>
                         <div class="dropdown-content">
                             <h5 class="ctmH2 text-[22px] text-[#008C99]  font-[500]">Learn about Bodypoint and
                                 postural support</h5>
                             <p class="text-[#333] pt-[5px] text-[16px] mb-5">Improve the independence, comfort and
                                 safety of children and adults who use wheelchairs and other mobility devices.</p>
                             <div class="ctm-grd-one">
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class="" src="{{ asset('img/literature-removebg-preview.png') }}"
                                             alt="Your Company" />
                                     </div>

                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/literature/">Literature</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Catalog and clinical information
                                         </p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class=""
                                             src="{{ asset('img/customer-service-removebg-preview.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="https://www.youtube.com/user/BodypointInc">Training</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Product and how-to videos</p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class="" src="{{ asset('img/faq-removebg-preview.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/faqs/">FAQs</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Product and ordering questions
                                         </p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class=""
                                             src="{{ asset('img/terms-and-conditions-removebg-preview.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/terms-conditions/">Terms &
                                             Conditions</a>
                                         <p class="text-[14px] text-[#333] font-[400]">BP trademarks, warranty, and
                                             policies</p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class="" src="{{ asset('img/contact-us-removebg-preview.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/contact-us/">Contact Us</a>
                                         <p class="text-[14px] text-[#333] font-[400]">How can we help?</p>

                                     </div>
                                 </div>

                             </div>
                         </div>
                     </div>
                     <div class="dropdown flex">
                         <a href="#"
                             class="px-2 py-2 font-normal text-[18px] text-white hover:text-[#fe7300] transition duration-150 ease-in-out"
                             aria-current="page">About Us <i class="fa fa-chevron-down text-[14px]"></i></a>
                         <div class="dropdown-content">
                             <h5 class="ctmH2 text-[22px] text-[#008C99]  font-[500]">About Us</h5>
                             <p class="text-[#333] pt-[5px] text-[16px] mb-5">“At Bodypoint, we work every day to
                                 better understand the capabilities and aspirations of people who use wheelchairs. As we
                                 imagine, design and manufacture our products, we strive to bridge the gap between the
                                 hard and the soft, the inanimate and the living, to create a better connection between
                                 wheelchairs and people.”
                                 – David Hintzman, Co-Founder </p>
                             <div class="ctm-grd-one">
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class=""
                                             src="{{ asset('img/company-overview-removebg-preview-1.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/company-overview/">Overview</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Every wheeler deserves all the
                                             safety, comfort and function we can provide.</p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class="" src="{{ asset('img/quality-removebg-preview.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/quality-policy/">Quality
                                             Policy</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Our supports are tested to
                                             ANSI/RESNA, EN and ISO standards.</p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class=""
                                             src="{{ asset('img/company-culture-removebg-preview.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/company-culture/">Culture</a>
                                         <p class="text-[14px] text-[#333] font-[400]">We celebrate innovation, while
                                             fostering consistency.</p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class="" src="{{ asset('img/news-removebg-preview-copy.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/newsletter/">Newsletter</a>
                                         <p class="text-[14px] text-[#333] font-[400]">To the Point - News that
                                             supports you!</p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class="" src="{{ asset('img/events-removebg-preview.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/events/">Events</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Stop by and chat!</p>
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
         <div class="pt-4 pb-1 border-t border-gray-200">
             <div class="space-y-1 px-2 pb-3 pt-2">
                 <div class="space-y-1 px-2 pb-3 h-77">
                     <a class="closebtn text-[#333] text-[22px] absolute top-[15px] right-[15px] cursor-pointer"
                         @click="open = ! open">X</a>
                 </div>
                 <div class="mobile-dropdown" x-data="{ open: false, toggle() { this.open = !this.open } }">
                     <x-nav-link-custom @click="toggle()"
                         classes="transition ease-in-out duration-150 rounded-md px-3 font-light text-[#333] hover:text-[#fe7300] block py-2 text-[18px] font-[300] flex justify-between items-center cursor-pointer"
                         aria-current="page">
                         {{ __('Products') }} <i class="fa fa-caret-down"></i>
                         </x-responsive-nave-link>
                         <div class="mobile-dropdown-content" x-show="open">

                             <h5 class="ctmH2 text-[22px] text-[#008C99] mb-5 font-[500]">Products</h5>
                             <div class="ctm-grd-one">
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-left min-h-[80px]">
                                         <img class="" src="{{ asset('img/c-one-1.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="<?php echo url('/category/upper-body'); ?>">Upper Body</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/shoulder-harness'); ?>">Shoulder Harness</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/chest-support'); ?>">Chest Support</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/options'); ?>">Options</a></p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-left min-h-[80px]">
                                         <img class="" src="{{ asset('img/c-two.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="<?php echo url('/category/pelvic-positioning'); ?>">Pelvic Positioning</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/hip-belts'); ?>">Hip Belts</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/leg-harness'); ?>">Leg Harness</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/essentials-hip-belt'); ?>">Essentials Hip Belt</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/options'); ?>">Options</a></p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-left min-h-[80px]">
                                         <img class="" src="{{ asset('img/speciality.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="<?php echo url('/category/specialty'); ?>">Specialty</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/shower'); ?>">Shower</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/pediatric'); ?>">Pediatric</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/sports-and-active-users'); ?>">Sports and Active Users</a></p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-left min-h-[80px]">
                                         <img class="" src="{{ asset('img/c-four.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="<?php echo url('/category/power-chair-components'); ?>">Power Chair Components</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/midline-joystick-mounting'); ?>">Midline Joystick Mounting</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/joystick-handles'); ?>">Joystick Handles</a></p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-left min-h-[80px]">
                                         <img class="" src="{{ asset('img/c-five.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="<?php echo url('/category/hardware'); ?>">Hardware</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/clamps'); ?>">Clamps</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/mounting-attachments'); ?>">Mounting Attachments</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/options'); ?>">Options</a></p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-left min-h-[80px]">
                                         <img class="" src="{{ asset('img/c-three.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="<?php echo url('/category/lower-body'); ?>">Lower Body</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/ankle-huggers'); ?>">Ankle Huggers</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/calf-supports'); ?>">Calf Supports</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/universal-elastic-strap'); ?>">Universal Elastic Strap</a></p>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/options'); ?>">Options</a></p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-left min-h-[80px]">
                                         <img src="{{ asset('img/c-three.png') }}" alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="<?php echo url('/category/dealer-tools-&-accessories'); ?>">Dealer Tools & Accessories</a>
                                         <p><a class="text-[14px] text-[#333] font-[400] hover:text-[#008C99]"
                                                 href="<?php echo url('/category/all-tools'); ?>">All Tools</a></p>


                                     </div>
                                 </div>
                             </div>

                         </div>

                 </div>

                 <div class="mobile-dropdown" x-data="{ open: false, toggle() { this.open = !this.open } }">
                     <x-nav-link-custom @click="toggle()"
                         classes="transition duration-150 ease-in-out rounded-md px-3 font-light text-[#333] hover:text-[#fe7300] block py-2 text-[18px] font-[300] flex justify-between items-center cursor-pointer"
                         aria-current="page">
                         {{ __('Wheelchair Positing') }} <i class="fa fa-caret-down"></i>
                         </x-responsive-nave-link>
                         <div class="mobile-dropdown-content" x-show="open">



                             <h5 class="ctmH2 text-[22px] text-[#008C99] mb-5 font-[500]">Positions Are Personal</h5>
                             <p class="text-[#333] pt-[5px] text-[16px] mb-5">One person, one chair, one position.</p>
                             <div class="ctm-grd-one">
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class=""
                                             src="{{ asset('img/wheelchair-positioning-removebg-preview-1.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/why-positioning-matters/">Why
                                             Positioning Matters</a>
                                         <p class="text-[14px] text-[#333] font-[400]">We improve users' safety,
                                             comfort and function.</p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class=""
                                             src="{{ asset('img/wheelchair-standards-removebg-preview.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/standards/">Wheelchair Seating
                                             Standards</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Standards illuminate the
                                             performance of our products.</p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class=""
                                             src="{{ asset('img/success-stories-removebg-preview-1.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/success-stories/">Success
                                             Stories</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Our postural supports change
                                             lives.</p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class="" src="{{ asset('img/advocacy-removebg-preview.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/advocacy/">Advocacy</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Bodypoint interacts with the
                                             industry, community and users.</p>


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
                             <h5 class="ctmH2 text-[22px] text-[#008C99] mb-5 font-[500]">Learn about Bodypoint and
                                 postural support</h5>
                             <p class="text-[#333] pt-[5px] text-[16px] mb-5">Improve the independence, comfort and
                                 safety of children and adults who use wheelchairs and other mobility devices.</p>
                             <div class="ctm-grd-one">
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class="" src="{{ asset('img/literature-removebg-preview.png') }}"
                                             alt="Your Company" />
                                     </div>

                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/literature/">Literature</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Catalog and clinical information
                                         </p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class=""
                                             src="{{ asset('img/customer-service-removebg-preview.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="https://www.youtube.com/user/BodypointInc">Training</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Product and how-to videos</p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class="" src="{{ asset('img/faq-removebg-preview.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/faqs/">FAQs</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Product and ordering questions
                                         </p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class=""
                                             src="{{ asset('img/terms-and-conditions-removebg-preview.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/terms-conditions/">Terms &
                                             Conditions</a>
                                         <p class="text-[14px] text-[#333] font-[400]">BP trademarks, warranty, and
                                             policies</p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class="" src="{{ asset('img/contact-us-removebg-preview.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
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
                         {{ __('About Us') }} <i class="fa fa-caret-down"></i>
                         </x-responsive-nave-link>
                         <div class="mobile-dropdown-content" x-show="open">
                             <h5 class="ctmH2 text-[22px] text-[#008C99] mb-5 font-[500]">About Us</h5>
                             <p class="text-[#333] pt-[5px] text-[16px] mb-5">“At Bodypoint, we work every day to
                                 better understand the capabilities and aspirations of people who use wheelchairs. As we
                                 imagine, design and manufacture our products, we strive to bridge the gap between the
                                 hard and the soft, the inanimate and the living, to create a better connection between
                                 wheelchairs and people.”
                                 – David Hintzman, Co-Founder </p>
                             <div class="ctm-grd-one">
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class=""
                                             src="{{ asset('img/company-overview-removebg-preview-1.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/company-overview/">Overview</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Every wheeler deserves all the
                                             safety, comfort and function we can provide.</p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class="" src="{{ asset('img/quality-removebg-preview.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/quality-policy/">Quality
                                             Policy</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Our supports are tested to
                                             ANSI/RESNA, EN and ISO standards.</p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class=""
                                             src="{{ asset('img/company-culture-removebg-preview.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/company-culture/">Culture</a>
                                         <p class="text-[14px] text-[#333] font-[400]">We celebrate innovation, while
                                             fostering consistency.</p>

                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class="" src="{{ asset('img/news-removebg-preview-copy.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/newsletter/">Newsletter</a>
                                         <p class="text-[14px] text-[#333] font-[400]">To the Point - News that
                                             supports you!</p>
                                     </div>
                                 </div>
                                 <div class="ctm-grd-two">
                                     <div
                                         class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                                         <img class="" src="{{ asset('img/events-removebg-preview.png') }}"
                                             alt="Your Company" />
                                     </div>
                                     <div class="prd-cntnt">
                                         <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2"
                                             href="{{ config('bodypoint.home_url') }}/events/">Events</a>
                                         <p class="text-[14px] text-[#333] font-[400]">Stop by and chat!</p>
                                     </div>
                                 </div>

                             </div>
                         </div>
                 </div>




                 </ul>
             </div>
         </div>

     </div>



     </div>



 </nav>
