<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.accordion {
  background-color: #eee;
  color: #444;
  cursor: pointer;
  padding: 18px;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
  transition: 0.4s;
}

.active1, .accordion:hover {
  background-color: #ccc; 
}

.panel {
  padding: 0 18px;
  display: none;
  
  overflow: hidden;
}
</style>
</head>
<body>


<script>
var acc = document.getElementsByClassName("accordion");
var i;
function openAcc(ele) {
    //ele.classList.toggle("active1");
    var panel = document.getElementById(ele);
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  }
</script>

</body>
</html>
