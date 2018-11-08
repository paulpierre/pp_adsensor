<?php
require_once 'wlJSOLex.php';
require_once 'wlJSOUtils.php';
require_once 'lib/jtokenizer.php';

if(class_exists('wlJSOJsParser')) {
    return;
}

/**
 * WiseLoop JavaScript Obfuscator JavaScript Parser class definition<br/>
 *
 * @author WiseLoop
 */
class wlJSOJsParser {
    /**
     * @var string - the original JavaScript source code.
     */
    private $_jsCode;

    /**
     * @var array -the tokenized JavaScript source code.
     */
    private $_tokens;

    /**
     * @var int - number of tokens.
     */
    private $_tokenCount;

    /**
     * Constructor.<br/>
     * Creates a wlJSOJsParser object and builds up the token list.
     * @param string $js the original JavaScript source code
     */
    public function __construct($js) {
        $this->_jsCode = $js;
        $t = new JTokenizer(true, true);
        $this->_tokens = $t->get_all_tokens($js);
        $this->_tokenCount = count($this->_tokens);
    }

    public function getCode() {
        return $this->_jsCode;
    }

    /**
     * Gets the relative token from position $i considering steps specified by $step parameter;
     * this is useful when locating next or previous token from the position specified by $i;
     * when searching tokens, optionally spaces, new lines or other neutral characters can be skipped.
     * @param int $i the token index to be retrieved
     * @param int $retIndex used internally when $step is specified (it must be set)
     * @param int $step the step taken relative to $i in order to find the desired token (can be positive or negative)
     * @param bool $skipSpaces specifies if neutral characters should be skipped when searching tokens using $step value
     * @return array|null the founded token or null if no token was founded
     */
    private function getToken($i, &$retIndex, $step = 0, $skipSpaces = false) {
        $i += $step;
        $retIndex = $i;
        if($i >= 0 && $i < $this->_tokenCount)
        {
            $ret = $this->_tokens[$i];
            $tokenType = $ret[0];
            if($step !== 0 && $skipSpaces && ($tokenType === J_WHITESPACE || $tokenType === J_LINE_TERMINATOR || $tokenType === J_COMMENT)) {
                return $this->getToken($i, $retIndex, $step, true);
            }
            return $ret;
        }
        return null;
    }

    /**
     * Gets a list of variables that can be safely renamed across the whole script source code.
     * @return array
     */
    public function getVars() {
        $ret = array();
        $forbidden = array();

        foreach($this->_tokens as $i=>$tok) {
            $tokType = $tok[0];
            $tokValue = $tok[1];

            if($tokType === J_IDENTIFIER && !in_array(strtolower($tokValue), wlJSOLex::$RESERVED)) {
                if(!in_array($tokValue, $ret)) {
                    $ret[] = $tokValue;
                }

                $forbid = false;

                $prevTok = $this->getToken($i, $prevI, -1, true);
                $prevTokType = $prevTok === null ? null : $prevTok[0];
                $prevTokValue = $prevTok === null ? null : $prevTok[1];
                $nextTok = $this->getToken($i, $nextI, +1, true);
                $nextTokValue = $nextTok === null ? null : $nextTok[1];

                if($prevTokValue === '.') {
                    $forbid = true;
                }elseif($prevTokValue === ',') {
                    $forbid = true;
                }elseif($prevTokType === J_REGEX) {
                    $forbid = true;
                }elseif($prevTokType === J_NUMERIC_LITERAL) {
                    $forbid = true;
                }elseif($prevTokValue === '{' && $nextTokValue === ':') {
                    $forbid = true;
                }elseif($nextTokValue === ':' && $prevTokValue !== '?') {
                    $forbid = true;
                }elseif($nextTokValue === '(') {
                    $forbid = true;
                }elseif($nextTokValue === '.') {
                    $forbid = true;
                }

                if($forbid && !in_array($tokValue, $forbidden)) {
                    $forbidden[] = $tokValue;
                }
            }
        }

        foreach($forbidden as $unToken) {
            if(in_array($unToken, $ret)) {
                unset($ret[array_search($unToken, $ret)]);
            }
        }
        return $ret;
    }

    /**
     * Renders the JavaScript code from the token list.
     * @return string the rendered JavaScript code
     */
    public function render() {
        $ret = '';
        foreach($this->_tokens as $tok) {
            $ret.=$tok[1];
        }
        return $ret;
    }

    /**
     * Replaces some identifiers (variables) from JavaScript based on a dictionary.
     * @param array $identifiersMap the dictionary of mapped identifiers
     */
    public function renameIdentifiers($identifiersMap) {
        foreach($this->_tokens as $i=>$tok) {
            $tokType = $tok[0];
            $tokValue = $tok[1];
            if($tokType == J_IDENTIFIER && array_key_exists($tokValue, $identifiersMap)) {
                $this->_tokens[$i][1] = $identifiersMap[$tokValue];
            }
        }
    }

    /**
     * Performs minimization and compressing against the token list.<br/>
     * It safely removes comments, whitespaces, tabs, line feeds and other neutral tokens from the token list.
     */
    public function minify() {
        $lex = wlJSOLex::get('wlJSOLex');
        $noSpacesAroundThem = array_keys($lex->getLiterals());

        $prevType = '';

        foreach($this->_tokens as $i=>$tok) {
            $go = false;
            $tokType = $tok[0];
            if($tokType != J_COMMENT) {
                if($tokType == J_WHITESPACE || $tokType == J_LINE_TERMINATOR) {
                    $nextTok = $this->getToken($i, $nextI, +1, true);
                    $nextTokType = $nextTok === null ? null : $nextTok[1];

                    if(!in_array($prevType, $noSpacesAroundThem) && !in_array($nextTokType, $noSpacesAroundThem)) {
                        $go = true;
                    }
                }else {
                    $go = true;
                }
            }

            if($go) {
                $prevType = $tokType;
            }else {
                unset($this->_tokens[$i]);
            }

        }
    }
}
