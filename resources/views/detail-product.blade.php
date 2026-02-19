@extends('layouts.main')

@section('title', 'Drawing & Export - Di-tool')

@section('content')
    <div class="mx-auto w-full max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-sm font-medium text-slate-500 dark:text-slate-400">
            <a class="hover:text-primary transition-colors" href="#">Home</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <a class="hover:text-primary transition-colors" href="#">Autodesk Inventor</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-slate-900 dark:text-white">Drawing &amp; Export</span>
        </nav>
    </div>

    <main class="mx-auto w-full max-w-7xl grow px-4 py-6 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-12 lg:grid-cols-12">
            <div class="lg:col-span-7 flex flex-col gap-4">
                <div
                    class="relative aspect-video w-full overflow-hidden rounded-xl bg-white dark:bg-slate-800 shadow-lg border border-slate-200 dark:border-slate-800">
                    <img alt="Product Main View" class="h-full w-full object-cover"
                        data-alt="Main product interface screenshot for Drawing and Export tool"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuDFiyfW16BqlTlp5m2Ic-34IvbXp4xo83UR5S6FBGhs_myfMUKK0zOD6-D5soN1dZ7I9ufcUPBqKA26S3YoFLE-PgwIOhbecYeIge6Cg5pEqBgWT0_SLslgpPzlfJn3gerNqxvgMfpPMkf96vf2ksZMWLHcGOyAoh2EzMbKeGQo5-IgD76WYpw3RytOSh4mLaxLP7A6CEnSy8eRUumlB3oTOOKmSkJiXmHjnezLGBeK3ZXh_TlM_KSElNndF0uwUb5_Gz_qJxG8DhM" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>
                <div class="grid grid-cols-4 gap-3 sm:gap-4">
                    <div
                        class="aspect-video cursor-pointer overflow-hidden rounded-lg border-2 border-primary ring-2 ring-primary ring-offset-2 dark:ring-offset-background-dark shadow-md transition-all">
                        <img alt="Thumbnail 1" class="h-full w-full object-cover opacity-100 hover:opacity-90"
                            data-alt="Thumbnail of Drawing and Export main interface"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDBJ90uMEnpfLm_dX01qeppmRyQxEJA94Va9ZQywMDpp6zGvZHalWRisXad6tr2eNB7YHmQVZVJNMi-el5xlo8btN9LIYGgW9jbjKmmpwJASqn5ATM1_k7702HCqArV6z7CTRbYsVj9ai3aRxHtumFs1u6yIR4EIDZ3j-x2wpEZx60NntCGvUXr84syPUeTmU8s9m17frWJJRPsXILPMX0vWa4DoVnFS7XuZa_wmKlKwNkjYE05Fep9q4ZlcoBr2Kc_Ek8fKFXOXbc" />
                    </div>
                    <div
                        class="aspect-video cursor-pointer overflow-hidden rounded-lg border border-slate-200 dark:border-slate-800 hover:border-primary transition-all grayscale hover:grayscale-0">
                        <img alt="Thumbnail 2" class="h-full w-full object-cover"
                            data-alt="Thumbnail showing batch export workflow"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCYgc7n2_UKZxJBDW3w3pVLY8l9qfBzqkQKFVIQyJZa-pZ4D_qAvSV9wutf67CAjkHAcuAOFQUTzyYrf7InUTzIO2G_2YmNFWL2sqQHE7g1jUcDyjdyJfWjy2NikVKd1E3NzaJ165z0APzbopNwG94_QRPG-YzeV7-6rKxsszQImrvU-CkB0wsDKPf2thGV5Jy5bdhhNGCKGaqVbXERiLozDF_JxDGBGNrkj0t8xlBACLtzY291Q06hJs-jrzKi1sKgzgd31mt8VvM" />
                    </div>
                    <div
                        class="aspect-video cursor-pointer overflow-hidden rounded-lg border border-slate-200 dark:border-slate-800 hover:border-primary transition-all grayscale hover:grayscale-0">
                        <img alt="Thumbnail 3" class="h-full w-full object-cover"
                            data-alt="Thumbnail of automated drawing generation"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuD1_xLlaqTqihSWIHr28GO0JOwtHwPR6T6hMa0Xxt7VZKgkaYw8ly353WWSVArAC1h2PLvX7PitS6qs5JXVf8ZJ3_ubUf339hlOFpREYAL6kMs6LahccxgT1qBeKdXgHku0ZuYCKCLQLw_gmZtZcjEb4mI15P3Wjbge89noKycIIe5uXt0GARdpI5wQgDz0rjQZMuyIyqpQsGaWirKmgiH_w18PFP34msTyzUYmsCZbnwoWDuKcXtCS6HuM2tO-90GypVEFPDxdDSA" />
                    </div>
                    <div
                        class="aspect-video cursor-pointer overflow-hidden rounded-lg border border-slate-200 dark:border-slate-800 hover:border-primary transition-all grayscale hover:grayscale-0">
                        <img alt="Thumbnail 4" class="h-full w-full object-cover"
                            data-alt="Thumbnail showing layer management settings"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuA1_W5F3p4pJ4XSHGAjlCCBwcI0NiP0XCbGXrblKv8Z9vILcIlKZ7zXsth-B0ArYyNKzHiydgBKBWU2pXnL6OQ4zhh0eeiDHAfBRcAWUXRblzTB59j4YrqKT8FGksaFwQR1T4QxgNON2bctoGuMwueKKtemIMu7fy7LQxhIV3AmjejuR3Dulpl1PHkRzLxcJl66Mxkwu8-RJDo4zEMbvKsbtr0hF74AKlPInoCTZWl30yr0jW9ob78TqowxrYK-Jfcx1mwwQdk5P7U" />
                    </div>
                </div>
                <div class="mt-8 space-y-4">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Professional Drawing Automation
                    </h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                        Optimize your engineering workflow with powerful automated drawing tools. 'Drawing &amp;
                        Export' significantly reduces the time spent on repetitive detailing tasks, allowing your
                        team to focus on core design challenges. Fully integrated with Autodesk Inventor for
                        seamless operation.
                    </p>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div
                    class="sticky top-24 rounded-2xl bg-white dark:bg-slate-900 p-6 sm:p-8 shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-200 dark:border-slate-800">
                    <div class="mb-6 flex flex-col gap-1">
                        <span class="text-xs font-bold uppercase tracking-widest text-primary">Standalone
                            Package</span>
                        <h1 class="text-3xl font-black leading-none tracking-tight text-slate-900 dark:text-white">
                            DRAWING &amp; EXPORT</h1>
                    </div>
                    <div class="mb-8 space-y-4 border-y border-slate-100 dark:border-slate-800 py-6">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Platform</span>
                            <span class="text-sm font-semibold text-slate-900 dark:text-white">Autodesk
                                Inventor</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Usage</span>
                            <span class="text-sm font-semibold text-slate-900 dark:text-white">Daily engineering
                                work</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Installation</span>
                            <span class="text-sm font-semibold text-slate-900 dark:text-white">Per user / per
                                machine</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Team Size</span>
                            <span class="text-sm font-semibold text-slate-900 dark:text-white">From 1 to 50+
                                users</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Language</span>
                            <span class="text-sm font-semibold text-slate-900 dark:text-white">English /
                                Netherlands</span>
                        </div>
                    </div>
                    <div class="mb-8 space-y-6">
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl font-black text-slate-900 dark:text-white">€239</span>
                            <span class="text-lg font-medium text-slate-500 dark:text-slate-400">/ 12 months</span>
                        </div>
                        <div class="space-y-3">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-500">Subscription
                                Period</label>
                            <div class="grid grid-cols-3 gap-2">
                                <button
                                    class="rounded-lg border-2 border-slate-100 bg-white py-3 text-sm font-bold text-slate-600 hover:border-primary/50 transition-all dark:border-slate-800 dark:bg-slate-800 dark:text-slate-300">3
                                    months</button>
                                <button
                                    class="rounded-lg border-2 border-slate-100 bg-white py-3 text-sm font-bold text-slate-600 hover:border-primary/50 transition-all dark:border-slate-800 dark:bg-slate-800 dark:text-slate-300">6
                                    months</button>
                                <button
                                    class="rounded-lg border-2 border-primary bg-primary/5 py-3 text-sm font-bold text-primary transition-all dark:bg-primary/10">12
                                    months</button>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <button
                            class="group relative flex w-full items-center justify-center gap-2 overflow-hidden rounded-xl bg-[var(--enterprise-blue)] py-4 text-lg font-bold text-white transition-all hover:bg-blue-600 active:scale-[0.98] shadow-lg shadow-blue-900/20">
                            <span>Buy Now</span>
                            <span
                                class="material-symbols-outlined text-xl transition-transform group-hover:translate-x-1">shopping_cart</span>
                        </button>
                        <p class="text-center text-xs text-slate-400 dark:text-slate-500">
                            30-day money-back guarantee. No credit card required for trial.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="flex flex-wrap justify-center items-center gap-8 md:gap-16 py-8 border-y border-slate-200 dark:border-slate-800 mb-20 opacity-60">
            <div class="flex items-center gap-2 grayscale hover:grayscale-0 transition-all">
                <span class="material-symbols-outlined">verified</span>
                <span class="font-bold text-lg tracking-tight">AUTODESK CERTIFIED</span>
            </div>
            <div class="flex items-center gap-2 grayscale hover:grayscale-0 transition-all">
                <span class="material-symbols-outlined">security</span>
                <span class="font-bold text-lg tracking-tight">ISO 27001 SECURE</span>
            </div>
            <div class="flex items-center gap-2 grayscale hover:grayscale-0 transition-all">
                <span class="material-symbols-outlined">engineering</span>
                <span class="font-bold text-lg tracking-tight">PRO-ENGINEER GRADE</span>
            </div>
            <div class="flex items-center gap-2 grayscale hover:grayscale-0 transition-all">
                <span class="material-symbols-outlined">public</span>
                <span class="font-bold text-lg tracking-tight">USED BY 500+ FIRMS</span>
            </div>
        </div>

        <section class="mb-24">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-black mb-4">Technical Excellence Redefined</h2>
                <p class="text-slate-600 dark:text-slate-400">Specifically engineered for professional CAD designers who
                    demand extreme performance without compromising on detail.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="p-8 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl hover:border-[var(--enterprise-blue)] transition-all">
                    <div
                        class="w-12 h-12 bg-[var(--enterprise-blue)]/10 text-[var(--enterprise-blue)] rounded-lg flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined">bolt</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">40% Faster Rendering</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">Proprietary GXL-Acceleration
                        engine reduces compute overhead, allowing real-time viewport feedback even on complex assemblies.
                    </p>
                </div>
                <div
                    class="p-8 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl hover:border-[var(--enterprise-blue)] transition-all">
                    <div
                        class="w-12 h-12 bg-[var(--enterprise-blue)]/10 text-[var(--enterprise-blue)] rounded-lg flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined">architecture</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Precision Surfacing</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">Advanced G2 and G3 continuity
                        algorithms for automotive-grade surfaces and perfect curvature analysis directly within Inventor.
                    </p>
                </div>
                <div
                    class="p-8 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl hover:border-[var(--enterprise-blue)] transition-all">
                    <div
                        class="w-12 h-12 bg-[var(--enterprise-blue)]/10 text-[var(--enterprise-blue)] rounded-lg flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined">history</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Parametric History</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">Fully non-destructive editing
                        workflow. Modify upstream features and watch your surfacing adapt instantly without errors.</p>
                </div>
            </div>
        </section>

        <section class="mb-24">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <h2 class="text-3xl font-black mb-2">Save More with Bundles</h2>
                    <p class="text-slate-600 dark:text-slate-400">Maximize your toolset while minimizing your costs.</p>
                </div>
                <a class="text-[var(--enterprise-blue)] font-bold text-sm flex items-center gap-1 hover:underline"
                    href="#">
                    View All Bundles <span class="material-symbols-outlined">chevron_right</span>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div
                    class="group relative overflow-hidden rounded-2xl border-2 border-[var(--enterprise-blue)] bg-[var(--enterprise-blue)]/5 p-1 transition-all hover:shadow-2xl hover:shadow-blue-900/10">
                    <div class="absolute top-4 right-4 z-10">
                        <span
                            class="bg-[var(--enterprise-blue)] text-white text-[10px] font-black px-2 py-1 rounded uppercase tracking-tighter">Most
                            Popular</span>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-8 rounded-xl h-full flex flex-col">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-2xl font-black text-slate-900 dark:text-white">Automation Master Pack</h3>
                                <p class="text-slate-500 text-sm mt-1 italic">Includes Modeling Suite 2.0 + 4 others</p>
                            </div>
                            <div class="text-right">
                                <p class="text-slate-400 line-through text-sm">$899</p>
                                <p class="text-3xl font-black text-[var(--enterprise-blue)]">$549</p>
                            </div>
                        </div>
                        <ul class="space-y-3 mb-8 flex-grow">
                            <li class="flex items-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-green-500 !text-lg">check_circle</span>
                                <span>Modeling Suite 2.0 (Full Version)</span>
                            </li>
                            <li class="flex items-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-green-500 !text-lg">check_circle</span>
                                <span>Scripting Engine Pro</span>
                            </li>
                            <li class="flex items-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-green-500 !text-lg">check_circle</span>
                                <span>Batch Export Toolkit</span>
                            </li>
                            <li class="flex items-center gap-2 text-sm text-slate-400">
                                <span class="material-symbols-outlined !text-lg">add</span>
                                <span>2 additional automation tools</span>
                            </li>
                        </ul>
                        <button
                            class="w-full bg-[var(--enterprise-blue)] text-white py-3 rounded-lg font-bold hover:brightness-110 transition-all">
                            Upgrade to Bundle
                        </button>
                    </div>
                </div>
                <div
                    class="group relative overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-100/50 dark:bg-slate-800/50 p-8 transition-all hover:shadow-xl">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-black text-slate-900 dark:text-white">Ultimate Inventor Suite</h3>
                            <p class="text-slate-500 text-sm mt-1 italic">Complete tool catalog access</p>
                        </div>
                        <div class="text-right">
                            <p class="text-slate-400 line-through text-sm">$1,499</p>
                            <p class="text-3xl font-black text-slate-900 dark:text-white">$999</p>
                        </div>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-2 text-sm">
                            <span class="material-symbols-outlined text-[var(--enterprise-blue)] !text-lg">token</span>
                            <span>Every DI-TOOL ever released</span>
                        </li>
                        <li class="flex items-center gap-2 text-sm">
                            <span class="material-symbols-outlined text-[var(--enterprise-blue)] !text-lg">token</span>
                            <span>Priority 24/7 Technical Support</span>
                        </li>
                        <li class="flex items-center gap-2 text-sm">
                            <span class="material-symbols-outlined text-[var(--enterprise-blue)] !text-lg">token</span>
                            <span>Enterprise Multi-seat Licensing</span>
                        </li>
                    </ul>
                    <button
                        class="w-full bg-slate-900 dark:bg-white dark:text-slate-900 text-white py-3 rounded-lg font-bold hover:opacity-90 transition-all">
                        Buy Ultimate Suite
                    </button>
                </div>
            </div>
        </section>

        <section class="mb-20">
            <h2 class="text-2xl font-black mb-8">Frequently Bought Together</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div
                    class="group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden hover:shadow-lg transition-all">
                    <div class="aspect-square bg-slate-100 dark:bg-slate-800 p-4">
                        <img class="w-full h-full object-contain mix-blend-multiply dark:mix-blend-normal opacity-80 group-hover:scale-110 transition-transform"
                            data-alt="Technical icon for a rendering engine plugin"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuADz2fKqgxIvjaTj5-lGjwoNT8MCRI9OeB4VkBT9SfnOC-ejIGeSk2nZSzNi2tc9JY93KvGyMOmiKy8tcO0x3xjIw5jGCzLUci29fvhdZu98X_1JxqPLpbXHZ3Ym4g-7Cl4fUuzlgFhK4dZ2l2swKfmJbPbHDofoao3kqPWr2q94KpXn6N5Qv4CxRwEuB5YLgYmO9Pc1wu_Vi97_Egr6ITV3YeNLW5timi7sAh0xCzyu4iTEQKofUhBqDK_sasUb1I0nsMoYPf8AvQ" />
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold text-sm mb-1 truncate">RenderPro Engine</h4>
                        <div class="flex items-center justify-between">
                            <span class="text-[var(--enterprise-blue)] font-bold">$79</span>
                            <button
                                class="w-8 h-8 rounded-full border border-slate-200 dark:border-slate-700 flex items-center justify-center hover:bg-[var(--enterprise-blue)] hover:text-white hover:border-[var(--enterprise-blue)] transition-all">
                                <span class="material-symbols-outlined !text-sm">add</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div
                    class="group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden hover:shadow-lg transition-all">
                    <div class="aspect-square bg-slate-100 dark:bg-slate-800 p-4">
                        <img class="w-full h-full object-contain mix-blend-multiply dark:mix-blend-normal opacity-80 group-hover:scale-110 transition-transform"
                            data-alt="Technical dashboard UI representing data analysis tool"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuA9u23NQRZqmg3IXYfIWNTXAFL7WsUsGqHdoGVLnNdK7IR6NMfqnxmfJ2129c5BEcdDq4ks2W9JKqUKWOmDOKk5cxuBmZlxgqmMvXxJTuq6SPcmruZIWUuDvt3lrP7KkmdtHLj_bzhmC2C66RWM2kgjbnQh-APZToYvnUXF6zKJ46TRkyzrfckVOzzj6S3m5HVpJEgHJUa9ud3-WaHYg-za064cNSOi6VpxM4OaDjBv1VTf8HX2g8VUf_vzzExLjwXkItLbAcjksQQ" />
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold text-sm mb-1 truncate">Material Library XL</h4>
                        <div class="flex items-center justify-between">
                            <span class="text-[var(--enterprise-blue)] font-bold">$49</span>
                            <button
                                class="w-8 h-8 rounded-full border border-slate-200 dark:border-slate-700 flex items-center justify-center hover:bg-[var(--enterprise-blue)] hover:text-white hover:border-[var(--enterprise-blue)] transition-all">
                                <span class="material-symbols-outlined !text-sm">add</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div
                    class="group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden hover:shadow-lg transition-all">
                    <div class="aspect-square bg-slate-100 dark:bg-slate-800 p-4">
                        <img class="w-full h-full object-contain mix-blend-multiply dark:mix-blend-normal opacity-80 group-hover:scale-110 transition-transform"
                            data-alt="Abstract hardware chip representing optimization plugin"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuA9I9gE16lI_z4bFCY2M0qEe9EU-Dv3T8j4_cpEc1n3ronut_jQ_LX-_hwf47yXpe2xuYOTtR5FbQiuoYbMJiRSppBvJOQVPfDMuMvm-sSYIoFX37p4o7NrO56SddRIC3-kKN_sR9NQbsW3jpodY1phzOfvHpzuqqRm3mYZ06rvtNB3To6dH7Qn2QdtXtQtK5MMeHk4DDn-USfNovMi9Df3n5CXRcQVHvRl1wfaoZC4dhaP3oEZdZvs-7oRXwBmsdFDfUKifMcqI70" />
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold text-sm mb-1 truncate">Constraint Solver Pro</h4>
                        <div class="flex items-center justify-between">
                            <span class="text-[var(--enterprise-blue)] font-bold">$129</span>
                            <button
                                class="w-8 h-8 rounded-full border border-slate-200 dark:border-slate-700 flex items-center justify-center hover:bg-[var(--enterprise-blue)] hover:text-white hover:border-[var(--enterprise-blue)] transition-all">
                                <span class="material-symbols-outlined !text-sm">add</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div
                    class="group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden hover:shadow-lg transition-all">
                    <div class="aspect-square bg-slate-100 dark:bg-slate-800 p-4">
                        <img class="w-full h-full object-contain mix-blend-multiply dark:mix-blend-normal opacity-80 group-hover:scale-110 transition-transform"
                            data-alt="Network server representing cloud integration tool"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuD8lbZUTGd1GLg5HcHiZ1PADrs7-7Pw0CU5rwiAISq3Khpqu_ufOto0OrYiTpHuhdopfYOXwa98et43_8But4Xsrogiqw8AZeDDmZj9BXMePNe7aHPEBGkLfOdICIXHYu7FNHq8hmOM12r-TqQWmGl5HUX8i8GzNaGyUFsn2R2skZAu_N0-HqMkEQFLoSM9D4yeKMNkVoX9dzUHRM1nxM1DrycLtmy5QsL51Zzk7Iqf0RktXPVlV99_bGeM4zeIrTVLTt6N6ubZQos" />
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold text-sm mb-1 truncate">Cloud Sync Utility</h4>
                        <div class="flex items-center justify-between">
                            <span class="text-[var(--enterprise-blue)] font-bold">$29</span>
                            <button
                                class="w-8 h-8 rounded-full border border-slate-200 dark:border-slate-700 flex items-center justify-center hover:bg-[var(--enterprise-blue)] hover:text-white hover:border-[var(--enterprise-blue)] transition-all">
                                <span class="material-symbols-outlined !text-sm">add</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
