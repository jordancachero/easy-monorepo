<?php
declare(strict_types=1);

namespace EonX\EasyCfhighlander\Interfaces;

use EonX\EasyCfhighlander\File\FileStatus;
use EonX\EasyCfhighlander\File\File;

interface FileGeneratorInterface
{
    /** @var string[] */
    public const STATUSES = [
        self::STATUS_CREATED,
        self::STATUS_REMOVED,
        self::STATUS_SKIPPED_IDENTICAL,
        self::STATUS_SKIPPED_NO_FILE,
        self::STATUS_UPDATED
    ];

    /** @var string[] */
    public const STATUSES_TO_TRIGGER_MANIFEST = [
        self::STATUS_CREATED,
        self::STATUS_REMOVED,
        self::STATUS_UPDATED
    ];

    /** @var string */
    public const STATUS_CREATED = 'created';

    /** @var string */
    public const STATUS_REMOVED = 'removed';

    /** @var string */
    public const STATUS_SKIPPED_IDENTICAL = 'skipped_identical';

    /** @var string */
    public const STATUS_SKIPPED_NO_FILE = 'skipped_no_file';

    /** @var string */
    public const STATUS_UPDATED = 'updated';

    /**
     * Generate file for given template and params.
     *
     * @param \EonX\EasyCfhighlander\File\File $fileToGenerate
     * @param null|mixed[] $params
     *
     * @return \EonX\EasyCfhighlander\File\FileStatus
     */
    public function generate(File $fileToGenerate, ?array $params = null): FileStatus;

    /**
     * Remove given file.
     *
     * @param \EonX\EasyCfhighlander\File\File $fileToRemove
     *
     * @return \EonX\EasyCfhighlander\File\FileStatus
     */
    public function remove(File $fileToRemove): FileStatus;
}
