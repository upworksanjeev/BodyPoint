 <nav class="" x-data="{ open: false }">
            <div class="ctm-pt relative flex flex-wrap items-center justify-between pb-5">
             
			   <div
                  class="inset-y-0 left-0 flex items-center xl:hidden justify-end lg:justify-start w-6/12 lg:w-1/12 xl:w-1/12">
                  <!-- Mobile menu button-->
                  <button @click="open = ! open"
                      class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-white focus:outline-none focus:ring-2 focus:ring-inset transition duration-150 ease-in-out text-[40px]">
                      <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                          <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                          <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                  </button>
              </div>
              <div
                class="flex flex-1 items-center justify-start order-first lg:order-none lg:justify-between shift-logo w-6/12 lg:w-6/12 xl:w-9/12 pb-1"
              >
                <div class="flex flex-shrink-0 items-center">
                  <img 
                    class="h-14 w-auto"
                    src="{{ asset('img/logo-1.png') }}"
                    alt="Body Point"
                  />
                </div>
                <div class="hidden sm:ml-6 lg:block">
                  <div class="flex space-x-4 nav-links mr-5 ">
                    <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                    <div class="dropdown flex">
                        <a
                          href="#"
                          class="px-2 py-2 font-normal text-[18px] text-white hover:text-[#fe7300] transition duration-150 ease-in-out"
                          aria-current="page">Products <i class="fa fa-chevron-down text-[14px]"></i></a
                        >
                        <div class="dropdown-content">
                           <h5 class="ctmH2 text-[22px] text-[#008C99]  font-[500]">Product</h5>
                          
                          <div class="ctm-grd-one">
                            <div class="ctm-grd-two">
                            <div class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                              <img
                    class=""
                    src="{{ asset('img/menu-1.png') }}"
                    alt="Your Company"
                  />
                            </div>
                            <div class="prd-cntnt">
                              <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2" href="">Upper Body</a>
                              <p class="text-[14px] text-[#333] font-[400]">Shoulder Harness</p>
                              <p class="text-[14px] text-[#333] font-[400]">Chest Support</p>
                              <p class="text-[14px] text-[#333] font-[400]">Options</p>
                            </div>
                          </div>
                          <div class="ctm-grd-two">
                            <div class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                              <img
                    class=""
                    src="{{ asset('img/Image-4.png') }}"
                    alt="Your Company"
                  />
                            </div>
                            <div class="prd-cntnt">
                              <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2" href="">Pelvic Positioning</a>
                              <p class="text-[14px] text-[#333] font-[400]">Hip Belts</p>
                              <p class="text-[14px] text-[#333] font-[400]">Leg Harness</p>
                              <p class="text-[14px] text-[#333] font-[400]">Essentials Hip Belt</p>
                              <p class="text-[14px] text-[#333] font-[400]">Options</p>
                            </div>
                          </div>
                          <div class="ctm-grd-two">
                            <div class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                              <img
                    class=""
                    src="{{ asset('img/Image-5.png') }}"
                    alt="Your Company"
                  />
                            </div>
                            <div class="prd-cntnt">
                              <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2" href="">Specialty</a>
                              <p class="text-[14px] text-[#333] font-[400]">Shower</p>
                              <p class="text-[14px] text-[#333] font-[400]">Pediatric</p>
                              <p class="text-[14px] text-[#333] font-[400]">Sports and Active Users</p>
                            </div>
                          </div>
                          <div class="ctm-grd-two">
                            <div class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                              <img
                    class=""
                    src="{{ asset('img/Image-6.png') }}"
                    alt="Your Company"
                  />
                            </div>
                            <div class="prd-cntnt">
                              <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2" href="">Power Chair Components</a>
                              <p class="text-[14px] text-[#333] font-[400]">Midline Joystick Mounting</p>
                              <p class="text-[14px] text-[#333] font-[400]">Joystick Handles</p>
                            </div>
                          </div>
                          <div class="ctm-grd-two">
                            <div class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                              <img
                    class=""
                    src="{{ asset('img/Image-7.png') }}"
                    alt="Your Company"
                  />
                            </div>
                            <div class="prd-cntnt">
                              <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2" href="">Hardware</a>
                              <p class="text-[14px] text-[#333] font-[400]">Clamps</p>
                              <p class="text-[14px] text-[#333] font-[400]">Mounting Attachments</p>
                              <p class="text-[14px] text-[#333] font-[400]">Options</p>
                            </div>
                          </div>
                          <div class="ctm-grd-two">
                            <div class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                              <img
                    class=""
                    src="{{ asset('img/Image-8.png') }}"
                    alt="Your Company"
                  />
                            </div>
                            <div class="prd-cntnt">
                              <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2" href="">Lower Body</a>
                              <p class="text-[14px] text-[#333] font-[400]">Ankle Huggers®</p>
                              <p class="text-[14px] text-[#333] font-[400]">Calf Supports</p>
                              <p class="text-[14px] text-[#333] font-[400]">Universal Elastic Strap</p>
                              <p class="text-[14px] text-[#333] font-[400]">Options</p>
                            </div>
                          </div> 
						  <div class="ctm-grd-two">
                            <div class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                              <img
                    class=""
                    src="{{ asset('img/Image-9.png') }}"
                    alt="Your Company"
                  />
                            </div>
                            <div class="prd-cntnt">
                              <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2" href="">Dealer Tools & Accessories</a>
                              <p class="text-[14px] text-[#333] font-[400]">All Tools</p>
                            
                            </div>
                          </div>
                          </div>
                        </div>
                    </div>
                   <div class="dropdown flex">
                        <a
                          href="#"
                          class="px-2 py-2 font-normal text-[18px] text-white hover:text-[#fe7300] transition duration-150 ease-in-out"
                          aria-current="page"
                          >Wheelchair Positing <i class="fa fa-chevron-down text-[14px]"></i></a
                        >
                        <div class="dropdown-content">
                           <h5 class="ctmH2 text-[22px] text-[#008C99]  font-[500]">Positions Are Personal</h5>
                          <p class="text-[#333] pt-[5px] text-[16px] mb-5">One person, one chair, one position.</p>
                          <div class="ctm-grd-one">
                            <div class="ctm-grd-two">
                            <div class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                              <img
                    class=""
                    src="{{ asset('img/wheelchair-positioning-removebg-preview-1.png') }}"
                    alt="Your Company"
                  />
                            </div>
                            <div class="prd-cntnt">
                              <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2" href="">Why Positioning Matters</a>
                              <p class="text-[14px] text-[#333] font-[400]">We improve users' safety, comfort and function.</p>
                            
                            </div>
                          </div>
                          <div class="ctm-grd-two">
                            <div class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                              <img
                    class=""
                    src="{{ asset('img/wheelchair-standards-removebg-preview.png') }}"
                    alt="Your Company"
                  />
                            </div>
                            <div class="prd-cntnt">
                              <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2" href="">Wheelchair Seating Standards</a>
                              <p class="text-[14px] text-[#333] font-[400]">Standards illuminate the performance of our products.</p>
                            </div>
                          </div>
                          <div class="ctm-grd-two">
                            <div class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                              <img
                    class=""
                    src="{{ asset('img/success-stories-removebg-preview-1.png') }}"
                    alt="Your Company"
                  />
                            </div>
                            <div class="prd-cntnt">
                              <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2" href="">Success Stories</a>
                              <p class="text-[14px] text-[#333] font-[400]">Our postural supports change lives.</p>
                             
                            </div>
                          </div>
                          <div class="ctm-grd-two">
                            <div class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                              <img
                    class=""
                    src="{{ asset('img/advocacy-removebg-preview.png') }}"
                    alt="Your Company"
                  />
                            </div>
                            <div class="prd-cntnt">
                              <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2" href="">Advocacy</a>
                              <p class="text-[14px] text-[#333] font-[400]">Bodypoint interacts with the industry, community and users.</p>
                              
                 
                            </div>
                          </div>
                         
                         
                          </div>
                        </div>
                    </div>
					<div class="dropdown flex">
                        <a
                          href="#"
                          class="px-2 py-2 font-normal text-[18px] text-white hover:text-[#fe7300] transition duration-150 ease-in-out"
                          aria-current="page"
                          >Resources <i class="fa fa-chevron-down text-[14px]"></i></a
                        >
                        <div class="dropdown-content">
                           <h5 class="ctmH2 text-[22px] text-[#008C99]  font-[500]">Learn about Bodypoint and postural support</h5>
                          <p class="text-[#333] pt-[5px] text-[16px] mb-5">Improve the independence, comfort and safety of children and adults who use wheelchairs and other mobility devices.</p>
                          <div class="ctm-grd-one">
                            <div class="ctm-grd-two">
                            <div class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                              <img
                    class=""
                    src="{{ asset('img/literature-removebg-preview.png') }}"
                    alt="Your Company"
                  />
                            </div>
						
                            <div class="prd-cntnt">
                              <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2" href="">Literature</a>
                              <p class="text-[14px] text-[#333] font-[400]">Catalog and clinical information</p>
                             
                            </div>
                          </div>
                          <div class="ctm-grd-two">
                            <div class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                              <img
                    class=""
                    src="{{ asset('img/customer-service-removebg-preview.png') }}"
                    alt="Your Company"
                  />
                            </div>
                            <div class="prd-cntnt">
                              <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2" href="">Training</a>
                              <p class="text-[14px] text-[#333] font-[400]">Product and how-to videos</p>
                             
                            </div>
                          </div>
                          <div class="ctm-grd-two">
                            <div class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                              <img
                    class=""
                    src="{{ asset('img/faq-removebg-preview.png') }}"
                    alt="Your Company"
                  />
                            </div>
                            <div class="prd-cntnt">
                              <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2" href="">FAQs</a>
                              <p class="text-[14px] text-[#333] font-[400]">Product and ordering questions</p>
                            </div>
                          </div>
                          <div class="ctm-grd-two">
                            <div class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                              <img
                    class=""
                    src="{{ asset('img/terms-and-conditions-removebg-preview.png') }}"
                    alt="Your Company"
                  />
                            </div>
                            <div class="prd-cntnt">
                              <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2" href="">Terms & Conditions</a>
                              <p class="text-[14px] text-[#333] font-[400]">BP trademarks, warranty, and policies</p>
                          
                            </div>
                          </div>
                          <div class="ctm-grd-two">
                            <div class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                              <img
                    class=""
                    src="{{ asset('img/contact-us-removebg-preview.png') }}"
                    alt="Your Company"
                  />
                            </div>
                            <div class="prd-cntnt">
                              <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2" href="">Contact Us</a>
                              <p class="text-[14px] text-[#333] font-[400]">How can we help?</p>
                             
                            </div>
                          </div>
                         
                          </div>
                        </div>
                    </div>
					<div class="dropdown flex">
                        <a
                          href="#"
                          class="px-2 py-2 font-normal text-[18px] text-white hover:text-[#fe7300] transition duration-150 ease-in-out"
                          aria-current="page"
                          >About Us <i class="fa fa-chevron-down text-[14px]"></i></a
                        >
						<div class="dropdown-content">
                           <h5 class="ctmH2 text-[22px] text-[#008C99]  font-[500]">About Us</h5>
                          <p class="text-[#333] pt-[5px] text-[16px] mb-5">“At Bodypoint, we work every day to better understand the capabilities and aspirations of people who use wheelchairs. As we imagine, design and manufacture our products, we strive to bridge the gap between the hard and the soft, the inanimate and the living, to create a better connection between wheelchairs and people.”
– David Hintzman, Co-Founder	</p>
                          <div class="ctm-grd-one">
                            <div class="ctm-grd-two">
                            <div class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                              <img
                    class=""
                    src="{{ asset('img/company-overview-removebg-preview-1.png') }}"
                    alt="Your Company"
                  />
                            </div>
                            <div class="prd-cntnt">
                              <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2" href="">Overview</a>
                              <p class="text-[14px] text-[#333] font-[400]">Every wheeler deserves all the safety, comfort and function we can provide.</p>
                             
                            </div>
                          </div>
                          <div class="ctm-grd-two">
                            <div class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                              <img
                    class=""
                    src="{{ asset('img/quality-removebg-preview.png') }}"
                    alt="Your Company"
                  />
                            </div>
                            <div class="prd-cntnt">
                              <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2" href="">Quality Policy</a>
                              <p class="text-[14px] text-[#333] font-[400]">Our supports are tested to ANSI/RESNA, EN and ISO standards.</p>
                       
                            </div>
                          </div>
                          <div class="ctm-grd-two">
                            <div class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                              <img
                    class=""
                    src="{{ asset('img/company-culture-removebg-preview.png') }}"
                    alt="Your Company"
                  />
                            </div>
                            <div class="prd-cntnt">
                              <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2" href="">Culture</a>
                              <p class="text-[14px] text-[#333] font-[400]">We celebrate innovation, while fostering consistency.</p>
                            
                            </div>
                          </div>
                          <div class="ctm-grd-two">
                            <div class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                              <img
                    class=""
                    src="{{ asset('img/news-removebg-preview-copy.png') }}"
                    alt="Your Company"
                  />
                            </div>
                            <div class="prd-cntnt">
                              <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2" href="">Newsletter</a>
                              <p class="text-[14px] text-[#333] font-[400]">To the Point - News that supports you!</p>
                            </div>
                          </div>
                          <div class="ctm-grd-two">
                            <div class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                              <img
                    class=""
                    src="{{ asset('img/events-removebg-preview.png') }}"
                    alt="Your Company"
                  />
                            </div>
                            <div class="prd-cntnt">
                              <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2" href="">Events</a>
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
              <div class="hidden flex items-center pr-2 sm:static sm:inset-auto sm:pr-0 w-full lg:w-2/12 xl:w-2/12 lg:block">
                
				 <x-header-search class='w-full' />
				
              </div>
            </div>
          
      <!-- Responsive Navigation Menu -->
      <div :class="{ 'block': open, 'hidden': !open }" class="hidden lg:hidden">


          <!-- Responsive Settings Options -->
          <div class="pt-4 pb-1 border-t border-gray-200">
              <div class="space-y-1 px-2 pb-3 pt-2">
			 
				<div class="mobile-dropdown" x-data="{ open: false, toggle() { this.open = ! this.open } }">
                  <x-nav-link-custom @click="toggle()"
                      classes="transition duration-150 ease-in-out text-white block rounded-md px-3 py-2 text-base font-medium"
                      aria-current="page">
                      {{ __('Product') }} <i class="fa fa-caret-down"></i>
                      </x-responsive-nave-link>
					<div class="mobile-dropdown-content" x-show="open">
               
                <div  class="ctm-grd-one">
                  <div class="ctm-grd-two">
                  <div class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                    <img class="" src="{{ asset('img/menu-1.png') }}" alt="Your Company"/>
                  </div>
                  <div class="prd-cntnt">
                    <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2" href="">Upper Body</a>
                    <p class="text-[14px] text-[#333] font-[400]">Shoulder Harness</p>
                    <p class="text-[14px] text-[#333] font-[400]">Chest Support</p>
                    <p class="text-[14px] text-[#333] font-[400]">Options</p>
                  </div>
                </div>
                <div class="ctm-grd-two">
                  <div class="prd-img py-5 px-2 rounded flex items-center justify-center min-h-[120px] border border-[#ECECEC]">
                    <img class="" src="{{ asset('img/Image-4.png') }}" alt="Your Company" />
                  </div>
                  <div class="prd-cntnt">
                              <a class="text-[22px]  text-[#333] hover:text-[#008C99] mb-2" href="">Pelvic Positioning</a>
                              <p class="text-[14px] text-[#333] font-[400]">Hip Belts</p>
                              <p class="text-[14px] text-[#333] font-[400]">Leg Harness</p>
                              <p class="text-[14px] text-[#333] font-[400]">Essentials Hip Belt</p>
                              <p class="text-[14px] text-[#333] font-[400]">Options</p>
                            </div>
                </div>
                
				</div>
				</div>
				</div>
                      <x-nav-link-custom href="#"
                          classes="transition duration-150 ease-in-out text-white block rounded-md px-3 py-2 text-base font-medium">
                          {{ __('Wheelchair Positioning') }}
                          </x-responsive-nave-link>
                          <x-nav-link-custom href="#"
                              classes=" text-white hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">
                              {{ __('How to Buy') }}
                              </x-responsive-nave-link>
                              <x-nav-link-custom href="#"
                                  classes=" text-white hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">
                                  {{ __('Resources') }}
                                  </x-responsive-nave-link>
                                  <x-nav-link-custom href="#"
                                      classes=" text-white hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">
                                      {{ __('About Us') }}
                                      </x-responsive-nave-link>
                                      <x-nav-link-custom href="#"
                                          classes=" text-white hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">
                                          {{ __('Partners') }}
                                          </x-responsive-nave-link>

                                          <x-nav-link-custom :href="route('login')"
                                              classes=" text-white hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">
                                              {{ __(' Sign In') }}

                                              </x-responsive-nav-link>

                                              <x-nav-link-custom :href="route('register')"
                                                  classes=" text-white hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">

                                                  {{ __('Register') }}

                                                  </x-responsive-nav-link>
              </div>
			  
			  

        </nav>