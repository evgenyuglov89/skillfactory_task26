<?php

class HtmlIterator implements \Iterator
{
    protected $filePointer = null;
    protected $rowCounter = 0;
    protected $arr = [];
    public function __construct($file)
    {
        try {
            $this->filePointer = fopen($file, 'rb');
            while (false !== ($char = fgets($this->filePointer))) {
                $this->arr[] = $char;
            }
        } catch (\Exception $e) {
            throw new \Exception('The file "' . $file . '" cannot be read.');
        }
    }
    public function rewind(): void
    {
        $this->rowCounter = 0;
    }
    public function current() : mixed
    {
        if(strrpos($this->arr[$this->rowCounter], 'meta') != false && strrpos($this->arr[$this->rowCounter], 'keywords') != false) {
            return null;
        }
        if(strrpos($this->arr[$this->rowCounter], 'meta') != false && strrpos($this->arr[$this->rowCounter], 'description') != false) {
            return null;
        }

        return $this->arr[$this->rowCounter];
    }
    public function key(): int
    {
        return $this->rowCounter;
    }
    public function next(): void
    {
        $this->rowCounter++;
    }
    public function valid(): bool
    {
        return isset($this->arr[$this->rowCounter]);
    }
}


$html = new HtmlIterator('html.txt');

foreach ($html as $key => $row) {
    echo htmlentities($row) . '<br>';
}

