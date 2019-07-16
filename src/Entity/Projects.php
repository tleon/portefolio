<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectsRepository")
 */
class Projects
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $link;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="projects")
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Attachments", cascade={"persist", "remove"})
     */
    private $attachment;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tools", mappedBy="projects")
     */
    private $tools;

    public function __construct()
    {
        $this->tools = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAttachment(): ?Attachments
    {
        return $this->attachment;
    }

    public function setAttachment(?Attachments $attachment): self
    {
        $this->attachment = $attachment;

        return $this;
    }

    /**
     * @return Collection|Tools[]
     */
    public function getTools(): Collection
    {
        return $this->tools;
    }

    public function addTool(Tools $tool): self
    {
        if (!$this->tools->contains($tool)) {
            $this->tools[] = $tool;
            $tool->addProject($this);
        }

        return $this;
    }

    public function removeTool(Tools $tool): self
    {
        if ($this->tools->contains($tool)) {
            $this->tools->removeElement($tool);
            $tool->removeProject($this);
        }

        return $this;
    }
}
