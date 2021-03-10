<?php

namespace App\Entity;

class Choice
{
    /**
     * Choice constructor.
     * @param int|null $id
     */
    public function __construct(?int $id = null)
    {
        $this->setId($id);
    }

    /**
     * @var int|null
     */
    private ?int $id = null;

    /**
     * @var string
     */
    private $text;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }
}
