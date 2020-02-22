<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResultRepository")
 */
class Result
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="results", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $username;

    /**
     * @ORM\Column(type="integer")
     */
    private $correctAnswers;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime")
     */
    private $finish;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Quiz", inversedBy="results")
     */
    private $quiz;

    public function __construct()
    {
        $this->quiz = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?User
    {
        return $this->username;
    }

    public function setUsername(User $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getCorrectAnswers(): ?int
    {
        return $this->correctAnswers;
    }

    public function setCorrectAnswers(int $correctAnswers): self
    {
        $this->correctAnswers = $correctAnswers;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getFinish(): ?\DateTimeInterface
    {
        return $this->finish;
    }

    public function setFinish(\DateTimeInterface $finish): self
    {
        $this->finish = $finish;

        return $this;
    }

    /**
     * @return Collection|Quiz[]
     */
    public function getQuiz(): Collection
    {
        return $this->quiz;
    }

    public function addQuiz(Quiz $quiz): self
    {
        if (!$this->quiz->contains($quiz)) {
            $this->quiz[] = $quiz;
            $quiz->setResults($this);
        }

        return $this;
    }

    public function removeQuiz(Quiz $quiz): self
    {
        if ($this->quiz->contains($quiz)) {
            $this->quiz->removeElement($quiz);
            // set the owning side to null (unless already changed)
            if ($quiz->getResults() === $this) {
                $quiz->setResults(null);
            }
        }

        return $this;
    }
}
