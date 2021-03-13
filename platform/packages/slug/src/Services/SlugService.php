<?php

namespace Botble\Slug\Services;

use Botble\Slug\Repositories\Interfaces\SlugInterface;
use Illuminate\Support\Str;
use SlugHelper;

class SlugService
{
    /**
     * @var SlugInterface
     */
    protected $slugRepository;

    /**
     * SlugService constructor.
     * @param SlugInterface $slugRepository
     */
    public function __construct(SlugInterface $slugRepository)
    {
        $this->slugRepository = $slugRepository;
    }

    /**
     * @param string $name
     * @param int $slugId
     * @return int|string
     */
    public function create($name, $slugId = 0, $model = null)
    {
        // $slug = Str::slug($name);
        $slug = $this->slug($name);
        $index = 1;
        $baseSlug = $slug;

        $prefix = null;
        if (!empty($model)) {
            $prefix = SlugHelper::getPrefix($model);
        }

        while ($this->checkIfExistedSlug($slug, $slugId, $prefix)) {
            $slug = apply_filters(FILTER_SLUG_EXISTED_STRING, $baseSlug . '-' . $index++, $baseSlug, $index, $model);
        }

        if (empty($slug)) {
            $slug = time();
        }

        return apply_filters(FILTER_SLUG_STRING, $slug, $model);
    }

    /**
     * @param string $slug
     * @param string $slugId
     * @param string $prefix
     * @return bool
     */
    protected function checkIfExistedSlug($slug, $slugId, $prefix)
    {
        return $this->slugRepository
                ->getModel()
                ->where([
                    'key'    => $slug,
                    'prefix' => $prefix,
                ])
                ->where('id', '!=', $slugId)
                ->count() > 0;
    }

    function slug($str, $limit = null) {
        if ($limit) {
            $str = mb_substr($str, 0, $limit, "utf-8");
        }
        $text = html_entity_decode($str, ENT_QUOTES, 'UTF-8');
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        // trim
        $text = trim($text, '-');
        return mb_strtolower($text);
    }
}
