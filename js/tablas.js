var headertext = [],
headers = document.querySelectorAll("#miyazaki th"),
tablerows = document.querySelectorAll("#miyazaki th"),
tablebody = document.querySelector("#miyazaki tbody");

for(var i = 0; i < headers.length; i++) {
  var current = headers[i];
  headertext.push(current.textContent.replace(/\r?\n|\r/,""));
} 
for (var i = 0, row; row = tablebody.rows[i]; i++) {
  for (var j = 0, col; col = row.cells[j]; j++) {
    col.setAttribute("data-th", headertext[j]);
  } 
}


var headertext2 = [],
headers2= document.querySelectorAll("#miyazaki2 th"),
tablerows2 = document.querySelectorAll("#miyazaki2 th"),
tablebody2 = document.querySelector("#miyazaki2 tbody");

for(var i = 0; i < headers2.length; i++) {
  var current = headers2[i];
  headertext2.push(current.textContent.replace(/\r?\n|\r/,""));
} 
for (var i = 0, row; row = tablebody2.rows[i]; i++) {
  for (var j = 0, col; col = row.cells[j]; j++) {
    col.setAttribute("data-th", headertext2[j]);
  } 
}

var headertext3 = [],
headers3= document.querySelectorAll("#miyazaki3 th"),
tablerows3 = document.querySelectorAll("#miyazaki3 th"),
tablebody3 = document.querySelector("#miyazaki3 tbody");

for(var i = 0; i < headers3.length; i++) {
  var current = headers3[i];
  headertext3.push(current.textContent.replace(/\r?\n|\r/,""));
} 
for (var i = 0, row; row = tablebody3.rows[i]; i++) {
  for (var j = 0, col; col = row.cells[j]; j++) {
    col.setAttribute("data-th", headertext3[j]);
  } 
}

var headertext4 = [],
headers4= document.querySelectorAll("#miyazaki4 th"),
tablerows4 = document.querySelectorAll("#miyazaki4 th"),
tablebody4 = document.querySelector("#miyazaki4 tbody");

for(var i = 0; i < headers4.length; i++) {
  var current = headers4[i];
  headertext4.push(current.textContent.replace(/\r?\n|\r/,""));
} 
for (var i = 0, row; row = tablebody4.rows[i]; i++) {
  for (var j = 0, col; col = row.cells[j]; j++) {
    col.setAttribute("data-th", headertext4[j]);
  } 
}

var headertext5 = [],
headers5= document.querySelectorAll("#miyazaki5 th"),
tablerows5 = document.querySelectorAll("#miyazaki5 th"),
tablebody5 = document.querySelector("#miyazaki5 tbody");

for(var i = 0; i < headers5.length; i++) {
  var current = headers5[i];
  headertext5.push(current.textContent.replace(/\r?\n|\r/,""));
} 
for (var i = 0, row; row = tablebody5.rows[i]; i++) {
  for (var j = 0, col; col = row.cells[j]; j++) {
    col.setAttribute("data-th", headertext5[j]);
  } 
}

var headertext6 = [],
headers6= document.querySelectorAll("#miyazaki6 th"),
tablerows6 = document.querySelectorAll("#miyazaki6 th"),
tablebody6 = document.querySelector("#miyazaki6 tbody");

for(var i = 0; i < headers6.length; i++) {
  var current = headers6[i];
  headertext6.push(current.textContent.replace(/\r?\n|\r/,""));
} 
for (var i = 0, row; row = tablebody6.rows[i]; i++) {
  for (var j = 0, col; col = row.cells[j]; j++) {
    col.setAttribute("data-th", headertext6[j]);
  } 
}