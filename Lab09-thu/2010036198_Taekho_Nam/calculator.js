"use strict"
var stack = [];
window.onload = function () {
    /*  value -> 버튼에 있는 글자
        displayVal -> 아래 쪽 결과 값 
        expr -> 위 쪽 연산 식   
        bracketCount -> 괄호 검사용  */
    var displayVal = "0";
    var expr = "0";
    var bracketCount = 0;
    var zeroFlag = true;
    for (var i in $$('button')) {
        $$('button')[i].onclick = function () {
            var value = $(this).innerHTML;
            
            $('result').innerHTML = displayVal;

            if(value == "0" || value == "1" || value == "2" || value == "3" || value == "4" || value == "5" || value == "6" || value == "7" || value == "8" || value == "9") {


                /* 새로 시작 */
                if(expr.indexOf("=") > -1) {
                    stack = [];
                    expr = "";
                    displayVal = "0";
                }
                
                
                

                /* ')' 뒤 곱하기 처리 */
                if(stack[stack.length-1] == ")" && value == "0") {


                } else if (stack[stack.length-1] == ")" && value != "0") {
                    stack.push("*");
                    displayVal += value;
                    expr += value;

                    if(displayVal.charAt("0") == "0") {
                        if(displayVal.indexOf(".") > -1) {

                        } else {
                            displayVal = displayVal.substring(1, displayVal.length);    
                        }
                        if(zeroFlag) {
                            expr = expr.substring(1, expr.length);    
                        }
                    }
                } else {
                    displayVal += value;
                    expr += value;

                    if(displayVal.charAt("0") == "0") {
                        if(displayVal.indexOf(".") > -1) {

                        } else {
                            displayVal = displayVal.substring(1, displayVal.length);    
                        }
                        if(zeroFlag) {
                            expr = expr.substring(1, expr.length);    
                            
                        }
                    }
                }
                $('expression').innerHTML = expr;
                print_r(stack);



            } else if (value == "AC") {
                stack = [];
                expr = 0;
                displayVal = 0;
                $('expression').innerHTML = expr;



            } else if (value == ".") {
                /*  displayVal에 '.'이 있는 지 확인
                    있으면 있는 그대로 표현식 적용
                    없으면 하나 추가               */
                zeroFlag = false;

                /* '.' 다음에 '(', ')' 올 경우 */
                if(displayVal.indexOf(".") > -1) {
                    $('expression').innerHTML = expr;
                } else {
                    expr += value;
                    displayVal += value;
                    $('expression').innerHTML = expr;
                }



            } else if (value == "(") {
                /*  '(' 앞에 숫자일 경우에는 숫자를 stack에 넣어주지만
                    만약 0이거나 숫자일 경우에는 스택에 넣지 말 것 */
                if(!(displayVal == "0")) {
                    stack.push(displayVal);
                    stack.push("*");
                }
                stack.push(value);
                zeroFlag = false;
                bracketCount++
                expr += value;
                displayVal = "0";

                $('expression').innerHTML = expr;

                print_r(stack);
            } else if (value == ")") {
                zeroFlag = false;
                stack.push(displayVal);
                if((stack[stack.length-1] != "+") && (stack[stack.length-1] != "-") && (stack[stack.length-1] != "*") && (stack[stack.length-1] != "/") && (stack[stack.length-1] != "0")) {
                
                    if(bracketCount > 0) {
                        stack.push(value);
                        expr += value;
                        displayVal = "0";
                        bracketCount--;
                        $('expression').innerHTML = expr;
                    } else {
                        stack.pop();
                        $('expression').innerHTML = expr;
                    }

                } else {
                    stack.pop();
                }
                print_r(stack);



            } else {
                zeroFlag = false;
                var postFixStack;
                if(value == "=") {
                    for(var i in stack) {
                        if((stack[i] != "(") && (stack[i] != ")") && (stack[i] != "+") && (stack[i] != "-") && (stack[i] != "*") && (stack[i] != "/")) {
                            stack[i] = parseFloat(stack[i]);
                        } 
                    }
                    if(((stack[stack.length-1] != "+") && (stack[stack.length-1] != "-") && (stack[stack.length-1] != "*") && (stack[stack.length-1] != "/")) || (displayVal != "0")) {
                        if(stack.length == 0) {

                        } else {
                            if(displayVal != 0) {
                                stack.push(displayVal);    
                            }
                            if(isValidExpression){
                                expr += value;
                                postFixStack = infixToPostfix(stack);
                                print_r(stack);
                                print_r(postFixStack);
                                displayVal = postfixCalculate(postFixStack);
                            }
                            
                        }
                    } else {

                    }
                    /* 앞에 연산자일 경우 클릭 안되도록 */
                    $('expression').innerHTML = expr;
                } else {
                    if(((stack[stack.length-1] != "+") && (stack[stack.length-1] != "-") && (stack[stack.length-1] != "*") && (stack[stack.length-1] != "/") && (stack[stack.length-1] != "(")) || (displayVal != "0")) {
                        stack.push(displayVal);
                        stack.push(value);
                        print_r(stack);
                        expr += value;
                        displayVal = "0";
                    }


                    /* 앞에 연산자일 경우 클릭 안되도록 */
                    $('expression').innerHTML = expr;
                    print_r(stack);
                }

            }
            document.getElementById('result').innerHTML = displayVal;
        }; 
    }
}

function isValidExpression(s) {
    var count = 0;
    for(var i in s) {
        if(s[i] == "(") {
            count++;
        } 
        if(s[i] == ")") {
            count--;
        }
    }
    if(count == 0) {
        return true;
    } else {
        return false;
    }
}

function infixToPostfix(s) {
    var priority = {
        "+":0,
        "-":0,
        "*":1,
        "/":1
    };
    var tmpStack = [];
    var result = [];
    for(var i =0; i<stack.length ; i++) {
        if(/^[0-9]+$/.test(s[i])){
            result.push(s[i]);
        } else {
            if(tmpStack.length === 0){
                tmpStack.push(s[i]);
            } else {
                if(s[i] === ")"){
                    while (true) {
                        if(tmpStack.last() === "("){
                            tmpStack.pop();
                            break;
                        } else {
                            result.push(tmpStack.pop());
                        }
                    }
                    continue;
                }
                if(s[i] ==="(" || tmpStack.last() === "("){
                    tmpStack.push(s[i]);
                } else {
                    while(priority[tmpStack.last()] >= priority[s[i]]){
                        result.push(tmpStack.pop());
                    }
                    tmpStack.push(s[i]);
                }
            }
        }
    }
    for(var i = tmpStack.length; i > 0; i--){
        result.push(tmpStack.pop());
    }
    return result;
}

function postfixCalculate(s) {
    var tempArr = [];
    var num1, num2, oper, result;
    while(s.length > 0) {
        if(((s[0] != "+") && (s[0] != "-") && (s[0] != "*") && (s[0] != "/"))) {
            tempArr.push(s.shift());
        } else {
            oper = s.shift();
            num2 = parseFloat(tempArr.pop());
            num1 = parseFloat(tempArr.pop());
        
            if(oper == "+") {
                result = num1 + num2;
            } else if (oper == "-") {
                result = num1 - num2;
            } else if (oper == "*") {
                result = num1 * num2;
            } else if (oper == "/") {
                result = num1 / num2;
            }
            
            tempArr.push(result);
        }    
    }
    
    
    return result;
    
}

function print_r(s) {
    for(var i in s) {
        console.log("["+i+"] => " + s[i] + " <br/>"); 
    }
    /* \[[0-9]+\] => */
}
