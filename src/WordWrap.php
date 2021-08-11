<?php


namespace KaywGeek;

/**
 * Class WordWrap
 * @package KaywGeek
 * @author kayw-geek <weikaiii@sina.cn>
 * @see https:://www.github.com/kayw-geek/php-wordwrap.git
 */
class WordWrap
{
    /**
     * Specifies to return a data format constant
     */
    const FORMAT_STRING = 1;
    const FORMAT_ARRAY = 2;
    const FORMAT_JSON = 3;
    /**
     * Specifies the length of the split character
     * @var int
     */
    private $width = 20;

    /**
     * Specifies the string you want to split
     * @var
     */
    private $text = '';

    /**
     * By default, long words will not break. Unless you set the break option.
     * @var bool
     */
    private $break = false;

    /**
     * Custom newline characters
     * @var string[]
     */
    public $lf = [',','?',';'];

    private $lfWrapEnable = false;
    /**
     * List of supported return formats
     * @var int[]
     */
    private $formatList = [
        self::FORMAT_STRING,
        self::FORMAT_ARRAY,
        self::FORMAT_JSON,
    ];
    /**
     * Specifies which format to return
     * @var int
     */
    private $responseFormat = self::FORMAT_STRING;
    /**
     * Chained call assignment
     */
    public function break(bool $break = true)
    {
        $this->break = $break;
        return $this;
    }
    /**
     * Chained call assignment
     */
    public function width(int $width)
    {
       $this->width = $width;
       return $this;
    }
    /**
     * Chained call assignment
     */
    public function lfEnable(bool $status = true)
    {
        $this->lfWrapEnable = $status;
        return $this;
    }
    /**
     * Chained call assignment
     */
    public function responseFormat(int $format)
    {
        if (!in_array($format,$this->formatList)){
            throw new InvalidArgumentException('Incorrectly specified format');
        }
        $this->responseFormat = $format;
        return $this;
    }
    /**
     * Loading text
     * @throws InvalidArgumentException
     */
    private function loadText()
    {
        if ($this->text === ''){
            throw new InvalidArgumentException('Text is empty');
        }
        if (!is_string($this->text)){
            throw new InvalidArgumentException('Text It\'s not a string');
        }
        if ($this->width <= 1){
            throw new InvalidArgumentException('Specifies that the width is too short');
        }
        $this->text = trim($this->text);
    }

    /**
     * Set the text
     * @param string $text
     * @return $this
     * @throws InvalidArgumentException
     */
    public function text(string $text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * Wrapping operation
     * @return string
     * @throws InvalidArgumentException
     */
    public function wrap()
    {
        $this->loadText();
        if (strlen($this->text) <= $this->width){
            return $this->format();
        }
        if ($this->lfWrapEnable){
            $this->text = str_replace($this->lf,','.PHP_EOL,$this->text);
            return $this->format();
        }
        $strArr = str_split($this->text,$this->width);
        foreach ($strArr as $key=>&$str){
            $str = ltrim($str);
            for ($i = min(strlen($str) -1,$this->width);$i > 0;$i--){
                if ($str[$i] === ' '){
                    $strArr[$key+1] = (substr($str,$i) ?: '').$strArr[$key+1];
                    $str = substr($str,0,$i) ?: ''.PHP_EOL;
                    break;
                }
                if ($str[$i] !== ' '){
                    if ($i == 1 && !$this->break){
                        if (isset($strArr[$key+1])){
                            $str = $str.substr($strArr[$key+1],strripos($strArr[$key+1],' '));
                            unset($strArr[$key+1]);
                        }
                    }
                    continue;
                }

            }
        }
        $this->text = implode(PHP_EOL,$strArr);
        return $this->format();
    }

    /**
     * Formatting text
     * @return string
     * @throws InvalidArgumentException
     */
    private function format()
    {
        if (!in_array($this->responseFormat,$this->formatList)){
            throw new InvalidArgumentException('Incorrectly specified format');
        }
        switch ($this->responseFormat){
            case self::FORMAT_STRING:{
                $this->text =  (string) $this->text;
                break;
            }
            case self::FORMAT_ARRAY:{
                $this->text = explode(PHP_EOL,$this->text);
                break;
            }
            case self::FORMAT_JSON:{
                $this->text = json_encode(explode(PHP_EOL,$this->text));
                break;
            }
            default:{
                $this->text = (string) $this->text;
                break;
            }
        }
        return $this->text;
    }
}