<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WordRepository")
 */
class Word
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $eng;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $rus;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    public function getId()
    {
        return $this->id;
    }

    public function getEng(): ?string
    {
        return $this->eng;
    }

    public function setEng(string $eng): self
    {
        $this->eng = $eng;

        return $this;
    }

    public function getRus(): ?string
    {
        return $this->rus;
    }

    public function setRus(string $rus): self
    {
        $this->rus = $rus;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
