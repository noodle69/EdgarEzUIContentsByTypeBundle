<?php

namespace Edgar\EzUIContentsByType\Form\Data;

use eZ\Publish\Core\Repository\Values\ContentType\ContentType;
use Symfony\Component\Validator\Constraints as Assert;

class FilterContentData
{
    /**
     * @var int
     *
     * @Assert\Range(
     *     max = 1000
     * )
     */
    private $limit;

    /** @var int */
    private $page;

    /**
     * @var ContentType
     *
     * @Assert\NotBlank()
     */
    private $content_type;

    /**
     * SimpleSearchData constructor.
     *
     * @param int $limit
     * @param int $page
     * @param ContentType|null $content_type
     */
    public function __construct(int $limit = 10, int $page = 1, ?ContentType $content_type = null)
    {
        $this->limit = $limit;
        $this->page = $page;
        $this->content_type = $content_type;
    }

    /**
     * @param int $limit
     *
     * @return FilterContentData
     */
    public function setLimit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @param int $page
     *
     * @return FilterContentData
     */
    public function setPage(int $page): self
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @param ContentType|null $content_type
     *
     * @return FilterContentData
     */
    public function setContentType(?ContentType $content_type): self
    {
        $this->content_type = $content_type;

        return $this;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return ContentType|null
     */
    public function getContentType(): ?ContentType
    {
        return $this->content_type;
    }
}
