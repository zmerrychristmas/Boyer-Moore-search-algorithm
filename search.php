<?php
class Search
{
    protected $subString;
    protected $mainString;
    public static $recently = [];

    public function __construct($subString = '', $mainString = '')
    {
        $this->$subString = $subString;
        $this->$mainString = $mainString;
    }

    public static function search($subString = '', $mainString = '', $algothirm = 1) {
        $result = [];
        if ($subString == '' || $mainString == '') {
            // String is empty
        } else {
            if ($algothirm == 1) {
                $result = self::boyerMoreSearch($subString, $mainString);
            }
        }
        self::$recently = $result;
        return $result;
    }

    protected static function boyerMoreSearch($subString, $mainString)
    {
        $result = [];
        $sub_len = strlen($subString);
        $main_len = strlen($mainString);
        if ($sub_len > $main_len || $sub_len == 0 || $main_len == 0) {
            return $result;
        }

        $badChar = self::_badCharacter($subString);
        $i = 0;
        $skip = 1;
        while($i <= ($main_len - $sub_len)) {
            $tmp = 0;
            $j = $sub_len - 1;
            while ($j >= 0 && $subString[$j] == $mainString[$i + $j]) {
                $j--;
            }
            if ($j < 0) { // Match sub_string into main_string
                $tmp ++;
                $result[] = $i;
                // get next last char index
                $i++;
            } else {
                // Finding the bad character with index nearest to the left side
                $char = $badChar[self::_getASCIIKey($mainString[$i + $j])];
                $charIndexs = explode(',', $char);
                $leftIndex = -1;
                foreach($charIndexs as $charIndex) {
                    if ($charIndex > $j) {
                        break;
                    } else {
                        $leftIndex = $charIndex;
                    }
                }
                $i += max(1, $j - $leftIndex);
            }
        }
        return $result;
    }

    /**
     * [_badCharacter give position of alphabelt in String: 'sub-string']
     * @param  [String] $subString ['string need to get index']
     * @return [Array]
     */
    protected static function _badCharacter($subString)
    {
        $badChar = [];
        for ($i = 0; $i < 256; $i ++) {
            // Prepare array position appear word of Alphabelt in $subString
            $badChar[$i] = -1;
        }
        $len = strlen($subString);
        for($i = 0; $i < $len; $i ++) {
            // List position appear
            if ($badChar[self::_getASCIIKey($subString[$i])] != -1) {
                $badChar[self::_getASCIIKey($subString[$i])] .= ',' . $i;
            } else {
                $badChar[self::_getASCIIKey($subString[$i])] = $i;
            }
        }
        return $badChar;
    }

    public function getResult()
    {
        $result = Search::search($this->subString, $this->mainString);
        return $result;
    }

    private static function _getASCIIKey($word)
    {
        return ord($word);
    }
};
