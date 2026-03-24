<footer class="bg-[#f6f9fd] border-t border-[#d6e3f1] px-6 md:px-12 lg:px-16 pt-16 pb-8">
    <div class="max-w-[1280px] mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-10 xl:gap-12">
            <div class="xl:col-span-2">
                <a href="{{ route('home') }}"
                    class="inline-flex items-center gap-2 hover:opacity-90 transition-opacity mb-5">
                    <img src="{{ asset('logo.png') }}" alt="DI-TOOLS Logo"
                        class="h-24 md:h-28 w-auto rounded object-cover" />
                </a>
                <p class="text-[#4c739a] text-base leading-relaxed max-w-md">
                    The premium standard for Autodesk Inventor extensions. Driving engineering excellence through
                    intelligent automation.
                </p>
                <div class="mt-6 flex items-center gap-3">
                    <a href="https://www.youtube.com/playlist?list=PLY_JFFRWFisYI1TTPDkNcH3RIhkaj4e9t" target="_blank"
                        rel="noopener noreferrer" aria-label="YouTube"
                        class="size-12 rounded-full flex items-center justify-center bg-[#137fec] hover:bg-[#0f6ecd] transition-colors shrink-0 p-2.5">
                        <svg class="size-full text-white" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path
                                d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                        </svg>
                    </a>
                    <a href="#" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"
                        class="size-12 rounded-full flex items-center justify-center bg-[#137fec] hover:bg-[#0f6ecd] transition-colors shrink-0 p-2.5">
                        <svg class="size-full text-white" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path
                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                        </svg>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="text-[#002b5c] text-lg font-black uppercase tracking-widest mb-5">D-Products</h4>
                <ul class="space-y-3 text-[#4c739a] text-lg font-semibold">
                    <li><a class="hover:text-[#002b5c] transition-colors"
                            href="https://www.cadinvo.com/products/d-projects">D-Projects</a></li>
                    <li><a class="hover:text-[#002b5c] transition-colors"
                            href="https://www.cadinvo.com/products/d-configurators-automation">D-Configurators &
                            Automation</a></li>
                    <li><a class="hover:text-[#002b5c] transition-colors"
                            href="https://www.cadinvo.com/products/di-tools">Di-Tools</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-[#002b5c] text-lg font-black uppercase tracking-widest mb-5">Services</h4>
                <ul class="space-y-3 text-[#4c739a] text-lg font-semibold">
                    <li><a class="hover:text-[#002b5c] transition-colors"
                            href="https://www.cadinvo.com/services/scanning-digitalization">Scanning &
                            Digitalization</a></li>
                    <li><a class="hover:text-[#002b5c] transition-colors"
                            href="https://www.cadinvo.com/services/configurators-automation">Configurators &
                            Automation</a></li>
                    <li><a class="hover:text-[#002b5c] transition-colors"
                            href="https://www.cadinvo.com/services/outsourcing-support">Outsourcing & Support</a></li>
                    <li><a class="hover:text-[#002b5c] transition-colors"
                            href="https://www.cadinvo.com/services/process-optimization">Process Optimization</a></li>
                    <li><a class="hover:text-[#002b5c] transition-colors"
                            href="https://www.cadinvo.com/services/engineering-technical-drafting">Engineering &
                            Technical Drafting</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-[#002b5c] text-lg font-black uppercase tracking-widest mb-5">Company</h4>
                <ul class="space-y-3 text-[#4c739a] text-lg font-semibold">
                    <li><a class="hover:text-[#002b5c] transition-colors" href="{{ route('home') }}">Shop</a></li>
                    <li><a class="hover:text-[#002b5c] transition-colors" href="{{ route('home') }}">Home</a></li>
                    <li><a class="hover:text-[#002b5c] transition-colors" href="{{ route('about') }}">About Us</a></li>
                    <li><a class="hover:text-[#002b5c] transition-colors" href="{{ route('contact-us') }}">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>

        <div
            class="mt-10 pt-6 border-t border-[#d6e3f1] flex flex-col md:flex-row items-start md:items-center justify-between gap-3">
            <p class="text-[#4c739a] text-xs font-medium">
                © {{ date('Y') }} DI-TOOLS. All rights reserved.
            </p>
        </div>
    </div>
</footer>
