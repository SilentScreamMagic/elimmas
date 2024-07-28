<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filterable Dropdown with Values</title>
    <style>
        /* Dropdown container */
        .dropdown {
            position: relative;
            display: inline-block;
            width: 200px;
        }

        /* Dropdown input */
        .dropdown input {
            width: 100%;
            box-sizing: border-box;
        }

        /* Dropdown content */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f6f6f6;
            min-width: 100%;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        /* Dropdown items */
        .dropdown-content div {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        /* Change color of items on hover */
        .dropdown-content div:hover {
            background-color: #ddd;
        }

        /* Show the dropdown content */
        .show {
            display: block;
        }
    </style>
</head>
<body>

<script>
        document.addEventListener("DOMContentLoaded", function() {
            function filterFunction(event) {
                var input = event.target;
                var filter = input.value.toUpperCase();
                var dropdownId = input.getAttribute('data-dropdown');
                var dropdown = document.getElementById(dropdownId).getElementsByClassName("dropdown-content")[0];
                var divs = dropdown.getElementsByTagName("div");

                for (var i = 0; i < divs.length; i++) {
                    var txtValue = divs[i].textContent || divs[i].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        divs[i].style.display = "";
                    } else {
                        divs[i].style.display = "none";
                    }
                }
                dropdown.classList.add("show");
            }

            var inputs = document.getElementsByClassName("dropdown-input");
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener("keyup", filterFunction);
            }

            document.body.addEventListener("click", function(event) {
                if (event.target.matches('.dropdown-input')) {
                    var dropdownId = event.target.getAttribute('data-dropdown');
                    document.getElementById(dropdownId).getElementsByClassName("dropdown-content")[0].classList.add("show");
                } else {
                    var dropdowns = document.getElementsByClassName("dropdown-content");
                    for (var i = 0; i < dropdowns.length; i++) {
                        if (dropdowns[i].classList.contains('show')) {
                            dropdowns[i].classList.remove('show');
                        }
                    }
                }
            });

            document.body.addEventListener("click", function(event) {
                if (event.target && event.target.nodeName == "DIV" && event.target.parentNode.classList.contains("dropdown-content")) {
                    var dropdownId = event.target.parentNode.parentNode.getAttribute('id');
                    var input = document.querySelector('.dropdown-input[data-dropdown="' + dropdownId + '"]');
                    var hiddenInput = document.getElementById('selectedValue' + dropdownId.replace('dropdown', ''));
                    input.value = event.target.innerText;
                    hiddenInput.value = event.target.getAttribute("data-value");
                    event.target.parentNode.classList.remove("show");
                }
            });
        });
    </script>
</body>
</html>
