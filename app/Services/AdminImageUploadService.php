<?php

namespace App\Services;

use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Shared limits and validation rules for admin image uploads.
 * Client-side preview uses {@see self::clientConfig()} (injected in layout) or {@see AdminMediaConfigController}.
 */
class AdminImageUploadService
{
    /** Max file size (KB) for product/package avatar and gallery uploads. */
    public const ADMIN_IMAGE_MAX_KILOBYTES = 5120;

    /** Max file size (KB) for blog post home card image. */
    public const POST_AVATAR_MAX_KILOBYTES = 3072;

    /**
     * @return list<string|ValidationRule>
     */
    public static function adminAvatarFileRules(): array
    {
        return ['nullable', 'file', 'image', 'max:'.self::ADMIN_IMAGE_MAX_KILOBYTES];
    }

    /**
     * @return list<string|ValidationRule>
     */
    public static function adminGalleryItemRules(): array
    {
        return ['nullable', 'file', 'image', 'max:'.self::ADMIN_IMAGE_MAX_KILOBYTES];
    }

    /**
     * @return list<string|ValidationRule>
     */
    public static function postAvatarRules(): array
    {
        return ['nullable', 'image', 'max:'.self::POST_AVATAR_MAX_KILOBYTES];
    }

    /**
     * @return array<string, int>
     */
    public static function clientConfig(): array
    {
        return [
            'defaultMaxFileKilobytes' => self::ADMIN_IMAGE_MAX_KILOBYTES,
            'postAvatarMaxKilobytes' => self::POST_AVATAR_MAX_KILOBYTES,
        ];
    }
}
