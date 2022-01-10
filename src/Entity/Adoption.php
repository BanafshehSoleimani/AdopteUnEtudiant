<?php

namespace App\Entity;

use App\Repository\AdoptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdoptionRepository::class)]
class Adoption 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;


    #[ORM\Column(type: 'boolean')]
    private $isAdopted = false;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $firstnameStudent;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $photoStudent;

    #[ORM\OneToMany(mappedBy: 'adoption', targetEntity: Student::class)]
    private $student;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'adoptions')]
    private $company;



    public function __construct()
    {
        $this->student = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    

    public function getIsAdopted(): ?bool
    {
        return $this->isAdopted;
    }

    public function setIsAdopted(bool $isAdopted): self
    {
        $this->isAdopted = $isAdopted;

        return $this;
    }

    public function getFirstnameStudent(): ?string
    {
        return $this->firstnameStudent;
    }

    public function setFirstnameStudent(?string $firstnameStudent): self
    {
        $this->firstnameStudent = $firstnameStudent;

        return $this;
    }

    public function getPhotoStudent(): ?string
    {
        return $this->photoStudent;
    }

    public function setPhotoStudent(?string $photoStudent): self
    {
        $this->photoStudent = $photoStudent;

        return $this;
    }

    /**
     * @return Collection|Student[]
     */
    public function getStudent(): Collection
    {
        return $this->student;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->student->contains($student)) {
            $this->student[] = $student;
            $student->setAdoption($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->student->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getAdoption() === $this) {
                $student->setAdoption(null);
            }
        }

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

 







  

   

   
}