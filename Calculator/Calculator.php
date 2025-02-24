<?php
class Calculator {
    public function calc($operator, $num1 = null, $num2 = null) {
        // Validate operator
        if (!in_array($operator, ["+", "-", "*", "/"])) {
            return "<p>Cannot perform operation. The first argument must be a valid operator (+,-,*,/).</p>";
        }

        // Validate numbers
        if (!is_numeric($num1) || !is_numeric($num2)) {
            return "<p>Cannot perform operation. You must have three arguments. A string for the operator (+,-,*,/) and two integers or floats for the numbers.</p>";
        }

        // Perform calculation based on the operator
        switch ($operator) {
            case "+":
                $result = $num1 + $num2;
                break;
            case "-":
                $result = $num1 - $num2;
                break;
            case "*":
                $result = $num1 * $num2;
                break;
            case "/":
                if ($num2 == 0) {
                    return "<p>The calculation is $num1 / $num2. The answer is cannot divide a number by zero.</p>";
                }
                $result = $num1 / $num2;
                break;
            default:
                return "<p>Cannot perform operation. Invalid operator.</p>";
        }

        return "<p>The calculation is $num1 $operator $num2. The answer is $result.</p>";
    }
}
?>
