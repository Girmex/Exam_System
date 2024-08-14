var focusedTextarea = null; 

  function setFocusedTextarea(textarea) {
    focusedTextarea = textarea;
    console.log("Focused textarea:", focusedTextarea);
  }
  function insertSuperscript() {
    console.log("Inserting superscript");
    var number = prompt("Enter the number for superscript:");
    console.log("Number for superscript:", number);
    if (number !== null) {
      var superscript = '';
      switch (number) {
        case '0':
          superscript = '⁰';
          break;
        case '1':
          superscript = '¹';
          break;
        case '2':
          superscript = '²';
          break;
        case '3':
          superscript = '³';
          break;
        case '4':
          superscript = '⁴';
          break;
        case '5':
          superscript = '⁵';
          break;
        case '6':
          superscript = '⁶';
          break;
        case '7':
          superscript = '⁷';
          break;
        case '8':
          superscript = '⁸';
          break;
        case '9':
          superscript = '⁹';
          break;
        default:
          superscript = '^{' + number + '}';
      }
      insertSymbol(superscript);
    }
  }
  
  function insertSubscript() {
    console.log("Inserting subscript");
    var number = prompt("Enter the number for subscript:");
    console.log("Number for subscript:", number);
    if (number !== null) {
      var subscript = '';
      switch (number) {
        case '0':
          subscript = '₀';
          break;
        case '1':
          subscript = '₁';
          break;
        case '2':
          subscript = '₂';
          break;
        case '3':
          subscript = '₃';
          break;
        case '4':
          subscript = '₄';
          break;
        case '5':
          subscript = '₅';
          break;
        case '6':
          subscript = '₆';
          break;
        case '7':
          subscript = '₇';
          break;
        case '8':
          subscript = '₈';
          break;
        case '9':
          subscript = '₉';
          break;
        default:
          subscript = '_{' + number + '}';
      }
      insertSymbol(subscript);
    }
  }
  

function insertSymbol(symbol) {
    var focusedTextarea = document.activeElement;
    var textarea = document.querySelector('#question-frm textarea');
    
    if (textarea) {
      textarea.focus(); 
      
      var currentPosition = textarea.selectionStart;
      var newValue = textarea.value.substring(0, currentPosition) + symbol + textarea.value.substring(currentPosition);
      textarea.value = newValue;
      textarea.focus();
    }
  }
   
  