<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
    .hidden {
            display: none;
        }
        .dropdown-input {
            margin-bottom: 12px;
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
        }
</style>
<body>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        var input = document.getElementById("tableFilterInput");
        input.addEventListener("keyup", function() {
            var filter = input.value.toUpperCase();
            var table = document.getElementById("filterTable");
            var rows = table.getElementsByTagName("tr");

            for (var i = 1; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName("td");
                var showRow = false;
                if (filter ==""){
                    showRow = true
                }else{
                    var cellValue = cells[1].textContent || cells[1].innerText;
                    if (cellValue.toUpperCase().indexOf(filter) > -1) {
                        showRow = true;
                    }
                }
                
                if (showRow) {
                    rows[i].classList.remove("hidden");
                } else {
                    rows[i].classList.add("hidden");
                }
            }
        });
    });
</script>

</body>
</html>