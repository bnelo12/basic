<?php

class math { 

    public function getValueOfFunction($mathFunction) {
		return $this->evaluateFunction($this->removeWhiteSpaces($mathFunction));
	}
    
	function removeWhiteSpaces($mathFunction) { 
        return preg_replace('/\s+/', '', $mathFunction);
    } 
	
	function evaluateFunction($mathFunction){
	
			$number = '(?:\d+(?:[,.]\d+)?|pi|π)'; // What is a number
			$functions = '(?:sinh?|cosh?|tanh?|abs|acosh?|asinh?|atanh?|exp|log10|deg2rad|rad2deg|sqrt|ceil|floor|round)'; // Allowed PHP functions
			$operators = '[+\/*\^%-]'; // Allowed math operators
			$regexp = '/^(('.$number.'|'.$functions.'\s*\((?1)+\)|\((?1)+\))(?:'.$operators.'(?2))?)+$/'; // Final regexp, heavily using recursive patterns

			if (preg_match($regexp, $mathFunction))
			{
				$mathFunction = preg_replace('!pi|π!', 'pi()', $mathFunction); // Replace pi with pi function
				eval('$result = '.$mathFunction.';');
				return $result;
			}
			else
			{
				return "Syntax Error";
			}
	}
	
} 

?>