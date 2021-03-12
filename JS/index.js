var overlay1 = document.getElementById("overlayBackground");
var overlay2 = document.getElementById("overlayBackground2");
var container = document.getElementById("TaskContainer");
var buttons = document.querySelectorAll(".toggleOverlay");
var buttonNewTask = document.getElementById("AddTask");
var buttonRemoveNewTask = document.getElementById("RemoveTask");
var buttons2 = document.querySelectorAll(".toggleOverlay2");
var check = document.querySelectorAll(".CheckRemove");
var counter = 0;

buttons.forEach(button => {
    button.addEventListener("click", toggleOverlay);
});
buttons2.forEach(button => {
    button.addEventListener("click", toggleOverlay2);
});
buttonNewTask.addEventListener("click", addTask);
buttonRemoveNewTask.addEventListener("click", removeNewTask);

check.forEach(box => {
    box.addEventListener("click", updateCheckedText);
});

function toggleOverlay(){
    if(overlay1.style.display == 'block'){
        overlay1.style.display = 'none';
    }
    else{
        overlay1.style.display = 'block';
    }
}

function toggleOverlay2(){
    if(overlay2.style.display == 'block'){
        overlay2.style.display = 'none';
    }
    else{
        overlay2.style.display = 'block';
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

function removeNewTask(){
    if(container.childElementCount <= 1) return;
    container.removeChild(container.lastChild);
    if(counter != 0)
        counter--;
}