/**
 * jQuery helpers: local preview for image file inputs before form submit.
 * Config: window.__ADMIN_MEDIA_CONFIG__ (from admin layout) or GET admin.media.client-config.
 */
(function ($) {
    'use strict';

    function getConfig() {
        return window.__ADMIN_MEDIA_CONFIG__ || { defaultMaxFileKilobytes: 5120, postAvatarMaxKilobytes: 3072 };
    }

    function maxBytesForInput($input) {
        var cfg = getConfig();
        var kb = parseInt($input.attr('data-max-kilobytes'), 10);
        if (!kb || kb < 1) {
            if ($input.hasClass('js-admin-post-avatar-file')) {
                kb = cfg.postAvatarMaxKilobytes || cfg.defaultMaxFileKilobytes;
            } else {
                kb = cfg.defaultMaxFileKilobytes;
            }
        }
        return kb * 1024;
    }

    function formatSizeLimit(bytes) {
        var mb = bytes / (1024 * 1024);
        if (mb >= 1) {
            return Math.round(mb * 10) / 10 + ' MB';
        }
        return Math.round(bytes / 1024) + ' KB';
    }

    function readAsDataURL(file, done) {
        var reader = new FileReader();
        reader.onload = function () {
            done(reader.result);
        };
        reader.onerror = function () {
            done(null);
        };
        reader.readAsDataURL(file);
    }

    function setInputFilesFromList(input, files) {
        var dt = new DataTransfer();
        for (var i = 0; i < files.length; i++) {
            dt.items.add(files[i]);
        }
        input.files = dt.files;
    }

    function bindAvatar($input) {
        var $staging = $input.nextAll('[data-admin-avatar-staging]').first();
        if (!$staging.length) {
            return;
        }
        var $img = $staging.find('[data-admin-avatar-staging-img]');
        var $cornerClear = $staging.find('[data-admin-avatar-corner-clear]');
        var $err = $staging.find('[data-admin-avatar-error]');

        function hidePreview() {
            $staging.addClass('hidden');
            $img.removeAttr('src').addClass('hidden');
            $cornerClear.addClass('hidden').removeClass('flex');
            $err.text('');
        }

        function showPreview(url) {
            $img.attr('src', url).removeClass('hidden');
            $cornerClear.removeClass('hidden').addClass('flex');
            $staging.removeClass('hidden');
        }

        $input.on('change', function () {
            $err.text('');
            var file = this.files && this.files[0];
            if (!file) {
                hidePreview();
                return;
            }
            if (!/^image\//.test(file.type)) {
                $err.text('Please choose an image file.');
                this.value = '';
                return;
            }
            var maxB = maxBytesForInput($input);
            if (file.size > maxB) {
                $err.text('Image must be under ' + formatSizeLimit(maxB) + '.');
                this.value = '';
                return;
            }
            readAsDataURL(file, function (url) {
                if (!url) {
                    return;
                }
                showPreview(url);
            });
        });

        $cornerClear.on('click', function (e) {
            e.preventDefault();
            $input.val('');
            hidePreview();
        });
    }

    function bindGallery($input) {
        var $wrap = $input.closest('[data-admin-gallery-field]');
        if (!$wrap.length) {
            $wrap = $input.parent();
        }
        var $staging = $wrap.find('[data-admin-gallery-staging]').first();
        var $err = $wrap.find('[data-admin-gallery-error]').first();
        var $clearAll = $wrap.find('[data-admin-gallery-clear]').first();
        if (!$staging.length) {
            return;
        }

        var galleryFiles = [];

        function setClearAllVisible(show) {
            if ($clearAll.length) {
                $clearAll.toggleClass('hidden', !show);
            }
        }

        function syncGalleryInputFiles() {
            setInputFilesFromList($input[0], galleryFiles);
        }

        function validateFileList(list) {
            var maxB = maxBytesForInput($input);
            for (var j = 0; j < list.length; j++) {
                var f = list[j];
                if (!/^image\//.test(f.type)) {
                    return { ok: false, message: 'Only image files are allowed.' };
                }
                if (f.size > maxB) {
                    return {
                        ok: false,
                        message: 'Each image must be under ' + formatSizeLimit(maxB) + '.',
                    };
                }
            }
            return { ok: true };
        }

        function renderGalleryTiles() {
            $staging.empty();
            if (!galleryFiles.length) {
                $staging.addClass('hidden');
                setClearAllVisible(false);
                return;
            }

            var urls = new Array(galleryFiles.length);
            var pending = galleryFiles.length;
            var tileClasses = 'relative inline-block shrink-0';
            var imgClasses =
                'h-16 w-16 rounded-md object-cover border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800';
            var btnClasses =
                'absolute -right-1.5 -top-1.5 z-10 flex h-7 w-7 items-center justify-center rounded-full border-2 border-white bg-primary text-white shadow-md hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-1 dark:border-slate-900';

            function buildTile(url, index) {
                var $tile = $('<div>', { class: tileClasses });
                $tile.append(
                    $('<img>', {
                        src: url,
                        alt: '',
                        class: imgClasses,
                    })
                );
                var $btn = $('<button>', {
                    type: 'button',
                    class: btnClasses,
                    'data-admin-gallery-remove': String(index),
                    title: 'Remove from selection',
                    'aria-label': 'Remove from selection',
                });
                $btn.append(
                    $('<span>', {
                        class: 'material-symbols-outlined text-lg leading-none',
                        text: 'close',
                    })
                );
                $tile.append($btn);
                return $tile;
            }

            galleryFiles.forEach(function (file, index) {
                readAsDataURL(file, function (url) {
                    urls[index] = url || null;
                    pending -= 1;
                    if (pending !== 0) {
                        return;
                    }
                    var shown = 0;
                    for (var i = 0; i < urls.length; i++) {
                        if (urls[i]) {
                            $staging.append(buildTile(urls[i], i));
                            shown += 1;
                        }
                    }
                    if (shown > 0) {
                        $staging.removeClass('hidden');
                        setClearAllVisible(true);
                    } else {
                        $staging.addClass('hidden');
                        setClearAllVisible(false);
                    }
                });
            });
        }

        $staging.on('click', '[data-admin-gallery-remove]', function (e) {
            e.preventDefault();
            var idx = parseInt($(this).attr('data-admin-gallery-remove'), 10);
            if (isNaN(idx) || idx < 0 || idx >= galleryFiles.length) {
                return;
            }
            galleryFiles.splice(idx, 1);
            syncGalleryInputFiles();
            renderGalleryTiles();
        });

        $input.on('change', function () {
            $err.text('');
            var raw = this.files;
            if (!raw || !raw.length) {
                galleryFiles = [];
                syncGalleryInputFiles();
                renderGalleryTiles();
                return;
            }
            var list = Array.prototype.slice.call(raw);
            var check = validateFileList(list);
            if (!check.ok) {
                $err.text(check.message);
                $input.val('');
                galleryFiles = [];
                syncGalleryInputFiles();
                renderGalleryTiles();
                return;
            }
            galleryFiles = list;
            syncGalleryInputFiles();
            renderGalleryTiles();
        });

        $clearAll.on('click', function () {
            $input.val('');
            galleryFiles = [];
            syncGalleryInputFiles();
            $staging.empty().addClass('hidden');
            $err.text('');
            setClearAllVisible(false);
        });
    }

    function bindAll() {
        $('.js-admin-avatar-file').each(function () {
            bindAvatar($(this));
        });
        $('.js-admin-gallery-file').each(function () {
            bindGallery($(this));
        });
    }

    window.AdminImagePreview = {
        init: bindAll,
        /**
         * Optional: refresh limits from API (e.g. after login). Returns jQuery promise.
         */
        fetchConfig: function () {
            var url = window.__ADMIN_MEDIA_CONFIG_URL__;
            if (!url) {
                return $.Deferred().resolve(getConfig());
            }
            return $.getJSON(url).done(function (data) {
                if (data && typeof data === 'object') {
                    window.__ADMIN_MEDIA_CONFIG__ = data;
                }
            });
        },
    };

    $(bindAll);
})(jQuery);
