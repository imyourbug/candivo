<!-- Download Modal Backdrop -->
<div id="downloadModal"
    class="download-modal fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
    <!-- Modal Container -->
    <div
        class="bg-white dark:bg-slate-900 w-full max-w-[520px] rounded-xl shadow-2xl overflow-hidden relative border border-slate-200 dark:border-slate-800">
        <!-- Close Button -->
        <button type="button"
            class="download-modal-close absolute top-4 right-4 p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
            <span class="material-symbols-outlined text-2xl">close</span>
        </button>
        <!-- Header Section -->
        <div class="px-8 pt-10 pb-6 border-b border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-3 mb-4">
                <div class="bg-blue-600/10 p-2 rounded-lg">
                    <span class="material-symbols-outlined text-blue-600 text-2xl">download</span>
                </div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100 tracking-tight">Download DI-Tools
                </h2>
            </div>
            <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">
                Enter your professional details below to receive the secure download links and installation guide
                directly in your inbox.
            </p>
        </div>
        <!-- Form Section -->
        <form id="downloadRequestForm" class="p-8 space-y-5" novalidate>
            @csrf
            <!-- Full Name -->
            <div class="space-y-1.5">
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Full name</label>
                <div class="relative">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">person</span>
                    <input
                        name="full_name"
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all text-slate-900 dark:text-slate-100 placeholder:text-slate-400"
                        placeholder="John Doe" type="text" />
                </div>
                <p class="hidden text-xs text-red-600" data-error-for="full_name"></p>
            </div>
            <!-- Email Address -->
            <div class="space-y-1.5">
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Email address</label>
                <div class="relative">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">mail</span>
                    <input
                        name="email"
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all text-slate-900 dark:text-slate-100 placeholder:text-slate-400"
                        placeholder="john@company.com" type="email" />
                </div>
                <p class="hidden text-xs text-red-600" data-error-for="email"></p>
            </div>
            <div class="space-y-1.5">
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Inventor version</label>
                <div class="relative">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">settings_input_component</span>
                    <select
                        name="inventor_version"
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all text-slate-900 dark:text-slate-100">
                        <option disabled="" selected="" value="">Select version</option>
                        <option value="2024">Inventor 2024</option>
                        <option value="2023">Inventor 2023</option>
                        <option value="2022">Inventor 2022</option>
                        <option value="legacy">Legacy Versions</option>
                    </select>
                </div>
                <p class="hidden text-xs text-red-600" data-error-for="inventor_version"></p>
            </div>
            <button id="downloadSubmitBtn"
                class="w-full premium-button text-white font-bold py-4 rounded-lg shadow-lg transition-all flex items-center justify-center gap-2 mt-4 group"
                type="submit">
                <span class="download-submit-loading hidden items-center gap-2">
                    <span class="material-symbols-outlined download-submit-spinner" style="font-size: 1.5rem;">progress_activity</span>
                    <span>Processing...</span>
                </span>
                <span class="download-submit-content flex items-center gap-2">
                    <span>Get Download</span>
                    <span
                        class="material-symbols-outlined text-xl group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </span>
            </button>
            <!-- Footer Info -->
            <p class="text-center text-xs text-slate-400 dark:text-slate-500 mt-6">
                By clicking download, you agree to our <a class="underline hover:text-primary" href="#">Terms
                    of Service</a> and <a class="underline hover:text-primary" href="#">Privacy Policy</a>.
            </p>
            <div class="text-xs text-slate-500 bg-slate-50 rounded-lg px-3 py-2 border border-slate-200">
                Selected item: <strong id="downloadSelectedItemLabel">DI-Tools Core Free</strong>
            </div>
            <input type="hidden" name="selected_entity_type" value="package" />
            <input type="hidden" name="selected_entity_id" value="" />
            <input type="hidden" name="selected_entity_name" value="DI-Tools Core Free" />
        </form>
    </div>
</div>

<style>
    @keyframes download-submit-spin {
        to {
            transform: rotate(360deg);
        }
    }

    .download-submit-spinner {
        animation: download-submit-spin 0.9s linear infinite;
    }
</style>

<script>
    $(document).ready(function() {
        const $downloadModal = $('#downloadModal');
        if ($downloadModal.length) {
            $downloadModal.on('click', function(e) {
                if (e.target === this) {
                    $(this).addClass('hidden');
                }
            });
        }

        const $form = $('#downloadRequestForm');
        if ($form.length === 0) return;

        const $submitBtn = $('#downloadSubmitBtn');
        const $selectedItemLabel = $('#downloadSelectedItemLabel');
        const endpoint = "{{ route('download.request') }}";

        const setFieldError = (field, message) => {
            const $field = $form.find(`[name="${field}"]`);
            const $error = $form.find(`[data-error-for="${field}"]`);
            if ($field.length) {
                $field.toggleClass('border-red-500', !!message);
            }
            if ($error.length) {
                $error.text(message || '').toggleClass('hidden', !message);
            }
        };

        const validateForm = () => {
            let isValid = true;
            const fullName = ($form.find('[name="full_name"]').val() || '').toString().trim();
            const email = ($form.find('[name="email"]').val() || '').toString().trim();
            const version = ($form.find('[name="inventor_version"]').val() || '').toString().trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            setFieldError('full_name', '');
            setFieldError('email', '');
            setFieldError('inventor_version', '');

            if (!fullName) {
                setFieldError('full_name', 'Full name is required.');
                isValid = false;
            }

            if (!email) {
                setFieldError('email', 'Email is required.');
                isValid = false;
            } else if (!emailRegex.test(email)) {
                setFieldError('email', 'Email format is invalid.');
                isValid = false;
            }

            if (!version) {
                setFieldError('inventor_version', 'Please select inventor version.');
                isValid = false;
            }

            return isValid;
        };

        const setDownloadContext = (context = {}) => {
            const entityType = (context.type || 'package').toString();
            const entityId = (context.id || '').toString();
            const entityName = (context.name || 'DI-Tools Core Free').toString();

            $form.find('[name="selected_entity_type"]').val(entityType);
            $form.find('[name="selected_entity_id"]').val(entityId);
            $form.find('[name="selected_entity_name"]').val(entityName);
            if ($selectedItemLabel.length) {
                $selectedItemLabel.text(entityName);
            }
        };

        setDownloadContext();

        $(document).on('click', '.getCoreFreeBtn', function() {
            const $btn = $(this);
            setDownloadContext({
                type: $btn.attr('data-download-entity-type') || 'package',
                id: $btn.attr('data-download-entity-id') || '',
                name: $btn.attr('data-download-entity-name') || '',
            });
            $('#downloadModal').removeClass('hidden');
        });

        $form.on('input change blur', '[name="full_name"], [name="email"], [name="inventor_version"]', function() {
            validateForm();
        });

        $form.on('submit', function(e) {
            e.preventDefault();
            if (!validateForm()) {
                if (typeof window.showToast === 'function') {
                    window.showToast('Please fix form errors before downloading.', 'error');
                }
                return;
            }

            const formData = $form.serialize();
            $submitBtn.find('.download-submit-content').addClass('hidden');
            $submitBtn.find('.download-submit-loading').removeClass('hidden').addClass('flex');
            $submitBtn.prop('disabled', true).addClass('opacity-70 cursor-not-allowed');

            $.ajax({
                url: endpoint,
                method: 'POST',
                data: formData,
                success: function() {
                    if (typeof window.showToast === 'function') {
                        window.showToast('Download email sent. Please check your inbox.', 'success');
                    }
                    $('#downloadModal').addClass('hidden');
                    $form[0].reset();
                    setDownloadContext();
                    setFieldError('full_name', '');
                    setFieldError('email', '');
                    setFieldError('inventor_version', '');
                },
                error: function(xhr) {
                    const responseErrors = xhr?.responseJSON?.errors || {};
                    setFieldError('full_name', responseErrors.full_name ? responseErrors.full_name[0] : '');
                    setFieldError('email', responseErrors.email ? responseErrors.email[0] : '');
                    setFieldError('inventor_version', responseErrors.inventor_version ? responseErrors
                        .inventor_version[0] : '');
                    if (typeof window.showToast === 'function') {
                        window.showToast(xhr?.responseJSON?.message ||
                            'Unable to send download email. Please try again.', 'error');
                    }
                },
                complete: function() {
                    $submitBtn.find('.download-submit-loading').addClass('hidden').removeClass('flex');
                    $submitBtn.find('.download-submit-content').removeClass('hidden');
                    $submitBtn.prop('disabled', false).removeClass('opacity-70 cursor-not-allowed');
                }
            });
        });
    });
</script>
