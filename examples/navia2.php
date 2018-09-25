<?php
require_once __DIR__.'/../vendor/autoload.php';
// https://www.doctrine-project.org/projects/collections.html
use Doctrine\Common\Collections\ArrayCollection;

$nb = new NaiveBayes([
    ["sunny", "working", "go-out"],
    ["rainy", "broken", "go-out"],
    ["sunny", "working", "go-out"],
    ["sunny", "working", "go-out"],
    ["sunny", "working", "go-out"],
    ["rainy", "broken", "stay-home"],
    ["rainy", "broken", "stay-home"],
    ["sunny", "working", "stay-home"],
    ["sunny", "broken", "stay-home"],
    ["rainy", "broken", "stay-home"],
], 2);

// $nb->setLabelColumn(2);

class NaiveBayes
{
    protected $data;

    protected $columnLabel;

    public function __construct(array $data, int $columnLabel)
    {
        $this->data = new ArrayCollection();
        foreach($data as $row) {
            $this->data->add(new ArrayCollection($row));
        }

        $this->setLabelColumn($columnLabel);

        foreach($this->getClassLabel() as $label){
            echo $label;
        }
    }

    public function setLabelColumn(int $column) : self
    {
        $this->columnLabel = $column;

        return $this;
    }

    public function getLabelData():ArrayCollection
    {
        $label = new ArrayCollection();
        foreach ($this->data as $item) {
            $label->add($item[$this->columnLabel]);
        }

        return $label;
    }

    public function getClassLabel() : ArrayCollection
    {
        $labelClass = new ArrayCollection;
        foreach($this->getLabelData() as $label) 
            if (!$labelClass->contains($label)) {
                $labelClass->set($label, $this->getLabelData()->containsKey($label)->count());
            }
        return $labelClass;
    }

}
