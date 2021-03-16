//when variable name contains add, it belongs to the add overlay
//when variable name contains remove, it belongs to the remove overlay
var overlayAdd = document.getElementById("overlayBackgroundAdd"); 
var overlayRemove = document.getElementById("overlayBackgroundRemove"); 
var container = document.getElementById("TaskContainer");
var buttonsAdd = document.querySelectorAll(".toggleOverlay");
var buttonsRemove = document.querySelectorAll(".toggleOverlayRemove");
var buttonNewTask = document.getElementById("AddTask");
var buttonNewTaskAdd = document.getElementById("AddTask2");
var buttonRemoveNewTask = document.getElementById("RemoveTask");
var check = document.querySelectorAll(".CheckRemove");
var counter = 0;

buttonsAdd.forEach(button => {
    button.addEventListener("click", toggleOverlay);
});
buttonsRemove.forEach(button => {
    button.addEventListener("click", toggleoverlayRemove);
});
if(buttonNewTask != null) buttonNewTask.addEventListener("click", addTask);
if(buttonNewTaskAdd != null) buttonNewTaskAdd.addEventListener("click", addTask2);
if(buttonRemoveNewTask != null) buttonRemoveNewTask.addEventListener("click", removeNewTask);

check.forEach(box => {
    box.addEventListener("click", updateCheckedText);
});

function toggleOverlay(){
    if(overlayAdd.style.display == 'block'){
        overlayAdd.style.display = 'none';
    }
    else{
        overlayAdd.style.display = 'block';
    }
}

function toggleoverlayRemove(){
    if(overlayRemove.style.display == 'block'){
        overlayRemove.style.display = 'none';
    }
    else{
        overlayRemove.style.display = 'block';
    }
}

function updateCheckedText(){
    var checkContainer = this.parentElement.parentElement;
    var checkLabel = checkContainer.children[0].children[0];
    console.log(checkLabel);
    if(this.checked){
        checkLabel.classList.remove("text-light");
        checkLabel.classList.add("text-danger");
    }
    else{
        checkLabel.classList.add("text-light");
        checkLabel.classList.remove("text-danger");
    }
}

function addTask(){
    if(counter >= 5) return;
    var inputName = document.createElement("input");
    inputName.classList.add("form-control", "mt-2");
    inputName.setAttribute("name", `NewTask${counter}`);
    inputName.setAttribute("type", 'text');
    inputName.setAttribute("placeholder", "name");

    container.appendChild(inputName);
    counter++;
}

function addTask2(){
    var inputName = document.createElement("input");
    inputName.classList.add("form-control", "mt-2", "mb-3");
    inputName.setAttribute("name", `NewTask${counter}`);
    inputName.setAttribute("type", 'text');
    inputName.setAttribute("placeholder", "task name");

    container.appendChild(inputName);
    counter++;
}

function removeNewTask(){
    if(container.childElementCount <= 1) return;
    container.removeChild(container.lastChild);
    if(counter != 0)
        counter--;
}