var overlay = document.getElementById("overlayBackground");
var overlayContainer = document.getElementById("overlayContainer");
var container = document.getElementById("TaskContainer");
var buttons = document.querySelectorAll(".toggleOverlay");
var buttonNewTask = document.getElementById("AddTask");
var buttonRemoveTask = document.getElementById("RemoveTask");
var counter = 0;

buttons.forEach(button => {
    button.addEventListener("click", toggleOverlay);
});
buttonNewTask.addEventListener("click", addTask);
buttonRemoveTask.addEventListener("click", removeTask);

function toggleOverlay(){
    if(overlay.style.display == 'block'){
        overlay.style.display = 'none';
    }
    else{
        overlay.style.display = 'block';
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

function removeTask(){
    if(container.childElementCount <= 1) return;
    container.removeChild(container.lastChild);
    if(counter != 0)
        counter--;
}