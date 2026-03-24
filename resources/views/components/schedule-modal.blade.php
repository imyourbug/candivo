<!-- Schedule Modal Backdrop -->
<div id="scheduleModal"
    class="schedule-modal fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
    <!-- Modal Container -->
    <div
        class="bg-white dark:bg-slate-900 w-full max-w-[560px] rounded-xl shadow-2xl overflow-hidden relative border border-slate-200 dark:border-slate-800">
        <!-- Close Button -->
        <button type="button" data-schedule-close
            class="absolute top-4 right-4 p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
            <span class="material-symbols-outlined text-2xl">close</span>
        </button>

        <!-- Header Section -->
        <div class="px-8 pt-10 pb-6 border-b border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-3 mb-4">
                <div class="bg-blue-600/10 p-2 rounded-lg">
                    <span class="material-symbols-outlined text-blue-600 text-2xl">calendar_month</span>
                </div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100 tracking-tight">Schedule a Meeting</h2>
            </div>
            <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">
                Leave your details and preferred date. Our technical team will contact you to confirm the session.
            </p>
        </div>

        <!-- Form Section -->
        <form id="scheduleRequestForm" class="p-8 space-y-5" novalidate>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300" for="schedule_name">Full name</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">person</span>
                        <input name="full_name" id="schedule_name" type="text" placeholder="John Doe"
                            class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all text-slate-900 dark:text-slate-100 placeholder:text-slate-400" />
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300" for="schedule_email">Email address</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">mail</span>
                        <input name="email" id="schedule_email" type="email" required placeholder="john@company.com"
                            class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all text-slate-900 dark:text-slate-100 placeholder:text-slate-400" />
                    </div>
                    <p class="hidden text-xs text-red-600" data-error-for="email"></p>
                </div>

                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300" for="schedule_company">Company</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">business</span>
                        <input name="company" id="schedule_company" type="text" placeholder="Precision Dynamics Inc."
                            class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all text-slate-900 dark:text-slate-100 placeholder:text-slate-400" />
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300" for="schedule_datetime">Preferred date/time</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">event</span>
                        <input name="datetime" id="schedule_datetime" type="datetime-local" required
                            class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all text-slate-900 dark:text-slate-100" />
                    </div>
                    <p class="hidden text-xs text-red-600" data-error-for="datetime"></p>
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-300" for="schedule_agenda">Agenda</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-3 text-slate-400 text-xl">description</span>
                    <textarea name="agenda" id="schedule_agenda" rows="3"
                        placeholder="Tell us what you want to discuss..."
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all text-slate-900 dark:text-slate-100 placeholder:text-slate-400 resize-none"></textarea>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button type="button" data-schedule-close
                    class="flex-1 px-6 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition-all">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 premium-button text-white font-bold py-3 rounded-lg shadow-lg transition-all flex items-center justify-center gap-2 group">
                    <span>Request Meeting</span>
                    <span class="material-symbols-outlined text-xl group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    $(function() {
        const $scheduleModal = $('#scheduleModal');
        const $scheduleForm = $('#scheduleRequestForm');
        if ($scheduleModal.length === 0 || $scheduleForm.length === 0) return;
        const endpoint = "{{ route('api.help-center.schedule-request') }}";

        const localStorageKey = 'schedule_modal_form';
        const fieldNames = ['full_name', 'email', 'company', 'datetime', 'agenda'];

        const setField = (name, value) => {
            const $field = $scheduleForm.find(`[name="${name}"]`);
            if ($field.length) $field.val(value || '');
        };

        const readSavedData = () => {
            try {
                const raw = localStorage.getItem(localStorageKey);
                return raw ? JSON.parse(raw) : {};
            } catch (e) {
                return {};
            }
        };

        const seedFromKnownStorage = (data) => {
            if (!data || typeof data !== 'object') data = {};
            if (!data.full_name) {
                data.full_name = localStorage.getItem('full_name') || localStorage.getItem('user_name') || '';
            }
            if (!data.email) {
                data.email = localStorage.getItem('email') || localStorage.getItem('user_email') || '';
            }
            if (!data.company) {
                data.company = localStorage.getItem('company') || localStorage.getItem('user_company') || '';
            }
            return data;
        };

        const hydrateForm = () => {
            const data = seedFromKnownStorage(readSavedData());
            fieldNames.forEach(name => setField(name, data[name] || ''));
        };

        const persistForm = () => {
            const data = {};
            fieldNames.forEach(name => {
                data[name] = ($scheduleForm.find(`[name="${name}"]`).val() || '').toString();
            });
            localStorage.setItem(localStorageKey, JSON.stringify(data));
        };

        const openModal = () => {
            hydrateForm();
            setFieldError('email', '');
            setFieldError('datetime', '');
            $scheduleModal.removeClass('hidden');
        };

        const closeModal = () => {
            $scheduleModal.addClass('hidden');
        };

        $(document).on('click', '.schedule-modal-open', function(e) {
            e.preventDefault();
            openModal();
        });

        $(document).on('click', '[data-schedule-close]', function(e) {
            e.preventDefault();
            closeModal();
        });

        $scheduleModal.on('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        $scheduleForm.on('input change blur', 'input, textarea, select', function() {
            persistForm();
            validateRequiredFields();
        });

        const setFieldError = (field, message) => {
            const $field = $scheduleForm.find(`[name="${field}"]`);
            const $error = $scheduleForm.find(`[data-error-for="${field}"]`);
            if ($field.length) {
                $field.toggleClass('border-red-500', !!message);
            }
            if ($error.length) {
                $error.text(message || '').toggleClass('hidden', !message);
            }
        };

        const validateRequiredFields = () => {
            let isValid = true;
            const email = ($scheduleForm.find('[name="email"]').val() || '').toString().trim();
            const datetime = ($scheduleForm.find('[name="datetime"]').val() || '').toString().trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            setFieldError('email', '');
            setFieldError('datetime', '');

            if (!email) {
                setFieldError('email', 'Email is required.');
                isValid = false;
            } else if (!emailRegex.test(email)) {
                setFieldError('email', 'Email format is invalid.');
                isValid = false;
            }

            if (!datetime) {
                setFieldError('datetime', 'Preferred date/time is required.');
                isValid = false;
            }

            return isValid;
        };

        $scheduleForm.on('submit', function(e) {
            e.preventDefault();
            if (!validateRequiredFields()) {
                if (typeof window.showToast === 'function') {
                    window.showToast('Please fill in required fields correctly.', 'error');
                }
                return;
            }
            persistForm();

            const payload = {
                full_name: ($scheduleForm.find('[name="full_name"]').val() || '').toString().trim(),
                email: ($scheduleForm.find('[name="email"]').val() || '').toString().trim(),
                company: ($scheduleForm.find('[name="company"]').val() || '').toString().trim(),
                datetime: ($scheduleForm.find('[name="datetime"]').val() || '').toString().trim(),
                agenda: ($scheduleForm.find('[name="agenda"]').val() || '').toString().trim(),
            };

            const $submitBtn = $scheduleForm.find('button[type="submit"]');
            $submitBtn.prop('disabled', true).addClass('opacity-70 cursor-not-allowed');

            $.ajax({
                url: endpoint,
                method: 'POST',
                data: payload,
                success: function() {
                    closeModal();
                    if (typeof window.showToast === 'function') {
                        window.showToast('Schedule request sent. We will contact you soon.', 'success');
                    }
                },
                error: function(xhr) {
                    const responseErrors = xhr?.responseJSON?.errors || {};
                    setFieldError('email', responseErrors.email ? responseErrors.email[0] : '');
                    setFieldError('datetime', responseErrors.datetime ? responseErrors.datetime[0] : '');

                    if (typeof window.showToast === 'function') {
                        window.showToast(
                            xhr?.responseJSON?.message || 'Unable to send schedule request. Please try again.',
                            'error'
                        );
                    }
                },
                complete: function() {
                    $submitBtn.prop('disabled', false).removeClass('opacity-70 cursor-not-allowed');
                }
            });
        });
    });
</script>
