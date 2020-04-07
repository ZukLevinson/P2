function popUp(boxName1, boxName2){
    const item1 = document.getElementById(boxName1);
    const item2 = document.getElementById(boxName2);
    if(item1.style.display==="none"){
        item1.style.display = "block";
        item2.style.display = "none";
        '<% $_SESSION["login"] = 1; %>'
    } else {
        item1.style.display = "none";
        item2.style.display = "block";
        '<% $_SESSION["login"] = 0; %>'
    }
}