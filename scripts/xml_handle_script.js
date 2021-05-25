function saveOption()
{
    var newFile=document.getElementById("newXML");
    var appendFile=document.getElementById("appendXML");
    var viewFile=document.getElementById("viewXML");
    var wnewFileName = document.getElementById("write_newFileField");
    var wexistingFileName = document.getElementById("write_existingFileField");
    var rexistingFileName = document.getElementById("view_existingFileField");


    if (newFile.checked)
    {
        wexistingFileName.style.display = "none";
        rexistingFileName.style.display = "none";
        wnewFileName.style.display = "block";
    }

    else if (appendFile.checked) 
    {
        wexistingFileName.style.display = "block";
        rexistingFileName.style.display = "none";
        wnewFileName.style.display = "none";    
    }
    else if (viewFile.checked) 
    {
        wexistingFileName.style.display = "none";
        rexistingFileName.style.display = "block";
        wnewFileName.style.display = "none";    
    }
}