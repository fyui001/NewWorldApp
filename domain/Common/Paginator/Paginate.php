<?php

declare(strict_types=1);

namespace Domain\Common\Paginator;

use Domain\Common\RawInteger;

class Paginate
{
    public function __construct(
        private Page $page,
        private PerPage $perPage,
    ) {
    }

    public static function make(int $page, int $perPage): self
    {
        return new self(new Page($page), new PerPage($perPage));
    }

    /**
     * @return Page
     */
    public function getPage(): Page
    {
        return $this->page;
    }

    /**
     * @return PerPage
     */
    public function getPerPage(): PerPage
    {
        return $this->perPage;
    }

    public function offset(): Offset
    {
        if ($this->page->isEqual(new RawInteger(1))) {
            return new Offset(0);
        }

        return new Offset(($this->page->getRawValue() - 1) * $this->perPage->getRawValue());
    }

    public function getLimit(): Limit
    {
        return new Limit($this->perPage->getRawValue());
    }
}
