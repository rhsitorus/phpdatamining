<?php 
namespace Algorithms;

class NaiveBayes
{
    protected $data = [];
    protected $attributes = [];
    protected $prob = [];

    public function __construct(array $data, array $attributes)
    {
        $this->data  = $data;
        $this->attributes = $attributes;
    }

    protected function getTargetValues()
    {
        $targetValues = [];

        foreach ($this->data as $item) {
            $targetValues[] = $item[count($this->attributes)];
        }

        return $targetValues;
    }

    public function getLabelClass()
    {
        return array_unique($this->getTargetValues());
    }

    protected function _hitung() 
    {
        $statisticKelas = array_count_values($this->getTargetValues());
        $probabilitasKelas = [];
        foreach($statisticKelas as $kelas => $stat) {
            $probabilitasKelas[$kelas]['prob'] = $stat/count($this->data);
        }

        foreach ($this->attributes as $indexAttribute=>$attribute) {
            $kelasAttribute = [];
            foreach ($this->getLabelClass() as $labelClass) {
                $p = $this->getDataByAttributeAndClassLabel($indexAttribute, $labelClass);
                $statistikKasusByAttributes = array_count_values($p);
                foreach ($statistikKasusByAttributes as $kasus => $nilai) {
                    $ratio= $nilai/count($p);
                    $probabilitasKelas[$labelClass][$attribute][$kasus] = $ratio;
                }
            }

        }
        $this->prob = $probabilitasKelas;
    }


    protected function getDataByAttributeAndClassLabel(int $attributeIndex, string $labelClass)
    {
        $data = [];

        foreach($this->data as $item) {
            if ($item[count($this->attributes)] == $labelClass) {
                $data[] = $item[$attributeIndex];
            }
        }

        return $data;
    }

    public function run()
    {
        $this->_hitung();

        return $this;
    }

    public function predict(array $data)
    {
        $prediction = [];
        foreach($this->getLabelClass() as $labelClass) {
            $probabilistik = $this->prob[$labelClass]['prob'];
            foreach($data as $indexAttribute => $av) {
                $probabilistik = $probabilistik * @$this->prob[$labelClass][$this->attributes[$indexAttribute]][$av];
            }
            $prediction[$labelClass] = $probabilistik;
        }
        krsort($prediction);
        return array_keys($prediction)[0];        
    }
}

?>